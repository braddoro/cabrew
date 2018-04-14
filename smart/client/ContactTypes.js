isc.defineClass("ContactTypes", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.ContactTypesLG = isc.myListGrid.create({
		parent: this,
		dataSource: isc.Shared.contactTypesDS,
		name: "Contact Types",
		autoFetchData: true
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.ContactTypesLG
	});
	this.ContactTypesVL = isc.myVLayout.create({members: [this.ContactTypesLG]});
	this.addItem(this.ContactTypesVL);
	}
});
