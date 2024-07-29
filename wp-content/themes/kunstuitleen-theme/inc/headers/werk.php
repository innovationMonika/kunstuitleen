<?php
        
    $landingspage = is_landingspage(); 
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
?>
<section id="top">
    
    <?php //include( locate_template( '/messages.php', false, false ) ); // Uitgeschakeld omdat er geen problemen met connecties zijn.....  ?>
    
    <div class="top-container">
        <section class="container">
            
    	    <a href="<?php echo get_permalink($favorieten_id); ?>" class="favorieten<?php if(count($favorieten) > 0){ echo ' active'; } ?>">
        	   <?php if(count($favorieten) > 0){ echo count($favorieten); } else { echo '0'; } ?>
            </a>
            
            <img src="<?php bloginfo('template_url'); ?>/static/images/favorieten-arrow.svg" class="favorieten-arrow" />
            
            <?php if( $landingspage != true ): get_search_form(); endif; ?>
    	   
            <section class="row">
                <section class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
    	            <a href="<?php bloginfo('siteurl'); ?>" class="logo">
        	            <img src="<?php bloginfo('template_url');?>/static/images/kunstuitleen.svg" alt="<?php bloginfo('name'); ?>" />
    	            </a>
                </section>
                <section class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    
                    <section class="row">
                        <section class="col-xs-12 col-sm-3 col-md-6 col-lg-6 site-switch">
                            <?php if( $landingspage != true ): ?>
                                <a href="<?php the_field('portal_link_left', 2); ?>" class="nocolor">Thuis</a> | <a href="<?php bloginfo('siteurl'); ?>/werk/">Werk</a>
                            <?php endif; ?>
                            
                            <div class="showmenu hidden-sm"><i class="fa fa-bars"></i></div>
                            <div class="hidden-xs hidden-sm scrollshowmenu"><i class="fa fa-bars"></i></div>
                        </section>
                        <section class="hidden-xs col-sm-9 col-md-6 col-lg-6 text-right contact-info">
                            <?php 
                                $contactinfo = '<a href="tel:'.str_replace(' (0)', '', get_field( "contact_phone", 'option' )).'">'.get_field( "contact_phone", 'option' ).'</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
                                $contactinfo .= '<a class="mailto" href="mailto:'.get_field( "contact_email", 'option' ).'">'.get_field( "contact_email", 'option' ).'</a>&nbsp;&nbsp;|';
                                echo apply_filters('the_content', $contactinfo); 
                            ?>
                            <div class="showmenu hidden-xs"><i class="fa fa-bars"></i></div>
                            <?php if( $landingspage != true ): ?>
                                <i class="fa fa-search"></i>
                            <?php endif; ?>
                        </section>
                    </section>
                </section>
                
                <section class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-md-offset-2 col-lg-offset-2 relative scroll">
                    <img src="<?php bloginfo('template_url');?>/static/images/top-bar.png" class="top-bar" />
                    <a href="<?php the_field($nav_btn_url, 'option'); ?>" class="button red"><?php the_field($nav_btn_label, 'option'); ?></a>
                    
                    
        	        <nav class="text-center">
            	        <?php wp_nav_menu(array(
            	            'theme_location' => $wp_nav_menu, 
            	            'container_class' => 'menu', 
            	            'items_wrap' => '<ul class="flexnav" data-breakpoint="991">%3$s</ul>', 
            	            'depth' => 2)); 
                        ?>
                    </nav>
                    
                </section>
            </section>
        </section>
    </div>
</section>