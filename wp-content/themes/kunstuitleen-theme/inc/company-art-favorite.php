<?php
/**
 * Company Favorite  
 */
$favorieten = get_favorieten();
$company_id = get_current_user_id();    
$users = kucrm_get_users_by_company($company_id);
?>
<section class="favorite_group_section" id="favorite_group_data">
  	<div class="container-fluid">
	    <div class="row">
	        <div class="col-lg-3 col-md-4 col-sm-5">
	     		<div class="favorite_left">
	        		<div class="favorite_left_box">
	           			<div class="favorite_left_title">
	              			<h4><?php echo esc_html__( 'De door jou voorgeselecteerde kunstwerken voor jouw bedrijf:', 'kunstuitleen-theme' ); ?></h4> 
	              		</div>
	              	</div>
	              	<div class="favorite_gallery">
	              		<?php
	              			if( $the_query->have_posts() ) :
	              			    $i = 0;	
								while ( $the_query->have_posts() ) : 
									    $the_query->the_post();
									    $favorieten = $aimage = $monthly_price = $inventory_number = $purchase_date = $image_size = $list_size = $price = $art_kunstenaar_name = $technique = $consignment = '';
									    $favorieten = get_favorieten();
									    $inventory_number = get_field('inventory_number');
									    $shelf_number = get_field('art_schap');
									    $purchase_date = get_field('art_inkoopdat');
									    $image_size = get_field('art_afmeting');
									    $list_size = get_field('art_lijstafmeting');
									    $price = get_field('art_prijs');
									    $art_kunstenaar_name = get_field('art_kunstenaar_name');
									    $aimage = get_field('art_image');
									    $technique = get_field('art_techniek_full');
									    $monthly_price = get_field('art_maandprijs');
									    $consignment = get_field('art_consignatie');
									    $data = array(
									    	    'post_id' => get_the_ID(),
									    	    'post_title' => get_the_title(),
									    		'inventory_number' => $inventory_number,
									    		'shelf_number' => $shelf_number,
									    		'purchase_date' => $purchase_date,
									    		'image_size' => $image_size,
									    		'list_size' => $list_size,
									    		'price' => $price,
									    		'art_kunstenaar_name' => $art_kunstenaar_name,
									    		'aimage' => $aimage,
									    		'technique' => $technique,
									    		'monthly_price' => $monthly_price,
									    		'consignment' => $consignment,
									    		'delete_img_url' => esc_url( KUNSTUITLEEN_PATH . '/static/images/del1.svg'),
									    		'delete_img_text' => esc_html__( 'VERWIJDER LOCATIE', 'kunstuitleen-theme' ),
									            );
									    if( $i == 0 ) :
									    	$class = 'favorite active';
									    else :
									    	$class = 'favorite';
									    endif;
						?>
										<div class="favorite_img" draggable="true" ondragstart="drag(event)" id="feature-img-drag-<?php echo esc_attr(get_the_ID()); ?>" data-wrapper_image_meta="<?php echo esc_attr( json_encode( $data)); ?>">
				                          <img src="<?php echo esc_url( $aimage ); ?>" data-image_meta="<?php echo esc_attr( json_encode( $data)); ?>">
				                          <div  class="<?php echo esc_attr( $class ); ?>"></div>
				                        </div>
						<?php   
						        $i++;
							    endwhile;
							    wp_reset_postdata();
							endif; 
	              		?>	              		
	              	</div>
	              	<div class="delete_all">
	           			<a href="#"><?php echo  esc_html__( 'VERWIJDER ALLE', 'kunstuitleen-theme' ); ?></a>
	        		</div>       
	     		</div>
	  		</div>
	  		<div class="col-lg-9 col-md-8 col-sm-7">
			  <div class="favorite_right">
			     <div class="row flex header_right">
			        <div class="col-md-7">
			           <div class="login">
			              <input type="text" class="form-control search" placeholder="Geef deze selectie een naam">
			              <span><?php echo esc_html('Totaal per maand € 00,00'); ?></span>
			           </div>
			        </div>
			        <div class="col-md-3 align-self-center ml-auto">
			           <a  hre="#" class="btn btn-default search-btn"><span><i class="fa fa-share-alt"></i></span><span><?php echo esc_html('Deel met collega\'s'); ?></span> </a>
			        </div>
			     </div>
			     <div class="row">
			       <div class="col-md-7">
			            <div class="login plus">
			              <a href="javascript:;" class="plus_link" id="company-art-favroite-cart-show"><span><img src="<?php echo esc_url( KUNSTUITLEEN_PATH . '/static/images/plus2.svg'); ?>"></span> <span><?php echo esc_html('Nieuwe locatie'); ?></span></a>
			            </div>
			       </div>  
			     </div>
			     <div class="custom_box w-75 company-art-favroite-cart company-art-favroite-display-none" id="company-art-favroite-cart">
			        <div class="row content d-lg-flex my-details">
			           <div class="col-md-3 img-view">
			              <div class="favorite_img favorite_img_right" ondrop="drop(event)" ondragover="allowDrop(event)" id="favorite-img-drop" style="border:1px solid #dad4d4;height:200px;">
			              </div>
			           </div>
			           <div class="col-md-4 border">
			              <div class="favorite_details" id="favorite-details">	
			              	 <div class="favorite_details_title text-center">
			                    <strong class="h4 mr-jonas"><?php echo esc_html('Title inventory'); ?></strong>
			                 </div>
			                 <div class="favorite_details_content">
			                    <p><?php echo esc_html('Name artist'); ?></p>
			                    <p><?php echo esc_html('000 X 000'); ?></p>
			                    <p><?php echo esc_html('E00,00 PER MAAND'); ?></p>
			                 </div>
			                 <div class="delet_btn">
			                    <span><img src="<?php echo esc_url( KUNSTUITLEEN_PATH . '/static/images/del1.svg'); ?>"></span>
			                    <a href="#"><?php echo esc_html('VERWIJDER LOCATIE'); ?></a>
			                 </div>		                 
			              </div>
			           </div>
			           <div class="col-md-5">
			              <div class="login_box">
			                 <div class="button">
			                    <div class="login login_input d-block">
			                       <select id="fav_option" class="plus_link">
			                       	    <?php 
			                       	   		if( !empty( $users ) ) :
			                       	   	?>
			                       	   			<option value=""><?php echo esc_html__( 'Select Employee', 'kunstuitleen-theme' ); ?></option>
			                       	   	<?php
			                       	   			foreach( $users as $users_key => $users_val ) : 
                                        ?>
                                        			<option value="<?php echo esc_html( $users_val['id'] ); ?>"><?php echo esc_html( $users_val['full_name'] ); ?></option>
                                        <?php
			                       	   			endforeach;
			                       	   		endif;
			                       	   	?>
			                       </select>
			                    </div>
			                 </div>
			                 <div class="button">
			                    <div class="login plus text-center">
			                       <a href="#" class="plus_link"><span><img src="<?php echo esc_url( KUNSTUITLEEN_PATH . '/static/images/arrow2.svg'); ?>"></span> <span><?php echo esc_html('voeg meer info toe'); ?></span></a>
			                    </div>
			                 </div>
			                 <div class="button">
			                    <div class="login plus" id="company-employee">
			                       <a href="javascript:;" class="plus_link" id="company-add-employee"><span><img src="<?php echo esc_url( KUNSTUITLEEN_PATH . '/static/images/plus2.svg'); ?>"></span> <span><?php echo esc_html('nog een alternatief kiezen'); ?></span></a>
			                    </div>
			                    <!--<div class="login plus" id="company-employee">
			                       	<a href="javascript:;" class="plus_link" id="company-add-employee">
			                       		<span><img src="<?php echo esc_url( KUNSTUITLEEN_PATH . '/static/images/plus2.svg'); ?>"></span> <span><?php echo esc_html('nog een alternatief kiezen'); ?></span>
			                        </a>
			                    </div>-->
			                 </div>
			              </div>
			           </div>
			        </div>
			     </div>
			     <!--<div class="custom_box custom_box1">
			        <div class="row content d-lg-flex my-details">
			           <div class="col-md-3 img-view">
			              <div class="favorite_img favorite_img_right">
			                 <img class="img-responsive" src="<?php echo esc_url( KUNSTUITLEEN_PATH . '/static/images/img2.jpg'); ?>">
			                 <div class="favorite"></div>
			                 <span><?php echo esc_html('VERWIJDER KUNST'); ?></span>
			              </div>
			           </div>
			           <div class="col-md-3 border">
			              <div class="favorite_details">
			                 <div class="favorite_details_title text-center">
			                    <strong class="h4 mr-jonas"><?php echo esc_html('Title inventory'); ?></strong>
			                 </div>
			                 <div class="favorite_details_content">
			                    <p><?php echo esc_html('Name artist'); ?></p>
			                    <p><?php echo esc_html('000 X 000'); ?></p>
			                    <p><?php echo esc_html('E00,00 PER MAAND'); ?></p>
			                 </div>
			                 <div class="delet_btn">
			                    <span><img src="<?php echo esc_url( KUNSTUITLEEN_PATH . '/static/images/del1.svg'); ?>"></span>
			                    <a href="#"><?php echo esc_html('VERWIJDER LOCATIE'); ?></a>
			                 </div>
			              </div>
			           </div>
			           <div class="col-md-3">
			              <div class="login_box">
			                 <div class="button">
			                    <div class="login login_input d-block">
			                       <input type="text" class="plus_link" placeholder="Edgar Kiwiet (alternatief)">
			                    </div>
			                 </div>
			                 <div class="button">
			                    <div class="login login_input d-block">
			                       <input type="text" class="plus_link" placeholder="Etage 1">
			                    </div>
			                 </div>
			                 <div class="button">
			                   <div class="login login_input d-block">
			                       <input type="text" class="plus_link" placeholder="Kamer 2">
			                    </div>
			                 </div>
			              </div>
			           </div>
			           <div class="col-md-3">
			              <div class="login_box">
			                 <div class="button">
			                    <div class="login login_input d-block">
			                       <input type="text" class="plus_link" placeholder="Linkerwand">
			                    </div>
			                 </div>
			                 <div class="button">
			                    <div class="login plus">
			                       <a href="#" class="plus_link"><span><?php echo esc_html('Hoohg ophangen'); ?></span></a>
			                    </div>
			                 </div>
			                 <div class="button">
			                    <div class="login plus text-center">
			                       <a href="#" class="plus_link roted"><span><img src="<?php echo esc_url( KUNSTUITLEEN_PATH . '/static/images/arrow2.svg'); ?>"></span> <span><?php echo esc_html('Verberg meer info'); ?></span></a>
			                    </div>
			                 </div>
			              </div>
			           </div>
			        </div>
			     </div>-->
			  </div>
			</div>
	  	</div>
  	</div>
</section>