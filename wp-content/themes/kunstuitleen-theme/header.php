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
         })(window,document,'script','dataLayer','GTM-K5TJLK2');
      </script>
      <!-- End Google Tag Manager -->
      <?php wp_head(); //Speciale WP header ?>	
   </head>
   <?php 
  // $parent             = getPostParent();
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
        $user_type='company';
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
    $user_type='private';
       $home_id  = 121868;
       $favorieten_id = 122275;
       $wp_nav_menu = 'primary-thuis';
       $nav_btn_url = 'nav_btn_thuis_url';
       $nav_btn_label = 'nav_btn_thuis_label';
       $contact_phone = 'contact_phone_thuis';
       $contact_email = 'contact_email_thuis';
   endif;
   
   
   ?>
   <body class="<?php echo $cookieWebVariant; ?><?php if(is_page_template( 'page-templates/page-home.php' ) || is_page_template( 'page-templates-thuis/page-home-thuis.php' )){ echo ' home'; } ?>">
      <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K5TJLK2"
         height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <!-- End Google Tag Manager (noscript) -->
      <section id="wrap">
      <div id="top">
         <div class="container">
            <div class="row d-flex header_main_kestag">
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
                     <nav class="text-center header_nav_menu">
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
                              <?php if($cookieWebVariant !== 'werk') { ?>
                              <li id='dropdown'>
                                <?php  if (!is_user_logged_in()) { ?>
                                 <button class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    aria-haspopup="true" data-bs-auto-close="false">
                                 <span class="login_user_logo">
                                     <img src="<?php bloginfo('template_url');?>/static/images/login_my.png">
                                 </span>
                                 <span class="login_kestag">
                                  Login
                              </span>
								<img src="<?php bloginfo('template_url');?>/static/images/dropdown_white.png" class="drop_white">
                                 </button>  
                                  <?php } 
                                    else { ?>  
                                   <button class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink1"
                                    aria-haspopup="true" data-bs-auto-close="false">
                                <span class="login_user_logo">
                                     <img src="<?php bloginfo('template_url');?>/static/images/login_my.png">
                                 </span>
                                 <span class="login_kestag">
                                    <?php 
                                    $current_user = wp_get_current_user();
                                    echo $current_user->user_firstname; ?>
                             </span>
                                
                                 <img src="<?php bloginfo('template_url');?>/static/images/dropdown_white.png" class="drop_white">
                                 </button>   
                                  <?php } ?>            
                                 <div class="dropdown-menu dropdown-menu-right"  id="form_one">
                                    <div class="modal-content">
                                       <?php if (!is_user_logged_in()) { ?>
                                       <div class="modal-body login" id="login">   <?php }else{
                                        ?>
                                        <div class="modal-body after_login" id="login">
                                       <?php } ?>                                       
                                        <?php if (!is_user_logged_in()) { ?>
                                                    <div class="form-title">
                                                        <h2 class="mr-jonas"><strong>Login</strong></h2>
                                                    </div>
                                                    <div class="row title">
                                                        <label class="h4"><strong>Welkom terug bij kunstuitleen</strong></label>
                                                    </div>
                                                    <div class=" flex-column text-center">
                                                    <?php echo do_shortcode('[kucrm-login-form]'); ?>
                                                        <div class="justify-content-center social-media-icons">
                                                            <div>
                                                                <a type="button" class="btn btn-round mr-jonas sign-up" data-toggle="tooltip" data-placement="top" title="Google">
                                                                    <strong>Nog geen account? Begin heir. </strong>
                                                                 </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                        <?php }else{
                                                $class = ''; 
                                                $current_user = wp_get_current_user();
                                                $user_name = "Welkom " . $current_user->display_name;
                                                $class = 'kunstuitleen-menu-parent';
                                                echo do_shortcode('[kunstuitleen-my-account-top-menu title="' . esc_html( $user_name ) . '" class="' . esc_html( $class ) . '"]');
                                              } 
                                        ?>                                          
                                       </div>
                                        
                                        <div class="modal-body" id="forget-pass">
                                            <div class="form-title">
                                                <h2 class="mr-jonas"><strong>Wachtwoord opnieuw instellen</strong></h2>
                                            </div>
                                            <div class="title">
                                                <label class="h4"><strong>Vul je emailadress in en je ontvangt binnen enkele minuteen een link waarme je een Wachtwoord kunt instellen</strong></label>
                                            </div>
                                            <div class="d-flex flex-column text-center">
                                               <?php echo do_shortcode('[kucrm-password-lost-form]'); ?>
                                            </div>
                                            <div class="justify-content-center social-media-icons">
                                                 <div>
                                                      <a type="button" class="btn btn-round mr-jonas go_to_login" data-toggle="tooltip" data-placement="top" title="Google">
                                                      <strong><span><img src="<?php bloginfo('template_url');?>/static/images/back.png?>"></span>Terug naar login </strong>
                                                      </a>
                                                   </div>
                                            </div>
                                        </div>
                                        <div class="modal-body" id="confirm">
                                            <div class="form-title">
                                                <h2 class="mr-jonas"><strong>Wachtwoord opnieuw opgevraagd</strong></h2>
                                            </div>
                                            <div class="title">
                                                <label class="h4"><strong>Binnen enkele minuten ontvangt u een e-mail met een link. U kunt dit ondar uw gegevens in uw account wijzigen in uw gewenste wachtwoord</strong></label>
                                            </div>
                                            <div class="d-flex flex-column text-center">
                                                <button type="button" class="btn btn-info btn-block btn-round" id="close">Sluiten</button>
                                            </div>
                                        </div>
                                        <div class="modal-body" id="sign-up">
                                            <div class="form-title">
                                                <h2 class="mr-jonas"><strong>Account aanmaken</strong></h2>
                                            </div>
                                            <div class="title">
                                                <label class="h4"><strong>Met de onderstaande gegevens kun je een account aanvragen</strong></label>
                                            </div>
                                            <?php echo do_shortcode('[kucrm-register-form user_type='.$user_type.']'); ?>
                                            <?php if (!is_user_logged_in()) { ?>
                                            <div class="d-flex justify-content-center social-media-icons">
                                                <div class="row  text-center">
                                                    <a type="button" class="btn btn-round sign-in">
                                                        <strong>Terug naar login</strong>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php  } ?>
                                        </div>
                                        <div class="modal-body" id="sign-up-complete">
                                            <div class="form-title">
                                                <h2 class="mr-jonas"><strong>Account aangevraagd!</strong></h2>
                                            </div>
                                            <div class="row title">
                                                <label class="h4"><strong>Je account is met succes aangevraagd. Je ontvangt een mail met jouw wachtwoord. Dit kan enkele minuten duren.</strong></label>
                                            </div>
                                           <div class="row text-center">
                                                <div class="icon_checked">
                                                <img src="<?php bloginfo('template_url');?>/static/images/tick.svg" class="
                                                img-responsive checked">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center social-media-icons">
                                                <div class="row">
                                                    <button type="button" class="btn btn-info btn-block btn-round" id="close_2">Sluiten</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-body" id="account-detail">
                                            <div class="form-title">
                                                <h2 class="mr-jonas"><strong>Welkom Voornaam</strong></h2>
                                            </div>
                                            <div class="row" style="margin-top: 22px;">
                                                <ul>
                                                    <li><a href="#" class="btn"><label class="h5"><strong>Accountoverzicht</strong></label></a></li>
                                                    <li><a href="#" class="btn"><label class="h5"><strong>Mijn kunstwerken</strong></label></a></li>
                                                    <li><a href="#" class="btn"><label class="h5"><strong>Mijn tegoeden</strong></label></a></li>
                                                    <li><a href="#" class="btn"><label class="h5"><strong>Mijn aankoopfacturen</strong></label></a></li>
                                                    <li><a href="#" class="btn"><label class="h5"><strong>Mijn huurfacturen</strong></label></a></li>
                                                    <li><a href="#" class="btn"><label class="h5"><strong>Mijn gegevens</strong></label></a></li>
                                                    <li><a href="#" class="btn"><label class="h5"><strong>Log uit</strong></label></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                    
                                    </div>
                                 </div>
                              </li>
                              <?php } ?>
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