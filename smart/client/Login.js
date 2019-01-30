isc.defineClass("Login", "myWindow").addProperties({
	title: "Login",
	autoCenter: true,
	showHeader: false,
	height: 100,
	width: 300,
	margin: 1,
	isModal: true,
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.LoginDS = isc.myDataSource.create({
			dataURL: serverPath + "Login.php",
			fields:[
				{name: "USER_NAME", type: "text", width: 150},
				{name: "PASSWORD", type: "text", width: 150}
			]
		});
		this.LoginDF = isc.myDynamicForm.create({
			parent: this,
			dataSource: this.LoginDS
		});
		this.SubmitBT = isc.myIButton.create({
			parent: this,
			title: "Submit",
			align: "center",
			click: function(){
				this.parent.submitData();
			}
		});
		this.LoginVL = isc.myVLayout.create({members: [this.LoginDF, this.SubmitBT]});
		this.addItem(this.LoginVL);
	},
	submitData: function(){
		var formData = this.LoginDF.getValues();
		if(formData.USER_NAME > ""){
			this.LoginDS.addData(formData,{target: this, methodName: "submitData_callback"});
		} else{
			isc.warn("A username is necessary.");
		}
	},
	submitData_callback: function(rpcResponse){
		var userData = rpcResponse.data[0];
		if(userData === undefined){
			isc.warn("Improper Credentials");
		} else {
			isc.userData = userData;
			this.destroy();
		}
	}
});
