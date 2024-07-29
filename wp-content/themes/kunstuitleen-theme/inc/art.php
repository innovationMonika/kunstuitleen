<?php 
    $favorieten = get_favorieten(); 
    if(!$cols){ $cols = 'col-xs-12 col-sm-4 col-md-3 col-lg-3'; }
?>
<article class="<?php echo $cols; ?> art" id="<?php the_field('art_inventnr'); ?>">

    <section class="art-content text-center">
        
        <?php $aimage = get_field('art_image'); ?>
        <?php if($aimage){ ?>
            <a href="<?php the_permalink(); ?>"><img src="<?php echo $aimage; ?>" alt="<?php the_title(); ?>" /></a>
        <?php } ?>
        
        <?php if ( !empty($favorieten) && in_array( get_the_ID(), $favorieten )) { $span = 'VERWIJDER';  } else { $span = 'VOEG TOE'; } ?>
        <section class="favorite<?php if (in_array( get_the_ID(), $favorieten )) { echo ' active'; } ?>" id="<?php echo get_the_ID(); ?>"><span><?php echo $span; ?></span></section>
         
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <h3 class="kunstenaar"><?php the_field('art_kunstenaar_name'); ?></h3>
        
        <p>
            <?php the_field('art_lijstafmeting'); ?><br/>
        
            <?php if( $cookieWebVariant == 'thuis' ): ?>
                <span class="maandbedrag">&euro; <?php the_field('art_maandprijs'); ?> per maand</span><br/>
                <small><em>(waarvan 50% spaartegoed)</em></small>
            <?php else: ?>
                <?php $waarde = get_the_terms( $post->ID, 'waarde' ); ?>
                Categorie <?php echo strtoupper($waarde[0]->slug);  ?>
                <br/>
                <span class="inventnr">
                    #<?php echo get_field('art_inventnr') . ( !empty(get_field('art_schap')) ? ' / ' . get_field('art_schap') : ''); ?>
                </span>
            <?php endif; ?>
        </p>
        
        <img src="<?php bloginfo('template_url'); ?>/static/images/art-corner.svg" class="corner" />
    </section>
</article>