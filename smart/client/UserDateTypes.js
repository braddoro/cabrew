isc.defineClass("UserDateTypes", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		if(!checkPerms(this.getClassName() + ".js")){
			isc.warn(this.mm_accessFail);
			this.close();
		}
		this.UserDateTypeDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "UserDateTypes.php",
			showFilterEditor: true,
			fields:[
				{name: "UserDateTypeID", primaryKey: true, detail: true, type: "sequence"},
				{name: "DateUserID", width: 150, editorType: "selectItem", optionDataSource: isc.Shared.UserDS, displayField: "fullName", valueField: "secUserID"},
				{name: "DateTypeID", width: 150, optionDataSource: isc.Shared.dateTypesDS, optionCriteria: {active: "Y"}, displayField: "dateType", valueField: "dateTypeID", pickListProperties: {showFilterEditor: true}},
				{name: "lastChangeDate", width: 100, detail: true}
			]
		});
		this.UserDateTypeLG = isc.myListGrid.create({
			autoFetchData: true,
			dataSource: this.UserDateTypeDS,
			name: "User Date Type Access",
			parent: this,
			showFilterEditor: true
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.UserDateTypeLG
		});
		this.addItem(isc.myVLayout.create({members: [this.UserDateTypeLG]}));
		this.UserDateTypeLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
