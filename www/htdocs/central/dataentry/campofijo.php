<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");

include ("../lang/admin.php");
include("../lang/soporte.php");

//foreach ($arrHttp as $var=>$value)  echo "$var=>$value";
unset($fp_leader);
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/ldr_06.tab" ;
if (!file_exists($archivo)){	$archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/ldr_06.tab" ;
}
if (!file_exists($archivo)){	echo $arrHttp["falta"].": ".$archivo;
	die;}
$fp_leader=file($archivo);
$ix=0;
$titulo="";
$pll=explode('|',$arrHttp["formato"]);
foreach ($fp_leader as $value){	$value=trim($value);
	if ($value!=""){
			$tr=explode('|',$value);
			if($tr[0]==$pll[0]){				$titulo.= $tr[1].". (".$tr[0].")"." ".$tr[2];
				break;			}
	}
}
//echo $titulo;
$pl_tag=substr($arrHttp["Tag"],3);
echo $pl_tag;
if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$pll[1]))
	$fp=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$pll[1]);
else
    $fp=file($db_path.$arrHttp["base"]."/def/".$lang_db."/".$pll[1]);
echo "\n<script>
picklist=new Array()
namepick=new Array()
SubCampos=new Array()\n";
$ixpos=-1;
foreach ($fp as $value) {	$value=rtrim($value);
	if ($value!=""){		$t=explode('|',$value);
		$pick=trim($t[11]);
	    $ixpos=$ixpos+1;
	    echo "SubCampos"."[".$ixpos."]=\"$value\"\n";
		if ($pick!=""){			$name=$pick;
			$name=str_replace(".","_",$pick);
			if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/$pick"))
				$fpick=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/$pick");
			else
			    $fpick=file($db_path.$arrHttp["base"]."/def/".$lang_db."/$pick");
			$tt="";
			foreach ($fpick as $pl){				$pl=rtrim($pl);
				if ($pl!="") $tt.=$pl."!!!!";			}
			$tt=substr($tt,0,strlen($tt)-4);
			$tt=str_replace('"',"&quot;",$tt);
			echo "picklist"."[".$ixpos."]=\"$tt\"\n";
			$arr=explode("|",$value);
			echo "namepick"."[".$ixpos."]=\"".$arr[11]."\"\n";
		}
	}}
echo "</script>\n";
include("../common/header.php");
?>

<script language=Javascript src=js/lr_trim.js></script>
<script language=javascript>
mod_picklist="<?php echo $msgstr["mod_picklist"]?>"
reload_picklist="<?php echo $msgstr["reload_picklist"]?>"
var valoresCampo=new Array()    /* para colocar las ocurrencias del campo */
var lista_sc=Array()
Tag="<?php echo $arrHttp["Tag"]?>"
Contenido=eval("window.opener.document.forma1.<?php echo $arrHttp["Tag"]?>").value   /*Contenido del campo*/
//document.writeln(Contenido)
var valoresCampo=new Array()    /* para colocar las ocurrencias del campo */

var lista_sc=Array()
Contenido=window.opener.document.forma1.conte.value   /*Contenido del campo*/
//document.writeln(Contenido)
nSC=SubCampos.length

function ActualizarForma(){
	numvars=SubCampos.length
	ValorCapturado=""
	VC=new Array()
	for (i=1;i<numvars;i++){
		len=SubCampos[i].split("|")
		len_fix=len[9]
		Ctrl=eval("document.forma1.tag"+i)
		nombre=Ctrl.name
		id=Ctrl.id
		Valor=""
		switch (Ctrl.type){

			case "radio":
			case "checkbox":
				if (Ctrl.checked) Valor=Ctrl.value;
				break
			case "select":
			case "select-one":
			case "select-multiple":
				for (ixsel=0;ixsel<Ctrl.length;ixsel++){
					if (Ctrl.options[ixsel].selected){
							if (Valor.length<len_fix) Valor+=Ctrl.options[ixsel].value;
					}
				}
				break
			default:
				Valor=Ctrl.value;
		}
		ixlen=Valor.length
		for (iXx=ixlen;iXx<len_fix;iXx++) Valor+=" "
		ValorCapturado+=Valor

	}
	Ctrl=eval("window.opener.document.forma1."+Tag)
	Ctrl.value=ValorCapturado
	self.close()
}

</script></head>
<body>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/campofijo.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/campofijo.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: campofijo.php" ?>
</font>
	</div>
 <div class="middle form">
			<div class="formContent">
<?php echo "<h4>".$titulo."</h4>"?>
<form name=forma1><script language=javascript>

