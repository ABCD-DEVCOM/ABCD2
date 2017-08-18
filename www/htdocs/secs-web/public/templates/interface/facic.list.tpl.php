<!--div style="clear:both;margin: 3 0 3 0;">&nbsp;</div-->
<div class="yui-skin-sam">

    <div id="facicDialogResizable">
        <div class="hd">{$BVS_LANG.titleApp}</div>
        <div class="bd">
            {include file="facic.list.form.tpl.php"}
        </div>
        <div class="ft"></div>
    </div>
    <div id="SavingMessageDialog">
        <div class="hd">{$BVS_LANG.titleApp}</div>
        <div class="bd">
            <div>{$BVS_LANG.msgSaving}</div>
        </div>
    </div>
    <div  id="AnyMessageDialog">
        <div class="hd">{$BVS_LANG.titleApp}</div>
        <div class="bd">
            <div id="anyMessage"></div>
        </div>
    </div>
    <div id="dialog1">
        <div class="hd">{$BVS_LANG.lblSelectMask}</div>
        <div class="bd">
            <form id="maskForm" method="POST" action="?m=facic&title={$smarty.get.title}&initialDate={$smarty.get.initialDate}&initialVolume={$smarty.get.initialVolume}&initialNumber={$smarty.get.initialNumber}">
                <label for="selectMask"><strong>{$BVS_LANG.mask}</strong></label>
                <select id="selectMask" name="maskId" class="smallTextEntry">
                        {html_options values=$collectionMask output=$collectionMask selected=$newDataRecord.codeNameMask}
                </select>
                <span id="selectMask_help">
                        <a href="javascript:showHideDiv('selectMask_helpA')"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>
                </span>
                <div class="helpBG" id="selectMask_helpA" style="display: none;">
                    <div class="helpArea">
                        <span class="exit"><a href="javascript:showHideDiv('selectMask_helpA');" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png" alt="cancel" /></a></span>
                        <h2>{$BVS_LANG.help} - {$BVS_LANG.lblSelectMask}</h2>
                        <div class="help_message">{$BVS_LANG.helpFacicMask}</div>
                    </div>
                </div>
            </form>
            <div id="dialog1Message"></div>
        </div>
    </div>

    <div id="addRowsDialog">
        <div class="hd">{$BVS_LANG.lblYear}</div>
        <div class="bd">
            <form method="POST" action="#">
                <select id="untilYear" name="untilYear" class="smallTextEntry">
                   {html_options values=$yearList output=$yearList}
                </select>
            </form>
            <div id="addRowsDialogMessage"></div>
        </div>
    </div>

    <div id="collectionDialog">
        <div class="hd">{$BVS_LANG.lblHldg}</div>
        <div class="bd">
            <div id="collectionDisplayed"></div>
        </div>
    </div>
    
<form name="formReload" method="POST" action="?m=facic&title={$smarty.get.title}&initialDate={$smarty.get.initialDate}&initialVolume={$smarty.get.initialVolume}&initialNumber={$smarty.get.initialNumber}">
</form>
</div>
<div id="listRecords" class="listTable"></div>
<div id="futureIssues" xstyle="display:none;"></div>

<script type="text/javascript">	   
var msgInvalidMaskForThisFacic = '{$BVS_LANG.msgInvalidMaskForThisFacic}';
var i_new = 0;
var facicCount = {$totalRecords};
{$x}
var today = "{$today}";
var username = "{$smarty.session.logged}";
var lblHldgMessage = "{$BVS_LANG.lblHldgMessage}";
var currentMask = "{$currentMask}";
var initialDate = "{$smarty.get.initialDate}";
var thisTable = null;
var msgWaiting = "{$BVS_LANG.msgWaiting}";
var lblViewOf = "{$BVS_LANG.lblViewOf}";
var lblUntil  = "{$BVS_LANG.lblUntil}";
var lblOf  = "{$BVS_LANG.lblOf}";
var lblID  = "{$BVS_LANG.lblID}";
var lblIssue = "{$BVS_LANG.lblFacic}";
var lblFacic  = "{$BVS_LANG.lblIssueNumber}";
var lblMask = "{$BVS_LANG.mask}";
var lblAction = "{$BVS_LANG.lblAction}";
var lblYear = "{$BVS_LANG.lblYear}";
var lblVol = "{$BVS_LANG.lblVol}";
var lblStatus = "{$BVS_LANG.lblColPA}";
var lblType = "{$BVS_LANG.lblColPubType}";
var lblQtd = "{$BVS_LANG.lblColQtd}";
var lblNote = "{$BVS_LANG.lblNote}";
var btEdFasc = "{$BVS_LANG.btEdFasc}";
var btDelete = "{$BVS_LANG.btDeleteRecord}";
var btAddFasc = "{$BVS_LANG.btAddFasc}";
var btInsertFascBetween = "{$BVS_LANG.btInsFascBetween}";
var btNext = "{$BVS_LANG.btNext}";
var btPrevious = "{$BVS_LANG.btPrevious}";
var btFirst = "{$BVS_LANG.btFirst}";
var btLast = "{$BVS_LANG.btLast}";
var lblPerPage = "{$BVS_LANG.perPage}";
var search = "{$smarty.get.searchExpr}";
var numRecordsPage = {$BVS_CONF.numRecordsPage};
var searchExpr = null;
var indexes = null;
var title = null;
var m = null;
var d = new Date();
var hRequest = null;
var futureIssues = new Array();
var i_futureIssues = 0;
var futureIssuesLoaded = false;
var askForHoldingsExecution = false;
var centerCode = "{$smarty.session.centerCode}";
var btInsertRecord = "{$BVS_LANG.btInsertRecord}";
var btDeleteRecord = "{$BVS_LANG.btDeleteRecord}";

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
    var m = "{$smarty.get.m}";
{/if}
{if $smarty.get.title}
    var title = "{$smarty.get.title}";
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
if(title != null) {
    hRequest = hRequest + "&title=" + title;
}	
YAHOO.widget.DataTable.CLASS_DESC = "desc";
YAHOO.widget.DataTable.CLASS_ASC = "asc";
YAHOO.namespace("example.container");

