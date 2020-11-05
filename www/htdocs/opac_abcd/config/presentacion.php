<?php
include ("tope_config.php");
echo "<script src=\"../js/jscolor.js\"></script>" ;
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){}
?>
<div id="page">
	<p>
    <h3><?php echo $msgstr["styles"]?> &nbsp; <a href=http://wiki.abcdonline.info/OPAC-ABCD_configuraci%C3%B3n#Estilos.2C_encabezado.2C_pie_de_p.C3.A1gina target=_blank><img src=../images_config/helper_bg.png></a></h3><p>
   <?php echo $msgstr["styles_msg"]?>
    <p><?php echo $msgstr["styles_body"]?> <p>
    <img src=../images_config/estilos_1.png border=1><br>
    <table>
    <tr><td colspan=2>body</td></tr>
    <tr><td>Color de fondo</td><td>
    <input name=body_background value="" class="jscolor {width:243, height:150, position:'right',
    borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}">
    </td></tr>
    <tr><td colspan=2>header-wrapper</td></tr>
    <tr><td>Color de fondo</td><td>
    <input name=header_wrapper_background value="" class="jscolor {width:243, height:150, position:'right',
    borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}">
    </td></tr>
    </table>
    <table>
    <tr><td colspan=2>menu-wrapper (menu horizontal)</td></tr>
    <tr><td>Color de fondo</td><td>
    <input name=menu_wrapper_background value="" class="jscolor {width:243, height:150, position:'right',
    borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}">
    </td></tr>
    <td colspan=2>Enlaces del menú horizontal</td></tr>
    <tr><td size=10></td><td>Fuente - familia(s)</td>
    <td>
    <input name=menu_font_family value="" size=100>
    </td></tr>
    <tr><td size=10></td><td>Fuente - color</td>
    <td>
    <input name=menu_font_family value="" class="jscolor {width:243, height:150, position:'right',
    borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}">
    </td></tr>
    <tr><td size=10></td><td>Fuente - tamaño</td>
    <td>
    <input name=menu_font_size value="" size=1> px
    </td></tr>
    <tr><td size=10></td><td>HOOVER - color</td>
    <td>
    <input name=menu_li_coloe value="" class="jscolor {width:243, height:150, position:'right',
    borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}">
    </td></tr>

    </table>

    <p>


<?php
//echo "<xmp>";
//PRINT_R ($_SERVER);
//echo "</xmp>";
include ("../php/footer.php");
?>
</div>
</div>
</body
</html>