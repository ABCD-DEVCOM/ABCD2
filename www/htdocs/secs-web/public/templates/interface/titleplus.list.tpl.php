<div id="menuExport" style="display: none;">
    <a href="javascript: fullExportMenu('allRegisters');">{$BVS_LANG.btAllRegisters}</a><br/>
    <a href="javascript: fullExportMenu('oneRegister');">{$BVS_LANG.btOneRegister}</a><br/>
    <span class="exit"><a href="javascript: hideFullExportMenu();" title="Fechar"><img src="public/images/common/icon/singleButton_erase.png" alt="cancel" /></a></span>
    <!--span><a href="javascript: exportDialog('titWithoutCollection');">{$BVS_LANG.btExportAllTitWithoutCollection}</a></span><br/>
    <span><a href="javascript: exportDialog('titFormatSeCS');">{$BVS_LANG.btExportAllTitFormatSeCS}</a></span><br/>
    <span><a href="javascript: exportDialog('titFormatISSN');">{$BVS_LANG.btExportAllTitFormatISSN}</a></span><br/-->
</div>

<div id="formatMenuAllRegisters" style="display: none;">
    <span><a href="javascript: fullExportMenu('secsFormat', 'allRegisters'); ">{$BVS_LANG.btSeCSFormat}</a></span><br/>
    <span><a href="javascript: fullExportMenu('marcFormat', 'allRegisters'); ">{$BVS_LANG.btMarcFormat}</a></span><br/>
    <span><a href="javascript: showHideDiv('formatMenuAllRegisters');" title="Fechar"><img src="public/images/common/icon/singleButton_back.png" alt="cancel" /></a></span>
    <span class="exit"><a href="javascript: hideFullExportMenu();" title="Fechar"><img src="public/images/common/icon/singleButton_erase.png" alt="cancel" /></a></span>


</div>
<div id="formatMenuOneRegister" style="display: none;">
    <span><a href="javascript: fullExportMenu('secsFormat', 'oneRegister'); ">{$BVS_LANG.btSeCSFormat}</a></span><br/>
    <span><a href="javascript: fullExportMenu('marcFormat', 'oneRegister'); ">{$BVS_LANG.btMarcFormat}</a></span><br/>
    <span><a href="javascript: showHideDiv('formatMenuOneRegister');" title="Fechar"><img src="public/images/common/icon/singleButton_back.png" alt="cancel" /></a></span>
    <span class="exit"><a href="javascript: hideFullExportMenu();" title="Fechar"><img src="public/images/common/icon/singleButton_erase.png" alt="cancel" /></a></span>
</div>

<div id="collectionMenuSeCSFormat" style="display: none;">
    <span><a href="javascript: exportDialog('titWithoutCollection', 'allRegisters', 'secsFormat'); hideFullExportMenu();">{$BVS_LANG.btExportAllTitWithoutCollection}</a></span><br/>
    <span><a href="javascript: exportDialog('titFormatSeCS', 'allRegisters', 'secsFormat'); hideFullExportMenu();">{$BVS_LANG.btExportAllTitFormatSeCS}</a></span><br/>
    <span><a href="javascript: showHideDiv('collectionMenuSeCSFormat');" title="Fechar"><img src="public/images/common/icon/singleButton_back.png" alt="cancel" /></a></span>
    <span class="exit"><a href="javascript: hideFullExportMenu();" title="Fechar"><img src="public/images/common/icon/singleButton_erase.png" alt="cancel" /></a></span>
</div>

<div id="collectionMenuMarcFormat" style="display: none;">
    <span><a href="javascript: exportDialog('titWithoutCollection', 'oneRegister', 'marcFormat'); hideFullExportMenu();">{$BVS_LANG.btExportAllTitWithoutCollection}</a></span><br/>
    <span><a href="javascript: exportDialog('titFormatSeCS', 'oneRegister', 'marcFormat'); hideFullExportMenu();">{$BVS_LANG.btExportAllTitFormatSeCS}</a></span><br/>
    <span><a href="javascript: showHideDiv('collectionMenuMarcFormat');" title="Fechar"><img src="public/images/common/icon/singleButton_back.png" alt="cancel" /></a></span>
    <span class="exit"><a href="javascript: hideFullExportMenu();" title="Fechar"><img src="public/images/common/icon/singleButton_erase.png" alt="cancel" /></a></span>
</div>

