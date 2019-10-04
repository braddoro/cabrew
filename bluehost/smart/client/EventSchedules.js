isc.defineClass("EventSchedules", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.EventScheduleDS = isc.myDataSource.create({
			dataURL: serverPath + "EventSchedules.php",
			showFilterEditor: true,
			fields:[
				{name: "eventScheduleID", primaryKey: true, detail: true, type: "sequence"},
				{name: "typeID", width: 80, type: "integer", title: "Type", editorType: "spinner"},
				{name: "eventID", width: 100, type: "integer", title: "Event", optionDataSource: isc.Shared.eventTypesDS, displayField: "eventType", valueField: "eventTypeID", optionCriteria: {active: "Y"}},
				{name: "stepStart", type: "time", title: "Start", editorType: "TimeItem"},
				{name: "stepEnd", type: "time", title: "End", editorType: "TimeItem"},
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
			showFilterEditor: true,
			startEditingNew: function(newValues, suppressFocus){
				var data;
				var typeID;
				var eventID;
				var stepStart;
				if(this.anySelected()){
					data = this.getSelectedRecord();
					data.step = "";
					typeID = data.typeID;
					eventID = data.eventID;
					stepStart = data.stepEnd;
					// eventTypeID = data.eventTypeID;
					// status = data.status;
				// }else{
				// 	today = new Date();
				}
				var rowDefaults = {eventID: eventID, typeID: typeID, stepStart: stepStart};
				var newCriteria = isc.addProperties({}, newValues, rowDefaults);
				return this.Super("startEditingNew", [newCriteria, suppressFocus]);
			},
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.EventScheduleLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.EventScheduleLG]}));
		this.EventScheduleLG.canEdit = checkPerms(this.getClassName() + ".js");
  	}
});
