<?php
require_once("../php/include.php");
require_once("../php/common.php");
require_once("auth_check.php");

auth_check_login();

function stripFromText($haystack, $bfstarttext, $endsection) {
    $startpostext = $bfstarttext;
    $startposlen = strlen($startpostext);
    $startpos = strpos($haystack, $startpostext);
    $endpostext = $endsection;
    $endposlen = strlen($endpostext);
    $endpos = strpos($haystack, $endpostext, $startpos);

    return substr($haystack, $startpos + $startposlen, $endpos - ($startpos + $startposlen));
}

$back = $_SERVER["HTTP_REFERER"];
$page = $_REQUEST["page"];
$id = $checked['id'];
$lang = $checked['lang'];
$action = $_POST["action"];

$xml = $localPath["xml"] . $checked["id"] . ".xml";
$xmlSave = 'xml/'.$checked['lang'].'/'.$checked["id"] . ".xml";

$admPath = substr($_SERVER['PHP_SELF'],0,strpos($_SERVER['PHP_SELF'],'htmlarea.php'));


if ( file_exists($xml) ){
    $xml = getDoc($xml);

    if ( strpos($xml,'<content>') > 0 ){
        $startTag = "<content>";
        $endTag   = "</content>";
        // retira marcas CDATA
        $xml = str_replace( array('<![CDATA[',']]>'), '', $xml);
        $textarea = trim( stripFromText($xml, $startTag, $endTag) );
        $textarea = html_entity_decode( $textarea );
    }else{
        $textarea = "";
    }
}

$messageArray = array (
"es" =>
    array (
        "title" => "Administración: ABCD Site",
        "available" => "Disponible",
        "unavailable" => "Indisponible",
        "exit" => "Salir",
        "save" => "Graba",
    ),
"pt" =>
    array (
        "title" => "Administração: ABCD Site",
        "available" => "Disponível",
        "unavailable" => "Indisponível",
        "exit" => "Sai",
        "save" => "Grava",
    ),
"en" =>
    array (
        "title" => "Administration: ABCD Site",
        "available" => "Available",
        "unavailable" => "Unavailable",
        "exit" => "Exit",
        "save" => "Save",
    ),

"fr" =>
    array (
        "title" => "Administration: ABCD Site",
        "available" => "Disponible",
        "unavailable" => "Non-disponible",
        "exit" => "Exit",
        "save" => "Sauvegarder",
    ),

"am" =>
    array (
        "title" => "Administration: ABCD Site",
        "available" => "Available",
        "unavailable" => "Unavailable",
        "exit" => "Exit",
        "save" => "Save",
    ),
);
$message = $messageArray[$lang];

//die($textarea);
?>
<html>
  <head>
    <title>BVS-Site Admin</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <script type="text/javascript" src="../bvs-mod/ckeditor/ckeditor.js"></script>

    <script type="text/javascript">
      window.onload = function()
      {
        var editor = new FCKeditor( 'buffer' ) ;
        editor.BasePath = "../bvs-mod/ckeditor/" ;
           editor.Height = "400";
        editor.Config["AutoDetectLanguage"] = false ;
        editor.Config["ProcessHTMLEntities"] = false;
        editor.Config["DefaultLanguage"] = "<?php if ($lang =='pt') echo 'pt-br'; else $lang;?>" ;

        editor.Config["LinkBrowserURL"] = "<?php echo $admPath?>editor/filemanager/browser/browser.html?Connector=connectors/php/connector.php";
        editor.Config["LinkUploadURL"]  = "<?php echo $admPath?>editor/filemanager/upload/php/upload.php?Type=File";
        editor.Config["ImageBrowserURL"]= "<?php echo $admPath?>editor/filemanager/browser/browser.html?Type=Image&Connector=connectors/php/connector.php";
        editor.Config["ImageUploadURL"] = "<?php echo $admPath?>editor/filemanager/upload/php/upload.php?Type=Image";
        editor.Config["FlashBrowserURL"]= "<?php echo $admPath?>editor/filemanager/browser/browser.html?Type=Flash&Connector=connectors/php/connector.php";
        editor.Config["FlashUploadURL"] = "<?php echo $admPath?>editor/filemanager/upload/php/upload.php?Type=Flash";

        editor.ReplaceTextarea() ;
      }
    </script>

    <link rel="stylesheet" href="../css/admin/adm.css" type="text/css" />
    <style type="text/css">
        textarea { background-color: #fff; border: 1px solid; width: 100%; margin-left: 10px;}
    </style>

  </head>

  <body>
        <form name="formPage" action="../php/xmlRoot.php" method="post">
            <input type="hidden" name="xml" value="xml/<?php echo $checked["lang"]?>/adm.xml" />
            <input type="hidden" name="xsl" value="xsl/adm/menu.xsl" />
            <input type="hidden" name="lang" value="<?php echo $checked["lang"]?>" />
            <input type="hidden" name="id" value="<?php echo $checked["id"]?>" />
            <input type="hidden" name="xmlSave" value="<?php echo $xmlSave?>" />
            <input type="hidden" name="xslSave" value="xsl/adm/save-xhtml.xsl" />
            <input type="hidden" name="portal" value="<?php echo $checked["portal"]?>" />

            <span class="identification">
                <center><?php echo $message["title"]?></center>
            </span>
            <hr size="1" noshade="" />
            <table width="100%" border="0" cellpadding="4" cellspacing="0" class="bar">
                <tr valign="top">
                    <td align="left" valign="middle"><?php echo $page; ?> <b>|</b>
                        <select name="available" size="1">
                            <option value="yes"><?php echo $message["available"]; ?></option>
                            <option value="no"><?php echo $message["unavailable"]; ?></option>
                        </select>
                        <b>|</b>
                        <a href="javascript:formPage.submit();">
                            <?php echo $message["save"]; ?>
                        </a>
                    </td>
                    <td align="right" valign="middle">
                        <a href="../php/xmlRoot.php?xml=xml/<?php echo $lang?>/adm.xml&xsl=xsl/adm/menu.xsl&lang=<?php echo $lang?>" target="_top"><?php echo $message["exit"]?></a>
                    </td>
                </tr>
            </table>
            <hr size="1" noshade="" />
            <br />
            <table width="100%" cellpadding="0" cellspacing="0" class="button-list">
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td>&#160;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table width="100%" class="tree-edit">
                <tr valign="top">
                    <td>
                       <textarea id="buffer" name="buffer" rows="20" cols="80"><?php echo trim($textarea)?></textarea>
                      <br/>
                      </td>
                </tr>
            </table>
            <table width="100%" cellpadding="0" cellspacing="0" class="button-list">
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="25">&#160;</td>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>

  </body>
</html>

