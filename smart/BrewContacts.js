isc.defineClass("BrewContacts", "myWindow").addProperties({
	title: "Brew Contacts",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BrewContactsDS = isc.myDataSource.create({
			dataURL: "BrewContacts.php",
			showFilterEditor: true,
			fields:[
				{name: "contactID", primaryKey: true, type: "sequence"},
				{name: "clubID"},
				{name: "contactName"},
				{name: "priority"}
			]
		});
		this.BrewContactsLG = isc.myListGrid.create({
			parent: this,
			dataSource: this.BrewContactsDS,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.BrewContactsLG
		});
		this.BrewContactsVL = isc.myVLayout.create({members: [this.BrewContactsLG]});
		this.addItem(this.BrewContactsVL);
	}
});
