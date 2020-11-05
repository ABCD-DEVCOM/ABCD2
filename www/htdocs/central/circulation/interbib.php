<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      interbib.php
 * @desc:      Inter-library  loan
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
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/prestamo.php");
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>"; //die;
include("../common/header.php");

if (file_exists($db_path."loans.dat")){
	$fp=file($db_path."loans.dat");
	$sel_base="S";
	$cuenta=0;
	foreach ($fp as $value){
		if (trim($value)!=""){
			$cuenta=$cuenta+1;
			$value=trim($value);
			$b=explode('|',$value);
            $base=$b[0];
            break;
   		}
   	}
}

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

$sel_base="N";
?>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<!-- calendar stylesheet -->
  <link rel="stylesheet" type="text/css" media="all" href="../dataentry/calendar/calendar-win2k-cold-1.css" title="win2k-cold-1" />
  <!-- main calendar program -->
  <script  language="JavaScript" type="text/javascript"" src="../dataentry/calendar/calendar.js"></script>
  <!-- language for the calendar -->
  <script  language="JavaScript" type="text/javascript" src="../dataentry/calendar/lang/calendar-<?php echo $_SESSION["lang"]?>.js"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes
       adding a calendar a matter of 1 or 2 lines of code. -->
  <script language="JavaScript" type="text/javascript" src="../dataentry/calendar/calendar-setup.js"></script>
<script>
kardex=""

function ValidarFecha(){
	msg=""
	valor=Trim(document.interlibraryloan.date.value)
	if (valor!=""){		var expreg = /^(\d{4})([0][1-9]|[1][0-2])([0][1-9]|[12][0-9]|3[01])$/;
   		if (!expreg.test(valor) )  {
            msg="<?php echo $msgstr["js_inv_dateformat"]?>"
        }else{
   			var today = "<?php echo date("Ymd")?>";
   			if (valor<today) msg="<?php echo $msgstr["js_inv_date"]?>"
   		}
   		if(msg!=""){
   			alert(msg)
   			return false
   		}	}
	return true}

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

		if (dateformat=="DD/MM/YY"){
			iso=d[2]+d[1]+d[0]
		}else{
			iso=d[2]+d[0]+d[1]
		}
		To.value=iso
	}


function EnviarForma(){
	if (ASK_LPN=="Y"){
		ret=ValidarFecha()
		if (ret==false)
			return
	}
	if (document.interlibraryloan.agreement.selectedIndex==-1 || document.interlibraryloan.agreement.selectedIndex==0){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["agreement"];?>")
		return
	}
	loan_policy="<?php echo $LOAN_POLICY?>"
	if (Trim(document.interlibraryloan.inventory_sel.value)=="" || Trim(document.interlibraryloan.usuario.value)=="" ){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["signature"]." / ".$msgstr["usercode"]?>")
		return
	}

    INV=escape(document.interlibraryloan.inventory_sel.value)
    document.interlibraryloan.inventory.value=INV
    document.interlibraryloan.submit()}

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
			bd_sel=document.interlibraryloan.db_inven.selectedIndex
			if (bd_sel<=0){
				alert("debe seleccionar una base de datos")
				return
			}
			bd_a=document.interlibraryloan.db_inven.options[bd_sel].value
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
						ix=document.interlibraryloan.db_inven.selectedIndex
						sel=document.interlibraryloan.db_inven.options[ix].value
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
			break		case "I":
			Separa=""
			ancho=200

			if (search_in==""){
    			Prefijo=Separa+"&prefijo=IN_"

				url_indice="capturaclaves.php?opcion=autoridades&base=loanobjects&cipar=loanobjects.par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible="+Repetible+"&Formato=@autoridades.pft"
			}else{
				ix=document.interlibraryloan.db_inven.selectedIndex
				sel=document.interlibraryloan.db_inven.options[ix].value
				s=sel.split('|')
				bd=s[0]
				pref="IN_"+pref				Prefijo=Separa+"&prefijo="+pref
				url_indice="capturaclaves.php?opcion=autoridades&base="+bd+"&cipar="+bd+".par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible="+Repetible+"&Formato=@autoridades.pft"			}
			break
		case "U":
<?php
# Se lee el prefijo y el formato para extraer el código de usuario
$us_tab=LeerPft("loans_uskey.tab","users");
$t=explode("\n",$us_tab);
$codigo=LeerPft("loans_uskey.pft","users");
?>
			Separa=""
			Formato="<?php if (isset($t[2]))  echo trim($t[2]); else echo 'v30';?>,`$$$`,<?php echo str_replace("'","`",$codigo)?>"
    		Prefijo=Separa+"&prefijo=<?php if (isset($t[1])) echo trim($t[1]); else echo 'NO_';?>"
    		ancho=200
			url_indice="capturaclaves.php?opcion=autoridades&base=users&cipar=users.par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible=0&Formato="+Formato
			break	}
	msgwin=window.open(url_indice,"Indice","width=480, height=450,left=300,scrollbars")
	msgwin.focus()
}
ASK_LPN="<?php echo $ASK_LPN?>"

