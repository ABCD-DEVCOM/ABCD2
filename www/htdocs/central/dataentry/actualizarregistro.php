<?php
include("verificar_eliminacion.php");

function ValidarDuplicados($tag,$subc,$prefijo,$valor,$titulo){
global $arrHttp,$db_path,$Wxis,$xWxis,$wxisUrl,$fdt,$msgstr,$def;
	$c_ant=array();
	$occ=explode("\n",$valor);
	$Expresion="";
	$error="";
	foreach ($occ as $value){		$value=trim($value);
		if (isset($subc)and $subc!=""){
			$ix=strpos($value,"^".$subc);
			$c=substr($value,$ix+2);
			$ix=strpos($c,'^');
			if ($ix>0){
				$c=substr($c,0,$ix);
			}
		}else{			$c=$value;		}
		if (trim($c)!=""){			if ($Expresion=="")
				$Expresion=$prefijo.$c;
			else
				$Expresion.=" or ".$prefijo.$c;		}
		if (isset($c_ant[$c])){			$error.="$tag $titulo $c ".$msgstr["dup_in_field"]."<br>";		}else{
		  	$c_ant[$c]=$c;
		}
	}
	if($Expresion=="")  return;
	$sc="";
	if ($subc!="") $sc='^'.$subc;
	$Pft="(mfn'|'v$tag"."$sc/)/";
	$IsisScript=$xWxis."buscar_ingreso.xis";
	$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Expresion=".$Expresion."&Pft=$Pft";
	include("../common/wxis_llamar.php");

	foreach ($contenido as $value) {
		$value=trim($value);		if (substr($value,0,6)!="[MFN:]" and substr($value,0,8)!="[TOTAL:]" and $value!=""){
			if (trim($value)!=""){
				$i=explode('|',$value);
				if ($arrHttp["Mfn"]=="New"){					if (isset($c_ant[$i[1]])) $error.="$tag $titulo ".$i[1]." ".$msgstr["duplicated"]." (Mfn:".$i[0].")<br>";				}else{					if ($i[0]*1!=$arrHttp["Mfn"])
						if (isset($c_ant[$i[1]])) $error.="$tag $titulo ".$i[1]." ".$msgstr["duplicated"]." (Mfn:".$i[0].")<br>";
                }
			}
		}
	}    return $error;}

function CodificaSubCampos($campo,$numsubc,$subc,$delimsc){
$valores=explode("\n",$campo);
$salida="";
 	foreach ($valores as $lin){
		$lin=trim($lin);
		if($lin!=""){
 			for ($isc=0;$isc<strlen($subc);$isc++){
   				$delim=substr($delimsc,$isc,1);
   				if ($isc==0){
					if (substr($subc,$isc,1)!=" " and substr($subc,$isc,1)!="_") {
				    	$lin='^'.substr($subc,$isc,1).$lin;
					}
   				}else{
       				$pos=strpos($lin, $delim);
   					if (is_integer($pos)) {
    					$lin=substr($lin,0,$pos).'^'.substr($subc,$isc,1).trim(substr($lin,$pos+1));
   					}
   				}

  			}
	  		$salida=$salida."\n".$lin;
		}
 	}
 	return $salida;
}

