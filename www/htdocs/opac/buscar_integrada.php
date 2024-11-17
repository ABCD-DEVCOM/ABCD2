<?php
/**************** Modifications ****************

2022-03-23 rogercgui change the folder /par to the variable $actparfolder

***********************************************/



if (isset($_REQUEST["db_path"])) $_REQUEST["db_path"]=urldecode($_REQUEST["db_path"]);
include("../central/config_opac.php");
include($Web_Dir.'views/presentar_registros.php');
include($Web_Dir.'views/nav_pages.php');

include($Web_Dir.'head.php');

$select_formato="";

//foreach ($_REQUEST as $var=>$value) echo "$var=>$value<br>";
if (isset($_REQUEST["Formato"])) {
	$_REQUEST["Formato"]=trim($_REQUEST["Formato"]);
	if ($_REQUEST["Formato"]==""){
		unset($_REQUEST["Formato"]);
	}else{
		if (substr($_REQUEST["Formato"],strlen($_REQUEST["Formato"])-4)==".pft") $_REQUEST["Formato"]=substr($_REQUEST["Formato"],0,strlen($_REQUEST["Formato"])-4);
	}
}

function SelectFormato($base,$db_path,$msgstr){
	global $lang;
	$PFT="";
	$Formato="";
	
	$archivo=$base."_formatos.dat";
	if (file_exists($db_path.$base."/opac/".$lang."/".$archivo)){
		$fp=file($db_path.$base."/opac/".$lang."/".$archivo);
	}else{
		echo "<h4><font color=red>".$msgstr["front_no_format"]."</h4>";
		die;
	}

	$select_formato=$msgstr["front_select_formato"]." <select class=\"form-select\" name=cambio_Pft id=cambio_Pft onchange=CambiarFormato()>";
	$primero="";
	$encontrado="";
	foreach ($fp as $linea){
		if (trim($linea!="")){
			$f=explode('|',$linea);
			$f[0]=trim($f[0]);
			if (substr($f[0],strlen($f[0])-4)==".pft") $f[0]=substr($f[0],0,strlen($f[0])-4);
			$linea=$f[0].'|'.$f[1];
			if ($PFT==""){
				$PFT=trim($linea);
			} else {
				$PFT.='$$$'.trim($linea);
			}
			if (!isset($_REQUEST["Formato"]) and $primero==""){
				$primero=$f[0];
			}
			if (isset($_REQUEST["Formato"]) and $_REQUEST["Formato"]==$f[0]){
				$xselected=" selected";
				$encontrado="Y";
			}else {
				$xselected="";
				$select_formato.= "<option value=".$f[0]." $xselected>".$f[1]."</option>\n";
			}
		}
	}
	$select_formato.="</select>";
	if ($encontrado!="Y")
		$_REQUEST["Formato"]=$primero;
	$Formato=$_REQUEST["Formato"];
	return array($select_formato,$Formato);
}



if (isset($_REQUEST["prefijoindice"])) $_REQUEST["mostrar_exp"]="N";
if (!isset($_REQUEST["Opcion"])) die;

if (!isset($_REQUEST["indice_base"])) $_REQUEST["indice_base"]=0;

if ($_REQUEST["Opcion"]!="directa"){
	if (isset($_REQUEST["prefijoindice"])) {
		$letra=$_REQUEST["Expresion"];
		$_REQUEST["Expresion_o"]=str_replace('"','',rtrim($_REQUEST["Expresion"]));
		$Prefijo=$_REQUEST["prefijoindice"];

	}else{
		if (isset($_REQUEST["prefijo"]))  $Prefijo=$_REQUEST["prefijo"];
	}
	foreach ($_REQUEST as $key=>$value) $_REQUEST[$key]=urldecode($value);
	//foreach ($_REQUEST as $key=>$value) $_REQUEST[$key]=urldecode($value);

	if (isset($_REQUEST["Sub_Expresion"])) $_REQUEST["Sub_Expresion"] =str_replace('\\','',$_REQUEST["Sub_Expresion"]);
	}

	if (isset($rec_pag)) $_REQUEST["count"] = $rec_pag;
	if (!isset($_REQUEST["desde"]) or trim($_REQUEST["desde"])=="" ) $_REQUEST["desde"]=1;
	if (!isset($_REQUEST["count"]) or trim($_REQUEST["count"])=="")  $_REQUEST["count"]=$npages;



	$desde=$_REQUEST["desde"];
	$count=$_REQUEST["count"];


