(function ($) {
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

    /* Jquery for resgister */
    $(document).ready(function () {
        $('.crm_signup_btn').on('click', function (e) {
            e.preventDefault();

            var fname = jQuery('.kucrm_register_form input[name="vooornaam"]').val();
            var lname = jQuery('.kucrm_register_form input[name="achternaam"]').val();
            var company = jQuery('.kucrm_register_form input[name="organisatie"]').val();
            var phone = jQuery('.kucrm_register_form input[name="telefoonnummer"]').val();
            var street_name = jQuery('.kucrm_register_form input[name="straatnaam"]').val();
            var postcode = jQuery('.kucrm_register_form input[name="postcode"]').val();
            var city = jQuery('.kucrm_register_form input[name="woonplaats"]').val();
            var email = jQuery('.kucrm_register_form input[name="emailadres"]').val();
            var password = jQuery('.kucrm_register_form input[name="wachtwoord"]').val();
            var c_password = jQuery('.kucrm_register_form input[name="bevestig_wachtwoord"]').val();
            var error = 0;

            jQuery('.kucrm_register_form .kucrm_loader').show();
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: kucrm_ajax_object.ajax_url,
                data: {
                    'action': 'kucrm_ajaxregister',
                    'emailadres': jQuery('.kucrm_register_form input[name="emailadres"]').val(),
                    'wachtwoord': jQuery('.kucrm_register_form input[name="wachtwoord"]').val(),
                    'bevestig_wachtwoord': jQuery('.kucrm_register_form input[name="bevestig_wachtwoord"]').val(),
                    'organisatie': jQuery('.kucrm_register_form input[name="organisatie"]').val(),
                    'vooornaam': jQuery('.kucrm_register_form input[name="vooornaam"]').val(),
                    'straatnaam': jQuery('.kucrm_register_form input[name="straatnaam"]').val(),
                    'postcode': jQuery('.kucrm_register_form input[name="postcode"]').val(),
                    'woonplaats': jQuery('.kucrm_register_form input[name="woonplaats"]').val(),
                    'achternaam': jQuery('.kucrm_register_form input[name="achternaam"]').val(),
                    'telefoonnummer': jQuery('.kucrm_register_form input[name="telefoonnummer"]').val(),
                    'reg_user_type': jQuery('.kucrm_register_form input[name="user_type"]').val(),
                    'reg_user_parent': jQuery('.kucrm_register_form input[name="user_parent"]').val()

                },

                success: function (data) {
                    //console.log(data); return false;
                    jQuery('.kucrm_register_form .kucrm_loader').hide();
                    var string1 = JSON.stringify(data);
                    const obj = JSON.parse(string1);


                    $('.kucrm_register_form .kucrm-message-wrapper').remove();
                    $('.kucrm_register_form .form-group input').removeClass('kucrm_error');

                    if ($.isArray(obj)) {
                        $.each(obj, function (i, field) {

                            if (field.status == 'error') {
                                $('[name="' + field.field_key + '"]').addClass('kucrm_error');
                                if (field.message != '') {
                                    $('[name="' + field.field_key + '"]').after('<span class="' + field.field_key + '-error kucrm-message-wrapper" id="' + field.field_key + '-error">' + field.message + '</span>');
                                }
                            } else {
                                $('[name="' + field.field_key + '"]').removeClass('kucrm');
                                $('#' + field.field_key + '-error').remove();
                                $('#' + field.field_key + '-error').empty();

                            }
                        });
                    } else {
                        jQuery('.kucrm_register_form .kucrm_signup_error_msg').show();
                        jQuery('.kucrm_register_form .kucrm_signup_error_msg .alert').removeClass('alert-error');
                        jQuery('.kucrm_register_form .kucrm_signup_error_msg .alert').addClass('alert-success');
                        jQuery('.kucrm_register_form .kucrm_signup_error_msg .alert').text(data.message);
                        jQuery('.kucrm_register_form .kucrm_signup_error_msg').delay(5000).fadeOut();

                        jQuery(".kucrm_register_form")[0].reset();
                        setTimeout(function () {
                            jQuery('#sign-up').hide();
                        }, 3000);
                        setTimeout(function () {
                            jQuery('#sign-up-complete').show();
                        }, 2500);
                    }

                }
            });
        });
    });


    $(document).ready(function () {
        $('.rent_year').on('change', function (e) {
            e.preventDefault();
            let year = $('#rent_private_year :selected').text();
            let divs = $('#rentInvoiceTab').children();
            //hide all childrens
            divs.hide();
            //show selected year
            $('#rentInvoiceTab #' + year).show();
        });
        let divs = $('#rentInvoiceTab').children();
        //hide all childrens
        divs.hide();
        divs.first().show();
    });

    $(document).ready(function () {
        $('.sale_year').on('change', function (e) {
            e.preventDefault();
            let year = $('#sale_private_year :selected').text();
            let divs = $('#saleInvoiceTab').children();
            //hide all childrens
            divs.hide();
            //show selected year
            $('#saleInvoiceTab #' + year).show();
        });
        let divs = $('#saleInvoiceTab').children();
        //hide all childrens
        divs.hide();
        divs.first().show();
    });
   $(document).ready(function () {
        $('.inventoryDetails').on('click', function (e) {
            e.preventDefault();
            //get id of the clicked element
            var id = $(this).attr('id');
            //redirect to the url
            console.log(window.location.href+'my-inventory/?id='+id);
            window.location.href =window.location.href+'my-inventory/?id='+id;
            //console.log(id);
        });
    });

    $(document).ready(function () {
        $('.rent_agreement_year').on('change', function (e) {

            e.preventDefault();
            let year = $('#rent_agreement_year_2 :selected').text();
            let divs = $('#rentAgreementTab').children();
            //hide all childrens
            divs.hide();
            //show selected year
            $('#rentAgreementTab #' + year).show();
        });
        let divs = $('#rentAgreementTab').children();
        //hide all childrens
        divs.hide();
        divs.first().show();
    });

