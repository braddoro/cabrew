isc.defineClass("Desktop", "Canvas").addProperties({
	initWidget: function (initData) {
		this.Super("initWidget", initData);
		this.deskMenu = isc.Navigation.create();
		this.addMethods(this.deskMenu);
		// isc.ShowInfo.create({title: "Git Branch Info", info: initData.data, width: "33%"});
		// isc.Users.create();
		// isc.Items.create();
		// isc.Groups.create();
		// isc.UserGroups.create();
		// isc.ItemGroups.create();
	}
});
