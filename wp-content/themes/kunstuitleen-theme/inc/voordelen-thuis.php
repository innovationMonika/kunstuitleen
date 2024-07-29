<div id="voordelen"<?php if( $singleProduct == true ): echo ' class="single-product-voordelen"'; endif; ?>>
    <?php if( $singleProduct != true ): ?>
        <img src="<?php bloginfo('template_url'); ?>/static/images/voordelen-thuis-top.svg" class="top-img" />
    <?php endif; ?>
    
    <div class="voordelen-thuis text-left">
        <?php include( locate_template( 'inc/voordelen-list-thuis.php', false, false ) ); ?>
    </div>
    
    <img src="<?php bloginfo('template_url'); ?>/static/images/voordelen-thuis-bottom.svg"  />
</div>