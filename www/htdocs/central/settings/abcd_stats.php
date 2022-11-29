<?php
/*

*/


session_start();
//ini_set('memory_limit', '1024M');   
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
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


function all_databases_list() {
global $db_path, $xWxis, $actparfolder;
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
        echo "No Collection";
    }
echo "</td>";

} else {
    $dr_path_def = "";
    echo "<td>Not exist dr_path.def</td>";
    echo "<td>Not exist dr_path.def</td>";
    echo "<td>Not exist dr_path.def</td>";
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
    ABCD Status
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
include "../common/inc_div-helper.php"
?>
<div class="middle form">
<div class="formContent">


<pre>
    URL: <?php echo $server_url;?>

    Dir Database: <?php echo $db_path;?>

    Hostname: <?php echo gethostname();?>

    DB List: <?php echo $db_path."bases.dat"; ?>
</pre>

<hr>

<h1>Databases</h1>
<table class="striped table">
    <tr>
        <th>#</th>
        <th>Database</th>
        <th>Database description</th>
        <th>Total records</th>
        <th>dr_path</th>
        <th>Codification</th>
        <th>Collection</th>
    </tr>        

<?php echo all_databases_list(); ?>

</table>



<hr>

<h1>Environment</h1>

<table class="striped table">
    <tr>
        <th>Extension</th>
        <th>Info</th>
        <th>Status</th>
    </tr>    
 <tr>
    <td>mbstring</td>
    <td>Multibyte support. To enable unicode.</td>
    <td><?php if (extension_loaded('mbstring')==1 )echo "Ok!"; else echo "Missing!"; ?></td>
</tr>

<tr>
    <td>gd</td>
    <td>Image functions. The name depends on the PHP implementation</td>
    <td><?php if (extension_loaded('gd')==1 )echo "Ok!"; else echo "Missing!"; ?></td>
</tr>
 <tr>
    <td>gd2</td>
    <td>Image functions. The name depends on the PHP implementation</td>
    <td><?php if (extension_loaded('gd2')==1 )echo "Ok!"; else echo "Missing!"; ?></td>
</tr>
 <tr>
    <td>curl</td>
    <td>Required if DSpace bridge is used (to download records from DSpace repositories)</td>
    <td><?php if (extension_loaded('curl')==1 )echo "Ok!"; else echo "Missing!"; ?></td>
</tr>
 <tr>
    <td>ldap</td>
    <td>Required if login with LDAP is used</td>
    <td><?php if (extension_loaded('ldap')==1 )echo "Ok!"; else echo "Missing!"; ?></td>
</tr>
 <tr>
    <td>xmlrpc</td>
    <td>Required if Site is used</td>
    <td><?php if (extension_loaded('xmlrpc')==1 )echo "Ok!"; else echo "Missing!"; ?></td>
</tr>
 <tr>
    <td>xsl</td>
    <td>Required if Site is used</td>
    <td><?php if (extension_loaded('xsl')==1 )echo "Ok!"; else echo "Missing!"; ?></td>
</tr>
 <tr>
    <td>yaz</td>
    <td>Required if Z39.50 client is used (to download records via the Z39.50 communication protocol)</td>
    <td><?php if (extension_loaded('yaz')==1 )echo "Ok!"; else echo "Missing!"; ?></td>
</tr>
</table>

<?php 

//print_r(implode('<br> ', get_loaded_extensions()));
//echo extension_loaded('gd2');

/**
 * mbstring
 * gd
 * gd2
 * curl
 * ldap
 * xmlrpc
 * xsl
 * yaz
 ***/

/*
$all = extension_loaded('mbstring'); 
    foreach($all as $i) { 
        $ext = new ReflectionExtension($i); 
        $ver = $ext->getVersion(); 
        echo "$i - $ver" . PHP_EOL . "<br>";
    }
*/

 ?>

 <hr>

<h1>Server Info</h1>

<?php show_phpinfo(); ?>
    
</div>


