/*!
* Native5 UX SDK - v0.0.2 - 2013-11-08
* http://docs.native5.com
* Copyright (c) 2013 ;  Licensed Native5 
*/

/**
 * Usage :
 *
 *  app.config = {
 *      path:'app-base-path',
 *      method:'POST',
 *  }
 *  
 *  var notifyService = new native5.core.Service("/notify", app.config);
 *  notifyService.invoke(data);
 *
 */
var native5 = {};

(function(jQuery, native5) {
    native5.core = native5.core || {};
    native5.core.Service = function(service_name, config) {
        var that = this;
        this.name = service_name;
        this.method = config.method;
        this.config = config;

        var successHandler = function(response) {
            if (response.redirect) {
                if (app.loader) app.loader.hideLoadingMessage();
                window.location.href = response.redirect;
                return;
            }
            if (that.successCallback) that.successCallback(response);
        };

        var defaultSuccessCallback = function(data) {
            if (that.config.toPage) {
                native5.notifier.hideProgress();
                if (app.currentPage == 'Home') return;
                var pageToShow = "#" + that.config.toPage;
                $.mobile.changePage(pageToShow);
                app.currentPage = that.config.toPage;
                $(pageToShow + ' div[data-role="content"]').empty();
                $(pageToShow + ' div[data-role="content"]').append(data.message);
                updateServiceRegistry();
            }
        };
        this.errorCallback = native5.core.defaultHandler;

        this.invoke = function(dataObj) {
            var url_to_invoke = this.name;
            if(!(/^http:\/\//.test(url_to_invoke)) && !(/^https:\/\//.test(url_to_invoke)))
                url_to_invoke = location.protocol + "//" + location.hostname + "/" + this.config.path + "/" + this.name;
            data = {};
            if (dataObj) {
                if (typeof dataObj == 'object') {
                    data = dataObj;
                } else if(typeof dataObj == 'string') {
                    try {
                        myData = $.parseJSON(dataObj);
                    } catch(err) {
                        myData = {
                            feed: dataObj
                        };
                    }
                    data = myData;
                }
            }
            data.mode = this.config.mode;
            data.count = this.config.count;
            if (app.loader) app.loader.showLoadingMessage();
            if (app.token !== undefined) data.rand_token = app.token;
            // Handling history
            if (app && app.currentService) data['N5_NAME'] = app.currentService;
            //window.history.replaceState(data, null, window.location.href);
            if (app) app.currentService = this.name;
            var request = $.ajax({
                url: url_to_invoke,
                type: this.method,
                data: data,
                dataType: "json"
            });
            if (successHandler) request.done(successHandler);
            if (this.errorCallback) request.fail(this.errorCallback);
            return request;
        };

        this.configureHandlers = function(successHandler, errorHandler) {
            this.successCallback = successHandler;
            this.errorCallback = errorHandler;
        };

        this.defaultHandler = function(data) {
            alert("No or incorrect handler defined for service response");
            if (DEBUG) console.log(data.message);
        };
    };

    native5.core.ServiceRegistry = function() {
        this.services = [];
        if (arguments.callee._singletonInstance) return arguments.callee._singletonInstance;
        arguments.callee._singletonInstance = this;

        this.addService = function(name, service) {
            // Can add in some validation like throwing an alert/error signalling that service with same name already exists.
            if (!this.services[name]) this.services[name] = service;
        };

        this.getService = function(name) {
            return this.services[name];
        };
    };
})($, native5);

/**
 *	This is the parent module which holds all the custom widgets, UI elements, libraries, configurations (both client and server side), etc. done in Javascript/jQuery for Native5 Software Solutions &trade;.
 *	@module native5
*/

/**
 *	This is the container for all the core functionalities needed for Native5 Software Solutions &trade; to work.
 *	@submodule core
*/

var _gaq;

(function(native5) {

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
			this.localStore.delete({"name":"analytics"}, [{"id":item.id}]);
		}, function(){});
	}
};

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
				'noninteraction');
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

})(native5 || {});// end of define

(function(jQuery, native5) {
    native5.data = native5.data || {};
    native5.data.LocalStore = function() {
        this.db = {};
        this.db.name = "native5";
        this.db.desc = "Default Database";
        this.db.size = 5 * 1024 * 1024;

        this.setup = function(config) {
            var deferred = $.Deferred();
            if (config) {
                if (config.name !== undefined) this.db.name = config.name;
                if (config.desc !== undefined) this.db.desc = config.desc;
                if (config.size) this.db.size = config.size;
                if (config.tables) this.db.tables = config.tables;
            }
            this.database = openDatabase(this.db.name, '', this.db.desc, this.db.size);
            for (i = 0; i < this.db.tables.length; i++) {
                table = this.db.tables[i];

                sql = "create table if not exists " + table.name + "(";
                for (j = 0; j < table.columns.length; j++) {
                    column = table.columns[j];
                    sql += column.name + " " + column.type;
                    if (column.primary == 'true') sql += " PRIMARY KEY";
                    if (column.autoincrement) sql += ' AUTOINCREMENT';
                    sql = sql + ",";
                }
                sql = sql.substring(0, sql.length - 1) + ")";
                console.log(sql);
                this.database.transaction(function(tx) {
                    tx.executeSql(sql, [], function(tx, rs) {
                        console.log(rs);
                        deferred.resolve();
                    },
                    function(tx, e) {
                        console.log(e.message);
                        deferred.reject();
                    });
                });
            }
            return deferred.promise();
        };

        this.save = function(data, callback) {
            var deferred = $.Deferred();
            var d = new Date();
            var tablesToSave = this.db.tables;
            if(data.tables !== undefined) {
                tablesToSave = data.tables;
            }
            for (i = 0; i < tablesToSave.length; i++) {
                table = tablesToSave[i];
                console.log(table.name);
                insertSQL = "insert into " + table.name + "(";
                valStr = "values(";
                vals = [];
                for (var idx=0;idx<table.columns.length;idx++) {
                    var key =  table.columns[idx].name;
                    if(key != 'id') {
                        insertSQL += key + ",";
                        valStr += "?,";
                        vals.push(data[key]);
                    }
                }
                insertSQL = insertSQL.substring(0, insertSQL.length - 1);
                valStr = valStr.substring(0, valStr.length - 1);
                insertSQL += ") " + valStr + ")";
                console.log(insertSQL);
                this.database.transaction(function(tx) {
                    tx.executeSql(insertSQL, vals, callback, function(tx, e) {
                        console.log(e.message);
                        deferred.reject(e.message);
                    });
                });
            }
            return deferred.promise();
        };

        this.update = function(data, filters, callback) {
            var deferred = $.Deferred();
            var d = new Date;
            for (i = 0; i < data.tables.length; i++) {
                table = data.tables[i];
                uSQL = "update " + table.name + " set ";
                for (var key in table.values) {
                    uSQL += key + "=" + table.values[key] + ",";
                }
                uSQL = uSQL.substring(0, uSQL.length - 1);
                options = new Array();
                if (filters) {
                    for (i = 0; i < filters.length; i++) {
                        filter = filters[i];
                        if (filter) {
                            clause = " where ";
                            for (var i in filter) {
                                key = i;
                                if (filter.exact) {
                                    options.push(filter[i]);
                                    clause += key + " = ? and";
                                } else {
                                    fil = filter[i].trim();
                                    fil = "%" + fil.replace("*", "%") + "%";
                                    options.push(fil);
                                    clause += key + " like ? and";
                                }
                            }
                        }
                    }
                }
                clause = clause.substring(0, clause.lastIndexOf(" and"));
                uSQL = uSQL + clause;
                console.log(uSQL);
                this.database.transaction(function(tx) {
                    tx.executeSql(uSQL, options, callback, function(tx, e) {
                        console.log(e.message);
                        deferred.reject(e.message);
                    });
                });
            }
            return deferred.promise();
        };

        this.find = function(table, filters, callback) {
            var deferred = $.Deferred();
            selectC = "select * from " + table.name;
            options = new Array();
            if (filters) {
                for (i = 0; i < filters.length; i++) {
                    filter = filters[i];
                    if (filter) {
                        clause = " where ";
                        for (var i in filter) {
                            key = i;
                            if (key != "exact") {
                                if (filter.exact) {
                                    options.push(filter[i]);
                                    clause += key + " = ? and";
                                } else {
                                    fil = filter[i].trim();
                                    fil = "%" + fil.replace("*", "%") + "%";
                                    options.push(fil);
                                    clause += key + " like ? and";
                                }
                            }
                        }
                        clause = clause.substring(0, clause.lastIndexOf(" and"));
                        selectC = selectC + clause;
                    }
                }
            }
            this.database.transaction(function(tx) {
                tx.executeSql(selectC, options, callback);
            });
        };

        this.findUpdated = function(callback) {
            filters = new Array();
            filter = {};
            filter.updated = 1;
            filter.exact = 1;
            filters.push(filter);
            this.find(filter, callback);
        };

        this.deleteDB = function(table, filters, callback) {
            deleteC = "delete from " + table.name;
            options = new Array();
            if (filters) {
                for (i = 0; i < filters.length; i++) {
                    filter = filters[i];
                    if (filter) {
                        clause = " where ";
                        for (var i in filter) {
                            key = i;
                            if (filter[i] instanceof Array) {
                                clause += table.name + "." + key + " in (";
                                for (var j in filter[i]) {
                                    options.push(filter[i][j]);
                                    clause += "?,"
                                }
                                clause = clause.substring(0, clause.length - 1);
                                clause += ") and";
                            } else {
                                options.push(filter[i]);
                                clause += table.name + "." + key + " = ? and";
                            }
                        }
                        clause = clause.substring(0, clause.lastIndexOf(" and"));
                        deleteC = deleteC + clause;
                    }
                }
            }
            console.log(deleteC);
            this.database.transaction(function(tx) {
                tx.executeSql(deleteC, options, callback, function(tx, e) {
                    console.log("Error happened " + e);
                });
            });
        };
    };

})($, native5);

