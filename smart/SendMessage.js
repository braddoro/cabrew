// {name: "dateTypeID_fk", type: "integer", title: "Date Type", optionDataSource: isc.Shared.dateTypesDS, displayField: "dateType", valueField: "dateTypeID"},
// {name: "memberDate", title: "Date", useTextField: true, editorType: "DateItem", validators: [{type: "isDate"}]},
// optionDataSource: isc.Shared.messageTypesDS, displayField: "displayLOV", valueField: "valueLOV"
//
isc.defineClass("SendMessage", "myWindow").addProperties({
	title: "Add Event",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.AddEventDS = isc.myDataSource.create({
			dataURL: "SendMessage.php",
			fields:[
				{name: "memberDateID", primaryKey: true, type: "sequence", visible: false},
				{name: "MessageType", type: "radioGroup", vertical: false, width: "*", defaultValue: "SMS", valueMap:["SMS","Email","Other"]},
				{name: "Subject", type: "text", width: "*", validators: [{type: "lengthRange", max: 64}]},
				{name: "Message", type: "textArea", width: "*", validators: [{type: "lengthRange", max: 150}]}
			]
		});
		this.ActiveMembersDS = isc.myDataSource.create({
			dataURL: "MemberStatus.php",
			fields:[
				{name: "memberID", primaryKey: true, type: "sequence", hidden: true},
				{name: "FullName"},
				{name: "statusTypeID_fk", title: "Status", optionDataSource: isc.Shared.statusTypesDS, displayField: "displayLOV", valueField: "valueLOV"}
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
			showFilterEditor: true,
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
				MessageType: formData["MessageType"],
				Subject: formData["Subject"],
				Message: formData["Message"]
			};
			this.AddEventDS.addData(newData);
		}
	}
});
