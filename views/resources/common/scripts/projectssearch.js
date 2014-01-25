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
                    // find projects             
                },
                function(err) {
                    console.log(err);
                }
            );
        
            service.invoke(args);
        }
        
        function emptyListChecker() {
            
            if($('#projects-list > ul').children().length < 1) {
                $('#projects-list > ul').addClass('empty-list');
            } else {
                $('#projects-list > ul').removeClass('empty-list');
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
                console.log(args.q);
                
                var url = 'project/search';
                getData(args, url); 
            }
            
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

