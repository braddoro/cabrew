isc.defineClass("Items", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.ItemLG = isc.myListGrid.create({
			autoFetchData: true,
			dataSource: isc.Shared.ItemDS,
			name: "Items",
			parent: this,
			showFilterEditor: true
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.ItemLG
		});
		this.addItem(isc.myVLayout.create({members: [this.ItemLG]}));
	}
});
