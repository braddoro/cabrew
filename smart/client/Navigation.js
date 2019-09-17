isc.defineClass("Navigation", "Menu").addProperties({
	initWidget: function(initData){
		this.AccessMenu = isc.myMenu.create({
			title: "Access Security",
			items: [
				{title: "Users", click: "isc.Users.create({title: 'Users', left: isc.Math.random(340), top: isc.Math.random(240), height: 300, width: 550});"},
				{title: "Items", click: "isc.Items.create({title: 'Items', left: isc.Math.random(340), top: isc.Math.random(240), height: \"80%\", width: 500});"},
				{title: "Groups", click: "isc.Groups.create({title: 'Groups', left: isc.Math.random(340), top: isc.Math.random(240), height: 300, width: 400});"},
				{isSeparator: true},
				{title: "User Groups", click: "isc.UserGroups.create({title: 'User Groups', left: isc.Math.random(340), top: isc.Math.random(240), height: 300, width: 400});"},
				{title: "User Date Types", click: "isc.UserDateTypes.create({left: isc.Math.random(340), top: isc.Math.random(240), height: 300, width: 400});"},
				{title: "Item Groups", click: "isc.ItemGroups.create({title: 'Item Groups', left: isc.Math.random(340), top: isc.Math.random(240), height: \"90%\", width: 400});"}
			]
		});
		this.MembersMenu = isc.myMenu.create({
			title: "Members",
			items: [
				{title: "History", click: "isc.MemberHistory.create({width: 900, height: 300});"},
				{title: "Points", click: "isc.MemberPoints.create({width: 900, height: 300});"},
				{title: "Search", click: "isc.MemberSearch.create({width: 600, height: \"95%\"});"},
				{isSeparator: true},
				{title: "Add Date", click: "isc.AddEvent.create({width: 300, height: \"95%\", title: \"Add Date\"});"}
				// {title: "Add Payment", click: "isc.AddPayment.create({width: 800, height: 275});"}
				// {title: "Send Message", click: "isc.SendMessage.create({width: 800, height: \"95%\"});"}
			]
		});
		this.EventMenu = isc.myMenu.create({
			title: "Events",
			items: [
				{title: "Attendance", click: "isc.EventAttendance.create({width: \"95%\", height: \"95%\"});"},
				{title: "Beers", click: "isc.EventBeers.create({width: \"1000\", height: \"95%\"});"},
				{title: "Budgets", click: "isc.EventBudgets.create({width: \"1000\", height: \"95%\"});"},
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
				{title: "Clubs", click: "isc.BrewClubs.create({width: \"800\", height: \"66%\"});"},
				{title: "Corporations", click: "isc.Corporations.create({width: \"95%\", height: \"95%\"});"},
				{title: "Donations", click: "isc.CorporateDonations.create({width: \"1000\", height: \"95%\"});"},
				{title: "Search", click: "isc.ClubSearch.create({width: \"95%\", height: \"95%\"});"}
			]
		});
		this.MiscMenu = isc.myMenu.create({
			title: "Misc Tables",
			items: [
				{title: "Chairs", click: "isc.ChairTypes.create()"},
				{title: "Contacts", click: "isc.ContactTypes.create()"},
				{title: "Dates", click: "isc.DateTypes.create()"},
				{title: "EntityNames", click: "isc.EntityNames.create()"},
				{title: "Events", click: "isc.EventTypes.create()"},
				{title: "Notes", click: "isc.NoteTypes.create()"},
				{title: "Status", click: "isc.StatusTypes.create()"},
				{title: "Teams", click: "isc.EventTeamNames.create()"}
			]
		});
		this.MainMenu = isc.myMenu.create({
			title: "...",
			showShadow: true,
			items: [
				{title: "Books", submenu: this.BookMenu},
				{title: "Clubs", submenu: this.ClubMenu},
				{title: "Events", submenu: this.EventMenu},
				{title: "Members", submenu: this.MembersMenu},
				{title: "Misc Tables", submenu: this.MiscMenu},
				{title: "Access", submenu: this.AccessMenu},
				{isSeparator: true},
				{title: "Show Log", click: "isc.ShowLog.create({width: 1200, height: \"95%\"})"}
			]
		});
		this.menuBar = isc.MenuBar.create({
			height: 16,
			width: 16,
			menus: [this.MainMenu]
		});
	}
});