$(document).ready(function () {
	$("#small-image").on('click', function (e) {
            	e.preventDefault();
		var src_value = $("#small-image-src").attr('src');
		$("#large-image ").attr('src',src_value);
// add scroller to modal
        $('#large-image').wrap('<div class="img-preview-scroller"></div>');
        $('#large-image').on('click', function (e) {
            e.preventDefault();
            $('#large-image').toggleClass('zoom');
        }
        );
        
    

	});
});


    /*jquery for update Password*/
    $(document).ready(function () {
        $('.kucrm_update_password').on('click', function (e) {
            e.preventDefault();
           var current_password = jQuery('.kucrm_account_password_update input[name="old_password"]').val();
              var new_password = jQuery('.kucrm_account_password_update input[name="new_password"]').val();
                var confirm_password = jQuery('.kucrm_account_password_update input[name="c_new_password"]').val();
                // jQuery('.kucrm_account_password_update .kucrm_company_loader').show();
            // if (current_password == '') {
            //     jQuery('.kucrm_account_password_update input[name="old_password"]').addClass('kucrm_error');
            //     jQuery('.kucrm_account_password_update input[name="old_password"]').after('<span class="old_password-error kucrm-message-wrapper" id="old_password-error">Vul uw huidige wachtwoord in</span>');
            // } else {
            //     jQuery('.kucrm_account_password_update input[name="old_password"]').removeClass('kucrm_error');
            //     jQuery('#old_password-error').remove();
            // }
            // if (new_password == '') {
            //     jQuery('.kucrm_account_password_update input[name="new_password"]').addClass('kucrm_error');
            //     jQuery('.kucrm_account_password_update input[name="new_password"]').after('<span class="new_password-error kucrm-message-wrapper" id="new_password-error">Vul uw nieuwe wachtwoord in</span>');
            // } else {
            //     jQuery('.kucrm_account_password_update input[name="new_password"]').removeClass('kucrm_error');
            //     jQuery('#new_password-error').remove();
            // }
            // if (confirm_password == '') {
            //     jQuery('.kucrm_account_password_update input[name="c_new_password"]').addClass('kucrm_error');
            //     jQuery('.kucrm_account_password_update input[name="c_new_password"]').after('<span class="c_new_password-error kucrm-message-wrapper" id="c_new_password-error">Vul uw nieuwe wachtwoord nogmaals in</span>');
            // } else {
            //     jQuery('.kucrm_account_password_update input[name="c_new_password"]').removeClass('kucrm_error');
            //     jQuery('#c_new_password-error').remove();
            // }
            if (current_password != '' && new_password != '' && confirm_password != '') {
                jQuery.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: kucrm_ajax_object.ajax_url,
                    data: {
                        'action': 'kucrm_update_password',
                        'current_password': current_password,
                        'new_password': new_password,
                        'confirm_password': confirm_password,
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.status == 'success') {
			jQuery('#alertSuccessMessage').show();
                            jQuery('#alertSuccessMessage').text(data.message);
                           
                             jQuery(".kucrm_account_password_update")[0].reset();
                        } else {
				jQuery('#alertErrorMessage').show();
                            jQuery('#alertErrorMessage').text(data.message);
                        }
                    }
                });
            }
            else{
                console.log('error');
            }
        });
    });
    /*jquery for update Password*/

    /* Jquery for login */
    $(document).ready(function () {

        // jQuery('.kucrm_login_btn').click(function(e){
        $('.kucrm_login_btn').on('click', function (e) {

            e.preventDefault();

            var uname = jQuery('form input[name="kucrm_user_login"]').val();
            var pwd = jQuery('form input[name="kucrm_user_password"]').val();

            jQuery('#kucrm_user_login-error').remove();
            jQuery('#kucrm_user_password-error').remove();
            if (uname.length == 0) {
                jQuery('form input[name="kucrm_user_login"]').addClass('input-error');
                jQuery('form input[name="kucrm_user_login"]').after('<span class="kucrm_user_login-error kucrm-message-wrapper" id="kucrm_user_login-error">Voer e-mailadres in.</span>');
            } else {
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                var result = regex.test(uname);
                if (result == false) {
                    jQuery('form input[name="kucrm_user_login"]').addClass('input-error');
                    jQuery('form input[name="kucrm_user_login"]').after('<span class="kucrm_user_login-error kucrm-message-wrapper" id="kucrm_user_login-error">Vul alstublieft een geldig e-mailadres in.</span>');
                    uname = '';
                } else {
                    jQuery('form input[name="kucrm_user_login"]').removeClass('input-error');
                }
            }
            if (pwd.length == 0) {
                jQuery('form input[name="kucrm_user_password"]').addClass('input-error');
                jQuery('form input[name="kucrm_user_password"]').after('<span class="kucrm_user_password-error kucrm-message-wrapper" id="kucrm_user_password-error">Voer wachtwoord in alstublieft.</span>');
            } else {
                jQuery('form input[name="kucrm_user_password"]').removeClass('input-error');
            }

            if (uname.length == 0 || pwd.length == 0) {
                return false;
            } else {

                jQuery('.kucrm_login_form .kucrm_loader').show();
                jQuery.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: kucrm_ajax_object.ajax_url,
                    data: {
                        'action': 'kucrm_ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                        'username': jQuery('.kucrm_login_form input[name="kucrm_user_login"]').val(),
                        'password': jQuery('.kucrm_login_form input[name="kucrm_user_password"]').val(),
                        //'rememberme': jQuery('form input[name="kucrm_rememberme"]').val()
                    },
                    success: function (data) {
                        jQuery('.kucrm_login_form .kucrm_loader').hide();
                        if (data.loggedin == true) {
                            jQuery('.kucrm_login_form .kucrm_response_msg').show();
                            jQuery('.kucrm_login_form .kucrm_response_msg .alert').addClass('alert-success');
                            jQuery('.kucrm_login_form .kucrm_response_msg .alert').text(data.message);
                            jQuery('.kucrm_login_form .kucrm_response_msg').delay(1000).fadeOut();
                            //location.reload();
                            //console.log(window.location.origin);
                            //var url = window.location.origin;

                            /*setTimeout(function() {
                                window.location.href = url + "/kunstuitleen-my-account/";
                            }, 3000);*/
                            if (data.redirect_url != '') {
                                setTimeout(function () {
                                    window.location.href = data.redirect_url;
                                }, 3000);
                            }
                        } else {
                            jQuery('.kucrm_login_form .kucrm_response_msg').show();
                            jQuery('.kucrm_login_form .kucrm_response_msg .alert').addClass('alert-error');
                            jQuery('.kucrm_login_form .kucrm_response_msg .alert').text(data.message);
                            jQuery('.kucrm_login_form .kucrm_response_msg').delay(5000).fadeOut();
                        }
                    }
                });
            }
        });
    });

    /* Jquery for Resetpassword */
    $(document).ready(function () {

        // jQuery('.kucrm_login_btn').click(function(e){
        $('.lostpassword-button').on('click', function (e) {
            e.preventDefault();

            jQuery('.lostpasswordform .kucrm_loader').show();
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: kucrm_ajax_object.ajax_url,
                data: {
                    'action': 'kucrm_ajax_resetpassword', //calls wp_ajax_nopriv_ajaxlogin
                    'username': jQuery('.lostpasswordform input[name="user_login"]').val(),
                    //'rememberme': jQuery('form input[name="kucrm_rememberme"]').val()
                },
                success: function (data) {
                    console.log(data.message);
                    jQuery('.lostpasswordform .kucrm_loader').hide();
                    jQuery('#user_login-error').remove();
                    jQuery('.lostpasswordform input[name="user_login"]').removeClass('form-group kucrm_error');
                    if (data.loggedin == true) {
                        //jQuery('#login').hide();
                        jQuery('.lostpasswordform .kucrm_response_msg').show();
                        jQuery('.lostpasswordform .kucrm_response_msg .alert').addClass('alert-success');
                        jQuery('.lostpasswordform .kucrm_response_msg .alert').text(data.message);
                        //jQuery('.lostpasswordform .kucrm_response_msg').delay(1000).fadeOut();
                        setTimeout(function () {
                            jQuery('#forget-pass').hide();
                            jQuery('#confirm').show();
                            jQuery('.lostpasswordform .kucrm_response_msg .alert').text('');
                            jQuery('.lostpasswordform .kucrm_response_msg').hide();
                        }, 1000);
                        // location.reload();
                    } else {
                        jQuery('.lostpasswordform .kucrm_response_msg').hide();
                        jQuery('.lostpasswordform .kucrm_response_msg .alert').removeClass('alert-success');
                        jQuery('.lostpasswordform .kucrm_response_msg .alert').text('');
                        jQuery('.lostpasswordform input[name="user_login"]').addClass('form-group kucrm_error');
                        //jQuery('.lostpasswordform .kucrm_response_msg .alert').text(data.message);
                        jQuery('.lostpasswordform input[name="user_login"]').after('<span class="user_login-error kucrm-message-wrapper" id="user_login-error">' + data.message + '</span>');
                        //jQuery('form#kucrm_login_form .kucrm_response_msg').delay(10000).fadeOut();
                    }
                }
            });
        });

        $('.update_password_button').on('click', function (e) {
            e.preventDefault();
            alert("clicked");
            jQuery('.update_password_form .kucrm_loader').show();
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: kucrm_ajax_object.ajax_url,
                data: {
                    'action': 'kucrm_ajax_update_password', //calls wp_ajax_nopriv_ajaxlogin
                    'new_password': jQuery('.update_password_form input[name="new_password"]').val(),
                    'confirm_password': jQuery('.update_password_form input[name="confirm_password"]').val(),
                    'user_id': jQuery('.update_password_form input[name="user_id"]').val(),
                },
                success: function (data) {
                    console.log(data.message);
                    jQuery('.update_password_form .kucrm_loader').hide();
                    if (data.loggedin == true) {
                        jQuery('#new_password').val('');
                        jQuery('#confirm_password').val('');
                        jQuery('.update_password_form .kucrm_response_msg').show();
                        jQuery('.update_password_form .kucrm_response_msg .alert').addClass('alert-success');
                        jQuery('.update_password_form .kucrm_response_msg .alert').text(data.message);
                        jQuery('.update_password_form .kucrm_response_msg').delay(1000).fadeOut();
                        // location.reload();
                    } else {
                        jQuery('.update_password_form .kucrm_response_msg').show();
                        jQuery('.update_password_form .kucrm_response_msg .alert').addClass('alert-error');
                        jQuery('.update_password_form .kucrm_response_msg .alert').text(data.message);
                        //jQuery('form#kucrm_login_form .kucrm_response_msg').delay(10000).fadeOut();
                    }
                }
            });
        });
        $(document).mouseup(function (e) {
            if ($(e.target).closest("#form_one").length === 0) {
                $("#form_one").removeClass('form_toggle').hide();
            }
            jQuery('.dropdown-toggle').on('click', function () {
                jQuery('div#form_one').toggleClass('form_toggle');
            });
        });
    });
})(jQuery);