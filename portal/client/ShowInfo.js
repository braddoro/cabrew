isc.defineClass("ShowInfo", "myWindow").addProperties({
	autoCenter: true,
	showHeader: false,
	border: "0px solid black",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.ShowInfoLabel = isc.Label.create({
			margin: 10,
			autoDraw: false,
			height: "100%",
			width: "100%",
			align: "center",
			valign: "center",
			baseStyle: "font-family: monospace;font-size: 10px;"
		});
		this.ShowInfoVL = isc.myVLayout.create({members: [this.ShowInfoLabel]});
		this.addItem(this.ShowInfoVL);
		this.ShowInfoLabel.contents = initData.info;
	}
});
