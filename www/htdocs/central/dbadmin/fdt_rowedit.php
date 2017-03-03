<?php

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("fdt_include.php");
//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";
$Fdt=explode('|',$arrHttp["ValorCapturado"]);
include("../common/header.php");
?>
	<script src=../dataentry/js/lr_trim.js></script>
	<script>

	function AsignarFdt(){		nf=window.opener.frames.length
		fila=<?php echo $arrHttp["row"]?>

		for (ixvar=1;ixvar<23;ixvar++){			Ctrl=eval("document.forma1.c"+ixvar)
			columna=ixvar
			if (columna>13) columna++
			switch (Ctrl.type){				case "select-one":
					ix_sel=Ctrl.selectedIndex
					campo=Ctrl.options[ix_sel].value

					break;
				case "checkbox":
					if (Ctrl.checked)
						campo=1
					else
						campo=0
					break
				default:
					campo=Trim(Ctrl.value)
					break			}
			window.opener.mygrid.cells2(fila,columna).setValue(campo)
		}
		self.close()	}

	function Asignar(){
		document.forma1.c12.value=valor
		document.forma1.c13.value=prefix
		document.forma1.c14.value=list
		document.forma1.c15.value=extract
	}

	function Picklist(name,row){
		prefix=""
		valor=""
		fila=row
		ix=document.forma1.c11.selectedIndex
		pl_type=document.forma1.c11.options[ix].value
		pl_name=document.forma1.c12.value
		if (pl_type==""){
			alert("<?php echo $msgstr["selpltype"]?>")
			return
		}
		switch (pl_type){
			case "P":
				Url="picklist.php?base=<?php echo $arrHttp["base"]?>&picklist="+pl_name+"&row="+row
				break
			case "D":
				dbsel=document.forma1.c12.value
				if (dbsel=="") dbsel="<?php echo $arrHttp["base"]?>"
				prefix=document.forma1.c13.value
				list=document.forma1.c14.value
				extract=document.forma1.c15.value
				Url="picklist_db.php?base=<?php echo $arrHttp["base"]?>&picklist="+name+"&row="+row +"&dbsel="+dbsel+"&prefix="+prefix+"&list="+list+"&extract="+extract
				break

			case "T":

				break
		}
		Url+="&type="+pl_type
		msgwin=window.open(Url,"PL","")
		msgwin.focus()
	}
</script>
<body>
<div class="middle form">
<div class="formContent">
<?php
echo "<form name=forma1><table bgcolor=#cccccc width=90%>";
echo "<tr><td bgcolor=white>". $msgstr["type"]."</td><td bgcolor=white>
<select name=c1><option></option>";
foreach ($field_type as $var=>$value){	if ($Fdt[0]==$var)
		$selected=" selected";
	else
		$selected="";	echo "<option value=".$var.$selected.">$value\n";}
