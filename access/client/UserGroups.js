isc.defineClass("UserGroups", "myWindow").addProperties({
	top: 125,
	left: 125,
	height: 300,
	width: 600,
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.UserGroupDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "UserGroups.php",
			showFilterEditor: true,
			fields:[
				{name: "secUserGroupID", primaryKey: true, detail: true, type: "sequence"},
				{name: "secUserID", width: 150, type: "integer", editorType: "selectItem", optionDataSource: isc.Shared.UserDS, displayField: "fullName", valueField: "secUserID"},
				{name: "secGroupID", width: 150, type: "integer", editorType: "selectItem", optionDataSource: isc.Shared.GroupDS, displayField: "groupName", valueField: "secGroupID"},
				{name: "lastChangeDate", width: 100, detail: true}
			]
		});
		this.UserGroupLG = isc.myListGrid.create({
			autoFetchData: true,
			dataSource: this.UserGroupDS,
			name: "User Groups",
			parent: this,
			showFilterEditor: true
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.UserGroupLG
		});
		this.addItem(isc.myVLayout.create({members: [this.UserGroupLG]}));
	}
});
