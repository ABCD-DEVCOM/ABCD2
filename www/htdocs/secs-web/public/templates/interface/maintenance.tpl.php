{if $smarty.session.role eq "Administrator"}
<div class="yui-skin-sam">

    <div id="importDialog">
        <form id="importFormIssues" enctype="multipart/form-data" action="displayFormat.php?m=import" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
            <div class="hd">{$BVS_LANG.titleApp}</div>
            <div class="bd">
                <label for="importFile">{$BVS_LANG.lblFileName}</label><input name="importFile" id="importFile" type="file" />
                <br/>
                <div id="fieldsetExport">
                    <input id="submitbutton1" type="submit" value="Submit Form">
                </div>
            </div>

       </form>
   </div>

    <div id="reverseDB">
            <div class="hd">{$BVS_LANG.titleApp}</div>
            <div class="bd">
                <div id="msgDisplayed"></div>
            </div>
   </div>
</div>

<style>
#example { height:30em;}
label { display:block;float:left;width:45%;clear:left; }
.clear { clear:both; }
#resp { margin:10px;padding:5px;border:1px solid #ccc;background:#fff;}
#resp li { font-family:monospace }
</style>


<script type="text/javascript">
YAHOO.widget.DataTable.MSG_LOADING = "<div class='loading'><div>{$BVS_LANG.MSG_LOADING}</div></div>";
var install_dir = "{$BVS_CONF.install_dir}";
var msgSuccess = "{$BVS_LANG.mSuccess}";

{literal}
YAHOO.namespace("example.container");

function init() {


        // Define various event handlers for Dialog
	var handleSubmit = function() {
		this.submit();
	};
	var handleCancel = function() {
		this.cancel();
	};
        
	YAHOO.example.container.importDialog = new YAHOO.widget.Dialog("importDialog",
							{ width : "50em",
							  fixedcenter : true,
							  visible : false,
							  constraintoviewport : true
                                                          /*,
							  buttons : [ { text:"Submit", handler:handleSubmit} ]*/
							});

        YAHOO.example.container.importDialog.render();
	YAHOO.util.Event.addListener("importIssues", "click", YAHOO.example.container.importDialog.show, YAHOO.example.container.importDialog, true);

        // "contentready" event handler for the "fieldsetExport" <fieldset>
        YAHOO.util.Event.onContentReady("fieldsetExport", function () {
            // Create a Button using an existing <input> element as a data source
            var oSubmitButton1 = new YAHOO.widget.Button("submitbutton1", { value: "submitbutton1value" });
        });

        function onExampleSubmit(p_oEvent) {
            YAHOO.util.Event.preventDefault(p_oEvent);
            /*var bSubmit = window.confirm("Are you sure you want to submit this form?");
            if(!bSubmit) {
                YAHOO.util.Event.preventDefault(p_oEvent);
            }*/
        }

        YAHOO.util.Event.on("importFormIssues", "submit", onExampleSubmit);


}
YAHOO.util.Event.onDOMReady(init);


function reverseDB(){

    var handleSuccess = function(o) {
            document.getElementById('msgDisplayed').innerHTML = msgSuccess+ o.responseText;
    }
    var handleFailure = function(o) {
            document.getElementById('msgDisplayed').innerHTML = 'failure';
    }

    var callback = {
            success: handleSuccess,
            failure: handleFailure
    };

    var x = document.getElementById("libraryReverseDB").selectedIndex;
    var selectedDB = document.getElementById('libraryReverseDB').options[x].value;
    if(x != "0"){
        var sUrl = "displayFormat.php?m=reverseDB&database="+selectedDB;
        var postData = "";

        document.getElementById('msgDisplayed').innerHTML = YAHOO.widget.DataTable.MSG_LOADING;
        var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callback, postData);
        YAHOO.example.container.reverseDB.show();
    }else{
        alert("Please, select a database");
    }
}

function unlockDB(){

    var handleSuccess = function(o) {
            document.getElementById('msgDisplayed').innerHTML = msgSuccess + o.responseText;
    }
    var handleFailure = function(o) {
            document.getElementById('msgDisplayed').innerHTML = 'failure';
    }

    var callback = {
            success: handleSuccess,
            failure: handleFailure
    };

    var x = document.getElementById("libraryUnlockDB").selectedIndex;
    var selectedDB = document.getElementById('libraryUnlockDB').options[x].value;
    if(x != "0"){
        var sUrl = "displayFormat.php?m=unlockDB&database="+selectedDB;
        var postData = "";

        document.getElementById('msgDisplayed').innerHTML = YAHOO.widget.DataTable.MSG_LOADING;
        var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callback, postData);
        YAHOO.example.container.reverseDB.show();
    }else{
        alert("Please, select a database");
    }
}

YAHOO.example.container.reverseDB = new YAHOO.widget.Dialog("reverseDB",
							{ width : "50em",
							  fixedcenter : true,
							  visible : false,
							  constraintoviewport : true
							});

YAHOO.example.container.reverseDB.render();

{/literal}
</script>