</script>
<?php
$encabezado="";
echo "<body onLoad=javascript:document.interlibraryloan.inventory_sel.focus()>\n";
include("../common/institutional_info.php");
$link_u="";
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") $link_u="&usuario=".$arrHttp["usuario"];
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["loan"];
		  if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") echo " - ".$msgstr["users"].": ".$arrHttp["usuario"];
		?>
	</div>
	<div class="actions">
		<?php include("submenu_prestamo.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<?php echo "
<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/circulation/loan.html target=_blank>". $msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/circulation/interbib.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: circulation/interbib.php </font>
	</div>";
// prestar, reservar o renovar
?>


<form name=interlibraryloan action=interbib_ex.php method=post onsubmit="javascript:return false">
<input type=hidden name=loan_policy value=<?php echo $LOAN_POLICY?>>
<input type=hidden name=type value=<?php echo $ILL?>>
<input type=hidden name=base value=<?php echo $base?>>
<input type=hidden name=Opcion value=prestar>
<input type=hidden name=inventory>
<div class="middle list">
	<div class="searchBox">
	<table width=100% border=0>
<?php
if (!file_exists($db_path."circulation/def/".$_SESSION["lang"]."/ill.tab")){
	echo "<h1>Falta lista de convenios para préstamo interbibliotecario</h1>";
	die;
}else{
	$fp=file($db_path."circulation/def/".$_SESSION["lang"]."/ill.tab");
	$sel_base="S";
?>
	<table width=100% border=0>
		<td width=150>
		<label for="dataBases">
			<strong><?php echo $msgstr["agreement"]?></strong>
		</label>
		</td><td>
		<select name=agreement>
		<option></option>
<?php
	$xselected="";
	$cuenta=0;
	foreach ($fp as $value){
		if (trim($value)!=""){
			$cuenta=$cuenta+1;
			$value=trim($value);
			$v=explode('|',$value);
			//SE LEE EL PREFIJO PARA OBTENER EL NUMERO DE INVENTARIO DE LA BASE DE DATOS
			if (trim($v[1])=="") $v[1]=$v[0];
			$value=$v[0].'|'.$v[1];
			echo "<option value='$value' $xselected>".$v[1]."</option>\n";
			$xselected="";
		}
	}
}
?>
		</select>
		</td>
		<tr>
		<td width=150>
		<label for="searchExpr">
			<strong><?php echo $msgstr["signature"]. " &nbsp".$ILL."-"?></strong>
		</label>
		</td><td>
		<?php if (isset($LOAN_POLICY) and $LOAN_POLICY=="BY_USER"  ){			?><input type=text name="inventory_sel" id="inventory_sel" value="" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry';">	<?php }else{			?>
		<textarea name="inventory_sel" id="inventory_sel" value="" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry';" rows=5 cols=50/></textarea>
	<?php }

	?>

		</td>
	<tr>
		<td>
			<label for="searchExpr">
				<strong><?php echo $msgstr["author"]?></strong>
			</label></td><td><input type=text name=tag100_a size=40></td>
	</tr>
	<tr>
		<td>
			<label for="searchExpr">
				<strong><?php echo $msgstr["title"]?></strong>
			</label></td><td><input type=text name=tag100_b size=100></td>
	</tr>
<?php
if (isset($ASK_LPN) AND $ASK_LPN=="Y"){
			echo "<tr><td height=50>
			<label for=date>".$msgstr["date"]. "</td><td> <!-- calendar attaches to existing form element -->
					<input type=text name=date id=date"."_c Xreadonly=\"1\"  value=\"\" size=10";
			echo " onChange='Javascript:DateToIso(this.value,document.interlibraryloan.date)'";
			echo "/>
				<img src=\"../dataentry/img/calendar.gif\" id=\"f_date\" style=\"cursor: pointer;\" title=\"Date selector\"
			 	 / valign=bottom>
				<script type=\"text/javascript\">
				   Calendar.setup({
       					inputField     :    \"date"."_c\",     // id of the input field
						ifFormat       :    \"";
						if ($config_date_format=="DD/MM/YY")    // format of the input field
						   	echo "%d/%m/%Y";
						else
							echo "%m/%d/%Y";
						echo "\",
						    button         :    \"f_date\",  // trigger for the calendar (button ID)
						   	align          :    '',           // alignment (defaults to \"Bl\")
							singleClick    :    true
					});
				</script>";
			    echo" &nbsp;&nbsp; <strong> or </strong>
					<label for=lappso><strong>".$msgstr["days"]."</strong><input type=text name=lpn size=4>\n";

            echo  "</td></tr>";
		}
?>
	</table>
	</div>


	<div class="searchBox">
		<table width=100% border=0>
		<td width=150>
		<label for="searchExpr">
			<strong><?php echo $msgstr["usercode"]?></strong>
		</label>
		</td>
		<td>
		<input type="text" name="usuario" id="usuario" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry'; "
<?php
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="")
	echo "value=\"".$arrHttp["usuario"]."\"";
?>
 onclick="document.interlibraryloan.usuario.value=''"
/>

		<input type="button" name="list" value="<?php echo $msgstr["list"]?>" class="submit" onclick="javascript:AbrirIndice('U',document.interlibraryloan.usuario)"/></td>

		<tr><br><td>
		<label for="searchExpr">
			<strong><?php echo $msgstr["comments"]?></strong>
		</label></td><td><br><input type=text name=comments   size=100 maxlength=100>
		<input type="submit" name="prestar" value="<?php echo $msgstr["loan"]?>" xclass="submitAdvanced" onclick="javascript:EnviarForma()"/>

		</td></table>
        <?php echo $msgstr["clic_en"]." <i>[".$msgstr["loan"]."]</i> ".$msgstr["para_c"]?>

	</div>
	</div>
</div>

</form>
<?php include("../common/footer.php");
echo "</body></html>" ;

?>
