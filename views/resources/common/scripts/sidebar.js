// Sidebar Stuff
		
$(document).ready(function(){
    
    var animation = false;
				
    var ua = navigator.userAgent,
    clickevent = (ua.match(/iPad/i) || ua.match(/iPhone/i) || ua.match(/Android/i)) ? "touchstart" : "click";
    
    
    function closeMenu(){
        menuIcon();
        $('#page-wrap').removeClass('active');
        $('#sidebar').removeClass('active');
        setTimeout(function(){ $('#sidebar').css('z-index','-100'); animation = false; },350);
        if(clickevent == "touchstart")
            enable_scroll();
    }
    
    function openMenu(){
        menuIcon();
        $('#sidebar').css('z-index','100');
        $('#page-wrap').addClass('active');
        $('#sidebar').addClass('active');
        if(clickevent == "touchstart")
            disable_scroll();
        setTimeout(function(){ animation = false; },350);
    }
    
    $(document).on(clickevent, '#page-wrap', function(event) {
        if($('#page-wrap').hasClass('active')) {
            event.preventDefault();
            if(!animation && Modernizr.csstransforms3d) {
                animation = true;
                closeMenu();
            } 
        } //else this is not supposed to fire
    });
    
    $(document).on(clickevent, '.trigger', function(event) {
        event.preventDefault();
        if(!animation && Modernizr.csstransforms3d) {
            animation = true;
            if($('#page-wrap').hasClass('active')) {
                closeMenu();
            }
            else openMenu();
        } //else open with accordion
    });
    
    function menuIcon() {
        if($('.trigger').children('h5').children('i').hasClass('fa-bars'))
            $('.trigger').children('h5').children('i').removeClass('fa-bars').addClass('fa-times');
        else
            $('.trigger').children('h5').children('i').removeClass('fa-times').addClass('fa-bars');
    }
    
    // left: 37, up: 38, right: 39, down: 40,
    // spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
    var keys = [37, 38, 39, 40];
    var pos;
    
    function preventDefault(e) {
        e = e || window.event;
        if (e.preventDefault)
          e.preventDefault();
        e.returnValue = false;  
    }
    
    function keydown(e) {
        for (var i = keys.length; i--;) {
            if (e.keyCode === keys[i]) {
                preventDefault(e);
                return;
            }
        }
    }
    
    function wheel(e) {
        preventDefault(e);
    }
    
    function disable_scroll() {
        if (window.addEventListener) {
          window.addEventListener('DOMMouseScroll', wheel, false);
        }
        window.onmousewheel = document.onmousewheel = wheel;
        document.onkeydown = keydown;
        $('#page-wrap').bind('touchmove', function(e){e.preventDefault(); return false;});
        
        pos = $(document).scrollTop();
        $('#page-wrap').css({'overflow' : 'hidden', 'height' : '100%'});
        $('#page-wrap').scrollTop(pos);
        
    }
    
    function enable_scroll() {
        if (window.removeEventListener) {
            window.removeEventListener('DOMMouseScroll', wheel, false);
        }
        window.onmousewheel = document.onmousewheel = document.onkeydown = null;  
        $('#page-wrap').unbind('touchmove');
        $('#page-wrap').removeAttr( 'style' );
        $(document).scrollTop(pos);
    }
    
    
    $('#back').click(function(e) {
        e.preventDefault();
        history.back();
    })
    
    
    // Validate
    
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
    };
    
    $('#login-button').click(function(){
        var email = document.getElementById('email').value;
        
        if( !isValidEmailAddress( email ) ) {
            $('#email').parent().addClass('warning');
            return false;
        } else {
            document.getElementById('login').submit();
        }
        
    });
    
});