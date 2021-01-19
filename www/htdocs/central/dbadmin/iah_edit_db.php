<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];


include("../lang/dbadmin.php");
include("../lang/iah_conf.php");
include("../lang/lang.php");

if (strpos($arrHttp["base"],"|")===false){

}   else{
		$ix=strpos($arrHttp["base"],'^b');
		$arrHttp["base"]=substr($arrHttp["base"],2,$ix-2);
}
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../common/header.php");

function AddKey($preliteral,$value){global $search_ix;
	$ix=-1;
	$ix1=-1;
	$value=trim($value);
	$ix=strpos($value,$preliteral);
	if ($ix>0){
		$ix1=strpos($value,$preliteral,$ix+1);
		$pref= substr($value,$ix+1,$ix1-$ix-1);
		if (strlen($pref)<4){
			$end_str=substr($pref,strlen($pref)-1,1);
			if ($end_str=="_"  or $end_str=="="){
				if (isset($search_ix[$pref])){					$search_ix[$pref].="%%%%%%%%".$value;				}else{					$search_ix[$pref]=$value;				}
			}
		}
	}
}

//READ THE FST OF THE DATABASE
$file=$db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".fst";
unset($fst);
$search_ix=array();
if (file_exists($file)){	$fst=file($file);
	foreach ($fst as $value){
		AddKey("|",$value);
		AddKey("'",$value);
		AddKey('"',$value);
	}
	echo "<script>
	fst=new Array()\n";
	foreach ($search_ix as $key=>$value) echo "fst['$key']=\"".str_replace('"','&quot;',$value)."\"\n";
	echo "</script>\n";}



// OPEN iah.def.php AND GET THE AVAILABLE LANGUAGES
$iah_def=parse_ini_file("../../iah/scripts/iah.def.php");
$iah_lang=explode(',',$iah_def["AVAILABLE LANGUAGES"]);
$ix=0;
foreach ($iah_lang as $value){
	$ix=$ix+1;
	$lan_iah[$ix]=trim($value);}
unset($fp);


?>


<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script>
//NUMBER OF LANGUAGES DEFINED IN IAH.DEF.PHP
n_lang=<?php echo count($lan_iah)."\n"?>
<?
$ix=0;
$rotulo_lan="";
foreach ($lan_iah as $lan){
	$ix=$ix+1;
	$rotulo_lan.='^'.$ix."<font color=red><i>".$msgstr[$lan]."</i></font>";}
echo "rotulo_lan='&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;$rotulo_lan'\n";
?>
IndexId=""
Nuevo=""

var file=new Array()
var index=new Array()
var format=new Array()
var gizmo=new Array()
var help=new Array()
var pref=new Array()

Index_el=new Array()


<?php
$ix=-1;
foreach ($lan_iah as $key=>$value) {	echo "Index_el[\"$key\"]=\"$value\"\n";}?>
Index_el["d"]="<?php echo $msgstr["d"]?>"
Index_el["f"]="<?php echo $msgstr["f"]?>"
Index_el["t"]="<?php echo $msgstr["t"]?>"
Index_el["g"]="<?php echo $msgstr["g"]?>"
Index_el["x"]="<?php echo $msgstr["x"]?>"
Index_el["y"]="<?php echo $msgstr["y"]?>"
Index_el["u"]="<?php echo $msgstr["u"]?>"
Index_el["m"]="<?php echo $msgstr["m"]?>"


function seeElement(ele){
	msgwin=window.open("","fst")
	msgwin.document.close()
//	msgwin.document.writeln("<font face='courier new'>")	for (i in fst){		lin=fst[i]
		re=/%%%%%%%%/gi
		lin=lin.replace(re,"<br>&nbsp;&nbsp;&nbsp;")
		re=/&quot;/gi
		lin=lin.replace(re,'"')
		msgwin.document.writeln(lin+"<br>")	}
}


function AceptarIndice(Id){
	VC=""
	for(i=0;i<msgwin.document.index.incampo.length;i++){
		type=msgwin.document.index.incampo[i].type
		campo=msgwin.document.index.incampo[i].value
		subc=msgwin.document.index.incampo[i].id

		if (type=="radio"){
			if (msgwin.document.index.incampo[i].checked){			}else{				campo=""			}		}
		if (type=="checkbox"){
			if (msgwin.document.index.incampo[i].checked){

			}else{
				campo=""
			}
		}
		if (subc<9)			 VC+="^"+subc+campo		else
			if (Trim(campo)!="") VC+="^"+subc+campo	}
	elemento=returnObjById("index_cont_"+IndexId )
	elemento.value=VC
	msgwin.close()}

function Ver(Archivo){	switch (Archivo){		case "fdt":
			url="fdt_leer.php?base=<?php echo $arrHttp["base"]?>"
			break
		case "fst":
			url="fst_leer.php?base=<?php echo $arrHttp["base"]?>"
			break
	}
	msgres=window.open(url,Archivo,"resizable, scrollbars,menu=no,status=yes,width=500,height=600,left=0")
	msgres.focus()}

function returnObjById( id )
{
    if (document.getElementById)
        var returnVar = document.getElementById(id);
    else if (document.all)
        var returnVar = document.all[id];
    else if (document.layers)
        var returnVar = document.layers[id];
    return returnVar;
}

function getElement(psID) {
	if(!document.all) {
		return document.getElementById(psID);

	} else {
		return document.all[psID];
	}
}

