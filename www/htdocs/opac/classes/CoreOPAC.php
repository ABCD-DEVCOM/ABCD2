<?php

class CoreOPAC {
    private $parametros;
    private $db_path;

    public function __construct($opac_global_def, $db_path) {
        $pathcomplete = $db_path."opac_conf/".$opac_global_def;
        $this->parametros = $this->loadParameters($pathcomplete);
        $this->db_path = $db_path;
    }

    public function getDbPath() {
        return $this->db_path;
    }

    public function getLogo() {
        return $this->getParametro('logo');
    }

    public function inserirGoogleAnalytics() {
        $googleAnalyticsId = $this->getGoogleAnalyticsId();
        if (!empty($googleAnalyticsId)) {
            $gCode =  "
    <!-- Google tag (gtag.js) -->
    <script async src=\"https://www.googletagmanager.com/gtag/js?id=$googleAnalyticsId\"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '$googleAnalyticsId');
    </script>
            ";
            return $gCode;
        }
    }


    private function getGoogleAnalyticsId() {
        $gAnalyticsValue = $this->getParametro('GANALYTICS');
        return $gAnalyticsValue;
    }

    public function getLinkLogo() {
        return $this->getParametro('link_logo');
    }

    public function getCharset() {
        return $this->getParametro('charset');
    }

    public function getFooter() {
        $containerValue = $this->getParametro('footer');
        if ($containerValue != '') {
            return $containerValue;
        } else {
            return "&copy; 2023 - Consultation databases";
        }
    }

    public function getTituloPagina() {
        $containerValue = $this->getParametro('TituloPagina');
        if ($containerValue != '') {
            return $containerValue;
        } else {
            return "ABCD - OPAC";
        }
    }

    public function getTituloEncabezado() {
        $containerValue = $this->getParametro('TituloEncabezado');
        if ($containerValue != '') {
            return $containerValue;
        } else {
            return "ABCD - OPAC";
        }
    }

    public function getDescription() {
        $containerValue = $this->getParametro('SITE_DESCRIPTION');
        if ($containerValue != '') {
            return htmlspecialchars($containerValue);
        } else {
            return "Search the collection at the Documentation Centre.";
        }
    }

    public function getKeywords() {
        $containerValue = $this->getParametro('SITE_KEYWORDS');
        if ($containerValue != '') {
            return htmlspecialchars($containerValue);
        } else {
            return "Research, collection, books, magazines.";
        }
    }

    public function getOnlineStatment() {
        return $this->getParametro('ONLINESTATMENT');
    }

    public function getWebReservation() {
        return $this->getParametro('WEBRESERVATION');
    }

    public function getWebRenovation() {
        return $this->getParametro('WEBRENOVATION');
    }

    public function getShowHelp() {
        return $this->getParametro('SHOWHELP');
    }

    public function getOpacHttp() {
        return $this->getParametro('OpacHttp');
    }

    public function getShortIcon() {
        return $this->getParametro('shortIcon');
    }

    public function getParametro($chave, $padrao = '') {
        if (isset($this->parametros[$chave])) {
            return $this->parametros[$chave];
        } else {
            return $padrao;
        }
    }

    private function loadParameters($pathcomplete) {
        $linhas = file($pathcomplete);
        $parametros = array();

        foreach ($linhas as $linha) {
            $linha = trim($linha);

            if (strpos($linha, '=') !== false) {
                list($chave, $valor) = explode('=', $linha, 2);
                $parametros[$chave] = $valor;
            }
        }

        return $parametros;
    }
}

$opac_global_defConfig = 'opac.def';
$configuracoes = new CoreOPAC($opac_global_defConfig, $db_path);


$OpacHttp = $configuracoes->getOpacHttp();
$logo = $configuracoes->getLogo();
$Site_Description = $configuracoes->getDescription();
$Site_Keywords = $configuracoes->getKeywords();
$link_logo = $configuracoes->getLinkLogo();

$TituloPagina = $configuracoes->getTituloPagina();
$TituloEncabezado = $configuracoes->getTituloEncabezado();
$footer = $configuracoes->getFooter();
$meta_encoding = $configuracoes->getCharset();
$OnlineStatment = $configuracoes->getOnlineStatment();
$WebReservation = $configuracoes->getWebRenovation();
$WebRenovation = $configuracoes->getWebRenovation();
$showhide = $configuracoes->getShowHelp();


$googleAnalyticsCode = $configuracoes->inserirGoogleAnalytics(); 

