<?php
    
/**
 * Plugin Name: G2P Cookie Notice
 * Description: Cookienotice AVG Ready
 * Author:      Go2People Websites
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
 
class G2PCookieNotice {
    
    function __construct() {
        add_action( 'plugins_loaded', [$this, 'g2p_add_theme_options'] );
        add_action( 'wp_footer', [$this, 'g2p_footer_html'] );
        add_action( 'wp_enqueue_scripts', [$this, 'g2p_load_css_js'] );   
        add_filter( 'embed_oembed_html', [$this, 'video_wrapper'], 20, 3);
        add_filter( 'the_content', [$this, 'g2p_control_embed'], 15);
        
        
    }
    
    public function g2p_control_embed($html) {

        // AAN/UIT
        $cookie_notice_onoff = get_field('option_cookienotice_onoff', 'option'); 
        $cookie_video_notice = get_field('option_cookienotice_video_notice', 'option'); 
        
        if ( $cookie_notice_onoff === true && strpos($html, "<iframe" ) !== false) {
            
            $reset_cookie_choice = '<br/><a href="#" class="button">Wijzig keuze</a>';
            $html = preg_replace('/<div class="videoWrapper">/', '<div class="videoWrapper videoHidden"><div class="videoHidden_container"><p>' . $cookie_video_notice . $reset_cookie_choice .'</p></div>', $html);
            $html = preg_replace('/<iframe(.*?)src="(.*?)"/', '<iframe$1data-src="$2" data-cookie-name="cookieconsent" data-cookie-value="accept" /', $html);
  
        }
        
        return $html;
    }
    
    
    public function video_wrapper($html, $url, $attr){
        
        // IF videoWrapper does not exist yet, add it
        if( strpos($html, 'videoWrapper') === false ){
            return '<div class="videoWrapper">' . $html . '</div>';
        }
        
        return $html;
    }
        
        
    /**
     * Output HTML in footer
     */
    public function g2p_footer_html() {
        
        $plugin_url = plugin_dir_url( __FILE__ );
        
        // AAN/UIT
        $cookie_notice_onoff = get_field('option_cookienotice_onoff', 'option');        
        
        // TEKST
        $cookie_notice_description = get_field('option_cookienotice_description', 'option');
        $cookie_notice_label_accept = get_field('option_cookienotice_accept', 'option');
        $cookie_notice_label_decline = get_field('option_cookienotice_decline', 'option');
        
        // COLORS
        $cookie_notice_default_color = '#' . get_field('option_cookienotice_default_color', 'option');
        $cookie_notice_border_color = '#' . get_field('option_cookienotice_border_color', 'option');
        $cookie_notice_text_color = get_field('option_cookienotice_text_color', 'option');
            $css_text_color = ( $cookie_notice_text_color == '#FFF' ? 'color: #FFF;' : '' );
        
        // ADVANCED
        $cookie_notice_extra_classes = get_field('option_cookienotice_extra_classes', 'option');

        if( $cookie_notice_onoff === true ):
            echo '<div id="cookie-notification" style="background-color: ' . $cookie_notice_default_color . ';border-color: ' . $cookie_notice_border_color . '" class="' . ( $cookie_notice_text_color === '#FFF' ? 'cookie-text-white' : '' ) . '">
    		    <div class="container">
        		    <div class="row">
            		    <div class="col-12 col-sm-9">' . $cookie_notice_description . '</div>
            		    <div class="col-12 col-sm-3 text-center">
                            <a class="button close-cookie-notification' . ( !empty($cookie_notice_extra_classes) ? ' ' . $cookie_notice_extra_classes : '' ) . '" data-cookie-choice="accept" href="' . get_permalink( $post->ID ) . '#cookie-choice-accept" style="margin-bottom: 10px;">' .$cookie_notice_label_accept . '</a><br/>
                            <a class="close-cookie-notification" data-cookie-choice="decline" href="' . get_permalink( $post->ID ) . '#cookie-choice-decline">' .$cookie_notice_label_decline . '</a>
            		    </div>
        		    </div>
    		    </div>
		    </div>';
        endif;
        
    }
    
    /**
     * Enqueue scripts
    */
    public function g2p_load_css_js() {
        
        $plugin_url = plugin_dir_url( __FILE__ );
        $cookie_notice_onoff = get_field('option_cookienotice_onoff', 'option');

        if( $cookie_notice_onoff === true ):        
            wp_enqueue_style( 'g2p-cookienotice', $plugin_url . 'g2p-cookienotice/static/css/g2p-cookienotice.css', array(), '1.0.0', 'screen' );
            wp_enqueue_script('g2p-cookienotice', $plugin_url . 'g2p-cookienotice/static/js/g2p-cookienotice.js', array( 'jquery' ), '1.0.0.9', true );
        endif;
    }
    
    
    /**
     * ACF: Add theme options page & fields
    */
    public function g2p_add_theme_options() {
        
        if( function_exists('acf_add_options_page') ) {
            
            acf_add_options_page(array(
                'page_title'    => 'Cookie Notice',
                'menu_title'    => 'Cookie Notice',
                'menu_slug'     => 'theme-options-cookienotice',
                'capability'    => 'edit_posts',
                'parent_slug'   => '',
                'position'      => false,
                'icon_url'      => 'dashicons-megaphone',
            ));
                
        }
        
        if( function_exists('acf_add_local_field_group') ):
            
            acf_add_local_field_group(array(
            	'key' => 'group_5b03f0ea6c547',
            	'title' => 'Thema optie: Cookiemelding',
            	'fields' => array(
                	array(
            			'key' => 'field_5b4859d1ae356',
            			'label' => 'Aan/uit',
            			'name' => '',
            			'type' => 'tab',
            			'instructions' => '',
            			'required' => 0,
            			'conditional_logic' => 0,
            			'wrapper' => array(
            				'width' => '',
            				'class' => '',
            				'id' => '',
            			),
            			'placement' => 'left',
            			'endpoint' => 0,
            		),
                	array(
            			'key' => 'field_5b48593cecd00',
            			'label' => 'Zet \'Cookie Notice\' aan',
            			'name' => 'option_cookienotice_onoff',
            			'type' => 'true_false',
            			'instructions' => '',
            			'required' => 0,
            			'conditional_logic' => 0,
            			'wrapper' => array(
            				'width' => '',
            				'class' => '',
            				'id' => '',
            			),
            			'message' => '',
            			'default_value' => 0,
            			'ui' => 1,
            			'ui_on_text' => 'Ja',
            			'ui_off_text' => 'Nee',
            		),
            		array(
            			'key' => 'field_5b0402f4dfcb8',
            			'label' => 'Tekst',
            			'name' => '',
            			'type' => 'tab',
            			'instructions' => '',
            			'required' => 0,
            			'conditional_logic' => 0,
            			'wrapper' => array(
            				'width' => '',
            				'class' => '',
            				'id' => '',
            			),
            			'placement' => 'left',
            			'endpoint' => 0,
            		),
            		array(
            			'key' => 'field_5b03fa9080f63',
            			'label' => 'Cookiemelding: Omschrijving',
            			'name' => 'option_cookienotice_description',
            			'type' => 'wysiwyg',
            			'instructions' => '',
            			'required' => 0,
            			'conditional_logic' => 0,
            			'wrapper' => array(
            				'width' => '',
            				'class' => '',
            				'id' => '',
            			),
            			'default_value' => '',
            			'tabs' => 'all',
            			'toolbar' => 'full',
            			'media_upload' => 1,
            			'delay' => 0,
            		),
            		array(
            			'key' => 'field_5b03fb3880f64',
            			'label' => 'Cookiemelding: Weigeren ( label )',
            			'name' => 'option_cookienotice_decline',
            			'type' => 'text',
            			'instructions' => '',
            			'required' => 1,
            			'conditional_logic' => 0,
            			'wrapper' => array(
            				'width' => '',
            				'class' => '',
            				'id' => '',
            			),
            			'default_value' => 'Weigeren',
            			'placeholder' => '',
            			'prepend' => '',
            			'append' => '',
            			'maxlength' => '',
            		),
            		array(
            			'key' => 'field_5b03fb8480f65',
            			'label' => 'Cookiemelding: Accepteren ( label )',
            			'name' => 'option_cookienotice_accept',
            			'type' => 'text',
            			'instructions' => '',
            			'required' => 1,
            			'conditional_logic' => 0,
            			'wrapper' => array(
            				'width' => '',
            				'class' => '',
            				'id' => '',
            			),
            			'default_value' => 'Accepteren',
            			'placeholder' => '',
            			'prepend' => '',
            			'append' => '',
            			'maxlength' => '',
            		),
            		array(
            			'key' => 'field_5b519a04c1a42',
            			'label' => 'Video privacy melding',
            			'name' => 'option_cookienotice_video_notice',
            			'type' => 'text',
            			'instructions' => 'Wanneer een bezoeker (nog) niet akkoord is gegaan, dan mogen video\'s als Youtube en Vimeo ook niet worden getoond.<br/>
            Vul optioneel een melding in die wordt getoond aan de gebruiker.',
            			'required' => 0,
            			'conditional_logic' => 0,
            			'wrapper' => array(
            				'width' => '',
            				'class' => '',
            				'id' => '',
            			),
            			'default_value' => 'Deze video wordt niet getoond omdat er (nog) niet akkoord is gegaan met het plaatsen van cookies.',
            			'placeholder' => '',
            			'prepend' => '',
            			'append' => '',
            			'maxlength' => '',
            		),
            		array(
            			'key' => 'field_5b040303dfcb9',
            			'label' => 'Kleuren',
            			'name' => '',
            			'type' => 'tab',
            			'instructions' => '',
            			'required' => 0,
            			'conditional_logic' => 0,
            			'wrapper' => array(
            				'width' => '',
            				'class' => '',
            				'id' => '',
            			),
            			'placement' => 'left',
            			'endpoint' => 0,
            		),
            		array(
            			'key' => 'field_5b03fc7a99956',
            			'label' => 'Cookiemelding: Basiskleur',
            			'name' => 'option_cookienotice_default_color',
            			'type' => 'text',
            			'instructions' => '',
            			'required' => 1,
            			'conditional_logic' => 0,
            			'wrapper' => array(
            				'width' => '',
            				'class' => '',
            				'id' => '',
            			),
            			'default_value' => 'FFFFFF',
            			'placeholder' => '',
            			'prepend' => '#',
            			'append' => '',
            			'maxlength' => 6,
            		),
            		array(
            			'key' => 'field_5b040283c2a43',
            			'label' => 'Cookiemelding: Randkleur',
            			'name' => 'option_cookienotice_border_color',
            			'type' => 'text',
            			'instructions' => '',
            			'required' => 1,
            			'conditional_logic' => 0,
            			'wrapper' => array(
            				'width' => '',
            				'class' => '',
            				'id' => '',
            			),
            			'default_value' => '000000',
            			'placeholder' => '',
            			'prepend' => '#',
            			'append' => '',
            			'maxlength' => 6,
            		),
            		array(
            			'key' => 'field_5b0402b3c2a45',
            			'label' => 'Cookiemelding: Tekstkleur',
            			'name' => 'option_cookienotice_text_color',
            			'type' => 'select',
            			'instructions' => '',
            			'required' => 1,
            			'conditional_logic' => 0,
            			'wrapper' => array(
            				'width' => '',
            				'class' => '',
            				'id' => '',
            			),
            			'choices' => array(
            				'default' => 'Default',
            				'#FFF' => 'Wit',
            			),
            			'default_value' => array(
            			),
            			'allow_null' => 0,
            			'multiple' => 0,
            			'ui' => 0,
            			'ajax' => 0,
            			'return_format' => 'value',
            			'placeholder' => '',
            		),
            		array(
            			'key' => 'field_5b04031adfcba',
            			'label' => 'Geavanceerd',
            			'name' => '',
            			'type' => 'tab',
            			'instructions' => '',
            			'required' => 0,
            			'conditional_logic' => 0,
            			'wrapper' => array(
            				'width' => '',
            				'class' => '',
            				'id' => '',
            			),
            			'placement' => 'left',
            			'endpoint' => 0,
            		),
            		array(
            			'key' => 'field_5b040292c2a44',
            			'label' => 'Cookiemelding: Button: extra classes',
            			'name' => 'option_cookienotice_extra_classes',
            			'type' => 'text',
            			'instructions' => '',
            			'required' => 0,
            			'conditional_logic' => 0,
            			'wrapper' => array(
            				'width' => '',
            				'class' => '',
            				'id' => '',
            			),
            			'default_value' => '',
            			'placeholder' => '',
            			'prepend' => '',
            			'append' => '',
            			'maxlength' => '',
            		),
            	),
            	'location' => array(
            		array(
            			array(
            				'param' => 'options_page',
            				'operator' => '==',
            				'value' => 'theme-options-cookienotice',
            			),
            		),
            	),
            	'menu_order' => 0,
            	'position' => 'normal',
            	'style' => 'default',
            	'label_placement' => 'top',
            	'instruction_placement' => 'label',
            	'hide_on_screen' => '',
            	'active' => 1,
            	'description' => '',
            ));
            
        endif;
    
    }
    
}


$cookieNotice = new G2PCookieNotice();