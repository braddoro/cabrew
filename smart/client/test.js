isc.defineClass("test", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
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
	}
});
