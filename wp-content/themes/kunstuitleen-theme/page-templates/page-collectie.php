<?php
/*
    Template name: Collectie (overzicht)
*/    
    get_header(); 
    
    // Vars
    $cookieWebVariant = get_web_variant(); 
    
    // Query-args
    $args = array(
        'post_type'         => 'collectie', 
        'meta_key'          => 'art_inkoopdat', 
        'orderby'           => 'menu_order meta_value',
        'order'             => 'DESC', 
        'posts_per_page'    => 12,
    );
    
    // Extra args
    if( !empty( safe_get('c') ) ):
        $args['s'] = safe_get('c');
    endif;
    

    if( safe_get('consignatie') ):
        
        if( !array_key_exists('meta_query', $args) ): $args['meta_query'] = array('relation' => 'AND'); endif;
        
        $args['meta_query'] = array(
			'key'     => 'art_consignatie',
			'value'   => safe_get('consignatie'),
    	);
    	
    endif;
    
    if( safe_get('kunstenaars') ):
        
        if( !array_key_exists('meta_query', $args) ): $args['meta_query'] = array('relation' => 'AND'); endif;
        
        $args['meta_query'] = array(
			'key'     => 'art_kunstenaar',
			'value'   => array(strstr(safe_get('kunstenaars'), '_', true)),
			'compare' => 'IN',
    	);
    	
    endif;
    
    if( safe_get('kunstenaars') ):
        
        if( !array_key_exists('meta_query', $args) ): $args['meta_query'] = array('relation' => 'AND'); endif;
        
        $args['meta_query'] = array(
			'key'     => 'art_kunstenaar',
			'value'   => array(strstr(safe_get('kunstenaars'), '_', true)),
			'compare' => 'IN',
    	);
    	
    endif;
    
    $taxes = [
        'stijl'         => 'stijlen',
        'orientatie'    => 'orientaties',
        'waarde'        => 'waarden',
        'formaat'       => 'formaten',
        'techniek'      => 'technieken',
        'maandbedrag'   => 'maandbedragen',
    ];
    
    foreach( $taxes as $key => $var ):
    
        if( safe_get($var) ):
        
            if( !array_key_exists('tax_query', $args) ): $args['tax_query'] = array('relation' => 'AND'); endif;
            
            $args['tax_query'][] = [
                'taxonomy' => $key,
    			'field'    => 'slug',
    			'terms'    => safe_get($var),
            ];
            
        endif;
    
    endforeach;
    
    // IF no waarden is selected, exclude waarde: r & x
    if( empty( safe_get('waarden') ) && $cookieWebVariant === 'werk' || $cookieWebVariant === 'thuis' ):
        
        if( !array_key_exists('tax_query', $args) ): $args['tax_query'] = array('relation' => 'AND'); endif;
        
        $args['tax_query'][] = [
			'taxonomy' => 'waarde',
			'field'    => 'slug',
			'terms'    => array( 'r', 'x', 's' ),
            'operator' => 'NOT IN',
        ];
    
    endif;
    
    $currentPage = 1;
    $ajax_last_loaded_page = get_cookie_value('ajax_last_loaded_page'); // prev: collectieCurrentPage 
    
    
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
    
    <section id="filters" class="column <?php echo ( $cookieWebVariant === 'werk' ? 'werk' : 'red' ); ?> relative">
        <form action="<?php echo get_permalink($post->ID); ?>" id="filter" method="get">
         
            <section class="container">
                <section class="row">
                    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter-option">
                        
                        <section class="row">
                            <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <h3 class="nomargin">Zoek op:</h3>
                                <div class="filter-search">
                                    <?php $searched = safe_get('c'); ?>
                                    <input type="text" name="c" id="c" value="<?php echo $searched; ?>" placeholder="Titel, nummer, etc..." />
                                    
                                    <ul class="custom-autocomplete"></ul>
                                    
                                    <img src="<?php bloginfo('template_url');?>/static/images/<?php echo $cookieWebVariant; ?>-filter-search.svg" alt="Zoeken >" class="filter-submit" />
                                </div>
                            </section>
    
                            <?php 
                                $args = array(
                                    'post_type' => 'kunstenaar', 
                                    'orderby' => 'name', 
                                    'order' => 'ASC', 
                                    'posts_per_page' => '-1',
                                    'meta_query' => array(
                                		array(
                                			'key'     => 'kunstenaar_kunstkunstenaar',
                                			'value'   => 'false',
                                			'compare' => '!=',
                                		),
                                    ),
                                );
                                $kunstenaars = get_posts( $args );
                            ?>
                            
                            <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter-option filter-kunstenaars">
                                <h3 class="nomargin">Kunstenaars:</h3>
                                <select name="kunstenaars">
                                    <option value="">Alle kunstenaars</option>
                                    <?php foreach ( $kunstenaars as $kunstenaar ) : if( $kunstenaar->post_name ): ?>
                                        <?php $optionVal = $kunstenaar->ID.'_'.$kunstenaar->post_name; ?>
                                        <?php if( $optionVal == safe_get('kunstenaars') ): ?>
                                            <option value="<?php echo $optionVal; ?>" selected="selected"><?php echo $kunstenaar->post_title; ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo $optionVal; ?>"><?php echo $kunstenaar->post_title; ?></option>
                                        <?php endif; ?>
                                    <?php endif; endforeach; ?>
                                </select>
                            </section>
                            
                        </section>
                        
                        <section class="row">
                            <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter-option">
                                <h3>Stijl:</h3>
                                <?php createFilter('stijlen', 'stijl'); ?>
                            </section>
                            <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter-option">
                                <h3>Oriëntatie:</h3>
                                <?php createFilter('orientaties', 'orientatie'); ?>
                            </section>
                        </section>
                        
                    </section>
                    
                    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        
                        <div class="filter-option">
                            <?php if( $cookieWebVariant === 'werk' ): ?>
                                <h3 class="nomargin">Waarde:</h3>
                                <?php createFilter('waarden', 'waarde'); ?>
                            <?php else: ?>
                                <h3 class="nomargin">Maandbedrag:</h3>
                                <?php createFilter('maandbedragen', 'maandbedrag'); ?>
                            <?php endif; ?>
                        </div>
                        
                        <section class="row">
                            <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter-option">
                                <h3>Formaat:</h3>
                                <?php createFilter('formaten', 'formaat'); ?>
                            </section>
                            <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter-option">
                                <h3>Techniek:</h3>
                                <?php createFilter('technieken', 'techniek', array(28)); ?>
                            </section>
                        </section>
                        
                    </section>
                </section>
                <?php /*<aside class="results"><?php echo $the_query->found_posts; ?> kunstwerken gevonden</aside>*/ ?>
            </section>
            
            <?php if( safe_get('consignatie') ): ?>
                <input type="hidden" value="<?php echo safe_get('consignatie'); ?>" name="consignatie" />
            <?php endif; ?>
            
        </form>
    </section>
    
    <section class="container ajaxloading" id="collectie">        
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column">
                <section class="row collectie">
                
                    <script>
                        var maxPages = <?php echo $maxPages; ?>;
                        var currentPage = <?php echo $currentPage + 1; // + 1 for next page ?>;           
                    </script>

                    <?php if ( $the_query->have_posts() ) {	while ( $the_query->have_posts() ) { $the_query->the_post();  ?>
                        <?php include( locate_template( 'inc/art.php', false, false )); ?>
                    <?php  } /* endwhile */ } /* endif */ wp_reset_postdata(); /* Restore original Post Data */ ?>
                    
                    <?php include( locate_template( 'inc/art-ad.php', false, false )); ?>
                    
                </section>

                <aside class="loading text-center clear">
                    <img src="<?php bloginfo('template_url'); ?>/static/images/arrow-rotatie.gif" alt="Bezig met laden" />
                </aside>
                
                <aside class="end-message text-center<?php echo ($totalFound == 0 ? ' show' : ''); ?>">
                    Er zijn geen kunstwerken (meer) gevonden die aan uw zoekcriteria voldoen. Probeer het gerust opnieuw door uw zoekopdracht aan te passen.
                </aside>
                
            </article>
		</section>
    </section>

<?php get_footer(); ?>
