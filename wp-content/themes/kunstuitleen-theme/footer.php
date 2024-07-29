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
            	Copyright <?php echo date('Y'); ?> - <a href="<?php echo get_site_url(); ?>">Kunstuitleen.nl</a> 
                <div class="footershare">
                    <?php $shareid = ''; ?>
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

        if( isset($_GET['entry_id']) && !empty($entry_id) && isset($_GET['email']) && !empty($email) ){
            $entry_id = esc_html($_GET['entry_id']);
            $email = esc_html($_GET['email']);
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
<script>
// 	login form
		jQuery(document).ready(function(){
        jQuery('#confirm').hide();
        jQuery('#sign-up-complete').hide();
        jQuery('#forget-pass').hide();
        jQuery('#sign-up').hide();
        jQuery('#account-detail').hide();
            
        jQuery('.forget-pass').click(function(){
            jQuery('#forget-pass').show();
            jQuery('#login').hide();
            jQuery('#sign-up-complete').hide();
        });
        /*jQuery('#login-btn').click(function(){
            jQuery('.dropdown-menu').css({"min-width": "400px"});
            jQuery('#account-detail').show();
            jQuery('#login').hide();
            jQuery('#sign-up-complete').hide();
        });*/
       /* jQuery('.confirm').click(function(){
            jQuery('#forget-pass').hide();
            jQuery('#confirm').show();
            jQuery('#login').hide();
        });*/
       /* jQuery('.sign-up-complete').click(function(){
            jQuery('#forget-pass').hide();
            jQuery('#sign-up').hide();
            jQuery('#login').hide();
            jQuery('#sign-up-complete').show();
        });*/
        jQuery('.sign-up').click(function(){
            jQuery('#sign-up').show();
            jQuery('#login').hide();
        });
        jQuery('.sign-in').click(function(){
            jQuery('#sign-up-complete').hide();
            jQuery('#login').show();
            jQuery('#sign-up').hide();
            jQuery('#forget-pass').hide();
            jQuery('#confirm').hide();
        });
         jQuery('.go_to_login').click(function(){
            jQuery('#sign-up-complete').hide();
            jQuery('#login').show();
            jQuery('#sign-up').hide();
            jQuery('#forget-pass').hide();
            jQuery('#confirm').hide();
        });
        $('#close_2').click(function(){
            jQuery('#dropdown').removeClass('open');
            jQuery('#form_one').removeClass('form_toggle');
            jQuery('#confirm').hide();
            jQuery('#forget-pass').hide();
            jQuery('#login').show();
            jQuery('#sign-up-complete').hide();
            jQuery('#account-detail').hide();
        });
        $('#close').click(function() {
            jQuery('#dropdown').removeClass('open');
            jQuery('#confirm').hide();
            jQuery('#forget-pass').hide();
            jQuery('#login').show();
            jQuery('#sign-up-complete').hide();
            jQuery('#account-detail').hide();
        });
//         $('.dropdown-menu').on("click.bs.dropdown", function (e) {
//             e.stopPropagation();
//             e.preventDefault();                
//         });
			
		$('#new_account, #dropdown').click(function() {
			jQuery('#form_one').show();
		});
			
		/*$(document).mouseup(function(){
		    jQuery("#form_one").hide();
		});*/
        jQuery('.dropdown-toggle').on('click', function(){
        jQuery('div#form_one').toggleClass('form_toggle');
});
    });
	
    // $(function () {
    // $(".grid").sortable({
    //         tolerance: 'pointer',
    //         revert: 'invalid',
    //         forceHelperSize: true
    //     });
    // });
	
    jQuery(document).ready(function () {
        jQuery('.favorite').click(function () {
            console.log(jQuery(this).text());
            if (jQuery(this).text() == 'VERWIJDER') {
                jQuery(this).removeClass('active');
                jQuery(this).html('<span>VOEG TOE</span>');
            } else {
                jQuery(this).addClass('active');
                jQuery(this).html('<span>VERWIJDER</span>');
            }
        });
    });

</script>
<script>
function allowDrop(ev) {
  ev.preventDefault();  
}

function drag(ev) {   
  ev.dataTransfer.setData('dragged-image', ev.target.id);  
}

function drop(ev) {
  ev.preventDefault();
  var data = ev.dataTransfer.getData('dragged-image');
  ev.target.append(document.getElementById(data)); 
  var get_dataset = document.getElementById(data).dataset.wrapper_image_meta;
  const obj = JSON.parse(get_dataset);
  var sethtml = '<div class="favorite_details_title text-center">\n\
                    <strong class="h4 mr-jonas">'+obj.post_title+'</strong>\n\
                </div>\n\
                <div class="favorite_details_content">\n\
                    <p>'+obj.art_kunstenaar_name+'</p>\n\
                    <p>'+obj.image_size+'</p>\n\
                    <p>'+obj.monthly_price+' PER MAAND</p>\n\
                </div>\n\
                <div class="delet_btn">\n\
                    <span><img src="'+obj.delete_img_url+'"></span>\n\
                    <a href="javascript:;" id="company-clear-cart" class="company-clear-cart">'+obj.delete_img_text+'</a>\n\
                </div>';
    document.getElementById('favorite-details').innerHTML = sethtml;
    document.getElementById('company-add-employee').dataset.company_frame_details = get_dataset;
    document.getElementById('company-add-employee').dataset.company_frame_id = obj.post_id;
}
</script>