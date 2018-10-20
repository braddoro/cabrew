isc.defineClass("ClubSearch", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.ClubSearchDS = isc.myDataSource.create({
		dataURL: serverPath + "ClubSearch.php",
		fields:[
			{name: "clubID", primaryKey: true, type: "sequence", canEdit: false, detail: true},
			{name: "contactID", type: "integer", canEdit: false, detail: true},
			{name: "contactPointID", type: "integer", canEdit: false, detail: true},
			{name: "mediaID", type: "integer", canEdit: false, detail: true},
			{name: "LastAttended", width: 100},
			{name: "active", width: 100},
			{name: "clubName", width: "*"},
			{name: "clubAbbr", width: 80},
			{name: "Location"},
			{name: "distance", width: 80},
			{name: "contactName"},
			{name: "cp_contactType", title: "Contact Type", detail: true},
			{name: "contactPoint"},
			{name: "bm_contactType", title: "Media Type", detail: true},
			{name: "media"}
		]
	});
	this.ClubSearchLG = isc.myListGrid.create({
		canEdit: false,
		dataSource: this.ClubSearchDS,
		name: "Club Search",
		parent: this,
		showFilterEditor: true
	});
	this.localContextMenu = isc.myClubMenu.create({
		callingListGrid: this.ClubSearchLG,
		parent: this
	});
	this.addItem(isc.myVLayout.create({members: [this.ClubSearchLG]}));
	}
});
