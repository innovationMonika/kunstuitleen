<?php
/*
    Template name: Mijn Selectie ( voorselectie )
*/
    get_header();
    $cookieWebVariant       = get_web_variant();
    $preselect_client       = get_preselect_client();
    $favorieten             = get_favorieten();
    $landingspage           = is_landingspage(); 
    
    $maxSelection           = 20;
    $backID                 = 285780;
    $confirmID              = 285801;
    
    $backToActiveFilters    = get_cookie_value('collectieFilters');
    $ajax_last_loaded_page  = get_cookie_value('ajax_last_loaded_page');
    
    $step_active = 'one';
    
    $backlink = ( !empty($backToActiveFilters) ? get_permalink($backID).'?'.$backToActiveFilters.'&backto=footer' : ( !empty($ajax_last_loaded_page) ?  get_permalink($backID).'?backto=footer' : get_permalink($backID) )  );

?>


    <section class="container relative page-content-container">
        
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column page-content">
                	
                <h1><?php the_title(); ?></h1>
                <div class="text-center"><a href="<?php echo $backlink; ?>" class="backto">Terug naar de collectie</a></div>
                
            </article>
            		
		</section>
    </section>
    
    <div class="content-container no-margin-top">
        <div class="container relative">
            <section class="row">
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 relative page-content favorieten-intro">
                    <?php include( locate_template( 'inc/favorieten/steps.php', false, false ) ); ?>
                    
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; endif; ?>
                </article>
            </section>
        </div>
    </div>
    
    <?php include( locate_template( 'inc/favorieten/bevestig-eindselectie.php', false, false ) ); ?>
    
    <section class="container text-center" id="collectie">
        
        <?php if($favorieten){} else { ?>               
             <br/><br/><p>Je hebt nog geen favorieten.</p>
        <?php } ?>
        
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column favorieten-overzicht" id="collectie">
                <?php if($favorieten){ ?>
                    <section class="row collectie">
                        <?php 
                            $selectedArt = get_cookie_value('selectedArt');
                            $the_query = new WP_Query( 
                                array(
                                    'post_type' => 'preselect_collection', 
                                    'orderby' => 'date', 
                                    'post__in' => $favorieten,
                                    'order' => 'DESC', 
                                    'posts_per_page' => '-1'
                                ) 
                            ); 
                        ?>
                        <?php if ( $the_query->have_posts() ) {	while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
                            <?php $cols = 'col-xs-12 col-sm-4 col-md-3 col-lg-3'; ?>
                            <?php include( locate_template( 'inc/art-favorite.php', false, false )); ?>
                        <?php  } /* endwhile */ } /* endif */ wp_reset_postdata(); /* Restore original Post Data */ ?>
                        
                    </section> 
                <?php } ?> 
            </article>
		</section>
    </section>
    
    <?php include( locate_template( 'inc/favorieten/bevestig-eindselectie.php', false, false ) ); ?>
    
    <?php if( !empty($preselect_client) ): ?>
        <input type="hidden" value="<?php echo $preselect_client['client_code']; ?>" name="preselect_client_code" id="preselect_client_code" />
        <input type="hidden" value="<?php echo $preselect_client['client_id']; ?>" name="preselect_client_id" id="preselect_client_id" />
    <?php endif; ?>

<?php get_footer(); ?>
