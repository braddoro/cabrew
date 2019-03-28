isc.defineClass("test", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		// https://www.smartclient.com/smartclient-release/isomorphic/system/reference/?id=group..relogin
		// if(!checkPerms(this.getClassName() + ".js")){
		// 	isc.warn(this.mm_accessFail);
		// 	this.close();
		// }
		this.testDS = isc.myDataSource.create({
			dataURL: serverPath + "test.php",
			fields:[
				{name: "testID", type: "sequence", primaryKey: true, canEdit: false, width: 100},
				{name: "testInt", type: "integer", width: 100},
				{name: "testDate", type: "date", width: 150},
				{name: "testString", type: "text", width: "*"},
				{name: "testTimeStamp", type: "DateTime", width: 150},
				{name: "lastChangeDate", type: "datetime", canEdit: false}
			]
		});
		this.testLG = isc.myListGrid.create({
			dataSource: this.testDS,
			name: "Test",
			parent: this,
			baseStyle: "cell",
			getBaseStyle: function (record, rowNum, colNum){
				var today = new Date();
				var yyyy = today.getFullYear();
				var mm = today.getMonth();
				var dd = today.getDate();
				var newdate = '' + yyyy + '-' + mm + '-' + dd;
				// console.log(newdate);
				// console.log(today);
				// console.log(record.dueDate);
				if(record.status == 'complete'){
					console.log('complete');
					return "myHighGridCell";
				}else if(record.status == 'in process'){
					console.log('in process');
					return "myLowGridCell";
				}else{
					console.log('misc');
					return this.baseStyle;
				}
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.testLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.testLG]}));
		// this.testLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
