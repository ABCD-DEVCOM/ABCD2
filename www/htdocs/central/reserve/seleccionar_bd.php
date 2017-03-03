<?php
function SeleccionarBaseDeDatos($db_path,$msgstr){
global $copies,$ix_nb,$base_sel;
	$sel_base="N";
	$ix_nb=-1;
	$base_sel="";
	if (file_exists($db_path."loans.dat")){
		$copies="N";
		$bases_p=SeleccionarLoansDat($db_path,$msgstr);
	}else{
		$copies="S";
		$bases_p=SeleccionarBasesDat($db_path,$msgstr);
	}
	$sel_base= "
				<label for=\"dataBases\">
				<strong>". $msgstr["basedatos"]."</strong>
				</label>
				<select name=bd onchange=Enviar()>
				<option></option>\n";
    if (count($bases_p)==1)
       	$selected=" selected";
    else
      	$selected="";
	foreach ($bases_p as $value){
		$v=explode('|',$value);
		$sel_base.= "<option value=".$v[0]." $selected>".$v[1]."</option>\n";
		$selected="";
	}
	$sel_base.= "</select>\n";

	return $sel_base;
}

function SeleccionarLoansDat($db_path,$msgstr){
global $ix_nb,$base_sel;
	$fp=file($db_path."loans.dat");
	foreach ($fp as $value){
		if (trim($value)!=""){
			$ix_nb=$ix_nb+1;
			$value=trim($value);
			$bases_p[]=$value;
			$v=explode('|',$value);
			$base_sel=$v[0];
		}
	}
	return $bases_p;
}

function SeleccionarBasesDat($db_path,$msgstr){
global $ix_nb,$base_sel;
	$fp=file($db_path."bases.dat");
	$bases_p=array();
	foreach ($fp as $value){
		$value=trim($value);
		if (trim($value)!=""){
			$v=explode('|',$value);
			if (isset($v[2])){
				if (trim($v[2])=="Y"){
					$ix_nb=$ix_nb+1;
					$bases_p[]=$value;
					$base_sel=$v[0];
				}
			}
		}
	}
	return $bases_p;
}
?>
