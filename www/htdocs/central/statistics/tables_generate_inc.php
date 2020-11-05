<?php
function LeerVariables($db_path,$arrHttp,$lang_db){
	$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/stat.cfg";
	if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/stat.cfg";
	if (!file_exists($file)){
		$error="S";
	}else{
		$tab_vars=file($file);
	}
	return $tab_vars;
}

// SE LEEN LOS REGISTROS DE LA BASE DE DATOS
function LeerRegistros($contenido){
global $trow,$tcol,$rows,$cols,$tabs,$tab,$tipo,$filter_date;
	$descartar="";
	$ix=-1;

	foreach ($contenido as $value){
		if (trim($value)!="" and trim($value)!='$$$$'){
			$rec=explode('****',$value);
            $i=-1;
			foreach ($rec as $linea){				$i=$i+1;
				if (isset($_REQUEST["year_from"]) and trim($_REQUEST["year_from"])!=""){					$fecha_comp=$_REQUEST["year_from"];
					if (isset($_REQUEST["month_from"]) and $_REQUEST["month_from"]!="")
						$fecha_comp.=$_REQUEST["month_from"];
					$fecha_comp=str_replace('$',"",$fecha_comp);
					$len=strlen($fecha_comp);
				}
                $linea=trim($linea);
				$x=explode('|',$tabs[$i]);
				$trow=$x[1];
				if (isset($x[2]) and $x[2]!="LMP")
					$tcol=$x[2];
				else
					$tcol="";
				$row_col=explode('¬¬¬¬¬',$linea);
				foreach ($row_col as $rrcc){					if(trim($rrcc)=="") continue;
					$rrcc.='$$$$';
					$t=explode('$$$$',$rrcc);
                    $descartar="";
                    if (isset($filter_date[$i]) and isset($fecha_comp)){
						switch ($filter_date[$i]){
							case "rows":
							case "r":
								if (substr($t[0],0,$len)!=$fecha_comp)
									$descartar="Y";
								break;
							case "cols":
								if (substr($t[1],0,$len)!=$fecha_comp)
									$descartar="Y";
								break;
						}
					}
					if ($descartar=="Y") continue;
					if (isset($t[0]) and !isset($t[1])) $t[1]="";
					if ($trow!="" and $tcol!=""){
						if (!isset($tab[$i][$t[0]][$t[1]]))
							$tab[$i][$t[0]][$t[1]]=1;
						else
							$tab[$i][$t[0]][$t[1]]=$tab[$i][$t[0]][$t[1]]+1;
						if (!isset($rows[$i][$t[0]])) $rows[$i][$t[0]]=$t[0];
						if (!isset($cols[$i][$t[1]]))$cols[$i][$t[1]]=$t[1];
					}else{
						if ($trow!=""){
							if (!isset($tab[$i][$t[0]]))
								$tab[$i][$t[0]][""]=1;
							else
					    		$tab[$i][$t[0]][""]=$tab[$i][$t[0]][""]+1;
							$rows[$i][$t[0]]=$t[0];
						}else{
							if (!isset($tab[$i][""][$t[1]]))
								$tab[$i][""][$t[1]]=1;
							else
								$tab[$i][""][$t[1]]=$tab[$i][""][$t[1]]+1;
							$cols[$i][$t[1]]=$t[1];
						}
					}
				}
			}
		}
	}

}

// SE CONSTRUYE EL FORMATO PARA LA TABLA DE FRECUENCIA
function Frecuencia($rc){
	$rc=trim(stripslashes($rc));
	$tabla=explode('|',$rc);
	$Formato=$tabla[0];
	$trow=$tabla[1];
	$tcol=$tabla[2];
	$Formato=$tabla[1];
	$Formato.="$$$$".$trow."$$$$".$tcol;
	if (strpos($Formato,"/")===false) $Formato.="'$$$$'/";
	return ($Formato);
}