// Patch for width and/or minWidth Column values bug in non-scrolling DataTables
(function(){var B=YAHOO.widget.DataTable,A=YAHOO.util.Dom;B.prototype._setColumnWidth=function(I,D,J){I=this.getColumn(I);if(I){J=J||"hidden";if(!B._bStylesheetFallback){var N;if(!B._elStylesheet){N=document.createElement("style");N.type="text/css";B._elStylesheet=document.getElementsByTagName("head").item(0).appendChild(N)}if(B._elStylesheet){N=B._elStylesheet;var M=".yui-dt-col-"+I.getId();var K=B._oStylesheetRules[M];if(!K){if(N.styleSheet&&N.styleSheet.addRule){N.styleSheet.addRule(M,"overflow:"+J);N.styleSheet.addRule(M,"width:"+D);K=N.styleSheet.rules[N.styleSheet.rules.length-1]}else{if(N.sheet&&N.sheet.insertRule){N.sheet.insertRule(M+" {overflow:"+J+";width:"+D+";}",N.sheet.cssRules.length);K=N.sheet.cssRules[N.sheet.cssRules.length-1]}else{B._bStylesheetFallback=true}}B._oStylesheetRules[M]=K}else{K.style.overflow=J;K.style.width=D}return }B._bStylesheetFallback=true}if(B._bStylesheetFallback){if(D=="auto"){D=""}var C=this._elTbody?this._elTbody.rows.length:0;if(!this._aFallbackColResizer[C]){var H,G,F;var L=["var colIdx=oColumn.getKeyIndex();","oColumn.getThEl().firstChild.style.width="];for(H=C-1,G=2;H>=0;--H){L[G++]="this._elTbody.rows[";L[G++]=H;L[G++]="].cells[colIdx].firstChild.style.width=";L[G++]="this._elTbody.rows[";L[G++]=H;L[G++]="].cells[colIdx].style.width="}L[G]="sWidth;";L[G+1]="oColumn.getThEl().firstChild.style.overflow=";for(H=C-1,F=G+2;H>=0;--H){L[F++]="this._elTbody.rows[";L[F++]=H;L[F++]="].cells[colIdx].firstChild.style.overflow=";L[F++]="this._elTbody.rows[";L[F++]=H;L[F++]="].cells[colIdx].style.overflow="}L[F]="sOverflow;";this._aFallbackColResizer[C]=new Function("oColumn","sWidth","sOverflow",L.join(""))}var E=this._aFallbackColResizer[C];if(E){E.call(this,I,D,J);return }}}else{}};B.prototype._syncColWidths=function(){var J=this.get("scrollable");if(this._elTbody.rows.length>0){var M=this._oColumnSet.keys,C=this.getFirstTrEl();if(M&&C&&(C.cells.length===M.length)){var O=false;if(J&&(YAHOO.env.ua.gecko||YAHOO.env.ua.opera)){O=true;if(this.get("width")){this._elTheadContainer.style.width="";this._elTbodyContainer.style.width=""}else{this._elContainer.style.width=""}}var I,L,F=C.cells.length;for(I=0;I<F;I++){L=M[I];if(!L.width){this._setColumnWidth(L,"auto","visible")}}for(I=0;I<F;I++){L=M[I];var H=0;var E="hidden";if(!L.width){var G=L.getThEl();var K=C.cells[I];if(J){var N=(G.offsetWidth>K.offsetWidth)?G.firstChild:K.firstChild;if(G.offsetWidth!==K.offsetWidth||N.offsetWidth<L.minWidth){H=Math.max(0,L.minWidth,N.offsetWidth-(parseInt(A.getStyle(N,"paddingLeft"),10)|0)-(parseInt(A.getStyle(N,"paddingRight"),10)|0))}}else{if(K.offsetWidth<L.minWidth){E=K.offsetWidth?"visible":"hidden";H=Math.max(0,L.minWidth,K.offsetWidth-(parseInt(A.getStyle(K,"paddingLeft"),10)|0)-(parseInt(A.getStyle(K,"paddingRight"),10)|0))}}}else{H=L.width}if(L.hidden){L._nLastWidth=H;this._setColumnWidth(L,"1px","hidden")}else{if(H){this._setColumnWidth(L,H+"px",E)}}}if(O){var D=this.get("width");this._elTheadContainer.style.width=D;this._elTbodyContainer.style.width=D}}}this._syncScrollPadding()}})();
// Patch for initial hidden Columns bug
(function(){var A=YAHOO.util,B=YAHOO.env.ua,E=A.Event,C=A.Dom,D=YAHOO.widget.DataTable;D.prototype._initTheadEls=function(){var X,V,T,Z,I,M;if(!this._elThead){Z=this._elThead=document.createElement("thead");I=this._elA11yThead=document.createElement("thead");M=[Z,I];E.addListener(Z,"focus",this._onTheadFocus,this);E.addListener(Z,"keydown",this._onTheadKeydown,this);E.addListener(Z,"mouseover",this._onTableMouseover,this);E.addListener(Z,"mouseout",this._onTableMouseout,this);E.addListener(Z,"mousedown",this._onTableMousedown,this);E.addListener(Z,"mouseup",this._onTableMouseup,this);E.addListener(Z,"click",this._onTheadClick,this);E.addListener(Z.parentNode,"dblclick",this._onTableDblclick,this);this._elTheadContainer.firstChild.appendChild(I);this._elTbodyContainer.firstChild.appendChild(Z)}else{Z=this._elThead;I=this._elA11yThead;M=[Z,I];for(X=0;X<M.length;X++){for(V=M[X].rows.length-1;V>-1;V--){E.purgeElement(M[X].rows[V],true);M[X].removeChild(M[X].rows[V])}}}var N,d=this._oColumnSet;var H=d.tree;var L,P;for(T=0;T<M.length;T++){for(X=0;X<H.length;X++){var U=M[T].appendChild(document.createElement("tr"));P=(T===1)?this._sId+"-hdrow"+X+"-a11y":this._sId+"-hdrow"+X;U.id=P;for(V=0;V<H[X].length;V++){N=H[X][V];L=U.appendChild(document.createElement("th"));if(T===0){N._elTh=L}P=(T===1)?this._sId+"-th"+N.getId()+"-a11y":this._sId+"-th"+N.getId();L.id=P;L.yuiCellIndex=V;this._initThEl(L,N,X,V,(T===1))}if(T===0){if(X===0){C.addClass(U,D.CLASS_FIRST)}if(X===(H.length-1)){C.addClass(U,D.CLASS_LAST)}}}if(T===0){var R=d.headers[0];var J=d.headers[d.headers.length-1];for(X=0;X<R.length;X++){C.addClass(C.get(this._sId+"-th"+R[X]),D.CLASS_FIRST)}for(X=0;X<J.length;X++){C.addClass(C.get(this._sId+"-th"+J[X]),D.CLASS_LAST)}var Q=(A.DD)?true:false;var c=false;if(this._oConfigs.draggableColumns){for(X=0;X<this._oColumnSet.tree[0].length;X++){N=this._oColumnSet.tree[0][X];if(Q){L=N.getThEl();C.addClass(L,D.CLASS_DRAGGABLE);var O=D._initColumnDragTargetEl();N._dd=new YAHOO.widget.ColumnDD(this,N,L,O)}else{c=true}}}for(X=0;X<this._oColumnSet.keys.length;X++){N=this._oColumnSet.keys[X];if(N.resizeable){if(Q){L=N.getThEl();C.addClass(L,D.CLASS_RESIZEABLE);var G=L.firstChild;var F=G.appendChild(document.createElement("div"));F.id=this._sId+"-colresizer"+N.getId();N._elResizer=F;C.addClass(F,D.CLASS_RESIZER);var e=D._initColumnResizerProxyEl();N._ddResizer=new YAHOO.util.ColumnResizer(this,N,L,F.id,e);var W=function(f){E.stopPropagation(f)};E.addListener(F,"click",W)}else{c=true}}}if(c){}}else{}}for(var a=0,Y=this._oColumnSet.keys.length;a<Y;a++){if(this._oColumnSet.keys[a].hidden){var b=this._oColumnSet.keys[a];var S=b.getThEl();b._nLastWidth=S.offsetWidth-(parseInt(C.getStyle(S,"paddingLeft"),10)|0)-(parseInt(C.getStyle(S,"paddingRight"),10)|0);this._setColumnWidth(b.getKeyIndex(),"1px")}}if(B.webkit&&B.webkit<420){var K=this;setTimeout(function(){K._elThead.style.display=""},0);this._elThead.style.display="none"}}})();

         var futureIssues_ColumnDefs = [
		{key:"MFN",label:lblID,sortable:false},
//		{key:"teste",label:"920",sortable:false},
//		{key:"previous",label:"Previous 920",sortable:false},
		{key:"YEAR",label:lblYear,sortable:false},
		{key: "VOLU",label:lblVol,sortable:false},
		{key:"FASC",label:lblFacic,sortable:false},
		{key: "TYPE",label:lblType,sortable:false},
		{key: "STAT",label:lblStatus,sortable:false},
		{key: "QTD",label:lblQtd,sortable:false},
		{key: "MASK",label:lblMask,sortable:false},
		{key: "NOTE",label:lblNote,sortable:false},
		{key: "MODIFIED",label:lblNote,sortable:false},
		{key:"IDMFN",label:lblAction,formatter:this.myFormatAction,sortable:false}
	];

