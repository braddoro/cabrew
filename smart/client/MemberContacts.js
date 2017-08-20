isc.defineClass("MemberContacts", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.MemberContactsLG = isc.myListGrid.create({
			parent: this,
			dataSource: isc.Members.contactsDS,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.MemberContactsLG
		});
		this.MemberContactsVL = isc.myVLayout.create({members: [this.MemberContactsLG]});
		this.addItem(this.MemberContactsVL);
		this.MemberContactsLG.fetchData({memberID: initData.memberID});
	}
});
