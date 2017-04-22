isc.defineClass("Navigation", "Menu").addProperties({
	initWidget: function(initData){
		this.membersMenu = isc.myMenu.create({
			title: "Members",
			items: [
				{title: "Add Event", click: "isc.AddEvent.create({width: 300, height: \"95%\"})"},
				{isSeparator: true},
				{title: "By Status", click: "isc.MemberStatus.create({width: 750})"},
				{title: "By Date", click: "isc.MemberDates.create({hideNames: false, autoFetch: false})"},
				{title: "By Points", click: "isc.MemberPoints.create()"}
			]
		});
		this.AffiliatesMenu = isc.myMenu.create({
			title: "Affiliates",
			items: [
				{title: "Clubs", click: "isc.BrewClubs.create()"},
				{title: "Corporations", click: "isc.Corporations.create()"}
			]
		});
		this.mainMenu = isc.myMenu.create({
			title: "...",
			showShadow: true,
			items: [
				{title: "Members", submenu: this.membersMenu},
				{title: "Affiliate", submenu: this.AffiliatesMenu}
			]
		});
		this.menuBar = isc.MenuBar.create({
			menus: [this.mainMenu]
		});
	}
});
