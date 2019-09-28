isc.defineClass("BJCP2015Categories", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BJCP2015CategoriesLG = isc.myListGrid.create({
			parent: this,
			name: "BJCP 2015 Styles",
			showFilterEditor: true,
			dataSource: isc.Shared.BJCP2015CategoriesDS,
			initialSort: [{property: "bjcp2015_category", direction: "ascending"}]
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.BJCP2015CategoriesLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.BJCP2015CategoriesLG]}));
		this.BJCP2015CategoriesLG.canEdit = checkPerms(this.getClassName() + ".js");
  	}
});
