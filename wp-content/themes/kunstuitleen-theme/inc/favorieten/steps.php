<?php
    $step_labels = [
        'one' => 'Favorieten',
        'two' => 'Gegevens',
        'three' => 'Bedankt',
    ];
    
    if( $cookieWebVariant === 'werk' ):
        if( $landingspage === true ): 
            $step_labels['one'] = 'Selectie';
            $step_ids = [
                'one' => 285794,
                'two' => 285801,
            ];
        else:
            $step_one_label = 'Favorieten';
            $step_ids = [
                'one' => 256,
                'two' => 121862,
            ];
        
        endif;
    else:
        $step_ids = [
            'one' => 122275,
            'two' => 122277,
        ];
    endif;
?>
<div class="row">
    <div class="col-xs-12 col-lg-10 col-lg-offset-1">
        <ul class="favorieten-steps<?php echo ( $thankyou === true ? ' thank-you' : '' ); ?>">
            <li class="step step-favorieten<?php echo ( $step_active === 'one' ? ' active' : ''); ?>" onclick="window.location = '<?php echo get_permalink($step_ids['one']); ?>';">
                <div class="step-inner-container"><div class="step-inner"><?php locate_template('static/images/favorieten-step_mijn-favorieten.svg', true, false); ?>1. <?php echo $step_labels['one']; ?></div></div>
            </li>    
            <li class="step step-gegevens<?php echo ( $step_active === 'two' ? ' active' : ''); ?>" onclick="window.location = '<?php echo get_permalink($step_ids['two']); ?>';">
                <div class="step-inner-container"><div class="step-inner"><?php locate_template('static/images/favorieten-step_gegevens.svg', true, false); ?>2. <?php echo $step_labels['two']; ?></div></div>
            </li>    
            <li class="step step-bedankt<?php echo ( $step_active === 'three' ? ' active' : ''); ?>">
                <div class="step-inner-container"><div class="step-inner"><?php locate_template('static/images/favorieten-step_bedankt.svg', true, false); ?>3. <?php echo $step_labels['three']; ?></div></div>
            </li>    
        </ul>
    </div>
</div>