isc.defineClass("MemberStatus", "myWindow").addProperties({
	title: "Members by Status",
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.MemberStatusDS = isc.myDataSource.create({
		dataURL: serverPath + "MemberStatus.php",
		showFilterEditor: true,
		fields:[
			{name: "statusTypeID_fk", title: "Status", optionDataSource: isc.Shared.statusTypesDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "memberID", primaryKey: true, detail: true, type: "sequence"},
			{name: "FullName"},
			{name: "lastName", detail: true},
			{name: "firstName", detail: true},
			{name: "sex", detail: true},
			{name: "lastChangeDate", detail: true},
			{name: "renewalMonth", type: "integer"},
			{name: "LastPayment", detail: true},
			{name: "JoinedDate", detail: true},
			{name: "MonthsPaid", type: "integer"}
		]
	});
	this.MemberStatusLG = isc.myListGrid.create({
		parent: this,
		showFilterEditor: true,
		dataSource: this.MemberStatusDS,
		rowContextClick: function(record, rowNum, colNum){
			this.parent.localContextMenu.showContextMenu();
			return false;
		}
	});
	this.localContextMenu = isc.myFullMenu.create({
		parent: this,
		callingListGrid: this.MemberStatusLG
	});
	this.MemberStatusVL = isc.myVLayout.create({members: [this.MemberStatusLG]});
	this.addItem(this.MemberStatusVL);
  }
});
