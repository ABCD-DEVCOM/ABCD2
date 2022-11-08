<?php
/*
20220925 fho4abcd repair save,add header,new style buttons, clean html
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
unset($fp);
$helpfile="tag_".$arrHttp["help"].".html";
$archivo_in="";
$archivo=$db_path.$arrHttp["base"]."/ayudas/".$_SESSION["lang"]."/".$helpfile;
$archivo_save=$archivo;
if (file_exists($archivo)){
	$archivo_in=$arrHttp["base"]."/ayudas/".$_SESSION["lang"]."/".$helpfile;
	$fp=file($archivo);
}else{
	$archivo=$db_path.$arrHttp["base"]."/ayudas/".$lang_db."/".$helpfile;
	if (file_exists($archivo)){
		$fp=file($archivo);
        $archivo_in=$arrHttp["base"]."/ayudas/".$lang_db."/".$helpfile;
	}
}
$texto="";

if (isset($fp)){
	foreach ($fp as $value) $texto.= trim($value);
}
$texto=str_replace("'","`",$texto);

include("../common/header.php");
?>
<body>
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
<script type="text/javascript">
// FCKeditor_OnComplete is a special function that is called when an editor
// instance is loaded ad available to the API. It must be named exactly in
// this way.

function Enviar(){

	document.FCKfrm.submit()
}
function FCKeditor_OnComplete( editorInstance )
{
	// Show the editor name and description in the browser status bar.
	//document.getElementById('eMessage').innerHTML = 'Instance "' + editorInstance.Name + '" loaded - ' + editorInstance.Description ;

	// Show this sample buttons.
	//document.getElementById('eButtons').style.visibility = '' ;
}

function InsertHTML()
{
	// Get the editor instance that we want to interact with.
	var oEditor = FCKeditorAPI.GetInstance('FCKeditor1') ;

	// Check the active editing mode.
	if ( oEditor.EditMode == FCK_EDITMODE_WYSIWYG )
	{
		// Insert the desired HTML.
		oEditor.InsertHtml( '- This is some <b>sample</b> HTML -' ) ;
	}
	else
		alert( 'You must be on WYSIWYG mode!' ) ;
}


function GetContents()
{
	// Get the editor instance that we want to interact with.
	var oEditor = FCKeditorAPI.GetInstance('FCKeditor1') ;

	// Get the editor contents in XHTML.
	alert( oEditor.GetXHTML( true ) ) ;		// "true" means you want it formatted.
}

function ExecuteCommand( commandName )
{
	// Get the editor instance that we want to interact with.
	var oEditor = FCKeditorAPI.GetInstance('FCK') ;

	// Execute the command.
	oEditor.Commands.GetCommand( commandName ).Execute() ;
}

function GetLength()
{
	// This functions shows that you can interact directly with the editor area
	// DOM. In this way you have the freedom to do anything you want with it.

	// Get the editor instance that we want to interact with.
	var oEditor = FCKeditorAPI.GetInstance('FCKeditor') ;

	// Get the Editor Area DOM (Document object).
	var oDOM = oEditor.EditorDocument ;

	var iLength ;

	// The are two diffent ways to get the text (without HTML markups).
	// It is browser specific.

	if ( document.all )		// If Internet Explorer.
	{
		iLength = oDOM.body.innerText.length ;
	}
	else					// If Gecko.
	{
		var r = oDOM.createRange() ;
		r.selectNodeContents( oDOM.body ) ;
		iLength = r.toString().length ;
	}

	alert( 'Actual text length (without HTML markups): ' + iLength + ' characters' ) ;
}
</script>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["edithelpfile"].": ".$helpfile?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="formContent">
    <form action="save_help_db.php" method="post"  name=FCKfrm onSubmit="Enviar();return false">
        <textarea cols="100%" id="editor1" name=FCK ><?php echo str_replace('',$app_path.'/',$texto)?></textarea>
        <input type=hidden name=Opcion>
        <input type=hidden name=archivo value="<?php echo $archivo_save?>">
        <br>
        <a class="bt bt-red" href="javascript:window.close();">
            <i class="far fa-window-close"></i> &nbsp;<?php echo $msgstr["close"]?></a>
        <a class="bt bt-blue" href=http://docs.fckeditor.net/FCKeditor_2.x/Users_Guide/Quick_Reference target=_blank>
            <?php echo $msgstr["fckeditor"]?></a>
        &nbsp; &nbsp; &nbsp; &nbsp;
        <button class="bt bt-green" type="submit"  onClick='javascript:document.FCKfrm.Opcion.value="Revisar"'>
            <i class="far fa-save"></i> &nbsp;<?php echo $msgstr["save"]?></button>
    </form>
    <div>&nbsp;</div>
</div>
<script>
    <!-- sets the initial heigth of the textbox -->
    CKEDITOR.replace( 'editor1', {
        height: 260
    } );
</script>
</body>
</html>
