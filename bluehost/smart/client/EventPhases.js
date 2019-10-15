isc.defineClass("EventPhases", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.EventPhasesLG = isc.myListGrid.create({
			dataSource: isc.Shared.eventPhasesDS,
			name: "Event Phases",
			parent: this
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.EventPhasesLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.EventPhasesLG]}));
		this.EventPhasesLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
