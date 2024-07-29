<?php 
    get_header();
    $cookieWebVariant = get_web_variant(); 
?>
    
    <section class="container relative">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 column page-content">
                
                <h1>Pagina niet gevonden</h1>
                
                <p>De pagina die je probeert te bereiken kan niet worden gevonden. Probeer het opnieuw of gebruik het hoofdmenu.</p>
           
            </article>
            		
		</section>
    </section>

<?php get_footer(); ?>
