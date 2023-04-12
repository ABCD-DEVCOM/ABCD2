
<form name="reservacion" method="post" action="../reserve/reservar_ex.php">
    <input type="hidden" name="encabezado"  value="s">
    <input type="hidden" name="usuario" value="<?php echo $arrHttp["usuario"]?>">
    <?php if (isset($arrHttp["reserve"])) echo "<input type=hidden name=reserve value=".$arrHttp["reserve"].">\n";
        if (isset($arrHttp["base"]))  echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";
        if (isset($control_number))   {
                echo "<input type=hidden name=Expresion value=$Expresion".">\n";
                echo "<input type=hidden name=control_number value=$control_number".">\n";
        }?>
</form>


<form name="busqueda" action="../reserve/buscar.php" method="post">
    <input type="hidden" name="base">
    <input type="hidden" name="desde" value="reserva">
    <input type="hidden" name="count" value="1">
    <input type="hidden" name="cipar">
    <input type="hidden" name="Opcion" value="formab">
    <input type="hidden" name="copies" value="<?php if (isset($copies)) echo $copies ?>">
    <input type="hidden" name="usuario" value="<?php echo $arrHttp["usuario"]?>">
</form>



<form name="EnviarFrm" method="post">
<?php if (isset($arrHttp["base"])) echo '<input type="hidden" name="base" value="'.$arrHttp["base"].'">';?>
<input type="hidden" name="usuario" value="">
<input type="hidden" name="inventory">
<input type="hidden" name="ecta" value="Y">
<input type="hidden" name="lang" value="<?php echo $lang;?>">
<?php if (isset($arrHttp["reserve"])){
	echo "<input type=hidden name=reserve value=S>\n";
}
?>
</form>

<form name="output" method="post">
<input type="hidden" name="base" value="reserve">
<input type="hidden" name="code">
<input type="hidden" name="name">
<input type="hidden" name="user">
<input type="hidden" name="sort">
<input type="hidden" name="retorno" value="../circulation/estado_de_cuenta.php">
<input type="hidden" name="lang" value="<?php echo $lang;?>">
<input type="hidden" name="reserva" value="S">
</form>