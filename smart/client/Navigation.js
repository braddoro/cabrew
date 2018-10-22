isc.defineClass("Navigation", "Menu").addProperties({
	initWidget: function(initData){
		this.MembersMenu = isc.myMenu.create({
			title: "Members",
			items: [
				{title: "Search", click: "isc.MemberSearch.create({width: 400, height: \"95%\"});"},
				{title: "Points", click: "isc.MemberPoints.create({width: 900, height: 300});"},
				{title: "History", click: "isc.MemberHistory.create({width: 900, height: 300});"},
				{isSeparator: true},
				{title: "Add Date", click: "isc.AddEvent.create({width: 300, height: \"95%\", title: \"Add Date\"});"}
				// {title: "Add Payment", click: "isc.AddPayment.create({width: 800, height: 275});"}
				// {title: "Send Message", click: "isc.SendMessage.create({width: 800, height: \"95%\"});"}
			]
		});
		this.EventMenu = isc.myMenu.create({
			title: "Events",
			items: [
				{title: "Beers", click: "isc.EventBeers.create({width: \"95%\", height: \"95%\"});"},
				{title: "Plans", click: "isc.EventPlans.create({width: \"95%\", height: \"95%\"});"},
				{title: "Posts", click: "isc.WebPosts.create({width: \"95%\", height: \"95%\"});"},
				{title: "Schedules", click: "isc.EventSchedules.create({width: 600, height: \"95%\"});"},
				{title: "Teams", click: "isc.EventTeams.create({width: 750, height: \"95%\"});"}
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
				{title: "Search", click: "isc.ClubSearch.create({width: \"95%\", height: \"95%\"});"},
				{title: "Clubs", click: "isc.BrewClubs.create({width: \"800\", height: \"66%\"});"},
				{title: "Corporations", click: "isc.Corporations.create({width: \"95%\", height: \"95%\"});"}
			]
		});
		this.MiscMenu = isc.myMenu.create({
			title: "Misc Tables",
			items: [
				{title: "Chairs", click: "isc.ChairTypes.create()"},
				{title: "Contacts", click: "isc.ContactTypes.create()"},
				{title: "Dates", click: "isc.DateTypes.create()"},
				{title: "Teams", click: "isc.EventTeamNames.create()"},
				{title: "Events", click: "isc.EventTypes.create()"},
				{title: "Notes", click: "isc.NoteTypes.create()"},
				{title: "Status", click: "isc.StatusTypes.create()"}
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
				{title: "Misc Tables", submenu: this.MiscMenu},
				{title: "Test Code", click: "isc.test.create({width: 800})"}
			]
		});
		this.menuBar = isc.MenuBar.create({
			height: 32,
			menus: [this.MainMenu]
		});
	}
});
