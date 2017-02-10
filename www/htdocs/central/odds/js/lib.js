// ------------------------------------------------------------------------------------------
// All functions in this file ares used for send mails from ABCD when a request is answered
// ------------------------------------------------------------------------------------------
function getOutput(email, email_apoderado, fecha, name, status, uploadFiles, notes, title) {
  getRequest(
      '../odds/lib/sendMail.php', // URL for the PHP file
       drawOutput,  // handle successful request
       drawError,    // handle error
       email, email_apoderado, fecha, name, status, uploadFiles, notes, title // parameters
  );
  return false;
}  
// handles drawing an error message
function drawError () {
    var container = document.getElementById('output');
    container.innerHTML = 'Error en AJAX';
}
// handles the response, adds the html
function drawOutput(responseText) {
    var container = document.getElementById('output');    
    container.innerHTML = responseText;
}
// helper function for cross-browser request object
function getRequest(url, success, error, email, email_apoderado, fecha, name, status, uploadFiles, notes, title) {
    var req = false;
    try{
        // most browsers
        req = new XMLHttpRequest();
    } catch (e){
        // IE
        try{
            req = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            // try an older version
            try{
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e){
                return false;
            }
        }
    }
    if (!req) return false;
    if (typeof success != 'function') success = function () {};
    if (typeof error!= 'function') error = function () {};
    req.onreadystatechange = function(){
        if(req .readyState == 4){
            return req.status === 200 ? 
                success(req.responseText) : error(req.status)
            ;
        }
    }
    url = url + "?email=" + email + "&email_apoderado=" + email_apoderado + "&fecha=" + fecha +  "&name=" + name + "&status=" + status+ "&uploadFiles=" + uploadFiles + "&notes=" + notes+ "&title=" + title;
    alert(url);
    req.open("GET", url, true);
    req.send(null);
    return req;
}