// SE CONSTRUYE EL FORMATO PARA LA TABLA DE CONTINGENCIA
function Contingencia($tabla_L,$tab_vars){
	$filter_d="";	$lmp="";
	$excluir="";
// SE LEE LA LISTA DE VARIABLES PARA FORMAR LA TABLA
	$tabla_L=urldecode($tabla_L);
	$tabla=explode('|',$tabla_L); //[0]=NOMBRE DE LA TABLA, [1]=VARIABLE FILAS , [2]=VARIABLE COLUMNAS  ,
	$pft_row="";
	$pft_col="";
	foreach ($tab_vars as $value) {
		$value=trim($value);
		if ($value!=""){
			$t=explode('|',$value);
			if ($tabla[1]== $t[0]){
				$pft_row=$t[1];
				if(isset($t[2])and $t[2]=="LMP"){
					$lmp=$t{2};
					$excluir=$t[3];
				}else{					if (isset($t[2]) and $t[2]=="true")
						$filter_d="rows";
				}
			}
		}
	}
    if (isset($tabla[2]) and $tabla[2]!=""){
		foreach ($tab_vars as $value) {
			$value=trim($value);
			if ($value!=""){
				$t=explode('|',$value);
				if ($tabla[2]== $t[0]){
					$pft_col=$t[1];
					if (isset($t[2]) and $t[2]=="true")
						$filter_d="cols";
				}
			}
		}
	}
	$Formato=$pft_row."'$$$$'".$pft_col."'$$$$'/";
	return array($Formato,$lmp,$excluir,$filter_d);
}

function LosMasPrestados($tab,$maximo){
//echo $maximo;die;
	foreach ($tab as $key=>$value){
		if ($value[""]>$maximo)
			$arreglo[$key]=$value[""];

	}

	arsort($arreglo);
	foreach ($arreglo as $key=>$value){
		echo "<tr><td bgcolor=#ffffff>".$key."</td>";
		echo "<td bgcolor=#ffffff>".$value."</td></tr>\n";
		if (!isset($total_cols))
			$total_cols=$value;
		else
			$total_cols=$total_cols+$value;
	}
	echo "<tr><td>Total</td><td>$total_cols</td></tr></table>\n";
}

