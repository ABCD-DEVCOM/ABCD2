<!-- Bibliotecas necessárias -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabelaLog').DataTable();
    });
</script>


<?php
include("conf_opac_top.php");
$wiki_help = "OPAC-ABCD DCXML";
include "../../common/inc_div-helper.php";

// Função para obter localização via ip-api.com
function geoLocalizacao($ip)
{
    $url = "http://ip-api.com/json/{$ip}?fields=status,message,lat,lon,city,regionName,country";
    $resposta = @file_get_contents($url);
    if ($resposta === FALSE) {
        return false;
    }
    $dados = json_decode($resposta, true);
    if ($dados && $dados['status'] === 'success') {
        return [
            'local' => $dados['city'] . ", " . $dados['regionName'] . ", " . $dados['country'],
            'lat' => $dados['lat'],
            'lon' => $dados['lon']
        ];
    }
    return false;
}

// Lendo o log
$arquivo = $db_path . "/opac_conf/logs/log_opac.txt";
$linhas = file_exists($arquivo) ? file($arquivo) : [];

$registros = [];
$contagem_termos = [];
$contagem_cidades = [];
$ips_unicos = [];

foreach ($linhas as $linha) {
    $dados = explode("\t", trim($linha));
    if (count($dados) >= 3) {
        $datahora = $dados[0];
        $ip = $dados[1];
        $termo = strtolower(trim($dados[2]));

        if (!isset($ips_unicos[$ip])) {
            $geo = geoLocalizacao($ip);
            $ips_unicos[$ip] = $geo ?: ['local' => 'Desconhecido', 'lat' => null, 'lon' => null];
        }

        $local = $ips_unicos[$ip]['local'];

        if ($local !== 'Desconhecido') {
            if (!isset($contagem_cidades[$local])) {
                $contagem_cidades[$local] = 1;
            } else {
                $contagem_cidades[$local]++;
            }
        }

        $registros[] = [
            'datahora' => $datahora,
            'ip' => $ip,
            'local' => $local,
            'termo' => htmlspecialchars($termo)
        ];

        if ($termo != '') {
            if (!isset($contagem_termos[$termo])) {
                $contagem_termos[$termo] = 1;
            } else {
                $contagem_termos[$termo]++;
            }
        }
    }
}

// Ordenar registros do mais recente para o mais antigo
usort($registros, function ($a, $b) {
    return strtotime($b['datahora']) - strtotime($a['datahora']);
});

// Top 5 termos e cidades
arsort($contagem_termos);
$top_termos = array_slice($contagem_termos, 0, 5, true);

