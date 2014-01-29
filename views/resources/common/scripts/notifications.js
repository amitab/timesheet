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
            var days = ~~(timeLeft/(3600*24));
            var hrs = ~~(timeLeft / 3600);
            var mins = ~~((timeLeft % 3600) / 60);
            var secs = ~~(timeLeft % 60);
            
            var timeString = '';
            
            if(days > 0) {
                timeString += days + ' days ago';
            } else if (hrs > 0) {
                timeString += hrs + ' hours ago';
            } else if (mins > 0) {
                timeString += mins + ' minutes ago';
            } else if (secs > 0) {
                timeString += secs + 'seconds ago';
            } else {
                timeString += 'Just Now';
            }
            
            var list = '';
            list += '<li class="notification-link" id="' + value.notificationId +'" url="\\' + path + '\\' + value.url + '?id=' + value.notificationSubjectId + '">';
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

