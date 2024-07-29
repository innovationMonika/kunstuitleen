<?php 
    get_header(); 
    
    $cookieWebVariant   = get_web_variant();
    $favorieten         = get_favorieten();
    $preselect_client   = get_preselect_client(); 
    
    $kunstenaar = get_field('art_kunstenaar');

    $backlinkFilter = apply_filters('collectie_backlink', NULL);
    $backlink = $backlinkFilter[0];
    $backlinkLabel = $backlinkFilter[1];


    $favorite_cta_label = get_field('collectie_favorite_cta_label_' . $cookieWebVariant, 'option');

?>
    
    <section class="container relative" id="single-art">
        <?php if ( function_exists('yoast_breadcrumb') && !is_singular( 'preselect_collection' ) ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        <?php if(  is_singular( 'preselect_collection' ) ): echo '<p></p>'; endif; ?>
        
        <a href="<?php echo $backlink; ?>" id="back" class="backlink"><?php echo $backlinkLabel; ?></a>
        
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column page-content">
                                
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                
                    <section class="page-art-content relative">
                        <section class="row">
                            <aside class="col-xs-12 col-sm-8 col-md-8 col-lg-9 art-image text-center">
                                <?php $image = get_field('art_image'); ?>
                                <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />
                            </aside>
                            
                            <article class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                
                                <h1><?php the_title(); ?></h1>
                                
                                <?php if( $cookieWebVariant == 'werk' ): 
                                    $waarde = get_the_terms( $post->ID, 'waarde' );
                                    if( $waarde[0]->slug == 'r' || $waarde[0]->slug == 'x' ):
                                        $waardeParam = '&waarden='.$waarde[0]->slug;
                                    endif;
                                endif;
                                ?>
                                
                                <?php 
                                    $kunstenaar_args = array('post_type' => 'kunstenaar', 'include' => ($kunstenaar), 'showposts' => '1' ); 
                                    $kunstenaar_name = get_posts( $kunstenaar_args ); 
                                    
                                    if( $kunstenaar_name ):
                                ?>
                                    <h2 class="kunstenaar">
                                        <a href="#biografie">
                                           <?php echo $kunstenaar_name[0]->post_title; ?>
                                        </a>
                                    </h2>
                                <?php endif; ?>
                                
                                <?php //$cookie_name = ( is_singular( 'preselect_collection' ) ? 'favorieten-preselect-'.$preselect_client['client_code'] : 'favorieten'.$cookieWebVariant); ?>
                                <?php //$cookie = $_COOKIE[$cookie_name]; $cookie = stripslashes($cookie); $favorieten = json_decode($cookie, true); ?>
                                                                
                                <ul class="art-meta">
                                    
                                    <?php if( $cookieWebVariant == 'werk' ): ?>
                                        <?php if($waarde){ ?>
                                            <li><label>Categorie:</label> <?php echo strtoupper($waarde[0]->slug); ?></li>
                                        <?php } ?>
                                    <?php endif; ?>
                                    
                                    <?php $technieken = get_the_terms( $post->ID, 'techniek' ); ?>
                                    <?php if( !empty($technieken) ) { foreach($technieken as $technieken){ $techniek = $technieken->name; } ?>
                                    <?php if($technieken){ ?>
                                        <li><label>Techniek:</label> <?php echo $techniek; ?></li>
                                    <?php }} ?>
                                    
                                    <?php $stijlen = get_the_terms( $post->ID, 'stijl' ); ?>
                                    <?php if( !empty($stijlen) ) {foreach($stijlen as $stijlen){ $stijl = $stijlen->name; } ?>
                                    <?php if($stijl){ ?>
                                        <li><label>Stijl:</label> <?php echo $stijl; ?></li>
                                    <?php }} ?>
                                    
                                    <?php if( !empty($orientaties) ) {$orientaties = get_the_terms( $post->ID, 'orientatie' ); ?>
                                    <?php foreach($orientaties as $orientaties){ $orientatie = $orientaties->name; } ?>
                                    <?php if($orientatie){ ?>
                                        <li><label>Oriëntatie:</label> <?php echo $orientatie; ?></li>
                                    <?php }} ?>
                                    
                                    <?php if( $cookieWebVariant == 'thuis' ): ?>
                                        <li><label>Beeldformaat:</label> <?php the_field('art_afmeting'); ?> cm</li>
                                    <?php endif; ?>
                                    <li><label>Lijstformaat:</label> <?php the_field('art_lijstafmeting'); ?> cm</li>
                                    <li><label>Nummer:</label> <?php the_field('art_inventnr') . ( !empty(get_field('art_schap')) && $cookieWebVariant == 'werk' ? ' / ' . get_field('art_schap') : ''); ?></li>
                                    <li><label>Vrij voor verhuur:</label> Ja</li>
                                </ul>
                                
                                <ul class="art-meta border">
                                    
                                    <?php if( $cookieWebVariant == 'thuis' ): ?>
                                        <?php $maandbedrag = get_the_terms( $post->ID, 'maandbedrag' ); ?>
                                        <li><label>Maandbedrag:</label> &euro; <?php the_field('art_maandprijs'); ?><br/><label>(waarvan 50% spaartegoed)</label></li>
                                    <?php endif; ?>
                                    
                                    <?php if( !is_singular( 'preselect_collection' ) ): ?>
                                        <li><label>Direct kopen:</label> &euro; <?php the_field('art_prijs'); ?></li>
                                    <?php endif; ?>
                                    
                                </ul>
								
								<?php if (in_array( get_the_ID(), $favorieten )) { $span = 'TOEGEVOEGD';  } else { $span = 'VOEG TOE'; } ?>
                                
                                <section class="favorite<?php if (in_array( get_the_ID(), $favorieten )) { echo ' active'; } ?><?php if( !empty($preselect_client) ): echo ' preselect-favorite'; endif; ?>" id="<?php echo get_the_ID(); ?>">

                                    <?php if( !empty($favorite_cta_label) ) { ?>
                                        <div class="cta">
                                            <div class="cta-label"><?= $favorite_cta_label ?></div>
                                        </div>
                                    <?php } ?>

                                    <span><?php echo $span; ?></span>
                                </section>
                                
                                
                                <div class="share-art">
                                    <?php include( locate_template( 'inc/share.php', false, false )); ?>
                                </div>
                                
                                
                            </article>
                        </section>
                        
                        <img src="<?php bloginfo('template_url'); ?>/static/images/art-corner.svg" class="corner" />
                        
                        <?php /* Custom Prev/Next Post Buttons script, build for meta_key and meta_query */
                            $filters = array();
                                    
                            $prevNextFilters = explode('&', $backToActiveFilters);
                            foreach($prevNextFilters as $prevNextFilter):
                                $filterSplit = explode('=', $prevNextFilter);
                                if( is_array($filterSplit) && isset($filterSplit1) ) {
                                    $filters[$filterSplit[0]] = $filterSplit[1];
                                }
                            endforeach;
                            
                            $args = array(
                                'post_type'         => 'collectie', 
                                'meta_key'          => 'art_inkoopdat', 
                                'orderby'           => 'menu_order meta_value',
                                'order'             => 'DESC', 
                                'posts_per_page'    => '-1',
                                'fields'            => 'ids'
                            );
                            
                            // Extra args
                            if( !empty( $filters['c'] ) ):
                                $args['s'] = $filters['c'];
                            endif;
                            
                            if( isset($filters['kunstenaars']) ):
        
                                if( !array_key_exists('meta_query', $args) ): $args['meta_query'] = array('relation' => 'AND'); endif;
                                
                                $args['meta_query'] = array(
                        			'key'     => 'art_kunstenaar',
                        			'value'   => array(strstr($filters['kunstenaars'], '_', true)),
                        			'compare' => 'IN',
                            	);
                            	
                            endif;
                            
                            $taxes = [
                                'stijl'         => 'stijlen',
                                'orientatie'    => 'orientaties',
                                'waarde'        => 'waarden',
                                'formaat'       => 'formaten',
                                'techniek'      => 'technieken',
                            ];
                            
                            foreach( $taxes as $key => $var ):
                            
                                if( isset($filters[$var]) && !empty($filters[$var]) ):
                                
                                    if( !array_key_exists('tax_query', $args) ): $args['tax_query'] = array('relation' => 'AND'); endif;
                                    
                                    $args['tax_query'] = [
                                        'taxonomy' => $key,
                            			'field'    => 'slug',
                            			'terms'    => $var,
                                    ];
                                    
                                endif;
                            
                            endforeach;
                                
                            // IF no waarden is selected, exclude waarde: r & x
                            if( empty( $filters['waarden'] ) ):
                                
                                if( !array_key_exists('tax_query', $args) ): $args['tax_query'] = array('relation' => 'AND'); endif;
                                
                                $args['tax_query'] = [
                        			'taxonomy' => 'waarde',
                        			'field'    => 'slug',
                        			'terms'    => array( 'r', 'x' ),
                                    'operator' => 'NOT IN',
                                ];
                            
                            endif; 
                            
                            $postslist  = get_posts( $args ); 
                            $postID     = get_the_ID(); $maxPosts = count($postslist) - 1;
                            $postKey    = array_search($postID, $postslist);
                            
                            if( !is_singular( 'preselect_collection' ) ): //Added because preselection next / prev arrow is breaking the system rules
                                if( $postKey != 0 ){
                                    echo '<a href="' . get_permalink($postslist[$postKey-1]) . '" class="art-prev art-nav"><i class="fa fa-arrow-circle-left"></i></a>';
                                }
                                if( $postKey != $maxPosts ){ 
                                    echo '<a href="' . get_permalink($postslist[$postKey+1]) . '" class="art-next art-nav"><i class="fa fa-arrow-circle-right"></i></a>';
                                }
                            endif;
                        ?>
                    </section>
                    
                <?php endwhile; endif; ?>
                
            </article>
            		
		</section>
		
		<?php if($kunstenaar){ ?>
		    <?php if( is_array($kunstenaar) ): $kunstenaar = $kunstenaar[0]; endif; ?>
    		<section class="row" id="biografie">
        		
                <?php if( $cookieWebVariant == 'werk' ):
                    $bigCol = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
                    $imgCol = 'hidden-xs col-sm-5 col-md-4 col-lg-4';
                    $bioCol = 'col-xs-12 col-sm-7 col-md-8 col-lg-8';
                else:
                    $bigCol = 'col-xs-12 col-sm-8 col-md-8 col-lg-8';
                    $imgCol = 'hidden-xs col-sm-4 col-md-4 col-lg-4';
                    $bioCol = 'col-xs-12 col-sm-8 col-md-8 col-lg-8';
                endif; ?>
                <article class="<?php echo $bigCol; ?> column biografie">
                    <?php $the_query = new WP_Query( 
                       array( 'post_type' => 'kunstenaar', 'p' => $kunstenaar, 'showposts' => '1') ); ?>
                    <?php if ( $the_query->have_posts() ) {	while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
                        <section class="row">
                            <aside class="<?php echo $imgCol; ?> text-center">
                                
                                <?php 
                                   $artist_name = get_the_title();
                                   $artist_idslug = get_the_ID().'_'.basename(get_permalink());
                                   $artist_content_intro = substr(str_replace('\n', '<br/>', get_the_content()), 0, 750 );
                                   $artist_content_more = substr(str_replace('\n', '<br/>', get_the_content()), 750, 999999 );
                                ?>
                                
                                <?php $kimage = get_field('kunstenaar_foto'); ?>
                          
                                <?php if(!$kimage || $kimage == 'https://www.petermaasdam.nl/kunstuitleen/images/largenofile.jpg'){ 
                                    $inner_query = new WP_Query( array( 
                                        'post_type' => 'collectie', 
                                        'meta_query' => array(
                                            array(
                                                'key' => 'art_kunstenaar',
                                                'value' => $kunstenaar,
                                            )
                                        ), 
                                        'orderby' => 'rand',
                                        'showposts' => '1') );
                                    if ( $inner_query->have_posts() ) {	while ( $inner_query->have_posts() ) { $inner_query->the_post();
                                         $kimage = get_field('art_image');
                                    } /* endwhile */ } /* endif */ /* Restore original Post Data */  
                                }  ?>
                                
                                <img src="<?php echo $kimage; ?>" alt="<?php the_title(); ?>" />    
                            </aside>
                            
                            <article class="<?php echo $bioCol; ?>">
                                <h2>Biografie <?php echo $artist_name; ?></h2>
                                
                                <a href="<?php echo get_permalink($backID); ?>?kunstenaars=<?php echo $artist_idslug.(isset($waardeParam) ? $waardeParam : ''); ?>" class="more-art">
                                    Meer werk van <?php echo $artist_name; ?> bij KUNSTUITLEEN.NL
                                </a><br/>
                                
                                
                                <?php 
                                    $artist_content = $artist_content_intro;
                                    if( $artist_content_more ) {  
                                        $artist_content .= '<span class="bio-dots">...</span><span class="bio-more">';
                                        $artist_content .= $artist_content_more;
                                        $artist_content .= '</span>';
                                        $artist_content .= '<br/><a class="button-simple showfullbio" href="#more-bio">Lees meer</a>';
                                    } 
                                ?>
                                
                                <?php echo apply_filters('the_content', $artist_content); ?>
                               
                            </article>
                        </section>
                    <?php  } /* endwhile */ } /* endif */ wp_reset_postdata(); /* Restore original Post Data */ ?>
                </article>
                <?php if( $cookieWebVariant != 'werk' ): ?>
                <aside class="hidden-xs col-sm-4 col-md-4 col-lg-4">
                    <?php $singleProduct = true; ?>
                    <?php include( locate_template( 'inc/voordelen-thuis.php', false, false )); ?>
                </aside>
                <?php endif; ?>
    		</section>
		<?php } ?>
		
    </section>

    <?php if( !empty($preselect_client) ): ?>
        <input type="hidden" value="<?php echo $preselect_client['client_code']; ?>" name="preselect_client_code" id="preselect_client_code" />
        <input type="hidden" value="<?php echo $preselect_client['client_id']; ?>" name="preselect_client_id" id="preselect_client_id" />
    <?php endif; ?>

<?php get_footer(); ?>
