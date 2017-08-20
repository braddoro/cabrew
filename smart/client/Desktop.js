isc.defineClass("Desktop", "Canvas").addProperties({
	initWidget: function (initData) {
		this.Super("initWidget", arguments);
		this.deskMenu = isc.Navigation.create();
		this.addMethods(this.deskMenu);
		isc.ShowInfo.create({title: "Git Branch Info", info: initData.gitInfo, width: "33%"});
		//isc.MemberStatus.create({width: 550, height: "95%"});
		isc.MemberDetails.create({width: 800, height: "95%"});
	}
});
