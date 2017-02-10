<div id="menuExport" style="display: none;">
    <a href="javascript: fullExportMenu('allRegisters');">{$BVS_LANG.btAllRegisters}</a><br/>
    <a href="javascript: fullExportMenu('oneRegister');">{$BVS_LANG.btOneRegister}</a><br/>
    <span class="exit"><a href="javascript: hideFullExportMenu();" title="Fechar"><img src="public/images/common/icon/singleButton_erase.png" alt="cancel" /></a></span>
</div>

<div id="formatMenuAllRegisters" style="display: none;">
    <span><a href="javascript: fullExportMenu('secsFormat', 'allRegisters'); ">{$BVS_LANG.btSeCSFormat}</a></span><br/>
    <!--span><a href="javascript: fullExportMenu('marcFormat', 'allRegisters'); ">{$BVS_LANG.btMarcFormat}</a></span><br/-->
    <span><a href="javascript: showHideDiv('formatMenuAllRegisters');" title="Fechar"><img src="public/images/common/icon/singleButton_back.png" alt="cancel" /></a></span>
    <span class="exit"><a href="javascript: hideFullExportMenu();" title="Fechar"><img src="public/images/common/icon/singleButton_erase.png" alt="cancel" /></a></span>
</div>

<div id="formatMenuOneRegister" style="display: none;">
    <span><a href="javascript: fullExportMenu('secsFormat', 'oneRegister'); ">{$BVS_LANG.btSeCSFormat}</a></span><br/>
    <span><a href="javascript: fullExportMenu('marcFormat', 'oneRegister'); ">{$BVS_LANG.btMarcFormat}</a></span><br/>
    <span><a href="javascript: showHideDiv('formatMenuOneRegister');" title="Back"><img src="public/images/common/icon/singleButton_back.png" alt="back" /></a></span>
    <span class="exit"><a href="javascript: hideFullExportMenu();" title="Fechar"><img src="public/images/common/icon/singleButton_erase.png" alt="close" /></a></span>
</div>

<div id="exportID" style="display: none;">
    <label><strong>{$BVS_LANG.lblID}: </strong></label><br/>
    <input type="text" name="fileNameID" id="fileNameID" value="" class="superTextEntry" onfocus="this.className='superTextEntry textEntryFocus';" onblur="this.className='superTextEntry';" /><br/><br/>
    <span><a href="javascript: fullExportMenu('secsFormat', 'oneRegister'); ">{$BVS_LANG.lblExport} {$BVS_LANG.btSeCSFormat}</a></span><br/>
    <!--span><a href="javascript: fullExportMenu('marcFormat', 'oneRegister'); ">{$BVS_LANG.lblExport} {$BVS_LANG.btMarcFormat}</a></span><br/-->
    <span><a href="javascript: showHideDiv('exportID');" title="Back"><img src="public/images/common/icon/singleButton_back.png" alt="back" /></a></span>
    <span class="exit"><a href="javascript: hideFullExportMenu();" title="Fechar"><img src="public/images/common/icon/singleButton_erase.png" alt="cancel" /></a></span>
</div>

<div id="collectionMenuSeCSFormat" style="display: none;">
    <span><a href="javascript: hideFullExportMenu();exportDialog('titWithoutCollection', 'allRegisters', 'secsFormat');" id="btCollectionMenuSeCSFormatTitleOnly">{$BVS_LANG.btExportTitleCollection}</a></span><br/>
    <span><a href="javascript: hideFullExportMenu(); exportDialog('titWithCollection', 'allRegisters', 'secsFormat');" id="btCollectionMenuSeCSFormatCollectionTitleCollection">{$BVS_LANG.btExportTitlePlusCollection}</a></span><br/>
    <span><a href="javascript: showHideDiv('collectionMenuSeCSFormat');" title="Back"><img src="public/images/common/icon/singleButton_back.png" alt="back" /></a></span>
    <span class="exit"><a href="javascript: hideFullExportMenu();" title="Fechar"><img src="public/images/common/icon/singleButton_erase.png" alt="close" /></a></span>
</div>

<div id="collectionMenuMarcFormat" style="display: none;">
    <span><a href="javascript: hideFullExportMenu(); exportDialog('titWithoutCollection', 'oneRegister', 'marcFormat');" id="btCollectionMenuMarcFormatTitleOnly">{$BVS_LANG.btExportTitleCollection}</a></span><br/>
    <span><a href="javascript: showHideDiv('collectionMenuMarcFormat');" title="Back"><img src="public/images/common/icon/singleButton_back.png" alt="back" /></a></span>
    <span class="exit"><a href="javascript: hideFullExportMenu();" title="Fechar"><img src="public/images/common/icon/singleButton_erase.png" alt="close" /></a></span>
</div>