if (isset($_REQUEST["Opcion"]) and ($_REQUEST["Opcion"]=="diccionario")){
	$_REQUEST["Expresion"]=str_replace($_REQUEST["prefijo"],"",$_REQUEST["Expresion"]);
}
if (isset($_REQUEST["integrada"])) $_REQUEST["integrada"]=urldecode($_REQUEST["integrada"]);
if (!isset($_REQUEST["alcance"]) or $_REQUEST["alcance"]=="") $_REQUEST["alcance"]="or";

$Expresion="";
switch ($_REQUEST["Opcion"]){
    case "directa":
    	$Expresion=urldecode($_REQUEST["Expresion"]);
    	$_REQUEST["titulo_c"]=urldecode($_REQUEST["titulo_c"]) ;
    	$afinarBusqueda="N";
    	break;

	case "libre":
		if (!isset($_REQUEST["alcance"])) $_REQUEST["alcance"]="or";
		If (!isset($_REQUEST["Sub_Expresion"]) or trim($_REQUEST["Sub_Expresion"])==""){
			if (isset($_REQUEST["Seleccionados"])) $_REQUEST["Sub_Expresion"]=$_REQUEST["Seleccionados"];
		}
		if (isset($_REQUEST["Sub_Expresion"]) and trim($_REQUEST["Sub_Expresion"])!=""){
			if (strpos($_REQUEST["Sub_Expresion"],'"')!==false){
				$pal=explode('"',$_REQUEST["Sub_Expresion"]);
			}else{
				$pal=explode(' ',$_REQUEST["Sub_Expresion"]);
	            }
			if ($_REQUEST["alcance"]=="") $_REQUEST["alcance"]="or";
			if (isset($_REQUEST["prefijo"]) and $_REQUEST["prefijo"]=="TW_"){
				 $_REQUEST["Sub_Expresion"]="";
				foreach ($pal as $w){
					if (trim($w)!=""){
						if ($Expresion==""){
							$Expresion='"'.$_REQUEST["prefijo"].$w.'"';
							if (isset($_REQUEST["prefijo"]) and $_REQUEST["prefijo"]=="TW_") $_REQUEST["Sub_Expresion"]='"'.$w.'"';
						}else{
							$Expresion.=" ".$_REQUEST["alcance"].' "'.$_REQUEST["prefijo"].$w.'"';
							if (isset($_REQUEST["prefijo"]) and $_REQUEST["prefijo"]=="TW_") $_REQUEST["Sub_Expresion"].=' "'.$w.'"';
						}
					}
				}
			}
		} else{
			$_REQUEST["Sub_Expresion"]="";
			$Expresion='$';
		}
		if ($Expresion!='$'){
			$CA[]=$_REQUEST["prefijo"];
			$EX[]=$_REQUEST["Sub_Expresion"];
			unset($_REQUEST["Seleccionados"]);
		}
		break;
	case "detalle":
        if (isset($_REQUEST["prefijo"]) and $_REQUEST["prefijo"]!="") $Prefijo=$_REQUEST["prefijo"];
		$EX[]=str_replace($Prefijo,'',$_REQUEST["Sub_Expresion"]);
		$CA[]=$Prefijo;
		$_REQUEST["Campos"]= $Prefijo;
		if (substr($_REQUEST["Sub_Expresion"],0,strlen($Prefijo))!=$Prefijo){
			$Expresion=$Prefijo.$_REQUEST["Sub_Expresion"];
		}else{
			$Expresion=$_REQUEST["Sub_Expresion"];
		}
		$_REQUEST["Sub_Expresion"]=str_replace($_REQUEST["prefijo"],'',$_REQUEST["Sub_Expresion"]);
		$Expresion="\"".$Expresion."\"";
		break;
	case "avanzada":
	case "buscar_diccionario":
		if ($_REQUEST["Opcion"]=="avanzada"){
			$EX=explode('~~~',urldecode($_REQUEST["Sub_Expresion"]));
			$CA=explode('~~~',$_REQUEST["Campos"]);
			if (isset($_REQUEST["Operadores"])){
				$_REQUEST["Operadores"].=" ~~~ ";
				$OP=explode('~~~',$_REQUEST["Operadores"]);
			}else{
				$OP=array();
			}
			if (isset($_REQUEST["Seleccionados"])){
				if (isset($_REQUEST["Diccio"])){
					$EX[$_REQUEST["Diccio"]]=$_REQUEST["Seleccionados"] ;
					$OP[]="";
	            	$CA[]=$_REQUEST["prefijo"];
				}else{
					$EX[count($EX)-1]=$_REQUEST["Seleccionados"] ;
	            	$OP[]="";
	            	$CA[]=$_REQUEST["prefijo"];
				}
			}
			
		}else{
            if (isset($_REQUEST["base"]) and $_REQUEST["base"]!="")
				$fav=file($db_path.$base."/opac/".$lang."/".$_REQUEST["base"]."_avanzada.tab");
			else
				$fav=file($db_path."opac_conf/".$lang."/avanzada.tab");
			$ix=-1;
			$exp_bb="";

			foreach ($fav as $value){
				$value=trim($value);
				if ($value!=""){
					$ix=$ix+1;
					$v=explode('|',$value) ;
					$OP[$ix]=" ";
					$CA[$ix]=$v[1];
					if ($_REQUEST["prefijo"]==$v[1])
						if (isset($_REQUEST["Seleccionados"]))
							$EX[$ix]=$_REQUEST["Seleccionados"];
						else
							$EX[$ix]=" ";
	            	else
	                    $EX[$ix]=" ";
	          		if ($exp_bb=="")
	          			$exp_bb=$EX[$ix];
	          		else
	          			$exp_bb.='~~~'.$EX[$ix];
				}
			}
			$_REQUEST["Sub_Expresion"]=$exp_bb;
			/*
			if (isset($_REQUEST["Seleccionados"])){
				$EX[0]=$_REQUEST["Seleccionados"];
			}else{
                $EX[0]=str_replace('"',"",$_REQUEST["Sub_Expresion"]);
			}
				$CA[0]=$_REQUEST["prefijo"];
				$OP[0]="";
            */
		}

		$Expresion="";
		$EB=array();
		$EBO=array();
		$IB=-1;
		for ($ix=0;$ix<count($EX);$ix++){
			$booleano="";
			if ($ix<>0) if(isset($OP[$ix-1]) )$booleano=$OP[$ix-1];
			if (trim($EX[$ix])!=""){
				if (strpos($EX[$ix],'"')===false){
                    if (trim($CA[$ix])=="TW_"){
						$expre=explode(' ',$EX[$ix]);
					}else{
						$expre=explode('"',$EX[$ix]);
						$expre=explode(' ',$EX[$ix]);
					}
        	    }else{
					$expre=explode('"',$EX[$ix]);
				}
                $sub_expre="";
				foreach ($expre as $exp){
					$exp=rtrim($exp);
					if ($exp!=""){
						$exp='"'.trim((string)$CA[$ix]).$exp.'"';
						if ($sub_expre==""){
							$sub_expre=$exp;
						}else{
							$sub_expre.=" ".$_REQUEST["alcance"]." ".$exp;
						}
					}
				}
				if ($sub_expre!=""){
					$IB=$IB+1;
					$EB[$IB]= "(".$sub_expre.")";
					$EBO[$IB]=$OP[$ix];
				}
			}
		}
		$Expresion="";
		for ($ix=0;$ix<=$IB;$ix++){
			if ($ix==0){
				$Expresion=$EB[$ix];
			}else{
				$Expresion.=" ".$EBO[$ix-1]." ".$EB[$ix];
			}
		}
        break;
}
if ($Expresion=="") { 
	$Expresion='$';
} else {
	$_REQUEST["Expresion"]=$Expresion;
}

