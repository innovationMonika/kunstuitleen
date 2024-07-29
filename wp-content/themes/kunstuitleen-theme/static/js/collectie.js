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
    
    
    // Refresh the favorite list, check if some favorite art has removed by the daily feed
    if( favorieten.refresh == true ){ 
        
        if( favorieten.list.length > 0 ) {

            $('#top .favorieten').text(favorieten.list.length).removeClass('animated').addClass('animated');
            Cookies.set(favorieten_cookie_name, JSON.stringify(favorieten.list), { expires: 30, path: '/' });
            
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
                   
            if( $(this).hasClass('active') ){
                
                favorite = jQuery.grep(favorite, function(value) {
                  return value != clickedID;
                });
                 
                $(this).removeClass('active');
                if( $(this).find('span').length != 0){ $(this).find('span').html('VOEG TOE'); }
                
            } else {
                
                favorite.push(clickedID);
                $(this).addClass('active');
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
    
    if($('#collectie.ajaxloading').length != 0){
        
        var loading = false;
        
        
        $(window).scroll(function() {
           
            var scrollTop = $(window).scrollTop() + $(window).height();
            var triggerLoad = $(document).height() - $('footer').outerHeight();
            
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
    
});
