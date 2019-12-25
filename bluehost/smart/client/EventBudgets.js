isc.defineClass("EventBudgets", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.EventBudgetDS = isc.myDataSource.create({
		dataURL: serverPath + "EventBudgets.php",
		showFilterEditor: true,
		fields:[
			{name: "eventBudgetID", primaryKey: true, detail: true, type: "sequence"},
			{name: "eventTypeID",
				displayField: "eventType",
				optionCriteria: {active: "Y"},
				optionDataSource: isc.Shared.eventTypesDS,
				title: "Event",
				type: "integer",
				valueField: "eventTypeID",
				width: 90
			},
			{name: "status",
				displayField: "displayLOV",
				editorType: "selectItem",
				optionDataSource: isc.Clients.budgetStatusDS,
				validators: [{type: "lengthRange", max: 20}],
				valueField: "valueLOV",
				width: 80
			},
			{name: "units", width: 60, type: "integer", editorType: "SpinnerItem"},
			{name: "count", width: 60, type: "float", editorType: "SpinnerItem"},
			{name: "countUnits", width: 90, type: "text", validators: [{type: "lengthRange", max: 45}]},
			{name: "itemName", width: "*", validators: [{type: "lengthRange", max: 200}]},
			{name: "source", width: 110, validators: [{type: "lengthRange", max: 45}]},
			{name: "owner", width: 110, validators: [{type: "lengthRange", max: 45}]},
			{name: "budgetActionID",
				displayField: "budgetAction",
				editorType: "selectItem",
				optionCriteria: {active: "Y"},
				optionDataSource: isc.Shared.budgetActionDS,
				title: "Action",
				type: "integer",
				valueField: "budgetActionID",
				width: 70
			},
			{name: "cost", width: 60, type: "float", editorType: "SpinnerItem"},
			{name: "lastChangeDate", width: 130, detail: true}
		]
	});
	this.EventBudgetLG = isc.myListGrid.create({
		dataSource: this.EventBudgetDS,
		initialSort: [{property: "dueDate", direction: "ascending"}],
		name: "Event Budget",
		parent: this,
		showFilterEditor: true,
		startEditingNew: function(newValues, suppressFocus){
			var data;
			var eventTypeID;
			if(this.anySelected()){
				data = this.getSelectedRecord();
				eventTypeID = data.eventTypeID;
			}
			var rowDefaults = {eventTypeID: eventTypeID};
			var newCriteria = isc.addProperties({}, newValues, rowDefaults);
			return this.Super("startEditingNew", [newCriteria, suppressFocus]);
		}
	});
	this.localContextMenu = isc.myContextMenu.create({
		callingListGrid: this.EventBudgetLG,
		parent: this
	});
	this.addItem(isc.myVLayout.create({members: [this.EventBudgetLG]}));
	this.EventBudgetLG.canEdit = checkPerms(this.getClassName() + ".js");
  }
});
