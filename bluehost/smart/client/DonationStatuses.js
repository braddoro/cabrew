isc.defineClass("DonationStatuses", "myWindow").addProperties({
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.DonationStatusesLG = isc.myListGrid.create({
			dataSource: isc.Shared.donationStatusDS,
			initialSort: [{property: "donationStatus", direction: "ascending"}],
			name: "Donation Statuses",
			parent: this
		});
		this.localContextMenu = isc.myContextMenu.create({
			callingListGrid: this.DonationStatusesLG,
			parent: this
		});
		this.addItem(isc.myVLayout.create({members: [this.DonationStatusesLG]}));
		this.DonationStatusesLG.canEdit = checkPerms(this.getClassName() + ".js");
	}
});
