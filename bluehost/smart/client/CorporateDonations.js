isc.defineClass("CorporateDonations", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.CorporateDonationDS = isc.myDataSource.create({
		dataURL: serverPath + "CorporateDonations.php",
		showFilterEditor: true,
		fields:[
			{name: "corporateDonationID", primaryKey: true, detail: true, type: "sequence"},
			{name: "eventTypeID_fk", width: 120, type: "integer", title: "Event", optionDataSource: isc.Shared.eventTypesDS, displayField: "eventType", valueField: "eventTypeID", optionCriteria: {active: "Y"}},
			{name: "entityNameID_fk",
				align: "left",
				displayField: "entityName",
				optionCriteria: {active: "Y"},
				optionDataSource: isc.Shared.entityNamesDS,
				pickListFields: [{name: "entityType", width: "75"}, {name: "entityName", width: "*"}],
				pickListProperties: {showFilterEditor: true},
				pickListWidth: 300,
				title: "Corporation",
				type: "integer",
				valueField: "entityNameID",
				width: 250
			},
			{name: "donationStatusID_fk", width: 120, type: "integer", title: "Status", optionDataSource: isc.Shared.donationStatusDS, displayField: "donationStatus", valueField: "donationStatusID", optionCriteria: {active: "Y"}},
			{name: "notes", width: "*", validators: [{type: "lengthRange", max: 200}]},
			{name: "items", width: 100, validators: [{type: "lengthRange", max: 1000}], detail: true},
			{name: "lastChangeDate", width: 130, detail: true}
		]
	});
	this.CorporateDonationLG = isc.myListGrid.create({
		dataSource: this.CorporateDonationDS,
		initialSort: [{property: "eventTypeID_fk", direction: "ascending"}],
		name: "Corporate Donations",
		parent: this,
		showFilterEditor: true,
		startEditingNew: function(newValues, suppressFocus){
			var data;
			var eventTypeID;
			var entityNameID_fk;
			if(this.anySelected()){
				data = this.getSelectedRecord();
				eventTypeID = data.eventTypeID_fk;
				entityNameID = data.entityNameID_fk;
			}
			var rowDefaults = {eventTypeID_fk: eventTypeID, entityNameID_fk: entityNameID_fk, status: ""};
			var newCriteria = isc.addProperties({}, newValues, rowDefaults);
			return this.Super("startEditingNew", [newCriteria, suppressFocus]);
		}
	});
	this.localContextMenu = isc.myContextMenu.create({
		callingListGrid: this.CorporateDonationLG,
		parent: this
	});
	// ,
	// 	data: [
	// 		{title: "Add Items", click: "isc.CorporateDonationItems.create({title: 'Items', corporateDonationID: this.parent.CorporateDonationLG.getSelectedRecord.corporateDonationID});"},
 //        ]
	// left: isc.Math.random(340), top: isc.Math.random(240), height: 300, width: 400,
	this.addItem(isc.myVLayout.create({members: [this.CorporateDonationLG]}));
	this.CorporateDonationLG.canEdit = checkPerms(this.getClassName() + ".js");
  }
});
