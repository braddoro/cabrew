function copyValues(stringIn){
	var stringOut = "";
	for(var key in stringIn) {
		if (stringIn.hasOwnProperty) {
			let value = stringIn[key];
			if (typeof value !== "undefined" && typeof key !== "undefined") {
				stringOut += key + ": " + value + " - " + typeof(value) + "<br/>";
			}
		}
	}
	return stringOut;
}
function errorTitle(code) {
	if(code === isc.RPCResponse.STATUS_SUCCESS){ // 0
		return "Success";
	}
	if(code === isc.RPCResponse.STATUS_OFFLINE){ // 1
		return "Offline";
	}
	if(code === isc.RPCResponse.STATUS_FAILURE){ // -1
		return "Failure";
	}
	if(code === isc.RPCResponse.STATUS_AUTHORIZATION_FAILURE){ // -3
		return "Authorization Failure";
	}
	if(code === isc.RPCResponse.STATUS_VALIDATION_ERROR){ // -4
		return "Validation Error";
	}
	if(code === isc.RPCResponse.STATUS_LOGIN_INCORRECT){ // -5
		return "Login Incorrect";
	}
	if(code === isc.RPCResponse.STATUS_MAX_LOGIN_ATTEMPTS_EXCEEDED){ // -6
		return "Max Login Attempts Exceeded";
	}
	if(code === isc.RPCResponse.STATUS_LOGIN_REQUIRED){ // -7
		return "Login Required";
	}
	if(code === isc.RPCResponse.STATUS_LOGIN_SUCCESS){ // -8
		return "Login Success";
	}
	if(code === isc.RPCResponse.STATUS_LOGIN_SUCCESS){ // -9
		return "Update Without PK Error";
	}
	if(code === isc.RPCResponse.STATUS_TRANSACTION_FAILED){ // -10
		return "Transaction Failed";
	}
	if(code === isc.RPCResponse.STATUS_MAX_FILE_SIZE_EXCEEDED){ // -11
		return "Max File Size Exceeded";
	}
	if(code === isc.RPCResponse.STATUS_MAX_POST_SIZE_EXCEEDED){ // -12
		return "Max Post Size Exceeded";
	}
	if(code === isc.RPCResponse.STATUS_FILE_REQUIRED_ERROR){ // -15
		return "File Required Error";
	}
	if(code === isc.RPCResponse.INVALID_RESPONSE_FORMAT){ // -16
		return "Invalid Response Format";
	}
	if(code === isc.RPCResponse.STATUS_TRANSPORT_ERROR){ // -90
		return "Transport Error";
	}
	if(code === isc.RPCResponse.STATUS_UNKNOWN_HOST_ERROR){ // -91
		return "Unknown Host Error";
	}
	if(code === isc.RPCResponse.STATUS_CONNECTION_RESET_ERROR){ // -92
		return "Connection Reset Error";
	}
	if(code === isc.RPCResponse.STATUS_SERVER_TIMEOUT){ // -100
		return "Server Timeout";
	}
	if(code === isc.RPCResponse.STATUS_ERROR_DATA_ACCESS){ // -110
		return "General Data Access Error";
	}
	if(code === isc.RPCResponse.STATUS_SERVER_CONNECTION_ERROR){ // -111
		return "Server Connection Error";
	}
	if(code === isc.RPCResponse.STATUS_SETUP_DATA_ERROR){ // -112
		return "Server Setup Error";
	}
	title = "Unknown Error Type";
    return title;
}
