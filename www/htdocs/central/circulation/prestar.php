<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      prestar.php
 * @desc:      Ask for the inventory number and the user code for processing a loan
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
$arrHttp["base"]="users";
include("../config.php");
include("../lang/admin.php");
include("../lang/prestamo.php");
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>"; //die;
include("../common/header.php");

function LeerPft($pft_name,$base){
global $arrHttp,$db_path,$lang_db;
	$pft="";
	$archivo=$db_path.$base."/loans/".$_SESSION["lang"]."/$pft_name";
	if (!file_exists($archivo)) $archivo=$db_path.$base."/loans/".$lang_db."/$pft_name";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$pft.=$value;
		}
	}
    return $pft;
}

function LeerNumeroClasificacion($base){
global $db_path,$lang_db,$prefix_nc,$prefix_in;
	$prefix_nc="";
	$archivo=$db_path.$base."/loans/".$_SESSION["lang"]."/loans_conf.tab";
	if (!file_exists($archivo)) $archivo=$db_path.$base."/loans/".$lang_db."/loans_conf.tab";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$ix=strpos($value," ");
			$tag=trim(substr($value,0,$ix));
			switch($tag){
				case "IN": $prefix_in=trim(substr($value,$ix));
					break;
				case "NC":
					$prefix_nc=trim(substr($value,$ix));
					break;
			}
		}
	}
}
if (file_exists($db_path."loans.dat"))
	echo "<script>search_in='IN='\n";
else
    echo "<script>search_in=''\n";
echo "</script>\n";

?>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<!-- calendar stylesheet -->
  <link rel="stylesheet" type="text/css" media="all" href="/assets/calendar/calendar-win2k-cold-1.css" title="win2k-cold-1" />
  <!-- main calendar program -->
  <script  language="JavaScript" type="text/javascript" src="/assets/calendar/calendar.js"></script>
  <!-- language for the calendar -->
  <script  language="JavaScript" type="text/javascript" src="/assets/calendar/lang/calendar-<?php echo $_SESSION["lang"]?>.js"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes
       adding a calendar a matter of 1 or 2 lines of code. -->
  <script language="JavaScript" type="text/javascript" src="/assets/calendar/calendar-setup.js"></script>
<script>
kardex=""

function ValidarFecha(){
	msg=""
	valor=Trim(document.inventorysearch.date.value)
	if (valor!=""){
		var expreg = /^(\d{4})([0][1-9]|[1][0-2])([0][1-9]|[12][0-9]|3[01])$/;
   		if (!expreg.test(valor) )  {
            msg="<?php echo $msgstr["js_inv_dateformat"]?>"
        }else{
   			var today = "<?php echo date("Ymd")?>";
   			if (valor<today) msg="<?php echo $msgstr["js_inv_date"]?>"
   		}
   		if(msg!=""){
   			alert(msg)
   			return false
   		}
	}
	return true
}

function DateToIso(From,To){
		if (Trim(From)=="") {
			To.value=""
			return
		}
        d=new Array()
		d[0]=""
		d[1]=""
		d[2]=""
        if (From.indexOf('-')>1){
			d=From.split('-')
		}else{
			if (From.indexOf('/')>1){
				d=From.split('/')
			}else{
				iso=From
				return
			}
		}
		<?php echo "dateformat=\"$config_date_format\"\n" ?>

		if (dateformat=="d/m/Y"){
			iso=d[2]+d[1]+d[0]
		}else{
			iso=d[2]+d[0]+d[1]
		}
		To.value=iso
	}


function CambiarBase(){
	bd_sel=document.inventorysearch.db_inven.selectedIndex
	bd_a=document.inventorysearch.db_inven.options[bd_sel].value
	b=bd_a.split('|')
	kardex=b[5].toUpperCase()
	if (kardex=="KARDEX"){
       document.getElementById('kardex').style.visibility = 'visible';
       document.getElementById('kardex').style.display = 'block';
	}else{
       document.getElementById('kardex').style.visibility = 'none';
       document.getElementById('kardex').style.display = 'none';
	}
}

