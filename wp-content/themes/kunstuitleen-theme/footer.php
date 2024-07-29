<?php 
    $cookieWebVariant   = get_web_variant(); 
    $landingspage       = is_landingspage();
    $option             = ( $cookieWebVariant == 'thuis' ? '_thuis' : '' ); 
?>

            <div id="push"></div>
			
		</section> <!-- End of wrap -->
		
		<footer id="footer" class="sticky-footer">
    		<?php if( $landingspage != true ): ?>
        		<aside id="call-to-action">
            		<?php echo str_replace(array('<p>', '</p>'), '', get_field('footer_cta'.$option, 'option')); ?>
        		</aside>
                
                <section class="container text-center footer-cols">
                    <section class="row">
                        <section class="col-xs-12 col-sm-6 col-md-4 col-lg-4 footer-col border">	
                            <?php the_field('footer_left'.$option, 'option'); ?>
            			</section>
                        <section class="hidden-xs hidden-sm col-md-4 col-lg-4 footer-col border">	
            			    <h2>Navigatie</h2>
            			    
            			    <ul>
                			    <?php 
                    			    if( $cookieWebVariant == 'thuis' ): $menuLocation = 'primary-thuis'; else: $menuLocation = 'primary'; endif;
                    			    wp_nav_menu(array(
                    	            'theme_location' => $menuLocation, 
                    	            'container_class' => 'menu', 
                    	            'items_wrap' => '%3$s', 
                    	            'depth' => 1)); 
                                ?>
                            </ul>
                        </section>
            			<aside class="col-xs-12 col-sm-6 col-md-4 col-lg-4 footer-col">
            			    <?php the_field('footer_right'.$option, 'option'); ?>
            			    
            			    
                        </aside>		
                        
            		</section>
            		<section class="row">
                		<aside class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    		<ul class="landingspages">
                                <?php wp_nav_menu(array(
                    	            'theme_location' => 'landingspage', 
                    	            'container' => false,
                    	            'items_wrap' => '%3$s', 
                    	            'depth' => 1)); 
                                ?>
                            </ul>
                		</aside>
            		</section>
            	</section>
        	<?php endif; ?>
        	
        	<section id="bottom">
            	Copyright <?php echo date('Y'); ?> - <a href="<?php bloginfo('siteurl'); ?>">Kunstuitleen.nl</a> 
                <div class="footershare">
                    <?php include( locate_template( 'inc/share.php', false, false )); ?>
                </div>
            	<?php the_field('footer_copyright'.$option, 'option'); ?>
        	</section>
            
		</footer>
		
		<?php  
			// 	Don't show popup on 'voorselectie' pages
			if ( $landingspage == false ) {
				 include( locate_template('inc/popup.php', false, false) );  	   		       
				 include( locate_template('inc/helpbox.php', false, false) );  
            } 
        ?>
               	
		<a class="backtotop" onclick="$('html, body').animate({ scrollTop: 0 });">Terug naar boven</a>

        <?php
        $entry_id = safe_get('entry_id');
        $email = safe_get('email');

        // GTM Enhanced conversions (datalayer)
        if (!empty($entry_id) && !empty($email)) {

            $entry = FrmEntry::getOne($entry_id, true);
            $datalayerSettings = maybe_unserialize(get_option('frm_datalayer_' . $entry->form_id));

            if ($entry && !empty($datalayerSettings) && !empty(@$datalayerSettings['event']) && @$datalayerSettings['event'] !== 'none') {

                $event = $datalayerSettings['event'];

                // We can't use 'type' as a field
                unset($datalayerSettings['event']);

                $values = [];
                foreach($datalayerSettings as $key => $fieldId) {

                    if(!empty($fieldId) && isset($entry->metas[$fieldId])) {
                        $values[$key] = $entry->metas[$fieldId];
                    }

                    // Small fallback
                    if ($key === 'land' && empty($fieldId)) {
                        $values[$key] = 'NL';
                    }
                }

                if ($values['email'] === $email) {

                    if(!empty($values['price'])) {
                        $price = $values['price'];
                        unset($values['price']);
                    } else {
                        $price = 0;
                    }

                    $datalayer = array_merge([
                        'event' => $event,
                    ], $values);

                    if ($event === 'purchase') {

                        $datalayer = array_merge($datalayer, [
                            'transaction_id' => sprintf('%d_%d_%s', $entry->form_id, $entry_id, $entry->form_key),
                            'value' => $price,
                            'currency' => 'EUR',
                            'items' => [
                                'item_id' => $entry->form_id,
                                'item_name' => $entry->form_name,
                                'quantity' => 1,
                                'price' => number_format((float)$price, 2, '.', '')
                            ],
                        ]);
                    }

                    ?>
                    <script>
                        window.dataLayer = window.dataLayer || [];
                        window.dataLayer.push(<?= json_encode($datalayer) ?>);
                    </script>
                    <?php
                }
            }

        }

        // Adtraction
        if( isset($_GET['entry_id']) && !empty($entry_id) && isset($_GET['email']) && !empty($email) ){
            $hashed_email = adtraction_hash($email);
        ?>
        <script>
            var ADT = ADT || {};
            ADT.Tag = ADT.Tag || {};
            ADT.Tag.t = 4;
            ADT.Tag.c = "EUR";
            ADT.Tag.tp = 1514204094;
            ADT.Tag.ti = '<?= $entry_id ?>';
            ADT.Tag.xd = '<?= $hashed_email ?>';
        </script>
        <script defer src="https://pin.kunstuitleen.nl/jsTag?ap=1514076328"></script>
        <?php } // if entry_id and email ?>
		
		<?php wp_footer(); // Speciale WP footer ?>
		
		<!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</body>
</html>
