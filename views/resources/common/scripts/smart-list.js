// Native5 Default Application Configuration

native5.core.Service.prototype.storage = function(data) {
    var result = Object.create(this);

    

    return result;

}

/*native5.core.Service.prototype.storage = {
    ajaxData : null
};*/
var app = (function (app, native5) {
    app.registry = new native5.core.ServiceRegistry(); 
    var getService = function(url) {
        var service =  new native5.core.Service(url, this.config);
        service.successHandler = function(data) {
            this.storage.ajaxData = data;
        }
        return service;
    }
    
    app.construct = function(path, method) {
        return {
            config : {
                path: path,
                method: method,
                mode:'ui'
            },
            service : getService,
        };
    };
    
    return app;
})(app || {}, native5 || {});



var smartList = (function(smartList) {
    
    var randomColors = function() {
        var colour = ['#4cc2e4', '#FFCC5C', '#FF6F69', '#77C4D3', '#00A388', '#3085d6'];
        return colour[Math.floor(Math.random() * colour.length)];
    };
    
    smartList.createList = function(elementIdentifier) {
        var element = $(elementIdentifier);
        
        return {
            testing : function() {
                console.log("sup");
            },
            randomColors : randomColors
        };
        
    };
    
    return smartList;
    
}(smartList || {}));