function ConstruirFormato($arrHttp,$lang_db,$tab_vars,$db_path){
global $tabla,$tit_proc,$tabs,$tipo,$filter_date;
	$filter_date=array();
	switch ($_REQUEST["Accion"]){
		case "Procesos":
			$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tabs.cfg";
			if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/tabs.cfg";
			$file=file($file);
			$i=0;
			foreach ($file as $value){
				$value=trim($value);
				if ($value!=""){
					$v=explode("|",$value);
					$tabla[$v[0]]=$value;
				}
			}
			$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tables.cfg";
			if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/tables.cfg";
			if (file_exists($file)){
				$file=file($file);
				$i=0;
				foreach ($file as $value){
					$value=trim($value);
					if ($value!=""){
						$v=explode("|",$value);
						$tabla[$v[0]]=$value;
					}
				}
			}
			$proc=explode("|",urldecode($_REQUEST["proc"]));
			$tit_proc="**";
			$Formulas="";
			foreach ($proc as $value){				if ($tit_proc=="**"){
					$tit_proc=$value;
				}else{
					$PFT="";
					$value=trim($value);
					if ($value!=""){
						$txx=explode('{{',$value);
						$value=$txx[0];
						if(isset($txx[1])) $PFT="PFT";
						$tabs[]=$tabla[$value];

	                    if ($PFT=="PFT"){	                    	$For=explode('|',$tabla[$value]);
							$Formato=str_replace("/","'¬¬¬¬¬'",$For[3]);
							$tipo[]=$For[1].'|'.$For[2];
							if (isset($For[4])) $filter_date[]=$For[4];
	                    }else{
							$For=Contingencia($tabla[$value],$tab_vars);
							$Formato=$For[0];
		                    $tipo[]=$For[1].'|'.$For[2];
		                    if (isset($For[3]))
		                    	$filter_date[]=$For[3];
							$Formato=str_replace("/","",$Formato);
						}
						if ($Formulas=="")
							$Formulas=$Formato;
						else
							$Formulas.="'****'".$Formato;
					}

				}
			}
			$Formato=$Formulas."/";
			break;
		case 'Tablas':
			$tabs[]=stripslashes($arrHttp["tables"]);
			$txx=explode('{{',stripslashes($arrHttp["tables"]));
			if (isset($txx[1]) and $txx[1]=="PFT"){
				$For=explode('|',$txx[0]);
				$Formato=$For[3]."/";
				$tipo[]=$For[1].'|'.$For[2];

			}else{
				$For=Contingencia($_REQUEST["tables"],$tab_vars);
				$Formato=$For[0];
				$tipo[]=$For[1].'|'.$For[2];
			}
            if (isset($For[4])) $filter_date[]=$For[4];
          //  echo $filter_date."****<p>";
			break;
		case 'Variables':
			if (isset($arrHttp["rows"]) and isset($arrHttp["cols"])){
				$arrHttp["rows"]=stripslashes($arrHttp["rows"]);
				$arrHttp["cols"]=stripslashes($arrHttp["cols"]);
				$t=explode('|',$arrHttp["rows"]);

				$titulo=$t[0];
				$tipo[]="";
				$pft_rows=$t[1];
				$tit_rows=$t[0];
				$t=explode('|',$arrHttp["cols"]);
				$pft_cols=$t[1];
				$titulo.='/'.$t[0];
				$tt="|".$t[0];

				$tabs[0]=$titulo."|".$tit_rows."|".$t[0];
				$tabla[$titulo]=$titulo."|".$tt;
				$arrHttp["tables"]=$tabs[0];
				$Formato=$pft_rows."'$$$$'".$pft_cols."/";
			}else{
		 		if (isset($arrHttp["rows"])){
		 			$arrHttp["rows"]=urldecode($arrHttp["rows"]);
		 			$t=explode('|',$arrHttp["rows"]);
		 			$titulo=$t[0];
		 			$xlmpx="";
		 			if (isset($t[2]) and $t[2]=="LMP"){
		 				$xlmpx=$t[2]."|".$t[3];
		 			}
		 			$tabs[]=$titulo."|".$t[0]."|".$xlmpx;
	                $tipo[]=$xlmpx;
		 			$tabla[$titulo]=$titulo."|".$t[0]."|".$xlmpx;
		 			$ff=explode('/',$t[1]);
		 			$Formato="";
		 			foreach ($ff as $pft){
		 				$Formato.=$pft."'$$$$'/";
		 			}



		 		}else{
		 			if (isset($arrHttp["cols"])) {
		 				$t=explode('|',$arrHttp["cols"]);
		 				$titulo=$t[0];
		 				$tabs[]=$titulo."||".$t[0];
		 				$Formato='$$$$'.$t[1].'/';
		 				$tipo[]="";
		 			}
		 		}
		 	}
		 	break;
	}
	return $Formato;
}

function SeleccionarRegistros($arrHttp,$db_path,$Formato,$xWxis){global $msgstr;
	switch ($_REQUEST["Opcion"]){
		case "FECHAS":
			$file_date=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/date_prefix.cfg";
			if (!file_exists($file_date)){				echo $msgstr["miss_dp"];
				die;			}
			$fp=file($file_date);
			foreach ($fp as $value){				$value=trim($value);				if ($value!=""){					$date_prefix=$value;
					break;				}			}
		    $Expresion=$date_prefix.$_REQUEST["year_from"];
		    if (isset($_REQUEST["month_from"]))
		    	$Expresion.=$_REQUEST["month_from"];
			$Expresion=$Expresion;
			$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Opcion=buscar&Formato=".$Formato;
			$query.="&Expresion=$Expresion";
			break;
		case "MFN":
			$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Opcion=rango&Formato=".$Formato;
			$query.="&from=".$arrHttp["Mfn"]."&to=".$arrHttp["to"];
			break;
		case "BUSQUEDA":
			$Expresion=urlencode($arrHttp["Expresion"]);
			$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Opcion=buscar&Formato=".$Formato;
			$query.="&Expresion=$Expresion";
			break;
	}
	$IsisScript=$xWxis. "imprime.xis";
	$contenido=WxisLLamar($IsisScript,$query);
	return $contenido;
}

