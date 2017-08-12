isc.defineClass("AddPayment", "myWindow").addProperties({
	title: "Add Payment",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.AddPaymentDS = isc.myDataSource.create({
			dataURL: serverPath + "AddPayment.php",
			fields: [
				{
					name: "memberID",
					title: "Member",
					editorType: "SelectItem",
					optionDataSource: isc.Shared.memberNamesDS,
					wrapTitle: false,
					displayField: "FullName",
					valueField: "memberID",
					pickListWidth: 300,
					pickListProperties: {
						showFilterEditor: true
					},
					pickListFields: [
						{name: "FullName", width: "*"},
						{name: "Status", width: 75},
						{name: "Month", width: 50},
					]
				},
				{
					name: "resetMonth",
					title: "Reset Month",
					useTextField: true,
					editorType: "integer",
					defaultValue: 0,
					width: 50,
					validators: [
						{type:"integerRange", min: 0, max: 12}
					]
				},
				{	name: "renewalDate",
					title: "Renewal Date",
					useTextField: true,
					editorType: "DateItem",
					validators: [
						{type: "isDate"}
					]
				},
				{	name: "note",
					title: "Note",
					type: "textArea",
					width: "*",
					validators: [
						{type: "lengthRange", max :500}
					]
				}
			]
		});
		// this.ActiveMembersDS = isc.myDataSource.create({
		// 	dataURL: serverPath + "ActiveMembers.php",
		// 	fields:[
		// 		{name: "memberID", primaryKey: true, type: "sequence", hidden: true},
		// 		{name: "FullName"}
		// 	]
		// });
		this.AddPaymentDF = isc.myDynamicForm.create({
			parent: this,
//			showFilterEditor: true,
			dataSource: this.AddPaymentDS
		});
		// this.AddPaymentLG = isc.myListGrid.create({
		// 	parent: this,
		// 	showHeader: false,
		// 	autoSaveEdits: false,
		// 	dataSource: this.ActiveMembersDS
		// });
		this.AddPaymentBT = isc.myIButton.create({
			parent: this,
			title: "Add",
			align: "center",
			click: function(){
				this.parent.submitData();
			}
		});
		this.AddPaymentVL = isc.myVLayout.create({members: [
			this.AddPaymentDF,
			this.AddPaymentBT
		]});
		this.addItem(this.AddPaymentVL);
	},
	submitData: function(){
		// var formData = this.AddPaymentDF.getValues();
		// console.log(formData);
		// var selectedData = this.AddPaymentLG.getSelectedRecords();
		// var newData;
		// var loop = selectedData.length;
		// var zero = 0;
		// for (i = zero; i < loop; i++) {
		// newData = {
		// 	memberID_fk: selectedData[i]["memberID"],
		// 	dateTypeID_fk: formData["dateTypeID_fk"],
		// 	memberDate: formData["memberDate"],
		// 	dateDetail: formData["dateDetail"]
		// };
			this.AddPaymentDS.addData(this.AddPaymentDF.getValues());
		//}
	}
});
