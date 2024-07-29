<?php 
    $parent             = getPostParent();
    $cookieWebVariant   = get_web_variant();
    $favorieten         = get_favorieten();
    $landingspage       = is_landingspage(); 
    
    switch ($cookieWebVariant) {
    case 'werk':
        $switch     = "thuis";
        
        break;
    default: // werk
        $switch     = "werk";
        $switch_id  = 31;
        break;
}
    
    if( $cookieWebVariant === 'werk'):
        $home_id  = 31;
        if( $landingspage === true ): 
            $favorieten_id = 285794;
            $wp_nav_menu = 'werk-voorselectie';
            $nav_btn_url = 'nav_btn_werk_url_voorselectie';
            $nav_btn_label = 'nav_btn_werk_label_voorselectie';
        else: 
            $favorieten_id = 256;
            $wp_nav_menu = 'primary';
            $nav_btn_url = 'nav_btn_werk_url';
            $nav_btn_label = 'nav_btn_werk_label';
        endif;
        $contact_phone = 'contact_phone';
        $contact_email = 'contact_email';
    else:
        $home_id  = 121868;
        $favorieten_id = 122275;
        $wp_nav_menu = 'primary-thuis';
        $nav_btn_url = 'nav_btn_thuis_url';
        $nav_btn_label = 'nav_btn_thuis_label';
        $contact_phone = 'contact_phone_thuis';
        $contact_email = 'contact_email_thuis';
    endif;
    
    
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<title>
		<?php if(is_front_page()){ ?>
		    <?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>
		<?php } else {?>
		    <?php wp_title('',true,'') ?> | <?php bloginfo('name'); ?>
		<?php } ?>
		</title>
		
		<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('template_url');?>/static/images/favicon.ico">

	    <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-K5TJLK2');</script>
        <!-- End Google Tag Manager -->
	    
	    <?php wp_head(); //Speciale WP header ?>	
	</head>
	
	<body class="<?php echo $cookieWebVariant; ?><?php if(is_page_template( 'page-templates/page-home.php' ) || is_page_template( 'page-templates-thuis/page-home-thuis.php' )){ echo ' home'; } ?>">
    	
    	<!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K5TJLK2"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        
        <section id="wrap">
            
            <div id="top">
                <div class="container">
                    <div class="row d-flex">
                        <div class="col-xs-4 col-sm-3 col-md-2 d-flex">
            	            <a href="<?php echo get_permalink( $home_id ); ?>" class="logo">
                	            <img src="<?php bloginfo('template_url');?>/static/images/kunstuitleen.svg" alt="<?php bloginfo('name'); ?>" />
            	            </a>
                        </div>
                        <div class="col-xs-8 hidden-sm hidden-md hidden-lg">
                            <div class="inner">
                                <ul class="extra-nav">
                                    <li class="site-switch hidden-sm"><?php include( locate_template( 'inc/site-switch.php', false, false )); ?></li>
                                </ul>
                                <div class="showmenu"><i class="fa fa-bars"></i></div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-9 col-md-10 d-flex">
                            <div class="inner">
                                
                                <div class="hidden-xs hidden-sm scrollshowmenu"><i class="fa fa-bars"></i></div>
                                
                                <ul class="extra-nav">
                                    <li class="site-switch hidden-xs hidden-sm"><?php include( locate_template( 'inc/site-switch.php', false, false )); ?></li>
                                    <li class="contact-info hidden-xs">
                                        <?php locate_template( 'static/images/contact-info-triangle.svg', true, false ); ?>
                                        <a class="link" href="tel:<?php echo str_replace(' (0)', '', get_field( $contact_phone, 'option' )); ?>"><?php echo the_field( $contact_phone, 'option' ); ?></a>
                                        <span class="link-divider">|</span>
                                        <a class="link mailto" href="mailto:<?php the_field( $contact_email, 'option' ); ?>"><?php the_field( $contact_email, 'option' ); ?></a>
                                        
                                        <br class="hidden-xs hidden-md hidden-lg" />
                                        <span class="hidden-xs hidden-md hidden-lg"><?php include( locate_template( 'inc/site-switch.php', false, false )); ?></span>
                                        
                                        <a href="<?php the_field($nav_btn_url, 'option'); ?>" class="button <?php echo ( $cookieWebVariant === 'werk' ? 'red' : 'black'); ?> top-extra-nav-cta"><?php the_field($nav_btn_label, 'option'); ?></a>
                                    </li>
                                    
                                    <a href="<?php echo get_permalink($favorieten_id); ?>" class="favorieten<?php if(count($favorieten) > 0){ echo ' active'; } ?>">
                                        <span class="favorieten-count"><?php echo ( count($favorieten) > 0 ? count($favorieten) : '0' ); ?></span>
                                        <?php locate_template( 'static/images/favorieten.svg', true, false ); ?>
                                    </a>
                                    
                                </ul>
        
                                <div class="showmenu hidden-xs"><i class="fa fa-bars"></i></div>
                                
                                <nav class="text-center">
                                    <div class="menu">
                                        <ul class="flexnav" data-breakpoint="991">
                                             <?php wp_nav_menu(array(
                                	            'theme_location' => $wp_nav_menu, 
                                	            'container' => false, 
                                	            'items_wrap' => '%3$s', 
                                	            'depth' => 2)); 
                                            ?>
                                            <li class="hidden-sm hidden-md hidden-lg"><a href="<?php the_field($nav_btn_url, 'option'); ?>"><?php the_field($nav_btn_label, 'option'); ?></a></li>
                                            <li class="nav-li-search"><a href="#search" onclick="return false;"><i class="fa fa-search"></i></a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                <?php if( $landingspage != true ): get_search_form(); endif; ?>

            </div>
            
            <?php //include( locate_template( 'headers/' . $cookieWebVariant . '.php', true, false ) ); ?>

