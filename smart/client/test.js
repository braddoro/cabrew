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
			parent: this
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.testLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.testLG]}));
		// this.testLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
