isc.defineClass("AddEvent", "myWindow").addProperties({
	title: "Add Event",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.AddEventDS = isc.myDataSource.create({
			dataURL: serverPath + "AddEvent.php",
			fields:[
				{name: "memberDateID", primaryKey: true, type: "sequence", visible: false},
				{name: "dateTypeID_fk",
					type: "integer",
					title: "Date Type",
					optionDataSource: isc.Shared.dateTypesDS,
					optionCriteria: {active: "Y"},
					displayField: "dateType",
					valueField: "dateTypeID",
					pickListProperties: {
						showFilterEditor: true
					}
				},
				{name: "memberDate", type: "date",  title: "Date", editorType: "DateItem", validators: [{type: "isDate"}]},
				{name: "dateDetail", title: "Detail", type: "textArea", width: "*", validators: [{type: "lengthRange", max :150}]}
			]
		});
		this.ActiveMembersDS = isc.myDataSource.create({
			dataURL: serverPath + "ActiveMembers.php",
			fields:[
				{name: "memberID", primaryKey: true, type: "sequence", hidden: true},
				{name: "FullName"}
			]
		});
		this.AddEventDF = isc.myDynamicForm.create({
			parent: this,
			dataSource: this.AddEventDS
		});
		this.AddEventLG = isc.myListGrid.create({
			parent: this,
			showHeader: false,
			autoSaveEdits: false,
			dataSource: this.ActiveMembersDS
		});
		this.AddEventBT = isc.myIButton.create({
			parent: this,
			title: "Add",
			align: "center",
			click: function(){
				this.parent.submitData();
			}
		});
		this.AddEventVL = isc.myVLayout.create({members: [
			this.AddEventDF,
			this.AddEventBT,
			this.AddEventLG
		]});
		this.addItem(this.AddEventVL);
	},
	submitData: function(){
		var formData = this.AddEventDF.getValues();
		var selectedData = this.AddEventLG.getSelectedRecords();
		var newData;
		var loop = selectedData.length;
		var zero = 0;
		for (i = zero; i < loop; i++) {
			newData = {
				memberID_fk: selectedData[i]["memberID"],
				dateTypeID_fk: formData["dateTypeID_fk"],
				memberDate: formData["memberDate"],
				dateDetail: formData["dateDetail"]
			};
			this.AddEventDS.addData(newData);
		}
	}
});
