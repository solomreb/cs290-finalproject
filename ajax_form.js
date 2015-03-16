
function CreateRequestObj () {
    var forceActiveX = (window.ActiveXObject && location.protocol === "file:");
    if (window.XMLHttpRequest && !forceActiveX) {
        return new XMLHttpRequest();
    }
    else {
        try {
            return new ActiveXObject("Microsoft.XMLHTTP");
        } catch(e) {}
    }
}

    // create HTTP request body from form data
function GetMessageBody (form) {
    var data = "";
    for (var i = 0; i < form.elements.length; i++) {
        var elem = form.elements[i];
        if (elem.name) {
            var nodeName = elem.nodeName.toLowerCase ();
            var type = elem.type ? elem.type.toLowerCase () : "";

                // if an input:checked or input:radio is not checked, skip it
            if (nodeName === "input" && (type === "checkbox" || type === "radio")) {
                if (!elem.checked) {
                    continue;
                }
            }

            var param = "";
                // select element is special, if no value is specified the text must be sent
            if (nodeName === "select") {
                for (var j = 0; j < elem.options.length; j++) {
                    var option = elem.options[j];
                    if (option.selected) {
                        var valueAttr = option.getAttributeNode ("value");
                        var value = (valueAttr && valueAttr.specified) ? option.value : option.text;
                        if (param != "") {
                            param += "&";
                        }
                        param += encodeURIComponent (elem.name) + "=" + encodeURIComponent (value);
                    }
                }
            }
            else {
                param = encodeURIComponent (elem.name) + "=" + encodeURIComponent (elem.value);
            }

            if (data != "") {
                data += "&";
            }
            data += param;                  
        }
    }
    return data;
}

    // returns whether the HTTP request was successful
function IsRequestSuccessful (httpRequest) {
        // IE: sometimes 1223 instead of 204
    var success = (httpRequest.status == 0 || 
        (httpRequest.status >= 200 && httpRequest.status < 300) || 
        httpRequest.status == 304 || httpRequest.status == 1223);
    
    return success;
}