/* ***************************
* COMMON 
*************************** */
// Define various event handlers for Dialog
	var handleSubmit = function() {
		//this.submit();
		document.maskForm.submit();
	};
YAHOO.example.container.AnyMessageDialog = new YAHOO.widget.Dialog("AnyMessageDialog",
							{ width : "30em",
							  fixedcenter : true,
							  visible : false,
							  constraintoviewport : true
							});
YAHOO.example.container.AnyMessageDialog.render();
/* ***************************
* MASK 
*************************** */

	var maskHandleSubmit = function() {
            currentMask = document.getElementById('selectMask').value;
            loadFutureIssues('addRow', this);
	};

	var handleCancel = function() {
            this.cancel();
	};
	var handleSuccess = function(o) {
            //var response = o.responseText;
            //response = response.split("<!")[0];
            //document.getElementById("resp").innerHTML = response;
	};
	var handleFailure = function(o) {
		alert("Submission failed: " + o.status);
	};

/*****
 *
 *
 */
YAHOO.example.container.SavingMessageDialog = new YAHOO.widget.Dialog("SavingMessageDialog",
							{ width : "30em",
							  fixedcenter : true,
							  visible : false,
							  constraintoviewport : true
							});
YAHOO.example.container.SavingMessageDialog.render();

/* ***************************
* FACIC FORM RESIZABLE
*************************** */

