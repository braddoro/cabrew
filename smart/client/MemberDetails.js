isc.defineClass("MemberDetails", "myWindow").addProperties({
	title: "Member Details",
	initWidget: function(initData){
	this.Super("initWidget", arguments);
		this.MemberDetailsLG = isc.myListGrid.create({
			parent: this,
			height: "10%",
			dataSource: isc.Members.membersDS,
			recordClick: function(viewer, record, recordNum, field, fieldNum, value, rawValue){
				this.parent.MemberContactsLG.fetchData({memberID: record.memberID});
				this.parent.MemberDatesLG.fetchData({memberID: record.memberID});
				this.parent.MemberNotesLG.fetchData({memberID: record.memberID});
			}
		});
		this.MemberContactsLG = isc.myListGrid.create({
			parent: this,
			dataSource: isc.Members.contactsDS,
			height: "15%",
			fetchData: function(criteria, callback, requestProperties){
				var morecriteria = "";
				var newcriteria = "";
				if (this.parent.MemberDetailsLG.anySelected()){
					morecriteria = {memberID : this.parent.MemberDetailsLG.getSelectedRecord().memberID};
					newcriteria = isc.addProperties({}, criteria, morecriteria);
					callback = {target: this, methodName: "selectFirstRow"};
					return this.Super("fetchData", [newcriteria, callback, requestProperties]);
				} else {
					return false;
				}
			},
			selectFirstRow: function(){
				this.selectRecord(0, true);
				this.recordClick();
			}
		});
		this.MemberDatesLG = isc.myListGrid.create({
			parent: this,
			height: "*",
			dataSource: isc.Members.datesDS,
			fetchData: function(criteria, callback, requestProperties){
				var morecriteria = "";
				var newcriteria = "";
				if (this.parent.MemberDetailsLG.anySelected()){
					morecriteria = {memberID : this.parent.MemberDetailsLG.getSelectedRecord().memberID};
					newcriteria = isc.addProperties({}, criteria, morecriteria);
					callback = {target: this, methodName: "selectFirstRow"};
					return this.Super("fetchData", [newcriteria, callback, requestProperties]);
				} else {
					return false;
				}
			},
			selectFirstRow: function(){
				this.selectRecord(0, true);
				this.recordClick();
			}
		});
		this.MemberNotesLG = isc.myListGrid.create({
			parent: this,
			height: "15%",
			dataSource: isc.Members.notesDS,
			fetchData: function(criteria, callback, requestProperties){
				var morecriteria = "";
				var newcriteria = "";
				if (this.parent.MemberDetailsLG.anySelected()){
					morecriteria = {memberID : this.parent.MemberDetailsLG.getSelectedRecord().memberID};
					newcriteria = isc.addProperties({}, criteria, morecriteria);
					callback = {target: this, methodName: "selectFirstRow"};
					return this.Super("fetchData", [newcriteria, callback, requestProperties]);
				} else {
					return false;
				}
			},
			selectFirstRow: function(){
				this.selectRecord(0, true);
				this.recordClick();
			}
		});
		this.MemberDetailsVL = isc.myVLayout.create({
			members: [
				this.MemberDetailsLG,
				this.MemberContactsLG,
				this.MemberDatesLG,
				this.MemberNotesLG
			]
		});
		this.addItem(this.MemberDetailsVL);
		this.MemberDetailsLG.fetchData({memberID: initData.memberID});
	}
});
