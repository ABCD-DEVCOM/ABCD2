<?php
/* Modifications
20210310 fho4abcd Replaced helper code fragment by included file
20210310 fho4abcd html code:body at begin+...
20210310 fho4abcd check existence $L1
20220110 rogercgui change in process visualisation
*/

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/acquisitions.php");
include("../lang/dbadmin.php");
include("../lang/admin.php");
include("../lang/prestamo.php");
include("../lang/opac.php");

include("../common/get_post.php");
$arrHttp["base"]="suggestions";

//Fields - copied from dataentry/browse.php 
$ABCD_lang = $_SESSION["lang"];
$ABCD_permission = $_SESSION["permiso"];
$ABCD_base = $arrHttp['base'];
$ABCD_cipar = $db_path."par/".$ABCD_base.".par";

//$Formato - copied from dataentry/browse.php 
$table_browser="tb".$ABCD_base."";


if (isset($arrHttp["pft"]) and trim($arrHttp["pft"])!=""){
    $Formato=urlencode($arrHttp["pft"]);
}else{
    if (isset($table_browser) and $table_browser!="") {
        $pft_name=explode('|',trim($table_browser));
        $table_browser=$pft_name[0];
        if (isset($pft_name[1]))
            $arrHttp["tipof"]=trim($pft_name[1]);
        else
            $arrHttp["tipof"]="";
        if (strpos($table_browser,'.pft')===false) $table_browser.=".pft";
        $Formato=$db_path.$arrHttp["base"]."/pfts/".$ABCD_lang."/".$table_browser;

//To export to spreadsheet you must have a pft tbDABASE_html.pft
        $Formato_html=$db_path.$arrHttp["base"]."/pfts/".$ABCD_lang."/tb".$ABCD_base."_html.pft";
        if (!file_exists($Formato)){
            $Formato=$db_path.$arrHttp["base"]."/pfts/".$ABCD_lang."/".$table_browser;
        }
        if (file_exists($Formato)) $Formato="@".$Formato;
        if (file_exists($Formato_html)) $Formato_html="@".$Formato_html;
// READ THE HEADINGS, IF ANY
    //    if ($arrHttp["tipof"]!=""){
            $head=$db_path.$arrHttp["base"]."/pfts/".$ABCD_lang."/tbtit.tab";
            if (!file_exists($head)){
                $head=$db_path.$arrHttp["base"]."/pfts/".$ABCD_lang."/tbtit.tab";
            }

            if (file_exists($head)){
                $fp=file($head);
                $arrHttp["headings"]="";
                foreach ($fp as $value) {
                    $arrHttp["headings"].=trim($value)."\r";
                }
            }
       // }
    }
}
         

include("../common/header.php");


// Se determina el total de registros según cada status del proceso
$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&prefijo=STA_&Opcion=diccionario";
$IsisScript=$xWxis."ifp.xis";
include("../common/wxis_llamar.php");
$Total=array(0,0,0,0,0,0,0,0);

foreach ($contenido as $value)  {
	$L=explode('|',$value);
	$ix=substr($L[0],4);
	if (isset($L[1]) ) $Total[$ix]=$L[1];
}


