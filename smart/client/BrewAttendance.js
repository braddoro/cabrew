isc.defineClass("BrewAttendance", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BrewAttendanceDS = isc.myDataSource.create({
			cacheAllData: false,
			dataURL: serverPath + "BrewAttendance.php",
			fields:[
				{name: "attended", type: "integer"},
				{name: "attendenceID", primaryKey: true, type: "sequence", detail: true, canEdit: false},
				{name: "eventTypeID", width: 120, type: "integer", title: "Event", optionDataSource: isc.Shared.eventTypesDS, displayField: "eventType", valueField: "eventTypeID", optionCriteria: {active: "Y"}},
				{name: "beers", type: "integer"},
				{name: "clubID", required: true, detail: true, canEdit: false},
				{name: "interested", type: "text", width: 80, editorType: "selectItem", defaultValue: "N", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
				{name: "participated", type: "text", width: 80, editorType: "selectItem", defaultValue: "N", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
				{name: "year", required: true, type: "integer"}
			]
		});
		this.BrewAttendanceLG = isc.myListGrid.create({
			dataSource: this.BrewAttendanceDS,
			name: "Brew Club Attendance",
			parent: this,
			startEditingNew: function(newValues, suppressFocus){
				var moreCriteria = isc.addProperties({}, newValues, {clubID: initData.clubID});
				return this.Super("startEditingNew", [moreCriteria, suppressFocus]);
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.BrewAttendanceLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.BrewAttendanceLG]}));
		this.BrewAttendanceLG.fetchData({clubID: initData.clubID});
	}
});