<div id="catalogExport" style="display: none;">
    <span><a href="javascript: exportDialog('sendToSeCS'); hideFullExportMenu();">{$BVS_LANG.btSendToSeCS}</a></span><br/>
    <span><a href="javascript: exportDialog('sendToNationalCollection'); hideFullExportMenu();">{$BVS_LANG.btSendToNationalCollection}</a></span><br/>
    <span class="exit"><a href="javascript: hideFullExportMenu();" title="Fechar"><img src="public/images/common/icon/singleButton_erase.png" alt="cancel" /></a></span>
</div>

{if $smarty.session.role eq "Administrator" || $smarty.session.role eq "Editor"}
<div class="yui-skin-sam">
   <div id="collectionDialog">
      <div class="hd">{$BVS_LANG.titleApp}</div>
        <div class="bd">
            <div id="collectionDisplayed"></div>
      </div>
   </div>
</div>

<div id="listRecords" class="listTable"></div>
<script type="text/javascript">
var lblID  = "{$BVS_LANG.lblID}";
var lblLibrary  = "{$BVS_LANG.library}";
var lblTitle  = "{$BVS_LANG.title}";
var lblCenterCode  = "{$BVS_LANG.lblCenterCod}";
var lblAcquisitionMethod = "{$BVS_LANG.lblAcquisitionMethod}";
var lblAcquisitionControl = "{$BVS_LANG.lblAcquisitionControl}";
var lblExpirationSubs = "{$BVS_LANG.lblExpirationSubs}";
var lblProvider = "{$BVS_LANG.lblProvider}";
var lblActionFacic = "{$BVS_LANG.ActionFacic}";
var lblinitialVolume = "{$BVS_LANG.lblinitialVolume}";
var lblinitialDate = "{$BVS_LANG.lblinitialDate}";
var lblinitialNumber = "{$BVS_LANG.lblinitialNumber}";
var btList = "{$BVS_LANG.lblList}";
var lblFacic  = "{$BVS_LANG.facic}";
var lblViewHldg = "{$BVS_LANG.lblViewHldg}";
var msgWaiting = "{$BVS_LANG.lblHldgMessage}";
var lblTitlePlus  = "{$BVS_LANG.titlePlus}";

var btEdTitlePlus = "{$BVS_LANG.btEdTitlePlus}";
var lblAction = "{$BVS_LANG.lblAction}";
var btDelete = "{$BVS_LANG.btEraserRecord}";
var btNext = "{$BVS_LANG.btNext}";
var btPrevious = "{$BVS_LANG.btPrevious}";
var btFirst = "{$BVS_LANG.btFirst}";
var btLast = "{$BVS_LANG.btLast}";
var lblPerPage = "{$BVS_LANG.perPage}";
var lblViewOf = "{$BVS_LANG.lblViewOf}";
var search = "{$smarty.get.searchExpr}";
var lblTitPlusInfo = "{$BVS_LANG.lblTitlePlusInformation}";
var numRecordsPage = {$BVS_CONF.numRecordsPage};
var hRequest = "";
var searchExpr = null;
var indexes = null;
var m = null;
var d = new Date();
var t = d.getTime();
hRequest = "&tty=" + t;
YAHOO.namespace("example.container");

{if $smarty.request.searchExpr}
var searchExpr = "{$smarty.request.searchExpr}";
{/if}
{if $smarty.request.indexes}
var indexes = "{$smarty.request.indexes}";
{/if}
{if $smarty.get.m}
m = "{$smarty.get.m}";
{/if}

//Customizing the interface YUI DataTable
YAHOO.widget.DataTable.MSG_LOADING = "<div class='loading'><div>{$BVS_LANG.MSG_LOADING}</div></div>";
YAHOO.widget.DataTable.MSG_EMPTY = "{$BVS_LANG.MSG_EMPTY}";
YAHOO.widget.DataTable.MSG_ERROR = "{$BVS_LANG.MSG_ERROR}";
YAHOO.widget.DataTable.CLASS_DESC = "desc";
YAHOO.widget.DataTable.CLASS_ASC = "asc";
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

