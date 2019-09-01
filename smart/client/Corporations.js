isc.defineClass("Corporations", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.CorporationsDS = isc.myDataSource.create({
			dataURL: serverPath + "Corporations.php",
			showFilterEditor: true,
			fields:[
				{name: "corporationID", primaryKey: true, type: "sequence", detail: true},
				{name: "name"},
				{name: "contact", width: 120},
				{name: "owner", width: 50, editorType: "selectItem", valueMap: {"Yes":"Yes","No":"No"}},
				{name: "type", width: 120},
				{name: "phone", width: 100},
				{name: "email"},
				{name: "website",
					formatCellValue: function (value) {
						var formatted;
						if (value) {
							formatted = "<a href='" + value + "' target='_blank'>" + value + "</a>";
						}
						return formatted;
					}
				},
				{name: "address"}
			]
		});
		this.CorporationsLG = isc.myListGrid.create({
			dataSource: this.CorporationsDS,
			name: "Corporations",
			parent: this
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.CorporationsLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.CorporationsLG]}));
		this.CorporationsLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
