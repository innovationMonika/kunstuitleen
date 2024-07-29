<?php
/*
    Template name: Collection Demo
*/
get_header();

// Vars
$cookieWebVariant = get_web_variant();

// Query-args
$args = array(
    'post_type' => 'collectie',
    'meta_key' => 'art_inkoopdat',
    'orderby' => 'menu_order meta_value',
    'order' => 'DESC',
    'posts_per_page' => 12,
);

// Extra args
if (!empty(safe_get('c'))):
    $args['s'] = safe_get('c');
endif;

if (safe_get('consignatie')):

    if (!array_key_exists('meta_query', $args)):
        $args['meta_query'] = array(
            'relation' => 'AND'
        );
    endif;

    $args['meta_query'] = array(
        'key' => 'art_consignatie',
        'value' => safe_get('consignatie') ,
    );

endif;

if (safe_get('kunstenaars')):

    if (!array_key_exists('meta_query', $args)):
        $args['meta_query'] = array(
            'relation' => 'AND'
        );
    endif;

    $args['meta_query'] = array(
        'key' => 'art_kunstenaar',
        'value' => array(
            strstr(safe_get('kunstenaars') , '_', true)
        ) ,
        'compare' => 'IN',
    );

endif;

if (safe_get('kunstenaars')):

    if (!array_key_exists('meta_query', $args)):
        $args['meta_query'] = array(
            'relation' => 'AND'
        );
    endif;

    $args['meta_query'] = array(
        'key' => 'art_kunstenaar',
        'value' => array(
            strstr(safe_get('kunstenaars') , '_', true)
        ) ,
        'compare' => 'IN',
    );

endif;

$taxes = ['stijl' => 'stijlen', 'orientatie' => 'orientaties', 'waarde' => 'waarden', 'formaat' => 'formaten', 'techniek' => 'technieken', 'maandbedrag' => 'maandbedragen', ];

foreach ($taxes as $key => $var):

    if (safe_get($var)):

        if (!array_key_exists('tax_query', $args)):
            $args['tax_query'] = array(
                'relation' => 'AND'
            );
        endif;

        $args['tax_query'][] = ['taxonomy' => $key, 'field' => 'slug', 'terms' => safe_get($var) , ];

    endif;

endforeach;

// IF no waarden is selected, exclude waarde: r & x
if (empty(safe_get('waarden')) && $cookieWebVariant === 'werk' || $cookieWebVariant === 'thuis'):

    if (!array_key_exists('tax_query', $args)):
        $args['tax_query'] = array(
            'relation' => 'AND'
        );
    endif;

    $args['tax_query'][] = ['taxonomy' => 'waarde', 'field' => 'slug', 'terms' => array(
        'r',
        'x',
        's'
    ) , 'operator' => 'NOT IN', ];

endif;

$currentPage = 1;
$ajax_last_loaded_page = get_cookie_value('ajax_last_loaded_page'); // prev: collectieCurrentPage


if (!empty($ajax_last_loaded_page) && !empty(safe_get('backto')))
{

    // count Query
    $count_query = new WP_Query($args);

    $maxPages = $count_query->max_num_pages;
    $totalFound = $count_query->found_posts;

    $currentPage = $ajax_last_loaded_page;
    $args['posts_per_page'] = $args['posts_per_page'] * $ajax_last_loaded_page;

    // the Query
    $the_query = new WP_Query($args);

}
else
{

    // the Query
    $the_query = new WP_Query($args);

    $maxPages = $the_query->max_num_pages;
    $totalFound = $the_query->found_posts;

}

?>
    
    
    <section class="container relative page-content-container">
        <?php if (function_exists('yoast_breadcrumb'))
{
    yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
} ?>
        
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 column page-content">
                <?php if (have_posts()):
    while (have_posts()):
        the_post(); ?>
                    <!-- <h1><?php the_title(); ?></h1> -->
                    <?php the_content(); ?>
                <?php
    endwhile;
endif; ?>
            </article>
            		
		</section>
  

<div class="d-flex flex-column h-100 collect">
	
