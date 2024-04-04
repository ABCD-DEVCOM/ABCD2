<?php
/* Modifications
2022-11-02 fho4abcd actparfolder
2024-04-03 fho4abcd Use breadcrumb and div-helper, sanitize
*/
session_start();


if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/dbadmin.php");

if (!isset($tesaurus)) $tesaurus=$_REQUEST["base"];
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";if (file_exists($db_path.$tesaurus."/def/".$_SESSION["lang"]."/".$tesaurus.".dat"))
	$fp=file($db_path.$tesaurus."/def/".$_SESSION["lang"]."/".$tesaurus.".dat");
else
	$fp=file($db_path.$tesaurus."/def/".$lang_db."/".$tesaurus.".dat");
foreach($fp as $value) {	$f=explode('=',$value);
	switch($f[0]){		case "alpha_prefix":
			$prefijo=trim($f[1]);
			break;
		case "perm_prefix":
			$perm_prefix=trim($f[1]);
			break;
		case "alpha_pft":
			$Formato=trim($f[1]);
			break;
	}}
if (isset($arrHttp["perm"])) $prefijo=$perm_prefix;
$delimitador="";
$pref=$prefijo;
if(isset($arrHttp["pref"]))

	$prefijo=$prefijo.$arrHttp["pref"];
else
	$pref=$prefijo;
$prefix_search_tesaurus=$pref;
$IsisScript=$xWxis."ifp.xis";
if ($actparfolder!="par/") $actparfolder="$tesaurus/";
$query ="&base=$tesaurus&cipar=$db_path".$actparfolder.$tesaurus.".par&Opcion=autoridades&prefijo=$prefijo&pref=$pref&formato_e=".urlencode($Formato);
include("../common/wxis_llamar.php");
$contenido = array_unique ($contenido);
//foreach ($contenido as $var=>$value) echo "$var=$value<br>";die;
include("../common/header.php");
?>
<body>
<script src="../dataentry/js/lr_trim.js"></script>
<script>
<?php
echo "
		document.onkeypress =
  			function (evt) {
    			var c = document.layers ? evt.which
            		: document.all ? event.keyCode
            		: evt.keyCode;
    			return true;
  		}
		var nav4 = window.Event ? true : false;

		function codes(e) {
  			if (nav4) // Navigator 4.0x
    			var whichCode = e.which

			else // Internet Explorer 4.0x
    			if (e.type == 'keypress') // the user entered a character
     				 var whichCode = e.keyCode
    			else
      				var whichCode = e.button;
  			if (e.type == 'keypress' && whichCode==13)
				IrA()
  			else
				if (whichCode==13) IrA()
		}
		\n";
	$Tag="";
    echo "Tag=''\n";
	if (isset($arrHttp["Tag"])){
		echo "Tag='".$arrHttp["Tag"]."'\n";
		$Tag=$arrHttp["Tag"];
	}
?>
	function ObtenerTerminos(){
		Seleccion=""
		i=document.Lista.autoridades.selectedIndex
		for (i=0;i<document.Lista.autoridades.options.length; i++){
			if (document.Lista.autoridades.options[i].selected){
				Seleccion=document.Lista.autoridades.options[i].value
            }
		}
		if (document.Lista.ficha.checked){
        	document.show.termino.value=Seleccion
        	document.show.submit()
        	return
        }
		if (Seleccion!=""){
			if (Tag==""){
				window.opener.top.Expresion='"'+"<?php echo $prefix_search_tesaurus?>"+Seleccion+'"'
				window.opener.top.Menu("ejecutarbusqueda")
			}else{				Var=eval("window.opener.document.forma1."+Tag)
				if (Var.type=="text")
					Separa=";"
				else
					Separa="\n"
				VarOriginal=Var.value
				VarOriginal=Trim(VarOriginal)
				if (VarOriginal=="")
					VarOriginal=Seleccion
				else
					VarOriginal=Var.value+Separa+Seleccion
				Var.value=VarOriginal
				a=Var.value
				if (Var.type=="textarea") {
					b=a.split("\n")
					if(b.length>Var.rows) Var.rows=b.length

				}else{					self.close()				}			}
		}
	}

function Continuar(){
	i=document.Lista.autoridades.length-1
	a=document.Lista.autoridades[i].text
	AbrirIndice(a)
}