function EditIndex(Id){
	IndexId=Id
    idEl="index_tag_"+Id
    etq=returnObjById(idEl)
    Tit=Trim(etq.value)
    T=Tit.split(" ")
    if (T.length==1 || Trim(T[1])==""){    	alert("<?php echo $msgstr["err_ix"]?>")
    	return    }
	msgwin=window.open("","Index","resizable, scrollbars,menu=no,status=yes,width=780,height=550")
	msgwin.focus()
	msgwin.document.close()
	msgwin.document.writeln("<html><title>IAH-INDEX</title>")
	msgwin.document.writeln("<style type=\"text/css\">")
	msgwin.document.writeln("h1 {font-family:  Arial, Helvetica, sans-serif; font-size: 12pt; color: #00626C }")
	msgwin.document.writeln("td {  font-family:  Arial, Helvetica, sans-serif; font-size: 8pt; color: #00626C }")
	msgwin.document.writeln("a {  font-family:  Arial, Helvetica, sans-serif; font-size: 8pt; color: #00626C }")
    msgwin.document.writeln("</style>")
    msgwin.document.writeln("<body>")
	msgwin.document.writeln("<H1>"+Tit+"</h1>")
	msgwin.document.writeln("<FONT class=td><?php echo $msgstr["see"]?>: <a href=\"javascript:window.opener.Ver('fdt')\">FDT</a> | <a href=javascript:window.opener.Ver('fst')>FST</a><p>")
	msgwin.document.writeln("<form name=index>\n<table width=100% bgcolor=#eeeeff>");
	msgwin.document.writeln("<tr><td colspan=2 bgcolor=white><?php echo $msgstr["iah_lang"]?></td>")
	ele=new Array()
	<?php foreach ($lan_iah as $key=>$value) {		echo "ele[\"$key\"]=\"\"\n";	}
	?>
	ele["d"]=""
	ele["f"]=""
	ele["t"]=""
	ele["g"]=""
	ele["x"]=""
	ele["y"]=""
	ele["u"]=""
	ele["m"]=""

        elemento=returnObjById("index_cont_"+Id)
		dato=elemento.value
    //    alert(dato)
		while(dato!=""){			xpos=dato.indexOf("^")
			if (xpos>=0){
				xpos1=dato.indexOf("^",xpos+1)
				if (xpos1<0){
					xpos1=dato.length
				}
			}
			subc=dato.substr(xpos+1,1)
			xp=xpos+2
			campo=dato.substring(xp,xpos1)
			dato=dato.substr(xpos1)
			ele[subc]=campo
		}

	for (subc in ele){
		size=""
		salida=""
		switch (subc){			case "t":				select_s=""
				select_h=""
				select_n=""
				switch (ele[subc]){					case "short":
						select_s=" checked"
						break
					case "hidden":
						select_h=" checked"
						break
				}				msgwin.document.write("<tr><td bgcolor=white><font color=red>^"+subc+"</font> "+Index_el[subc]+"</td><td bgcolor=white>")
				msgwin.document.write("<input type=radio value=\"short\" name=incampo id="+subc+select_s+"><?php echo $msgstr["short"]?>")
				msgwin.document.write("<input type=radio value=\"hidden\" name=incampo id="+subc+select_h+"><?php echo $msgstr["hidden"]?>")
				msgwin.document.writeln("<input type=radio value=\"\" name=incampo id="+subc+select_n+"><?php echo $msgstr["none"]?></td>")
				break;			case "d" :
				fchecked=""
				if (ele[subc]=="*") fchecked=" checked"
				msgwin.document.write("<tr><td bgcolor=white width=550><font color=red>^"+subc+"</font> "+Index_el[subc]+"</td><td bgcolor=white><input type=checkbox value=\"*\" name=incampo id="+subc+fchecked+"></td>")
				size=" size=1 maxlength=1"
				break
			case "f" :
				fchecked=""
				if (ele[subc]=="A") fchecked=" checked"
				msgwin.document.write("<tr><td bgcolor=white width=550><font color=red>^"+subc+"</font> "+Index_el[subc]+"</td><td bgcolor=white><input type=checkbox value=\"A\" name=incampo id="+subc+fchecked+"></td>")
				size=" size=1 maxlength=1"
				break
			case "x":
				salida="Y"
				break
			case "u":
				salida="Y"
				break
			case "m":
				size=" size=3 maxlength=3"
				salida="Y"
				break
			default:
				salida="Y"
				break
		}
		if (salida=="Y")
				msgwin.document.writeln("<tr><td bgcolor=white width=550><font color=red>^"+subc+"</font> "+Index_el[subc]+"</td><td bgcolor=white><input type=text value=\""+ele[subc]+"\" name=incampo id="+subc+size+"></td>")


	}
   msgwin.document.writeln("</table>")

   msgwin.document.write("<h1><a href='javascript:window.opener.AceptarIndice()'><?php echo $msgstr["accept"]?></a> | ")
   msgwin.document.writeln("<a href='javascript:self.close()'><?php echo $msgstr["close"]?></a></h1>")
   msgwin.document.writeln("</form></body></html>")
   msgwin.document.close()
}

function DeleteElement(ix,IdSec){
	if (IdSec==1) if (ix==0) return
	switch (IdSec){
		case 1:
			Name="file"
			rotulo=""
			break
		case 2:
			Name="index"
			rotulo=rotulo_lan
			break
		case 3:
			Name="gizmo"
			rotulo=""
			break
		case 4:
			Name="format"
			rotulo=rotulo_lan
			break
		case 5:
			Name="help"
			rotulo=""
			break
	}
	html_sec=rotulo
	seccion=returnObjById( IdSec )
	Ctrl_1=Name+"_tag_"+ix
	Ctrl_2=Name+"_cont_"+ix
	Ctrl_1=returnObjById( Ctrl_1 )
	Ctrl_2=returnObjById( Ctrl_2 )
	Ctrl=eval("document.iah_edit."+Name+"_tag")
	ixLength=Ctrl.length
	if (ixLength<3){		if (ix==0 && IdSec==1){		}else{
			Ctrl_1.value=""
			Ctrl_2.value=""
		}
	}else{
		ixE=-1
		tags=new Array()
		cont=new Array()
		for (i=0;i<ixLength;i++){
			if (i!=ix){
				Ctrl_tag=Name+"_tag_"+i
				Ctrl_cont=Name+"_cont_"+i
				Ctrl_1=returnObjById( Ctrl_tag )
				Ctrl_2=returnObjById( Ctrl_cont )
				ixE++
				html=DrawElement(Ctrl_1.value,Ctrl_2.value,ixE,IdSec,Name)
    			html_sec+=html
			}
		}
		seccion.innerHTML = html_sec
	}

}

