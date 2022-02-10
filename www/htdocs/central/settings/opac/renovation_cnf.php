<?php
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_Circulacion_y_pr%C3%A9stamos";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_Circulacion_y_pr%C3%A9stamos";

if (isset($Web_Dir)) {
    $Web_Dir = '<p style="color:darkblue;"><b>'.$Web_Dir.'</b></p>';
} else {
    $Web_Dir = '<p style="color:red;"><b>Web_Dir parameter missing</b></p>';
}


if (isset($OpacHttp)) {
    $OpacHttp = $OpacHttp;
} else {
    $OpacHttp = '';
}

?>
<form name=parametros method=post>
<input type=hidden name=db_path value=<?php echo $db_path;?>>
<input type=hidden name=lang value=<?php echo $_REQUEST["lang"];?>>
<div id="page">
	<p>
    <h3>
<?php
echo $msgstr["WEBRENOVATION"]." &nbsp; ";
include("wiki_help.php");
echo "<p>".'$ABCD_scripts_path= '.$ABCD_scripts_path."<br>";
if (!is_dir($ABCD_scripts_path)) {
	echo "Invalid path<p>";
}else{
	echo '$Web_Dir= '. $Web_Dir."<p>";
	echo '$CentralPath= '.$CentralPath."<br>";
	if (!is_dir($CentralPath."circulation"))
		echo "Invalid path<br>";
	else{
		$actualDir=getcwd();
		chdir($CentralPath."circulation");
		if (!file_exists("opac_statment_orbita.php")){
			echo "missing ".getcwd(). "opac_statment_orbita.php<p>";
		}

	}


}
echo '$CentralHttp= '.$CentralHttp. " &nbsp;Defined en central/config_opac.php. Specifies the url to be used to access the ABCD central  module";

$url = "$CentralHttp/central/circulation/ec_include.php";
$urlexists = url_exists( $url );
if (!$urlexists){
	echo "<br>".$CentralHttp. " is invalid<p>";
}
echo "<p>".$msgstr["ONLINESTATMENT"];
if (!isset($ONLINESTATMENT) or $ONLINESTATMENT!="Y")
	echo ": <font color=darkblue><strong>".$msgstr["is_not_set"]."</strong></font>";
else
    echo ": <font color=darkblue><strong>".$msgstr["is_set"]."</strong></font>";

echo "<p>".$msgstr["WEBRENOVATION"];
if (!isset($WEBRENOVATION) or $WEBRENOVATION!="Y")
	echo ": <font color=darkblue><strong>".$msgstr["is_not_set"]."</strong></font>";
else
    echo ": <font color=darkblue><strong>".$msgstr["is_set"]."</strong></font>";
Echo "<BR><font color=darkblue><strong>".$msgstr["parm_cnf_menu"]."</strong></font><br>";
echo "<H3>".$msgstr["ols_required"]."</h3>";
echo "<h4>".$msgstr["minf_loans"]." <a href=http://wiki.abcdonline.info/Configuraci%C3%B3n_del_sistema_de_pr%C3%A9stamos target=_blank><font color=blue>Loans configuration</font></a> in wiki.abcdonline.info</h4>";



function url_exists( $url = NULL ) {
	if( empty( $url ) ){
        return false;
    }

    $options['http'] = array(
        'method' => "HEAD",
        'ignore_errors' => 1,
        'max_redirects' => 0
    );
    $body = @file_get_contents( $url, NULL, stream_context_create( $options ) );

    // Ver http://php.net/manual/es/reserved.variables.httpresponseheader.php
    if( isset( $http_response_header ) ) {
        sscanf( $http_response_header[0], 'HTTP/%*d.%*d %d', $httpcode );

        // Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
        $accepted_response = array( 200, 301, 302 );
        if( in_array( $httpcode, $accepted_response ) ) {
            return true;
        } else {
            return false;
        }
     } else {
         return false;
     }
}


?>