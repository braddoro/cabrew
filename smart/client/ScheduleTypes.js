isc.defineClass("ScheduleTypes", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.ScheduleTypesLG = isc.myListGrid.create({
		parent: this,
		dataSource: isc.Shared.eventTypesDS,
		name: "Schedule Types"
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.ScheduleTypesLG
	});
	this.addItem(isc.myVLayout.create({members: [this.ScheduleTypesLG]}));
	}
});
