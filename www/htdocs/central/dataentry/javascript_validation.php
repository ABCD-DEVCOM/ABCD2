<?php
    //SE CONSTRUYE EL FORMATO DE VALIDACION
    echo "<script>\n" ;
	echo "var fdt_val= new Array()\n";
    $ix=-1;
	for ($ivars=0;$ivars<count($vars);$ivars++){
 		$linea=$vars[$ivars];
 		$linea=trim($linea);
		$t=explode('|',$linea);
		if ($t[0]=="F" or $t[0]=="T"){			if (isset($t[19]) and isset($t[20]) and isset($t[21]) ){        // modificado 18-07-2016
				if ( trim($t[20])!="" or trim($t[21])!="" or $t[19]==1){
					$ix=$ix+1;
					echo "fdt_val[".$ix."]=\"".$linea."\"\n";
            	}
            }
		}
	}
	if ($ix>=0)
		echo "fdt_validation='Y'\n";
	else
	   echo "fdt_validation='N'\n";
	?>
mensaje=""


function ValidarTexto(Ctrl,tipo,patron,nombre_c,obligatorio){
   	msg=""
   	valor=Ctrl.value
   	tag=Ctrl.name
   	tag=tag.substr(3)
   	if (Trim(valor)=="" ){
   		if (obligatorio==1)
   			msg="- "+nombre_c+" ("+tag+") "+"<?php echo $msgstr["missing"]?>"
   	}else{
   		switch(tipo){
   			case "A":               //ALFABETICO
   				if(!/^[\sa-zA-Z]+$/.test(valor)){
   					msg="- "+nombre_c+ " ("+tag+") "+"<?php echo $msgstr["js_alphabetic"]?>"
   				}
   				break
   			case "X":               //ALFANUMERICO
   				break
   			case "I":               //ENTERO
   				if(!/^[0-9]+$/.test(valor)){
   					msg="- "+nombre_c+ " ("+tag+") "+"<?php echo $msgstr["js_numeric"]?>"
   				}
   				break
   			case "C":               //DECIMAL CON COMA
   				if (!/^([0-9])*[,]?[0-9]*$/.test(valor)){
					msg="- "+nombre_c+ " ("+tag+") "+"<?php echo $msgstr["js_dec_comma"]?>"
                }
   				break
   			case "D":               //DECIMAL CON PUNTO
   				if (!/^([0-9])*[.]?[0-9]*$/.test(valor)){
					msg="- "+nombre_c+ " ("+tag+") "+"<?php echo $msgstr["js_dec_period"]?>"
                }
   				break
   			case "T":               //FECHA >= fecha del día
   				var expreg = /^(\d{4})([0][1-9]|[1][0-2])([0][1-9]|[12][0-9]|3[01])$/;
   				if (!expreg.test(valor) )  {
            		msg="- "+nombre_c+ " ("+tag+") "+"<?php echo $msgstr["js_inv_dateformat"]?>"
        		}else{
   					var today = "<?php echo date("Ymd")?>";
   					if (valor<today) msg="- "+nombre_c+ " ("+tag+") "+"<?php echo $msgstr["js_inv_date"]?>"
   				}
   				break
   			case "F":
   				var expreg = /^(\d{4})([0][1-9]|[1][0-2])([0][1-9]|[12][0-9]|3[01])$/;
   				if (!expreg.test(valor) )  {
            		msg="- "+nombre_c+ " ("+tag+") "+"<?php echo $msgstr["js_inv_dateformat"]?>"
        		}
   				break
   			case "P":				//PATRON
   				Ctrl=eval("document.forma1."+Ctrl.name)
   				regex=""
   				for (ireg=0;ireg<patron.length;ireg++){
   					p=patron.substr(ireg,1)
   					switch (p){
   						case "A":
   							regex=regex+"[A-Z]"
   							break
   						case "a":
   							regex=regex+"[a-z]"
   							break
   						case "9":
   							regex=regex+"\\d{1}"
   							break
   						default:
   							regex=regex+"\\"+p+"{1}"
   							break
   					}
   				}
   				regex="/^"+regex+"$/"
   				regex=eval(regex)
				if (Ctrl.value.search(regex)==-1) //if match failed
                      msg="- "+nombre_c+ " ("+tag+") "+"<?php echo $msgstr["js_patron"]?>"+": "+patron
   				break
   		}
   	}
   	return msg
}

function ValidarEntrada(Ctrl,tipo,patron,nombre_c,obligatorio){
	mens=""
	switch (Ctrl.type){
		case "text":
		case "textarea":
			res=ValidarTexto(Ctrl,tipo,patron,nombre_c,obligatorio)
			if (res!=""){
				mens=res+"\n"
			}
			break
		case "select-one":
		case "select-multiple":
			if (Ctrl.selectedIndex==-1 || Ctrl.selectedIndex==0)
				mens=nombre_c+" ("+t[1]+") "+" debe seleccionar una opción\n"
			break
		case "radio":
		case "checkbox":
			Ctrl=eval("document.forma1."+Ctrl.name)
			chk="N"
			for (ix_el=0;ix_el<Ctrl.length;ix_el++){
				if (Ctrl[ix_el].checked){
					chk="Y"
				}
			}
			if (chk=="N"){
				mens=nombre_c+" ("+t[1]+") "+" debe seleccionar una opción\n"
			}
	}
	return mens}

function ValidarCampos_FDT(){               //SE REVISA LOS CAMPOS QUE TIENEN VALIDACION
	tope=fdt_val.length
	result=""
	for (i=0;i<tope;i++) {
		t=fdt_val[i].split("|")
		nombre_c=t[2]
		tipo=t[20]
		patron=t[21]
		obligatorio=t[19]
		tipocampo=t[7]
  		switch (t[0]){
			case "F":
				obj="tag"+t[1]
				Ctrl=document.getElementById(obj)
				if (tipocampo=="D" || tipocampo=="ISO")
					obj=obj+"_c"
                Ctrl=document.getElementById(obj)
				msg=ValidarEntrada(Ctrl,tipo,patron,nombre_c,obligatorio)
				if (msg!="")
					result=result+msg+"\n"
				break
     		case "T":     //CAMPO REPETIBLE CON SUBCAMPOS OBLIGATORIO

                	obj="tag"+t[1]
                	nombre_c=t[2]
                	subC=t[5]
                	lensc=subC.length
                	contenido=""
                	for (ixoc=0;ixoc<99;ixoc++){                		for (isc=0;isc<lensc;isc++) {                			delim=subC.substr(isc,1)
                			if (delim=="-") delim="_"
                			tag_name=obj+"_"+ixoc+"_"+delim
                			Ctrl=document.getElementById(tag_name)
                			if (Ctrl!=null){
                				if (Trim(Ctrl.value)!=""){                					contenido="S"                				}
                			}else{
                				isc=lensc+100
                				ixoc=9999                			}                		}                	}
                	if (contenido=="")
                		result=result+"- "+nombre_c+" ("+t[1]+") "+" campo obligatorio\n"
                	break			}
	}
    return result
}

</script>
	<?php


?>
