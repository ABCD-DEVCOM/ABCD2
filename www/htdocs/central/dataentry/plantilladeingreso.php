<?php
function ConstruyeWorksheetFMT(){
global $arrHttp,$vars,$db_path,$lang_db,$base_fdt,$wks_avail,$msgstr;
	$base=$arrHttp["base"];
	$fpDb_fdt = $db_path.$base."/def/".$_SESSION["lang"]."/"."$base.fdt";
	if (!file_exists($fpDb_fdt)) {
		$fpDb_fdt = $db_path.$base."/def/".$lang_db."/"."$base.fdt";
		if (!file_exists($fpDb_fdt)){
   			echo $db_path.$base."/def/".$_SESSION["lang"]."/$base.fdt"." no existe";
			die;
		}
	}

	$fpDb=file($fpDb_fdt);
	// se lee la estructura de la base de datos (dbn.fdt)
	foreach ($fpDb as $linea){
		if (trim($linea)!="") {
			$base_fdt[]=$linea;
		}
	}
	unset($fp);
	if (isset($arrHttp["wks"])){
		if (strpos($arrHttp["wks"],".fmt")===false and strpos($arrHttp["wks"],".fdt")===false)  $arrHttp["wks"].=".fmt";
		$cod=$arrHttp["wks"];
		$ixpos=strpos($cod,".");
		$cod=substr($cod,0,$ixpos);
        if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$arrHttp["base"]."_fmt_ALL"]) or isset($_SESSION["permiso"][$arrHttp["base"]."_fmt_$cod"]) or isset($_SESSION["permiso"]["ACQ_ACQALL"])  or isset($_SESSION["permiso"]["ACQ_NEWSUGGESTIONS"])
			or (isset($arrHttp["db_addto"]) and (isset($_SESSION["permiso"][$arrHttp["db_addto"]."_CENTRAL_ADDCOP"]) or isset($_SESSION["permiso"][$arrHttp["db_addto"]."_CENTRAL_ADDLO"])))){
			if (file_exists($db_path.$base."/def/".$_SESSION["lang"]."/".$arrHttp["wks"])){
				$fp = file($db_path.$base."/def/".$_SESSION["lang"]."/".$arrHttp["wks"]);
			}else{
				if (file_exists($db_path.$base."/def/".$lang_db."/".$arrHttp["wks"])){
					$fp = file($db_path.$base."/def/".$lang_db."/".$arrHttp["wks"]);
				}
			}
		}else{
			echo "	<div class=\"middle form\">
						<div class=\"formContent\">\n";			 echo "<h4>".$msgstr["fmt"].":".$arrHttp["wks"]." ".$msgstr["recnoallow"]."</h4>";
			 echo "<script>top.xeditar=\"\"</script>";
			 $arrHttp["unlock"] ="S";
			 $maxmfn=0;
			 $res=LeerRegistro($arrHttp["base"],$arrHttp["base"].".par",$arrHttp["Mfn"],$maxmfn,$arrHttp["Opcion"],$arrHttp["login"],"","");
			 die;		}
	}
	if (!isset($fp)){
		if (isset($arrHttp["wks"])) echo "<h4>".$msgstr["notfound"].": ".$db_path.$base."/def/".$_SESSION["lang"]."/".$arrHttp["wks"]."</h4>";
		$vars=$base_fdt;
	    return;

	}
    $ix=-1;
    reset($fp);
    $copiado="N";
	foreach ($fp as $value){		$value=trim($value);
		if ($value!=""){
			unset($tx);
			$tx=explode('|',$value) ;
			if ($tx[18]==1){
				$copiado="S";
				$primeravez="S";
				reset($base_fdt);
				foreach ($base_fdt as $lin){
					unset($vx);
					$vx=explode('|',$lin);
					if ($vx[1]==$tx[1] or $primeravez=="N"){

						if ($primeravez=="S"){
							$ix=$ix+1;
							$vars[$ix]=$lin;
							$primeravez="N";
						}else{
							if (trim($vx[1])!="" or $vx[0]=="H"){       //Si la columna de tag no tiene un blanco se termina la lista de los subcampos
								break;
							}else{
								$ix=$ix+1;
								$vars[$ix]=$lin;
							}
						}
					}
				}			}else{
				if ($copiado=="S" and $tx[1]=="" and $tx[0]!="H" and $tx[0]!="L"){					continue;				}else{					$copiado="N";				}
				if ($tx[0]=="LDR"){					$Leader="S";
					$Marc="S";
					if (file_exists($db_path.$base."/def/".$_SESSION["lang"]."/leader.fdt"))
						$fixed=file($db_path.$base."/def/".$_SESSION["lang"]."/leader.fdt");
					else
						$fixed=file($db_path.$base."/def/".$lang_db."/leader.fdt");
					foreach ($fixed as $fx){
						if (trim($fx)!="") {							$ix=$ix+1;
							$vars[$ix]=$fx;						}
					}				}else{
                	$ix=$ix+1;
					$vars[$ix]=$value;
				}
			}
		}
	}
}


