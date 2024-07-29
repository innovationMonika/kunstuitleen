
<?php if(!$cols){ $cols = 'col-xs-12 col-sm-4 col-md-3 col-lg-3'; } ?>
<article class="<?php echo $cols; ?> kunstenaar" id="<?php echo basename(get_permalink()); ?>">
    
    <?php $artArgs = array(
        'post_type'  => 'collectie',
        'orderby'    => 'rand',
        'showposts' => 3,
        'meta_query' => array(
    		array(
    			'key'     => 'art_kunstenaar',
    			'value'   => array(get_the_ID()),
    			'compare' => 'IN',
    		),
    	)
    );
    
    $getArt = get_posts($artArgs); ?>
    
    <section class="kunstenaar-content text-center">
        <?php if( get_the_title() == '' ): $kunstenaarNaam = 'Geen naam'; else: $kunstenaarNaam = get_the_title(); endif; ?>
        <h2><a href="<?php the_permalink(); ?>"><?php echo $kunstenaarNaam; ?></a></h2>
        
        <?php $kimage = get_field('kunstenaar_foto'); ?>
        <?php if($kimage ){ ?>
            <?php if( $kimage == 'https://www.petermaasdam.nl/kunstuitleen/images/largenofile.jpg'): $kimage = get_field('art_image', $getArt[0]->ID); endif; ?>
            <a href="<?php the_permalink(); ?>" class="kunstenaar-foto" style="background-image: url('<?php echo $kimage; ?>');">
                <img src="<?php bloginfo('template_url'); ?>/static/images/kunstenaar-spacer.png" />
            </a>
        <?php } ?>
        
        <?php unset($getArt[0]); // Remove first item from array, because i'ts probably used for the author photo ?>
        <?php if( $getArt ): ?>
            <section class="kunstenaar-art-container">
                <section class="row">
                    <?php foreach( $getArt as $art ): ?>
                        <section class="col-xs-6 kunstenaar-art">
                            
                            <?php $aimage = get_field('art_image', $art->ID); ?>
                            <?php if($aimage){ ?>
                                <a title="<?php echo $art->post_title; ?>" class="kunstenaar-art-image" href="<?php the_permalink($art->ID); ?>" style="background-image: url('<?php echo $aimage; ?>');">
                                    <img src="<?php bloginfo('template_url'); ?>/static/images/art-spacer.png" />
                                </a>
                            <?php } ?>
                            
                        </section>
                    <?php endforeach; ?>
                </section>
            </section>
        <?php endif; ?>
        
        <a href="<?php the_permalink(); ?>" class="kunstenaar-link">Overzicht van <?php echo $kunstenaarNaam; ?></a>
        
        <img src="<?php bloginfo('template_url'); ?>/static/images/art-corner.svg" class="corner" />
    </section>
</article>