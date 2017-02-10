<?php

function LeerFdt($base){global $lang_db;	include ("../config.php");
// se lee el archivo dbn.fdt
	$archivo="$db_path$base/def/".$_SESSION["lang"]."/$base.fdt";
	if (file_exists($archivo))
		$fpTm = file($archivo);
	else
		$fpTm=file("$db_path$base/def/".$lang_db."/$base.fdt");

	foreach ($fpTm as $linea){
		if (trim($linea)!="") {
			$t=explode('|',$linea);
  			if ($t[0]!="S" and $t[0]!="H" and $t[0]!="L"){
  				//ESTO SE PONE PARA LOS CAMBIOS QUE SE HICIERON EN LA FDT EN CUANTO AL TIPO DE CAMPO Y EL TIPO DE INGRESO
				 switch ($t[0]){
					case "OD":
							$t[0]="F" ;
							$t[7]="OD";
					  		break;
					  	case "OC":
					       $t[0]="F";
					       $t[7]="OC";
					  		break;
					    case "ISO":
					       $t[0]="F";
					       $t[7]="ISO";
					  		break;
					    case "DC":
					    	$t[0]="F";
					    	$t[7]="DC";
							break;
						case "AI":
							$t[0]="F";
					    	$t[7]="AI";
				}
  	  			$tag=$t[1];
  	  			if ($tag!="" and $tag!="*"){
  	  				if (!isset($Fdt[$tag])){
		    			$Fdt[$tag]=$linea;
					}
				}
			}
		}
	}
   return $Fdt;
}

?>