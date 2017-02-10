<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      browse.php
 * @desc:      Browse the loan's databases
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
include("../common/get_post.php");
include ("../config.php");
include("../lang/dbadmin.php");

include("../lang/admin.php");
include("../lang/prestamo.php");


$Permiso=$_SESSION["permiso"];
if (strpos($Permiso,'loanadm')===false ){
	echo "<br><br><h2>".$msgstr["menu_noau"]."<h2>";
	die;
}

if (!isset($arrHttp["from"])) $arrHttp["from"]=1;
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$arrHttp["Mfn"]=1;
$Formato=$db_path."users/pfts/".$_SESSION["lang"]."/tbusers";
if (!file_exists($Formato)) $Formato=$db_path."users/pfts/".$lang_db."/tbusers";
$to=$arrHttp["from"]+9;
if (!isset($arrHttp["Expresion"])){
	$query = "&base=users&cipar=$db_path"."par/users.par"."&from=".$arrHttp["from"]."&to=$to&Formato=$Formato&Opcion=buscar";
	$IsisScript=$xWxis."leer_mfnrange.xis";
	include("../common/wxis_llamar.php");
	$lista_users=$contenido;
}else{
	$to=$arrHttp["from"]+9;
	$query = "?xx=CCCCC" ."&base=users&cipar=$db_path"."par/users.par"."&from=".$arrHttp["from"]."&to=$to&Formato=$Formato".".pft&Expresion=".urlencode($arrHttp["Expresion"]);
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$lista_users=$contenido;
}

include("../common/header.php");
?>
<script>
xEliminar="";
Mfn_elminar=0;

	function Browse(){		self.location="browse.php?encabezado=s"	}


	function EjecutarBusqueda(Accion){
		switch (Accion){			case "first":
				document.diccionario.from.value=1
				break
			case "previous":
                desde=desde-20
                if (desde<=0) desde=1
                document.diccionario.from.value=desde
				break
			case "next":
				break
			case "last":
				desde=last-10
				if (desde<=0) desde=1
				document.diccionario.from.value=desde
				break		}		ix=document.searchBox.indexes.selectedIndex
		sel=document.searchBox.indexes.options[ix].value
		t=sel.split('|')
        document.diccionario.target=""
        document.diccionario.Expresion.value=document.searchBox.Expresion.value
        document.diccionario.action="buscar.php"
		document.diccionario.campo.value=escape(t[0])
		document.diccionario.prefijo.value=t[2]
		document.diccionario.id.value=t[1]
		document.diccionario.Opcion.value="buscar"

		document.diccionario.submit()	}

	function PresentarDiccionario(){
		msgwin=window.open("","Diccionario","scrolling, height=400")		ix=document.searchBox.indexes.selectedIndex
		if (ix<1){			alert("<?php echo $msgstr["selcampob"]?>")
			return		}
		sel=document.searchBox.indexes.options[ix].value
		t=sel.split('|')
		document.diccionario.campo.value=escape(t[0])
		document.diccionario.prefijo.value=t[2]
		document.diccionario.id.value=t[1]
		document.diccionario.Diccio.value="document.searchBox.searchExpr"
		document.diccionario.submit()
		msgwin.focus()	}
	function Eliminar(Mfn){		if (xEliminar==""){
			alert("<?php echo $msgstr["confirmdel"]?>")
			xEliminar="1"
			Mfn_eliminar=Mfn
		}else{
			if (Mfn_eliminar!=Mfn){				alert("<?php echo $msgstr["mfndelchanged"]?>")
				xEliminar=""
                return			}
			xEliminar=""
			document.eliminar.Mfn.value=Mfn
			document.eliminar.submit()
		}	}
</script>
<?php
echo "<body>";
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["usuarios"]?>
	</div>
	<div class="actions">
		<a href="../inicio.php?reinicio=s<?php echo $encabezado?>" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"]?></strong></span>
		</a>
		<a href="../dataentry/fmt.php?base=users&cipar=users.par&Mfn=New<?php echo $encabezado?>&Opcion=nuevo" class="defaultButton  newButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["newoper"]?></strong> </span>
		</a>

	</div>
	<div class="spacer">&#160;</div>
</div>
		<div class="middle list">
         <form name=searchBox onsubmit="javascript:return false">
		<div class="searchBox">
				<label for="searchExpr">
					<strong><?php echo $msgstr["buscar"]?></strong>
				</label>
				<input type="text" name="Expresion" id="searchExpr" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';"
				value='<?php if (isset($arrHttp["Expresion"])) echo trim(stripslashes($arrHttp["Expresion_b"]))?>' />
				<select name="indexes" class="textEntry">
					<option></option>
