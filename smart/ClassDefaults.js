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
	height: "40%",
	width: "60%",
	left: 25,
	top: 25
});

isc.defineClass("myVLayout", "VLayout").addProperties({
	height: "100%"
});

isc.defineClass("myDataSource", "DataSource").addProperties({
	dataProtocol: "postParams",
	dataFormat: "json",
	autoFetchData: true,
	showPrompt: true,
	transformRequest: function(dsRequest){
		var superClassArguments = this.Super("transformRequest", dsRequest);
		var newProperties = {operationType: dsRequest.operationType};
		return isc.addProperties({}, superClassArguments, newProperties);
	},
	transformResponse: function(dsResponse, dsRequest, data){
		var newResponse;
		var status = (data.status) ? data.status : isc.RPCResponse.STATUS_SUCCESS;
		var title = errorTitle(status);
		if(status === isc.RPCResponse.STATUS_SUCCESS){
			newResponse = dsResponse;
			isc.addProperties({}, newResponse, {willHandleError: false});
		}else{
			isc.warn(data.errorMessage, null, {title: title});
			newResponse = {
				status: status,
				willHandleError: false,
				errorMessage: (data.errorMessage) ? data.errorMessage : "A bad thing happened. It was probably your fault. Go outside and play.",
				clientContext: dsRequest.clientContext,
				httpResponseCode: dsResponse.httpResponseCode
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
	autoFetchData: true
});

isc.defineClass("myDynamicForm", "DynamicForm").addProperties({

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