function EnviarForma(){
	if (ASK_LPN=="Y"){
		ret=ValidarFecha()
		if (ret==false)
			return
	}
	loan_policy="<?php echo $LOAN_POLICY?>"
	if (Trim(document.inventorysearch.inventory_sel.value)=="" || Trim(document.inventorysearch.usuario.value)=="" ){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["inventory"]." / ".$msgstr["usercode"]?>")
		return
	}
	if (kardex=="KARDEX"){
		if (Trim(document.inventorysearch.year.value)=="" || Trim(document.inventorysearch.numero.value)=="" ){
			alert("Debe especificar el a�o, el n�mero y opcionalmente el volumen")
			return
		}
	}
    INV=escape(document.inventorysearch.inventory_sel.value)
    if (loan_policy=="BY_USER")
    	document.inventorysearch.action="ask_policy.php"
    document.inventorysearch.inventory.value=INV
    document.inventorysearch.submit()
}

function AbrirIndiceAlfabetico(xI,Prefijo,Subc,Separa,db,cipar,tag,postings,Repetible,Formato){
		Ctrl_activo=xI
		lang="en"
	    Separa="&delimitador="+Separa
	    library=""
		<?php if (isset($_SESSION["library"]))  echo "library='".$_SESSION["library"]."_'\n";?>
	    Prefijo=Separa+"&tagfst="+tag+"&prefijo="+Prefijo+library
	    ancho=200
		url_indice="capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&Tag="+tag+Prefijo+"&postings="+postings+"&lang="+lang+"&repetible="+Repetible+"&Formato="+Formato
		msgwin=window.open(url_indice,"Indice","width=480, height=425,left=200,scrollbars")
		msgwin.focus()
}

function AbrirIndice(Tipo,xI){
	Ctrl_activo=xI
	lang="<?php echo $_SESSION["lang"]?>"
	library=""
	<?php if (isset($_SESSION["library"]))  echo "library='_".$_SESSION["library"]."'\n";?>
	<?php if (isset($LOAN_POLICY) and $LOAN_POLICY=="BY_USER")
    				echo "Repetible=0\n";
    	              else
    	            echo "Repetible=1\n";
 	?>
	switch (Tipo){

		case "S":
			bd_sel=document.inventorysearch.db_inven.selectedIndex
			if (bd_sel<=0){
				alert("debe seleccionar una base de datos")
				return
			}
			bd_a=document.inventorysearch.db_inven.options[bd_sel].value
			b=bd_a.split('|')
			bd=b[0]
			switch (bd){
				case "loanobjects":
					Separa=""
					ancho=200
					if (search_in==""){
		    			Prefijo=Separa+"&prefijo=IN_"
						url_indice="capturaclaves.php?opcion=autoridades&base=loanobjects&cipar=loanobjects.par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible=0&Formato=@autoridades.pft"
					}else{
						ix=document.inventorysearch.db_inven.selectedIndex
						sel=document.inventorysearch.db_inven.options[ix].value
						s=sel.split('|')
						bd=s[0]
						pref="IN_"
						Prefijo=Separa+"&prefijo="
						url_indice="capturaclaves.php?opcion=autoridades&base="+bd+"&cipar="+bd+".par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible="+Repetible+"&Formato=@autoridades.pft"
					}
					break;
				default:

					prefijo=b[2]
					formato=b[3]
					AbrirIndiceAlfabetico(xI,prefijo,"","",bd,bd+".par","3",1,Repetible,formato)
					break
			}
			break
		case "I":
			Separa=""
			ancho=200

			if (search_in==""){
    			Prefijo=Separa+"&prefijo=IN_"

				url_indice="capturaclaves.php?opcion=autoridades&base=loanobjects&cipar=loanobjects.par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible="+Repetible+"&Formato=@autoridades.pft"
			}else{
				ix=document.inventorysearch.db_inven.selectedIndex
				sel=document.inventorysearch.db_inven.options[ix].value
				s=sel.split('|')
				bd=s[0]
				pref="IN_"+pref
				Prefijo=Separa+"&prefijo="+pref
				url_indice="capturaclaves.php?opcion=autoridades&base="+bd+"&cipar="+bd+".par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible="+Repetible+"&Formato=@autoridades.pft"
			}
			break
		case "U":
<?php
// The prefix and format are read to extract the user code.
// O prefixo e o formato são lidos para extrair o código do usuário.

			$us_tab=LeerPft("loans_uskey.tab","users");
			$t=explode("\n",$us_tab);
			$codigo=LeerPft("loans_uskey.pft","users");
?>
			Separa=""
			Formato="<?php if (isset($t[2]))  echo trim($t[2]); else echo 'v30';?>,`$$$`,<?php echo str_replace("'","`",trim($codigo))?>"
    		Prefijo=Separa+"&prefijo=<?php if (isset($t[1])) echo trim($t[1]); else echo 'NO_';?>"
    		ancho=200
			url_indice="capturaclaves.php?opcion=autoridades&base=users&cipar=users.par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible=0&Formato="+Formato
			break
	}
	msgwin=window.open(url_indice,"Indice","width=480, height=450,left=300,scrollbars")
	msgwin.focus()
}
ASK_LPN="<?php echo $ASK_LPN?>"

