isc.defineClass("BeerList", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.BeerListDS = isc.myDataSource.create({
		dataURL: serverPath + "BeerList.php",
		showFilterEditor: true,
		fields:[
			{name: "beerListID", primaryKey: true, detail: true, type: "sequence"},
			{name: "eventID", width: 120, type: "integer", title: "Event", optionDataSource: isc.Shared.eventTypesDS, displayField: "eventType", valueField: "eventTypeID", optionCriteria: {active: 'Y'}},
			{name: "clubID", width: 120, title: "Club",
			optionDataSource: isc.Shared.brewClubsDS,
			optionCriteria: {active: 'Y'},
			displayField: "clubAbbr",
			valueField: "clubID",
			pickListWidth: 300,
			pickListProperties: {showFilterEditor: true},
			pickListFields: [{name: "clubAbbr", width: "70"},{name: "clubName", width: "*"}]},
			{name: "beerStyle", width: 300, validators: [{type: "lengthRange", max: 100}]},
			{name: "beerName", width: "*", validators: [{type: "lengthRange", max: 100}]},
			{name: "brewerName", width: 300, validators: [{type: "lengthRange", max: 100}]},
			{name: "beerStory", width: 300, validators: [{type: "lengthRange", max: 1000}], detail: true},
			{name: "lastChangeDate", width: 100, detail: true}
		]
	});
	this.BeerListLG = isc.myListGrid.create({
		parent: this,
		name: "Beer list",
		showFilterEditor: true,
		dataSource: this.BeerListDS,
		initialSort: [{property: "dueDate", direction: "ascending"}],
		startEditingNew: function(newValues, suppressFocus){
			var data;
			var clubID;
			var eventID;
			if(this.anySelected()){
				data = this.getSelectedRecord();
				clubID = data.clubID;
				eventID = data.eventID;
			}
			var rowDefaults = {clubID: clubID, eventID: eventID};
			var newCriteria = isc.addProperties({}, newValues, rowDefaults);
			return this.Super("startEditingNew", [newCriteria, suppressFocus]);
		}
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.BeerListLG
	});
	this.addItem(isc.myVLayout.create({members: [this.BeerListLG]}));
	// this.BeerListLG.filterData();
  }
});