function ActualizarRegistro(){
$tabla = Array();

global $vars,$cipar,$from,$base,$ValorCapturado,$arrHttp,$ver,$valortag,$fdt,$tagisis,$cn,$msgstr,$tm,$lang_db,$MD5;
global $xtl,$xnr,$Mfn,$FdtHtml,$xWxis,$variables,$db_path,$Wxis,$default_values,$rec_validation,$wxisUrl,$validar,$tm;
global $max_cn_length,$def;

	$variables_org=$variables;
	$ValorCapturado="";
	$VC="";
	if ($arrHttp["Opcion"]=="eliminar"){		$archivo=$db_path.$arrHttp["base"]."/pfts/recdel_val";
		$verify="";
		if (file_exists($archivo.".pft")){			$verify="Y";
		}else{            $archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/recdel_val";
            if (file_exists($archivo.".pft")){
				$verify="Y";
			}else{				$archivo=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/recdel_val";
            	if (file_exists($archivo.".pft")){
					$verify="Y";
				}			}		}		if ($verify=="Y") {
			$salida=VerificarEliminacion($archivo);
			if ($salida!=""){
				echo "<div class=\"middle form\">
						<div class=\"formContent\">
					";

				echo "<p><font color=red><strong>".$salida."</strong></font>";
				$url= "fmt.php?base=".$arrHttp["base"]."&cipar=".$arrHttp["base"].".par&Opcion=ver&Mfn=".$arrHttp["Mfn"]."&error=".urlencode($salida)."&Formato=".$arrHttp["Formato"];
				if (isset($arrHttp["wks_a"])) $url.="&wks=".$arrHttp["wks_a"];
				$url.="&ver=S";
				if (isset($arrHttp["db_copies"]))  $url.="&db_copies=".$arrHttp["db_copies"];
				if (isset($arrHttp["ventana"])) $url.="&ventana=".$arrHttp["ventana"];
				echo "<p><a href=$url><h3>".$msgstr["editar"]."</h3></a>";
				echo "</div></div>";
				die;
			}
		}
	}
	if (is_array($variables)){
		if (count($variables)==0 and !isset($arrHttp["check_select"]) and $arrHttp["Opcion"]!="eliminar") {
		    echo $msgstr["specvalue"];
			return;
		}
	}
	PlantillaDeIngreso($xtl,$xnr);
	$cdup=array();
	//para la validación de duplicados
	foreach ($vars as $fdt) {
		$t=explode('|',$fdt);
  		if ($t[1]!="") $tag=$t[1];
  		if (isset($t[20]) and $t[20]=="U"){       //Modificado 18-07-2014
  			$cdup[$tag]["subc"]=$t[5];
  			$cdup[$tag]["prefix"]=$t[12];
  			$cdup[$tag]["name"]=$t[2];
  			$cdup[$tag]["key"]=$t[13];
  		}
  	}
	foreach ($vars as $fdt) {
		$t=explode('|',$fdt);
  		$tag=$t[1];
  		$dataentry=$t[7];
  		if (isset($variables["tag".$tag])){
			$rep=$t[4];
			$tipoc=$t[0];

			if ($dataentry=="A") {
				$variables["tag".$tag]=str_replace("\n","", $variables["tag".$tag]);
				$variables["tag".$tag]=str_replace("\r","", $variables["tag".$tag]);
				//$variables["tag".$tag]=substr($variables["tag".$tag],0,16360);    //Esto es provisional porque es el largo máximo que actualiza
			}
			$subc=rtrim($t[5]);
			if (substr($subc,0,1)=="-") $subc="_".substr($subc,1);
			$numsubc=strlen($subc);
 			$delimsc=$t[6];
 			$ispassword=$t[7];
 			if ($ispassword=="P" and isset($MD5) and $MD5==1 ){ 				$variables["tag".$tag]= md5($variables["tag".$tag]);
 			}else{ 			}
			if ($subc!="" && $tipoc!="T"){
				$lin=trim($variables["tag".$tag]);
                if (!isset($default_values) and !isset($rec_validation) and !isset($end_code)){
					if ($lin!="") {
	                    if (trim($t[6])!=""){
					   		$variables["tag".$tag]=CodificaSubCampos($lin,$numsubc,$subc,$delimsc);
						}
					}
				}

			}
// si $rep=T el campo se edita en forma de tabla por lo que hay que convertirlo en un campo
// repetible con subcampos
		//	if ($rep=="T") {			$dummy=explode("\n",$variables["tag".$tag]);
			$salida="";
			foreach ($dummy as $linea) {
 				//$linea=trim($linea);  //no colocar el trim porque borra los espacios antes del indicador
 				if (trim($linea!="")){					$xlin="";
					for ($i=0; $i<strlen($subc);$i++){						$resc="";
						if ($i==0 and (substr($subc,$i,1)=="_" or substr($subc,$i,1)=="-")){
                                if (substr($linea,0,1)=="^")
                                	$linea=substr($linea,1);
								$resc="";
						}
						if ($resc==""){
							$xlin.=$linea;
							break;
						}else{
	                        $ix1=strpos($linea,$resc);
							if ($ix1===false) {
							}else{
								$ix2=strpos($linea,'^',$ix1+1);
								if ($ix2===false) {
							    	$ix2=strlen($linea);
								}
								$ix1=$ix1+strlen($resc);
								$valorsc=substr($linea,$ix1,$ix2-$ix1);
								if (trim($valorsc)!="") {
									if ($i==0){										if ($resc=="^" ) {
											$resc="";
										}									}
									$xlin.=$resc.$valorsc;
								}
								$linea=substr($linea,$ix2);
							}
						}
					}
					if ($xlin!="") $salida.=$xlin."\n";
      			}
			}
			if (trim($salida)!="") $variables["tag".$tag]= $salida;
		}else{			if ($dataentry!="B") $variables["tag".$tag]="";       //THE EXTERNAL HTML IS NOT UPDATED		}
	}
	$val_duplicado="";

    if (isset($arrHttp["check_select"])){
    	$dummy=array();
    	$dummy=explode("\n",$arrHttp["check_select"]);    	foreach ($dummy as $value){    		if (trim($value)!=""){	    		$ixD=strpos($value,"_");
	    		if ($ixD>0){
		    		$parte1=substr($value,0,$ixD);
		    		$parte2=substr($value,$ixD+1);
		    		$k=trim(substr($parte1,3));
		    		$key=trim(substr($parte1,3));
					if (strlen($key)==1) $key="000".$key;
					if (strlen($key)==2) $key="00".$key;
					if (strlen($key)==3) $key="0".$key;
					$parte2=stripslashes($parte2);
				//	$parte2=str_replace("'","&acute;",$parte2);
					unset($p2);
					$p2=explode("_",$parte2);
					if (isset($p2[2])){
					}else{
				    	$ValorCapturado.=$key.$parte2."\n";
				    	$VC.=$k." ".$parte2."\n";
					}
				}
             }    	}
	}

	if ($arrHttp["Opcion"]!="eliminar" and isset($variables)){
		foreach ($variables as $key => $lin){
		//OJO No se deben eliminar las líneas cuyo contenido esté vacío porque ello significa
		// que se quiere eliminar el campo   del registro
			$key=trim(substr($key,3));
			$k=$key;
			$ixPos=strpos($key,"_");
			if (!$ixPos===false) {
		    	$key=substr($key,0,$ixPos-1);
			}
			if (trim($key)!=""){
				if (strlen($key)==1) $key="000".$key;
				if (strlen($key)==2) $key="00".$key;
				if (strlen($key)==3) $key="0".$key;
				$lin=stripslashes($lin);
		//		$lin=str_replace("'","&acute;",$lin);
				$campo=array();
    			if ($dataentry!="xA")
						$campo=explode("\n",$lin);
					else
				$campo[]=str_replace("\n","",$lin);
				foreach($campo as $lin){
					$VC.=$k." ".$lin."\n";
					$ValorCapturado.=$key.$lin."\n";
				}
			}
		}
	}
	$valc=explode("\n",$ValorCapturado);
 	$ValorCapturado="";
 	$Eliminar="";
 	$Eli_array=array();
 	foreach ($valc as $v){
 		//$v=trim($v);
 		if (trim(substr($v,0,4))!=""){ 			if (!isset($Eli_array[substr($v,0,4)])){
 		   		$Eliminar.="d".substr($v,0,4);
 		   		$Eli_array[substr($v,0,4)]="S";
 			}
 		   	if (trim(substr($v,4))!=""){
				//$ValorCapturado.="a".substr($v,0,4)."¬".substr($v,4)."¬";
				$cc=str_replace("\n","",substr($v,4));
				$cc=str_replace("\r","",$cc);
				$ValorCapturado.="<".substr($v,0,4)." 0>".$cc."</".substr($v,0,4).">";
			}
		}
 	}
	$x=isset($default_values);
	$fatal_cn="";
	$fatal="";
	$error="";
    if ($arrHttp["Opcion"]!="eliminar" and $arrHttp["Opcion"]!="save" and !isset($arrHttp["Validar"])){
	   	if (isset($default_values) or isset($rec_validation) or isset($end_code)){
	   		$variables=$variables_org;
	   		return;
	   	}else{

	   		// si en la FDT existe un campo del tipo autoincrement, entonces se determina el número de identificación
	   		// si el valor del campo ya viene fijado entonces no se genera un nuevo valor
	   		if(isset($arrHttp["autoincrement"]) and $arrHttp["Mfn"]=="New"){	 			if (isset($arrHttp["tag".$arrHttp["autoincrement"]]) and $arrHttp["tag".$arrHttp["autoincrement"]]=="" or !isset($arrHttp["tag".$arrHttp["autoincrement"]])){	 				$nc="";	 			 	include("autoincrement.php");
	 			 	if ($cn=="" or $cn==false){                        $fatal_cn="Could not generate the control number";	 			 	}else{
		   				$key=$arrHttp["autoincrement"];
						$ValorCapturado.="<".$key." 0>".$cn."</".$key.">";
						$VC.=$arrHttp["autoincrement"]." ".$cn."\n";
					}
				}else{					$cn=$arrHttp["tag".$arrHttp["autoincrement"]];				}
	   		}

	        unset($validar);
			$pftval="";
			if (isset($arrHttp["wks"])){				$val=explode(".",$arrHttp["wks"]);
				if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$val[0].".val")){					$pftval=$val[0].".val";
				}else{
					if (isset($tm)){						foreach ($tm as $value){							$t=explode('|',$value);
							if ($t[0]==$arrHttp["wks"]){								$tl=strtolower($t[1]);
								$nr=strtolower($t[2]);
								$pftval=$tl;
								if (isset($nr) and $nr!="")
									$pftval.="_".$nr;
								$pftval.="_".$arrHttp["base"].".val";
								break;							}						}					}
				}			}
			$file_val="";
			if ($pftval!=""){
				$file_val=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$pftval;				if (!file_exists($file_val))  $file_val=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$pftval;	        }
			if ($file_val=="" or !file_exists($file_val)){				$file_val=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".val";
				if (!file_exists($file_val))  $file_val=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".val";			}
		//CALL THE VALIDATION FORMAT
			$output="";
			if (file_exists($file_val) and $arrHttp["Opcion"]!="save" and !isset($arrHttp["Validar"])){

				include("recval_check.php");

			}
		//VALIDACION POR DUPLICADOS MARCADOS EN LA FDT
			$fatal_dup="";
			foreach ($cdup as $key=>$var){
				if (isset($variables["tag".$key])){
					$res=ValidarDuplicados($key,$var["subc"],$var["prefix"],$variables["tag".$key],$var["name"]);
					if ($res!=""){						$fatal_dup.="<br>".$res;
					}
				}
			}
		}

	    if ($fatal=="Y" or $fatal_cn!="" or $fatal_dup!="") {			echo "<div class=\"middle form\">
					<div class=\"formContent\">
				";

			echo "<p><font color=red><strong>".$msgstr["recnotupdated"]."</strong></font>";
			if ($fatal_cn!="") echo $fatal_cn. " $cn";
			if ($fatal_dup!="") echo $fatal_dup;
			$error= $output;
			echo $output;
		//	if (isset($arrHttp["autoincrement"]))
	  	//		echo "<p><font color=red><strong>".$msgstr["cwritefile"]. "control_number.cn"."</strong></font>";
	  	    $VC=urlencode($VC);
			$url= "fmt.php?base=".$arrHttp["base"]."&cipar=".$arrHttp["base"].".par&ValorCapturado=$VC&Opcion=reintentar&Mfn=".$arrHttp["Mfn"]."&error=".urlencode($error)."&Formato=".$arrHttp["Formato"];
			if (isset($arrHttp["wks_a"])) $url.="&wks=".$arrHttp["wks_a"];
			if (isset($arrHttp["wks"])) $url.="&wks=".$arrHttp["wks"];
			$url.="&ver=N";
			if (isset($arrHttp["db_copies"]))  $url.="&db_copies=".$arrHttp["db_copies"];
			if (isset($arrHttp["ventana"])) $url.="&ventana=".$arrHttp["ventana"];
			echo "<p><a href=$url><h3>".$msgstr["editar"]."</h3></a>";
			echo "</div></div>";
			die;
		}else{			if (isset($output) and trim($output)!=""){				echo $output;

				$VC=urlencode($VC);
				$url_orig= "fmt.php?base=".$arrHttp["base"]."&cipar=".$arrHttp["base"].".par&ValorCapturado=$VC&Mfn=".$arrHttp["Mfn"]."&error=".urlencode($error)."&Formato=".$arrHttp["Formato"];
				$url=$url_orig."&Opcion=reintentar";
				if (isset($arrHttp["wks_a"])) $url.="&wks=".$arrHttp["wks_a"];
				$url.="&ver=N";
				if (isset($arrHttp["db_copies"]))  $url.="&db_copies=".$arrHttp["db_copies"];
				if (isset($arrHttp["ventana"])) $url.="&ventana=".$arrHttp["ventana"];
				echo "<p><a href=$url><strong><font size=4>".$msgstr["editar"]."</font></a>";
				echo "&nbsp; &nbsp;";
				$url=$url_orig."&Opcion=cancelar";
				if (isset($arrHttp["wks_a"])) $url.="&wks=".$arrHttp["wks_a"];
				$url.="&ver=N";
				if (isset($arrHttp["db_copies"]))  $url.="&db_copies=".$arrHttp["db_copies"];
				if (isset($arrHttp["ventana"])) $url.="&ventana=".$arrHttp["ventana"];
				echo "<a href=$url><font size=4>".$msgstr["cancelar"]."</font></a>";
				echo "&nbsp; &nbsp;";
				$url=$url_orig."&Opcion=save";
				if (isset($arrHttp["wks_a"])) $url.="&wks=".$arrHttp["wks_a"];
				$url.="&ver=N";
				if (isset($arrHttp["db_copies"]))  $url.="&db_copies=".$arrHttp["db_copies"];
				echo "<a href=$url><font size=4>".$msgstr["save"]."</font></a>";
				echo "</div></div>";
				die;			}		}
	}else{
		if ($arrHttp["Opcion"]=="save"){

			//$ValorCapturado=urlencode($ValorCapturado);
			//$VC=urlencode($VC);
	        unset($validar);
		}
	}
	if ($arrHttp["Opcion"]=="save") {		$arrHttp["Validar"]="NO";
		$arrHttp["Opcion"]="actualizar";	}
 	if ($arrHttp["Opcion"]=="addocc"){ 		$ValorCapturado=urlencode($ValorCapturado); 	}else{ 		$ValorCapturado=urlencode($Eliminar.$ValorCapturado); 	}
	if ($arrHttp["Mfn"]=="New") $arrHttp["Opcion"]="crear";
	$IsisScript=$xWxis."actualizar.xis";
	if (file_exists($db_path."$base/data/stw.tab"))
		$stw="&stw=".$db_path."$base/data/stw.tab";
	else
		if (file_exists($db_path."stw.tab"))
			$stw="&stw=".$db_path."stw.tab";
		else
			$stw="";
  	$query = "&base=".$base ."&cipar=$db_path"."par/".$cipar."&login=".$_SESSION["login"]."&Mfn=" . $arrHttp["Mfn"]."&Opcion=".$arrHttp["Opcion"]."$stw&ValorCapturado=".$ValorCapturado;

  	if (isset($arrHttp["wks"])) $query.="&wks=".$arrHttp["wks"];
  	if (isset($arrHttp["Validar"])){  		$query.="&Validar=NO";  	}
	include("../common/wxis_llamar.php");
//	echo "Longitud del campo de actualización: ".strlen($ValorCapturado);
    $salida="";
	foreach ($contenido as $linea){
        if (substr($linea,0,4)=="WXIS"){        	echo $linea;        }		if (substr($linea,0,4)=="MFN:") {
	    	$arrHttp["Mfn"]=trim(substr($linea,4));
		}else{
			if (trim($linea)!="") $salida.= $linea."\n";
		}
	}
	return $salida;

}


if(isset($arrHttp["Opcion"]) and $arrHttp["Opcion"]=="crear"){
	$maxmfn=$arrHttp["Mfn"];
	$arrHttp["Maxmfn"]=$maxmfn;
}


?>