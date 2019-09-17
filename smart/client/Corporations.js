isc.defineClass("Corporations", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.CorporationsLG = isc.myListGrid.create({
			dataSource: isc.Shared.CorporationsDS,
			name: "Corporations",
			parent: this
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.CorporationsLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.CorporationsLG]}));
		this.CorporationsLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
