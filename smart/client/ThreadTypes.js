isc.defineClass("ThreadTypes", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);

	this.threadTypesDS = isc.myDataSource.create({
		dataURL: serverPath + "ThreadTypes.php",
		fields:[
			{name: "threadTypeID", type: "sequence", primaryKey: true, detail: true, canEdit: false},
			{name: "threadType", type: "text"},
			{name: "active", type: "text", width: 80},
			{name: "lastChangeDate", type: "datetime", canEdit: false, detail: true}
		]
	});

	this.ThreadTypesLG = isc.myListGrid.create({
		parent: this,
		autoFetchData: true,
		dataSource: this.threadTypesDS,
		name: "Thread Types"
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.ThreadTypesLG
	});
	this.addItem(isc.myVLayout.create({members: [this.ThreadTypesLG]}));
	}
});
