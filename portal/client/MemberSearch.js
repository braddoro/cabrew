isc.defineClass("MemberSearch", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.MemberSearchDS = isc.myDataSource.create({
		dataURL: serverPath + "MemberSearch.php",
		fields:[
			{name: "memberID", primaryKey: true, type: "sequence", canEdit: false, detail: true},
			{name: "FullName", width: "*"}
		]
	});
	this.MemberSearchLG = isc.myListGrid.create({
		canEdit: false,
		dataSource: this.MemberSearchDS,
		name: "Members",
		parent: this,
		showFilterEditor: true
	});
	// this.localContextMenu = isc.myChildMenu.create({
	// 	callingListGrid: this.MemberSearchLG,
	// 	parent: this
	// });
	this.addItem(isc.myVLayout.create({members: [this.MemberSearchLG]}));
	this.MemberSearchLG.filterData({statusTypeID_fk: 1});
	}
});
