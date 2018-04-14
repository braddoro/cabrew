isc.defineClass("MemberDates", "myWindow").addProperties({
	title: "Members By Date",
	initWidget: function(initData){
	this.Super("initWidget", arguments);
		this.MemberDatesLG = isc.myListGrid.create({
			parent: this,
			name: "Members By Date",
			showFilterEditor: true,
			autoFetchData: false,
			dataSource: isc.Members.datesDS,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			}
		});
		this.localContextMenu = isc.myChildMenu.create({
			parent: this,
			callingListGrid: this.MemberDatesLG
		});
		this.MemberDatesVL = isc.myVLayout.create({members: [this.MemberDatesLG]});
		this.addItem(this.MemberDatesVL);
		// if(initData.hideNames === true) {
		// 	this.MemberDatesLG.hideField("FullName");
		// 	this.MemberDatesLG.hideField("statusTypeID_fk");
		// 	this.MemberDatesLG.hideField("dateDetail");
		// 	this.MemberDatesLG.hideField("Year");
		// 	this.MemberDatesLG.setShowFilterEditor(false);
		// }
		if(initData.autoFetch === true) {
			this.MemberDatesLG.fetchData({memberID: initData.memberID});
		}else{
			var curr = new Date().getFullYear();
			this.MemberDatesLG.filterData({Year: curr, statusTypeID_fk: 1});
		}
	}
});
