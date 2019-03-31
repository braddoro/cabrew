isc.defineClass("ShowLog", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.ShowLogDS = isc.myDataSource.create({
			dataURL: serverPath + "ShowLog.php",
			fields: [
				{name: "siteLogID", type: "sequence", primaryKey: true, width: 60},
				{name: "siteLogTimeStamp", type: "datetime", width: "120"},
				{name: "pageName", type: "text", width: "100"},
				{name: "action", type: "text", width: "60"},
				{name: "ip_address", type: "text", width: "60"},
				{name: "fullName", type: "text", width: "120"},
				{name: "userID", type: "text", width: "60"},
				{name: "tableName", type: "text", width: "100"},
				{name: "primaryKey", type: "text", width: "100"},
				{name: "primaryKeyID", type: "text", width: "75"},
				{name: "fieldsVals", type: "text", width: "*"}
			]
		});
		this.ShowLogLG = isc.myListGrid.create({
			dataSource: this.ShowLogDS,
			name: "Show Log",
			canEdit: false,
			parent: this,
			showFilterEditor: true
		});
		this.localContextMenu = isc.myRefreshMenu.create({
			callingListGrid: this.ShowLogLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.ShowLogLG]}));
	}
});
