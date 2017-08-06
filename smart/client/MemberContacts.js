isc.defineClass("MemberContacts", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.MemberContactsDS = isc.myDataSource.create({
			dataURL: serverPath + "MemberContacts.php",
			fields:[
				{name: "memberContactID", primaryKey: true, detail: true},
				{name: "memberID_fk", detail: true},
				{name: "contactTypeID_fk", title: "Type", optionDataSource: isc.Shared.contactTypesDS, displayField: "contactType", valueField: "contactTypeID"},
				{name: "memberContact"},
				{name: "contactDetail"},
				{name: "lastChangeDate", detail: true}
			]
		});
		this.MemberContactsLG = isc.myListGrid.create({
			parent: this,
			dataSource: this.MemberContactsDS,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.MemberContactsLG
		});
		this.MemberContactsVL = isc.myVLayout.create({members: [this.MemberContactsLG]});
		this.addItem(this.MemberContactsVL);
		this.MemberContactsLG.fetchData({memberID: initData.memberID});
	}
});
