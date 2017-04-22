isc.defineClass("MemberChairs", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.MemberChairsDS = isc.myDataSource.create({
			dataURL: "MemberChairs.php",
			fields:[
				{name: "memberChairID", primaryKey: true, detail: true, type: "sequence"},
				{name: "memberID_fk", detail: true},
				{name: "chairTypeID_fk", title: "Chair Type", optionDataSource: isc.Shared.chairTypesDS, displayField: "chairType", valueField: "chairTypeID"},
				{name: "dateTypeID_fk", title: "Date Type", optionDataSource: isc.Shared.dateTypesDS, displayField: "dateType", valueField: "dateTypeID"},
				{name: "chairDate"},
				{name: "memberChair"},
				{name: "lastChangeDate", detail: true}
			]
		});
		this.MemberChairsLG = isc.myListGrid.create({dataSource: this.MemberChairsDS});
		this.MemberChairsVL = isc.myVLayout.create({members: [this.MemberChairsLG]});
		this.addItem(this.MemberChairsVL);
		this.MemberChairsLG.fetchData({memberID: initData.memberID});
	}
});
