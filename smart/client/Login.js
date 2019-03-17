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
				{name: "user_name", type: "text", width: 150},
				{name: "password", type: "text", width: 150}
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
		var newCriteria;
		if(formData.user_name > ""){
			newCriteria = isc.addProperties({}, {operationType: "fetch", password: formData.password, user_name: formData.user_name}); this.LoginDS.addData(newCriteria, {target: this, methodName: "submitData_callback"});
		} else{
			isc.warn("A username usually a good iden when wanting to log into things. Or not. I don't really care. You can do it your way if you want.");
		}
	},
	submitData_callback: function(rpcResponse){
		var userData = rpcResponse.data[0];
		if(userData === undefined){
			isc.warn("So in theory that should have worked but one of us did something wrong. Probably it was you.");
		} else {
			isc.userData = userData;
			// this.destroy();
		}
		RPCManager.sendRequest({
			clientContext: 'login',
			useStrictJSON: true,
			params: {operationType: 'fetch', userID: userData.secUserID},
			callback: {target: this, methodName: "sendRequest_callback"},
			actionURL: serverPath + "Pages.php"
		});
	},
	sendRequest_callback: function(rpcResponse){
		var json = JSON.parse(rpcResponse.data);
		var pages = [];
		for(var i = 0; i < json.length; i++){
			var obj = json[i];
			for (var key in obj){
				pages.push(obj[key]);
			}
		}
        isc.userPages = isc.addProperties({}, pages);
		this.destroy();
	}
});
