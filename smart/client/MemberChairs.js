isc.defineClass("MemberChairs", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.MemberChairsDS = isc.myDataSource.create({
			dataURL: serverPath + "MemberChairs.php",
			fields:[
				{name: "memberChairID", type: "sequence", primaryKey: true, detail: true, canEdit: false},
				{name: "memberID_fk", required: true, detail: true},
				{name: "chairTypeID_fk", title: "Chair Type", optionDataSource: isc.Shared.chairTypesDS, optionCriteria: {active: "Y"}, displayField: "chairType", valueField: "chairTypeID"},
				{name: "dateTypeID_fk", title: "Date Type", optionDataSource: isc.Shared.dateTypesDS, optionCriteria: {active: "Y"}, displayField: "dateType", valueField: "dateTypeID"},
				{name: "chairDate"},
				{name: "lastChangeDate", detail: true, canEdit: false}
			]
		});
		this.MemberChairsLG = isc.myListGrid.create({
			parent: this,
			dataSource: this.MemberChairsDS,
			name: "Member Chairs",
			startEditingNew: function(newValues, suppressFocus){
				var newCriteria = isc.addProperties({}, newValues, {memberID_fk: initData.memberID});
				return this.Super("startEditingNew", [newCriteria, suppressFocus]);
			}
		});
		this.localContextMenu = isc.myContextMenu.create({parent: this, callingListGrid: this.MemberChairsLG});
		this.MemberChairsVL = isc.myVLayout.create({members: [this.MemberChairsLG]});
		this.addItem(this.MemberChairsVL);
		this.MemberChairsLG.fetchData({memberID_fk: initData.memberID});
	}
});
