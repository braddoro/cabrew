isc.defineClass("MemberNotes", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.MemberNotesLG = isc.myListGrid.create({parent: this, dataSource: isc.Members.notesDS, name: "Member Notes"});
		this.MemberNotesVL = isc.myVLayout.create({members: [this.MemberNotesLG]});
		this.addItem(this.MemberNotesVL);
		this.MemberNotesLG.fetchData({memberID: initData.memberID});
	}
});
