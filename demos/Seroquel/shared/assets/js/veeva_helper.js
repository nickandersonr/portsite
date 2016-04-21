var runningInVeeva = ((location.hostname == "" || location.hostname.indexOf('veevamobile') > -1)) && (navigator.userAgent.indexOf("Mobile") > 0 || (navigator.userAgent.indexOf("Touch") > 0));


function Deferred() {
    try {
        this.resolve = null;
        this.reject = null;
        this.promise = new Promise(function (resolve, reject) {
            this.resolve = resolve;
            this.reject = reject;
        }.bind(this));
        Object.freeze(this);
    } catch (ex) {
        throw new Error('Promise/Deferred is not available');
    }
}




function apiValue(object, field, defaultValue) {
    this.object = object;
    this.field = field;
    this.defaultValue = defaultValue;
    this.deferred = new Deferred();
}

var veevaHelper = {};
veevaHelper.callStack = [];


veevaHelper.get = function (call) {
    
    veevaHelper.callStack.push(call);
    if (veevaHelper.callStack.length == 1) {
        veevaHelper.doCall();
    }
    return call.deferred.promise;
}

veevaHelper.doCall = function (result) {
    
    var theCall = veevaHelper.callStack[0];
    //Check to see if we have a result object so we know if this got called from a callback.
    if (result != undefined && result != null) {
        
        if (!result.success) {
     
            theCall.deferred.reject(result);
        } else {
             
            theCall.deferred.resolve(result);
            //theCall.promise = Promise.resolve(result);
          
        }
        //Remove the call from the stack.
        veevaHelper.callStack.splice(0, 1);
    }

    //Check to see if we have more calls to make!
    if (veevaHelper.callStack.length > 0) {
        var newCall = veevaHelper.callStack[0];
        //Check to see if this is in iREP from veeva_boilerplate
        if (runningInVeeva) {
            //If this is iRep then run the query!
            //Check here for "Current vs Object"
            setTimeout(function(){
                 com.veeva.clm.getDataForCurrentObject(newCall.object, newCall.field, veevaHelper.doCall);
            }, 1);
           
        } else {
            //Fake the results since this is not iRep
            var result = {}
            result.success = true;
            result[newCall.object] = {};
            result[newCall.object][newCall.field] = newCall.defaultValue;

            //Fire the call back by hand
            veevaHelper.doCall(result);
        }

    }
}