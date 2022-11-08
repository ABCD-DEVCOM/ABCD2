<?php
include ("tope_config.php");
$wiki_help="OPAC-ABCD_Apariencia#Estilos";
include "../../common/inc_div-helper.php";

?>
<script src="../../../opac/js/jscolor.js"></script>
<div class="middle form">
   <h3><?php echo $msgstr["styles"];?>
    </h3>
    <div class="formContent">

<div id="page">

<?php
if (!isset($_SESSION["db_path"])){
	echo "Session expired";die;
}

echo $msgstr["styles_body"]?>
    <img src=../../../opac/images_config/estilos_1.png border=1><br>

    <table>
        <tr>
            <td colspan=2>body</td>
        </tr>
        <tr>
            <td>Color de fondo</td>
            <td><input name=body_background value="" class="jscolor {width:243, height:150, position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}"></td>
        </tr>
    
        <tr>
            <td colspan=2>header-wrapper</td>
        </tr>
        <tr>
            <td>Color de fondo</td>
            <td><input name=header_wrapper_background value="" class="jscolor {width:243, height:150, position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}"></td>
        </tr>
    </table>
    
    <table>
        <tr>
            <td colspan=2>menu-wrapper (menu horizontal)</td>
        </tr>
        <tr>
            <td>Color de fondo</td>
            <td><input name=menu_wrapper_background value="" class="jscolor {width:243, height:150, position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}"></td>
        </tr>
        <tr>
            <td colspan=2>Enlaces del menú horizontal</td>
        </tr>
        <tr>
            <td>Fuente - familia(s)</td>
            <td><input name=menu_font_family value="" size=100></td>
        </tr>
        <tr>
            <td>Fuente - color</td>
            <input name=menu_font_family value="" class="jscolor {width:243, height:150, position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}"></td>
        </tr>
        <tr>
            <td>Fuente - tamaño</td>
            <td><input name=menu_font_size value="" size=1> px </td>
        </tr>
        <tr>
           <td>HOOVER - color</td>
            <td><input name=menu_li_coloe value="" class="jscolor {width:243, height:150, position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}"></td>
        </tr>

    </table>

</div>    
</div>    
</div>    

<?php include ("../../common/footer.php"); ?>