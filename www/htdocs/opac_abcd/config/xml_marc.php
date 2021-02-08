<?php
$url_back="procesos_base.php?base=".$_REQUEST["base"].'&';
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_MARCXML";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_MARCXML";
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
if (!isset($_SESSION["db_path"])){	echo "Session expired";die;}
$db_path=$_SESSION["db_path"];
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){	$lang=$_REQUEST["lang"];
	$archivo=$db_path.$_REQUEST["base"]."/pfts/marcxml.pft";
	$fout=fopen($archivo,"w");
	$Pft=$_REQUEST["Pft"];
	fwrite($fout,$Pft."\n");
	fclose($fout);
    echo "<p><h3><font color=red>". $_REQUEST["base"]."/pfts/marc2xml.pft"." ".$msgstr["updated"]."</font></h3>";
    die;
}

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){?>
	<div id="page" style="min-height:400px";>
	    <h3><?php echo $msgstr["xml_marc"]." &nbsp";
	    include("wiki_help.php");
	//DATABASES
	echo "<h4>".$msgstr["db"]." ".$_REQUEST["base"]."<p>";
	echo "<strong>".$msgstr["xml_step2"]."</strong></h4>";
	echo "<form name=marcxml method=post id=marcxml>\n";
	echo "<input type=hidden name=base value=".$_REQUEST["base"].">\n";
	echo "<input type=hidden name=db_path value=".$_REQUEST["db_path"].">\n";
	echo "<input type=hidden name=cookie>\n";
	echo "<input type=hidden name=marc_sch value=\"Y\">\n";
	echo "<input type=hidden name=Opcion value=Guardar>";
	$fdt_file=file($db_path.$_REQUEST["base"]."/def/".$_REQUEST["lang"]."/".$_REQUEST["base"].".fdt");
	foreach($fdt_file as $value) {		if (substr($value,0,3)=="LDR"){			$leader_file=file($db_path.$_REQUEST["base"]."/def/".$_REQUEST["lang"]."/leader.fdt");
			foreach ($leader_file as $l_lin){				$l=explode('|',$l_lin);
				if ($l[0]=="S"){					$tag=$l[1];
					$pos=substr($tag,2);
					$leader[$pos]=$tag;				}			}
		}else{			$fdt=explode('|',$value);
			if ($fdt[1]!="")
			 	$fdt_tag[$fdt[1]]=$fdt[5];		}
	}
	//echo "<pre>";print_r($leader);echo "</pre>";
	//echo "<pre>";print_r($fdt_tag);echo "</pre>";
	$marc_leader="";
	$ixpos=1;
	$pos_ant=0;
	if (isset($leader)){
		foreach ($leader as $pos=>$tag){			//echo $pos_ant." - $pos<br>";
			if ($pos-$pos_ant==1){
				$marc_leader.=",v$tag,";
				$ixpos=$ixpos+1;
			}else{				$marc_leader.="'";				for ($i=$ixpos;$i<$pos;$i++){
					$marc_leader.='-';
				}
				$marc_leader.="',v".$tag.',';
			}
			$pos_ant=$pos;		}
	}
	//echo "<xmp>$marc_leader</xmp>";
	$archivo=$db_path."opac_conf/marc_sch.xml";
	if (!file_exists($archivo))
		$archivo="marc.xml";
	echo "<textarea rows=25 cols=90 name=Pft>\n";
	$fp=file($archivo);
	$cerrar="";
	$fi="";
	$cerrarParentesis="";
	foreach ($fp as $value){		if (trim($value)=="") continue;
		$value=trim($value);
		$ixpos1=strpos($value,'<');
		$ixpos2=strpos($value,'>');
		$meta=substr($value,$ixpos1+1,$ixpos2-($ixpos1+1));
		$ix=strpos($meta,'tag=');
		If (!$ix)
			$ix=strpos($meta,'code=');
		if ($ix) $meta=substr($meta,0,$ix-1);
		switch ($meta){
			case "marc:leader";
				if ($marc_leader!=""){
					$ixpos1=strpos($value,'>');
					$ixpos2=strpos($value,'<',2);
					$value="'".substr($value,0,$ixpos1+1)."'$marc_leader'".substr($value,$ixpos2)."'/";
					echo "$value\n";
				}
				break;
			case "marc:controlfield":
				$tt=strpos($value,'tag="');
				$tag=substr($value,$tt+5);
				//echo "--$tag<br>";
				$tt=strpos($tag,'"');
				$tag=substr($tag,0,$tt);
				//echo "**$tag**";
				$ixpos1=strpos($value,'>');
				$ixpos2=strpos($value,'<',2);
				$value="'".substr($value,0,$ixpos1+1)."'v$tag'".substr($value,$ixpos2)."'";
				echo "if p(v$tag) then ";
				echo "$value/ ";
				echo "fi,\n";
				break;
        	case "marc:datafield";
        		$cerrarParentesis="S";
        		$tt=strpos($value,'tag="');
				$tag=substr($value,$tt+5);

				//echo "--$tag<br>";
				$tt=strpos($tag,'"');
				$tag=substr($tag,0,$tt);
				$indicador1=" ";
				$indicador2=" ";
				if (isset($fdt_tag[$tag])){					if (substr($fdt_tag[$tag],0,1)==1){
						$indicador1="'v$tag*0.1'";
						$indicador2="'v$tag*1.1'";
					}
				}
				$value=str_replace('ind1=" "',"ind1=\"$indicador1\"",$value);
				$value=str_replace('ind2=" "',"ind2=\"$indicador2\"",$value);
                echo "(if p(v$tag) then \n";
				echo "     '$value'/\n";
				$fi = "fi/";
				break;
			case "marc:subfield";
				$ixpos1=strpos($value,"code=\"");
				$xsubc=substr($value,$ixpos1+6,1);
				$tag_subc=$tag.'^'.$xsubc;
				$ixpos1=strpos($value,'>');
				$ixpos2=strpos($value,'<',2);
				$value="'".substr($value,0,$ixpos1+1)."'v$tag_subc'".substr($value,$ixpos2)."'";
				$cerrarParantesis="S";
				echo "     if p(v$tag_subc) then \n";
				echo "         $value/\n";
				echo "     fi,\n";
				break;
			default:
			    if ($fi=="fi/")
			    	echo "     ";
				echo "'$value'/\n";
				echo $fi;
				if ($cerrarParentesis=="S") echo "),\n";
				echo "";
				$fi="\n";
				$cerrarParentesis="";
				break;


		}	}
	echo "</textarea>";
    echo "<p><br>";
    echo $msgstr["try_mfn"]." <input type=text name=mfn size=5 id=mfn> <input type=button value=\" ".$msgstr["send"]." \" onclick=Probar()>";
	echo "<div><img src=../images/arrow.jpg style=\"margin-top:-7px;vertical-align: middle;\"> &nbsp;<input type=submit name=guardar value=\" ".$msgstr["save"]." ".$_REQUEST["base"]."/pfts/marc2xml.pft\" \" onclick=document.marcxml.submit() style=\"font-size:15px;\"></div>";
	?>
	</form>
	</div>
<?php
}
include ("../php/footer.php");
?>
</div>
</div>
</body
</html>
<script>
document.getElementById("mfn").onkeypress = function(e) {
  var key = e.charCode || e.keyCode || 0;
  if (key == 13) {  	e.preventDefault();
  	Probar()
  }
}
function Probar(){	mfn=document.marcxml.mfn.value;
	if (mfn==0){		alert("<?php echo $msgstr["missing"]?> MFN")
		return false	}
	document.marcxml.cookie.value="c_<?php echo $_REQUEST["base"]?>_"+mfn ;
	document.marcxml.target="_blank";
	document.marcxml.action="../php/sendtoxml.php";
	document.marcxml.submit();
	document.marcxml.action="" ;}
</script>

