isc.defineClass("UserStories", "myWindow").addProperties({
	title: "User Stories",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.UserStoriesDS = isc.myDataSource.create({
			dataURL: "UserStories.php",
			fields:[
				{name: "storyID", primaryKey: true, type: "sequence", detail: true, canEdit: false},
				{name: "author", width: 80},
				{name: "storyName", width: 150},
				{name: "role", width: "25%", title: "As a"},
				{name: "something", width: "25%", title: "I want"},
				{name: "benefit", width: "25%", title: "So that"},
				{name: "lastChangedDate", width: 120, canEdit: false}
			]
		});
		this.UserStoriesLG = isc.myListGrid.create({
			parent: this,
			showFilterEditor: true,
			dataSource: this.UserStoriesDS,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			},
			rowDoubleClick: function(record, recordNum, fieldNum, keyboardGenerated) {
				this.startEditing(recordNum);
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.UserStoriesLG
		});
		this.addItem(isc.myVLayout.create({members: [this.UserStoriesLG]}));
	}
});
