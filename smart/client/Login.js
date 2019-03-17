isc.defineClass("Login", "myWindow").addProperties({
	autoCenter: true,
	height: 100,
	isModal: true,
	margin: 1,
	showHeader: false,
	title: "Login",
	width: 300,
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
		}else{
			isc.warn(this.mm_missingUserName);
		}
	},
	submitData_callback: function(rpcResponse){
		var userData = rpcResponse.data[0];
		// userData === undefined ||
		if(userData.secUserID === undefined){
			isc.warn(this.mm_badPassword);
		}else{
			isc.userData = userData;
			RPCManager.sendRequest({
				actionURL: serverPath + "Pages.php",
				callback: {target: this, methodName: "sendRequest_callback"},
				clientContext: 'login',
				params: {operationType: 'fetch', userID: userData.secUserID},
				useStrictJSON: true
			});
		}
	},
	sendRequest_callback: function(rpcResponse){
		var json = JSON.parse(rpcResponse.data);
		var pages = [];
		for(var i = 0; i < json.length; i++){
			var obj = json[i];
			for(var key in obj){
				pages.push(obj[key]);
			}
		}
        isc.userPages = isc.addProperties({}, pages);
		this.destroy();
	}
});
