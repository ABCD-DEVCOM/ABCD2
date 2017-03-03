<div id="listRecords" class="listTable"></div>
<script type="text/javascript">
/*** Form Begin ****/
 /***  Step 1  ***/
var lblrecordIdentification = "{$BVS_LANG.lblrecordIdentification}";
var lblpublicationTitle = "{$BVS_LANG.lblpublicationTitle}";
var lblnameOfIssuingBody = "{$BVS_LANG.lblnameOfIssuingBody}";
var lblofIssuingBody = "{$BVS_LANG.lblnameOfIssuingBody}";
var lblkeyTitle = "{$BVS_LANG.lblkeyTitle}";
var lblabbreviatedTitle = "{$BVS_LANG.lblabbreviatedTitle}";
var lblabbreviatedTitleMedline = "{$BVS_LANG.lblabbreviatedTitleMedline}";
 /***  Step 2  ***/
var lblsubTitle = "{$BVS_LANG.lblsubtitle}";
var lblsectionPart = "{$BVS_LANG.lblsectionPart}";
var lbltitleOfSectionPart = "{$BVS_LANG.lbltitleOfSectionPart}";
var lblparallelTitle = "{$BVS_LANG.lblparallelTitle}";
var lblotherTitle = "{$BVS_LANG.lblotherTitle}";
var lbltitleHasOtherLanguageEditions = "{$BVS_LANG.lbltitleHasOtherLanguageEditions}";
var lbltitleAnotherLanguageEdition = "{$BVS_LANG.lbltitleAnotherLanguageEdition}";
var lbltitleHasSubseries = "{$BVS_LANG.lbltitleHasSubseries}";
var lbltitleIsSubseriesOf = "{$BVS_LANG.lbltitleIsSubseriesOf}";
var lbltitleHasSupplementInsert = "{$BVS_LANG.lbltitleHasSupplementInsert}";
var lbltitleIsSupplementInsertOf = "{$BVS_LANG.lbltitleIsSupplementInsertOf}";
 /***  Step 3  ***/
var lbltitleContinuationOf = "{$BVS_LANG.lbltitleContinuationOf}";
var lbltitlePartialContinuationOf = "{$BVS_LANG.lbltitlePartialContinuationOf}";
var lbltitleAbsorbed = "{$BVS_LANG.lbltitleAbsorbed}";
var lbltitleAbsorbedInPart = "{$BVS_LANG.lbltitleAbsorbedInPart}";
var lbltitleFormedByTheSplittingOf = "{$BVS_LANG.lbltitleFormedByTheSplittingOf}";
var lbltitleMergeOfWith = "{$BVS_LANG.lbltitleMergeOfWith}";
var lbltitleContinuedBy = "{$BVS_LANG.lbltitleContinuedBy}";
var lbltitleContinuedInPartBy = "{$BVS_LANG.lbltitleContinuedInPartBy}";
var lbltitleAbsorbedBy = "{$BVS_LANG.lbltitleAbsorbedBy}";
var lbltitleAbsorbedInPartBy = "{$BVS_LANG.lbltitleAbsorbedInPartBy}";
var lbltitleSplitInto = "{$BVS_LANG.lbltitleSplitInto}";
var lbltitleMergedWith = "{$BVS_LANG.lbltitleMergedWith}";
var lbltitleToForm = "{$BVS_LANG.lbltitleToForm}";
 /***  Step 4  ***/
var lblpublisher = "{$BVS_LANG.lblpublisher}";
var lblplace = "{$BVS_LANG.lblplace}";
var lblCountry  = "{$BVS_LANG.lblcountry}";
var lblState  = "{$BVS_LANG.lblstate}";
var lblISSN  = "{$BVS_LANG.lblissn}";
var lblcoden = "{$BVS_LANG.lblcoden}";
var lblpublicationStatus = "{$BVS_LANG.lblpublicationStatus}";
var lblinitialVolume = "{$BVS_LANG.lblinitialVolume}";
var lblinitialDate = "{$BVS_LANG.lblinitialDate}";
var lblinitialNumber = "{$BVS_LANG.lblinitialNumber}";
var lblfinalVolume = "{$BVS_LANG.lblfinalVolume}";
var lblfinalDate = "{$BVS_LANG.lblfinalDate}";
var lblfinalNumber = "{$BVS_LANG.lblfinalNumber}";
var lblFrequency = "{$BVS_LANG.lblFrequency}";
var lblpublicationLevel = "{$BVS_LANG.lblpublicationLevel}";
var lblalphabetTitle = "{$BVS_LANG.lblalphabetTitle}";
var lbllanguageText = "{$BVS_LANG.lbllanguageText}";
var lbllanguageAbstract = "{$BVS_LANG.lbllanguageAbstract}";
 /***  Step 5  ***/
