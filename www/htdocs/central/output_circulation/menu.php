<?php

//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/prestamo.php");

if (!isset($_SESSION["login"])){	echo $msgstr["sessionexpired"];
	die;}
include("../common/header.php");

function SolicitarExpresion($base){global $msgstr,$arrHttp,$db_path,$lang_db;?>
&nbsp; <A HREF="javascript:Buscar('<?php echo $base?>')"><u><strong><?php echo $msgstr["r_busqueda"]?></strong></u></a>
			<br>
			<textarea rows=2 cols=100 name=Expresion_<?php echo $base?>></textarea>
			<a href=javascript:BorrarExpresion("<?php echo $base?>") class=boton><?php echo $msgstr["borrar"]?></a>
<?php
}

function SelectUserType($Ctrl){
global $db_path;	echo "<select name=select_$Ctrl><option></Option>";
	$file=$db_path."circulation/def/".$_SESSION["lang"]."/typeofusers.tab";
	$fp=file($file);
	foreach ($fp as $tipo){		$t=explode('|',$tipo);		echo "<option value=".$t[0].">".$t[1]."\n";	}
	echo "</select>";}

function SelectItemType($Ctrl){
global $db_path;
	echo "<select name=select_$Ctrl><option></option>";
	$file=$db_path."circulation/def/".$_SESSION["lang"]."/items.tab";
	$fp=file($file);
	foreach ($fp as $tipo){		if (trim($tipo)!=""){
			$t=explode('|',$tipo);
			echo "<option value=".$t[0].">".$t[1]."\n";
		}
	}
	echo "</select>";
}

