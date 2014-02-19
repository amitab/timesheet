/**
* @preserve Copyright 2012 Native5
* version 0.5
* author: Native5 Solutions Inc.
*/

/**
 *	This is the parent module which holds all the custom widgets, UI elements, libraries, configurations (both client and server side), etc. done in Javascript/jQuery for Native5 Software Solutions &trade;.
 *	@module native5
*/

/**
 *	This is the container for all the core functionalities needed for Native5 Software Solutions &trade; to work.
 *	@submodule core
*/

var _gaq;


/**
 * This tool provides analytics for any application. User can choose the type of analytics to be used and have the ability to include or remove them anytime. Through this tool analytics of <b>any page</b>, <b>transaction events</b> or <b>any custom events</b> can be done.
 * @class Analytics
 * @constructor
 * @param mode {String} Defines the target on which analytics is to be performed. Mode can be `mweb` or `native`.
 * @param id {String} Key to the analytics to be used.
 * @example
		var analytics = new native5.core.Analytics('mweb', 'UA-123456-7');
*/

native5.core.Analytics = function(mode, id) {
	this.mode = mode;
	if (this.mode === 'mweb') {
		_gaq = _gaq || [];
		_gaq.push([ '_setAccount', id ]);
		_gaq.push(['_setDomainName', 'native5.com']);
	  this.localStore = new native5.core.Storage();
		this.localStore.setup({"size":5, "tables":[{"name":"analytics", "columns":[{"name":"id", "type":"INTEGER PRIMARY KEY AUTOINCREMENT"}, {"name":"type", "type":"TEXT"}, {"name":"value", "type":"TEXT"}, {"name":"time", "type":"TIMESTAMP DEFAULT CURRENT_TIMESTAMP"}]}]});
}
  var that = this;
  window.ononline = function() {
		that.localStore.find({"name":"analytics"}, [], that.syncData.bind(that));
	};
};

native5.core.Analytics.prototype.syncData = function(tx, rs) {
  console.log(" Got back online , syncing "+rs.rows.length);
	for(var i=0;i<rs.rows.length;i++) {
		var item = rs.rows.item(i);
		if(item.type==="page") this.logPageView("GA", item.value,function(){
			this.localStore.deleteDB({"name":"analytics"}, [{"id":item.id}]);
		}, function(){});
	}
}

/**
 * This method gives user ability to opt out of any/all analytics for his native/web app.
 * @method optOut
 * @param success {function} Callback function if the method is successful.
 * @param fail {function} Callback function if the method fails.
 * @param source {String} Source of analytics from which app is needed to be opted out.
 * @example
		analytics.optOut(successHandler, errorHandler, 'GA');
*/

native5.core.Analytics.prototype.optOut = function(success, fail, source) {
	return Cordova.exec(success, fail, "AnalyticsPlugin", "optOut", [ source ]);
};

/**
 * This method gives user ability to opt in to any/all analytics for his native/web app.
 * @method optIn
 * @param success {function} Callback function if the method is successful.
 * @param fail {function} Callback function if the method fails.
 * @param source {String} Source of analytics to be applied to the app.
 * @example
		analytics.optIn(successHandler, errorHandler, 'GA');
*/

native5.core.Analytics.prototype.optIn = function(source, success, fail) {
	return Cordova.exec(success, fail, "AnalyticsPlugin", "optIn", [ source ]);
};

/**
 * This method creates and starts the naalytics session to record app activity.
 * @method startSession
 * @param success {function} Callback function if the method is successful.
 * @param fail {function} Callback function if the method fails.
 * @param source {String} Source of analytics for which session is be started.
 * @example
		analytics.optOut('GA', successHandler, errorHandler);
*/

native5.core.Analytics.prototype.startSession = function(source, success, fail) {
	try {
		return Cordova.exec(success, fail, "AnalyticsPlugin",
				"startNewSession", [ source ]);
	} catch (err) {
		alert(err);
	}
};

/**
 * This method provides the log of particular page of the app.
 * @method logPageView
 * @param source {String} Source of analytics from which app is needed to be opted out.
 * @param page {String} Name of the page to be monitored.
 * @param success {function} Callback function if the method is successful.
 * @param fail {function} Callback function if the method fails.
 * @example
		analytics.logPageView('GA', toPage, successHandler, errorHandler);
*/

native5.core.Analytics.prototype.logPageView = function(source, page, success,
		fail) {
	if (this.mode === 'mweb') {
	  if(navigator.onLine || !("onLine" in navigator)) {
			_gaq.push([ '_trackPageview', page ]);
			success.call(this);
		} else {
			this.localStore.save({"tables":[{"name":"analytics", "values":{"type":"page", "value":page}}]});
		}
	} else {
		return Cordova.exec(success, fail, "AnalyticsPlugin", "logPageView", [
				source, page ]);
	}
};

/**
 * This method provides the log of user defined events for the particular app.
 * @method logEvent
 * @param source {String} Source of analytics from which app is needed to be opted out.
 * @param event {function} Custom user function.
 * @param success {function} Callback function if the method is successful.
 * @param fail {function} Callback function if the method fails.
 * @example
		analytics.logPageView('GA', userEvent, successHandler, errorHandler);
*/

native5.core.Analytics.prototype.logEvent = function(source, event, success,
		fail) {
	if (this.mode === 'mweb') {
		_gaq.push(['_setSessionCookieTimeout',300000]); // 5 mins default session cookie timeout, suited for Mobile web
		return _gaq.push('category', 'action', 'label', 'value',
				'noninteraction')
	} else {
		return Cordova.exec(success, fail, "AnalyticsPlugin", "logEvent", [
				source, event ]);
	}
};

/**
 * This method provides the log of transaction related functions for the given app.
 * @method logTransaction
 * @param source {String} Source of analytics from which app is needed to be opted out.
 * @param event {function} Transaction function on which analytics is to be done.
 * @param success {function} Callback function if the method is successful.
 * @param fail {function} Callback function if the method fails.
 * @example
		analytics.logPageView('GA', transactionEvent, successHandler, errorHandler);
*/

native5.core.Analytics.logTransaction = function(source, event, success, fail) {
	if (this.mode === 'mweb') {
		// Have to add a transaction details before this, donno why this is
		// available through the same API though.
		// Kinda stupid to mix domain with platform.
		// _gaq.push(['_trackTrans']);
	} else {
		return Cordova.exec(success, fail, "AnalyticsPlugin", "logTransaction",
				[ source, transactionData ]);
	}
};