if (isset($_REQUEST["prefijo"]) or $_REQUEST["Opcion"]=="detalle") {
	$formula=explode('$#$',$Expresion);
	if ((strpos($formula[0],"(")!==false or strpos($formula[0],")" )!==false or strpos($formula[0],"'" )!==false ) and strpos($formula[0],'"')===false)
		$formula[0]='"'.$formula[0].'"';
	$Expresion=$formula[0];
	if (isset($formula[1])and trim($formula[1])!=""){
		$formula[1]=substr($formula[1],0,30);
		if (strpos($formula[1],"(")!==false or strpos($formula[1],")")!==false )
			$formula[1]='"'.$formula[1].'"';
		$Expresion.=' and '.$formula[1];
	}
}

if (isset($_REQUEST["coleccion"]) and $_REQUEST["coleccion"]!=""){
	$Expresion_col="";
	$coleccion=explode('|',$_REQUEST["coleccion"]);
	//if (!isset($_REQUEST["titulo_c"]))
		$_REQUEST["titulo_c"]=$coleccion[1];
	$_REQUEST["prefijo_col"] =$coleccion[2];
	$expr_coleccion=$coleccion[1];
	if ($Expresion!="" and $Expresion!='$' and $Expresion!=$coleccion[2].$coleccion[0]){
		$Expresion_col="(".$Expresion.") and ";
		$Expresion_col.=$coleccion[2].$coleccion[0];
	}else{
		$Expresion_col=$coleccion[2].$coleccion[0];
	}
}
//echo $Expresion_col." , $expre_coleccion";
//if (isset($_REQUEST["titulo_c"])) echo "<p><span class=titulo3>".urldecode($_REQUEST["titulo_c"])."</span></p>";