<div id="catalogExport" style="display: none;">
    <span><a href="javascript: hideFullExportMenu(); exportDialog('sendToSeCS'); ">{$BVS_LANG.btSendToSeCS}</a></span><br/>
    <span><a href="javascript: hideFullExportMenu(); exportDialog('sendToNationalCollection'); ">{$BVS_LANG.btSendToNationalCollection}</a></span><br/>
    <span class="exit"><a href="javascript: hideFullExportMenu();" title="Fechar"><img src="public/images/common/icon/singleButton_erase.png" alt="close" /></a></span>
</div>

<div class="yui-skin-sam">

<div id="buttoncontainer"></div>
    <div  id="checkTitlePlusDialog">
        <div class="hd">{$BVS_LANG.titleApp}</div>
        <div class="bd">{$BVS_LANG.msgTitlePlusDoesNotExist}</div>
    </div>

    <div id="collectionDialog">
      <div class="hd">{$BVS_LANG.titleApp}</div>
        <div class="bd">
        <div id="collectionDisplayed"></div>
      </div>
    </div>

    <div id="exportDialogResizable">
        <div class="hd">{$BVS_LANG.titleApp}</div>
        <div class="bd">
            <div class="formHead">
            <div id="formRow01" class="formRow">
                <div class="fieldBlock">
                <div id="labelStepTitle"></div>
                <div id="labelIbictID"></div>
                <input type="text" name="ibictID" id="ibictID" value="" style="display: none;" class="superTextEntry" onfocus="this.className='superTextEntry textEntryFocus';" onblur="this.className='superTextEntry';" />
                <label><strong>{$BVS_LANG.lblFileName} </strong></label>
                <input type="text" name="fileName" id="fileName" value="" class="superTextEntry" onfocus="this.className='superTextEntry textEntryFocus';" onblur="this.className='superTextEntry';" />
                <a href="javascript: exportFile(); " id="btSaveExport"  class="defaultButton saveButton" >
                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="{$BVS_LANG.btSaveRecord}" title="{$BVS_LANG.btSaveRecord}" />
                    <span><strong>{$BVS_LANG.btSaveRecord}</strong></span>
                </a>
                <a href="javascript: hideExportDialog(); "  class="defaultButton cancelButton" >
                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="{$BVS_LANG.btCancelAction}" title="{$BVS_LANG.btCancelAction}" />
                    <span><strong>{$BVS_LANG.btCancelAction}</strong></span>
                </a>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            </div>
        </div>
        <div class="ft"></div>
    </div>

    <div id="exportDialogResizable-step2">
        <div class="hd">{$BVS_LANG.titleApp}</div>
        <div class="bd">
            <div class="formHead">
            <div id="formRow02" class="formRow">
                <div class="fieldBlock">
                <label><strong>{$BVS_LANG.lblDialogStep2}</strong></label><br/><br/>
                <label><strong>{$BVS_LANG.lblFileName}</strong></label>
                <input type="hidden" name="ibictID2" id="ibictID2" value="" class="superTextEntry" onfocus="this.className='superTextEntry textEntryFocus';" onblur="this.className='superTextEntry';" />
                <input type="text" name="fileName2" id="fileName2" value="" class="superTextEntry" onfocus="this.className='superTextEntry textEntryFocus';" onblur="this.className='superTextEntry';" />
                <a href="javascript: exportFile(); " id="btSaveExport2"  class="defaultButton saveButton" >
                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="{$BVS_LANG.btSaveRecord}" title="{$BVS_LANG.btSaveRecord}" />
                    <span><strong>{$BVS_LANG.btSaveRecord}</strong></span>
                </a>
                <a href="javascript: hideExportDialog(); "  class="defaultButton cancelButton" >
                    <img src="public/images/common/defaultButton_iconBorder.gif" alt="{$BVS_LANG.btCancelAction}" title="{$BVS_LANG.btCancelAction}" />
                    <span><strong>{$BVS_LANG.btCancelAction}</strong></span>
                </a>
                </div>
                <div class="spacer">&#160;</div>
            </div>
            </div>
        </div>
        <div class="ft"></div>
    </div>
</div>

<div id="listRecords" class="listTable"></div>

