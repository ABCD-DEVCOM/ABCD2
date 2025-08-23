<?php
/*
20220203 fho4abcd backbutton+div-helper
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
if (!isset($arrHttp)) $arrHttp = array();
include ("../config.php");
$lang=$_SESSION["lang"];
include("../common/header.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
include("../lang/reports.php");



if (!isset($_SESSION["login"])or $_SESSION["profile"]!="adm" ){
	echo "<script>
	      alert('".$msgstr["invalidright"]."')
          history.back();
          </script>";
    die;
}
$Permiso=$_SESSION["permiso"];
?>


<form name="ReloadSite" method="post">
	<input type="hidden" name=encabezado value="s">
	<input type="hidden" name=base value="<?php echo $arrHttp["base"];?>">
</form>	

<script>
function ReloadSite() {
	document.ReloadSite.encabezado.value='s';
	document.ReloadSite.base.value='<?php echo $arrHttp["base"];?>';
	document.ReloadSite.submit();
}

function Update(Option){ 
	switch (Option){
		case "pft":
		document.ReloadSite.action="pft.php"
		break;
	}
		document.ReloadSite.submit()
}
</script>


	<?php include("../common/institutional_info.php");?>

	<div class="sectionInfo">
		<div class="breadcrumb">
			<?php echo $msgstr["chk_dbdef"]. ": " . $arrHttp["base"]; ?>
		</div>
		<div class="actions">
            <?php
                $backtoscript="../dbadmin/menu_modificardb.php";
                include "../common/inc_back.php";
			?>
		</div>
		<div class="spacer">&#160;</div>
	</div>
	<?php include("submenu_dbadmin.php");?>
    <?php include "../common/inc_div-helper.php";?>

	<div class="middle">
		<div class="formContent">

		<h2><?php echo $msgstr["chk_dbdef"]; ?></h2>

		<h3><?php echo $msgstr["def_lang"]; ?> (lang.tab)</h3>

<?php
//Checks the languages available in the installation
if (isset($msg_path))
	$path_this=$msg_path;
else
	$path_this=$db_path;
	$a=$path_this."lang/".$_SESSION["lang"]."/lang.tab";
	$fp=file($a);
foreach ($fp as $value) {
	$v=explode('=',$value);
	$lang_tab[$v[0]]=$v[1];
	echo "<li>".$v[1]."</li>";
}
$ll_t=$lang_tab;


//Checks existing PFTS
function pft_exist($db_path, $arrHttp) {
	global $msgstr;
	$base_dir    = $db_path.$arrHttp["base"]."/pfts";
	$lang_dir = scandir($base_dir);

	//Checks the languages available in the installation
		if (isset($msg_path))
			$path_this=$msg_path;
		else
			$path_this=$db_path;
			$a=$path_this."lang/".$_SESSION["lang"]."/lang.tab";
			$fp=file($a);
			echo '<label> Copiar modelo a partir do idioma</label><br>';			
			echo "<select name='source'>";
			echo '<option></option>';			
			foreach ($fp as $value) {
				$v=explode('=',$value);
				$lang_tab[$v[0]]=$v[1];
			foreach ($lang_dir as $lb) {
				if ( $v[0]==$lb ){
					echo '<option value="/pfts/'.$v[0].'">'.$v[1].'</option>';
				} 

			}
		}
			echo '</select>';
			echo '<br><button id="ButtoncopyPFT" class="bt bt-blue" type="submit">'.$msgstr["cf_copyfolder"].' PFTs</button>';			
}

//Verifica as DEF existentes
function def_exist($db_path, $arrHttp) {
	global $msgstr;
	$base_dir    = $db_path.$arrHttp["base"]."/def";
	$lang_dir = scandir($base_dir);

	//Verifica os idiomas disponíveis na instalação
		if (isset($msg_path))
			$path_this=$msg_path;
		else
			$path_this=$db_path;
			$a=$path_this."lang/".$_SESSION["lang"]."/lang.tab";
			$fp=file($a);
			echo '<label> Copiar modelo a partir do idioma</label><br>';			
			echo ' <select name="source">';
			echo '<option></option>';			
			foreach ($fp as $value) {
				$v=explode('=',$value);
				$lang_tab[$v[0]]=$v[1];
			foreach ($lang_dir as $lb) {
				if ( $v[0]==$lb ){
					echo '<option value="/def/'.$v[0].'">'.$v[1].'</option>';
				} 

			}
		}
			echo '</select>';
			echo '<br><button id="ButtoncopyDEF" class="bt bt-blue" type="submit">'.$msgstr["cf_copyfolder"].' DEF</button>';			

}

//Verifica as ajudas existentes
function help_exist($db_path, $arrHttp) {
	global $msgstr;	
	$base_dir    = $db_path.$arrHttp["base"]."/ayudas";

	if (is_dir($base_dir)){

	$lang_dir = scandir($base_dir);

	} else {
	$lang_dir = array(); 			
	}

	//Verifica os idiomas disponíveis na instalação
		if (isset($msg_path))
			$path_this=$msg_path;
		else
			$path_this=$db_path;
			$a=$path_this."lang/".$_SESSION["lang"]."/lang.tab";
			$fp=file($a);
			if ($lang_dir <> 0) {
						echo '<label> Copiar modelo a partir do idioma</label><br>';
						echo ' <select name="source">';
						echo '<option></option>';
						foreach ($fp as $value) {
							$v=explode('=',$value);
							$lang_tab[$v[0]]=$v[1];
						foreach ($lang_dir as $lb) {
							if ( $v[0]==$lb ){
								echo '<option value="/ayudas/'.$v[0].'">'.$v[1].'</option>';
							} 
			
						}
					}
						echo '</select>';
		
						echo '<br><button id="ButtoncopyHELP" class="bt bt-blue" type="submit">'.$msgstr["cf_copyfolder"].' Ayudas</button>';}
}
?>

<br>

<h3><?php echo $msgstr["cf_label_dir"];?></h3>
<table class="listTable browse">
	<tr>
		<th><?php echo $msgstr["cf_prfix"];?></th>
		<th><?php echo $msgstr["cf_languages"];?></th>
		<th><?php echo $msgstr["cf_pftfiles"];?></th>
		<th><?php echo $msgstr["cf_deffiles"];?></th>
		<th><?php echo $msgstr["cf_ayudas"];?></th>
	</tr>

<?php
$ixid=0;
foreach ($lang_tab as $v => $value){

	$folder_pfts = $db_path.$arrHttp["base"]."/pfts/$v";
	$files_pfts = glob($folder_pfts.'/*.*');
	$folder_def = $db_path.$arrHttp["base"]."/def/$v";
	$files_def = glob($folder_def.'/*.*');
	$folder_help = $db_path.$arrHttp["base"]."/ayudas/$v";
	$files_help = glob($folder_help.'/*.*');
	
	echo "<tr><td>".$v." </td><td> ".$value."</td>";
	
	$ixid=$ixid+1;
	
	if (is_dir($folder_pfts)){
		echo "<td>";
		$total_files = count($files_pfts);
		echo $total_files." ".$msgstr["cf_files"];
		echo "</td>";

	} else {
?>
	<td>
	<form name="maintenancePFT" method="post">
		<input type="hidden" name="encabezado" value="s">
		<input type="hidden" name="base" value="<?php echo $arrHttp["base"];?>">
		<input type="hidden" name="folder" value="<?php echo $db_path.$arrHttp["base"]; ?>">
		<input type="hidden" name="destiny" value="/pfts/<?php echo $v;?>">
		<label><?php echo $msgstr["falta"]; ?></label><br>
		<?php echo pft_exist($db_path,$arrHttp); ?>	
	</form>
	</td>

<?php	
	}
	if (is_dir($folder_def)){
		echo "<td>";
		echo count($files_def)." ".$msgstr["cf_files"];
		echo "</td>";

	} else {

?>
	<td>
	<form name="maintenance" method="post">
		<input type="hidden" name="encabezado" value="s">
		<input type="hidden" name="base" value="<?php echo $arrHttp["base"];?>">
		<input type="hidden" name="folder" value="<?php echo $db_path.$arrHttp["base"]; ?>">
		<input type="hidden" name="destiny" value="/def/<?php echo $v;?>">
		<label><?php echo $msgstr["falta"]; ?></label><br>
		<?php echo def_exist($db_path,$arrHttp); ?>	
	</form>
	</td>

<?php	
	}
	if (is_dir($folder_help)){
		echo "<td>";
		echo count($files_help)." ".$msgstr["cf_files"];
		echo "</td>";
	} else {
?>
	<td>
	<form name="maintenance" method="post">
		<input type="hidden" name="encabezado" value="s">
		<input type="hidden" name="base" value="<?php echo $arrHttp["base"];?>">
		<input type="hidden" name="folder" value="<?php echo $db_path.$arrHttp["base"]; ?>">
		<input type="hidden" name="destiny" value="/ayudas/<?php echo $v;?>">
		<label><?php echo $msgstr["falta"]; ?></label><br>
		<?php echo help_exist($db_path,$arrHttp); ?>	
	</form>
	</td>	
<?php
	}

}
?>
</table>

<h3><?php echo $msgstr["analyzing"]." PFTs "; ?></h3>
<?php
//Analyses available formats in each language
foreach ($lang_tab as $v => $value){
	echo "<div>";
	if (is_dir($db_path.$arrHttp["base"]."/pfts/$v")){
  		echo "<p><b>Arquivo: ".$arrHttp["base"]."/pfts/$v";
  		Analizar('pfts',$db_path,$arrHttp["base"],$v);
	}
	echo "</div>";
}
?>

<br><br>

<h3><?php echo $msgstr["analyzing"]." DEFs "; ?></h3>
<?php
//Analyses available formats in each language
foreach ($lang_tab as $v => $value){
	if (is_dir($db_path.$arrHttp["base"]."/def/$v")){
  		echo "<p><b>Arquivo: ".$arrHttp["base"]."/def/$v";
  		echo "<div style='max-height: 250px; overflow-y: scroll;'>";
  		Analizar('def',$db_path,$arrHttp["base"],$v);
	}

	echo "</div>";
}
?>



	</div> <!--./formContent-->

</div> <!--./middle-->



<div id="confirm" class="modal">
  <div class="modal-content">
    <div class="container">
      <h1>Arquivos copiados de 
      	<?php 
  		if (isset($_POST['source'])) { echo $_POST['source']; }?> para <?php if (isset($_POST['destiny'])) { echo $_POST['destiny']; }?>!</h1>
      <p>Total <?php echo $total_files;?> arquivos copiados.</p>
      <div class="clearfix">
        <a class="button btn_ok" href="javascript:ReloadSite();">OK!</a>
      </div>
    </div>
  </div>
</div>


<form name=forma1 method=post action=../dataentry/imprimir_g.php onsubmit="Javascript:return false">
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
	<input type=hidden name=Modulo value=<?php if (isset($arrHttp["Modulo"])) echo $arrHttp["Modulo"]?>>
	<input type=hidden name=tagsel>
	<input type=hidden name=Opcion>
	<input type=hidden name=vp>
</form>


<?php 

include("../common/footer.php");

//function that reads the file formats.dat inside each folder
function Analizar ($tipo,$db_path,$base,$lang){
global $msgstr;
	switch ($tipo){
		case 'pfts':
			$file="formatos.dat";
			echo "/$file</b></p>";
			if (!file_exists($db_path.$base."/pfts/$lang/".$file)) {
				echo "<font color=red>".$msgstr["falta"]." ".$file."</font><br>";
			} else {
				$fp=file($db_path.$base."/pfts/$lang/".$file);
				foreach ($fp as $value) {
					$value=trim($value);
					if ($value!=""){
						echo $value;
						$v=explode('|',$value);
						$pft=trim($v[0]).".pft";
						if ($lang==$_SESSION["lang"]) {
							echo " Ver: <a href=javascript:LeerArchivo_$v[0](\"\")>".$pft."</a>";
						}
						if (!file_exists($db_path.$base."/pfts/$lang/$pft")) 
							echo '<font color=red> <a href=javascript:Update("pft")>'.$msgstr['falta'].'</a></font>';
							echo "<br>";
			?>
			<script type="text/javascript">
			function LeerArchivo_<?php echo $v[0];?>(Opcion){
				msgwin=window.open("leertxt.php?base=<?php echo $base;?>&cipar=<?php echo $base;?>.par&lang=en&pft=s&archivo=<?php echo $pft;?>","editar","menu=no,status=yes, resizable, scrollbars,width=790")
				msgwin.focus()
			}			
			</script>
			<?php						
					}
				}
			}
			break;

		case 'def':
		$def=$db_path.$base."/def/".$lang."/";
		echo "</b>";
		if ($handle = opendir($def)) {
	    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            echo "<li>$entry</li>";
        }
    }
    closedir($handle);
	}
			
	break;			
	}
}

if (isset($_POST['source'])!="" and isset($_POST['destiny'])!="" and isset($_POST['folder'])) {
	$src=$_POST['folder'].$_POST['source'];
	$dst=$_POST['folder'].$_POST['destiny'];
	copy_directory($src, $dst);
} 


function chmod_Recursive($path, $filemode) {
 if ( !is_dir($path) ) {
  return chmod($path, $filemode);
 }

 $dh = opendir($path);
 while ( $file = readdir($dh) ) {

  if ( $file != '.' && $file != '..' ) {
   $fullpath = $path.'/'.$file;
   if( !is_dir($fullpath) ) {
    if ( !chmod($fullpath, $filemode) ){
     return false;
    }
   } else {
    if ( !chmod_Recursive($fullpath, $filemode) ) {
     return false;
    }
   }
  
  }

 }//end while

 closedir($dh);
 
if (chmod($path, $filemode)) {
  return true;
 } else {
  return false;
 }
}

function copy_directory($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);

            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
            chmod_Recursive($dst,0777);
        }
    }
    closedir($dir);
    reload_dbdef(); 
}

function reload_dbdef() {
    global $arrHttp;
	$_POST['base'] = $arrHttp["base"];
	$_POST['encabezado '] = "s";
	$_POST['folder']="";
	$_POST['source']="";
	$_POST['destiny']="";
	echo "<script type='text/JavaScript'> document.getElementById('confirm').style.display='block'; </script>";
	exit();
}

?>