function ConstruyeWorksheetFDT($tm){
global $arrHttp,$vars,$db_path,$lang_db;
	if (!isset($arrHttp["base"])){		$base=$arrHttp["db"];	}else{		$base=$arrHttp["base"];	}

	$fpDb_fdt = $db_path.$base."/def/".$_SESSION["lang"]."/"."$base.fdt";
	if (!file_exists($fpDb_fdt)) {
		$fpDb_fdt = $db_path.$base."/def/".$lang_db."/"."$base.fdt";
		if (!file_exists($fpDb_fdt)){
   			echo $msgstr["notfound"].": ".$db_path.$base."/$base.fdt";
			die;
		}
	}
	$fpTm=file($fpDb_fdt);	if (!$fpTm) {
   		echo $msgstr["notfound"].": ".$db_path.$base."/def/".$_SESSION["lang"]."/$base.fdt";
		die;
	}
	$base_fdt=array();
	foreach ($fpTm as $linea){		if (trim($linea)!="") {
			$t=explode('|',$linea);
			if (trim($linea)!=""){
				switch ($t[0]){
					case "MF":
						$Marc="S";
						if (file_exists($db_path.$base."/def/".$_SESSION["lang"]."/$tm"))
							$fixed=file($db_path.$base."/def/".$_SESSION["lang"]."/$tm");
						else
							$fixed=file($db_path.$base."/def/".$lang_db."/$tm");
						foreach ($fixed as $fx){
							if (trim($fx)!="") $base_fdt[]=$fx;
						}
						break;
					case "LDR":
						$Leader="S";
						$Marc="S";
						if (file_exists($db_path.$base."/def/".$_SESSION["lang"]."/leader.fdt"))
							$fixed=file($db_path.$base."/def/".$_SESSION["lang"]."/leader.fdt");
						else
							$fixed=file($db_path.$base."/def/".$lang_db."/leader.fdt");
						foreach ($fixed as $fx){
							if (trim($fx)!="") $base_fdt[]=$fx;
						}
						break;
					default:
						$base_fdt[]=$linea;
				}
			}
		}
	}
    $vars=$base_fdt;

	return;

}

function PlantillaDeIngreso(){
global $arrHttp,$valortag,$tm,$vars,$base,$fdt,$tab_prop,$msgstr,$tagisis,$db_path,$Marc,$tl,$nr,$lang_db;

	$ixsfdt=0;
	if (!isset($arrHttp["wks"])){    	ConstruyeWorksheetFDT("");
    	return;    }
	if (isset($arrHttp["wks"])and $arrHttp["wks"]!=""){		$ix=strpos($arrHttp["wks"],".");
		$tipo_f=substr($arrHttp["wks"],$ix);
		if ($tipo_f==".fdt"){			ConstruyeWorksheetFDT($arrHttp["wks"]);
			return;		}else{
			ConstruyeWorksheetFMT($arrHttp["wks"].".fmt");
			return;		}

	}else{		$comp="";
		$tipom="";
		if (isset($valortag[trim($tl)]))
			$tipom=$valortag[trim($tl)];
		if (isset($valortag[trim($nr)]))
			$tipom.=$valortag[trim($nr)];
		if ($tipom=="")
			$tipom=$arrHttp["base"].".fdt";
		$tipom=strtolower($tipom);
		$archivo=$db_path.$base."/def/".$_SESSION["lang"]."/".$tipom;
		if (!file_exists($archivo))  $archivo=$db_path.$base."/def/".$lang_db."/".$tipom;
		$fp = file($archivo);
		$tipov="";
		$filas= Array ();
		$vars= Array ();
		$i=-1;

		foreach ($fp as $linea){
			if ($i==-1){
				$i=0;

			}
			$linea=rtrim($linea);
			if ($linea!=""){
				if (substr($linea,0,3)=="LDR"){					$Leader="S";
					$Marc="S";
					if (file_exists($db_path.$base."/def/".$_SESSION["lang"]."/leader.fdt"))
						$fixed=file($db_path.$base."/def/".$_SESSION["lang"]."/leader.fdt");
					else
						$fixed=file($db_path.$base."/def/".$lang_db."/leader.fdt");
					foreach ($fixed as $fx){
						if (trim($fx)!="") $vars[]=$fx;
					}				}else{
  					$vars[]=$linea;
  				}
			}
		}



	}

	$FdtHtml="S";
	$arrHttp["administrador"]="S";
	for ($ivars=0;$ivars<count($vars);$ivars++){
		$linea=$vars[$ivars];
		$t=explode('|',$linea);
		$tag=$t[1];
	  	$fdt[$tag]=$linea;
	}

}



?>