<script type="text/javascript">
var msgDoesNotExist = "{$BVS_LANG.msgTitlePlusDoesNotExist}";
var lblViewOf = "{$BVS_LANG.lblViewOf}";
var lblUntil  = "{$BVS_LANG.lblUntil}";
var lblOf  = "{$BVS_LANG.lblOf}";
var lblID  = "{$BVS_LANG.lblID}";
var lblMask  = "{$BVS_LANG.mask}";
var lblNote  = "{$BVS_LANG.lblNote}";
var lblAction = "{$BVS_LANG.lblAction}";
var lblPerPage = "{$BVS_LANG.perPage}";
var lblTitle  = "{$BVS_LANG.title}";
var lblTitlePlus  = "{$BVS_LANG.lblTitlePlus}";
var lblHldgMessage = "{$BVS_LANG.lblHldgMessage}";
var msgWaiting = "{$BVS_LANG.lblHldgMessage}";
var lblActionFacic = "{$BVS_LANG.ActionFacic}";
var lblActionTitle = "{$BVS_LANG.ActionTitle}";
var lblActionTitlePlus = "{$BVS_LANG.lblActionTitPlus}";
var btInTitlePlus = "{$BVS_LANG.btInTitlePlus}";
var btEdTitlePlus = "{$BVS_LANG.btCreEdTitlePlus}";
var btEdMask = "{$BVS_LANG.btEdMask}";
var btDelete = "{$BVS_LANG.btDeleteRecord}";
var btNext = "{$BVS_LANG.btNext}";
var btPrevious = "{$BVS_LANG.btPrevious}";
var btFirst = "{$BVS_LANG.btFirst}";
var btLast = "{$BVS_LANG.btLast}";
var btList = "{$BVS_LANG.lblList}";
var lblFacic  = "{$BVS_LANG.facic}";
var lblViewHldg = "{$BVS_LANG.lblViewHldg}";
var btEdTitle = "{$BVS_LANG.btEdTitle}";
var btEdFasc = "{$BVS_LANG.btEdFasc}";
var btInsFasc = "{$BVS_LANG.btInsFasc}";
var msgEmpty = "{$BVS_LANG.msgEmpty}";
var lblExport = "{$BVS_LANG.lblExport}";
var lblInfo = "{$BVS_LANG.lblTitleInformation}";
var lblTitPlusInfo = "{$BVS_LANG.lblTitlePlusInformation}";
var lblStep1 = "{$BVS_LANG.lblDialogStep1}";
var lblStep2 = "{$BVS_LANG.lblDialogStep2}";
var lblIBICTId = "{$BVS_LANG.lblIBICTId}";
var search = "{$smarty.get.searchExpr}";
var lblCatalog = "{$BVS_LANG.lblCatalog}";
var lblLong = "{$BVS_LANG.lblLong}";
var lblShort = "{$BVS_LANG.lblShort}";
var lblComplete = "{$BVS_LANG.lblComplete}";

var numRecordsPage = {$BVS_CONF.numRecordsPage};
var hRequest = "";
var searchExpr = null;
var indexes = null;
var m = null;
var d = new Date();
var t = d.getTime();
hRequest = "tty=" + d.getTime();
YAHOO.namespace("example.container");

YAHOO.widget.DataTable.MSG_LOADING = "<div class='loading'><div>{$BVS_LANG.MSG_LOADING}</div></div>";
YAHOO.widget.DataTable.MSG_EMPTY = "{$BVS_LANG.MSG_EMPTY}";
YAHOO.widget.DataTable.MSG_ERROR = "{$BVS_LANG.MSG_ERROR}";

{if $smarty.request.searchExpr}
    var searchExpr = "{$smarty.request.searchExpr}";
{/if}
{if $smarty.request.indexes}
    var indexes = "{$smarty.request.indexes}";
{/if}
{if $smarty.get.m}
    m = "{$smarty.get.m}";
{/if}
{if $smarty.get.title}
    t = "{$smarty.get.title}";
{/if}
{if $smarty.session.role}
    var role = "{$smarty.session.role}";
{/if}
var titPlus = false;
{if $smarty.get.titleplus}
    var titPlus = "{$smarty.get.titleplus}";
{/if}

