isc.defineClass("LibraryLoans", "myWindow").addProperties({
	title: "Library Books",
	baseTitle: "Library Books",
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.LibraryLoansDS = isc.myDataSource.create({
		dataURL: serverPath + "LibraryLoans.php",
		fields:[
			{name: "loanID", primaryKey: true, detail: true, type: "sequence", width: 100},
			{name: "memberID", detail: true, type: "integer", width: 100},
			{name: "firstName", width: 120},
			{name: "lastName", width: 120},
			{name: "requestDate", width: 120, type: "date"},
			{name: "loanDate", width: 120, type: "date"},
			{name: "returnDate", width: 120, type: "date"},
			{name: "title", width: "*"},
			{name: "lastChangeDate", width: 150, detail: true}
		]
	});
	this.LibraryLoansLG = isc.myListGrid.create({
		parent: this,
		dataSource: this.LibraryLoansDS,
		showFilterEditor: true,
		rowContextClick: function(record, rowNum, colNum){
			this.parent.localContextMenu.showContextMenu();
			return false;
		}
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.LibraryLoansLG
	});
	this.LibraryLoansVL = isc.myVLayout.create({members: [this.LibraryLoansLG]});
	this.addItem(this.LibraryLoansVL);
  }
});
