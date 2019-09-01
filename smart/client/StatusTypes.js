isc.defineClass("StatusTypes", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.StatusTypesLG = isc.myListGrid.create({
			dataSource: isc.Shared.statusTypesDS,
			name: "Status Types",
			parent: this
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.StatusTypesLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.StatusTypesLG]}));
		this.StatusTypesLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
