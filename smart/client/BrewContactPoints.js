isc.defineClass("BrewContactPoints", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BrewContactPointsDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "BrewContactPoints.php",
			fields:[
				{name: "contactPointID", primaryKey: true, type: "sequence", detail: true},
				{name: "contactID", detail: true, required: true},
				{name: "contactTypeID_fk", title: "Type", optionDataSource: isc.Shared.contactTypesDS, displayField: "contactType", valueField: "contactTypeID", width: 75, defaultValue: 1},
				{name: "contactPoint", type: "text", width: "*"},
				{name: "priority", type: "integer", editorType: "spinner", width: 100, defaultValue: 1}
			]
		});
		this.BrewContactPointsLG = isc.myListGrid.create({
			dataSource: this.BrewContactPointsDS,
			name: "Brew Contact Points",
			parent: this,
			startEditingNew: function(newValues, suppressFocus){
				var moreCriteria = isc.addProperties({}, newValues, {contactID: initData.contactID});
				return this.Super("startEditingNew", [moreCriteria, suppressFocus]);
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.BrewContactPointsLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.BrewContactPointsLG]}));
		this.BrewContactPointsLG.fetchData({contactID: initData.contactID});
		this.BrewContactPointsLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
