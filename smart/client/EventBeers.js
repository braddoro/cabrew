isc.defineClass("EventBeers", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.EventBeerDS = isc.myDataSource.create({
		dataURL: serverPath + "EventBeers.php",
		showFilterEditor: true,
		fields:[
			{name: "eventBeerID", primaryKey: true, detail: true, type: "sequence"},
			{name: "eventID", width: 120, type: "integer", title: "Event", optionDataSource: isc.Shared.eventTypesDS, displayField: "eventType", valueField: "eventTypeID", optionCriteria: {active: "Y"}},
			{name: "clubID", width: 120, title: "Club", optionDataSource: isc.Shared.brewClubsDS, optionCriteria: {active: "Y"}, displayField: "clubAbbr", valueField: "clubID", pickListWidth: 300, pickListProperties: {showFilterEditor: true}, pickListFields: [{name: "clubAbbr", width: "70"},{name: "clubName", width: "*"}]},
			{name: "beerStyle", width: 300, validators: [{type: "lengthRange", max: 100}]},
			{name: "beerName", width: "*", validators: [{type: "lengthRange", max: 100}]},
			{name: "brewerName", width: 300, validators: [{type: "lengthRange", max: 100}]},
			{name: "abv", title: "ABV", width: 80, type: "float"},
			{name: "votes", width: 80, type: "integer", editorType: "spinner"},
			{name: "beerStory", width: 300, validators: [{type: "lengthRange", max: 1000}], detail: true},
			{name: "lastChangeDate", width: 100, detail: true}
		]
	});
	this.EventBeerLG = isc.myListGrid.create({
		dataSource: this.EventBeerDS,
		initialSort: [{property: "dueDate", direction: "ascending"}],
		name: "Beer list",
		parent: this,
		showFilterEditor: true,
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
		callingListGrid: this.EventBeerLG,
		parent: this
	});
	this.addItem(isc.myVLayout.create({members: [this.EventBeerLG]}));
	this.EventBeerLG.canEdit = checkPerms(this.getClassName() + ".js");
  }
});
