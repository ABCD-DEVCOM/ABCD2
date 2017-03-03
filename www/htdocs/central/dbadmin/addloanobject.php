<?php
echo "<script language=\"javascript\">
function validar()
{
if(document.form1.from.value<=0||document.form1.from.value>document.form1.to.value)
{
alert(\"Check the range!\");
event.returnValue=false;
return false;
}
return true;
}
</script>";
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
echo "<script src=../dataentry/js/lr_trim.js></script>";
echo "<body>\n";
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
	
}

echo "<a href=\"menu_mantenimiento.php?base=".$arrHttp["base"]."&encabezado=s\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong> back </strong></span>
				</a>";
//$base=$arrHttp['base']; //$_POST['base'];
echo "<br>";
echo "<br>";
echo "<br>";
?>

<div class="middle form">
	<div class="formContent">
<form action="" method="post" name="form1" target="_self" id="form1">
<label>
<strong> Base:</strong>
<?php include("../common/get_post.php");
$base=$_POST['base'];
echo $base;
?>
</label>
  <label>
  <br>
  <br>
  From
   <input type="text" name="from" id="from" />
  </label>
  <script language="javascript">//estableciendo el foco en el 1mer textbox
   document.form1.from.value="1";
  document.form1.from.focus();
  </script>
  <label>To
  <input type="text" name="to" id="to" />
    <label>
    last MFN=<?php 
  include("../common/get_post.php");
$base=$_POST['base'];
  $mx_max_mfn="$mx_path"."mx.exe ".$db_path.$base."/data/".$base;
exec($mx_max_mfn,$outmx_max_mfn,$banderamx_max_mfn);
for($i=0;$i<count($outmx_max_mfn);$i++)
{
$datosMFN.=$outmx_max_mfn[$i];
}
$split_mfn=explode("mfn=",$datosMFN);
$max_mfn=count($split_mfn);
$max_mfnM1=$max_mfn-1;
  echo "
  <script language=\"javascript\">
   document.form1.to.value=\"$max_mfnM1\";
   </script> ";
  echo $max_mfnM1 ;
  ?>
  </label>
  <label></label>
  <br />
  <br />
  
  <label>
     Field for barcode
     </label>
  <input type="text" name="field" id="field" value="82"/>
  <script>
   document.form1.field.value="82";
    </script>
       Sub-field
  <input type="text" name="tag" id="tag" value="a"/>
   <label></label><label><br />
  <br />
  
  Control number field
  <input name="cnf" type="text" id="cnf" value="1" />
  <br />
  <br />
  Number of copies
  <input name="nc" type="text" id="nc" value="3" />
   or take the number
    
   of copies from field 
   <input name="fnc" type="text" id="fnc" />
    and sub-field 
    <input type="text" name="ncsf" id="ncsf" />
    <br />
    <br />
    Type of object
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
    <br />
  </label>
  <label><br />
  </label>
  <p> 
    <label>Main Library
    <input type="text" name="ml" id="ml" />
    </label>
</p>
  <p>
    <label>Secundary Library
    <input type="text" name="sl" id="sl" />
    </label>
    </p>
  <p>
    <label></label>
    <?php
 include("../common/get_post.php");
  $base=$arrHttp["base"];
 
  echo " <input type=\"hidden\" value=\"$base\" name=\"base\"/>";
  ?>
      <input type="submit" name="sub" id="sub" value="Submit"
  onClick="javascript:validar();" />
      </label>
  </p>
  <p>&nbsp;</p>
  
</form>
</div>
<?php
include("../common/get_post.php");
$base=$_POST['base'];
$IsisScript="$Wxis"."wxis.exe IsisScript=hi.xis";
$from=$_POST['from'];
$to=$_POST['to'];
$bprinc=$_POST['ml'];;
$bsec=$_POST['sl'];
$campo=$_POST['field'];
$tag=$_POST['tag'];
$bdp="loanobjects";
$CNF=$_POST['cnf'];
$mx="$mx_path"."mx.exe $db_path".$base."/data/".$base." from=$from to=$to pft=v".$campo;
$queryNro="$mx_path"."mx.exe $db_path".$base."/data/".$base." from=$from to=$to pft=v".$CNF;
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
$mx_num_cop="$mx_path"."mx.exe $db_path".$base."/data/".$base." from=$from to=$to pft=v".$numcopiascampo;

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
else
{
echo "<script language=\"javascript\">
function validar()
{
if(document.form1.from.value<=0||document.form1.from.value>document.form1.to.value)
{
alert(\"Check the range!\");
event.returnValue=false;
return false;
}
return true;
}
</script>";
exit();
}

?>
</div>

<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>"?>
<?
include("../common/footer.php");

?>