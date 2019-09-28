isc.defineClass("ItemGroups", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		if(!checkPerms(this.getClassName() + ".js")){
			isc.warn(this.mm_accessFail);
			this.close();
		}
		this.ItemGroupDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "ItemGroups.php",
			showFilterEditor: true,
			fields:[
				{name: "secItemGroupID", primaryKey: true, detail: true, type: "sequence"},
				{name: "secItemID", width: "50%", type: "integer", editorType: "selectItem", optionDataSource: isc.Shared.ItemDS, displayField: "itemName", valueField: "secItemID"},
				{name: "secGroupID", width: "50%", type: "integer", editorType: "selectItem", optionDataSource: isc.Shared.GroupDS, displayField: "groupName", valueField: "secGroupID"},
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
		this.ItemGroupLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