/*var Dom = YAHOO.util.Dom,
Event = YAHOO.util.Event;
var resize = new YAHOO.util.Resize('resizablepanel');
*/

	function removeFieldInventory(rowId){

            var i = rowId.substr(rowId.indexOf('_')+1);
            reallyRemoveRow('frDFRow_'+i);
            i = i - 1;
            if (i > 0){
                    document.getElementById('remove_' + i).style.display = '';
            }
            document.getElementById('insert_' + i).style.display = '';
	}

	function removeInventoryFields(){
		var invs = document.getElementsByName('field[inventoryNumber][]');
		var len = invs.length;

		for (i=0;i<len;i++){
			invs[i].value = '';			
		}	
		for (i=1;i<len;i++){
				reallyRemoveRow('frDFRow_'+i);
		}	
	}
	
	var facicResizableHandleCancel = function() {
		removeInventoryFields();
		YAHOO.example.container.facicDialogResizable.cancel();

	}
	var facicResizableHandleSubmit = function() {
		var r = thisTable.getRecord(document.getElementById('formFacic_recordId').value);
		var inv = '';
		var qtd = 0;
		var q = 0;
	        
		if (document.getElementById('formFacic_year').value != r.getData('YEAR') ||
			document.getElementById('formFacic_volume').value != r.getData('VOLU') ||
			document.getElementById('formFacic_issue').value != r.getData('FASC') ||
			document.getElementById('formFacic_pubType').value != r.getData('TYPE') ||
			document.getElementById('formFacic_status').value != r.getData('STAT') ||
			document.getElementById('formFacic_mask').value != r.getData('MASK')			
			){
				askForHoldingsExecution = true;
		}

		invs = document.getElementsByName('field[inventoryNumber][]');

		for (i=0;i< invs.length;i++){
			if (invs[i].value!=''){
				inv = inv + invs[i].value + '; ';
				invs[i].value = '';
				qtd++;
			}
		}
		removeInventoryFields();
                //alert('formFacic_quantity=' + document.getElementById('formFacic_quantity').value);

		q = parseInt(document.getElementById('formFacic_quantity').value);
		if (qtd > q){
			q = qtd;
		}
		
		r.setData('QTD', q); 

		if (askForHoldingsExecution || 
			q != r.getData('QTD') ||
			document.getElementById('formFacic_notes').value != r.getData('NOTE') ||
			inv != r.getData('INVENTORY') ||
			document.getElementById('formFacic_standardizedDate').value != r.getData('DATEISO') ||
			document.getElementById('formFacic_eAddress').value != r.getData('EADDR') ||
			document.getElementById('formFacic_textualDesignation').value != r.getData('DESIGN')	
			){
			
			r.setData('MODIFIED', 'M'); 
			r.setData('YEAR', document.getElementById('formFacic_year').value); 
			r.setData('VOLU', document.getElementById('formFacic_volume').value); 
			r.setData('FASC', document.getElementById('formFacic_issue').value); 
			r.setData('TYPE', document.getElementById('formFacic_pubType').value); 
			r.setData('STAT', document.getElementById('formFacic_status').value); 
			r.setData('MASK', document.getElementById('formFacic_mask').value); 
			r.setData('NOTE', document.getElementById('formFacic_notes').value); 
			//FIXME
			r.setData('INVENTORY', inv); 
			r.setData('DATEISO', document.getElementById('formFacic_standardizedDate').value); 
			r.setData('EADDR', document.getElementById('formFacic_eAddress').value); 
			r.setData('DESIGN', document.getElementById('formFacic_textualDesignation').value); 
			thisTable.render();
		}
                if (currentMask != r.getData('MASK')){
                    currentMask = r.getData('MASK');
                    loadFutureIssues();
                }
		YAHOO.example.container.facicDialogResizable.hide();
		//panel.hide();

	};
	// Instantiate the Dialog
	YAHOO.example.container.facicDialogResizable = new YAHOO.widget.Dialog("facicDialogResizable",
							{ width : "80em",
                              height : "20em",
							  fixedcenter : true,
							  visible : false,
							  constraintoviewport : true,
							  buttons : [ { text:"Submit", handler:facicResizableHandleSubmit, isDefault:true },
								      { text:"Cancel", handler:facicResizableHandleCancel } ]
							});

	// Wire up the success and failure handlers
	YAHOO.example.container.facicDialogResizable.callback = { success: handleSuccess,
						     failure: handleFailure };
	
        // Render the Dialog
	YAHOO.example.container.facicDialogResizable.render();


	function editIssue(recordId){
		var r = thisTable.getRecord(recordId);
		var a_inv = new Array();
		var inv = '';
		var i = 0;

		document.getElementById('formFacic_recordId').value = recordId;
		document.getElementById('formFacic_year').value = r.getData('YEAR');
		document.getElementById('formFacic_volume').value = r.getData('VOLU');
		document.getElementById('formFacic_issue').value = r.getData('FASC');
		document.getElementById('formFacic_pubType').value = r.getData('TYPE');
		document.getElementById('formFacic_status').value = r.getData('STAT');
		document.getElementById('formFacic_quantity').value = r.getData('QTD');
		document.getElementById('formFacic_mask').value = r.getData('MASK');
		document.getElementById('formFacic_notes').value = r.getData('NOTE');
		
		//FIXME
		inv =  r.getData('INVENTORY');
		if ( (inv!=null) &&  inv!='' ){
			a_inv = inv.split('; ');
		}
		
		if ( a_inv.length==0 ) document.getElementById('insert_0').style.display = '';
		for (i=0;i<a_inv.length;i++){
			if (a_inv[i]!=''){
				if (i>0){
					insertFieldInventoryRepeat('frDFRowIns', i);
				}

				if (document.getElementById('formFacic_inventoryNumber_' + i)){
					document.getElementById('formFacic_inventoryNumber_' + i).value = a_inv[i];
				} else {
				}
			}
		}
		document.getElementById('formFacic_standardizedDate').value = r.getData('DATEISO');
		document.getElementById('formFacic_eAddress').value = r.getData('EADDR');
		document.getElementById('formFacic_textualDesignation').value = r.getData('DESIGN');

		//panel.show();
		YAHOO.example.container.facicDialogResizable.show();
	}

	document.getElementById('template').style.display = 'none';

	/* ***************************
	* INSERT THE FOLLING ROW
	*************************** */
	function insertFollowingIssue(recordId) {
            
		var r = thisTable.getRecord(recordId);
		var i = thisTable.getRecordIndex(thisTable.getTrEl(r));
                //alert(recordId);

		if (i == 0){
                    if (!futureIssues){
                        loadFutureIssues('addRow');
                    } else  {
                        if (futureIssues.length==0){
                            loadFutureIssues('addRow');
                        }else{
                            addFacic();
                        }
                    }
                    //alert (thisTable.getTrEl(r).id);
                    
                    YAHOO.util.Dom.addClass(thisTable.getPreviousTrEl(r),"rowOver");
		}else{
                    YAHOO.util.Dom.addClass(thisTable.getTrEl(r),"rowOver");
                    var data = {MFN:'New', YEAR: r.getData('YEAR'), VOLU: '', FASC: '', STAT: 'P', QTD: 1, TYPE: '', NOTE: '', MASK: r.getData('MASK'), SEQN: r.getData('SEQN') + 100, FORMERSTAT: 'P', FORMERQTD: 'P', MODIFIED: 'M', IDMFN:'',INVENTORY:'',DATEISO:'',EADDR:'',DESIGN:''};
                    thisTable.addRow(data, i);
                    thisTable.render();
		}
	}
			
	/* ***************************
	* DELETE AN ISSUE
	*************************** */
	function removeIssue(recordId) {       
		//alert("remove " + recordId);

		var r = thisTable.getRecord(recordId);				
		if (r.getData('MFN')=='New'){
			removeRow(recordId);
		} else {
			r.setData('MODIFIED', 'D');
		}
		thisTable.render();
	}
	/* ***************************
	* DELETE THE ROW
	*************************** */
	function removeRow(recordId) {       
		var r = thisTable.getRecord(recordId);
		var i = thisTable.getRecordIndex(thisTable.getTrEl(r));
                thisTable.deleteRow(i);
	}
        
