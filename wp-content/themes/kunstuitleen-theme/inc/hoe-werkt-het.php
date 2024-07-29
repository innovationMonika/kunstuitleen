<section class="content-container ">
    <div class="container">
        <section class="row">
            <div class="col-xs-12">
                
                <h1><?php echo get_the_title($include_post_id); ?></h1><br/>
                <p class="text-center"><a href="<?php echo get_permalink($include_post_id); ?>?form=contact" class="backto">Waar kunnen wij u mee helpen?</a></p>
       
                <?php if( have_rows('howitworks_steps', $include_post_id) ): $i = 0; ?>
                    <div class="hiw-steps">
                        <?php while ( have_rows('howitworks_steps', $include_post_id) ) : the_row(); ?>
                            <?php 
                                
                                // Step Vars 
                                $i++;
                                $step_image = get_sub_field('howitworks_step_img');
                            ?>
                        
                            <div class="step">
                                <div class="step-number"><?php echo $i; ?></div>
                                <div class="row">
                                    
                                    <?php if( $i % 2 === 0 ): ?>
                                        <div class="hidden-xs col-sm-6 d-flex no-padding-right">
                                            <div class="step-image" style="background-image: url(<?php echo $step_image['sizes']['responsive']; ?>);"></div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="col-xs-12 col-sm-6 d-flex">
                                        <div class="step-description">
                                            <h2><?php the_sub_field('howitworks_step_title'); ?></h2>
                                            <?php the_sub_field('howitworks_step_description'); ?>
                                        </div>
                                        
                                        <?php if( get_sub_field('howitworks_step_button') === true ): ?>
                                            <a href="<?php echo get_sub_field('howitworks_step_button_href')['url']; ?>" class="button upsidedown hidden-xs hidden-sm <?php echo ( $cookieWebVariant == 'werk' ? 'werk' : 'mustard' ); ?>"><?php the_sub_field('howitworks_step_button_label'); ?></a>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="col-xs-12 <?php echo ( $i % 2 === 1 ? 'col-sm-6' : 'hidden-sm hidden-md hidden-lg' ); ?> d-flex no-padding-left">
                                        <div class="step-image" style="background-image: url(<?php echo $step_image['sizes']['responsive']; ?>);"></div>
                                    </div>
                                </div>
                                
                                <?php if( get_sub_field('howitworks_step_button') === true ): ?>
                                    <a href="<?php echo get_sub_field('howitworks_step_button_href')['url']; ?>" class="button upsidedown hidden-md hidden-lg <?php echo ( $cookieWebVariant == 'werk' ? 'werk' : 'mustard' ); ?>"><?php the_sub_field('howitworks_step_button_label'); ?></a>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</section>

<section class="column padding-bottom">
    <section class="container relative">
        <section class="row">
            <?php if(get_field('black_columns') == '2'){ 
                $cols = 'col-xs-12 col-sm-6 col-md-6 col-lg-6'; 
            } else { $cols = 'col-xs-12'; } ?>
            
            <article class="<?php echo $cols; ?>">
                <h2 class="text-center"><?php the_field('black_column_title', $include_post_id); ?></h2>
                <?php $image = get_field('black_column_image', $include_post_id)['sizes']['black_column_image']; ?>
                
                <?php $videoUrl = get_field('black_column_video', $include_post_id); ?>
                <?php if( get_field('black_column_has_video', $include_post_id) && $videoUrl){ ?>
                    <section class="video videoWrapper">
                        <?php echo wp_oembed_get($videoUrl); ?>
                    </section>
                <?php } else { ?>
                    <img src="<?php echo $image; ?>" alt="<?php echo get_the_title($include_post_id); ?>" />
                <?php } ?>

            </article>
            
            <?php /*if(get_field('black_columns', $include_post_id) == '2'){ ?>
            <article class="<?php echo $cols; ?> how-it-works">
                <h2 class="text-center"><?php the_field('black_column_scnd_title', $include_post_id); ?></h2>
                <?php $image = get_field('black_column_scnd_image', $include_post_id)['sizes']['black_column_image_2nd']; ?>
                
                <?php $videoimage = get_field('black_column_scnd_video', $include_post_id); ?>               
                <?php if($videoimage){ ?>
                    <section class="video"> 
                        <a href="<?php echo $videoimage; ?>" class="lightbox">   
                            <img src="<?php echo $image; ?>" alt="<?php echo get_the_title($include_post_id); ?>" />
                            <img src="<?php bloginfo('template_url'); ?>/static/images/play.svg" class="play" />
                        </a>
                    </section>
                <?php } else { ?>
                    <img src="<?php echo $image; ?>" alt="<?php echo get_the_title($include_post_id); ?>" />
                <?php } ?>
                
            </article>
            <?php } */?>
        </section>
    </section>
</section>


<section class="container padding-top relative">
    <section class="row">
        <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6 marginb">
            <section class="column red lightgray form">
                <?php echo do_shortcode( get_field('how_it_works_form', $include_post_id) ); ?>
            </section>
        </section>
        <section class="hidden-xs col-sm-6 col-md-6 col-lg-6 referentie werk-referentie marginb">
			<div class="row">
				<div class="col-xs-8 col-xs-offset-2 text-center werk testimonial title">
					<h2>Wat klanten van ons zeggen</h2>
				</div>	
			</div>	
            <?php include( locate_template( 'inc/referentie.php', false, false )); ?>
        </section>
    </section>
</section>