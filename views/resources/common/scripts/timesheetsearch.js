$(document).ready(function() {
    var offset = 0;
    var load = false;
    
    function emptyListCheck() {
        if($('div#timesheet-list').children().length > 0) {
            $('div#timesheet-list').removeClass('empty-list');
            return;
        } else {
            $('div#timesheet-list').addClass('empty-list');
        }
    }
    
    var successHandler = function(data) {
        if(!load) {
            offset = 0;
            $('div#timesheet-list').html('');
        }
        
        if(data.message.tables.length == 0 && load) {
            
            native5.Notifications.show( "You have no more timesheets.", {
                notificationType:'toast',
                title:'Information',
                position:'bottom',
                distance:'0px',
                timeout: 5000,
                persistent:false
            });
            
            return;
        }
        
        $.each(data.message.tables, function(key, value) {
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
                offset++;
            });
        });
        emptyListCheck();
        if(load) {
            load = false;
        }
    };
    
    var communicator = app.construct({
        path : 'timesheet',
        method : 'POST',
        url : 'timesheets/search',
        successHandler : successHandler
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
                if(prevQuery != '') {
                    communicator.serviceObject.invoke({default:'true'});
                    emptyListCheck();
                }
                closeSearchBox(searchBox);
            }
        }
        
        else {
           var query = '%' + $('#search-box').val() + '%';
            // Search using ajax
            var args = {};
            args.q = query;
			if(prevQuery != query) {
				prevQuery = query;
				communicator.serviceObject.invoke(args);
			} else {
				closeSearchBox(searchBox);
			}
        }
        
    });
    
    // load initial data
    communicator.serviceObject.invoke({default: true});
    
    $(document).on('click', 'tr.timesheet-details', function(e) {
        e.preventDefault();
        var url = $('input#url').attr('timesheet-details-path') + '&id=' + $(this).attr('id');
        window.location.href = url;
    });
    
    $(document).on('click', 'div#load-more', function(e) {
        e.preventDefault();
        // Search using ajax
        load = true;
        var args = {default: true, offset: offset};
        communicator.serviceObject.invoke(args);
    });
    
});

