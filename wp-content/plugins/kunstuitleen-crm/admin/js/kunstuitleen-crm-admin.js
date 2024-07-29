(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$( document ).ready(function() {

           jQuery("#btnQueryString").on('click',function(e){
           	e.preventDefault();
           	var checked_val = ''; 
            var ids_array = [];
            var arr = '';
           	jQuery('[name="users[]"]:checked').each(function(){
            checked_val = jQuery(this).val();
            ids_array.push(checked_val);
            
            });     
          var crm_user_status = $('#crm_user_status').find(":selected").val();	
	        jQuery.ajax({
	        type: 'POST',
	        dataType: 'json',
	        url: kucrm_ajax_object.ajax_url,
	        data: { 
	            'action': 'kucrm_user_status_update_ajax', //calls wp_ajax_nopriv_ajaxlogin
	            'ids_arr'  : ids_array,
	            'crm_user_status'  : crm_user_status,
	            
	        },          
	        success: function(data){
	        	
	        	if (data.status == true){
	                location.reload();
	            }
	        }
	      });
        });
                       
    });
})( jQuery );
