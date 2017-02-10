
<a href="../common/inicio.php?reinicio=s&modulo=loan"><strong>
			<?php echo "MENU"?></strong></a> |
<?php
if (!isset($link_u)) $link_u="";
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_LOAN"])){
?>
		<a href="../circulation/prestar.php?encabezado=s<?php echo $link_u?>" ><strong>
			<?php echo $msgstr["loan"]?></strong></a> |
<?php }
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_RENEW"])){
?>
		<a href="../circulation/renovar.php?encabezado=s<?php echo $link_u?>" ><strong>
			<?php echo $msgstr["renew"]?></strong></a> |
<?php }
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_RETURN"])){
?>
		<a href="../circulation/devolver.php?encabezado=s"><strong>
			<?php echo $msgstr["return"]?></strong></a> |

<?php }
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_RESERVE"])){
	if (!isset($reserve_active) or isset($reserve_active) and $reserve_active=="Y"){
?>
		<a href="../circulation/estado_de_cuenta.php?encabezado=s&reserve=S<?php echo $link_u?>"><strong>
			<?php echo $msgstr["reserve"]?></strong></a> |

<?php } }
if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_SALA"])){?>     <a href=../circulation/sala.php><strong><?php echo $msgstr["sala"]?></a><strong> |
<?php }
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_SUSPEND"])){
?>
		<a href="../circulation/sanctions.php?encabezado=s"><strong>
			<?php echo $msgstr["suspend"]."/".$msgstr["fine"]?></strong></a> |
<?php }?><br>
		<a href="../circulation/estado_de_cuenta.php?encabezado=s<?php echo $link_u?>"><strong>
			<?php echo $msgstr["statment"]?></strong></a> |

		<a href="../circulation/situacion_de_un_objeto.php?encabezado=s<?php echo $link_u?>"><strong>
			<?php echo $msgstr["ecobj"]?></strong></a> |

       <a href="../circulation/borrower_history.php?encabezado=s<?php echo $link_u?>"><strong>
			<?php echo $msgstr["bo_history"]?></strong></a> |



