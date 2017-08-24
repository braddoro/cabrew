isc.defineClass("MemberDetails", "myWindow").addProperties({
	title: "Member Details",
	initWidget: function(initData){
	this.Super("initWidget", arguments);
console.log(arguments);
		this.MemberListDF = isc.myDynamicForm.create({
			parent: this,
			dataSource: isc.Members.nameListDS,
			itemChange: function(item, newValue, oldValue){
				this.parent.MembersLG.fetchData({memberID: newValue});
				this.parent.MemberContactsLG.fetchData({memberID_fk: newValue});
				this.parent.MemberDatesLG.fetchData({memberID_fk: newValue});
				this.parent.MemberNotesLG.fetchData({memberID_fk: newValue});
			}
		});
		this.MembersLG = isc.myListGrid.create({
			parent: this,
			height: 50,
			dataSource: isc.Tables.memberDS,
			showCustomScrollbars: false
		});
		this.MemberContactsLG = isc.myListGrid.create({
			parent: this,
			height: "15%",
			minHeight: 100,
			dataSource: isc.Tables.contactDS
		});
		this.MemberDatesLG = isc.myListGrid.create({
			parent: this,
			height: "*",
			dataSource: isc.Tables.dateDS,
			initialSort: ["memberDate"],
			sortDirection: "descending"
		});
		this.MemberNotesLG = isc.myListGrid.create({
			parent: this,
			height: "15%",
			minHeight: 100,
			dataSource: isc.Tables.noteDS
		});
		this.MemberDetailsVL = isc.myVLayout.create({
			members: [
				this.MemberListDF,
				this.MembersLG,
				this.MemberContactsLG,
				this.MemberDatesLG,
				this.MemberNotesLG
			]
		});
		this.addItem(this.MemberDetailsVL);
		// this.parent.MembersLG.fetchData({memberID: this.arguments.memberID});
		// this.parent.MemberContactsLG.fetchData({memberID_fk: this.arguments.memberID});
		// this.parent.MemberDatesLG.fetchData({memberID_fk: this.arguments.memberID});
		// this.parent.MemberNotesLG.fetchData({memberID_fk: this.arguments.memberID});
	}
});
