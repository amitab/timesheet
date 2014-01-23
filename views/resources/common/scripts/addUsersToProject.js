// Native5 Default Application Configuration
var app = (function (app, native5) {
    app.registry = new native5.core.ServiceRegistry();
    app.config = { 
        path:'timesheet',   // Change the path when developing locally - same as settings.yml
        method:'POST',
        mode:'ui'
    };
    
    $(document).ready(function() {
        
        function getData(args, url) {
            var service =  new native5.core.Service(url, app.config);
        
            service.configureHandlers(
                function(data) {
                    // set the data in $('#search-results > ul'). But first create List elements.
                    var listItem;
                    $('#search-results > ul').html('');
                    $.each(data.message.users, function(key, value) {
                        listItem = '<li class="list-item" style="border-left: 4px solid green;">';
                        listItem += '<div class="wrapper">';
                        listItem += '<table><tr><td><div class="display-picture" style="margin-bottom: -8px;">';
                        listItem += '<img src="' + data.message.image_location + value.userImageUrl + '" alt="" class="image round" width="50">';
                        listItem += '</div></td><td style="text-align: center;">';
                        listItem += '<h5 style="padding-top: 0;">' + value.userName + '</h5>';
                        listItem += '</td><td class="check-input"><input class="check" name="checkbox" value="' + value.userId + '" type="checkbox"></td></tr></table></div></li>';
                        $('#search-results > ul').append(listItem);
                    });
                    emptyListChecker();
                },
                function(err) {
                    console.log(err);
                }
            );
        
            service.invoke(args);
        }
        
        function emptyListChecker() {
            if($('#selected-users > ul').children().length < 1) {
                $('#selected-users > ul').addClass('empty-list');
            } else {
                $('#selected-users > ul').removeClass('empty-list');
            }
            
            if($('#search-results > ul').children().length < 1) {
                $('#search-results > ul').addClass('empty-list');
            } else {
                $('#search-results > ul').removeClass('empty-list');
            }
        }
        
        $('#search-button').click(function(e){
            e.preventDefault();
            var query = '%' + $('#search-box').val() + '%';
            // Search using ajax
            var args = {};
            args.q = query;
            args.ids = [];
            $('#selected-users input:checkbox').each(function(index) {
                args.ids.push(parseInt($(this).attr('value')));
            });
            var url = 'project/search_to_add';
            getData(args, url);
        });
        $(document).on('click', '.check' ,function(e) {
            
            var parent = $(this).closest('li.list-item');
            parent.remove();
            
            if($(this).is(':checked')) {
                $('#selected-users > ul').append(parent);
            } else {
                // Redo Search using ajax
            }
            emptyListChecker();
        });  
        
    });
    
    return app;
})(app || {}, native5 || {});

