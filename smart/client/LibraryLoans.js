isc.defineClass("LibraryLoans", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.LibraryLoansDS = isc.myDataSource.create({
		dataURL: serverPath + "LibraryLoans.php",
		fields:[
			{name: "loanID", type: "sequence", primaryKey: true, width: 100, detail: true},
			{name: "memberID_fk",
				title: "Member",
				type: "text",
				width: 120,
				optionDataSource: isc.Shared.memberNamesDS,
				optionCriteria: {statusTypeID_fk: 1},
				displayField: "FullName",
				valueField: "memberID"
			},
			{name: "libraryID_fk",
				title: "Book",
				type: "text",
				width: "*",
				optionDataSource: isc.Shared.libraryBooksDS,
				displayField: "title",
				valueField: "bookID"
			},
			{name: "requestDate", width: 120, type: "date"},
			{name: "loanDate", width: 120, type: "date"},
			{name: "returnDate", width: 120, type: "date"},
			{name: "lastChangeDate", width: 150, detail: true}
		]
	});
	this.LibraryLoansLG = isc.myListGrid.create({
		dataSource: this.LibraryLoansDS,
		name: "Library Loans",
		parent: this,
		showFilterEditor: true,
		rowContextClick: function(record, rowNum, colNum){
			this.parent.localContextMenu.showContextMenu();
			return false;
		},
		recordDoubleClick: function(viewer, record, recordNum, field, fieldNum, value, rawValue){
			this.startEditing(recordNum);
		}
	});
	this.localContextMenu = isc.myContextMenu.create({
		callingListGrid: this.LibraryLoansLG,
		parent: this
	});
	this.LibraryLoansVL = isc.myVLayout.create({members: [this.LibraryLoansLG]});
	this.addItem(this.LibraryLoansVL);
  }
});