var native5 = (function($, native5) {
    native5.data = native5.data || {};


    var saveAsync = function(stores, data) {
        var deferreds = [];
        for(var i = 0; i<stores.length; i++) {
            deferreds.push(stores[i].save(data));
        }

        return deferreds;
    };

    var searchAsync = function(stores, data) {
        var deferreds = [];
        for(var i = 0; i<stores.length; i++) {
            deferreds.push(stores[i].find(data));
        }

        return deferreds;
    };

    var randomString = function() {
        var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
        var string_length = 8;
        var randomstring = '';
        for (var i=0; i<string_length; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum,rnum+1);
        }
        return randomstring;
    };
    
    native5.data.Events = {
        // bind Custom Events, with Listeners
        on : function(name, callback) {
            this._events || (this._events = {});
            var attachedEvent = this._events[name] || (this._events[name] = []);
            attachedEvent.push({callback:callback});
            return this;
        },

        // Removes all callbacks with event if callback is empty.
        // if name == undefined, remove all callbacks 
        remove : function(name, callback) {
            if(!name) {
                this._events = {};
                return this;
            }
            if (events = this._events[name]) {
                delete this._events[name];
            }
        },

        // trigger a particular event by name, execute attached listeners
        trigger : function(evtName) {
            if (!this._events) return this;
            var args = [].slice.call(arguments, 1);
            var events = this._events[evtName];
            if(events) {
                for(var i=0;i<events.length; i++) {
                    events[i].callback.apply(this, args);
                }
            }
            return this;
        }
    };

    native5.data.Model = function(rawData, opts) {
        this.src = rawData;
        var stores = [];
        var validators = [];
        var validationErrors = [];
        var syncing = false;
        var dataToSync = [];

        if(opts && opts.store) {
            if(opts.store.local) {
                var localStore = new native5.data.LocalStore();
                var dataCols = [{
                    name : 'id',
                         type : 'INTEGER PRIMARY KEY AUTOINCREMENT'
                }];
                for (var key in this.src) {
                    if (this.src.hasOwnProperty(key)) {
                        var elem = {
                            name : key,
                            type : 'TEXT'
                        };
                        dataCols.push(elem);
                    }
                }
                localStore.setup({
                    tables: [{
                        name: randomString(),
                    columns : dataCols
                    }]
                });
                stores.push(localStore);
            }
            if(opts.store.remote) {
                stores.push(new native5.data.RemoteStore(opts.store.remote));
            }
        }


        var sync = function(data) {
            if(!data) {
                data = dataToSync;
            }
            //if(!syncing) {
                syncing = true;
                var deferred = $.Deferred();
                $.when.apply($, saveAsync(stores, data))
                    .then(
                            function(){
                            }, 
                            function() {
                                var failureReason = {
                                    code : 500,
                        message : Array.prototype.slice.call(arguments)
                                };
                                syncing = false;
                                deferred.reject(failureReason);
                            });
                return deferred;
            //} else {
                //var that 
                //setTimeout(this.trigger('sync'), 500); 
            //}
        };

        this.save = function(data) {
            if(!data)
                data = this.src;
            var isValid = this.validate();
            var deferred = $.Deferred();
            if(isValid) {
                $.when.apply($, saveAsync(stores, data)).then(function(){
                    deferred.resolve(Array.prototype.slice.call(arguments));
                }, function() {
                    var failureReason = {
                        code : 500,
                    message : Array.prototype.slice.call(arguments)
                    };
                    deferred.reject(failureReason);
                });
            } else {
                var failureReason = {
                    code : 206,
                    message : validationErrors
                };
                deferred.reject(failureReason); 
            } 
            return deferred;
        };

        this.on('sync', sync);

        this.find = function(pattern) {
            var deferred = $.Deferred();
            $.when.apply($, searchAsync(stores,pattern)).then(function(){
                deferred.resolve(Array.prototype.slice.call(arguments));
            }, function() {
                var failureReason = {
                    code : 500,
                message : Array.prototype.slice.call(arguments)
                };
                deferred.reject(failureReason);
            });
            return deferred;
        };

        this.bindValidator = function(validator) {
            validators.push(validator);
        };

        this.validate = function() {
            validationErrors = [];
            for(var i=0;i<validators.length;i++) {
                if(validators[i].isRun()) {
                    validationErrors.push.apply(validationErrors, validators[i].validate(this.src));
                }
            }
            if(validationErrors.length > 0)
                return false;
            return true;
        };
        return this;
    };


    $.extend(
            native5.data.Model.prototype, 
            native5.data.Events, {
                // set model property value, trigger change event
                set : function(val) {
                    var oldValue = {};
                    for(var key in val) {
                        if(val.hasOwnProperty(key)) {
                            oldValue[key] = this.src[key];
                            this.src[key] = val[key];
                        }
                    }
                    this.trigger('change', this, key, oldValue, val);
                    this.trigger('sync', val);
                },

                // get model source
                get : function() {
                    return this.src;
                }
            });


    native5.data.Collection = function(opts) {
        this.elems = [];
        var stores = [];
        var validators = [];
        var validationErrors = [];
        var syncing = false;
        var dataToSync = [];
        var syncCall = $.Deferred();

        if(opts && opts.store) {
            if(opts.store.local) {
                var localStore = new native5.data.LocalStore();
                var dataCols = [{
                    name : 'id',
                         type : 'INTEGER PRIMARY KEY AUTOINCREMENT'
                }];
                for (var key in this.src) {
                    if (this.src.hasOwnProperty(key)) {
                        var elem = {
                            name : key,
                            type : 'TEXT'
                        };
                        dataCols.push(elem);
                    }
                }
                localStore.setup({
                    tables: [{
                        name: randomString(),
                    columns : dataCols
                    }]
                });
                stores.push(localStore);
            }
            if(opts.store.remote) {
                stores.push(new native5.data.RemoteStore(opts.store.remote));
            }
        }


        var sync = function(data) {
            var that = this;
            //if(!syncing) {
                if(!data) {
                    data = this.elems;
                }
                
                var syncData = [];
                if (data instanceof Array) {
                    syncData = data;
                } else {
                    syncData.push(data);
                }

                var deferred = $.Deferred();
                $.when.apply($, saveAsync(stores, syncData))
                    .then(
                            function() {
                                deferred.resolve(Array.prototype.slice.call(arguments));
                                syncing = false;
                                that.trigger('synced');
                            }, 
                            function() {
                                var failureReason = {
                                    code : 500,
                                    message : Array.prototype.slice.call(arguments)
                                };
                                syncing = false;
                                deferred.reject(failureReason);
                            });
                if(syncing) {
                    syncCall = $.when(syncCall, deferred);
                } else {
                    syncCall = deferred;
                }
                syncing = true;
                return syncCall;
            //} else {
                //if(data) {
                    //dataToSync.push(data);
                //}
                
                //setTimeout( function() {
                   //that.trigger('sync'); 
                //}, 2500);
            //}
        };

        this.save = function(data) {
            var deferred = $.Deferred();
            $.when.apply($, saveAsync(stores, data)).then(function(){
                    deferred.resolve(Array.prototype.slice.call(arguments));
            }, function() {
                    var failureReason = {
                        code : 500,
                    message : Array.prototype.slice.call(arguments)
                    };
                    deferred.reject(failureReason);
            });
            return deferred;
        };

        this.on('sync', sync);
        this.on('added', sync);
        this.on('updated', sync);

        this.find = function(pattern) {
            var deferred = $.Deferred();
            $.when.apply($, searchAsync(stores, pattern)).then(function(){
                deferred.resolve(Array.prototype.slice.call(arguments));
            }, function() {
                var failureReason = {
                    code : 500,
                message : Array.prototype.slice.call(arguments)
                };
                deferred.reject(failureReason);
            });
            return deferred;
        };
        
        this.bindValidator = function(validator) {
            validators.push(validator);
        };

        this.validate = function() {
            validationErrors = [];
            for(var i=0;i<validators.length;i++) {
                if(validators[i].isRun()) {
                    validationErrors.push.apply(validationErrors, validators[i].validate(this.src));
                }
            }
            if(validationErrors.length > 0)
                return false;
            return true;
        };
    };

    $.extend(
            native5.data.Collection.prototype,
            native5.data.Events, {
                add : function(row) {
                    this.elems.push(row);
                    var idx = this.elems.length - 1;
                    this.trigger('added', row);
                    return idx;
                },
                update : function(idx, row) {
                    if(!this.elems[idx]) {
                        this.elems[idx] = row;
                    } else {
                        for(var key in row) {
                            if(row.hasOwnProperty(key)) {
                                this.elems[idx][key] = row[key];
                            }
                        }
                    }
                    this.trigger('updated', row);
                    return idx;
                },
                getAt : function(idx) {
                    return this.elems[idx];
                }
            });
    return native5;
})(jQuery, native5 || {});

var native5 = (function($, native5) {
    native5.data = native5.data || {};

    native5.data.RemoteStore = function(opts) {
        var remoteOpts = opts;
        var method = opts.method || "POST";

        this.save = function(saveData) {
            return $.ajax({
                   url : remoteOpts.url,
                   method:method,
                   data: {data: JSON.stringify(saveData)}
            });
        };

        this.find = function(pattern) {
            return $.ajax({
                url : remoteOpts.findURL,
                type : 'GET',
                data: {data: JSON.stringify(pattern)}
            });
        };
    };

    return native5;
})(jQuery, native5 || {});

var native5 = (function($, native5, klass) {
    native5.ui = native5.ui||{};

    native5.ui.UIComponent = klass(function(options) {
        this.refresh          = options.refresh||'none';
        this.view	      = this.getView(); 
        this.supportedActions = [];
        this.model            = options.model;
        this.init();

        // TODO:
        // Elements of a Component (Views, Model, Actions)
        // Sub-Components (Composite pattern)
        // Views (Layouts, Elements)
        // Model - View binding (Trigger Change in Model, view auto-updated)
        // Add CSS Layouts i.e Grid, Table, Fluid etc. 
    })
    .methods({
        init:function() {
            this.supportedActions.push('change');
            this.supportedActions.push('swipe');
        },
        render:function() {
            throw { 
                name : "Syntax Error",
                level : "ERROR",
                message : "Base UIComponent cannot be rendered"
            };
            // TODO: Attach view to page
        },
        refresh:function() {

        },
        getModel:function() {
            return this.model;	
        },
        updateData:function(data) {
            // update View
        },
        addView:function(view) {
            if(view.supports(this.model)) {
                this.views.push(view);
            }
        },
        getView:							function() {
            return document.createElement('div');	
        },
        addAction: function(action, handler) {
            this.supportedActions.push(action);
            $(this).on(action, function(evt) {
                handler();
            });
        },
        getSupportedActions:	function(element) {
            return this.supportedActions;
        },
        setRoute:	function(routeOptions) {
            this.route = routeOptions;		
        }
    });
    return native5;
}(jQuery, native5||{}, klass) );

/**
 *	This is the parent module which holds all the custom widgets, UI elements, libraries, configurations (both client and server side), etc. done in Javascript/jQuery for Native5 Software Solutions &trade;.
 *	@module native5
 */

/**
 *	This is the container for all the custom UI elements and widgets created by Native5 Software Solutions &trade;.
 *	@submodule ui
 */

