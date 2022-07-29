<?php 
$facetas="Y";

if (isset($facetas) and $facetas=="Y" and (!isset($_REQUEST["prefijoindice"]) OR $_REQUEST["prefijoindice"]=="")){
    $archivo="";

    if ((isset($_SESSION['Accion'])) and $_SESSION['Accion']!="reserve_one") {
    $archivo="";    

} else {
    if (file_exists($db_path."/opac_conf/".$lang."/".$_REQUEST["base"]."_facetas.dat")){
    $archivo=$db_path."/opac_conf/".$lang."/".$_REQUEST["base"]."_facetas.dat";
    }else{
    if (file_exists($db_path."/opac_conf/".$lang."/facetas.dat"))
        $archivo=$db_path."/opac_conf/".$lang."/"."facetas.dat";
    }
}

    if ($archivo!=""){
        $fp=file($archivo);
    if (count($fp)>0){
?>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
          <span><?php echo $msgstr["facetas"]; ?></span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle" class="align-text-bottom"></span>
          </a>
        </h6>	

<?php
            $fp = file($archivo);
            foreach ($fp as $value) {
                $value = trim($value);
                if ($value != "") {
                    $x = explode('|', $value);
                    echo '<li class="nav-item"><a class="nav-link" href="javascript:Facetas('.$value.')">' . $x[0];
                    $IsisScript = "opac/buscar.xis";
                    if ($Expresion == '$')
                        $ex = $x[1];
                    else
                        $ex = $x[1] . " and " . $busqueda;
                    if (isset($Expresion_col) and $Expresion_col != "") {
                        $ex .= " and " . $Expresion_col;
                    }
                    if (isset($_REQUEST["base"]) and $_REQUEST["base"] != "")
                        $bb = $_REQUEST["base"];
                    else
                        $bb = $primera_base;
                    $query = "&base=$bb&cipar=$db_path" . $actparfolder . "$bb" . ".par&Expresion=" . urlencode($ex) . "&from=1&count=1&Opcion=buscar&lang=" . $lang;
                    $resultado = wxisLlamar($bb, $query, $xWxis . $IsisScript);
                    $primeravez = "S";
                    foreach ($resultado as $value) {
                        $value = trim($value);
                        if (trim($value) != "") {
                            if (substr($value, 0, 8) == "[TOTAL:]") {
                                $primeravez = "N";
                                echo " (" . substr($value, 8) . ")";
                                break;
                            }
                        }
                    }
                    if ($primeravez == "S") echo " (0)";
                    echo "</a>";
                }
            }

		}
	}
}
?>