echo "</select>";
echo "</td>";
echo "<tr><td bgcolor=white>". $msgstr["tag"]."</td><td bgcolor=white><input type=text name=c2 value='".$Fdt[1]."' size=3 ></td>";
echo "<tr><td bgcolor=white>". $msgstr["title"]."</td><td bgcolor=white><input type=text name=c3 value=\"".$Fdt[2]."\" size=80></td>";
echo "<tr><td bgcolor=white>". "I"."</td><td bgcolor=white>";
echo "<input type=checkbox name=c4 value=".$Fdt[3];
if ($Fdt[3]==1)	echo " checked";
echo "></td>";
echo "<tr><td bgcolor=white>". "R"."</td><td bgcolor=white>";
echo "<input type=checkbox name=c5 value=".$Fdt[4];
if ($Fdt[4]==1)	echo " checked";
echo "></td>";
echo "<tr><td bgcolor=white>". $msgstr["subfields"]."</td><td bgcolor=white>";
echo "<input type=text name=c6 value=\"".$Fdt[5]."\" size=30></td>";
echo "<tr><td bgcolor=white>". $msgstr["preliteral"]."</td><td bgcolor=white>";
echo "<input type=text name=c7 value=\"".$Fdt[6]."\" size=30></td>";
echo "<tr><td bgcolor=white>". $msgstr["inputtype"]."</td><td bgcolor=white>";
echo "<select name=c8><option></option>";
foreach ($input_type as $var=>$value){
	if ($Fdt[7]==$var)
		$selected=" selected";
	else
		$selected="";
	echo "<option value=".$var.$selected.">$value\n";
}
echo "</select>";
echo "</td>";
echo "<tr><td bgcolor=white>". $msgstr["rows"]."</td><td bgcolor=white>";
echo "<input type=text name=c9 value=\"".$Fdt[8]."\" size=10></td>";
echo "<tr><td bgcolor=white>". $msgstr["cols"]."</td><td bgcolor=white>";
echo "<input type=text name=c10 value=\"".$Fdt[9]."\" size=10></td>";
echo "<tr><td colspan=2>". $msgstr["picklist"]."</td>";
echo "<tr><td bgcolor=white>". $msgstr["type"]."</td><td bgcolor=white>";
echo "<select name=c11><option></option>";
foreach ($pick_type as $var=>$value){
	if ($Fdt[10]==$var)
		$selected=" selected";
	else
		$selected="";
	echo "<option value=".$var.$selected.">$value\n";
}
echo "</select>";
if (trim($Fdt[0])!="H" and trim($Fdt[0])!="L"){
	if ($Fdt[10]=="")
		$pick="<a href='javascript:Picklist(\"".$Fdt[10].".tab\",".$arrHttp["row"].")'><font size=1>browse</a>";
	else
		$pick="<a href='javascript:Picklist(\"".$Fdt[10]."\",".$arrHttp["row"].")'><font size=1>browse</a>";
}
if (isset($pick)) echo "$pick</td>";
echo "<tr><td bgcolor=white>". $msgstr["name"]."</td><td bgcolor=white>";
echo "<input type=text name=c12 value=\"".$Fdt[11]."\" size=80></td>";
echo "<tr><td bgcolor=white>". $msgstr["prefix"]."</td><td bgcolor=white>";
echo "<input type=text name=c13 value=\"".$Fdt[12]."\" size=20></td>";
echo "<tr><td bgcolor=white>". $msgstr["listas"]."</td><td bgcolor=white>";
echo "<input type=text name=c14 value=\"".stripslashes($Fdt[13])."\" size=80></td>";
echo "<tr><td bgcolor=white>". $msgstr["extractas"]."</td><td bgcolor=white>";
echo "<input type=text name=c15 value= \"".stripslashes($Fdt[14])."\" size=80></td>";
echo "<tr><td colspan=2  height=5></td>";
echo "<tr><td bgcolor=white>". $msgstr["valdef"]."</td><td bgcolor=white><input type=text name=c16 value=\"".$Fdt[15]."\" size=80></td>";
echo "<tr><td bgcolor=white>". $msgstr["help"]."</td><td bgcolor=white>";
echo "<input type=checkbox name=c17 value=".$Fdt[16];
if ($Fdt[16]==1)	echo " checked";
echo "></td>";
echo "<tr><td bgcolor=white>". $msgstr["url_help"]."</td><td bgcolor=white><input type=text name=c18 value=\"".$Fdt[17]."\" size=100></td>";
echo "<tr><td bgcolor=white>". $msgstr["link_fdt"]."</td><td bgcolor=white>";
echo "<input type=checkbox name=c19 value=".$Fdt[18];
if ($Fdt[18]==1)	echo " checked";
echo "></td>";
echo "<tr><td bgcolor=white>". $msgstr["mandatory"]."</td><td bgcolor=white>";
echo "<input type=checkbox name=c20 value=".$Fdt[19];
if ($Fdt[19]==1)	echo " checked";
echo "></td>";
echo "<tr><td bgcolor=white>". $msgstr["field_validation"]."</td><td bgcolor=white>";
echo "<select name=c21><option></option>";
foreach ($validation as $var=>$value){
	if ($Fdt[20]==$var)
		$selected=" selected";
	else
		$selected="";
	echo "<option value=".$var.$selected.">$value\n";
}
echo "</select>";
echo "</td>";
echo "<tr><td bgcolor=white>". $msgstr["pattern"]."</td><td bgcolor=white>";
echo "<input type=text name=c22 value= \"".stripslashes($Fdt[21])."\" size=80></td>";
echo "</table>
<a href=javascript:AsignarFdt()>".$msgstr["update"]."</a>&nbsp; &nbsp; &nbsp;<a href=javascript:self.close()>".$msgstr["cancel"]."</a>
</form>
</div>
</div>
</body>
</html>";
?>