var native5=(function($, native5) {

    /**
     *	This widget creates Path like circular menu - that is, on click of button the menu opens up in a circular manner. Based on the requirements, it can be full circular, semi-circular or on any arc.
     *	@class CircleMenu
     *	@constructor
     *	@param element {Object} `HTML DOM element` which will be converted to circular menu.
     *	@param [options] {Object} Options which can be used to modify the ImageGallery as per the need.
     *	@param [options.depth=0] {Number} Starting z-index of the eleemnt.
     *	@param [options.item_diameter=30] {Number} Diameter of each item of circular menu. Helps setting width, height and border-radius property.
     *	@param [options.circle_radius=80] {Number} Radius of circle to be formed.
     *	@param [options.start_angle=0] {Number} Angle at which first element gets expanded when menu opens.
     *	@param [options.end_angle=90] {Number} Angle at which last element expands to when menu opens.
     *	@param [options.speed=500] {Number} Animation speed (in ms).
     *	@param [options.delay=1000] {Number} In case of hover (auto collapse), it's the time (in ms) after the wiget falls back to initial state.
     *	@param [options.step_out=20] {Number} Number of milliseconds when the next element gets out after circle menu is opened. Negative value indicates reverse direction.
     *	@param [options.step_in=-20] {Number} Number of milliseconds when the next element gets in after circle menu is closed. Negative value indicates reverse direction.
     *	@param [options.trigger='click'] {String} Determines which function to be assigned to open/close circular menu. Options can be `click` or `hover`.
     *	@param [options.transition_function='ease'] {String} Determines which transition function to use while opening/closing circular menu.
     *	@param [options.direction='bottom-right'] {String} Determines the direction in which the circular menu will open, assuming the close state is at (0,0). Options can be - `top`, `left`, `right`, `bottom`, `top-right`, `top-left`, `bottom-right`, `bottom-left`, `top-half`, `right-half`, `bottom-half`, `left-half`, full.
     *	@example
     *		var cmenu = new native5.ui.circlemenu(element,{direction:'bottom-right'});
     */

    native5.ui.CircleMenu = function(element, options) {
        if (!element) return null;

        this.pluginName = 'circlemenu';
        this.options = options || {};
        this.depth = this.options.depth || 0;
        this.item_diameter = this.options.item_diameter || 30;
        this.circle_radius = this.options.circle_radius || 80;
        this.start_angle = this.options.start_angle || 0;
        this.end_angle = this.options.end_angle || 90;
        this.speed = this.options.speed || 500;
        this.delay = this.options.delay || 1000;
        this.step_out = this.options.step_out || 20;
        this.step_in = this.options.step_in || -20;
        this.trigger = this.options.trigger || 'click';
        this.transition_function = this.options.transition_function || 'ease';
        this.direction = this.options.direction || 'bottom-right';

        this._timeouts = [];
        this.element = $(element);
        this.init();
        this.hook();
    };

    native5.ui.CircleMenu.prototype = {
        vendorPrefixes: function(items,prop,value){
            ['-webkit-','-moz-','-o-','-ms-',''].forEach(function(prefix){
                items.css(prefix+prop,value);
            });
        },
        init: function() {
            var self = this,
            directions = {
                'bottom-left':[180,90],
                'bottom':[135,45],
                'right':[-45,45],
                'left':[225,135],
                'top':[225,315],
                'bottom-half':[180,0],
                'right-half':[-90,90],
                'left-half':[270,90],
                'top-half':[180,360],
                'top-left':[270,180],
                'top-right':[270,360],
                'full':[-90,270-Math.floor(360/(self.element.children('li').length - 1))],
                'bottom-right':[0,90]
            },
            dir;

            self._state = 'closed';
            self.element.addClass(self.pluginName+'-closed');

            if(typeof self.direction === 'string'){
                dir = directions[self.direction.toLowerCase()];
                if(dir){
                    self.start_angle = dir[0];
                    self.end_angle = dir[1];
                }
            }

            self.menu_items = self.element.children('li:not(:first-child)');
            self.initCss();
            self.item_count = self.menu_items.length;
            self._step = (self.end_angle - self.start_angle) / (self.item_count-1);
            self.menu_items.each(function(index){
                var $item = $(this),
                angle = (self.start_angle + (self._step * index)) * (Math.PI/180),
                x = Math.round(self.circle_radius * Math.cos(angle)),
                y = Math.round(self.circle_radius * Math.sin(angle));

            $item.data('plugin_'+self.pluginName+'-pos-x', x);
            $item.data('plugin_'+self.pluginName+'-pos-y', y);
            $item.click(function(){
                self.select(index+2);
            });
            });

            // Initialize event hooks from options
            ['open','close','init','select'].forEach(function(evt){
                var fn;

                if(self.options[evt]){
                    fn = self.options[evt];
                    self.element.on(self.pluginName+'-'+evt, function(){
                        return fn.apply(self,arguments);
                    });
                    delete self.options[evt];
                }
            });

            // self.init();
        },
        trigger: function() {
            var _this = this;
            var args = [],
                i, len;

            for(i = 0, len = arguments.length; i < len; i++){
                args.push(arguments[i]);
            }
            _this.element.trigger(_this.pluginName+'-'+args.shift(), args);
        },
        hook: function() {
            var self = this;

            if(self.trigger === 'hover'){
                self.element.on('mouseenter',function(evt){
                    self.open();
                }).on('mouseleave',function(evt){
                    self.close();
                });
            }else if(self.trigger === 'click'){
                self.element.children('li:first-child').on('click',function(evt){
                    evt.preventDefault();
                    if(self._state === 'closed' || self._state === 'closing'){
                        self.open();
                    }else{
                        self.close(true);
                    }
                    return false;
                });
            }else if(self.trigger === 'none'){
                // Do nothing
            }
        },


        /**
         *	This method allows to open the circualr menu through the trigger method set while creating circle menu object. This method modifies `_state` variable which helps in determining the state of circle menu (open/closed).
         *	This assumes no argument while invoking.
         *	@method open
         *	@return {Object} element
         *	@example
         *		cmenu.open();
         */
        open: function() {
            var self = this,
            $self = this.element,
            start = 0,
            set;

            self.clearTimeouts();
            if(self._state === 'open') return self;
            $self.addClass(self.pluginName+'-open');
            $self.removeClass(self.pluginName+'-closed');
            if(self.step_out >= 0){
                set = self.menu_items;
            }else{
                set = $(self.menu_items.get().reverse());
            }
            set.each(function(index){
                var $item = $(this);

                self._timeouts.push(setTimeout(function(){
                    $item.css({
                        left: $item.data('plugin_'+self.pluginName+'-pos-x')+'px',
                        top: $item.data('plugin_'+self.pluginName+'-pos-y')+'px'
                    });
                    self.vendorPrefixes($item,'transform','scale(1)');
                }, start + Math.abs(self.step_out) * index));
            });
            self._timeouts.push(setTimeout(function(){
                if(self._state === 'opening') self.open();
                self._state = 'open';
            },start+Math.abs(self.step_out) * set.length));
            self._state = 'opening';
            return self;
        },


        /**
         *	This method allows to close the circualr menu through the trigger method set while creating circle menu object. This method modifies `_state` variable which helps in determining the state of circle menu (open/closed).
         *	This assumes no argument while invoking.
         *	@method close
         *	@param [immediate] {Boolean} If set to true, the circle menu closes immediately. Else it'll wait for timeout.
         *	@return {Object} element
         *	@example
         *		cmenu.close();
         */
        close: function(immediate) {
            var self = this,
            $self = this.element,
            do_animation = function do_animation(){
                var start = 0,
                set;

                self.clearTimeouts();
                if(self._state === 'closed') return self;
                if(self.step_in >= 0){
                    set = self.menu_items;
                }else{
                    set = $(self.menu_items.get().reverse());
                }
                set.each(function(index){
                    var $item = $(this);

                    self._timeouts.push(setTimeout(function(){
                        $item.css({top:0,left:0});
                        self.vendorPrefixes($item,'transform','scale(.5)');
                    }, start + Math.abs(self.step_in) * index));
                });
                self._timeouts.push(setTimeout(function(){
                    if(self._state === 'closing') self.close();
                    self._state = 'closed';
                },start+Math.abs(self.step_in) * set.length));
                $self.removeClass(self.pluginName+'-open');
                $self.addClass(self.pluginName+'-closed');
                self._state = 'closing';
                return self;
            };
            if(immediate){
                do_animation();
            }else{
                self._timeouts.push(setTimeout(do_animation,self.delay));
            }
            return this;
        },
        select: function(index) {
            var self = this,
            selected, set_other;

            if(self._state === 'open' || self._state === 'opening'){
                self.clearTimeouts();
                set_other = self.element.children('li:not(:nth-child('+index+'),:first-child)');
                selected = self.element.children('li:nth-child('+index+')');
                        self.vendorPrefixes(selected.add(set_other), 'transition', 'all 500ms ease-out');
                        self.vendorPrefixes(selected, 'transform', 'scale(2)');
                        self.vendorPrefixes(set_other, 'transform', 'scale(0)');
                        selected.css('opacity','0');
                        set_other.css('opacity','0');
                        self.element.removeClass(self.pluginName+'-open');
                        setTimeout(function(){self.initCss();},500);
                        }
                        },
                        clearTimeouts: function() {
                            var timeout;

                            do {
                                clearTimeout(timeout);
                            } while(timeout != this._timeouts.shift());
                        },
                        initCss: function() {
                            var self = this, 
                         $items;

                            self._state = 'closed';
                            self.element.removeClass(self.pluginName+'-open');
                            self.element.css({
                                'list-style': 'none',
                                'margin': 0,
                                'padding': 0,
                                'width': self.item_diameter+'px'
                            });
                            $items = self.element.children('li');
                            $items.attr('style','');
                            $items.css({
                                'display': 'block',
                                'width': self.item_diameter+'px',
                                'height': self.item_diameter+'px',
                                'text-align': 'center',
                                'line-height': self.item_diameter+'px',
                                'position': 'absolute',
                                'z-index': 1,
                                'opacity': ''
                            });
                            self.element.children('li:first-child').css({'z-index': 1000-self.depth});
                            self.menu_items.css({
                                top:0,
                                left:0
                            });
                            self.vendorPrefixes($items, 'border-radius', self.item_diameter+'px');
                            self.vendorPrefixes(self.menu_items, 'transform', 'scale(.5)');
                            setTimeout(function(){
                                self.vendorPrefixes($items, 'transition', 'all '+self.speed+'ms '+self.transition_function);
                            },0);
                        }
    };
    return native5;
})(jQuery, native5);

/**
 * This is set of functions that enables drag and drop capability to any HTML DOM Element. A draggable widget can move with the user touch input whereas a droppable widget is an element where draggable widget can interact (dropped, removed of the DOM, etc.).
 * @class jQuery
*/
 
var dragElements = [];
var dragInitPos = [];
var dropElements = [];

// var dragType, dropObject, dragCallback;

$.fn.extend ({
	
	/**
	 *	This jQuery method makes the element draggable, i.e. it adds touch events to the element and on touch cancel (end of the drag), fires the callback function if provided by the user.
	 *	@method setDraggable
	 *  @param [options] {Object} Contains the array of optional parameters.
	 *	@param [options.callback=null] {function} Callback function which will be fired on completion of drag.
	 *	@example
	 *		$(element).setDraggable({callback: function() {console.log("Successful drag.")}});
	*/ 
	setDraggable: function(options) {
		var opts = options || {};
		dragCallback = opts.callback || null;
		
		$(this).bind('touchstart mousedown', startDrag);
		dragElements.push($(this));
		dragInitPos.push([$(this).offset().left, $(this).offset().top]);
	},
	
	/**
	 *	This jQuery method checks whether the element is Draggable or not. Return true if the element is draggable. This assumes no parameter.
	 *	@method isDraggable
	 *  @return {Boolean}
	 *	@example
	 *		$(element).isDraggable();
	*/ 
	isDraggable: function() {
		var result = false;
		var obj = $(this)[0];
		$.each(dragElements, function(key, val) {
			if(val[0] === obj) {
				result = true;
			}
		});
		return result;
	},
	
	/**
	 *	This jQuery method returns the initial position (left and top distance) of an element when it is set as Draggable. The element must be draggable widget. This assumes no parameters.
	 *	@method initPosition
	 *	@return {Array}
	 *	@example
	 *		$(element).initPosition;
	*/ 
	initPosition: function() {
		var result = [];
		var obj = $(this)[0];
		$.each(dragElements, function(key, val) {
			if(val[0] === obj) {
				result = dragInitPos[key];
			}
		});
		return result;
	},
	
	/**
	 *	This jQuery method makes the element droppable. Functionality-wise, it doesn't add any new behavior to the element, but it jsut mark the element as droppable widget. Additionally, callback functions can be fired after the creation of droppable widget.
	 *	@method setDroppable
	 *  @param [options] {Object} Contains the array of optional parameters.
	 *	@param [options.callback=null] {function} Callback function which will be fired on completion of drag.
	 *	@example
	 *		$(element).setDroppable({callback: function() {console.log("Successful drag.")}});
	*/ 
	setDroppable: function(options) {
		var opts = options || {};
		var callback = opts.callback || null;
		
		dropElements.push($(this));
		if(callback && typeof(callback) === "function") {
			callback();
		}
	},
	
	/**
	 *	This jQuery method checks whether the element is Droppable or not. Return true if the element is droppable. This assumes no parameter.
	 *	@method isDroppable
	 *  @return {Boolean}
	 *	@example
	 *		$(element).isDroppable();
	*/ 
	isDroppable: function() {
		var result = false;
		var obj = $(this)[0];
		$.each(dropElements, function(key, val) {
			if(val[0] === obj) {
				result = true;
			}
		});
		return result;
	}
});

