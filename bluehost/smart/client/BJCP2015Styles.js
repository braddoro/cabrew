isc.defineClass("BJCP2015Styles", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BJCP2015StylesLG = isc.myListGrid.create({
			parent: this,
			name: "BJCP 2015 Styles",
			showFilterEditor: true,
			dataSource: isc.Shared.BJCP2015StylesDS,
			initialSort: [{property: "bjcpCode", direction: "ascending"}]
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.BJCP2015StylesLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.BJCP2015StylesLG]}));
		this.BJCP2015StylesLG.canEdit = checkPerms(this.getClassName() + ".js");
  	}
});
