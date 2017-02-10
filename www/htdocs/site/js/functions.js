
function popUp(url,size) {
    if (size == 'small') {
        properties = 'width=100,height=100,';
    } else if ( size == 'medium' ) {
        properties = 'width=300,height=300,';
    } else if ( size == 'larger') {
        properties = 'width=500,height=500,';
    }

    window.open(url,'',properties+'resizable=no,scrollbars=yes');
    return false;
}


function checkUncheck( group, status  )
{
     var fieldList = document.forms[0].elements;
     var fieldId;
     var pos;

     for ( i = 0; i < fieldList.length; i++ )
     {
        field = fieldList[i];

        if ( field.type != 'checkbox' ){
           continue;
        }

        if ( group == "all" ) {

            field.checked = true;

        } else {

             fieldId = field.id;
             pos = group.length;

             if ( fieldId.substring(0,pos) == group ){

                     field.checked = status;

             }
       }
     }
    return;
}

// JavaScript Contact validation
    function checkContactForm (form, alertMessage, nameTranslation, emailTranslation, messageTranslation) {
        var name = form.fromName;
        var from = form.from;
        var fromValidMail = isEmailAddr(from.value);
        var message = form.message;
        var error = 0;
        var errorMessage = "";

        if (name.value == '') {
            error++;
            errorMessage += nameTranslation+"\r";
            name.focus();
        }
        if (from.value == '' || fromValidMail != true) {
            error++;
            errorMessage += emailTranslation+"\r";
            from.focus();
        }
        if (message.value == '') {
            error++;
            errorMessage += messageTranslation+"\r";
            message.focus();
        }

        if (error > 0) {
            alert(alertMessage+' \r'+errorMessage);
        } else {
            form.submit();
        }
    }

    function isEmailAddr(email) {
        var result = false
        var theStr = new String(email)
        var index = theStr.indexOf("@");
        if (index > 0) {
            var pindex = theStr.indexOf(".",index);
            if ((pindex > index+1) && (theStr.length > pindex+1))
            result = true;
        }
        return result;
    }
// end contact validation


function postHref ( href, target){

    var hrefAction = href.substring(0,href.indexOf('?'));
    var hrefParameters = href.substring(href.indexOf('?')+1);
    var splitedHref = hrefParameters.split("&");
    var qtt = splitedHref.length;
    var splitedHidden = new Array();
    var hiddenName = "";
    var hiddenValue = "";
    var submitForm = document.formHref;

    if ( target == '' || !target ){
        target = 'postHref';
    }

    submitForm.action = hrefAction;
    submitForm.target = target;

    for ( var i = 0; i < qtt; i++ )
    {
        splitedHidden = splitedHref[i].split("=");
        hiddenName = splitedHidden[0];
        splitedHidden[0] = "";
        hiddenValue = splitedHidden.join("=");
        hiddenValue = hiddenValue.replace(/%20/g,' ');
        hiddenValue = hiddenValue.replace(/%2F/g,'/');
        hiddenValue = hiddenValue.replace(/\+/g,' ');

        submitForm.elements[i].name = hiddenName;
        submitForm.elements[i].value = hiddenValue.substring(1);
    }
    // limpa campos hidden adicionais do formulario
    var totalHidden = submitForm.elements.length;
    for ( var i = qtt; i < totalHidden; i++ )
    {
        submitForm.elements[i].name = "";
        submitForm.elements[i].value = "";
    }

    submitForm.submit();
    //resultWindow = window.open('',target);
    //resultWindow.focus();
}


function fixPNG(myImage){ // correctly handle PNG transparency in Win IE 5.5 or higher.
     var imgID = (myImage.id) ? "id='" + myImage.id + "' " : ""
     var imgClass = (myImage.className) ? "class='" + myImage.className + "' " : ""
     var imgTitle = (myImage.title) ? "title='" + myImage.title + "' " : "title='" + myImage.alt + "' "
     var imgStyle = "display:inline-block;" + myImage.style.cssText
     var strNewHTML = "<span " + imgID + imgClass + imgTitle
     strNewHTML += " style=\"" + "width:" + myImage.width + "px; height:" + myImage.height + "px;" + imgStyle + ";"
     strNewHTML += "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
     strNewHTML += "(src=\'" + myImage.src + "\', sizingMethod='scale');\"></span>"
     myImage.outerHTML = strNewHTML
}