function startDrag(e) {
	var self = this;
	
	self.ontouchmove = moveDrag;
	self.ontouchend = cancelTouch;
	self.onmousemove = moveDrag;
	self.onmouseup = cancelMouse;
	
	var origin = [self.offsetLeft, self.offsetTop];
	var pos = [self.offsetLeft, self.offsetTop];
	
	function cancelTouch(e) {
		var self = this;
		e.preventDefault();
		var currentPos = [self.offsetLeft, self.offsetTop];
		self.onmousemove = null;
		self.onmouseup = null;
		if(dragCallback && typeof(dragCallback) === "function") {
			dragCallback();
		}
	}
	
	function cancelMouse(e) {
		var self = this;
		e.preventDefault();
		var currentPos = [self.offsetLeft, self.offsetTop];
		self.onmousemove = null;
		self.onmouseup = null;
		if(dragCallback && typeof(dragCallback) === "function") {
			dragCallback();
		}
	}
	
	function moveDrag(e) {
		var self = this;
		e.preventDefault();
		var currentPos = getCoors(e);
		var deltaX = currentPos[0] - origin[0];
		var deltaY = currentPos[1] - origin[1];
		self.style.left = (pos[0] + deltaX) + 'px';
		self.style.top  = (pos[1] + deltaY) + 'px';
		return false;
	}
	
	function getCoors(e) {
		var coors = [];
		if (e.touches && e.touches.length) { 
			coors[0] = e.touches[0].clientX;
			coors[1] = e.touches[0].clientY;
		} else {
			coors[0] = e.clientX;
			coors[1] = e.clientY;
		}
		return coors;
	}
}

	
/**
 *	This method returns the cordinates of any widget. It return both start and end coordinates along the x and y-axis.
 *	@method getCoordinates
 *	@param element {Object} The element whose coordinates is to get.
 *  @return {Array}
 *	@example
 *		var coords = getCoordinates(element);
*/ 
function getCoordinates(elm) {
	var startx = $(elm).offset().left;
	var starty = $(elm).offset().top;
	var endx = startx + $(elm).width();
	var endy = starty + $(elm).height();
	
	return [startx, starty, endx, endy];
}
/**
 *	This is the parent module which holds all the custom widgets, UI elements, libraries, configurations (both client and server side), etc. done in Javascript/jQuery for Native5 Software Solutions &trade;.
 *	@module native5
 */

/**
 *	This is the container for all the custom UI elements and widgets created by Native5 Software Solutions &trade;.
 *	@submodule ui
 */

var native5=(function($, native5) {
    native5.ui = native5.ui || {};
    /**
     *	This widget creates touch (swipe) supported drawer style menu. The menu can be placed on any side of the screen. With the touch event, the drawer can be opened or closed and the same feature can be emulated through click event as well. This widget concerns about the supplied element and amount of entities the element holds is of no consequence.
     *	@class Drawer
     *	@constructor
     *	@param element {Object} It's the `HTML DOM element` which will act as drawer menu.
     *	@param [options] {Object} Options which can be used to modify the ImageGallery as per the need.
     *	@param [options.shown=true] {Boolean} Determines if the drawer is shown by default.
     *	@param [options.position='bottom'] {String} Determines the position of drawer menu. Can be `bottom`, `top`, `left`, or `right`.
     *	@param [options.height=160] {Number} Height of drawer in pixels.
     *	@example
     *		var drawer = new native5.ui.drawer(element, {height: 80});
     */
    native5.ui.Drawer = function(element, options) { 
        if (!element) return null;

        this.element = element;

        this.options = options || {};
        this.shown = this.options.shown || true;
        this.position = this.options.position || 'bottom';
        this.height = this.options.height || 160;
        this.height = "-"+this.height+"px";

        $(this.element).css("z-index", "999");

        this.swipeToShow();
    };

    native5.ui.Drawer.prototype = {

        /**
         *	This method adds the swipe events to the drawer menu and is called internally by the drawer object. This can also be used to add swipe functionality to different elements, once the DrawerMenu object is created.
         *	@method swipeToShow
         *	@param element {Object} `HTML DOM element` on which swipe action is to be binded.
         *	@example
         *		drawer.swpeToShow(element);
         */ 
        swipeToShow: function (el) {
            var elm;
            var _this = this;

            if(el) {
                elm = el;
            }
            else {
                elm = _this.element;
            }

            if((_this.position).toLowerCase() == "bottom") {
                $(elm).live("swipedown", function(e){
                    e.preventDefault();
                    $(_this.element).animate({bottom: _this.height}, "slow", "linear");
                    _this.shown = false;
                });
                $(elm).live("swipeup", function(e){
                    e.preventDefault();
                    $(_this.element).animate({bottom: "0px"}, "slow", "linear");
                    _this.shown = true;
                });
            }
            if((_this.position).toLowerCase() == "top") {
                $(elm).live("swipeup", function(e){
                    e.preventDefault();
                    $(_this.element).animate({top: _this.height}, "slow", "linear");
                    _this.shown = false;
                });
                $(elm).live("swipedown", function(e){
                    e.preventDefault();
                    $(_this.element).animate({top: "0px"}, "slow", "linear");
                    _this.shown = true;
                });
            }
            if((_this.position).toLowerCase() == "left") {
                $(elm).live("swipeleft", function(e){
                    e.preventDefault();
                    $(_this.element).animate({left: _this.height}, "slow", "linear");
                    _this.shown = false;
                });
                $(elm).live("swiperight", function(e){
                    e.preventDefault();
                    $(_this.element).animate({left: "0px"}, "slow", "linear");
                    _this.shown = true;
                });
            }
            if((_this.position).toLowerCase() == "right") {
                $(elm).live("swiperight", function(e){
                    e.preventDefault();
                    $(_this.element).animate({right: _this.height}, "slow", "linear");
                    _this.shown = false;
                });
                $(elm).live("swipeleft", function(e){
                    e.preventDefault();
                    $(_this.element).animate({right: "0px"}, "slow", "linear");
                    _this.shown = true;
                });
            }
        },

        /**
         *	This method adds click events to the element. Using this function, user can toggle between opening and closing of drawer menu. This method in turn calls two different function for opening and closing action.
         *	This accepts no argument.
         *	@method clickToToggle
         *	@example
         *		$(newElement).click(function() {
         *			drawer.clickToToggle();
         *		});
         */ 
        clickToToggle: function() {
            var _this = this;

            if(!_this.shown) {
                _this.clickToShow();
            } else {
                _this.clickToHide();
            }
        },

        /**
         *	This method adds click event to the element which works for opening the drawer.
         *	This accepts no argument.
         *	@method clickToShow
         *	@example
         *		$(newElement).click(function() {
         *			drawer.clickToShow();
         *		});
         */ 
        clickToShow: function() {
            var _this = this;
            if((_this.position).toLowerCase() == "bottom") {
                $(_this.element).animate({bottom:"0px"}, "slow", "linear");
                _this.shown = true;
            }
            if((_this.position).toLowerCase() == "top") {
                $(_this.element).animate({top:"0px"}, "slow", "linear");
                _this.shown = true;
            }
            if((_this.position).toLowerCase() == "left") {
                $(_this.element).animate({left:"0px"}, "slow", "linear");
                _this.shown = true;
            }
            if((_this.position).toLowerCase() == "right") {
                $(_this.element).animate({right:"0px"}, "slow", "linear");
                _this.shown = true;
            }
        },

        /**
         *	This method adds click event to the element which works for closing the drawer. 
         *	This accepts no argument.
         *	@method clickToHide
         *	@example
         *		$(newElement).click(function() {
         *			drawer.clickToHide();
         *		});
         */ 
        clickToHide: function() {
            var _this = this;
            if((_this.position).toLowerCase() == "bottom") {
                $(_this.element).animate({bottom:_this.height}, "slow", "linear");
                _this.shown = false;
            }
            if((_this.position).toLowerCase() == "top") {
                $(_this.element).animate({top:_this.height}, "slow", "linear");
                _this.shown = false;
            }
            if((_this.position).toLowerCase() == "left") {
                $(_this.element).animate({left:_this.height}, "slow", "linear");
                _this.shown = false;
            }
            if((_this.position).toLowerCase() == "right") {
                $(_this.element).animate({right:_this.height}, "slow", "linear");
                _this.shown = false;
            }
        }
    };
    return native5;
})(jQuery, native5);

/**
 *	This is the parent module which holds all the custom widgets, UI elements, libraries, configurations (both client and server side), etc. done in Javascript/jQuery for Native5 Software Solutions &trade;.
 *	@module native5
*/

/**
 *	This is the container for all the custom UI elements and widgets created by Native5 Software Solutions &trade;.
 *	@submodule ui
*/

/**
 *	This widget provides the Grid View implementation required by ImageGallery and supposed to be called internally by ImageGallery. It's created in pure JavaScript.
 *	@class ImageGrid
 *	@constructor
 *	@param element {Object} It's the `HTML DOM element` which contains the set of images.
 *	@param [options] {Object} Options which can be used to modify the ImageGrid as per the need.
 *	@param [options.column=3] {Number} Number of columns to display.
*/

native5.ui.ImageGrid = function(element, options) {
	if (!element) return null;
	var _this = this;
	
	this.options = options || {};
	this.column = this.options.column || 3;
	
	this.container = element;
	this.element = this.container.children[0];
	this.lists = this.element.children;
	
	$(this.element).width($(this.container).width());
	
	var index = this.lists.length;	
	for (i = 0; i < index; i++) {
		var el = this.lists[i];
		width = ($(this.element).width()/this.column)+"px";
		el.style.width = width;
		el.style.listStyleType = "none";
		el.style.display = "inline";
		if((i+1) % this.column === 0) {
			var val = el.innerHTML + "<br />";
			el.innerHTML = val;
		}
	}
};
/**
 *	This is the parent module which holds all the custom widgets, UI elements, libraries, configurations (both client and server side), etc. done in Javascript/jQuery for Native5 Software Solutions &trade;.
 *	@module native5
 */

/**
 *	This is the container for all the custom UI elements and widgets created by Native5 Software Solutions &trade;.
 *	@submodule ui
 */

