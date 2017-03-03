<?php
// BEGIN CODE
// END CODE

if (isset($arrHttp["wk_tipom_1"]))
	$pref=strtolower($arrHttp["wk_tipom_1"]);
else
	$pref="";
if (isset($arrHttp["wk_tipom_2"]) and $arrHttp["wk_tipom_2"]!=""){	$pref.="_".strtolower($arrHttp["wk_tipom_2"]);}
$pref.="_".$arrHttp["base"];
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/$pref".$ext;
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/$pref".$ext;
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].$ext;
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].$ext;
if (file_exists($archivo)){
	$fp = file($archivo);
	$fp_str=implode('$%|%$',$fp);
	$fp=explode('###',$fp_str);
	$ix_fatal=-1;
	$rec_validation="";
	foreach($fp as $value){		$value=str_replace('$%|%$',' ',$value);
		$value=trim($value);
		if ($value!="") {
			$ix=strpos($value,':');
			if ($ix===false){
			}else{
				$tag_val=substr($value,0,$ix);
				$value=substr($value,$ix+1);
				$v=explode('$$|$$',$value);
				if (substr(trim($v[0]),0,1)=="@"){
					$pft_file=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".trim(substr($v[0],1));
					if (!file_exists($pft_file)) $pft_file=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".trim(substr($v[0],1));
					$v[0]="@".$pft_file;
					$rec_validation.= "'$tag_val: ',".$v[0]." ,, mpl '$$$$',";
				}else{
					$rec_validation.= "'$tag_val: ',".$v[0].",mpl '$$$$',";
				}
			}
		}
	}

	$formato=urlencode($rec_validation);
	$query="";

	switch ($ext){		case ".beg":
			switch ($arrHttp["Mfn"]){				case "New":
					$ValorCapturado="";
					if (isset($arrHttp["ValorCapturado"])){						  $VC=explode("\n",$arrHttp["ValorCapturado"]);
						  $valx=$VC[0];
						  $ixpos=strpos($valx," ");
						  $tag_vc=substr($valx,0,$ixpos);
						  $val_vc=trim(substr($valx,$ixpos+1));
						  $ValorCapturado="<$tag_vc 0>$val_vc</$tag_vc>";					}
					$ValorCapturado=$ValorCapturado."<3333 0>0</3333>";
					$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&Pft=".$formato."&ValorCapturado=".$ValorCapturado."&";

					$IsisScript=$xWxis."z3950_cnv.xis";
					break;
				default:
					if ($arrHttp["Mfn"]!=""){						if ($ValorCapturado=="")
						    $ValorCapturado.="<3333 0>".$arrHttp["Mfn"]."</3333>";
						else
							 $ValorCapturado.="<3333 0>".$arrHttp["Mfn"]."</3333>";					}
					$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&Pft=".$formato."&ValorCapturado=".$ValorCapturado;
					$IsisScript=$xWxis."z3950_cnv.xis";			}
			break;
		case ".end":
			$end_code="S";   // CREATE A DUMMY RECORD AND APLY THE VALIDATION FORMAT
			ActualizarRegistro();
			unset($end_code);
			if ($arrHttp["Mfn"]=="New")
			   	$ValorCapturado.="<3333 0>0</3333>";
			else
				if ($arrHttp["Mfn"]!="") $ValorCapturado.="<3333 0>".$arrHttp["Mfn"]."</3333>";
			$ValorCapturado=urlencode($ValorCapturado);
			$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&Pft=".$formato."&ValorCapturado=".$ValorCapturado;
			$IsisScript=$xWxis."z3950_cnv.xis";
			break;
	}
	if ($query!=""){
		include("../common/wxis_llamar.php");
		$recval_pft="";
		$res=implode("\n",$contenido);
		$linea=explode('$$$$',$res);
		$ix_fatal=-1;
		foreach ($linea as $v_value){
			if ($v_value!=""){
				$v_ix=strpos($v_value,':');
				$v_tag=trim(substr($v_value,0,$v_ix));
				$v_res=substr($v_value,$v_ix+2);
				if (trim($v_res)!=""){					if ($ext==".beg"){
						if (!isset($valortag[$v_tag]) or $valortag[$v_tag]==""){
							$valortag[$v_tag]=$v_res;
                        }
					}
					if ($ext==".end"){						if (!isset($variables["tag".$v_tag]) or trim($variables["tag".$v_tag])=="")
							$variables["tag".$v_tag]=$v_res;
					}
				}
		    }
		}
	}
}
?>