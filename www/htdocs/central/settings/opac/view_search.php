<?php
include("conf_opac_top.php");
$wiki_help = "OPAC-ABCD DCXML";
include "../../common/inc_div-helper.php";
?>

<script>
    var idPage = "general";
</script>

<?php
$arquivo = $db_path . "/opac_conf/logs/log_opac.txt";
$linhas = file_exists($arquivo) ? file($arquivo) : [];

$registros = [];

foreach ($linhas as $linha) {
    $dados = explode("\t", trim($linha));
    if (count($dados) >= 3) {
        $registros[] = [
            'datahora' => $dados[0],
            'ip' => $dados[1],
            'termo' => htmlspecialchars($dados[2])
        ];
    }
}
?>

<div class="middle form row m-0">
    <div class="formContent col-2 m-2">
        <?php include("conf_opac_menu.php"); ?>
    </div>
    <div class="formContent col-9 m-2">
        <div class="container">
            <h3>Análise de Pesquisas</h3>

            <div class="mb-3">
                <label for="filtroData">Filtrar por período:</label>
                <select id="filtroData" class="form-select" style="max-width: 200px; display: inline-block;">
                    <option value="todos">Todos</option>
                    <option value="hoje">Hoje</option>
                    <option value="7dias">Últimos 7 dias</option>
                    <option value="30dias">Últimos 30 dias</option>
                </select>

                <label for="filtroTermo" class="ms-4">Buscar termo:</label>
                <input type="text" id="filtroTermo" class="form-control" style="max-width: 300px; display: inline-block;">
            </div>

            <table class="table striped" id="tabelaLog">
                <thead>
                    <tr>
                        <th id="thData" style="cursor: pointer;">Data/Hora <span id="iconData"></span></th>
                        <th>IP</th>
                        <th id="thTermo" style="cursor: pointer;">Termo Pesquisado <span id="iconTermo"></span></th>
                    </tr>
                </thead>
                <tbody id="corpoTabela">
                    <?php foreach ($registros as $registro): ?>
                        <tr>
                            <td><?= $registro['datahora'] ?></td>
                            <td><?= $registro['ip'] ?></td>
                            <td><?= $registro['termo'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../../common/footer.php"); ?>

<script>
    const tabela = document.getElementById('tabelaLog');
    const corpoTabela = document.getElementById('corpoTabela');
    const filtroData = document.getElementById('filtroData');
    const filtroTermo = document.getElementById('filtroTermo');

    let linhasOriginais = Array.from(corpoTabela.querySelectorAll('tr'));
    let ordemDataAsc = true;
    let ordemTermoAsc = true;

    function parseDataHora(texto) {
        if (!texto) return null;
        var partes = texto.split(' ');
        if (partes.length === 0) return null;
        var dataPartes = partes[0].split('-'); // yyyy-mm-dd
        if (dataPartes.length < 3) return null;
        return new Date(
            parseInt(dataPartes[0], 10),
            parseInt(dataPartes[1], 10) - 1,
            parseInt(dataPartes[2], 10)
        );
    }

    function aplicarFiltros() {
        const periodo = filtroData.value;
        const termoBusca = filtroTermo.value.trim().toLowerCase();

        let hoje = new Date();
        let dataInicioFiltro = null;
        let dataFimFiltro = null;

        if (periodo === "hoje") {
            dataInicioFiltro = new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate(), 0, 0, 0);
            dataFimFiltro = new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate(), 23, 59, 59);
        } else if (periodo === "7dias") {
            dataInicioFiltro = new Date();
            dataInicioFiltro.setDate(hoje.getDate() - 7);
        } else if (periodo === "30dias") {
            dataInicioFiltro = new Date();
            dataInicioFiltro.setDate(hoje.getDate() - 30);
        }

        corpoTabela.innerHTML = '';

        linhasOriginais.forEach(linha => {
            const td = linha.querySelectorAll('td');
            const dataTexto = td[0].textContent.trim();
            const termoTexto = td[2].textContent.trim().toLowerCase();

            let mostrar = true;

            const dataRegistro = parseDataHora(dataTexto);

            if (periodo !== "todos" && dataRegistro) {
                if (periodo === "hoje") {
                    mostrar = dataRegistro >= dataInicioFiltro && dataRegistro <= dataFimFiltro;
                } else {
                    mostrar = dataRegistro >= dataInicioFiltro;
                }
            }

            if (mostrar && termoBusca) {
                mostrar = termoTexto.includes(termoBusca);
            }

            if (mostrar) {
                corpoTabela.appendChild(linha);
            }
        });
    }

    filtroData.addEventListener('change', aplicarFiltros);
    filtroTermo.addEventListener('input', aplicarFiltros);

    function ordenarTabela(coluna, ascendente) {
        const linhas = Array.from(corpoTabela.querySelectorAll('tr'));
        linhas.sort((a, b) => {
            const valA = a.children[coluna].textContent.trim().toLowerCase();
            const valB = b.children[coluna].textContent.trim().toLowerCase();

            if (coluna === 0) { // Data
                return ascendente ? new Date(valA) - new Date(valB) : new Date(valB) - new Date(valA);
            } else { // Termo
                return ascendente ? valA.localeCompare(valB) : valB.localeCompare(valA);
            }
        });

        linhas.forEach(linha => corpoTabela.appendChild(linha));
    }

    document.getElementById('thData').addEventListener('click', () => {
        ordenarTabela(0, ordemDataAsc);
        ordemDataAsc = !ordemDataAsc;
        atualizarIcones();
    });

    document.getElementById('thTermo').addEventListener('click', () => {
        ordenarTabela(2, ordemTermoAsc);
        ordemTermoAsc = !ordemTermoAsc;
        atualizarIcones();
    });

    function atualizarIcones() {
        document.getElementById('iconData').textContent = ordemDataAsc ? '↑' : '↓';
        document.getElementById('iconTermo').textContent = ordemTermoAsc ? '↑' : '↓';
    }

    // Inicializa ícones
    atualizarIcones();
</script>