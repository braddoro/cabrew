isc.defineClass("ChairTypes", "myWindow").addProperties({
	title: "Chair Types",
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.ChairTypesLG = isc.myListGrid.create({
		parent: this,
		dataSource: isc.Shared.chairTypesDS,
		name: "Chair Types"
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.ChairTypesLG
	});
	this.ChairTypesVL = isc.myVLayout.create({members: [this.ChairTypesLG]});
	this.addItem(this.ChairTypesVL);
	}
});
