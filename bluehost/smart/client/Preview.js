isc.defineClass("Preview", "myWindow").addProperties({
	title: "Preview",
	initWidget: function(initData){
//		console.log('initWidget');

		this.Super("initWidget", initData);
		this.PreviewDS = isc.myDataSource.create({
			parent: this,
			fields:[]
		});
		this.PreviewDF = isc.myDynamicForm.create({
			parent: this,
			dataSource: this.PreviewDS
		});
		this.addItem(isc.myVLayout.create({members: [this.PreviewDF]}));
		this.transformRecord(initData);
	},
	transformRecord(record){
//		console.log('transformRecord');
//		console.log(record);
		var fields = Object.keys(record).length;
//		console.log(fields);
		var newRec = new Array();
		var newFld = new Array();
		// for (i=0; i<fields; i++) {
		// 	console.log(record[i]);
		// 	newFld = {name: "asdf" + i, type: "text", label: record[i], defaultValue: record[i]};
		// 	newRec = isc.addProperties({}, newRec, newFld);
		// }

// newFld = {name: "asdfsadf" , type: "text", label: "dfghdfgh", defaultValue: "sdfsf"};
// newRec[] = newFld;
//newRec = isc.addProperties({}, newRec, newFld);

// newFld = {name: "bbihibhj" , type: "text", label: "szfsd1", defaultValue: "fghrt"};
// newRec[] = newFld;
//newRec = isc.addProperties({}, newRec, newFld);

//console.log(newRec);
//this.PreviewDS.fields(newRec);
// this.PreviewDF.setFields(newRec);
//this.PreviewDF.setValues(newRec);

		// var record = new Array();
		// var newRow = new Array();
		// var fieldList = new Array();
		// var records = this.FormItemsLG.getTotalRows();
		// for (i=0; i<records; i++) {
		//     record = this.FormItemsLG.getRecord(i);
		//     r_name = record.ELEMENT_NAME;
		//     r_value = (typeof record.DEFAULT_VALUE != "undefined") ? record.DEFAULT_VALUE : "";
		//     r_type = record.DATA_TYPE;
		//     r_desc = record.DESCRIPTION;
		//     r_width = record.FIELD_WIDTH;
		//     r_reqd = record.FIELD_REQUIRED;
		//     r_hint = record.FIELD_HINT;

		//     newRow = {name: r_name, type: r_type, title: r_desc, defaultValue: r_value, width: r_width, validateOnChange: true, validators: [{type: "lengthRange", max: 240}]};

		//     moreAttrs = {hint: r_hint, hintStyle: "white-space: nowrap;"};
		//     newRow = isc.addProperties({}, newRow, moreAttrs);

		//     if(r_type == "DateItem"){
		//         moreAttrs = {editorType: "DateItem", useTextField: true, validators: [{type: "lengthRange", max: 240}, {type: "isDate"}]};
		//         newRow = isc.addProperties({}, newRow, moreAttrs);
		//     }

		//     if(r_type == "integer"){
		//         moreAttrs = {validators: [{type: "lengthRange", max: 240}, {type: "isInteger"}]};
		//         newRow = isc.addProperties({}, newRow, moreAttrs);
		//     }

		//     if(r_type == "CheckboxItem"){
		//         moreAttrs = {labelAsTitle: true};
		//         newRow = isc.addProperties({}, newRow, moreAttrs);
		//     }

		//     if(r_type == "Yes/No"){
		//         moreAttrs = {
		//             type: "SelectItem",
		//             editorType: "SelectItem",
		//             optionDataSource: isc.EASDataSources.EAS.YNLOV,
		//             displayField: "YES_NO_LBL",
		//             valueField: "YES_NO_VAL"
		//         };
		//         newRow = isc.addProperties({}, newRow, moreAttrs);
		//     }

		//     if(r_type == "EmployeeList"){
		//         moreAttrs = {
		//             type: "SelectItem",
		//             editorType: "SelectItem",
		//             optionDataSource: isc.EASDataSources.EAS.employees,
		//             displayField: "EMPLOYEE_NAME",
		//             valueField: "EMPLOYEE_NUM",
		//             allowEmptyValue: true,
		//             pickListWidth: 300,
		//             pickListFields: [
		//                 {name: "EMPLOYEE_NUM", title: lang_trans("string_number", isc.locale_EAS_shared_strings.string_number), width: 50},
		//                 {name: "EMPLOYEE_NAME", title: lang_trans("string_name", isc.locale_EAS_shared_strings.string_name)}
		//             ]
		//         };
		//         newRow = isc.addProperties({}, newRow, moreAttrs);
		//     }

		//     if(r_reqd == "Y"){
		//         moreAttrs = {required: true, headerTitleStyle: "headerTitleRequired"};
		//         newRow = isc.addProperties({}, newRow, moreAttrs);
		//     }

		//     fieldList[i] = newRow;
		// }
		// this.PreviewDF.setFields(fieldList);
		return true;
	}
});
