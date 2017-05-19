isc.defineClass("MemberPoints", "myWindow").addProperties({
	title: "Members By Points",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.memberPointsDS = isc.myDataSource.create({
			dataURL: "MemberPoints.php",
			fields:[
				{name: "memberID", type: "sequence", primaryKey: true, detail: true, foreignKey: "this.pointListDS.memberID"},
				{name: "statusType", type: "string", width: 75},
				{name: "FullName", type: "string"},
				{name: "Points", type: "integer", width: 50}
			]
		});
		this.pointListDS = isc.myDataSource.create({
			dataURL: "PointsList.php",
			fields:[
				{name: "memberID", type: "sequence", primaryKey: true, detail: true},
				{name: "memberDate", type: "string", title: "Date", width: 100},
				{name: "datePoints", type: "integer", title: "Points", width: 75},
				{name: "dateTypeID", title: "Event", optionDataSource: isc.Shared.dateTypesDS, displayField: "dateType", valueField: "dateTypeID"},
				{name: "dateDetail", type: "string", title: "Detail", width: "*"}
			]
		});
		this.yearChooserDF = isc.myDynamicForm.create({
			parent: this,
			fields: [
				{name: "Year",
					type: "SelectItem",
					optionDataSource: isc.Shared.eventYearsDS,
					displayField: "Year",
					valueField: "Year",
					changed: function(form, item, value){
						form.parent.memberPointsLG.invalidateCache();
						form.parent.memberPointsLG.fetchData({year: value});
					}
				}
			]
		});
		this.memberPointsLG = isc.myListGrid.create({
			parent: this,
			margin: 1,
			width: 300,
			dataSource: this.memberPointsDS,
			recordClick: function(viewer, record, recordNum, field, fieldNum, value, rawValue){
				if(viewer.anySelected()){
					this.parent.pointListLG.fetchData({memberID: record.memberID, year: this.parent.yearChooserDF.getValue("Year")});
				}else{
					this.parent.pointListLG.setData([]);
				}
			},
			dataArrived: function(startRow, endRow){
				this.selectSingleRecord(startRow);
				this.recordClick(this,this.getRecord(0),"memberID",0);
			},
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			}
		});
		this.localContextMenu = isc.myChildMenu.create({
			parent: this,
			callingListGrid: this.memberPointsLG
		});
		this.pointListLG = isc.myListGrid.create({
			dataSource: this.pointListDS,
			margin: 1,
			width: "*",
			sortField: 0,
			sortDirection: "descending"
		});
		this.memberPointsScreenVL = isc.myVLayout.create({
			members: [this.yearChooserDF,
				isc.HLayout.create({members: [this.memberPointsLG, this.pointListLG]})
			]
		});
		var now = new Date();
		var current = new Date(now);
		this.yearChooserDF.setValue("Year",current.getFullYear());
		this.addItem(this.memberPointsScreenVL);
	}
});