//Function generating the paging - copied from dataentry/browse.php 
function custom_pagination($page, $totalpage, $link, $show)  {
    global $msgstr;
//show page
    if($totalpage == 0) { 
        return '<div class="navpage"><span class="current">'.$msgstr['Page'].' 0 '.$msgstr['de'].' 0</span></div>'; 
    } else { 

//Fixes the space for sprintf()
    $link=str_replace("%2A","*",$link);    
    $link=str_replace("%24","*",$link);    
        
        $nav_page = '<div class="navpage"><span class="current">'.$msgstr['Page'].' '.$page.' '.$msgstr['de'].' '.$totalpage.': </span>'; 
        $limit_nav = 3; 
        $start = ($page - $limit_nav <= 0) ? 1 : $page - $limit_nav; 
        $end = $page + $limit_nav > $totalpage ? $totalpage : $page + $limit_nav; 
    if($page + $limit_nav >= $totalpage && $totalpage > $limit_nav * 2) { 
        $start = $totalpage - $limit_nav * 2; 
    } 

    if($start != 1){ //show first page 
        $nav_page .= '<span class="item"><a href="'.sprintf($link, 1).'"> 1 </a></span>'; 
    } 
    if($start > 2){ //add ... 
        $nav_page .= '<span class="current">...</span>'; 
    } 
    if($page > 5){ //add prev 
        $nav_page .= '<span class="item"><a href="'.sprintf($link, $page-5).'">&laquo;</a></span>'; 
    } 
    for($i = $start; $i <= $end; $i++){ 
    if($page == $i) 
        $nav_page .= '<span class="current">'.$i.'</span>'; 
    else 
        $nav_page .= '<span class="item"><a href="'.sprintf($link, $i).'"> '.$i.' </a></span>'; 
    } 
    if($page + 3 < $totalpage){ //add next 
        $nav_page .= '<span class="item"><a href="'.sprintf($link, $page+4).'">&raquo;</a></span>'; 
    } 
    if($end + 1 < $totalpage){ //add ... 
        $nav_page .= '<span class="current">...</span>'; 
    }     
    if($end != $totalpage) //show last page 
        $nav_page .= '<span class="item"><a href="'.sprintf($link, $totalpage).'"> '.$totalpage.'</a></span>'; 
        $nav_page .= '</div>'; 
    return $nav_page; 
    } 
} 

