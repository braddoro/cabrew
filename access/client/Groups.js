isc.defineClass("Groups", "myWindow").addProperties({
	height: 300,
	width: 600,
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		// this.GroupDS = isc.myDataSource.create({
		// 	cacheAllData: false,
		// 	dataURL: serverPath + "Groups.php",
		// 	showFilterEditor: true,
		// 	fields:[
		// 		{name: "secGroupID", primaryKey: true, detail: true, type: "sequence"},
		// 		{name: "groupName", width: 300, validators: [{type: "lengthRange", max: 200}]},
		// 		{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
		// 		{name: "lastChangeDate", width: 100, detail: true}
		// 	]
		// });
		this.GroupLG = isc.myListGrid.create({
			dataSource: isc.Shared.GroupDS,
			name: "Groups",
			parent: this,
			showFilterEditor: true
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.GroupLG
		});
		this.addItem(isc.myVLayout.create({members: [this.GroupLG]}));
	}
});
