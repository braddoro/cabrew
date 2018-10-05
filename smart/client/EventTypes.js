isc.defineClass("EventTypes", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.EventTypesLG = isc.myListGrid.create({
		parent: this,
		dataSource: isc.Shared.eventTypesDS,
		name: "Event Types"
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.EventTypesLG
	});
	this.addItem(isc.myVLayout.create({members: [this.EventTypesLG]}));
	}
});
