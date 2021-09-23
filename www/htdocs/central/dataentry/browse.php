<?php 
error_reporting(E_ALL);
session_start();

include ("../config.php");

if (!isset($_SESSION["permiso"])){
    header("Location: ../common/error_page.php") ;
}

include("../common/get_post.php");

//include for translate
include("../lang/dbadmin.php");
include("../lang/admin.php");
include("../lang/prestamo.php");
include("../lang/opac.php");

//Fields
$ABCD_lang = $_SESSION["lang"];
$ABCD_permission = $_SESSION["permiso"];
$ABCD_base = $arrHttp['base'];
$ABCD_cipar = $db_path."par/".$ABCD_base.".par";

//$Formato
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
         


//Treatment of the search expression
if (isset($arrHttp["Expresion"])){
    $arrHttp["Expresion"]=stripslashes($arrHttp["Expresion"]);
    $Expresion=trim($arrHttp["Expresion"]);
    $Expresion=str_replace("  "," ",$Expresion);
    $Expresion=str_replace("  "," ",$Expresion);
    $Expresion=str_replace('("',"",$Expresion);
    $Expresion=str_replace('")',"",$Expresion);
    $xor="¬or¬";
    $xand="¬and¬";
    $Expresion=str_replace (" {", "{", $Expresion);
    $Expresion=str_replace (" or ", $xor, $Expresion);
    $Expresion=str_replace ("+", $xor, $Expresion);
    $Expresion=str_replace (" and ", $xand, $Expresion);
    $Expresion=str_replace ("*", $xand, $Expresion);
    $nse=-1;
    while (is_integer(strpos($Expresion,'"'))){
        $nse=$nse+1;
        $pos1=strpos($Expresion,'"');
        $xpos=$pos1+1;
        $pos2=strpos($Expresion,'"',$xpos);
        $subex[$nse]=trim(substr($Expresion,$xpos,$pos2-$xpos));
        if ($pos1==0){
            $Expresion="{".$nse."}".substr($Expresion,$pos2+1);
        }else{
            $Expresion=substr($Expresion,0,$pos1-1)."{".$nse."}".substr($Expresion,$pos2+1);
        }
    }

   $Expresion=str_replace(" ","*",$Expresion);

    while (is_integer(strpos($Expresion,"{"))){
        $pos1=strpos($Expresion,"{");
        $pos2=strpos($Expresion,"}");
        $ix=substr($Expresion,$pos1+1,$pos2-$pos1-1);
        if ($pos1==0){
            $Expresion=$subex[$ix].substr($Expresion,$pos2+1);
        }else{
            $Expresion=substr($Expresion,0,$pos1)." ".$subex[$ix]." ".substr($Expresion,$pos2+1);
        }
    }
    $Expresion=str_replace ("¬", " ", $Expresion);
    $Expresion=urlencode($Expresion);
}
 

if (isset($arrHttp["unlock"]) and $arrHttp["Mfn"]!="New"){

//if the record editing was cancelled unlock the record or keep deleted
    $query="";
    if (isset($arrHttp["unlock"])){
        if (isset($arrHttp["Status"]) and $arrHttp["Status"]!=0)
            $IsisScript=$xWxis."eliminarregistro.xis";
        else
            $IsisScript=$xWxis."unlock.xis";
        $query = "&base=" . $arrHttp["base"] . "&cipar=$db_path"."par/".$arrHttp["base"]. ".par&Mfn=" . $arrHttp["Mfn"]."&login=".$_SESSION["login"];
        include("../common/wxis_llamar.php");
        $res=implode("",$contenido);
        $res=trim($res);
    }
}


//Function generating the paging
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


//check Option
if (isset($arrHttp['option'])) {
    $ABCD_option = $arrHttp['option'];
    $parameters = "&option=".$ABCD_option;
} else {
    $ABCD_option = "sort";
    $parameters = "&option=sort";
}

//check reverse
if (isset($arrHttp['reverse'])) {
    $ABCD_reverse = $arrHttp['reverse'];
    $parameters.= "&reverse=".$ABCD_reverse;
} else {
    $ABCD_reverse = "Off";
    $parameters.= "&reverse=Off";
}

//check sortkey
if (isset($arrHttp['sortkey'])) {
    $ABCD_sortkey = $arrHttp['sortkey'];
    $parameters.= "&sortkey=".$ABCD_sortkey;
} else {
    $ABCD_sortkey = "mfn";
    $parameters.= "&sortkey=mfn";
}

