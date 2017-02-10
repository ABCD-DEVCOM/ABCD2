<?php
echo "<script language=\"javascript\">
function validar()
{
if(document.form1.from.value<=0)
{
alert(\"Check the range!\");
event.returnValue=false;
return false;
}
return true;
}
</script>";
//session_start();
/*if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}*/
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");
include("../config.php");
include("../common/header.php");
$base=$arrHttp['base']; //$_POST['base'];
echo "<script src=../dataentry/js/lr_trim.js></script>";
echo "<body>\n";
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";

}
				echo "<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">Add to Loan Objects: " . $base."
			</div>
			<div class=\"actions\">";
if (isset($arrHttp["encabezado"])){
echo "<a href=\"../dbadmin/menu_mx_based.php?base=".$base."&encabezado=s\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["back"]."</strong></span></a>";
}
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento_addloanobject.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento_addloanobject.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: addloanobject.php</font>";
?>
</div>	
<div class="middle form">
	<div class="formContent">
<form id="form1" name="form1" method="post" action="">
<label>
<strong> Base:</strong>
<?php include("../common/get_post.php");
$base=$_POST['base'];
echo $base;
?>
</label>
<table>
  <tr>
  <td>
    From
	</td>
	<td>
   <input type="text" name="from" id="from" value="1"/>
 </td>
  <td>To</td>
  <td>
  <input type="text" name="to" id="to" value="9999" />
  </td>
  <td>
  last MFN=<?php 
  include("../common/get_post.php");
$base=$_POST['base'];
$OS=strtoupper(PHP_OS);
$converter_path=$mx_path;
if (strpos($OS,"WIN")=== false) 
{
$converter_path=str_replace('mx.exe','',$converter_path);
$converter_path.=$cisis_ver."mx";

}
else
$converter_path.=$cisis_ver."mx.exe";
$mx_path=$converter_path;
  $mx_max_mfn="$mx_path"." ".$db_path.$base."/data/".$base;
exec($mx_max_mfn,$outmx_max_mfn,$banderamx_max_mfn);
for($i=0;$i<count($outmx_max_mfn);$i++)
{
$datosMFN.=$outmx_max_mfn[$i];
}
$split_mfn=explode("mfn=",$datosMFN);
$max_mfn=count($split_mfn);
  echo $max_mfn-1;?>
  </td>
  </tr>
  <tr>
  <td>
  Field for barcode
  </td>
  <td>
  <input type="text" name="field" id="field" value="82"/>
  </td>
  <td>
  Sub-field
  </td>
  <td>
  <input type="text" name="tag" id="tag" value="a"/>
  </td>
 <td> 
  Control number field
  </td>
  <td>
  <input name="cnf" type="text" id="cnf" value="1" />
  </td>
  </tr>
  <tr>
   <td>
  Number of copies
  </td>
  <td>
  <input name="nc" type="text" id="nc" value="3" />
  </td>
  <td>
   or take the number of copies from field 
   </td>
   <td>
   <input name="fnc" type="text" id="fnc" />
   </td>
   <td>
    and sub-field 
	</td>
	<td>
    <input type="text" name="ncsf" id="ncsf" />
	</td>
    </tr>
	<tr>
	<td>
    Type of object
	</td>
	<td>
     <select name="type" id="type">
    <?php
	@ $fp = fopen($db_path."circulation/def/$lang/items.tab", "r");
 flock($fp, 1);
 if (!$fp)
   {
     echo "Unable to open file circulation/def/$lang/items.tab.</strong></p></body></html>";
         
     exit;

   }
   
while(!feof($fp))
{
 $order= fgets($fp, 100);
 $splitorder=explode("|",$order);
 echo "<option value=\"$splitorder[0]\"> $splitorder[1]</option>";
}
 flock($fp, 3);
  fclose($fp);
	?>
   
      
    </select>
	</td>
     <td>Main Library</td>
	 <td>
    <input type="text" name="ml" id="ml" />
    </td>
    <td>Secundary Library</td>
	<td>
    <input type="text" name="sl" id="sl" />
    </td>
   </tr>
   <tr>
   <td>
        <?php
 include("../common/get_post.php");
  $base=$arrHttp["base"];
 
  echo " <input type=\"hidden\" value=\"$base\" name=\"base\"/>";
  ?>
      <input type="submit" name="sub" id="sub" value="Submit" 
  onClick="javascript:validar();" />
  </td>
     </tr>
	 </table>
  
