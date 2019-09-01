isc.defineClass("NoteTypes", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.NoteTypesLG = isc.myListGrid.create({
			dataSource: isc.Shared.noteTypesDS,
			name: "Note Types",
			parent: this
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.NoteTypesLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.NoteTypesLG]}));
		this.NoteTypesLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
