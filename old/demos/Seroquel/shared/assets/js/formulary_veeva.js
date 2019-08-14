/*veeva:
veeva:getDataForObject(Object), fieldname(FIELDNAME), callback(result);
veeva:saveObject(<object API name>),value(<string>),callback(<function>)


Sync_Tracking_vod__c
Sync_Completed_Date_time_vod__c

*/

var runningInVeeva = ((location.hostname == "" || location.hostname.indexOf('veevamobile') > -1)) && (navigator.userAgent.indexOf("Mobile") > 0 || (navigator.userAgent.indexOf("Touch") > 0));

var isIREP = runningInVeeva; //legacy


function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
	return pattern.test(emailAddress);
};


function savedClickstream(result) {
    // result is a json object passed in by iRep media player
    divEle = document.getElementById("returned_result");
    divEle.innerHTML += "<br/> success: " + result.success;
    if (!result.success) {
        divEle.innerHTML += "<br/> error message: " + result.message;
    }
}

function saveClickStreamData(frm) {
    var clickStream = {};
    clickStream.Answer_vod__c = frm.fieldName.value
    clickStream.Question_vod__c = "What would make you prescribe Cholecap more often?"
    clickStream.Survey_Type_vod__c = "freetext"
    clickStream.Text_Entered_vod__c = "textarea"
    var myJSONText = JSON.stringify(clickStream);
    divEle = document.getElementById("returned_result");
    request = "veeva:saveObject(Call_Clickstream_vod__c),value(" + myJSONText + "),callback(savedClickstream)";
    divEle.innerHTML += "<br/> Request:<br/>" + request;
    document.location = request;
}

function getSyncDate() {
    divEle = document.getElementById("veeva_debug");
    request = "veeva:getDataForObject(Sync_Tracking_vod__c), fieldname(Sync_Completed_Date_time_vod__c), showSyncDate(result)";
    divEle.innerHTML = "Request:" + request;
    document.location = request;
    alert(request);
}

function showSyncDate(result) {
    alert(result);
    // result is a json object passed in by iRep media player
    divEle = document.getElementById("veeva_debug");
    divEle.innerHTML += "<br/> success: " + result.success;
    if (!result.success) {
        divEle.innerHTML += "<br/> error message: " + result.message;
    }
}
