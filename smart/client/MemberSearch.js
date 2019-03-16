isc.defineClass("MemberSearch", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.MemberSearchDS = isc.myDataSource.create({
			dataURL: serverPath + "MemberSearch.php",
			fields:[
				{name: "memberID", primaryKey: true, type: "sequence", canEdit: false, detail: true},
				{name: "statusTypeID_fk", width: 75, title: "Status", optionDataSource: isc.Shared.statusTypesDS, optionCriteria: {active: "Y"}, displayField: "statusType", valueField: "statusTypeID"},
				{name: "FullName", width: "*"},
				{name: "sex", width: 50},
				{name: "renewalYear", width: 90, type: "integer", detail: true},
				{name: "lastChangeDate", width: 100, canEdit: false, detail: true}
			]
		});
		this.MemberSearchLG = isc.myListGrid.create({
			canEdit: false,
			dataSource: this.MemberSearchDS,
			name: "Member Search",
			parent: this,
			showFilterEditor: true
		});
		this.localContextMenu = isc.myChildMenu.create({
			callingListGrid: this.MemberSearchLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.MemberSearchLG]}));
		this.MemberSearchLG.filterData({statusTypeID_fk: 1});
	}
});
