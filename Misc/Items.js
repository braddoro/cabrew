isc.defineClass("Items", "myWindow").addProperties({
	title: "Items",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.ItemsDS = isc.myDataSource.create({
			dataURL: "Items.php",
			fields:[
				{name: "itemID", primaryKey: true, type: "sequence", detail: true, canEdit: false},
				{name: "itemDate", width: 120, editorType: "DateItem", inputFormat: "toUSShortDate", displayFormat: "toSerializeableDate", useTextField: true},
				{name: "userName", width: 80},
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
				return false;
			},
 			rowDoubleClick: function(record, recordNum, fieldNum, keyboardGenerated) {
 				this.startEditing(recordNum);
 			},
 			startEditingNew: function(newValues, suppressFocus){
				var now = new Date();
				var today = now.toSerializeableDate();
				var moreCriteria = isc.addProperties({}, newValues, {itemDate: today});
 				return this.Super("startEditingNew", [moreCriteria, suppressFocus]);
 			}
 			// ,
 			// removeData: function(){
 			// 	return this.Super("removeData", [data, callback, requestProperties]);
 			// }
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.ItemsLG
		});
		this.ItemsVL = isc.myVLayout.create({members: [this.ItemsLG]});
		this.addItem(this.ItemsVL);
	}
});
