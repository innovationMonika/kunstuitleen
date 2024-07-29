<?php
    /*
        Template name: Hoe werkt het?
    */
    get_header();
    $cookieWebVariant = get_web_variant(); 
    
    $include_post_id = get_the_ID();
?>
    
    
    <section class="container relative page-content-container">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
    </section>
    
    <?php include( locate_template( 'inc/hoe-werkt-het.php', false, false ) ); ?>
    

<?php get_footer(); ?>
