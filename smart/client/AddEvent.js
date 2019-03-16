isc.defineClass("AddEvent", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.AddEventDS = isc.myDataSource.create({
			dataURL: serverPath + "AddEvent.php",
			fields:[
				{name: "memberDateID", primaryKey: true, type: "sequence", visible: false},
				{name: "dateTypeID_fk", type: "integer", title: "Date Type", optionDataSource: isc.Shared.dateTypesDS, optionCriteria: {active: "Y"}, displayField: "dateType", valueField: "dateTypeID", pickListProperties: {showFilterEditor: true}},
				{name: "memberDate", type: "date", title: "Date", editorType: "DateItem", validators: [{type: "isDate"}]},
				{name: "dateDetail", title: "Detail", type: "textArea", width: "*", validators: [{type: "lengthRange", max :150}]}
			]
		});
		this.AddEventDF = isc.myDynamicForm.create({
			dataSource: this.AddEventDS,
			parent: this
		});
		this.AddEventLG = isc.myListGrid.create({
			autoSaveEdits: false,
			dataSource: isc.Shared.memberNamesDS,
			parent: this,
			showFilterEditor: true,
			showHeader: false
		});
		this.AddEventBT = isc.myIButton.create({
			align: "center",
			parent: this,
			title: "Add",
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
		this.AddEventLG.fetchData({statusTypeID_fk: 1});
		this.AddEventDF.canEdit = checkPerms(this.getClassName() + ".js");
	},
	submitData: function(){
		var formData = this.AddEventDF.getValues();
		var selectedData = this.AddEventLG.getSelectedRecords();
		var newData;
		var loop = selectedData.length;
		var zero = 0;
		for (i = zero; i < loop; i++) {
			newData = {
				dateDetail: formData["dateDetail"],
				dateTypeID_fk: formData["dateTypeID_fk"],
				memberDate: formData["memberDate"],
				memberID_fk: selectedData[i]["memberID"]
			};
			this.AddEventDS.addData(newData);
		}
	}
});
