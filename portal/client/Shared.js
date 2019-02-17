isc.Clients = {
	yesNoDS: isc.DataSource.create({
		clientOnly: true,
		fields: [
			{name: "valueLOV", type: "sequence", primaryKey: true},
			{name: "displayLOV", type: "text"}
		],
		testData:[
			{valueLOV: "Y", displayLOV: "Yes"},
			{valueLOV: "N", displayLOV: "No"}
		]
	})
};
isc.Shared = {
	dateTypesDS: isc.myDataSource.create({
		dataURL: serverPath + "../../smart/server/DateTypes.php",
		fields:[
			{name: "dateTypeID", type: "sequence", primaryKey: true, detail: true, canEdit: false},
			{name: "dateType", type: "text"},
			{name: "datePoints", type: "integer", editorType: "spinner"},
			{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "lastChangeDate", type: "datetime", canEdit: false, detail: true}
		]
	})
};
