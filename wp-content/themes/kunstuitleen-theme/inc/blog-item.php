<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 blog-item relative">
    
    <section class="row">
        <aside class="col-xs-12 col-sm-5 col-md-5 col-lg-5 art-image text-center">
            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'square' );  ?>
            <?php if( $image ): ?>
                <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" />
            <?php endif; ?>
        </aside>
        
        <article class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            
            <p class="post-meta">
                <a class="author" href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>">
                    <?php the_author_firstname();?>&nbsp;<?php the_author_lastname(); ?>
                </a>
                
                /
                
                <?php echo get_the_date('d F Y'); ?>
                

            </p>
            
            <?php content_is_more(); ?>
            
            <br/>
            
            <a href="<?php the_permalink(); ?>" class="button <?php echo $cookieWebVariant; ?>">Lees verder</a>
        </article>
    </section>
    
    <img src="<?php bloginfo('template_url'); ?>/static/images/art-corner.svg" class="corner" />
</section>