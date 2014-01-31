$(document).ready(function() {
    var path = 'timesheet';
    var notificationList = smartList.createList({element : '#notification-list'});
    var currentOffset = 0;
    var successHandler = function(data) {
        
        if(data.message.notifications.length == 0) {
            native5.Notifications.show( data.message.lol, {
                notificationType:'toast',
                title:'Information',
                position:'bottom',
                distance:'0px',
                timeout: 5000,
                persistent:false
            });
            
            return;
        }
        
        $.each(data.message.notifications, function(key, value) {
            
            var notificationDate = ~~(new Date(value.notificationDate).getTime()/1000);
            var today = ~~(new Date(Date.now()).getTime()/1000);
            
            var timeLeft = today - notificationDate;
            var days = Math.round(timeLeft/(3600*24));
            var hrs = Math.round(timeLeft / 3600);
            var mins = Math.round((timeLeft % 3600) / 60);
            var secs = Math.round(timeLeft % 60);
            
            var timeString = '';
            
            if(days > 0) {
                timeString += days;
                if(days == 1) timeString  += ' day ago';
                else timeString  += ' days ago';
            } else if (hrs > 0) {
                timeString += hrs;
                if(hrs == 1) timeString  += ' hour ago';
                else timeString  += ' hours ago';
            } else if (mins > 0) {
                timeString += mins;
                if(hrs == 1) timeString  += ' minute ago';
                else timeString  += ' minutes ago';
            } else if (secs > 0) {
                timeString += secs;
                if(hrs == 1) timeString  += ' second ago';
                else timeString  += ' seconds ago';
            } else {
                timeString += 'Just Now';
            }
            
            var list = '';
            list += '<li class="notification-link" id="' + value.notificationId +'" url="\\' + path + '\\' + value.url + '&id=' + value.notificationSubjectId + '">';
            list += '<div class="content">';
            list += '<div class="content-header">';
            list += '<p class="small"><span class="from">' + value.notificationFromUser + '</span>, <span class="time">'; 
            list += timeString + '</span></p>';
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

