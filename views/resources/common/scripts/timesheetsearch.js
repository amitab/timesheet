// Native5 Default Application Configuration
var app = (function (app, native5) {
    app.registry = new native5.core.ServiceRegistry();
    app.config = { 
        path:'timesheet',   // Change the path when developing locally - same as settings.yml
        method:'POST',
        mode:'ui'
    };
    
    $(document).ready(function() {
        
        var colour = ['#4cc2e4', '#FFCC5C', '#FF6F69', '#77C4D3', '#00A388', '#3085d6'];
        
        function getColor() {
           return colour[Math.floor(Math.random() * colour.length)];
        }
        
        function getData(args, url) {
            var service =  new native5.core.Service(url, app.config);
        
            service.configureHandlers(
                function(data) {
                                        
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
                $('#selected-users li').each(function(index) {
                    args.ids.push(parseInt($(this).attr('userid')));
                });
                var url = 'project/search_to_add';
                getData(args, url); 
            }
            
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
            emptyListChecker();
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
        
    });
    
    return app;
})(app || {}, native5 || {});