var lblrelatedSystems = "{$BVS_LANG.lblrelatedSystems}";
var lblnationalCode = "{$BVS_LANG.lblnationalCode}";
var lblsecsIdentification = "{$BVS_LANG.lblsecsIdentification}";
var lblmedlineCode = "{$BVS_LANG.lblmedlineCode}";
var lblclassification = "{$BVS_LANG.lblclassification}";
var lblclassificationCdu = "{$BVS_LANG.lblclassificationCdu}";
var lblclassificationDewey = "{$BVS_LANG.lblclassificationDewey}";
var lblthematicaArea = "{$BVS_LANG.lblthematicaArea}";
var lbldescriptors = "{$BVS_LANG.lbldescriptors}";
var lblotherDescriptors = "{$BVS_LANG.lblotherDescriptors}";
var lblindexingCoverage = "{$BVS_LANG.lblindexingCoverage}";
var lblmethodAcquisition = "{$BVS_LANG.lblmethodAcquisition}";
var lblacquisitionPriority = "{$BVS_LANG.lblacquisitionPriority}";
var lblnotes = "{$BVS_LANG.lblnotes}";
 /***  Step 6  ***/
var lblurlPortal = "{$BVS_LANG.lblurlPortal}";
var lblurlInformation = "{$BVS_LANG.lblurlInformation}";
 /***  Step 7  ***/
var lblspecialtyVHL = "{$BVS_LANG.lblspecialtyVHL}";
var lbluserVHL = "{$BVS_LANG.lbluserVHL}";
var lblnotesBVS = "{$BVS_LANG.lblnotesBVS}";
var lblwhoindex = "{$BVS_LANG.lblwhoindex}";
var lblcodepublisher = "{$BVS_LANG.lblcodepublisher}";
/*** Form End ****/

var lblViewOf = "{$BVS_LANG.lblViewOf}";
var lblUntil  = "{$BVS_LANG.lblUntil}";
var lblOf  = "{$BVS_LANG.lblOf}";
var lblID  = "{$BVS_LANG.lblID}";
var lblMask  = "{$BVS_LANG.mask}";
var lblNote  = "{$BVS_LANG.lblNote}";
var lblAction = "{$BVS_LANG.lblAction}";
var lblPerPage = "{$BVS_LANG.perPage}";
var lblTitle  = "{$BVS_LANG.title}";
var lblActionFacic = "{$BVS_LANG.ActionFacic}";
var lblActionTitle = "{$BVS_LANG.ActionTitle}";
var lblActionTitlePlus = "{$BVS_LANG.lblActionTitPlus}";
var btInTitlePlus = "{$BVS_LANG.btInTitlePlus}";
var btEdTitlePlus = "{$BVS_LANG.btEdTitlePlus}";
var btEdMask = "{$BVS_LANG.btEdMask}";
var btDelete = "{$BVS_LANG.btEraserRecord}";
var btNext = "{$BVS_LANG.btNext}";
var btPrevious = "{$BVS_LANG.btPrevious}";
var btFirst = "{$BVS_LANG.btFirst}";
var btLast = "{$BVS_LANG.btLast}";
var btList = "{$BVS_LANG.lblList}";
var lblFacic  = "{$BVS_LANG.facic}";