<?php
$archivo=$db_path."users/pfts/".$_SESSION["lang"]."/camposbusqueda.tab";
if (!file_exists($archivo)) $archivo=file($db_path."users/pfts/".$lang_db."/camposbusqueda.tab");
$fp=file($archivo);
foreach ($fp as $value){	$t=explode('|',$value);
	$xselected="";
	if (isset($arrHttp["Indice"])){		if ($arrHttp["Indice"]==$t[1]) $xselected=" selected";	}	echo "<Option value='$value' $xselected>".$t[0]."\n";
}
?>
				</select>
				<input type="submit" name="ok" value="<?php echo $msgstr["buscar"]?>" class="submit" onClick=javascript:document.diccionario.from.value=1;EjecutarBusqueda() />
				<input type="submit" name="ok" value="<?php echo $msgstr["index"]?>" class="submit" onClick=javascript:PresentarDiccionario() />
				<input type="submit" name="ok" value="<?php echo $msgstr["browse"]?>" class="submit" onClick=javascript:Browse() />
         </form>
		</div>
			<table class="listTable">
				<tr>
					<!-- para ordenar utilize: class=asc|desc -->
					<th>&nbsp;</th>
					<th><?php echo $msgstr["username"]?></th>
					<th><?php echo $msgstr["usertype"]?></th>
					<th><?php echo $msgstr["carnet"]?></th>
					<th><?php echo $msgstr["docid"]?></th>
					<th><?php echo $msgstr["location"]?></th>
					<th class="action">&nbsp;</th>
				</tr>
<?php
foreach ($lista_users as $value){
	echo "<tr onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = '';\">\n";	$u=explode('|',$value);
	$Mfn=$u[0];
	$Status=$u[1];
	$desde=$u[2];
	$hasta=$u[3];
	echo "<td>".$u[2]."/",$u[3];
	if ($Status==1) echo "<img src=\"../images/delete.png\" align=absmiddle alt=\"excluir base de dados\" title=\"excluir base de dados\" />";
	echo "</td>";
	for ($ix=4;$ix<count($u);$ix++) echo "<td>" .$u[$ix]."</td>";
	echo "<td class=\"action\">
		<a href=../dataentry/fmt.php?base=users&cipar=users.par&Mfn=$Mfn".$encabezado."&Opcion=editar><img src=\"../images/edit.png\" alt=\"editar base de dados\" title=\"editar base de dados\" /></a>";
	if ($Status==0) echo "
		<a href=\"javascript:Eliminar($Mfn)\"><img src=\"../images/delete.png\" alt=\"".$msgstr["eliminar"]."\" title=\"".$msgstr["eliminar"]."\" /></a>";
	else
		echo $msgstr["recdel"];
	echo "</td>";
	echo "</tr>";}
echo "			</table>";

?>			<div class="tMacroActions">
				<div class="pagination">
					<a href="javascript:EjecutarBusqueda('first')" class="singleButton eraseButton">
						<span class="sb_lb">&#160;</span>
						&#171; <?php echo $msgstr["first"]?>
						<span class="sb_rb">&#160;</span>
					</a>
					<a href="javascript:EjecutarBusqueda()" class="singleButton eraseButton">
						<span class="sb_lb">&#160;</span>
						&#187; <?php echo $msgstr["next"] ?>
						<span class="sb_rb">&#160;</span>
					</a>
					<a href="javascript:EjecutarBusqueda('previous')" class="singleButton eraseButton">
						<span class="sb_lb">&#160;</span>
						&#171; <?php echo $msgstr["previous"]?>
						<span class="sb_rb">&#160;</span>
					</a>
					<a href="javascript:EjecutarBusqueda('last')" class="singleButton eraseButton">
						<span class="sb_lb">&#160;</span>
						&#171; <?php echo $msgstr["last"]?>
						<span class="sb_rb">&#160;</span>
					</a>
					<div class="spacer">&#160;</div>
				</div>
				<div class="spacer">&#160;</div>
			</div>
		</div>
<?php
echo "</div></div>";
include("../common/footer.php");
echo "
 <form name=eliminar method=post action=../dataentry/eliminar_registro.php>
 <input type=hidden name=base value=users>
 <input type=hidden name=Mfn>\n";
 if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>\n";
 $desde=$desde+1;
echo "</form>
<form name=diccionario method=post action=diccionario.php target=Diccionario>
	<input type=hidden name=base value=users>
	<input type=hidden name=cipar value=users.par>
	<input type=hidden name=prefijo>
	<input type=hidden name=Formato>
	<input type=hidden name=campo>
	<input type=hidden name=id>
	<input type=hidden name=Diccio>
	<input type=hidden name=from value=$desde>
	<input type=hidden name=Opcion value=diccionario>
	<input type=hidden name=Target value=s>
	<input type=hidden name=Expresion>
</form>


	</body>
</html>
<script>
	first=1
	last=$hasta
	desde=$desde
</script>
";