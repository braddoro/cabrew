isc.defineClass("MemberDates", "myWindow").addProperties({
	title: "Members By Date",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.MemberDatesDS = isc.myDataSource.create({
			dataURL: application.server_path + "MemberDates.php",
			fields:[
				{name: "memberID", primaryKey: true, type: "sequence", detail: true},
				{name: "FullName"},
				{name: "lastName", detail: true},
				{name: "firstName", detail: true},
				{name: "sex", detail: true},
				{name: "statusTypeID_fk", title: "Status", optionDataSource: isc.Shared.statusTypesDS, displayField: "displayLOV", valueField: "valueLOV"},
				{name: "dateTypeID", title: "Date Type", optionDataSource: isc.Shared.dateTypesDS, displayField: "dateType", valueField: "dateTypeID"},
				{name: "Points"},
				{name: "Year", type: "SelectItem", optionDataSource: isc.Shared.eventYearsDS, displayField: "Year", valueField: "Year"},
				{name: "Month", type: "integer", detail: true},
				{name: "Day", type: "integer", detail: true},
				{name: "memberDate"},
				{name: "DateDetail"}
			]
		});
		this.MemberDatesLG = isc.myListGrid.create({
			showFilterEditor: true,
			autoFetchData: false,
			dataSource: this.MemberDatesDS,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			}
		});
		this.localContextMenu = isc.myFullMenu.create({
			parent: this,
			callingListGrid: this.MemberDatesLG
		});
		this.MemberDatesVL = isc.myVLayout.create({members: [this.MemberDatesLG]});
		this.addItem(this.MemberDatesVL);
		if(initData.hideNames === true) {
			this.MemberDatesLG.hideField("FullName");
			this.MemberDatesLG.hideField("statusTypeID_fk");
			this.MemberDatesLG.hideField("DateDetail");
			this.MemberDatesLG.hideField("Year");
			this.MemberDatesLG.setShowFilterEditor(false);
		}
		if(initData.autoFetch === true) {
			this.MemberDatesLG.fetchData({memberID: initData.memberID});
		}
	}
});
