isc.defineClass("MemberSearch", "myWindow").addProperties({
	title: "Member Search",
	baseTitle: "Member Search",
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.MemberSearchDS = isc.myDataSource.create({
		dataURL: serverPath + "MemberSearch.php",
		showFilterEditor: true,
		fields:[
			{name: "memberID", primaryKey: true, type: "sequence", canEdit: false, detail: true},
			{name: "statusTypeID_fk", width: 75, title: "Status", optionDataSource: isc.Shared.statusTypesDS, optionCriteria: {active: "Y"}, displayField: "statusType", valueField: "statusTypeID"},
			{name: "FullName", width: "*"},
			{name: "firstName", detail: true},
			{name: "midName", detail: true},
			{name: "lastName", detail: true},
			{name: "nickName", detail: true},
			{name: "JoinedDate", width: 100},
			{name: "sex", width: 50},
			{name: "renewalYear", width: 90, type: "integer", detail: true},
			{name: "lastChangeDate", width: 100, canEdit: false, detail: true}
		]
	});
	this.MemberSearchLG = isc.myListGrid.create({
		parent: this,
		name: "Member Search",
		id: "MemberSearchLG",
		showFilterEditor: true,
		canEdit: false,
		dataSource: this.MemberSearchDS
	});
	this.localContextMenu = isc.myChildMenu.create({
		parent: this,
		callingListGrid: this.MemberSearchLG
	});
	this.MemberSearchVL = isc.myVLayout.create({members: [this.MemberSearchLG]});
	this.addItem(this.MemberSearchVL);
	this.MemberSearchLG.filterData({statusTypeID_fk: 1});
  }
});
