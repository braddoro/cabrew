isc.defineClass("Navigation", "Menu").addProperties({
	initWidget: function(initData){
		this.AccessMenu = isc.myMenu.create({
			title: "Access Security",
			items: [
				{title: "Users", click: "isc.Users.create({title: 'Users'});"},
				{title: "Items", click: "isc.Items.create({title: 'Items'});"},
				{title: "Groups", click: "isc.Groups.create({title: 'Groups'});"},
				{isSeparator: true},
				{title: "User Groups", click: "isc.UserGroups.create({title: 'User Groups'});"},
				{title: "Item Groups", click: "isc.ItemGroups.create({title: 'Item Groups'});"}
			]
		});
		this.MainMenu = isc.myMenu.create({
			title: "...",
			showShadow: true,
			items: [
				{title: "Access", submenu: this.AccessMenu}
			]
		});
		this.menuBar = isc.MenuBar.create({
			height: 32,
			width: 32,
			menus: [this.MainMenu]
		});
	}
});
