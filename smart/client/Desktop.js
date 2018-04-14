isc.defineClass("Desktop", "Canvas").addProperties({
	initWidget: function (initData) {
		this.Super("initWidget", initData);
		this.deskMenu = isc.Navigation.create();
		this.addMethods(this.deskMenu);
		isc.ShowInfo.create({title: "Git Branch Info", info: initData.gitInfo, width: "33%"});
		isc.MemberSearch.create({width: 450, height: "95%"})
	}
});