//check range
if (isset($arrHttp['range'])) {
    $ABCD_range = $arrHttp['range'];
    $parameters.= "&range=".$ABCD_range;
} else {
    $ABCD_range = "10";
    $parameters.= "&range=10";
}



//check from
if (isset($arrHttp['from'])) {
    $ABCD_from = $arrHttp['from'];
    $parameters.= "&from=".$ABCD_from;
} else {
    $ABCD_from = "1";
    $parameters.= "&from=1";
}

//checks the parameter "Expresion"
if (isset($arrHttp['Expresion'])) {
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


//Function Displays Options For Sorting Based On Sort.tab
function display_sort($db_path,$ABCD_base,$ABCD_lang) {
    global $msgstr;
    global $ABCD_sortkey;
    unset($fp);
    if (file_exists($db_path.$ABCD_base."/pfts/".$ABCD_lang."/sort.tab"))
        $fp = file($db_path.$ABCD_base."/pfts/".$ABCD_lang."/sort.tab");
    else
        if (file_exists($db_path.$ABCD_base."/pfts/".$ABCD_lang."/sort.tab"))
            $fp = file($db_path.$ABCD_base."/pfts/".$ABCD_lang."/sort.tab");
    if (isset($fp)){
        echo '<option value="">'.$msgstr["select"].'</option>';
        foreach ($fp as $value){
            if (trim($value)!=""){
                $pp=explode('|',$value);

                $ver_sortkey=$ABCD_sortkey;

               if (trim($pp[1]) == $ver_sortkey) {
                   $selected = 'selected';
               } else {
                   $selected = "";
               }
               echo '<option value="' . trim($pp[1]) . '" '.$selected.'>' . $pp[0] . '</option>';

            }
        }
    }

}


include("../common/header.php");
include("../common/institutional_info.php"); 

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
                    echo '<button class="button_browse show bt-blue" type="button" onclick="Mostrar('.$mfn.')"><i class="far fa-eye" alt="'.$msgstr["show"].'" title="'.$msgstr["show"].'"></i> '.$msgstr["show"].'</button>';
                
                    echo '<button class="button_browse edit" "type="button" onclick="Editar('.$mfn.','.$Isis_Status.')"><i class="fas fa-edit" alt="'.$msgstr["edit"].'" title="'.$msgstr["edit"].'"></i> '.$msgstr["edit"].'</button>';

                    echo '<button class="button_browse delete" type="button" onclick="Eliminar('.$mfn.')"><i class="far fa-trash-alt" alt="'.$msgstr["eliminar"].' title="'.$msgstr["eliminar"].' ></i> '.$msgstr["eliminar"].'</button>';
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


<div class="sectionInfo">

    <div class="breadcrumb">
        <?php $breadcrumb=$msgstr["admin"]." (".$arrHttp["base"].") | ".$total_lines." ".$msgstr["registros"];  ?>
        <?php echo $breadcrumb;?>
    </div><!--./breadcrumb-->


    <div class="actions">
        <?php
        if (!isset($arrHttp["return"])){
            $ret="../common/inicio.php?reinicio=s".$encabezado;
            if (isset($arrHttp["modulo"])) $ret.="&modulo=".$arrHttp["modulo"];
            if (isset($base)) $ret.="&base=".$base;
        }else{
            $ret=str_replace("|","?",$arrHttp["return"])."&encabezado=".$arrHttp["encabezado"];
        }
        ?>
        <a href=<?php echo $ret?> class="defaultButton backButton">
        <img src="../../assets/images/defaultButton_iconBorder.gif" alt="" title="" />
        <span><strong><?php echo $msgstr["back"]?></strong></span>
        </a>
        <a href="javascript:Crear()" class="defaultButton  newButton">
        <img src="../../assets/images/defaultButton_iconBorder.gif" alt="" title="" />
        <span><strong><?php echo $msgstr["crear"]?></strong> </span>
        </a>
    </div><!--.actions-->
    <div class="spacer">&#160;</div>
</div><!--./sectionInfo-->



<div class="middle list">

    <div class="searchBoxBrowser">
            

        <div class="f_left">    
 
        <!--SEARCH FORM-->    
            <button type="button" onclick="javascript:advancedSearch()" class="bt-blue">
                <i class="fas fa-search-plus"></i> <?php echo $msgstr["advsearch"];?>
            </button>

            <form name="forma1" class="formsearch" onsubmit="setGetParameter('forma1', 'ok')"> 
                <label><?php echo $msgstr["buscar"]?>: </label>
                <input type="hidden" name="reverse" value="<?php echo $ABCD_reverse;?>" onSubmit="setGetParameter('reverse', this.value,clear)">  
                <input type="hidden" name="sortkey" value="<?php echo $ABCD_sortkey;?>" >      
                <input type="hidden" name="range" value="<?php echo $ABCD_range;?>" >      
                <input type="hidden" name="base" value="<?php echo $arrHttp['base'];?>" onSubmit="setGetParameter('base', this.value,clear)">
                <input type="text" name="Expresion" placeholder="<?php echo $msgstr["m_busquedalibre"]?>..." class="textEntry b_search" onfocus="this.className = 'textEntry textEntryFocus b_search';"  onblur="this.className = 'textEntry b_search';" value='<?php if (isset($arrHttp["Expresion"])) echo $arrHttp['Expresion']?>' onchange="setGetParameter('Expresion', this.value)" />
                <button type="submit" class="bt-blue">
                    <i class="fas fa-search"></i> <?php echo $msgstr["buscar"]?>
                </button>            
            </form>
        <!--./SEARCH FORM-->

        </div><!--./f_left-->


        <div class="f_right">
            <!--Form for clearing all filters and search expressions-->
            <form>
                <input type="hidden" name="base" value="<?php echo $arrHttp['base'];?>" onSubmit="setGetParameter('base', this.value,clear)">
                <input type="hidden" name="reverse" value="<?php echo $ABCD_reverse;?>" onSubmit="setGetParameter('reverse', this.value,clear)">
                <button type="submit" class="bt-blue" value="sort" name="option" onclick="setGetParameter('option', this.value,clear)"><i class="fas fa-redo-alt"></i> <?php echo $msgstr["borrar"];?></button>
            </form>

            <!--Displays only deleted records-->
            <?php
             if ($ABCD_option=='showdeleted') {
            ?>
            <form>
                <input type="hidden" name="base" value="<?php echo $arrHttp['base'];?>" onSubmit="setGetParameter('base', this.value,clear)">
                <input type="hidden" name="reverse" value="<?php echo $ABCD_reverse;?>" onSubmit="setGetParameter('reverse', this.value,clear)">
                <button type="submit" class="bt-green"  value="sort" name="option" onclick="setGetParameter('option', this.value,clear)"><i class="far fa-eye-slash"></i> <?php echo $msgstr["showdelrec"];?></button>
            </form>

            <?php 
            } else {
            ?>

            <form>
                <input type="hidden" name="base" value="<?php echo $arrHttp['base'];?>" onSubmit="setGetParameter('base', this.value,clear)">
                <input type="hidden" name="reverse" value="<?php echo $ABCD_reverse;?>" onSubmit="setGetParameter('reverse', this.value,clear)">
                <input type="hidden" name="Expresion" onSubmit="setGetParameter('Expresion', this.value,clear)">

                <button type="submit" class="bt-blue" value="showdeleted" name="option" onclick="setGetParameter('option', this.value,clear)"><i class="far fa-eye"></i></i> <?php echo $msgstr["showdelrec"];?></button>

            </form>

            <?php
            }
            ?>
        </div><!--./f_right-->

    </div><!--./searchBoxBrowser-->


    <div class="SubsearchBoxBrowser">

        <div class="f_left">
             <h2>
               <?php
                 echo $msgstr["total_recup"].": ".$total_lines." ".$msgstr["registros"];
                ?>
            </h2>

            
        <!-- FORM RANGE -->
        <label><?php echo $msgstr["show"];?>: </label>
            <select name="range" id="range" class="textEntry" onchange="setGetParameter('range', this.value)">
                 <?php
            
                    if(!empty($_REQUEST['range'])) {
                      $selected = $_GET['range'];
                      $check = 'selected';
                      echo '<option value="'.$selected.'" '.$check.'>'.$selected.'</option>';
                    } else {
                      echo '<option value="" disabled selected>'.$msgstr["select"].'</option>';
                    }
                ?>           
                <option value="10" >10</option>
                <option value="20" >20</option>
                <option value="50" >50</option>
                <option value="100" >100</option>
            </select>

    
            <!-- ./FORM RANGE -->

            <!-- FORM SORTKEY -->   
                <label><?php echo $msgstr["orderby"];?>: </label>
                <select name="sortkey" class="textEntry" onchange="setGetParameter('sortkey', this.value)">
                    <?php echo display_sort($db_path,$ABCD_base,$ABCD_lang);?>
                </select>
            <!-- /SORTKEY -->   


            <!-- FORM ASC/DESC -->
            <form> 
                <input type="hidden" name="sortkey" value="<?php echo $ABCD_sortkey;?>" onSubmit="setGetParameter('reverse', this.value)">    
                <label>Reverse: </label>
                <select name="reverse" class="textEntry" onchange="setGetParameter('reverse', this.value)">
                    <option></option>
                          <?php                    
                              $selected = $ABCD_reverse;
                              $check = 'selected';
                              echo '<option value="" disabled selected>'.$msgstr["select"].'</option>';
                        ?>  
                    <option value="On" <?php if ($selected=="On") { echo $check; } ?> >On</option>
                    <option value="Off"  <?php if ($selected=="Off") {echo $check; }?> >Off</option>
                </select>
            </form>

        </div><!--./f_left-->



        <div class="f_right"> 
            <!-- FORM XLS -->
            <form name="spreadsheet" method="post" action="../dataentry/print.php" >
                <input type="hidden" name="base" value="<?php echo $arrHttp["base"]?>" >
                <input type="hidden" name="cipar" value="<?php echo $arrHttp["base"]?>.par" >
                <input type="hidden" name="tipof" value="CT">
            <?php
            if (isset($arrHttp["Expresion"])){
                $Expresion=str_replace("%2A","*",$Expresion);
                echo '<input type="hidden" name="Expresion" value="'.$Expresion.'">';
                }

            ?>
                <input type="hidden" name=headings value="<?php echo $arrHttp["headings"];?>">
                <input type="hidden" name="print_content" value="<?php echo $breadcrumb;?>">
                <input type="hidden" name="pft" value="<?php echo $Formato_html;?>">
                <input type="hidden" name="vp" value="TB">
                <button type="submit" class="bt-gray" onclick="document.spreadsheet.submit" ><i class="fas fa-table"></i> <?php echo $msgstr["wsproc"]?></button>
             </form>  
             <!-- ./FORM XLS -->

             <!-- FORM PRINT -->
            <form name="print" method="post" action="../dataentry/print.php" >
                <input type="hidden" name="base" value="<?php echo $arrHttp["base"]?>" >
                <input type="hidden" name="cipar" value="<?php echo $arrHttp["base"]?>.par" >
                <input type="hidden" name="tipof" value="CT">
                <input type="hidden" name="print_content" value="<?php echo $breadcrumb;?>">
            <?php
            if (isset($arrHttp["Expresion"])){
                $Expresion=str_replace("%2A","*",$Expresion);
                echo '<input type="hidden" name="Expresion" value="'.$Expresion.'">';
                }

            ?>
                <input type="hidden" name=headings value="<?php echo $arrHttp["headings"];?>">
                <input type="hidden" name="pft" value="<?php echo $Formato_html;?>">
                <input type="hidden" name="vp" value="S">
                <button type="submit" class="bt-gray" onclick="EnviarForma('P')"><i class="fas fa-print"></i> <?php echo $msgstr["Print"]?></button>
             </form>
             <!-- ./FORM PRINT -->


    </div><!--./f_right-->
        
    </div>


    <!--Table of Contents-->
        <table  class="listTable browse">
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

    <?php
        $head=$db_path.$arrHttp["base"]."/pfts/".$ABCD_lang."/".$pft_name[0]."_print.txt";

        if (file_exists($head)){
            $fp=file($head);
            $arrHttp["headings"]="";
            foreach ($fp as $value) {
                $arrHttp["headings"].=trim($value)."\r";
            }
        }
    ?>

</div><!--./middle list-->


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
    msgwin=window.open("show.php?base=<?php echo $arrHttp["base"]?>&cipar=<?php echo $arrHttp["base"]?>.par&Mfn="+Mfn+"&encabezado=s&Opcion=editar","show","width=600,height=400,scrollbars, resizable")
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
<form name="eliminar" method="post" action="eliminar_registro.php">
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
        if (isset($arrHttp["return"])) {
    ?>
    <input type="hidden" name="showdeleted" value="yes">
    <input type="hidden" name="return" value="<?php echo $arrHttp["return"];?>">
    <?php
    }
    ?>

</form>
<!--./FORM DELETE-->


<!--FORM EDITION-->
<form name="editar" method="post" action="fmt.php">
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
    <input type="hidden" name="retorno" value="browse.php">
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


<?php include("../common/footer.php"); ?>