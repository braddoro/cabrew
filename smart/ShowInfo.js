isc.defineClass("ShowInfo", "myWindow").addProperties({
	autoCenter: true,
	initWidget: function(initData){
	this.Super("initWidget", arguments);
	this.ShowInfoLabel = isc.Label.create({
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