// Patch for width and/or minWidth Column values bug in non-scrolling DataTables
(function(){var B=YAHOO.widget.DataTable,A=YAHOO.util.Dom;B.prototype._setColumnWidth=function(I,D,J){I=this.getColumn(I);if(I){J=J||"hidden";if(!B._bStylesheetFallback){var N;if(!B._elStylesheet){N=document.createElement("style");N.type="text/css";B._elStylesheet=document.getElementsByTagName("head").item(0).appendChild(N)}if(B._elStylesheet){N=B._elStylesheet;var M=".yui-dt-col-"+I.getId();var K=B._oStylesheetRules[M];if(!K){if(N.styleSheet&&N.styleSheet.addRule){N.styleSheet.addRule(M,"overflow:"+J);N.styleSheet.addRule(M,"width:"+D);K=N.styleSheet.rules[N.styleSheet.rules.length-1]}else{if(N.sheet&&N.sheet.insertRule){N.sheet.insertRule(M+" {overflow:"+J+";width:"+D+";}",N.sheet.cssRules.length);K=N.sheet.cssRules[N.sheet.cssRules.length-1]}else{B._bStylesheetFallback=true}}B._oStylesheetRules[M]=K}else{K.style.overflow=J;K.style.width=D}return }B._bStylesheetFallback=true}if(B._bStylesheetFallback){if(D=="auto"){D=""}var C=this._elTbody?this._elTbody.rows.length:0;if(!this._aFallbackColResizer[C]){var H,G,F;var L=["var colIdx=oColumn.getKeyIndex();","oColumn.getThEl().firstChild.style.width="];for(H=C-1,G=2;H>=0;--H){L[G++]="this._elTbody.rows[";L[G++]=H;L[G++]="].cells[colIdx].firstChild.style.width=";L[G++]="this._elTbody.rows[";L[G++]=H;L[G++]="].cells[colIdx].style.width="}L[G]="sWidth;";L[G+1]="oColumn.getThEl().firstChild.style.overflow=";for(H=C-1,F=G+2;H>=0;--H){L[F++]="this._elTbody.rows[";L[F++]=H;L[F++]="].cells[colIdx].firstChild.style.overflow=";L[F++]="this._elTbody.rows[";L[F++]=H;L[F++]="].cells[colIdx].style.overflow="}L[F]="sOverflow;";this._aFallbackColResizer[C]=new Function("oColumn","sWidth","sOverflow",L.join(""))}var E=this._aFallbackColResizer[C];if(E){E.call(this,I,D,J);return }}}else{}};B.prototype._syncColWidths=function(){var J=this.get("scrollable");if(this._elTbody.rows.length>0){var M=this._oColumnSet.keys,C=this.getFirstTrEl();if(M&&C&&(C.cells.length===M.length)){var O=false;if(J&&(YAHOO.env.ua.gecko||YAHOO.env.ua.opera)){O=true;if(this.get("width")){this._elTheadContainer.style.width="";this._elTbodyContainer.style.width=""}else{this._elContainer.style.width=""}}var I,L,F=C.cells.length;for(I=0;I<F;I++){L=M[I];if(!L.width){this._setColumnWidth(L,"auto","visible")}}for(I=0;I<F;I++){L=M[I];var H=0;var E="hidden";if(!L.width){var G=L.getThEl();var K=C.cells[I];if(J){var N=(G.offsetWidth>K.offsetWidth)?G.firstChild:K.firstChild;if(G.offsetWidth!==K.offsetWidth||N.offsetWidth<L.minWidth){H=Math.max(0,L.minWidth,N.offsetWidth-(parseInt(A.getStyle(N,"paddingLeft"),10)|0)-(parseInt(A.getStyle(N,"paddingRight"),10)|0))}}else{if(K.offsetWidth<L.minWidth){E=K.offsetWidth?"visible":"hidden";H=Math.max(0,L.minWidth,K.offsetWidth-(parseInt(A.getStyle(K,"paddingLeft"),10)|0)-(parseInt(A.getStyle(K,"paddingRight"),10)|0))}}}else{H=L.width}if(L.hidden){L._nLastWidth=H;this._setColumnWidth(L,"1px","hidden")}else{if(H){this._setColumnWidth(L,H+"px",E)}}}if(O){var D=this.get("width");this._elTheadContainer.style.width=D;this._elTbodyContainer.style.width=D}}}this._syncScrollPadding()}})();
// Patch for initial hidden Columns bug
(function(){var A=YAHOO.util,B=YAHOO.env.ua,E=A.Event,C=A.Dom,D=YAHOO.widget.DataTable;D.prototype._initTheadEls=function(){var X,V,T,Z,I,M;if(!this._elThead){Z=this._elThead=document.createElement("thead");I=this._elA11yThead=document.createElement("thead");M=[Z,I];E.addListener(Z,"focus",this._onTheadFocus,this);E.addListener(Z,"keydown",this._onTheadKeydown,this);E.addListener(Z,"mouseover",this._onTableMouseover,this);E.addListener(Z,"mouseout",this._onTableMouseout,this);E.addListener(Z,"mousedown",this._onTableMousedown,this);E.addListener(Z,"mouseup",this._onTableMouseup,this);E.addListener(Z,"click",this._onTheadClick,this);E.addListener(Z.parentNode,"dblclick",this._onTableDblclick,this);this._elTheadContainer.firstChild.appendChild(I);this._elTbodyContainer.firstChild.appendChild(Z)}else{Z=this._elThead;I=this._elA11yThead;M=[Z,I];for(X=0;X<M.length;X++){for(V=M[X].rows.length-1;V>-1;V--){E.purgeElement(M[X].rows[V],true);M[X].removeChild(M[X].rows[V])}}}var N,d=this._oColumnSet;var H=d.tree;var L,P;for(T=0;T<M.length;T++){for(X=0;X<H.length;X++){var U=M[T].appendChild(document.createElement("tr"));P=(T===1)?this._sId+"-hdrow"+X+"-a11y":this._sId+"-hdrow"+X;U.id=P;for(V=0;V<H[X].length;V++){N=H[X][V];L=U.appendChild(document.createElement("th"));if(T===0){N._elTh=L}P=(T===1)?this._sId+"-th"+N.getId()+"-a11y":this._sId+"-th"+N.getId();L.id=P;L.yuiCellIndex=V;this._initThEl(L,N,X,V,(T===1))}if(T===0){if(X===0){C.addClass(U,D.CLASS_FIRST)}if(X===(H.length-1)){C.addClass(U,D.CLASS_LAST)}}}if(T===0){var R=d.headers[0];var J=d.headers[d.headers.length-1];for(X=0;X<R.length;X++){C.addClass(C.get(this._sId+"-th"+R[X]),D.CLASS_FIRST)}for(X=0;X<J.length;X++){C.addClass(C.get(this._sId+"-th"+J[X]),D.CLASS_LAST)}var Q=(A.DD)?true:false;var c=false;if(this._oConfigs.draggableColumns){for(X=0;X<this._oColumnSet.tree[0].length;X++){N=this._oColumnSet.tree[0][X];if(Q){L=N.getThEl();C.addClass(L,D.CLASS_DRAGGABLE);var O=D._initColumnDragTargetEl();N._dd=new YAHOO.widget.ColumnDD(this,N,L,O)}else{c=true}}}for(X=0;X<this._oColumnSet.keys.length;X++){N=this._oColumnSet.keys[X];if(N.resizeable){if(Q){L=N.getThEl();C.addClass(L,D.CLASS_RESIZEABLE);var G=L.firstChild;var F=G.appendChild(document.createElement("div"));F.id=this._sId+"-colresizer"+N.getId();N._elResizer=F;C.addClass(F,D.CLASS_RESIZER);var e=D._initColumnResizerProxyEl();N._ddResizer=new YAHOO.util.ColumnResizer(this,N,L,F.id,e);var W=function(f){E.stopPropagation(f)};E.addListener(F,"click",W)}else{c=true}}}if(c){}}else{}}for(var a=0,Y=this._oColumnSet.keys.length;a<Y;a++){if(this._oColumnSet.keys[a].hidden){var b=this._oColumnSet.keys[a];var S=b.getThEl();b._nLastWidth=S.offsetWidth-(parseInt(C.getStyle(S,"paddingLeft"),10)|0)-(parseInt(C.getStyle(S,"paddingRight"),10)|0);this._setColumnWidth(b.getKeyIndex(),"1px")}}if(B.webkit&&B.webkit<420){var K=this;setTimeout(function(){K._elThead.style.display=""},0);this._elThead.style.display="none"}}})();

