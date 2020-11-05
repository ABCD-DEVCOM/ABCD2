<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;

}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
if (!isset($arrHttp["archivo"])) {
    $arrHttp["archivo"]="";
}
if (!isset($arrHttp["carpeta"])) {
    $arrHttp["carpeta"]="";
}

$a=$msg_path."documentacion/".$arrHttp["archivo"];
unset($fp);
$texto="";
if (file_exists($a)){
	$fp = file($a);
}else{
	$t=explode("/",$arrHttp["archivo"]);
	if (isset($t[2]))
		$a=$msg_path."documentacion/en/".$t[2];
	else
		$a=$msg_path."documentacion/en/".$t[1];
	if (file_exists($a)) $fp=file($a);

}
if (isset($fp)) foreach ($fp as $value) $texto.= trim($value);
$texto=str_replace("'","`",$texto)
//
?>
<html>
	<head>
		<title>Archivos de Ayuda</title>
	</head>

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

function SetContents()
{
	// Get the editor instance that we want to interact with.
	var oEditor = FCKeditorAPI.GetInstance('FCKeditor1') ;

	// Set the editor contents (replace the actual one).
	//oEditor.SetHTML( '<?php echo $texto?>' ) ;
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
	</head>
	<body>
    <a href=http://docs.fckeditor.net/FCKeditor_2.x/Users_Guide/Quick_Reference target=_blank><?php echo $msgstr["fckeditor"]?></a>
		<form action="procesar.php" method="post"  name=FCKfrm onSubmit="Enviar();return false">
		<?php echo $msgstr["edhlp"]?>:<input type=hidden name=archivo value='<?php echo $arrHttp["archivo"]. "'>".$arrHttp["archivo"]?>
			<textarea cols="100%" id="editor1" name=FCK rows="20" ><?php echo str_replace('php',$app_path,$texto)?></textarea>
			<input type=hidden name=Opcion>
			<input type=hidden name=archivo_o value="<?php echo $arrHttp["archivo"]?>">
			<br>
			<input type="submit" value="<?php echo $msgstr["save"]?>" onClick=javascript:document.FCKfrm.Opcion.value="Revisar">  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			<input type="submit" value="<?php echo $msgstr["close"]?>" onclick=javascript:self.close()>
		</form>
		<div>&nbsp;</div>
	</body>
</html>
<script>
		CKEDITOR.replace( 'editor1', {
			height: 260
		} );
</script>