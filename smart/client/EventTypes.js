isc.defineClass("EventTypes", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.EventTypesLG = isc.myListGrid.create({
		dataSource: isc.Shared.eventTypesDS,
		name: "Event Types",
		parent: this
	});
	this.localContextMenu = isc.myContextMenu.create({
		callingListGrid: this.EventTypesLG,
		parent: this
	});
	this.addItem(isc.myVLayout.create({members: [this.EventTypesLG]}));
	}
});
