<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      z3950.php
 * @desc:      Search form for z3950 record importing
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
include("../common/get_post.php");
include ("../config.php");

include("../lang/admin.php");

//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";
include("../common/header.php");

?>
<script src=js/lr_trim.js></script>
<script language=javascript>
   function AbrirVentana(Marc){
        msgwin=window.open("",Marc,"status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,width=800,height=600,top=00,left=00")
        msgwin.focus()
   }
   function Reintentar(){
       document.CapturarZ3950.submit()
       return true
   }

 function Isbn(){ 	ixdb="HOST"+document.z39.host.selectedIndex

	ix1=document.z39.isbn.length
	listaI=""
	for (i=0;i<ix1;i++){
		if (document.z39.isbn[i].value!=""){
			if (listaI==""){
				listaI=document.z39.isbn[i].value
			}else{
				listaI=listaI+"\n"+document.z39.isbn[i].value
			}
		}
	}
	if (Trim(document.z39.term.value)=="" && Trim(document.z39.term1.value)=="" && listaI==""){
 		alert("<?php echo $msgstr["faltaexpr"]?>")
 		return
 	}
 	document.z39.isbn_l.value=listaI
 	<?php if (!isset($arrHttp["desde"])){ 		echo "msgwin=window.open(\"\",\"z3950\",\"width=750, height=600, scrollbars, resizable\")
	document.z39.target=\"z3950\"
	document.z39.submit()
	msgwin.focus()
	"; 	}else{ 		echo "document.z39.submit()\n"; 	}
 	?>
}
   </script>
   <body>
		<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]."/z3950.html"?> target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
 <?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/z3950.html target=_blank>".$msgstr["edhlp"]."</a>";
 echo "<font color=white>&nbsp; &nbsp; Script: dataentry/z3950.php" ?></font>
?>
	</div>
    <div class="middle form">

		<div class="formContent">
		<center>
	<span><h4><?php echo $msgstr["catz3950"]?></h4></span>
	<form method="post" action=z3950-01.php
	<?php if (!isset($arrHttp["desde"])) echo "  target=z3950 "?> onSubmit="javascript:return false" name=z39 >
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<input type=hidden name=cipar value=<?php echo $arrHttp["cipar"]?>>
	<table  border=0 cellpadding=0 cellspacing=0>
		<td class=td bgcolor=lightgrey>
			<?php echo $msgstr["connectto"]?>:
		</td>
		<td class=td bgcolor=lightgrey>
			<select name="host">
<?php

$Pft="v1'|'v2'|'v3'|'v4'|'v5/";
$query = "&base=servers&cipar=".$db_path."par/servers.par&from=1&Formato=$Pft&Opcion=rango";
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
foreach ($contenido as $value) {
	$val=str_replace('|',"",$value);
	if (trim($val)!="") {		$s=explode('|',$value);
		echo "<option value=".$s[1].":".$s[2]."/".$s[3]."^susmarc^f".$s[4].">".$s[0]."\n";	}}

?>
			</select>
<?php
$archivo=$db_path.$arrHttp["base"]."/def/z3950.cnv";
if (file_exists($archivo)){
	$selected=" selected";	echo $msgstr["z3950_tab"].": ";
	echo "<select name=cnvtab>";
	echo "<option></option>";
	$fp=file($archivo);
	foreach ($fp as $value){
		$v=explode('|',$value);
		echo "<option value='".$v[0]."' $selected>".$v[1]."\n";
		$selected="";
	}
	echo "</select>";
}
?>
		</td>
		<tr>
		<td class=td><?php echo $msgstr["busqueda"]?>:
		</td>
		<td>
			<input type="text" size="50" name="term" value="">&nbsp;
			<?php echo $msgstr["z3950_in"]?>&nbsp;
			<select name="field">
				<option value="Todos los campos"><?php echo $msgstr["z3950_all"]?>
				<option value="Título"><?php echo $msgstr["z3950_title"]?>
				<option value="Autor"><?php echo $msgstr["z3950_author"]?>
				<option value="ISBN"><?php echo $msgstr["z3950_isbn"]?>
				<option value="ISSN"><?php echo $msgstr["z3950_issn"]?>
			</select>

		</td>
		<tr>
		<td></td>
		<td>
			<input type="text" size="50" name="term1" value="">&nbsp;
			<?php echo $msgstr["z3950_in"]?>&nbsp;
			<select name="field1">
				<option value="Todos los campos"><?php echo $msgstr["z3950_all"]?>
				<option value="Título"><?php echo $msgstr["z3950_title"]?>
				<option value="Autor"><?php echo $msgstr["z3950_author"]?>
				<option value="ISBN"><?php echo $msgstr["z3950_isbn"]?>
				<option value="ISSN"><?php echo $msgstr["z3950_issn"]?>
			</select>
		</td>
		<tr>
	</table>
	<table width=600>
		<td colspan=5 bgcolor=linen align=center class=td><?php echo $msgstr["z3950_msg"]?></td>
		<tr>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<tr>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<tr>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<tr>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<tr>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
		<td align=center><input type=text size=15 name=isbn value=""</td>
	</table>
<input type=hidden name=isbn_l value="">
<br><?php echo $msgstr["show"]?> <input type=text name=number value="10" size=4> <?php echo $msgstr["registros"]?>.
&nbsp; &nbsp; &nbsp; <?php echo $msgstr["z3950_retray"]?> <input type=text name=reintentar value="10" size=2> <?php echo $msgstr["z3950_times"]?>
&nbsp;<p><input type="submit" name="action" onclick=Isbn() value="<?php echo $msgstr["busqueda"]?>"><input type=hidden name=start value="1">&nbsp; &nbsp;
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>

<?php
if (isset($arrHttp["Mfn"])) echo "<input type=hidden name=Mfn value=".$arrHttp["Mfn"].">\n"; //COPY TO AN EXISTENT RECORD
if (isset($arrHttp["test"])){
	echo "<input type=submit value='".$msgstr["cerrar"]."' onclick=javascript:self.close()>\n";
	echo "<input type=hidden name=test value=Y>\n";

}
?>
</center>
<p><!--a href=../lc/lc.html target=_new>Test</a -->
</form>
</div>
</div>
<?php include ("../common/footer.php")?>

     </body>
</html>