<?php 


function facetas(){

global $db_path, $lang, $msgstr, $actparfolder, $xWxis, $busqueda, $Expresion,$primera_base ;

/*
if (isset($_REQUEST["base"])){
    $_REQUEST["base"]=$_REQUEST["base"];
} else {
    $_REQUEST["base"]="marc";
}
  
if (isset($_REQUEST['prefijo']) && isset($_REQUEST['Sub_Expresion'])) {
    $Expresion=$_REQUEST['prefijo'].$_REQUEST['Sub_Expresion'];
} else {
    $Expresion="TW_$";
}

$busqueda=$Expresion;
*/

$facetas="S";


if (isset($facetas) and $facetas=="S" and (!isset($_REQUEST["prefijoindice"]) OR $_REQUEST["prefijoindice"]=="")){
    $archivo="";
if (file_exists($db_path."/opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["base"]."_facetas.dat")){
    $archivo=$db_path."/opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["base"]."_facetas.dat";
    }else{
    if (file_exists($db_path."/opac_conf/".$_REQUEST["lang"]."/facetas.dat"))
        $archivo=$db_path."/opac_conf/".$_REQUEST["lang"]."/"."facetas.dat";
    }

    if ($archivo!=""){
        $fp=file($archivo);
    if (count($fp)>0){
?>


            <?php
            $fp = file($archivo);
            foreach ($fp as $value_key) {
                $value_key = trim($value_key);
                if ($value_key != "") {
                    $x = explode('|', $value_key);
                    //echo " <li class='nav-item'><a class='nav-link' href='javascript:Facetas(\"$value_key\")'>" . $x[0];
                    $IsisScript = "opac/buscar.xis";
                    if ($Expresion == '$')
                        $ex = $x[1];
                    else
                        $ex = $x[1] . " and " . $busqueda;
                    if (isset($Expresion_col) and $Expresion_col != "") {
                        $ex .= " and " . $Expresion_col;
                    }
                    if (isset($_REQUEST["base"]) and $_REQUEST["base"] != "")
                        $base = $_REQUEST["base"];
                    else
                        $base = $primera_base;
                    $query = "&base=$base&cipar=$db_path" . $actparfolder . "$base" . ".par&Expresion=" . urlencode($ex) . "&from=1&count=1&Opcion=buscar&lang=".$lang;
                    //echo $query;
                    $resultado = wxisLlamar($base, $query, $xWxis . $IsisScript);
                    
                    foreach ($resultado as $value) {
                        $value = trim($value);
                        if (trim($value) != "") {
                            if (substr($value, 0, 8) == "[TOTAL:]") {
                                $list_fac=" <li class='nav-item'><a class='nav-link' href='javascript:Facetas(\"$value_key\")'>" . $x[0];
                                $list_fac.=" (" . substr($value, 8) . ")";
                                $list_fac.="</a></li>";
                                echo $list_fac;
                                break;
                            }
                        }
                    }
                    
                }
            }
            ?>


<?php

		}
	}
}


}//end facets


//if (isset($_REQUEST['Sub_Expresion']))   {
?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel"><?php echo $msgstr["facetas"] ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

<ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
       <?php  facetas(); ?>
        </ul>
  </div>
</div>

<?php
//}
?>