YAHOO.util.Event.addListener(window, "load", function() {
YAHOO.example.ClientPagination = new function() {

    this.myFormatAction = function(elCell, oRecord, oColumn, oData) {
        var mfn = oRecord.getData('MFN');
        var title = oRecord.getData('titleCode');
        var id = oRecord.getId();
        //elCell.innerHTML = "<a href=\"?m=titleplus&edit=" + mfn + "&title="+title+"&tty="+t+"&searchExpr="+search+"\" class=\"tButton\">"+btEdTitlePlus+"</a> <a href=\"?m=titleplus&action=delete&id="+mfn+"\" class=\"tButton tErase\">"+btDelete+"</a>";
        btViewTitPlus = "<a href=\"javascript: getCollectionAndDisplay('"+title+"', 'titleplus'); \" ><img src=\"public/images/common/icon/singleButton_info.png\" title=\""+lblTitPlusInfo+"\" alt=\""+lblTitPlusInfo+"\" id=\"btAdd"+id+"\"/></a>  ";
        btCreatEditTitPlus = "<a href=\"?m=titleplus&edit=" + mfn + "&title="+title+"&tty="+t+"&searchExpr="+search+"\" ><img src=\"public/images/common/icon/singleButton_edit.png\" title=\""+btEdTitlePlus+"\" alt=\""+btEdTitlePlus+"\" /></a>  ";
        btDeleteTitPlus = "<a href=\"?m=titleplus&action=delete&id="+mfn+ "&title="+title+"\" ><img src=\"public/images/common/icon/singleButton_delete.png\" title=\""+btDelete+" "+lblTitle+"\" alt=\""+btDelete+ " "+lblTitlePlus+"\" /></a>";
        elCell.innerHTML = btViewTitPlus + btCreatEditTitPlus + btDeleteTitPlus;
    };

    this.myFormatFascic = function(elCell, oRecord, oColumn, oData) {
        var mfn = oRecord.getData('MFN');
        var titleCode = oRecord.getData('titleCode');
        var initialDate = oRecord.getData('initialDate');
        var initialVolume = oRecord.getData('initialVolume');
        var initialNumber = oRecord.getData('initialNumber');
        
        tQuery = "?m=facic&title="+titleCode+"&tty="+d.getTime()+"&initialDate="+initialDate+"&initialVolume="+initialVolume+"&initialNumber="+initialNumber+"&listRequest=titleplus";
        var btEditIssues = '<a href="javascript: checkTitlePlusAndExecute(\''+titleCode+'\',\''+tQuery+'\');" ><img src="public/images/common/icon/singleButton_listIssues.png" title="'+btList+'" "'+lblFacic+'" alt="'+btList+'" "'+lblFacic+'" /></a>';
        var btViewHldg = " <a href=\"javascript: getCollectionAndDisplay('"+titleCode+"', 'holdings'); \" ><img src=\"public/images/common/icon/singleButton_viewHoldings.png\" title=\""+lblViewHldg+"\" alt=\""+lblViewHldg+"\" /></a>";
        elCell.innerHTML = btEditIssues + btViewHldg
    };

    var myColumnDefs = [
        {key:"titleCode", label:lblID},
        {key:"titleName", label:lblTitle},
        {key:"acquisitionControl", label:lblAcquisitionControl, width:"10px"},
        {key:"acquisitionMethod", label:lblAcquisitionMethod},
        {key:"expirationSubs", label:lblExpirationSubs},
        {key:"provider", label:lblProvider},
        {key:"ACTION", label:lblAction, formatter:this.myFormatAction},
        {key:"FACIC",label:lblActionFacic, formatter:this.myFormatFascic}
    ];

    this.myDataSource = new YAHOO.util.DataSource("yuiservice.php?" + hRequest);
    this.myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;

    // When responseSchema.totalRecords is not indicated, the records
    // returned from the DataSource are assumed to represent the entire set
    this.myDataSource.responseSchema = {
        resultsList: "records",
        fields: [{key:"MFN",parser:YAHOO.util.DataSource.parseNumber},
                {key:"titleName", parser:YAHOO.util.DataSource.parseString},
                {key:"initialDate",parser:YAHOO.util.DataSource.parseString},
                {key:"initialVolume",parser:YAHOO.util.DataSource.parseString},
                {key:"initialNumber",parser:YAHOO.util.DataSource.parseString},
                {key:"acquisitionControl", parser:YAHOO.util.DataSource.parseString},
                {key:"acquisitionMethod", parser:YAHOO.util.DataSource.parseString},
                {key:"expirationSubs", parser:YAHOO.util.DataSource.parseString},
                {key:"provider", parser:YAHOO.util.DataSource.parseString},
                {key:"centerCode", parser:YAHOO.util.DataSource.parseString},
                {key:"titleCode", parser:YAHOO.util.DataSource.parseString},
                {key:"ACTION", parser:YAHOO.util.DataSource.parseNumber}],
        metaFields: {totalRecords: "totalRecords"}
    };

    // A custom function to translate the js paging request into a query
    // string sent to the XHR DataSource
    var buildQueryString = function (state,dt) {
    return "&startIndex=" + state.pagination.recordOffset + "&results=" + state.pagination.rowsPerPage;
    };

    // The Paginator instance will have its totalRecords configuration
    // populated by the DataTable when it receives the records from the
    // DataSource
    var oConfigs = {
            paginator: new YAHOO.widget.Paginator({
                containers         : ['pagination'],
                pageLinks          : 5,
                rowsPerPage        : numRecordsPage,
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
                // Options for NextPageLink component
                nextPageLinkLabel : btNext + " &gt;", // default
                nextPageLinkClass : "singleButton eraseButton", // default
                template           : "{FirstPageLink} {PreviousPageLink} " + "{PageLinks} " + "{NextPageLink} {LastPageLink}  " + lblViewOf + " {RowsPerPageDropdown} " + lblPerPage,
                // use custom page link labels
                pageLabelBuilder : function (page,paginator) {
                    var recs = paginator.getPageRecords(page);
                    return (recs[0] + 1) + ' - ' + (recs[1] + 1);
                }
            }),

            // Show over 500 records
            initialRequest: "&startIndex=0&results=" +numRecordsPage,
            generateRequest: buildQueryString,
            paginationEventHandler : YAHOO.widget.DataTable.handleDataSourcePagination
        };

        this.myDataTable = new YAHOO.widget.DataTable("listRecords", myColumnDefs, this.myDataSource, oConfigs);
        this.myDataTable.subscribe("cellMouseoverEvent",function(oArgs) {
			elTrRow = oArgs.target;
			YAHOO.util.Dom.addClass(this.getTrEl(elTrRow),"rowOver");
		});
        this.myDataTable.subscribe("cellMouseoutEvent",function(oArgs) {
                elTrRow = oArgs.target;
                YAHOO.util.Dom.removeClass(this.getTrEl(elTrRow),"rowOver");
        });
    };
});

	var handleCancel = function() {
		this.cancel();
	};

        /* Facic  Display */
	function callIssues(titleId) {

		var handleSuccess2 = function(o) {
			document.getElementById('collectionDisplayed').innerHTML = o.responseText;
		}
		var handleFailure2 = function(o) {
			document.getElementById('collectionDisplayed').innerHTML = 'failure';
		}

		var callback2 = {
			success: handleSuccess2,
			failure: handleFailure2
		};

                var sUrl2 = "displayFormat.php?m=facic&title="+titleId;
		var postData2 = "";
		//document.getElementById('collectionDisplayed').innerHTML = msgWaiting;
		var request2 = YAHOO.util.Connect.asyncRequest('POST', sUrl2, callback2, postData2);


		YAHOO.example.container.callIssues.toString();
	};

        	YAHOO.example.container.callIssues = new YAHOO.widget.Dialog("callIssues",
							{ width : "90em",
							  fixedcenter : true,
							  visible : false,
							  constraintoviewport : true,
							  buttons : [ { text:"OK", handler:handleCancel } ]
							});

                                                        
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

        
        /* Holding Display */
	function getCollectionAndDisplay(titleId, database, format) {
                
		var handleSuccess = function(o) {
			document.getElementById('collectionDisplayed').innerHTML = o.responseText;
		}
		var handleFailure = function(o) {
			document.getElementById('collectionDisplayed').innerHTML = 'failure';
		}

		var callback = {
			success: handleSuccess,
			failure: handleFailure
		};

 		switch (database) {
			case 'holdings':
				var sUrl = "getHolding.php?title="+titleId;
				break;
			case 'titleplus':
				var sUrl = "displayFormat.php?m=titleplus&title="+titleId;
				break;
			case 'title':
				var sUrl = "displayFormat.php?m=title&edit="+titleId+"&format="+format;
				break;
		}
		var postData = "";

		document.getElementById('collectionDisplayed').innerHTML = msgWaiting;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callback, postData);


		YAHOO.example.container.collectionDialog.show();
	};

	YAHOO.example.container.collectionDialog = new YAHOO.widget.Dialog("collectionDialog",
							{ width : "90em",
							  fixedcenter : true,
							  visible : false,
							  constraintoviewport : true,
							  buttons : [ { text:"OK", handler:handleCancel } ]
							});

	YAHOO.example.container.collectionDialog.render();

{/literal}
</script>

<div class="helpBG" id="formRow01_helpA" style="display: none;">
    <div class="helpArea">
            <span class="exit"><a href="javascript:showHideDiv('formRow01_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
            <h2>{$BVS_LANG.help} - {$BVS_LANG.field} {$BVS_LANG.lblSearchTitlePlus}</h2>
            <div class="help_message">
                {$BVS_LANG.helpSearchTitlePlus}
            </div>
    </div>
</div>
{/if}