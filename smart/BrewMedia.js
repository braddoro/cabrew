isc.defineClass("BrewMedia", "myWindow").addProperties({
	title: "Brew Media",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BrewMediaDS = isc.myDataSource.create({
			dataURL: "BrewMedia.php",
			showFilterEditor: true,
			fields:[
				{name: "mediaID", primaryKey: true, type: "sequence"},
				{name: "clubID"},
				{name: "typeID"},
				{name: "priority"},
				{name: "media"}
			]
		});
		this.BrewMediaLG = isc.myListGrid.create({
			parent: this,
			dataSource: this.BrewMediaDS,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.BrewMediaLG
		});
		this.BrewMediaVL = isc.myVLayout.create({members: [this.BrewMediaLG]});
		this.addItem(this.BrewMediaVL);
	}
});
