<?php
/*
    Template name: Collectie - Voorselectie ( klant )
*/    
    get_header(); 
    
    // Vars
    
    $cookieWebVariant = get_web_variant();
    $preselect_client = get_preselect_client(); 
    
    // Query-args
    $args = array(
        'post_type'         => 'preselect_collection', 
        'meta_key'          => 'art_inkoopdat', 
        'orderby'           => 'menu_order meta_value',
        'order'             => 'DESC', 
        'posts_per_page'    => 12,
        'meta_query'        => [
            'relation' => 'AND',
            [
                'key' => 'preselect_art_already_chosen',
    			'value' => 'false',
    			'compare' => '='
            ],
            [
                'key' => 'preselect_art_customer', // name of custom field
    			'value' => $preselect_client['client_id'], // Array of values
    			'compare' => '='
            ],
        ]
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
    
    // TODO
    
    $taxes = [
        'stijl'         => 'stijlen',
        'orientatie'    => 'orientaties',
        'waarde'        => 'waarden',
        'formaat'       => 'formaten',
        'techniek'      => 'technieken',
    ];
    
    foreach( $taxes as $key => $var ):
    
        if( safe_get($var) ):
        
            if( !array_key_exists('tax_query', $args) ): $args['tax_query'] = array('relation' => 'AND'); endif;
            
            $args['tax_query'] = [
                'taxonomy' => $key,
    			'field'    => 'slug',
    			'terms'    => $var,
            ];
            
        endif;
    
    endforeach;
    
    // IF no waarden is selected, exclude waarde: r & x
    if( empty( safe_get('waarden') ) ):
        
        if( !array_key_exists('tax_query', $args) ): $args['tax_query'] = array('relation' => 'AND'); endif;
        
        $args['tax_query'] = [
			'taxonomy' => 'waarde',
			'field'    => 'slug',
			'terms'    => array( 'r', 'x' ),
            'operator' => 'NOT IN',
        ];
    
    endif; 
    

    $currentPage = 1;
    $ajax_last_loaded_page = json_decode( stripslashes( $_COOKIE['ajax_last_loaded_page'] ), true );  // prev: collectieCurrentPage
    
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
        <?php //if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 column page-content">
                <h1><?php the_title(); ?></h1>
                <div class="row">
            		<aside class="col-xs-12 col-sm-3 col-md-2">
                		<script type="text/javascript">countdown_datetime = "<?php echo date_i18n( 'Y/m/d', strtotime( get_field('preselect_client_enddate', $preselect_client['client_id']) ) ); ?> 23:59:59";</script>
                		<section id="countdown">
                    		Tijd om uit te zoeken:
                            <section class="counter-days row">
                                <div class="col-xs-6 countdown days"><div>00</div> <span>Dagen</span></div>
                                <div class="col-xs-6 countdown hours"><div>00</div> <span>Uren</span></div>
                            </section>
                        </section>
            		</aside>
            		<div class="col-xs-12 col-sm-9 col-md-10">
                		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <?php 
                                
                                $search_content = array('{{ klant_naam }}', '{{ klant_einddatum }}', '{{ klant_contractnr }}'); 
                                $replace_content = array(get_field('preselect_client_name', $preselect_client['client_id']), date_i18n( 'd F Y', strtotime( get_field('preselect_client_enddate', $preselect_client['client_id']) ) ), $preselect_client['client_code'] ); 
                            ?>
                            <?php echo apply_filters('the_content', str_replace( $search_content, $replace_content, $post->post_content ) ); ?>
                            
                            <?php echo str_replace( $search_content, $replace_content, get_field('preselect_client_intro', $preselect_client['client_id']) ); ?>
                        <?php endwhile; endif; ?>
            		</div>
        		</div>
            </article>	
		</section>
    </section>
            
    <section id="filters" class="column werk relative">
        <form action="<?php echo get_permalink($post->ID); ?>" id="filter" method="get">

            <section class="container">
                <section class="row">
                    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        
                        <section class="row">
                            <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter-option">
                                <h3 class="nomargin">Zoek op:</h3>
                                <div class="filter-search">
                                    <?php $searched = $_GET['c']; ?>
                                    <input type="text" name="c" id="c" value="<?php echo $searched; ?>" placeholder="Titel, nummer, etc..." />
                                    
                                    <ul class="custom-autocomplete"></ul>
                                    
                                    <img src="<?php bloginfo('template_url');?>/static/images/werk-filter-search.svg" alt="Zoeken >" class="filter-submit" />
                                </div>
                            </section>
    
                            <?php 
                                $artists_filters = get_field('preselect_filter_artists', $preselect_client['client_id']);
                                
                                $artist_args = array(
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
                                    'post__in' => $artists_filters 
                                );
                                $kunstenaars = get_posts( $artist_args );
                            ?>
                            
                            <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter-option filter-kunstenaars">
                                <h3 class="nomargin">Kunstenaars:</h3>
                                <select name="kunstenaars">
                                    <option value="">Alle kunstenaars</option>
                                    <?php foreach ( $kunstenaars as $kunstenaar ) : if( $kunstenaar->post_name ): ?>
                                        <?php $optionVal = $kunstenaar->ID.'_'.$kunstenaar->post_name; ?>
                                        <?php if( $optionVal == $_GET['kunstenaars'] ): ?>
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
                                <?php createFilterPreselect('stijlen', 'stijl', $preselect_client['client_id']); ?>
                            </section>
                            <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter-option">
                                <h3>Oriëntatie:</h3>
                                <?php createFilterPreselect('orientaties', 'orientatie', $preselect_client['client_id']); ?>
                            </section>
                        </section>
                        
                    </section>
                    
                    <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        
                        <div class="filter-option">
                            <h3 class="nomargin">Waarde:</h3>
                            <?php createFilterPreselect('waarden', 'waarde', $preselect_client['client_id']); ?>
                        </div>
                        
                        <section class="row">
                            <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter-option">
                                <h3>Formaat:</h3>
                                <?php createFilterPreselect('formaten', 'formaat', $preselect_client['client_id']); ?>
                            </section>
                            <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter-option">
                                <h3>Techniek:</h3>
                                <?php createFilterPreselect('technieken', 'techniek', $preselect_client['client_id']); ?>
                            </section>
                        </section>
                        
                    </section>
                </section>
                <?php /*<aside class="results"><?php echo $the_query->found_posts; ?> kunstwerken gevonden</aside>*/ ?>
            </section>
            
            <?php if( !empty($preselect_client) ): ?>
                <input type="hidden" value="<?php echo $preselect_client['client_code']; ?>" name="preselect_client_code" id="preselect_client_code" />
                <input type="hidden" value="<?php echo $preselect_client['client_id']; ?>" name="preselect_client_id" id="preselect_client_id" />
            <?php endif; ?>
            
            <?php if( $_GET['consignatie'] ): ?>
                <input type="hidden" value="<?php echo $_GET['consignatie']; ?>" name="consignatie" />
            <?php endif; ?>
            
            <input type="hidden" value="<?php echo $args['post_type']; ?>" name="wp_post_type" id="wp_post_type" />
        </form>
    </section>
    
    <section class="container ajaxloading" id="collectie">
        
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