isc.defineClass("DateTypes", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.DateTypesLG = isc.myListGrid.create({
		parent: this,
		dataSource: isc.Shared.dateTypesDS,
		name: "Date Types",
		autoFetchData: true
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.DateTypesLG
	});
	this.DateTypesVL = isc.myVLayout.create({members: [this.DateTypesLG]});
	this.addItem(this.DateTypesVL);
	}
});