</script>

<?php
$encabezado="";

echo "<body onLoad=javascript:document.inventorysearch.inventory_sel.focus()>\n";

include("../common/institutional_info.php");
$link_u="";
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") $link_u="&usuario=".$arrHttp["usuario"];
?>

<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["loan"]." ";
		  if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") echo " - ".$msgstr["users"].": ".$arrHttp["usuario"];
		?>
	</div>
	<?php include("submenu_prestamo.php");?>
	<div class="actions">
	</div>
</div>

<?php
$ayuda="loan.html";
include "../common/inc_div-helper.php";
?>

<div class="middle list">
	<div class="formContent">

<form name="inventorysearch" action="usuario_prestamos_presentar.php" method="post" onsubmit="javascript:return false">
	<input type="hidden" name="loan_policy" value="<?php echo $LOAN_POLICY;?>">
	<input type="hidden" name="Opcion" value="prestar">
	<input type="hidden" name="lang" value="<?php echo $lang;?>">
	<input type="hidden" name="inventory">

	<div class="searchBox">


<?php
//Read bases.dat to find the databases connected with the circulation module, if not, working with copies databases

$sel_base="N";
if (file_exists($db_path."loans.dat")){
	$fp=file($db_path."loans.dat");
	$sel_base="S";
?>
		<label for="dataBases"><?php echo $msgstr["basedatos"]?></label>
		<select name="db_inven" onchange="CambiarBase()">
		<option></option>
<?php
	$xselected=" selected";
	$cuenta=0;
	foreach ($fp as $value){
		if (trim($value)!=""){
			$cuenta=$cuenta+1;
			$value=trim($value);
			$v=explode('|',$value);
			//SE LEE EL PREFIJO PARA OBTENER EL NUMERO DE INVENTARIO DE LA BASE DE DATOS
			$value=$v[0].'|'.$v[1];
			LeerNumeroClasificacion($v[0]);
			$pft_ni=LeerPft("loans_inventorynumber.pft",$v[0]);

			$signa=LeerPft("loans_cn.pft",$v[0]);
            if (isset($_SESSION["library"])) $prefix_in=$prefix_in;
			$value.="|".$prefix_in."|ifp|".urlencode($signa);
			$value.='|';
			if (isset($v[2])){
				$value.=$v[2];
			}

			if (isset($_SESSION["loans_dbinven"])){

				if ($_SESSION["loans_dbinven"]==$v[0])
					$xselected=" selected";
				else
					$xselected="";
			}
			echo "<option value='$value' $xselected>".$v[1]."</option>\n";
			$xselected="";
		}
	}

?>
		</select>

	</div>

<?php }?>

	<div class="searchBox">
		<label for="searchExpr"><?php echo $msgstr["inventory"]?></label><br>
		<?php 
		if (isset($LOAN_POLICY) and $LOAN_POLICY=="BY_USER"  ){
			echo "<input type=text name=\"inventory_sel\" id=\"inventory_sel\" value=\"";
			if (isset($arrHttp["inventory_sel"])) echo $arrHttp["inventory_sel"];
				echo ">\n";
			  }else{
			?>	
				<textarea name="inventory_sel" id="inventory_sel" rows="5" class="w-2"></textarea>
	 		<?php  
			}
			?>
	    <input type="button" name="list" value="<?php echo $msgstr["list"]?>" class="bt bt-block w-2 bt-blue" onclick="javascript:AbrirIndice('<?php if ($sel_base=="S") echo "S"; else echo "I";?>',document.inventorysearch.inventory_sel);return false"/>
        <br>
		<div id=kardex style="display:none;">
            <br>
			Ano: <input type=text name=year size=4>
			Volumen:<input type=text name=volumen size=8>
			Numero:<input type=text name=numero size=8>
		</div>
	</div>

	<div class="searchBox">
