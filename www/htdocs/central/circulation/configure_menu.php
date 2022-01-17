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
$encabezado="&encabezado=s";
?>

<body>

<?php include("../common/institutional_info.php"); ?>

	<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["configure"];?>
	</div>
	<div class="actions">
	</div>
	<?php include("submenu_prestamo.php");?>
</div>


<?php
$ayuda="configure_menu.html";
include "../common/inc_div-helper.php";
?>


<div class="middle homepage">


<div class="mainBox" >
	<div class="boxContent loanSection">
		<div class="sectionTitle">
		<img src="../../assets/svg/circ/ic_fluent_database_24_regular.svg">
			<h1><?php echo $msgstr["policy"]?></h1>
		</div>
		<div class="sectionButtons">

				<a href="databases.php" class="menuButton multiLine origendatabaseButton">
					<span><strong><?php echo $msgstr["sourcedb"]?></strong></span>
				</a>
				<a href="borrowers_configure.php" class="menuButton multiLine usersconfigureButton">
					<span><strong><?php echo $msgstr["bconf"]?></strong></span>
				</a>
				<a href="typeofusers.php" class="menuButton multiLine userstypeButton">
					<span><strong><?php echo $msgstr["typeofusers"]?></strong></span>
				</a>
    				<a href="typeofitems.php" class="menuButton multiLine itemstypeButton">
					<span><strong><?php echo $msgstr["typeofitems"]?></strong></span>
				</a>
    			<a href="loanobjects.php" class="menuButton multiLine loanpolicyButton">
					<span><strong><?php echo $msgstr["objectpolicy"]?></strong></span>
				</a>

				<a href="locales.php" class="menuButton multiLine currency_daysButton">
					<span><strong><?php echo $msgstr["local"]?></strong></span>
				</a>

				<a href="calendario.php" class="menuButton multiLine calendarButton">
					<span><strong><?php echo $msgstr["calendar"]?></strong></span>
				</a>

           		<a href="sala_configure.php" class="menuButton multiLine loanpolicyButton">
					<span><strong><?php echo $msgstr["sala"]?></strong></span>
				</a>
				<?php if (isset($ILL)){
				?>
				<a href="../circulation/interbib_configure.php?encabezado=s" class="menuButton providersButton">
	
							<span><strong><?php echo $msgstr["r_ill"]?></strong></span>
						</a>
				<?php
				}
				?>

			</div>
			<div class="spacer">&#160;</div>
		</div>

	</div>


<div class="mainBox" >
	<div class="boxContent loanSection">
		<div class="sectionTitle">
		<img src="../../assets/svg/circ/ic_fluent_database_24_regular.svg">
			<h1><?php echo $msgstr["outputs"]?></h1>
		</div>
		<div class="sectionButtons">

				<a href="../circulation/receipts.php?base=trans&encabezado=s&retorno=../circulation/configure_menu.php" class="menuButton multiLine reportsButton">
					<span><strong><?php echo $msgstr["receipts"]?></strong></span>
				</a>
				<a href="../dbadmin/pft.php?base=trans&encabezado=s&retorno=../circulation/configure_menu.php" class="menuButton multiLine reportsButton">
					<span><strong><?php echo $msgstr["reports_trans"]?></strong></span>
				</a>
				<a href="../dbadmin/pft.php?base=suspml&encabezado=s&retorno=../circulation/configure_menu.php" class="menuButton multiLine reportsButton">
					<span><strong><?php echo $msgstr["reports_suspml"]?></strong></span>
				</a>
				<a href="../dbadmin/pft.php?base=users&encabezado=s&retorno=../circulation/configure_menu.php" class="menuButton multiLine reportsButton">
					<span><strong><?php echo $msgstr["reports_borrowers"]?></strong></span>
				</a>


			</div>
			<div class="spacer">&#160;</div>
		</div>

			<div class="spacer">&#160;</div>

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
