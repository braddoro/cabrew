isc.defineClass("MemberHistory", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.MemberHistoryDS = isc.myDataSource.create({
		dataURL: serverPath + "MemberHistory.php",
		canEdit: false,
		fields:[
			{name: "memberDateID", primaryKey: true, type: "sequence", canEdit: false, detail: true},
			{name: "memberID_fk", width: 120, title: "Full Name", optionDataSource: isc.Shared.memberNamesDS, displayField: "FullName", valueField: "memberID"},
			{name: "dateTypeID_fk", type: "integer", title: "Date Type", optionDataSource: isc.Shared.dateTypesDS, displayField: "dateType", valueField: "dateTypeID"},
			{name: "memberDate", width: 120, title: "Date", useTextField: true, editorType: "DateItem", validators: [{type: "isDate"}]},
			{name: "dateDetail"},
			{name: "lastChangeDate", width: 100, canEdit: false, detail: true}
		]
	});
	this.MemberHistoryLG = isc.myListGrid.create({
		parent: this,
		name: "Member History",
		showFilterEditor: true,
		dataSource: this.MemberHistoryDS
	});
	this.localContextMenu = isc.myChildMenu.create({
		parent: this,
		callingListGrid: this.MemberHistoryLG
	});
	this.addItem(isc.myVLayout.create({members: [this.MemberHistoryLG]}));
	}
});
