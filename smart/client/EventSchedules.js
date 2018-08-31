isc.defineClass("EventSchedules", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.EventScheduleDS = isc.myDataSource.create({
		dataURL: serverPath + "EventSchedules.php",
		showFilterEditor: true,
		fields:[
			{name: "eventDataID", primaryKey: true, detail: true, type: "sequence"},
			{name: "eventTypeID", width: 120, type: "integer", title: "Event", optionDataSource: isc.Shared.eventTypesDS, displayField: "checklistType", valueField: "checklistTypeID", optionCriteria: {active: 'Y'}},
			{name: "memberID", width: 120, title: "Member", allowEmptyValue: true, type: "text", optionDataSource: isc.Shared.memberNamesDS, optionCriteria: {statusTypeID_fk: 1}, displayField: "FullName", valueField: "memberID", pickListWidth: 150, pickListProperties: {showFilterEditor: true}, pickListFields: [{name: "FullName", width: "*"}]},
			{name: "dueDate", width: 100, useTextField: true, editorType: "DateItem", validators: [{type: "isDate"}]},
			{name: "step", width: 300, validators: [{type: "lengthRange", max: 100}]},
			{name: "status", width: 75, validators: [{type: "lengthRange", max: 45}], valueMap:["not started","in process","blocked","complete","not needed"]},
			{name: "cost", width: 50, type: "float"},
			{name: "notes", width: "*", validators: [{type: "lengthRange", max: 1000}]},
			{name: "lastChangeDate", width: 100, detail: true}
		]
	});
	this.EventScheduleLG = isc.myListGrid.create({
		parent: this,
		name: "Event Planning Playlist",
		showFilterEditor: true,
		dataSource: this.EventScheduleDS,
		initialSort: [{property: "dueDate", direction: "ascending"}],
		startEditingNew: function(newValues, suppressFocus){
			var today;
			var step;
			var data;
			var checklistTypeID;
			if(this.anySelected()){
				data = this.getSelectedRecord();
				today = data.dueDate;
				step = data.step;
				thread = data.thread;
				checklistTypeID = data.checklistTypeID;
			}else{
				today = new Date();
			}
			var rowDefaults = {step: step, thread: thread, dueDate: today, checklistTypeID: checklistTypeID};
			var newCriteria = isc.addProperties({}, newValues, rowDefaults);
			return this.Super("startEditingNew", [newCriteria, suppressFocus]);
		}
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.EventScheduleLG
	});
	this.addItem(isc.myVLayout.create({members: [this.EventScheduleLG]}));
	this.EventScheduleLG.filterData();
  }
});
