isc.defineClass("ItemGroups", "myWindow").addProperties({
	top: 150,
	left: 150,
	height: 300,
	width: 600,
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.ItemGroupDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "ItemGroups.php",
			showFilterEditor: true,
			fields:[
				{name: "secItemGroupID", primaryKey: true, detail: true, type: "sequence"},
				{name: "secItemID", width: 150, type: "integer", editorType: "selectItem", optionDataSource: isc.Shared.ItemDS, displayField: "itemName", valueField: "secItemID"},
				{name: "secGroupID", width: 150, type: "integer", editorType: "selectItem", optionDataSource: isc.Shared.GroupDS, displayField: "groupName", valueField: "secGroupID"},
				{name: "lastChangeDate", width: 100, detail: true}
			]
		});
		this.ItemGroupLG = isc.myListGrid.create({
			autoFetchData: true,
			dataSource: this.ItemGroupDS,
			name: "Item Groups",
			parent: this,
			showFilterEditor: true
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.ItemGroupLG
		});
		this.addItem(isc.myVLayout.create({members: [this.ItemGroupLG]}));
	}
});
