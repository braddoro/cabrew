isc.defineClass("TestData", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.testDataDS = isc.myDataSource.create({
			dataURL: "TestData.php",
			fields:[
				{name: "testID",        type: "sequence", primaryKey: true, canEdit: false},
				{name: "testString",    type: "string"},
				{name: "testInt",       type: "integer"},
				{name: "lastChangeDate",type: "string", canEdit: false}
			],
			editComplete: function(rowNum, colNum, newValues, oldValues, editCompletionEvent, dsResponse) {
				if(dsResponse.status === 0){
					this.invalidateCache();
				}
			},
		});
		this.testDataLG = isc.myListGrid.create({
			parent: this,
			dataSource: this.testDataDS,
			canEdit: true,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.testDataLG
		});
		this.localLayout = isc.myVLayout.create({members: [this.testDataLG]});
		this.addItem(this.localLayout);
		this.testDataLG.fetchData();
	}
});