//Checks the page number, otherwise the value is 1
if(isset($arrHttp['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}


//check Option - copied from dataentry/browse.php 
if (isset($arrHttp['option'])) {
    $ABCD_option = $arrHttp['option'];
    $parameters = "&option=".$ABCD_option;
} else {
    $ABCD_option = "sort";
    $parameters = "&option=sort";
}

//check reverse - copied from dataentry/browse.php 
if (isset($arrHttp['reverse'])) {
    $ABCD_reverse = $arrHttp['reverse'];
    $parameters.= "&reverse=".$ABCD_reverse;
} else {
    $ABCD_reverse = "Off";
    $parameters.= "&reverse=Off";
}

//check sortkey - copied from dataentry/browse.php 
if (isset($arrHttp['sortkey'])) {
    $ABCD_sortkey = $arrHttp['sortkey'];
    $parameters.= "&sortkey=".$ABCD_sortkey;
} else {
    $ABCD_sortkey = "mfn";
    $parameters.= "&sortkey=mfn";
}

//check range - copied from dataentry/browse.php 
if (isset($arrHttp['range'])) {
    $ABCD_range = $arrHttp['range'];
    $parameters.= "&range=".$ABCD_range;
} else {
    $ABCD_range = "10";
    $parameters.= "&range=10";
}



//check from - copied from dataentry/browse.php 
if (isset($arrHttp['from'])) {
    $ABCD_from = $arrHttp['from'];
    $parameters.= "&from=".$ABCD_from;
} else {
    $ABCD_from = "1";
    $parameters.= "&from=1";
}

//checks the parameter "Expresion"
if (isset($arrHttp['Expresion'])) {
	$Expresion = $arrHttp['Expresion'];
    $parameters.= "&Expresion=".$Expresion;
 
} else {
    $parameters.= "";
}

if (isset($arrHttp['encabezado'])) {
    $encabezado=$arrHttp['encabezado'];
} else {
    $encabezado = "s";
}

//Query that triggers WXIS
$query = "&base=".$ABCD_base."&cipar=".$ABCD_cipar."&Formato=".$Formato.$parameters;


$IsisScript=$xWxis."browse.xis";
include("../common/wxis_llamar.php");


if ($ABCD_permission==""){
    echo "<br><br><h2>".$msgstr["menu_noau"]."<h2>";
    die;
}

if (strpos($ABCD_base,'^')===false){

} else {
    $b=explode('^',$ABCD_base);
    $ABCD_base=substr($b[1],1);
    $arrHttp["base"]=$ABCD_base;
}

//Read the table with the column headings
$archivo_tit=$db_path.$ABCD_base."/pfts/".$ABCD_lang."/tbtit.tab";

$archivo_field=$db_path.$ABCD_base."/pfts/".$ABCD_lang."/tb".$ABCD_base.".pft";


//Function created to display the information of the columns
function read_collumns($archivo_tit) {
    global $ABCD_reverse;

    switch ($ABCD_reverse) {
    case "On":
         $class_order = '<i class="fas fa-sort-amount-down"></i>';
        break;
    case "Off":
         $class_order = '<i class="fas fa-sort-amount-down-alt"></i>';
        break;
    }

    if (!file_exists($archivo_tit)) $archivo_tit=$db_path.$ABCD_base."/pfts/".$ABCD_lang."/tbtit.tab";
    if (!file_exists($archivo_tit)) $archivo_tit=$db_path.$ABCD_base."/pfts/".$ABCD_lang."/tb".$ABCD_base."_print.txt";
    if (!file_exists($archivo_tit)) $archivo_tit=$db_path.$ABCD_base."/pfts/".$ABCD_lang."/tb".$ABCD_base."_print.txt";
    $Pft_t=explode("/",$archivo_tit);
    $Pft_tit=end($Pft_t);
        echo "<tr><th>".$class_order."</th><th>MFN</th>";
    if (file_exists($archivo_tit)){
        $fp=file($archivo_tit);
        foreach ($fp as $value){
            $value=trim($value);
            if (trim($value)!=""){
                $t=explode('|',$value);
                foreach ($t as $rot) echo "<th>".$rot."</th>";
            }
        }
    }
    echo "<th class=\"action\"></th></tr>";
}


$mode = 0;

if ($mode == 0) { 
    $opFile = $query; 
    } 
    $posts = array();

//Loop to count the total of rows
foreach ($contenido as $line){
    $line=trim($line);
    if ($line!=""){
        $post = explode('|', $line);
        array_push($posts, $post);
//    echo $line."<br>";
    }
}

//count total 
$total_lines = count($posts); 

//$show define range
if (isset($_GET['range'])){
    $show = $_GET['range'];
} else {
$show = 10; //Show 10 result per page
}

$totalpage = ceil($total_lines / $show); //Total page

$start = ($page * $show) - $show; //Start result

$end_l = ($page * $show) - ($total_lines + $show); 

//Figure out the first and last posts on this page
$first_post = ($page - 1) * $show;
$last_post = $page + 1 * $show;



function generate_table($contenido, $first_post, $last_post,$show,$total_lines,$end_l) {
    global $msgstr;
    global $ABCD_reverse;
    global $ABCD_sortkey;
    $i=1;

    //$input_array=array_slice($contenido, $first_post, $last_post);
    $input_array=array_slice($contenido, $first_post, $last_post);

    foreach($input_array as $line) {

    if($i==$show+1) break;
        //Ignore blank lines
        if($line != "") {
            //Explode each non-empty line
            $post = explode('|', $line);
            $Isis_Status=$post[0];
            $Isis_Item=$post[1];
            $Isis_Total=$post[2];
            $mfn=$post[3];

            echo "<style>";
            echo  "td.".$ABCD_sortkey." {
                    font-weight: bold; 
                    background: var(--cyan);
                }";
            echo "</style>";
            
                if ($Isis_Status==1) {
                echo "<style>
                .bg_status-".$Isis_Item."{ 
                    color: #666;
                }

                </style>";
                }

                if ($Isis_Status==-2) {
                    echo "<style>
                    .bg_status-".$Isis_Item."{ 
                        color: #d63031;
                    }
                    </style>";
                }

                switch ($ABCD_reverse) {
                case "On":
                    $n_lines = substr($end_l++,1);
                    break;
                case "Off":
                     $n_lines = $Isis_Item;
                    break;
                default: $Isis_Item;
                }
      

                echo "<tr class=\"bg_status-".$Isis_Item."\" onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = 'bg_status-".$Isis_Item."';\">\n";
                echo "<td><small>".$n_lines."/".$Isis_Total."</small></td>";
                echo "<td>".$mfn;
                echo "</td>";
                for ($ix=7;$ix<count($post);$ix++) echo '<td class="'.$post[$ix].'">'.$post[$ix].'</td>';
                echo '<td class="action" nowrap>';

                if ($Isis_Status==0) {
                    echo '<button class="button_browse show bt-blue" type="button" title='.$msgstr["show"].' onclick="Mostrar('.$mfn.')"><i class="far fa-eye" alt="'.$msgstr["show"].'" title="'.$msgstr["show"].'"></i> </button>';
                
                    echo '<button title="'.$msgstr["edit"].'" class="button_browse edit bt-green" "type="button" onclick="Editar('.$mfn.','.$Isis_Status.')"><i class="fas fa-edit" alt="'.$msgstr["edit"].'" title="'.$msgstr["edit"].'"></i></button>';

                    echo '<button title="'.$msgstr["eliminar"].'" class="button_browse delete bt-red" type="button" onclick="Eliminar('.$mfn.')"><i class="far fa-trash-alt" alt="'.$msgstr["eliminar"].' title="'.$msgstr["eliminar"].' ></i> </button>';
                } else {
                    switch ($Isis_Status){
                        case -2:
                            echo '<button class="button_browse edit" "type="button" onclick="Editar('.$mfn.','.$Isis_Status.')">
                                <i class="fas fa-edit" alt="'.$msgstr["edit"].'" title="'.$msgstr["edit"].'"></i> '.$msgstr["edit"]." ".$msgstr["recblock"].'</button>';
                            break;
                        case 1:
                            echo '<button class="button_browse edit" "type="button" onclick="Editar('.$mfn.','.$Isis_Status.')"><i class="fas fa-edit" alt="'.$msgstr["edit"].'" title="'.$msgstr["edit"].'"></i> '.$msgstr["edit"]." ".$msgstr["recdel"].'</button>';                        
                            break;
                    }
                }
                echo "</td>";
                echo "</tr>";
        }
          $i++;  
    }

}//generate_table()
?>

<style type="text/css">
	a.<?php echo $Expresion;?> {
		font-weight: bold;
	}

</style>

<body>

<?php
$encabezado="";
include("../common/institutional_info.php");
?>

<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["suggestions"]?>
	</div>
	<div class=actions>
	</div>
<?php include("suggestions_menu.php");?>
</div>
<?php 
$ayuda="acquisitions/overview.html";
include "../common/inc_div-helper.php" 
?>

<div>
<div class="middle form">
	<h3><?php echo $msgstr["overview"].": ".$msgstr["suggestions"]?></h3>
	<div class="formContent row">

	
	<div class="col-2 abcd-sidebar abcd-bar-block"  style="width:20%">
	<h3 class="w3-bar-item">Menu</h3>
		<a href="overview.php?base=suggestions&Expresion=STA_0" class="abcd-bar-item abcd-button STA_0" >
			<i class="far fa-clock"></i> <?php echo $msgstr["status_0"]?> (<?php if (isset( $Total[0])) echo $Total[0]?>) 
		</a>
		
		
		<a href="overview.php?base=suggestions&Expresion=STA_1" class="abcd-bar-item abcd-button STA_1" >
			<i class="far fa-thumbs-up"></i> <?php echo $msgstr["approved"]?> (<?php if (isset($Total[1])) echo $Total[1]?>) 
		</a>
		
		
		<a href="overview.php?base=suggestions&Expresion=STA_2" class="abcd-bar-item abcd-button STA_2" >
			<i class="far fa-thumbs-down"></i> <?php echo $msgstr["rejected"]?>
		(<?php if (isset($Total[2])) echo $Total[2]?>) </a>
		
		
		<a href="overview.php?base=suggestions&Expresion=STA_3" class="abcd-bar-item abcd-button STA_3" >
			<i class="fas fa-search-dollar"></i> <?php echo $msgstr["inbidding"]?>
		(<?php if (isset($Total[3])) echo $Total[3]?>) </a>
		
		
		<a href="overview.php?base=suggestions&Expresion=STA_4" class="abcd-bar-item abcd-button STA_4" >
			<i class="fas fa-shopping-cart"></i> <?php echo $msgstr["prov_sel"]?>
		(<?php if (isset($Total[4])) echo $Total[4]?>) </a>
		
		
		<a href="overview.php?base=suggestions&Expresion=STA_5" class="abcd-bar-item abcd-button STA_5" >
			<i class="fas fa-file-invoice-dollar"></i> <?php echo $msgstr["purchase"]?>
		(<?php if (isset($Total[5])) echo $Total[5]?>) </a>
		
		
		<a href="overview.php?base=suggestions&Expresion=STA_6" class="abcd-bar-item abcd-button STA_6" >
			<i class="fas fa-receipt"></i> <?php echo $msgstr["itemsrec"]?>
		(<?php if (isset($Total[6])) echo $Total[6]?>) </a>
		
		
		<a href="overview.php?base=suggestions&Expresion=STA_7" class="abcd-bar-item abcd-button STA_7" >
			<i class="fas fa-check"></i> <?php echo $msgstr["completed"]?>
			(<?php if (isset($Total[7])) echo $Total[7]?>) 
		</a>
		
	
	</div> <!--./col-2-->

	<div class="col-10">
        <table  class=" browse">
            <?php echo read_collumns($archivo_tit);?>
            <?php echo generate_table($contenido, $first_post, $last_post,$show,$total_lines,$end_l) ;?>
            <?php echo read_collumns($archivo_tit);?>
        </table>


    <div class="tMacroActions Browser">
        <div class="spacer">&#160;</div>     
         <?php
        //Show pagination
        echo custom_pagination($page, $totalpage, 'browse.php?action=detail&page=%s&base='.$arrHttp['base'].'&range='.$show.$parameters , $show);
         ?>
        <div class="spacer">&#160;</div>        
    </div><!--./tMacroActions-->  

    </div>  
    
	</div>
</div>



<script type="text/javascript">

function setGetParameter(paramName, paramValue, clear) {

clear = typeof clear !== 'undefined' ? clear : false;

var url = window.location.href;
var queryString = location.search.substring(1); 
var newQueryString = "";

if (clear)
{
    newQueryString = paramName + "=" + paramValue;
}
else if (url.indexOf(paramName + "=") >= 0)
{
    var decode = function (s) { return decodeURIComponent(s.replace(/\+/g, " ")); };
    var keyValues = queryString.split('&'); 
    for(var i in keyValues) { 
        var key = keyValues[i].split('=');
        if (key.length > 1) {
            if(newQueryString.length > 0) {newQueryString += "&";}
            if(decode(key[0]) == paramName)
            {
                newQueryString += key[0] + "=" + encodeURIComponent(paramValue);
            }
            else
            {
                newQueryString += key[0] + "=" + key[1];
            }
        }
    } 
}
else
{
    if (url.indexOf("?") < 0)
        newQueryString = "?" + paramName + "=" + paramValue;
    else
        newQueryString = queryString + "&" + paramName + "=" + paramValue;
}
window.location.href = window.location.href.split('?')[0] + "?" + newQueryString;
}

function advancedSearch(){
    base = '<?php echo $arrHttp["base"]?>'
    cipar = base+".par"
    Url ="../dataentry/buscar.php?Opcion=formab&prologo=prologoact&Target=s&Tabla=cGlobal&base="+base+"&cipar="+cipar
    msgwin=window.open(Url,"Buscar","menu=no, resizable,scrollbars,width=750,height=400")
    msgwin.focus()
}

function EnviarForma(vp){
    if (vp=="P") {
        document.print.vp.value="S"
        document.print.target="VistaPrevia"
        msgwin=window.open("","VistaPrevia","width=400,top=0,left=0,resizable, status, scrollbars")
    }else{
        document.print.vp.value=vp
        document.print.target=""
    }
        document.print.submit()
    msgwin.focus();

}

//Basic functions
function Editar(Mfn,Status){
        document.editar.Mfn.value=Mfn
        document.editar.Status.value=Status
        document.editar.Opcion.value="editar"
        document.editar.submit()
}

function Crear(){
        document.editar.Mfn.value="New"
        document.editar.Opcion.value="nuevo"
        document.editar.submit()
}


function Mostrar(Mfn){
    msgwin=window.open("../dataentry/show.php?base=<?php echo $arrHttp["base"]?>&cipar=<?php echo $arrHttp["base"]?>.par&Mfn="+Mfn+"&encabezado=s&Opcion=editar","show","width=600,height=400,scrollbars, resizable")
    msgwin.focus()
}

function Eliminar(Mfn){
    if (confirm('<?php echo $msgstr["areysure"]?>')){
        xEliminar=""
        document.eliminar.Mfn.value=Mfn
        document.eliminar.submit()
    }
}

</script>


<!--FORM DELETE-->
<form name="eliminar" method="post" action="../dataentry/eliminar_registro.php">
    <input type="hidden" name="base" value="<?php echo $arrHttp["base"]; ?>">
    <input type="hidden" name="from" value="<?php echo $first_post+1; ?>">

    <?php if (isset($arrHttp["Expresion"])) { ?>
    <input type="hidden" name="Expresion" value="<?php echo urlencode($arrHttp["Expresion"]);?>">
    <?php
    }
    ?>
    <input type="hidden" name="Mfn">
    <?php if (isset($arrHttp["encabezado"])) ?>
    <input type="hidden" name="encabezado" value="s">
    <?php


    if (isset($arrHttp["encabezado"])){
        echo "<input type=hidden name=encabezado value=s>\n";
    }
    if (isset($arrHttp["return"])){
        echo "<input type=hidden name=retorno value=".$arrHttp["return"].">\n";
        echo '<input type="hidden" name="showdeleted" value="yes">';
    }
    if (isset($arrHttp["Expresion"])) echo "<input type=hidden name=Expresion value=".urlencode($arrHttp["Expresion"]).">\n";
    ?>
</form>
<!--./FORM DELETE-->


<!--FORM EDITION-->
<form name="editar" method="post" action="../dataentry/fmt.php">
    <input type="hidden" name="from" value="<?php echo $first_post+1; ?>">
    <input type="hidden" name="base" value="<?php echo $arrHttp["base"]; ?>">
    <input type="hidden" name="cipar" value="<?php echo $arrHttp["base"]; ?>.par">
    <?php
    if (isset($arrHttp["modulo"])) {
    ?>  
    <input type="hidden" name="modulo" value="<?php echo $arrHttp["modulo"]; ?>.par">
    <?php
    }
    ?>
    <input type="hidden" name="Mfn">
    <input type="hidden" name="Status">
    <input type="hidden" name="showdeleted" value="yes">
    <input type="hidden" name="retorno" value="../acquisitions/overview.php">
    <input type="hidden" name="Opcion" value="editar">
    <input type="hidden" name="encabezado" value="s">
    <?php


    if (isset($arrHttp["encabezado"])){
        echo "<input type=hidden name=encabezado value=s>\n";
    }
    if (isset($arrHttp["return"])){
        echo "<input type=hidden name=return value=".$arrHttp["return"].">\n";
        echo '<input type="hidden" name="showdeleted" value="yes">';
    }
    if (isset($arrHttp["Expresion"])) echo "<input type=hidden name=Expresion value=".urlencode($arrHttp["Expresion"]).">\n";
    ?>
</form>
<!--./FORM EDITION-->


<?php
include("../common/footer.php");
?>