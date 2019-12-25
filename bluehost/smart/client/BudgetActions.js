isc.defineClass("BudgetActions", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BudgetActionsLG = isc.myListGrid.create({
			dataSource: isc.Shared.budgetActionDS,
			name: "Budget Actions",
			parent: this
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.BudgetActionsLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.BudgetActionsLG]}));
		this.BudgetActionsLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
