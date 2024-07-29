jQuery(function($){
        
    //CookieConsent recheck Video's
    $(window).on('cookieconsent_video', function(){
        // On load, if cookie consent is given
        if( getCookie("cookieconsent") === 'accept' ){
            enableVideos();
        }
        
    });
    
    function getCookie(cname) {
    
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length,c.length);
            }
        }
        return "";
    }
    
    function enableVideos(){
        
        $('.videoWrapper.videoHidden').each(function(){
            
            $(this).removeClass('videoHidden');
            $(this).find('.videoHidden_container').fadeOut(300);
            $(this).find('iframe').attr('src', $(this).find('iframe').attr('data-src'));
            
        });
        
    }
    
    if( $('#cookie-notification').length != 0	){
        
        if( getCookie("cookieconsent") === '' ){
            $('#cookie-notification').fadeIn(300);
        }

        var d = new Date();
            d.setTime(d.getTime() + (31*24*60*60*1000));
        var expires = d.toUTCString();
        
        $('#cookie-notification .close-cookie-notification').on('click', function(event){
            event.preventDefault();
            
            var cookie_choice = $(this).attr('data-cookie-choice');
            
            $('#cookie-notification').fadeOut(300);
            document.cookie = "cookieconsent="+cookie_choice+"; expires="+expires+"; path=/";
            location.reload();
        });
        
        // Video trigger
        $(window).trigger('cookieconsent_video');
                
    }
    
    
    function showCookieChoice(){
        
        $('.videoHidden_container a').on('click', function(e){
            
            e.preventDefault();
            $('#cookie-notification').fadeIn(300);
            
        });
        
    }
    
    showCookieChoice();
    
});