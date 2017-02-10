<?php
session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);

if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
$rec_isis_len=500000;  //PHYSICAL SIZE OF EACH ISIS RECORD
include("../common/get_post.php");
include ("../config.php");
include("../lang/admin.php");
include("../lang/importdoc.php");

//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
//die;
$base=$arrHttp["base"];
function LlamarWxis($base,$ValorCapturado,$IsisScript,$query){
global $arrHttp,$xWxis,$wxisUrl,$OS,$db_path,$Wxis;
	include("../common/wxis_llamar.php");
	return ($contenido);
}

function VerStatus(){
global $arrHttp,$xWxis,$wxisUrl,$OS,$db_path,$Wxis;
	$query = "&base=".$arrHttp["base"] . "&cipar=$db_path"."par/".$arrHttp["base"].".par&Opcion=status";
 	$IsisScript=$xWxis."administrar.xis";
 	include("../common/wxis_llamar.php");
 	$ix=-1;
	foreach($contenido as $linea) {
		if (trim($linea)!=""){
			$ix=$ix+1;
			if ($ix>0) {
	  			$a=explode(":",$linea);
	  			$tag[$a[0]]=$a[1];
			}
		}
	}
	return $tag;
}

///////////////////////////////////////////////////////////////////////////////////////////////

$URL=$arrHttp["fURL"];
$Tag=$arrHttp["Tag"];
if (isset($arrHttp["storein"])){
	$storein=$arrHttp["storein"];
	if (substr($storein,0,1)=="/" ) $storein=substr($storein,1);
}else{
	$storein="";
}

$lang=$_SESSION["lang"];
if ( substr(PHP_OS,0,3) == 'WIN') {
	$target="pc";
	$copycmd="copy ";
}else{
	$target="linux";
	$copycmd="cp ";
}
if (file_exists($db_path."abcd.def")){
	$def = parse_ini_file($db_path."abcd.def");
	$cisis_ver=trim($def[$arrHttp["base"]]);
}else {
	if (isset($arrHttp["base"]))
		if (isset($def[$arrHttp["base"]]))
 			$cisis_ver=$def[$arrHttp["base"]]."/";
}
//GET THE CONVERTER PATH FROM THE MX PATH
$converter_path=$mx_path;
$i=strrpos($converter_path,"/");
$converter_path=substr($converter_path,0,$i)."/";
$tipo=$arrHttp["Tipo"];
$dbname=$arrHttp["base"];
$files=$_FILES['userfile'];
$cipar = " cipar=" . $db_path . "par/".$dbname . ".par";

$max=(int)get_cfg_var ("upload_max_filesize") * 1000000;

