isc.defineClass("CorporateDonationItems", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.CorporateDonationItemDS = isc.myDataSource.create({
		dataURL: serverPath + "CorporateDonationItems.php",
		showFilterEditor: true,
		fields:[
			{name: "corporateDonationItemID", primaryKey: true, detail: true, type: "sequence"},
			{name: "eventTypeID", width: 120, type: "integer", title: "Event", optionDataSource: isc.Shared.eventTypesDS, displayField: "eventType", valueField: "eventTypeID", optionCriteria: {active: "Y"}},
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
			{name: "type", width: 120, validators: [{type: "lengthRange", max: 45}]},
			{name: "donationItem", width: "*", validators: [{type: "lengthRange", max: 200}]},
			{name: "lastChangeDate", width: 100, detail: true}
		]
	});

	this.CorporateDonationItemLG = isc.myListGrid.create({
		dataSource: this.CorporateDonationItemDS,
		initialSort: [{property: "entityNameID", direction: "ascending"}, {property: "type", direction: "ascending"}, {property: "donationItem", direction: "ascending"}],
		name: "Corporate Donation Items",
		parent: this,
		showFilterEditor: true,
		startEditingNew: function(newValues, suppressFocus){
			var data;
			var entityNameID;
			var eventTypeID;
			if(this.anySelected()){
				data = this.getSelectedRecord();
				entityNameID = data.entityNameID;
				eventTypeID = data.eventTypeID;
			}
			var rowDefaults = {entityNameID: entityNameID, eventTypeID: eventTypeID};
			var newCriteria = isc.addProperties({}, newValues, rowDefaults);
			return this.Super("startEditingNew", [newCriteria, suppressFocus]);
		}
	});
	this.localContextMenu = isc.myContextMenu.create({
		callingListGrid: this.CorporateDonationItemLG,
		parent: this
	});
	this.addItem(isc.myVLayout.create({members: [this.CorporateDonationItemLG]}));
	// this.CorporateDonationItemLG.fetchData({corporateDonationID: initData.corporateDonationID});
	this.CorporateDonationItemLG.canEdit = checkPerms(this.getClassName() + ".js");
  }
});
