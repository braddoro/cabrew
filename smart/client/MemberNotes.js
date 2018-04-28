isc.defineClass("MemberNotes", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.MemberNotesLG = isc.myListGrid.create({
			parent: this,
			dataSource: isc.Members.notesDS,
			name: "Member Notes",
			startEditingNew: function(newValues, suppressFocus){
				var newCriteria = isc.addProperties({}, newValues, {memberID_fk: initData.memberID});
				return this.Super("startEditingNew", [newCriteria, suppressFocus]);
			}
		});
		this.localContextMenu = isc.myContextMenu.create({parent: this, callingListGrid: this.MemberNotesLG});
		this.addItem(isc.myVLayout.create({members: [this.MemberNotesLG]}));
		this.MemberNotesLG.fetchData({memberID_fk: initData.memberID});
	}
});
