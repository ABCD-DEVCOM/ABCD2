<?php
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/prestamo.php");
include("../lang/admin.php");
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

function LeerNumeroClasificacion($base){global $db_path,$lang_db;
	$prefix_nc="";
	$prefix_in="";	$archivo=$db_path.$base."/loans/".$_SESSION["lang"]."/loans_conf.tab";
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
	$prefijos=array($prefix_in,$prefix_nc);
	return $prefijos;}

function DibujarSelectBases($fp){global $msgstr,$arrHttp,$copies;
	echo "<table width=100% border=0 bgcolor=white>";
?>

		<td width=150>
			<label for="dataBases">
			<strong><?php echo $msgstr["basedatos"]?></strong>
			</label>
		</td><td>
		<select name=db onChange=VerSiLoanObjects()>
			<option></option>
<?php
	$ixcount=0;
	foreach ($fp as $value){
		if (trim($value)!=""){
			$ixcount=$ixcount+1;
		}
	}
	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			$v=explode('|',$value);
			$value=$v[0].'|'.$v[1];
//SE LEE EL PREFIJO PARA OBTENER EL NUMERO DE CLASIFICACION DE LA BASE DE DATOS

			$prefijo=LeerNumeroClasificacion($v[0]);
			$prefijo_in=$prefijo[0];
			$prefijo_nc=$prefijo[1];
			$pft_in=LeerPft("loans_inventorynumber.pft",$v[0]);
			$pft_nc=LeerPft("loans_cn.pft",$v[0]);
			$value.="|".$prefijo_in."|@autoridades.pft|$prefijo_nc|$pft_nc";
			$value.='|';
			if (isset($v[2])){
				$value.=$v[2];
			}
			echo "<option value='$value'";
			if ($ixcount==1 and $value!="") echo " selected";
			if (isset($arrHttp["base"]) and $arrHttp["base"]==$v[0]) echo " selected";
			echo ">".$v[1]."</option>\n";
		}
	}
?>
		</select>
		<input type=submit value="<?php echo $msgstr["adsearch"]?>" onclick=BusquedaAvanzada("<?php echo $copies?>")></td></table>

<?php}
?>
<script src=../dataentry/js/lr_trim.js></script>
<script>

base_selec=""
function EnviarForma(){
	if (Trim(document.inventorysearch.control.value)=="" && Trim(document.inventorysearch.inventory_sel.value)==""){		alert("<?php echo $msgstr["falta"]." ".$msgstr["control_n"].' / '.$msgstr["inventory"]?>")
		return	}
	if (Trim(document.inventorysearch.control.value)!="" && Trim(document.inventorysearch.inventory_sel.value)!=""){
		alert("<?php echo $msgstr["onlyone"]?>")
		return
	}
    if (base_selec=="Y"){
		 bd_sel=document.inventorysearch.db.selectedIndex
		if (bd_sel<=0){
			alert("<?php echo $msgstr["seldb"]?>")
			return
		}
	}
	if (base_selec=="Y")
		document.inventorysearch.action="situacion_de_un_objeto_db_ex.php"
	else
    	document.inventorysearch.action="situacion_de_un_objeto_ex.php";
   /* if (Trim(document.inventorysearch.inventory_sel.value)!=""){    	INV=escape(document.inventorysearch.inventory_sel.value)
	<?php if (isset($inventory_numeric) and $inventory_numeric =="Y")
		echo "INV=parseInt(document.inventorysearch.inventory_sel.value,10)\n";
	?>

		document.inventorysearch.inventory_sel.value=INV    } */
	document.inventorysearch.submit()}

function AbrirIndiceAlfabetico(xI,Prefijo,Subc,Separa,db,cipar,tag,postings,Repetible,Formato){		Ctrl_activo=xI
		lang="en"
	    Separa="&delimitador="+Separa
	    Prefijo=Separa+"&tagfst="+tag+"&prefijo="+Prefijo
	    ancho=200
		url_indice="capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&Tag="+tag+Prefijo+"&postings="+postings+"&lang="+lang+"&repetible="+Repetible+"&Formato="+Formato
		msgwin=window.open(url_indice,"Indice","width=480, height=425,scrollbars")
		msgwin.focus()
}

