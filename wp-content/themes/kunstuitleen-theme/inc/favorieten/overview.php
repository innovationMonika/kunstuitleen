<h3 class="mrjonesbook">De door jou geselecteerde kunstwerken:</h3>

<?php 
$cookieWebVariant = get_web_variant();
if( !empty($favorieten) ) { ?>  
    
    <section class="row">
    <?php 
        $post_type = ( !empty($preselect_client) ? 'preselect_collection' : 'collectie' );
        $the_query = new WP_Query( 
            array(
                'post_type' => $post_type, 
                'orderby' => 'date', 
                'post__in' => $favorieten,
                'order' => 'DESC', 
                'posts_per_page' => '-1'
            ) 
        ); 
	foreach ($favorieten as $a => $b) {
		// echo "<pre>";
		// print_r($a);
		// echo "</pre>";
	}
	
    ?>
    <?php
		$count = 0;
		if ( $the_query->have_posts() ) {
			$inventoryArr = array();	
		while ( $the_query->have_posts() ) {
			
		$the_query->the_post();
		array_push($inventoryArr, get_field('art_inventnr'));
		?>
        <article class="col-xs-12 col-md-4" name="<?php the_field('art_inventnr'); ?>" id="fav_post">
            
            <?php $aimage = get_field('art_image'); ?>
			
			<?php if($count < 3):?>
				       <?php if( !empty($aimage)) { ?>
		<!--           <a href="<?php the_permalink(); ?>" class="art-favorite-thumb" style="background-image: url(<?php echo $aimage; ?>);">  -->
					   <a class="art-favorite-thumb" style="background-image: url(<?php echo $aimage; ?>);"> 
								<!-- <section class="favorite<?php if (in_array(get_the_ID() , $favorieten))
									{
										echo ' active';
									} ?><?php if (!empty($preselect_client)):
									echo ' preselect-favorite';
									endif; ?>" id="<?php echo get_the_ID(); ?>">


								</section> -->
						</a>	
			           <?php } ?>
            <?php endif; ?>

        </article>
    <?php  $count++; }
	if ($cookieWebVariant == 'thuis') {
		$webVariant = 'home';
	} else {
		$webVariant = 'work';
	}
		?><input type="hidden" id="pageType" value="<?php echo $webVariant; ?>" />
		<input type="hidden" id="inventoryArr" value="<?php echo implode(',',$inventoryArr); ?>" />
		

	<?php /* endwhile */ } /* endif */ wp_reset_postdata(); /* Restore original Post Data */ ?>
    
</section> 
                            
<?php } else { ?>             
     <p>Je hebt nog geen favorieten.</p>
<?php } ?>