function DrawElement(Val_1,Val_2,ixE,ixSec,Name){	xhtml ="<br><input type=text name=\""+Name+"_tag\"  value=\""+Val_1+"\" id="+Name+"_tag_"+ixE+">: "
    xhtml+="<input type=text name=\""+Name+"_cont\" value=\""+Val_2+"\" size=90 id="+Name+"_cont_"+ixE+"> "
    if (ixSec==2){
    	xhtml+="<a href='javascript:EditIndex("+ixE+")'><?php echo$msgstr["edit"]?></a>&nbsp;|";
    }
    if (ixSec==1 && ixE==0){    }else{
    	xhtml+=" <a href=javascript:DeleteElement("+ixE+","+ixSec+")><?php echo $msgstr["delete"]?></a>\n";
    }

    return xhtml}

function DrawElementHelp(Val_1,Val_2,Val_3,ixE,ixSec,Name){
	xhtml="<br><select name=help_tag><option value=''</option>";
	xhtml+="<option value='HELP FORM'"
	if (Val_1=="HELP FORM") {
		xhtml+= " selected";
	}
	xhtml+=">HELP FORM</OPTION>"
	xhtml+="<option value='NOTE FORM'";
	if (Val_1=="NOTE FORM")
		xhtml+= " selected";
	xhtml+=">NOTE FORM</OPTION>";
	xhtml+="<option value='HELP INDEX'";
	if (Val_1=="HELP INDEX")
		xhtml+= " selected";
	xhtml+=">HELP INDEX</OPTION>";
	xhtml+="<option value='NOTE INDEX'";
	if (Val_1=="NOTE INDEX")
		xhtml+= " selected";
	xhtml+=">NOTE INDEX</OPTION>";
	xhtml+="</select>";
	xhtml+="<input type=text name=\"lang_form\"  value=\""+Val_2+"\" id="+Name+"_tag_"+ixE+" size=2>= "
    xhtml+="<input type=text name=\""+Name+"_cont\" value=\""+Val_3+"\" size=90 id="+Name+"_cont_"+ixE+"> "
    xhtml+=" <a href=javascript:DeleteElementHelp("+ixE+","+ixSec+")><?php echo $msgstr["delete"]?></a>\n";
    return xhtml
}

function AddElement(IdSec){
	seccion=returnObjById( IdSec )
	switch(IdSec){		case 1:
			Ctrl_1=eval("document.iah_edit.file_tag")
			Ctrl_2=eval("document.iah_edit.file_cont")
			Str_1="FILE"
			Str_2="%path_database%<?php echo $arrHttp["base"]?>/pfts/%lang%/[pft].pft"    //OJO
			Name="file"
			rotulo=0
			break
		case 2:
			Ctrl_1=eval("document.iah_edit.index_tag")
			Ctrl_2=eval("document.iah_edit.index_cont")
			Str_1="INDEX"
			Str_2=""
			Name="index"
			rotulo=rotulo_lan
			break
		case 3:
			Ctrl_1=eval("document.iah_edit.gizmo_tag")
			Ctrl_2=eval("document.iah_edit.gizmo_cont")
			Str_1=""
			Str_2=""
			rotulo=""
			Name="gizmo"
			break
		case 4:
			Ctrl_1=eval("document.iah_edit.format_tag")
			Ctrl_2=eval("document.iah_edit.format_cont")
			Str_1="FORMAT"
			Str_2=""
			Name="format"
			rotulo=rotulo_lan
			break
		case 5:
			Ctrl_1=eval("document.iah_edit.help_tag")
			Ctrl_2=eval("document.iah_edit.help_cont")
			Str_1=""
			Str_2=""
			Name="help"
			break	}
	ixLength=Ctrl_1.length
	last=ixLength-1
	ant=returnObjById(Name+"_tag_"+last)
	if (Trim(ant.value)=="") return
	ant=returnObjById(Name+"_cont_"+last)
	if (Trim(ant.value)=="") return
	html=rotulo
    for (ia=0;ia<ixLength;ia++){
    	xhtm=DrawElement(Ctrl_1[ia].value,Ctrl_2[ia].value,ia,IdSec,Name)
    	html+=xhtm
    }
	nuevo=DrawElement(Str_1,Str_2,ia,IdSec,Name)
	seccion.innerHTML = html+nuevo

}

function AddHelp(IdSec){
	seccion=returnObjById( IdSec )
	Ctrl_1=eval("document.iah_edit.help_tag")
	Ctrl_2=eval("document.iah_edit.lang_form")
	Ctrl_3=eval("document.iah_edit.help_cont")
	Str_1=""
	Str_2=""
	Str_3=""
	Name="help"
	ixLength=Ctrl_1.length
	last=ixLength-1
	html=""
    for (ia=0;ia<ixLength;ia++){
    	xhtm=DrawElementHelp(Ctrl_1[ia].value,Ctrl_2[ia].value,Ctrl_3[ia].value,ia,IdSec,Name)
    	html+=xhtm
    }
	nuevo=DrawElementHelp(Str_1,Str_2,Str_3,ia,IdSec,Name)
	seccion.innerHTML = html+nuevo

}

function CheckNames(def){//DETECTS IF AT LEAST A NAME IS ENTERED IN THE LENGUAGE SUBFIELDS (^1 ^2 ...)
	str_lan=""
	for (i_lang=1;i_lang<=n_lang;i_lang++){		ix_lang=def.indexOf('^'+i_lang)
		if (ix_lang!=-1)
			ix2=def.indexOf('^',ix_lang+1)
			if (ix2!=-1){
				ix_lang=ix_lang+2				str_name=def.substr(ix_lang,ix2-ix_lang)
				if (Trim(str_name)!="") str_lan="yes"			}	}
    if (str_lan=="")
    	return false
    else
    	return true
}

