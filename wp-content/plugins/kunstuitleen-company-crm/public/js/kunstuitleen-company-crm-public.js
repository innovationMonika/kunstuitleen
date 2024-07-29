(function($) {
    'use strict';

    /**
     * All of the code for your public-facing JavaScript source
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
    $(document).ready(function() {
        $('#reg_search_value').select2();
        $('.company_user_register').on('click', function(e) {
            e.preventDefault();
            jQuery('.kucrm_company_register_form .kucrm_company_loader').show();
            var search_value = jQuery(".kucrm_company_register_form option:selected").val();
           var selected = [];
            var selected_data = '';
            $("#reg_search_value :selected").map(function(i, el) {
                if( $(el).val() != '' ){
                    selected.push($(el).val());
                }               
            }).get();            
            if(selected.length === 0 ){
                selected_data = '';
            }else{
                selected_data = selected;
            } 
            jQuery.ajax({
                type: 'POST',
                //dataType: 'json',
                url: kucrm_ajax_object.ajax_url,
                data: {
                    'action': 'kucrm_company_ajaxregister',
                    'reg_fname': jQuery('.kucrm_company_register_form input[name="reg_fname"]').val(),
                    'reg_lname': jQuery('.kucrm_company_register_form input[name="reg_lname"]').val(),
                    'reg_phone': jQuery('.kucrm_company_register_form input[name="reg_phone"]').val(),
                    'reg_department': jQuery('.kucrm_company_register_form input[name="reg_department"]').val(),
                    'reg_email': jQuery('.kucrm_company_register_form input[name="reg_email"]').val(),
                    'reg_search_value': selected_data,
                    'reg_user_type': jQuery('.kucrm_company_register_form input[name="reg_user_type"]').val(),
                    'reg_user_parent': jQuery('.kucrm_company_register_form input[name="reg_user_parent"]').val(),
                    'user_myaccount_update': jQuery('.kucrm_company_register_form input[name="user_myaccount_update"]').val(),
                    'user_id': jQuery('.kucrm_company_register_form input[name="user_id"]').val(),

                },

                        success: function(res) {
                        jQuery('.kucrm_company_register_form .kucrm_company_loader').hide(); 
                        $('.kucrm_company_register_form .form-group input').removeClass('kuerror');
                        $('.kucrm_company_register_form .kuerror-message-wrapper').remove();                   
                        const obj = JSON.parse(res);                                            
                        if($.isArray(obj)){                         
                            $.each( obj, function( i, field ){                                
                                if( field.status == 'error' ){
                                   $('[name="'+field.field_key+'"]').removeClass('kuerror');
                                    $('#'+field.field_key+'-error').remove();                                   
                                    $('[name="'+field.field_key+'"]').addClass('kuerror');
                                    if( field.message != '' ){
                                        if( field.field_key == 'reg_search_value' ){
                                            $('#'+field.field_key).after('<span class="'+field.field_key+'-error kuerror-message-wrapper" id="'+field.field_key+'-error">'+field.message+'</span>');
                                        }else{  
                                            if( field.field_key == 'reg_search_value' ){
                                                $('#'+field.field_key).removeClass('kuerror');
                                                $('#'+field.field_key).remove();
                                            }  
                                            $('[name="'+field.field_key+'"]').after('<span class="'+field.field_key+'-error kuerror-message-wrapper" id="'+field.field_key+'-error">'+field.message+'</span>');
                                        }
                                    }
                                }else{                                   
                                    $('[name="'+field.field_key+'"]').removeClass('kuerror');
                                    $('#'+field.field_key+'-error').remove();
                                }
                            });
                        }else{
                             $('.kucrm_company_register_form .form-group input').removeClass('kuerror');
                            $('.kucrm_company_register_form .kuerror-message-wrapper').remove();  
                            if( obj.status == 'success' ){
                                $('#kucrm-company-register-form').after('<div class="alert alert-success" role="alert" id="kucrm-company-register-form-message">'+obj.message+'</div>');
                                setTimeout(function(){
                                    $('#kucrm-company-register-form-message').remove();
                                    window.location.reload();
                                }, 1000);                               
                            }else{
                                $('#kucrm-company-register-form').after('<div class="alert alert-danger" role="alert" id="kucrm-company-register-form-message">'+obj.message+'</div>');
                                setTimeout(function(){
                                    $('#kucrm-company-register-form-message').remove();
                                    window.location.reload();
                                }, 1000);
                            }
                        } 
                }
            });
        });

         /**
         * Kunstuitleen company details
         */
         $('#mailing-address').on( 'click', function(){
            if($(this).prop("checked") == true){
               $(this).val('on');
            }
            else if($(this).prop("checked") == false){
               $(this).val('off');
            }
        });
         /**
         * Kunstuitleen company details
         */
         $('#company-details').on('click', function(e){
            e.preventDefault(); 
            $(this).attr('disabled', 'disabled');
            var form_id = $(this).closest('form').attr('id');           
            var form_data = $('#'+form_id).serialize();
            var form_data_check = $('#'+form_id).serializeArray();          
            var error = 0;
            var message = '';
            var data = [];          
                if( error == 0 ) {
                $.ajax({
                     url: kunstuitleen_company_crm_public_ajax_object.ajax_url,
                     type: 'post',
                     data: {
                         action  : 'kunstuitleen_company_details_form_ajax',
                         form_data  : form_data,
                     },
                     beforeSend: function() {                                
                         $("#"+form_id+" .kucrm_company_loader").show();                           
                     },
                     success: function(res) {  
                           $('#company-details').removeAttr('disabled');
                           $("#"+form_id+" .kucrm_company_loader").hide();
                           $('#company-details-form .kuerror-message-wrapper').remove();
                        $('#company-details-form .form-group input').removeClass('kuerror');
                            const obj = JSON.parse(res);                                            
                         if($.isArray(obj)){                         
                            $.each( obj, function( i, field ){
                                if( field.status == 'error' ){
                                   $('[name="'+field.field_key+'"]').removeClass('kuerror');
                                    $('#'+field.field_key+'-error').remove();                                   
                                    $('[name="'+field.field_key+'"]').addClass('kuerror');
                                    if( field.message != '' ){
                                        $('[name="'+field.field_key+'"]').after('<span class="'+field.field_key+'-error kuerror-message-wrapper" id="'+field.field_key+'-error">'+field.message+'</span>');
                                    }
                                }else{
                                    $('[name="'+field.field_key+'"]').removeClass('kuerror');
                                    $('#'+field.field_key+'-error').remove();
                                }
                            });
                         }else{
                            $('#company-details-form-message').remove();
                            if( obj.status == 'success' ){
                                $('#'+form_id).after('<div class="alert alert-success" role="alert" id="company-details-form-message">'+obj.message+'</div>');
                                setTimeout(function(){
                                    $('#company-details-form-message').remove();
                                    window.location.reload();
                                }, 1000);                               
                            }else{
                                $('#'+form_id).after('<div class="alert alert-danger" role="alert" id="company-details-form-message">'+obj.message+'</div>');
                                setTimeout(function(){
                                    $('#company-details-form-message').remove();
                                    window.location.reload();
                                }, 1000);
                            }
                         }                       
                     }
                 });
            }
         });
        
        jQuery('.artwork_email_btn').on('click', function(e) {
            e.preventDefault();
            var colleagues = [];
           /* jQuery.each(jQuery("input[name='colleagues_mail']:checked"), function() {
                colleagues.push(jQuery(this).val());
            });*/

            var colleagues = $("#email_js_select2 :selected").map((_, e) => e.value).get();
            console.log(colleagues);
            jQuery('.my_artworks_form .kucrm_company_loader').show();
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: kucrm_ajax_object.ajax_url,
                data: {
                    'action': 'kucrm_company_artwork_ajax',
                    //'reg_uname'    : jQuery('.my_artworks_form input[name="gebruikersnaam"]').val(),
                    'colleagues_mail': colleagues,


                },
                
                success: function(data) {
                    jQuery('.my_artworks_form .kucrm_company_loader').hide();
                    
                    if (data.status == 'success') {
                        
                        jQuery('.my_artworks_form .kucrm_company_signup_error_msg').show();
                        jQuery('.my_artworks_form .kucrm_company_signup_error_msg .alert').addClass('alert-success');
                        jQuery('.my_artworks_form .kucrm_company_signup_error_msg .alert').text(data.message);
                        jQuery('.my_artworks_form .kucrm_company_signup_error_msg').delay(2500).fadeOut();

                        jQuery(".my_artworks_form")[0].reset();
                        setTimeout(function() {
                             jQuery('#email_send').hide().delay(3000).fadeOut();
                            jQuery('#confirm_email_send').show().delay(3000).fadeIn();
                        }, 3000);
                    } else {
                        jQuery('.my_artworks_form .kucrm_company_signup_error_msg').show();
                        jQuery('.my_artworks_form .kucrm_company_signup_error_msg .alert').addClass('alert-error');
                        jQuery('.my_artworks_form .kucrm_company_signup_error_msg .alert').text(data.message);
                        // jQuery('form#kucrm_company_register_form .kucrm_company_signup_error_msg').delay(5000).fadeOut();
                    }
                }
            });
        });
        jQuery('.art-block .share-btn a.art_work_modal').on('click', function(){
            jQuery('.modal_main_div').toggleClass('modal_data_content');
        }); 
         jQuery('#email_close_btn').on('click', function(e){
            e.preventDefault();
            jQuery('.modal_main_div').removeClass('modal_data_content');
            jQuery('#email_send').css('display', 'block');
            jQuery('#confirm_email_send').css('display', 'none');
      });

         $("#email_js_select2").select2({
            closeOnSelect : false,
            placeholder : "Please select an email",
            allowHtml: true,
            allowClear: true,
            tags: false 
        });
        
        /**
         * Company-art-favorite.php
         * Cart show
         */
        $('#company-art-favroite-cart-show').on('click', function(){
            if($('#company-art-favroite-cart').hasClass('company-art-favroite-display-none')){
                $('#company-art-favroite-cart').removeClass('company-art-favroite-display-none');
            }else{
                $('#company-art-favroite-cart').addClass('company-art-favroite-display-none');
            }
        });

        /*$('#company-clear-cart').on('click', function(){
            console.log('Hello');
        });*/

        $('#fav_option').on('change', function(){
            var optval = $(this).val();
            if( optval != '' ){
                $('#company-add-employee').attr('data-company-employee-id', optval);
            }else{
                $('#company-add-employee').removeAttr('data-company-employee-id');
            }
        });
    });
})(jQuery);