function VerSiLoanObjects(){	bd_sel=document.inventorysearch.db.selectedIndex
	if (bd_sel<=0){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	bd_a=document.inventorysearch.db.options[bd_sel].value
	b=bd_a.split('|')
	bd=b[0]
	if (bd=="loanobjects"){		self.location.href="situacion_de_un_objeto.php?base=loanobjects"
		return	}}

function AbrirIndice(Ix,Ctrl){	library=""
	switch (Ix){		case "S":
		      <?php if (isset($_SESSION["library"])) echo "library='".$_SESSION["library"]."_'\n";?>
		case "SC":
            bd_sel=document.inventorysearch.db.selectedIndex

			if (bd_sel<=0){
				alert("<?php echo $msgstr["seldb"]?>")
				return
			}
			bd_a=document.inventorysearch.db.options[bd_sel].value
			b=bd_a.split('|')
			bd=b[0]
			if (bd=="loanobjects") Ix="C";
			base_sel=bd
			if (Ix=="S"){
				prefijo=b[2]
				formato=b[3]
				repetible=1
			}else{				prefijo=b[4]
				formato=b[5]
				repetible=0			}
			prefijo=prefijo+library
			AbrirIndiceAlfabetico(Ctrl,prefijo,"","",bd,bd+".par","3",1,repetible,"ifp")
			break
		case "I":

			AbrirIndiceAlfabetico(Ctrl,"IN_","","","copies","copies.par","1",1,"1","v30")
			break
		case "C":

			AbrirIndiceAlfabetico(Ctrl,"CN_","","","copies","copies.par","1",1,"0","mpu,v10`_`v1")
			break
	}
}

function PresentarDiccionario(){
		msgwin=window.open("","Diccionario","scrolling, height=400")
		ix=document.searchBox.indexes.selectedIndex
		if (ix<1){
			alert("<?php echo $msgstr["selcampob"]?>")
			return
		}
		sel=document.searchBox.indexes.options[ix].value
		t=sel.split('|')
		document.diccionario.campo.value=escape(t[0])
		document.diccionario.prefijo.value=t[2]
		document.diccionario.id.value=t[1]
		document.diccionario.Diccio.value="document.inventorysearch.searchExpr"
		document.diccionario.submit()
		msgwin.focus()
	}
function BusquedaAvanzada(copies) {        switch (copies){        	case "N":
        		Ctrl=eval("document.inventorysearch.db")
        		break;
        	case "Y":
        		Ctrl=eval("document.busqueda.db")
        		break        }		 bd_sel=Ctrl.selectedIndex
		if (bd_sel<=0){
			alert("<?php echo $msgstr["seldb"]?>")
			return
		}
		bd_a=Ctrl.options[bd_sel].value
		base_selec=bd_a
		b=bd_a.split('|')
		bd=b[0]
		document.busqueda.base.value=bd
		document.busqueda.copies.value=copies
		document.busqueda.submit()}
</script>
<?php
$encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
$link_u="";
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") $link_u="&usuario=".$arrHttp["usuario"];
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["ecobj"]?>
	</div>
	<div class="actions">
		<?php include("submenu_prestamo.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulation/object_statment.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/circulation/object_statment.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: situacion_de_un_objeto.php</font>\n";

?>
</div>
<div class="middle list">
	<div class="searchBox">
		<form name=inventorysearch  method=post onsubmit="javascript:return false">
<?php
//READ BASES.DAT TO FIND THOSE DATABASES IF NOT WORKING WITH COPIES DATABASES
$sel_base="";
$copies="";
$fp=array();
if (file_exists($db_path."loans.dat")){
	$fp=file($db_path."loans.dat");
	$sel_base="Y";
	$copies="N";
}else{	$file=file($db_path."bases.dat");
	foreach ($file as $val){		$val=trim($val);		if ($val!=""){			$ff=explode('|',$val);
			if (isset($ff[2])){
				if ($ff[2]=="Y"){					$sel_base="N";
					$copies="Y";				}
			}
			if (file_exists($db_path.trim($ff[0])."/loans/".$_SESSION["lang"]."/loans_display.pft")){				$fp[]=$val;			}		}	}}
?>
<script><?php echo 'base_selec="'.$sel_base.'";'; echo 'copies="'.$copies.'"'?></script>
<?php if ($copies=="N") {
	DibujarSelectBases($fp);
}
?>




	<input type=hidden name=inventory>

		<table width=100% border=0>
			<td width=150>
				<label for="searchExpr">
				<strong><?php echo $msgstr["inventory"]?></strong>
			</label>
			</td><td>
				<textarea name="inventory_sel" id="inventory_sel" value="" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry';" rows=5 cols=50/></textarea>
				<input type="button" name="list" value="<?php echo $msgstr["list"]?>" class="submit" onclick="javascript:AbrirIndice('<?php if ($sel_base=="Y") echo "S"; else echo "I";?>',document.inventorysearch.inventory_sel);return false"/>
				<input type="submit" name="buscar" value="<?php echo $msgstr["search"]?>" class="submit" onclick="javascript:EnviarForma()"/>
			</td>
		</table>
	</div>

	<div class="searchBox">
	<table width=100%>
		<td width=150>
		<label for="searchExpr">
			<strong><?php echo $msgstr["controlnum"]?></strong>
		</label>
		</td><td>
		<input type="text" name="control" id="control" value="" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry';" />
		<input type="button" name="list" value="<?php echo $msgstr["list"]?>" class="submit" onclick="javascript:AbrirIndice('<?php if ($sel_base=="Y") echo "SC"; else echo "C";?>',document.inventorysearch.control)"/>
		<input type="submit" name="ok" value="<?php echo $msgstr["search"]?>" class="submit" onClick=EnviarForma() />
		</td></table>
	<p>

	</form>
	<form name=busqueda method=post action=buscar.php onsubmit="javascript:return false">
	<input type=hidden name=Opcion value="formab">
	<?php echo "<input type=hidden name=copies value=$copies>\n";?>
	<input type=hidden name=base value="<?php if (isset($arrHttp["base"]))echo $arrHttp["base"]?>">
	<?php if ($copies=="Y") {
		DibujarSelectBases($fp);
	}
	?>

	</form>
	<br><br><br><br>
	</div>

</div>
<form name=EnviarFrm method=post>
<input type=hidden name=base value="<?php if (isset($arrHttp["base"])) echo $arrHttp["base"]?>">
<input type=hidden name=usuario value="">
<input type=hidden name=desde value=1>
</form>
<form name=diccionario method=post action=diccionario.php target=Diccionario>
	<input type=hidden name=base value="<?php if (isset($arrHttp["base"])) echo $arrHttp["base"]?>">
	<input type=hidden name=cipar value="<?php if (isset($arrHttp["base"])) echo $arrHttp["base"]?>.par">
	<input type=hidden name=prefijo>
	<input type=hidden name=Formato>
	<input type=hidden name=campo>
	<input type=hidden name=id>
	<input type=hidden name=Diccio>
	<input type=hidden name=from value=$desde>
	<input type=hidden name=Opcion value=diccionario>
	<input type=hidden name=Target value=s>
	<input type=hidden name=Expresion>
</form>
<?php include("../common/footer.php");
echo "</body></html>" ;

?>