function ValidateForm(){	ret=Validar()
	if (ret){		alert("<?php echo $msgstr["noerrors"]?>")	}}

function Validar(){	file=[]
	index=[]
	format=[]
	gizmo=[]
	help=[]
	pref=[]

// Seccion FILE_LOCATION
//
	n=document.iah_edit.file_tag.length
	FILE_LOC=""
	file_str=""
	for (i=0;i<n;i++){		name=document.iah_edit.file_tag[i].value;
		path=document.iah_edit.file_cont[i].value
		name=Trim(name)

		if (name.substr(0,4)!="FILE") {			name="FILE "+name
			document.iah_edit.file_tag[i].value=name		}
		if (Trim(name)=="FILE"){			alert("<?php echo $msgstr["filelocation"]?>: <?php echo $msgstr["missfile"]?>")
			return		}
		if (path.indexOf('[pft]')>0){			alert("<?php echo $msgstr["filelocation"]?>: <?php echo $msgstr["misspft"]?>")
			return  false		}
		logic_name=name
    	FILE_LOC+="$$$"+logic_name+"$$$"
		path=Trim(path)
		if (path.substr(0,15)!="%path_database%"){			path="%path_database%"+path
			document.iah_edit.file_cont[i].value=path		}

		if (name+path!="") file_str+=name+"="+path+"\n"
	}

// Seccion INDEX_DEFINITION
//
	n=document.iah_edit.index_tag.length
	index_str=""
	tmain=0
	for (i=0;i<n;i++){
		name=document.iah_edit.index_tag[i].value;
		def=document.iah_edit.index_cont[i].value
		name=Trim(name)
		if (name.substr(0,5)!="INDEX" && Trim(name)!="" && Trim(def)!="") {
			name="INDEX "+name
			document.iah_edit.index_tag[i].value=name
		}
		if (Trim(name)=="INDEX"){
			alert("<?php echo $msgstr["indexdef"]?>: <?php echo $msgstr["missindex"]?>")
			return  false
		}

		def=Trim(def)
		if (def=="" && name!=""){			alert("<?php echo $msgstr["indexdef"]?>: <?php echo $msgstr["missindconf"]?>")
			return		}
// CHECK IF THE MAIN INDEX IS DEFINED
		ixpos=def.indexOf("^d")
		if (ixpos!=-1){			tmain++		}


// CHECK IF ALL ^y EXISTS AND IF DEFINED IN FILE_LOCATION

		ixpos=def.indexOf('^y')
		if (ixpos!=-1){			ixpos=ixpos+2
			arch=def.substr(ixpos)
			ixend=arch.indexOf('^')
			if (ixend==-1) ixend=arch.length
			if (Trim(arch.substr(0,ixend))!=""){
				arch="FILE "+arch.substr(0,ixend)
				if (FILE_LOC.indexOf("$$$"+arch+"$$$")==-1){					arch_01=arch+".*"
					if (FILE_LOC.indexOf("$$$"+arch_01+"$$$")==-1) {						alert(arch+ " <?php $msgstr["missfileloc"]?>")
						return false
					}
				}			}
		}
//CHECK IF AT LEAST ONE NAME IS SUPPLIED FOR THE INDEX
        val_res=CheckNames(def)
        if (!val_res) {        	alert("<?php echo $msgstr["misslang"]?> "+name)
        	return false        }
		if (name+def!="") index_str+=name+"="+def+"\n"
	}
    if (tmain==0 || tmain>1){    	alert("<?php echo $msgstr["missdup_d"]?>")
    	return false    }



// Seccion APPLY_GIZMO
//
	n=document.iah_edit.gizmo_tag.length
	gizmo_str=""
	for (i=0;i<n;i++){
		name=Trim(document.iah_edit.gizmo_tag[i].value);
		def=document.iah_edit.gizmo_cont[i].value
		def=Trim(def)
		if((name=="" || def=="") && name+def!=""){			alert("<?php echo $msgstr["gizmo"]?>: <?php echo $msgstr["missfileloc"]?>")
			return false		}
		if (def!=""){
// Se localiza si el formato hace referencia a algún archivo para localizarlo en FILE_LOCATION
			if (FILE_LOC.indexOf("$$$FILE "+def+".*$$$")==-1){
				alert(def+ " <?php $msgstr["missfileloc"]?>")
				return  false
			}
		}
		if (name+def!="")  gizmo_str+=name+"="+def+"\n"
	}

// Seccion FORMAT_NAME
//
	n=document.iah_edit.format_tag.length
	format_str=""
	for (ipft=0;ipft<n;ipft++){
		name_pft=Trim(document.iah_edit.format_tag[ipft].value);
		def_pft=Trim(document.iah_edit.format_cont[ipft].value)
		if (name_pft!=""){
			if (name_pft.substr(0,6)!="FORMAT") {
				name_pft="FORMAT "+name_pft
				document.iah_edit.format_tag[ipft].value=name_pft
			}
	// Se localiza si el formato hace referencia a algún archivo para localizarlo en FILE_LOCATION
			ar=name_pft.split(" ")
			ar[1]=Trim(ar[1])
			if (ar[1]!="DEFAULT")def=ar[1]
			if (FILE_LOC.indexOf("$$$FILE "+def+"$$$")==-1){
				alert(def_pft+ " <?php $msgstr["missfileloc"]?>")
				return   false
			}
			if (name+def_pft!="") format_str+=name_pft+"="+def_pft+"\n"

//CHECK IF AT LEAST ONE NAME IS SUPPLIED FOR THE FORMAT

			if (name_pft.indexOf('.pft')!=-1){        		val_res=CheckNames(def_pft)
        		if (!val_res) {
        			alert("<?php echo $msgstr["misslang"]?> "+name_pft)
        			return false
        		}
        	}
		}
	}

// Seccion HELP
	help_str=""
	n=document.iah_edit.help_tag.length
	for (i=0;i<n;i++){
		name=document.iah_edit.help_tag[i].value;
		form=Trim(document.iah_edit.lang_form[i].value)
		if (form!="") form=" "+form
		def=document.iah_edit.help_cont[i].value
		name=Trim(name) + form
		def=Trim(def)
		if (name+def!="")help_str+=name+"="+def+"\n"
	}
    ValorCapturado="[FILE_LOCATION]\n\n"+file_str+"\n"
    ValorCapturado+="[INDEX_DEFINITION]\n\n"+index_str+"\n"
    ValorCapturado+="[APPLY_GIZMO]\n\n"+gizmo_str+"\n"
    ValorCapturado+="[FORMAT_NAME]\n\n"+format_str+"\n"
    ValorCapturado+="[HELP_FORM]\n\n"+help_str+"\n"
    ValorCapturado+="[PREFERENCES]\n\n"

  	ValorCapturado+="AVAILABLE FORMS="
    str_val=""
    for (i=0;i<document.iah_edit.preferences.length;i++){
    	if (document.iah_edit.preferences[i].selected) {    		str_val+=document.iah_edit.preferences[i].value+","
    	}
    }
    if (str_val!="")  str_val=str_val.substr(0,str_val.length-1)
    ValorCapturado+=str_val

	ValorCapturado+="\nSEND RESULT BY EMAIL="
	if (document.iah_edit.email.checked)
		ValorCapturado+="ON"
	else
		ValorCapturado+="OFF"

	ValorCapturado+="\nNAVIGATION BAR="
	if (document.iah_edit.bar.checked)
		ValorCapturado+="ON"
	else
		ValorCapturado+="OFF"

	ValorCapturado+="\nDOCUMENTS PER PAGE=" +document.iah_edit.dpp.value

	ValorCapturado+="\nFEATURES="
	if (document.iah_edit.features_xml.checked)
		ValorCapturado+="XML"
    ValorCapturado+= "\nSEARCH UCTAB="+document.iah_edit.uctab.value;
    if (document.iah_edit.UNICODE.checked){    	ValorCapturado+= "\nUNICODE=ON";    }
    ValorCapturado+="\n";

	document.iah_edit.ValorCapturado.value=ValorCapturado
	return true
}

