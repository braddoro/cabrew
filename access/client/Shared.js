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
	GroupDS: isc.myDataSource.create({
		cacheAllData: false,
		dataURL: serverPath + "Groups.php",
		showFilterEditor: true,
		fields:[
			{name: "secGroupID", primaryKey: true, detail: true, type: "sequence"},
			{name: "groupName", width: 300, validators: [{type: "lengthRange", max: 200}]},
			{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "lastChangeDate", width: 100, detail: true}
		]
	}),
	ItemDS: isc.myDataSource.create({
		cacheAllData: false,
		dataURL: serverPath + "Items.php",
		showFilterEditor: true,
		fields:[
			{name: "secItemID", primaryKey: true, detail: true, type: "sequence"},
			{name: "itemName", width: 300, validators: [{type: "lengthRange", max: 200}]},
			{name: "itemType", width: 100, validators: [{type: "lengthRange", max: 45}]},
			{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "lastChangeDate", width: 100, detail: true}
		]
	}),
	UserDS: isc.myDataSource.create({
		cacheAllData: false,
		dataURL: serverPath + "Users.php",
		showFilterEditor: true,
		fields:[
			{name: "secUserID", primaryKey: true, detail: true, type: "sequence"},
			{name: "userName", width: 100, validators: [{type: "lengthRange", max: 20}]},
			{name: "password", width: 150, validators: [{type: "lengthRange", max: 45}]},
			{name: "fullName", width: 200, validators: [{type: "lengthRange", max: 50}]},
			{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "lastChangeDate", width: 100, detail: true}
		]
	})
};
