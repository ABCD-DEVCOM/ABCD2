<?php

namespace opac\classes;

class DesignOPAC {
    private $design;
    private $db_path;

    public function __construct($opac_global_style_def, $db_path) {
        global $msgstr;
        $pathcomplete = $db_path."opac_conf/".$opac_global_style_def;
        if (!file_exists($pathcomplete)) {
            echo $msgstr['front_file_not_exist']."<b>$pathcomplete</b><br> <h2>".$msgstr['front_update']."</h2>";
            die;
        }
        $this->design = $this->loadDesign($pathcomplete);
        $this->db_path = $db_path;
    }

    public function getDbPath() {
        return $this->db_path;
    }

    public function getContainer() {
        $containerValue = $this->getDesign('CONTAINER');
        if ($containerValue === '-fluid') {
            return '-fluid';
        } else {
            return '';
        } 
    }

    public function getTopbar() {
        return $this->getDesign('TOPBAR');
    }

    public function getSidebar() {
        return $this->getDesign('SIDEBAR');
    }

    public function getNPages() {
        $containerValue = $this->getDesign('NUM_PAGES');
        if ($containerValue != '') {
            return $containerValue;
        } else {
            return 5;
        } 
    }


    public function getDesign($chave, $default = '') {
        if (isset($this->design[$chave])) {
            return $this->design[$chave];
        } else {
            return $default;
        }
    }

    private function loadDesign($pathcomplete) {
        $linhas = file($pathcomplete);
        $design = array();

        foreach ($linhas as $linha) {
            $linha = trim($linha);

            if (strpos($linha, '=') !== false) {
                list($chave, $valor) = explode('=', $linha, 2);
                $design[$chave] = $valor;
            }
        }

        return $design;
    }
}

$opac_global_style_def = 'global_style.def';
$opacdesign = new DesignOPAC($opac_global_style_def, $db_path);

$sidebar = $opacdesign->getSidebar();
$npages = $opacdesign->getNPages();
$container= $opacdesign->getContainer();
$topbar = $opacdesign->getTopbar();

?>
