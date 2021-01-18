
<a href="../common/inicio.php?reinicio=s&modulo=loan">
			<?php echo "MENU"?></a>&nbsp; | &nbsp;
<?php
if (!isset($link_u)) $link_u="";
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_LOAN"])){
?>
		<a href="../circulation/prestar.php?encabezado=s<?php echo $link_u?>" >
			<?php echo $msgstr["loan"]?></a>&nbsp; | &nbsp;
		<?php if (isset($ILL) and $ILL!=""){		?>
			 <a href="../circulation/interbib.php?encabezado=s<?php echo $link_u?>"><?php echo $msgstr["r_ill"]?></a>&nbsp; | &nbsp;
		<?php
		}}



if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_RENEW"])){
?>
		<a href="../circulation/renovar.php?encabezado=s<?php echo $link_u?>" >
			<?php echo $msgstr["renew"]?></a>&nbsp; | &nbsp;
<?php }
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_RETURN"])){
?>
		<a href="../circulation/devolver.php?encabezado=s">
			<?php echo $msgstr["return"]?></a>&nbsp; | &nbsp;

<?php }
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_RESERVE"])){
	if (!isset($reserve_active) or isset($reserve_active) and $reserve_active=="Y"){
?>
		<a href="../circulation/estado_de_cuenta.php?encabezado=s&reserve=S<?php echo $link_u?>">
			<?php echo $msgstr["reserve"]?></a>&nbsp; | &nbsp;

<?php } }
if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_SALA"])){?>     <a href=../circulation/sala.php><?php echo $msgstr["sala"]?></a>&nbsp; | &nbsp;
<?php }
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_SUSPEND"])){
?>
		<a href="../circulation/sanctions.php?encabezado=s<?php echo $link_u?>">
			<?php echo $msgstr["suspend"]."/".$msgstr["fine"]?></a>&nbsp; | &nbsp;
<?php }?><br>
		<a href="../circulation/estado_de_cuenta.php?encabezado=s<?php echo $link_u?>">
			<?php echo $msgstr["statment"]?></a>&nbsp; | &nbsp;

		<a href="../circulation/situacion_de_un_objeto.php?encabezado=s<?php echo $link_u?>">
			<?php echo $msgstr["ecobj"]?></strong></a>&nbsp; | &nbsp;

		<a href="../circulation/item_history.php?encabezado=s<?php echo $link_u?>">
			<?php echo $msgstr["item_history"]?></strong></a>&nbsp; | &nbsp;

		<a href="../circulation/borrower_history.php?encabezado=s<?php echo $link_u?>">
			<?php echo $msgstr["bo_history"]?></a>&nbsp; | &nbsp;






