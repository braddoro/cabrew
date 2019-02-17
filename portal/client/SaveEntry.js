isc.defineClass("SaveEntry", "myWindow").addProperties({
	title: "Save Entry",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.SaveEntryDS = isc.myDataSource.create({
			dataURL: serverPath + "SaveEntry.php",
			fields:[
				{name: "memberEventID", primaryKey: true, type: "sequence", visible: false},
				{name: "memberID", visible: false},
				{name: "dateTypeID", type: "integer", title: "Date Type", optionDataSource: isc.Shared.dateTypesDS, optionCriteria: {active: "Y"}, displayField: "dateType", valueField: "dateTypeID", pickListProperties: {showFilterEditor: true}, defaultValue: 6},
				{name: "eventDate", type: "date", title: "Date", editorType: "DateItem", validators: [{type: "isDate"}]},
				{name: "present", type: "checkbox", defaultValue: "N", valueMap: {"N": false, "Y": true}},
				{name: "beer", type: "checkbox", defaultValue: "N", valueMap: {"N": false, "Y": true}}
			]
		});
		this.SaveEntryDF = isc.myDynamicForm.create({
			dataSource: this.SaveEntryDS,
			parent: this,
			addData: function(newRecord, callback, requestProperties){
				return this.Super("addData", [newRecord, callback, requestProperties]);
			},
			updateData: function(updatedRecord, callback, requestProperties){
				return this.Super("updateData", [updatedRecord, callback, requestProperties]);
			}
		});
		this.SaveEntryBT = isc.myIButton.create({
			align: "center",
			parent: this,
			title: "Save",
			click: function(){
				this.parent.SaveEntryDF.addData(this.parent.SaveEntryDF.getValues());
			}
		});
		this.addItem(isc.myVLayout.create({members: [this.SaveEntryDF, this.SaveEntryBT]}));
		this.SaveEntryDF.setValue("memberID", initData.memberID);
	}
});
