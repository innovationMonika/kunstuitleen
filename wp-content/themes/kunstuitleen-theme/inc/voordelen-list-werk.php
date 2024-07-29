<h2><?php the_field('benefits_title', 'option'); ?></h2>  
<?php if( have_rows('benefits', 'option') ): while ( have_rows('benefits', 'option') ) : the_row(); ?>
    <?php $icon = get_sub_field('benefits_icon'); ?>
    <?php if(!$icon){ $icon = '<i class="fa fa-thumbs-up"></i>'; } ?>
    
    <p><?php echo $icon; ?> <span><?php the_sub_field('benefits_benefit'); ?></span></p>
<?php endwhile; endif; ?>