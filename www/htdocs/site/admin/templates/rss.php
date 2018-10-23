<?php echo '<?xml version="1.0" encoding="iso-8859-1"?>'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $lang?>" xml:lang="<?php echo $lang?>">
    <head>
        <title>BVS-Site Admin</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
        <link rel="stylesheet" href="../css/admin/adm.css" type="text/css" />
        <script language="javascript">
            function updateView(){
                var url = document.getElementById("buffer").value;
                url = url.replace(/%HTTP_HOST%/,"<?php echo $_SERVER["HTTP_HOST"]?>");
                window.status = url;
                rss_preview.location = url;
            }
        </script>
    </head>
    <body>
        <div class="top">
            <h1 class="identification"><?php echo $message["title"]?></h1>
        </div>
        <form id="formPage" name="formPage" action="../php/xmlRoot.php" method="post">
            <input type="hidden" name="portal" value="<?php echo $checked['portal']?>" />
            <input type="hidden" name="xml" value="xml/<?php echo $lang?>/adm.xml" />
            <input type="hidden" name="xsl" value="xsl/adm/menu.xsl" />
            <input type="hidden" name="lang" value="<?php echo $lang?>" />
            <input type="hidden" name="id" value="<?php echo $id?>" />
            <input type="hidden" name="xmlSave" value="<?php echo $xmlSave?>" />
            <input type="hidden" name="xslSave" value="<?php echo $xsl?>" />
            <div class="bar">
                <h3><?php echo $page?></h3>
                <ul class="left-options">
                    <li>&#160;</li>
                </ul>
                <ul class="right-options">
                    <li><a href="../php/xmlRoot.php?xml=xml/<?php echo $lang?>/adm.xml&xsl=xsl/adm/menu.xsl&lang=<?php echo $lang?>"><?php echo $message["exit"]?></a></li>
                </ul>
            </div>
            <ul class="button-list1">
                <li><a href="#save" onclick="document.forms[0].submit();">
                    <img src="../image/admin/common/save.png" border="0" alt=" Gravar "/>&nbsp;<?php echo $message["save"]?></a>
                </li>
            </ul>
            <div class="tree-edit">
                <label for="buffer"><?php echo $message["url"]?></label>
                <input type="text" name="buffer" id="buffer" size="70" value="<?php echo $buffer?>"/>
                <input type="button" value="verificar" onclick="javascript:updateView();"/>
                <iframe src="about:blank" name="rss_preview" style="background-color: #ffffff; width: 700px; height: 220px"></iframe>
            </div>
        </form>
    </body>
</html>