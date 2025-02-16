<?php
/*
* This script was created to display an overview about the environment where ABCD is installed.
* Running it allows you to see the total records of all databases, their encodings and the absence of main files.
* It is also possible to detect databases with execution errors.
* This file can be deleted if it poses a risk to the server.´
* 2022-12-02 rogercgui Publish the first version of this script
* 2022-12-04 fho4abcd Improvement for $actparfolder not equal to standard par/
* 2025-02-10 fho4abcd Correct index "status_inf_mbstring" to "status_inf__mbstring" (=less work as updating all language files)
*/

session_start();
//ini_set('memory_limit', '1024M');   
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");

include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");

include("../common/header.php");

$base="";
$confirmcount=0;
$backtoscript="conf_abcd.php";

function show_phpinfo() {
    ob_start();
    phpinfo(INFO_GENERAL);
    $info_php = ob_get_contents();
    ob_end_clean();
    $info_php = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $info_php);
    echo "
        <style type='text/css'>
            #phpinfo {}
            #phpinfo pre {}
            #phpinfo a:link {}
            #phpinfo a:hover {}
            #phpinfo table {border-collapse: collapse; border: 0; width: 934px; box-shadow: 0;}
            #phpinfo .center {}
            #phpinfo .center table {}
            #phpinfo .center th {}
            #phpinfo td, th {border: 1px solid #666; font-size: 75%; vertical-align: baseline; padding: 4px 5px;}
            #phpinfo img {display: none; }
        </style>
        <div id='phpinfo'>
            $info_php
        </div>
        ";
}


function exec_enabled() {
  global $db_path, $xWxis, $actparfolder, $msgstr;
  $disabled = explode(',', ini_get('disable_functions'));
  if(function_exists('exec')) {
    echo "exec() is enabled <i class='fa fa-check color-green'></i>";
} else {
    echo "<p class='color-red'><b>exec() disabled</b>: ".$msgstr['alert_disable_functions']."</p>";
}
}


function all_databases_list() {
global $db_path, $xWxis, $actparfolder, $msgstr;
$lista_bases=array();
$i="1";
if (file_exists($db_path."bases.dat")){
    $fp = file($db_path."bases.dat");
    $IsisScript=$xWxis."administrar.xis";
    
    foreach ($fp as $linea){
        $linea=trim($linea);
        if ($linea!="") {
            $ix=strpos($linea,"|");
            $llave=trim(substr($linea,0,$ix));
            $lista_bases[$llave]=trim(substr($linea,$ix+1));
            if ( $actparfolder!="par/") $actparfolder=$llave."/";
            $ABCD_cipar = $db_path.$actparfolder.$llave.".par";
            $query = "&base=".$llave."&cipar=".$ABCD_cipar."&Opcion=status";
            $dr_path = $db_path.$llave."/dr_path.def";
            include("../common/wxis_llamar.php");
            
            echo "<tr><td>".$i++."</td>";
            echo "<td>".$llave."</td><td>".$lista_bases[$llave]."</td>";

    $dbinfo_ix=-1;
    if (isset($contenido )) {
        foreach($contenido as $dbinfo_linea) {
            $dbinfo_ix=$dbinfo_ix+1;
            if ($dbinfo_ix>0) {
                if (trim($dbinfo_linea)!=""){
                    $dbinfo_a=explode(":",$dbinfo_linea);
                    if (isset($dbinfo_a[1])) $arrHttp[$dbinfo_a[0]]=$dbinfo_a[1];
                }
            }
        }
    }

   echo "<td>".$arrHttp["MAXMFN"]."</td>"; // 2        

if (file_exists($dr_path)) {
    $dr_path_def = parse_ini_file($dr_path,true);
    echo "<td>OK!</td>";
    echo "<td>";
        if (isset($dr_path_def["UNICODE"])) {
            echo $dr_path_def["UNICODE"];
        } else {
            echo "Empty";
        }
    echo "</td>";

    echo "<td>";
    if (isset($dr_path_def["COLLECTION"])) {
        echo $dr_path_def["COLLECTION"];
    } else {
       echo $msgstr["status_collection_no"];
    }
echo "</td>";

} else {
    $dr_path_def = "";
    echo "<td>".$msgstr['status_no_file']."</td>";
    echo "<td>".$msgstr['status_no_file']."</td>";
    echo "<td>".$msgstr['status_no_file']."</td>";
}
        }
    }
}

}// end function all_databases_list

