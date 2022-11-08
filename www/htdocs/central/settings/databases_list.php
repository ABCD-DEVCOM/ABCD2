<?php
/*
20220313 fho4abcd edit list in next window and not in pop-up.Update of the file in this script
20220316 fho4abcd Only one update
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../common/header.php");
$base="";
$confirmcount=0;
$backtoscript="conf_abcd.php";
if (isset($arrHttp["base"])) $base=$arrHttp["base"];
if (isset($arrHttp["confirmcount"])) $confirmcount=$arrHttp["confirmcount"];
?>
<body>
<!--link rel=stylesheet href=../css/styles.css type=text/css -->
<script language=Javascript src=../dataentry/js/selectbox.js></script>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script>
function Editar(){
	document.editform.submit()
}

function Enviar(){
	ValorCapturado=""
	for (i=0;i<document.forma1.lista.options.length;i++){
		a= Trim(document.forma1.lista.options[i].value)
		if (a!="") {
			if (ValorCapturado=="")
				ValorCapturado=a
			else
			    ValorCapturado+="\n"+a
		}
	}
	document.forma1.txt.value=ValorCapturado
	document.forma1.submit()
}
</script>
<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["dblist"] ?>
	</div>
	<div class="actions">
	<?php 
		$backtoscript="conf_abcd.php";
		include "../common/inc_back.php";
		include "../common/inc_home.php";
        $savescript="javascript:Enviar()";
        if ($confirmcount==0) include "../common/inc_save.php";
	?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php"
?>
<div class="middle form">
<div class="formContent">
<?php
if ($confirmcount==0){
    $confirmcount++;
    // Show and edit the filecontent
    ?>
    <form name=editform action=editararchivotxt.php method=post onsubmit='javascript:return false'>
    <input type=hidden name=archivo value='bases.dat'>
    <input type=hidden name=backtoscript value=databases_list.php>
    <input type=hidden name=base value="<?php echo $base;?>">
    </form>

    <form name=forma1  method=post onsubmit='javascript:return false'>
    <input type=hidden name=confirmcount value=<?php echo $confirmcount;?>>
    <input type=hidden name=txt>
    <input type=hidden name=archivo value='bases.dat'>
    <input type=hidden name=retorno value=databases_list.php>
    <input type=hidden name=encabezado value=s>
    <input type=hidden name=base value="<?php echo $base;?>">
    <br><center>
    <table border=0>
        <tr>
            <td valign=center>
                <button class="button_browse show" TYPE="button" VALUE="up" onClick="moveOptionUp(this.form['lista'])">
                    <i class="fas fa-sort-up"></i>
                </button>
                <BR><BR>
                <button class="button_browse show" TYPE="button" VALUE="down" onClick="moveOptionDown(this.form['lista'])">
                    <i class="fas fa-sort-down"></i>
                </button>
            </td>
            <td>
                <select name=lista size=20>
                <?php
                $fp=file($db_path."bases.dat");
                foreach ($fp as $value){
                    if (trim($value)!=""){
                        $b=explode('|',$value);
                        echo "<option value='$value'>".$b[1]." (".$b[0].")</option>";
                    }
                }
                ?>
                </select>
            </td>
    </table>
    <a class="bt bt-green" href="javascript:Enviar()" ><i class="far fa-save"></i> <?php echo $msgstr["update"]?></a>
    <a class="bt bt-blue" href="javascript:Editar()" ><i class="far fa-edit"></i> <?php echo $msgstr["edit"]?></a>
    <a class="bt bt-gray" href="<?php echo $backtoscript;?>"><i class="far fa-window-close"></i> &nbsp;<?php echo $msgstr["cancel"]?></a>
    </form>

    <form name=cancelar method=post action=conf_abcd.php>
    <input type=hidden name=encabezado value=s>
    </form>
    </center>
    <?php
} else if ($confirmcount>0 ) {
    // Write the file if this was a "next" run
    $arrHttp["txt"]=stripslashes($arrHttp["txt"]);
    $arrHttp["txt"]=str_replace("\"",'"',$arrHttp["txt"]);
    $arrHttp["txt"]=str_replace(PHP_EOL.PHP_EOL,PHP_EOL,$arrHttp["txt"]);
    $archivo=$arrHttp["archivo"];
    $fp=fopen($db_path.$archivo,"w");
    fputs($fp,$arrHttp["txt"]);
    fclose($fp);
    echo "<h4 style='text-align:center'>";
    echo $archivo." ".$msgstr["updated"];
    echo "</h4>";
}
?>
</div></div>
<?php include("../common/footer.php");?>