/* ***************************
* MASK 
*************************** */
	var maskHandleSubmit = function() {

		currentMask = document.getElementById('selectMask').value;
                //alert('aqui '+currentMask);
                document.getElementById('dialog1Message').innerHTML = msgWaiting;
                loadFutureIssues('addRow', YAHOO.example.container.dialog1);
	};

	// Instantiate the Dialog
	YAHOO.example.container.dialog1 = new YAHOO.widget.Dialog("dialog1",
							{ width : "30em",
							  fixedcenter : true,
							  visible : false,
							  constraintoviewport : true,
							  buttons : [ { text:"Submit", handler:maskHandleSubmit, isDefault:true },
								      { text:"Cancel", handler:handleCancel } ]
							});

	// Validate the entries in the form to require that both first and last name are entered
	// Wire up the success and failure handlers
	YAHOO.example.container.dialog1.callback = { success: handleSuccess,
						     failure: handleFailure };

	// Render the Dialog
	YAHOO.example.container.dialog1.render();

	YAHOO.util.Event.addListener("show", "click", YAHOO.example.container.dialog1.show, YAHOO.example.container.dialog1, true);
	YAHOO.util.Event.addListener("hide", "click", YAHOO.example.container.dialog1.hide, YAHOO.example.container.dialog1, true);

/* ***************************
* YEAR LIST 
*************************** */
	var addRowsDialoghandleShow = function() {
		if (currentMask=="" ){
                    YAHOO.example.container.dialog1.show();
		}else{
                    document.getElementById('addRowsDialogMessage').innerHTML = '';
                    YAHOO.example.container.addRowsDialog.show();
		}
	};

	var addRowsDialoghandleSubmit = function() {
            if (!futureIssues || futureIssues.length == 0){
                    document.getElementById('addRowsDialogMessage').innerHTML = msgWaiting; //FIXME
                    loadFutureIssues('addRows', this);
            } else  {
                if (futureIssues.length == 0){
                    document.getElementById('addRowsDialogMessage').innerHTML = msgWaiting; //FIXME
                    loadFutureIssues('addRows', this);
                }else{
                        call_addRows(this);
                }
            }
	};
        
	YAHOO.example.container.addRowsDialog = new YAHOO.widget.Dialog("addRowsDialog",
							{ width : "30em",
							  fixedcenter : true,
							  visible : false,
							  constraintoviewport : true,
							  buttons : [ { text:"Submit", handler:addRowsDialoghandleSubmit, isDefault:true },
								      { text:"Cancel", handler:handleCancel } ]
							});
	YAHOO.example.container.addRowsDialog.callback = { 
		success:  function(o) {
				//var response = o.responseText;
				//response = response.split("<!")[0];
				//document.getElementById("resp").innerHTML = response;
		},
		failure: handleFailure };

	YAHOO.example.container.addRowsDialog.render();

	YAHOO.util.Event.addListener("addRows", "click", addRowsDialoghandleShow, YAHOO.example.container.addRowsDialog, true);
	YAHOO.util.Event.addListener("hide", "click", YAHOO.example.container.addRowsDialog.hide, YAHOO.example.container.addRowsDialog, true);