?>

<style>
font::before {
    content: "Database with errors \a\a";
    white-space: pre;
}

font {
    /*display:none;*/
    font: 15px monospace;
    padding: 10px 0;
    margin-bottom: 30px;
    display: block;
}
font::after {
  border-bottom: 5px #000 solid;
  bottom: 100px;
  display: relative;
}    
</style>


<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["s_e_overview"]; ?>
	</div>
	<div class="actions">
	<?php 
		$backtoscript="conf_abcd.php";
		include "../common/inc_back.php";
		include "../common/inc_home.php";
	?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";


if ($_SERVER['SERVER_ADDR']!="::1"){
$ip_server = $_SERVER['SERVER_ADDR'];
} else {
$ip_server = getHostByName(php_uname('n'));
}


?>
<div class="middle form">
<div class="formContent">

<h1><?php echo $msgstr["status_server"]; ?></h1>

<table>
<tr>
    <th>URL:</th><td><?php echo $server_url;?></td>
</tr>
<tr>
    <th><?php echo $msgstr["status_dir_database"]; ?>:</th><td><?php echo $db_path;?></td>
</tr>
<tr>
    <th><?php echo $msgstr["status_db_list"];?>:</th><td><?php echo $db_path."bases.dat"; ?></td>
</tr>
<tr>
    <th>Scripts ABCD:</th><td><?php echo $ABCD_scripts_path;?></td>
</tr>
<tr>
    <th><?php echo $msgstr["status_path_cgi_bin"];?>:</th><td><?php echo $cgibin_path;?></td>
</tr>
<tr>
    <th>Hostname:</th><td><?php echo gethostname();?></td>
</tr>
<tr>
    <th><?php echo $msgstr["status_os"];?>:</th><td><?php echo getHostByName(php_uname('s')); ?></td>
</tr>
<tr>
    <th><?php echo $msgstr["status_machine"];?>:</th><td><?php echo getHostByName(php_uname('m')); ?></td>
</tr>

<tr>
    <th><?php echo $msgstr["status_ip"];?>:</th><td><?php echo $ip_server; ?></td>
</tr>
<tr>
    <th><?php echo $msgstr["status_direct"];?>:</th><td><?php echo exec_enabled(); ?></td>
</tr>
</table>



<hr>

<h1><?php echo $msgstr["status_disk"];?></h1>

 <?php

    $bytes_free = disk_free_space(".");
    $bytes_total = disk_total_space(".");
    $bytes_used = $bytes_total - $bytes_free;
    
    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
    $base = 1024;

    $class_free = min((int)log($bytes_free , $base) , count($si_prefix) - 1);
    $class_total = min((int)log($bytes_total , $base) , count($si_prefix) - 1);
    $class_used = min((int)log($bytes_used , $base) , count($si_prefix) - 1);

    $total_disk = sprintf('%1.2f' , $bytes_total / pow($base,$class_total)) . ' ' . $si_prefix[$class_total] . '<br />';
    $free_disk = sprintf('%1.2f' , $bytes_free / pow($base,$class_free)) . ' ' . $si_prefix[$class_free] . '<br />';
    $used_disk = sprintf('%1.2f' , $bytes_used / pow($base,$class_used)) . ' ' . $si_prefix[$class_used] . '<br />';

    

?>
<hr>

<table>
<tr><th><?php echo $msgstr["status_total_disk"];?>: </th><td><?php echo $total_disk;?></td></tr>    
<tr><th><?php echo $msgstr["status_used_disk"];?>: </th><td><?php echo $free_disk;?></td></tr>    
<tr><th><?php echo $msgstr["status_free_disk"];?>: </th><td><?php echo $used_disk;?></td></tr>    
</table>


