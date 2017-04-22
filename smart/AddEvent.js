isc.defineClass("AddEvent", "myWindow").addProperties({
	title: "Add Event",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.AddEventDS = isc.myDataSource.create({
			dataURL: "AddEvent.php",
			showFilterEditor: true,
			fields:[
				{name: "memberDateID", primaryKey: true, type: "sequence", visible: false},
				{name: "dateTypeID_fk", type: "integer", title: "Date Type", optionDataSource: isc.Shared.dateTypesDS, displayField: "dateType", valueField: "dateTypeID"},
				{name: "memberDate", title: 'Date', useTextField: true, editorType: "DateItem", validators: [{type: "isDate"}]},
				{name: "dateDetail", title: "Detail", type: "textArea", width: "*", validators: [{type: "lengthRange", max :150}]}
			]
		});
		this.ActiveMembersDS = isc.myDataSource.create({
			dataURL: "ActiveMembers.php",
			fields:[
				{name: "memberID", primaryKey: true, type: "sequence", hidden: true},
				{name: "Attended", type: "boolean", canEdit: true},
				{name: "FullName"}
			]
		});
		this.AddEventDF = isc.myDynamicForm.create({
			parent: this,
			dataSource: this.AddEventDS
		});
		this.AddEventLG = isc.myListGrid.create({
			parent: this,
			dataSource: this.ActiveMembersDS
		});
		this.AddEventVL = isc.myVLayout.create({members: [this.AddEventDF, this.AddEventLG]});
		this.addItem(this.AddEventVL);
	}
});
