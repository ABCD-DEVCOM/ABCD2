<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      upload_html.php
 * @desc:
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/soporte.php");
//foreach($arrHttp as $var=>$value) echo "$var=$value<br>";
$tag=$arrHttp["Tag"];
$tipo=$arrHttp["Tipo"];


$files = $_FILES['userfile'];
foreach ($files['name'] as $key=>$name) {  	echo "$name<br>";
  	$max=get_cfg_var ("upload_max_filesize");
    if ((int)$files['size'][$key]==0){    	$max=get_cfg_var ("upload_max_filesize");
    	echo "upload_max_filesize = $max<br>";    	echo $msgstr["maxfilesiz"];
    	die;    }
	if ($files['size'][$key]) {
      // clean up file name
   		$name = ereg_replace("[^a-z0-9._]", "",
        	str_replace(" ", "_",
            	str_replace("%20", "_", strtolower($name)
            	)
            )
         );
     	echo "nombre del archivo $name<br>";
		echo "<html>\n";
		echo "<title>".$msgstr["uploadfile"]."</title>\n";
		echo "<script language=javascript src=js/lr_trim.js></script>\n";
		echo "<body>\n";
		echo "<font face=verdana>\n";
		switch ($tipo){			case "A":
				$fp=file($files['tmp_name'][$key]);
  				$html="";
  				foreach ($fp as $value) $html.= trim(str_replace("'","&quote;",$value));
  				echo $html;
  				break;
  			case "B":
  				/*if (strtoupper(substr($_ENVIRONMENT["OS"],0,3))== "WIN"){
					$target="pc";
					$extension="bat";
				}else{
					$target="linux";
					$extension="sh";
				}*/
				#echo $mx_path."<p>";
				#echo $files['tmp_name'][$key];
				$s=explode("." ,$name);
				$ix=count($s)-1;
				#echo '<br>'.$s[$ix]."<br>";
				$name=$db_path."wrk/".$s[0].".html";
				if (strtolower($s[$ix])=="pdf"){					echo $mx_path."pdftohtml.exe -noframes ".$files['tmp_name'][$key]."  ".$name."<br>";
					$res=exec($mx_path."pdftohtml.exe -noframes ".$files['tmp_name'][$key]."  ".$name,$contenido,$resultado);
	  				if ($resultado==0){
	  					$s=explode("." ,$name);
						$ix=count($s)-1;
						$name=$s[0].".html";
	  				}else{
	  					echo "no funcionó";
	  				    die;
	  				}
	  			}else{	  				$name=$files['tmp_name'][$key];
	  			}
	  			#sleep(10);
	  			$database=$db_path.$arrHttp["base"].'/data/'.$arrHttp["base"];
	  			echo "<br>File size $name: ".filesize($name)." bytes<br>";
	  			if (!file_exists($name)){	  				echo "$name Not created";
	  				die;	  			}

	  			if (filesize($name)>32000){	  				echo "<font color=red>File too big. Max=32K";
	  				die;	  			}
	  			if ($arrHttp["Mfn"]=="New"){
	  				echo "COMMAND: ".$mx_path."mx null \"proc='Gload/".$arrHttp["Tag"]."/nonl=$name'\" append=$database now -all count=1<P>";
  					$res=exec($mx_path."mx null \"proc='Gload/".$arrHttp["Tag"]."=$name'\" append=$database now -all count=1");
  				}else{
  					echo "COMMAND: ".$mx_path."mx $database from=".trim($arrHttp["Mfn"])." to=".trim($arrHttp["Mfn"])." \"proc='Gload/".$arrHttp["Tag"]."/nonl=$name'\"  updatf=$database now -all count=1<P>";
  					$res=exec($mx_path."mx $database from=".$arrHttp["Mfn"]." to=".$arrHttp["Mfn"]." \"proc='Gload/".$arrHttp["Tag"]."/nonl=$name'\"  updatf=$database now -all count=1");
  				}
  				break;		}
        if ($res==""){        	echo "<H4><font color=red>Copied to the tag ".$arrHttp["Tag"]."</font>";
        	if ($arrHttp["Mfn"]=="New")
        		echo "<script>window.opener.top.maxmfn++;window.opener.top.Menu('ultimo')</script>";
        	else
        		echo "<script>window.opener.top.Menu('same')</script>";
        }
		#unlink($files['tmp_name'][$key]);

   	}
}

	echo "</body>\n";
	echo "</html>\n";

?>
<script>

    window.opener.SetFckeditor('<?php echo $tag?>','<?php echo $html?>')




</script>