isc.defineClass("BrewMedia", "myWindow").addProperties({
	title: "Brew Media",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.brewMediaDS = isc.myDataSource.create({
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
		this.brewMediaLG = isc.myListGrid.create({
			parent: this,
			dataSource: this.brewMediaDS,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.brewMediaLG
		});
		this.brewMediaVL = isc.myVLayout.create({members: [this.brewMediaLG]});
		this.addItem(this.brewMediaVL);
	}
});
