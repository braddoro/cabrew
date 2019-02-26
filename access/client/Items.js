isc.defineClass("Items", "myWindow").addProperties({
	top: 75,
	left: 75,
	height: 300,
	width: 600,
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
