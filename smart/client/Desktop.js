isc.defineClass("Desktop", "Canvas").addProperties({
	initWidget: function (initData) {
		this.Super("initWidget", initData);
		this.deskMenu = isc.Navigation.create();
		this.addMethods(this.deskMenu);
		isc.ShowInfo.create({title: "Git Branch Info", info: initData.gitInfo, width: "33%"});
		//isc.MemberStatus.create({width: 550, height: "95%"});
		//var record = {var1: 1, var2: 2};
		//isc.Preview.create({width: 550, height: "95%", title: "baz", data: record});
	}
});
