<?php
/**
 * Class and Function List:
 * Function list:
 * Classes list:
 */
get_header();

// Vars
$cookieWebVariant = get_web_variant();
$favorieten = get_favorieten();
/*
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

endif; */
?>   
<section class="container relative page-content-container">  
    <div class="d-flex flex-column h-100 collect">	
        <div class="flex-shrink-0">
            <div class="col-md-12">     
                <?php if (function_exists("yoast_breadcrumb")) {
                    yoast_breadcrumb('<p id="breadcrumbs">', "</p>");
                } ?>                       
                <div class="row text-center">  
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h1 class="cinzel">Collectie</h1>
                    </div>
                    <div>
                    <label class="col"> <p style="text-align: center;"><span style="color: #000000;">Selecteer of sleep je favorieten naar mijn selectie en maak gebruikvan de handige filters.</span></p>
                    </label>
                    </div>                                          
                </div> 
            </div>
            <div class="col-md-12">
                <div class="tabbable-panel">
                    <div class="tabbable-line">
                        <ul class="nav nav-tabs nav-justified mt-4">
                            <li class="active"><a href="#tab1default" data-toggle="tab"><label class="collection-heading h4 text-uppercase"><strong>Collection</strong></label></a></li>
                            <li><a href="/thuis/favorieten/?filters=true" ><label class="collection-heading h4 text-uppercase"><strong>My favorites (<span class="favorite-selection-count">0</span>)</strong></label></a></li>
                        </ul>
                    </div>
                </div> 
                <div class="tab-pane fade in active" id="tab1default">
                    <div class="tab-content">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-8 text-right mt-4">
                                <a href="/thuis/collectie" type="button" id="back" class="backlink">
                                    Terug naar collectie</a>
                            </div>
                        </div>
                        <section class="page-art-content relative">
                            <section class="row collection">                                    
                                <aside class="col-xs-12 col-sm-8 col-md-8 col-lg-9 art-image text-center">

                                <?php $image = get_field(
                                "art_image"
                                ); ?>
                                <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />

                                <div class="col-md-offset-2 col-md-8">
                                <button type="button" class="btn btn-default btn-lg btn-block image-model" data-toggle="modal" data-target="#myModal"><strong>Vergroot zien</strong></button>                                   
                                </aside>
                                <article class="text-center col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                        <h1 class="text-uppercase"><?php the_title(); ?></h1>

                                        <?php 
                                            if ($cookieWebVariant =="werk"):
                                                $waarde = get_the_terms($post->ID,"waarde");
                                                if ( $waarde[0]->slug =="r" || $waarde[0]->slug =="x"):
                                                    $waardeParam = "&waarden=" .$waarde[0]->slug;
                                                endif;
                                            endif; 
                                            /*$kunstenaar_args = 
                                                [
                                                    "post_type" =>
                                                    "kunstenaar",
                                                    "include" => $kunstenaar,
                                                    "showposts" => "1"
                                                ];
                                            $kunstenaar_name = get_posts($kunstenaar_args);
                                            if ($kunstenaar_name): ?>
                                                <h2 class="kunstenaar">
                                                    <a href="#biografie"><?php echo $kunstenaar_name[0]->post_title; ?></a>
                                                </h2>
                                        <?php endif; */?>

                                        <ul class="art-meta">
                                            <?php if($cookieWebVariant == "werk"): ?>
                                            <?php if($waarde) { ?>
                                                <li><label>Categorie:</label> <?php echo strtoupper($waarde[0]->slug); ?></li>
                                            <?php } ?>
                                            <?php endif; ?>

                                            <?php $technieken = get_the_terms($post->ID,"techniek"); ?>
                                            <?php foreach ($technieken as $technieken) {
                                                $techniek = $technieken->name;
                                            } ?>
                                            <?php if ( $technieken) { ?>
                                                <li><label>Technician   :</label> <?php echo $techniek; ?></li>
                                            <?php } ?>

                                            <?php $stijlen = get_the_terms($post->ID,"stijl"); ?>
                                            <?php foreach($stijlen as $stijlen) {
                                                $stijl = $stijlen->name;
                                            } ?>
                                            <?php if ($stijl) { ?>
                                                <li><label>Style:</label> <?php echo $stijl; ?></li>
                                            <?php } ?>

                                            <?php $orientaties = get_the_terms($post->ID,"orientatie"); ?>
                                            <?php foreach ($orientaties as $orientaties) {
                                                $orientatie = $orientaties->name;
                                            } ?>
                                            <?php if ($orientatie) { ?>
                                            <li><label>Orientation:</label> <?php echo $orientatie; ?></li>
                                            <?php } ?>

                                            <?php if ($cookieWebVariant == "thuis"): ?>
                                            <li><label>Image format:</label> <?php the_field("art_afmeting"); ?> cm</li>
                                                <?php endif; ?>
                                            <li><label>List format:</label> <?php the_field("art_lijstafmeting"); ?> cm</li>
                                            <li><label>Number:</label> <?php the_field("art_inventnr") .(!empty(get_field("art_schap")) &&
                                                        $cookieWebVariant == "werk" ? " / " .get_field("art_schap"): ""); ?></li>
                                            <li><label>Free for rental:</label> Ja</li>
                                        </ul>

                                        <ul class="art-meta border">
                                            <?php if ($cookieWebVariant == "thuis"): ?>
                                                <?php $maandbedrag = get_the_terms($post->ID, "maandbedrag"); ?>
                                                <li>
                                                    <label>Monthly amount:</label> &euro; <?php the_field("art_maandprijs"); ?><br/>
                                                    <label>(waarvan 50% spaartegoed)</label>
                                                </li>
                                            <?php endif; ?>

                                            <?php if (!is_singular("preselect_collection")): ?>
                                                <li><label>Buy directly:</label> &euro; <?php the_field("art_prijs"); ?></li>
                                            <?php endif; ?>
                                        </ul>

                                        <?php if (in_array(get_the_ID(), $favorieten) ) {
                                            $span = "VERWIJDER";
                                            } else {
                                            $span = "VOEG TOE";
                                        } ?>

                                        <section class="favorite<?php
                                            if (in_array(get_the_ID(), $favorieten )) {
                                                echo " active";
                                            }
                                            if (!empty($preselect_client) ):
                                                echo " preselect-favorite";
                                            endif;
                                        ?>" id="<?php echo get_the_ID(); ?>">
                                            <span><?php echo $span; ?></span>
                                        </section>
                                        <div class="col share-art">
                                                
                                            <?php $shareid = ''; ?>
                                            <?php include( locate_template( 'inc/share.php', false, false )); ?>                          
                                        </div>
                                        <!-- <section class="favorite" style="margin-top: 68px;"><span>ADD</span></section> -->
                                </article>
                            </section>
                            <img src="https://kunstuitleen.nl/wp-content/themes/kunstuitleen/static/images/art-corner.svg" class="corner">
                            <?php
                            $filters = [];
                            /*$prevNextFilters = explode("&", $backToActiveFilters);
                            foreach ($prevNextFilters as $prevNextFilter):
                                $filterSplit = explode("=", $prevNextFilter);
                                $filters[$filterSplit[0]] = $filterSplit[1];
                            endforeach;*/
                            
                            $args = [
                                "post_type" =>
                                "collectie",
                                "meta_key" =>
                                "art_inkoopdat",
                                "orderby" =>
                                "menu_order meta_value",
                                "order" =>
                                "DESC",
                                "posts_per_page" =>
                                "-1",
                                "fields" =>
                                "ids",
                            ];
                            // Extra args
                            /*  if (!empty($filters["c"] )):
                                $args["s"] =  $filters["c"];
                            endif;*/
                            if (array_key_exists("kunstenaars",$filters)):
                                if (!array_key_exists("meta_query",$args)):
                                    $args["meta_query"] = ["relation" => "AND",];
                                endif;
                                $args["meta_query"] = [
                                        "key" =>"art_kunstenaar",
                                        "value" => [strstr($filters["kunstenaars"],"_", true),],
                                        "compare" => "IN" ];
                                endif;
                                $taxes = [
                                    "stijl" =>
                                    "stijlen",
                                    "orientatie" =>
                                    "orientaties",
                                    "waarde" =>
                                    "waarden",
                                    "formaat" =>
                                    "formaten",
                                    "techniek" =>
                                    "technieken",
                                ];
                                foreach ($taxes as $key => $var):
                                    if (array_key_exists($var,$filters)):
                                        if (!array_key_exists("tax_query", $args)):
                                            $args["tax_query"] = ["relation" => "AND",];
                                        endif;
                                        $args["tax_query"] = [
                                        "taxonomy" => $key,
                                        "field" =>
                                        "slug",
                                        "terms" => $var,
                                        ];
                                    endif;
                                endforeach;
                                // IF no waarden is selected, exclude waarde: r & x
                                if (empty($filters["waarden"])):
                                    if (!array_key_exists("tax_query",$args)):
                                        $args["tax_query"] = ["relation" => "AND",];
                                    endif;
                                        $args["tax_query"] = [
                                                "taxonomy" =>
                                                "waarde",
                                                "field" =>
                                                "slug",
                                                "terms" => [
                                                "r",
                                                "x",
                                                ],
                                                "operator" =>
                                                "NOT IN",
                                        ];
                                    endif;
                                    $postslist = get_posts($args);
                                    $postID = get_the_ID();
                                    $maxPosts = count($postslist) - 1;
                                    $postKey = array_search($postID, $postslist);
                                    if (!is_singular("preselect_collection")):
                                    //Added because preselection next / prev arrow is breaking the system rules
                                        if ($postKey != 0) {
                                            echo '<a href="' .get_permalink($postslist[$postKey - 1]) .'" class="art-prev art-nav"><i class="fa fa-arrow-circle-left"></i></a>';
                                        }
                                        if ($postKey !=  $maxPosts) {
                                            echo '<a href="' .get_permalink($postslist[$postKey +1]) .'" class="art-next art-nav"><i class="fa fa-arrow-circle-right"></i></a>';
                                        }
                                endif; ?>
                        </section>                           
                        <section class="row" id="biografie">
            
                            <article class="col-xs-12 col-sm-8 col-md-8 col-lg-8 column biografie">
                                <section class="row">
                                    <aside class="hidden-xs col-sm-4 col-md-4 col-lg-4 text-center"> <img src="https://www.petermaasdam.nl/kunstuitleen/artist/largerutten.jpg" alt="Ron Gessel">    
                                    </aside>

                                    <article class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                    <h2>Biography Peer Rutten</h2>

                                    <a href="http://15.236.239.91/thuis/collectie/?kunstenaars=1077266_ron-gessel" class="more-art">
                                    Meer werk van Peer Rutten bij KUNSTUITLEEN.NL
                                    </a><br>
                                    <p class="">Peer Rutten grew up in Helden and showed an early interest in depicting the surrounding world. His talent was soon noticed by those around him, resulting in countless portraits of acquaintances and friends. Although sometimes years old, these drawings have still not lost any of their clarity and authenticity.<br>
                                        Na de grafisch studie in Eindhoven, wist Peer zich binnen korte tijd als illustrator/vormgever verdienstelijk te maken bij een reclamestudio. Voor het uitvoeren van opdrachten maakt hij inmiddels dankbaar gebruik van de computer. Misschien is het daardoor, dat hij in zijn vrije tijd juist zoekt naar wegen om zijn persoonlijke, artistieke kwaliteiten uit te drukken. Misschien is het zelfs de illustrator, die overdag het vuurtje bij de kunstenaar ’s avonds stevig opstookt.<span class="bio-dots">…</span><br><a class="showfullbio" href="#more-bio">Lees meer</a><p class="bio-more">
                                        De “No-serie, welke bij toeval is ontstaan, na een tekening met als titel”; “No-body”. In deze serie zijn letters en cijfers een belangrijk onderdeel van het kunstwerk. De letters die erin verwerkt zijn, komen uit de collectie van gebruikte letters en cijfers, die hij de afgelopen jaren digitaal heeft vastgelegd. De voorwaarden, waar deze letters en cijfers aan moeten voldoen, is dat ze “de tand des tijds” hebben doorstaan. Ze liggen vaak gewoon op straat. Alleen de meeste mensen zien ze niet en lopen er gewoon aan voorbij. In deze serie krijgen ze een nieuwe identiteit en vaak zelfs de hoofdrol (titel van het werk). De basis van de “No Serie” komt voornamelijk uit de serie “Terras”, met een toevoeging van deze letters.</p>
                                    </article>
                                </section>
                            </article>
                            <aside class="hidden-xs col-sm-4 col-md-4 col-lg-4">
                                <div id="voordelen" class="single-product-voordelen">
                                    <div class="voordelen-thuis text-left">
                                        <h2>THE ADVANTAGES OF KUNSTUITLENEN.NL</h2> 
                                        <p><i class="fa fa-thumbs-up icon-size"></i><span class="">Alles goed geregeld</span></p>
                                        <p><i class="fa fa-comments icon-size"></i><span class="">Deskundig en prersoonlijk advies</span></p>
                                        <p><i class="fa fa-plus icon-size"></i><span class="">Ruim 30,000 kunstwerken</span></p>
                                        <p><i class="fa fa-shopping-cart icon-size"></i><span class="">Gratis proefplaasting</span></p>
                                        <p><i class="fa fa-random icon-size"></i><span class="">Flexibiliteit</span></p>
                                        <p><i class="fa fa-unlock icon-size"></i><span class="">Betaalbaar</span></p>
                                    </div>
                                    <img src="https://kunstuitleen.nl/wp-content/themes/kunstuitleen/static/images/voordelen-thuis-bottom.svg">
                                </div>                
                            </aside>
                        </section>                          
                    </div>
                </div> 
            </div>  
            <div class="modal fade modal-dialog-center" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" style="height:100%; width:80%;">
                    <div class="modal-content" style="margin-left: 80px;">
                        <div class="modal-header" style="margin-top: 5px;">
                        </div>
                        <div class="modal-body" style="text-align: center;padding: 10px !important;">
                        <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" /> 
                        </div>
                        <div class="modal-footer" style="margin-bottom: 10px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
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
