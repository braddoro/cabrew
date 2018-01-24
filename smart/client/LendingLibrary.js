isc.defineClass("LendingLibrary", "myWindow").addProperties({
	title: "Lending Library",
	baseTitle: "Lending Library",
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.LendingLibraryDS = isc.myDataSource.create({
		dataURL: serverPath + "LendingLibrary.php",
		fields:[
			{name: "libraryID", primaryKey: true, detail: true, type: "sequence"},
			{name: "series", width: 150},
			{name: "title", width: 250},
			{name: "author", width: 300},
			{name: "copyright", type: "integer", width: 100},
			{name: "abstract"}
		]
	});
	this.LendingLibraryLG = isc.myListGrid.create({
		parent: this,
		dataSource: this.LendingLibraryDS,
		showFilterEditor: true,
		rowContextClick: function(record, rowNum, colNum){
			this.parent.localContextMenu.showContextMenu();
			return false;
		}
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.LendingLibraryLG
	});
	this.LendingLibraryVL = isc.myVLayout.create({members: [this.LendingLibraryLG]});
	this.addItem(this.LendingLibraryVL);
  }
});