if ($Expresion!='$' or isset($Expresion_col)){
	if (isset($expr_coleccion)  and !isset($yaidentificado)){
		echo "<div style='margin-top:30px;display: block;width:100%;font-size:12px;'>";
		echo "<h3>$expr_coleccion<h3>";
		echo "</div>";
	}

}

//if (isset($_REQUEST["titulo_c"]) and $_REQUEST["titulo_c"]!="") echo "<p><span class=titulo3>".urldecode($_REQUEST["titulo_c"])."</span></p>";


$ix=-1;
$primera_base="";
$total_registros=0;
$integrada="";
if ($Expresion=='' and !isset($_REQUEST["coleccion"])) $Expresion='';

//echo "<p>$Expresion</p>";


foreach ($bd_list as $base=>$value) {
	if (!isset($_REQUEST["modo"]) or $_REQUEST["modo"]!="integrado"){
		if (isset($_REQUEST["base"]) and $_REQUEST["base"]!="" ){
			if  ($base!= $_REQUEST["base"]) {
				continue;
				echo "continue";
			}
		}
	}

	if (isset($Expresion_col)){
		$busqueda=$Expresion_col;
	} else {
		$busqueda=$Expresion;
	}

 	if (isset($_REQUEST["cipar"]) and $_REQUEST["cipar"]!="" ){
       	$cipar=$_REQUEST["cipar"];
 	} else {
       	$cipar=$base;
	}


$dr_path=$db_path.$base."/dr_path.def";


$cset_db = ""; 

if (file_exists($dr_path)) {
    	$def_db = parse_ini_file($dr_path);
} 

if (!isset($def_db['UNICODE'])) {
	$cset_db = "ANSI";
} elseif ($def_db['UNICODE'] == "1") {
	$cset_db = "UTF-8";
} else {
	$cset_db = "ANSI";
}

	
	$cset=strtoupper($meta_encoding);
        if ($cset=="UTF-8" and $cset_db=="ANSI"){
        	//$busqueda_decode[$base]=mb_convert_encoding($busqueda,'UTF-8', 'ISO-8859-1');
        	$busqueda_decode[$base]=mb_convert_encoding($busqueda,'ISO-8859-1','UTF-8');
        } else {
        	$busqueda_decode[$base]=$busqueda;
		}
        if ($busqueda_decode[$base]=="") $busqueda_decode[$base]='$';


// Toda a busca acontece aqui
    if (($Expresion=="" or substr($Expresion, -2,-1)=='$') and (!isset($Expresion_col) or $Expresion_col=="") ){
	   	$status="Y";
      	$IsisScript="opac/status.xis";
       	$busqueda_decode["$base"]='$';
		$query = "&base=".$base."&cipar=".$db_path.$actparfolder.$cipar.".par&Expresion=".$busqueda_decode[$base]."&from=1&count=1&Opcion=status&lang=".$lang;
    } else {
       	$status="N";
       	$facetas=array();
       	$IsisScript="opac/buscar.xis";
		$query = "&base=".$base."&cipar=".$db_path.$actparfolder.$cipar.".par&Expresion=".$busqueda_decode[$base]."&from=1&count=1&Opcion=buscar&lang=".$lang;
	}

	$resultado=wxisLlamar($base,$query,$xWxis.$IsisScript);
	$primeravez="S";
	$total=0;
    $ix=$ix+1;
	foreach ($resultado as $value_res) {
		$total="";
		$value_res=trim($value_res);
		if ($status=="Y"){
			if (substr($value_res,0,7)=='MAXMFN:'){
				$total=trim(substr($value_res,7));
                if ($primera_base=="")  $primera_base=$base;
			}
		}else{
			if (substr($value_res,0,8)=='[TOTAL:]'){
				$total=trim(substr($value_res,8));
				if ($primera_base=="") $primera_base=$base;
			}
		}
		if ($total!=0){
			if ($total>0) {
				$total_base[$base]=$total;
			}
			if (isset($_REQUEST["Expresion"])) { 
				$Expresion=$_REQUEST["Expresion"];
			} else {
				$Expresion="$";
			} 			
			if ($integrada=="")
				$integrada=$base.'$$'.$total.'$$'.urlencode($Expresion);
			else
			$integrada.='||'.$base.'$$'.$total.'$$'.urlencode($Expresion);
			$total_base_seq[$base]=$ix;
			$total_registros=(int)$total_registros+(int)$total;
		}
   		$Expresion_base_seq[$base]=urlencode($Expresion);
   		
	}

}

