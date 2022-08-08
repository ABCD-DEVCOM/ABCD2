<?php
/*
20220112 fh04abcd line-ends+improved html+layout like in alfa (buttons,letters left)+removed duplicates from output
20220131 fh04abcd Removed duplicates from output (better)
20220711 fho4abcd Use $actparfolder as location for .par files
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");

if (!isset($_REQUEST["base"]) or $_REQUEST["base"]==""){
	$arrHttp["base"]=$_REQUEST["baseactiva"];
	$arrHttp["cipar"]=$arrHttp["base"].".par";
}
include ("../config.php");

// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

$arrHttp["lang"]=$_SESSION["lang"];
include("../lang/admin.php");
include ("../common/header_display.php");

?>
<body LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" onunload=CloseWindows() onsubmit="javascript: return false">
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["indicede"].": ".urldecode($arrHttp["Tag"])?>
    </div>
    <div class="actions">
    </div>
<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="formContent" style="padding:5">

<?php 
//foreach ($arrHttp as $var => $value )	echo "$var = $value<br>";
$primeravez="";
if (!isset($arrHttp["pref"])) $arrHttp["pref"]=$arrHttp["prefijo"];
/*
if (!isset($arrHttp["baseactiva"])){
	$primeravez="S";
	$arrHttp["baseactiva"]=$arrHttp["base"];
	$arrHttp["ba_formato"]=$arrHttp["Formato"];
	$arrHttp["pref"]=$arrHttp["prefijo"];
}*/
//READ FILE WITH TESAURIS DEFINITION
if (isset($arrHttp["baseactiva"])){
	$tesaurus=$db_path.$arrHttp["baseactiva"]."/def/".$_SESSION["lang"]."/tesaurus.def";
	unset($tesau);
	if (!file_exists($tesaurus)){
		$tesaurus=$db_path.$arrHttp["baseactiva"]."/def/".$lang_db."/tesaurus.def";
	}
	if (file_exists($tesaurus)){
		$tesau=parse_ini_file($tesaurus,1);
	}
}
if (isset($arrHttp["tesauro"])){
	$arrHttp["base"]=$arrHttp["tesauro"];
	$arrHttp["cipar"]=$arrHttp["tesauro"].".par";
	$arrHttp["Formato"]=$tesau[$arrHttp["base"]][$arrHttp["index"]."_pft"];
	if (!isset($arrHttp["prefijo"]) || $arrHttp["prefijo"]=="**"){
		$arrHttp["prefijo"]=$tesau[$arrHttp["base"]][$arrHttp["index"]."_pref"];
	}
	$arrHttp["pref"]=$tesau[$arrHttp["base"]][$arrHttp["index"]."_pref"];
}else{
   if (!isset($arrHttp["prefijo"]) || $arrHttp["prefijo"]=="**"){
   		if (!isset($arrHttp["ba_prefijo"])) $arrHttp["ba_prefijo"]="";
   		if (!isset($arrHttp["ba_pref"])) $arrHttp["ba_pref"]="";
		$arrHttp["prefijo"]=$arrHttp["ba_prefijo"];
		$arrHttp["pref"] =$arrHttp["ba_pref"];
	}
}


if (!isset($arrHttp["subc"])) $arrHttp["subc"]="";

if (!isset($arrHttp["tagfst"])) $arrHttp["tagfst"]="";
if (!isset($arrHttp["delimitador"])) $arrHttp["delimitador"]="";
if (!isset($arrHttp["separa"])) $arrHttp["separa"]="";
if (!isset($arrHttp["postings"])) $arrHttp["postings"]="ALL";
$arrHttp["Formato"]=stripslashes($arrHttp["Formato"]);
if (substr($arrHttp["Formato"],0,1)=="@"){
    $Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".substr($arrHttp["Formato"],1);
    if (!file_exists($Formato))
        $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".substr($arrHttp["Formato"],1);
    $Formato="@".$Formato;
}else
    $Formato=",".$arrHttp["Formato"].",";
$Prefijo=$arrHttp["prefijo"];
$Pref=$arrHttp["pref"];
$ver="";
if ($cisis_ver=="unicode/"){
    $Prefijo=utf8_encode($Prefijo);
    $Pref=utf8_encode($Pref);
    $ver="&cisis_ver=".$cisis_ver;
}

