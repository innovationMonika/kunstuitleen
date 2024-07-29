<?php
    /*
        Template name: Hoe werkt het?
    */
    get_header();
    $cookieWebVariant = get_web_variant(); 
?>
    
    
    <section class="container relative page-content-container">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        
        <section class="column first marginb">
            <section class="row">
                <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="howitworks">
                    
                    <section class="column gradient topextra relative">
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <h1><?php the_title(); ?></h1>
                            <?php the_content(); ?>
                        <?php endwhile; endif; ?>
                    </section>
                    
                </article>
                
                <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 marginb">
                    
                    <?php if( $cookieWebVariant == 'werk' ): 
                        include( locate_template( 'inc/voordelen-werk.php', false, false ));
                    else: ?>
                        <section class="row">
                            <section class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-2 col-lg-offset-2" id="how-it-works-voordelen">
                                <?php include( locate_template( 'inc/voordelen-thuis.php', false, false )); ?>
                            </section>
                        </section>
                        
                    <?php endif; ?>
                    
                    <?php if(get_field('howitworks_extracontent')){ ?>
                        <div id="howitworks" class="margintop">
                            
                            <section class="column gradient topextra relative">
                                <?php the_field('howitworks_extracontent'); ?>
                            </section>
    		
                    		<?php 
                                if( $cookieWebVariant == 'thuis' ): 
                                    $option = '_thuis'; 
                                else:
                                    $option = ''; 
                                endif;
                            ?>
                            
                            <aside class="column-buttons">
                               <a href="tel:<?php echo get_field( "contact_phone".$option, 'option' ); ?>" class="button red mirrored layered"><?php echo get_field( "contact_phone".$option, 'option' ); ?></a>
                               <section class="share">
                                   <a href="mailto:<?php echo get_field(  'contact_email'.$option, 'option' ); ?>"><?php echo get_field(  'contact_email'.$option, 'option' ); ?></a>
                               </section>
                           </aside>
                            
                        </div>
                    <?php } ?>
                    
                </section>
    		</section>
        </section>
    </section>
    
    <?php if( $cookieWebVariant == 'werk' ): ?>
    
    <section class="column black">
        <section class="container relative">
            <section class="row">
                <?php if(get_field('black_columns') == '2'){ 
                    $cols = 'col-xs-12 col-sm-6 col-md-6 col-lg-6'; 
                } else { $cols = 'col-xs-12 col-sm-8 col-md-8 col-lg-8 col-sm-offset-2 col-md-offset-2 col-lg-offset-2'; } ?>
                
                <article class="<?php echo $cols; ?>">
                    <h2><?php the_field('black_column_title'); ?></h2>
                    <?php $image = get_field('black_column_image')['sizes']['black_column_image']; ?>
                    
                    <?php $videoimage = get_field('black_column_video'); ?>               
                    <?php if($videoimage){ ?>
                        <section class="video"> 
                            
                            <div class="relative">
	                            <video id="html5videoAbout" poster="<?php echo $image; ?>" preload="auto" <?php /*onended="runnextvideo()"*/?>>
			                      <source src="<?php bloginfo('template_url'); ?>/static/video/kunstuitleen_nl_uitleg_over_ons_servicepakket-compress.mp4" type="video/mp4">
			                      <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />
			                    </video>
		                    
			                    <div class="video-controls">
					                <img src="<?php bloginfo('template_url'); ?>/static/images/video-play.svg" alt="Play" title="Play" class="video-play" />
					                <img src="<?php bloginfo('template_url'); ?>/static/images/video-pause.svg" alt="Pause" title="Pause" class="video-pause" />
					                
					                <img src="<?php bloginfo('template_url'); ?>/static/images/video-volume-on.svg" alt="Geluid uit" title="Geluid uit" class="video-volume-on" />
					                <img src="<?php bloginfo('template_url'); ?>/static/images/video-volume-off.svg" alt="Geluid aan" title="Geluid aan" class="video-volume-off" />
					            </div>
							</div>
                        </section>
                    <?php } else { ?>
                        <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />
                    <?php } ?>
                </article>
                
                <?php if(get_field('black_columns') == '2'){ ?>
                <article class="<?php echo $cols; ?> how-it-works">
                    <h2><?php the_field('black_column_scnd_title'); ?></h2>
                    <?php $image = get_field('black_column_scnd_image')['sizes']['black_column_image_2nd']; ?>
                    
                    <?php $videoimage = get_field('black_column_scnd_video'); ?>               
                    <?php if($videoimage){ ?>
                        <section class="video"> 
                            <a href="<?php echo $videoimage; ?>" class="lightbox">   
                                <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />
                                <img src="<?php bloginfo('template_url'); ?>/static/images/play.svg" class="play" />
                            </a>
                        </section>
                    <?php } else { ?>
                        <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />
                    <?php } ?>
                    
                </article>
                <?php } ?>
            </section>
        </section>
    </section>

    
    <section class="container relative">
        <section class="row">
            <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 marginb">
                <section class="column red form">
                    <?php echo do_shortcode( get_field('how_it_works_form') ); ?>
                </section>
            </section>
            <section class="hidden-xs col-sm-6 col-md-6 col-lg-6 column referentie">
                <?php include( locate_template( 'inc/referentie.php', false, false )); ?>
            </section>
        </section>
    </section>
    
    <?php endif; // if webVariant = werk ?>
    
    
    <section class="column hidden-xs">
        
        <section class="container" id="testimonials">
            <section class="row">
                
                <?php $the_query = new WP_Query( array( 
                    'post_type' => 'referentie',  
                    'orderby' => 'rand', 
                    'showposts' => '2',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'referentie_type',
                            'field' => 'slug',
                            'terms'    => $cookieWebVariant,
                        ),
                    ),
                ) ); ?>
                <?php if ( $the_query->have_posts() ) {	while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
                
                    <section id="testimonial" class="col-sm-6 col-md-6 col-lg-6">
                        
                        <article class="testimonial-content">
                            
                            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'referentie' ); ?>
                            
                            <?php if($image){ ?>
                                <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" />
                                <br/><br/>
                            <?php } ?>
    	   
                            <?php the_content(); ?>    
                            <img src="<?php bloginfo('template_url'); ?>/static/images/testimonial-arrow.svg" class="arrow" />
                                
                        </article>
                        
                        <section class="testimonial-author row">   
                            <?php $a_image = get_field('referentie_photo')['sizes']['referentie_author']; ?>                        
                            <?php if($a_image){ ?>
                                <section class="col-xs-5 col-sm-2 col-md-3 col-lg-3 text-center">
                                    <img src="<?php echo $a_image; ?>" class="photo" alt="<?php the_title(); ?>" />
                                </section>
                            <?php } ?>
                            <section class="col-xs-7 col-sm-10 col-md-9 col-lg-9">
                                <h2><?php the_title(); ?></h2>
                                
                                <?php $company = get_field('referentie_company'); ?>
                                <?php $website = get_field('referentie_website'); ?>
                                <?php if($company && $website){ ?>
                                    <p class="company"><a href="<?php echo $website; ?>" target="_blank"><?php echo $company; ?></a></p>
                                <?php } else { ?>
                                    <p class="company"><?php echo $company; ?></p>
                                <?php } ?>
                            </section>                 
                        </section>
                        
                    </section>
                
                <?php  } /* endwhile */ } /* endif */ wp_reset_postdata(); /* Restore original Post Data */ ?>
                
            </section>    
        </section>
        
    </section>

<?php get_footer(); ?>
