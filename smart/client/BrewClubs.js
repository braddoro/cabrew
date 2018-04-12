isc.defineClass("BrewClubs", "myWindow").addProperties({
	title: "Brew Clubs",
	autoFetch: true,
	hideNames: false,
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BrewClubsDS = isc.myDataSource.create({
			dataURL: serverPath + "BrewClubs.php",
			showFilterEditor: true,
			fields:[
				{name: "clubID", primaryKey: true, type: "sequence", detail: true},
				{name: "clubName"},
				{name: "clubAbbr"},
				{name: "city"},
				{name: "state"},
				{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
				{name: "lastChangeDate", type: "date", detail: true, canEdit: false}
			]
		});
		this.BrewClubsLG = isc.myListGrid.create({
			parent: this,
			name: "Brew Clubs",
			dataSource: this.BrewClubsDS,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			}
		});
		this.localContextMenu = isc.myClubMenu.create({
			parent: this,
			callingListGrid: this.BrewClubsLG
		});
		this.BrewClubsVL = isc.myVLayout.create({members: [this.BrewClubsLG]});
		this.addItem(this.BrewClubsVL);
	}
});