$_SESSION['primera_base']=$primera_base;

if (!isset($_REQUEST["mostrar_exp"])){
	// Inserts the search refinement option by opening the advanced form
	include_once $Web_Dir.'components/refine_search.php';
}


if (isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado" and isset($_REQUEST["integrada"]) and $_REQUEST["integrada"]!=""){
	$_REQUEST["integrada"]=urldecode($_REQUEST["integrada"]);
	$int_tot=explode('||',$_REQUEST["integrada"]);
	

	unset($total_base);

	$total_registros=0;
	foreach ($int_tot as $linea){
	
		$l=explode("$$",$linea);
		if ($l[1]>1)
		$total_base[$l[0]]=$l[1];
		$total_base_seq[$l[0]]=$l[1];
		$total_registros=(int)$total_registros+(int)$l[1];
		$Expresion_base_seq[$l[0]]=urlencode($_REQUEST["Expresion"]);

	}
}else{
	$_REQUEST["integrada"]=$integrada;
}

$_REQUEST["integrada"]=urlencode($_REQUEST["integrada"]);
$ix=0;
$contador=0;

if ($Expresion=='' and !isset($_REQUEST["coleccion"])) $Expresion='$';

include_once 'components/total_bases.php';

	if (isset($_REQUEST["facetas"]) and $_REQUEST["facetas"]!="") {
			$Expr_facetas=$_REQUEST["facetas"];
		}else{
			$Expr_facetas="";
		}
