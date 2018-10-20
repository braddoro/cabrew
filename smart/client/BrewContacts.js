isc.defineClass("BrewContacts", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BrewContactsDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "BrewContacts.php",
			fields:[
				{name: "contactID", primaryKey: true, type: "sequence", detail: true},
				{name: "clubID", detail: true, required: true},
				{name: "contactName"},
				{name: "priority", editorType: "spinner", width: 100, defaultValue: 1}
			]
		});
		this.BrewContactsLG = isc.myListGrid.create({
			parent: this,
			name: "Brew Contacts",
			dataSource: this.BrewContactsDS,
			startEditingNew: function(newValues, suppressFocus){
				var moreCriteria = isc.addProperties({}, newValues, {clubID: initData.clubID});
				return this.Super("startEditingNew", [moreCriteria, suppressFocus]);
			}
		});
		this.localContextMenu = isc.myContactMenu.create({
			callingListGrid: this.BrewContactsLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.BrewContactsLG]}));
		this.BrewContactsLG.fetchData({clubID: initData.clubID});
	}
});
