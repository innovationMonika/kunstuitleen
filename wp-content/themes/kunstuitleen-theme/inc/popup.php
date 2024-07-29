<aside id="overlay" class="hidden-xs"></aside>

<aside id="modal-button" class="hidden-xs <?php echo $cookieWebVariant; ?>">
    <div class="inner">
        <?php the_field($cookieWebVariant.'_popup_label', 'option'); ?> 
        <img src="<?php bloginfo('template_url'); ?>/static/images/modal-info.svg" alt="i" />
    </div>
</aside>

<aside id="modal" class="hidden-xs <?php echo $cookieWebVariant; ?>" data-seconds-firsttime="<?php the_field($cookieWebVariant.'_popup_seconds_firsttime', 'option'); ?>" data-seconds="<?php the_field($cookieWebVariant.'_popup_seconds', 'option'); ?>">

    <div class="modal-label">
        <?php the_field($cookieWebVariant.'_popup_label', 'option'); ?> 
        <img src="<?php bloginfo('template_url'); ?>/static/images/modal-info.svg" alt="i" />
    </div>
    
    <?php 
        if( $cookieWebVariant == 'thuis' ):
            $contentCols = 'col-xs-12 col-sm-6 col-md-3 col-lg-3';
            $photoCols = 'col-xs-12 col-sm-4 col-md-4 col-lg-4';
            $listCols = 'col-xs-12 hidden-sm col-md-5 col-lg-5';
        else:
            $contentCols = 'col-xs-12 col-sm-6 col-md-4 col-lg-4';
            $photoCols = 'col-xs-12 col-sm-4 col-md-3 col-lg-3';
            $listCols = 'col-xs-12 hidden-sm col-md-4 col-lg-4';
        endif;
    ?>
    
    <div id="modal-content">
        <img src="<?php bloginfo('template_url'); ?>/static/images/header-page-label-<?php echo $cookieWebVariant; ?>.svg" class="corner" />
        <div class="container">
            <div class="row">
                <div class="<?php echo $contentCols; ?> modal-col-content">
                    <h2 class="title"><?php the_field($cookieWebVariant.'_popup_title', 'option'); ?></h2>
                    <br/>
                    <?php the_field($cookieWebVariant.'_popup_content', 'option'); ?>
                </div>
                
                <div class="<?php echo $photoCols; ?> modal-col-photo">
                    <?php /* $photo = get_field($cookieWebVariant.'_popup_photo', 'option'); ?>
                    <img src="<?php echo isset($photo['url'])?$photo['url']:$photo; ?>" />
                    */ ?>
                </div>
                
                <div class="<?php echo $listCols; ?> modal-col-list">
                    <?php 
                        if( $cookieWebVariant == 'thuis' ):
                            //Thuis
                            include( locate_template( 'inc/voordelen-list-thuis.php', false, false ) );
                        else:
                            // Werk
                            include( locate_template( 'inc/voordelen-list-werk.php', false, false ) );                    
                        endif;
                        
                        if( have_rows($cookieWebVariant . '_popup_follow', 'option') ):
                            echo '<ul class="modal-social">';
                                echo '<li class="label">VOLG!</li>';
                                while ( have_rows($cookieWebVariant . '_popup_follow', 'option') ) : the_row();
                                    echo '<li><a href="' . get_sub_field('link', 'option') . '" target="_blank"><i class="fa ' . get_sub_field('icon', 'option') . '"></i></a></li>';
                                endwhile;
                            echo '</ul>';
                        endif; 
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
    
    <img src="<?php bloginfo('template_url'); ?>/static/images/modal-close.svg" alt="X" class="modal-close" />
</aside>