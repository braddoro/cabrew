isc.defineClass("EventAttendance", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.EventAttendanceDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "BrewAttendance.php",
			fields:[
				{name: "attendenceID", primaryKey: true, type: "sequence", detail: true, canEdit: false},
				{name: "clubID", width: 120, title: "Club", optionDataSource: isc.Shared.brewClubsDS, optionCriteria: {active: "Y"}, displayField: "clubAbbr", valueField: "clubID", pickListWidth: 300, pickListProperties: {showFilterEditor: true}, pickListFields: [{name: "clubAbbr", width: "70"},{name: "clubName", width: "*"}]},
				{name: "distance", type: "integer", canEdit: false},
				{name: "eventTypeID", width: 120, type: "integer", title: "Event", optionDataSource: isc.Shared.eventTypesDS, displayField: "eventType", valueField: "eventTypeID", optionCriteria: {active: "Y"}},
				{name: "year", required: true, type: "integer"},
				{name: "interested", type: "text", width: 80, editorType: "selectItem", defaultValue: "", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
				{name: "participated", type: "text", width: 80, editorType: "selectItem", defaultValue: "", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
				{name: "beers", type: "integer"},
				{name: "attended", type: "integer"},
				{name: "lastChangeDate", width: 100, detail: true}
			]
		});
		this.EventAttendanceLG = isc.myListGrid.create({
			dataSource: this.EventAttendanceDS,
			name: "Event Attendance",
			parent: this,
			showFilterEditor: true,
			startEditingNew: function(newValues, suppressFocus){
				var moreCriteria = isc.addProperties({}, newValues, {clubID: initData.clubID});
				return this.Super("startEditingNew", [moreCriteria, suppressFocus]);
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.EventAttendanceLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.EventAttendanceLG]}));
		this.EventAttendanceLG.canEdit = checkPerms(this.getClassName() + ".js");
		this.EventAttendanceLG.fetchData();
	}
});