function IrA(ixj){
	a=document.Lista.ira.value
	AbrirIndice(a)
}

<?php
echo "function AbrirIndice(Termino){\n";
	echo "
    	db='".$arrHttp["base"]."'\n
		URL='index.php?base='+db+'&pref='+Termino
		if (Tag!=\"\") URL+='&Tag='+Tag
		self.location.href=URL
	}
";
?>
</script>
<div class="sectionInfo">
    <div class="breadcrumb" style="width:auto">
		<?php
        echo $msgstr["m_tesaurus"]." (".$tesaurus.")";
		?>
    </div>
    <div class="actions" style="width:auto">
		<?php
		$smallbutton=true;
		include "../common/inc_close.php";
		?>
    </div>
<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<form method=post name=Lista onSubmit="javascript:return false">
	<table width=100%  style="background:#EEEEEE">
	<tr>
		<td width=50% bgcolor=#EEEEEE>
			<img src=../dataentry/img/toolbarSearch.png>
			<a href="index.php?base=<?php echo $arrHttp["base"];if ($Tag!="") echo "&Tag=$Tag"?>"><strong><?php echo $msgstr["tes_alphabetic"]?></strong></a>  &nbsp; &nbsp;
			<a href="perm.php?perm=Y&base=<?php echo $arrHttp["base"];if ($Tag!="") echo "&Tag=$Tag"?>"><strong><?php echo $msgstr["tes_permuted"]?></strong></a>
		</td>
    	<td width=50% align=right>
			<input type=checkbox name=ficha>&nbsp;
			<?php echo $msgstr["tes_helpterm"]?>
		</td>
	</tr>
    </table>

<?php
// si viene de la opción de capturar de otra base de datos se presenta la lista de bases de datos disponibles
if (isset($arrHttp["capturar"]) and $arrHttp["capturar"]=="S"){
	$key_bd="";
	if (isset($arrHttp["base"])) $key_bd=$arrHttp["base"];
	$prefijo="";
	if (isset($arrHttp["prefijo"])) $prefijo=$arrHttp["prefijo"];
	if (!isset($arrHttp["Mfn"])) $arrHttp["Mfn"]="";
	$fp = file($db_path."bases.dat");
	foreach ($fp as $linea){
		if (trim($linea)!="") {
			$ix=strpos($linea,"|");
			$llave=trim(substr($linea,0,$ix));
			if ($llave!="acces")
				$lista_bases[$llave]=$linea;
		}

	}
}
	$xwidth="400";
	?>
	<table cellpadding=0 cellspacing=0 border=0  height=80%>
	<tr>
	<td width=5% align=center style='font-size:10px'>
		<?php for ($i=65;$i<91;$i++ ) {?>
		<a href="javascript:AbrirIndice('<?php echo chr($i)?>')"><?php echo chr($i)?></a><br>
		<?php }	?>
	</td>
	<td width=95% valign=top>
	<select name=autoridades size=28 style="width:<?php echo $xwidth?>px; height:400px" onchange=ObtenerTerminos()>
	<?php
		foreach ($contenido as $linea){			$linea=trim($linea);
			if (trim($linea)!=""){
				$l=explode('|',$linea);
			//	if (substr($i,0,strlen($arrHttp["pref"]))!=$arrHttp["pref"]) break;
				if (isset($l[1])){					echo "<option value=\"".$l[1]."\" title='".$l[1]."' alt='".$l[1]."'>".$l[0]."\n";					echo "<option value=\"".$l[1]."\" title='".$l[1]."' alt='".$l[1]."'>". " &nbsp; &nbsp; &nbsp;<b>USE:</B> ".$l[1]."\n";
				}else{
					echo "<option value=\"".$l[0]."\" title='".$l[0]."' alt='".$l[0]."'>".$l[0];
				}
			}
		}
	?>
	</select>
	</td>
	</table>
	<table cellpadding=0 cellspacing=0 border=0 width=100%  height=20%>
	<tr>
    <td>
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
</form>
</div>
</div>
<form name=show method=post action=show.php>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=termino>
<?php if (isset($arrHttp["Tag"])) echo "<input type=hidden name=Tag value=".$arrHttp["Tag"].">\n";?>
</form>
</body>
</html>
