<?php
$_SESSION["MODULO"]="acquisitions";
global $arrHttp,$msgstr,$db_path,$valortag,$lista_bases;
	include ("../lang/acquisitions.php");
?>
			<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent loanSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
						<h4>&#160;<strong><?php echo $msgstr["suggestions"]?></strong></h4>
					</div>
					<div class="sectionButtons">
						<a href="../acquisitions/overview.php?encabezado=s" class="defaultButton multiLine resumeButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["overview"]?></strong></span>
						</a>
<?php
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_NEWSUGGESTIONS"])){
?>
						<a href="../acquisitions/suggestions_new.php?encabezado=s&base=suggestions&cipar=suggestions.par" class="defaultButton multiLine newsuggestionButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["newsugges"]?></strong></span>
						</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_APPROVREJECT"])){
?>
						<a href="../acquisitions/suggestions_status.php?base=suggestions&cipar=suggestions.par&sort=TI&encabezado=s" class="defaultButton multiLine approvedsuggestionsButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["approve"]."/".$msgstr["reject"]?></strong></span>
						</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_BIDDING"])){
?>
						<a href="../acquisitions/bidding.php?base=suggestions&sort=DA&encabezado=s&menu=s" class="defaultButton multiLine biddingButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["bidding"]?></strong></span>
						</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_DECISION"])){
?>
						<a href="../acquisitions/decision.php?base=suggestions&sort=DA&encabezado=s&menu=s" class="defaultButton multiLine decisionButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["decision"]?></strong></span>
						</a>
<?php }?>
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
				<div class="boxContent orderSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
						<h4>&#160;<strong><?php echo $msgstr["purchase"]?></strong></h4>
					</div>
					<div class="sectionButtons">
<?php
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_CREATEORDER"])){
?>
						<a href="../acquisitions/order_new_menu.php?base=suggestions&sort=PV&encabezado=s" class="defaultButton multiLine createpurchaseorderButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["createorder"]?></strong></span>
						</a>

						<a href="../acquisitions/order.php?base=suggestions&sort=PV&encabezado=s" class="defaultButton multiLine requisitionButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["generateorder"]?></strong></span>
						</a>
<?php }?>
						<a href="../acquisitions/pending_order.php?base=purchaseorder&sort=PV&encabezado=s" class="defaultButton multiLine pendingButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["pendingorder"]?></strong></span>
						</a>
<?php if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_RECEIVING"])){
?>
						<a href="../acquisitions/receive_order.php?encabezado=s" class="defaultButton multiLine receivingButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["receiving"]?></strong></span>
						</a>
<?php }?>
					</div>
					<div class="spacer">&#160;</div>
				</div>
				<div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>
			</div>
<?php
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_ACQDATABASES"])){
?>
			<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent dbSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
						<h4>&#160;<strong><?php echo $msgstr["basedatos"]?></strong></h4>
					</div>
					<div class="sectionButtons">
						<a href="../dataentry/browse.php?base=suggestions&modulo=acquisitions" class="defaultButton multiLine suggestButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["suggestions"]?></strong></span>
						</a>
						<a href="../dataentry/browse.php?base=providers&modulo=acquisitions" class="defaultButton multiLine providersButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["providers"]?></strong></span>
						</a>
						<a href="../dataentry/browse.php?base=purchaseorder&modulo=acquisitions" class="defaultButton multiLine requisitionButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["purchase"]?></strong></span>
						</a>
						<a href="../dataentry/browse.php?base=copies&modulo=acquisitions" class="defaultButton multiLine copiesdbButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["copies"]?></strong></span>
						</a>

					</div>
					<div class="spacer">&#160;</div>
				</div>
				<div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>
			</div>
<?php  }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_RESETCN"])){
?>
            <div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent toolSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
						<h4>&#160;<strong><?php echo $msgstr["admin"]?></strong></h4>
					</div>

					<div class="sectionButtons">
						<a href="../acquisitions/resetautoinc.php?base=suggestions" class="defaultButton multiLine resetButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["resetctl"]. " (".$msgstr["suggestions"].")"?></strong></span>
						</a>
					</div>
					<div class="spacer">&#160;</div>

				</div>
				<div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>
			</div>
<?php }?>