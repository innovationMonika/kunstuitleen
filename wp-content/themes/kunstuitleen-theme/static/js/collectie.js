$(window).load(function(){
    
    /*
     * Vars
     */
    var js_settings = myLocalized.settings;
    var webVariant = js_settings.webVariant; //Cookies.get('kunstuitleenVariant');
    var favorieten = js_settings.favorieten;
    
    if( $('#preselect_client_code').length > 0 && $('#preselect_client_id').length > 0 ){
        var favorieten_cookie_name = 'favorieten-preselect-'+$('#preselect_client_code').val();    
    } else {
        var favorieten_cookie_name = 'favorieten'+webVariant;        
    }
    
    /*
     * Functions
     */ 
     
    
    
     
    // Get all values from the FORM, if the value is empty, remove it from string
    function customGetAllVars(clickedVal){
        
        // Get values from FORM
        var urlGET = $('#filters form#filter').serialize();
        
        // Split URL Parameters into an Array
        var urlParameters = urlGET.split('&');
        var removeParams = [], param;
        
        // Reverse Loop ( last to first)
        for(var i = urlParameters.length -1; i >= 0; i--){
            param = urlParameters[i].split('=');
            if( !param[1] ){ urlParameters.splice(i, 1);  }
        }
        
        //Join array to string with &
        return urlParameters.join('&');
    }
    
    // GET VARS FROM URL
    function getUrlVars(){
        
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        
        for(var i = 0; i < hashes.length; i++){
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        
        return vars;
    }
    
    
    /* Add backto param to url onClick detailpage */
    function detailPageBackLink(){
    
        $('.art a').off().on('click', function(e){
            e.preventDefault();
            
            var redirect_url = $(this).attr('href');
            var art_id = $(this).closest('.art').attr('id');
            var current_url = window.location.href;
    
            
            if ( current_url.indexOf("backto=") >= 0 ){
                
                // Backto exists
                var backTo = getUrlVars()["backto"];
                var new_url = current_url.replace(backTo, art_id);
            } else {
                
                // Backto doesn't exist yet
                if ( current_url.indexOf("?") >= 0 ){
                    var new_url = current_url + '&backto=' + art_id;   
                } else {
                    var new_url = current_url + '?backto=' + art_id;
                }
            }
    
    
            history.pushState({ foo: "bar" }, "BackTo", new_url);
            window.location.href = redirect_url;
            
            return false;
        });
    
    }
    
    detailPageBackLink();
    
    /* Reset button */
    $('.reset').on('click', function(e){
        e.preventDefault();
        Cookies.remove(favorieten_cookie_name, { path: '/' });
        var url = $(this).attr('href');
        url = url.replace('#', '');
        window.location.href = url;
    });

    $('.frm_final_submit').attr("type","button");
    $('.frm_final_submit').on('click', function(e){
        e.preventDefault();
        // remove label 
        $('#errorMessage').remove();
        //get all values from the FORM
        let voornaam = $('#field_2hguor3').val();
        let achternaam = $('#field_6v7a9m5').val();
        let straatnaam = $('#field_tk5mu').val();
        let postcode = $('#field_qrb1b').val();
        // let radio = $('#frm_radio_100-0').val();
        let radio = $('input[name="item_meta[100]"]:checked').val();
        let woonplaats = $('#field_8dbxnx5').val();
        let telefoonnummer = $('#field_14jjjj5').val();
        let email = $('#field_984fwo5').val();
        let bericht = $('#field_4degfl5').val();
        let inventoryIds = $('#inventoryArr').val();
let webType = $('#pageType').val();
        //seperate inventoryIds by comma
        let inventoryIdsArr = inventoryIds.split(',');
        // check all these field is not ''
        if(voornaam != '' && achternaam != '' && straatnaam != '' && postcode != '' && woonplaats != '' && telefoonnummer != '' && email != '' ){

        var fd=new FormData();
        fd.append('first_name', voornaam);
        fd.append('last_name', achternaam);
        fd.append('street', straatnaam);
        fd.append('postal_code', postcode);
        fd.append('radio', radio);
        fd.append('city', woonplaats);
        fd.append('phone', telefoonnummer);
        fd.append('email', email);
        fd.append('message', bericht);
	fd.append('type',webType);
        fd.append('inventoryIds', inventoryIdsArr);
       // console.log(fd)
        $.ajax({
            url:"https://k-crm.agile-steps.com/api/create-Trial-Request",
            type:"POST",
            data:fd,
            contentType:false,
            processData:false,
            success:function(data){
                $('.frm_final_submit').attr("type","submit");
                    $('#form_v3tom924 .frm_final_submit').submit();
                
            }
          });
        }
        else{
            //show error message
           //add label in div without removing the existing elements
              $('#frm_field_164_container').after('<label class="error" id="errorMessage" style="color:red;" for="field_2hguor3"><strong>Velden mogen niet leeg zijn.</strong></label>');
        }
    });


    $('#filtersSearch .filter-search input').keydown(function(e){
            if(e.which == 13) {
               $('#filters form').submit();
            }
        });

    // Refresh the favorite list, check if some favorite art has removed by the daily feed
    if( favorieten.refresh == true ){ 
        
        if( favorieten.list.length > 0 ) {

            $('#top .favorieten').text(favorieten.list.length).removeClass('animated').addClass('animated');
            Cookies.set(favorieten_cookie_name, JSON.stringify(refreshFavorite), { expires: 30, path: '/' });
            
            //window.clearTimeout();
            //window.setTimeout(function(){ $('#top .favorieten').removeClass('animated').addClass('active'); }, 5000);
            window.location.reload();
    
        } else {
            
            //No favorites
            $('#top .favorieten').text('0').removeClass('active');
            Cookies.remove(favorieten_cookie_name, { path: '/' });
            
        }
        
    }
 
    if($('#filters').length != 0){

        $('#filters select').on('change', function(){
        	$('#filters form').submit();
    	}); 
        $('#filters input').on('change', function(){
            $('#filters form').submit();
        });
    	
    	$('#filters .filter-search input').keydown(function(e){
            if(e.which == 13) {
               $('#filters form').submit();
            }
        });
    	
        $('.filter-submit').on('click', function(){
            $('#filters form').submit();
        });
    }
    

    
    /* COOKIE - FAVORIETEN */
    
    function setFavoriteSelection(){
        if( $('span.favorite-selection-count').length != 0 ){
            
            var favorite = [];
            
            if(Cookies.get(favorieten_cookie_name) === undefined || Cookies.get(favorieten_cookie_name) === ''){} else {
                favorite = JSON.parse(Cookies.get(favorieten_cookie_name));    
            } 
            
            $('span.favorite-selection-count').html(favorite.length);
        }
    }
    
    
    function favorietenCookie() {       
        var favorite = [];
        setFavoriteSelection();
        
        $('.favorite').off('click').on('click', function(){            
            var clickedID = $(this).attr('id');
            var animateArrow = false;
            
            if(Cookies.get(favorieten_cookie_name) === undefined || Cookies.get(favorieten_cookie_name) === '' || Cookies.get(favorieten_cookie_name) == null ){} else {
                favorite = JSON.parse(Cookies.get(favorieten_cookie_name));  

            }

            /* if( jQuery(this).hasClass('.favorite-remove')){
                console.log('Hello');
                var get_ID = $('#'+clickedID).closest('article').attr('id');
                favorite_visible(get_ID);
            }*/
                   
            if( $(this).hasClass('active') ){          
                favorite = jQuery.grep(favorite, function(value) {
                  return value != clickedID;
                });                
                $(this).removeClass('active favorite-remove');               
                 //$('#'+clickedID).closest('article').remove();
                if( $(this).find('span').length != 0){ $(this).find('span').html('VOEG TOE'); }  
                var get_ID = $('#'+clickedID).closest('article').attr('id');
                $('.favorite-remove-'+get_ID).remove();              
                
            } else {
                favorite.push(clickedID);
                $(this).addClass('active favorite-remove');
                if( $(this).find('span').length != 0){ $(this).find('span').html('VERWIJDER'); }
                animateArrow = true;
            }
            
            if(favorite.length > 0) {
                
                //Has favorites 
                $('#top .favorieten').removeClass('animated').addClass('animated');
                $('#top .favorieten .favorieten-count').text(favorite.length);
/*
                
                if( animateArrow == true && $(window).width() > 767 ){
                    var arrowAnimateTop = $('#top .favorieten').outerHeight();
                    $('#top .favorieten-arrow').fadeIn().animate({ 'top': arrowAnimateTop, 'margin-left': '-25px', 'width': '50px' }, 500).fadeOut().css({ 'top': '75%', 'margin-left': '-100px', 'width': '200px' });
                }
*/

                Cookies.set(favorieten_cookie_name, JSON.stringify(favorite), { expires: 30, path: '/' });
                window.clearTimeout();
                window.setTimeout(function(){ $('#top .favorieten').removeClass('animated').addClass('active'); }, 2000);

                
            } else {
                //No favorites
                $('#top .favorieten').text('0').removeClass('active');
                Cookies.remove(favorieten_cookie_name, { path: '/' }); 
            }
            
            setFavoriteSelection();
    
        });   
    
    }
    
    favorietenCookie();
    
    /* END - COOKIE - FAVORIETEN */

    
    /* COLLECTIE - MASONRY */
    
    var masonryActivated = false;
    
    function activeMasonry(){
        
        if($(window).width() < 768 && masonryActivated == true ){
            
            $('#collectie .collectie').masonry( 'destroy' );
            masonryActivated = false;
            
        } 
    
        if($(window).width() > 767 && masonryActivated == false ){
            
            $('#collectie .collectie').imagesLoaded( function() {
                $('#collectie .collectie').masonry({
                    itemSelector: '.art',
                    columnWidth: '.art',
                    transitionDuration: 0
                });
            });
            
            masonryActivated = true;
            
        }
        
           
    }
    
    if($('#collectie .collectie').length != 0){
    
        activeMasonry();
        
        setTimeout(function() {
            
            var backTo = getUrlVars()["backto"];
        
            if( backTo ) {
        		
        		if( $('#'+backTo).length > 0 ){
            		var idPOS = $('#'+backTo).offset();
                    var scrollToID = idPOS.top - $('#'+backTo).outerHeight();
        		    $("html, body").animate({ scrollTop: scrollToID });
    		    }
            }
            
        }, 500);

    
    }
    
    /* END - COLLECTIE - MASONRY */
    
    /* COLLECTIE AJAX LOADING */
    
    /* Active Filters, if url has vars, set it */
    if( customGetAllVars() ) {
        
        activeFilters = customGetAllVars();
        Cookies.set('collectieFilters', JSON.stringify(activeFilters), { path: '/' });
        
        $('#top .favorieten').attr('href', $('#top .favorieten').attr('href')+'?filters=true');
        
    } else {
        
        if( $('#single-art').length != 1 ){
            Cookies.remove('collectieFilters', { path: '/' });
        }
    }
    
    /*****Strat ****/
    if($('#collectie.ajaxloading').length != 0){
        
        var loading = false;
        
        
        $(window).scroll(function() {
           
            var scrollTop = $(window).scrollTop() + $(window).height();
            var triggerLoad = $(document).height() - $('footer').outerHeight();
            //console.log('scrollTop:'+scrollTop);
            //console.log('triggerLoad:'+triggerLoad);
            if( scrollTop > triggerLoad) {
                
                if(loading == false){
                    
                    if(maxPages >= currentPage){
                        
                        loading = true;
                        $('.loading').slideDown();

                        var ajax_data = { action: "collectiePage", page: currentPage };
                        var ajax_filters = $('#filters form#filter').serializeArray();
                        
                        $.each(ajax_filters, function( index, value ) {
                            if( value.value.length > 0 ){
                                ajax_data[value.name] = value.value;
                            }
                        });
                        
                        if( typeof kunstenaarID != "undefined" ){
                            if( kunstenaarID != '' ){
                                ajax_data['kunstenaars'] = kunstenaarID;
                            }
                        }
                        
                                         
                        $.ajax({
                            type: "GET",
                            url: myLocalized.ajaxurl,
                            data : ajax_data,
                            dataType: "html",
                            success: function(result) {
                               
                               $("#collectie .collectie").append(result).imagesLoaded( function() {
                                    $("#collectie .collectie").masonry( 'reloadItems' ).masonry( 'layout' ); 
                                });
                                $('.loading').slideUp();
                                
                                currentPage = currentPage+1;
                                
                                Cookies.set('ajax_last_loaded_page', JSON.stringify(currentPage), { expires: 30, path: '/' });
                                
                                loading = false;

                                $('.collectie .favorite').unbind( "click" );
                                favorietenCookie();
                                detailPageBackLink();
                            }
                        });

                      
                        
                    } else {
                        $('.end-message').slideDown();
                    }
                }
           }
        });
    
    }

    /*****Strat favorieten-ajax ****/
    if($('#collectie.ajaxloading').length != 0){
        //console.log(maxPages);
        var loading = false;
        
        
        $(window).scroll(function() {
           
            var scrollTop = $(window).scrollTop() + $(window).height();
            var triggerLoad = ( $(document).height() - $('footer').outerHeight() ) / 2;
           /* console.log('total-height:'+$(document).height());
            console.log('outer-height:'+$('#favorieten-ajax-section').position().top);*/
           /* console.log('scroll:'+scrollTop);
            console.log('trigger:'+triggerLoad);*/
            
            if( scrollTop > triggerLoad) {
                
                if(loading == false){
                    
                    if(maxPages >= currentPage){
                        
                        loading = true;
                        $('.loading').slideDown();

                        var ajax_data = { action: "collectiePage", page: currentPage };
                        var ajax_filters = $('#filters form#filter').serializeArray();
                        
                        $.each(ajax_filters, function( index, value ) {
                            if( value.value.length > 0 ){
                                ajax_data[value.name] = value.value;
                            }
                        });
                        
                        if( typeof kunstenaarID != "undefined" ){
                            if( kunstenaarID != '' ){
                                ajax_data['kunstenaars'] = kunstenaarID;
                            }
                        }
                        
                                         
                        $.ajax({
                            type: "GET",
                            url: myLocalized.ajaxurl,
                            data : ajax_data,
                            dataType: "html",
                            success: function(result) {
                               
                               $("#collectie .collectie").append(result).imagesLoaded( function() {
                                    $("#collectie .collectie").masonry( 'reloadItems' ).masonry( 'layout' ); 
                                });
                                $('.loading').slideUp();
                                
                                currentPage = currentPage+1;
                                
                                Cookies.set('ajax_last_loaded_page', JSON.stringify(currentPage), { expires: 30, path: '/' });
                                
                                loading = false;

                                $('.collectie .favorite').unbind( "click" );
                                favorietenCookie();
                                detailPageBackLink();
                            }
                        });

                      
                        
                    } else {
                        $('.end-message').slideDown();
                    }
                }
           }
        });
    
    }
    /* END - COLLECTIE AJAX LOADING */
    
	$(window).resize(function() {
    	
    	if($('#collectie .collectie').length != 0){
        	$("#collectie .collectie").imagesLoaded( function() {
		        $("#collectie .collectie").masonry('reloadItems');
		    });
        }
    });

    $('#div1').on('click', function(){
        jQuery(window).scrollTop(700);
    });
    
});




function setFavoriteSelectionNew(favorieten_cookie_name){
        if( $('span.favorite-selection-count').length != 0 ){
            
            var favorite = [];
            
            if(Cookies.get(favorieten_cookie_name) === undefined || Cookies.get(favorieten_cookie_name) === ''){} else {
                favorite = JSON.parse(Cookies.get(favorieten_cookie_name));    
            } 
            
            $('span.favorite-selection-count').html(favorite.length);
        }
    }
    
    
    function favorietenCookienew(favorieten_cookie_name) {       
        var favorite = [];
        setFavoriteSelectionNew(favorieten_cookie_name);
        
        $('.favorite').off('click').on('click', function(){            
            var clickedID = $(this).attr('id');
            var animateArrow = false;
            
            if(Cookies.get(favorieten_cookie_name) === undefined || Cookies.get(favorieten_cookie_name) === '' || Cookies.get(favorieten_cookie_name) == null ){} else {
                favorite = JSON.parse(Cookies.get(favorieten_cookie_name));  

            }

            /* if( jQuery(this).hasClass('.favorite-remove')){
                console.log('Hello');
                var get_ID = $('#'+clickedID).closest('article').attr('id');
                favorite_visible(get_ID);
            }*/
                   
            if( $(this).hasClass('active') ){          
                favorite = jQuery.grep(favorite, function(value) {
                  return value != clickedID;
                });                
                $(this).removeClass('active favorite-remove');               
                 //$('#'+clickedID).closest('article').remove();
                if( $(this).find('span').length != 0){ $(this).find('span').html('VOEG TOE'); }  
                var get_ID = $('#'+clickedID).closest('article').attr('id');
                $('.favorite-remove-'+get_ID).remove();   
                $('#'+clickedID).removeClass('active favorite-remove');          
                
            } else {
                favorite.push(clickedID);
                $(this).addClass('active favorite-remove');
                if( $(this).find('span').length != 0){ $(this).find('span').html('VERWIJDER'); }
                animateArrow = true;
            }
            
            if(favorite.length > 0) {
                
                //Has favorites 
                $('#top .favorieten').removeClass('animated').addClass('animated');
                $('#top .favorieten .favorieten-count').text(favorite.length);
/*
                
                if( animateArrow == true && $(window).width() > 767 ){
                    var arrowAnimateTop = $('#top .favorieten').outerHeight();
                    $('#top .favorieten-arrow').fadeIn().animate({ 'top': arrowAnimateTop, 'margin-left': '-25px', 'width': '50px' }, 500).fadeOut().css({ 'top': '75%', 'margin-left': '-100px', 'width': '200px' });
                }
*/

                Cookies.set(favorieten_cookie_name, JSON.stringify(favorite), { expires: 30, path: '/' });
                window.clearTimeout();
                window.setTimeout(function(){ $('#top .favorieten').removeClass('animated').addClass('active'); }, 2000);

                
            } else {
                //No favorites
                $('#top .favorieten').text('0').removeClass('active');
                Cookies.remove(favorieten_cookie_name, { path: '/' }); 
            }
            
            setFavoriteSelectionNew(favorieten_cookie_name);
    
        });   
    
    }

function favorite_collective(e){
    var favorite_id =  jQuery(e).attr('id');
    var data_drag =  jQuery(e).attr('data_drag');
    if (data_drag == '1') {
         jQuery(e).html('<span>VOEG TOE</span>');
    }
       jQuery(e).attr('data_drag','0');
       var favorite_text = '';               
    if (jQuery(e).text() == 'VERWIJDER') {
        var favorite_text = 'VERWIJDER';
        jQuery(this).removeClass('active favorite-remove');
        jQuery(this).html('<span>VOEG TOE</span>');
    } 
    else {
        var favorite_text = 'VOEGTOE';
        jQuery(this).addClass('active favorite-remove');
        jQuery(this).html('<span>VERWIJDER</span>');
    }
    jQuery.ajax({
        url : collectie_public_ajax_object.ajax_url,
        data :  {
                    action : 'kstage_kstage_favorieten_collectie_ajax',
                    favorite_id : favorite_id,
                    favorite_text : favorite_text,
                },
        type : 'POST',
        success : function( response ) {                        
            if (response !='error') {
                jQuery('#favrate_collectie').html('');
                jQuery('#favrate_collectie').html(response);
                jQuery('#favrate_collectie .favorite').addClass('active favorite-remove');
                jQuery('#favrate_collectie .favorite').html('<span>VERWIJDER</span>');
                /*
     * Vars
     */
    var js_settings = myLocalized.settings;
    var webVariant = js_settings.webVariant; //Cookies.get('kunstuitleenVariant');
    var favorieten = js_settings.favorieten;
    
    if( jQuery('#preselect_client_code').length > 0 && jQuery('#preselect_client_id').length > 0 ){
        var favorieten_cookie_name = 'favorieten-preselect-'+jQuery('#preselect_client_code').val();    
    } else {
        var favorieten_cookie_name = 'favorieten'+webVariant;        
    }
                favorietenCookienew(favorieten_cookie_name);
                /*jQuery('.favorite.active.favorite-remove').on('click', function(){
                    jQuery(this).removeClass('active favorite-remove');
                    var clickedID = jQuery(this).attr('id');
                    var get_ID = $('#'+clickedID).closest('article').attr('id');
                    $('.favorite-remove-'+get_ID).remove();
                });*/
            }
            else{

            }
        }
    });

}

function favorite_collectie(){
    
    if(maxPages >= currentPage){
                        
            loading = true;
            $('.loading').slideDown();

            var ajax_data = { action: "collectiePage", page: currentPage };
            var ajax_filters = $('#filters form#filter').serializeArray();
            
            $.each(ajax_filters, function( index, value ) {
                if( value.value.length > 0 ){
                    ajax_data[value.name] = value.value;
                }
            });
            
            if( typeof kunstenaarID != "undefined" ){
                if( kunstenaarID != '' ){
                    ajax_data['kunstenaars'] = kunstenaarID;
                }
            }
            
                             
            $.ajax({
                type: "GET",
                url: myLocalized.ajaxurl,
                data : ajax_data,
                dataType: "html",
                success: function(result) {
                   
                   $("#collectie .collectie").append(result).imagesLoaded( function() {
                        $("#collectie .collectie").masonry( 'reloadItems' ).masonry( 'layout' ); 
                    });
                    $('.loading').slideUp();
                    
                    currentPage = currentPage+1;
                    
                    Cookies.set('ajax_last_loaded_page', JSON.stringify(currentPage), { expires: 30, path: '/' });
                    
                    loading = false;

                    $('.collectie .favorite').unbind( "click" );
                    favorietenCookie();
                    detailPageBackLink();
                }
            });
          
            
        } else {
            $('.end-message').slideDown();
        }
}