var native5=(function($, native5) {

    /**
     *	This widget arranges images, present inside given element, in differnet views. There is currently three views possible through this widget -<br />
     *	<ol>
     *	<li> <b>none</b> - Images are displayed as is without any changes. This view is good if someone wants to use available functions of the widget without making any changes in image display.</li>
     *	<li> <b>grid</b> - Images are aranged in the grid of user given rows and columns.</li>
     *	<li> <b>slide</b> - Images are arranged in carousel and can be swiped with the touch.</li>
     *	</ol>
     *	*For <b>slide</b> view, <b>ImageGallery</b> currently uses external library, <a href='http://swipejs.com/'>swipe.js</a>.
     *	@class ImageGallery
     *	@constructor
     *	@uses swipe
     *	@uses ImageGrid
     *	@param element {Object} It's the `HTML DOM element` which contains the set of images.
     *	@param [options] {Object} Options which can be used to modify the ImageGallery as per the need.
     *	@param [options.view='none'] {String} Type of Image Gallery to display. It can be `none`, `grid`, or `swipe`.
     *	@param [options.column=3] {Number} Number of columns to display. Applicalbe only in Grid view.
     *	@param [options.startSlide=0] {Number} Default slide to display when ImageGallery is constructed. Applicalbe only in Slide view.
     *	@param [options.speed=300] {Number} Speed (in ms) at which images changes on swipe. Applicalbe only in Slide view.
     *	@param [options.callback] {Function} Function to be called once the change of slide occurs. Applicalbe only in Slide view.
     *	@param [options.auto=0] {Number} Duration after which the slide changes. If set to `0`, no auto slide will occur. Applicalbe only in Slide view.
     *	@example
     *		var grid = new native5.ui.ImageGallery(element, {view: 'grid', column: 4});
     */

    native5.ui.ImageGallery = function(element, options) {
        if (!element) return null;

        this.options = options || {};
        this.view = this.options.view || 'none';

        //Property for Image Grid.
        this.column = this.options.column || 3;

        //Property for Image Slideshow.
        this.index = this.options.startSlide || 0;
        this.speed = this.options.speed || 300;
        this.callback = this.options.callback || function() {};
        this.delay = this.options.auto || 0;

        this.container = element;
        this.element = this.container.children[0];
        this.lists = this.element.children;
        this.length = this.lists.length;

        if(this.view.toLowerCase() == 'slide'.toLowerCase()) {
            $('head').append('<script type="text/javascript" src="../../src/swipe.min.js"></script>');
            var slider = new Swipe(element, {startSlide: this.index, speed: this.speed, auto:this.delay, callback: this.callback});
        }
        else if(this.view.toLowerCase() == 'grid'.toLowerCase()) {
            $('head').append('<script type="text/javascript" src="../../src/native5.ui.grid.js"></script>');
            var grid = new native5.ui.ImageGrid(element, {column: this.column});
        }
        else {
            this.defaultDisplay();
        }

        // this.loadContent(this.imgCount, this.refreshDelay);
    };

    native5.ui.ImageGallery.prototype = {

        /**
         *	This method allows the images in ImageGallery to delay load. User can define the time after which iamges to load and the number of images to load in each burst. It works on the principle that each `img` tag has src of image but stored in different attribute.
         *	@method loadContent
         *	@param [options] {Object} Set of parameters to modify the delay loading behaviour.
         *	@param [options.count=1] {Number} Number of images to load in a single burst.
         *	@param [options.delay=300] {Number} Time (in ms) after which next set of images are to be loaded.
         *	@param [options.fromAttr="data-src"] {String} Name of attribute which stores the url of image.
         *	@param [options.toAttr="src"] {String} Name in which the fromAttr to be changed to. Its useful if the user wants to use images in some other forms, like `bckground image`.
         *	@example
         *		grid.loadContent({count: 2, delay: 500});
         */
        loadContent: function(val) {
            this.val = val || {};
            this.count = this.val.count || 1;
            this.timeout = this.val.delay || 300;
            this.fromAttr = this.val.fromAttr || "data-src";
            this.toAttr = this.val.toAttr || "src";
            var self = this;
            var counter = 0;
            var i = 0;
            this.imgLoad = setInterval(function() {
                for (i; i < (counter+self.count); i++) {
                    if((counter+self.count) >= self.length)
                clearInterval(self.imgLoad);

            if (i < self.length) {
                var elm = self.lists[i].getElementsByTagName('img')[0];
                var attr = elm.getAttribute(self.fromAttr);
                elm.removeAttribute(self.fromAttr);

                if(attr !== null)
                elm.setAttribute(self.toAttr, attr);
            }
                }
                counter += self.count;
            }, self.timeout);
        },

        /**
         *	This method essentially used by ImageGallery internally when view is `none`, but can be used by the user as well.This method does not require any argument. This method simply removes all the padding and margin of the element and it's immediate children (structure which is used for ImageGallery widget) keeping all other feature intact. This way user can remove `grid` or `slide` view as per his need.
         *	@method defaultDisplay
         *	@example
         *		grid.defaultDisplay();
         */

        defaultDisplay: function() {
            this.container.style.margin = 0;
            this.container.style.padding = 0;
            this.element.style.margin = 0;
            this.element.style.padding = 0;
            for(i = 0; i < this.length; i++) {
                var el = this.lists[i];
                el.style.margin = 0;
                el.style.padding = 0;
            }
        }
    };
    return native5;
})(jQuery, native5);

/**
 *	This is the parent module which holds all the custom widgets, UI elements, libraries, configurations (both client and server side), etc. done in Javascript/jQuery for Native5 Software Solutions &trade;.
 *	@module native5
 */

/**
 *	This is the container for all the custom UI elements and widgets created by Native5 Software Solutions &trade;.
 *	@submodule ui
 */

var native5=(function($, native5) {
    /**
     *	This widget creates Drop-Down menu implementation using jQuery. User can click the menu button to display/hide the drop-down menu. Each item can have it's own individual action.
     *	@class ListMenu
     *	@constructor
     *	@param element {Object} It's the `HTML DOM element` on which the Drop-Down menu will be applied.
     *	@param [options] {Object}
     *	@param [options.menuClass=null] {String} Class to be applied to the container for menu items, i.e. &lt;ul&gt; item.
     *	@param [options.spanClass=null] {String} Class to be applied to the supplied element, i.e. &lt;span&gt;. Providing `android` as span class automatically creates Holo themed menu.
     *	@example
     *		var abc = new native5.ui.ListMenu(element, {menuClass: "myClass", spanClass: "android"});
     */
    native5.ui.ListMenu = function(element, options) { 
        if (!element) return null;
        this.element = element;
        this.options = options || {};
        this.spanClass = this.options.spanClass || null;
        this.menuClass = this.options.menuClass || null;
        this.items = [];

        $(element).click(function() {
            $(this).children().toggle("fast");
        });
    };

    native5.ui.ListMenu.prototype = {

        /**
         *	This method allows users to add menu items to the Drop-down menu. All parameters are optional but if none is provided, empty `<li>` tag will be created.
         *	@method addItem
         *  @param [opts] {Object}
         *  @param [opts.itemText] {String} Text for the menu item. User can provide either `String` or `html` with `<li>` tag with it.
         *  @param [opts.itemClass] {String} `Class` property of the `<li>` element that defines the menu item. If `html` with `<li>` is provided as text, this feature will be neglected.
         *  @param [opts.itemId] {String} `Id` property of the `<li>` element that defines the menu item. If `html` with `<li>` is provided as text, this feature will be neglected.
         *  @param [opts.itemStyle] {String} `Style` property of the `<li>` element that defines the menu item. If `html` with `<li>` is provided as text, this feature will be neglected.
         *  @param [opts.itemClick] {String} `Onclick` property of the `<li>` element that defines the menu item. If `html` with `<li>` is provided as text, this feature will be neglected. Note: function is accepted in a `String` format and applied to onlcik of the list.
         *	@example
         *		menu.addItem({itemText: "Hi", itemClass: "abc", itemStyle: "margin-left: 10px;", itemId: "list", itemClick: "alert('Hi')" });
         */
        addItem: function(item, opts) {
            this.items.push(item);
            if(!opts) return null;

            // var itemText = opts.itemText || "";
            // var itemClass = opts.itemClass || null;
            // var itemId = opts.itemId || null;
            // var itemStyle = opts.itemStyle || null;
            // var itemClick = opts.itemClick || null;
            // var self = this;
            // var ulItem = $(self.element).children('ul')[0];
            // var content = "";

            /**
              if(itemText.indexOf("<li") !== 0) {
              content = "<li";
              if(itemClass) {
              content+= " class = '" + itemClass + "'";
              }
              if(itemStyle) {
              content+= " style = '" + itemStyle + "'";
              }
              if(itemId) {
              content+= " id = '" + itemId + "'";
              }
              if(itemClick) {
              content+= " onclick = " + new Function(itemClick);
              }
              content += ">" + itemText + "</li>";
              }
              else {
              content = itemText;
              if(itemClick) {
              $(content)[0].onclick = new Function(itemClick);
              }
              }

              if(ulItem !== undefined) {
              $(ulItem).append(content);
              }
              else {
              $(self.element).append("<ul>"+content+"</ul>");
              }

              if(self.menuClass) {
              $(ulItem).addClass(self.menuClass);
              }
              $(ulItem).css({"list-style": "none", "padding": 0, "margin": 0, "display": "none"});
             **/
        },

        /**
         *	This method allows users to remove menu items from the drop-down menu. Either item index or id is necessary for this funtion to operate.
         *	@method removeItem
         *  @param [opts] {Object}
         *  @param [opts.index] {Number} Index (0 based) of `<li>` element to be deleted.
         *  @param [opts.itemId] {String} `Id` of `<li>` element to be deleted.
         *	@example
         *		menu.removeItem({index: 5});
         */
        removeItem: function(opts) {
            if(!opts) return null;

            var self = this;
            var index = opts.index || -1;
            var itemId = opts.itemId || null;

            if(index === -1 && itemId === null) return null;
            var ulItem = $(self.element).children('ul')[0];
            if(ulItem === undefined) return null;

            if(index !== -1) {
                var removeEl = $(ulItem).children()[index];
                $(removeEl).remove();
            }
            else {
                $("#"+itemId).remove();
            }
        },

        render: function() {
            self = this;
            $(self.element).append("<ul>"+"</ul>");
            var ulItem = $(self.element).children('ul')[0];
            if(self.spanClass) {
                $(self.element).addClass(self.spanClass);
            }
            if(self.menuClass) {
                $(ulItem).addClass(self.menuClass);
            }
            content = '';
            this.items.forEach(function(elem) {
                $(ulItem).append(elem.render());
                //content = content.concat(elem.render().outerHTML);
            });
            $(ulItem).css({"list-style": "none", "padding": 0, "margin": 0, "display": "none"});

        }
    };

    native5.ui.MenuItem = function(name, opts) {
        this.name=name;
        // Auto-Generate ID for element
        this.element = document.createElement('li');
        this.element.innerHTML = name;
        if(!opts) return this;
        if(opts.raw) {
            this.element = document.createElement(opts.element);
        }
        if(opts.style)
            this.element.style = opts.style;
        if(opts.className)
            this.element.className = opts.className;
        return this;
    };

    native5.ui.MenuItem.prototype = {
        setAction: function(action) {
            this.action = action;
            this.element.onclick = action;
        },
        render: function(){
            return this.element;	
        }
    };
    return native5;
})(jQuery, native5);

native5.ui.Loader = function(options) {
	this.loadingMessage = "Loading ...";
	this.showLoader = false;

	_this = this;
	$('.ui-load').each(function(index) {
		$(this).bind('fade-cycle', function() {
			if(_this.showLoader)
			$(this).fadeOut(300, function() {
				$(this).fadeIn(300, function() {
					if(index <3)
						$(this).next().trigger('fade-cycle');
					else
						$('.ui-load').first().trigger('fade-cycle');
					});
				});
		});
	});
};

native5.ui.Loader.prototype = {
	showLoadingMessage:function(message) {
		this.showLoader = true;	
		$("#loading").fadeIn("fast", function() {
			$('.ui-loader-1').trigger('fade-cycle');	
		}); 
	},
	hideLoadingMessage:function(message) {
		this.showLoader = false;
		$("#loading").fadeOut("fast");
	}
};

