isc.defineClass("ClubSearch", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.ClubSearchDS = isc.myDataSource.create({
		dataURL: serverPath + "ClubSearch.php",
		canEdit: false,
		fields:[
			{name: "clubID", primaryKey: true, type: "sequence", canEdit: false, detail: true},
			{name: "contactID", type: "integer", canEdit: false, detail: true},
			{name: "contactPointID", type: "integer", canEdit: false, detail: true},
			{name: "mediaID", type: "integer", canEdit: false, detail: true},
			{name: "clubName", width: "*"},
			{name: "clubAbbr", width: 80},
			{name: "Location"},
			{name: "contactName"},
			{name: "cp_contactType", title: "Contact Type"},
			{name: "contactPoint"},
			{name: "bm_contactType", title: "Media Type"},
			{name: "media"}
		]
	});
	this.ClubSearchLG = isc.myListGrid.create({
		parent: this,
		name: "Club Search",
		showFilterEditor: true,
		dataSource: this.ClubSearchDS
	});
	this.localContextMenu = isc.myChildMenu.create({
		parent: this,
		callingListGrid: this.ClubSearchLG
	});
	this.addItem(isc.myVLayout.create({members: [this.ClubSearchLG]}));
	}
});
