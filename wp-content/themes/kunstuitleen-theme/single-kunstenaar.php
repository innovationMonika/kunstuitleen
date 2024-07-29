<?php 
    get_header(); 
    
    // Vars
    $cookieWebVariant = get_web_variant(); 
    
    $backID = ( $cookieWebVariant == 'werk' ? 121857 : 122289 );
    
    
    if ( strpos( $_SERVER['HTTP_REFERER'], get_permalink($backID) ) !== false ) {
        $backlink = $_SERVER['HTTP_REFERER'];
    } else {
        $backlink = get_permalink($backID).'?backto='.basename(get_permalink());
    }
        
    $backlinkLabel = 'Terug naar de kunstenaars';
    
?>

    <section class="container relative" id="single-kunstenaar">
        
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        <a href="<?php echo $backlink; ?>" id="back" class="backlink"><?php echo $backlinkLabel; ?></a>
        
		<section class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column page-artist-content biografie">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <section class="row">
                        <aside class="hidden-xs col-sm-5 col-md-4 col-lg-4">
                            
                            <?php 
                               $artist_idslug = get_the_ID().'_'.basename(get_permalink());
                               $artist_name = get_the_title();
                            ?>
                            
                            <?php $kimage = get_field('kunstenaar_foto'); ?>
                      
                            <?php  
                                if( $kimage == 'https://www.petermaasdam.nl/kunstuitleen/images/largenofile.jpg'): 
                                    $artArgs = array(
                                        'post_type'  => 'collectie',
                                        'orderby'    => 'rand',
                                        'showposts' => 1,
                                        'meta_query' => array(
                                    		array(
                                    			'key'     => 'art_kunstenaar',
                                    			'value'   => array(get_the_ID()),
                                    			'compare' => 'IN',
                                    		),
                                    	),
                                    	'tax_query' => [
                                        	[
                                    			'taxonomy' => 'waarde',
                                    			'field'    => 'slug',
                                    			'terms'    => array( 'r', 'x', 's' ),
                                                'operator' => 'NOT IN',
                                            ]
                                    	]
                                    );
                                    
                                    $getArt = get_posts($artArgs);
                                    
                                    if( !empty($getArt) ):
                                        $kimage = get_field('art_image', $getArt[0]->ID); 
                                        echo '<img src="' . $kimage . '" alt="' . $artist_name . '" />    ';
                                    endif;
                                    
                                else:
                                    echo '<img src="' . $kimage . '" alt="' . $artist_name . '" />    ';
                                endif; 
                            ?>
                            
                            
                        </aside>
                        
                        <article class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
                            <h2>Biografie <?php the_title(); ?></h2>
                            
                            <a href="#collectie-van-kunstenaar" class="more-art">
                                Werk van <?php the_title(); ?> bij KUNSTUITLEEN.NL
                            </a><br/>
                            
                            
                            <?php $artistContent = apply_filters('the_content', get_the_content()); ?>
                            
                            <?php $artistContentSplit = explode('</p>', $artistContent); ?>
                            <?php $i = 0; $countP = count($artistContentSplit); ?>
                            <?php 
                                
                                foreach( $artistContentSplit as $p ): 
                                    if( $countP > 2 && $i == 2 ): echo '<div class="bio-more">'; endif;
                                    echo $p.'</p>';
                                $i++; endforeach; 
                                
                                // Closing div and button
                                if( $countP > 2 ): echo '</div><a class="button-simple showfullbio" href="#more-bio">Lees meer</a>'; endif; 
                            
                            ?>
                            
                        </article>
                    </section>
                <?php endwhile; endif; ?>
            </article>
		</section>
		
    </section>
    
    <?php 
        // Query-args
        $args = array(
            'post_type'         => 'collectie', 
            'meta_key'          => 'art_inkoopdat', 
            'orderby'           => 'menu_order meta_value',
            'order'             => 'DESC', 
            'posts_per_page'    => 12,
            'meta_query'        => [
        		[
        			'key'     => 'art_kunstenaar',
        			'value'   => array(get_the_ID()),
        			'compare' => 'IN',
        		],
        	],
        	'tax_query' => [
            	[
        			'taxonomy' => 'waarde',
        			'field'    => 'slug',
        			'terms'    => array( 'r', 'x', 's' ),
                    'operator' => 'NOT IN',
                ]
        	]
        );
        
        // Extra args
        if( !empty( safe_get('c') ) ):
            $args['s'] = safe_get('c');
        endif;
        
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
        
        // the Query
        $the_query = new WP_Query($args);
        
        $maxPages   = $the_query->max_num_pages;
        $totalFound = $the_query->found_posts;
    ?>
    
    <section class="container ajaxloading" id="collectie">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="collectie-van-kunstenaar">
                <h2>Werk van <?php the_title(); ?></h2>
            </article>
        </section>
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column">
                <section class="row collectie">               
                    <script>
                        var maxPages = <?php echo $maxPages; ?>;
                        var currentPage = 2;
                        var kunstenaarID = '<?php echo get_the_ID().'_'.basename(get_permalink()); ?>';
                    </script>

                    <?php if ( $the_query->have_posts() ) {	while ( $the_query->have_posts() ) { $the_query->the_post();  ?>
                        <?php include( locate_template( 'inc/art.php', false, false )); ?>
                    <?php  } /* endwhile */ } /* endif */ wp_reset_postdata(); /* Restore original Post Data */ ?>
                    
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
