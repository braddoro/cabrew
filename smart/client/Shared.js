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
	brewClubsDS: isc.myDataSource.create({
		dataURL: serverPath + "BrewClubs.php",
		fields:[
			{name: "clubID", type: "sequence", primaryKey: true, detail: true, canEdit: false},
			{name: "clubAbbr", type: "text"},
			{name: "clubName", type: "text"},
			{name: "active", type: "text", width: 80}
		]
	}),
	contactTypesDS: isc.myDataSource.create({
		dataURL: serverPath + "ContactTypes.php",
		fields:[
			{name: "contactTypeID", type: "sequence", primaryKey: true, canEdit: false, detail: true},
			{name: "contactType", type: "text"},
			{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "lastChangeDate", type: "datetime", canEdit: false, detail: true}
		]
	}),
	chairTypesDS: isc.myDataSource.create({
		dataURL: serverPath + "ChairTypes.php",
		fields:[
			{name: "chairTypeID", type: "sequence", primaryKey: true, canEdit: false, detail: true},
			{name: "chairType", type: "text"},
			{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"}
		]
	}),
	dateTypesDS: isc.myDataSource.create({
		dataURL: serverPath + "DateTypes.php",
		fields:[
			{name: "dateTypeID", type: "sequence", primaryKey: true, detail: true, canEdit: false},
			{name: "dateType", type: "text"},
			{name: "datePoints", type: "integer", editorType: "spinner"},
			{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "lastChangeDate", type: "datetime", canEdit: false, detail: true}
		]
	}),
	eventYearsDS: isc.myDataSource.create({
		dataURL: serverPath + "EventYears.php",
		fields:[
			{name: "Year", type: "sequence", primaryKey: true}
		]
	}),
	eventTypesDS: isc.myDataSource.create({
		dataURL: serverPath + "EventTypes.php",
		fields:[
			{name: "eventTypeID", type: "sequence", primaryKey: true, detail: true, canEdit: false},
			{name: "eventType", type: "text"},
			{name: "description", type: "text"},
			{name: "active", type: "text", width: 80},
			{name: "lastChangeDate", type: "datetime", canEdit: false, detail: true}
		]
	}),
	eventTeamNamesDS: isc.myDataSource.create({
		dataURL: serverPath + "EventTeamNames.php",
		fields:[
			{name: "eventTeamNameID", type: "sequence", primaryKey: true, detail: true, canEdit: false},
			{name: "teamName", type: "text"},
			{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "lastChangeDate", type: "datetime", canEdit: false, detail: true}
		]
	}),
	libraryBooksDS: isc.myDataSource.create({
		dataURL: serverPath + "LibraryBooks.php",
		fields:[
			{name: "bookID", primaryKey: true, type: "sequence", canEdit: false, detail: true},
			{name: "series", width: 150},
			{name: "title", width: 250},
			{name: "author", width: 300},
			{name: "copyright", type: "integer", width: 100},
			{name: "abstract"}
		]
	}),
	memberNamesDS: isc.myDataSource.create({
		dataURL: serverPath + "MemberSearch.php",
		fields:[
			{name: "memberID", type: "sequence", primaryKey: true, canEdit: false, detail: true},
			{name: "FullName", type: "text"},
			{name: "Status", type: "text"}
		]
	}),
	messageTypesDS: isc.myDataSource.create({
		clientOnly: true,
		fields: [
			{name: "valueLOV", type: "sequence", primaryKey: true},
			{name: "displayLOV", type: "text"}
		],
		testData:[
			{valueLOV: 1, displayLOV: "SMS"},
			{valueLOV: 2, displayLOV: "Email"}
		]
	}),
	noteTypesDS: isc.myDataSource.create({
		dataURL: serverPath + "NoteTypes.php",
		fields:[
			{name: "noteTypeID", type: "sequence", primaryKey: true, canEdit: false, detail: true},
			{name: "noteType", type: "text"},
			{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"}
		]
	}),
	statusTypesDS: isc.myDataSource.create({
		dataURL: serverPath + "StatusTypes.php",
		fields:[
			{name: "statusTypeID", type: "sequence", primaryKey: true, detail: true, canEdit: false},
			{name: "statusType", type: "text"},
			{name: "statusCode", type: "text"},
			{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "lastChangeDate", type: "datetime", canEdit: false, detail: true}
		]
	})
};
isc.Members = {
	membersDS: isc.myDataSource.create({
		dataURL: serverPath + "EditMember.php",
		fields:[
			{name: "memberID", primaryKey: true, type: "sequence", canEdit: false, detail: true},
			{name: "statusTypeID_fk", width: 75, title: "Status", optionDataSource: isc.Shared.statusTypesDS, optionCriteria: {active: "Y"}, displayField: "statusType", valueField: "statusTypeID"},
			{name: "firstName", validators: [{type: "lengthRange", max: 30}]},
			{name: "midName", validators: [{type: "lengthRange", max: 30}]},
			{name: "lastName", validators: [{type: "lengthRange", max: 45}]},
			{name: "nickname", validators: [{type: "lengthRange", max: 45}]},
			{name: "sex", validators: [{type: "lengthRange", max: 1}, {type:"isOneOf", list: ["M","F"]}]},
			{name: "renewalYear", type: "integer", validators: [{type:"integerRange", min:2014, max:2030}], detail: true},
			{name: "lastChangeDate", type: "datetime", canEdit: false, detail: true}
		]
	}),
	contactsDS: isc.myDataSource.create({
		dataURL: serverPath + "MemberContacts.php",
		fields:[
			{name: "memberContactID", primaryKey: true, type: "sequence", canEdit: false, detail: true},
			{name: "memberID_fk", type: "integer", detail: true, required: true},
			{name: "contactTypeID_fk", type: "integer", required: true, title: "Type", optionDataSource: isc.Shared.contactTypesDS, optionCriteria: {active: "Y"}, displayField: "contactType", valueField: "contactTypeID"},
			{name: "memberContact"},
			{name: "contactDetail"},
			{name: "lastChangeDate", canEdit: false, detail: true}
		]
	}),
	datesDS: isc.myDataSource.create({
		dataURL: serverPath + "MemberDates.php",
		fields:[
			{name: "memberDateID", primaryKey: true, type: "sequence", canEdit: false, detail: true},
			{name: "memberID_fk", type: "integer", detail: true, required: true},
			{name: "dateTypeID_fk", required: true, type: "integer", title: "Date Type", optionDataSource: isc.Shared.dateTypesDS, optionCriteria: {active: "Y"}, displayField: "dateType", valueField: "dateTypeID"},
			{name: "memberDate"},
			{name: "dateDetail"},
			{name: "lastChangeDate", canEdit: false, detail: true}
		]
	}),
	notesDS: isc.myDataSource.create({
		dataURL: serverPath + "MemberNotes.php",
		fields:[
			{name: "memberNoteID", primaryKey: true, type: "sequence", canEdit: false, detail: true},
			{name: "memberID_fk", detail: true, required: true},
			{name: "noteTypeID_fk", required: true, title: "Type", optionDataSource: isc.Shared.noteTypesDS, optionCriteria: {active: "Y"}, displayField: "noteType", valueField: "noteTypeID"},
			{name: "noteDate"},
			{name: "memberNote"},
			{name: "lastChangeDate", canEdit: false, detail: true}
		]
	})
};
