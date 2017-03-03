<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      configure_menu.php
 * @desc:      Configuration menu
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
$lang=$_SESSION["lang"];
include("../common/get_post.php");
include("../config.php");
include("../lang/admin.php");
include("../lang/prestamo.php");


//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
$encabezado="";
echo "<body>\n";
$encabezado="&encabezado=s";
include("../common/institutional_info.php");
echo "<div class=\"sectionInfo\">
	<div class=\"breadcrumb\">".
		$msgstr["configure"]."
	</div>
	<div class=\"actions\">";
	include("submenu_prestamo.php");
echo "</div>
	<div class=\"spacer\">&#160;</div>
</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulation/configure_menu.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/configure_menu.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: configure_menu.php" ?></font>
	</div>
<div class="middle homepage">
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
				<h4>&#160;<strong><?php echo $msgstr["policy"]?></strong></h4>
			</div>
			<div class="sectionButtons">
				<a href="databases.php" class="menuButton multiLine origendatabaseButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["sourcedb"]?></strong></span>
				</a>
				<a href="borrowers_configure.php" class="menuButton multiLine usersconfigureButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["bconf"]?></strong></span>
				</a>
				<a href="typeofusers.php" class="menuButton multiLine userstypeButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["typeofusers"]?></strong></span>
				</a>
    				<a href="typeofitems.php" class="menuButton multiLine itemstypeButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["typeofitems"]?></strong></span>
				</a>
    			<a href="loanobjects.php" class="menuButton multiLine loanpolicyButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["objectpolicy"]?></strong></span>
				</a>

				<a href="locales.php" class="menuButton multiLine currency_daysButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["local"]?></strong></span>
				</a>

				<a href="calendario.php" class="menuButton multiLine calendarButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["calendar"]?></strong></span>
				</a>

           		<a href="sala_configure.php" class="menuButton multiLine loanpolicyButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["sala"]?></strong></span>
				</a>

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
		<div class="boxContent toolSection">
			<div class="sectionIcon">
						&#160;
			</div>
			<div class="sectionTitle">
				<h4>&#160;<strong><?php echo $msgstr["outputs"]?></strong></h4>
			</div>
			<div class="sectionButtons">
				<a href="../circulation/receipts.php?base=trans&encabezado=s&retorno=../circulation/configure_menu.php" class="menuButton multiLine receiptsButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["receipts"]?></strong></span>
				</a>
				<a href="../dbadmin/pft.php?base=trans&encabezado=s&retorno=../circulation/configure_menu.php" class="menuButton multiLine reportsButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["reports_trans"]?></strong></span>
				</a>
				<a href="../dbadmin/pft.php?base=suspml&encabezado=s&retorno=../circulation/configure_menu.php" class="menuButton multiLine reportsButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["reports_suspml"]?></strong></span>
				</a>
				<a href="../dbadmin/pft.php?base=users&encabezado=s&retorno=../circulation/configure_menu.php" class="menuButton multiLine reportsButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["reports_borrowers"]?></strong></span>
				</a>


			</div>
			<div class="spacer">&#160;</div>
		</div>

			<div class="spacer">&#160;</div>
		<div class="boxBottom">
			<div class="bbLeft">&#160;</div>
			<div class="bbRight">&#160;</div>
		</div>
	</div>
</div>
<form name=admin method=post action=administrar_ex.php onSubmit="Javascript:return false">
<input type=hidden name=base>
<input type=hidden name=cipar>
<input type=hidden name=Opcion>
</form>
</div>
</div>
<?php include("../common/footer.php");?>

</body>
</html>
