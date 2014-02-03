$(document).ready(function() {
    
    function emptyListCheck() {
        if($('div#timesheet-list').children().length > 0) {
            $('div#timesheet-list').removeClass('empty-list');
            return;
        } else {
            $('div#timesheet-list').addClass('empty-list');
        }
    }
    
    var successHandler = function(data) {
        $('div#timesheet-list').html('');
        console.log(data);
        
        if(data.message.timesheets.length == 0) {
            
            native5.Notifications.show( "There are no timesheets under this project.", {
                notificationType:'toast',
                title:'Information',
                position:'bottom',
                distance:'0px',
                timeout: 5000,
                persistent:false
            });
            
            return;
        }
        
        $.each(data.message.timesheets, function(key, value) {
            var year = key; 
            
            $.each(value, function(key, value) {
				var row = '';
                var week = key;
                row += '<table>';
                row += '<thead>';
                row += '<tr>';
                row += '<th>' + year ;
                row += ', Week : ' + week + '</th>';
                row += '<th>Duration</th>';
                row += '</tr>';
                row += '</thead>';
                row += '<tbody>';
                $.each(value, function(key, value) {
                    
                    var time = value.timesheetDuration;
                    var hrs = Math.round(time / 3600);
                    var mins = Math.round((time % 3600) / 60);
                    var secs = Math.round(time % 60);
                    
                    row += '<tr class="timesheet-details" id="' + value.timesheetId + '">';
                    row += '<td>' + value.timesheetProjectName + '</td>';
                    row += '<td>' + hrs + ':' + mins + ':' + secs + ' </td>';
                    row += '</tr>';
                });
                row += '</tbody>';
                row += '</table>';
				$('div#timesheet-list').prepend(row);
            });
        });
        emptyListCheck();
    };
    
    function getJsonFromUrl() {
        var query = location.search.substr(1);
        var data = query.split("&");
        var result = {};
        for(var i=0; i<data.length; i++) {
            var item = data[i].split("=");
            result[item[0]] = item[1];
        }
        return result;
    }
    
    var result = getJsonFromUrl();
    var projectId = result['id'];
    
    var communicator = app.construct({
        path : 'timesheet_iphone',
        method : 'POST',
        url : 'project/timesheets',
        successHandler : successHandler
    });
    
    // load initial data
    communicator.serviceObject.invoke({get_timesheets: projectId});
    
    $(document).hammer().on('tap', 'tr.timesheet-details', function(e) {
        e.preventDefault();
        var url = $('input#url').attr('timesheet-details-path') + '&id=' + $(this).attr('id');
        window.location.href = url;
    });
    
});

