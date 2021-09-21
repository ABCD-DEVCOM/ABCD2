<?php
/* Modifications
2021-04-15 fho4abcd use charset from config.php+show charsets like institutional_info.php
2021-04-21 fho4abcd no undefined index for emergency user.
2021-05-03 fho4abcd Use include to select best language tables
*/
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
global $valortag;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

include("../common/get_post.php");
include("../config.php");



if (isset($arrHttp["lang"]) and  $arrHttp["lang"]!="")  $_SESSION["lang"]=$arrHttp["lang"];
include ("../lang/admin.php");
include ("../lang/lang.php");
include("leerregistroisispft.php");

$arrHttp["IsisScript"]="ingreso.xis";
if (isset($_SESSION["mfn_admin"])){
    $arrHttp["Mfn"]=$_SESSION["mfn_admin"];
} else {
    //Pointing to a user mfn in the acces database is not good.
    //The fake name is set in inicio.php
}

$fp = file($db_path."bases.dat");
if (!$fp){
	echo "falta el archivo bases.dat";
	die;
}
include("../common/header.php");
echo "<script>
top.listabases=Array()
top.basesdat=Array()\n";
foreach ($fp as $linea){
	$linea=trim($linea);
	if ($linea!="") {
		$ix=strpos($linea,"|");
		$ix_bb=explode('|',$linea);
		$llave=trim($ix_bb[0]);
		$lista_bases[$llave]=trim(substr($linea,$ix+1));
		echo "top.listabases['$llave']='".trim(substr($linea,$ix+1))."'\n";
		echo "top.basesdat['$llave']='".$ix_bb[1]."'\n";
	}

}
echo "</script>\n";

?>
<script>
lang='<?php echo $_SESSION["lang"]?>'

function AbrirAyuda(){
	msgwin=window.open("ayudas/"+lang+"/menubases.html","Ayuda","status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,width=750,height=500,top=10,left=5")
	msgwin.focus()
}

Entrando="S"

function VerificarEdicion(Modulo){
	 if(top.xeditar=="S"){
		alert("<?php echo $msgstr["aoc"]?>")
		return
	}
}

function CambiarBase(){
	tl=""
   	nr=""
   	top.img_dir=""
  	i=document.OpcionesMenu.baseSel.selectedIndex
  	top.ixbasesel=i
   	if (i==-1) i=0
  	abd=document.OpcionesMenu.baseSel.options[i].value

	if (abd.substr(0,2)=="--"){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	ab=abd+'|||'
	ix=ab.split('|')
	base=ix[0]
	top.base=base
	if (document.OpcionesMenu.baseSel.options[i].text==""){
		return
	}
	base_sel=base+'|'+ix[1]+'|'+top.basesdat[base]+'|'+ix[2]
	top.db_copies=ix[2]
	cipar=base+".par"
	top.nr=nr
	document.OpcionesMenu.base.value=base
   	document.OpcionesMenu.cipar.value=cipar
	document.OpcionesMenu.tlit.value=tl
	document.OpcionesMenu.nreg.value=nr
	top.base=base
	top.cipar=cipar
	top.mfn=0
	top.maxmfn=99999999
	top.browseby="mfn"
	top.Expresion=""
	top.Mfn_Search=0
	top.Max_Search=0
	top.Search_pos=0
	lang=document.OpcionesMenu.lang.value
	switch (top.ModuloActivo){
		case "dbadmin":

			top.menu.location.href="../dbadmin/index.php?base="+base

            break;
		case "catalog":
			i=document.OpcionesMenu.baseSel.selectedIndex
			document.OpcionesMenu.baseSel.options[i].text
			top.NombreBase=document.OpcionesMenu.baseSel.options[i].text
			top.location.href="inicio_main.php?base="+base_sel+"|"+"&base_activa="+base_sel+"&lang="+lang+"&cambiolang=s"
			top.menu.document.forma1.ir_a.value=""
			i=document.OpcionesMenu.baseSel.selectedIndex
			break
		case "Capturar":

			break
	}
}

function Modulo(){
	Opcion=document.OpcionesMenu.modulo.options[document.OpcionesMenu.modulo.selectedIndex].value
	switch (Opcion){
		case "loan":
			top.location.href="../common/change_module.php?modulo=loan"
			break
		case "acquisitions":
			top.location.href="../common/change_module.php?modulo=acquisitions"
			break

		case "dbadmin":
				document.OpcionesMenu.modulo.selectedIndex=0
				top.ModuloActivo="dbadmin"
			top.menu.location.href="../dbadmin/index.php?basesel="
			break
		case "catalog":
			top.main.location.href="inicio_base.php?inicio=s&base="+base+"&cipar="+base+".par"
			top.menu.location.href="../dataentry/menu_main.php?Opcion=continue&cipar=acces.par&cambiolang=S&base="+base
			top.ModuloActivo="catalog"
			if (i>0) {
				top.menu.location.href="../dataentry/menu_main.php?Opcion=continue&cipar=acces.par&cambiolang=S&base="+base
			}else{
				top.menu.location.href="../dataentry/blank.html"
			}
			break


	}
}

function CambiarLenguaje(){
	url=top.main.location.href
	lang=document.OpcionesMenu.lenguaje.options[document.OpcionesMenu.lenguaje.selectedIndex].value
	Opcion=top.ModuloActivo
	top.encabezado.location.href="menubases.php?base="+top.base+"&base_activa="+top.base+"&lang="+lang+"&cambiolang=s"
	switch (Opcion){
		case "loan":
			break
		case "dbadmin":
			top.menu.location.href="../dbadmin/index.php?Opcion=continue&lang="+lang+"&base="+top.base
			top.main.location.href=url
			break
		case "catalog":
			break
		case "statistics":
			break

	}
}
</script>
</head>
<body>

<?php

$verify_selbase="Y";

require_once ('../common/institutional_info.php');

?>



<script>
<?php
if (isset($arrHttp["inicio"]))
	$inicio="&inicio=s";
else
	$inicio="";
echo "top.menu.location.href=\"menu_main.php?base=\"+top.base+\"$inicio\"\n";?>
</script>
</body>
</html>

