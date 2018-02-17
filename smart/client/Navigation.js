isc.defineClass("Navigation", "Menu").addProperties({
	initWidget: function(initData){
		this.membersMenu = isc.myMenu.create({
			title: "Members",
			items: [
				{title: "By Status", click: "isc.MemberStatus.create({width: 800, height: \"95%\"})"},
				{title: "By Date", click: "isc.MemberDates.create({hideNames: false, autoFetch: false})"},
				{title: "By Points", click: "isc.MemberPoints.create()"},
				{isSeparator: true},
				{title: "Add Date", click: "isc.AddEvent.create({width: 300, height: \"95%\", title: \"Add Date\"})"},
				{title: "Add Payment", click: "isc.AddPayment.create({width: 800, height: 275})"},
				{title: "Send Message", click: "isc.SendMessage.create({width: 800, height: \"95%\"})"}
			]
		});
		this.BookMenu = isc.myMenu.create({
			title: "Books",
			items: [
				{title: "Books", click: "isc.LibraryBooks.create({width: \"95%\", height: \"95%\"})"},
				{title: "Loans", click: "isc.LibraryLoans.create({width: 800, height: 400})"},
			]
		});
		this.AffiliatesMenu = isc.myMenu.create({
			title: "Affiliates",
			items: [
				{title: "Clubs", click: "isc.BrewClubs.create()"},
				{title: "Corporations", click: "isc.Corporations.create()"}
			]
		});
		this.MainMenu = isc.myMenu.create({
			title: "...",
			showShadow: true,
			items: [
//				{title: "Member Detail", click: "isc.MemberDetails.create({width: 800, height: \"95%\"})"},
				{title: "Members", submenu: this.membersMenu},
				{title: "Books", submenu: this.BookMenu},
				{isSeparator: true},
				{title: "Affiliate", submenu: this.AffiliatesMenu}
			]
		});
		this.menuBar = isc.MenuBar.create({
			menus: [this.MainMenu]
		});
	}
});
