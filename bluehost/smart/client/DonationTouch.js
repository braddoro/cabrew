isc.defineClass("DonationTouch", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);

	// {name: "entityNameID_fk",
	// 	align: "left",
	// 	displayField: "entityName",
	// 	optionCriteria: {active: "Y"},
	// 	optionDataSource: isc.Shared.entityNamesDS,
	// 	pickListFields: [{name: "entityType", width: "75"}, {name: "entityName", width: "*"}],
	// 	pickListProperties: {showFilterEditor: true},
	// 	pickListWidth: 300,
	// 	title: "Corporation",
	// 	type: "integer",
	// 	valueField: "entityNameID",
	// 	width: 250
	// },

	this.DonationTouchDS = isc.myDataSource.create({
		dataURL: serverPath + "DonationTouch.php",
		showFilterEditor: true,
		fields:[
 			{name: "donationTouchID", primaryKey: true, detail: true, type: "sequence"},
			{name: "corporateDonationID_fk", width: 120, type: "integer", detail: true},
			{name: "contactTypeID_fk", width: 120, type: "integer", detail: true}]},
			{name: "contactDate", width: "150", type: "text"},
			{name: "contactNote", width: "*", validators: [{type: "lengthRange", max: 2000}]},
			{name: "lastChangeDate", width: 100, detail: true}
		]
	});

	this.DonationTouchLG = isc.myListGrid.create({
		dataSource: this.DonationTouchDS,
		initialSort: [{property: "entityNameID", direction: "ascending"}, {property: "type", direction: "ascending"}, {property: "donationItem", direction: "ascending"}],
		name: "Corporate Donation Touches",
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
		callingListGrid: this.DonationTouchLG,
		parent: this
	});
	this.addItem(isc.myVLayout.create({members: [this.DonationTouchLG]}));
	this.DonationTouchLG.fetchData({corporateDonationID: initData.corporateDonationID});
	this.DonationTouchLG.canEdit = checkPerms(this.getClassName() + ".js");
  }
});
