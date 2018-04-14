isc.defineClass("BrewMedia", "myWindow").addProperties({
	title: "Brew Media",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BrewMediaDS = isc.myDataSource.create({
			dataURL: serverPath + "BrewMedia.php",
			fields:[
				{name: "mediaID", primaryKey: true, type: "sequence", detail: true},
				{name: "clubID", detail: true},
				{name: "contactTypeID_fk", title: "Type", optionDataSource: isc.Shared.contactTypesDS, displayField: "contactType", valueField: "contactTypeID", width: 75},
				{name: "priority", width: 75},
				{name: "media"}
			]
		});
		this.BrewMediaLG = isc.myListGrid.create({
			parent: this,
			name: "Brew Media",
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
		if(initData.clubID){
			this.BrewMediaLG.fetchData({clubID: initData.clubID});
		}
	}
});
