isc.defineClass("Items", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		if(!checkPerms(this.getClassName() + ".js")){
			isc.warn(this.mm_accessFail);
			this.close();
		}
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
		this.ItemLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
