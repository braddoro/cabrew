isc.Clients = {
	budgetActionDS: isc.DataSource.create({
		clientOnly: true,
		fields: [
			{name: "valueLOV", type: "sequence", primaryKey: true},
			{name: "displayLOV", type: "text"}
		],
		testData:[
			{valueLOV: "Decide", displayLOV: "Decide"},
			{valueLOV: "Deliver", displayLOV: "Deliver"},
			{valueLOV: "Followup", displayLOV: "Followup"},
			{valueLOV: "Locate", displayLOV: "Locate"},
			{valueLOV: "Need", displayLOV: "Need"},
			{valueLOV: "Order", displayLOV: "Order"},
			{valueLOV: "Ordered", displayLOV: "Ordered"},
			{valueLOV: "Pickup", displayLOV: "Pickup"},
			{valueLOV: "Price", displayLOV: "Price"},
			{valueLOV: "Ready", displayLOV: "Ready"},
			{valueLOV: "Research", displayLOV: "Research"},
			{valueLOV: "Verify", displayLOV: "Verify"}
		]
	}),
	budgetStatusDS: isc.DataSource.create({
		clientOnly: true,
		fields: [
			{name: "valueLOV", type: "sequence", primaryKey: true},
			{name: "displayLOV", type: "text"}
		],
		testData:[
			{valueLOV: "Buy", displayLOV: "Buy"},
			{valueLOV: "Donation", displayLOV: "Donation"},
			{valueLOV: "Have", displayLOV: "Have"}
		]
	}),
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
	}),
	yesNoMaybeDS: isc.DataSource.create({
		clientOnly: true,
		fields: [
			{name: "valueLOV", type: "sequence", primaryKey: true},
			{name: "displayLOV", type: "text"}
		],
		testData:[
			{valueLOV: "M", displayLOV: "Maybe"},
			{valueLOV: "D", displayLOV: "Defer"},
			{valueLOV: "G", displayLOV: "Guest"},
			{valueLOV: "N", displayLOV: "No"},
			{valueLOV: "Y", displayLOV: "Yes"}
		]
	})
};
isc.Shared = {
	donationStatusDS: isc.DataSource.create({
		dataURL: serverPath + "DonationStatuses.php",
		showFilterEditor: true,
		fields: [
			{name: "donationStatusID", type: "sequence", primaryKey: true, detail: true},
			{name: "donationStatus", type: "text", width: "*", validators: [{type: "lengthRange", max: 45}]},
			{name: "active", type: "text", width: 80, editorType: "selectItem", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "lastChangeDate", type: "datetime", canEdit: false, detail: true}
		]
	}),
	eventPhasesDS: isc.myDataSource.create({
		dataURL: serverPath + "EventPhases.php",
		showFilterEditor: true,
		fields:[
			{name: "eventPhaseID", primaryKey: true, type: "sequence", detail: true},
			{name: "eventPhase", type: "text"},
			{name: "active", type: "text", width: 80, editorType: "selectItem", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "lastChangeDate", type: "datetime", canEdit: false, detail: true}
		]
	}),
	entityNamesDS: isc.myDataSource.create({
		dataURL: serverPath + "EntityNames.php",
		fields:[
			{name: "entityNameID", primaryKey: true, type: "sequence", detail: true},
			{name: "entityName", type: "text", validators: [{type: "lengthRange", max: 200}]},
			{name: "entityType", type: "text", editorType: "selectItem", validators: [{type: "lengthRange", max: 45}],
			valueMap:["","Ingredient","Supply","Equipment","Brewery","Misc"] },
			// {name: "weblink", type: "text", validators: [{type: "lengthRange", max: 300}],
			// 	formatCellValue: function (value) {
			// 		var formatted;
			// 		if (value) {
			// 			formatted = "<a href='" + value + "' target='_blank'>" + value + "</a>";
			// 		}
			// 		return formatted;
			// 	}
			// },
			{name: "active", type: "text", width: 80, editorType: "selectItem", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV", defaultValue: "Y"},
			{name: "lastChangeDate", type: "datetime", canEdit: false, detail: true}
		]
	}),
	BJCP2015CategoriesDS: isc.myDataSource.create({
		dataURL: serverPath + "BJCP2015Categories.php",
		showFilterEditor: true,
		fields:[
			{name: "bjcp2015_categoryID", primaryKey: true, detail: true, type: "sequence"},
			{name: "beerTable", type: "text", width: "150", validators: [{type: "lengthRange", max: 50}]},
			{name: "bjcp2015_category", title: "BJCP Category", type: "text", width: 200, validators: [{type: "lengthRange", max: 45}]},
			{name: "description", type: "text", width: "*", validators: [{type: "lengthRange", max: 4000}]},
			{name: "lastChangeDate", width: 100, detail: true}
		]
	}),
	BJCP2015StylesDS: isc.myDataSource.create({
		dataURL: serverPath + "BJCP2015Styles.php",
		fields:[
			{name: "bjcp2015styleID", primaryKey: true, detail: true, type: "sequence"},
			{name: "bjcp2015_categoryID", align: "left", title: "BJCP Category", width: 200, type: "integer", optionDataSource: this.BJCP2015CategoriesDS, displayField: "bjcp2015_category", valueField: "bjcp2015_categoryID"},
			{name: "bjcpCode", width: 105, type: "text", validators: [{type: "lengthRange", max: 5}]},
			{name: "styleABBR", width: 150, type: "text",  validators: [{type: "lengthRange", max: 45}]},
			{name: "bjcpStyle", width: "*", type: "text",  validators: [{type: "lengthRange", max: 45}]},
			{name: "lastChangeDate", width: 100, detail: true}
		]
	}),
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
	userDateTypesDS: isc.myDataSource.create({
		dataURL: serverPath + "DateTypesUser.php",
		fields:[
			{name: "dateType", type: "text"},
			{name: "dateTypeID", type: "sequence", primaryKey: true}
		]
	}),
	dateTypesDS: isc.myDataSource.create({
		cacheAllData: false,
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
			{name: "eventType", type: "text", width: 120},
			{name: "eventBudget", type: "float", width: 120},
			{name: "description", type: "text", width: "*"},
			{name: "active", type: "text", width: 80, editorType: "selectItem", defaultValue: "Y", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
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
			{name: "statusTypeID_fk", type: "integer", canEdit: false, detail: true}
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
	}),
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
			{name: "itemName", width: "*", validators: [{type: "lengthRange", max: 200}]},
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
			{name: "noteDate", type: "date", width: 120, title: "Date", editorType: "DateItem", validators: [{type: "isDate"}]},
			{name: "memberNote"},
			{name: "lastChangeDate", canEdit: false, detail: true}
		]
	})
};
