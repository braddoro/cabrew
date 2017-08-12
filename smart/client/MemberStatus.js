isc.defineClass("MemberStatus", "myWindow").addProperties({
	title: "Members by Status",
	baseTitle: "Members by Status",
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.MemberStatusDS = isc.myDataSource.create({
		dataURL: serverPath + "MemberStatus.php",
		showFilterEditor: true,
		fields:[
			{name: "statusTypeID_fk", width: 100, title: "Status", optionDataSource: isc.Shared.statusTypesDS, displayField: "displayLOV", valueField: "valueLOV"},
			{name: "FullName", width: "*"},
			{name: "JoinedDate", width: 100},
			{name: "renewalMonth", width: 100, type: "integer"},
			{name: "MonthsPaid", width: 100, type: "integer"},
			{name: "memberID", primaryKey: true, detail: true, type: "sequence"},
			{name: "sex", detail: true},
			{name: "nickName", detail: true},
			{name: "firstName", detail: true},
			{name: "midName", detail: true},
			{name: "lastName", detail: true},
			{name: "lastChangeDate", width: 100, detail: true},
			{name: "LastPayment", width: 100, detail: true}
		]
	});
	this.MemberStatusLG = isc.myListGrid.create({
		parent: this,
		id: "MemberStatusLG",
		showFilterEditor: true,
		canEdit: false,
		dataSource: this.MemberStatusDS,
		rowContextClick: function(record, rowNum, colNum){
			this.parent.localContextMenu.showContextMenu();
			return false;
		},
		dataArrived: function(){
			var statusText = this.parent.baseTitle;
			statusText += " - Rows: ";
			statusText += this.getTotalRows();
			this.parent.setTitle = statusText;
		}
	});
	this.localContextMenu = isc.myChildMenu.create({
		parent: this,
		callingListGrid: this.MemberStatusLG
	});
	this.MemberStatusVL = isc.myVLayout.create({members: [this.MemberStatusLG]});
	this.addItem(this.MemberStatusVL);
	this.MemberStatusLG.filterData({statusTypeID_fk: 1});
  }
});