var btEdTitle = "{$BVS_LANG.btEdTitle}";
var btEdFasc = "{$BVS_LANG.btEdFasc}";
var btInsFasc = "{$BVS_LANG.btInsFasc}";
var search = "{$smarty.get.searchExpr}";
var numRecordsPage = {$BVS_CONF.numRecordsPage};
var hRequest = "";
var searchExpr = null;
var indexes = null;
var m = null;
var d = new Date();
var t = d.getTime();
hRequest = "tty=" + d.getTime();
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
            {key:"flag",parser:YAHOO.util.DataSource.parseNumber},
			{key:"MFN",parser:YAHOO.util.DataSource.parseNumber},
			{key:"DBNAME",parser:YAHOO.util.DataSource.parseNumber},
			{key:"REGTYPE",parser:YAHOO.util.DataSource.parseNumber},
			{key:"TREATLEVEL",parser:YAHOO.util.DataSource.parseNumber},
			{key:"CENTERCODE",parser:YAHOO.util.DataSource.parseNumber},
            {key:"TITLE",parser:YAHOO.util.DataSource.parseString},
            {key:"OFISSUINGBODY",parser:YAHOO.util.DataSource.parseString},
            {key:"KEYTITLE",parser:YAHOO.util.DataSource.parseString},
			{key:"ABBREVIATEDTITLE",parser:YAHOO.util.DataSource.parseString},
			{key:"ABBREVIATEDTITLEMEDLINE",parser:YAHOO.util.DataSource.parseString},
            {key:"SUBTITLE",parser:YAHOO.util.DataSource.parseString},
			{key:"SECTIONPART",parser:YAHOO.util.DataSource.parseString},
			{key:"OFSECTIONPART",parser:YAHOO.util.DataSource.parseString},
            {key:"PARALLELTITLE",parser:YAHOO.util.DataSource.parseString},
			{key:"OTHERTITLE",parser:YAHOO.util.DataSource.parseString},
			{key:"HASOTHERLANGUAGEEDITIONS",parser:YAHOO.util.DataSource.parseString},
			{key:"ANOTHERLANGUAGEEDITION",parser:YAHOO.util.DataSource.parseString},
			{key:"HASSUBSERIES",parser:YAHOO.util.DataSource.parseString},
			{key:"ISSUBSERIESOF",parser:YAHOO.util.DataSource.parseString},
			{key:"HASSUPPLEMENTINSERT",parser:YAHOO.util.DataSource.parseString},
			{key:"TITLECONTINUATIONOF",parser:YAHOO.util.DataSource.parseString},
			{key:"TITLEPARTIALCONTINUATIONOF",parser:YAHOO.util.DataSource.parseString},
			{key:"TITLEABSORBVED",parser:YAHOO.util.DataSource.parseString},
			{key:"TITLEABSORBVEDINPARTINPART",parser:YAHOO.util.DataSource.parseString},
			{key:"TITLEFORMEDBYTHESPLITTINGOF",parser:YAHOO.util.DataSource.parseString},
			{key:"TITLEMERGEDOFWITH",parser:YAHOO.util.DataSource.parseString},
			{key:"TITLECONTINUEDTBY",parser:YAHOO.util.DataSource.parseString},
			{key:"TITLECONTINUATEDINPARTBY",parser:YAHOO.util.DataSource.parseString},
			{key:"TITLEABSORBVEDBY",parser:YAHOO.util.DataSource.parseString},
			{key:"TITLEABSORBVEDINPARTBY",parser:YAHOO.util.DataSource.parseString},
			{key:"TITLESPLITINTO",parser:YAHOO.util.DataSource.parseString},
			{key:"TITLEMERGEDWITH",parser:YAHOO.util.DataSource.parseString},
			{key:"TITLETOFORM",parser:YAHOO.util.DataSource.parseString},
            {key:"PUBLISHER",parser:YAHOO.util.DataSource.parseString},
            {key:"CITY",parser:YAHOO.util.DataSource.parseString},
			{key:"COUNTRY",parser:YAHOO.util.DataSource.parseString},
			{key:"STATE",parser:YAHOO.util.DataSource.parseString},
            {key:"ISSN",parser:YAHOO.util.DataSource.parseString},
			{key:"CODEN",parser:YAHOO.util.DataSource.parseString},
			{key:"PUBLICATIONSTATUS",parser:YAHOO.util.DataSource.parseString},
            {key:"INITIALDATE",parser:YAHOO.util.DataSource.parseString},
            {key:"INITIALVOLUME",parser:YAHOO.util.DataSource.parseString},
            {key:"INITIALNUMBER",parser:YAHOO.util.DataSource.parseString},
            {key:"FINALDATE",parser:YAHOO.util.DataSource.parseString},
            {key:"FINALVOLUME",parser:YAHOO.util.DataSource.parseString},
            {key:"FINALNUMBER",parser:YAHOO.util.DataSource.parseString},
			{key:"FREQUENCY",parser:YAHOO.util.DataSource.parseString},
			{key:"PUBLICATIONLEVEL",parser:YAHOO.util.DataSource.parseString},
			{key:"ALPHABETTITLE",parser:YAHOO.util.DataSource.parseString},
			{key:"LANGUAGETEXT",parser:YAHOO.util.DataSource.parseString},
			{key:"LANGUAGEABSTRACT",parser:YAHOO.util.DataSource.parseString},
			{key:"RELATEDSYSTEMS",parser:YAHOO.util.DataSource.parseString},
			{key:"NATIONALCODE",parser:YAHOO.util.DataSource.parseString},
			{key:"SECSIDENTIFICATION",parser:YAHOO.util.DataSource.parseString},
			{key:"MEDLINECODE",parser:YAHOO.util.DataSource.parseString},
			{key:"CLASSIFICATION",parser:YAHOO.util.DataSource.parseString},
			{key:"CLASSIFICATIONCDU",parser:YAHOO.util.DataSource.parseString},
			{key:"CLASSIFICATIONDEWEY",parser:YAHOO.util.DataSource.parseString},
			{key:"THEMATICAREA",parser:YAHOO.util.DataSource.parseString},
			{key:"DESCRIPTORS",parser:YAHOO.util.DataSource.parseString},
			{key:"ANOTHERDESCRIPTORS",parser:YAHOO.util.DataSource.parseString},
			{key:"INDEXINGCOVERAGE",parser:YAHOO.util.DataSource.parseString},
			{key:"METHODACQUISITION",parser:YAHOO.util.DataSource.parseString},
			{key:"NOTES",parser:YAHOO.util.DataSource.parseString},
			{key:"URLPORTAL",parser:YAHOO.util.DataSource.parseString},
			{key:"URLINFORMATION",parser:YAHOO.util.DataSource.parseString},
			{key:"SPECIALTYVHL",parser:YAHOO.util.DataSource.parseString},
			{key:"USERVHL",parser:YAHOO.util.DataSource.parseString},
			{key:"NOTESVHL",parser:YAHOO.util.DataSource.parseString},
			{key:"WHOINDEX",parser:YAHOO.util.DataSource.parseString},
			{key:"CODEPUBLISHER",parser:YAHOO.util.DataSource.parseString},
            {key:"FASC",parser:YAHOO.util.DataSource.parseString},
            {key:"IDMFN",parser:YAHOO.util.DataSource.parseNumber}],

         metaFields : {
            totalRecords: 'totalRecords',
            paginationRecordOffset : "startIndex",
            sortKey: "flag",
            sortDir: "asc"
        }
    };

    var buildQueryString = function (state,dt) {
        return "&startIndex=" + state.pagination.recordOffset +
               "&results=" + state.pagination.rowsPerPage;
    };

    var myPaginator = new Paginator({
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
        template           : "{FirstPageLink} {PreviousPageLink} " +
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
        initialRequest         : '&startIndex=0&results=' + numRecordsPage,
        generateRequest        : buildQueryString,
        paginationEventHandler : DataTable.handleDataSourcePagination,
        paginator              : myPaginator
    };

	this.myFormatTitle = function(elCell, oRecord, oColumn, oData) {
        var id = oRecord.getData('MFN');
        var button = "<a href=\"javascript: selectView("+id+",'selView');\" id=\"btView"+id+"\"><img src=\"public/images/common/icon/singleButton_ok.png\" title=\"add\" alt=\"add\" id=\"btAdd"+id+"\"/></a>";
        /***  Head View   ***/
        var presentation = "<div id=\"viewHead"+id+"\" style=\"display: block;\">" + button + oRecord.getData('TITLE');
        if(oRecord.getData('SUBTITLE') != null){ presentation = presentation + ": " + oRecord.getData('SUBTITLE');  }
        if(oRecord.getData('SECTIONPART') != null){ presentation = presentation + ". " + oRecord.getData('SECTIONPART');  }
        if(oRecord.getData('OFSECTIONPART') != null){ presentation = presentation + ", " + oRecord.getData('OFSECTIONPART');  }
        if(oRecord.getData('OFISSUINGBODY') != null){ presentation = presentation + " / " + oRecord.getData('OFISSUINGBODY');  }
        if(oRecord.getData('PARALLELTITLE') != null){ presentation = presentation + " = " + oRecord.getData('PARALLELTITLE');  }
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
        var presentation = presentation + "<div id=\"selView"+id+ "\" style=\"display: none;\" ><div id=\"vizForm\">";
        var presentation = presentation + "<a href=\"javascript:selectView("+id+",'Catalog');\">Catalogo</a><br />";
        var presentation = presentation + "<a href=\"javascript:selectView("+id+",'Short');\">Curto</a><br />";
        var presentation = presentation + "<a href=\"javascript:selectView("+id+",'Long'); \">Longo</a><br />";
        var presentation = presentation + "<a href=\"javascript:selectView("+id+",'Full');\">Completo</a><br />";
        var presentation = presentation + "</div></div></div>";

        /***  Catalog View  ***/
        var presentation = presentation + "<div id=\"formRow"+id+"Catalog\" style=\"display: none;\"><br />";
		if(oRecord.getData('HASSUPPLEMENTINSERT') != null)
        { presentation = presentation + lbltitleHasSupplementInsert + " : " + oRecord.getData('HASSUPPLEMENTINSERT') + "<br /><br />"; }
        if(oRecord.getData('ISSN') != null)
        { presentation = presentation +  lblISSN + ": "+oRecord.getData('ISSN')+"<br />"; }
		if(oRecord.getData('ABBREVIATEDTITLE') != null)
        { presentation = presentation + lblabbreviatedTitle + ": " + oRecord.getData('ABBREVIATEDTITLE') + "<br />"; }
        var presentation = presentation + "</div>";

        /***  Short View  ***/
        var presentation = presentation + "<div id=\"formRow"+id+"Short\" style=\"display: none;\"><br />";
        if(oRecord.getData('ISSN') != null)
        { presentation = presentation +  lblISSN + ": "+oRecord.getData('ISSN')+"<br />"; }
		if(oRecord.getData('ABBREVIATEDTITLE') != null)
        { presentation = presentation + lblabbreviatedTitle + ": " + oRecord.getData('ABBREVIATEDTITLE') + "<br />"; }
        var presentation = presentation + "</div>";

        /***  Long View  ***/
        var presentation = presentation + "<div id=\"formRow"+id+"Long\" style=\"display: none;\"><br />";
		if(oRecord.getData('HASSUPPLEMENTINSERT') != null)
        { presentation = presentation + lbltitleHasSupplementInsert + " : " + oRecord.getData('HASSUPPLEMENTINSERT') + "<br /><br />"; }
        if(oRecord.getData('ISSN') != null)
        { presentation = presentation +  lblISSN + ": "+oRecord.getData('ISSN')+"<br />"; }
		if(oRecord.getData('ABBREVIATEDTITLE') != null)
        { presentation = presentation + lblabbreviatedTitle + ": " + oRecord.getData('ABBREVIATEDTITLE') + "<br />"; }
        var presentation = presentation + "</div>";

        /***  Full View  ***/
        var presentation = presentation + "<div id=\"formRow"+id+"Full\" style=\"display: none;\"><br />";
        var button = "<a href=\"javascript: selectView("+id+",'off');\" id=\"btView"+id+"\"><img src=\"public/images/common/icon/singleButton_erase.png\" title=\"add\" alt=\"add\" id=\"btAdd"+id+"\"/></a>";

        if(oRecord.getData('IDMFN') != null)
        { presentation = presentation + button + " MFN = " + oRecord.getData('IDMFN') + "<br />"; }
        if(oRecord.getData('DBNAME') != null)
        { presentation = presentation +lblnationalCode + " [1] : " + oRecord.getData('DBNAME') + "<br />"; }
        if(oRecord.getData('REGTYPE') != null)
        { presentation = presentation + lblnationalCode + " [5] : " + oRecord.getData('REGTYPEE') + "<br />"; }
        if(oRecord.getData('TREATLEVEL') != null)
        { presentation = presentation + lblnationalCode + " [10] : " + oRecord.getData('TREATLEVEL') + "<br />"; }
        if(oRecord.getData('CENTERCODE') != null)
        { presentation = presentation + lblnationalCode + " [20] : " + oRecord.getData('CENTERCODE') + "<br />"; }
        if(oRecord.getData('NATIONALCODE') != null)
        { presentation = presentation + lblnationalCode + " [20] : <div align=\"left\">" + oRecord.getData('NATIONALCODE') + "</div><br />"; }
        if(oRecord.getData('SECSIDENTIFICATION') != null)
        { presentation = presentation + lblsecsIdentification + " [37] : " + oRecord.getData('SECSIDENTIFICATION') + "<br />"; }
        if(oRecord.getData('RELATEDSYSTEMS') != null)
        { presentation = presentation + lblrelatedSystems + " [40] : " + oRecord.getData('RELATEDSYSTEMS') + "<br />"; }
        if(oRecord.getData('PUBLICATIONSTATUS') != null)
        { presentation = presentation +  lblpublicationStatus + "[50] : "+oRecord.getData('PUBLICATIONSTATUS')+"<br />"; }
        if(oRecord.getData('TITLE') != null)
        { presentation = presentation + lblTitle + " [100] : " + oRecord.getData('TITLE') + "<br />"; }
        if(oRecord.getData('OFISSUINGBODY') != null)
        { presentation = presentation + lblnameOfIssuingBody + " [140] : " + oRecord.getData('OFISSUINGBODY') + "<br />"; }
        if(oRecord.getData('SUBTITLE') != null)
        { presentation = presentation + lblsubTitle +" [110] : " + oRecord.getData('SUBTITLE') + "<br />"; }
		if(oRecord.getData('SECTIONPART') != null)
        { presentation = presentation + lblsectionPart +" [120] : " + oRecord.getData('SECTIONPART') + "<br />"; }
		if(oRecord.getData('OFSECTIONPART') != null)
        { presentation = presentation + lbltitleOfSectionPart +" [130] : " + oRecord.getData('OFSECTIONPART') + "<br />"; }
		if(oRecord.getData('KEYTITLE') != null)
        { presentation = presentation + lblkeyTitle + " [149] : " + oRecord.getData('KEYTITLE') + "<br />"; }
		if(oRecord.getData('ABBREVIATEDTITLE') != null)
        { presentation = presentation + lblabbreviatedTitle + " [150] : " + oRecord.getData('ABBREVIATEDTITLE') + "<br />"; }
		if(oRecord.getData('ABBREVIATEDTITLEMEDLINE') != null)
        { presentation = presentation + lblabbreviatedTitleMedline + " [180] : " + oRecord.getData('ABBREVIATEDTITLEMEDLINE') + "<br />"; }
		if(oRecord.getData('PARALLELTITLE') != null)
        { presentation = presentation + lblparallelTitle +" [230] : " + oRecord.getData('PARALLELTITLE') + "<br />"; }
		if(oRecord.getData('OTHERTITLE') != null)
        { presentation = presentation + lblotherTitle + " [240] : " + oRecord.getData('OTHERTITLE') + "<br />"; }
        if(oRecord.getData('INITIALVOLUME') != null)
        { presentation = presentation + lblinitialVolume + " [301] : " + oRecord.getData('INITIALVOLUME') + "<br />"; }
		if(oRecord.getData('INITIALDATE') != null)
        { presentation = presentation + lblfinalDate + " [302] : " + oRecord.getData('INITIALDATE') + "<br />"; }
		if(oRecord.getData('INITIALNUMBER') != null)
        { presentation = presentation + lblinitialNumber + " [303] : " + oRecord.getData('INITIALNUMBER') + "<br />"; }
		if(oRecord.getData('FINALVOLUME') != null)
        { presentation = presentation + lblfinalVolume + " [304] : " + oRecord.getData('FINALVOLUME') + "<br />"; }
        if(oRecord.getData('FINALDATE') != null)
        { presentation = presentation + lblfinalDate + " [305] : " + oRecord.getData('FINALDATE') + "<br />"; }
        if(oRecord.getData('FINALNUMBER') != null)
        { presentation = presentation + lblfinalNumber + " [306] : " + oRecord.getData('FINALNUMBER') + "<br />"; }
        if(oRecord.getData('COUNTRY') != null)
        { presentation = presentation + lblCountry + " [310] : " + oRecord.getData('COUNTRY') + "<br />"; }
		if(oRecord.getData('STATE') != null)
        { presentation = presentation + lblState + " [320] : " + oRecord.getData('STATE') + "<br />"; }
        if(oRecord.getData('PUBLICATIONLEVEL') != null)
        { presentation = presentation + lblpublicationLevel + " [330] : " + oRecord.getData('PUBLICATIONLEVEL') + "<br />"; }
        if(oRecord.getData('ALPHABETTITLE') != null)
        { presentation = presentation + lblalphabetTitle + " [340] : " + oRecord.getData('ALPHABETTITLE') + "<br />"; }
        if(oRecord.getData('LANGUAGETEXT') != null)
        { presentation = presentation + lbllanguageText + " [350] : " + oRecord.getData('LANGUAGETEXT') + "<br />"; }
        if(oRecord.getData('LANGUAGEABSTRACT') != null)
        { presentation = presentation + lbllanguageAbstract + " [360] : " + oRecord.getData('LANGUAGEABSTRACT') + "<br />"; }
        if(oRecord.getData('FREQUENCY') != null)
        { presentation = presentation + lblFrequency + " [380] : " + oRecord.getData('FREQUENCY') + "<br />"; }
        if(oRecord.getData('ISSN') != null)
        { presentation = presentation +  lblISSN + "[400] : "+oRecord.getData('ISSN')+"<br />"; }
        if(oRecord.getData('CODEN') != null)
        { presentation = presentation +  lblcoden + "[410] : "+oRecord.getData('CODEN')+"<br />"; }
        if(oRecord.getData('MEDLINECODE') != null)
        { presentation = presentation + lblmedlineCode + " [420] : " + oRecord.getData('MEDLINECODE') + "<br />"; }
        if(oRecord.getData('CLASSIFICATIONCDU') != null)
        { presentation = presentation + lblclassificationCdu + " [421] : " + oRecord.getData('CLASSIFICATIONCDU') + "<br />"; }
        if(oRecord.getData('CLASSIFICATIONDEWEY') != null)
        { presentation = presentation + lblclassificationDewey + " [422] : " + oRecord.getData('CLASSIFICATIONDEWEY') + "<br />"; }
        if(oRecord.getData('CLASSIFICATION') != null)
        { presentation = presentation + lblclassification + " [430] : " + oRecord.getData('CLASSIFICATION') + "<br />"; }
        if(oRecord.getData('THEMATICAREA') != null)
        { presentation = presentation + lblthematicaArea + " [435] : " + oRecord.getData('THEMATICAREA') + "<br />"; }
        if(oRecord.getData('SPECIALTYVHL') != null)
        { presentation = presentation + lblspecialtyVHL + " [436] : " + oRecord.getData('SPECIALTYVHL') + "<br />"; }
        if(oRecord.getData('DESCRIPTORS') != null)
        { presentation = presentation + lbldescriptors + " [440] : " + oRecord.getData('DESCRIPTORS') + "<br />"; }
        if(oRecord.getData('ANOTHERDESCRIPTORS') != null)
        { presentation = presentation + lblotherDescriptors + " [441] : " + oRecord.getData('ANOTHERDESCRIPTORS') + "<br />"; }
        if(oRecord.getData('USERVHL') != null)
        { presentation = presentation + lbluserVHL + " [445] : " + oRecord.getData('USERVHL') + "<br />"; }
        if(oRecord.getData('INDEXINGCOVERAGE') != null)
        { presentation = presentation + lblindexingCoverage + " [450] : " + oRecord.getData('INDEXINGCOVERAGE') + "<br />"; }
        if(oRecord.getData('METHODACQUISITION') != null)
        { presentation = presentation + lblmethodAcquisition+" [470] : " + oRecord.getData('METHODACQUISITION') + "<br />"; }
        if(oRecord.getData('PUBLISHER') != null)
        { presentation = presentation + lblpublisher + " [480] : " + oRecord.getData('PUBLISHER') + "<br />"; }
        if(oRecord.getData('CITY') != null)
        { presentation = presentation + lblplace + " [490] : " + oRecord.getData('CITY') + "<br />"; }
        if(oRecord.getData('HASOTHERLANGUAGEEDITIONS') != null)
        { presentation = presentation + lbltitleHasOtherLanguageEditions + " [510] : " + oRecord.getData('HASOTHERLANGUAGEEDITIONS') + "<br />"; }
		if(oRecord.getData('ANOTHERLANGUAGEEDITION') != null)
        { presentation = presentation + lbltitleAnotherLanguageEdition + " [520] : " + oRecord.getData('ANOTHERLANGUAGEEDITION') + "<br />"; }
		if(oRecord.getData('HASSUBSERIES') != null)
        { presentation = presentation + lbltitleHasSubseries + " [530] : " + oRecord.getData('HASSUBSERIES') + "<br />"; }
		if(oRecord.getData('ISSUBSERIESOF') != null)
        { presentation = presentation + lbltitleIsSubseriesOf + " [540] : " + oRecord.getData('ISSUBSERIESOF') + "<br />"; }
		if(oRecord.getData('HASSUPPLEMENTINSERT') != null)
        { presentation = presentation + lbltitleHasSupplementInsert + " [550] : " + oRecord.getData('HASSUPPLEMENTINSERT') + "<br />"; }
		if(oRecord.getData('HASSUPPLEMENTINSERTOF') != null)
        { presentation = presentation + lbltitleIsSupplementInsertOf + " [560] : " + oRecord.getData('HASSUPPLEMENTINSERT') + "<br />"; }
        if(oRecord.getData('TITLECONTINUATIONOF') != null)
        { presentation = presentation +  lbltitleContinuationOf + " [610]: " + oRecord.getData('TITLECONTINUATIONOF') + "<br />"; }
        if(oRecord.getData('TITLEPARTIALCONTINUATIONOF') != null)
        { presentation = presentation +  lbltitlePartialContinuationOf + " [620]: " + oRecord.getData('TITLEPARTIALCONTINUATIONOF') + "<br />"; }
        if(oRecord.getData('TITLEABSORBVED') != null)
        { presentation = presentation +  lbltitleAbsorbed + " [650]: " + oRecord.getData('TITLEABSORBVED') + "<br />"; }
        if(oRecord.getData('TITLEABSORBVEDINPARTINPART') != null)
        { presentation = presentation +  lbltitleAbsorbedInPart + " [660]: " + oRecord.getData('TITLEABSORBVEDINPARTINPART') + "<br />"; }
        if(oRecord.getData('TITLEFORMEDBYTHESPLITTINGOF') != null)
        { presentation = presentation +  lbltitleFormedByTheSplittingOf + " [670]: " + oRecord.getData('TITLEFORMEDBYTHESPLITTINGOF') + "<br />"; }
        if(oRecord.getData('TITLEMERGEDOFWITH') != null)
        { presentation = presentation +  lbltitleMergeOfWith + " [680]: " + oRecord.getData('TITLEMERGEDOFWITH') + "<br />"; }
        if(oRecord.getData('TITLECONTINUEDTBY') != null)
        { presentation = presentation +  lbltitleContinuedBy + " [710]: " + oRecord.getData('TITLECONTINUEDTBY') + "<br />"; }
        if(oRecord.getData('TITLECONTINUATEDINPARTBY') != null)
        { presentation = presentation +  lbltitleContinuedInPartBy + " [720]: " + oRecord.getData('TITLECONTINUATEDINPARTBY') + "<br />"; }
        if(oRecord.getData('TITLEABSORBVEDBY') != null)
        { presentation = presentation +  lbltitleAbsorbedBy + " [750]: " + oRecord.getData('TITLEABSORBVEDBY') + "<br />"; }
        if(oRecord.getData('TITLEABSORBVEDINPARTBY') != null)
        { presentation = presentation +  lbltitleAbsorbedInPartBy + " [760]: " + oRecord.getData('TITLEABSORBVEDINPARTBY') + "<br />"; }
        if(oRecord.getData('TITLESPLITINTO') != null)
        { presentation = presentation +  lbltitleSplitInto + " [770]: " + oRecord.getData('TITLESPLITINTO') + "<br />"; }
        if(oRecord.getData('TITLEMERGEDWITH') != null)
        { presentation = presentation +  lbltitleMergedWith + " [780]: " + oRecord.getData('TITLEMERGEDWITH') + "<br />"; }
        if(oRecord.getData('TITLETOFORM') != null)
        { presentation = presentation +  lbltitleToForm + " [790]: " + oRecord.getData('TITLETOFORM') + "<br />"; }
        if(oRecord.getData('URLINFORMATION') != null)
        { presentation = presentation + lblurlInformation + " [860] : " + oRecord.getData('URLINFORMATION') + "<br />"; }
        if(oRecord.getData('NOTES') != null)
        { presentation = presentation + lblnotes + " [900] : " + oRecord.getData('NOTES') + "<br />"; }
        if(oRecord.getData('NOTESVHL') != null)
        { presentation = presentation + lblnotesBVS + " [910] : " + oRecord.getData('NOTESVHL') + "<br />"; }
        if(oRecord.getData('WHOINDEX') != null)
        { presentation = presentation + lblwhoindex + " [920] : " + oRecord.getData('WHOINDEX') + "<br />"; }
        if(oRecord.getData('CODEPUBLISHER') != null)
        { presentation = presentation + lblcodepublisher + " [930] : " + oRecord.getData('CODEPUBLISHER') + "<br />"; }
        if(oRecord.getData('URLPORTAL') != null)
        { presentation = presentation + lblurlPortal + " [999] : " + oRecord.getData('URLPORTAL') + "<br />"; }
        elCell.innerHTML = presentation +"</div>" ;
    };



    this.myFormatAction = function(elCell, oRecord, oColumn, oData) {
    	var mfn = oData;
        elCell.innerHTML = "<a href=\"?m=title&edit=" + mfn + "&tty="+d.getTime()+"&searchExpr="+search+"\" class=\"tButton\">"+btEdTitle+"</a> <a href=\"?m=title&action=delete&id="+mfn+"\" class=\"tButton tErase\">"+btDelete+"</a>";
	};
	this.myFormatFascic = function(elCell, oRecord, oColumn, oData) {
    	var mfn = oData;
        var initialDate = oRecord.getData('INITIALDATE'),
            initialVolume = oRecord.getData('INITIALVOLUME'),
            initialNumber = oRecord.getData('INITIALNUMBER');

        tQuery = "initialDate="+initialDate+"&initialVolume="+initialVolume+"&initialNumber="+initialNumber;
        elCell.innerHTML = "<a href=\"?m=facic&title="+mfn+"&tty="+d.getTime() + "&"+ tQuery + "\" class=\"tButton\">"+btList+" "+lblFacic+"</a>";
	};
	this.myFormatTitPlus = function(elCell, oRecord, oColumn, oData) {
    	var mfn = oRecord.getData('MFN');
        elCell.innerHTML = "<a href=\"?m=titleplus&edit=" + mfn +"&title="+mfn+"&tty="+d.getTime()+"&searchExpr="+search+"\" class=\"tButton\">"+btEdTitlePlus+"</a> <a href=\"?m=titleplus&action=delete&title="+mfn+"\" class=\"tButton tErase\">"+btDelete+"</a>";
	};

	if(role == "Operator")
	{
		var myColumnDefs = [
	    	{key:"TITLE",label:lblTitle, formatter:this.myFormatTitle, sortable:false},
	    ];
	}
	if(role == "Editor")
	{
		var myColumnDefs = [
	        //{key:"MFN",label:lblID,sortable:false},
	    	{key:"TITLE",label:lblTitle, formatter:this.myFormatTitle, sortable:false},
	 		//{key:"IDMFN",label:lblActionTitlePlus, formatter:this.myFormatTitPlus, sortable:false},
	 		//{key:"FASC",label:lblActionFacic, formatter:this.myFormatFascic, sortable:false}
	    ];
	}
	if(role == "Administrator")
	{
		var myColumnDefs = [
	        //{key:"MFN",label:lblID,sortable:false},
	    	{key:"TITLE",label:lblTitle, formatter:this.myFormatTitle, sortable:false},
	 		//{key:"IDMFN",label:lblActionTitle, formatter:this.myFormatAction, sortable:false},
	 		//{key:"FASC",label:lblActionFacic, formatter:this.myFormatFascic, sortable:false},
	    	//{key:"TITLEEDT",label:lblActionTitlePlus, formatter:this.myFormatTitPlus, sortable:false}
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
{/literal}
</script>