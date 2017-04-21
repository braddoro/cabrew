isc.defineClass("BrewClubs", "myWindow").addProperties({
	title: "Brew Clubs",
	autoFetch: true,
	hideNames: false,
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BrewClubsDS = isc.myDataSource.create({
			dataURL: "BrewClubs.php",
			showFilterEditor: true,
			fields:[
				{name: "clubID", primaryKey: true, type: "sequence"},
				{name: "clubName"},
				{name: "clubAbbr"},
				{name: "city"},
				{name: "state"}
			]
		});
		this.BrewClubsLG = isc.myListGrid.create({
			parent: this,
			dataSource: this.BrewClubsDS,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.BrewClubsLG
		});
		this.BrewClubsVL = isc.myVLayout.create({members: [this.BrewClubsLG]});
		this.addItem(this.BrewClubsVL);
	}
});
