<?php 
    get_header(); 
    $cookieWebVariant   = get_web_variant();
    $landingspage       = is_landingspage();
?>
    
    <section class="container relative page-content-container">
        <?php if ( function_exists('yoast_breadcrumb') && $landingspage == false ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        
        <section class="row">
            <article class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-2 col-lg-offset-2 column page-content">
                
                
                	
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                    <br class="hidden-xs" />
                <?php endwhile; endif; ?>
                
            </article>
            		
		</section>
    </section>
    
    
    <?php if( have_rows('page_repeat_blocks') ): while ( have_rows('page_repeat_blocks') ) : the_row(); ?>
        
        
        <section class="column padding-large <?php the_sub_field('page_block_bg'); ?>">
            
            <section class="container">
                <section class="row">
                    
                    <?php $columns = get_sub_field('page_block_columns'); ?>
                    <?php if($columns == 'two'){ ?>
                        
                        <article class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-2 col-lg-offset-2 two-columns column-inner">
                           
                            <section class="row">
                        
                                <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    
                                    <?php if( get_sub_field('page_block_column_has_img') == 'left' ){ ?>
                                    
                                        <?php $image = get_sub_field('page_block_column_image')['sizes']['responsive']; ?>
                                        <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />
                                    
                                    <?php } else { ?>
                                    
                                        <?php if( get_sub_field('page_block_title') ) { ?>
                                            <h2><?php the_sub_field('page_block_title'); ?></h2>
                                        <?php } ?>
                                    
                                        <?php the_sub_field('page_block_content'); ?>
                                    
                                    <?php } ?>
                                    
                                </section>
                                
                                <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    
                                    <?php if( get_sub_field('page_block_column_has_img') == 'right' ){ ?>
                                    
                                        <?php $image = get_sub_field('page_block_column_image_second')['sizes']['responsive']; ?>
                                        <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />
                                    
                                    <?php } else { ?>
                                    
                                        <?php if( get_sub_field('page_block_title') ) { ?>
                                            <h2><?php the_sub_field('page_block_title'); ?></h2>
                                        <?php } ?>
                                    
                                        <?php the_sub_field('page_block_column_second'); ?>
                                    
                                    <?php } ?>
                                    
                                </section>
                                
                            </section>
                            
                        </article>
                        
                    <?php } else { //One column ?>
                        
                        <article class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-2 col-lg-offset-2">
                            <?php if( get_sub_field('page_block_title') ) { ?>
                                <h2><?php the_sub_field('page_block_title'); ?></h2>
                            <?php } ?>
                            
                            <?php if( get_sub_field('page_block_has_image') == 'yes' ) { //One column image i.o. content ?>
                            
                                <?php $image = get_sub_field('page_block_image')['sizes']['one_column_image']; ?>
                                <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />
                                        
                            <?php } else { //One column normal content  ?>
                                <?php the_sub_field('page_block_content'); ?>
                            <?php } ?>
                            
                        </article>
                        
                    <?php } ?>
                    
                </section>
            </section>
            
            
            
        </section>
        
    <?php endwhile; endif; ?>

<?php get_footer(); ?>
