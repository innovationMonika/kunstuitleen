<?php
/**
 * Plugin Name: Rocket custom tmp path
 * Description: Modify the tmp path used for minified files creation.
 * Author:      WP Rocket team
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

// Basic security, prevents file from being loaded directly.
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

add_filter( 'rocket_override_min_cachepath', '__return_true' );
add_filter( 'rocket_min_cachePath', '__rocket_custom_min_cachepath' );
function __rocket_custom_min_cachepath() {
    return ABSPATH.'tmp'; // ABSPATH = /srv/sitename
}