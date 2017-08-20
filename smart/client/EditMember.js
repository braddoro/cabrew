isc.defineClass("EditMember", "myWindow").addProperties({
	title: "Edit Member",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.EditMemberDF = isc.myDynamicForm.create({
			parent: this,
			dataSource: isc.Members.membersDS
		});
		this.EditMemberBT = isc.myIButton.create({
			parent: this,
			title: "Save",
			align: "center",
			click: function(){
				this.parent.EditMemberDS.updateData(this.parent.EditMemberDF.getValues());
			}
		});
		this.EditMemberVL = isc.myVLayout.create({members: [this.EditMemberDF, this.EditMemberBT]});
		this.addItem(this.EditMemberVL);
		this.EditMemberDF.fetchData({memberID: initData.memberID});
	}
});
