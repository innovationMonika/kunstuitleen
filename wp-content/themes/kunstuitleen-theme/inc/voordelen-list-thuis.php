<h2><?php the_field('benefits_title_thuis', 'option'); ?></h2>  
<?php if( have_rows('benefits_thuis', 'option') ): while ( have_rows('benefits_thuis', 'option') ) : the_row(); ?>
    
    <p><i class="fa fa-check"></i> <span><?php the_sub_field('thuis_benefits_benefit'); ?></span></p>
<?php endwhile; endif; ?>