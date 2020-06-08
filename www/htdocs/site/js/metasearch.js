    var xmlHttp = false;
    var metaengine = "";

    function httpInit() {

        if (!xmlHttp){

            if (window.XMLHttpRequest) { // Mozilla, Safari,...
                xmlHttp = new XMLHttpRequest();
                if (xmlHttp.overrideMimeType) {
                    xmlHttp.overrideMimeType('text/xml');
                }
            } else if (window.ActiveXObject) { // IE
                try {
                    xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e) {
                    try {
                        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (e) {}
                }
            }

        }

        if (!xmlHttp) {
            alert('Cannot create an XMLHTTP instance');
            return false;
        }
    }

    function executeSearch(){
        var searchForm = document.searchForm;
        var resultView = searchForm.view.value;
        var    lang = searchForm.lang.value;
        var expression = searchForm.expression.value;
       
        if (expression == ""){
            return false;
        }
        
        if (searchForm.engine.length == null || searchForm.engine.length == 1 ){
            metaengine = searchForm.engine.value;
        }else{
            for (i = 0; i < searchForm.engine.length; i++) {
                if (searchForm.engine[i].checked == true){
                    metaengine = searchForm.engine[i].value;
                    break;
                }
            }
        }
       
        if (metaengine === "metaiah"){
            expression = insertDefaultOperator(expression);
        }

		if (metaengine === "iahx"){
            searchForm.action = "/apps/iahx/";
            return true;
        }

        if (resultView == 'BOX'){
            // inicializing XMLHttpRequest
            httpInit();
            var url = "../" + metaengine + "/searchAjax.php?expression=" + escape(expression) + "&lang=" + lang;
               xmlHttp.open("POST", url, true);
            xmlHttp.onreadystatechange = updatePage;
               xmlHttp.send('');
            return false;
        }else{
            searchForm.action = "../" + metaengine + "/search.php";
        }
       
        return true;
    }


    function updatePage(){
        var resultPortlet = document.getElementById("searchResult");
        var result = document.getElementById("result");
        var buffer = "";
        var message = "";
         var error = false;
        resultPortlet.style.display="block";

        result.innerHTML = "<div align='center'><img src='../image/common/loading.gif' border='0'></div>";

        if (xmlHttp.readyState == 4) {
            if (xmlHttp.status == 200) {
                var metaiah = xmlHttp.responseXML;

                var groupList = metaiah.getElementsByTagName("result-group");

                for (var i = 0; i < groupList.length; i++) {
                    var group = groupList[i];
                    sourceList =  group.childNodes;

                    var sources = group.getAttribute("sources");

                    buffer += "<ul>";
                    if (sources == 1){        // caso tenha somente uma fonte no grupo
                        for (y = 0; y < sourceList.length; y++) {
                            var source = sourceList[y];
                            if (source.nodeType == 1){
                                if (source.getAttribute("error") != null){
                                    error = true;
                                    buffer += "<li>" + source.getAttribute("label") + " <span title='" + source.getAttribute("error") + "'>(!)</span></li>";
                                }else{
                                    browseUrl = encodeQuot( source.getAttribute("browse-url") );
                                    buffer += "<li><a href=\"" + browseUrl +  "\" target=\"metaResult\" onclick=\"openResultWin(this.href, this.target)\">" + source.getAttribute("label") + "</a> (" + source.getAttribute("total") + ") </li>";
                                }
                            }
                        }
                    }else{
                        buffer += " <li>" + group.getAttribute("label") + " (" + group.getAttribute("total") + ")";
                        for (y = 0; y < sourceList.length; y++) {
                            buffer += "<ul>";
                            var source = sourceList[y];

                            if (source.nodeType == 1){
                                if (source.getAttribute("error") != null){
                                    error = true;
                                    buffer += "<li>" + source.getAttribute("label") + " <span title='" + source.getAttribute("error") + "'>(!)</span></li>";
                                }else{
                                    browseUrl = encodeQuot( source.getAttribute("browse-url") );
                                    buffer += "<li><a href=\"" + browseUrl +  "\" target=\"metaResult\" onclick=\"openResultWin(this.href, this.target)\">" + source.getAttribute("label") + "</a> (" + source.getAttribute("total") + ") </li>";
                                }
                            }
                            buffer += "</ul>";
                        }
                    }
                    buffer += " </li>";
                    buffer += "</ul>";
                }
                if (error == true){
                    if (lang == 'pt')
                        message = "não foi possivel conectar";
                    if (lang == 'es')
                         message = "no fue posible conectar";
                    if (lang == 'en')
                        message = "unable to connect";

                    buffer += "<div style='text-align:right; font-size: 90%'>(!)" + message + "</div>";
                  }
            } else {
                buffer = xmlHttp.responseText;
            }

            buffer += "<div align='right'><img src='../image/common/engine/" + metaengine + "/logo.gif' border='0'></div>";
            result.innerHTML = buffer;
        }

    }

    function portletClose(portletId){
        xmlHttp.abort();
        var portlet = document.getElementById(portletId);
        portlet.style.display = "none";

        return;
    }

    function insertDefaultOperator(str){


        var quotedExpressions = str.match(/("[^"]*")/g);

        // Substitui expressões dentro de aspas por %~~%
        if (quotedExpressions)
        {
            for (var i = 0; i < quotedExpressions.length; i++)
            {
                var qexp = quotedExpressions[i];
                var pos = str.indexOf(qexp);

                str = str.slice(0, pos) + "\%~~\%" + str.slice(pos + qexp.length);
            }
        }

        var patterns = [ /^\s+/, /\s+$/, /\s+/g, / AND (AND|OR|NOT) AND /ig, /^NOT AND /i, / NOT AND /ig, / AND /g, / OR /g, /^NOT /, / NOT /g ];
        var replacements = [ "", "", " and ", " $1 ", "not ", " not ", " and ", " or ", "not ", " not " ];

        for (var i = 0; i < patterns.length; i++)
        {
            str = str.replace(patterns[i], replacements[i]);
        }

        // Insere de volta a expressão dentro de aspas
        if (quotedExpressions)
        {
            for (var i = 0; i < quotedExpressions.length; i++)
            {
                str = str.replace(/%~~%/, quotedExpressions[i]);
            }
        }

        return str;
    }

    function openResultWin(url, target){
          newWindow = window.open(url, target);
         if(newWindow.focus) newWindow.focus();
    }

    function encodeQuot(str) {
        str=str.replace(/"/g,'%22');
        return str;
    }

    function clearDefault(id, newclass) {
        identity=document.getElementById(id);
        identity.className=newclass;
    }
