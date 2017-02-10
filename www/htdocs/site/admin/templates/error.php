<?='<?xml version="1.0" encoding="iso-8859-1"?>'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?=$lang?>" xml:lang="<?=$lang?>">
    <head>
        <title>BVS-Site Admin</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
        <link rel="stylesheet" href="../css/admin/adm.css" type="text/css" />
        <script language="javascript">
            function updateView(){
                var url = document.getElementById("buffer").value;
                url = url.replace(/%HTTP_HOST%/,"<?=$_SERVER["HTTP_HOST"]?>");
                window.status = url;
                rss_preview.location = url;
            }
        </script>
    </head>
    <body>
        <div class="top">
            <h1 class="identification">Error page</h1>
        </div>
        <form id="formPage" name="formPage">
            <br/>
            <div class="bar">
                <h3>Error</h3>
                <div class="error"><?= $php_errormsg?></div>
                <br/>
                <input type="button" value="Back" onclick="javascript:history.back()"/>
            </div>
            <br/>
            <div class="advices">
                <ul>
                    <li>Check if write permissions is set in "bases" folder for apache user</li>
                    <li>Check if the XML is well-formed</li>
                </ul>
            </div>
        </form>
    </body>
</html>