<?php
/*
20220215 fho4abcd back&save button,div-helper + error if nothing found
20220216 fho4abcd !! This code contains errors and requires debugging
*/
session_start();
if (!isset($_SESSION["permiso"])) die;
include("../common/get_post.php");
include ("../config.php");
// ARCHIVOD DE MENSAJES
include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/statistics.php");

// ENCABEZAMIENTO HTML Y ARCHIVOS DE ESTILO
include("../common/header.php");

// LECTURA DE LA LISTA DE PROCESOS YA DEFINIDAS (PROC.CFG)
$total=-1;
$error="";
$fields="";
$cfg=array();
$tabs="";
$file=$db_path."/bases.dat";
$fp=file($file);
$fields="";
$bases_proc=array();
foreach ($fp as $value) {
	$value=trim($value);
	if ($value!=""){
		$b=explode('|',$value);
		if (file_exists($db_path.$b[0]."/def/".$lang."/proc.cfg")){
			$fproc=file($db_path.$b[0]."/def/".$lang."/proc.cfg");
			$ix=-1;
			foreach ($fproc as $procesos){
				if (trim($procesos)!=""){
					$ix=$ix+1;
					$p=explode('||',$procesos);
					$bases_proc[$b[0]][$ix]=$p[0];
					$last_base=$b[0];
				}
			}
		}
	}
}
$proc_gen=array();
$file=$db_path."proc_gen.cfg";
if (file_exists($file)){
	$fp=file($file);
	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			$proc_gen[]=$value;
		}
	}
}
?>
<body>
<script>fields='<?php echo $tabs;?>'</script>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<script languaje=javascript>

//RECOLECTA LOS VALORES DE LA PAGINA Y ENVIA LA FORMA

function Guardar(){
	ValorCapturado=""
	base="<?php echo $arrHttp["base"]?>"
	total=document.stats.rows.length
	if (total==undefined){
		ixRowTot=document.stats.rows.options.length
		row="";
		for (ixrt=0;ixrt<ixRowTot;ixrt++) {
			if (document.stats.rows.options[ixrt].selected)
				row=document.stats.rows.options[ixrt].value
		}
		if (row!=""){
			base=document.forma1.base.value
			ValorCapturado=row
		}
	}else{
		for (i=0;i<total;i++){
			row=""
			col=""
			base=document.stats.base[i].value
			ixRowTot=document.stats.rows[i].options.length
			row="";
			for (ixrt=0;ixrt<ixRowTot;ixrt++) {
				if (document.stats.rows[i].options[ixrt].selected)
					row=document.stats.rows[i].options[ixrt].value
			}
			if (row!="") ValorCapturado+=row+"\n"
		}
	}
	document.enviar.base.value=base
	document.enviar.ValorCapturado.value=ValorCapturado
	document.enviar.submit()
}

</script>
<?php
// VERIFICA SI VIENE DEL TOOLBAR O NO PARA COLOCAR EL ENCABEZAMIENTO
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["stats_conf"]." - ".$msgstr["stats_gen"];?>
    </div>
	<div class="actions">
        <?php
        if (isset($arrHttp["from"]) and $arrHttp["from"]=="statistics")
            $backtoscript="tables_generate.php";
        else
            $backtoscript="../dbadmin/menu_modificardb.php";//old status where variables were defined in that script
        include "../common/inc_back.php";
        $savescript="javascript:Guardar()";
        include "../common/inc_save.php";
        ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
	<div class="formContent">
<?php
//LECTURA DE LOS CUADROS Y TABLA YA DEFINIDOS
if ( count($bases_proc)==0) {
    echo $msgstr["no_procfiles_in_system"];
    echo "</div></div>";
    include("../common/footer.php");
    die;
}    
echo "<form name=stats method=post>";

echo "<table  width=800 bgcolor=#eeeeee border=0 name=tbst>\n";
foreach ($bases_proc as $base=>$proc) {
	echo "<tr><td>Database</td><td>$base</td></tr>";
	echo "<input type=hidden name=base value=$base>\n";
	echo "<tr><td bgcolor=white valign=top>".$msgstr["exist_proc"]."</td><td bgcolor=white>";
   	$size=count($proc);
   	echo "<select name=rows >";
   	echo "<option></option>\n";
   	foreach ($proc as $opt) {
   		$opt=trim($opt);
   		if ($opt!=""){
       		$OO=explode('||',$opt);
	  		$selected="";
	   		foreach ($proc_gen as $opcion){
	   			if (trim($opcion)==$base.'$$'.$opt) {
	   				$selected=" selected";
	   				break;
	   			}
	   		}
	   		echo "<option value=\"".$base.'$$'.$opt."\" $selected>".$opt."</option>\n";
	   	}
   	}
	echo "</select></td></tr>";
    if ($base!=$last_base)
		echo "<tr><td colspan=2 bgcolor=white> &nbsp; </td></tr>";
}
echo "</table>";
echo "<script>total=$total</script>\n";
?>
        </div>
	</div>
</div>
</form>
<?php echo "<h4>Script under construction, so sorry</h4>";?>
<form name=enviar method=post action=stats_gen_update.php>
<input type=hidden name=base>
<input type=hidden name=ValorCapturado>
<?php
if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=S>\n";
if (isset($arrHttp["from"])) echo "<input type=hidden name=from value=".$arrHttp["from"].">\n";
?>
</form>
<script>
	if (total==-1) AgregarTabla()
</script>
<?php
include("../common/footer.php");
?>