/*global jQuery:false, native5:false */
var native5 = (function($, native5) {
	"use strict";
    native5.ui = native5.ui || {};

    native5.ui.SideMenu = native5.ui.UIComponent.extend(function(options) {
        this.element        = document.createElement('div');
        this.options        = options || {};
        this.displacement   = this.options.displacement || '147';
        this.displacement   += 'px';
        this.duration       = this.options.duration || '300';
        this.active         = false;
        var bodySelector    = options.bodySelector || ".ui-page-active";
        this.header         = this.options.welcome || "<h3 style='color:white;text-align:center;padding:0px 10px;'><span>Welcome,</span><em>Guest</em></h3>";

    }).methods({
        init:function() {
            var self = this;
            this.supportedActions.push('change');
            $(this).on('change', function() {
                self.toggle();
            });
            var supportsOrientationChange = "onorientationchange" in window,
        orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
    window.addEventListener(orientationEvent, function() {
        $("body").width($(window).width());
        $(bodySelector).trigger("resize");
    }, false);
    $(bodySelector).bind("webkitTransitionEnd", function() {
        self.active ? $(self.element).css("z-index","1") : $(self.element).css('visibility', 'hidden');
    });
        },
        render: function () {
            var self = this;
            var fragment = document.createDocumentFragment();
            fragment.appendChild(this.element);
            var container = document.createElement('div');
            var header = document.createElement('div');
            container.insertBefore(header, container.firstChild);
            $(container).append($(this.element).children('ul')[0]);
            $(this.element).empty();
            $(this.element).append(container);
            header.innerHTML = this.header;
            this.element.setAttribute("id", "smenu");
            this.element.style.cssText = ''.concat(
                    "background-color:transparent;",
                    "height:100%;",
                    "left:0px;",
                    "top:0px;",
                    "z-index:-1;",
                    "visibility:hidden;",
                    "-webkit-transition-property:visibility;",
                    "-webkit-transition-duration:0s;",
                    "-webkit-transition-delay:"+this.duration+"ms;",
                    "-webkit-transition-timing-function:"+"linear;",
                    "width:1000px;",
                    "overflow:auto;",
                    "position:fixed;");
            document.body.appendChild(fragment);
            var elemWidth = this.displacement;
            $(container).width(elemWidth);
            $(this.element).bind('click', function(evt) {
                self.toggle();
                evt.stopPropagation();
            });
            //this.displacement = elemWidth;
        },
        toggle: function () {
            var self = this;
            var elemStyles = {};
            if(!self.active) {
                self.active= true;
                var styleMap = {};
                styleMap['-webkit-transition']="-webkit-transform "+self.duration+"ms";
                styleMap['-webkit-transform']="translate3d("+self.displacement+",0,0)";
                styleMap['overflow-x']="hidden !important";
                elemStyles.visibility = "visible";
                elemStyles["-webkit-transition-property"]="z-index",
                elemStyles["-webkit-transition-duration"]="0s",
                elemStyles["-webkit-transition-delay"]=this.duration+"ms";
                elemStyles["-webkit-transition-timing-function"]="linear";
                elemStyles["z-index"]="1";
                $(self.element).css(elemStyles);
                $(bodySelector).css(styleMap);
                $("#smenu").addClass("scrollable");
                $("#smenu").bind('touchmove', function(evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                });
                $(document).bind("touchmove",self.preventScroll);
                //$(document).bind("touchmove",self.stopScroll);
                return false;
            } else {
                self.active=false;
                elemStyles["-webkit-transition-property"]="visibility",
                elemStyles["-webkit-transition-duration"]="0s",
                elemStyles["-webkit-transition-delay"]=this.duration+"ms";
                elemStyles["-webkit-transition-timing-function"]="linear";
                //elemStyles['visibility']="visible";
                elemStyles['z-index']="-1";
                $(self.element).css(elemStyles);
                $(bodySelector).css("-webkit-transform", "translate3d(0,0,0)");
                $(document).unbind("touchmove", self.preventScroll);
                return false;
            }
        },
        preventScroll:function(e) {
            var scrollable = false;
            var items = $(e.target).parents();
            $(items).each(function(i,o) {
                if($(o).hasClass("scrollable")) {
                    scrollable = true;
                }
            });
            if(!scrollable)
                e.preventDefault();
            //evt.stopPropagation();
        },
        stopScroll:function(evt) {
            evt.preventDefault();
        },
        addItem: function(opts) {
            if(!opts) return null;

            var self = this;
            var itemText = opts.itemText || "";
            var itemClass = opts.itemClass || null;
            var itemId = opts.itemId || null;
            var itemStyle = opts.itemStyle || null;
            var itemClick = opts.itemClick || null;
            var ulItem = $(self.element).children('ul')[0];
            var content = "";

            if(itemText.indexOf("<li") !== 0) {
                content = "<li";
                if(itemClass) {
                    content+= " class = '" + itemClass + "'";
                }
                if(itemStyle) {
                    content+= " style = '" + itemStyle + "'";
                }
                if(itemId) {
                    content+= " id = '" + itemId + "'";
                }
                if(itemClick) {
                    content+= " onclick = " + itemClick;
                }
                content += ">" + itemText + "</li>";
            } else {
                content = itemText;
                if(itemClick) {
                    $(content).attr("onclick", itemClick);
                }
            }

            if(ulItem !== undefined) {
                $(ulItem).append(content);
            } else {
                $(self.element).append("<ul class='sidemenu'>"+content+"</ul>");
            }
        },

        /**
         *	This method allows users to remove menu items from the side menu. Either item index or id is necessary for this funtion to operate.
         *	@method removeItem
         *  @param [opts] {Object}
         *  @param [opts.index] {Number} Index (0 based) of `<li>` element to be deleted.
         *  @param [opts.itemId] {String} `Id` of `<li>` element to be deleted.
         *	@example
         *		menu.removeItem({index: 5});
         */
        removeItem: function(opts) {
            if(!opts) return null;

            var self = this;
            var index = opts.index || -1;
            var itemId = opts.itemId || null;

            if(index === -1 && itemId === null) return null;
            var ulItem = $(self.element).children('ul')[0];
            if(ulItem === undefined) return null;

            if(index !== -1) {
                var removeEl = $(ulItem).children()[index];
                $(removeEl).remove();
            } else {
                $("#"+itemId).remove();
            }
        }
    });
    return native5;

}(jQuery, native5||{}));

/**
 *	This is the parent module which holds all the custom widgets, UI elements, libraries, configurations (both client and server side), etc. done in Javascript/jQuery for Native5 Software Solutions &trade;.
 *	@module native5
 */

/**
 *	This is the container for all the custom UI elements and widgets created by Native5 Software Solutions &trade;.
 *	@submodule ui
 */


