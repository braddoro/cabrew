//isc.setAutoDraw(false);
isc.RPCResponse.STATUS_ERROR_DATA_ACCESS = -110;
isc.RPCResponse.STATUS_SERVER_CONNECTION_ERROR = -111;
isc.RPCResponse.STATUS_SETUP_DATA_ERROR = -112;

isc.defineClass("myWindow", "Window").addProperties({
	showMaximizeButton: true,
	canDragReposition: true,
	keepInParentRect: true,
	dismissOnEscape: false,
	canDragResize: true,
	edgeMarginSize:10,
	showShadow: true,
	height: "300",
	width: "485",
	title: "",
	left: 25,
	top: 25,
	mm_accessFail: "It's unfortunate, mostly for you, that you don't have clearance to view this page.",
	mm_badPassword: "So in theory that should have worked but one of us did something wrong. Probably it was you.",
	mm_missingUserName: "A username usually a good idea when wanting to log into things. Or not. I don't really care. You can do it your way if you want.",
	resized: function(){
		console.log("Title.: " + this.title);
		console.log("Width.: " + this.width);
		console.log("Height: " + this.height);
		console.log("Left..: " + this.left);
		console.log("Top...: " + this.top);
	},
	moved: function(){
		// console.log("Title.: " + this.title);
		// console.log("Width.: " + this.width);
		// console.log("Height: " + this.height);
		// console.log("Left..: " + this.left);
		// console.log("Top...: " + this.top);
	}
});

isc.defineClass("myVLayout", "VLayout").addProperties({
	height: "100%"
});
isc.defineClass("myHLayout", "HLayout").addProperties({
	//width: "99%"
});
isc.defineClass("myDataSource", "DataSource").addProperties({
	cacheAllData: true,
	cacheMaxAge: 86400,
	dataFormat: "json",
	dataProtocol: "postParams",
	transformRequest: function(dsRequest){
		var superClassArguments = this.Super("transformRequest", dsRequest);
		var userID = 0;
		if(typeof saveUserID !== 'undefined'){
			userID = saveUserID;
		}
		var newProperties = {operationType: dsRequest.operationType, userID: userID};
		return isc.addProperties({}, superClassArguments, newProperties);
	},
	transformResponse: function(dsResponse, dsRequest, data){
		var status = isc.RPCResponse.STATUS_SUCCESS;
		var title = "";
		var error = "";
		var newResponse;
		var message = "";

		if(dsResponse.httpResponseCode
			&& dsResponse.httpResponseCode < 200
			&& dsResponse.httpResponseCode > 299){
			status = dsResponse.httpResponseCode;
		}
		if(dsResponse.status
			&& dsResponse.status !== isc.RPCResponse.STATUS_SUCCESS){
			status = dsResponse.status;
		}
		if(status === isc.RPCResponse.STATUS_SUCCESS
			&& data.status
			&& data.status !== isc.RPCResponse.STATUS_SUCCESS){
			status = data.status;
		}

		title = status;
		title = "Response";

		if(dsResponse.errorMessage){
			error = dsResponse.errorMessage;
		}
		if(error === "" && data.errorMessage){
			error += data.errorMessage;
		}
		if(error === "" && dsResponse.httpResponseText){
			error += dsResponse.httpResponseText;
		}
		if(error === ""){
			error = title;
		}

		message = title + "\nError Code: " + status + "\n" + error;

		if(status === isc.RPCResponse.STATUS_SUCCESS){
			newResponse = dsResponse;
			isc.addProperties({}, newResponse, {willHandleError: true});
		}else{
			isc.warn(message, null, {title: title});
			newResponse = {
				status: status,
				willHandleError: true,
				data: message
			};
		}
		return this.Super("transformResponse", [newResponse, dsRequest, data]);
	}
});

isc.defineClass("myListGrid", "ListGrid").addProperties({
	alternateRecordStyles: true,
	autoFetchData: true,
	autoFitWidth: true,
	canEdit: true,
	leaveScrollbarGap: false,
	modalEditing: true,
	showAllRecords: true,
	showFilterEditor: false,
	rowContextClick: function(record, rowNum, colNum){
		this.parent.localContextMenu.showContextMenu();
		return false;
	},
	recordClick: function(viewer, record, recordNum, field, fieldNum, value, rawValue){
		this.updateStatus();
	},
	doubleClick: function(){
		if(this.getTotalRows() == 0 && this.canEdit){
			this.startEditingNew();
		}
		return true;
	},
	rowDoubleClick: function(record, recordNum, fieldNum, keyboardGenerated) {
		if(this.canEdit){
			this.startEditing(recordNum);
		}
	},
	updateStatus: function() {
		var name = this.name;
		var nameStr = "";
		var rows = this.getTotalRows();
		var rowsStr = "Total Rows - " + rows;
		var selected = this.getSelectedRecords();
		var single = 1;
		var state = this.canEdit;
		var stateStr = "";
		if(selected.length > single){
			rowsStr = "Selected Rows - " + selected.length;
		}
		if(!state){
			stateStr = "(read only)";
		}
		if(this.name){
			nameStr = this.name + " | ";
		}
		var title = nameStr + "" + rowsStr + " " + stateStr;
		// this.parent.setTitle(title);
		this.focus();
	},
	dataArrived: function(){
		// this.updateStatus();
	}
});

isc.defineClass("myDynamicForm", "DynamicForm").addProperties({
	validateOnChange: true
});

isc.defineClass("myMenu", "Menu").addProperties({
	showIcons: false,
	shadowDepth: 10,
	cellHeight: 16,
	width: 24
});

isc.defineClass("myLabel", "Label").addProperties({
	align: "left",
	baseStyle: "headerItem"
});

isc.defineClass("myIButton", "IButton").addProperties({
	autoFit: true
});
