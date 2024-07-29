<?php 
    get_header();
    $cookieWebVariant = get_web_variant();
?>
    
    <section class="container relative">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 column page-content">
                    <h1>Zoekresultaten voor: '<?php echo esc_html( $_GET['s'] ); ?>'</h1>
            </article>
            		
		</section>
    </section>
    
    <?php $bgcolor = array('white', 'grey'); $b = 1; ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php $permalink = get_permalink(); ?>
        <?php if(get_post_type($post->ID) == 'kunstenaar'){ $permalink = get_permalink(42).'?c='.get_the_title(); } else { $permalink = get_permalink(); } ?>
    
        <section class="column <?php echo $bgcolor[$b]; ?>">
                
                <section class="container">
                    <section class="row">
                        <article class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                            <h2 class="text-center">
                                <a href="<?php echo $permalink; ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <?php
                            // Check the content for the more text
                            $ismore = @strpos( $post->post_content, '<!--more-->');
                            // If there's a match
                            if($ismore) : the_content(' ');
                            // Else no more tag exists
                            else : the_excerpt();
                            // End if more
                            endif;
                            ?>
                            
                            <?php $simage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'one_column_image' ); ?>
                            <?php if($simage){ ?>
                                <a href="<?php echo $permalink; ?>">
                                    <img src="<?php echo $simage[0]; ?>" alt="<?php the_title(); ?>" />
                                </a>
                            <?php } ?>
                            
                            <a href="<?php echo $permalink; ?>">Bekijken</a>
                        </article>
                    </section>
                </section>
        </section>
        
        <?php if($b == 1){ $b = 0; } else { $b++; } ?>
    <?php endwhile; endif; ?>


<?php get_footer(); ?>