function Guardar(){	ret=Validar()
	if (ret==true) document.iah_edit.submit()
}

function BajarOpcion(){
	ix=document.iah_edit.preferences.selectedIndex
	if (ix==-1 || ix+1>=document.iah_edit.preferences.options.length) return
	ocurren=document.iah_edit.preferences.options[ix+1].value
	txt_ocurren=document.iah_edit.preferences.options[ix+1].text
	document.iah_edit.preferences.options[ix+1].value=document.iah_edit.preferences.options[ix].value
	document.iah_edit.preferences.options[ix+1].text=document.iah_edit.preferences.options[ix].text
	document.iah_edit.preferences.options[ix].value=ocurren
	document.iah_edit.preferences.options[ix].text=txt_ocurren
	document.iah_edit.preferences.selectedIndex=ix+1
}

function SubirOpcion(){
	ix=document.iah_edit.preferences.selectedIndex
	if (ix==-1 || ix==0) return
	ocurren=document.iah_edit.preferences.options[ix-1].value
	txt_ocurren=document.iah_edit.preferences.options[ix-1].text
	document.iah_edit.preferences.options[ix-1].value=document.iah_edit.preferences.options[ix].value
	document.iah_edit.preferences.options[ix-1].text=document.iah_edit.preferences.options[ix].text
	document.iah_edit.preferences.options[ix].value=ocurren
	document.iah_edit.preferences.options[ix].text=txt_ocurren
	document.iah_edit.preferences.selectedIndex=ix-1
}
</script>
</head>
<body>
<A NAME=INICIO>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{	$encabezado="";}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["iah-conf"].": ".strtoupper($arrHttp["base"]).".def"?>
	</div>
	<div class="actions">
<?php
	echo "<a href=\"menu_modificardb.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"]?></strong></span></a>
<?php if (isset($fst)){?>
		<a href="javascript:Guardar()" class="defaultButton saveButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["save"]?></strong></span></a>
<?php }?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/iah_edit_db.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/iah_edit_db.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; &nbsp;<font color=white>&nbsp; &nbsp; Script: iah_edit_db.php";
?>
</font>
	</div>
<div class="middle form">
	<div class="formContent">
	<form name=iah_edit method=post action=iah_save.php onsubmit="javascript:return false">

<?php
	if (!isset($fst)) {		echo "<h1>".$msgstr["missing"]." bases/".$arrHttp["base"]."/data/".$arrHttp["base"].".fst</h1>";
		die;	}
	echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";
    echo "<input type=hidden name=ValorCapturado value=\"\">\n";
    if (isset($arrHttp["encabezado"]))
    	echo "<input type=hidden name=encabezado value=s>\n";
	if (file_exists($db_path."par/".strtoupper($arrHttp["base"]).".def")){
		$db_def=parse_ini_file ($db_path."par/".strtoupper($arrHttp["base"]).".def",true,INI_SCANNER_RAW);
		$msg="";
	}else{         //CONFIGURE A NEW DATABASE
		$msg="<font color=red><strong>".$msgstr["newfile"]." bases/par/".$arrHttp["base"].".def. ".$msgstr["reminder"]."</strong></font><p>";	}
