<?php
require_once("../php/include.php");
require_once("../php/common.php");
require_once("auth_check.php");

auth_check_login();

$action = $_REQUEST["action"];

$fileXml = $localPath["xml"] . $checked['id'] . ".xml";
$fileIni = $localPath["ini"] . $checked['id'] . ".ini";
$fileHtml= $localPath["html"] . $checked['id'] . ".html";


$messageArray = array (
    "es" =>
        array (
            "title" => "Administración: Biblioteca Virtual en Salud",
            "exist" => "Atención esta operación irá borrar el contenido deste componente de laa BVS.",
            "fail"  => "No fue posible borrar el componente, verifique los permisos del archivo: ",

        ),
    "pt" =>
        array (
            "title" => "Administração: Biblioteca Virtual em Saúde",
            "exist" => "Atenção esta operação irá apagar o conteúdo deste componente da BVS.",
            "fail"  => "Não foi possivel apagar o componente, verifique as permissões do arquivo: ",
        ),
    "en" =>
        array (
            "title" => "Administration: Virtual Health Library",
            "exist" => "Atention this operation will delete this component of VHL.",
            "fail"  => "Unable to delete this component, please verify permission of file: ",

        ),
    );
$messages = $messageArray[$lang];


if ( $action == "delete" ) {
    $status1 = @unlink($fileXml);
    $status2 = @unlink($fileHtml);
    $status3 = @unlink($fileIni);

    if ($status1 == false){
        die( $messages["fail"] . $fileXml );
    }
}

?>
<html>
    <head>
        <title><?=$messages["title"]?></title>
        <link rel="stylesheet" href="../css/public/skins/<?=$def['SKIN_NAME']?>/style-<?=$lang?>.css" type="text/css" media="screen"/>
        <style>
            .confirm { margin: 10px; padding: 10px; background-color: #ddffdd;}
        </style>
        <script language="JavaScript" src="../js/tree-edit.js"></script>

        <script language="JavaScript">
            var listValues = opener.listValues;
            function initialCheck(){
                <? if ( $fileXml != "" && file_exists($fileXml) ) {?>
                    if (parseInt(navigator.appVersion)>3){
                          top.resizeTo(470,510);
                        top.moveTo(350,100);
                    }
                <? } else {?>
                    del( opener.document.formPage.tree );
                    top.close();
                <? } ?>
            }
        </script>

    </head>
    <body onload="javascript:initialCheck();">
        <form action="<?=$_SERVER["PHP_SELF"]?>" name="formPage" method="GET">
            <input type="hidden" name="portal" value="<?=$checked['portal']?>"/>
            <input type="hidden" name="action" value="delete"/>
            <input type="hidden" name="id" value="<?=$checked['id']?>"/>
            <input type="hidden" name="lang" value="<?=$checked['lang']?>"/>
        </form>

        <div class="container">
            <? if ( file_exists($fileXml) ){ ?>
                <div class="confirm">
                    <b><?=$messages["exist"]?></b><br/>
                    <div align="center">
                        <input type="button" value="confirmar" onclick="javascript:document.formPage.submit();" class="submit"/>
                        <input type="button" value="cancelar"  onclick="javascript:window.close();" class="submit"/>
                    </div>
                </div>
                <div class="middle">
                    <div class="secondColumn">
                        <?
                            if ( file_exists($fileHtml) ){
                                print getDoc($fileHtml);
                            }
                        ?>
                    </div>
                </div>
            <? } ?>
        </div>

    </body>
</html>
