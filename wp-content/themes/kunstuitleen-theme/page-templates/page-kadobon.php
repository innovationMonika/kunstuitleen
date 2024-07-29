<?php 
    /*
        Template name: Kadobon
    */
    get_header(); 
    $cookieWebVariant   = get_web_variant();
    $landingspage       = is_landingspage();
    
    $form_id            = get_field('kadobon_form_id');
    $ideal_image        = get_field('ideal_image');
?>
    
    <section class="container relative page-content-container">
        <?php if ( function_exists('yoast_breadcrumb') && $landingspage == false ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        
        <section class="row">
            <article class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-2 col-lg-offset-2 column page-content">
                
                
                	
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                <?php endwhile; endif; ?>
                
            </article>
            		
		</section>
    </section>
    
    <div class="content-container no-margin-top">
        <div class="container">
            <div class="row d-lg-flex">
                
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 d-lg-flex">
                    <div class="form kadobon">
                        
                        <div class="kadobon-top-container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 kadobon-logo-container hidden-xs">
                                    <img src="<?php bloginfo('template_url');?>/static/images/kunstuitleen.svg" alt="<?php bloginfo('name'); ?>" />
                                </div>
                                <div class="col-xs-12 col-sm-9 kadobon-slogan-container">
                                    Serving the art of inspiration 
                                </div>
                            </div>
                        </div>
                        
                        <div class="kadobon-form-container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-7">
                                    <?php echo FrmFormsController::show_form($form_id, $key = '', $title=false, $description=false); ?>
                                    
                                    <div class="kadobon-gift-data">
                                        <div class="gift-meta">
                                            <span>Geldig t/m <?php echo date_i18n('j F Y', strtotime('+1 year')); ?></span><br/>
                                            <em>Bonnummer:</em> XXXXX
                                        </div>
                                        <div class="gift-contact">
                                            Wij zijn gevestigd in Amsterdam Art Center<br/>Donauweg 23 - 1043 AJ Amsterdam
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-5 hidden-xs hidden-sm">
                                    <img src="<?php bloginfo('template_url'); ?>/static/images/pdf/pdf-foto-pand.png" class="kadobon-image" />
                                </div>
                            </div>
                            
                            <img src="<?php bloginfo('template_url'); ?>/static/images/pdf/pdf-kadobon-price-bg-<?= $cookieWebVariant ?>.png" class="kadobon-corner-bg" />
                            <img src="<?php bloginfo('template_url'); ?>/static/images/pdf/web-kadobon-price-<?= $cookieWebVariant ?>.svg"  class="kadobon-corner-price" />
                        </div>

                    </div>
                </div>
                <div class="col-xs-8 col-sm-6 col-md-4 col-lg-3 col-xs-offset-2 col-sm-offset-3 col-md-offset-4 col-lg-offset-0 d-lg-flex align-items-center">
                    <?php if( !empty($ideal_image) ): ?>
                        <img src="<?php echo $ideal_image['sizes']['responsive']; ?>" />
                    <?php endif; ?>
                </div>
                
            </div>
        </div>
    </div> 
    <div class="content-container">
        <div class="container">
            <div class="col-12 referentie werk-referentie">
    			<div class="row">
    				<div class="col-xs-8 col-xs-offset-2 text-center werk testimonial title">
    					<h2>Wat klanten van ons zeggen</h2>
    				</div>	
    			</div>	
                <?php include( locate_template( 'inc/referentie-2cols.php', false, false )); ?>
            </div>
        </div>
    </div>
    
    
    <?php //include( locate_template( 'inc/hoe-werkt-het.php', false, false ) ); ?>

<?php get_footer(); ?>
