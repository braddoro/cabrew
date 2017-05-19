function copyValues(stringIn){
	var stringOut = "";
	for(var key in stringIn) {
		if (stringIn.hasOwnProperty) {
			let value = stringIn[key];
			if (typeof value !== "undefined" && typeof key !== "undefined") {
				stringOut += key +  ": " + value + " - " + typeof(value) + "<br/>";
			}
		}
	}
	return stringOut;
}
function errorTitle(code) {
	var title = "";
	switch(code) {
	case isc.RPCResponse.STATUS_SUCCESS: // 0
		title = "Success";
		break;
	case isc.RPCResponse.STATUS_OFFLINE: // 1
		title = "Offline";
		break;
	case isc.RPCResponse.STATUS_FAILURE: // -1
		title = "Failure";
		break;
	case isc.RPCResponse.STATUS_AUTHORIZATION_FAILURE: // -3
		title = "Authorization Failure";
		break;
	case isc.RPCResponse.STATUS_VALIDATION_ERROR: // -4
		title = "Status Validation Error";
		break;
	case isc.RPCResponse.STATUS_LOGIN_INCORRECT: // -5
		title = "Status Login Incorrect";
		break;
	case isc.RPCResponse.STATUS_MAX_LOGIN_ATTEMPTS_EXCEEDED: // -6
		title = "Status Max Login Attempts Exceeded";
		break;
	case isc.RPCResponse.STATUS_LOGIN_REQUIRED: // -7
		title = "Status Login Required";
		break;
	case isc.RPCResponse.STATUS_LOGIN_SUCCESS: // -8
		title = "Status Login Success";
		break;
	case isc.RPCResponse.STATUS_UPDATE_WITHOUT_PK_ERROR: // -9
		title = "Status Update Without PK Error";
		break;
	case isc.RPCResponse.STATUS_TRANSACTION_FAILED: // -10
		title = "Status Transaction Failed";
		break;
	case isc.RPCResponse.STATUS_MAX_FILE_SIZE_EXCEEDED: // -11
		title = "Status Max File Size Exceeded";
		break;
	case isc.RPCResponse.STATUS_MAX_POST_SIZE_EXCEEDED: // -12
		title = "Status Max Post Size Exceeded";
		break;
	case isc.RPCResponse.STATUS_FILE_REQUIRED_ERROR: // -15
		title = "Status File Required Error";
		break;
	case isc.RPCResponse.INVALID_RESPONSE_FORMAT: // -16
		title = "Invalid Response Format";
		break;
	case isc.RPCResponse.STATUS_TRANSPORT_ERROR: // -90
		title = "Status Transport Error";
		break;
	case isc.RPCResponse.STATUS_UNKNOWN_HOST_ERROR: // -91
		title = "Status Unknown Host Error";
		break;
	case isc.RPCResponse.STATUS_CONNECTION_RESET_ERROR: // -92
		title = "Status Connection Reset Error";
		break;
	case isc.RPCResponse.STATUS_SERVER_TIMEOUT: // -100
		title = "Status Server Timeout";
		break;
	case isc.RPCResponse.STATUS_ERROR_DATA_ACCESS: // -110
		title = "General Data Access Error";
		break;
	case isc.RPCResponse.STATUS_SERVER_CONNECTION_ERROR: // -111
		title = "Server Connection Error";
		break;
	case isc.RPCResponse.STATUS_SETUP_DATA_ERROR: // -112
		title = "Server Setup Error";
		break;
	default:
		title = "Unknown Error Type";
		break;
	}
    return title;
}
