$(document).ready(function() {
    
    var searchList = smartList.createList({element : '#projects-list'});
    
    // success handler must be declared before app is constructed
    
    var successHandler = function(data) {
        $('#projects-list > ul').html('');
        $.each(data.message.projects, function(key, value) {
            var list = '';
            var extract = value.projectDescription.substring(0,60) + '...';
            
            var deadline = Math.round(new Date(value.projectTimeAlloted)/1000);
            var today = Math.round(new Date(value.projectCreatedDate)/1000);
            
            var timeLeft = deadline - today;
            var days = Math.round(timeLeft/(3600*24))
            var hrs = Math.round(timeLeft / 3600);
            var mins = Math.round((timeLeft % 3600) / 60);
            //var secs = Math.round(timeLeft % 60);
            
            var timeString = '';
            
            if(days > 0) {
                timeString += days + ' days left';
            } else if (hrs > 0) {
                timeString += hrs + ' hours left';
            } else if (mins > 0) {
                timeString += mins + ' minutes left';
            } else {
                timeString += 'Time is up.';
            }
            
            var state;
            if(mins <= 0 && value.projectState != 1) {
                state = '<i class="fa fa-times-circle" style="color: #FF6F69;"></i>&nbsp;Overdue';
            } else if(value.projectState == 0) {
                state = '<i class="fa fa-circle" style="color: #FFCC5C;"></i>&nbsp;' + value.readableProjectState;
            } else if(value.projectState == 1) {
                state = '<i class="fa fa-check-circle" style="color: #00A388;"></i>&nbsp;' + value.readableProjectState;
            }
            
            list += '<li class="project-link" id="' + value.projectId + '">';
            list += '<table>';
            list += '<tr>';
            list += '<td><h6 class="no-padding"><a href="#"';
            list += '">' + value.projectName + '</a></h6></td>';
            list += '<td><p class="right small">' + state + '</p></td>';
            list += '</tr>';
            list += '</table>';
            list += '<div class="detail">';
            list += '<p class="about small">' + extract + '</p>';
            list += '<p class="time-alloted small">';
            list += '<span>Deadline : </span>';
            list += '' + timeString + '</p>';
            list += '</div>';
            list += '</li>';
            $('#projects-list > ul').prepend(list);
        });
        searchList.activate();
        searchList.emptyListCheck();
    };
    
    var communicator = app.construct({
        path : 'timesheet',
        method : 'POST',
        url : 'project/search',
        successHandler : successHandler
    });
    
    console.log(communicator);
    
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
                    communicator.serviceObject.invoke({getCreated:true});
                    searchList.emptyListCheck();
                }
                closeSearchBox(searchBox);
            }
        }
        
        else {
           var query = '%' + $('#search-box').val() + '%';
            
            if(prevQuery != query) {
                prevQuery = query;
            } else {
                return;
            }
            
            // Search using ajax
            var args = {};
            args.q = query;
            args.getCreated = true;
            args.ids = [];
            communicator.serviceObject.invoke(args);
        }
        
    });
    
    // Load initial data
    communicator.serviceObject.invoke({getCreated:true});
    searchList.emptyListCheck();
    
    // Link to the details page
    $(document).on('click', 'li.project-link', function(e) {
        e.preventDefault();
        var url = $('input#url').attr('project-details-path') + '&id=' + $(this).attr('id');
        window.location.href = url;
    });
    
});


