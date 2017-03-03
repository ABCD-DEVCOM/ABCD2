$(document).ready(resizeIFrames);

function resizeIFrames(){
    var iframe = document.all.platserv;
    iframe.height = window.frames["platserv"].document.body.scrollHeight;
}
