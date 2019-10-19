isc.defineClass("EventPlans", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.EventPlanDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "EventPlans.php",
			showFilterEditor: true,
			fields:[
				{name: "eventPlanID", primaryKey: true, detail: true, type: "sequence"},
				{name: "eventTypeID", width: 120, type: "integer", title: "Event", optionDataSource: isc.Shared.eventTypesDS, displayField: "eventType", valueField: "eventTypeID", optionCriteria: {active: "Y"}},
				{name: "eventPhaseID", width: 120, type: "integer", title: "Phase", optionDataSource: isc.Shared.eventPhasesDS, displayField: "eventPhase", valueField: "eventPhaseID", optionCriteria: {active: "Y"}},
				{name: "memberID", width: 120, title: "Member", allowEmptyValue: true, type: "text", optionDataSource: isc.Shared.memberNamesDS, optionCriteria: {statusTypeID_fk: 1}, displayField: "FullName", valueField: "memberID", pickListWidth: 150, pickListProperties: {showFilterEditor: true}, pickListFields: [{name: "FullName", width: "*"}]},
				{name: "dueDate", width: 100, useTextField: true, editorType: "DateItem", validators: [{type: "isDate"}]},
				{name: "step", width: 300, validators: [{type: "lengthRange", max: 100}]},
				{name: "status", width: 75, validators: [{type: "lengthRange", max: 45}], valueMap:["not started","in process","blocked","complete","not needed","milestone"]},
				{name: "cost", width: 50, type: "float"},
				{name: "done", type: "text", width: 80, editorType: "selectItem", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV", canEdit: false},
				{name: "notes", width: "*", validators: [{type: "lengthRange", max: 1000}]},
				{name: "stepURL", width: "*", validators: [{type: "lengthRange", max: 250}]},
				{name: "lastChangeDate", width: 100, detail: true}
			]
		});
		this.EventPlanLG = isc.myListGrid.create({
			dataSource: this.EventPlanDS,
			initialSort: [{property: "dueDate", direction: "ascending"}],
			name: "Event Planning",
			parent: this,
			showFilterEditor: true,
			startEditingNew: function(newValues, suppressFocus){
				var today;
				var data;
				var status = "not started";
				var eventTypeID;
				var eventPhaseID;
				var memberID = null;
				if(this.anySelected()){
					data = this.getSelectedRecord();
					today = data.dueDate;
					eventTypeID = data.eventTypeID;
					status = data.status;
					eventPhaseID = data.eventPhaseID;
					if(data.memberID > 0){
						memberID = data.memberID;
					}
				}else{
					today = new Date();
				}
				var rowDefaults = {dueDate: today, eventTypeID: eventTypeID, status: status, eventPhaseID: eventPhaseID, memberID: memberID};
				var newCriteria = isc.addProperties({}, newValues, rowDefaults);
				return this.Super("startEditingNew", [newCriteria, suppressFocus]);
			},
			dataArrived: function(startRow, endRow){}
		});
		this.localContextMenu = isc.myContextMenu.create({parent: this, callingListGrid: this.EventPlanLG});
		this.addItem(isc.myVLayout.create({members: [this.EventPlanLG]}));
		this.EventPlanLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
