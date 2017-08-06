// defaultValue: function() {
// 	var today = new Date();
// 	var datestring = (today.getMonth()+1) + "/" + today.getDate() + "/" + today.getFullYear();
// 	return datestring;
// }
// ,
// windowInitialize: function(initData){
// 	this.initData = initData;
// 	var today = new Date();
// 	console.log(today);
// 	var datestring = (today.getMonth()+1) + "/" + today.getDate() + "/" + today.getFullYear();
// 	console.log(datestring);
// 	this.AddEventDF.getItem("memberDate").defaultValue = datestring;
// }
isc.defineClass("AddMember", "myWindow").addProperties({
	title: "Add Member",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.AddEventDS = isc.myDataSource.create({
			dataURL: serverPath + "AddMember.php",
			fields:[
				{name: "memberDateID", primaryKey: true, type: "sequence", visible: false},
				{name: "dateTypeID_fk", type: "integer", title: "Date Type", optionDataSource: isc.Shared.dateTypesDS, displayField: "dateType", valueField: "dateTypeID"},
				{name: "memberDate", title: "Date", useTextField: true, editorType: "DateItem", validators: [{type: "isDate"}]},
				{name: "dateDetail", title: "Detail", type: "textArea", width: "*", validators: [{type: "lengthRange", max :150}]}
			]
		});
		this.AddEventDF = isc.myDynamicForm.create({
			parent: this,
			dataSource: this.AddEventDS
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
			this.AddEventDF
		]});
		this.addItem(this.AddEventVL);
	},
	submitData: function(){
		// var formData = this.AddEventDF.getValues();
		// var selectedData = this.AddEventLG.getSelectedRecords();
		// var newData;
		// var loop = selectedData.length;
		// var zero = 0;
		// for (i = zero; i < loop; i++) {
		// 	newData = {
		// 		memberID_fk: selectedData[i]["memberID"],
		// 		dateTypeID_fk: formData["dateTypeID_fk"],
		// 		memberDate: formData["memberDate"],
		// 		dateDetail: formData["dateDetail"]
		// 	};
		// 	this.AddEventDS.addData(newData);
		// }
	}
});
