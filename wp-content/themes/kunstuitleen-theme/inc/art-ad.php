<?php $art_ads = get_field('collectie_art_ads', 'option'); ?>
<?php if( !empty($art_ads) ): ?>
<section class="col-xs-12 col-sm-4 col-md-3 col-lg-3 art">
    <div class="art-ad">
        <?php $ad_key = ($currentPage - 1) % sizeof($art_ads); ?>
        <img src="<?php echo $art_ads[$ad_key]['sizes']['responsive']; ?>" alt="<?php echo $art_ads[$ad_key]['alt']; ?>" />
    </div>
</section>
<?php endif; ?>