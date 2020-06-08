function DeCSAutoCompleteConfigure(){

    /* auto complete */
    var serviceUrl = "../php/decsAutoCompleteProxy.php";
    var serviceSchema = ["item","term","id"];
    var decsDataSource = new YAHOO.widget.DS_XHR(serviceUrl, serviceSchema);
    decsDataSource.responseType = decsDataSource.TYPE_XML;

    var decsAutoComp = new YAHOO.widget.AutoComplete('terminput','container', decsDataSource);
    decsAutoComp.forceSelection = true;
    decsAutoComp.allowBrowserAutocomplete = false;
    decsAutoComp.minQueryLength = 2;
    decsAutoComp.maxResultsDisplayed = 40;

    decsAutoComp.itemSelectEvent.subscribe(onItemSelect);

    decsAutoComp.dataRequestEvent.subscribe(showLoadingImage);
    decsAutoComp.dataReturnEvent.subscribe(hideLoadingImage);

}

function onItemSelect(sType, aArgs) {
    var oItem = aArgs[1];
    var tree_id = oItem._oResultData[1];
    var termName= oItem._oResultData[0];
    document.decswsForm.tree_id.value = tree_id;
    document.decswsForm.autocomplete_term.value = termName;
    document.decswsForm.submit();
}

function showLoadingImage() {
    var loading = document.getElementById("loading");
    loading.innerHTML = "<img src=\"../image/common/progress.gif\" border=\"0\"/>";
}

function hideLoadingImage() {
    var loading = document.getElementById("loading");
    loading.innerHTML = "";
}

/* END auto complete */

/* selection terms area */

function showTermInfo(id){
    var serviceUrl = "../php/decsws.php?lang=" + lang + "&tree_id=" + id + "&page=info";

    termWindow = window.open(serviceUrl,'DeCS', 'width=375,height=350,resizable=no,top=200,left=300,menubar=0,scrollbars=1');
    termWindow.focus();

    return false;
}

function selectTermQualifier(id){
    var serviceUrl = "../php/decsws.php?lang=" + lang + "&tree_id=" + id + "&page=qualifier";

    termWindow = window.open(serviceUrl,'DeCS', 'width=270,height=325,resizable=yes,top=300,left=500,menubar=0,scrollbars=1');
    termWindow.focus();

    return false;
}

function selectTermExplode(id){
    var serviceUrl = "../php/decsws.php?lang=" + lang + "&tree_id=" + id + "&page=explode";

    termWindow = window.open(serviceUrl,'DeCS', 'width=265,height=150,resizable=yes,top=300,left=500,menubar=0,scrollbars=0');
    termWindow.focus();

    return false;
}


/* END selection terms area */

function showDeCSTerm(id){

    if (lang == "pt"){ decsLang = "p"; }
    if (lang == "es"){ decsLang = "e"; }
    if (lang == "en"){ decsLang = "i"; }

    decsUrl = "http://decs.bvs.br/cgi-bin/wxis1660.exe/decsserver/?IsisScript=../cgi-bin/decsserver/decsserver.xis&interface_language=" + decsLang + "&search_language=" + decsLang + "&previous_page=homepage&task=exact_term&search_exp=mfn=" + id + "#RegisterTop";
    decsWindow = window.open(decsUrl, "decsTerm", "height=450,width=630,menubar=no,toolbar=no,location=no,resizable=yes,scrollbars=yes,status=no");
    decsWindow.focus();

    return;
}

function showDeCSQualifier(qlf){

    if (lang == "pt"){ decsLang = "p"; }
    if (lang == "es"){ decsLang = "e"; }
    if (lang == "en"){ decsLang = "i"; }

    qlfUrl = "http://decs.bvs.br/cgi-bin/wxis1660.exe/decsserver/?IsisScript=../cgi-bin/decsserver/decsserver.xis&interface_language=" + decsLang + "&search_language=" + decsLang + "&previous_page=homepage&task=show_qualifier&qualifier=" + qlf;
    qlfWindow = window.open(qlfUrl, "decsTerm", "height=380,width=610,menubar=no,toolbar=no,location=no,resizable=yes,scrollbars=yes,status=no");
    qlfWindow.focus();

    return;
}


function executeSearchDecs(){
    var searchForm = document.decsSearchForm;
    var expression = searchForm.expression.value;

    if (expression == ""){
        return false;
    }
    // inicializing XMLHttpRequest
    httpInit();
    var url = "../php/decsSearchProxy.php?expression=" + escape(expression);

      xmlHttp.open("POST", url, true);
    xmlHttp.onreadystatechange = updateResultDecsPage;

      xmlHttp.send('');
    return false;
}


function updateResultDecsPage(){
    var resultPortlet = document.getElementById("searchResult");
    var result = document.getElementById("result");
    var buffer = "";
    var message = "";
    var error = false;
    resultPortlet.style.display="block";

    result.innerHTML = "<div align='center'><img src='../image/common/loading.gif' border='0'></div>";

    if (xmlHttp.readyState == 4) {
            if (xmlHttp.status == 200) {
                var decsResponse = xmlHttp.responseXML;

                var decsResult = decsResponse.getElementsByTagName("Result").item(0);
                var total = decsResult.getAttribute("total");
                var decsServiceUrl = "../php/decsws.php?lang=" + lang;

                if (total == '0'){
                    if (lang == 'pt')
                        message = "Não foram encontrados descritores";
                    if (lang == 'es')
                         message = "No fueron encontrados descritores";
                    if (lang == 'en')
                        message = "No descriptors found";

                    result.innerHTML = message;
                    return;
                }
                var itemList= decsResponse.getElementsByTagName("item");

                var buffer = "<ul>";
                for (var i = 0; i < itemList.length; i++) {
                    var item = itemList[i];
                    var id = item.getAttribute("id");
                    var term = item.getAttribute("term");

                    buffer += "<li><a href=\"" + decsServiceUrl + "&tree_id=" + id + "&autocomplete_term=" + term + "\">" + term + "</a></li>\n";
                }
                buffer += "</ul>";
            } else {
                buffer = xmlHttp.responseText;
            }

            buffer += "<div align=\"right\"><a href=\"http://decs.bvs.br\" target=\"decs\"><img src=\"../image/common/decs/logo.gif\" border=\"0\"></a></div>";
            result.innerHTML = buffer;

     }
}
