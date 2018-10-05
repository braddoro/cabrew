isc.defineClass("Navigation", "Menu").addProperties({
	initWidget: function(initData){
		this.MembersMenu = isc.myMenu.create({
			title: "Members",
			items: [
				{title: "Name Search", click: "isc.MemberSearch.create({width: 400, height: \"95%\"});"},
				{title: "Points", click: "isc.MemberPoints.create({width: 900, height: 300});"},
				{title: "History", click: "isc.MemberHistory.create({width: 900, height: 300});"},
				{isSeparator: true},
				{title: "Add Date", click: "isc.AddEvent.create({width: 300, height: \"95%\", title: \"Add Date\"});"},
				{title: "Add Payment", click: "isc.AddPayment.create({width: 800, height: 275});"},
				{title: "Send Message", click: "isc.SendMessage.create({width: 800, height: \"95%\"});"}
			]
		});
		this.EventMenu = isc.myMenu.create({
			title: "Events",
			items: [
				{title: "Event Scheduling", click: "isc.EventSchedules.create({width: \"95%\", height: \"95%\"});"},
				{title: "Event Steps", click: "isc.EventSteps.create({width: \"95%\", height: \"95%\"});"},
				{title: "Event Teams", click: "isc.EventTeams.create({width: 750, height: \"95%\"});"},
				{title: "Beer List", click: "isc.BeerList.create({width: \"95%\", height: \"95%\"});"},
				{title: "Web Posts", click: "isc.WebPosts.create({width: \"95%\", height: \"95%\"});"}
			]
		});
		this.BookMenu = isc.myMenu.create({
			title: "Books",
			items: [
				{title: "Books", click: "isc.LibraryBooks.create({width: \"95%\", height: \"95%\"});"},
				{title: "Loans", click: "isc.LibraryLoans.create({width: 800, height: 400});"}
			]
		});
		this.ClubMenu = isc.myMenu.create({
			title: "Clubs",
			items: [
				{title: "Club Search", click: "isc.ClubSearch.create({width: \"95%\", height: \"95%\"});"},
				{title: "Clubs", click: "isc.BrewClubs.create({width: \"800\", height: \"66%\"});"},
				{title: "Corporations", click: "isc.Corporations.create({width: \"95%\", height: \"95%\"});"}
			]
		});
		this.MiscMenu = isc.myMenu.create({
			title: "Misc Tables",
			items: [
				{title: "Chair Types", click: "isc.ChairTypes.create()"},
				{title: "Contact Types", click: "isc.ContactTypes.create()"},
				{title: "Date Types", click: "isc.DateTypes.create()"},
				{title: "Event Team Names", click: "isc.EventTeamNames.create()"},
				{title: "Event Types", click: "isc.EventTypes.create()"},
				{title: "Status Types", click: "isc.StatusTypes.create()"}
			]
		});
		this.MainMenu = isc.myMenu.create({
			title: "...",
			showShadow: true,
			items: [
				{title: "Members", submenu: this.MembersMenu},
				{title: "Events", submenu: this.EventMenu},
				{title: "Books", submenu: this.BookMenu},
				{title: "Clubs", submenu: this.ClubMenu},
				{isSeparator: true},
				{title: "Misc Tables", submenu: this.MiscMenu}
			]
		});
		this.menuBar = isc.MenuBar.create({
			menus: [this.MainMenu]
		});
	}
});
