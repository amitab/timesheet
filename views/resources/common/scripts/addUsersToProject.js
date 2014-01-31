$(document).ready(function() {
    
    var searchList = smartList.createList({element : '#search-results'});
    var resultList = smartList.createList({element : '#selected-users'});
    
    // success handler must be declared before app is constructed
    
    var successHandler = function(data) {
        $('#search-results > ul').html('');
        var list = '';
        
        if(data.message.users.length == 0) {
            native5.Notifications.show( data.message.reason, {
                notificationType:'toast',
                title:'Error',
                position:'bottom',
                distance:'0px',
                timeout: 5000,
                persistent:false
            });
            
            return;
        }
        
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
            list += '<img src="' + data.message.thumb_image_location + 'thumb_' + value.userImageUrl + '">';
            list += '</td>';
            list += '<td>';
            list += '<h5>' + value.userFirstName + ' ' + value.userLastName + '</h5>';
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
    
    var prevQuery = '';
    
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
            
            if(prevQuery == query) {
                return;
            }
            
            var args = {};
            args.q = query;
            args.ids = [];
            args.project_id = parseInt($('input#project_id').val());
            
            $('section#selected-users li').each(function(index) {
                args.ids.push($(this).attr('userid'));
            });
            
            communicator.serviceObject.invoke(args);
        }
        
    });
    
    
    // When add button is clicked
    
    var addSuccessHandler = function(data) {
        $('div.warnings').html('');
        if(data.message.success == true) {
            native5.Notifications.show( data.message.info.response, {
                notificationType:'toast',
                title:'Success',
                position:'bottom',
                distance:'0px',
                timeout: 5000,
                persistent:false
            });
            
            setTimeout(function(){ window.location.href = data.message.info.redirect; }, 5000);
            
        } else {
            native5.Notifications.show( data.message.info.response, {
                notificationType:'toast',
                title:'Error',
                position:'bottom',
                distance:'0px',
                timeout: 5000,
                persistent:false
            });
        }
    };
    
    var adder = app.construct({
        path : 'timesheet',
        method : 'POST',
        url : 'project/add_users',
        successHandler : addSuccessHandler
    });
    
    $(document).on('click', 'a#add_users', function(e) {
        e.preventDefault();
        var args = {};
        args.add_users = true;
        args.project_id = parseInt($('#project_id').val());
        args.ids = [];
        
        $('section#selected-users li').each(function(index) {
            args.ids.push($(this).attr('userid'));
        });
        
        if(args.ids.length == 0) {
            native5.Notifications.show( "You haven't selected anyone!", {
                notificationType:'toast',
                title:'Error',
                position:'bottom',
                distance:'0px',
                timeout: 5000,
                persistent:false
            });
            
            return;
        }
        
        adder.serviceObject.invoke(args);
        
    });
    
});

