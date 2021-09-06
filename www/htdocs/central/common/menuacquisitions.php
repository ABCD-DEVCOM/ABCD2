<?php
/* Modifications
20210310 fho4abcd removed language include.(set by inicio.php)
*/
$_SESSION["MODULO"]="acquisitions";
global $arrHttp,$msgstr,$db_path,$valortag,$lista_bases;
?>
			<div class="mainBox" >

				<div class="boxContent loanSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
						<h4>&#160;<strong><?php echo $msgstr["suggestions"]?></strong></h4>
					</div>
					<div class="sectionButtons">
						<a href="../acquisitions/overview.php?encabezado=s" class="menuButton multiLine resumeButton">
							<img src="../../assets/images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["overview"]?></strong></span>
						</a>
<?php
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_NEWSUGGESTIONS"])){
?>
						<a href="../acquisitions/suggestions_new.php?encabezado=s&base=suggestions&cipar=suggestions.par" class="menuButton multiLine newsuggestionButton">
							<img src="../../assets/images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["newsugges"]?></strong></span>
						</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_APPROVREJECT"])){
?>
						<a href="../acquisitions/suggestions_status.php?base=suggestions&cipar=suggestions.par&sort=TI&encabezado=s" class="menuButton multiLine approvedsuggestionsButton">
							<img src="../../assets/images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["approve"]."/".$msgstr["reject"]?></strong></span>
						</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_BIDDING"])){
?>
						<a href="../acquisitions/bidding.php?base=suggestions&sort=DA&encabezado=s&menu=s" class="menuButton multiLine biddingButton">
							<img src="../../assets/images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["bidding"]?></strong></span>
						</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_DECISION"])){
?>
						<a href="../acquisitions/decision.php?base=suggestions&sort=DA&encabezado=s&menu=s" class="menuButton multiLine decisionButton">
							<img src="../../assets/images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["decision"]?></strong></span>
						</a>
<?php }?>
					</div>
					<div class="spacer">&#160;</div>
				</div>

			</div>
			<div class="mainBox" >

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
						<a href="../acquisitions/order_new_menu.php?base=suggestions&sort=PV&encabezado=s" class="menuButton multiLine createpurchaseorderButton">
							<img src="../../assets/images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["createorder"]?></strong></span>
						</a>

						<a href="../acquisitions/order.php?base=suggestions&sort=PV&encabezado=s" class="menuButton multiLine requisitionButton">
							<img src="../../assets/images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["generateorder"]?></strong></span>
						</a>
<?php }?>
						<a href="../acquisitions/pending_order.php?base=purchaseorder&sort=PV&encabezado=s" class="menuButton multiLine pendingButton">
							<img src="../../assets/images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["pendingorder"]?></strong></span>
						</a>
<?php if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_RECEIVING"])){
?>
						<a href="../acquisitions/receive_order.php?encabezado=s" class="menuButton multiLine receivingButton">
							<img src="../../assets/images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["receiving"]?></strong></span>
						</a>
<?php }?>
					</div>
					<div class="spacer">&#160;</div>
				</div>

			</div>
<?php
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_ACQDATABASES"])){
?>
			<div class="mainBox" >

				<div class="boxContent dbSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
						<h4>&#160;<strong><?php echo $msgstr["basedatos"]?></strong></h4>
					</div>
					<div class="sectionButtons">
						<a href="../dataentry/browse.php?base=suggestions&modulo=acquisitions" class="menuButton multiLine suggestButton">
							<img src="../../assets/images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["suggestions"]?></strong></span>
						</a>
						<a href="../dataentry/browse.php?base=providers&modulo=acquisitions" class="menuButton multiLine providersButton">
							<img src="../../assets/images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["providers"]?></strong></span>
						</a>
						<a href="../dataentry/browse.php?base=purchaseorder&modulo=acquisitions" class="menuButton multiLine requisitionButton">
							<img src="../../assets/images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["purchase"]?></strong></span>
						</a>
						<a href="../dataentry/browse.php?base=copies&modulo=acquisitions" class="menuButton multiLine copiesdbButton">
							<img src="../../assets/images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["copies"]?></strong></span>
						</a>

					</div>
					<div class="spacer">&#160;</div>
				</div>

			</div>
<?php  }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_RESETCN"])){
?>
            <div class="mainBox" >

				<div class="boxContent toolSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
						<h4>&#160;<strong><?php echo $msgstr["admin"]?></strong></h4>
					</div>

					<div class="sectionButtons">
						<a href="../acquisitions/resetautoinc.php?base=suggestions&encabezado=s" class="menuButton multiLine resetButton">
							<img src="../../assets/images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><?php echo $msgstr["resetctl"]. " (".$msgstr["suggestions"].")"?></strong></span>
						</a>
					</div>
					<div class="spacer">&#160;</div>

				</div>

			</div>
<?php }?>