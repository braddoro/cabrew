isc.defineClass("BrewContactPoints", "myWindow").addProperties({
	title: "Brew Contact Points",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BrewContactPointsDS = isc.myDataSource.create({
			dataURL: "BrewContactPoints.php",
			autoFetchData: false,
			fields:[
				{name: "contactPointID", primaryKey: true, type: "sequence", detail: true},
				{name: "contactID", detail: true},
				{name: "contactTypeID_fk", title: "Type", optionDataSource: isc.Shared.contactTypesDS, displayField: "contactType", valueField: "contactTypeID", width: 75},
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
		if(initData.contactID){
			this.BrewContactPointsLG.fetchData({contactID: initData.contactID});
		}
	}
});
