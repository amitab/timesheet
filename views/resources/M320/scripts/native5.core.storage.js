/**
* @preserve Copyright 2012 Native5
* This is a proprietary library defining core handlers and functions for 
* native5 client side framework. This library uses elements of JQuery for selectors
* and hence is used in tandem with it.
* native5.core.js
* version 0.5
* author: Native5 Solutions Inc.
*/

/**
 *	This is the parent module which holds all the custom widgets, UI elements, libraries, configurations (both client and server side), etc. done in Javascript/jQuery for Native5 Software Solutions &trade;.
 *	@module native5
*/

/**
 * This is the submodule containing all the configuration, services and libraries used for Native5 core libraries.
 * @submodule core
*/

/**
 * Storage APIs for both native and web apps built using the Native5 platform.
 * @class Storage
 * @constructor
*/

native5.core.Storage = function() {
	this.db = {};
	this.db.name = "native5";
	this.db.desc = "Default Database";
	this.db.size = 5*1024*1024;

};

/**
 * This method configures the database for the Storage.
 * @method setup
 * @param config {Object}
 * @param config.name {String} Name of the database.
 * @param config.desc {String} Description of the database.
 * @param config.size {Number} Size of the database.
 * @param config.tables {String} Tables inside the database.
*/

native5.core.Storage.prototype.setup = function(config) {
	if(config) {
		if(config.name != undefined) 
			this.db.name = config.name;
		if(config.desc != undefined)
			this.db.desc = config.desc;
		if(config.size)
			this.db.size = config.size;
		if(config.tables)
			this.db.tables = config.tables;
	}
	this.database = openDatabase(this.db.name, '', this.db.desc, this.db.size);
	for(i=0;i<this.db.tables.length;i++) {
		table = this.db.tables[i];
		
		sql = "create table if not exists "+table.name +"(";
		for(j=0;j<table.columns.length;j++) {
			column = table.columns[j];
			sql +=column.name + " " + column.type;
			if(column.primary == 'true')
				sql += " PRIMARY KEY";
			if(column.autoincrement)
				sql += ' AUTOINCREMENT';
			sql = sql + ",";
		}
		sql = sql.substring(0, sql.length-1) + ")";
		console.log(sql);
		this.database.transaction(function(tx) {
			tx.executeSql(sql, [], function(tx, rs){console.log(rs);}, function(tx, e){console.log(e.message);});	
		});	
	}
}

/**
 * This method saves the data to the database and returns the callback.
 * @method save
 * @param data {Object} Data to be saved to the database.
 * @param callback {Function} Callback function based on the result of execution.
*/

native5.core.Storage.prototype.save = function(data, callback) {
	var d = new Date;
	for(i=0;i<data.tables.length;i++) {
		table = data.tables[i];
		console.log(table.name);
		insertSQL = "insert into "+table.name + "(";
		valStr = "values(";
		vals = new Array();
		for(var key in table.values) {
			insertSQL += key +",";
			valStr+="?,"; 
			vals.push(table.values[key]);	
		}
		insertSQL = insertSQL.substring(0, insertSQL.length-1);
		valStr =valStr.substring(0, valStr.length-1);
		insertSQL +=") "+valStr+")";
		console.log(insertSQL);
		this.database.transaction(function(tx) {
				tx.executeSql(insertSQL, vals, callback, function(tx,e){console.log(e.message)});
		});
	}
}

native5.core.Storage.prototype.update = function(data, filters, callback) {
	var d = new Date;
	for(i=0;i<data.tables.length;i++) {
		table = data.tables[i];
		uSQL = "update "+table.name + " set ";
		for(var key in table.values) {
			uSQL += key+"="+table.values[key]+",";
		}
		uSQL = uSQL.substring(0, uSQL.length-1);
		options = new Array();
		if(filters) {
		for(i=0;i<filters.length;i++) {
			filter = filters[i];
			if(filter) {
				clause = " where ";
				for(var i in filter) {
					key = i;
					if(filter.exact) {
						options.push(filter[i]);
						clause += key + " = ? and";
					} else {
						fil = filter[i].trim();
						fil="%"+fil.replace("*", "%")+"%";
						options.push(fil);
						clause += key +" like ? and";
					}
				}
			}
		}
		}
		clause = clause.substring(0, clause.lastIndexOf(" and"));
		uSQL= uSQL+clause;
		console.log(uSQL);
		this.database.transaction(function(tx) {
				tx.executeSql(uSQL, options, callback, function(tx,e){console.log(e.message)});
		});
	}
}

/**
 * This method finds the required data from the given table. Users can further customise the search string.
 * @method find
 * @param table {String} Name of the table where search is to be performed.
 * @param filters {String} Filters (for SQL) to narrow down the result.
 * @param callback {Function} Callback function based on the result of execution.
*/

native5.core.Storage.prototype.find = function(table, filters, callback) {
	selectC = "select * from "+table.name;
	options = new Array();
	if(filters) {
		for(i=0;i<filters.length;i++) {
		filter = filters[i];
		if(filter) {
			clause = " where ";
			for(var i in filter) {
				key = i;
				if(key != "exact") {
				if(filter.exact) {
					options.push(filter[i]);
					clause += key + " = ? and";
				} else {
					fil = filter[i].trim();
					fil="%"+fil.replace("*", "%")+"%";
					options.push(fil);
					clause += key +" like ? and";
				}
				}
			}
			clause = clause.substring(0, clause.lastIndexOf(" and"));
			selectC = selectC+clause;
		}
		}
	}
	this.database.transaction(function(tx) {
		tx.executeSql(selectC, options, callback);
	});
}

/**
 * This method returns the callback if the database is updated.
 * @method findUpdated
 * @param callback {Function} Callback function which will be performed if the update is found.
*/

native5.core.Storage.prototype.findUpdated = function(callback) {
	filters = new Array();
	filter = {};
	filter.updated = 1;
	filter.exact = 1;
	filters.push(filter);
	this.find(filter,callback);
}

/**
 * This method deletes the entries from the existing table.
 * @method delete
 * @param table {String} Name of the table on which delete action is to be performed.
 * @param filters {String} Filters (written in SQL) required to narrow down the search of entries to be deleted.
 * @param callback {Function} Callback function which will be performed if the deletion is successful.
*/

native5.core.Storage.prototype.deleteDB = function(table, filters, callback) {
	deleteC = "delete from "+table.name;
	options = new Array();
	if(filters) {
		for(i=0;i<filters.length;i++) {
		filter = filters[i];
		if(filter) {
			clause = " where ";
			for(var i in filter) {
					key = i;
					if(filter[i] instanceof Array) {
						clause += table.name+"."+key + " in (";  
						for(var j in filter[i]) {		
							options.push(filter[i][j]);
							clause += "?,"
						}
						clause = clause.substring(0, clause.length-1);
						clause +=") and";
					} else {
						options.push(filter[i]);
						clause += table.name+"."+key + " = ? and";
					}
			}
			clause = clause.substring(0, clause.lastIndexOf(" and"));
			deleteC = deleteC+clause;
		}
		}
	}
	console.log(deleteC);
	this.database.transaction(function(tx) {
		tx.executeSql(deleteC, options, callback, function(tx, e) {
			console.log("Error happened " + e);
		});
	});
} 
