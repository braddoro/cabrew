isc.defineClass("StatusTypes", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.StatusTypesLG = isc.myListGrid.create({
			parent: this,
			dataSource: isc.Shared.statusTypesDS,
			name: "Status Types"
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.StatusTypesLG
		});
		this.addItem(isc.myVLayout.create({members: [this.StatusTypesLG]}));
	}
});
