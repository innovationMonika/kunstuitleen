
$(window).load(function(){
    
    /*
     * Vars
     */
     
    var activeFilters = '';
     
    
    /*
     * Functions
     */
     
    /* GET VARS FROM URL */
    function getUrlVars()
    {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }
    
    // Set var
    activeFilters = getUrlVars()["c"];
    
    
    $('.kunstenaar a').on('click', function(e){
        e.preventDefault();
        
        var redirect_url = $(this).attr('href');
        var art_id = $(this).closest('.kunstenaar').attr('id');
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
    
    
    if($('#filters').length != 0){
    	
    	$('#filters .filter-search input').keydown(function(e){
            if(e.which == 13) {
               $('#filters form').submit();
            }
        });
    	
        $('.filter-submit').on('click', function(){
            $('#filters form').submit();
        });
    }
    
    
    if($('#kunstenaars').length != 0){
    
        //activeMasonry();
        
        setTimeout(function() {
            
            var backTo = getUrlVars()["backto"];
        
            if( backTo ) {

        		var idPOS = $('#'+backTo).offset();
    		    var scrollToID = idPOS.top - $('#'+backTo).outerHeight();
    		    $("html, body").animate({ scrollTop: scrollToID });
            }
            
        }, 500);

    
    }
    
    /* KUNSTENAARS AJAX LOADING */
    
    
    if($('#kunstenaars.ajaxloading').length != 0){
        
        var loading = false;
        currentPage = 2;
        
        $(window).scroll(function() {
           
            var scrollTop = $(window).scrollTop() + ( $(window).height() * 2.5 );
            var triggerLoad = $(document).height() - $('footer').outerHeight();
            
            if( scrollTop > triggerLoad) {
                
                if(loading == false){
                    if(maxPages >= currentPage){
                        
                        console.log(currentPage);
                        
                        loading = true;
                        $('.loading').slideDown();
                        
                        var ajax_data = { action: "getArtists", page: currentPage };
                        var ajax_filters = $('#filters form#filter').serializeArray();
                        
                        $.each(ajax_filters, function( index, value ) {
                            if( value.value.length > 0 ){
                                ajax_data[value.name] = value.value;
                            }
                        });
                                
                        $.ajax({
                            type: "GET",
                            //url: myLocalized.inc+'./ajax-kunstenaars.php?page='+currentPage+'&pw=uehdW9MQPRhfPg'+ajaxActiveFilters,
                            url: myLocalized.ajaxurl,
                            data : ajax_data,
                            dataType: "html",
                            success: function(result) {
                                $("#kunstenaars .kunstenaars").append(result);
                                
                                $('.loading').slideUp();
                                
                                currentPage = currentPage+1;
                                
                                Cookies.set('kunstenaarCurrentPage', JSON.stringify(currentPage), { expires: 30, path: '/' });
                                
                                loading = false;
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
    	if($('#collectie').length != 0){
		    $("#collectie .collectie").masonry('reloadItems');
        }
    });
    
});