/* ***************************
* COLLLECTION
*************************** */
	var getCollectionAndDisplay = function() {

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
		var sUrl = 'getHolding.php?title='+title;
		var postData = '';
		
		for (i=0;i<thisTable.getRecordSet().getLength();i++){
			if (thisTable.getRecord(i).getData('MODIFIED')!= 'D'){
				postData = postData + '&YEAR[]=' + thisTable.getRecord(i).getData('YEAR');
				postData = postData + '&VOLU[]=' + thisTable.getRecord(i).getData('VOLU');
				postData = postData + '&FASC[]=' + thisTable.getRecord(i).getData('FASC');
				postData = postData + '&TYPE[]=' + thisTable.getRecord(i).getData('TYPE');
				postData = postData + '&STAT[]=' + thisTable.getRecord(i).getData('STAT');
				postData = postData + '&SEQN[]=' + thisTable.getRecord(i).getData('SEQN');
				postData = postData + '&MASK[]=' + thisTable.getRecord(i).getData('MASK').replace('+','%2B');
			}
		}
		document.getElementById('collectionDisplayed').innerHTML = lblHldgMessage;
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
	
	// Render the Dialog
	YAHOO.example.container.collectionDialog.render();
	YAHOO.util.Event.addListener("displayCollection", "click", getCollectionAndDisplay, YAHOO.example.container.collectionDialog, true);
/* FIM COLLECTION */

/* ***************************
* TABLE 
*************************** */
YAHOO.util.Event.addListener(window, "load", function() {
    YAHOO.example.ClientPagination = new function() {
    	
    	this.myFormatAction = function(elCell, oRecord, oColumn, oData) {
			var mfn = oData;
			var currentFacic = oRecord.getData("MFN");
			var previousFacic = oRecord.getData("FASC");
			var yearFacic = oRecord.getData("YEAR");
			var id = oRecord.getId();
			var btEditIssue = '<a href="javascript: editIssue(\''+id+'\');" ><img src="public/images/common/icon/singleButton_edit.png" title="'+btEdFasc+'" alt="'+btEdFasc+'" /></a>';
                        var btDeleteIssue = '<a href="javascript: removeIssue(\''+id+'\');"><img src="public/images/common/icon/singleButton_delete.png" title="'+btDelete+' '+lblIssue+'" alt="'+btDelete+ ' '+lblIssue+'" /></a>';
                        var btInsertNextIssue = ' <a href="javascript: insertFollowingIssue(\''+id+'\');"><img title="Insert the following" src="public/images/common/icon/singleButton_ADD.png" title="'+btInsertFascBetween+'" alt="'+btInsertFascBetween+'" /></a></a> ';
                        elCell.innerHTML = btEditIssue + btDeleteIssue + btInsertNextIssue;
		};

        var modified = false;
        var myColumnDefs = [
                //{key:"MFN",label:lblID,sortable:false},
                //{key:"teste",label:"920",sortable:false},
                //{key:"previous",label:"Previous 920",sortable:false},
            {key:"YEAR",label:lblYear,sortable:false},
            {key: "VOLU",label:lblVol,sortable:false},
	    	{key:"FASC",label:lblFacic,sortable:false},
	    	{key: "TYPE",label:lblType,sortable:false},
	    	{key: "STAT",label:lblStatus,sortable:false, formatter:"dropdown", dropdownOptions:["P","A"]},
	    	{key: "QTD",label:lblQtd,sortable:false},
	    	{key: "MASK",label:lblMask,sortable:false, editor:"dropdown", editorOptions:{dropdownOptions:collectionMask}, width: 60},
            {key: "NOTE",label:lblNote,sortable:false, width: 200},
	    	{key: "MODIFIED",label:'',sortable:false},
	    	{key:"IDMFN",label:lblAction,formatter:this.myFormatAction,sortable:false, width: 270}
        ];
        this.myDataSource = new YAHOO.util.DataSource("yuiservice.php?" + hRequest);
        this.myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;

        // When responseSchema.totalRecords is not indicated, the records
        // returned from the DataSource are assumed to represent the entire set
        this.myDataSource.responseSchema = {
            resultsList: "records",
            fields: [{key:"MFN",parser:YAHOO.util.DataSource.parseNumber},
                    {key:"teste",parser:YAHOO.util.DataSource.parseNumber},
                    {key:"previous",parser:YAHOO.util.DataSource.parseNumber},
                    {key:"YEAR",parser:YAHOO.util.DataSource.parseString},
                    {key:"VOLU",parser:YAHOO.util.DataSource.parseString},
                    {key:"FASC",parser:YAHOO.util.DataSource.parseString},
                    {key:"TYPE",parser:YAHOO.util.DataSource.parseString},
                    {key:"STAT",parser:YAHOO.util.DataSource.parseString},
                    {key:"QTD",parser:YAHOO.util.DataSource.parseString},
                    {key:"FORMERSTAT",parser:YAHOO.util.DataSource.parseString},
                    {key:"FORMERQTD",parser:YAHOO.util.DataSource.parseString},
                    {key:"MASK",parser:YAHOO.util.DataSource.parseString},
                    {key:"NOTE",parser:YAHOO.util.DataSource.parseString},
                    {key:"MODIFIED",parser:YAHOO.util.DataSource.parseString},
                    {key:"IDMFN",parser:YAHOO.util.DataSource.parseNumber},
                    {key:"INVENTORY",parser:YAHOO.util.DataSource.parseString},
                    {key:"DATEISO",parser:YAHOO.util.DataSource.parseString},
                    {key:"EADDR",parser:YAHOO.util.DataSource.parseString},
                    {key:"DESIGN",parser:YAHOO.util.DataSource.parseString},
                    {key:"SEQN",parser:YAHOO.util.DataSource.parseString},
                    {key:"CRDATE",parser:YAHOO.util.DataSource.parseString},
                    {key:"UPDATE",parser:YAHOO.util.DataSource.parseString},
                    {key:"CRDOC",parser:YAHOO.util.DataSource.parseString},
                    {key:"UPDOC",parser:YAHOO.util.DataSource.parseString}],
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
                                previousPageLinkClass : "singleButton eraseButton",
                                nextPageLinkLabel : btNext + " &gt;",
				nextPageLinkClass : "singleButton eraseButton",  
			        template          : "{FirstPageLink} {PreviousPageLink} " +
                                                     "{PageLinks} " + "{NextPageLink} {LastPageLink}  " +
                                                     lblViewOf+" {RowsPerPageDropdown} " + lblPerPage,
			        // use custom page link labels 
			        pageLabelBuilder : function (page,paginator) { 
			            var recs = paginator.getPageRecords(page); 
			            return (recs[0] + 1) + ' - ' + (recs[1] + 1); 
			        } 
                }),

                initialRequest: "&startIndex=0&results=" +numRecordsPage,
                generateRequest: buildQueryString, 
                paginationEventHandler : YAHOO.widget.DataTable.handleDataSourcePagination
        };

        this.myDataTable = new YAHOO.widget.DataTable("listRecords", myColumnDefs, this.myDataSource, oConfigs);
        thisTable = this.myDataTable;

		
		// EDITOR DE MASCARA
		this.myDataTable.subscribe("cellClickEvent", function(oArgs){
			var oRecord = this.getRecord(oArgs.target);

			var last = thisTable.getRecord(0).getData('YEAR')+"_"+thisTable.getRecord(0).getData('VOLU')+"_"+thisTable.getRecord(0).getData('FASC');
			var curr = oRecord.getData('YEAR')+"_"+oRecord.getData('VOLU')+"_"+oRecord.getData('FASC');

			if (curr==last){
				this.showCellEditor(oArgs.target);
			}
		});

		// EDITOR DE MASCARA
		this.myDataTable.subscribe("editorSaveEvent", function(oArgs) {
                    if ((oArgs.newData != currentMask) && (currentMask==oArgs.oldData)){
                        this.saveCellEditor();
                        currentMask = oArgs.newData;
                        loadFutureIssues();
                    }
                });

		// EDITOR DE P/A
		this.myDataTable.subscribe("dropdownChangeEvent", function(oArgs){
			var elDropdown = oArgs.target;
			var oRecord = this.getRecord(elDropdown);
			var oCol = this.getColumn(elDropdown);

			if (elDropdown.options[elDropdown.selectedIndex].value == 'A'){
				oRecord.setData('QTD', '0');
			}else{
                if (oRecord.getData('QTD')=='0'){
                    oRecord.setData('QTD','1');
                } else {
                    oRecord.setData('QTD', oRecord.getData('FORMERQTD'));
                }
			}
			if (elDropdown.options[elDropdown.selectedIndex].value != oRecord.getData('FORMERSTAT')){
				oRecord.setData('MODIFIED','M');
			} else
			{
				oRecord.setData('MODIFIED','');
			}
			oRecord.setData(oCol.key,elDropdown.options[elDropdown.selectedIndex].value);
			thisTable.render();
                });

		// ROW SELECTIONS
		thisTable.subscribe("cellMouseoverEvent", function(oArgs){
			var elTrRow = oArgs.target;
			YAHOO.util.Dom.addClass(this.getTrEl(elTrRow),"rowOver");
		});
		thisTable.subscribe("cellMouseoutEvent", function(oArgs){
			var elTrRow = oArgs.target;
			YAHOO.util.Dom.removeClass(this.getTrEl(elTrRow),"rowOver");
                });
        
        thisTable.subscribe("rowClickEvent", function(oArgs){
        });
    };
});

