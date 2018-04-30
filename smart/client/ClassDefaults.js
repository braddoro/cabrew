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
	resized: function(){
		// console.log("Title.: " + this.title);
		// console.log("Width.: " + this.width);
		// console.log("Height: " + this.height);
		// console.log("Left..: " + this.left);
		// console.log("Top...: " + this.top);
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
	dataProtocol: "postParams",
	dataFormat: "json",
	transformRequest: function(dsRequest){
		var superClassArguments = this.Super("transformRequest", dsRequest);
		var newProperties = {operationType: dsRequest.operationType};
		return isc.addProperties({}, superClassArguments, newProperties);
	},
	transformResponse: function(dsResponse, dsRequest, data){
		var status = isc.RPCResponse.STATUS_SUCCESS;
		var title = "";
		var error = "";
		var newResponse;
		var message = "";

		if(dsResponse.httpResponseCode &&
			dsResponse.httpResponseCode < 200 &&
			dsResponse.httpResponseCode > 299){
			status = dsResponse.httpResponseCode;
		}
		if(dsResponse.status &&
			dsResponse.status !== isc.RPCResponse.STATUS_SUCCESS){
			status = dsResponse.status;
		}
		if(status === isc.RPCResponse.STATUS_SUCCESS &&
			data.status &&
			data.status !== isc.RPCResponse.STATUS_SUCCESS){
			status = data.status;
		}

		title = errorTitle(status);

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
	leaveScrollbarGap: false,
	showFilterEditor: false,
	showAllRecords: true,
	autoFetchData: true,
	modalEditing: true,
	autoFitWidth: true,
	rowContextClick: function(record, rowNum, colNum){
		this.parent.localContextMenu.showContextMenu();
		return false;
	},
	recordClick: function(viewer, record, recordNum, field, fieldNum, value, rawValue){
		var selected = viewer.getSelectedRecords();
		var count = selected.length;
		var single = 1;
		var name = "";
		var title = "";
		if (viewer.name) {
			name = viewer.name;
		}
		if(count > single){
			title = name + " : Selected Rows - " + count;
		}else{
			title = name + " : Total Rows - " + this.getTotalRows();
		}
		viewer.parent.setTitle(title);
	},
	doubleClick: function(){
		if(this.getTotalRows() > 0){

		} else{
			this.startEditingNew();
		}
		return true;
	},
	rowDoubleClick: function(record, recordNum, fieldNum, keyboardGenerated) {
		this.startEditing(recordNum);
	},
	updateStatus: function() {
		if(this.name) {
			this.parent.setTitle(this.name + " : Total Rows - " + this.getTotalRows());
		}else{
			this.parent.setTitle("Total Rows - " + this.getTotalRows());
		}
		this.focus();
	},
	dataArrived: function(){
		this.updateStatus();
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
