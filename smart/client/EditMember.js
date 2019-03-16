isc.defineClass("EditMember", "myWindow").addProperties({
	title: "Edit Member",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.EditMemberDF = isc.myDynamicForm.create({
			dataSource: isc.Members.membersDS,
			parent: this,
			updateData: function(updatedRecord, callback, requestProperties){
				return this.Super("updateData", [updatedRecord, callback, requestProperties]);
			}
		});
		this.EditMemberBT = isc.myIButton.create({
			align: "center",
			parent: this,
			title: "Save",
			click: function(){
				this.parent.EditMemberDF.updateData(this.parent.EditMemberDF.getValues());
			}
		});
		this.addItem(isc.myVLayout.create({members: [this.EditMemberDF, this.EditMemberBT]}));
		this.EditMemberDF.fetchData({memberID: initData.memberID});
		this.EditMemberDF.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