$query ="&base=".$arrHttp["base"] ."&cipar=$db_path".$actparfolder.$arrHttp["cipar"]."&autoridades=S&Opcion=autoridades"."&tagfst=".$arrHttp["tagfst"];
$query.="&prefijo=".urlencode($Prefijo)."&pref=".urlencode($Pref)."&postings=".$arrHttp["postings"]."&formato_e=".urlencode($Formato).$ver;
//echo "query=".$query."<br>";
//echo "unencoded Formato&rarr;".$Formato."&larr;, length=".strlen($Formato)."<br>";
$IsisScript=$xWxis."ifp_slashm.xis";
include("../common/wxis_llamar.php");
//foreach ($contenido as $value) echo $value."<br>";
$contenido = array_unique ($contenido);

?>
<script>
msg_pv=""
<?php
if (!isset($arrHttp["subcampos"])) $arrHttp["subcampos"]="";
if (!isset($arrHttp["delimitador"])) $arrHttp["delimitador"]="";
if (!isset($arrHttp["separa"])) $arrHttp["separa"]="";
if (!isset($arrHttp["repetible"])) $arrHttp["repetible"]="";
echo "subC=\"".$arrHttp["subcampos"]."\"\n";
echo "Repetible=\"".$arrHttp["repetible"]."\"\n";
echo "Tag=\"".$arrHttp["Tag"]."\"\n";
echo "Delimitador=\"".$arrHttp["delimitador"]."\"\n";
echo "Prefijo=\"".$arrHttp["prefijo"]."\"\n";
echo "Separa=\"".$arrHttp["separa"]."\"\n";
echo "Pref='".$arrHttp["pref"]."'\n";
if (isset($arrHttp["indice"]))
    echo "Indice=\"".$arrHttp["indice"]."\"\n";
else
    echo "Indice='N'\n";

