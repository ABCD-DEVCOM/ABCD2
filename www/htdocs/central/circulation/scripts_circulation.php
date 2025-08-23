<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<script>
	function SendMail(code, Mfn) {
		msgwin = window.open("../reserve/mail.php?code=" + code + "&Mfn=" + Mfn, "MAIL", "width=400,height=600,resizable,scrollbars")
		msgwin.focus()
	}

	function PrintReserve(code, Mfn) {
		msgwin = window.open("../reserve/print.php?code=" + code + "&Mfn=" + Mfn<?php if ((isset($arrHttp["desde"]) and $arrHttp["desde"] == "IAH_RESERVA")) echo "+\"&lang=" . $arrHttp["lang"] . "\"" ?>, "PRINT", "width=400,height=400,resizable,scrollbars")
		msgwin.focus()
	}

	function ShowReservations(CN, BD) {
		msgwin = window.open("../reserve/show_reservations.php?submenu=N&key=" + CN + "&bases=" + BD, "reservations", "width=1000,height=400,resizable,scrollbars")
		msgwin.focus()
	}

	function Reservar(usuario) {
		if (nMultas > 0 || nv > 0 || nSusp > 0) {
			alert("<?php echo $msgstr["reservations_not_allowed"] ?>")
			return
		}
		ix = document.ecta.bd.selectedIndex
		if (ix > 0) {
			base = document.ecta.bd.options[ix].value
			document.busqueda.base.value = base
			document.busqueda.cipar.value = base + ".par"
			document.busqueda.submit()
		} else {
			alert("<?php echo $msgstr["seldb"] ?>")
			return
		}
		document.busqueda.submit()
	}

	function EvaluarRenovacion(p, atraso, fecha_d, nMultas, item) {
		if (p[6] == 0 && p[6] != "") {
			alert(item + ". <?php echo $msgstr["noitrenew"] ?>")
			return true
		}
		if (atraso != 0) {
			if (p[13] != "Y") {
				alert(item + ". <?php echo $msgstr["loanoverduedbut"] ?>")
				return true
			}
		}
		if (Trim(p[15]) != "") {
			if (fecha_d > p[15]) {
				alert(item + ". <?php echo $msgstr["limituserdata"] ?>" + ": " + p[15])
				return false
			}
		}
		if (Trim(p[16]) != "") {
			if (fecha_d > p[16]) {
				alert(item + ". <?php echo $msgstr["limitobjectdata"] ?>" + ": " + p[16])
				return false
			}
		}
		if (nMultas != 0) {
			alert(item + ". <?php echo $msgstr["norenew"] ?>")
			return false
		}
		return true
	}

	function DevolverRenovar(Proceso, politica) {
		if (Proceso == "D") {
			document.devolver.action = "devolver_ex.php"
		} else {
			if (Vigencia == "N") {
				alert("<?php echo $msgstr["norenew"] ?>");
				return
			}
			document.devolver.action = "renovar_ex.php"
		}
		marca = "N"
		search = ""
		atraso = ""
		switch (np) {
			case 1:
				if (document.ecta.chkPr_1.checked) {
					search = document.ecta.chkPr_1.id
					atraso = document.ecta.chkPr_1.value
					fecha_d = "<?php echo date("Ymd") ?>"
					p = politica.split('|')
					if (Proceso == "R") {
						res = EvaluarRenovacion(p, atraso, fecha_d, nMultas, 1)
						if (res)
							marca = "S"
						else
							marca = "N"
					} else {
						marca = "S"
					}
				}
				break
			default:
				for (i = 1; i <= np; i++) {
					Ctrl = eval("document.ecta.chkPr_" + i)
					if (Ctrl.checked) {
						marca = "S"
						search += Ctrl.id + "$$"
						atraso = Ctrl.value
						fecha_d = "<?php echo date("Ymd") ?>"
						p = politica.split('|')

						if (Proceso == "R") {
							res = EvaluarRenovacion(p, atraso, fecha_d, nMultas, i)
							if (res)
								marca = "S"
							else
								marca = "N"
						} else {
							marca = "S"
						}
					}
				}

		}
		if (marca == "S") {
			document.devolver.searchExpr.value = search
			var elementExists = document.getElementById("lpn");
			if (elementExists != null)
				document.devolver.lpn.value = document.ecta.lpn.value
			document.devolver.submit()
		} else {
			alert("<?php echo $msgstr["markloan"] ?>")
		}
	}


	function PagarMultas(Accion) {
		Mfn = ""
		switch (nMultas) {
			case 1:
				if (document.ecta.pay.checked) {
					Mfn = document.ecta.pay.value
				}
				break
			default:
				for (i = 0; i < nMultas; i++) {
					if (document.ecta.pay[i].checked) {
						Mfn += document.ecta.pay[i].value + "|"
					}
				}
				break
		}
		if (Mfn == "") {
			alert("<?php echo $msgstr["selfine"] ?>")
			return
		}
		document.multas.Mfn.value = Mfn
		document.multas.Accion.value = Accion
		document.multas.Tipo.value = "M"
		document.multas.submit()
	}


	function DeleteSuspentions(Accion) {
		Mfn = ""
		switch (nSusp) {
			case 1:
				if (document.ecta.susp.checked) {
					Mfn = document.ecta.susp.value
				}
				break
			default:
				for (i = 0; i < nSusp; i++) {
					if (document.ecta.susp[i].checked) {
						Mfn += document.ecta.susp[i].value + "|"
					}
				}
				break
		}
		if (Mfn == "") {
			alert("<?php echo $msgstr["selsusp"] ?>")
			return
		}
		document.multas.Mfn.value = Mfn
		document.multas.Accion.value = Accion
		document.multas.Tipo.value = "S"
		document.multas.submit()
	}

	function DeleteNote() {
		Mfn = ""
		switch (nNota) {
			case 1:
				if (document.ecta.note.checked) {
					Mfn = document.ecta.note.value
				}
				break
			default:
				for (i = 0; i < nNota; i++) {
					if (document.ecta.note[i].checked) {
						Mfn += document.ecta.note[i].value + "|"
					}
				}
				break
		}
		if (Mfn == "") {
			alert("<?php echo $msgstr["selnote"] ?>")
			return
		}
		document.multas.Mfn.value = Mfn
		document.multas.Accion.value = "D"
		document.multas.Tipo.value = "N"
		document.multas.submit()
	}

	function DeleteReserve(Mfn) {
		document.reservas.Accion.value = "delete"
		document.reservas.Mfn_reserve.value = Mfn
		document.reservas.submit()
	}

	function AlertReserve(Mfn) {
		alert("<?php echo $msgstr["cancel_and_assign"] ?>")
		return
	}

	function CancelReserve(Mfn, base, ncontrol) {
		if (confirm("<?php echo $msgstr["areysure"] ?>")) {
			document.reservas.base_reserve.value = base
			document.reservas.ncontrol.value = ncontrol
			document.reservas.Accion.value = "cancel"
			document.reservas.Mfn_reserve.value = Mfn
			// CORREÇÃO: Verifica se $script_php existe antes de usá-la
			document.reservas.retorno.value = "<?php if (isset($script_php)) echo $script_php ?>"
			document.reservas.submit()
		}
	}

	function AssignReserve(Mfn) {
		document.reservas.Accion.value = "assign"
		document.reservas.Mfn_reserve.value = Mfn
		document.reservas.base_reserve.value = ""
		document.reservas.ncontrol.value = ""
		document.reservas.submit()
	}

	function Eliminar(Expresion) {
		document.eliminar.Expresion.value = Expresion
		document.eliminar.submit()
	}

	function ImprimirSolvencia() {
		msgwin = window.open("", "solvencia", "width=1000,height=400,resizable,scrollbars")
		msgwin.focus()
		document.solvencia.submit()
	}

	function checkAll(o) {
		var boxes = document.getElementsByTagName("input");
		for (var x = 0; x < boxes.length; x++) {
			var obj = boxes[x];
			if (obj.type == "checkbox") {
				if (obj.name != "pay")
					obj.checked = o.checked;
			}
		}
	}
</script>

<form name="reservas" method="post" action="../reserve/delete_reserve.php">
	<input type="hidden" name="Mfn_reserve">
	<input type="hidden" name="Accion">
	<input type="hidden" name="base_reserve">
	<input type="hidden" name="ncontrol">
	<?php // CORREÇÃO: Verifica se $script_php existe antes de usá-la 
	?>
	<?php if (isset($script_php)) { ?>
		<input type="hidden" name="retorno" value="<?php echo $script_php; ?>">
	<?php } ?>
	<?php foreach ($arrHttp as $var => $value)
		if ($var != "Accion" and $var != "Mfn_reserve" and $var != "base_reserve" and $var != "retorno") echo "<input type=hidden name=$var value=\"" . $value . "\">\n"; ?>
</form>

<form name="eliminar" method="post" action="../reserve/delete_expression.php">
	<?php // CORREÇÃO: Verifica se $script_php existe antes de usá-la 
	?>
	<?php if (isset($script_php)) { ?>
		<input type="hidden" name="retorno" value="<?php echo $script_php; ?>">
	<?php } ?>
	<input type="hidden" name="Expresion">
	<?php foreach ($arrHttp as $var => $value) echo "<input type=hidden name=$var value=\"" . $value . "\">\n"; ?>
</form>