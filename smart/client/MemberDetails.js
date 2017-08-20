isc.defineClass("MemberDetails", "myWindow").addProperties({
	title: "Member Details",
	initWidget: function(initData){
	this.Super("initWidget", arguments);
		this.MemberListDF = isc.myDynamicForm.create({
			parent: this,
			dataSource: isc.Members.nameListDS,
			itemChange: function(item, newValue, oldValue){
				this.parent.MemberDetailsLG.fetchData({memberID: newValue});
				this.parent.MemberContactsLG.fetchData({memberID: newValue});
				this.parent.MemberDatesLG.fetchData({memberID: newValue});
				this.parent.MemberNotesLG.fetchData({memberID: newValue});
			}
		});
		this.MemberDetailsLG = isc.myListGrid.create({
			parent: this,
			height: "10%",
			dataSource: isc.Members.membersDS,
			autoFetchData: false
		});
		this.MemberContactsLG = isc.myListGrid.create({
			parent: this,
			height: "15%",
			dataSource: isc.Members.contactsDS,
			autoFetchData: false
		});
		this.MemberDatesLG = isc.myListGrid.create({
			parent: this,
			height: "*",
			dataSource: isc.Members.datesDS,
			autoFetchData: false,
			initialSort: ["memberDate"]
		});
		this.MemberNotesLG = isc.myListGrid.create({
			parent: this,
			height: "15%",
			dataSource: isc.Members.notesDS,
			autoFetchData: false
		});
		this.MemberDetailsVL = isc.myVLayout.create({
			members: [
				this.MemberListDF,
				this.MemberDetailsLG,
				this.MemberContactsLG,
				this.MemberDatesLG,
				this.MemberNotesLG
			]
		});
		this.addItem(this.MemberDetailsVL);
		// this.MemberDetailsLG.fetchData({memberID: 0});
		// this.MemberContactsLG.fetchData({memberID: 0});
		// this.MemberDatesLG.fetchData({memberID: 0});
		// this.MemberNotesLG.fetchData({memberID: 0});
	}
});
