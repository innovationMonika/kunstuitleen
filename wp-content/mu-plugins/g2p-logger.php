<?php
/**
 * Plugin name: G2P Logger
 * Description: Logging plugin for WordPress
 * Version:     0.1.3
 * Author:      Go2People Websites B.V.
 * Author URI:  https://go2people.nl
 * License:     MIT License
 */

namespace g2p\utils;

defined('DS') || define('DS', DIRECTORY_SEPARATOR);

add_action('init', function () {

    // Log status transitions
    add_action('transition_post_status', function ($new, $old, $post) {

        // We only want to log actual transitions
        if ($new === $old || $old === 'new')
            return;

        // We don't care about revisions
        if (wp_is_post_revision(($post->ID)))
            return;

        $user = wp_get_current_user();

        switch ($new) {
            case "publish":
                $new = Log::color('green', $new);
                break;

            case "trash":
                $new = Log::color('red', $new);
                break;
        }

        $postTypeObject = get_post_type_object($post->post_type);
        if ($postTypeObject instanceof WP_Post_Type) {
            $label = $postTypeObject->labels->singular_name;
        } else {
            $label = "Unknown Post Type";
        }

        Log::log(
            '%1$s %2$s status changed from %3$s to %4$s by user %5$s (id: %6$d)',
            $label,
            Log::color('cyan', $post->ID),
            $old,
            $new,
            $user->user_login,
            $user->ID
        );
    }, 100, 4);

    // Permanently deleted posts
    add_action('before_delete_post', function ($postId, $post) {

        // We don't care about revisions
        if (wp_is_post_revision(($postId)))
            return;

        $user = wp_get_current_user();

        $postTypeObject = get_post_type_object($post->post_type);
        $label          = $postTypeObject->labels->singular_name;

        Log::log(
            '%1$s %2$s (%3$s) was %4$s by user %5$s (id: %6$d)',
            $label,
            Log::color('cyan', $postId),
            Log::color('darkgray', $post->post_title),
            Log::color('red', 'permanently deleted'),
            Log::color('lightblue', $user->user_login),
            $user->ID
        );
    }, 100, 3);

    // Detect updates to certain options
    add_action('update_option', function ($option, $old, $new) {

        if (!in_array($option, ['blog_public', 'users_can_register', 'siteurl', 'home', 'permalink_structure']))
            return;

        $user = wp_get_current_user();

        // Serialize things we can't easily output
        $old = is_string($old) ? $old : serialize($old);
        $new = is_string($new) ? $new : serialize($new);

        Log::log(
            'Option %1$s was updated from %2$s to %3$s by %4$s (id: %5$d)',
            Log::color('cyan', $option),
            Log::color('darkgray', $old),
            Log::color('lightgray', $new),
            Log::color('lightblue', $user->user_login),
            $user->ID
        );

    }, 100, 4);

    // Plugin being activated
    add_action('activated_plugin', function ($plugin) {

        $user = wp_get_current_user();

        Log::log(
            'Plugin %1$s was %2$s by %3$s (id: %4$s)',
            Log::color('cyan', $plugin),
            Log::color('lightgreen', 'activated'),
            Log::color('lightblue', $user->user_login),
            $user->ID
        );
    }, 100, 2);

    // Plugin being deactivated
    add_action('deactivated_plugin', function ($plugin) {

        $user = wp_get_current_user();

        Log::log(
            'Plugin %1$s was %2$s by %3$s (id: %4$s)',
            Log::color('cyan', $plugin),
            Log::color('lightyellow', 'deactivated'),
            Log::color('lightblue', $user->user_login),
            $user->ID
        );
    }, 100, 2);

    // Detect Gravity Forms
    if (class_exists('\GFAPI')) {

        // Log (new) Gravity Forms being saved
        add_action('gform_after_save_form', function ($form, $isNew) {

            $user = wp_get_current_user();

            if ($isNew) {
                $action = 'created';
            } else {
                $action = 'updated';
            }

            Log::log(
                'Gravity Form %1$s was %2$s by user %3$s (id: %4$d)',
                Log::color('cyan', $form['id']),
                $action,
                Log::color('lightblue', $user->user_login),
                $user->ID
            );
        }, 100, 3);

        // Gravity Forms being activated
        add_action('gform_post_form_activated', function ($formId) {

            $user = wp_get_current_user();

            Log::log(
                'Gravity Form %1$s was %2$s by user %3$s (id: %4$d)',
                Log::color('cyan', $formId),
                Log::color('lightgreen', 'activated'),
                Log::color('lightblue', $user->user_login),
                $user->ID
            );
        }, 100, 2);

        // Gravity Forms being deactivated
        add_action('gform_post_form_deactivated', function ($formId) {

            $user = wp_get_current_user();

            Log::log(
                'Gravity Form %1$s was %2$s by user %3$s (id: %4$d)',
                Log::color('cyan', $formId),
                Log::color('lightyellow', 'deactivated'),
                Log::color('lightblue', $user->user_login),
                $user->ID
            );
        }, 100, 2);

        // Gravity Forms being trashed
        add_action('gform_post_form_trashed', function ($formId) {

            $user = wp_get_current_user();

            Log::log(
                'Gravity Form %1$s was %2$s by user %3$s (id: %4$d)',
                Log::color('cyan', $formId),
                Log::color('lightred', 'trashed'),
                Log::color('lightblue', $user->user_login),
                $user->ID
            );
        }, 100, 2);

        // Gravity Forms being restored
        add_action('gform_post_form_restored', function ($formId) {

            $user = wp_get_current_user();

            Log::log(
                'Gravity Form %1$s was %2$s by user %3$s (id: %4$d)',
                Log::color('cyan', $formId),
                Log::color('lightcyan', 'restored'),
                Log::color('lightblue', $user->user_login),
                $user->ID
            );
        }, 100, 1);

        // Gravity Forms being permanently deleted
        add_action('gform_before_delete_form', function ($formId) {

            $user = wp_get_current_user();
            $form = \GFAPI::get_form($formId);

            Log::log(
                'Gravity Form %1$s (%2$s) was %3$s by user %4$s (id: %5$d)',
                Log::color('cyan', $formId),
                Log::color('darkgray', $form['title']),
                Log::color('red', 'permanently deleted'),
                Log::color('lightblue', $user->user_login),
                $user->ID
            );
        }, 100, 2);

    }

});

