isc.defineClass("EventSchedules", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.EventScheduleDS = isc.myDataSource.create({
		dataURL: serverPath + "EventSchedules.php",
		showFilterEditor: true,
		fields:[
			{name: "checklistDataID", primaryKey: true, detail: true, type: "sequence"},
			{name: "checklistTypeID", width: 150, type: "integer", optionDataSource: isc.Shared.checklistTypesDS, displayField: "checklistType", valueField: "checklistTypeID"},
			{name: "phase", width: 60, type: "integer", editorType: "spinner", valueMap:["1","2","3","4","5"]},
			{name: "dueDate", width: 100, useTextField: true, editorType: "DateItem", validators: [{type: "isDate"}]},
			{name: "step", width: 300, validators: [{type: "lengthRange", max: 100}]},
			{name: "status", width: 100, validators: [{type: "lengthRange", max: 45}], valueMap:["", "not started","in process","blocked","complete"]},
			{name: "memberID_fk", width: 120, title: "Member", allowEmptyValue: true, type: "text", optionDataSource: isc.Shared.memberNamesDS, optionCriteria: {statusTypeID_fk: 1}, displayField: "FullName", valueField: "memberID", pickListWidth: 150, pickListProperties: {showFilterEditor: true}, pickListFields: [{name: "FullName", width: "*"}]},
			{name: "cost", width: 100, type: "float"},
			{name: "milestone", width: 80, type: "text", editorType: "selectItem", defaultValue: "", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
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
			var phase = 1;
			var checklistTypeID;
			if(this.anySelected()){
				data = this.getSelectedRecord();
				today = data.dueDate;
				step = data.step;
				checklistTypeID = data.checklistTypeID;
				phase = data.phase;
			}else{
				today = new Date();
			}
			var rowDefaults = {step: step, phase: phase, dueDate: today, checklistTypeID: checklistTypeID};
			var newCriteria = isc.addProperties({}, newValues, rowDefaults);
			return this.Super("startEditingNew", [newCriteria, suppressFocus]);
		}
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.EventScheduleLG
	});
	this.addItem(isc.myVLayout.create({members: [this.EventScheduleLG]}));
	this.EventScheduleLG.filterData({statusTypeID_fk: 1});
  }
});
