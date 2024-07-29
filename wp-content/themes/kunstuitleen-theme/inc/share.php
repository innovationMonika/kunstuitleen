<?php  $termname = ''; if(!$shareid){ $shareid = $post->ID; $termname = ''; } ?>
Deel! 
<a href="https://twitter.com/intent/tweet?original_referer=https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink($shareid); ?>&source=tweetbutton&text=<?php the_title($shareid); ?>%20<?php echo get_permalink($shareid); ?>&hashtags=<?php echo $termname; ?>" onclick="window.open(this.href, 'mywin',
'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;">
    <i class="fa fa-twitter"></i>
</a> / 
<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink($shareid); ?>&display=popup" onclick="window.open(this.href, 'mywin',
'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;">
    <i class="fa fa-facebook"></i>
</a> / 
<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink($shareid); ?>&title=<?php echo get_the_title($shareid); ?>&summary=<?php echo get_the_excerpt($shareid); ?>%20<?php echo get_permalink($shareid); ?>" onclick="window.open(this.href, 'mywin',
'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;">
    <i class="fa fa-linkedin"></i>
</a><?php if ( is_singular( 'collectie' ) ) { ?> /
<a href="https://www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php the_field('art_image'); ?>&description=<?php the_title(); ?>" data-pin-do="buttonPin" data-pin-config="above" target="_blank">
    <i class="fa fa-pinterest"></i>
</a>

<?php /** Whatsapp - Only on Mobile **/ ?>
<?php $dataText = get_the_title($shareid).' - '.get_bloginfo('name').': '.get_permalink($shareid); ?>
<?php if ( wp_is_mobile() ) { $display = 'display:inline-block;'; } else { $display = 'display:none;'; } ?>
/ <a href="whatsapp://send?text=<?php echo urlencode($dataText); ?>" data-text="<?php echo $dataText; ?>" data-href="" target="_top" onclick="window.parent.null" class="whatsapp">
    <i class="fa fa-whatsapp"></i>
</a>
<?php } ?>