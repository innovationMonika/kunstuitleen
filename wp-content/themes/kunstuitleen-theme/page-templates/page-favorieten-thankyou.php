<?php
/*
    Template name: Favorieten - Thank you
*/
 

    get_header();
    
    $cookieWebVariant = get_web_variant(); 
    $favorieten = get_favorieten();
    
    $maxSelection   = ( $cookieWebVariant == 'werk' ? 20 : 5 );
    $backID         = ( $cookieWebVariant == 'werk' ? 256 : 122275 );
    $updateID       = ( $cookieWebVariant == 'werk' ? 121862 : 122277 );
    $collectieID    = ( $cookieWebVariant == 'werk' ? 42 : 122258 );

    $step_active = 'three';
    $include_post_id = ( $cookieWebVariant == 'werk' ? 40 : 122282 );

?>
    
    <section class="container relative page-content-container">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column page-content">
                	
                <h1><?php echo get_the_title($backID); ?></h1>
                <div class="text-center"><a href="<?php echo get_permalink($collectieID); ?>" class="backto">Terug naar de collectie</a></div>
            </article>
            		
		</section>
    </section>
    
    <div class="content-container no-margin-top no-margin-bottom">
        <div class="container relative">
            <section class="row">
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 relative page-content favorieten-intro">
                    <?php $thankyou = true; include( locate_template( 'inc/favorieten/steps.php', false, false ) ); ?>
                </article>
            </section>
        </div>
    </div>
     
    <section class="content-container no-padding-top">
        
        <section class="container" id="favorieten-info">
            <section class="row">
                
                <section class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                    <section class="column">
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <?php the_content(); ?>
                        <?php endwhile; endif; ?>
                    </section>
                </section>
                
                <section class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <section class="column favorieten-overview">
                        <?php include( locate_template( 'inc/favorieten/overview.php', false, false )); ?>
                    </section>
                    
                    <div class="favorieten-voordelen">
                        <?php 
                            if( $cookieWebVariant == 'werk' ): 
                                include( locate_template( 'inc/voordelen-werk.php', false, false ));
                            else:
                                include( locate_template( 'inc/voordelen-thuis.php', false, false ));
                            endif; 
                        ?>
                    </div>
                </section>
                
            </section>    
        </section>
        
    </section>
<?php get_footer(); ?>
