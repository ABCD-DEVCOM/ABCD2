<?php
error_reporting(0);
if(session_id() == '') {
    session_start();
}
$fp=file("correo.ini");

// SE LEE LA CLAUSULA DE PROTECCION DE LOS DATOS
function getScriptOutput($path, $print = FALSE){
    ob_start();
    if( is_readable($path) && $path ){
        include $path;
    }else{
        return FALSE;
    }

    if( $print == FALSE )
        return ob_get_clean();
    else
        echo ob_get_clean();
}

foreach ($fp as $key=>$value){
	$value=trim($value);
	if ($value!=""){
		$x=explode('=',$value);
		$ini[$x[0]]=$x[1];
	}
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="es";
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../config.php");
$subtitle=" Correo invitación inscripción";
include ("../common/header.php");
?>
<div class="middle">
	<div class="formContent" >
<?php
$lang=$_SESSION["lang"];
$mensaje=getScriptOutput("../eventos/proteccion.php");
$IsisScript=$xWxis."z3950_cnv.xis";
$base=$_REQUEST["base"];
echo "Formato: $base/pfts/es/correo_01.pft &nbsp;<a href=javascript:EditarFormato()>Editar formato del correo</a><p>";
if (file_exists($db_path."$base/pfts/es/correo_01.pft")){
	$query = "?base=$base&cipar=$db_path"."par/$base.par&Expresion=$"."&Pft=v21'$$$'@$db_path"."$base/pfts/es/correo_01.pft&prologo=NNN&epilogo=NNN&Opcion=buscar";
	include("../common/wxis_llamar.php");
	// se obtiene el mes de las actividades para el encabezado
	foreach ($contenido as $value){		if (trim($value)!=""){
			$x=explode('$$$',$value);
			echo $x[1]."<br>";
			echo $mensaje."<hr>";
		}	}
}else{	echo "Ejemplo del formato:<xmp>
'<img src=http://localhost:9090/central/css/eventos/logo.png>'
'<p>'
'Sr(a). ',v34^b,\" \"v34^*
'<p>'
'Lo invitamos a '
'<a href=http://localhost:9090/central/gestion_usuarios/act_w.php?base=$base&u='v1,'&Mfn='f(mfn,1,0)'&i='v35'>
               actualizar su datos en nuestra base de datos</a> para recibir información acerca de nuestros eventos y productos.<p>'

'<a href=http://localhost:9090/central/gestion_usuarios/act_w_participante_eliminar_ex.php?base=$base&u='v1,'&Mfn='f(mfn,1,0)'&i='v35'>Darse de baja</a><p>'
</xmp>
Adapte los mensajes y URL's a su instalación";}
?>
<script>
function EditarFormato(){	msgwin=window.open("","editpft","width=800, height=400, scrollbars, resizable")
	document.editpft.submit()
	msgwin.focus()
}
</script>
<form name=editpft method=post action=../dbadmin/leertxt.php target=editpft>
<input type=hidden name=desde value=dataentry>
<input type=hidden name=base value=<?php if (isset($_REQUEST["base"])) echo $_REQUEST["base"]; else echo "caras_temp";?>>
<input type=hidden name=cipar value=<?php if (isset($_REQUEST["base"])) echo $_REQUEST["base"]; else echo "caras_temp";?>.par>
<input type=hidden name=archivo value=correo_01|||>
<input type=hidden name=pft>
<input type=hidden name=descripcion value="Envío correo inscripción Caracterización de Usuarios">
</form>