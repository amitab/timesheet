/**
* @preserve Copyright 2012 Native5
* This is a proprietary library defining core handlers and functions for 
* native5 client side framework. This library uses elements of JQuery for selectors
* and hence is used in tandem with it.
* native5.core.js
* version 0.5
* author: Native5 Solutions Inc.
*/

/** @define {boolean} */
var DEBUG = true;

var native5 = {
	core:{},
	utils:{},
	ui:{}	
};

/**
 * Service 
 * @constructor 
 */ 
native5.core.Service=function(service_name, config) {
	var that = this;
	this.name = service_name;
	this.method = config.method;
	this.config = config;
	
	this.successHandler = function(response) {
		if(response.redirect) {
			if(app.loader)
				app.loader.hideLoadingMessage();
			window.location.href = response.redirect;
			return;
		}
		that.successCallback(response);
	};
	this.successCallback = function(data) {
		if(that.config.toPage) {
			app.loader.hideLoadingMessage();
			if(app.currentPage == 'Home')
				return;
			var pageToShow = "#"+that.config.toPage;
			$.mobile.changePage(pageToShow);
			app.currentPage = that.config.toPage;
			$(pageToShow+' div[data-role="content"]').empty();
			$(pageToShow+' div[data-role="content"]').append(data.message);
			updateServiceRegistry();
		}
	};
	this.errorCallback = native5.core.defaultHandler;
};

/**
 * @this {native5.Service} 
 * @param {function} successCallback
 * @param {function} errorCallback
*/
native5.core.Service.prototype.invoke = function(dataObj) {
	var url_to_invoke = location.protocol+"//"+location.hostname+"/"+this.config.path+"/"+this.name;
	if(DEBUG) console.log("Invoking Service call to "+url_to_invoke);
	data = {};
	if(dataObj) {
		if(typeof dataObj == 'object') {
			data = dataObj;	
		} else { 
			try {	
				myData = $.parseJSON(dataObj);
			} catch(err) {
				myData={feed:dataObj};
			}
			data = myData;
		}
	}
	data.mode =this.config.mode;
	data.count =this.config.count;
	if(app.loader)
		app.loader.showLoadingMessage();
	if(app.token != undefined) 
		data.rand_token = app.token; 
	// Handling history
	if(app && app.currentService)
		data["N5_NAME"]= app.currentService;
	window.history.replaceState(data, null, window.location.href);
	if(app) app.currentService = this.name;
	$.ajax({
		url:url_to_invoke,
		type:this.method,
		data:data,
		dataType:"json",
		success:this.successHandler,
		error:this.errorCallback
	});
	return false;
};

/**
 * @this {native5.Service} 
 * @param {function} successCallback
 * @param {function} errorCallback
*/
native5.core.Service.prototype.configureHandlers = function(successHandler, errorHandler) {
	this.successCallback = successHandler;
	this.errorCallback = errorHandler;
};

native5.core.Service.prototype["invoke"]=native5.core.Service.prototype.invoke;

native5.core.defaultHandler = function(data) {
	alert("No or incorrect handler defined for service response");
        if(DEBUG) console.log(data.message);
}

/**
 * ServiceRegistry 
 * @constructor 
 */ 
native5.core.ServiceRegistry= function() {
	this.services = new Array();
	if ( arguments.callee._singletonInstance )
    		return arguments.callee._singletonInstance;
  	arguments.callee._singletonInstance = this;
}

native5.core.ServiceRegistry.prototype.addService = function(name, service) {
	// Can add in some validation like throwing an alert/error signalling that service with same name already exists.
	if(!this.services[name])
		this.services[name]=service;
}

native5.core.ServiceRegistry.prototype.getService = function(name) {
	return this.services[name];
}

native5.core.ServiceRegistry.prototype.update= function() {
	var self = this;
  $("a[service]").each(function(index) {
      var name = $(this).attr("service");
      var config = $.extend(true, {}, app.config);
      config.method = $(this).attr("method")?$(this).attr("method"):"post";
      var service = new native5.core.Service(
          name,
          config);
    if($(this).attr("handler"))
        service.configureHandlers(window[$(this).attr("handler")], errorHandler);
      self.addService(name, service);
  });

  $("a[service]").each(function() {$(this).off('click');});
  $("a[service]").on("click", function(e) {
    if($(this).attr("data-program")=="true")
                        return;
    e.preventDefault();
    var serviceToCall = self.getService($(this).attr("service"));
    var data = $(this).attr("service-data")
    if(DEBUG)
      if(!serviceToCall) {
        alert("No service with given name found");
        return;
      }
    serviceToCall.invoke(data);
		e.preventDefault();
		return false;
  });
	$('form').each(function(index, elem) {
		if($(elem).attr('data-ajax') == 'true') {
			$(elem).submit(function() {
				// Ajax Post
				var opts = {};
				opts['Method'] = $(elem).attr('method');
				opts['URL']= app.config.proto+"://"+app.config.host+"/"+app.config.path+"/"+$(elem).attr('action');
				var sHandler = $(elem).attr("data-success");
				$.ajax({
					type:opts['Method'],
					url:opts['URL'],
					data:$(elem).serialize(),
					dataType:"json",
					success:window[sHandler],
					error: errorHandler
				});
				return false;
			});
		}
	});
}


$(document).ready(function() {
	app.registry.update();
});
