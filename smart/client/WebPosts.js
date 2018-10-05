isc.defineClass("WebPosts", "myWindow").addProperties({
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.webPostsDS = isc.myDataSource.create({
		dataURL: serverPath + "WebPosts.php",
		fields:[
			{name: "webPostID", primaryKey: true, type: "sequence", canEdit: false},
			{name: "postName", type: "text", validators: [{type: "lengthRange", max: 45}]},
			{name: "postText", type: "richText", length: 10000},
			{name: "lastChangeDate", canEdit: false}
		]
	});
	this.webPostsLG = isc.myListGrid.create({
		parent: this,
		name: "Static Web Posts",
		width: 200,
		showHeader: false,
		canEdit: false,
		sortField: 1,
		dataSource: this.webPostsDS,
		fields:[
			{name: "webPostID", detail: true},
			{name: "postName", type: "text", width: "*"},
			{name: "postText", type: "richText", detail: true}
		],
		rowClick: function(record, recordNum, fieldNum) {
			this.parent.webPostsDF.setData([record]);
		}
	});
	this.localContextMenu = isc.myContextMenu.create({
		parent: this,
		callingListGrid: this.webPostsLG
	});
	this.webPostsDF = isc.myDynamicForm.create({
		parent: this,
		dataSource: this.webPosts,
		height: "100%",
		margin: 5,
		titleSuffix: "",
		fields: [
			{name: "webPostID", title: "", titleOrientation: "top", width: 50, type: "sequence", colSpan: 1, canEdit: false},
			{name: "postName",
				title: "",
				titleOrientation: "top",
				type: "text",
				colSpan: 1,
				width: 300,
				validators: [{type: "lengthRange", max: 45}]
			},
			{name: "postText",
				editorType: "richText",
				title: "",
				titleOrientation: "top",
				controlGroups:["fontControls", "formatControls", "styleControls", "colorControls", "bulletControls"],
				colSpan: 2,
				border: "2px solid black",
				width: "*",
				height: "*",
				valign: top
				}
			]
		});
		this.webPostsBT = isc.myIButton.create({
			parent: this,
			title: "Save",
			align: "center",
			click: function(){
				var newValues = this.parent.webPostsDF.getValues();
				var newData = {webPostID: newValues.webPostID, postName: newValues.postName, postText: newValues.postText};
				this.parent.webPostsDS.updateData(newData);
			}
		});
	this.webPostsDVL = isc.myVLayout.create({
		members: [this.webPostsDF, this.webPostsBT]
	});
	this.webPostsHL = isc.myHLayout.create({
		members: [this.webPostsLG, this.webPostsDVL]
	});
	this.addItem(this.webPostsHL);
  }
});
