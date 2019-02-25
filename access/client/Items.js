isc.defineClass("Items", "myWindow").addProperties({
	height: 300,
	width: 600,
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		// this.ItemDS = isc.myDataSource.create({
		// 	cacheAllData: false,
		// 	dataURL: serverPath + "Items.php",
		// 	showFilterEditor: true,
		// 	fields:[
		// 		{name: "secItemID", primaryKey: true, detail: true, type: "sequence"},
		// 		{name: "itemName", width: 300, validators: [{type: "lengthRange", max: 200}]},
		// 		{name: "itemType", width: 100, validators: [{type: "lengthRange", max: 45}]},
		// 		{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
		// 		{name: "lastChangeDate", width: 100, detail: true}
		// 	]
		// });
		this.ItemLG = isc.myListGrid.create({
			dataSource: isc.Shared.ItemDS,
			name: "Items",
			parent: this,
			showFilterEditor: true
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.ItemLG
		});
		this.addItem(isc.myVLayout.create({members: [this.ItemLG]}));
	}
});
