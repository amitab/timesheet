var app = (function (app, native5) {
    app.registry = new native5.core.ServiceRegistry(); 
    
    var createService = function(url, config, successHandler) {
        var service =  new native5.core.Service(url, config);
        service.successHandler = successHandler;
        return service;
    };
    
    app.construct = function(args) {
        this.config = {
            path : args.path,
            method : args.method,
            mode : 'ui'
        };
        
        return {
            config : this.config,
            serviceObject : createService(args.url, this.config, args.successHandler),
        };
        
    };
    
    return app;
})(app || {}, native5 || {});

var smartList = (function(smartList) {
    var domElement;
    var randomColors = function() {
        var colour = ['#4cc2e4', '#FFCC5C', '#FF6F69', '#77C4D3', '#00A388', '#3085d6'];
        return colour[Math.floor(Math.random() * colour.length)];
    };
    
    var emptyListCheck = function() {
        if(this.domElement.children('ul').children().length < 1) {
            this.domElement.children('ul').addClass('empty-list');
        } else {
            this.domElement.children('ul').removeClass('empty-list');
        }
    }
    
    var activate = function() {
        this.emptyListCheck();
        this.domElement.children('ul').children().each(function(index) {
            if(!$(this).hasClass('list-item')) {
                $(this).addClass('list-item');
            } else {
                console.log('list-item class already present');
            }
            
            var style = 'border-left: 4px solid ' + randomColors() + ';';
            $(this).attr({'style' : style});
            
            if($(this).has('div.wrapper').length > 0) {
                console.log('wrapper already present');
            } else {
                $(this).wrapInner('<div class="wrapper"></div>');
            }
            
            $(this).find('p.email').each(function(index) {
                if($( this ).has('i.fa.fa-envelope').length > 0) {
                    console.log('Email icon already present');
                } else {
                    $(this).append('&nbsp;&nbsp;<i class="fa fa-envelope"></i>');
                }
                
            });
            
            $(this).find('img').each(function(index) {
                $(this).addClass('image round').attr({'width' : '50'});
                $(this).wrap('<div class="display-picture"></div>');
            });
        });
    }
    
    smartList.createList = function(args) {
        domElement = $(args.element);
        domElement.addClass('list');
        
        return {
            domElement : domElement,
            activate : activate,
            emptyListCheck : emptyListCheck,
            randomColors : randomColors,
        };
        
    };
    
    return smartList;
    
}(smartList || {}));

// ----------------------------------------------------------------------------------------------------------------------- //

/*
$(document).ready(function() {
    
    var searchList = smartList.createList({element : '#search-results'});
    var resultList = smartList.createList({element : '#selected-users'});
    
    // success handler must be declared before app is constructed
    
    var successHandler = function(data) {
        $('#search-results > ul').html('');
        var list = '';
        $.each(data.message.users, function(key, value) {
            var matcher = value.userMail.match(/@+.+/);
            var domain = matcher[0];
            var mail = value.userMail.substring(0,matcher.index);
            if(mail.length > 10) {
                var extract = mail.substring(0,10) + '...';
            } else {
                var extract = mail;
            }
            list += '<li userid="' + value.userId + '">';
            list += '<table>';
            list += '<tbody>';
            list += '<tr>';
            list += '<td>';
            list += '<img src="' + data.message.image_location + value.userImageUrl + '">';
            list += '</td>';
            list += '<td>';
            list += '<h5>' + value.userName + '</h5>';
            list += '<p class="small email">' + extract + domain + '</p>';
            list += '</td>';
            list += '</tr>';
            list += '</tbody>';
            list += '</table>';
            list += '</li>';
        });
        $('#search-results > ul').append(list);
        searchList.activate();
        console.log('appended data');
    };
    
    var communicator = app.construct({
        path : 'timesheet',
        method : 'POST',
        url : 'project/search_to_add',
        successHandler : successHandler
    });
    
    $(document).on('click', '.list-item' ,function(e) {
                
        var parent = $(this).closest('section');
        var item = $(this);
        item.remove();
        if(parent.is('#search-results')) {
            $('#selected-users > ul').append(item);
        } else {
            $('#search-results > ul').append(item);
        }
        searchList.emptyListCheck();
        resultList.emptyListCheck();
        
    });  
    
    function openSearchBox(searchBox) {
        searchBox.removeClass('closed');
        $('div.header-item:first').addClass('fade-out');
    }
    
    function closeSearchBox(searchBox) {
        searchBox.addClass('closed');
        $('#search-box').val('');
        $('div.header-item:first').removeClass('fade-out');
    }
    
    $('#search-button').click(function(e){
        e.preventDefault();
        var searchBox = $($(this).attr('href'));
        
        if(searchBox.val().length <= 0) {
            if(searchBox.hasClass('closed')) {
                openSearchBox(searchBox);
            } else {
                closeSearchBox(searchBox);
            }
        }
        
        else {
           var query = '%' + $('#search-box').val() + '%';
            // Search using ajax
            var args = {};
            args.q = query;
            args.ids = [];
            communicator.serviceObject.invoke(args);
        }
        
    });
    
});
*/
