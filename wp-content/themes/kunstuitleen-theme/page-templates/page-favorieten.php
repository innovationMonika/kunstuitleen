<?php
/*
    Template name: Mijn favorieten
*/
    get_header(); 
    
    $cookieWebVariant = get_web_variant(); 
    $favorieten = get_favorieten();
    
    $maxSelection   = ( $cookieWebVariant == 'werk' ? 20 : 5 );
    $backID         = ( $cookieWebVariant == 'werk' ? 42 : 122258 );
    $confirmID      = ( $cookieWebVariant == 'werk' ? 121862 : 122277 );
    
    $backToActiveFilters = get_cookie_value('collectieFilters');
    $ajax_last_loaded_page = get_cookie_value('ajax_last_loaded_page');
    
    $backlink = ( !empty($backToActiveFilters) ? get_permalink($backID).'?'.$backToActiveFilters.'&backto=footer' : ( !empty($ajax_last_loaded_page) ?  get_permalink($backID).'?backto=footer' : get_permalink($backID) )  );
    
    $step_active = 'one';
    
    $include_post_id = ( $cookieWebVariant == 'werk' ? 40 : 122282 );
?>
    
    <section class="container relative page-content-container">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        
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
    

    
    <?php include( locate_template( 'inc/collection_header.php', false, false ) ); ?>
    <div class="favorieten-ajax" id="favorieten-ajax-section"><?php include( locate_template( 'inc/favorieten/bevestig-eindselectie.php', false, false ) ); ?></div>    
    <?php include( locate_template( 'inc/hoe-werkt-het.php', false, false ) ); ?>

<?php get_footer(); ?>