function ConstruirSalida($tab,$tabs,$tipo,$rows,$cols){	for ($i=0;$i<count($tab);$i++){		$t=explode("|",$tabs[$i]);
		$tit=$t[0];
		$lmp="";$maximo="";
		$x=explode('|',$tipo[$i]);
		if ($x[0]=="LMP"){
			$lmp="S";
			$maximo=$x[1];
		}else{
			if (isset($t[2]) and $t[2]=="LMP"){
				$lmp="S";
				$maximo=$t[3];
			}else{
				 if (isset($t[2]))$columnas=$t[2];
			}
	    }
	    $filas=$t[1];

		//ENCABEZADO DE LA TABLA
		$enproceso=$tab[$i];


		unset($rows_label);unset($cols_label);
		$rows_label=$rows[$i];
		if (isset($cols[$i])) $cols_label=$cols[$i];

		if (isset($rows_label))ksort($rows_label);
		if (isset($cols_label))ksort($cols_label);
	    if (isset($cols_label))
	    	$ix=count($cols_label);
	    else
	    	$ix=1;
		echo "<p><br><strong>".$tit."</strong><br>";
		echo "<table border class=statTable cellpadding=5>\n";
		if (isset($cols_label))echo "<tr><th>&nbsp;</th><th colspan=$ix align=center>$columnas</th><th>&nbsp;</th>";
		echo "<tr><th>$filas</th>";
		if (isset($cols_label))
			foreach ($cols_label as $key=>$c) echo "<th>$key</th>";
		echo "<th>Total</th>\n";

		echo "</tr>";
	    $total_cols=array();
	    if ($lmp=="S"){
		    LosMasPrestados($tab[$i],$maximo);
			continue;
		}
		foreach ($rows_label as $ixrow){
			echo "<tr><td>".$ixrow."</td>";

			$ixtot=-1;
			$total_fila=0;
			if (isset($cols_label)){
		        foreach ($cols_label as $ixcol){
		        	if (isset($enproceso[$ixrow][$ixcol])){
					    $cell=$enproceso[$ixrow][$ixcol];
					    $total_fila=$total_fila+$cell;
						echo "<td bgcolor=#ffffff>".$cell."</td>";
						if (!isset($total_cols[$ixcol]))
							$total_cols[$ixcol]=$cell;
						else
							$total_cols[$ixcol]=$total_cols[$ixcol]+$cell;
					}else{
					 	echo "<td bgcolor=#ffffff></td>";
					}
				}
				echo "<td bgcolor=#ffffff>".$total_fila."</td>";
			}else{
				$cell=$enproceso[$ixrow][""];
				echo "<td bgcolor=#ffffff>".$cell."</td>";
				if (!isset($total_cols[0]))
					$total_cols[0]=$cell;
				else
					$total_cols[0]=$total_cols[0]+$cell;

			}

			echo "</tr>\n";

		}
		echo "<tr><td>Total</td>";
		$tgen=0;
		if (isset($cols_label)){
			foreach ($cols_label as $ixcol){
				echo "<td>".$total_cols[$ixcol]."</td>";
				$tgen=$tgen+$total_cols[$ixcol];
			}
		}else{			echo "<td>".$total_cols[0]."</td>";			$tgen=$tgen+$total_cols[0];		}
		if (isset($cols_label)){
			echo "<td>$tgen</td>";
		}
		echo "</tr>\n</table>\n<p>";
	}
}

function WxisLlamar($IsisScript,$query){
global $db_path,$xWxis,$Wxis,$wxisUrl,$arrHttp;
	include ("../common/wxis_llamar.php");
	return $contenido;
}

?>