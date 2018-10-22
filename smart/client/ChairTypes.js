isc.defineClass("ChairTypes", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.ChairTypesLG = isc.myListGrid.create({
		parent: this,
		dataSource: isc.Shared.chairTypesDS,
		name: "Chair Types"
	});
	this.localContextMenu = isc.myContextMenu.create({
		callingListGrid: this.ChairTypesLG,
		parent: this
	});
	this.addItem(isc.myVLayout.create({members: [this.ChairTypesLG]}));
	}
});
