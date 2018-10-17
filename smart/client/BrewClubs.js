isc.defineClass("BrewClubs", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BrewClubsDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "BrewClubs.php",
			showFilterEditor: true,
			fields:[
				{name: "clubID", primaryKey: true, type: "sequence", detail: true},
				{name: "clubName", width: "*"},
				{name: "clubAbbr", width: 80},
				{name: "distance", type: "integer", width: 80, detail: true},
				{name: "city", width: 150, detail: true},
				{name: "state", width: 80, detail: true},
				{name: "updated", type: "integer", width: 80, detail: true},
				{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
				{name: "lastChangeDate", type: "date", detail: true, canEdit: false}
			]
		});
		this.BrewClubsLG = isc.myListGrid.create({
			parent: this,
			name: "Brew Clubs",
			dataSource: this.BrewClubsDS,
			showFilterEditor: true,
			sortField: "clubName"
		});
		this.localContextMenu = isc.myClubMenu.create({
			parent: this,
			callingListGrid: this.BrewClubsLG
		});
		this.addItem(isc.myVLayout.create({members: [this.BrewClubsLG]}));
	}
});
