<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");
include("../config.php");
include("../common/header.php");

$base=$arrHttp["base"];
$OS=strtoupper(PHP_OS);
$converter_path=$cisis_path;

include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
echo "<div style='float:right;'> <a href=\"../dbadmin/menu_mantenimiento.php?base=".$base."&encabezado=s\" class=\"defaultButton backButton\">";
echo "<img 'src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong> back </strong></span>
				</a></div>";
echo "<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">Import ISO: " . $base."
			</div>
			<div class=\"actions\">";
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento_vmxISO_load.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento_vmxISO_load.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: vmxISO_import.php</font>";
?>
</div>
<div class="middle form">
<form action="" method="post" enctype="multipart/form-data">
 <br> <label for="archivo">Choose File:</label>
  <input type="file" name="archivo" id="archivo" />
  <br><br>
  <label>Select the operation</label>
  <select name="OpISO">
  <option>append</option>
  <option>create</option>
  </select>
 <?php
 include("../common/get_post.php");
  $base=$arrHttp["base"];
 
  echo " <input type=\"hidden\" value=\"$base\" name=\"base\"/>";
  ?>
<br><br><label>Marc format</label>
  <select name="mf">
  <option>yes</option>
  <option>no</option>
  </select>
<br><br>
  <input type="submit" value="Start"/>
  </form>

<?php

		$base=$_POST['base'];
$bd=$db_path.$base;
			
if( !isset($_FILES['archivo']) )
{
  echo '<div class=\"middle form\"><br>No file chosen yet<br/></div>';
  
}

else
{

  $nombre = $_FILES['archivo']['name'];
  $nombre_tmp = $_FILES['archivo']['tmp_name'];
  $tipo = $_FILES['archivo']['type'];
  $tamano = $_FILES['archivo']['size'];

     $limite = 5000 * 1024;

  
    if( $_FILES['archivo']['error'] > 0 )
	{
      echo 'Error: ' . $_FILES['archivo']['error'] . '<br/>';
    }
	else
	{
	echo "<h3>File upload information</h3>";
      echo 'Name: ' . $nombre . '<br/>';
      echo 'Type: ' . $tipo . '<br/>';
      echo 'Size: ' . ($tamano / 1024) . ' Kb<br/>';
      echo 'saved in: ' . $nombre_tmp;

      if( file_exists( 'subidas/'.$nombre) )
	  {
        echo '<br/>The file: ' . $nombre. " already exists";
      }
	  else
	  {
   move_uploaded_file($nombre_tmp,
          "../../../bases/wrk/" . $nombre);
		  
		  echo "<br/>Saved in: " . "../../../bases/wrk/" . $nombre;
		  $OK="OK";
      }
    }
	
  }
		  
		  
	
  if(isset($OK))
  {
  echo "<h3>Process information</h3>";
echo "File upload OK, importing ".$nombre."...";
	 $op=$_POST['OpISO'];
	$mf=$_POST['mf'];
if($mf=="no")
	 $strINV=$cisis_path."mx "."iso="."../../../bases/wrk/".$nombre." ".$op."=".$bd."/data/".$base." -all now";
else 
$strINV=$cisis_path."mx "."iso="."../../../bases/wrk/".$nombre." ".$op."=".$bd."/data/".$base." isotag1=3000 -all now";
	 exec($strINV, $output,$t);
	 $straux="";
for($i=0;$i<count($output);$i++)
{
$straux.=$output[$i]."<br>";
}
echo "<br>MX query: ".$strINV;
echo "<br>Process output: ".$straux; 
if($t==0)
echo "<br>Process OK!";
else
echo "<br>Process NOT executed!";
if($base=="")
{
echo"<br>NO database selected";
}
}
//echo "<br>"."<a href='../dbadmin/menu_mantenimiento.php?base=&encabezado=s'>Maintenance Menu</a>"."<br>";
?>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>"?>
</form>
</div>
</div>
<?php
include("../common/footer.php");
echo "</body></html>";

?>