//	echo $db_path."par/".strtoupper($arrHttp["base"]).".def" ;
//	echo "<pre>"; echo print_r($db_def); echo "</pre>";
	if (!isset($db_def["FILE_LOCATION"]["FILE DATABASE.*"]))
		$db_def["FILE_LOCATION"]["FILE DATABASE.*"]="%path_database%".$arrHttp["base"]."/data/".$arrHttp["base"].".*";
	if (!isset($db_def["FILE_LOCATION"]["FILE standard.pft"]))
		$db_def["FILE_LOCATION"]["FILE standard.pft"]="%path_database%".$arrHttp["base"].'/pfts/%lang%/'.$arrHttp["base"].'.pft';
	if (!isset($db_def["FILE_LOCATION"]["FILE SHORTCUT.IAH"]))
		$db_def["FILE_LOCATION"]["FILE SHORTCUT.IAH"]="%path_database%".$arrHttp["base"].'/pfts/%lang%/shortcut.pft';
	if (!isset($db_def["FILE_LOCATION"]["FILE GXML"]))
		$db_def["FILE_LOCATION"]["FILE GXML"]="%path_database%gizmo/gXML.*";
	if (!isset($db_def["INDEX_DEFINITION"])){
		$desc="";
		foreach ($lan_iah as $key=>$lang){			$desc.='^'.$key;		}

		if (isset($search_ix) and count($search_ix)>0 ){			$d="^d*";			foreach ($search_ix as $key=>$value){				$pref=$key;				$str_pref=strtoupper(substr($pref,0,1)).strtolower(substr($pref,1));
				$str_pref_end=substr($pref,0,strlen($pref)-1);				$db_def["INDEX_DEFINITION"]["INDEX ".strtoupper(substr($str_pref_end,0,1)).strtolower(substr($str_pref_end,1))]=$desc."$d^x".strtoupper($str_pref_end)." ^u".strtoupper($key)."^yDATABASE^m$key";
				$d="";			}
		}else{
			$db_def["INDEX_DEFINITION"]["INDEX Tw"]="";
			$db_def["INDEX_DEFINITION"]["INDEX "]="";
		}
	}
	if (!isset($db_def["APPLY_GIZMO"])){
		$db_def["APPLY_GIZMO"][0]="";
		$db_def["APPLY_GIZMO"][1]="";
	}
	if (!isset($db_def["FORMAT_NAME"]["FORMAT standard.pft"])){		$desc="";
		foreach ($lan_iah as $key=>$lang){
			$desc.='^'.$key;
		}		$db_def["FORMAT_NAME"]["FORMAT standard.pft"]=$desc;
	}
	if (!isset($db_def["FORMAT_NAME"]["FORMAT DEFAULT"]))
		$db_def["FORMAT_NAME"]["FORMAT DEFAULT"]="standard.pft";
	if (!isset($db_def["HELP_FORM"])){
		$db_def["HELP_FORM"][0]="";
		$db_def["HELP_FORM"][1]="";
	}
	if (!isset($db_def["PREFERENCES"])){
		$db_def["PREFERENCES"][]="";	}
	echo "<A NAME=INICIO>";
