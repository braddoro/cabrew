isc.defineClass("Groups", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		if(!checkPerms(this.getClassName() + ".js")){
			isc.warn(this.mm_accessFail);
			this.close();
		}
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
		this.GroupLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
