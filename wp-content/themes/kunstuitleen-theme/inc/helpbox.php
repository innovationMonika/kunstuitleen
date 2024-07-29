<?php if( have_rows('helpboxes', 'option') ): ?>
    <?php while ( have_rows('helpboxes', 'option') ) : the_row(); ?>
        <div class="helpbox" id="helpbox-<?php the_sub_field('helpbox_key'); ?>">
            <div class="helpbox-close"><i class="fa fa-times" aria-hidden="true"></i></div>
            <?php the_sub_field('helpbox_content'); ?>
        </div>
    <?php endwhile; ?>
<?php endif; ?>