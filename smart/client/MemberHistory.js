isc.defineClass("MemberHistory", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.MemberHistoryDS = isc.myDataSource.create({
		dataURL: serverPath + "MemberHistory.php",
		fields:[
			{name: "memberDateID", primaryKey: true, type: "sequence", canEdit: false, detail: true},
			{name: "memberID_fk", width: 120, title: "Full Name", optionDataSource: isc.Shared.memberNamesDS, displayField: "FullName", valueField: "memberID"},
			{name: "YearDate", type: "integer"},
			{name: "dateTypeID_fk", type: "integer", title: "Date Type", optionDataSource: isc.Shared.dateTypesDS, displayField: "dateType", valueField: "dateTypeID"},
			{name: "memberDate", width: 120, title: "Date", useTextField: true, editorType: "DateItem", validators: [{type: "isDate"}]},
			{name: "dateDetail"},
			{name: "lastChangeDate", width: 100, canEdit: false, detail: true}
		]
	});
	this.MemberHistoryLG = isc.myListGrid.create({
		canEdit: false,
		dataSource: this.MemberHistoryDS,
		name: "Member History",
		parent: this,
		showFilterEditor: true
	});
	this.localContextMenu = isc.myChildMenu.create({
		callingListGrid: this.MemberHistoryLG,
		parent: this
	});
	this.addItem(isc.myVLayout.create({members: [this.MemberHistoryLG]}));
	var current = new Date();
	this.MemberHistoryLG.fetchData({YearDate: current.getFullYear()});
	}
});
