/*if($('.lazy').length != 0){
    $("img.lazy").show().lazyload({
        threshold : 150,
    });
}*/

$(window).load(function(){
    
    /* FLEX NAV */
        $('nav ul ul').show();
        
        $(".flexnav").flexNav();
        
        $('.showmenu').click(function(){
            $('.menu').slideToggle();
        });    
    /* END OF FLEX NAV */  
    
    
    if($('select').length != 0 && $(window).width() > 991){
    	$("select").chosen({ disable_search_threshold:100,width:'' });
    	
    	
    	if( $('.filter-kunstenaars select option').filter(':selected').text() != 'Alle kunstenaars' ){
        	$('.filter-kunstenaars .chosen-container .chosen-single').addClass('has-remove-filter').append('<div class="remove-kunstenaar-filter"><i class="fa fa-close"></i></div>');
        	
        	$('.filter-kunstenaars .chosen-container .chosen-single .remove-kunstenaar-filter').on('click', function(){
            	$('.filter-kunstenaars select option:first').attr("selected", "selected");
            	$('#filters form').submit();
        	});
        	
    	}
    }
    
    if($('.bio-more').length != 0){
        $('.showfullbio').click(function(){
            $('.bio-dots').fadeOut();
            $('.bio-more').slideDown();
            $(this).fadeOut();
        });
    } 
    
    $('.fa-search').click(function(){
        $('#searchform').slideToggle().find('input[type="text"]').focus();
    });
    
    $('#filters .filter-submit, .play').mouseover(function() { 
        var src = $(this).attr("src").replace(".svg", "-hover.svg");
        $(this).attr("src", src);
    })
    .mouseout(function() {
        var src = $(this).attr("src").replace("-hover.svg", ".svg");
        $(this).attr("src", src);
    });
    
    
    // HEADER 
    
    function scrollHeader() {
        
    
        if($(window).width() > 991){
            
            var headerSize = 'big';
            var logoHeight = $('.logo img').width();
            
            function setScroll(){
                if($(document).scrollTop() > 20) {
                    if(headerSize == 'big') {
                        headerSize = 'small';
                        $('#top').animate({ 'padding-bottom' : 10 }, 300);
                        //$('#top nav').fadeOut('fast');
                        $('.logo img').animate({ 'width' : '90px', 'margin-top' : '-5px' },300);
                        $('nav ul li').animate({ 'padding-bottom' : 10, 'margin-bottom' : '-10px', }, 300);
                        //$('.scrollshowmenu').fadeIn();
                    }
                } else {
                    if(headerSize == 'small') {
                        headerSize = 'big';
                        
                        $('#top').animate({ 'padding-bottom' : 15 }, 300);
                        $('nav ul li').animate({ 'padding-bottom' : 15, 'margin-bottom' : '-15px', }, 300);
                        //$('#top nav').fadeIn('fast');
                        $('.logo img').animate({ 'width' : logoHeight, 'margin-top' : '0' },300);
                        //$('.scrollshowmenu').fadeOut();
                    }
                }
            }
            
            if($(document).scrollTop() > 20) { setScroll(); }
            
            $(window).scroll(function() {
                setScroll();
            });
            
            
/*
            $('.scrollshowmenu').click(function(){
                if(headerSize == 'big') {
                    headerSize = 'small';
                    $('#top').animate({ 'padding-bottom' : 0 }, 300);
                    $('#top nav').fadeOut('fast');
                    $('.logo img').animate({ 'width' : '30px', 'margin-top' : '-5px' },300);
                    //$('.scrollshowmenu').fadeIn();
                } else if(headerSize == 'small') {
                    headerSize = 'big';
                    $('#top').animate({ 'padding-bottom' : '25' }, 300);
                    $('#top nav').fadeIn('fast');
                    $('.logo img').animate({ 'width' : logoHeight, 'margin-top' : '0' },300);
                    //$('.scrollshowmenu').fadeOut();
                }
            });
*/
            
        }
    
    }
    
    if($('.portal').length == 0){
        scrollHeader();
    }
    
    if($('#carousel').length != 0){
        $('#carousel .slide').show();
        
        $('#carousel').slick({
            lazyLoad: 'ondemand',
            arrows: false,
            autoplay: true,
            autoplaySpeed: 3000,
            slidesToShow: 3,
            slidesToScroll: 1,
            centerMode: true,
            focusOnSelect: true,
            centerPadding: '125px',
            responsive: [
                {
                  breakpoint: 768,
                  settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                  }
                }
            ]
        });
        
        
    }
    
    if($('header video').length != 0){
        document.getElementById("html5video").play();
    }
    
    if($('.frm_form_field .frm_opt_container').length != 0){
        $('input[type="checkbox"]').change(function(){
            if( $(this).is(':checked') ){ 
                $(this).parent().addClass('checked');
            } else {
                $(this).parent().removeClass('checked');
            }
        });    
        
        function getUrlParameter(sParam)
        {
            var sPageURL = window.location.search.substring(1);
            var sURLVariables = sPageURL.split('&');
            for (var i = 0; i < sURLVariables.length; i++) 
            {
                var sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] == sParam) 
                {
                    return sParameterName[1];
                }
            }
        } 
        
        var form = getUrlParameter('form');
        if(form === '' || form === undefined){} else {
            $('[value="' + form + '"]').parent().addClass('checked');
            $('html, body').animate({ scrollTop: $(".frm_forms").parent().offset().top - 30 }, 2000);
        }
        
        
        $('input[type="radio"]').change(function(){
            if( $(this).is(':checked') ){ 
                $(this).parent().parent().parent().find('.checked').removeClass('checked');
                $(this).parent().addClass('checked');
                $(this).parent().find('label').addClass('checked');

            } 
        });  
        
        $('input[type="radio"]').each(function(){
            if( $(this).is(':checked') ){ 
                $(this).parent().addClass('checked');
            } 
        });
    }
    
    
    if($('.gallery-item a, a.lightbox').length != 0){
        $('.gallery-item a, a.lightbox').nivoLightbox();
    }
    
    var footerColHeight = '';
    $('.footer-col.border').each(function(){
        if($(this).outerHeight() > footerColHeight){ footerColHeight = $(this).outerHeight(); }
    });
    $('.footer-col').css({ 'min-height' : footerColHeight });
    
    if($('.video-controls').length != 0){
	    var videoMuted = false;
	    
        $('.video-play').click(function(){
            $(this).fadeOut();
            $('.video-pause').fadeIn();
            
            if( videoMuted == true) {
	            $('.video-volume-off').fadeIn();
            } else {
	        	$('.video-volume-on').fadeIn();    
            }
            
            document.getElementById('html5videoAbout').play();
        });
        
        $('.video-pause').click(function(){
            $(this).fadeOut();
            $('.video-play').fadeIn();
            $('.video-volume-on, .video-volume-off').fadeOut();
            document.getElementById('html5videoAbout').pause();
        });
        
        $('.video-volume-on').click(function(){
	        $(this).fadeOut();
            $('.video-volume-off').fadeIn();
            videoMuted = true;
            $("#html5videoAbout").prop('muted', true); //mute
	    });
	    
	    $('.video-volume-off').click(function(){
	        $(this).fadeOut();
            $('.video-volume-on').fadeIn();
            videoMuted = false;
            $("#html5videoAbout").prop('muted', false); //mute
	    });
        
        
        var video = document.getElementById('html5videoAbout');
        
        video.addEventListener('ended',myHandler,false);
        function myHandler(e) {
            if(!e) { e = window.event; }
            // What you want to do after the event
            video.currentTime = 0;
            video.load();
            $('.video-pause').fadeOut();
            $('.video-volume-on, .video-volume-off').fadeOut();
            $('.video-play').fadeIn();
        }
        
    }
    
