<?php
switch ($cookieWebVariant) {
    case 'werk':
        $active     = 'werk';
        $active_id  = 31;
        $switch     = "thuis";
        $switch_id  = 121868;
        break;
    default: // werk
        $active     = 'thuis';
        $active_id  = 121868;
        $switch     = "werk";
        $switch_id  = 31;
        break;
}
?>
<a href="<?php echo get_permalink($active_id); ?>" class="link active"><span class=" hidden-md"><?php echo $active; ?></a>
<span>|</span>
<a href="<?php echo get_permalink($switch_id); ?>" class="link">Naar <span><?php echo $switch; ?></span></a>