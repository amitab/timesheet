var app = (function (app, native5) {
    app.registry = new native5.core.ServiceRegistry();
    app.config = { 
        path:'timesheet',
        method:'POST',
        mode:'ui'
    };
    
    $(document).ready(function() {
        var back = [];
        var ptr = -1;
    
        function loadPage(args, url) {
            var service =  new native5.core.Service(url, app.config);
            
            service.configureHandlers(
                function(data) {
                    back.push({
                        'url' : url,
                        'args' : args,
                        'title' : data.message.page_title
                    });
                    $('.title > h5').html('&nbsp;' + data.message.page_title);
                    $('#page-wrap').html(data.message.html);
                },
                function(err) {
                    console.log(err);
                }
            );
            
            service.invoke(args);
        }
        
        $('.page-link').click(function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            var args = {};
            loadPage(args, url);
        });
        
        function firstLoad() {
            var url = 'profile';
            var args = {};
            loadPage(args, url);
        }
        
        firstLoad();
        
    });
    
    return app;
})(app || {}, native5 || {});
    
