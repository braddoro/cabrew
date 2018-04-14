isc.defineClass("ScheduleTypes", "myWindow").addProperties({
	title: "Schedule Types",
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.ScheduleTypesLG = isc.myListGrid.create({
		parent: this,
		dataSource: isc.Shared.checklistTypesDS,
		name: "Schedule Types"
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.ScheduleTypesLG
	});
	this.ScheduleTypesVL = isc.myVLayout.create({members: [this.ScheduleTypesLG]});
	this.addItem(this.ScheduleTypesVL);
	}
});
