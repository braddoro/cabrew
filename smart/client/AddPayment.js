isc.defineClass("AddPayment", "myWindow").addProperties({
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
						{name: "Month", width: 50}
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
		this.AddPaymentDF = isc.myDynamicForm.create({
			parent: this,
			dataSource: this.AddPaymentDS
		});
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
		this.AddPaymentDS.addData(this.AddPaymentDF.getValues());
	}
});