arsort($contagem_cidades);
$top_cidades = array_slice($contagem_cidades, 0, 5, true);
?>
<div class="middle form row m-0">
    <div class="formContent col-2 m-2">
        <?php include("conf_opac_menu.php"); ?>
    </div>
    <div class="formContent col-9 m-2">
        <div class="container">
            <h3><?php echo $msgstr['cfg_Research_Analysis']; ?></h3>

            <div class="mb-3">
                <label for="filtroData"><?php echo $msgstr['cfg_filter']; ?></label>
                <select id="filtroData" class="form-select" style="max-width: 200px; display: inline-block;">
                    <option value="todos"><?php echo $msgstr['cfg_all']; ?></option>
                    <option value="hoje"><?php echo $msgstr['cfg_today']; ?></option>
                    <option value="7dias"><?php echo $msgstr['cfg_last_7days']; ?></option>
                    <option value="30dias"><?php echo $msgstr['cfg_last_30days']; ?></option>
                </select>

                <label for="filtroTermo" class="ms-4"><?php echo $msgstr['cfg_search_term']; ?></label>
                <input type="text" id="filtroTermo" class="form-control" style="max-width: 300px; display: inline-block;">
            </div>

            <h5><?php echo $msgstr['cfg_search_list'] ?></h5>
            <table class="table striped w-10" id="tabelaLog">
                <thead>
                    <tr>
                        <th class="w-1"><?php echo $msgstr['cfg_date_hour']; ?></th>
                        <th class="w-2"><?php echo $msgstr['cfg_ip']; ?></th>
                        <th class="w-3"><?php echo $msgstr['cfg_location']; ?></th>
                        <th class="w-3"><?php echo $msgstr['cfg_search_term']; ?></th>
                    </tr>
                </thead>
                <tbody id="corpoTabela">
                    <?php foreach ($registros as $registro): ?>
                        <tr>
                            <td><?php echo $registro['datahora']; ?></td>
                            <td><?php echo $registro['ip']; ?></td>
                            <td><?php echo htmlspecialchars($ips_unicos[$registro['ip']]['local'] ?? 'Desconhecido'); ?></td>
                            <td><?php echo $registro['termo']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <script>
                const dadosCSV = <?php echo json_encode($registros, JSON_UNESCAPED_UNICODE); ?>;
            </script>


            <div id="paginacaoTabelaLog" class="mt-2">
                <button id="anteriorTabelaLog" class="bt bt-green"><i class="fas fa-chevron-left"></i> <?php echo $msgstr['previous']; ?></button>
                <span id="paginaAtualTabelaLog"></span>
                <button id="proximoTabelaLog" class="bt bt-green"><?php echo $msgstr['next']; ?> <i class="fas fa-chevron-right"></i></button>
            </div>

            <div class="mt-3">
                <button id="btnExportarCSV" class="bt bt-blue"><i class="far fa-file-excel"></i> <?php echo $msgstr['export_csv']; ?></button>
            </div>


            <div class="row mt-5">
                <div class="col-md-6">
                    <h5><?php echo $msgstr['cfg_top5']; ?></h5>
                    <table class="table striped w-10">
                        <thead>
                            <tr>
                                <th><?php echo $msgstr['cfg_search_term']; ?></th>
                                <th><?php echo $msgstr['cfg_quantity']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($top_termos as $termo => $qtd): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($termo); ?></td>
                                    <td><?php echo $qtd; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-6">
                    <h5><?php echo $msgstr['cfg_top_cities']; ?></h5>
                    <table class="table striped">
                        <thead>
                            <tr>
                                <th><?php echo $msgstr['cfg_city']; ?></th>
                                <th><?php echo $msgstr['cfg_quantity']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($top_cidades as $cidade => $qtd): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($cidade); ?></td>
                                    <td><?php echo $qtd; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <h5 class="mt-5"><?php echo $msgstr['cfg_map']; ?></h5>
            <div id="mapa" style="height: 500px;"></div>

        </div>
    </div>
</div>

<?php include("../../common/footer.php"); ?>

