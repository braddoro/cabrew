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
				optionDataSource: isc.Shared.entityNamesDS,
				pickListFields: [{name: "entityName", width: "*"}],
				pickListProperties: {showFilterEditor: true},
				title: "Corporation",
				type: "integer",
				valueField: "entityNameID",
				width: 250
			},
			{name: "asked", type: "text", width: 80, editorType: "selectItem", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "agreed", type: "text", width: 80, editorType: "selectItem", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "delivered", type: "text", width: 80, editorType: "selectItem", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "active", type: "text", width: 80, editorType: "selectItem", optionDataSource: isc.Clients.yesNoDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "contact", width: "*", validators: [{type: "lengthRange", max: 200}]},
			{name: "notes", width: "*", validators: [{type: "lengthRange", max: 200}]},
			{name: "donatedItems", width: "*", validators: [{type: "lengthRange", max: 1000}]},
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
			var rowDefaults = {eventTypeID_fk: eventTypeID, entityNameID_fk: entityNameID, asked: "Y"};
			var newCriteria = isc.addProperties({}, newValues, rowDefaults);
			return this.Super("startEditingNew", [newCriteria, suppressFocus]);
		}
	});
	this.localContextMenu = isc.myContextMenu.create({
		callingListGrid: this.CorporateDonationLG,
		parent: this
	});
	this.addItem(isc.myVLayout.create({members: [this.CorporateDonationLG]}));
	this.CorporateDonationLG.canEdit = checkPerms(this.getClassName() + ".js");
  }
});
