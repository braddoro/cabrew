isc.defineClass("EventSchedules", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.EventScheduleDS = isc.myDataSource.create({
		dataURL: serverPath + "EventSchedules.php",
		showFilterEditor: true,
		fields:[
			{name: "eventScheduleID", primaryKey: true, detail: true, type: "sequence"},
			{name: "typeID", width: 120, type: "integer", title: "Type"},
			{name: "eventID", width: 120, type: "integer", title: "Event", optionDataSource: isc.Shared.eventTypesDS, displayField: "eventType", valueField: "eventTypeID", optionCriteria: {active: "Y"}},
			{name: "stepStart", type: "time", title: "Start", editorType: "TimeItem"},
			{name: "step", width: "*", validators: [{type: "lengthRange", max: 100}]},
			{name: "stepDetails", width: 300, validators: [{type: "lengthRange", max: 1000}], detail: true},
			{name: "lastChangeDate", width: 100, detail: true}
		]
	});
	this.EventScheduleLG = isc.myListGrid.create({
		dataSource: this.EventScheduleDS,
		initialSort: [{property: "eventID", direction: "ascending"},{property: "date", direction: "ascending"},{property: "stepStart", direction: "ascending"}],
		name: "Event Scheduling",
		parent: this,
		showFilterEditor: true
	});
	this.localContextMenu = isc.myContextMenu.create({
		callingListGrid: this.EventScheduleLG,
		parent: this
	});
	this.addItem(isc.myVLayout.create({members: [this.EventScheduleLG]}));
  }
});
