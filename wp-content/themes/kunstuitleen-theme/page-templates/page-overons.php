<?php
    /*
        Template name: Over ons
    */
    get_header();
    $cookieWebVariant = get_web_variant(); 
?>
	<section class="inner-header">
		<div class="container relative page-content-container">
			 <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
		</div>
		<?php $image = get_field('about_us_header_image')['sizes']['home_header']; ?>
		<?php if ( !empty($image) ) :?>
			<img class="about-us-header-image" src="<?php echo $image; ?>">
		<?php endif; ?>
	</section>

    <section class="container relative page-content-container">
        
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 column padding-bottom-none page-content">
                
                
                	
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                <?php endwhile; endif; ?>
            </article>
            		
		</section>
    </section>
    
    
    <?php if( have_rows('page_repeat_blocks') ): while ( have_rows('page_repeat_blocks') ) : the_row(); ?>
        
        
        <section class="column padding-top-none <?php the_sub_field('page_block_bg'); ?>">
            
            <section class="container">
                <section class="row">
                    
                    <?php $columns = get_sub_field('page_block_columns'); ?>
                    <?php if($columns == 'two'){ ?>
                        
                        <article class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                            <?php if( get_sub_field('page_block_title') ) { ?>
                                <h2 class="text-center"><?php the_sub_field('page_block_title'); ?></h2>
                            <?php } ?>
                            
                            <section class="row">
                        
                                <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    
                                    <?php if( get_sub_field('page_block_column_has_img') == 'left' ){ ?>
                                    
                                        <?php $image = get_sub_field('page_block_column_image')['sizes']['responsive']; ?>
                                        <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />
                                    
                                    <?php } else { ?>
                                    
                                        <?php the_sub_field('page_block_content'); ?>
                                    
                                    <?php } ?>
                                    
                                </section>
                                
                                <section class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    
                                    <?php if( get_sub_field('page_block_column_has_img') == 'right' ){ ?>
                                    
                                        <?php $image = get_sub_field('page_block_column_image_second')['sizes']['responsive']; ?>
                                        <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />
                                    
                                    <?php } else { ?>
                                    
                                        <?php the_sub_field('page_block_column_second'); ?>
                                    
                                    <?php } ?>
                                    
                                </section>
                                
                            </section>
                            
                        </article>
                        
                    <?php } else { //One column ?>
                        
                        <article class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                            <?php if( get_sub_field('page_block_title') ) { ?>
                                <h2 class="text-center"><?php the_sub_field('page_block_title'); ?></h2>
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
    
    <?php if( have_rows('team_employees') ): ?>
        <section class="column" id="employees">
            <section class="container">
                <section class="row">
                    <?php $t = 0; ?>
                    <?php while ( have_rows('team_employees') ) : the_row(); $t++; ?>
                        <?php if( count(get_field('team_employees')) < 2 ) { $contentalign = 'text-center col-sm-offset-3 col-md-offset-3 col-lg-offset-3'; } else { $contentalign = 'text-right'; } ?>
                        <?php $image = get_sub_field('team_photo')['sizes']['responsive']; ?>
                        <?php if($t == 2): ?>
                            <aside class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                <img src="<?php echo $image; ?>" alt="<?php the_sub_field('team_name'); ?>" />
                            </aside>
                            <?php $contentalign = 'text-left'; ?>
                        <?php $t = 0; endif; ?>
                        
                        
                        <article class="col-xs-6 col-sm-6 col-md-3 col-lg-3 <?php echo $contentalign; ?>">
                            <h2><?php the_sub_field('team_name'); ?></h2>
                            <p class="function"><?php the_sub_field('team_function'); ?></p>
                            
                            <?php $quote = get_sub_field('team_quote'); ?>
                            <?php $phone = get_sub_field('team_phone'); ?>
                            <?php $email = get_sub_field('team_email'); ?>
                            <?php $linkedin = get_sub_field('team_linkedin'); ?>
                            
                            <?php if($quote): ?><blockquote><?php echo $quote; ?></blockquote><?php endif; ?>
                            
                            <?php if($phone): ?><a href="tel:<?php echo str_replace('(0) ', '', $phone); ?>"><?php echo $phone; ?></a><?php endif; ?>
                            <?php if($phone && $email): echo '<br/>'; endif; ?>
                            <?php if($email): ?><a href="mailto:<?php echo $email; ?>" class="email"><?php echo $email; ?></a><?php endif; ?>
                            <br/>
                            <?php if($linkedin): ?>
                                <a href="<?php echo $linkedin; ?>" class="social" target="_blank"><i class="fa fa-linkedin"></i></a>
                            <?php endif; ?>
                        </article>
                        
                        <?php if($t == 1): ?> 
                            <aside class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                <img src="<?php echo $image; ?>" alt="<?php the_sub_field('team_name'); ?>" />
                            </aside>
                            <br class="clear hidden-sm hidden-md hidden-lg" /><br class="clear hidden-sm hidden-md hidden-lg" />
                        <?php endif; ?>
                    <?php endwhile; ?>
                </section>
            </section>
        </section>
    <?php endif; ?>

<?php get_footer(); ?>
