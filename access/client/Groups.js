isc.defineClass("Groups", "myWindow").addProperties({
	top: 100,
	left: 100,
	height: 300,
	width: 600,
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.GroupLG = isc.myListGrid.create({
			autoFetchData: true,
			dataSource: isc.Shared.GroupDS,
			name: "Groups",
			parent: this,
			showFilterEditor: true
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.GroupLG
		});
		this.addItem(isc.myVLayout.create({members: [this.GroupLG]}));
	}
});
