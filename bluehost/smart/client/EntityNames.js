isc.defineClass("EntityNames", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.EntityNamesLG = isc.myListGrid.create({
			dataSource: isc.Shared.entityNamesDS,
			initialSort: [{property: "entityName", direction: "ascending"}],
			showFilterEditor: true,
			name: "Entity Names",
			parent: this
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.EntityNamesLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.EntityNamesLG]}));
		this.EntityNamesLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
