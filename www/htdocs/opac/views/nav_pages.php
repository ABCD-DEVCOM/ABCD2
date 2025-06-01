<?php
function NavegarPaginas($totalRegistros, $count, $desde, $select_formato)
{
	global $bd_list, $multiplesBases, $base, $msgstr, $npages;

	if (!isset($_REQUEST["pagina"]) || $_REQUEST["pagina"] == "") {
		$_REQUEST["pagina"] = 1;
	}

	$paginaAtual = (int)$_REQUEST["pagina"];
	$prox_p = $paginaAtual;
	$paramsHidden = "";

	foreach ($_REQUEST as $key => $value) {
		if ($key == "integrada") $value = urlencode($value);
		if (!in_array($key, ["desde", "existencias", "count", "Expresion", "pagina", "Campos", "Operadores", "Sub_Expresion"])) {
			$paramsHidden .= '<input type="hidden" name="' . $key . '" value="' . htmlspecialchars($value) . '">' . "\n";
		}
	}

	$paginas = (int)ceil($totalRegistros / $count);
	$paginaAnterior = max(1, $paginaAtual - 1);
	$paginaPosterior = min($paginas, $paginaAtual + 1);
	$pgAnterior = ($paginaAnterior - 1) * $npages + 1;
	$pgPosterior = ($paginaPosterior - 1) * $npages + 1;

	// Lista de páginas visíveis (máximo 5)
	$listaPaginas = [];
	$inicio = max(1, $paginaAtual - 2);
	$fim = min($paginas, $inicio + 4);
	for ($i = $inicio; $i <= $fim; $i++) {
		$listaPaginas[] = [
			'pagina' => $i,
			'pg' => ($i - 1) * $npages + 1,
			'active' => ($i == $paginaAtual)
		];
	}

	// Última página
	$pgUltima = max(1, $totalRegistros - $count + 1);

	// Dados prontos para template
	include 'templates/default/nav_page.php';
}
