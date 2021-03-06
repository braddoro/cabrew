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
			dataSource: this.LibraryBooksDS,
			name: "Library Books",
			parent: this,
			showFilterEditor: true
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.LibraryBooksLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.LibraryBooksLG]}));
		this.LibraryBooksLG.canEdit = checkPerms(this.getClassName() + ".js");
  	}
});
