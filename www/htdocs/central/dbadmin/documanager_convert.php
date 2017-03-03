<?php
session_start();
include("../common/get_post.php");
include ("../config.php");


include("../lang/admin.php");
include("../lang/soporte.php");

//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";

function CrearFdtOrbita(){
global $db_path;
	global $arrHttp,$path_database;
	$fdt_c=$db_path.$arrHttp["base"]."/".$arrHttp["fdt"];
	$fp=file($fdt_c);
	echo "<p>".$fdt_c."<p>";
	$arrHttp["dir"]=$db_path.$arrHttp["base"]."/".$arrHttp["base"].".fdt";
	$fout=fopen($arrHttp["dir"],"w");
	$ix=0;
	echo "<p><dd><span class=title>".$arrHttp["dir"].$arrHttp["dir"]."</span>";
	echo "<p><dd><table bgcolor=#cccccc>
	<td width=50 bgcolor=white>Tipo</td><td width=50 bgcolor=white>Tag</td><td nowrap width=200 bgcolor=white>Description</td>
	<td xwidth=50 bgcolor=white>Rep</td>
	<td xwidth=50 nowrap bgcolor=white>Subfields</td>
	<td xwidth=50 nowrap bgcolor=white>Subfields ed</td>
	<td xwidth=50 nowrap bgcolor=white>rows</td>
	<td xwidth=50 nowrap bgcolor=white>cols</td>
	<td xwidth=10 bgcolor=white>T.A</td>
	<td xwidth=50 bgcolor=white>tabla</td>
	<td xwidth=50 bgcolor=white>prefijo</td>";
	foreach ($fp as $value){		echo "$value<br>";
		$ix++;

		if (trim($value)!=""){			$nc="";
			$subc="";
			$editsubc="";
			$tag="";
			$prefijo="";
			$rows="";
			$cols="";
			$tabla="";
			$tipoau="";
			$rep="";
			$repetible="";
			$tipo="";
			if (substr($value,0,2)=='##'){				$tipo="H";
				$nc=trim(substr($value,8));
			}else{				$nc=trim(substr($value,3,26));
				$cols=trim(substr($value,33,3))*1;
				$rows=trim(substr($value,37,3))*1;
				if ($cols==0) $cols="";
				if ($rows==0) $rows="";
				$subc=trim(substr($value,62,10));
				$editsubc=trim(substr($value,74,10));
				$tag=trim(substr($value,50,3));
				$prefijo=trim(substr($value,46,2));
				$rep=trim(substr($value,54,1));
				if ($tag=="") $tipo="S";
				if ($rep=="E") $tipo="T";
				if ($tipo=="") $tipo="F";
				if ($rep=="F") $tipo="M";
				$prefijo=trim(substr($value,46,2));
				$rep=trim(substr($value,54,1));
				$repetible='';
				if ($rep=="R") $rep=1;
				if ($rep=="1")  $repetible="yes";
				$tabla=trim(substr($value,89));
				if ($tabla!=""){					if (strpos($tabla,".tab")>0)
						$tipoau="P";
					else
						$tipoau="D";				}
				if ($prefijo!="") $tipoau="D";			}
            if ($tag!="***"){
				$salida="$tipo|$tag|$nc|0|$rep|$subc|$editsubc||$rows|$cols|$tipoau|$tabla|$prefijo||\n";
				fwrite($fout,$salida);
				echo "<tr><td  bgcolor=white nowrap>$tipo</td>
				<td  bgcolor=white nowrap>$tag</td>
				<td  bgcolor=white nowrap>$nc</td>
				<td  bgcolor=white nowrap>$repetible</td>
				<td  bgcolor=white nowrap>$subc</td>
				<td  bgcolor=white nowrap>$editsubc</td>
				 <td  bgcolor=white nowrap>$rows</td>
				 <td  bgcolor=white nowrap>$cols</td>
				<td  bgcolor=white nowrap>$tipoau</td>
				<td  bgcolor=white nowrap>$tabla</td>
				<td  bgcolor=white nowrap>$prefijo</td>
				";
			}
		}
	}
	echo "</table>";
	fclose ($fout);
	echo "<dd>" .$arrHttp["base"].".fdt Converted!!";
	die;
}

if (isset($arrHttp["base"]))
	CrearFdtOrbita();
else{	echo "<form name=dm method=post action=documanager_convert.php>
<textarea name=DocuManager rows=30 cols=150 wrap=off></textarea>
<input type=submit value=enviar>
</form>";}

?>
