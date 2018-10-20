isc.defineClass("ContactTypes", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.ContactTypesLG = isc.myListGrid.create({
		dataSource: isc.Shared.contactTypesDS,
		name: "Contact Types",
		parent: this
	});
	this.localContextMenu = isc.myContextMenu.create({
		callingListGrid: this.ContactTypesLG,
		parent: this
	});
	this.addItem(isc.myVLayout.create({members: [this.ContactTypesLG]}));
	}
});
