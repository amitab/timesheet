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
                    row += '<tr class="timesheet-details" id="' + value.timesheetId + '">';
                    row += '<td>' + value.timesheetProjectName + '</td>';
                    row += '<td>' + value.timesheetDuration + '</td>';
                    row += '</tr>';
                });
                row += '</tbody>';
                row += '</table>';
				$('div#timesheet-list').prepend(row);
            });
        });
        emptyListCheck();
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
        var url = $('input#url').attr('timesheet-details-path') + '?id=' + $(this).attr('id');
        window.location.href = url;
    });
    
});

