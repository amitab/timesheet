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
    
    function openInlineMenu(inlineMenu) {
        animation = true;
        inlineMenu.removeClass('hidden').addClass('moving-in');
        setTimeout(function(){ inlineMenu.removeClass('moving-in'); animation = false; },350);
    }
    
    function closeInlineMenu(inlineMenu) {
        animation = true;
        inlineMenu.addClass('moving-out');
        setTimeout(function(){ inlineMenu.addClass('hidden').removeClass('moving-out'); animation = false; },350);
    }
    
    $(document).on(clickevent, '#page-wrap', function(event) {
        //event.preventDefault();
        
        var target = $(event.target);
        if(target.is('a.page-link.small')) {
            window.location.href = target.attr('href');
        }
        if(!target.is('div.inline-menu a')) {
            if(!$('div.inline-menu').hasClass('hidden')) {
                closeInlineMenu($('div.inline-menu'));
            }
        }
        
        if($('#page-wrap').hasClass('active')) {
            event.preventDefault();
            if(!animation && Modernizr.csstransforms3d) {
                animation = true;
                closeMenu();
            } 
        } 
        /*if(!$('#search-box').hasClass('closed')) {
            $('#search-box').addClass('closed');
            $('#search-box').val('');
            $('div.header-item:first').removeClass('fade-out');
        }*/
    });
    
    $(document).on(clickevent, '.trigger', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        if(!animation && Modernizr.csstransforms3d) {
            animation = true;
            if($('#page-wrap').hasClass('active')) {
                closeMenu();
            }
            else openMenu();
        } 
    });
    
    $(document).on(clickevent, '.inline-menu-trigger', function(e) {
        e.preventDefault();
        if(animation) return false;
        var inlineMenu = $($(this).attr('menu'));
        if(inlineMenu.hasClass('hidden')) {
            openInlineMenu(inlineMenu);
        } else {
            closeInlineMenu(inlineMenu);
        }
    });
    
    $(document).on(clickevent, '.remove-section', function(e) {
        e.preventDefault();
        var section = $(this).closest('section');
        section.addClass('moving-out');
        setTimeout(function(){ section.remove(); },400);
    });
    
    function menuIcon() {
        if($('.trigger').children('h5').children('i').hasClass('fa-bars'))
            $('.trigger').children('h5').children('i').removeClass('fa-bars').addClass('fa-times');
        else
            $('.trigger').children('h5').children('i').removeClass('fa-times').addClass('fa-bars');
    }
    
    /*$('.warnings').bind('DOMNodeInserted', function(e) {
        $('.warnings').removeClass('hide').addClass('waah');
        setTimeout(function(){ 
            $('.warnings').removeClass('waah'); 
            setTimeout(function(){ $('.warnings').addClass('hide'); },400);
        },4000);
    }); */
    
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

    
    $('#submit').click(function(){
        $(this).closest('form').submit();
    });
    
    $(document).on(clickevent, '#save-form', function(e) {
        e.preventDefault();
        var form = $($(this).attr('target'));
        form.submit();
    });
    
});