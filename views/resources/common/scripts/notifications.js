$(document).ready(function() {
    var path = 'timesheet';
    var notificationList = smartList.createList({element : '#notification-list'});
    var currentOffset = 0;
    var successHandler = function(data) {
        
        if(data.message.notifications.length == 0) {
            $('div.warnings').html('');
            $('div.warnings').append('<p class="alert primary">' + data.message.lol + '</p>');
            return;
        }
        
        $.each(data.message.notifications, function(key, value) {
            var list = '';
            list += '<li class="notification-link" id="' + value.notificationId +'" url="\\' + path + '\\' + value.url + '?id=' + value.notificationSubjectId + '">';
            list += '<div class="content">';
            list += '<div class="content-header">';
            list += '<p class="small left">From : ' + value.notificationFromUser + '</p>';
            list += '<p class="small right">' + value.notificationPriority + '</p>';
            list += '</div>';
            list += '<p>' + value.notificationBody + '</p>';
            list += '</div>';
            list += '</li>';
            $('section#notification-list > ul').append(list);
            currentOffset++;
        });
        notificationList.activate();
        notificationList.emptyListCheck();
    };
    
    var communicator = app.construct({
        path : path,
        method : 'POST',
        url : 'notifications/search',
        successHandler : successHandler
    });
    
    // load initial data
    communicator.serviceObject.invoke({default: true});
    notificationList.emptyListCheck();
    
    $(document).on('click', 'div#load-notitfications', function(e) {
        e.preventDefault();
        communicator.serviceObject.invoke({offset: currentOffset});
    });
    
    $(document).on('click', 'li.notification-link', function(e) {
        e.preventDefault();
        var url = $(this).attr('url');
        window.location.href = url;
    });
    
});

