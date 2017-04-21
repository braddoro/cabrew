isc.Shared = {
	statusTypesDS: isc.DataSource.create({
		clientOnly: true,
		fields: [
			{name: "valueLOV", type: "sequence", primaryKey: true},
			{name: "displayLOV", type: "text"}
		],
		testData:[
			{valueLOV: 1, displayLOV: "Active"},
			{valueLOV: 2, displayLOV: "Inactive"},
			{valueLOV: 3, displayLOV: "Overdue"},
			{valueLOV: 4, displayLOV: "Archive"},
			{valueLOV: 5, displayLOV: "Comp"}
		]
	}),
	eventYearsDS: isc.myDataSource.create({
		dataURL: "EventYears.php",
		fields:[
			{name: "Year", type: "sequence", primaryKey: true}
		]
	}),
	dateTypesDS: isc.myDataSource.create({
		dataURL: "DateTypes.php",
		fields:[
			{name: "dateTypeID", type: "sequence", primaryKey: true},
			{name: "dateType", type: "text"},
			{name: "active", type: "text"}
		]
	}),
	noteTypesDS: isc.myDataSource.create({
		dataURL: "NoteTypes.php",
		fields:[
			{name: "noteTypeID", type: "sequence", primaryKey: true},
			{name: "noteType", type: "text"},
			{name: "active", type: "text"}
		]
	}),
	contactTypesDS: isc.myDataSource.create({
		dataURL: "ContactTypes.php",
		fields:[
			{name: "contactTypeID", type: "sequence", primaryKey: true},
			{name: "contactType", type: "text"},
			{name: "active", type: "text"}
		]
	}),
	chairTypesDS: isc.myDataSource.create({
		dataURL: "ChairTypes.php",
		fields:[
			{name: "chairTypeID", type: "sequence", primaryKey: true},
			{name: "chairType", type: "text"},
			{name: "active", type: "text"}
		]
	})
};
