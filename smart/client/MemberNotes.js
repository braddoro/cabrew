isc.defineClass("MemberNotes", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.MemberNotesLG = isc.myListGrid.create({dataSource: isc.Members.notesDS});
		this.MemberNotesVL = isc.myVLayout.create({members: [this.MemberNotesLG]});
		this.addItem(this.MemberNotesVL);
		this.MemberNotesLG.fetchData({memberID: initData.memberID});
	}
});
