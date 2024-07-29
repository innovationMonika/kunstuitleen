    <?php
/*
    Template name: Collectie Demo
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
<!--                     <h1><?php the_title(); ?></h1> -->
                    <?php the_content(); ?>
                <?php endwhile; endif; ?>
            </article>
            		
		</section>
    </section>

<div class="d-flex flex-column h-100 collection_page">    
    <div class="flex-shrink-0">
        <div class="container mt-4">
            <div class="row">
                <section class="container col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row text-center">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h1 class="text-muted cinzel">
                                COLLECTION
                            </h1>
                        </div>
                        <div>
                            <label class="col text-muted mr-jonas">Art inspires, makes curious and creates atmosphere. With KUNSTUITLEEN.NL you no longer have to go to a museum to admire art; you can easily bring your favorite art into your home. Renting art is very accessible and makes it possible to adjust paintings per season or attune them to your new interior. Our art collection is diverse, innovative and the largest in the Netherlands.We drive daily throughout the Netherlands and visit you without obligation so that you can admire your favorite works of art in real life. Can you make a choice? You get your favorite one month free trial. Got attached to your new asset? You can also choose to purchase the artwork with your saved savings. Curious how it works or view our collection directly ?</label>
                        </div>
                    </div>
                    <div class="tabbable-panel">
                        <div class="tabbable-line">
                            <ul class="nav nav-tabs nav-justified mt-4">
								<li class="active"><a href="#tab1default" data-toggle="tab"><label class="collection-heading h4 text-uppercase"><strong>Collection</strong></label></a></li>
								<li><a href="#tab2default" data-toggle="tab"><label class="collection-heading h4 text-uppercase"><strong>My favorites</strong></label></a></li>
                            </ul>
                            
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mt-5">
                <section class="container col-md-offset-1 col-xs-10 col-sm-10 col-md-10 col-lg-10">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab1default">
                                    <div class="row mt-4">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                                    <label class="h4 mr-jonas"><strong style="padding-right: 4px;">Collection for you</strong><span class="badge bg-info" style="background-color: #428bca;">3</span></label>
                                                </div>
                                                <div class="col-xs-12 col-sm-8 col-lg-8 col-md-8 text-center">
                                                    <div class="col-xs-12 col-sm-6 col-lg-6 col-md-6">
                                                        <input type="text" class="form-control filter-input" placeholder="Search">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div clas="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="row collection">
                                                <div class="col-md-2">
                                                    <div class="row mt-4">
                                                        <label class="h4 col-md-12 filter"><strong>Artists:</strong></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control filter-input">
                                                                <option class="form-control filter-input" selected>All artists</option>
                                                                <option class="form-control filter-input">A. van Dijk</option>
                                                                <option class="form-control filter-input">Art of Dobbenburgh</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <label class="h4 col-md-12 filter"><strong>Technic:</strong></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control filter-input">
                                                                <option class="form-control filter-input" selected>All Style</option>
                                                                <option class="form-control filter-input">A. van Dijk</option>
                                                                <option class="form-control filter-input">Art of Dobbenburgh</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <label class="h4 col-md-12 filter"><strong>Monthly amount:</strong></label>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6" style="margin-bottom: 10px;"> <input type="text" class="form-control filter-input" placeholder="€ min"></div>
                                                                <div class="col-md-6"> <input type="text" class="form-control filter-input" placeholder="€ max"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <label class="h4 col-md-12 filter"><strong>Style:</strong></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control filter-input">
                                                                <option class="form-control filter-input" selected>All Style</option>
                                                                <option class="form-control filter-input">A. van Dijk</option>
                                                                <option class="form-control filter-input">Art of Dobbenburgh</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4 filter">
                                                        <label class="h4 col-md-12"><strong>Orientation:</strong></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control filter-input">
                                                                <option class="form-control filter-input" selected>All Style</option>
                                                                <option class="form-control filter-input">A. van Dijk</option>
                                                                <option class="form-control filter-input">Art of Dobbenburgh</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <label class="h4 col-md-12 filter"><strong>Format:</strong></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control filter-input">
                                                                <option class="form-control filter-input" selected>All Style</option>
                                                                <option class="form-control filter-input">A. van Dijk</option>
                                                                <option class="form-control filter-input">Art of Dobbenburgh</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <label class="h4 col-md-12 filter"><strong>Technic:</strong></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control filter-input">
                                                                <option class="form-control filter-input" selected>All Style</option>
                                                                <option class="form-control filter-input">A. van Dijk</option>
                                                                <option class="form-control filter-input">Art of Dobbenburgh</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="width: 3%;"></div>
                                                <div class="col-md-9 mt-4">
                                                                                        
                                                    <section class="row collectie grid" id="collectie">
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade in" id="tab2default"></div>
                            </div>
                </section>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>

<script>
    jQuery(document).ready(function () {
        jQuery('.favorite').click(function () {
            console.log(jQuery(this).text());
            if (jQuery(this).text() == 'VERWIJDER') {
                jQuery(this).removeClass('active');
                jQuery(this).html('<span>VOEG TOE</span>');
            } else {
                jQuery(this).addClass('active');
                jQuery(this).html('<span>VERWIJDER</span>');
            }
        });
    });
</script>