?>


	<form name="continuar" action="buscar_integrada.php" method="get">
		<input type="hidden" name="integrada" value="<?php echo $integrada;?>">
		<input type="hidden" name="existencias">
		<input type="hidden" name="facetas" value="<?php echo $Expr_facetas;?>">
	
	<?php
		if (isset($total_base) and count($total_base)>0 ){

			if (isset($total_fac[$base])){
				foreach ($total_fac as $key=>$val_fac) echo $key=$val_fac."<br>";
			}

			if ($_REQUEST["indice_base"]==1 or isset($_REQUEST["base"]) and $_REQUEST["base"]!=""){
				$base=$_REQUEST["base"];
			} else{
				$base=$primera_base;
			}
				$frm_sel=SelectFormato($base,$db_path,$msgstr);
				$select_formato=$frm_sel[0];
				$Formato=$frm_sel[1];

			$contador=PresentarRegistros($base,$db_path,$busqueda_decode[$base],$Formato,$count,$desde,$ix,$contador,$bd_list,$Expr_facetas);
			$desde=$desde+$count;

			if ($desde>=$contador and isset($total_base) and count($total_base)==2 and $multiplesBases=="N") {
				$desde=1;
				$_REQUEST["pagina"] =1 ;
				echo "<hr>";

				$contador=PresentarRegistros($base,$db_path,$busqueda_decode[$base],$Formato,$count,$desde,$ix,$contador,$bd_list,$Expr_facetas);

			}
			
		}

		echo '<input type="hidden" name="Expresion" value="'.urlencode($Expresion).'">';
		NavegarPaginas($contador,$count,$desde,$select_formato); 
	?>
		<input type="hidden" name="Campos" value="<?php if (isset($_REQUEST["Campos"])) echo $_REQUEST["Campos"];?>">
		<input type="hidden" name="Operadores" value="<?php if (isset($_REQUEST["Operadores"])) echo $_REQUEST["Operadores"];?>">
		<input type="hidden" name="Sub_Expresion" value="<?php if (isset($_REQUEST["Sub_Expresion"])) echo urlencode($_REQUEST["Sub_Expresion"]);?>">

	</form>


<?php
// Inserts the total results per database in the footer.


include_once 'components/total_bases_footer.php';


if ($Expresion!="" or isset($_REQUEST["facetas"]) and $_REQUEST["facetas"]!=""){
	if ((!isset($total_base) or count($total_base)==0) ){
		echo "<div style='border: 1px solid;width: 98%; margin:0 auto;text-align:center'>";
		echo "<p><br> <font color=red>".$msgstr["front_no_rf"]."</font>";

		if (isset($_REQUEST["coleccion"]) and $_REQUEST["coleccion"]!=""){
			echo " ". $msgstr["en"]." ";
			$cc=explode('|',$_REQUEST["coleccion"]);
			echo "<strong>".$cc[1]."</strong><br>";

		}else{
			if (isset($_REQUEST["base"]) and $_REQUEST["base"]!="")echo " <strong>".$bd_list[$_REQUEST["base"]]["titulo"]."</strong>";
		}
		echo "<br>".$msgstr["front_p_refine"];

		echo "</div>\n";
	}
}

if (isset($_REQUEST["db_path"]))  echo "<input type=hidden name=db_path value=".$_REQUEST["db_path"].">\n";
echo "</form>";

include_once ('components/facets.php');


if (!isset($_REQUEST["base"])) $base="";

$Exp_b=PresentarExpresion($_REQUEST["base"]);

if ((!isset($_REQUEST["resaltar"]) or $_REQUEST["resaltar"]=="S")) {
    $Expresion=str_replace('"',"",$Exp_b);
?>	
	<script language="JavaScript">
		highlightSearchTerms("<?php echo $Expresion;?>");
		console.log("<?php echo $Expresion;?>");
	</script>

<?php 
} 

include("views/footer.php");

?>

	<script>
		WEBRESERVATION="<?php if (isset($WebReservation)) echo $WebReservation; ?>"
	</script>