<div class="flex-shrink-0">

    <section class="container col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="tab-content">
                            <div clas="row">
                            <div class="container mt-4">
                                <div class="row">
                                    <section class="col-md-12 conatiner">
                                        <div class="row text-center">
                                            <div class="col-md-12">
                                                <h1 class="text-muted cinzel">
                                                    COLLECTION
                                                </h1>
                                            </div>
                                            <div>
                                                <label class="col text-muted mr-jonas font-size">Select your favorite works of art from the largest and most contemporary art collection from  Netherlands</label>
                                            </div>
                                        </div>
                                        <div class="tabbable-panel">
                                            <div class="tabbable-line">
                                                <ul class="nav nav-tabs nav-justified mt-4">
                                                    <li class="active"><a href="#tab1default" data-toggle="tab"><label class="collection-heading h4 text-uppercase"><strong>Collection</strong></label></a></li>
                                                    <li><a href="#tab2default" data-toggle="tab"><label class="collection-heading h4 text-uppercase"><strong>My favorites</strong></label></a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade in active" id="tab1default">
                                                        <div class="row collection">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <a href="/test-collection" type="button" class="back-btn btn btn-default btn-lg btn-block text-capitalize"><i class="fa fa-chevron-left"></i><span class="btn-label"></span>back to collection overview</a>
                                                                    </div>
                                                                </div>
                                                                <section class="page-art-content relative">
                                                                    <div class="row collection">
                                                                        <div class="col-md-12">
                                                                            <aside class="col-xs-12 col-sm-8 col-md-8 col-lg-9 art-image text-center">
                                                                           
                                                                                <?php $image = get_field('art_image'); ?>
                                                                                <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />

                                                                                <div class="col-md-offset-2 col-md-8">
                                                                                    <button type="button" class="btn btn-default btn-lg btn-block image-model" data-toggle="modal" data-target="#myModal"><strong>Vergroot zien</strong></button>
                                                                                </div>
                                                                            </aside>
                                                                            <article class="text-center col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                                                                <h1 class="text-muted cinzel text-uppercase"><?php the_title(); ?></h1>

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

                                                                                <ul class="art-meta">
                                                                                    <?php if( $cookieWebVariant == 'werk' ): ?>
                                                                                        <?php if($waarde){ ?>
                                                                                            <li><label>Categorie:</label> <?php echo strtoupper($waarde[0]->slug); ?></li>
                                                                                        <?php } ?>
                                                                                    <?php endif; ?>
                                                                                    
                                                                                    <?php $technieken = get_the_terms( $post->ID, 'techniek' ); ?>
                                                                                    <?php foreach($technieken as $technieken){ $techniek = $technieken->name; } ?>
                                                                                    <?php if($technieken){ ?>
                                                                                        <li><label>Technician   :</label> <?php echo $techniek; ?></li>
                                                                                    <?php } ?>
                                                                                    
                                                                                    <?php $stijlen = get_the_terms( $post->ID, 'stijl' ); ?>
                                                                                    <?php foreach($stijlen as $stijlen){ $stijl = $stijlen->name; } ?>
                                                                                    <?php if($stijl){ ?>
                                                                                        <li><label>Style:</label> <?php echo $stijl; ?></li>
                                                                                    <?php } ?>
                                                                                    
                                                                                    <?php $orientaties = get_the_terms( $post->ID, 'orientatie' ); ?>
                                                                                    <?php foreach($orientaties as $orientaties){ $orientatie = $orientaties->name; } ?>
                                                                                    <?php if($orientatie){ ?>
                                                                                        <li><label>Orientation:</label> <?php echo $orientatie; ?></li>
                                                                                    <?php } ?>
                                                                                    
                                                                                    <?php if( $cookieWebVariant == 'thuis' ): ?>
                                                                                        <li><label>Image format:</label> <?php the_field('art_afmeting'); ?> cm</li>
                                                                                    <?php endif; ?>
                                                                                    <li><label>List format:</label> <?php the_field('art_lijstafmeting'); ?> cm</li>
                                                                                    <li><label>Number:</label> <?php the_field('art_inventnr') . ( !empty(get_field('art_schap')) && $cookieWebVariant == 'werk' ? ' / ' . get_field('art_schap') : ''); ?></li>
                                                                                    <li><label>Free for rental:</label> Ja</li>
                                                                                </ul>

                                                                                <ul class="art-meta border">
                                                                                    <?php if( $cookieWebVariant == 'thuis' ): ?>
                                                                                        <?php $maandbedrag = get_the_terms( $post->ID, 'maandbedrag' ); ?>
                                                                                        <li><label>Monthly amount:</label> &euro; <?php the_field('art_maandprijs'); ?><br/><label>(waarvan 50% spaartegoed)</label></li>
                                                                                    <?php endif; ?>
                                                                                    
                                                                                    <?php if( !is_singular( 'preselect_collection' ) ): ?>
                                                                                        <li><label>Buy directly:</label> &euro; <?php the_field('art_prijs'); ?></li>
                                                                                    <?php endif; ?>
                                                                                </ul>

                                                                                <?php if (in_array( get_the_ID(), $favorieten )) { $span = 'DELETE';  } else { $span = 'ADD'; } ?>
                                                                                
                                                                                <section class="favorite<?php if (in_array( get_the_ID(), $favorieten )) { echo ' active'; } ?><?php if( !empty($preselect_client) ): echo ' preselect-favorite'; endif; ?>" id="<?php echo get_the_ID(); ?>"><span><?php echo $span; ?></span></section>
                                                                                <!-- <section class="favorite" style="margin-top: 68px;"><span>ADD</span></section> -->
                                                                            </article>
                                                                        </div>
                                                                    </div>
                                                                    <img src="https://kunstuitleen.nl/wp-content/themes/kunstuitleen/static/images/art-corner.svg" class="corner">
                                                                    <a href="#" class="art-prev art-nav"><i class="fa fa-arrow-circle-left back-arrow"></i></a>
                                                                    <a href="#" class="art-next art-nav"><i class="fa fa-arrow-circle-right back-arrow"></i></a>
                                                                </section>
                                                                <div class="row mt-4 mb-4">
                                                                    <div class="col-md-8">
                                                                        <div class="row">
                                                                            <div class="col share-art">
                                                                                Share
                                                                            </div>
                                                                            <a href="#" target="_blank" class="btn-social btn-facebook"><i class="socail-icons fa fa-facebook"></i></a>
                                                                            <a href="#" target="_blank" class="btn-social btn-twitter"><i class="socail-icons fa fa-twitter-square"></i></a>
                                                                            <a href="#" target="_blank" class="btn-social btn-linkedin"><i class="socail-icons fa fa-linkedin"></i></a>
                                                                            <a href="#" target="_blank" class="btn-social btn-pinterest"><i class="socail-icons fa fa-pinterest"></i></a>
                                                                            <a href="#" target="_blank" class="btn-social btn-whatsapp"><i class="socail-icons fa fa-whatsapp"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="margin-right:0px">
                                                                    <article class="col-xs-6 col-sm-6 col-md-8 col-lg-6">
                                                                        <section class="row row-eq-height">
                                                                            <article class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                                                                <h2 class="text-justify author mr-jonas text-uppercase"><strong>Biography Peer Rutten</strong></h2>
                                                                            </article>
                                                                            <aside class="hidden-xs col-sm-4 col-md-4 col-lg-4 author-image">
                                                                                <img src="https://www.petermaasdam.nl/kunstuitleen/artist/largerutten.jpg" alt="Peer Rutten">    
                                                                            </aside>
                                                                        </section>
                                                                        <section class="row">
                                                                            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 author-space text-center">
                                                                                <!-- <div class="well"> -->
                                                                                    <a href="#" class="btn">
                                                                                        <label class="mr-jonas text-uppercase h4"><strong>Meer werk van Peer Rutten bij KUNSTUITLEEN.NL</strong></label>
                                                                                    </a>
                                                                                <!-- </div> -->
                                                                            </article>
                                                                            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 author-paragraph">
                                                                                <p class="mr-jonas font-size">Peer Rutten grew up in Helden and showed an early interest in depicting the surrounding world. His talent was soon noticed by those around him, resulting in countless portraits of acquaintances and friends. Although sometimes years old, these drawings have still not lost any of their clarity and authenticity.<br>
                                                                                Na de grafisch studie in Eindhoven, wist Peer zich binnen korte tijd als illustrator/vormgever verdienstelijk te maken bij een reclamestudio. Voor het uitvoeren van opdrachten maakt hij inmiddels dankbaar gebruik van de computer. Misschien is het daardoor, dat hij in zijn vrije tijd juist zoekt naar wegen om zijn persoonlijke, artistieke kwaliteiten uit te drukken. Misschien is het zelfs de illustrator<span class="bio-dots">…</span><span class="bio-more">, die overdag het vuurtje bij de kunstenaar ’s avonds stevig opstookt.</span></p>
                                                                                <p class="mr-jonas font-size">De “No-serie, welke bij toeval is ontstaan, na een tekening met als titel”; “No-body”. In deze serie zijn letters en cijfers een belangrijk onderdeel van het kunstwerk. De letters die erin verwerkt zijn, komen uit de collectie van gebruikte letters en cijfers, die hij de afgelopen jaren digitaal heeft vastgelegd. De voorwaarden, waar deze letters en cijfers aan moeten voldoen, is dat ze “de tand des tijds” hebben doorstaan. Ze liggen vaak gewoon op straat. Alleen de meeste mensen zien ze niet en lopen er gewoon aan voorbij. In deze serie krijgen ze een nieuwe identiteit en vaak zelfs de hoofdrol (titel van het werk). De basis van de “No Serie” komt voornamelijk uit de serie “Terras”, met een toevoeging van deze letters.<br><a class="showfullbio" href="#more-bio">Lees meer</a></p>
                                                                            </article>
                                                                        </section>
                                                                    </article>
                                                                    <article class="col-xs-1 col-sm-1 col-md-8 col-lg-1 column"></article>
                                                                    <aside class="hidden-xs col-sm-5 col-md-5 col-lg-5 page-section-content">
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <div class="text-center">
                                                                                    <h2 class="cinzel padding-bottom">THE ADVANTAGES OF KUNSTUITLENEN.NL</h2>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" id="voordelen"> 
                                                                            <p><i class="fa fa-thumbs-up icon-size"></i><span class="mr-jonas text-capitalize side-list">Alles goed geregeld</span></p>
                                                                            <p><i class="fa fa-comments icon-size"></i><span class="mr-jonas text-capitalize side-list">Deskundig en prersoonlijk advies</span></p>
                                                                            <p><i class="fa fa-plus icon-size"></i><span class="mr-jonas text-capitalize side-list">Ruim 30,000 kunstwerken</span></p>
                                                                            <p><i class="fa fa-shopping-cart icon-size"></i><span class="mr-jonas text-capitalize side-list">Gratis proefplaasting</span></p>
                                                                            <p><i class="fa fa-random icon-size"></i><span class="mr-jonas text-capitalize side-list">Flexibiliteit</span></p>
                                                                            <p><i class="fa fa-unlock icon-size"></i><span class="mr-jonas text-capitalize side-list">Betaalbaar</span></p>
                                                                        </div>
                                                                    </aside>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade in" id="tab2default"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <div class="modal fade modal-dialog-center" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog">
                                        <div class="modal-content" style="margin-left: 80px;">
                                            <div class="modal-header" style="margin-top: 5px;">
                                            </div>
                                            <div class="modal-body" style="text-align: center;">
                                                <img src="https://www.petermaasdam.nl/kunstuitleen/invent/inv60000/large60427.jpg" alt="no wifi">  
                                            </div>
                                            <div class="modal-footer" style="margin-bottom: 10px;"></div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
        </div>
                            </div>
                        </div>
                        <div class="tab-pane fade in" id="tab2default"></div>
            
    </section>
	 </div>
		</div>
<?php get_footer(); ?>

		
<script>
    jQuery(document).ready(function () {
        jQuery('.favorite').click(function () {
            console.log(jQuery(this).text());
            if (jQuery(this).text() == 'DELETE') {
                jQuery(this).removeClass('active');
                jQuery(this).html('<span>ADD</span>');
            } else {
                jQuery(this).addClass('active');
                jQuery(this).html('<span>DELETE</span>');
            }
        });
    });
</script>