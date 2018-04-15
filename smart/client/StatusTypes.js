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
		this.StatusTypesVL = isc.myVLayout.create({members: [this.StatusTypesLG]});
		this.addItem(this.StatusTypesVL);
	}
});
