<?php
/*
** Allows the edit of a file with generic content (e.g. html code, and ", / ? : @ & = + $ * #")
** The lineendings of the original file are preserved (standard case, not all exceptions are honoured)
** The encoding of the target file is also preserved.
**   - Only the encodings ASCII, UTF-8 and ISO-8859-1 are tested.
**   - If ISO-8859-1 or ASCII are detected the target encoding will be Windows-1252
**     (which gives correct result for all human readable files)
** The web client delivers always UTF-8. This implies that target encoding Windows-1252 is explicitly executed
**
20240629 fho4abcd Created. Intended to replace editararchivotxt.php/editpar.php
*/
session_start();
if (!isset($_SESSION["permiso"])){
	//header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
//foreach ($arrHttp as $var=>$value) echo "$var=".htmlspecialchars($value)."<br>";//die;

include("../lang/admin.php");;
include("../lang/dbadmin.php");;
include("../lang/soporte.php");;
$archivo=str_replace("\\","/",$arrHttp["archivo"]);
$base="";
$confirmcount=0;
$backtoscript="/central/dbadmin/menu_mantenimiento.php";
$strlinend="";
$fileencoding="";
if (isset($arrHttp["base"])) $base=$arrHttp["base"];
if (isset($arrHttp["confirmcount"])) $confirmcount=$arrHttp["confirmcount"];
if (isset($arrHttp["backtoscript"])) $backtoscript=$arrHttp["backtoscript"];
if (isset($arrHttp["strlinend"])) $strlinend=$arrHttp["strlinend"];
if (isset($arrHttp["fileencoding"])) $fileencoding=$arrHttp["fileencoding"];
include("../common/header.php");
?>
<body>
<script>
function Enviar(){
	document.update.txt.value=encodeURIComponent(document.update.txt.value);
	document.update.submit()
}
</script>
<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
    <div class="breadcrumb">
    <?php echo $msgstr["editar"].": ".$archivo ?>
    </div>
    <div class="actions">
		<?php
        include "../common/inc_back.php";
		include "../common/inc_home.php";
        $savescript="javascript:Enviar()";
        if ($confirmcount==0) include "../common/inc_save.php";
        ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";?>
<div class="middle form">
<div class="formContent">
<?php
if ( $confirmcount==0 ) {
    $confirmcount++;
    // Show and edit the filecontent
    if (file_exists($db_path.$archivo)){
        $fp=file($db_path.$archivo);
	} else {
        $fp=array();
	}
	foreach ($fp as $value){
		if ( strpos($value,"\r\n") !== false) { $strlinend="CRLF";break;}
		if ( strpos($value,"\r")   !== false) { $strlinend="CR";break;}
		if ( strpos($value,"\n")   !== false) { $strlinend="LF";break;}
	}
	/*
	** Detect the number of lines and wrong code sequences in advance
	** They can be shown before the actual text area
	*/
	$wrongcodelines="";
	$numline=0;
	$detect_order=Array();
	$detect_order[]="ASCII";// to prevent that palin text files wil be marked as UTF-8
	$detect_order[]="UTF-8";
	$detect_order[]="ISO-8859-1";// must be after UTF-8: all these characters are in UTF-8
	foreach ($fp as $value) {
		$numline++;
		if (trim($value)!="") {
			/*
			** Detect encoding of this lineend
			** plain text is always UTF-8, so any wrong code gives ISO
			*/
			$encoding=mb_detect_encoding($value,$detect_order,false);
			if ($encoding=="ISO-8859-1"){
				$fileencoding="ISO-8859-1";
				break;
			} else if ($encoding=="UTF-8" && ($fileencoding=="ASCII"||$fileencoding=="")) {
				$fileencoding="UTF-8";
			} else if ($fileencoding!="UTF-8") {
				$fileencoding="ASCII";
			}
		}
	}
    ?>
	<div style='text-align:center'><h3><?php echo $arrHttp["archivo"];?></h3>
	<table style=' margin-left:auto;margin-right:auto;'>
	<tr>
		<td><?php echo $msgstr["numberoflines"];?></td><td>:&nbsp;</td><td><?php echo $numline;?></td>
	</tr><tr>
		<td><?php echo $msgstr["fileencoding"];?></td><td>:&nbsp;</td><td><?php echo $fileencoding;?></td>
	</table>
    <form name=update method=post >
    <input type=hidden name=confirmcount value=<?php echo $confirmcount?>>
    <input type=hidden name=archivo value='<?php echo $arrHttp["archivo"];?>'>
    <input type=hidden name=base value="<?php echo $base;?>">
    <input type=hidden name=backtoscript value="<?php echo $backtoscript;?>">
    <input type=hidden name=strlinend value="<?php echo $strlinend;?>">
    <input type=hidden name=fileencoding value="<?php echo $fileencoding;?>">
	<textarea name=txt rows=20 cols=100 style="font-family:courier">
<?php
//left adjusted code to ensure leftadjusted text content
foreach ($fp as $value) {
	if (trim($value)=="") {
		echo $value;
	} else {
		/*
		** htmlentities returns a blank string if it contains invalid code sequences.
		** This depends on the used encoding
		** The flags are the default flags ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401
		** The samples in our test displayed correctly
		*/
		if (trim(htmlentities($value,null,"ISO-8859-1"))=="") {
			echo $value;
		}
		else {
			echo htmlentities($value,null,"ISO-8859-1");
		}
	}
}
?>
</textarea>
    <br>
	<?php include "../common/inc_back.php";?>
	&nbsp;&nbsp;&nbsp;
    <a class="bt bt-green" href="javascript:Enviar()" ><i class="far fa-save"></i> <?php echo $msgstr["actualizar"]?></a>
	</div>
    </form>
<?php
} else if ($confirmcount>0 ) {
    // Get filedata and decode it
    $archivo=$arrHttp["archivo"];
	$txt=urldecode($arrHttp["txt"]);
	// Check old and new lineend.
	// Start with most probable end
	// Mac ends have to be done. Happy coding :)
	if ( strpos($value,"\n")   !== false) {
		// newlinend="LF";
		if ($strlinend=="CRLF") {$txt=str_replace("\n","\r\n",$txt);}
	}
	elseif ( strpos($value,"\r\n") !== false) {
		// newlinend="CRLF";
		if ($strlinend=="LF") {$txt=str_replace("\r\n","\n",$txt);}
	}

	/*
	** If not UTF-8 then convert the filedata to Windows-1252 
	** Note that the detected encoding in this case was ISO-8859-1 or ASCII.
	** For ASCII (a subset of Windows-1252 this is a correct conversion
	** The encoding detection cannot see the difference between ISO-8859-1 and Windows-1252
	** The difference here is in the meaning of codes 8A-9F
	** For ISO-8859-1 these are forbidden controlcodes
	** For Windows-1252 these are signs like ƒ † Š Œ Ÿ
	*/
	if ($fileencoding!="UTF-8") {
		$txt=mb_convert_encoding($txt,"Windows-1252","UTF-8");
	}
	// Write the file
    $fp=fopen($db_path.$archivo,"w");
    fputs($fp,$txt);
    fclose($fp);
    echo "<h4 style='text-align:center'>";
    echo $archivo." ".$msgstr["updated"];
    echo "</h4>";
}
?>
</div></div>
<?php
include("../common/footer.php");
?>