<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
    <div class="boxTop">
        <div class="btLeft">&#160;</div>
        <div class="btRight">&#160;</div>
    </div>

        <div class="boxContent titleSection">
            <div class="sectionIcon">&#160;</div>
            <div class="sectionTitle">
                <h4><strong>{$BVS_LANG.lblImportTit}</strong></h4>
            </div>
            <div class="sectionButtons">
                <div class="searchTitles">
                    <form name="importFormTitle" action="{$smarty.server.PHP_SELF}?m=maintenance&action=import" method="post">
                        <div class="stInput">
                            <label for="searchExpr">{$BVS_LANG.lblSelFormat}</label>
                            <select name="indexes" class="textEntry superTextEntry">
                                {html_options options=$BVS_LANG.optExportTit}
                            </select>
                        </div>
                        
                        <a href="#" class="defaultButton importButton">
                            <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                            <span><strong>{$BVS_LANG.lblImportTit}</strong></span>
                        </a>
                    </form>
                </div>

            </div>
            <div class="spacer">&#160;</div>
        </div>

    <div class="boxBottom">
        <div class="bbLeft">&#160;</div>
        <div class="bbRight">&#160;</div>
    </div>
</div>
{/if}

<!--div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
    <div class="boxTop">
        <div class="btLeft">&#160;</div>
        <div class="btRight">&#160;</div>
    </div>
    <div class="boxContent maskSection">
        <div class="sectionIcon"><div class="spacer">&#160;</div></div>
        <div class="sectionTitle">
            <h4><strong>{$BVS_LANG.lblExportTit}</strong></h4>
        </div>
        <div class="sectionButtons">
            <div class="searchTitles">
                <form name="searchTitlesForm" action="{$smarty.server.PHP_SELF}?m=title" method="post">
                <div class="stInput">
                    <label>{$BVS_LANG.lblSelFormat}</label>
                    <select name="indexes" class="textEntry superTextEntry">
                        {html_options options=$BVS_LANG.optReportAdm }
                    </select>
                </div>
                <a href="?m=maintenance&searchParam=titCurrColect" class="defaultButton exportButton">
                    <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                    <span><strong>{$BVS_LANG.lblExportTit}</strong></span>
                </a>
                </form>
            </div>
         </div>
          <div class="spacer">&#160;</div>
    </div>
    <div class="boxBottom">
        <div class="bbLeft">&#160;</div>
        <div class="bbRight">&#160;</div>
    </div>
</div-->

<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
    <div class="boxTop">
        <div class="btLeft">&#160;</div>
        <div class="btRight">&#160;</div>
    </div>
    <div class="boxContent toolSection">
        <div class="sectionIcon"><div class="spacer">&#160;</div></div>
        <div class="sectionTitle">
            <h4><strong>{$BVS_LANG.lblImportFacic}</strong></h4>
        </div>
        <div class="sectionButtons">
            <div class="searchTitles">
                <div class="stInput"></div>
                <a href="#" id="importIssues" class="defaultButton reportButton">
                    <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                    <span><strong>{$BVS_LANG.lblImportFacic}</strong></span>
                </a>
            </div>
        </div>
        <div class="spacer">&#160;</div>
    </div>
    <div class="boxBottom">
        <div class="bbLeft">&#160;</div>
        <div class="bbRight">&#160;</div>
    </div>
</div>

<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
    <div class="boxTop">
        <div class="btLeft">&#160;</div>
        <div class="btRight">&#160;</div>
    </div>
    <div class="boxContent titleSection">
        <div class="sectionIcon"><div class="spacer">&#160;</div></div>
        <div class="sectionTitle">
            <h4><strong>{$BVS_LANG.lblUnlockDB}</strong></h4>
        </div>

        <div class="sectionButtons">
            <div class="searchTitles">
                <div class="stInput">
                    <label>{$BVS_LANG.lblSelDB}</label>
                    <select id="libraryUnlockDB" class="textEntry superTextEntry">
                        {if $smarty.session.role eq "Administrator"}
                            {html_options options=$BVS_LANG.optReportAdm}
                        {else}
                            {html_options options=$BVS_LANG.optReportEdt }
                        {/if}
                    </select>
                </div>
                  <a href="#" onclick="javascript: unlockDB();" class="defaultButton libraryButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblUnlockDB}</strong></span>
                    </a>
            </div>
      </div>
          <div class="spacer">&#160;</div>
    </div>
    <div class="boxBottom">
        <div class="bbLeft">&#160;</div>
        <div class="bbRight">&#160;</div>
    </div>
</div>

<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
    <div class="boxTop">
        <div class="btLeft">&#160;</div>
        <div class="btRight">&#160;</div>
    </div>
    <div class="boxContent maskSection">
        <div class="sectionIcon"><div class="spacer">&#160;</div></div>
        <div class="sectionTitle">
            <h4><strong>{$BVS_LANG.lblInvertDB}</strong></h4>
        </div>

        <div class="sectionButtons">
            <div class="searchTitles">
                <div class="stInput">
                    <label>{$BVS_LANG.lblSelDB}</label>
                    <select id="libraryReverseDB" class="textEntry superTextEntry">
                        {if $smarty.session.role eq "Administrator"}
                            {html_options options=$BVS_LANG.optReportAdm }
                        {else}
                            {html_options options=$BVS_LANG.optReportEdt }
                        {/if}
                    </select>
                </div>
                <a href="#" id="btUnlockDB" onclick="javascript: reverseDB();" class="defaultButton reportButton">
                    <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                    <span><strong>{$BVS_LANG.lblInvertDB}</strong></span>
                </a>
            </div>
     </div>
          <div class="spacer">&#160;</div>
    </div>
    <div class="boxBottom">
        <div class="bbLeft">&#160;</div>
        <div class="bbRight">&#160;</div>
    </div>
</div>