<?php
/*
** This script is intended for the installer to help debugging the login process with ABCD database (not LDAP)
** Does not use translations and assume ict&abcd knowledge to interprete the results
** Fixed entries are avoided to make the script more versatile.
** Note: this script can be a security risk due to showing password info 
*/
/*
20210402 fho4abcd Added test with context
20220710 fho4abcd More and improved checks, improved html and readbility, fixed security problem, option to vary some parameters
20221028 fho4abcd Show value of $postMethod + count number of entries with any expiration date (check is left to the user)
*/
?>
<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  border-color: blue;
}
td {
  padding: 5px;
}
input[type=text] {border:0px;background-color:#F5FFB7;width:400px;}
</style>
</head>
<font color=blue>Reading configuration from file '<?php echo realpath("../config.php")?></font><br><br>
<?php
include("../common/get_post.php");
include(realpath("../config.php"));
$tstphp_step=0;
$tstphp_check=0;
if (isset($arrHttp["tstphp_step"])) $tstphp_step=$arrHttp["tstphp_step"];
if ($tstphp_step==0) {
    if (isset($arrHttp["emerg_login"]) && $arrHttp["emerg_login"]!="" && $arrHttp["emerg_login"]==$adm_login) $tstphp_check++;
    if (isset($arrHttp["emerg_password"]) && $arrHttp["emerg_password"]!="" && $arrHttp["emerg_password"]==$adm_password) $tstphp_check++;
    if ($tstphp_check==2) {
        $tstphp_step=1;
    }else {
        echo "<div><font color=red>Please enter valid credentials<br></font><br></div>";
    }
}
$tstphp_hostname=gethostname();
$tstphp_logindatabase="acces";
$tstphp_loginname="abcd";
if ($tstphp_step==0){
    // show a form to request emergency login and password
    ?>
    <div>This script requires that the emergency login &amp; password are set in the configuration<br></div>
    <div>Empty values will not work. No explicit message<br></div>
    <form name=emergency action='' method='post' accept-charset=utf-8>
        <input type=hidden name="tstphp_step" value="0" >
        <table border=0>
            <tr><td>Emergency Login</td><td><input type=text name="emerg_login" value="" ></td></tr>
            <tr><td>Emergency Password</td><td><input type=text name="emerg_password" value= "" ></td></tr>
            <tr><td colspan=2><input type='submit' value='Continue' title='Continue'></td></tr>
        </table>
    </form>
    <?php
} elseif ($tstphp_step==1) {
    ?>
    <div>This form allows testing with deviations from the configuration<br></div>
    <div>No checks on the validity of your entries here<br></div>
    <div>Configuration parameter $postMethod = <?php echo $postMethod?>. (0=GET, 1=POST)<br></div>
    <form name=setvalues action='' method='post' accept-charset=utf-8>
        <input type=hidden name="tstphp_step" value="2" >
        <input type=hidden name="emerg_login" value="" >
        <input type=hidden name="emerg_password" value="" >
        <table border=0>
            <tr><td>User name (login)</td><td><input type=text name="tstphp_loginname" value="<?php echo $tstphp_loginname?>" ></td></tr>
            <tr><td>Login database ($base)</td><td><input type=text name="tstphp_logindatabase" value="<?php echo $tstphp_logindatabase?>" ></td></tr>
            <tr><td>Path to IsisScripts ($xWxis)</td><td><input type=text name="xWxis" value="<?php echo $xWxis?>" ></td></tr>
            <?php if ($wxisUrl!="") {?>
                <tr><td>Hello test: URL wxis($wxisUrl) &rarr; POST method.</td><td><input type=text name="wxisUrl" value="<?php echo $wxisUrl?>" ></td></tr>
                <input type=hidden name="Wxis" value="" >
            <?php } else { ?>
                <tr><td>Path to wxis($Wxis) &rarr; GET method</td><td><input type=text name="Wxis" value="<?php echo $Wxis?>"</td></tr>
                <input type=hidden name="wxisUrl" value="" >
            <?php } ?>
            <tr><td>Login test: Server URL ($server_url)</td><td><input type=text name="server_url" value="<?php echo $server_url?>" ></td></tr>
            <tr><td colspan=2><input type='submit' value='Continue' title='Continue'></td></tr>
        </table>
    </form>
    <?php

} else {
    // the excution of the test commands
    $tstphp_loginname=$arrHttp["tstphp_loginname"];
    $tstphp_logindatabase=$arrHttp["tstphp_logindatabase"];
    if ($actparfolder=="/")$actparfolder=$tstphp_logindatabase."/"; // initial value can be empty
    $xWxis=$arrHttp["xWxis"];
    if(isset($arrHttp["wxisUrl"])) $wxisUrl=$arrHttp["wxisUrl"];
    if(isset($arrHttp["Wxis"])) $Wxis=$arrHttp["Wxis"];
    $server_url=$arrHttp["server_url"];
?>
    <form name=reentervalues action='' method='post' accept-charset=utf-8>
        <input type=hidden name="tstphp_step" value="1" >
        <input type=hidden name="emerg_login" value="" >
        <input type=hidden name="emerg_password" value="" >
        <input type='submit' value='Modify Parameters' title='Modify Parameters'>
    </form><br><br>
<?php

echo "<hr>";
// Test of POST method
if ($wxisUrl!=""){
    echo "<font color=blue>Testing the execution of  <b>$wxisUrl</b>, NO context</font><br><hr>";
    ?>
    <table >
    <tr><td>Server URL ($server_url)</td><td><?php echo $server_url?></td></tr>
    <tr><td>Path to IsisScripts ($xWxis)</td><td><?php echo $xWxis?></td></tr>
    <?php if ($wxisUrl!="") {?>
        <tr><td>URL wxis ($wxisUrl) &rarr; POST method</td><td><?php echo $wxisUrl?></td></tr>
    <?php } else { ?>
        <tr><td>Path to wxis ($Wxis) &rarr; GET method</td><td><?php echo $Wxis?></td></tr>
    <?php } ?>
    <tr><td>Host name detected by gethostname()</td><td><?php echo $tstphp_hostname?></td></tr>
    </table>
    <?php
    echo "<font color=blue>This will always fail for tests with https configured with self-signed certificate</font><br>";
    $IsisScript=$xWxis.'hello.xis';
    if (!file_exists($IsisScript)) {
        echo "<font color=red>Script file not found : <b>".$IsisScript."</b></font><br>";
    }
    $command=$wxisUrl."?IsisScript=".$IsisScript;
    echo "Command = ".$command."<br>";
    $result =file_get_contents($command);
    echo $result;
    //-----------------------------------------------------
    echo "<hr>";
    echo "<font color=blue>Testing the execution of  <b>$wxisUrl</b>, WITH context</font><br><hr>";
    ?>
    <table >
    <tr><td>Server URL ($server_url)</td><td><?php echo $server_url?></td></tr>
    <tr><td>Path to IsisScripts ($xWxis)</td><td><?php echo $xWxis?></td></tr>
    <?php if ($wxisUrl!="") {?>
        <tr><td>URL wxis ($wxisUrl) &rarr; POST method</td><td><?php echo $wxisUrl?></td></tr>
    <?php }
          if ( $Wxis!="") { ?>
        <tr><td>Path to wxis ($Wxis) &rarr; GET method</td><td><?php echo $Wxis?></td></tr>
          <?php } ?>
    <tr><td>Host name detected by gethostname()</td><td><?php echo $tstphp_hostname?></td></tr>
    </table>
    <?php
    $command=$wxisUrl;
    $postdata="IsisScript=".$IsisScript; // $ postdata required by inc_setup-stream-context
    include "../common/inc_setup-stream-context.php";
    echo "Command = ".$command."<br>Context option = ".$postdata."<br>";
    $result =file_get_contents($wxisUrl,false,$context);
    echo $result;

    //-----------------------------------------------------
    echo "<p><hr>";
    echo "<font color=blue>Testing acces to the login database by listing the login data for a specific user (using wxis_llamar.php)</font><br><hr>";
    $IsisScript=$xWxis."login.xis";
    $tstphp_cipar=$db_path.$actparfolder.$tstphp_logindatabase.".par";
    $query = "&base=".$tstphp_logindatabase."&cipar=".$tstphp_cipar."&login=".$tstphp_loginname;
    $tstphp_fulldbpath=$db_path.$tstphp_logindatabase;
    ?>
    <table >
    <tr><td>User name (login)</td><td><?php echo $tstphp_loginname?></td><td></td></tr>
    <tr><td>Login database ($base)</td><td><?php echo $tstphp_logindatabase?></td><td></td></tr>
    <tr><td>Path to database ($db_path.$base)</td><td><?php echo $tstphp_fulldbpath?></td>
        <td><?php if (!file_exists($tstphp_fulldbpath)) {echo "<font color=red>Not found</font>";}
        elseif (!is_readable($tstphp_fulldbpath)){echo "<font color=red>Not readable</font>";}
        else{echo "Found";}?></td></tr>
    <tr><td>Parameter file (cipar)</td><td><?php echo $tstphp_cipar?></td>
        <td><?php if (!file_exists($tstphp_cipar)) {echo "<font color=red>Not found</font>";}
        elseif (!is_readable($tstphp_cipar)){echo "<font color=red>Not readable</font>";}
        else{echo "Found";}?></td></tr>
    <tr><td>PHP command script</td><td><?php echo "../common/wxis_llamar.php"?></td>
        <td><?php if (!file_exists("../common/wxis_llamar.php")) {echo "<font color=red>Not found</font>";}else{echo "Found";}?></td></tr>
    <tr><td>ISIS script ($IsisScript)</td><td><?php echo $IsisScript?></td>
        <td><?php if (!file_exists($IsisScript)) {echo "<font color=red>Not found</font>";}else{echo "Found";}?></td></tr>
    <tr><td>Query parameters ($query)</td><td colspan=2><?php echo $query?></td>
    <tr><td>Server URL ($server_url)</td><td><?php echo $server_url?></td></tr>
    </table>
    <?php
    include("../common/wxis_llamar.php");
    $tstphp_numentries=0;
    $testphp_numexp=0;
    if (sizeof($contenido)>=1 && !empty($contenido[0])) {
        ?><xmp><?php
        foreach ($contenido as $linea){
            echo "$linea";
            if (strpos($linea, '##LLAVE=')!==false) $tstphp_numentries++;;
            $lineparts=explode(" ",$linea);
            if ( sizeof($lineparts) > 3 && $lineparts[3]=="60"){
                $testphp_numexp++;
            }
        }
        ?></xmp><?php
    }
    echo "<font color=purple>".$tstphp_numentries." entries found for User name (login) = ".$tstphp_loginname."</font><br>";
    echo "<font color=purple>".$testphp_numexp." entries found with non-empty expiration date field [60]</font><br>";
} else {
    echo "<div><font color=purple>Variable \$wxisUrl is empty. No tests of <b>wxis</b> by an URL</font></div><br>";
}
/// Test of GET method
if ($Wxis!=""){
    echo "<hr>";
    echo "<font color=blue>Testing the execution of  <b>$Wxis</b></font><br>";
    echo "Command used: "."\"".$Wxis." what\" <p>";
    putenv('REQUEST_METHOD=GET');
    putenv('QUERY_STRING='."");
    unset($contenido);
    exec("\"".$Wxis."\" what" ,$contenido,$ret);
    if ($ret==1){
        echo "<font color=red>The program $Wxis could not be executed";
        die;
    }
    foreach ($contenido as $value) echo "$value<br>";
    echo "Result: <b>Ok !!!</b><p>";
    echo "<hr>";
    $script=$xWxis."hello.xis";
    echo "<font color=blue>Testing the execution of  <b>$Wxis</b> with the script <b>$script</b>: </font><br>";
    echo "Command line: ". "\"".$Wxis."\" IsisScript=$script";
    if (!file_exists($script)){
        echo "missing $script";
        die;
    }
    echo "<p>";
    putenv('REQUEST_METHOD=GET');
    putenv('QUERY_STRING='."");
    unset($contenido);
    exec("\"".$Wxis."\" IsisScript=$script ",$contenido,$ret);
    if ($ret!=0) {
        echo "no se puede ejecutar el wxis. Código de error: $ret<br>";
        die;
    }
    foreach ($contenido as $value) echo "$value<br>";

//-----------------------------------------------------
    echo "<br><hr>";
    unset ($contenido);
    echo "<div><font color=blue>Testing the acces to the login database using exec</font></div><hr>";
    $IsisScript=$xWxis."login.xis";
    $tstphp_cipar=$db_path.$actparfolder.$tstphp_logindatabase.".par";
    $query = "&base=".$tstphp_logindatabase."&cipar=".$tstphp_cipar."&login=".$tstphp_loginname."&path_db=".$db_path;
    $command="\"".$Wxis."\" IsisScript=$IsisScript ";
    $tstphp_fulldbpath=$db_path.$tstphp_logindatabase;
    ?>
    <table >
    <tr><td>User name (login)</td><td><?php echo $tstphp_loginname?></td><td></td></tr>
    <tr><td>Login database ($base)</td><td><?php echo $tstphp_logindatabase?></td><td></td></tr>
    <tr><td>Path to database ($db_path.$base)</td><td><?php echo $tstphp_fulldbpath?></td>
        <td><?php if (!file_exists($tstphp_fulldbpath)) {echo "<font color=red>Not found</font>";}
        elseif (!is_readable($tstphp_fulldbpath)){echo "<font color=red>Not readable</font>";}
        else{echo "Found";}?></td></tr>
    <tr><td>Parameter file (cipar)</td><td><?php echo $tstphp_cipar?></td>
        <td><?php if (!file_exists($tstphp_cipar)) {echo "<font color=red>Not found</font>";}
        elseif (!is_readable($tstphp_cipar)){echo "<font color=red>Not readable</font>";}
        else{echo "Found";}?></td></tr>
    <tr><td>ISIS script ($IsisScript)</td><td><?php echo $IsisScript?></td>
        <td><?php if (!file_exists($IsisScript)) {echo "<font color=red>Not found</font>";}else{echo "Found";}?></td></tr>
    <tr><td>Query parameters ($query)</td><td colspan=2><?php echo $query?></td>
    <tr><td>Command used in exec</td><td colspan=2><?php echo $command?></td></tr>
    </table>
    <?php
    putenv('REQUEST_METHOD=GET');
    putenv('QUERY_STRING='."?xx=".$query);
    exec($command,$contenido);
    foreach ($contenido as $linea){
        echo "$linea";
    }
//-----------------------------------------------------
    echo "<br><hr>";
    echo "<div><font color=blue>Testing the acces to the login database using wxis_llamar.php</font></div><hr>";
    $IsisScript=$xWxis."login.xis";
    $tstphp_cipar=$db_path.$actparfolder.$tstphp_logindatabase.".par";
    $query = "base=".$tstphp_logindatabase."&cipar=".$tstphp_cipar."&login=".$tstphp_loginname;
    $tstphp_fulldbpath=$db_path.$tstphp_logindatabase;
    ?>
    <table >
    <tr><td>User name (login)</td><td><?php echo $tstphp_loginname?></td><td></td></tr>
    <tr><td>Login database ($base)</td><td><?php echo $tstphp_logindatabase?></td><td></td></tr>
    <tr><td>Path to database ($db_path.$base)</td><td><?php echo $tstphp_fulldbpath?></td>
        <td><?php if (!file_exists($tstphp_fulldbpath)) {echo "<font color=red>Not found</font>";}
        elseif (!is_readable($tstphp_fulldbpath)){echo "<font color=red>Not readable</font>";}
        else{echo "Found";}?></td></tr>
    <tr><td>Parameter file (cipar)</td><td><?php echo $tstphp_cipar?></td>
        <td><?php if (!file_exists($tstphp_cipar)) {echo "<font color=red>Not found</font>";}
        elseif (!is_readable($tstphp_cipar)){echo "<font color=red>Not readable</font>";}
        else{echo "Found";}?></td></tr>
    <tr><td>PHP command script</td><td><?php echo "../common/wxis_llamar.php"?></td>
        <td><?php if (!file_exists("../common/wxis_llamar.php")) {echo "<font color=red>Not found</font>";}else{echo "Found";}?></td></tr>
    <tr><td>ISIS script ($IsisScript)</td><td><?php echo $IsisScript?></td>
        <td><?php if (!file_exists($IsisScript)) {echo "<font color=red>Not found</font>";}else{echo "Found";}?></td></tr>
    <tr><td>Query parameters ($query)</td><td colspan=2><?php echo $query?></td>
    </table>
    <?php
    unset($contenido);
    include("../common/wxis_llamar.php");
    $tstphp_numentries=0;
    $testphp_numexp=0;
    if (sizeof($contenido)>=1 && !empty($contenido[0])) {
        foreach ($contenido as $linea){
            echo "$linea";
            if (strpos($linea, '##LLAVE=')!==false) $tstphp_numentries++;
            $lineparts=explode(" ",$linea);
            if ( sizeof($lineparts) > 3 && $lineparts[3]=="60"){
                $testphp_numexp++;
            }
        }
    }
    echo "<font color=purple>".$tstphp_numentries." entries found for User name (login) = ".$tstphp_loginname."</font><br>";
    echo "<font color=purple>".$testphp_numexp." entries found with non-empty expiration date field [60]</font><br>";
}
}
?>
