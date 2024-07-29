<h3 class="mrjonesbook">De door jou geselecteerde kunstwerken:</h3>

<?php if( !empty($favorieten) ) { ?>  
    
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
    ?>
    <?php if ( $the_query->have_posts() ) {	while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
        <article class="col-xs-12 col-md-4">
            
            <?php $aimage = get_field('art_image'); ?>
            <?php if( !empty($aimage)) { ?>
                <a href="<?php the_permalink(); ?>" class="art-favorite-thumb" style="background-image: url(<?php echo $aimage; ?>);"></a>
            <?php } ?>
            
        </article>
    <?php  } /* endwhile */ } /* endif */ wp_reset_postdata(); /* Restore original Post Data */ ?>
    
</section> 
                            
<?php } else { ?>             
     <p>Je hebt nog geen favorieten.</p>
<?php } ?>