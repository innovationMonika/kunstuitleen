
$(window).load(function(){
    
    
    /* BLOG AJAX LOADING */
        
    if($('#blog.ajaxloading').length != 0){
        
        var loading = false;
        
        
        $(window).scroll(function() {
           
            var scrollTop = $(window).scrollTop() + ( $(window).height() * 2.5 );
            var triggerLoad = $(document).height() - $('footer').outerHeight();
            
            if( scrollTop > triggerLoad) {
                
                if(loading == false){
                    if(maxPages >= currentPage){
                        
                        loading = true;
                        $('.loading').slideDown();
                        
                        var ajax_data = { action: "getBlogItems", page: currentPage };
                                                      
                        $.ajax({
                            type: "GET",
                            //url: myLocalized.inc+'./ajax-blog.php?page='+currentPage+'&pw=uehdW9MQPRhfPg',
                            url: myLocalized.ajaxurl,
                            data : ajax_data,
                            dataType: "html",
                            success: function(result) {
                                $("#blog .blog-items").append(result);
                                
                                $('.loading').slideUp();
                                
                                currentPage = currentPage+1;
                                
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
	
    
});