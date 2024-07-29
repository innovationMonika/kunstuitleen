<?php
   /*
       Template name: Collectie (overzicht)
   */    
  get_header(); 
       
  // Vars
  $cookieWebVariant = get_web_variant(); 
  $favorieten = get_favorieten();
  
  // Query-args
  $args = array(
      'post_type'         => 'collectie', 
      'post_status'       => 'publish',   
      'meta_key'          => 'art_inkoopdat', 
      'orderby'           => 'menu_order meta_value',
      'order'             => 'DESC', 
      'posts_per_page'    =>  16         
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

    if( isset($_GET['min_maandbedrag']) ||  isset($_GET['max_maandbedrag']) && ( $_GET['min_maandbedrag'] || $_GET['max_maandbedrag']) ):
      
      if( !array_key_exists('meta_query', $args) ): $args['meta_query'] = array('relation' => 'AND'); endif;
      
     $args['meta_query']    =  array(
        'key'       => 'art_prijs',
        'value'     => array( $_GET['min_maandbedrag'], $_GET['max_maandbedrag'] ),
        'compare'   => 'BETWEEN',
        'type'      => 'NUMERIC',
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

 $ajax_last_loaded_page = get_cookie_value('ajax_last_loaded_page'); // prev: collectieCurrentPage        
 $currentPage = 1;     
 $the_query  = new WP_Query($args);
 $totalFound = $the_query->found_posts;
 $maxPages   = $the_query->max_num_pages; 

 if( !empty($ajax_last_loaded_page) && !empty( safe_get('backto') ) ){  
      $currentPage = $ajax_last_loaded_page;
      $args['posts_per_page'] = $args['posts_per_page'] * $ajax_last_loaded_page;
      // the Query
      $the_query  = new WP_Query($args);
      $maxPages   = $the_query->max_num_pages;
      $totalFound = $the_query->found_posts;
 }       
   ?>
   <script>
      var maxPages = <?php echo $maxPages; ?>;
      var currentPage = <?php echo $currentPage + 1; // + 1 for next page ?>;           
   </script>
<main class="flex-shrink-0 kunstenaars-font">   
   <div class="collection_favorites">
      <div class="container mt-4">
         <div class="row">
            <section class="container col-xs-12 col-sm-12 col-md-12 col-lg-12">
               <div class="tabbable-panel">
                  <div class="tabbable-line">
                     <ul class="nav nav-tabs nav-justified">
                        <li class="active"><a data-target="#tab1default" data-toggle="tab" onclick="favorite_collectie()"><label class="collection-heading h4 text-uppercase mr-jonas"><strong><?php echo esc_html__( 'Verzameling', 'kunstuitleen-theme' ); ?></strong></label></a></li>
                        <li id="drag_drop" ondrop="drop(event)" ondragover="allowDrop(event)"><a data-target="#tab2default" data-toggle="tab"><label id="div1" class="collection-heading h4 text-uppercase" onclick="favrate_collectie(this)"><strong><?php echo esc_html__( 'Mijn favorieten', 'kunstuitleen-theme' ); ?> (<span class="favorite-selection-count">0</span>)</strong></label></a></li>
                     </ul>
                  </div>
               </div>
            </section>
         </div>
      </div>
   </div>
   <?php include( locate_template( 'inc/favorieten/bevestig-eindselectie.php', false, false ) ); ?>
   <div class="container-fluid">
      <div class="row mt-5">
         <section class="container-fluid kunstenaars-page-collectie">
            <div class="tab-content">
               <div class="tab-pane fade in active" id="tab1default">               	   
                  <div class="row mt-4">
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                           <div class="col-xs-12 col-sm-5 col-lg-5 col-md-5">	
                              <label class="h4 mr-jonas"><strong style="padding-right: 4px;">Collectie voor jou</strong>
                              <span class="badge bg-info" style="background-color: #428bca;width:25px;height:25px;line-height:25px; ">
                              <?php echo $totalFound; ?></span></label>
                           </div>
                           <div class="col-sm-7 col-lg-7 col-md-7 text-center" id="filtersSearch"">
                              <div class="filter-search">
                                 <?php $searched = safe_get('c'); ?>
                                 <input type="text" name="c" id="c" value="<?php echo $searched; ?>" placeholder="Titel, nummer, etc..." />
                                 <ul class="custom-autocomplete"></ul>
                                 <img src="<?php bloginfo('template_url');?>/static/images/filter-search.svg" alt="Zoeken >" class="filter-submit" />
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div clas="row">
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row collection">
                           <div class="col-lg-2 col-md-3 collection_grid_tablet">
                              <section id="filters" class="">
                                 <form action="<?php echo get_permalink( get_the_ID() ); ?>" id="filter" method="get">
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
                                    <div class="row">
                                       <label class="h4 col-md-12 filter"><h3>Kunstenaars</h3></label>
                                       <div class="col-md-12">
                                          <select name="kunstenaars" class="form-control filter-input">
                                             <option value="" class="form-control filter-input">Alle kunstenaars</option>                                             
                                             <?php foreach ( $kunstenaars as $kunstenaar ) : if( $kunstenaar->post_name ): ?>
                                             <?php $optionVal = $kunstenaar->ID.'_'.$kunstenaar->post_name; ?>
                                             <?php if( $optionVal == safe_get('kunstenaars') ): ?>
                                             <option value="<?php echo $optionVal; ?>" selected="selected"><?php echo $kunstenaar->post_title; ?></option>
                                             <?php else: ?>
                                             <option value="<?php echo $optionVal; ?>"><?php echo $kunstenaar->post_title; ?></option>
                                             <?php endif; ?>
                                             <?php endif; endforeach; ?>
                                          </select>
                                       </div>
                                    </div>                            
                                    <div class="row">
                                       <label class="h4 col-md-12 filter"><h3><?php echo esc_html__( 'Techniek', 'kunstuitleen-theme' ); ?></h3></label>
                                       <div class="col-md-12">
                                          <?php createFilter('technieken', 'techniek', array(28)); ?>
                                       </div>
                                    </div>                                    
                                    <div class="row">
                                       <?php if( $cookieWebVariant === 'werk' ): ?>
                                       <label class="h4 col-md-12 filter"><h3><?php echo esc_html__( 'Waarde', 'kunstuitleen-theme' ); ?></h3></label>
                                       <?php else: ?>
                                       <label class="h4 col-md-12 filter"><h3><?php echo esc_html__( 'Maandbedrag', 'kunstuitleen-theme' );?></h3></label>
                                       <?php endif; ?>
                                       <div class="col-md-12">
                                          <?php if( $cookieWebVariant === 'werk' ): ?>
                                          <!-- <h3 class="nomargin">Waarde:</h3> -->
                                          <?php createFilter('waarden', 'waarde'); ?>
                                          <?php else: ?>
                                          <?php //createFilter('maandbedragen', 'maandbedrag'); 
                                             $min_max_array = array();
                                                // Query-args
                                                $maanargs = array(
                                                      'post_type'         => 'collectie', 
                                                      'post_status'       => 'publish',   
                                                      'meta_key'          => 'art_inkoopdat', 
                                                      'orderby'           => 'menu_order meta_value',
                                                      'order'             => 'DESC', 
                                                      'posts_per_page'    =>  12         
                                                );
                                                $maanargs_query  = new WP_Query($maanargs);
                                            if ( $maanargs_query->have_posts() ) { 
                                                while ( $maanargs_query->have_posts() ) { 
                                                   $maanargs_query->the_post();                                           
                                                   $min_max_array[] = get_field('art_prijs', $post->ID);
                                                }
                                             }                                              
                                             if( isset($_GET['min_maandbedrag']) && $_GET['min_maandbedrag'] && !empty($_GET['min_maandbedrag']) ){
                                                $min = $_GET['min_maandbedrag'];
                                             }else {
                                                $min = min($min_max_array);
                                             }
                                             if( isset($_GET['max_maandbedrag']) && $_GET['max_maandbedrag'] && !empty($_GET['max_maandbedrag']) ){
                                                $max = $_GET['max_maandbedrag'];
                                             }else{
                                                $max = max($min_max_array);
                                             }
                                          
                                          ?>
                                          <div class="row">
                                                <div class="col-md-12"> 
                                                   <input type="number" name="min_maandbedrag" class="form-control filter-input" placeholder="€ min"  style="padding-bottom: 5px;" value="<?php echo $min; ?>" min="<?php echo $min; ?>" ></div>
                                                <div class="col-md-12"> 
                                                   <input type="number" name="max_maandbedrag" class="form-control filter-input" placeholder="€ max" value="<?php echo $max; ?>" max="5<?php echo $max; ?>"></div>
                                                 </div>
                                          <?php endif;  ?>
                                       </div>
                                    </div>                                   
                                    <div class="row">
                                       <label class="h4 col-md-12 filter"><h3><?php echo esc_html__( 'Stijl', 'kunstuitleen-theme');?></h3></label>
                                       <div class="col-md-12">
                                          <?php createFilter('stijlen', 'stijl'); ?>
                                       </div>
                                    </div>                                    
                                    <div class="row filter">
                                       <label class="h4 col-md-12"><h3><?php echo esc_html__( 'Orientatie', 'kunstuitleen-theme' ); ?></h3></label>
                                       <div class="col-md-12">
                                          <?php createFilter('orientaties', 'orientatie'); ?>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <label class="h4 col-md-12 filter"><h3><?php echo esc_html__( 'Formaat', 'kunstuitleen-theme'); ?></h3></label>
                                       <div class="col-md-12">
                                          <?php createFilter('formaten', 'formaat'); ?>
                                       </div>
                                    </div> 
                                 </form>
                              </section>
                           </div>
                           <div class="col-lg-1 d-lg-block d-none" style="width: 3%;"></div>
                           <section class="container-fluid ajaxloading collection_grid_tablet_group" id="collectie">
                           <div class="kunstenaars-mt-4 mt-4">

                              <section class="row collectie grid kunstenaars-grid" >                                
                                 <?php if ( $the_query->have_posts() ) { while ( $the_query->have_posts() ) { $the_query->the_post();  ?>
                                 <?php include( locate_template( 'inc/collectie-art-favorite.php', false, false )); ?>
                                 <?php  } /* endwhile */ } /* endif */ wp_reset_postdata(); /* Restore original Post Data */ ?>
                                 <?php include( locate_template( 'inc/art-ad.php', false, false )); ?>
                                 
                              </section>
                           <aside class="loading text-center clear">
                              <img src="<?php bloginfo('template_url'); ?>/static/images/arrow-rotatie.gif" alt="Bezig met laden" />
                           </aside>
                           <aside class="end-message text-center<?php echo ($totalFound == 0 ? ' show' : ''); ?>">
                              Er zijn geen kunstwerken (meer) gevonden die aan uw zoekcriteria voldoen. Probeer het gerust opnieuw door uw zoekopdracht aan te passen.
                           </aside>
                           </div>
                            </section>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade in" id="tab2default">
                  <section class="container relative page-content-container">
                     <section class="container relative page-content-container favrate_collectie"  id="collectie">
                        <section class="row" id="favrate_collectie">
                           <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column favorieten-overzicht">
                              <?php
                                 //$selectedArt = get_cookie_value('selectedArt'); 
                                 if($favorieten){
                                 $the_query = new WP_Query( 
                                                            array(
                                                              'post_type' => 'collectie', 
                                                              'orderby' => 'date', 
                                                              'post__in' => $favorieten,
                                                              'order' => 'DESC', 
                                                              'posts_per_page' => '-1'
                                                            ) 
                                                         );
                                 if ( $the_query->have_posts() ) { 
                                     while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
                              <?php $cols = 'col-xs-12 col-sm-4 col-md-15 col-lg-15'; ?>
                              <?php include( locate_template( 'inc/art-favorite.php', false, false )); ?>
                              <?php  } /* endwhile */ 
                                 }/* endif */
                                  wp_reset_postdata(); /* Restore original Post Data */
                                 }
                                   ?>
                              <!-- </section> -->
                           </article>
                        </section>
                     </section>
                  </section>
               </div>
            </div>
         </section>
      </div>
   </div>
</main>
<script>
   function allowDrop(ev) {
     ev.preventDefault();
   }
   function drag(ev) {
      ev.dataTransfer.setData("text", ev.target.id);    
   }
   function drop(ev) {
      ev.preventDefault();
      var data = ev.dataTransfer.getData("text");
      var favorite_id = jQuery('#'+data+' > section').find('.favorite').attr('id');
         if (jQuery('#'+favorite_id).text() != 'VERWIJDER') {
               jQuery('#'+favorite_id).attr('data_drag',"1");
               jQuery('#'+favorite_id).trigger('click');
               jQuery('#'+favorite_id).html('<span>VERWIJDER</span>');
         } 
   }
   jQuery(document).ready(function(){
       jQuery('.favorite').click(function(){
           console.log(jQuery(this).text());
           if(jQuery(this).text() == 'DELETE'){
               jQuery(this).removeClass('active');
               jQuery(this).html('<span>ADD</span>');
           } else{
               jQuery(this).addClass('active');
               jQuery(this).html('<span>DELETE</span>');
           }
       });
   });

    
</script>