var native5=(function($, native5) {
    /**
     *	This widget creates Tag Cloud in 3D spherical display. User can swipe to rotate the cloud and alternatively select (click) the tag to perform action associated with it.
     *	@class TagCloud
     *	@constructor
     *	@param [options] {Object} Options which can be used to modify the TagCloud as per the need.
     *	@param [options.divId='tagDiv'] {String} `id` of the `<div>` which will contain the tag cloud. If this option is not set by user, a new `<div>` is created with default `id`.
     *	@param [options.zoom=90] {Number} Zoom state of tag cloud formed.
     *	@param [options.max_zoom=120] {Number} Maximum zoom possible.
     *	@param [options.min_zoom=25] {Number} Minimum zoom possible.
     *	@param [options.zoom_factor=5] {Number} Amount of zoom added/subtracted when zoomed in or out.
     *	@param [options.rotate_factor=2] {Number} Amount of rotation/movement done per swipe.
     *	@param [options.fps=20] {Number} Frames per second movement for tag cloud. More fps means faster movement.
     *	@param [options.centrex=125] {Number} Determines the center of x-axis.
     *	@param [options.centrey=125] {Number} Determines the center of y-axis.
     *	@param [options.min_font_size=12] {Number} Minimum font size for any tag.
     *	@param [options.max_font_size=32] {Number} Maximum font size for any tag.
     *	@param [options.font_units='px'] {String} unit of font. Can be `px`, `em`, or `%`.
     *	@param [options.initial_rotation_x=0] {Number} Determines the initial motion around x-axis when tag cloud is created.
     *	@param [options.initial_rotation_y=0] {Number} Determines the initial motion around y-axis when tag cloud is created.
     *	@param [options.decay=0.90] {Number} It's the factor by which the rotation of tag cloud decays till it stops completely. Maximum accepted value is `1.0` where there will be no auto stopping of tag cloud.
     *	@param [options.bgcolor=''] {String} Determines the background color of tag cloud. It can be of form `String (e.g. red)`, `hash`, `rgb`, or `rgba`.
     *	@param [options.width='250px'] {String} Determines width of tag cloud. User can use `px` or `em` values.
     *	@param [options.height='250px'] {String} Determines height of tag cloud. User can use `px` or `em` values.
     *	@example
     *		var tCloud = = new native5.ui.tagcloud({divId: "tgd", fps: 50, width: "300px", height: "300px", rotate_factor: 5, zoom: 100});
     */

    native5.ui.TagCloud = function(options) {
        this.options = options || {};
        this.zoom = this.options.zoom || 90;
        this.max_zoom = this.options.max_zoom || 120;
        this.min_zoom = this.options.min_zoom || 25;
        this.zoom_factor = this.options.zoom_factor || 5;
        this.rotate_factor = this.options.rotate_factor || 2;
        this.fps = this.options.fps || 20;
        this.centrex = this.options.centrex || 125;
        this.centrey = this.options.centrey || 125;
        this.min_font_size = this.options.min_font_size || 12;
        this.max_font_size = this.options.max_font_size || 32;
        this.font_units = this.options.font_units || 'px';
        this.initial_rotation_x = this.options.initial_rotation_x || 0;
        this.initial_rotation_y = this.options.initial_rotation_y || 0;
        this.decay = this.options.decay || 0.90;
        this.bgcolor = this.options.bgcolor || '';
        this.width = this.options.width || '250px';
        this.height = this.options.height || '250px';
        this.divName = this.options.divId || 'tagDiv';

        if(this.decay > 1.0)
            this.decay = 1.0;

        this.jsonObj = {"tags": [], "colors": []};
    };

    native5.ui.TagCloud.prototype = {

        /**
         *	This method modfies the values of tag cloud object once it's created. It's useful if the tag cloud is altered and requires `UI` adjustment. If this function is called without any argument, the it simply returns the values given during the object formation, but won't fail because of that.
         *	@method modify
         *	@param [options] {Object} Options to modify values of tagcloud object.
         *	@param [options.zoom=90] {Number} Zoom state of tag cloud formed.
         *	@param [options.max_zoom=120] {Number} Maximum zoom possible.
         *	@param [options.min_zoom=25] {Number} Minimum zoom possible.
         *	@param [options.zoom_factor=5] {Number} Amount of zoom added/subtracted when zoomed in or out.
         *	@param [options.rotate_factor=2] {Number} Amount of rotation/movement done per swipe.
         *	@param [options.fps=20] {Number} Frames per second movement for tag cloud. More fps means faster movement.
         *	@param [options.centrex=125] {Number} Determines the center of x-axis.
         *	@param [options.centrey=125] {Number} Determines the center of y-axis.
         *	@param [options.min_font_size=12] {Number} Minimum font size for any tag.
         *	@param [options.max_font_size=32] {Number} Maximum font size for any tag.
         *	@param [options.font_units='px'] {String} unit of font. Can be `px`, `em`, or `%`.
         *	@param [options.initial_rotation_x=0] {Number} Determines the initial motion around x-axis when tag cloud is created.
         *	@param [options.initial_rotation_y=0] {Number} Determines the initial motion around y-axis when tag cloud is created.
         *	@param [options.decay=0.90] {Number} It's the factor by which the rotation of tag cloud decays till it stops completely. Maximum accepted value is `1.0` where there will be no auto stopping of tag cloud.
         *	@param [options.bgcolor=''] {String} Determines the background color of tag cloud. It can be of form `String (e.g. red)`, `hash`, `rgb`, or `rgba`.
         *	@param [options.width='250px'] {String} Determines width of tag cloud. User can use `px` or `em` values.
         *	@param [options.height='250px'] {String} Determines height of tag cloud. User can use `px` or `em` values.
         *	@return options {Object}
         *	@example
         *		tCloud.modify({centrex: 120, centrey: 120});
         */
        modify: function(options) {
            var self = this;
            self.options = options || self.options;
            self.zoom = options.zoom || self.zoom;
            self.max_zoom = options.max_zoom || self.max_zoom;
            self.min_zoom = options.min_zoom || self.min_zoom;
            self.zoom_factor = options.zoom_factor || self.zoom_factor;
            self.rotate_factor = options.rotate_factor || self.rotate_factor;
            self.fps = options.fps || self.fps;
            self.centrex = options.centrex || self.centrex;
            self.centrey = options.centrey || self.centrey;
            self.min_font_size = options.min_font_size || self.min_font_size;
            self.max_font_size = options.max_font_size || self.max_font_size;
            self.font_units = options.font_units || self.font_units;
            self.initial_rotation_x = options.initial_rotation_x || self.initial_rotation_x;
            self.initial_rotation_y = options.initial_rotation_y || self.initial_rotation_y;
            self.decay = options.decay || self.decay;
            self.bgcolor = options.bgcolor || self.bgcolor;
            self.width = options.width || self.width;
            self.height = options.height || self.height;
            self.divName = options.divId || self.divName;

            if(this.decay > 1.0)
                this.decay = 1.0;
        },

        /**
         *	This method initializes the data used for creating the tag cloud. The data can be provided through url to jSon file or jSon object. This method removes the existing data and replace with the new data provided. <br />Please note: This only creates the data but not append to the DOM yet.
         *	@method init
         *	@param [options] {Object} Options for data.
         *	@param [options.url=null] {String} URL containing the jSon data.
         *	@param [options.jsonData=null] {Object|Array} inline jSon data.
         *	@example
         *		tCloud.init({url: 'path to json data'});
         */
        init: function(options) {
            var self = this;
            var opts = options || {};
            if(!opts) return null;
            var url = opts.url || null;
            var jsonData = opts.data || null;

            self.jsonObj = {"tags": [], "colors": []};

            if(url !== null) {
                $.ajax({
                    url: url,
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        if(data.colors !== undefined) {
                            $.merge(self.jsonObj.colors, data.colors);
                        }

                        $.merge(self.jsonObj.tags, data.tags);
                    }
                });
            }

            if(jsonData !== null) {
                var data = null;

                if(jsonData instanceof Object) {
                    data = jsonData;
                }
                else {
                    data = jQuery.parseJSON(jsonData);
                }

                if(data.colors !== undefined) {
                    $.merge(self.jsonObj.colors, data.colors);
                }

                $.merge(self.jsonObj.tags, data.tags);
            }
        },

        /**
         *	This method appends the tag data to existing data for tag clod creation. The data can be provided through url to jSon file or jSon object. It differs from `init()` method as it preserves the existing data as well. <br />Please note: This only creates the data but not append to the DOM yet.
         *	@method append
         *	@param [options] {Object} Options for data.
         *	@param [options.url=null] {String} URL containing the jSon data.
         *	@param [options.jsonData=null] {Object|Array} inline jSon data.
         *	@example
         *		tCloud.append({data: jsonData});
         */
        append: function(options) {
            var self = this;
            var opts = options || {};
            if(!opts) return null;
            var url = opts.url || null;
            var jsonData = opts.data || null;

            if(url) {
                $.ajax({
                    url: url,
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        if(data.colors !== undefined) {
                            $.merge(self.jsonObj.colors, data.colors);
                        }

                        $.merge(self.jsonObj.tags, data.tags);
                    }
                });
            } else if(jsonData) {
                var data = null;

                if(jsonData instanceof Object) {
                    data = jsonData;
                }
                else {
                    data = jQuery.parseJSON(jsonData);
                }

                if(data.colors !== undefined) {
                    $.merge(self.jsonObj.colors, data.colors);
                }

                $.merge(self.jsonObj.tags, data.tags);
            }	
        },

        /**
         *	This method adds the data to the DOM structure for the tag cloud creation. Property of DOM elements created is determined through given data (size, color, importance, etc.). Thois method accepts no arguments.
         *	@method refresh
         *	@example
         *		tCloud.refresh();
         */
        refresh: function() {
            var self = this;
            var items = [];
            var tagCol = ['#fff', '#eee', '#ddd', '#ccc', '#bbb', '#aaa', '#999', '#888', '#777', '#666'];

            if(self.jsonObj.colors !== undefined) {
                $.each(self.jsonObj.colors, function(key, val) {
                    tagCol[key] = val.color;
                });
            }

            if($('.exist').length === 0) {
                items.push("<ul class='ui-listview'>");
                $.each(self.jsonObj.tags, function(key, val) {
                    var fontSize = 16 + parseInt(val.imp, 10)*3 + parseInt(val.weight, 10) - Math.round((parseInt(val.age, 10) - 1)/2);
                    fontSize += "px";
                    items.push("<li style='font-size:"+ fontSize +"; color:"+ tagCol[parseInt(val.weight, 10)] +"'>" + val.name + '</li>');
                });
                items.push("</ul>");

                $('<div/>', {
                    'id': self.divName,
                    'class': 'exist',
                    'style': 'background-color: '+ self.bgcolor +'; width: '+ self.width +'; height: '+ self.height +';',
                    html: items.join('')
                }).appendTo('#divcontent').each(function() {
                    self.render();
                });
            }
            else {
                $.each(self.jsonObj.tags, function(key, val) {
                    var fontSize = 16 + parseInt(val.imp, 10)*3 + parseInt(val.weight, 10) - Math.round((parseInt(val.age, 10) - 1)/2);
                    fontSize += "px";
                    items.push("<li style='font-size:"+ fontSize +"; color:"+ tagCol[parseInt(val.weight, 10)] +"'>" + val.name + '</li>');
                });
                $('.exist').html(items.join(''));
            }


            self.render();
        },

        /**
         *	This method renders the DOM structure provided by the user (obtained through `divId` and it's children) or through `refresh()` method into a tag cloud. Without this method, the tags will appear as a list. This method accepts no arguments.
         *	<br /> note: `refresh()` method calls the `render()` method internally, so it's not required by the user to call this function if he's not applying tag cloud on existing DM structure.
         *	@method render
         *	@example
         *		tCloud.render();
         */
        render: function() {
            var self = this;
            var element = $("#"+self.divName);
            $(element).css('position', 'relative');
            $(element).css('background-color', self.bgcolor);

            var eyez = -500;

            // set rotation (in this case, 5degrees)
            var rad = Math.PI/180;
            // var global_cos = Math.cos(0);

            // per-instance values
            var dirty = true;
            var container = $(element);
            var id_stub = 'tc_' + $(element).attr('id') + "_";
            var zoom = this.zoom;
            var depth;
            var points_meta = [];
            var points_data = [];

            var vectorx = this.initial_rotation_x;
            var vectory = this.initial_rotation_y;
            var motionx = new this.mqueue(50, true);
            var motiony = new this.mqueue(50, false);
            var dragging = false;
            var clicked = false;
            // var mousex = 0;
            // var mousey = 0;

            var drawing_interval =  1/(self.fps/1000);
            var cmx = self.centrex; 
            var cmy = self.centrey;
            var bg_colour;
            if (self.bgcolor){
                bg_colour = parsecolour(self.bgcolor);
            }else{
                bg_colour = parsecolour($(element).css('background-color'));
            }

            function parsecolour(colour){
                function parse_rgb_colour(colour){
                    rgb = colour.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
                    if(!rgb) return {"r":255, "g":255, "b":255};

                    if(rgb.length > 3){
                        return {"r" : parseInt(rgb[1], 10), "g": parseInt(rgb[2], 10), "b" : parseInt(rgb[3], 10)};                 
                    }else{  
                        return {"r":0, "g":0, "b":0};
                    }
                }
                function parse_hex_colour(colour){
                    var r = 0, g = 0, b = 0;
                    if(colour.length > 4)
                    {
                        r = parseInt(colour.substr(1,2), 16);
                        g = parseInt(colour.substr(3,2), 16);
                        b = parseInt(colour.substr(5,2), 16);
                    }
                    else
                    {
                        r = parseInt(colour.substr(1,1)+colour.substr(1,1), 16);
                        g = parseInt(colour.substr(2,1)+colour.substr(2,1), 16);
                        b = parseInt(colour.substr(3,1)+colour.substr(3,1), 16);
                    }
                    return {"r" : r, "g" : g, "b" : b};
                }

                if(colour) {
                    if(colour.substr(0, 1) === '#')
                    {
                        return parse_hex_colour(colour);
                    }
                    else if (colour.substr(0,3) === 'rgb')
                    {
                        return parse_rgb_colour(colour);
                    }
                    else{
                        //somehow we've got a plain old string as a colour
                        if(window.console !== undefined)
                            console.log("unable to parse:'" + colour + "' please ensure background and foreground colors for the container are set as hex values");
                        return null;
                    }
                }
            }

            function getcolour(num, fg_colour){
                if(num>256){num=256;}
                if(num<0){num=0;}

                var r = 255, g = 255, b = 255;

                if(bg_colour && fg_colour) {
                    r = getshade(bg_colour.r, fg_colour.r, num);
                    g = getshade(bg_colour.g, fg_colour.g, num);
                    b = getshade(bg_colour.b, fg_colour.b, num);
                }

                var ret  = "rgb(" + r + ", "+ g + ", " + b + ")"; 
                return ret;
            }

            function getshade(lbound, ubound, dist){
                var scope = ubound - lbound;
                var dist_percent = scope / 100;
                var shade = Math.round(lbound + (dist * dist_percent));
                return shade;
            }

            function zoomed(by){
                zoom += by * opts.zoom_factor;

                if (zoom > opts.max_zoom) {
                    zoom = opts.max_zoom;
                }
                if (zoom < opts.min_zoom) {
                    zoom = opts.min_zoom;
                }

                depth = -(zoom * (eyez - opts.max_zoom) / 100) + eyez;
                dirty = true;
            }

            function decay_me(vector){ 
                if(Math.abs(vector) < 0.5){
                    vector = 0;
                }
                else{
                    if(vector > 0){
                        vector *= self.decay;
                    }
                    if (vector < 0){
                        vector *= self.decay;
                    }
                }
                return vector;
            }

            function move(){
                if(vectorx !== 0 || vectory !== 0){
                    var factor = self.rotate_factor;
                    var tx = -(vectorx * rad * factor);
                    var ty = vectory * rad * factor;

                    for(var p in points_data)
                    {                 
                        var sin_x = Math.sin(tx);
                        var cos_x = Math.cos(tx);
                        var sin_y = Math.sin(ty);
                        var cos_y = Math.cos(ty);

                        var x = points_data[p].x;
                        var z = points_data[p].z;
                        points_data[p].x = x * cos_x + z * sin_x;
                        points_data[p].z = z * cos_x - x * sin_x;

                        var y = points_data[p].y;
                        z = points_data[p].z;
                        points_data[p].y = y * cos_y - z * sin_y;
                        points_data[p].z = y * sin_y + z * cos_y;
                    }                
                    dirty = true;
                }
            }

            function decay_all(){
                vectorx = decay_me(vectorx);
                vectory = decay_me(vectory);
                if(!dragging){
                    motionx.add(0);
                    motiony.add(0);
                }
            }

            function draw(){
                // calculate 2D coordinates
                if(dirty){
                    var smallz = 10000; 
                    var bigz = -10000;

                    for(var r_p in points_data){
                        if(points_data[r_p].z < smallz){smallz = points_data[r_p].z;}
                        if(points_data[r_p].z > bigz){bigz = points_data[r_p].z;}
                    }
                    var minz = Math.min(smallz, bigz);
                    var maxz = Math.max(smallz, bigz);
                    var diffz = maxz - minz;

                    for(var s_p in points_data){ 
                        //normalise depth
                        var u = (depth - eyez)/(points_data[s_p].z - eyez);

                        // calculate normalised grey value
                        var dist = Math.round(((maxz - points_data[s_p].z)/diffz) * 100);
                        var dist_colour = getcolour(dist, points_data[s_p].colour);
                        //set new 2d positions for the data
                        points_data[s_p].element.css('color',dist_colour);
                        dist = Math.round(((maxz - points_data[s_p].z)/diffz) * 100);
                        points_data[s_p].element.css('z-index', dist);
                        points_data[s_p].element.css('left', u * points_data[s_p].x + cmx - points_data[s_p].cwidth);
                        points_data[s_p].element.css('top', u * points_data[s_p].y + cmy); 
                    }			
                    dirty = false;
                }
                move(vectorx, vectory);
                decay_all();
            }

            points_meta.count = $('li', container).length;
            points_meta.largest = 1;
            points_meta.smallest = 0;

            $('li', container).each(function(idx, val){
                var sz = parseInt($(this).css("font-size"), 10);
                if(sz === 0) 
                sz = 1;
            var point_id = id_stub + idx;
            points_data[idx] = {
                size:sz
            };

            var h = -1 + 2*(idx)/(points_meta.count-1);
            points_data[idx].theta = Math.acos(h);
            if(idx === 0 || idx === points_meta.count-1){
                points_data[idx].phi = 0;
            }
            else{
                points_data[idx].phi = (points_data[idx-1].phi + 3.6/Math.sqrt(points_meta.count*(1-Math.pow(h,2)))) % (2 * Math.PI);
            }

            points_data[idx].x = Math.cos(points_data[idx].phi) * Math.sin(points_data[idx].theta) * (cmx/2);
            points_data[idx].y = Math.sin(points_data[idx].phi) * Math.sin(points_data[idx].theta) * (cmy/2);
            points_data[idx].z = Math.cos(points_data[idx].theta) * (cmx/2);
            points_data[idx].colour = parsecolour($(this).css('color'));

            if(sz > points_meta.largest) points_meta.largest = sz;
            if(sz < points_meta.smallest) points_meta.smallest = sz;

            $(this).css('position','absolute');
            $(this).addClass('point');
            $(this).attr('id', point_id);

            points_data[idx].element = $('#'+point_id);

            });

            //tag size and font size ranges 
            var sz_range = points_meta.largest - points_meta.smallest + 1; 
            var sz_n_range = self.max_font_size - self.min_font_size + 1;

            //set font size to normalised tag size
            for(var p in points_data){
                var sz = points_data[p].size;
                var sz_n = parseInt((sz / sz_range) * sz_n_range, 10) + parseInt(self.min_font_size, 10);
                if(!points_data[p].element.hasClass('background')){
                    points_data[p].element.css('font-size', sz_n); 
                }
                //store element width / 2 so we can centre the text around the point later.
                points_data[p].cwidth = points_data[p].element.width()/2;
            }
            // bin original html
            //$('ul', container).remove();

            //set up initial view
            depth = -(zoom * (eyez - self.max_zoom) / 100) + eyez;
            draw();


            //call draw every so often
            drawing_interval = setInterval(draw, drawing_interval);

            var divId = container.attr('id');
            if(divId) {
                var divElement = document.getElementById(divId);
                divElement.addEventListener("touchstart", touchHandler, false);
                divElement.addEventListener("touchmove", touchHandler, false);
                divElement.addEventListener("touchend", touchHandler, false);
            }

            function touchHandler(e) {
                if (e.type == "touchstart") {
                    clicked = true;
                    motionx.reset();
                    motiony.reset();
                    vectorx = 0; 
                    vectory = 0;
                }
                else if (e.type == "touchmove") {
                    if (clicked) dragging = true;

                    if(dragging){
                        motionx.add(e.touches[0].pageX);
                        motiony.add(e.touches[0].pageY);
                        vectorx = motionx.avg();
                        vectory = motiony.avg();                                
                    }

                    e.preventDefault();
                }
                else if (e.type == "touchend" || e.type == "touchcancel") {
                    clicked = false;
                    dragging = false;
                    motionx.reset();
                    motiony.reset();
                }
            }

            container.mousedown(function(evt){
                if(evt.which == 1){
                    clicked = true;
                    motionx.reset();
                    motiony.reset();
                    vectorx = 0; 
                    vectory = 0;
                }
                evt.preventDefault();
                return false;
            });

            container.mousemove(function(evt){   
                if(clicked) dragging = true;

                if (dragging){
                    motionx.add(evt.pageX);
                    motiony.add(evt.pageY);
                    vectorx = motionx.avg();
                    vectory = motiony.avg();
                }
                evt.preventDefault();
            });

            container.mouseup(function(evt){
                if(evt.which == 1){
                    clicked = false;
                    dragging = false;
                    motionx.reset();
                    motiony.reset();                            
                }
            });


        },
        mqueue: function(size){
            this.items = [];
            this.size = size;
            this.last = 0;

            this.reset = function(){
                this.items = [];  
            };

            this.add = function(abs_val){
                var val = 0;

                //if we have no last value, store the current value as the last
                //that way movement starts out at 0 rather than jumping about
                if (this.last === 0) this.last = abs_val;

                // calculate val as movement rather than absolute coordinates
                val = abs_val - this.last;

                this.last = abs_val;
                // add item to list and remove last item if list is too large
                this.items.push(val);

                if(this.items.length > this.size){
                    this.items.shift();
                }
            };

            this.avg = function(){
                var total = 0;
                var rv = 0;

                if (this.items.length > 1){
                    for(var i in this.items){
                        total += this.items[i];
                    }
                    rv = (total / size);
                }

                return rv;
            };
        }
    };
    return native5;
})(jQuery,native5);

