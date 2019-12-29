isc.defineClass("DonationTouch", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);

	this.DonationTouchDS = isc.myDataSource.create({
		dataURL: serverPath + "DonationTouch.php",
		fields:[
 			{name: "donationTouchID", primaryKey: true, detail: true, type: "sequence"},
			{name: "corporateDonationID_fk", width: 120, type: "integer", detail: true},
			{name: "contactTypeID_fk", width: 120, type: "integer", detail: true},
			{name: "contactDate", width: "150", type: "text"},
			{name: "contactNote", width: "*", validators: [{type: "lengthRange", max: 2000}]},
			{name: "lastChangeDate", width: 100, detail: true}
		]
	});
	this.DonationTouchLG = isc.myListGrid.create({
		dataSource: this.DonationTouchDS,
		name: "Corporate Donation Touches",
		parent: this,
		// initialSort: [{property: "entityNameID", direction: "ascending"}, {property: "type", direction: "ascending"}, {property: "donationItem", direction: "ascending"}],
		// showFilterEditor: true,
		startEditingNew: function(newValues, suppressFocus){
			var data;
			var corporateDonationID_fk;
			if(this.anySelected()){
				data = this.getSelectedRecord();
				corporateDonationID_fk = data.corporateDonationID_fk;
			}
			var rowDefaults = {corporateDonationID_fk: corporateDonationID_fk};
			var newCriteria = isc.addProperties({}, newValues, rowDefaults);
			return this.Super("startEditingNew", [newCriteria, suppressFocus]);
		}
	});
	this.localContextMenu = isc.myContextMenu.create({
		callingListGrid: this.DonationTouchLG,
		parent: this
	});
	this.addItem(isc.myVLayout.create({members: [this.DonationTouchLG]}));
	this.DonationTouchLG.fetchData({corporateDonationID_fk: initData.corporateDonationID_fk});
	this.DonationTouchLG.canEdit = checkPerms(this.getClassName() + ".js");
  }
});