<?php
if (isset($ASK_LPN) AND $ASK_LPN=="Y"){
			echo "
			<label for=date>".$msgstr["date"]. "<!-- calendar attaches to existing form element -->
					<input type=text name=date id=date"."_c Xreadonly=\"1\"  value=\"\" size=10";
			echo " onChange='Javascript:DateToIso(this.value,document.inventorysearch.date)'";
			echo "/>

                <i class=\"far fa-calendar-alt\" title=\"Date selector\" id=\"f_date\" style=\"cursor: pointer;\"></i>
				
				<script type=\"text/javascript\">
				   Calendar.setup({
       					inputField     :    \"date"."_c\",     // id of the input field
						ifFormat       :    \"";
						if (($config_date_format=="DD/MM/YY") or ($config_date_format=="d/m/Y")) {    // format of the input field
						   	echo "%d/%m/%Y";
						} else {
							echo "%m/%d/%Y";
						}	
						echo "\",
						    button         :    \"f_date\",  // trigger for the calendar (button ID)
						   	align          :    '',           // alignment (defaults to \"Bl\")
							singleClick    :    true
					});
				</script>";
			    echo" &nbsp;&nbsp; <strong> or </strong>
					<label for=lappso><strong>".$msgstr["days"]."</strong><input type=text name=lpn size=4>\n";

		}
?>
	</div>


	<div class="searchBox">
		<label for="searchExpr"><?php echo $msgstr["usercode"]?></label><br>
		<input type="text" name="usuario" id="usuario" 
		<?php
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="")
	echo "value=\"".$arrHttp["usuario"]."\"";
?>
 onclick="document.inventorysearch.usuario.value=''"/>

		<input type="button" name="list" value="<?php echo $msgstr["list"]?>" class="bt bt-blue w-1" onclick="javascript:AbrirIndice('U',document.inventorysearch.usuario)"/></td>
	</div>
	<div class="searchBox">
		<label for="searchExpr"><?php echo $msgstr["comments"]?></label><br>
		<input type="text" name="comments" size="100" maxlength="100">
		<input type="submit" name="prestar" value="<?php echo $msgstr["loan"]?>" class="bt bt-green" onclick="javascript:EnviarForma()"/>
        <p><?php echo $msgstr["clic_en"]." <i>[".$msgstr["loan"]."]</i> ".$msgstr["para_c"]?></p>

		
	</div>
	</div>

</div><!--./formcontent-->

</form>




<?php include("../common/footer.php");

if (isset($cuenta) and $cuenta==1){
	echo "<script>
	        document.inventorysearch.db_inven.selectedIndex=2
	     </script";
}
?>
<script>CambiarBase()</script>