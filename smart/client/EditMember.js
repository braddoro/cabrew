isc.defineClass("EditMember", "myWindow").addProperties({
	title: "Edit Member",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.EditMemberDF = isc.myDynamicForm.create({
			parent: this,
			dataSource: isc.Members.membersDS,
			updateData: function(updatedRecord, callback, requestProperties){
				return this.Super("updateData", [updatedRecord, callback, requestProperties]);
			}
		});
		this.EditMemberBT = isc.myIButton.create({
			parent: this,
			title: "Save",
			align: "center",
			click: function(){
				this.parent.EditMemberDF.updateData(this.parent.EditMemberDF.getValues());
			}
		});
		this.addItem(isc.myVLayout.create({members: [this.EditMemberDF, this.EditMemberBT]}));
		this.EditMemberDF.fetchData({memberID: initData.memberID});
	}
});
