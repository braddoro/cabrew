isc.defineClass("MemberNotes", "myWindow").addProperties({
  initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.MemberNotesDS = isc.myDataSource.create({
	  dataURL: "MemberNotes.php",
	  showFilterEditor: true,
	  fields:[
		{name: "memberNoteID", primaryKey: true, detail: true, type: "sequence"},
		{name: "memberID_fk", detail: true},
		{name: "noteTypeID_fk", title: "Type", optionDataSource: isc.Shared.noteTypesDS, displayField: "noteType", valueField: "noteTypeID"},
		{name: "noteDate"},
		{name: "memberNote"},
		{name: "lastChangeDate", detail: true}
	  ]
	});
	this.MemberNotesLG = isc.myListGrid.create({dataSource: this.MemberNotesDS});
	this.MemberNotesVL = isc.myVLayout.create({members: [this.MemberNotesLG]});
	this.addItem(this.MemberNotesVL);
	this.MemberNotesLG.fetchData({memberID: initData.memberID});
  }
});
