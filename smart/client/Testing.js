isc.defineClass("Testing", "myWindow").addProperties({
	showFooter: true,
	showStatusBar: true,
	title: "Testing",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.TestingDS = isc.myDataSource.create({
			dataURL: serverPath + "EditMember.php",
				fields: [
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
		this.EventDS = isc.myDataSource.create({
			dataURL: serverPath + "AddEvent.php",
				fields: [
					{name: "memberDateID", primaryKey: true, type: "sequence", visible: false},
					{name: "dateTypeID_fk", type: "integer", title: "Date Type", optionDataSource: isc.Shared.dateTypesDS, displayField: "dateType", valueField: "dateTypeID"},
					{name: "memberDate", title: "Date", useTextField: true, editorType: "DateItem", validators: [{type: "isDate"}]},
					{name: "dateDetail", title: "Detail", type: "textArea", width: "*", validators: [{type: "lengthRange", max :150}]}
				]
		});
		this.TestingLB = isc.Label.create({
			contents: "Testing",
			align: "center"
		});
		this.TestingDF = isc.myDynamicForm.create({
			parent: this,
			dataSource: isc.Members.membersDS
		});
		this.TestingBT = isc.myIButton.create({
			parent: this,
			title: "One",
			align: "center",
			click: function(){
				console.log(this.parent.EventDS);
				this.parent.TestingDF.setDataSource(
					this.parent.EventDS,[
					{name: "memberID", primaryKey: true, statusTypepe: "sequence", canEdit: false},
					{name: "statusTypeID_fk", type: "integer", title: "Status", optionDataSource: isc.Shared.statusTypesDS, displayField: "displayLOV", valueField: "valueLOV"},
					{name: "firstName", validators: [{type: "lengthRange", max: 30}]},
					{name: "midName", validators: [{type: "lengthRange", max: 30}]},
					{name: "lastName", validators: [{type: "lengthRange", max: 45}]},
					{name: "nickname", validators: [{type: "lengthRange", max: 45}]},
					{name: "sex", validators: [{type: "lengthRange", max: 1}, {type:"isOneOf", list: ["M","F"]}]},
					{name: "renewalMonth", type: "integer", validators: [{type:"integerRange", min:1, max:12}]},
					{name: "lastChangeDate", type: "datetime", canEdit: false}
				]);
			}
		});
		this.Testing2BT = isc.myIButton.create({
			parent: this,
			title: "Two",
			align: "center",
			click: function(){
				//console.log(this.parent.EventDS.fields);
				var foo = this.parent.EventDS.getFieldNames();
				console.log(foo);
				var text = "";
				var x;
				for (x in foo) {
					console.log(this.parent.EventDS.getField(foo[x]));
					//text += foo[x];
				}
				console.log(text);

				var leng = foo.length;
				for (i=0; i<leng; i++) {
					console.log(i);
					console.log(this.parent.EventDS.getField(i));
				}
				// this.parent.TestingDF.setDataSource(
				// 	this.parent.EventDS,[
				// 	{name: "memberDateID", primaryKey: true, type: "sequence", visible: false},
				// 	{name: "dateTypeID_fk", type: "integer", title: "Date Type", optionDataSource: isc.Shared.dateTypesDS, displayField: "dateType", valueField: "dateTypeID"},
				// 	{name: "memberDate", title: "Date", useTextField: true, editorType: "DateItem", validators: [{type: "isDate"}]},
				// 	{name: "dateDetail", title: "Detail", type: "textArea", width: "*", validators: [{type: "lengthRange", max :150}]}
				// ]);this.parent.EventDS.getFieldNames();
			}
		});
		this.TestingVL = isc.myVLayout.create({members: [
			this.TestingLB,
			this.TestingDF,
			this.TestingBT,
			this.Testing2BT
		]});
		this.addItem(this.TestingVL);
		// this.AddEventDF.setFields([
		// 	{name: "memberID", primaryKey: true, statusTypepe: "sequence", canEdit: false},
		// 	{name: "statusTypeID_fk", type: "integer", title: "Status", optionDataSource: isc.Shared.statusTypesDS, displayField: "displayLOV", valueField: "valueLOV"},
		// 	{name: "firstName", validators: [{type: "lengthRange", max: 30}]},
		// 	{name: "midName", validators: [{type: "lengthRange", max: 30}]},
		// 	{name: "lastName", validators: [{type: "lengthRange", max: 45}]},
		// 	{name: "nickname", validators: [{type: "lengthRange", max: 45}]},
		// 	{name: "sex", validators: [{type: "lengthRange", max: 1}, {type:"isOneOf", list: ["M","F"]}]},
		// 	{name: "renewalMonth", type: "integer", validators: [{type:"integerRange", min:1, max:12}]},
		// 	{name: "lastChangeDate", type: "datetime", canEdit: false}
		// ]);
	}
});