</form>
</div>
<?php
include("../common/get_post.php");
$base=$_POST['base'];
$IsisScript=$Wxis." IsisScript=hi.xis";
$from=$_POST['from'];
$to=$_POST['to'];
$bprinc=$_POST['ml'];;
$bsec=$_POST['sl'];
$campo=$_POST['field'];
$tag=$_POST['tag'];
$bdp="loanobjects";
$CNF=$_POST['cnf'];
$OS=strtoupper(PHP_OS);
$converter_path=$mx_path;
if (strpos($OS,"WIN")=== false) 
{
$converter_path=str_replace('mx.exe','',$converter_path);
$converter_path.=$cisis_ver."mx";

}
else
$converter_path.=$cisis_ver."mx.exe";
$mx_path=$converter_path;
$mx="$mx_path"." $db_path".$base."/data/".$base." from=$from to=$to pft=v".$campo;
$queryNro="$mx_path"." $db_path".$base."/data/".$base." from=$from to=$to pft=v".$CNF;
$cantCopias=$_POST['nc'];
$numcopiascampo=$_POST['fnc'];
$numcopiassubcampo=$_POST['ncsf'];
$type=$_POST['type'];
exec($mx,$outmx,$banderamx);
exec($queryNro,$outNro,$banderaNro);
$dospuntos=explode("..",$outmx[0]);
$dospuntosNro=explode("..",$outNro[0]);
$cantReg=0;

if($from<=$to && $to>0 && $from>0&&$to<=$max_mfn-1)
{
if(strlen($numcopiascampo)>0&& strlen($numcopiassubcampo)>0)
{
unset($strOutNumCop);
$mx_num_cop="$mx_path"." $db_path".$base."/data/".$base." from=$from to=$to pft=v".$numcopiascampo;

exec($mx_num_cop,$outmx_num_cop,$banderamx_num_cop);
$splitCantCop=explode("..",$outmx_num_cop[0]);
$numcopdef="yes";

}
$dif=$to-$from;
for($i=1;$i<=$dif+1;$i++)
{

$valor=explode("^".$tag,$dospuntos[$i-1]);
$inv=$valor[1];
$invaux=explode("^",$inv);//comprobar q no existen mas etiquetas
if(count($invaux)>0)
{
$inv=$invaux[0];
}
$Nro=$dospuntosNro[$i-1];
if($numcopdef=="yes")
{
$cantC=0;
$tmpStrSplit=$splitCantCop[$i-1];

for($it=0;$it<strlen($tmpStrSplit)-1;$it++)
{

if($tmpStrSplit[$it]=='^'&&$tmpStrSplit[$it+1]=='n')
{
$cantC++;
}
}
$cantCopias=$cantC;
}
else
{
$cantCopias=$_POST['nc'];
}

for($j=1;$j<=$cantCopias;$j++)
{

$str="<IsisScript name=hi>
<parm name=cipar><pft>'$bdp.*=$db_path"."$bdp/data/$bdp.*',/
'htm.pft=$bdp\data\$bdp.pft'</pft></parm>
<do task=update>
<parm name=db>$bdp</parm>
<parm name=fst><pft>cat('$bdp.fst')</pft></parm>
<parm name=mfn>New</parm>
<field action=define tag=1102>Isis_Status</field>
<update>
<field action=add tag=1>".$Nro."</field>
<field action=add tag=10>".$base."</field>
<field action=add tag=959>^i".$inv."-".$j."^l".$bprinc."^b".$bsec."^o$type</field>
<field action=add tag=1001>45</field>
<field action=add tag=1092>0</field>
<field action=add tag=1091>0</field>
<field action=add tag=1002>45</field>
<field action=add tag=3030>all</field>
<field action=add tag=5001>$bdp</field>
<field action=replace tag=100 split=occ><pft>(v100/)</pft></field>
<write>Unlock</write>
<display>
<pft>if val(v1102) = 0 then '<b>Created!</b><hr>' fi </pft>
<pft>if val(v1102) = 1 then '<b>Sorry, no registries created!</b><hr>' fi </pft>
</display>
</update>
</do>
</IsisScript>";
@ $fp = fopen("hi.xis", "w");

@  flock($fp, 2);

  if (!$fp)
  {
    echo "<p><strong> Error ocurred in ISIS Script."
         ."Please try again.</strong></p></body></html>";
    exit;
  }

  fwrite($fp, $str);
  flock($fp, 3);
  fclose($fp);
exec($IsisScript,$salida,$bandera);
if(count($salida[0])>0)
$cantReg++;

}
}
if($cantReg>=1)
echo "$cantReg registries created!";
else
echo "NO registries created!";
}

?>
</div>

<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>"?>
<?php
include("../common/footer.php");

?>