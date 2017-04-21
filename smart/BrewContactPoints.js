isc.defineClass("BrewContactPoints", "myWindow").addProperties({
	title: "Brew Contact Points",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BrewContactPointsDS = isc.myDataSource.create({
			dataURL: "BrewContactPoints.php",
			showFilterEditor: true,
			fields:[
				{name: "contactPointID", primaryKey: true, type: "sequence"},
				{name: "contactID"},
				{name: "typeID"},
				{name: "contactPoint"}
			]
		});
		this.BrewContactPointsLG = isc.myListGrid.create({
			parent: this,
			dataSource: this.BrewContactPointsDS,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.BrewContactPointsLG
		});
		this.BrewContactPointsVL = isc.myVLayout.create({members: [this.BrewContactPointsLG]});
		this.addItem(this.BrewContactPointsVL);
	}
});
