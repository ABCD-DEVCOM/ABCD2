<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    define('APPLICATION_PATH', dirname(__FILE__));
    require_once(APPLICATION_PATH . '/lib/parse_config.php');

    // --- Lógica de Tradução ---
    $available_languages = $CONFIG['LANGUAGES']['available'] ?? ['en' => 'English'];
    $lang = $CONFIG['LANGUAGES']['default'] ?? 'en';

    if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $available_languages)) {
        $lang = $_GET['lang'];
    }

    if (!is_dir(APPLICATION_PATH . '/lang')) {
        mkdir(APPLICATION_PATH . '/lang');
    }
    $lang_file_path = APPLICATION_PATH . '/lang/' . $lang . '.json';
    $t = [];
    if (file_exists($lang_file_path)) {
        $lang_file = file_get_contents($lang_file_path);
        $t = json_decode($lang_file, true);
    } else {
        $fallback_lang = array_key_first($available_languages);
        $lang_file_path = APPLICATION_PATH . '/lang/' . $fallback_lang . '.json';
        if (file_exists($lang_file_path)) {
            $lang_file = file_get_contents($lang_file_path);
            $t = json_decode($lang_file, true);
        }
    }

    // --- Variáveis para o JavaScript ---
    $idDomain = $CONFIG['INFORMATION']['IDDOMAIN'] ?? 'defaultDomain';
    $idPrefix = $CONFIG['INFORMATION']['IDPREFIX'] ?? 'defaultPrefix';
    ?>

    <title><?php echo $t['title'] ?? 'ABCD | OAI-PMH API Explorer'; ?></title>

    <script>
        const oaiConfig = {
            idDomain: '<?php echo $idDomain; ?>',
            idPrefix: '<?php echo $idPrefix; ?>'
        };
        const translations = <?php echo json_encode($t); ?>;
        const currentLang = '<?php echo $lang; ?>';
    </script>

    <link rel="stylesheet" href="assets/css/explorer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css">
</head>

<body>
    <header class="main-header">
        <h1><?php echo $t['header'] ?? 'OAI-PMH API Explorer'; ?></h1>

        <div class="header-controls">
            <div class="lang-selector">
                <select id="lang-select">
                    <?php foreach ($available_languages as $code => $name): ?>
                        <option value="<?php echo $code; ?>" <?php if ($code == $lang) echo ' selected'; ?>>
                            <?php echo $name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="repo-url">
                <strong><?php echo $t['baseUrl'] ?? 'URL Base:'; ?></strong>
                <span><?php
                        // CORREÇÃO: Lógica robusta para encontrar a URL do oai.php
                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                        $host = $_SERVER['HTTP_HOST'];
                        $directory = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
                        $baseUrl = $protocol . $host . $directory . '/oai.php';
                        echo htmlspecialchars($baseUrl);
                        ?></span>
            </div>
        </div>
    </header>

    <div class="explorer-container">
        <aside class="sidebar">
            <h2 id="endpoints-title"><?php echo $t['endpoints'] ?? 'Endpoints (Verbs)'; ?></h2>
            <nav>
                <ul>
                    <li><a href="#" data-verb="Identify">Identify</a></li>
                    <li><a href="#" data-verb="ListMetadataFormats">ListMetadataFormats</a></li>
                    <li><a href="#" data-verb="ListSets">ListSets</a></li>
                    <li><a href="#" data-verb="ListIdentifiers">ListIdentifiers</a></li>
                    <li><a href="#" data-verb="ListRecords">ListRecords</a></li>
                    <li><a href="#" data-verb="GetRecord">GetRecord</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <section id="params-section">
                <h3 id="params-title"><?php echo $t['parameters'] ?? 'Parâmetros'; ?></h3>
                <div id="params-form-container">
                    <p class="placeholder" id="select-endpoint-text"><?php echo $t['selectEndpoint'] ?? 'Selecione um endpoint...'; ?></p>
                </div>
                <button id="execute-btn" style="display: none;"><?php echo $t['execute'] ?? 'Executar'; ?></button>
            </section>

            <section id="request-section">
                <div class="section-header">
                    <h3 id="request-url-title"><?php echo $t['requestUrl'] ?? 'URL da Requisição'; ?></h3>
                    <button id="copy-url-btn" title="Copiar URL"><?php echo $t['copyUrl'] ?? 'Copiar'; ?></button>
                </div>
                <pre><code id="request-url-display" class="language-http"></code></pre>
            </section>

            <section id="response-section">
                <h3 id="response-title"><?php echo $t['serverResponse'] ?? 'Resposta do Servidor (XML)'; ?></h3>
                <pre><code id="response-display" class="language-xml"></code></pre>
            </section>
        </main>
    </div>

    <footer class="main-footer">
        <img src="/opac/assets/img/logoabcd.png" alt="Logo ABCD">
        <p>OAI-PMH exploration interface for ABCD software.</p>
        <p>&copy; <?php echo date("Y"); ?>. All rights reserved.</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-xml-doc.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-http.min.js"></script>
    <script src="assets/js/explorer.js"></script>
</body>

</html>