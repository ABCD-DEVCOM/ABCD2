<?
require_once("../auth_check.php");

auth_check_login();
$lang = ( $_REQUEST['lang'] != '' ? $_REQUEST['lang'] : 'en' );
$admPath = substr($_SERVER['PHP_SELF'],0,strpos($_SERVER['PHP_SELF'],'editor.php'));

?>
<html>
  <head>
    <title>ABCD-Site Admin</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <!--script type="text/javascript" src="../../bvs-mod/FCKeditor/fckeditor.js"></script-->
    <script src="../../../central/ckeditor/ckeditor.js"></script>
    <script>
    /**
 * Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

/* exported initSample */

if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
	CKEDITOR.tools.enableHtml5Elements( document );

// The trick to keep the editor in the sample quite small
// unless user specified own height.
CKEDITOR.config.height = 150;
CKEDITOR.config.width = 'auto';
CKEDITOR.config.entities = true;
CKEDITOR.config.entities_latin = false;
CKEDITOR.config.AutoDetectLanguage= false;
CKEDITOR.config.htmlEncodeOutput = false;
CKEDITOR.config.basicEntities = false;
CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
CKEDITOR.config.startupMode = "wysiwyg";

function initCkeditor(){
	CKEDITOR.replace( 'buffer' );

}



     function updateContent() {

        // Get the editor instance that we want to interact with.
        var content = CKEDITOR.instances.buffer.getData();
        // Get the editor contents in XHTML.

        opener.HTMLAreaElement.innerHTML = content
            .replace(/&/g,'&amp;')  // Don't
            .replace(/</g,'&#60;')  // change
            .replace(/>/g,'&#62;')  // the
            .replace(/"/g,'&#34;'); // order

        opener.HTMLAreaElement.value = content;

        window.close();
    }

    var msgModify = opener.HTMLAreaModifyButtonLabel;
    var msgCancel = opener.HTMLAreaCancelButtonLabel;
	</script>


  </head>

  <body id="main">
    <form  name="formEditor">
	<div class="adjoined-bottom">
		<div class="grid-container">
			<div class="grid-width-100">

					<!--script>document.writeln('<div id="buffer">'+opener.HTMLAreaElement.innerHTML+'</div>')</script-->
                    <script>
                    content=opener.HTMLAreaElement.innerHTML
                    a=content.replace(/&lt;/g,'<')
                    a=a.replace(/&gt;/g,'>')
                    document.writeln('<div id="buffer">'+a+'</div>')</script>
				<script>
				document.write('<div align="center">');
            document.write('  <input type="button" name="cancel" value="' + msgCancel + '" onclick="javascript: window.close();" class="button"/>');
            document.write('  <input type="button" name="ok" value="' + msgModify + '" class="button" onclick=updateContent() />');
            document.write('</div>');
            	</script>
			</div>
		</div>
	</div>
   </form>
<script>
	initCkeditor();
</script>

</body>

</html>

