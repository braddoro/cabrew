
isc.defineClass("EventTeamNames", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.EventTeamNamesLG = isc.myListGrid.create({
		parent: this,
		dataSource: isc.Shared.eventTeamNamesDS,
		name: "Event Team Names"
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.EventTeamNamesLG
	});
	this.addItem(isc.myVLayout.create({members: [this.EventTeamNamesLG]}));
	}
});