<hr>

<h1><?php echo $msgstr["status_databases"];?></h1>
<table class="striped table">
    <tr>
        <th>#</th>
        <th><?php echo $msgstr["status_database"];?></th>
        <th><?php echo $msgstr["status_database_desc"];?></th>
        <th><?php echo $msgstr["status_total_mfns"];?></th>
        <th><?php echo $msgstr["status_dr_path"];?></th>
        <th><?php echo $msgstr["status_encoding"];?></th>
        <th><?php echo $msgstr["status_collection"];?></th>
    </tr>        
    <?php echo all_databases_list(); ?>
</table>

<hr>

<h1><?php echo $msgstr["status_environment"];?></h1>

<table width="100%" class="striped table">
    <tr>
        <th><?php echo $msgstr["status_extension"];?></th>
        <th><?php echo $msgstr["status_ext_info"];?></th>
        <th><?php echo $msgstr["status_ext_status"];?></th>
    </tr>    
 <tr>
    <td>mbstring</td>
    <td><?php echo $msgstr["status_inf__mbstring"];?></td>
    <td><?php if (extension_loaded('mbstring')==1 )echo "Ok!"; else echo $msgstr["status_ext_install"]; ?></td>
</tr>

<tr>
    <td>gd</td>
    <td><?php echo $msgstr["status_inf_gd"];?></td>
    <td><?php if (extension_loaded('gd')==1 )echo "Ok!"; else echo $msgstr["status_ext_install"]; ?></td>
</tr>
 <tr>
    <td>gd2</td>
    <td><?php echo $msgstr["status_inf_gd2"];?></td>
    <td><?php if (extension_loaded('gd2')==1 )echo "Ok!"; else echo $msgstr["status_ext_install"]; ?></td>
</tr>
 <tr>
    <td>curl</td>
    <td><?php echo $msgstr["status_inf_curl"];?></td>
    <td><?php if (extension_loaded('curl')==1 )echo "Ok!"; else echo $msgstr["status_ext_install"]; ?></td>
</tr>
 <tr>
    <td>ldap</td>
    <td><?php echo $msgstr["status_inf_ldap"];?></td>
    <td><?php if (extension_loaded('ldap')==1 )echo "Ok!"; else echo $msgstr["status_ext_install"]; ?></td>
</tr>
 <tr>
    <td>xmlrpc</td>
    <td><?php echo $msgstr["status_inf_xmlrpc"];?></td>
    <td><?php if (extension_loaded('xmlrpc')==1 )echo "Ok!"; else echo $msgstr["status_ext_install"]; ?></td>
</tr>
 <tr>
    <td>xsl</td>
    <td><?php echo $msgstr["status_inf_xsl"];?></td>
    <td><?php if (extension_loaded('xsl')==1 )echo "Ok!"; else echo $msgstr["status_ext_install"]; ?></td>
</tr>
 <tr>
    <td>yaz</td>
    <td><?php echo $msgstr["status_inf_yaz"];?></td>
    <td><?php if (extension_loaded('yaz')==1 )echo "Ok!"; else echo $msgstr["status_ext_install"]; ?></td>
</tr>
</table>


<h1><?php echo $msgstr["status_all_ext"];?></h1>
<table class="striped table">
<tr>
    <th><?php echo $msgstr["status_extension"];?></name>
    <th><?php echo $msgstr["status_inf_v"];?></th>
</tr>


<?php 
$all = get_loaded_extensions(); 
    foreach($all as $i) { 
        $ext = new ReflectionExtension($i); 
        $ver = $ext->getVersion(); 
        echo "<tr><td>".$i."</td><td> - ".$ver."</td>" . PHP_EOL . "</tr>";
    }
 ?>
</table>



</div>
</div>


<?php
include("../common/footer.php");
?>



