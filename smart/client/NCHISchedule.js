isc.defineClass("NCHISchedule", "myWindow").addProperties({
	title: "CABREW Event Planning Schedule",
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.NCHIScheduleDS = isc.myDataSource.create({
		dataURL: serverPath + "NCHISchedule.php",
		showFilterEditor: true,
		fields:[
			{name: "checklistDataID", primaryKey: true, detail: true, type: "sequence"},
			{name: "checklistTypeID", width: 100, type: "integer", optionDataSource: isc.Shared.checklistTypesDS, displayField: "checklistType", valueField: "checklistTypeID"},
			{name: "phase", width: 60, type: "integer", editorType: "spinner", valueMap:["1","2","3","4","5"]},
			{name: "dueDate", width: 100, useTextField: true, editorType: "DateItem", validators: [{type: "isDate"}]},
			{name: "step", width: 300, validators: [{type: "lengthRange", max: 100}]},
			{name: "status", width: 100, validators: [{type: "lengthRange", max: 45}], valueMap:["", "not started","in process","blocked","complete"]},
			{name: "assignee", width: 150, validators: [{type: "lengthRange", max: 45}]},
			{name: "notes", width: "*", validators: [{type: "lengthRange", max: 1000}]},
			{name: "lastChangeDate", width: 100, detail: true}
		]
	});
	this.NCHIScheduleLG = isc.myListGrid.create({
		parent: this,
		name: "CABREW Event Planning Schedule",
		id: "NCHIScheduleLG",
		showFilterEditor: true,
		dataSource: this.NCHIScheduleDS,
		initialSort: [
			{property: "phase", direction: "ascending"},
			{property: "dueDate", direction: "ascending"},
			{property: "step", direction: "ascending"}
		],
		rowContextClick: function(record, rowNum, colNum){
			this.parent.localContextMenu.showContextMenu();
			return false;
		},
		dataArrived: function(){
			var statusText = this.parent.baseTitle;
			statusText += " - Rows: ";
			statusText += this.getTotalRows();
			this.parent.setTitle = statusText;
		},
		rowDoubleClick: function(record, recordNum, fieldNum, keyboardGenerated) {
			this.startEditing(recordNum);
		},
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
		callingListGrid: this.NCHIScheduleLG
	});
	this.NCHIScheduleVL = isc.myVLayout.create({members: [this.NCHIScheduleLG]});
	this.addItem(this.NCHIScheduleVL);
	this.NCHIScheduleLG.filterData({statusTypeID_fk: 1});
  }
});