/* ***************************
* ADD ROWS
*************************** */

function call_addRows(formObj){
	var y = futureIssues[i_futureIssues].YEAR;
	while (y <= document.getElementById("untilYear").value){
		addFacic();	
		y = futureIssues[i_futureIssues].YEAR;
	}
	formObj.submit();	
}

/* ***************************
* ADD ROW
*************************** */

YAHOO.util.Event.addListener("addRow","click",function() {
    
    if (currentMask=="" ){
        YAHOO.example.container.dialog1.show();
    }else{
        if (futureIssues) {
            if (futureIssues.length==0){
                    loadFutureIssues('addRow');
            }else{
                    addFacic();
            }
        } else {
                    loadFutureIssues('addRow');

        }
    }

    selectedObj = document.getElementById('yui-dt0-bdrow0');
    YAHOO.util.Dom.addClass(selectedObj,"rowOver");
    //alert('elTrRow');

},this,true);
		
		
/* ***************************
* SAVE
*************************** */

var saveFunction = function() {
	var postData = '';
	var changed = 0;
	var done = 0;
	var what = '';
	var a_inv = new Array();
	var inv = '';
    var returnCount  = 0;
    var callingCount = 0;
    var calls = "";

	var handleSuccess = function(o) {
		var t = 0;
		t = o.responseText.indexOf('[recid]');
        
        //if (o.responseText.indexOf('[action]holdings')>0){
           //document.getElementById('teste').innerHTML = document.getElementById('teste').innerHTML + 'holdings executed' + "\n";
        //}
		if (t>0){
			var x ='';
			x = o.responseText.substr(t+7);
			x = x.substr(0,x.indexOf('[/recid]'));
			thisTable.getRecord(x).setData('MODIFIED','');
			t = o.responseText.indexOf('[mfn]');
			if (t>0){
				var mfn = o.responseText.substr(t+5);
				mfn = mfn.substr(0,mfn.indexOf('[/mfn]'));
				if (mfn == 'deleted'){
					// registro apagado
					removeRow(x);
				} else {
					// registro novo com MFN
					thisTable.getRecord(x).setData('MFN',mfn);
				}
			} 
		} else {
			//document.getElementById('teste').innerHTML = document.getElementById('teste').innerHTML + o.responseText;
		}
		thisTable.render();
        returnCount++;
        if (callingCount == returnCount) {
            YAHOO.util.Connect.asyncRequest('POST', '?hldg=execute', callback, postData);
            YAHOO.example.container.SavingMessageDialog.hide();
        }
	}
	var handleFailure = function(o) {
		returnCount++;
        if (callingCount == returnCount) {
            YAHOO.util.Connect.asyncRequest('POST', '?hldg=execute', callback, postData);
            YAHOO.example.container.SavingMessageDialog.hide();
        }
	}

	var callback = {
		success: handleSuccess,
		failure: handleFailure
	};
	var sUrl = '';

	var commonPostData = 'field[titleCode]='+title+'&field[database]=FACIC&field[literatureType]=S&field[treatmentLevel]=F&field[centerCode]='+centerCode;
	//var hldgExecute4each = '&hldg=execute';
    var hldgExecute4each = '';

    YAHOO.example.container.SavingMessageDialog.show();
    var total = thisTable.getRecordSet().getLength();
	for (i=0;i<total;i++ )
	{
		var record = thisTable.getRecord(i);

		if ( (record.getData('MODIFIED')=='M') ||  (record.getData('MODIFIED')=='updating...') ||  (record.getData('MODIFIED')=='D')){
            callingCount++;
			askForHoldingsExecution = true;
			what = record.getData('MODIFIED');
			record.setData('MODIFIED','updating...' ); //FIXME

			thisTable.render();
			
			postData = commonPostData + '&recid=' + record.getId();
			if (what == 'D') {
				what = 'delete=' + record.getData('MFN') + hldgExecute4each;
				postData = postData + '&id='+ record.getData('MFN');
			} else {
				what = 'edit=save' + hldgExecute4each;
				postData = postData + '&mfn=' + record.getData('MFN') + '&field[year]=' +record.getData('YEAR') +'&field[volume]=' + record.getData('VOLU') + '&field[issue]=' + record.getData('FASC') + '&field[codeNameMask]=' +record.getData('MASK').replace('+','%2B')+ '&field[status]=' + record.getData('STAT') +'&field[quantity]=' +record.getData('QTD') +'&field[publicationType]=' + record.getData('TYPE') + '&field[notes]=' + record.getData('NOTE') + '&field[sequentialNumber]=' + record.getData('SEQN')+'&gravar=true';
				if (record.getData('MFN')=='New'){
					postData = postData + '&field[creationDate]='+today+'&field[changeDate]='+today+'&field[documentalistCreation]='+username+'&field[documentalistChange]='+username;
				} else {
					a_inv = record.getData('INVENTORY').split('; ');
					inv = '';
					for (j=0;j<a_inv.length;j++){
						if (a_inv[j]!=''){
						inv = inv + '&field[inventoryNumber][]='+a_inv[j];
						}
					}
					//alert(inv);
					postData = postData + inv +'&field[standardizedDate]='+record.getData('DATEISO')+'&field[eAddress]='+record.getData('EADDR')+'&field[textualDesignation]='+record.getData('DESIGN')+ '&field[creationDate]='+record.getData('CRDATE')+'&field[changeDate]='+today+'&field[documentalistCreation]='+record.getData('CRDOC')+'&field[documentalistChange]='+username;
				}

			}
			sUrl = '?m=facic&title='+title+'&'+what;
            //document.getElementById('teste').innerHTML = document.getElementById('teste').innerHTML + "\n" + sUrl;
			YAHOO.util.Connect.asyncRequest('POST', sUrl, callback, postData); 
		}						
	} // fim for


}
YAHOO.util.Event.addListener("saveFacic","click",saveFunction,this,true);

