<?php
/* Modifications
20210607 fho4abcd Created from vmx_import_iso.php
*/
/*
** Function : Combine the common part of actions operaing on the wrk folder
** This file covers only the listing of the wrkfolder/formnames,... in this file
** In order to make it suitable for multiple applications the code depends on
** variable $scriptaction. Current recognized values:
**   $scriptaction=="importiso"
**   $scriptaction=="cnviso2utf"
*/

//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>";
if ( $scriptaction=="importiso") {
    include ("../common/inc_get-dblongname.php");
    include ("../common/inc_get-dbinfo.php");
    $dbmsg_label=$msgstr["database"].":";
    $dbmsg_value=$arrHttp["dblongname"]." (".$base.") &rarr; ";
    $dbmsg_value.="<b><font color=darkred>".$msgstr["maxmfn"].": ".$arrHttp["MAXMFN"]."</font></b>";
}
$file_label=$msgstr["archivo"].": ";
$file_value=$isofile;
$wrkfolder_label=$msgstr["workfolder"].":";
// Check if wrk is readable and writable. OS dependent
clearstatcache();
if ( PHP_OS_FAMILY=="Linux") {
    if (is_executable($wrkfull)) {
        $isexec=true;
    } else {
        $isexec=false;
    }
} else {
    $isexec=true; // Executable always true for windows
}
if (is_writable($wrkfull) and is_readable($wrkfull) and $isexec ) {
    $wrkfolder_value=$wrkfull;
    $is_readablefolder=true;
} else {
    $wrkfolder_value="<span style='color:red'>".$wrkfull." <b>".$msgstr["notreadable"]."</b></span>";
    $is_readablefolder=false;
}

/* --- The confirmcount determines the progress of the action ---*/
if ($confirmcount<=0) {  /* - First screen: Select the iso file -*/
    ?>
    <form name=initform  method=post >
    <?php
        if ( !isset($arrHttp["backtoscript"])) echo "<input type=hidden name=\"backtoscript\" value=\"".$backtoscript."\">";
        if ( !isset($arrHttp["inframe"]))      echo "<input type=hidden name=\"inframe\" value=\"".$inframe."\">";
        foreach ($_REQUEST as $var=>$value){
            if ( $var!= "deleteiso" ){
                // some values may contain quotes or other "non-standard" values
                $value=htmlspecialchars($value);
                echo "<input type=hidden name=$var value=\"$value\">\n";
            }
        }
    ?>
    <table  cellspacing=5>
        <?php if ($scriptaction=="importiso") { ?>
        <tr>
            <td><?php echo $dbmsg_label;?></td><td><?php echo $dbmsg_value;?></td>
        </tr>
        <?php } ?>
         <tr>
            <td><?php echo $wrkfolder_label;?></td><td><?php echo $wrkfolder_value;?></td>
        </tr>
       <tr><td align=center colspan=2>
                <input type=button value='<?php echo $msgstr["uploadfile"];?>' onclick=Upload()></td>
    </table>
    </form>
    <?php
    // Do not continue if the folder is not readable
    if (!$is_readablefolder) die;
    // Get the list of iso files in the working folder
    $file_array = Array();
    $handle = opendir($wrkfull);
    if ($handle===false) die;// to cope with unexpected situations
    $numisofiles=0;
	while (($file = readdir($handle))!== false) {
        $info = pathinfo($file);
        if (is_file($wrkfull."/".$file) and isset($info["extension"])and $info["extension"] == "iso") {
            if ( isset($arrHttp["deleteiso"]) and $file==$arrHttp["deleteiso"]) {
                //delete the file
                unlink ($wrkfull."/".$file);
                echo "<div>".$msgstr["archivo"]." ".$file." ".$msgstr["deleted"]."</div>";
            } else {
                $file_array[]=$file;
                $numisofiles++;
            }
        }
	}
	closedir($handle);
	if (count($file_array)>=0){
        sort ($file_array);
        reset ($file_array);
        $actioncolmsg=$msgstr["seleccionar"];
        $selimg="img src='../dataentry/img/aceptar.gif' alt='" .$msgstr["selfile"]."' title='".$msgstr["selfile"]."'";
        if ($scriptaction=="cnviso2utf") {
            $actioncolmsg=$msgstr["convert"];
            $selimg="img src='../dataentry/img/barTool.png' alt='" .$msgstr["cnv_iso2utf"]."' title='".$msgstr["cnv_iso2utf"]."'";
        }
        $selimg=htmlentities($selimg);
        $delimg="img src='../dataentry/img/barDelete.png' alt='" .$msgstr["eliminar"]."' title='".$msgstr["eliminar"]."'";
        $delimg=htmlentities($delimg);
        $lisimg="img src='../dataentry/img/preview.gif' alt='" .$msgstr["ver"]."' title='".$msgstr["ver"]."'";
        $lisimg=htmlentities($lisimg);
        // Create a form with all necessary info
        // Show the list of iso files in /wrk
        ?>
        <form name=continuar  method=post >
            <input type=hidden name=confirmcount value=0>
            <input type=hidden name=deleteiso value=0>
            <input type=hidden name=isofile value=0>
            <?php
            if ( !isset($arrHttp["backtoscript"])) echo "<input type=hidden name=\"backtoscript\" value=\"".$backtoscript."\">";
            if ( !isset($arrHttp["inframe"]))      echo "<input type=hidden name=\"inframe\" value=\"".$inframe."\">";
            foreach ($_REQUEST as $var=>$value){
                if ( $var!= "deleteiso" ){
                    // some values may contain quotes or other "non-standard" values
                    $value=htmlspecialchars($value);
                    echo "<input type=hidden name=$var value=\"$value\">\n";
                }
            }
            ?>
        </form>

        <h3><?php echo $msgstr["seleccionar"]." ".$msgstr["cnv_iso"]?> </h3>
        <table bgcolor=#e7e7e7 cellspacing=1 cellpadding=4>
        <tr>
            <th><?php echo $msgstr["archivo"]?> </th>
            <th><?php echo $msgstr["ver"]?> </th>
            <th><?php echo $msgstr["eliminar"]?> </th>
            <th><?php echo $actioncolmsg?> </th>
       </tr>
        <?php
        foreach ($file_array as $file) {
            $filemsg="<b>".$file."</b><br>";
            $filemsg.="&rarr; ".$msgstr["filemod"].": ".date("Y-m-d H:i:s", filemtime($wrkfull."/".$file));
            $filemsg.=", Size: ".number_format(filesize($wrkfull."/".$file),0,',','.');
        ?> 
        <tr>
            <td bgcolor=white><?php echo $filemsg?></td>
            <td bgcolor=white><a href="javascript:ActivarMx(<?php echo "'$wrk'"?>,<?php echo "'$file'"?>)"> <<?php echo $lisimg?>> </a></td>
            <td bgcolor=white><a href="javascript:Eliminar('<?php echo $file?>')"> <<?php echo $delimg?>> </a></td>
            <td bgcolor=white><a href="javascript:Seleccionar('<?php echo $file?>')"> <<?php echo $selimg?>> </a></td>
        </tr>
        <?php
        }
        echo "</table>";
        echo "<br><div>".$numisofiles." ".$msgstr["filesfound"]." (".$msgstr["extension"]." = iso)"."</div>";
    }
}
// and here the caller must continue with the other values of $confirmcount
//==========================================================================