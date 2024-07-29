<?php 
    get_header(); 
    $cookieWebVariant = get_web_variant(); 
?>
    
    <section class="container relative ajaxloading page-content-container" id="blog">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        
        <section class="row">
            <article class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-2 col-lg-offset-2 column page-content">
                
                    <h1><?php echo get_the_title( get_option('page_for_posts') ); ?></h1>
                    
                    <section class="row">
                            
                        <div class="blog-items">
                            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            
                                <?php include( locate_template( 'inc/blog-item.php', false, false )); ?>
                                
                            <?php endwhile; endif; ?>
                            
                        </div>
            
                    </section>
                    
                    <aside class="loading text-center clear">
                        <img src="<?php bloginfo('template_url'); ?>/static/images/arrow-rotatie.gif" alt="Bezig met laden" />
                    </aside>
                    
                    <aside class="end-message text-center"></aside>
                    
                    <script>
                        
                        <?php global $wp_query; ?>
                        var maxPages = <?php echo $wp_query->max_num_pages; ?>;
                        var postsPerPage = <?php echo get_option('posts_per_page'); ?>;
                        var currentPage = 2;
                        
                    </script>
                    
                    
                    
                </section>
                    
            </article>
            		
		</section>
		
        

<?php get_footer(); ?>
