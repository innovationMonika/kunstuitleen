<?php
    /*
        Template name: Portal
    */
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
		
		<link href='https://fonts.googleapis.com/css?family=Cinzel:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url');?>/fonts/mrjonesbook.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url');?>/css/forms.css" />
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url');?>/css/nav.css" />
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>?v=5" />

		<!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
		
        <!-- Google Analytics -->
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        
          ga('create', 'UA-53267952-1', 'auto');
          ga('send', 'pageview');
        
        </script>
	    
	    <?php wp_head(); //Speciale WP header ?>	
	</head>
	
	<?php $header = get_header_image(); ?>
	
	<body class="portal">
        
        <div class="portal-bg" style="background-image: url(<?php echo $header; ?>);"></div>
	    <section id="wrap">
    	    
    	   <section id="top">
        	   <section class="container">
        	        <section class="row">
        	            <section class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
            	            <a href="<?php bloginfo('siteurl'); ?>" class="logo">
                	            <img src="<?php bloginfo('template_url');?>/static/images/kunstuitleen.svg" alt="<?php bloginfo('name'); ?>" />
            	            </a>
                        </section>
                        <section class="hidden-xs col-sm-9 col-md-10 col-lg-10">
                            <div class="contact-info">
                                <?php 
                                    $contactinfo = '<a class="phonenumber" href="tel:'.str_replace(' (0)', '', get_field( "contact_phone", 'option' )).'">'.get_field( "contact_phone", 'option' ).'</a><span style="color: #ed1c24;"><br class="hidden-sm hidden-md hidden-lg"/><span class="hidden-xs">&nbsp;&nbsp;|&nbsp;&nbsp;</span></span>';
                                    $contactinfo .= '<a class="mailto" href="mailto:'.get_field( "contact_email", 'option' ).'">'.get_field( "contact_email", 'option' ).'</a>';
                                    
                                    echo apply_filters('the_content', $contactinfo);
                                ?>
                            </div>
                        </section>
                        <br class="clear" />
                    </section>
                </section>
    	   </section> 
    	   
    	   <section id="portal">
    	       <section class="container">
        	        <section class="row">
        	            <section class="hidden-xs col-sm-9 col-md-9 col-lg-9 col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
            	            <h1><?php bloginfo('description'); ?></h1>
                        </section>
                        
                        <section class="col-xs-12 hidden-sm hidden-md hidden-lg">
	                        <div class="contact-info text-center">
		                        <?php 
			                        if( get_field('portal_header_extra_content') ):
				                        $extrainfo = get_field('portal_header_extra_content');
				                        $contactinfo .= $extrainfo;
			                        endif; 
			                    ?>
		                        
                        		<?php echo apply_filters('the_content', $contactinfo); ?>
	                        </div>
                        </section>
                    </section>
                    <section class="row portal-content">
                        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6 portal text-center">
                            <a href="<?php the_field('portal_link_left'); ?>">
                                <?php $portalimage = get_field('portal_image_left')['sizes']['portal']; ?>
                                <div class="relative">
                                    <img src="<?php echo $portalimage; ?>" alt="<?php the_title(); ?>" />
                                    <img src="<?php bloginfo('template_url'); ?>/static/images/header-thuis.svg" class="portal-label" alt="Werk" />
                                </div>
                                <section class="portal-intro thuis">
                                    <?php the_field('portal_intro_left'); ?>
                                </section>
                            </a>
                        </article>
                        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6 portal text-center">
                            <a href="<?php the_field('portal_link_right'); ?>">
                                <?php $portalimage = get_field('portal_image_right')['sizes']['portal']; ?>
                                <div class="relative">
                                    <img src="<?php echo $portalimage; ?>" alt="<?php the_title(); ?>" />
                                    <img src="<?php bloginfo('template_url'); ?>/static/images/header-werk.svg" class="portal-label" alt="Werk" />
                                </div>
                                <section class="portal-intro werk">
                                    <?php the_field('portal_intro_right'); ?>
                                </section>
                            </a>
                        </article>
                    </section>
                </section>
            </section>
            
	    </section>
            
        <?php wp_footer(); // Speciale WP footer ?>
	</body>
</html>