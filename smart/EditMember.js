isc.defineClass("EditMember", "myWindow").addProperties({
	title: "Edit Member",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.EditMemberDS = isc.myDataSource.create({
			dataURL: "EditMember.php",
			fields:[
				{name: "memberID", primaryKey: true, statusTypepe: "sequence", canEdit: false},
				{name: "statusTypeID_fk", type: "integer", title: "Status", optionDataSource: isc.Shared.statusTypesDS, displayField: "displayLOV", valueField: "valueLOV"},
				{name: "firstName", validators: [{type: "lengthRange", max: 30}]},
				{name: "midName", validators: [{type: "lengthRange", max: 30}]},
				{name: "lastName", validators: [{type: "lengthRange", max: 45}]},
				{name: "nickname", validators: [{type: "lengthRange", max: 45}]},
				{name: "sex", validators: [{type: "lengthRange", max: 1}, {type:"isOneOf", list: ["M","F"]}]},
				{name: "renewalMonth", type: "integer", validators: [{type:"integerRange", min:1, max:12}]},
				{name: "lastChangeDate", type: "datetime", canEdit: false}
			]
		});
		this.EditMemberDF = isc.myDynamicForm.create({
			parent: this,
			dataSource: this.EditMemberDS,
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
		this.addItem(this.EditMemberVL);		;
		this.EditMemberDF.fetchData({memberID: initData.memberID});
	}
});