/**
 * This is the functin which will convert the appropriate DOM node to a Hozinatally Scrollable Menu.
 * The expected syntax will be <br />
 * <pre style="background:#EFEEED; border: 1px solid #BABABA; padding: 5px; color: #336699">
&lt;ParentNode&gt;  <span style="color:#339966">-- Parent container holding all the DOM elements of Horizontal Scroll Menu.</span>
	&lt;Left Navigation Menu /&gt;
	&lt;Container&gt; <span style="color:#339966">-- Fixed width container. This will be the width of scroll menu.</span>
		&lt;Container&gt; <span style="color:#339966">-- Container for all the scrollable items. It's size should at least equal to sum of all items.</span>
			&lt;Scrollable Items /&gt; <span style="color:#339966">--Menu items.</span>
			&lt;Scrollable Items /&gt;
			...
		&lt;/Container&gt;
	&lt;/Container&gt;
	&lt;Right Navigation Menu /&gt;
&lt;/ParentNode&gt;
</pre>
 * User can now call TouchScroll function on <span style="border: 1px solid #BABABA;">&lt;ParentNode&gt;</span>. If the <span style="border: 1px solid #BABABA;">&lt;ParentNode&gt;</span> doesn't have any child node, the function will return <i>null</i>.
 * @class jQuery
*/

(function($) {
	
	/**
	 *	This jQuery method converts the DOM node with proper syntax to a Horizontal Scroll Menu.
	 *	@method TouchScroll
	 *  @param [options] {Object}
	 *	@param [options.leftElm] {Object} DOM node which will act as `left` controller. On click, one item will move to the right.
	 *	@param [options.rightElm] {Object} DOM node which will act as `right` controller. On click, one item will move to the left.
	 *	@example
	 *		$(element).TouchScroll({leftElm: $("#left element")});
	*/ 
    $.fn.TouchScroll = function(options) {
        return this.each(function() {
            var defaults = {leftElm: null, rightElm: null};
            var settings  = $.extend(true, {}, defaults, options);

            var left      = settings.leftElm;
            var right     = settings.rightElm;
            var container = null;
			
			if($(this).children().length === 0) {
				return null;
			}
			else if($(this).children().length === 1) {
				container = $(this).children()[0];
			}
			else {
				container = $(this).children()[1];
			}
            
			var content   = $(container).children()[0];
            var touch = { start: {}, end: {} };
			var startTime = 0;
			var endTime = 0;

			var width = 0;
			var itemWidth = 0;
			$('> *', content).each(function() {
				width += $(this).outerWidth(true);
				var tempWidth = $(this).outerWidth(true);
				if(itemWidth < tempWidth) {
					itemWidth = tempWidth;
				}
				$(this).css("float", "left");
			});
			$(content).width(width);

            var max  = $(content).width() - $(container).width();
			touch.end.position = 0;
			$(content).bind('touchmove', touchmove);
			$(content).bind('touchstart', touchstart);
			
			applyCSS();

			$(left ).bind('touchstart', function(event) { move(event, 'left' ); });
			$(right).bind('touchstart', function(event) { move(event, 'right'); });

			function touchstart(event) {
				touch.start.x = event.originalEvent.targetTouches[0].pageX;
				touch.start.y = event.originalEvent.targetTouches[0].pageY;
				touch.start.position = touch.end.position;
				touch.start.time = Number(new Date());
				$(content).css('-webkit-transition', '');
				startTime = new Date().getTime();
			}

			function touchmove(event) {
				event.preventDefault();
				touch.end.x = event.originalEvent.targetTouches[0].pageX;
				touch.end.y = event.originalEvent.targetTouches[0].pageY;

				var deltaX = touch.end.x - touch.start.x;
				
				endTime = new Date().getTime();
				
				var touchSpeed = Math.abs(deltaX / (endTime - startTime));
				if(deltaX >= 0) {
					deltaX = 2 * touchSpeed * max;
				}
				else {
					deltaX = -(2* touchSpeed * max);
				}
				
				var target = touch.start.position + deltaX;

				/* constrain the target */
				if (target > 0) target = 0;
				if (target < -max) target = -max;
				
				checkArrows(target);
				$(content).css("-webkit-transition", "all linear 500ms");
				$(content).css('-webkit-transform', 'translate3d(' + target + 'px, 0, 0)');
				touch.end.position = target;
			}

			function move(event, direction) {
				var target = touch.end.position;

				if (direction == 'left') target += itemWidth;
				if (direction == 'right') target -= itemWidth;

				/* constrain the target */
				if (target > 0) target = 0;
				if (target < -max) target = -max;
				
				checkArrows(target);
				$(content).css('-webkit-transition', '-webkit-transform 0.5s ease-in-out');
				$(content).css('-webkit-transform', 'translate3d(' + target + 'px, 0, 0)');
				touch.end.position = target;
			}
			
			function checkArrows(target) {
				if(target === 0) {
					$(left).hide();
				}
				else {
					$(left).show();
				}
				
				if(target === -max) {
					$(right).hide();
				}
				else {
					$(right).show();
				}
			}
			
			function applyCSS() {
				$(this).css("position", "relative");
				$('*', this).css('-webkit-user-select', 'none');
				$('ul', this).css({'padding': 0, 'margin' : 0});
				$('li', this).css('list-style', 'none');
				
				$(container).css({"position": "relative", "overflow": "hidden"});
				$(content).css({
					'-webkit-transform': 'translate3d(0, 0, 0)',
					'position': 'absolute',
					'top': 0
				});
				$(left).css({
					'display': 'block',
					'position': 'absolute',
					'top': 0,
					'z-index': 999,
					'left': 0
				});
				$(right).css({
					'display': 'block',
					'position': 'absolute',
					'top': 0,
					'z-index': 999,
					'right': 0
				});
				$(left).hide();
			}
        });
    };
}(jQuery));