?>
	if (Repetible=='R'){
	 	if (Delimitador.substr(1,1)==' '|| Delimitador==''){
	      	Delimitador="\r"
	  	}else{
			Delimitador=Delimitador.substr(1,1)
		}
	}else{
		Delimitador=''
	}
	Var=eval("window.opener.document.forma1."+Tag)
 	VarOriginal=Var
	if (Var.length>1)Var=eval(Var[Indice])
	a=Var.type
	a=a.toUpperCase()
	if (a=="TEXTAREA") Separa="\r"

	function CopyTerm(Term){
		Var=eval("window.opener.document.forma1."+Tag)
		if (Var.type=="text")
			Separa=";"
		else
			Separa=Delimitador
		a=Var.value
		if (a=="" || Repetible!="R"){
			Var.value=Term
		}else{
			Var.value=a+Separa+Term
		}
		a=Var.value
		if (Var.type=="textarea") {
			b=a.split("\n")
			if(b.length>Var.rows) Var.rows=b.length+1

		}
	}
    selected=""

    function ObtenerTerminos(){
		index="<?php if (isset($arrHttp["index"])) echo $arrHttp["index"]?>"
		if (index=="jerar") document.Lista.preview.checked=true
		Seleccion=""
		Pref="<?php echo $arrHttp["prefijo"]?>"

		Var=eval("window.opener.document.forma1."+Tag)
		if (Var.type=="text")
			Separa=";"
		else
			Separa=Delimitador

		for (i=0;i<document.Lista.autoridades.options.length; i++){
			if (document.Lista.autoridades.options[i].selected){
				optval=document.Lista.autoridades.options[i].text
				term=document.Lista.autoridades.options[i].value
				if (term=="") term=optval
				// si se llama desde la plantilla de subcampos, se elimina el primer subcampo
				if (Indice!="N"){
					if (term.substring(0,1)=="^")
						term=term.substring(2)
				}
				tt='$$'+term+'$$'
				if (Repetible!="R"){     //   NON REPETEABLE FIELD
					Seleccion=term
				}else{
					if (selected.indexOf(tt)==-1){
						if (Seleccion==""){  //EMPTY BOX
							Seleccion=term
						}else{
							Seleccion+=Separa+term
						}
						selected+=tt
					}
				}
			}
		}
		if (Seleccion=="") return
        if (document.Lista.preview.checked){
        	msg_pv="Y"
        	if (index=="jerar"){
        		optval=term;
        	}
        	url="base=<?php echo $arrHttp["base"]?>&Expresion="+escape(Pref+optval)+"&Opcion=buscar"
        	<?php
        	if (isset($arrHttp["tesauro"]))
        		echo "script_name='tesauro_show.php'\n";
        	else
        		echo "script_name='show.php'\n";
            
        	?>
        	msgwin_preview=window.open(script_name+"?"+url,"preview","width=400, height=400,resizable,scrollbars,status")
			msgwin_preview.focus()
			return
		}


		VarOriginal=Var.value
		ss=Seleccion.split("^")
		nn=Var.name.split("_")
        if (Seleccion.indexOf('^')==-1 && Seleccion.substr(0,4)!="_TAG"){
        	a=Var.value
			if (a=="" || Repetible!="R"){
				Var.value=Seleccion
			}else{

				Var.value=a+Separa+Seleccion
				a=Var.value

				if (Var.type=="textarea") {
					b=a.split("\n")
					if(b.length>Var.rows) Var.rows=b.length
				}
			}
        }else{
			if (subC.length>0 ){
				if (Seleccion.substr(0,1)!="^")
					Seleccion="^"+subC.substr(0,1)+Seleccion
				for (jsc=0;jsc<subC.length;jsc++){
					Ctrl=eval("window.opener.document.forma1."+nn[0]+"_"+nn[1]+"_"+subC.substr(jsc,1))
					ixpos=Seleccion.indexOf("^"+subC.substr(jsc,1))
					if (ixpos>=0){
						cc=Seleccion.substr(ixpos+2)
						ixpos=cc.indexOf("^")
						if (ixpos>0) cc=cc.substr(0,ixpos)
						switch (Ctrl.type){
							case "text":
								Ctrl.value=cc
								break
							case "select-one":
							    selI=-1
								for (i=0;i<Ctrl.options.length;i++){
									if (Ctrl.options[i].value==cc){
										selI=i
									}
								}
								Ctrl.options.selectedIndex=selI
								break
						}

						Ctrl.value=cc
					}else{
						Ctrl.value=""
					}
				}
			}else{
				if (Seleccion.substr(0,4)=="_TAG"){
					CopyToFields(Seleccion)
					self.close()
					return
				}
				if (Var.type=="textarea" || Var.type=="text"){
					if (Seleccion!=""){
						a=Var.value
						if (a=="" || Repetible!="R"){
							Var.value=Seleccion
						}else{
							Var.value=a+Separa+Seleccion
						}
					}

				}
				a=Var.value

				if (Var.type=="textarea") {
					b=a.split("\n")

					if(b.length>Var.rows) Var.rows=b.length

				}
			}
		}
		if (Var.type!="textarea") self.close()
	}

function CopyToFields(Seleccion){
	t=Seleccion.split('_TAG');
	for (ix=1;ix<t.length;ix++){
		val=t[ix].split(':')
		Ctrl=eval("window.opener.document.forma1.tag"+val[0])
		Ctrl.value=val[1]
	}
}

function Continuar(){
	i=document.Lista.autoridades.length-1
    a=' '
    if (i>1) {
        i--
        a=document.Lista.autoridades[i].text
    }
	AbrirIndice(a)
}

function IrA(ixj){
	a=document.Lista.ira.value

	AbrirIndice(a)
}

function CloseWindows(){
	if (msg_pv=="Y"){
		msgwin_preview.close()
	}
}
/*
function AbrirTesauro(Tes,Index){
	if (Tes=="<?php echo $arrHttp["baseactiva"]?>"){

        document.Lista.baseactiva.value=""
        document.Lista.tesauro.value=""
        document.Lista.base.value="<?php echo $arrHttp["baseactiva"]?>"
        document.Lista.Formato.value="<?php if (isset($arrHttp["ba_Formato"])) echo $arrHttp["ba_Formato"]?>"
        document.Lista.pref.value="<?php if (isset($arrHttp["ba_pref"]))  echo $arrHttp["ba_pref"]?>"
        document.Lista.pref.value="<?php if (isset($arrHttp["ba_prefijo"])) echo $arrHttp["ba_prefijo"]?>"
	}else{
		document.Lista.tesauro.value=Tes

		document.Lista.pref.value=""
	}
	document.Lista.index.value=Index
	document.Lista.prefijo.value="**"
	document.Lista.submit()
}
*/
<?php
echo "function AbrirIndice(Termino){
		Prefijo='".$arrHttp["pref"]."'+Termino
		Pref='".$arrHttp["pref"]."'
		document.Lista.base.value='".$arrHttp["base"]."'		
		document.Lista.cipar.value='".$arrHttp["cipar"]."'		
		document.Lista.prefijo.value=Prefijo
		document.Lista.pref.value=Pref
		document.Lista.submit()
	}

