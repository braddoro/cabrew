isc.defineClass("EventStatusTypes", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.EventStatusTypesLG = isc.myListGrid.create({
		parent: this,
		autoFetchData: true,
		dataSource: isc.Shared.eventStatusTypesDS,
		name: "Thread Types"
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.EventStatusTypesLG
	});
	this.addItem(isc.myVLayout.create({members: [this.EventStatusTypesLG]}));
	}
});
