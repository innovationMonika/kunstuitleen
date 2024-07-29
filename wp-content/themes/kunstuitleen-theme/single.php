<?php 
    get_header();
    $cookieWebVariant = get_web_variant(); 
?>
    
    <section class="container relative page-content-container">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        
        <section class="row">
            <article class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-2 col-lg-offset-2 column single-post page-content">
                
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <h1><?php the_title(); ?></h1>
                    
                    <p class="post-meta text-center single">
                        <a class="author" href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>"><?php the_author_firstname();?>&nbsp;<?php the_author_lastname(); ?></a> / <?php echo get_the_date('d F Y'); ?>
                    </p>
                    
                    <?php $himage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive_full' ); ?>
            	        <?php if($himage){ ?>
                        <img src="<?php echo $himage[0]; ?>" alt="<?php the_title(); ?>" class="blog-featured-image" />
                    <?php } ?>
                                        
                    <?php the_content(); ?>
                <?php endwhile; endif; ?>
                
            </article>
            		
		</section>
    </section>
    
    <div id="grey-container" class="column">
        <section class="container relative">
            <section class="row">
                <section class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-2 col-lg-offset-2">
                    <?php comments_template(); ?>
                </section>
            </section>
        </section>
    </div>

<?php get_footer(); ?>