/*
    if($('video').length != 0){
        Modernizr.on('videoautoplay', function(result) {
            if (result) { 
                // Do nothing
            } else {
                // Show backup image
                $('video, .video-controls').hide();
                
                if( $(this).parent().parent().parent().attr('id') == 'about' ) ){
                    $(this).parent().parent().parent();
                }
                $('img.backup-image').show().css({ 'display' : 'block !important' });
            }
        }); 
    }
*/

    
    /* Responsive Table */
	$("table").addClass("table");
	

	
	
	
	function createPopup(melding){
    	$('body').prepend('<section class="popup"><section class="melding"><i class="fa fa-close"></i>' + melding + '</section></section>');
        $('.popup').fadeIn();
        
        closePopup();
	}
	
	function closePopup(){
    	$('.popup .melding .fa-close').on('click', function(){
            $('.popup').fadeOut(300);
            setTimeout(function() { $('.popup').remove(); }, 500);
        });
    }
    
    
    function confirmSelection( preselection ){
        
        var webVariant = Cookies.get('kunstuitleenVariant');
        if( typeof webVariant === 'undefined' ){ webVariant = 'thuis'; }
       
    	if( webVariant == 'werk' ){ maxSelection = 20; } else { maxSelection = 5; }
    	
    	var favorite = [];
    	
    	if( preselection == 'true' ){
        	
        	if(Cookies.get('favorieten-preselect-'+$('#preselect_client_code').val() ) === undefined || Cookies.get('favorieten-preselect-'+$('#preselect_client_code').val() ) === '') {
            	favorite = '';
        	} else {
            	favorite = JSON.parse(Cookies.get('favorieten-preselect-'+$('#preselect_client_code').val() ) );
        	}
        	
    	} else {
        	
            if(Cookies.get('favorieten'+webVariant) === undefined || Cookies.get('favorieten'+webVariant) === '') {
                favorite = '';
            } else {
                favorite = JSON.parse(Cookies.get('favorieten'+webVariant));    
            }
    	}
    	        

    	if(favorite.length == 0){
        	
        	createPopup('<h2>Minimaal 1 favoriet</h2><p>Je hebt ' + favorite.length + ' kunstwerken geselecteerd, selecteer a.u.b. minimaal 1 kunstwerk als favoriet om verder te kunnen gaan.</p>');
        	    
	    	return false;
	    	        
    	} else {
        	
            if( favorite.length > maxSelection ){
                
                createPopup('<h2>Maximaal ' + maxSelection + ' favorieten</h2><p>Je hebt ' + favorite.length + ' kunstwerken geselecteerd. Hierdoor zit je over de max. van ' + maxSelection + ' favorieten. Verwijder ' + ( favorite.length - maxSelection) + ' kunstwerk(en) om verder te kunnen gaan.</p>');
                
                return false;
                
            }	
            
    	}
    	
    }

    $('form#form_v3tom924, #form_v3tom92').on('submit', function(){
    
        var preselection = 'false';
        return confirmSelection(preselection);

	});
	
	$('#confirm-favorite-selection a.button').on('click', function(){
    	
    	var preselection = 'false';
    	return confirmSelection(preselection);
    	
	});
	
    $('#confirm-favorite-preselection a.button').on('click', function(){
    	
    	var preselection = 'true';
    	return confirmSelection(preselection);
    	
	});
	
	
	 //back to top link
    var backtotop = 0;
      
    function showOrHideBackToTop() {
        var browserHoogte = $(window).height();
        var scrollHoogte = $(window).scrollTop();
        if (scrollHoogte >= browserHoogte && backtotop == 0) {
            backtotop = 1;
            $('a.backtotop').fadeIn('medium');
        } else if (scrollHoogte < 50 && backtotop == 1) {
            backtotop = 0;
            $('a.backtotop').fadeOut('medium');
        } 
    }
      
    $(window).scroll(function(browserHoogte) {
       showOrHideBackToTop();
    });
    
    
    var $_form_limit_textarea = $('.form-limit-textarea');
    if( $_form_limit_textarea.length > 0 ){
        
        var limit = 200;
        $_form_limit_textarea.find('textarea').attr('maxLength', limit);
        $_form_limit_textarea.append('<div class="character-count"><span class="count">0</span> van de ' + limit + ' tekens gebruikt.</div>');
        
        $_form_limit_textarea.find('textarea').on('keyup', function(){
            var current_length = $(this).val().length;
            $_form_limit_textarea.find('.character-count .count').text(current_length);
        });
        
    } 
    
    
    function createModal(){
        
        $('#modal').show();         
        this.autoOpenModal = true;
         
        // Defaults
        this.setDefaults = function(){
            this.modalBtnW = $('#modal-button').outerWidth();
            this.modalW = $('#modal').outerWidth();
            this.scrollPos = $(window).scrollTop();
            this.modalH = $('#modal').outerHeight();
            
            this.windowH = $(window).height();
            this.documentH = $(document).height();
            this.modalPosition = ( ( this.modalH + 40 ) > this.windowH ? 'absolute' : 'fixed' );
            
            if( this.modalPosition  == 'absolute' ){
                // Absolute
                if( ( this.scrollPos + 125 ) + ( this.modalH + 40 ) > this.documentH ){
                    this.modalMargin = this.documentH - ( this.modalH + 40 + 125 ); // - 100 offset bottom of document
                } else {
                    this.modalMargin = this.scrollPos + 125; // + 100 offset top of document
                }
                
            } else {
                // Fixed
                this.modalMargin = '-'+( this.modalH / 2)+'px'
            }
            
        }
        
        this.cookieExpire = function(){
            var d = new Date();
            d.setTime(d.getTime() + (31*24*60*60*1000));
            return d.toUTCString();
        }
        
        this.getCookie = function(cname) {
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
        
        // Functions
        this.placeModal = function(){
            // Get / Set default values
            this.setDefaults();           
            
            // Set Modal in center of screen
            $('#modal')
            .removeClass('fixed')
            .removeClass('absolute')
            .addClass(this.modalPosition)
            .css({ 'margin-top' : this.modalMargin, 'margin-right' : '-'+this.modalW+'px' });

            if( $('#modal').offset().top < $('#top').outerHeight() ) {
                $('#modal').css({ 'margin-top' : 0, 'top' : $('#top').outerHeight() + 30 });
            }
        }
        
        this.showModal = function(){
            
            if( $(window).width() > 768 ){

                this.autoOpenModal = false;
                
                $('#modal-button').animate({ 'margin-right' :  '-'+this.modalBtnW+'px' }, 300, "linear");
                var modalPositionVar = this.modalPosition;
                
                setTimeout(function(){
                    if( modalPositionVar == 'fixed' ){ $('#overlay').fadeIn(300); }
                    $('#modal').animate({ 'margin-right' : 0 }, 300, "linear");
                }, 400);
            
            }
        }
        
        this.closeModal = function(){
            $('#modal').animate({ 'margin-right' : '-'+this.modalW+'px' }, 300, "linear");
            if( this.modalPosition == 'fixed' ){ $('#overlay').fadeOut(300); }
            
            setTimeout(function(){
                $('#modal-button').animate({ 'margin-right' : 0 }, 300, "linear");                
            }, 400);
        }
        
        
    }


    newModal = new createModal();
    newModal.placeModal();

    var cookieWebVariant = Cookies.get('kunstuitleenVariant');
    let cookieHideModal = newModal.getCookie("hideModal_" + cookieWebVariant);
    
    $('#modal-button').on('click', function(){
        newModal.showModal();
    });
    
    $('#modal .modal-label, #modal .modal-close, #overlay').on('click', function(){

        document.cookie = "hideModal_" + cookieWebVariant + "=true; path=/";
        newModal.closeModal();
    });
    
    $(window).resize(function() {
        newModal.closeModal();
    });
    

    // Show modal after X seconds
    let modalTimeout = $('#modal').data('seconds');
    if( cookieHideModal !== 'true') {
        modalTimeout = $('#modal').data('seconds-firsttime');
    }

    setTimeout(function(){
        if( newModal.autoOpenModal == true ){
            newModal.showModal();
        }
    }, (modalTimeout*1000));
    
    
    // Helpbox
    function helpboxes(){
        
        var this_self = this;
        this.helpbox_width = 550;
        
        
        this.trigger = function(){
            
            $('.helpbox-trigger').on('click', function(){
                
                var key = $(this).attr('data-key');
                var position = $(this).offset();
                
                if( $(window).width() > 768 ){
                    $('.helpbox#helpbox-' + key).css({ 'position' : 'absolute', 'top' : position.top, 'left' : ( position.left - this_self.helpbox_width ), 'width' : this_self.helpbox_width }).fadeIn();
                } else {
                    $('.helpbox#helpbox-' + key).css({ 'position' : 'absolute', 'top' : position.top, 'left' : 15, 'width' : ($(window).width() - 30) }).fadeIn();
                }
                
            });
            
            $('.helpbox-close').on('click', function(){
                $(this).parent().fadeOut();
            });
            
        }
        
    }
    
    var helpBox = new helpboxes();
        helpBox.trigger();
    
    //Smooth scrolling
	$('a[href^="#"]').on('click',function (e) {
	    e.preventDefault();

	    var target = this.hash,
	    $target = $(target);

	    $('html, body').stop().animate({
	        'scrollTop': $target.offset().top - 100
	    }, 800, 'swing', function () {
	        window.location.hash = target;
	    });
	});
    
    /* STICKY FOOTER */
	function stickyFooterHeight(){
		var footerHeight = $("footer").outerHeight();
		$("#wrap").css('margin-bottom', - footerHeight - 40);
		$("#push").css('height', footerHeight);
	}

	stickyFooterHeight();
	/* END OF STICKY FOOTER */
	
	$(window).resize(function() {
		stickyFooterHeight();
		
		$('.item-with-ul ul').hide(); /* Fix for FlexNav */
		$('.touch-button.active').removeClass('active'); /* Fix for FlexNav */
    });

});