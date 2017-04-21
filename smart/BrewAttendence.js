isc.defineClass("BrewAttendence", "myWindow").addProperties({
	title: "Brew Attendence",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BrewAttendenceDS = isc.myDataSource.create({
			dataURL: "BrewAttendence.php",
			showFilterEditor: true,
			fields:[
				{name: "attendenceID", primaryKey: true, type: "sequence"},
				{name: "clubID"},
				{name: "year"},
				{name: "attended"},
				{name: "beers"}
			]
		});
		this.BrewAttendenceLG = isc.myListGrid.create({
			parent: this,
			dataSource: this.BrewAttendenceDS,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.BrewAttendenceLG
		});
		this.BrewAttendenceVL = isc.myVLayout.create({members: [this.BrewAttendenceLG]});
		this.addItem(this.BrewAttendenceVL);
	}
});
