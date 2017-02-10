<div class="yui-skin-sam">
    <div id="msgDialog">
      <div class="hd">{$BVS_LANG.titleApp}</div>
        <div class="bd">
        <div id="msgDisplayed"></div>
      </div>
    </div>
</div>
<script type="text/javascript">
YAHOO.widget.DataTable.MSG_LOADING = "<div class='loading'><div>{$BVS_LANG.MSG_LOADING}</div></div>";
YAHOO.namespace("example.container");
{literal}

var handleCancel = function() {
        this.cancel();
};

function msgDialog(format) {


    var handleSuccess = function(o) {
            document.getElementById('msgDisplayed').innerHTML = o.responseText;
    }
    var handleFailure = function(o) {
            document.getElementById('msgDisplayed').innerHTML = 'failure';
    }

    var callback = {
            success: handleSuccess,
            failure: handleFailure
    };
    
    document.getElementById('msgDisplayed').innerHTML = YAHOO.widget.DataTable.MSG_LOADING;
    var sUrl = "reportService.php?m=report&startIndex=0&results=50&format="+format;
    var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callback, "");
    YAHOO.example.container.msgDialog.show();
}

YAHOO.example.container.msgDialog = new YAHOO.widget.Dialog("msgDialog",
                                                { width : "80em",
                                                  height : "5em",
                                                  fixedcenter : true,
                                                  visible : false,
                                                  constraintoviewport : true,
                                                  buttons : [ { text:"OK", handler:handleCancel } ]
                                                });
YAHOO.example.container.msgDialog.render();
{/literal}
</script>

    <div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
        <div class="boxTop">
            <div class="btLeft">&#160;</div>
            <div class="btRight">&#160;</div>
        </div>
        <div class="boxContent reportLibrary">
        
            <div class="sectionIcon"><div class="spacer">&#160;</div></div>
            <div class="sectionTitle">
                <h4><strong>{$BVS_LANG.lblReportLib}</strong></h4>
            </div>
             <div class="sectionButtons">
                <div class="searchTitles">
                <div class="stInput">
                    <select name="role" id="role" title="{$BVS_LANG.lblRole}" style="display:none;">
                         {if $smarty.session.role eq "Administrator"}
                            <option value="{$smarty.session.role}" selected="selected">{$smarty.session.role}</option>
                         {else}
                            <option value="" label="{$BVS_LANG.optSelValue}" selected="selected">{$BVS_LANG.optSelValue}</option>
                            {html_options values=$smarty.session.optRole output=$smarty.session.optRole}
                         {/if}
                    </select>
                    <select name="library" id="library" title="{$BVS_LANG.lblLibrary}" class="textEntry" onchange="changeLib('{$smarty.session.lang}', '{$BVS_LANG.msgLibChange}', 'report');">
                        <option value="" label="{$BVS_LANG.optSelValue}">{$BVS_LANG.optSelValue}</option>
                        {html_options values=$smarty.session.optLibraryDir output=$smarty.session.optLibrary}
                    </select>

                </div>
                </div>
            </div>
            <div class="menuActions">
            <ul>
                <li>
                    <a href="javascript: msgDialog('titCurrColect');" id="btTitCurrColect" class="defaultButton reportButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblTitCurrColect}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="javascript: msgDialog('titWCurrColect');" class="defaultButton reportButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblTitWCurrColect}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="javascript: msgDialog('titFinishColect');" class="defaultButton reportButton">
                        <img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblTitFinishColect}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="javascript: msgDialog('titWithoutColect');" class="defaultButton reportButton">
                        <img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblTitWithoutColect}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="javascript: msgDialog('numTitRegLib');" class="defaultButton reportButton">
                    <img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                    <span><strong>{$BVS_LANG.lblNumTitRegLib}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="javascript: msgDialog('totIssRegLib');" class="defaultButton reportButton">
                    <img src="public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                    <span><strong>{$BVS_LANG.lblTotIssRegLib}</strong></span>
                    </a>
                </li>
             </ul>
             </div>
              <div class="spacer">&#160;</div>

        </div>

            <div class="boxBottom">
                <div class="bbLeft">&#160;</div>
                <div class="bbRight">&#160;</div>
            </div>
        </div>
{if $smarty.session.role neq 'AdministratorOnly'|| $smarty.session.role eq 'EditorOnly' || $smarty.session.role eq 'Editor'}
    <div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
        <div class="boxTop">
            <div class="btLeft">&#160;</div>
            <div class="btRight">&#160;</div>
        </div>
        <div class="boxContent reportDatabase">

            <div class="sectionIcon"><div class="spacer">&#160;</div></div>
            <div class="sectionTitle">
                <h4><strong>{$BVS_LANG.lblReportDB}</strong></h4>
            </div>
            <div class="menuActions">
            <ul>
                <li>
                    <a href="#" class="defaultButton reportButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblIssuesBySupplier}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="#" class="defaultButton reportButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblTotTitFreeEletronicAccess}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="#" class="defaultButton reportButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblTotTitControlEletronicAccess}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="#" class="defaultButton reportButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblTotTitOneColection}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="#" class="defaultButton reportButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblTotTitMoreColection}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="#" class="defaultButton reportButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblTotTitWithoutColection}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="#" class="defaultButton reportButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblTotTitByDonation}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="#" class="defaultButton reportButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblTotTitByPermute}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="#" class="defaultButton reportButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblTotTitByBuying}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="#" class="defaultButton reportButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblIDNumber}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="#" class="defaultButton reportButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblTotColectionBireme}</strong></span>
                    </a>
                </li>
                <li>
                    <a href="#" class="defaultButton reportButton">
                        <img src="{$BVS_CONF.install_dir}/public/images/common/mainBox_iconBorder.gif" alt="" title="" />
                        <span><strong>{$BVS_LANG.lblTotTitBireme}</strong></span>
                    </a>
                </li>
             </ul>
             </div>
              <div class="spacer">&#160;</div>

        </div>

            <div class="boxBottom">
                <div class="bbLeft">&#160;</div>
                <div class="bbRight">&#160;</div>
            </div>
        </div>
{/if}
