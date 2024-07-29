<?php
/*
    Template name: Homepagina - werk
*/
get_header();
?>

    <header>
        <?php $himage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'home_header'); ?>
        <?php if (!$himage) {
            $himage = wp_get_attachment_image_src(get_post_thumbnail_id(31), 'home_header');
        } ?>

        <section class="inner-header">

            <video id="html5video" preload="auto" muted autoplay="true" loop="loop" class="hidden-xs" <?php /*onended="runnextvideo()"*/ ?>>
                <source src="<?php bloginfo('template_url'); ?>/static/video/comp<?php echo rand(1, 5); ?>.mp4" type="video/mp4">
                <img src="<?php echo $himage[0]; ?>" alt="<?php the_title(); ?>"/>
            </video>

            <img class="hidden-sm hidden-md hidden-lg backup-image" src="<?php echo $himage[0]; ?>" alt="<?php the_title(); ?>"/>

            <img src="<?php bloginfo('template_url'); ?>/static/images/header-werk.svg" class="header-label" alt="Werk"/>

            <section id="slogan">
                <section class="container">
                    <?php
                        $slogan = get_field('header_slogan');
                        $bullets = get_field('header_bullets');
                    ?>
                    <?php if( !empty($slogan) ){ ?>
                        <div class="row">
                            <div class="col-xs-12 text-center slogan-content">
                                <div class="inner">
                                    <h1><?= $slogan ?></h1>
                                    <?php if( !empty($bullets) ){ ?>
                                        <ul class="bullets">
                                            <?php foreach($bullets as $bullet) { ?>
                                                <li><?= $bullet['bullet'] ?></li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php $btnleft = get_field('header_left_btn_label'); $btnlefturl = get_field('header_left_btn_url'); ?>
                    <?php $btnright = get_field('header_right_btn_label'); $btnrighturl = get_field('header_right_btn_url'); ?>
                    <?php $btnmiddle = get_field('header_middle_btn_label'); $btnmiddleurl = get_field('header_middle_btn_url'); ?>
                    <?php if ($btnleft && $btnlefturl || $btnright && $btnrighturl || $btnmiddle && $btnmiddleurl) { ?>
                        <section class="row">
                            <section class="hidden-xs col-sm-12 col-md-12 col-lg-12 text-center buttons">

                                <?php if ($btnleft && $btnlefturl) { ?>
                                    <a href="<?php echo $btnlefturl; ?>" class="button mirrored layered"><?php echo $btnleft; ?></a>
                                <?php } ?>
                                <?php if ($btnright && $btnrighturl) { ?>
                                    <a href="<?php echo $btnrighturl; ?>" class="button white block right"><?php echo $btnright; ?></a>
                                <?php } ?>

                                <?php if ($btnmiddle && $btnmiddleurl) { ?>
                                    <a href="<?php echo $btnmiddleurl; ?>" class="button middle"><?php echo $btnmiddle; ?></a>
                                <?php } ?>

                            </section>
                        </section>
                    <?php } ?>
                </section>
            </section>

        </section>
    </header>


    <section id="collection-new" class="column text-center">
        <section class="container">
            <section class="row">
                <section class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2>Nieuw in de collectie</h2>
                    <section id="carousel">
                        <?php $the_query = new WP_Query(array(
                            'post_type' => 'collectie',
                            'meta_key' => 'art_inkoopdat',
                            'orderby' => 'meta_value name',
                            'order' => 'DESC',
                            'showposts' => '10',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'waarde',
                                    'field' => 'slug',
                                    'terms' => array('r', 'x'),
                                    'operator' => 'NOT IN',
                                ),
                            )
                        )); ?>
                        <?php if ($the_query->have_posts()) {
                            while ($the_query->have_posts()) {
                                $the_query->the_post(); ?>
                                <?php $cimage = get_field('art_image'); ?>
                                <?php if ($cimage) { ?>
                                    <div class="slide">

                                        <a href="<?php the_permalink(); ?>" style="background-image: url(<?php echo $cimage; ?>);">
                                            <img src="<?php bloginfo('template_url'); ?>/static/images/collection-spacer.png" alt="<?php the_title(); ?>"/>
                                            <section class="art-info">
                                                <h3><?php the_title(); ?></h3>
                                                <h4><?php the_field('art_kunstenaar_name'); ?></h4>
                                                <p>
                                                    <?php the_field('art_afmeting'); ?> - <?php the_field('art_inkoopdat'); ?>
                                                </p>
                                            </section>
                                        </a>

                                    </div>
                                <?php } ?>
                            <?php } /* endwhile */
                        } /* endif */
                        wp_reset_postdata(); /* Restore original Post Data */ ?>
                    </section>
                </section>
            </section>
        </section>
        <aside class="column-buttons">
            <a href="<?php echo $btnlefturl; ?>" class="button mirrored layered"><?php echo $btnleft; ?></a>
            <section class="share">
                <?php $shareid = 42; //Collectie ?>
                <?php include(locate_template('inc/share.php', false, false)); ?>
            </section>
        </aside>
    </section>


    <section id="about" class="column text-center">
        <h2><?php the_field('home_about_title'); ?></h2>

        <?php $videoimage = get_field('home_about_image'); ?>
        <?php if ($videoimage) { ?>
            <section class="video">
                <?php $video = get_field('home_about_video'); ?>
                <?php if ($video) { ?>
                    <a href="<?php echo $video; ?>" class="lightbox">
                        <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>"/>
                        <img src="<?php bloginfo('template_url'); ?>/static/images/play.svg" class="play"/>
                    </a>
                <?php } else { ?>
                    <div class="relative hidden-xs hidden-sm hidden-md">
                        <video id="html5videoAbout" preload="auto" <?php /*onended="runnextvideo()"*/ ?>>
                            <source src="<?php bloginfo('template_url'); ?>/static/video/kunstuitleen_v6d_h264-mp4-1080pv2-compress.mp4" type="video/mp4">
                            <source src="<?php bloginfo('template_url'); ?>/static/video/Kunstuitleen_v6d_VP8-WebM.webm" type="video/webm">
                        </video>

                        <div class="video-controls">
                            <img src="<?php bloginfo('template_url'); ?>/static/images/video-play.svg" alt="Play" title="Play" class="video-play"/>
                            <img src="<?php bloginfo('template_url'); ?>/static/images/video-pause.svg" alt="Pause" title="Pause" class="video-pause"/>

                            <img src="<?php bloginfo('template_url'); ?>/static/images/video-volume-on.svg" alt="Geluid uit" title="Geluid uit"
                                 class="video-volume-on"/>
                            <img src="<?php bloginfo('template_url'); ?>/static/images/video-volume-off.svg" alt="Geluid aan" title="Geluid aan"
                                 class="video-volume-off"/>
                        </div>
                    </div>

                    <img class="hidden-lg backup-image" src="<?php echo $image; ?>" alt="<?php the_title(); ?>"/>
                <?php } ?>


                <aside class="column-buttons">
                    <a href="<?php the_field('nav_btn_url', 31); ?>" class="button red mirrored layered"><?php the_field('nav_btn_label', 31); ?></a>
                    <section class="share">
                        <?php $shareid = 40; //Hoe werkt het ?>
                        <?php include(locate_template('inc/share.php', false, false)); ?>
                    </section>
                </aside>
            </section>
        <?php } ?>

        <?php if (get_field('home_about_content')) { ?>
            <section class="container">
                <section class="row">
                    <section class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-sm-offset-1 column">
                        <?php the_field('home_about_content'); ?>
                    </section>
                </section>
            </section>
        <?php } ?>

    </section>


    <section id="partof" class="column text-center">
        <section class="container">
            <section class="row">
                <section class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h3 class="subtitle">Kunstuitleen.nl is onderdeel van:</h3>
                    <h2>Amsterdam Art Center</h2>

                    <section id="parts">
                        <section class="row">
                            <?php $a = 0; ?>
                            <?php $the_query = new WP_Query(array(
                                'post_type' => 'amsterdamartcenter', 'orderby' => 'menu_order', 'order' => 'ASC', 'showposts' => '10')); ?>
                            <?php if ($the_query->have_posts()) {
                                while ($the_query->have_posts()) {
                                    $the_query->the_post();
                                    $a++; ?>
                                    <article class="col-xs-6 col-sm-4 col-md-3 col-lg-3 part">
                                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full_thumbnail_size'); ?>
                                        <?php if(!empty($image)) { ?>
                                        <?php if (get_field('onderdeel_url')): ?>
                                            <a href="<?php the_field('onderdeel_url'); ?>" target="_blank">
                                                <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>"/>
                                            </a>
                                        <?php else: ?>
                                            <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>"/>
                                        <?php endif; ?>
                                        <?php } ?>

                                        <h3><?php the_title(); ?></h3>
                                        <div class="text-left"><?php the_content(); ?></div>
                                    </article>
                                    <?php if ($a == 3) {
                                        echo '<br class="clear hidden-xs hidden-md hidden-lg" />';
                                    } ?>
                                <?php } /* endwhile */
                            } /* endif */
                            wp_reset_postdata(); /* Restore original Post Data */ ?>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>

<?php get_footer(); ?>