isc.defineClass("MemberSearch", "myWindow").addProperties({
	showMaximizeButton: false,
	showMinimizeButton: false,
	showCloseButton: false,
	canDragReposition: false,
	keepInParentRect: true,
	dismissOnEscape: false,
	canDragResize: false,
	edgeMarginSize:10,
	showShadow: true,
	maximized: true,
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
		showFilterEditor: true,
		rowDoubleClick: function(record, recordNum, fieldNum, keyboardGenerated) {
			isc.SaveEntry.create({width: "300", height: "150", memberID: record.memberID});
		}
	});
	this.addItem(isc.myVLayout.create({members: [this.MemberSearchLG]}));
	this.MemberSearchLG.filterData({statusTypeID_fk: 1});
	}
});
