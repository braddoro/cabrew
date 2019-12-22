
isc.defineClass("EventTeamNames", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.EventTeamNamesLG = isc.myListGrid.create({
			dataSource: isc.Shared.eventTeamNamesDS,
			name: "Event Team Names",
			parent: this
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.EventTeamNamesLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.EventTeamNamesLG]}));
		this.EventTeamNamesLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
