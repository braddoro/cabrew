isc.defineClass("NCHISchedule", "myWindow").addProperties({
	title: "NCHI Planning Schedule",
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.NCHIScheduleDS = isc.myDataSource.create({
		dataURL: serverPath + "NCHISchedule.php",
		showFilterEditor: true,
		fields:[
			{name: "checklistID", primaryKey: true, detail: true, type: "sequence"},
			{name: "phase", width: 50, type: "integer", valueMap:["1","2","3","4","5"]},
			{name: "dueDate", width: 100, useTextField: true, editorType: "DateItem", validators: [{type: "isDate"}]},
			{name: "step", width: 300, validators: [{type: "lengthRange", max: 100}]},
			{name: "status", width: 100, validators: [{type: "lengthRange", max: 45}]},
			{name: "assignee", width: 150, validators: [{type: "lengthRange", max: 45}]},
			{name: "notes", width: "*", validators: [{type: "lengthRange", max: 1000}]},


			{name: "lastChangeDate", width: 100, detail: true}
		]
	});
	this.NCHIScheduleLG = isc.myListGrid.create({
		parent: this,
		id: "NCHIScheduleLG",
		showFilterEditor: true,
		canEdit: false,
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
		recordClick: function (viewer, record, recordNum, field, fieldNum, value, rawValue){
			return true;
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
