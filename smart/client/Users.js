isc.defineClass("Users", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.UserDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "Users.php",
			showFilterEditor: true,
			fields:[
				{name: "secUserID", primaryKey: true, detail: true, type: "sequence"},
				{name: "userName", width: 150, validators: [{type: "lengthRange", max: 45}]},
				{name: "password", width: 150, validators: [{type: "lengthRange", max: 45}]},
				{name: "fullName", width: 100, validators: [{type: "lengthRange", max: 50}]},
				{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
				{name: "lastChangeDate", width: 100, detail: true}
			]
		});
		this.UserLG = isc.myListGrid.create({
			autoFetchData: true,
			dataSource: isc.Shared.UserDS,
			name: "Users",
			parent: this,
			showFilterEditor: true
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.UserLG
		});
		this.addItem(isc.myVLayout.create({members: [this.UserLG]}));
	}
});