//    echo "<a href=iah_def_edit_txt.php?base=".$arrHttp["base"].$encabezado.">".$msgstr["edit_txt"]."</a> | ";

	echo $msg."<div class=\"pagination\">
	<a href=#FILE_LOCACION>[FILE LOCATION]</A>&nbsp;&nbsp;<a href=#INDEX_DEFINITION>[INDEX DEFINITION]</A>&nbsp;&nbsp;
	<a href=#APPLY_GIZMO>[APPLY GIZMO]</A>&nbsp;&nbsp;<a href=#FORMAT_NAME>[FORMAT NAME]</A>&nbsp;&nbsp;<A HREF=#HELP_FORM>[HELP FORM]</A>
	&nbsp;&nbsp;<A HREF=#PREFERENCES>[PREFERENCES]</A>
	</DIV>";
	echo "<a href=javascript:ValidateForm()>".$msgstr["validate"]."</a>";

	foreach ($db_def as $var=>$value){        $var=trim($var);
		echo "<br><A NAME=$var><p><strong>[$var]</strong>&nbsp;&nbsp;&nbsp;<A href=#INICIO>".$msgstr["top"]."</a>";
		switch ($var){
			case "FILE_LOCATION":
				$id=-1;
				echo "<div id=1 style='line-height:200%'>\n";
				foreach ($value as $v1=>$v2){					$id=$id+1;
			    	echo "<br><input type=text name=\"file_tag\"  value=\"$v1\" id=file_tag_$id>=<input type=text name=\"file_cont\" value=\"$v2\" size=90 id=file_cont_$id>";
			    	if ($id!=0) echo "&nbsp;<a href=javascript:DeleteElement($id,1)>".$msgstr["delete"]."</a>\n";

//			    	if ($v1=="FILE SHORTCUT.IAH") echo "edit";
			    }
			    if ($id==-1){ // si se creó solo una casilla de ingreso, se fuerza un arreglo agregando otra casilla
                	$id=$id+1;
			    	echo "<br><input type=text name=\"file_tag\"  value=\"\" id=file_tag_$id>=<input type=text name=\"file_cont\" value=\"\" size=90 id=file_cont_$id>";
			    	if ($id!=0) echo "&nbsp;<a href=javascript:DeleteElement($id,1)>".$msgstr["delete"]."</a>\n";
				}
			    if ($id==0){ // si se creó solo una casilla de ingreso, se fuerza un arreglo agregando otra casilla
                	$id=$id+1;
			    	echo "<br><input type=text name=\"file_tag\"  value=\"\" id=file_tag_$id>=<input type=text name=\"file_cont\" value=\"\" size=90 id=file_cont_$id>";
			    	if ($id!=0) echo "&nbsp;<a href=javascript:DeleteElement($id,1)>".$msgstr["delete"]."</a>\n";
				}
			    echo "</div>\n";
			    echo "<a href=javascript:AddElement(1)>".$msgstr["add"]."</a>\n<br>";
			    break;
			case "INDEX_DEFINITION":
				$id=-1;
				echo "<div id=2 style='line-height:200%'>\n";
				$ix=0;
				echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
				foreach ($iah_lang as $l){
					$ix=$ix+1;
					echo '^'.$ix."<font color=red><i>".$msgstr[trim($l)]."</i></font>";
				}
				foreach ($value as $v1=>$v2){					$id=$id+1;
			   		echo "<br><input type=text name=\"index_tag\" value=\"$v1\" id=index_tag_$id>= <input type=text name=\"index_cont\" value=\"$v2\" size=90 id=index_cont_$id> <a href='javascript:EditIndex($id)'>".$msgstr["edit"]."</a> | <a href=javascript:DeleteElement($id,2)>".$msgstr["delete"]."</a>\n";
			   		echo "&nbsp;<a href=\"javascript:seeElement('$v2')\">".$msgstr["see"]."</a>\n";
			    }
			    if ($id==-1){
			    	$id=$id+1;
			    	echo "<br><input type=text name=\"index_tag\" value=\"$v1\" id=index_tag_$id>= <input type=text name=\"index_cont\" value=\"$v2\" size=90 id=index_cont_$id> <a href='javascript:EditIndex($id)'>".$msgstr["edit"]."</a> | <a href=javascript:DeleteElement($id,2)>".$msgstr["delete"]."</a>\n";
			    }
			    if ($id==0){			    	$id=$id+1;
			    	echo "<br><input type=text name=\"index_tag\" value=\"$v1\" id=index_tag_$id>= <input type=text name=\"index_cont\" value=\"$v2\" size=90 id=index_cont_$id> <a href='javascript:EditIndex($id)'>".$msgstr["edit"]."</a> | <a href=javascript:DeleteElement($id,2)>".$msgstr["delete"]."</a>\n";			    }
			    echo "</div>\n";
			    echo "<a href=javascript:AddElement(2)>".$msgstr["add"]."</a>\n<br>";
			    break;
			case "APPLY_GIZMO":
				$id=-1;
				echo "<div id=3 style='line-height:200%'>\n";
				foreach ($value as $v1=>$v2){					if ($v1=="0" or $v1=="1") $v1="";					$id=$id+1;
			    	echo "<br><input type=text name=\"gizmo_tag\" value=\"$v1\" id=gizmo_tag_$id>= <input type=text name=\"gizmo_cont\" value=\"$v2\" id=gizmo_cont_$id size=90> &nbsp;<a href=javascript:DeleteElement($id,3)>".$msgstr["delete"]."</a>\n";
			    }
			    if ($id==-1){			    	$id=$id+1;
			    	echo "<br><input type=text name=\"gizmo_tag\" value=\"\" id=gizmo_tag_$id>= <input type=text name=\"gizmo_cont\" value=\"\" id=gizmo_cont_$id size=90> &nbsp;<a href=javascript:DeleteElement($id,3)>".$msgstr["delete"]."</a>\n";			    }
			    if ($id==0){			    	$id=$id+1;
			    	echo "<br><input type=text name=\"gizmo_tag\" value=\"\" id=gizmo_tag_$id>= <input type=text name=\"gizmo_cont\" value=\"\" id=gizmo_cont_$id size=90>&nbsp;<a href=javascript:DeleteElement($id,3)>".$msgstr["delete"]."</a>\n";
			    }
			    echo "</div>";
			    echo "<a href=javascript:AddElement(3)>".$msgstr["add"]."</a>\n<br>";
			    break;
			case "FORMAT_NAME":
				$id=-1;
//				echo "<a href=pft.php?base=".$arrHttp["base"]."&encabezado=$encabezado target=_blank>Crear/editar formato</a>";
				echo "<div id=4 style='line-height:200%'>\n";
				$ix=0;
				echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
				foreach ($iah_lang as $l){
					$ix=$ix+1;
					echo '^'.$ix."<font color=red><i>".$msgstr[trim($l)]."</i></font>";
				}
				foreach ($value as $v1=>$v2){                    if ($v1=="0" or $v1=="1") $v1="";
                    $id=$id+1;
			    	echo "<br><input type=text name=\"format_tag\" value=\"$v1\" id=format_tag_$id>= <input type=text name=\"format_cont\" value=\"$v2\" size=90 id=format_cont_$id> &nbsp;<a href=javascript:DeleteElement($id,4)>".$msgstr["delete"]."</a>\n";
			    }
                if ($id==-1){                	$id=$id+1;
			    	echo "<br><input type=text name=\"format_tag\" value=\"\" id=format_tag_$id>: <input type=text name=\"format_cont\" value=\"\" size=90 id=format_cont_$id> &nbsp;<a href=javascript:DeleteElement($id,4)>".$msgstr["delete"]."</a>\n";                }
                if ($id==0){
                	$id=$id+1;
			    	echo "<br><input type=text name=\"format_tag\" value=\"\" id=format_tag_$id>: <input type=text name=\"format_cont\" value=\"\" size=90 id=format_cont_$id> &nbsp;<a href=javascript:DeleteElement($id,4)>".$msgstr["delete"]."</a>\n";
                }
			    echo "</div>";
			    echo "<a href=javascript:AddElement(4)>".$msgstr["add"]."</a>\n<br>";
			    break;
			case "HELP_FORM":
				echo "<div id=5 style='line-height:200%'>\n";
				$id=-1;
                $lang_form="";
				foreach ($value as $v1=>$v2){					if ($v1=="0" or $v1=="1") $v1="";
					$id=$id+1;
					echo "<br>";
					echo "<select name=help_tag><option value=''</option>";
					echo "<option value='HELP FORM'";
					if (substr($v1,0,9)=="HELP FORM") {						echo " selected";
						$lang_form=trim(substr($v1,10));					}
					echo ">HELP FORM</OPTION>";
					echo "<option value='NOTE FORM'";
					if (substr($v1,0,9)=="NOTE FORM") {						echo " selected";
						$lang_form=trim(substr($v1,10));
					}
					echo ">NOTE FORM</OPTION>";
					echo "<option value='HELP INDEX'";
					if (substr($v1,0,10)=="HELP INDEX") {
						echo " selected";
						$lang_form=trim(substr($v1,10));
					}
					echo ">HELP INDEX</OPTION>";
					echo "<option value='NOTE INDEX'";
					if (substr($v1,0,10)=="NOTE INDEX") {
						echo " selected";
						$lang_form=trim(substr($v1,10));
					}
					echo ">NOTE INDEX</OPTION>";
					echo "</select>";
			    	echo "<input type=text name=\"lang_form\" value=\"$lang_form\" id=lan_form_$id size=2>= <input type=text name=\"help_cont\" value=\"$v2\" size=90 id=help_cont_$id> &nbsp;<a href=javascript:DeleteElement($id,5)>".$msgstr["delete"]."</a>\n";
			    	$lang_form="";
			    }
			    if ($id==-1){			    	$id=$id+1;
			    	echo "<br>";
					echo "<select name=help_tag><option value=''</option>";
					echo "<option value='HELP FORM'>HELP FORM</OPTION>";
					echo "<option value='NOTE FORM'>NOTE FORM</OPTION>";
					echo "<option value='HELP INDEX'>HELP INDEX</OPTION>";
					echo "<option value='NOTE INDEX'>NOTE INDEX</OPTION>";
					echo "</select>";
			    	echo "<input type=text name=\"lang_form\" value=\"\" id=lang_form_$id size=2>= <input type=text name=\"help_cont\" value=\"\" size=90 id=help_cont_$id> &nbsp;<a href=javascript:DeleteElement($id,5)>".$msgstr["delete"]."</a>\n";			    }
			    if ($id==0){
			    	$id=$id+1;
			    	echo "<br>";
					echo "<select name=help_tag><option value=''</option>";
					echo "<option value='HELP FORM'>HELP FORM</OPTION>";
					echo "<option value='NOTE FORM'>NOTE FORM</OPTION>";
					echo "<option value='HELP INDEX'>HELP INDEX</OPTION>";
					echo "<option value='NOTE INDEX'>NOTE INDEX</OPTION>";
					echo "</select>";
			    	echo "<input type=text name=\"lang_form\" value=\"\" id=lang_form_$id size=2>= <input type=text name=\"help_cont\" value=\"\" size=90 id=help_cont_$id> &nbsp;<a href=javascript:DeleteElement($id,5,)>".$msgstr["delete"]."</a>\n";
			    }
				echo "</div>";
			    echo "<a href=javascript:AddHelp(5)>".$msgstr["add"]."</a>\n<br>";
			    break;
			case "PREFERENCES":
				$pref_f="";
				$pref_b="";
				$pref_a="";
				$email="";
				$bar="0";
				$dpp=20;
				$features="";
				$uctab="";
				$unicode="";
				foreach ($value as $v1=>$v2){
					$v2=trim($v2);
					switch ($v1){
						case "AVAILABLE FORMS":
							if ($v2!="")
								$adForm=explode(',',$v2);
							break;
						case "SEND RESULT BY EMAIL":
							switch ($v2){
								case "ON":
									$email=" checked";
									break;
								case "";
								case "OFF":
									$email="";
									break;

                               }
         					case "NAVIGATION BAR":
							switch ($v2){
								case "1":
									$bar=" checked";
									break;
								case "";
								case "0":
									$bar="";
									break;

                               }
         					case "DOCUMENTS PER PAGE":
                               $dpp=$v2;
							break;
						case "FEATURES":
                               if ($v2=="XML") $features=" checked";
							break;
						case "SEARCH UCTAB":
							$uctab=$v2;
							break;
						case "UNICODE";
							$unicode=$v2;
							break;
					}
				}
                if ($uctab==""){                	if (file_exists($db_path.$arrHttp["base"]."/data/isisuc.tab")) {                		$uctab=$db_path.$arrHttp["base"]."/data/isisuc.tab";                	}else{                		if (file_exists($db_path."isisuc.tab")) {
                			$uctab=$db_path."isisuc.tab";
                		}                	}                }
				echo "<table border=0 cellspacing=5>";
				echo "<tr><td valign=top>Available Forms: </td>";
				echo "              <td valign=middle><a href=javascript:SubirOpcion()>".$msgstr["up"]."</a>  | <a href=javascript:BajarOpcion()>".$msgstr["down"]."</a><br><select name=preferences size=3 multiple>";
				$pref=array();
				$sel=array();
				$pref["F"]="free";
				$pref["B"]="basic";
				$pref["A"]="advanced";
				if (!isset($adForm)){					$af=$pref;
				}else{					foreach ($adForm as $value){						$af[$value]=$pref[$value];
						$sel[$value]=" selected";					}
				}
				if (!isset($af["F"])) $af["F"]=$pref["F"];
				if (!isset($af["B"])) $af["B"]=$pref["B"];
				if (!isset($af["A"])) $af["A"]=$pref["A"];
				foreach ($af as $key=>$value){					echo "<option value=$key";
					if (isset($sel[$key])) echo " selected";
					echo ">".$msgstr[$value]."</option>\n";
				}
				echo "</select>";
				echo "</td>";
				echo "<tr><td valign=top>Send result by Email</td><td><input type=checkbox name=email value=ON $email> ON</td>";
				echo "<tr><td valign=top>Navigation Bar</td><td><input type=checkbox name=bar value=ON $bar> ON</td>";
				echo "<tr><td valign=top>".$msgstr["dpp"]."</td><td><input type=text name=dpp size=5 value=\"$dpp\"></td>";
				echo "<tr><td valign=top>".$msgstr["features"].": </td>";
				echo "              <td><input type=checkbox name=features_xml value=\"XML\" $features> XML</td></tr>";
				echo "<tr><td valign=top>UNICODE</td><td><input type=checkbox name=UNICODE value=\"ON\" ";
				if ($unicode!="")  echo " checked";
				echo "> ON</td>";
				echo "<tr><td valign=top>SEARCH UCTAB</td><td><input type=text name=uctab size=100 value=\"$uctab\"></td></TR>";
				echo "</table>";
		}

	}
?>
</form>
</div></div>
<?php include("../common/footer.php");?>
</body>
</html>