<!-- Leaflet CSS e JS -->
<link rel="stylesheet" href="/assets/css/leaflet.css" />
<script src="/assets/js/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapa = L.map('mapa').setView([-15, -47], 3); // Brasil centrado
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(mapa);

        const marcadores = [
            <?php foreach ($ips_unicos as $ip => $dados): ?>
                <?php if ($dados['lat'] !== null && $dados['lon'] !== null): ?> {
                        lat: <?php echo $dados['lat']; ?>,
                        lon: <?php echo $dados['lon']; ?>,
                        local: "<?php echo htmlspecialchars($dados['local'], ENT_QUOTES); ?>",
                        ip: "<?php echo $ip; ?>"
                    },
                <?php endif; ?>
            <?php endforeach; ?>
        ];

        marcadores.forEach(m => {
            L.marker([m.lat, m.lon])
                .addTo(mapa)
                .bindPopup(`<b>${m.local}</b><br>IP: ${m.ip}`);
        });
    });

    // Filtros de data/termo
    const filtroData = document.getElementById('filtroData');
    const filtroTermo = document.getElementById('filtroTermo');
    const corpoTabela = document.getElementById('corpoTabela');
    const linhasOriginais = Array.from(corpoTabela.querySelectorAll('tr'));

    function parseDataHora(texto) {
        var partes = texto.split(' ');
        if (partes.length < 2) return null;
        var dataPartes = partes[0].split('-');
        return new Date(dataPartes[0], dataPartes[1] - 1, dataPartes[2]);
    }

    function aplicarFiltros() {
        const periodo = filtroData.value;
        const termoBusca = filtroTermo.value.trim().toLowerCase();

        let hoje = new Date();
        let dataInicioFiltro = null;

        if (periodo === "hoje") {
            dataInicioFiltro = new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate());
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
            const termoTexto = td[3].textContent.trim().toLowerCase();

            let mostrar = true;
            const dataRegistro = parseDataHora(dataTexto);

            if (periodo !== "todos" && dataRegistro) {
                mostrar = dataRegistro >= dataInicioFiltro;
            }

            if (mostrar && termoBusca.length > 0) {
                mostrar = termoTexto.includes(termoBusca);
            }

            if (mostrar) {
                corpoTabela.appendChild(linha);
            }
        });
    }

    filtroData.addEventListener('change', aplicarFiltros);
    filtroTermo.addEventListener('input', aplicarFiltros);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filtroData = document.getElementById('filtroData');
        const filtroTermo = document.getElementById('filtroTermo');
        const corpoTabela = document.getElementById('corpoTabela');
        const todasLinhas = Array.from(corpoTabela.querySelectorAll('tr'));

        const linhasPorPagina = 20;
        let paginaAtual = 1;
        let linhasFiltradas = [...todasLinhas]; // Começa com tudo

        function parseDataHora(texto) {
            const partes = texto.split(' ');
            if (partes.length < 2) return null;
            const dataPartes = partes[0].split('-');
            return new Date(dataPartes[0], dataPartes[1] - 1, dataPartes[2]);
        }

        function aplicarFiltros() {
            const periodo = filtroData.value;
            const termoBusca = filtroTermo.value.trim().toLowerCase();
            const hoje = new Date();
            let dataInicioFiltro = null;

            if (periodo === "hoje") {
                dataInicioFiltro = new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate());
            } else if (periodo === "7dias") {
                dataInicioFiltro = new Date();
                dataInicioFiltro.setDate(hoje.getDate() - 7);
            } else if (periodo === "30dias") {
                dataInicioFiltro = new Date();
                dataInicioFiltro.setDate(hoje.getDate() - 30);
            }

            linhasFiltradas = todasLinhas.filter(linha => {
                const td = linha.querySelectorAll('td');
                const dataTexto = td[0].textContent.trim();
                const termoTexto = td[3].textContent.trim().toLowerCase();

                let mostrar = true;
                const dataRegistro = parseDataHora(dataTexto);

                if (periodo !== "todos" && dataRegistro) {
                    mostrar = dataRegistro >= dataInicioFiltro;
                }

                if (mostrar && termoBusca.length > 0) {
                    mostrar = termoTexto.includes(termoBusca);
                }

                return mostrar;
            });

            paginaAtual = 1; // Sempre voltar para a página 1 após filtro
            exibirPagina();
        }

        function exibirPagina() {
            corpoTabela.innerHTML = '';

            const inicio = (paginaAtual - 1) * linhasPorPagina;
            const fim = inicio + linhasPorPagina;
            const linhasPagina = linhasFiltradas.slice(inicio, fim);

            linhasPagina.forEach(linha => {
                corpoTabela.appendChild(linha);
            });

            const totalPaginas = Math.max(1, Math.ceil(linhasFiltradas.length / linhasPorPagina));
            document.getElementById('paginaAtualTabelaLog').textContent = `Página ${paginaAtual} de ${totalPaginas}`;

            // Desabilitar botões se necessário
            document.getElementById('anteriorTabelaLog').disabled = paginaAtual <= 1;
            document.getElementById('proximoTabelaLog').disabled = paginaAtual >= totalPaginas;
        }

        document.getElementById('anteriorTabelaLog').addEventListener('click', () => {
            if (paginaAtual > 1) {
                paginaAtual--;
                exibirPagina();
            }
        });

        document.getElementById('proximoTabelaLog').addEventListener('click', () => {
            const totalPaginas = Math.ceil(linhasFiltradas.length / linhasPorPagina);
            if (paginaAtual < totalPaginas) {
                paginaAtual++;
                exibirPagina();
            }
        });

        filtroData.addEventListener('change', aplicarFiltros);
        filtroTermo.addEventListener('input', aplicarFiltros);

        aplicarFiltros(); // Primeira carga
    });
</script>

<!-- Botão Exportar CSV -->
<script>
    document.getElementById('btnExportarCSV').addEventListener('click', function() {
        let csv = 'Data/Hora;IP;Localização;Termo Pesquisado\n';

        dadosCSV.forEach(linha => {
            const linhaCSV = [
                linha.datahora,
                linha.ip,
                linha.local,
                linha.termo.replace(/;/g, ',') // evita quebra do CSV
            ].join(';');
            csv += linhaCSV + '\n';
        });


        // Gerar nome de arquivo com data/hora atual
        const agora = new Date();
        const pad = n => n.toString().padStart(2, '0');
        const data = `${agora.getFullYear()}${pad(agora.getMonth()+1)}${pad(agora.getDate())}`;
        const hora = `${pad(agora.getHours())}${pad(agora.getMinutes())}`;
        const nomeArquivo = `opac_analytics_${data}-${hora}.csv`;

        const blob = new Blob([csv], {
            type: 'text/csv;charset=utf-8;'
        });
        const link = document.createElement('a');
        link.setAttribute('href', URL.createObjectURL(blob));
        link.setAttribute('download', nomeArquivo);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
</script>