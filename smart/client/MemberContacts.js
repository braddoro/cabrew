isc.defineClass("MemberContacts", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.MemberContactsLG = isc.myListGrid.create({
			dataSource: isc.Members.contactsDS,
			name: "Member Contacts",
			parent: this,
			startEditingNew: function(newValues, suppressFocus){
				var newCriteria = isc.addProperties({}, newValues, {memberID_fk: initData.memberID});
				return this.Super("startEditingNew", [newCriteria, suppressFocus]);
			}
		});
		this.localContextMenu = isc.myContextMenu.create({parent: this, callingListGrid: this.MemberContactsLG});
		this.addItem(isc.myVLayout.create({members: [this.MemberContactsLG]}));
		this.MemberContactsLG.fetchData({memberID_fk: initData.memberID});
	}
});
