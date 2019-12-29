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
		this.BookMenu = isc.myMenu.create({
			title: "Books",
			items: [
				{title: "Books", click: "isc.LibraryBooks.create({width: \"95%\", height: \"95%\"});"},
				{title: "Loans", click: "isc.LibraryLoans.create({width: 800, height: 400});"}
			]
		});
		this.ClubMenu = isc.myMenu.create({
			title: "Entities",
			items: [
				{title: "Clubs", click: "isc.BrewClubs.create({width: \"800\", height: \"66%\"});"},
				{title: "Corporations", click: "isc.Corporations.create({width: \"95%\", height: \"95%\"});"},
				{title: "Donation Touches", click: "isc.	.create({width: \"95%\", height: \"95%\"});"},
				{title: "Donor List", click: "isc.CorporateDonations.create({width: \"1000\", height: \"95%\"});"},
				{title: "Entity Names", click: "isc.EntityNames.create({width: \"800\", height: \"95%\"})"},
				{title: "Search", click: "isc.ClubSearch.create({width: \"95%\", height: \"95%\"});"}
			]
		});
		this.EventMenu = isc.myMenu.create({
			title: "Events",
			items: [
				{title: "Budgets", click: "isc.EventBudgets.create({width: \"1000\", height: \"95%\"});"},
				{title: "Donations", click: "isc.CorporateDonationItems.create({width: \"1000\", height: \"95%\"});"},
				{title: "Kegs", click: "isc.EventBeers.create({width: \"1000\", height: \"95%\"});"},
				{title: "Plans", click: "isc.EventPlans.create({width: \"95%\", height: \"95%\"});"},
				{title: "Posts", click: "isc.WebPosts.create({width: \"95%\", height: \"95%\"});"},
				{title: "Schedules", click: "isc.EventSchedules.create({width: 700, height: \"95%\"});"},
				{title: "Teams", click: "isc.EventTeams.create({width: 750, height: \"95%\"});"}
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
			]
		});
		this.MiscMenu = isc.myMenu.create({
			title: "Misc Tables",
			items: [
				{title: "BJCP 2015 Categories", click: "isc.BJCP2015Categories.create({width: \"95%\", height: \"95%\"})"},
				{title: "BJCP 2015 Styles", click: "isc.BJCP2015Styles.create({width: 650, height: \"95%\"})"},
				{title: "Budget Actions", click: "isc.BudgetActions.create()"},
				{title: "Chairs", click: "isc.ChairTypes.create()"},
				{title: "Contacts", click: "isc.ContactTypes.create()"},
				{title: "Dates", click: "isc.DateTypes.create()"},
				{title: "Donations", click: "isc.DonationStatuses.create()"},
				{title: "Events", click: "isc.EventTypes.create()"},
				{title: "Notes", click: "isc.NoteTypes.create()"},
				{title: "Phases", click: "isc.EventPhases.create()"},
				{title: "Status", click: "isc.StatusTypes.create()"},
				{title: "Teams", click: "isc.EventTeamNames.create()"}
			]
		});
		this.MainMenu = isc.myMenu.create({
			title: "...",
			showShadow: true,
			items: [
				{title: "Books", submenu: this.BookMenu},
				{title: "Entities", submenu: this.ClubMenu},
				{title: "Events", submenu: this.EventMenu},
				{title: "Members", submenu: this.MembersMenu},
				{isSeparator: true},
				{title: "Access", submenu: this.AccessMenu},
				{title: "Audit Log", click: "isc.ShowLog.create({width: 1200, height: \"95%\"})"},
				{title: "Misc Tables", submenu: this.MiscMenu},
			]
		});
		this.menuBar = isc.MenuBar.create({
			height: 16,
			width: 16,
			menus: [this.MainMenu]
		});
	}
});
