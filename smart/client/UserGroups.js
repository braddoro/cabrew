isc.defineClass("UserGroups", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		if(!checkPerms(this.getClassName() + ".js")){
			isc.warn(this.mm_accessFail);
			this.close();
		}
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
		this.UserGroupLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