{literal}
if(searchExpr != null) {
    hRequest = "&searchExpr="+searchExpr;
}
if(indexes != null) {
    hRequest = hRequest + "&indexes=" + indexes;
}
if(m != null) {
    hRequest = hRequest + "&m=" + m;
}
YAHOO.widget.DataTable.CLASS_DESC = "desc";
YAHOO.widget.DataTable.CLASS_ASC = "asc";
YAHOO.util.Event.onDOMReady(function () {
    var DataSource = YAHOO.util.DataSource,
    DataTable  = YAHOO.widget.DataTable,
    Paginator  = YAHOO.widget.Paginator;

	DataTable.CLASS_ASC = "asc";
   
    var mySource = new DataSource("yuiservice.php?" + hRequest);

    mySource.responseType   = DataSource.TYPE_JSON;
    mySource.responseSchema = {
    resultsList : 'records',
    fields      : [
        {key:"MFN",parser:YAHOO.util.DataSource.parseNumber},
        {key:"TITLE",parser:YAHOO.util.DataSource.parseString},
        {key:"SUBTITLE",parser:YAHOO.util.DataSource.parseString},
        {key:"SECTIONPART",parser:YAHOO.util.DataSource.parseString},
        {key:"OFSECTIONPART",parser:YAHOO.util.DataSource.parseString},
        {key:"PARALLELTITLE",parser:YAHOO.util.DataSource.parseString},
        {key:"OFISSUINGBODY",parser:YAHOO.util.DataSource.parseString},
        {key:"INITIALDATE",parser:YAHOO.util.DataSource.parseString},
        {key:"INITIALVOLUME",parser:YAHOO.util.DataSource.parseString},
        {key:"INITIALNUMBER",parser:YAHOO.util.DataSource.parseString},
        {key:"FINALDATE",parser:YAHOO.util.DataSource.parseString},
        {key:"FINALVOLUME",parser:YAHOO.util.DataSource.parseString},
        {key:"FINALNUMBER",parser:YAHOO.util.DataSource.parseString},
        {key:"PUBLISHER",parser:YAHOO.util.DataSource.parseString},
        {key:"CITY",parser:YAHOO.util.DataSource.parseString},
        {key:"FASC",parser:YAHOO.util.DataSource.parseString},
        {key:"ACTION",parser:YAHOO.util.DataSource.parseNumber}],

     metaFields : {
        totalRecords: 'totalRecords',
        paginationRecordOffset : "startIndex",
        sortKey: "MFN",
        sortDir: "asc"
    }
    };

    var buildQueryString = function (state,dt) {
    return "&startIndex=" + state.pagination.recordOffset +
           "&results=" + state.pagination.rowsPerPage;
    };

    var myPaginator = new Paginator({
    containers     : ['pagination'],
    pageLinks      : 5,
    rowsPerPage    : numRecordsPage,
    rowsPerPageOptions : [numRecordsPage,numRecordsPage*2,numRecordsPage*3,numRecordsPage*4,numRecordsPage*5],
    rowsPerPageDropdownClass : "textEntry",
    pageLinkClass	   : "singleButton",
    currentPageClass   : "singleButtonSelected",
    firstPageLinkLabel : "&lt;&lt; " + btFirst,
    firstPageLinkClass : "singleButton eraseButton",
    lastPageLinkLabel  : "&gt;&gt; " + btLast,
    lastPageLinkClass  : "singleButton eraseButton",
    previousPageLinkLabel : "&lt; " + btPrevious,
    previousPageLinkClass : "singleButton eraseButton", // default
    nextPageLinkLabel : btNext + " &gt;", // default
    nextPageLinkClass : "singleButton eraseButton", // default
    template       : "{FirstPageLink} {PreviousPageLink} " +
    					 "{PageLinks} "+
    					 "{NextPageLink} {LastPageLink}  " +
    					 lblViewOf+" {RowsPerPageDropdown} " + lblPerPage,
    // use custom page link labels
    pageLabelBuilder : function (page,paginator) {
        var recs = paginator.getPageRecords(page);
        return (recs[0] + 1) + ' - ' + (recs[1] + 1);
    }
    });

    var myTableConfig = {
    initialRequest     : '&startIndex=0&results=' + numRecordsPage,
    generateRequest    : buildQueryString,
    paginationEventHandler : DataTable.handleDataSourcePagination,
    paginator          : myPaginator
    };

    this.myFormatTitle = function(elCell, oRecord, oColumn, oData) {
    var mfn = oRecord.getData('MFN');
    var partitle = oRecord.getData('PARALLELTITLE');
    if(partitle != null){
        partitle = (partitle.search(',')!=-1) ? partitle.replace(',', ' = ') : partitle;
    }
    var btMenuViewFormats = "<a href=\"javascript: selectView("+mfn+",'selView');\" id=\"btView"+mfn+"\"><img src=\"public/images/common/icon/singleButton_info.png\" title=\""+lblInfo+"\" alt=\""+lblInfo+"\" id=\"btAdd"+mfn+"\"/></a>";
    /***  Head View   ***/
    var presentation = "<div id=\"viewHead"+mfn+"\" style=\"display: block;\">" + btMenuViewFormats + oRecord.getData('TITLE');
    if(oRecord.getData('SUBTITLE') != null){ presentation = presentation + ": " + oRecord.getData('SUBTITLE');  }
    if(oRecord.getData('SECTIONPART') != null){ presentation = presentation + ". " + oRecord.getData('SECTIONPART');  }
    if(oRecord.getData('OFSECTIONPART') != null){ presentation = presentation + ", " + oRecord.getData('OFSECTIONPART');  }
    if(oRecord.getData('OFISSUINGBODY') != null){ presentation = presentation + " / " + oRecord.getData('OFISSUINGBODY');  }
    if(oRecord.getData('PARALLELTITLE') != null){ presentation = presentation + " = " + partitle;  }
    if(oRecord.getData('INITIALVOLUME') != null){ presentation = presentation + ".-- Vol." + oRecord.getData('INITIALVOLUME');  }
    if(oRecord.getData('INITIALDATE') != null){ presentation = presentation + " (" + oRecord.getData('INITIALDATE') + ")";  }
    if(oRecord.getData('INITIALNUMBER') != null){ presentation = presentation + " no." + oRecord.getData('INITIALNUMBER');  }
    if(oRecord.getData('FINALVOLUME') != null){ presentation = presentation + " no." + oRecord.getData('FINALVOLUME');  }
    if(oRecord.getData('FINALDATE') != null){ presentation = presentation + " no." + oRecord.getData('FINALDATE');  }
    if(oRecord.getData('FINALNUMBER') != null){ presentation = presentation + " no." + oRecord.getData('FINALNUMBER');  }
    if(oRecord.getData('CITY') != null){ presentation = presentation + " " + oRecord.getData('CITY') + ":";  }
    if(oRecord.getData('PUBLISHER') != null){ presentation = presentation  + " " + oRecord.getData('PUBLISHER') + ".";  }
    var presentation = presentation +"</div>";
    /***  View List  ***/
    var presentation = presentation + "<div id=\"selView"+mfn+ "\" style=\"display: none;\" ><div id=\"vizForm\">";
    var presentation = presentation + "<a href=\"javascript: getCollectionAndDisplay('"+mfn+"', 'title', 'catalog'); selectView("+mfn+",'noSelView');\">"+lblCatalog+"</a><br />";
    var presentation = presentation + "<a href=\"javascript: getCollectionAndDisplay('"+mfn+"', 'title', 'short'); selectView("+mfn+",'noSelView');\">"+lblShort+"</a><br />";
    var presentation = presentation + "<a href=\"javascript: getCollectionAndDisplay('"+mfn+"', 'title', 'long'); selectView("+mfn+",'noSelView'); \">"+lblLong+"</a><br />";
    var presentation = presentation + "<a href=\"javascript: getCollectionAndDisplay('"+mfn+"', 'title', 'full'); selectView("+mfn+",'noSelView');\">"+lblComplete+"</a><br />";
    var presentation = presentation + "</div></div></div>";
    elCell.innerHTML = presentation +"</div>" ;
    };

    this.myFormatAction = function(elCell, oRecord, oColumn, oData) {
    var mfn = oRecord.getData('MFN');
    var btEditTitle = "<a href=\"?m=title&edit=" + mfn + "&tty="+d.getTime()+"&searchExpr="+search+"\" ><img src=\"public/images/common/icon/singleButton_edit.png\" title=\""+btEdTitle+"\" alt=\""+btEdTitle+"\" /></a> ";
    var btDeleteTitle = "<a href=\"?m=title&action=delete&id="+mfn+"\" ><img src=\"public/images/common/icon/singleButton_delete.png\" title=\""+btDelete+" "+lblTitle+"\" alt=\""+btDelete+ " "+lblTitle+"\" /></a> ";
    elCell.innerHTML =  btEditTitle + btDeleteTitle;
    };

    this.myFormatFascic = function(elCell, oRecord, oColumn, oData) {
    var mfn = oData;
    var initialDate = oRecord.getData('INITIALDATE');
    var initialVolume = oRecord.getData('INITIALVOLUME');
    var initialNumber = oRecord.getData('INITIALNUMBER');
    var tQuery = "initialDate="+initialDate+"&initialVolume="+initialVolume+"&initialNumber="+initialNumber;
    //var btListIssues = "<a href=\"?m=facic&title="+mfn+"&tty="+d.getTime() + "&"+ tQuery + "\" ><img src=\"public/images/common/icon/singleButton_listIssues.png\" title=\""+btList+" "+lblFacic+"\" alt=\""+btList+" "+lblFacic+"\" /></a>";
    var l1 = '?m=facic&title='+mfn+'&tty='+d.getTime() + '&'+ tQuery ;
    var btListIssues = '<a href="javascript: checkTitlePlusAndExecute(\''+mfn+'\', \''+l1+'\' );" ><img src="public/images/common/icon/singleButton_listIssues.png" title="'+btList+'" "'+lblFacic+'" alt="'+btList+'" "'+lblFacic+'" /></a>';
    var btViewHoldings = '<a href="javascript: getCollectionAndDisplay(\''+mfn+'\',\'holdings\');" ><img src="public/images/common/icon/singleButton_viewHoldings.png" title="'+lblViewHldg+'" alt="'+lblViewHldg+'" /></a>';
    elCell.innerHTML = btListIssues + btViewHoldings;
    };

    this.myFormatTitPlus = function(elCell, oRecord, oColumn, oData) {
    var mfn = oRecord.getData('MFN');
    var titleID = oRecord.getData('FASC');
    var initialDate = oRecord.getData('INITIALDATE');
    var initialVolume = oRecord.getData('INITIALVOLUME');
    var initialNumber = oRecord.getData('INITIALNUMBER');

    var l1 = "?m=titleplus&edit=" + titleID +"&title="+titleID+"&tty="+d.getTime()+"&searchExpr="+titleID+"&initialDate="+initialDate+"&initialVolume="+initialVolume+"&initialNumber="+initialNumber;
    var l2 = "?m=titleplus&action=delete&title="+titleID+"&id="+mfn ;
    var btViewTitPlus = "<a href=\"javascript: getCollectionAndDisplay('"+titleID+"','titleplus');  \" ><img src=\"public/images/common/icon/singleButton_info.png\" title=\""+lblTitPlusInfo+"\" alt=\""+lblTitPlusInfo+"\" id=\"btAdd"+mfn+"\"/></a>";
    var btCreatEditTitPlus = "<a href=\""+l1+"\" ><img src=\"public/images/common/icon/singleButton_edit.png\" title=\""+btEdTitlePlus+"\" alt=\""+btEdTitlePlus+"\" /></a> ";
    var btDeleteTitPlus = "<a href=\"javascript: checkTitlePlusAndExecute('"+titleID+"', '"+l2+"' );\" ><img src=\"public/images/common/icon/singleButton_delete.png\" title=\""+btDelete+" "+lblTitlePlus+"\" alt=\""+btDelete+ " "+lblTitlePlus+"\" /></a>";

    elCell.innerHTML = btViewTitPlus + btCreatEditTitPlus + btDeleteTitPlus;
    };
    this.myFormatTitPlus2 = function(elCell, oRecord, oColumn, oData) {
    	var mfn = oRecord.getData('MFN');
    elCell.innerHTML = "<a href=\"?m=titleplus&edit=" + mfn +"&title="+mfn+"&tty="+d.getTime()+"&searchExpr="+search+"\" class=\"tButton\">"+btInTitlePlus+"</a>";
    };
    /*this.myFormatExport = function(elCell, oRecord, oColumn, oData) {
    var mfn = oRecord.getData('MFN');
    var buttonExport = "<a id=\"btExport"+mfn+"\" href=\"javascript: selectView("+mfn+",'selExport');\" class=\"tButton\">"+lblExport+"</a>";
    var presentation = buttonExport + "<div id=\"selExport"+mfn+ "\" style=\"display: none;\" ><div id=\"exportForm\">";
    var presentation = presentation + "<a href=\"javascript: selectView("+mfn+",'off');\">Title without Collection</a><br />";
    var presentation = presentation + "<a href=\"javascript: selectView("+mfn+",'off');\">Title with Compacted Collection in IBICT Format</a><br />";
    var presentation = presentation + "</div></div>";
       elCell.innerHTML = presentation;
    };*/

    if(role == "Editor")
    {
    var myColumnDefs = [
    {key:"FASC",label:lblID,sortable:false},
    {key:"TITLE",label:lblTitle, formatter:this.myFormatTitle, sortable:false},
    {key:"ACTION",label:lblActionTitlePlus, formatter:this.myFormatTitPlus, sortable:false},
    {key:"FASC",label:lblActionFacic, formatter:this.myFormatFascic, sortable:false}
    ];
    }
    if(role == "Administrator")
    {
    var myColumnDefs = [
    {key:"FASC",label:lblID,sortable:false},
    {key:"TITLE",label:lblTitle, formatter:this.myFormatTitle, sortable:false},
    {key:"ACTION",label:lblActionTitle, formatter:this.myFormatAction, sortable:false},
    {key:"TITLEEDT",label:lblActionTitlePlus, formatter:this.myFormatTitPlus, sortable:false},
    {key:"FASC",label:lblActionFacic, formatter:this.myFormatFascic, sortable:false}
    //{key:"EXPORT",label:lblExport, formatter:this.myFormatExport, sortable:false}
    ];
    }
    
    var myTable = new DataTable('listRecords', myColumnDefs, mySource, myTableConfig);
    
    myTable.subscribe("cellMouseoverEvent",function(oArgs) {
		elTrRow = oArgs.target;
		YAHOO.util.Dom.addClass(this.getTrEl(elTrRow),"rowOver");
	});
	myTable.subscribe("cellMouseoutEvent",function(oArgs) {
		elTrRow = oArgs.target;
		YAHOO.util.Dom.removeClass(this.getTrEl(elTrRow),"rowOver");
	});      

});

	var handleCancel = function() {
		this.cancel();
	};

	function getCollectionAndDisplay(titleId, database, format) {

            var handleSuccess = function(o) {

                if (o.responseText.indexOf('empty')>=0 || o.responseText=='<p/>' ){
                    document.getElementById('collectionDisplayed').innerHTML = msgDoesNotExist;
                } else {
                    document.getElementById('collectionDisplayed').innerHTML = o.responseText;
                }
			
            }
		var handleFailure = function(o) {
			document.getElementById('collectionDisplayed').innerHTML = 'failure 1';
		}

		var callback = {
			success: handleSuccess,
			failure: handleFailure
		};

		switch (database) {
			case 'holdings':
				var sUrl = "getHolding.php?title="+titleId;
				break;
			case 'title':
				var sUrl = "displayFormat.php?m=title&edit="+titleId+"&format="+format;
				break;
			case 'titleplus':
				var sUrl = "displayFormat.php?m=titleplus&title="+titleId;
				break;
			case 'export':
				var sUrl = "displayFormat.php?m=export";
				break;
                }

		document.getElementById('collectionDisplayed').innerHTML = YAHOO.widget.DataTable.MSG_LOADING;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callback, "");

		YAHOO.example.container.collectionDialog.show();
	};
	
	YAHOO.example.container.collectionDialog = new YAHOO.widget.Dialog("collectionDialog",
							{ width : "50em",
							  fixedcenter : true,
							  visible : false,
							  constraintoviewport : true,
							  buttons : [ { text:"OK", handler:handleCancel } ]
							});
	
	YAHOO.example.container.collectionDialog.render();

    /*
     * Manda os dados para a funcao responsavel por
     * fazer a exportacao de arquivos
     */
    function exportFile(exportedType, numberRegisters, formatType, registerID, searchExpr, indexes){

        switch (exportedType) {

                case 'titWithoutCollection':
                    var fileName = document.getElementById("fileName").value;
                    break;
                case 'sendToSeCS-step2':
                    var fileName = document.getElementById("fileName2").value;
                    break;
               case 'sendToSeCS':
                    var fileName = document.getElementById("fileName").value;
                    document.getElementById("fileName2").value = fileName;
                    break;
                case 'titFormatIBICT':
                    var fileName = document.getElementById("fileName").value;
                    var ibictID = document.getElementById("ibictID").value;
                    document.getElementById('ibictID2').value = ibictID;
                    break;
                case 'titFormatIBICT-step2':
                    var fileName = document.getElementById("fileName2").value;
                    var ibictID = document.getElementById("ibictID2").value;
                    break;
                case 'titWithCollection':
                    var fileName = document.getElementById("fileName").value;
                    break;
        }

        hideExportDialog();
        var openURL = "index.php?m=title&export="+exportedType+"&filename="+fileName;
        if(ibictID){ openURL = openURL+"&ibictID="+ibictID; }
        if(numberRegisters){ openURL = openURL+"&numberRegisters="+numberRegisters; }
        if(formatType){ openURL = openURL+"&formatType="+formatType; }
        if(registerID){ openURL = openURL+"&registerID="+registerID; }
        if(searchExpr){ openURL = openURL+"&searchExpr="+searchExpr; }
        if(indexes){ openURL = openURL+"&indexes="+indexes; }

        var timeout = 1000;
        var t = 0;

        var handleSuccessExport = function(o) {
                //alert(openURL);
                window.location = openURL;
                //YAHOO.util.Connect.asyncRequest('POST', openURL, callback2, "");
                YAHOO.example.container.collectionDialog.hide();
                if(exportedType == "sendToSeCS" || exportedType == "titFormatIBICT"){
                    showExportDialog();
                }
        }

        var handleFailureExport = function(o) {
            document.getElementById('collectionDisplayed').innerHTML = 'failure';
        }

        var callback = {
                success: handleSuccessExport,
                failure: handleFailureExport
        };
            
        document.getElementById('collectionDisplayed').innerHTML = YAHOO.widget.DataTable.MSG_LOADING;
        YAHOO.example.container.collectionDialog.show();
        var request = YAHOO.util.Connect.asyncRequest('POST', openURL, callback, "");
            
    }

    /*
     * Exibe o widget dialog: exportDialogResizable
     * de acordo com a entrada de exportType
     */
    function exportDialog(exportType, numberRegisters, formatType, registerID) {

        switch (exportType) {
            case 'titWithoutCollection':
                document.getElementById('labelIbictID').style.display = "none";
                document.getElementById('ibictID').style.display = "none";
                document.getElementById('labelStepTitle').style.display = "none";
                    var btHref = "javascript: exportFile('titWithoutCollection', '"+numberRegisters+"', '"+formatType+"'";
                    if(numberRegisters == "oneRegister"){
                        btHref = btHref + ", '"+registerID+"'";
                    }else{
                         if(searchExpr != "" && searchExpr != null){
                            btHref = btHref + ",'' , '"+searchExpr+"', '"+indexes+"'";
                        }
                    }
                    document.getElementById('btSaveExport').href = btHref + ");";
                YAHOO.example.container.exportDialogResizable.show();
                break;
            case 'sendToSeCS':
                document.getElementById('fileName2').disabled = "disabled";
                document.getElementById('labelIbictID').style.display = "none";
                document.getElementById('ibictID').style.display = "none";
                document.getElementById('labelStepTitle').innerHTML = "<label><strong>"+lblStep1+"</strong></label><br/><br/>";
                document.getElementById('btSaveExport').href = "javascript: exportFile('sendToSeCS');";
                document.getElementById('btSaveExport2').href = "javascript: exportFile('sendToSeCS-step2'); hideExportDialog();";
                YAHOO.example.container.exportDialogResizable.show();
                
                break;
            case 'sendToNationalCollection':
                document.getElementById('labelStepTitle').innerHTML = "<label><strong>"+lblStep1+"</strong></label><br/><br/>";
                document.getElementById('labelIbictID').innerHTML = "<label><strong>"+lblIBICTId+"</strong></label><br/>";
                document.getElementById('ibictID').style.display = "block";
                document.getElementById('labelIbictID').style.display = "block";
                if(searchExpr == "null"){
                    document.getElementById('btSaveExport').href = "javascript: exportFile('titFormatIBICT');";
                    document.getElementById('btSaveExport2').href = "javascript: exportFile('titFormatIBICT-step2'); hideExportDialog();";
                }else{
                    document.getElementById('btSaveExport').href = "javascript: exportFile('titFormatIBICT');";
                    document.getElementById('btSaveExport2').href = "javascript: exportFile('titFormatIBICT-step2'); hideExportDialog();";
                }
                YAHOO.example.container.exportDialogResizable.show();
                break;
            case 'titWithCollection':
                document.getElementById('labelIbictID').style.display = "none";
                document.getElementById('ibictID').style.display = "none";
                document.getElementById('labelStepTitle').style.display = "none";
                if(numberRegisters == "oneRegister"){
                    document.getElementById('btSaveExport').href = "javascript: exportFile('titWithCollection', '"+numberRegisters+"', '"+formatType+"', '"+registerID+"');";
                }else{
                    document.getElementById('btSaveExport').href = "javascript: exportFile('titWithoutCollection', '"+numberRegisters+"', '"+formatType+"');";
                }
                YAHOO.example.container.exportDialogResizable.show();
                break;
        }
    }

        var handleSuccess = function(o) {
        }
        var handleFailure = function(o) {
        }

	YAHOO.example.container.exportDialogResizable = new YAHOO.widget.Dialog("exportDialogResizable",
							{ width : "50em",
							  fixedcenter : true,
							  visible : false
							});

	YAHOO.example.container.exportDialogResizable.callback = { success: handleSuccess,
                                   failure: handleFailure };

	YAHOO.example.container.exportDialogResizable.render();

	YAHOO.example.container.exportDialogResizableStep2 = new YAHOO.widget.Dialog("exportDialogResizable-step2",
							{ width : "50em",
							  fixedcenter : true,
							  visible : false
							});

	YAHOO.example.container.exportDialogResizableStep2.callback = { success: handleSuccess,
                                   failure: handleFailure };

	YAHOO.example.container.exportDialogResizableStep2.render();

        function checkTitlePlusAndExecute(titleId, location) {

            var timeout = 1000;
            var t = 0;

            var handleSuccess = function(o) {
                ret = o.responseText;
                if (ret == 'DOES_NOT_EXIST' || ret == 'nothing') {
                    YAHOO.example.container.checkTitlePlusDialog.show();
                } else {
                    window.location = location;
                }
                //globalExistTitlePlus = ret;
                //alert(ret);
            }

            var handleFailure = function(o) {
                //ret = 'failure';
                YAHOO.example.container.checkTitlePlusDialog.show();
                //globalExistTitlePlus = ret;
            }

            var callback = {
                    success: handleSuccess,
                    failure: handleFailure
            };
            var request = YAHOO.util.Connect.asyncRequest('GET', '?m=titleplus&action=exist&title='+titleId, callback, "");
            
        };

	YAHOO.example.container.checkTitlePlusDialog = new YAHOO.widget.Dialog("checkTitlePlusDialog",
							{ width : "40em",
							  fixedcenter : true,
							  visible : false,
							  constraintoviewport : true,
							  buttons : [ { text:"OK", handler:handleCancel } ]
							});

	YAHOO.example.container.checkTitlePlusDialog.render();

{/literal}
</script>

<div class="helpBG" id="formRow01_helpA" style="display: none;">
    <div class="helpArea">
            <span class="exit"><a href="javascript:showHideDiv('formRow01_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
            <h2>{$BVS_LANG.help} - {$BVS_LANG.field} {$BVS_LANG.lblSearchTitle}</h2>
            <div class="help_message">
                {$BVS_LANG.helpSearchTitle}
            </div>
    </div>
</div>