nSC=SubCampos.length
ixpos=0
document.writeln("<table border=0 width=100% cellspacing=0 cellpadding=0 class=listTable>")
ncols=3;
for (i=1;i<nSC;i++) {
	s=SubCampos[i].split("|")
	if (ncols>0) {		document.writeln("<tr onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = '';\">\n")
		ncols=0	}
	ncols++
	document.writeln("<td class=td><font size=2>"+s[2]+"</td>")
	document.writeln("<td>")
	if (s[11]==""){		document.writeln("<input type=text name=tag"+i+" size="+s[9]+" maxlength="+s[9]+" value='"+Contenido.substr(ixpos,s[9])+"'>")
	}else{
		if (s[4]==1)
   			multiple=" multiple"
   		else
   			multiple=" "
   		NombreCampo="tag"+i        document.writeln("<select name=tag"+i+multiple+" id="+NombreCampo+">")
        document.writeln("<option value=''></option>")
        pl=picklist[i].split('!!!!')
        optx=pl[0].split('|',2)

        opcion=Contenido.substr(ixpos,s[9])
        len_opt=optx[0].length
        sel=""
        for(ix_o in pl){
        	opc_output=pl[ix_o].split('|',2)
        	opcion=Contenido.substr(ixpos,s[9])
        	document.writeln("<option value='"+opc_output[0]+"'")
        	while (opcion.length>0){        		opt_data=opcion.substr(0,len_opt)

        		opcion=opcion.substr(len_opt)

        		if (opc_output[0]==opt_data){
        			sel=" selected"
        			opcion=""
        		}else{
        			sel=""
                }
			}
        	document.writeln(sel+">"+opc_output[1]+" ("+opc_output[0]+")"+"</option>\n")        }


        document.writeln("</select>\n")
        picklist_name=namepick[i]
        <?php
        $base=$arrHttp["base"];
        if (isset($_SESSION["permiso"])){
    		if (isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or  isset($_SESSION["permiso"][$base."_CENTRAL_ALL"])  or  isset($_SESSION["permiso"][$base."_CENTRAL_ACTPICKLIST"])){
        ?>
        document.writeln(" <a href=\"javascript:AgregarPicklist('"+picklist_name+"','"+NombreCampo+"','')\"><img src=img/s2.gif alt='"+mod_picklist+"' title='"+mod_picklist+"' border=0></a>")
		<?php } }?>
		document.writeln(" <a href=\"javascript:RefrescarPicklist('"+picklist_name+"','"+NombreCampo+"','')\"><img src=img/reset.gif alt='"+reload_picklist+"' title='"+reload_picklist+"' border=0></a>")
	}
	document.writeln("</td>")
	Contenido=Contenido.substr(s[9])
}
document.writeln("</table>")

function getElement(psID) {	if(!document.all) {
		return document.getElementById(psID);

	} else {
		return document.all[psID];
	}
}



	function Ayuda(tag){		tagx=String(tag)
		if (tagx.length<3) tagx="0"+tagx
		if (tagx.length<3) tagx="0"+tagx
		url="../ayudas/"+base+"/<?php echo $_SESSION["lang"]."/"?>tag_"+tagx+".html"
		msgwin=window.open(url,"Ayuda","status=yes,resizable=yes,toolbar=no,menu=yes,scrollbars=yes,width=600,height=400,top=100,left=100")
		msgwin.focus()	}

function RefrescarPicklist(tabla,Ctrl,valor){
	ValorOpcion=valor
	document.refrescarpicklist.picklist.value=tabla
	document.refrescarpicklist.Ctrl.value=Ctrl
	document.refrescarpicklist.valor.value=valor
	msgwin=window.open("","Picklist","width=20,height=10,scrollbars, resizable")
	document.refrescarpicklist.submit()
	msgwin.focus()
}

function AgregarPicklist(tabla,Ctrl,valor){
	ValorOpcion=valor
	document.agregarpicklist.picklist.value=tabla
	document.agregarpicklist.Ctrl.value=Ctrl
	document.agregarpicklist.valor.value=valor
	msgwin=window.open("","Picklist","width=600,height=500,scrollbars, resizable")
	document.agregarpicklist.submit()
	msgwin.focus()
}

//SE ACTUALIZA EL SELECT CON LA TABLA ACTUALIADA
ValorTabla=""
SelectName=""
ValorOpcion=""
function AsignarTabla(){
	opciones=ValorTabla.split('$$$$')
	var Sel = document.getElementById(SelectName);
	Sel.options.length = 0;
	var newOpt =Sel.appendChild(document.createElement('option'));
    newOpt.text = "";
    newOpt.value = " ";
	for (x in opciones){
		op=opciones[x].split('|')
		if (op[0]=="")
			op[0]=op[1]
		if (op[1]=="")
			op[1]=op[0]
		var newOpt =Sel.appendChild(document.createElement('option'));
    	newOpt.text = op[1];
    	newOpt.value = op[0];
    	if (op[0]==ValorOpcion)
    		newOpt.selected=true
	}
}


</script>

<input type=hidden name=occur><input type=hidden name=ep><input type=hidden name=NoVar><input type=hidden name=Indice value=""><input type=hidden name=base><input type=hidden name=cipar>
<input type=hidden name=Formato><input type=hidden name=Indice>
<br><br>
<table width=200 bgcolor=#FFFFFF border=0 cellspacing=5>	<td align=center><a href=javascript:ActualizarForma()><img src=img/pasaraldocumento.gif  border=0><br><?php echo $msgstr["actualizar"]?></a>	</td>
	<td align=center>
		<a href="javascript:self.close()"><img src=img/cancelar.gif  border=0><br><?php echo $msgstr["cancelar"]?></a>
	</td></table><script language=javascript>
</script></form>

<form name=agregarpicklist action=../dbadmin/picklist_edit.php method=post target=Picklist>
   <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
   <input type=hidden name=picklist>
   <input type=hidden name=Ctrl>
   <input type=hidden name=valor>
   <input type=hidden name=desde value=dataentry>
</form>

<form name=refrescarpicklist action=../dbadmin/picklist_refresh.php method=post target=Picklist>
   <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
   <input type=hidden name=picklist>
   <input type=hidden name=Ctrl>
   <input type=hidden name=valor>
   <input type=hidden name=desde value=dataentry>
</form>
<p>
</div></div>
<?php include("../common/footer.php")?>