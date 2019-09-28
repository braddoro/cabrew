isc.defineClass("BrewClubs", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BrewClubsDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "BrewClubs.php",
			showFilterEditor: true,
			fields:[
				{name: "clubID", primaryKey: true, type: "sequence", detail: true, canEdit: false},
				{name: "LastYear", width: 75, prompt: "The last year this club as invited.", canEdit: false},
				{name: "clubName", width: "*"},
				{name: "clubAbbr", width: 75},
				{name: "distance", type: "integer", width: 65},
				{name: "city", width: 150},
				{name: "state", width: 50},
				{name: "active", type: "text", width: 50, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
				{name: "lastChangeDate", type: "date", detail: true, canEdit: false}
			]
		});
		this.BrewClubsLG = isc.myListGrid.create({
			dataSource: this.BrewClubsDS,
			name: "Brew Clubs",
			parent: this,
			showFilterEditor: true,
			sortField: "clubName"
		});
		this.localContextMenu = isc.myClubMenu.create({
			callingListGrid: this.BrewClubsLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.BrewClubsLG]}));
		this.BrewClubsLG.canEdit = checkPerms(this.getClassName() + ".js");
		this.BrewClubsLG.filterData({active: "Y"});
	}
});
