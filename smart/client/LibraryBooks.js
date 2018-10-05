isc.defineClass("LibraryBooks", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.LibraryBooksDS = isc.myDataSource.create({
		dataURL: serverPath + "LibraryBooks.php",
		fields:[
			{name: "bookID", primaryKey: true, detail: true, type: "sequence"},
			{name: "series", width: 150},
			{name: "title", width: 250},
			{name: "author", width: 300},
			{name: "copyright", type: "integer", width: 100},
			{name: "abstract"}
		]
	});
	this.LibraryBooksLG = isc.myListGrid.create({
		name: "Library Books",
		parent: this,
		dataSource: this.LibraryBooksDS,
		showFilterEditor: true
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.LibraryBooksLG
	});
	this.addItem(isc.myVLayout.create({members: [this.LibraryBooksLG]}));
  }
});