function SetCalendar($Ctrl){global $config_date_format;	if ($config_date_format=="DD/MM/YY")    // format of the input field
		$date_format= "%d/%m/%Y";
 	else
		$date_format= "%m/%d/%Y";
	echo "<!-- calendar attaches to existing form element -->
	<input type=text size=10 name=date_$Ctrl id=date_$Ctrl value=''";
   //  echo " onChange='Javascript:DateToIso(this.value,document.forma1.date)'";
	echo "/> $config_date_format
	<a href='javascript:CalendarSetup(\"date_$Ctrl\",\"$date_format\",\"f_date_$Ctrl\", \"\",true )'>
 	<img src=\"../dataentry/img/calendar.gif\" id=\"f_date_$Ctrl\" style=\"cursor: pointer;\" title=\"Date selector\"
    /></a>
    <script type=\"text/javascript\">
	    Calendar.setup({

	        inputField     :    \"date_$Ctrl\",     // id of the input field
	        ifFormat       :    \"";
	        if ($config_date_format=="DD/MM/YY")    // format of the input field
	        	echo "%d/%m/%Y";
	        else
	        	echo "%m/%d/%Y";
	        echo "\",
	        button         :    \"f_date_$Ctrl\",  // trigger for the calendar (button ID)
	        align          :    '',           // alignment (defaults to \"Bl\")
	        singleClick    :    true
	    });
	</script>";}


// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//
?>
<!-- calendar stylesheet -->
  <link rel="stylesheet" type="text/css" media="all" href="../dataentry/calendar/calendar-win2k-cold-1.css" title="win2k-cold-1" />
  <!-- main calendar program -->
  <script type="text/javascript" src="../dataentry/calendar/calendar.js"></script>
  <!-- language for the calendar -->
  <script type="text/javascript" src="../dataentry/calendar/lang/calendar-es.js"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes
       adding a calendar a matter of 1 or 2 lines of code. -->
  <script type="text/javascript" src="../dataentry/calendar/calendar-setup.js"></script>
<script>
	function BorrarExpresion(base){		Ctrl=eval("document.forma1.Expresion_"+base)
		Ctrl.value=""	}

	function DateToIso(From,To){
		d=From.split('/')
		<?php echo "dateformat=\"$config_date_format\"\n" ?>
		if (dateformat="DD/MM/YY"){
			iso=d[2]+d[1]+d[0]
		}else{
			iso=d[2]+d[0]+d[1]
		}
		To.value=iso
	}
	function Imprimir(Media){
		sel=""
		Ctrl=document.forma1.RN
		if (Ctrl.constructor!==Array){			sel=Ctrl.value		}else{			for (ix=0;ix<Ctrl.length;ix++){				if (Ctrl[ix].checked){					sel=Ctrl[ix].value				}			}
		}
		if (sel==""){			alert("<?php echo $msgstr["r_self"]?>")
			return		}
		s=sel.split('|')
		ix=s[2].indexOf(".php")
		if (ix>0)
			document.forma1.action=s[2]
		else
			document.forma1.action="print.php"
		document.forma1.codigo.value=s[1]
		document.forma1.base.value=s[0]
		document.forma1.vp.value=Media
		document.forma1.submit()
	}
	function Editar(Codigo,Base){
		document.forma1.action="print_add.php";
		sel=""
		Ctrl=document.forma1.RN
		if (Ctrl.constructor!==Array){
			sel=Ctrl.value
		}else{
			for (ix=0;ix<Ctrl.length;ix++){
				if (Ctrl[ix].checked){
					sel=Ctrl[ix].value
				}
			}
		}
		if (sel==""){
			alert("<?php echo $msgstr["r_self"]?>")
			return
		}
		s=sel.split('|')
		document.forma1.codigo.value=s[1]
		document.forma1.base.value=s[0]
		document.forma1.submit()
	}
	function Buscar(base){
		cipar=base+".par"
		Url="../dataentry/buscar.php?Opcion=formab&prologo=prologoact&Target=s&Tabla=Expresion_"+base+"&base="+base+"&cipar="+cipar
	  	msgwin=window.open(Url,"Buscar","menu=no, resizable,scrollbars,width=750,height=400")
		msgwin.focus()
	}
</script>
<?php
include("../common/institutional_info.php");
 ?>

<div class="sectionInfo">
	<div class="breadcrumb">
	</div>
	<div class="actions">
		<a href="../common/inicio.php?reinicio=s&modulo=loan" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"];?></strong></span></a>
	</div>

<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulation/reports.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/reports.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: reports_menu.php";
?>
</font>
	</div>
<form name=forma1 method=post action=print.php>
<input type=hidden name=codigo>
<input type=hidden name=base>
<input type=hidden name=vp>
<div class="middle form">
	<div class="formContent">

<?php
	$base[]="trans";
	$base[]="suspml";
	if (!isset($reserve_active) or isset($reserve_active) and $reserve_active=="Y"){
		$base[]="reserve";
	}
	foreach ($base as $bd){
		if (file_exists($db_path."$bd/pfts/".$_SESSION["lang"]."/outputs.lst")){			$fp=file($db_path."$bd/pfts/".$_SESSION["lang"]."/outputs.lst");
			sort($fp);
			echo "<p>";
			echo "<strong>".$msgstr["basedatos"].": ".$bd."</strong>";
			echo "<ul>";
			foreach ($fp as $value){
				$value=trim($value);
				if ($value=="") continue;
				if (substr($value,0,2)=="//") continue;
				$l=explode('|',$value);
				echo "<li><input type=radio name=RN value=\"$bd|$l[0]|$l[1]\">(".$l[0].") ".$l[5]."</a>\n";
				if (isset($l[6])){					switch ($l[6]){						case "DATE":
						case "DATEQUAL":
						case "DATELESS":
							echo " ";//.$msgstr["date"];
							SetCalendar($l[0]);
							break;
						case "USERTYPE":
							echo " ";//.$msgstr["typeofusers"];
							SelectUserType($l[0]);
							break;
						case "ITEMTYPE":
							echo " ";//.$msgstr["typeofitems"];
							SelectItemType($l[0]);
							break;					}				}
			}

			echo " </ul>";
			SolicitarExpresion($bd);
			echo "<p>";
			echo " ".$msgstr["sendto"].": ";
			echo "<a href=javascript:Imprimir(\"display\")>".$msgstr["ver"]."</a> | ";
			echo "<a href=javascript:Imprimir(\"TB\")>".$msgstr["wsproc"]."</a> | ";
			echo "<a href=javascript:Imprimir(\"WP\")>".$msgstr["word"]."</a>";
			echo "&nbsp; &nbsp;<a href=javascript:Editar()><font color=red>".$msgstr["editar"]."</font></a>";
			echo "<hr size=5>";		}
	}
?>
<p>

<p>
<a href=print_add.php><?php echo $msgstr["new"]?></a>

</form>
<p>
</div>
</div>
<?php
include("../common/footer.php");
?>
</body>
</html>
