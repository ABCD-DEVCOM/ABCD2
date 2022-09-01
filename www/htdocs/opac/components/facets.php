<?php 
$facetas="S";

//echo $_REQUEST["base"];
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
        <div class="side-bar-facetas">
            <a href="#" class="facetas" onclick="openNavFacetas()"><?php echo $msgstr["facetas"] ?></a>
        </div>
        <div id="SidenavFacetas" class="sidenav-facetas">
            <?php
            $fp = file($archivo);
            foreach ($fp as $value) {
                $value = trim($value);
                if ($value != "") {
                    $x = explode('|', $value);
                    echo "<a href='javascript:Facetas(\"$value\")'>" . $x[0];
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
                    $query = "&base=$bb&cipar=$db_path" . $actparfolder . "/$bb" . ".par&Expresion=" . urlencode($ex) . "&from=1&count=1&Opcion=buscar&lang=" . $_REQUEST["lang"];
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
            ?>

            <br>
            <a href="javascript:void(0)" onclick="closeNavFacetas()">&times; <?php echo $msgstr["close"] ?></a>
            < <br><br><br><br>
        </div>
<?php

		}
	}
}