foreach ($files['name'] as $key=>$name){
	if (((int)$files['size'][$key]==0) || ((int)$files['size'][$key]>=(int)$max)){
		echo "size of file =" . $files['size'][$key];
		echo $msgstr["maxfilesiz"];
		die;
	}
	if ($files['size'][$key]){
	// clean up file name to make it easy to process
		$name = preg_replace("/[^a-z0-9._]/", "",
       			str_replace(" ", "_", str_replace("%20", "_", strtolower($name)))
		);
//setting folder to keep original documents
		if (file_exists($db_path.$arrHttp["base"]."/dr_path.def")){
			$def = parse_ini_file($db_path.$arrHttp["base"]."/dr_path.def");
			if (isset($def["ROOT"])){
				$dr_path=trim($def["ROOT"]).$storein."/";
			}else{
				if ($storein!="") $storein.="/";
				$dr_path=getenv("DOCUMENT_ROOT")."/bases/".$arrHttp["base"]."/$storein";
			}
		}
		$files = $_FILES['userfile'];
		// copy the original file in the htdocs/bases domain in the database folder
		$destpath = $dr_path ;
		$destpath = str_replace('\\','/',$destpath);
		$s=explode("/" ,$destpath);
		$ix=count($s);
		$destpath =  $s[$ix-2] . $s[$ix-1];
		if ($destpath==$dbname)
			$destpath="";
		else
			$destpath=$destpath.'/';
		$destfile = $dr_path .$name;
		echo "<strong>destfile=</strong>".$destfile . "<BR>";
		// THERE IS A PHP FUNCTION CALLED move_uploaded_file but often doesn't work for some reason
		//	$res=move_uploaded_file($files['tmp_name'][$key],$destfile);
		// so we use a simple copy cmd for the time being... but this is only for local network
		if ($target = 'pc'){
			$destfile = str_replace('/', '\\',$destfile);
		}
  		$cmd=$copycmd . $files['tmp_name'][$key] . ' '. $destfile;
		echo $cmd."<br>";
		$res=exec($cmd,$content,$result);
		if (!file_exists($destfile)) {
			echo "<p><font color=red>".$destfile. " ".$msgstr["fnl"]."<p>";
			die;
		}
		echo $res."<p>" ;
		//if ($res==0) echo "File uploaded to " . $destfile. "<BR>"; else echo "Problem uploading file with errno." . $res . "<BR>";
		if ($target=='linux') $converter_path = str_replace("\\", '/', $mx_path);
		// creating the upload window
		echo "<html>\n";
		echo "<title>".$msgstr["uploadfile"]."</title>\n";
		echo "<script language=javascript src=js/lr_trim.js></script>\n";
		echo "<body>\n";
		echo "<font face=verdana>\n";
		switch($tipo){
			case "B":
				if ($target=='pc') $converter_path = str_replace('/', '\\', $converter_path);
				//echo "mx_path=". $mx_path0 . "<BR>";
				$destfilename = $name;
				//echo "destfilename=".$destfilename."<BR>";
				//die;
				$s=explode("." ,$name);
				$ix=count($s)-1;
				$name = '';
                for ($i=0; $i<$ix; $i++){
                   	$name = $name.$s[$i];
				}
                $name=$db_path."wrk/".$name.".html";
				if ($target=='pc') $name = str_replace('/', '\\', $name);
				//echo "name=" . $name."<BR>";
				$redir="";
				if ($target == 'pc')
					$converterpdf = $converter_path ."pdftohtml.exe";
				else
					$converterpdf = '';
				$convertertika= $converter_path . "tika.jar";
				if ($target=='linux')  $convertertika = str_replace('\\', '/', $convertertika);
				//echo "convertertika=".$convertertika. "<BR>";
				// checking existence of pdftohtml.exe
				if (file_exists($converterpdf) && $s[$ix]== "pdf"){
					$converter=$converterpdf." -noframes -i -stdout -p ";
				}else{
					if (file_exists($convertertika)){
						$converter="java -jar ".$convertertika." -h ";
						$redir = ">";
					}else {
						echo $msgstr["convertermissing"];
						die;
					}
				}
				//the actual command to convert temporary file to html extraction
				$xcmd = $converter.$files['tmp_name'][$key]."  ".$redir.$name;
				echo $xcmd."<BR>";
				echo "<hr>";
				//die;
				$content=array();
				$res=exec($xcmd,$content,$result);
				if ($result==0){
					$texto="";
					foreach ($content as $key=>$value){
						$value=strip_tags($value,"<br>");
						$value=str_replace(" <br>","<br>",$value);
						while (strpos($value,"<br><br>"))
							$value=str_replace("<br><br>","<br>",$value);
						$value=str_replace("<br>"," ",$value);
						//$value=str_replace("\n","",$value);
					   	if (trim($value)!="" )
					   		$texto.=$value;
					}
					$campo=array();
					if (isset($arrHttp["nomultiple"])){
						$texto=substr($texto,0,$rec_isis_len);
					}
					if (strlen($texto)<=$rec_isis_len){
						$campo[]=$texto;
					}else{
						while ($texto!=""){
							$c=substr($texto,0,$rec_isis_len);
							$ix=strrpos($c," ");
							if ($ix===false or $ix==0){
								$ix=strlen($c);
							}
							if ($ix!=0){
								$campo[]=substr($texto,0,$ix);
								$texto=substr($texto,$ix);
							}else{
								$texto="";
							}
						}
					}
					//var_dump($campo);

					//die;
				}else{
	  				echo "<font color=red><p>conversion failed";
	  				echo " with error code = " . $result;
					die;
	  			}
// next part does the loading of the converted html into the ISIS-database
				$seq=0;
				//GET THE NEXT MFN TO BE ASSGINED
				$tag=VerStatus();
				$Mfn=$tag["MAXMFN"]+1;
				$ValorCapturado="";
				$total_recs=0;
				foreach ($campo as $value){
					if (trim($value)!=""){
						$total_recs=$total_recs+1;
					}
				}
				if ($arrHttp["Mfn"]=="New"){
                    $first_mfn=$Mfn;
                    $next_mfn=$Mfn;
    			}else{
    				$first_mfn=$arrHttp["Mfn"];
    				$next_mfn=$arrHttp["Mfn"];
    			}
				foreach ($campo as $value){
					if (trim($value)!=""){
						$seq=$seq+1;
						echo "<hr>$seq<br>"."length=".strlen($value)."<br>";
						echo "<font color=red>$value</font><br>";

						$ValorCapturado="<900>$seq</900>";                               //secuencia del registro
						$ValorCapturado.="<901>$total_recs</901>";                       //total de registros
						$ValorCapturado.="<902>$first_mfn</902>";                      //Mfn del primer registro
						if ($seq<$total_recs){
							$next_mfn=$next_mfn+1;
							$ValorCapturado.="<903>$next_mfn</903>";
						}
						if ($seq==1)   {
							$ValorCapturado.= "<".$URL.">".$destpath  . $destfilename."</".$URL.">";     //URL TO THE DOCUMENT
						}
                        $ValorCapturado.="<".$Tag.">".$value."</".$Tag.">";
                    	$ValorCapturado=urlencode($ValorCapturado);
						$IsisScript=$xWxis."actualizar_proc.xis";
						$Formato="/bases_abcd/bases/digilib/en/diglib";
  						$query = "&base=".$base ."&cipar=$db_path"."par/".$base.".par&login=".$_SESSION["login"]."&Mfn=" . $arrHttp["Mfn"]."&ValorCapturado=".$ValorCapturado;
						$contenido=LlamarWxis($base,$ValorCapturado,$IsisScript,$query);
						foreach ($contenido as $value) echo "	MFN: $value\n";
					}
				}
				break;
		}
            if ($result==0)	{
				echo "<H4><font color=green>" .$msgstr["documentfield"]." ".$Tag."<br>";
				echo $msgstr["urlfield"]." ".$URL."<br>";
				echo "<p><a href=javascript:VerDocumento()>".$msgstr["continuar"]."</a>";
				//echo "<script>setTimeout('self.close()',4000)</script>";
				if ($arrHttp["Mfn"]=="New")
					echo "<script>
							function VerDocumento(){
								top.maxmfn++;top.Menu('ultimo')
							}
						</script>";
				else
					echo "<script>
						function VerDocumento(){
							top.Menu('same')
						}
						</script>";
			}
		else echo "<H4><font color=red>".$msgstr["importdocfail"]."</font>";
    }
}
	echo "</body>\n";
	echo "</html>\n";
?>
