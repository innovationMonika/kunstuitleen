<?php
/*
    Template name: Kunstenaars (overzicht)
*/    
    get_header(); 
    
    // Vars
    $cookieWebVariant = get_web_variant(); 
    
    
    $sm = 0; $mdlg = 0;        
    $posts_per_page = 12;
    
    // Query-args
    $args = array(
        'post_type' => 'kunstenaar', 
        'orderby' => 'name',
        'order' => 'ASC', 
        'posts_per_page' => $posts_per_page,
        'meta_query' => array(
    		array(
    			'key'     => 'kunstenaar_kunstkunstenaar',
    			'value'   => 'false',
    			'compare' => '!=',
    		),
        ),
    );
    
    // Extra args
    if( !empty( safe_get('c') ) ):
        $args['s'] = safe_get('c');
    endif;
    
    
    $ajax_last_loaded_page = get_cookie_value('kunstenaarCurrentPage');
    
    if( !empty($ajax_last_loaded_page) && !empty( safe_get('backto') ) ){ 
    
        // count Query
        $count_query  = new WP_Query($args);
        
        $maxPages   = $count_query->max_num_pages;
        $totalFound = $count_query->found_posts;
        
        $currentPage = $ajax_last_loaded_page;
        $args['posts_per_page'] = $args['posts_per_page'] * $ajax_last_loaded_page;
        
        // the Query
        $the_query  = new WP_Query($args);
        
    } else {
        
        // the Query
        $the_query  = new WP_Query($args);
        
        $maxPages   = $the_query->max_num_pages;
        $totalFound = $the_query->found_posts;
        
    }

    $the_query = new WP_Query($args);
?>

    
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
        
    <section id="filters" class="column red werk relative">
        <form action="<?php echo get_permalink($post->ID); ?>" id="filter" method="get">
        <section class="container">
            <section class="row">
                <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-sm-offset-3">
                    
                    
                    <h3 class="nomargin">Zoek op:</h3>
                    <div class="filter-search">
                        <?php $searched = $_GET['c']; ?>
                        <input type="text" name="c" id="c" value="<?php echo $searched; ?>" placeholder="Naam kunstenaar..." />
                        <img src="<?php bloginfo('template_url');?>/static/images/<?php echo $cookieWebVariant; ?>-filter-search.svg" alt="Zoeken >" class="filter-submit" />
                    </div>                    
                </section>
            </section>
        </section>
        </form>
    </section>
    
    <section class="container ajaxloading" id="kunstenaars">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column">
                <section class="row kunstenaars">

                    <?php if ( $the_query->have_posts() ) {	while ( $the_query->have_posts() ) { $the_query->the_post(); $sm++; $mdlg++;  ?>
                        <?php include( locate_template( 'inc/kunstenaar.php', false, false )); ?>
                        <?php if( $sm == 3 ): echo '<br class="clear hidden-xs hidden-md hidden-lg" />'; $sm = 0; endif; ?>
                        <?php if( $mdlg == 4 ): echo '<br class="clear hidden-xs hidden-sm" />'; $mdlg = 0; endif; ?>
                    <?php  } /* endwhile */ } /* endif */ wp_reset_postdata(); /* Restore original Post Data */ ?>
                    
                    <script>
                        var maxPages = <?php echo $maxPages; ?>;
                        var currentPage = <?php echo $currentPage + 1; // + 1 for next page ?>;           
                    </script>
                    
                </section>

                <aside class="loading text-center clear">
                    <img src="<?php bloginfo('template_url'); ?>/static/images/arrow-rotatie.gif" alt="Bezig met laden" />
                </aside>
                
                <aside class="end-message text-center">
                    Er zijn geen kunstwerken (meer) gevonden die aan uw zoekcriteria voldoen. Probeer het gerust opnieuw door uw zoekopdracht aan te passen.
                </aside>
                
            </article>
		</section>
    </section>



<?php get_footer(); ?>
