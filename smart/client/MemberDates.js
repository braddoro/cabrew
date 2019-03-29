isc.defineClass("MemberDates", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.MemberDatesLG = isc.myListGrid.create({
			dataSource: isc.Members.datesDS,
			initialSort: [{property: "memberDate", direction: "descending"}],
			name: "Member Dates",
			parent: this,
			showFilterEditor: true,
			startEditingNew: function(newValues, suppressFocus){
				var newCriteria = isc.addProperties({}, newValues, {memberID_fk: initData.memberID});
				return this.Super("startEditingNew", [newCriteria, suppressFocus]);
			}
		});
		this.localContextMenu = isc.myContextMenu.create({parent: this, callingListGrid: this.MemberDatesLG});
		this.addItem(isc.myVLayout.create({members: [this.MemberDatesLG]}));
		this.MemberDatesLG.fetchData({memberID_fk: initData.memberID});
		this.MemberDatesLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
