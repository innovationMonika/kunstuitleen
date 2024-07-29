<?php $cookieWebVariant = get_web_variant(); $the_query = new WP_Query( 
    array( 
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
    ) 
); ?>
<?php if ( $the_query->have_posts() ) {	while ( $the_query->have_posts() ) { $the_query->the_post(); ?>

    <section id="testimonial" class="col-12 col-md-6">
        
        <article class="testimonial-content">
            
            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'referentie' ); ?>
            
            <?php if($image){ ?>
                <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" />
                <br/><br/>
            <?php } ?>

            <?php the_content(); ?>    
            <img src="<?php bloginfo('template_url'); ?>/static/images/testimonial-arrow.svg" class="arrow testimonial-arrow-home" />
			<img src="<?php bloginfo('template_url'); ?>/static/images/testimonial-arrow-werk.svg" class="arrow testimonial-arrow-work" />
                
        </article>
        
        <section class="testimonial-author row">   
            <?php $a_image = get_field('referentie_photo'); ?>                        
            <?php if($a_image){ ?>
                <section class="col-xs-5 col-sm-2 col-md-3 col-lg-3 text-center">
                    <img src="<?php echo $a_image['sizes']['referentie_author']; ?>" class="photo" alt="<?php the_title(); ?>" />
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