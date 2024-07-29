<?php
    /*
        Template name: Contact
    */
    get_header();
    $cookieWebVariant = get_web_variant(); ?>
 
    
    <section class="container relative page-content-container">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 column page-content">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                <?php endwhile; endif; ?>
            </article>
            		
		</section>
    </section>
    
    <?php if( have_rows('team_employees') ): ?>
        <section class="column" id="employees">
            <section class="container">
                <section class="row">
                    <?php $t = 0; ?>
                    <?php while ( have_rows('team_employees') ) : the_row(); $t++; ?>
                        <?php $contentalign = 'text-right'; ?>
                        <?php $image = get_sub_field('team_photo')['sizes']['responsive'];  ?>
                        <?php if($t == 2): ?>
                            <aside class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                <img src="<?php echo $image; ?>" alt="<?php the_sub_field('team_name'); ?>" />
                            </aside>
                            <?php $contentalign = 'text-left'; ?>
                        <?php $t = 0; endif; ?>
                        
                        
                        <article class="col-xs-6 col-sm-6 col-md-3 col-lg-3 <?php echo $contentalign; ?>">
                            <h2><?php the_sub_field('team_name'); ?></h2>
                            <p class="function"><?php the_sub_field('team_function'); ?></p>
                            
                            <?php $quote = get_sub_field('team_quote'); ?>
                            <?php $phone = get_sub_field('team_phone'); ?>
                            <?php $email = get_sub_field('team_email'); ?>
                            <?php $linkedin = get_sub_field('team_linkedin'); ?>
                            
                            <?php if($quote): ?><blockquote><?php echo $quote; ?></blockquote><?php endif; ?>
                            
                            <?php if($phone): ?><a href="tel:<?php echo str_replace('(0) ', '', $phone); ?>"><?php echo $phone; ?></a><?php endif; ?>
                            <?php if($phone && $email): echo '<br/>'; endif; ?>
                            <?php if($email): ?><a href="mailto:<?php echo $email; ?>" class="email"><?php echo $email; ?></a><?php endif; ?>
                            <br/>
                            <?php if($linkedin): ?>
                                <a href="<?php echo $linkedin; ?>" class="social" target="_blank"><i class="fa fa-linkedin"></i></a>
                            <?php endif; ?>
                        </article>
                        
                        <?php if($t == 1): ?> 
                            <aside class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                <img src="<?php echo $image; ?>" alt="<?php the_sub_field('team_name'); ?>" />
                            </aside>
                            <br class="clear hidden-sm hidden-md hidden-lg" /><br class="clear hidden-sm hidden-md hidden-lg" />
                        <?php endif; ?>
                    <?php endwhile; ?>
                </section>
            </section>
        </section>
    <?php endif; ?>
    
    <section class="column">
        
        <section class="container" id="favorieten-info">
            <section class="row">
                
                <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <section class="column grey form">
                        <?php echo do_shortcode( get_field('contact_form') ); ?>
                    </section>
                </section>
                
                <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    
                    <section class="column nopaddingtop">
                        <?php 
                            /* Advanced custom fields Google Maps */
                            $location = get_field('google_maps');
                        ?> 
                        <?php  
                            if( !empty($location) ): ?>
                                <div class="acf-map">
                                	<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
                                </div>
                        <?php endif; ?>                     
                    </section>                   
                    
                </section>
                
            </section>    
        </section>
        
    </section>

<?php get_footer(); ?>