function AgregarRegistro(){
	msgwin=window.open(\"\",\"agregar_r\",\"width=800, height=400, resizable, scrollbars\")
	document.agregar_r.submit()
	msgwin.focus()
	self.close()
}

function ImprimirDiccionario(){
	if (confirm('".$msgstr["print_diccio"]."')){
		msgwin=window.open(\"preloader.php\",\"print\",\"width=800, height=400, resizable, scrollbars, menubar=yes,toolbar=yes\")
		msgwin.focus()
		document.Lista.action=\"print_dictionary.php\";
		document.Lista.base.value='".$arrHttp["base"]."'
	 	document.Lista.Formato.value='".$arrHttp["Formato"]."'
	  	document.Lista.pref.value='".$arrHttp["pref"]."'
	    document.Lista.prefijo.value='".$arrHttp["prefijo"]."'
	    document.Lista.target=\"print\"
		document.Lista.submit()
	}


}
</script>\n";
if (isset($arrHttp["width"])){
	$width=$arrHttp["width"];
}else{
	$width=600;
}
?>
<div><b><?php echo $msgstr["termsdict"]?>: &nbsp;
<?php
if (!isset($tesau[$arrHttp["base"]]["name"])){
    if (isset($arrHttp["baseactiva"]))
        if ($arrHttp["baseactiva"]!=$arrHttp["base"]) echo $arrHttp["base"]." - ";
}else{
    echo $tesau[$arrHttp["base"]]["name"]." - ";
}
echo  " ".$msgstr["bd"];
if (isset($arrHttp["baseactiva"]))
    echo ": ".$arrHttp["baseactiva"];
?>
</b></div>
<div style='font-size:10px'><?php echo $msgstr["ayudaterminos"]?></div>
<form method=post name=Lista onSubmit="javascript:return false">
<table cellpadding=0 cellspacing=0 border=0 width=90%>
<tr>
<td  width=5% align=center style='font-size:10px'>
    <?php for ($i=65;$i<91;$i++ ){?>
    <a href="javascript:AbrirIndice('<?php echo chr($i)?>')"><?php echo chr($i)?></a><br>
    <?php } ?>
</td>

<?php
if (!isset($arrHttp["index"])) $arrHttp["index"]="";
switch($arrHttp["index"]){

	case "permu":
		foreach ($contenido as $linea)  {

			$linea=trim($linea);
			$ix=strpos($linea," ");
			$permuta=substr($linea,0,$ix);
			$permuta=substr($permuta,4);
			$permuta=trim($permuta);
			if (strlen($permuta)>1){
				$termino=trim(substr($linea,$ix));
				$ix=strpos($termino,$permuta);
				if ($ix==0){
					$parte1="&nbsp;";
					$parte2=$termino;
				}else{
					$parte1=substr($termino,0,$ix)."&nbsp;";
					$parte2=substr($termino,$ix);
				}
				echo "<tr><td align=right bgcolor=white><font size=1>".$parte1." </td><td bgcolor=white><font size=1>".$parte2."</td>";
			}
		}
		echo "</table>";
		break;
	default:
		echo "<td width=95% valign=top>";
		echo "
			<Select name=autoridades multiple size=22 style=\"width:".$width."px\" onclick=javascript:ObtenerTerminos()>\n";
        $f0_prev="";
		foreach ($contenido as $linea){
            // format is extrahandbooks$$$extrahandbooks###SE_HANDBOOKS%%%1
			if (trim($linea)!=""){
				$ll=explode('###',$linea);
				$pp=explode('%%%',$ll[1]);
				$f=explode('$$$',$ll[0]);
				if (isset($f[2])) $f[1]=$f[2];
				if (!isset($f[1])) $f[1]=$f[0];
				if (substr($f[0],0,1)=="^") $f[0]=substr($f[0],2);
				if (strlen($f[0])>60-strlen($arrHttp["prefijo"]) and $pp[1]>1){
					BuscarClavesLargas($ll[1]);
				}else if ($f[0]!="" && $f[0]!=$f0_prev){
					echo "<option value=\"";
					echo trim($f[1]);
					echo "\"";
					echo " title=\"".trim($f[1])."\"";
					echo ">";
			        echo trim($f[0]);
			        echo "</option>\n";
                    $f0_prev=$f[0];
                }
            }
		}
		echo "</select></td>";
		break;
}

?>


</table>
<table cellpadding=0 cellspacing=0 border=0 width=100% >
    <tr>
    <td colspan=2><!--full width required to avoid wrap in all languages-->
        <a href="javascript:AbrirIndice(' ')" class="bt bt-gray" title='<?php echo $msgstr["src_top"]?>'>
             <i class="fas fa-chevron-circle-up"></i> 
        </a>
        <a href="javascript:Continuar()" class="bt bt-gray" title='<?php echo $msgstr["masterms"]?>'>
             <i class="fas fa-chevron-circle-down"></i>
        </a>
        &nbsp;
        <?php echo $msgstr["avanzara"]?>
        <input type=text name=ira size=5 value="" onKeyPress="codes(event)" title="<?php echo $msgstr["src_advance"];?>">
        <a href=Javascript:IrA() class="bt bt-gray" title='<?php echo $msgstr["src_enter"]?>'>
            <i class="fas fa-angle-right"></i></a>
    </td>
    </tr>
</table>
<table bgcolor=#cccccc  cellpadding=0 cellspacing=0 width=100%>
    <tr>
        <td>&nbsp;<input type=checkbox name=preview> <?php echo $msgstr["vistap"]?></td>
        <td>&nbsp; &nbsp;
        <a href="javascript:ImprimirDiccionario()" class="bt bt-gray"  title="<?php echo $msgstr["print_dict"]?>" >
            <i class="fas fa-print"></i></a>
        </td>
    </tr>		

<?php
if (isset($arrHttp["baseactiva"]) and $arrHttp["baseactiva"]!=$arrHttp["base"]){
	$baseactiva=$arrHttp["baseactiva"];
	if (isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or  isset($_SESSION["permiso"][$baseactiva."_CENTRAL_ALL"])  or  isset($_SESSION["permiso"][$baseactiva."_ACTPICKLIST"])){
		echo "<td><a href=javascript:AgregarRegistro()><img src=img/db_add.png border=0 alt='".$msgstr["m_crear"]."' title='".$msgstr["m_crear"]."' border=0></a></td>";
	}
}
?>
<?php
if (isset($tesau)) {
	if (isset($arrHttp["baseactiva"]) and isset($tesau)){
	    echo "<td><a href=\"javascript:AbrirTesauro('".$arrHttp["baseactiva"]."')\">".$msgstr["bd"]." ".$arrHttp["baseactiva"]."</a></td>";
	}
	foreach ($tesau as $key=>$value){
		$name_t=$key;
		echo "</center><br>".$tesau[$key]["name"].": <a href=\"javascript:AbrirTesauro('$key','alpha')\">".$msgstr["alfabet"]."</a>&nbsp; &nbsp;";
		if (isset($tesau[$key]["permu_pref"])) echo  " | <a href=\"javascript:AbrirTesauro('$key','permu')\">".$msgstr["permutado"]."</a>&nbsp; &nbsp;";
		if (isset($tesau[$key]["jerar_pref"])) echo  " | <a href=\"javascript:AbrirTesauro('$key','jerar')\">".$msgstr["jerarq"]."</a>&nbsp; &nbsp;";
	}
}
?>
</table>
<?php
	echo "<input type=hidden name=baseactiva value=\"";
	if (isset($arrHttp["baseactiva"])) echo $arrHttp["baseactiva"];
	echo "\">\n";
if ($primeravez=="S") {
	echo "<input type=hidden name=ba_Formato value='".$arrHttp["Formato"]."'>\n";
	echo "<input type=hidden name=ba_Tag value=".$arrHttp["Tag"].">\n";
	echo "<input type=hidden name=ba_pref value=".$arrHttp["pref"].">\n";
	echo "<input type=hidden name=ba_prefijo value=".$arrHttp["prefijo"].">\n";
	echo "<input type=hidden name=ba_repetible value=".$arrHttp["repetible"].">\n";
}else{
	if (isset($arrHttp["ba_formato"]))   echo "<input type=hidden name=ba_formato value=".$arrHttp["ba_formato"].">\n";
	if (isset($arrHttp["ba_Tag"]))       echo "<input type=hidden name=ba_Tag value=".$arrHttp["ba_Tag"].">\n";
	if (isset($arrHttp["ba_pref"]))      echo "<input type=hidden name=ba_pref value=".$arrHttp["ba_pref"].">\n";
	if (isset($arrHttp["ba_prefijo"]))   echo "<input type=hidden name=ba_prefijo value=".$arrHttp["ba_prefijo"].">\n";
	if (isset($arrHttp["ba_repetible"])) echo "<input type=hidden name=ba_repetible value=".$arrHttp["ba_repetible"].">\n";
}
?>
<input type=hidden name=base>
<input type=hidden name=cipar>
<input type=hidden name=Formato value='<?php echo $arrHttp["Formato"]?>'>
<input type=hidden name=Tag value='<?php echo $arrHttp["Tag"]?>'>
<input type=hidden name=pref value='<?php echo $arrHttp["pref"]?>'>
<input type=hidden name=prefijo value='<?php echo $arrHttp["prefijo"]?>'>
<input type=hidden name=repetible value='<?php echo $arrHttp["repetible"]?>'>
<input type=hidden name=postings value='<?php echo $arrHttp["postings"]?>'>
<input type=hidden name=index value='<?php if (isset($arrHttp["index"])) echo $arrHttp["index"]?>'>
<?php
if (isset($arrHttp["tesauro"])){
	echo "<input type=hidden name=tesauro value=".$arrHttp["tesauro"].">\n";
}else{
	echo "<input type=hidden name=tesauro>\n";
}
?>

</form>
<?php
if (isset($arrHttp["baseactiva"])){
	echo "<form name=agregar_r method=post action=fmt.php target=agregar_r>\n";
	echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";
	echo "<input type=hidden name=cipar value=".$arrHttp["base"].".par>\n";
	echo "<input type=hidden name=Opcion value=nuevo>\n";
	echo "<input type=hidden name=Mfn value=New>\n";
	echo "<input type=hidden name=ver value=N>\n";
	echo "<input type=hidden name=formato value='".$arrHttp["base"]."'>\n";
    echo "<input type=hidden name=desde value=autoridades>\n";
    echo "<input type=hidden name=ventana value=s>\n";
}
?>
</form>
</div>
</body></html>
<?php
//=============  Functions ===============
function BuscarClavesLargas($Termino){
global $arrHttp,$Formato,$xWxis,$Wxis,$wxisUrl,$db_path,$actparfolder;

	$Termino=str_replace($arrHttp["pref"],"",$Termino);
	$Termino=urlencode($Termino);
	$contenido="";
	$query = "&base=".$arrHttp["base"] ."&cipar=$db_path".$actparfolder.$arrHttp["cipar"]."&autoridades=S&Opcion=autoridades";
    $query.= "&tagfst=".substr($arrHttp["tagfst"],3);
    $query.= "&prefijo=".strtoupper($arrHttp["pref"]).$Termino;
    $query.= "&to=".strtoupper($arrHttp["pref"]).$Termino."ZZ";
    $query.= "&pref=".strtoupper($arrHttp["pref"]);
    $query.= "&postings=ALL";
    $query.= "&formato_e=".urlencode($Formato);
	$IsisScript=$xWxis."ifp_slashm.xis";
	include("../common/wxis_llamar.php");
	$cont = array_unique ($contenido);
    $f0_prev="";
	foreach ($cont as $linea ){
		if (trim($linea)!=""){
			$ll=explode('###',$linea);
			$f=explode('$$$',$ll[0]);
			if (isset($f[2])) $f[1]=$f[2];
			if (!isset($f[1])) $f[1]=$f[0];
			if (substr($f[0],0,1)=="^") $f[0]=substr($f[0],2);
			if ($f[0]!="" && $f[0]!=$f0_prev){
                echo "<option value=\"";
                echo $f[1];
                echo "\"";
                echo " title=\"".$f[1]."\"";
                echo ">";
                echo $f[0];
                echo "</option>";
                $f0_prev=$f[0];
            }
        }
	}
}



