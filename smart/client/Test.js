isc.defineClass("Test", "myWindow").addProperties({
	title: "Test",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.TestDF = isc.myDynamicForm.create({
			parent: this
		});
		this.TestBT = isc.myIButton.create({
			parent: this,
			title: "Button",
			align: "center",
			click: function(){
				this.submitData();
			}
		});
		this.TestVL = isc.myVLayout.create({members: [
			this.TestDF,
			this.TestBT
		]});
		this.addItem(this.TestVL);
	},
	submitData: function(){
		isc.say("Foo",{title: "Foo."});
		//this.AddPaymentDS.addData(this.AddPaymentDF.getValues());
	}
});
