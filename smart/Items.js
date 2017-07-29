isc.defineClass("Items", "myWindow").addProperties({
	title: "Items",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.ItemsDS = isc.myDataSource.create({
			dataURL: "Items.php",
			fields:[
				{name: "itemID", primaryKey: true, type: "sequence", detail: true, canEdit: false},
				{name: "userName", width: 100},
				{name: "itemDate",
					defaultValue: this.today,
					width: 100,
					editorType: "DateItem",
					inputFormat: "toUSShortDate",
					displayFormat: "toUSShortDate",
					useTextField: true},
				{name: "item", width: "*"}
			]
		});
		this.ItemsLG = isc.myListGrid.create({
			parent: this,
			showFilterEditor: true,
			dataSource: this.ItemsDS,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				var now = new Date();
				console.log(now.toISOString());
				return false;
			},
 			rowDoubleClick: function(record, recordNum, fieldNum, keyboardGenerated) {
 				this.startEditing(recordNum);
 			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.ItemsLG
		});
		this.ItemsVL = isc.myVLayout.create({members: [this.ItemsLG]});
		this.addItem(this.ItemsVL);
		var now = new Date();
		this.today = now.toSerializeableDate();

	}
});