/* ***************************
* LOAD FUTURE ISSUES
*************************** */

function loadFutureIssues(actionName, formObj){

        document.getElementById('anyMessage').innerHTML = msgWaiting ; // + ' ' + currentMask;
	YAHOO.example.container.AnyMessageDialog.show();
        if (currentMask){
		futureIssuesLoaded = false;
		var request = '';
                var prevMask = currentMask;
                if (thisTable.getRecordSet().getLength() > 1){
                    prevMask = thisTable.getRecord(1).getData('MASK').replace('+','%2B');
                }
                //var maskHasChanged = (currentMask != thisTable.getRecord(1).getData('MASK'));
		if (thisTable.getRecordSet().getLength()==0){
                    request = 'm=futureIssues&maskId='+currentMask.replace('+','%2B')+'&initialDate='+initialDate+'&lastDate='+initialDate+'&lastVolume='+initialVolume+'&lastNumber='+initialNumber+'&lastSeqN=0&prevMask=';
		} else {
                    request = 'm=futureIssues&maskId='+thisTable.getRecord(0).getData('MASK').replace('+','%2B')+'&initialDate='+initialDate+'&lastDate='+thisTable.getRecord(0).getData('YEAR')+'&lastVolume='+thisTable.getRecord(0).getData('VOLU')+'&lastNumber='+thisTable.getRecord(0).getData('FASC')+'&lastSeqN='+thisTable.getRecord(0).getData('SEQN')+'&prevMask='+prevMask;
		}
		//document.getElementById('teste').innerHTML = 'yuiservice.php?'+request;

		var callbacks = {
			// Successful XHR response handler
			success : function (o) {
				try {
                                        futureIssues = YAHOO.lang.JSON.parse(o.responseText);
                                        YAHOO.example.container.AnyMessageDialog.hide();
                                        if (!futureIssues){
                                            currentMask = '';
                                            alert(msgInvalidMaskForThisFacic);
                                            //alert('yuiservice.php?'+request); //alert(futureIssues.length);
                                        }
				}catch (x) {
                                        //alert('try again!!!');
                                        loadFutureIssues(actionName, formObj);
					return;
				}
				
				i_futureIssues = 0;
				futureIssuesLoaded = true;

				if (actionName == 'addRows'){
                                    call_addRows(formObj);
				} else {
                                    if (actionName == 'addRow'){
                                            addFacic(formObj);
                                    } else {

                                    }
				}
			},
                        failure: function(o){
                                    alert('try again...');
                                    futureIssuesLoaded = true;
                                }
		};
		// Make the call to the server for JSON data
                //alert('yuiservice.php?'+request);
		YAHOO.util.Connect.asyncRequest('POST','yuiservice.php?'+request, callbacks);
		//document.getElementById('teste').innerHTML = 'yuiservice.php?'+request;
	}
}
/* ***************************
* ADD FACIC
*************************** */
function addFacicPart2(formObj){

	var data = new Array();
	var myType = '';
        if (futureIssues) {
            if (futureIssues.length>0 && i_futureIssues <=futureIssues.length){

                    if (thisTable.getRecordSet().getLength()>0){
                            myType = thisTable.getRecord(0).getData('TYPE');
                    }
                    data = {
                            MFN: futureIssues[i_futureIssues].MFN,
                            YEAR: futureIssues[i_futureIssues].YEAR,
                            VOLU: futureIssues[i_futureIssues].VOLU,
                            FASC: futureIssues[i_futureIssues].FASC,
                            STAT: futureIssues[i_futureIssues].STAT,
                            QTD: futureIssues[i_futureIssues].QTD,
                            TYPE: myType,
                            NOTE: futureIssues[i_futureIssues].NOTE,
                            MASK: futureIssues[i_futureIssues].MASK,
                            SEQN: futureIssues[i_futureIssues].SEQN,
                            FORMERSTAT: futureIssues[i_futureIssues].STAT,
                            MODIFIED: 'M',
                            IDMFN:'',
                            INVENTORY:'',
                            DATEISO:'',
                            EADDR:'',
                            DESIGN:''};
                    i_futureIssues ++;
                    thisTable.addRow(data,0);
                    thisTable.render();
            } else {
                    //alert("Completo");//FIXME
            }
        }
            if (formObj) {
                    formObj.cancel();
            }
}
function addFacic(formObj){

	addFacicPart2(formObj);
}
{/literal}
</script>


<div class="helpBG" id="formRow01_helpA" style="display: none;">
    <div class="helpArea">
            <span class="exit"><a href="javascript:showHideDiv('formRow01_helpA');" title="{$BVS_LANG.close}" alt="{$BVS_LANG.close}"><img src="public/images/common/icon/defaultButton_cancel.png" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}" title="{$BVS_LANG.btCancelAction}" alt="{$BVS_LANG.btCancelAction}"></a></span>
            <h2>{$BVS_LANG.help} - {$BVS_LANG.field} {$BVS_LANG.lblSearchIssue}</h2>
            <div class="help_message">
                {$BVS_LANG.helpSearchIssue}
            </div>
    </div>
</div>