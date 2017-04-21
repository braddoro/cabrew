isc.defineClass("Navigation", "Menu").addProperties({
	initWidget: function(initData){
		this.membersMenu = isc.myMenu.create({
			title: "Members",
			items: [
				{title: "Members By Status", click: "isc.MemberStatus.create({width: 750})"},
				{title: "Members By Date", click: "isc.MemberDates.create()"},
				{title: "Members By Points", click: "isc.MemberPoints.create()"}
			]
		});
		this.clubsMenu = isc.myMenu.create({
			title: "Brew Clubs",
			items: [
				{title: "Clubs", click: "isc.BrewClubs.create()"},
				{title: "Club Media", click: "isc.BrewMedia.create()"},
				{title: "Club Attendence", click: "isc.BrewAttendence.create()"},
				{title: "Contacts", click: "isc.BrewContacts.create()"},
				{title: "Contact Points", click: "isc.BrewContactPoints.create()"}
			]
		});
		this.mainMenu = isc.myMenu.create({
			title: "...",
			showShadow: true,
			items: [
				{title: "Members", submenu: this.membersMenu},
				{title: "Clubs", submenu: this.clubsMenu}
				//,{title: "Testing", click: "isc.TestData.create({title: "Testing"})"}
			]
		});
		this.menuBar = isc.MenuBar.create({
			menus: [this.mainMenu]
		});
	}
});
