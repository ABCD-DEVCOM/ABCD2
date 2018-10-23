<?php
require_once("../php/include.php");
require_once("auth_check.php");

auth_check_login();

$xml = simplexml_load_file( DEFAULT_DATA_PATH . 'xml/subportals.xml');
$items = count($xml->item);

$messageArray = array (
"es" =>
    array (
        "title" => "Administración: Biblioteca Virtual en Salud",
        "add" => "Añadir",
        "exit" => "Salir",
        "remove" => "Borrar",
        "rename" => "Renomear",
        "selected" => "Selecionado",
        "subportal" => "Subportal",
        "subportals" => "Subportais",
        "subportals list" => "Subportals list",
    ),
"pt" =>
    array (
        "title" => "Administração: Biblioteca Virtual em Saúde",
        "add" => "Adicionar",
        "exit" => "Sair",
        "remove" => "Remover",
        "rename" => "Renomear",
        "selected" => "Selecionado",
        "subportal" => "Subportal",
        "subportals" => "Subportais",
        "subportals list" => "Lista de subportais",
    ),
"en" =>
    array (
        "title" => "Administration: Virtual Health Library",
        "add" => "Add",
        "exit" => "Exit",
        "remove" => "Remove",
        "rename" => "Rename",
        "selected" => "Selected",
        "subportal" => "Subportal",
        "subportals" => "Subportals",
        "subportals list" => "Subportals list",
    ),
);
$message = $messageArray[$lang];

?>
<html>
    <head>
        <meta http-equiv="Expires" content="-1"/>
        <meta http-equiv="pragma" content="no-cache"/>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
        <title><?php echo $message['title']?></title>
        <link rel="stylesheet" href="../css/admin/adm.css" type="text/css"/>

        <style type="text/css">
            button {
                padding: 0 5px;
            }
        </style>
    </head>
    <body>
        <span class="identification">
            <center><?php echo$message['title']?></center>
        </span>
        <hr size="1" noshade=""/>
        <table width="100%" border="0" cellpadding="4" cellspacing="0" class="bar">
            <tr valign="top">
                <td align="left" valign="middle"><?php echo$message['subportals']?></td>
                <td align="right" valign="middle">
                    <a href="../php/xmlRoot.php?xml=xml/<?php echo$lang?>/adm.xml&xsl=xsl/adm/menu.xsl&lang=<?php echo$lang?>" target="_top"><?php echo$message["exit"]?></a>
                </td>
            </tr>
        </table>
        <hr size="1" noshade=""/>
        <br/>

        <form name="newSubportal" action="manage_subportal.php" method="POST">
            <input type="hidden" name="lang" value="<?php echo$checked['lang']?>"/>
            <table width="100%" class="tree-edit">
                <tr valign="top">
                    <td>
                        <br/>
                        <ul>
                            <li><?php echo$message['add'].' '.$message['subportal']?><br/>
                                <input type="text" name="addname" style="width:250px" id="newsubportal"/>
                                <button type="submit" name="action" value="add">+</button>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr valign="middle">
                    <td>
                        <br/>
                        <ul>
                            <li><?php echo$message['subportals list']?><br/>
                                <select name="subportal" size="15" style="width:325px">
                                    <?for ($i = 0; $i < $items; $i++){?>
                                    <option value="<?php echo(String) $xml->item[$i]['id']?>">
                                        <?php echo utf8_decode( (String) $xml->item[$i] )?>
                                    </option>
                                    <?}?>
                                </select>
                            </li>
                            <li>
                                <span style="width:11em; display:block; float:left"><?php echo$message['rename']?> <?php echo$message['selected']?></span>
                                <input type="text" name="rename" value="" id="rensubportal"/>
                                <button type="submit" name="action" value="ren">ok</button>
                            </li>
                            <li>
                                <span style="width: 11em; display:block;float:left"><?php echo $message['remove']?> $message['selected']?></span>
                                <button type="submit" name="action" value="del">-</button>
                            </li>
                        </ul>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
