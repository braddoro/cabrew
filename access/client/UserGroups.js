isc.defineClass("UserGroups", "myWindow").addProperties({
	height: 300,
	width: 600,
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.GroupDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "Groups.php",
			showFilterEditor: true,
			fields:[
				{name: "secGroupID", primaryKey: true, detail: true, type: "sequence"},
				{name: "groupName", width: 300, validators: [{type: "lengthRange", max: 200}]},
				{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
				{name: "lastChangeDate", width: 100, detail: true}
			]
		}),
		this.UserDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "Users.php",
			showFilterEditor: true,
			fields:[
				{name: "secUserID", primaryKey: true, detail: true, type: "sequence"},
				{name: "userName", width: 100, validators: [{type: "lengthRange", max: 20}]},
				{name: "password", width: 150, validators: [{type: "lengthRange", max: 45}]},
				{name: "fullName", width: 200, validators: [{type: "lengthRange", max: 50}]},
				{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
				{name: "lastChangeDate", width: 100, detail: true}
			]
		})
		this.UserGroupDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "UserGroups.php",
			showFilterEditor: true,
			fields:[
				{name: "secUserGroupID", primaryKey: true, detail: true, type: "sequence"},
				{name: "secUserID", width: 150, type: "integer", editorType: "selectItem", optionDataSource: this.UserDS, displayField: "fullName", valueField: "secUserID"},
				{name: "secGroupID", width: 150, type: "integer", editorType: "selectItem", optionDataSource: this.GroupDS, displayField: "groupName", valueField: "secGroupID"},
				{name: "lastChangeDate", width: 100, detail: true}
			]
		});
		this.UserGroupLG = isc.myListGrid.create({
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
