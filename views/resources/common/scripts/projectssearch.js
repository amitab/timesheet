$(document).ready(function() {
    
    var searchList = smartList.createList({element : '#projects-list'});
    
    // success handler must be declared before app is constructed
    
    var successHandler = function(data) {
        $('#projects-list > ul').html('');
        $.each(data.message.projects, function(key, value) {
            var list = '';
            var extract = value.projectDescription.substring(0,60) + '...';
            
            list += '<li>'
            list += '<table>'
            list += '<tr>'
            list += '<td><h6 class="no-padding"><a href="#" class="project-details" id="' + value.projectId
            list += '">' + value.projectName + '</a></h6></td>'
            list += '<td><p class="right small">Completed</p></td>'
            list += '</tr>'
            list += '</table>'
            list += '<div class="detail">'
            list += '<p class="about small">' + extract + '</p>'
            list += '<p class="time-alloted small">'
            list += '<span>Deadline : </span>'
            list += '' + value.projectTimeAlloted + '</p>'
            list += '</div>'
            list += '</li>'
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
    
    // Load initial data
    communicator.serviceObject.invoke({default:'true'});
    searchList.emptyListCheck();
    
    // Link to the details page
    $(document).on('click', 'a.project-details', function(e) {
        e.preventDefault();
        var url = $('input#url').attr('project-details-path') + '?id=' + $(this).attr('id');
        window.location.href = url;
    });
    
});


