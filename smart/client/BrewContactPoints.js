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
				{name: "priority", type: "integer", editorType: "spinner", defaultValue: 1},
				{name: "contactPoint", type: "text"}
			]
		});
		this.BrewContactPointsLG = isc.myListGrid.create({
			parent: this,
			name: "Brew Contact Points",
			dataSource: this.BrewContactPointsDS,
			startEditingNew: function(newValues, suppressFocus){
				var moreCriteria = isc.addProperties({}, newValues, {contactID: initData.contactID});
				return this.Super("startEditingNew", [moreCriteria, suppressFocus]);
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.BrewContactPointsLG
		});
		this.addItem(isc.myVLayout.create({members: [this.BrewContactPointsLG]}));
		this.BrewContactPointsLG.fetchData({contactID: initData.contactID});
	}
});