class Log
{

    public static array $colors = [
        'default'      => 39,
        'black'        => 30,
        'red'          => 31,
        'green'        => 32,
        'yellow'       => 33,
        'blue'         => 34,
        'magenta'      => 35,
        'cyan'         => 36,
        'lightgray'    => 37,
        'darkgray'     => 90,
        'lightred'     => 91,
        'lightgreen'   => 92,
        'lightyellow'  => 93,
        'lightblue'    => 94,
        'lightmagenta' => 95,
        'lightcyan'    => 96,
        'white'        => 97,
    ];

    public static function color($color, $text)
    {

        if (isset(self::$colors[$color]))
            $colorCode = self::$colors[$color];
        else
            return $text;

        return "\033[" . $colorCode . "m" . $text . "\033[0m";
    }

    public static function log($text, ...$args)
    {

        $directory = str_replace(['/web/app/mu-plugins', '/wp-content/mu-plugins'], '', __DIR__). DS . 'g2p-logger';
        $datetime = new \DateTime('NOW', new \DateTimeZone('Europe/Amsterdam'));

        if (!file_exists($directory)) { mkdir($directory, 0770, true); }

        try {
            $file = $directory . DS . 'log.' . $datetime->format('Ym') . '.txt';
            file_put_contents($file, '[' . $datetime->format('d-M-Y H:i:s e') . '] ' . sprintf($text, ...$args) . PHP_EOL, FILE_APPEND);
        } catch (Exception $e) {
            error_log($e->getMessage());
            error_log(sprintf($text, ...$args));
        }
    }

}
