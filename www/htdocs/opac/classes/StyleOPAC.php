<?php

use opac\classes\DesignOPAC;

class StyleOPAC extends DesignOPAC {
    private $db_path;

    public function __construct($opac_global_style_def,$db_path) {
        parent::__construct($opac_global_style_def,$db_path);
    }

    public function inserStyle() {
        $getTopBarBG = $this->getTopBarBG();
        $getTopBarTXT = $this->getTopBarTXT();
        $getColorBtnSubmit = $this->getColorBtnSubmit();
        $getColorBtnLight = $this->getColorBtnLight();
        $getColorBtnPrimary = $this->getColorBtnPrimary();
        $getColorBtnSecondary = $this->getColorBtnSecondary();
        $getColorBG = $this->getColorBG();
        $getColorSearchBoxBG = $this->getColorSearchBoxBG();
        $getColorResultsBG = $this->getColorResultsBG();
        $getColorToTop = $this->getColorToTop();
        $getColorFooter = $this->getColorFooter();
        $getColorFooterTXT = $this->getColorFooterTXT();
        $getColorA = $this->getColorA();
        $getColorTXT = $this->getColorTXT();
        //if (!empty($googleAnalyticsId)) {
$gCode =  "
<style>
    $getTopBarBG
    $getTopBarTXT
    $getColorBtnSubmit
    $getColorBtnLight
    $getColorBtnPrimary
    $getColorBtnSecondary
    $getColorBG
    $getColorSearchBoxBG
    $getColorResultsBG
    $getColorToTop
    $getColorFooter
    $getColorFooterTXT
    $getColorA
    $getColorTXT
    </style>";
return $gCode;
        //}
    }

    public function getTopBarBG() {
        $get_style = $this->getDesign('COLOR_TOPBAR_BG');
        $opac_style = ".navbar-primary.bg-white { background: $get_style !important; }";
        $opac_style.= " select.bg-white { background: $get_style !important; border: none;}";
        return $opac_style;
    }

    public function getTopBarTXT() {
        $get_style = $this->getDesign('COLOR_TOPBAR_TXT');
        $opac_style = ".custom-top-link label,.custom-top-link a, .custom-top-link button, .custom-top-link select {color: $get_style !important; }";
        return $opac_style;
    }

    public function getColorBtnSubmit() {
        $get_style = $this->getDesign('COLOR_BUTTONS_SUBMIT_BG');
        $get_style2 = $this->getDesign('COLOR_BUTTONS_SUBMIT_TXT');
        $opac_style = ".btn-submit{background: $get_style !important; border-color: rgba(0,0,0, 0.25) !important; color: $get_style2 !important; }";
        return $opac_style;
    }

    public function getColorBtnLight() {
        $get_style = $this->getDesign('COLOR_BUTTONS_LIGHT_BG');
        $get_style2 = $this->getDesign('COLOR_BUTTONS_LIGHT_TXT');
        $opac_style = ".btn-light{ background: $get_style !important; border-color: rgba(0,0,0, 0.25) !important; color: $get_style2 !important; }";
        return $opac_style;
    }

    public function getColorBtnPrimary() {
        $get_style = $this->getDesign('COLOR_BUTTONS_PRIMARY_BG');
        $get_style2 = $this->getDesign('COLOR_BUTTONS_PRIMARY_TXT');
        $opac_style = ".active>.page-link, .page-link.active, .btn-primary { background: $get_style !important; border-color: rgba(0,0,0, 0.25) !important; color: $get_style2 !important; }";
        return $opac_style;
    }

    public function getColorBtnSecondary() {
        $get_style = $this->getDesign('COLOR_BUTTONS_SECONDARY_BG');
        $get_style2 = $this->getDesign('COLOR_BUTTONS_SECONDARY_TXT');
        $opac_style = ".btn-secondary, .bg-secondary { background: $get_style !important; border-color: rgba(0,0,0, 0.25) !important; color: $get_style2 !important; }";
        return $opac_style;
    }

    public function getColorBG() {
        $get_style = $this->getDesign('COLOR_BG');
        $opac_style = "body.bg-light-subtle { background: $get_style !important; }";
        return $opac_style;
    }

    public function getColorSearchBoxBG() {
        $get_style = $this->getDesign('COLOR_SEARCHBOX_BG');
        $opac_style = "#searchBox.card.bg-white, .card.text-bg-light { background-color: $get_style !important; }";
        return $opac_style;
    }

    public function getColorResultsBG() {
        $get_style = $this->getDesign('COLOR_RESULTS_BG');
        $opac_style = "#results > .bg-white { background-color: $get_style !important; }";
        return $opac_style;
    }

    public function getColorToTop() {
        $get_style = $this->getDesign('COLOR_TOTOP_BG');
        $get_style2 = $this->getDesign('COLOR_TOTOP_TXT');
        $opac_style = ".smoothscroll-top.show { background: $get_style !important; color: $get_style2; }";
        return $opac_style;
    }

    public function getColorFooter() {
        $get_style = $this->getDesign('COLOR_FOOTER_BG');
        $opac_style = ".custom-footer { background: $get_style !important; }";
        return $opac_style;
    }

    public function getColorFooterTXT() {
        $get_style = $this->getDesign('COLOR_FOOTER_TXT');
        $opac_style = "footer.custom-footer, .custom-footer a, footer.custom-footer p, .custom-footer h1, .custom-footer h2  { color: $get_style !important; }";
        return $opac_style;
    }

    public function getColorA() {
        $get_style = $this->getDesign('COLOR_LINKS');
        $opac_style = ".custom-sidebar .navbar-nav  { color: $get_style; }";
        //$opac_style = "#sidebar .navbar-nav  { color: $get_style; }";
        //$opac_style = "#sidebar>a, .nav-link, .nav-link>.text-dark { color: $get_style; }";
        return $opac_style;
    }

    public function getColorTXT() {
        $get_style = $this->getDesign('COLOR_TEXT');
        $opac_style = ".custom-sidebar h6 { color: $get_style !important;}";
        $opac_style.= ".custom-searchbox h6, .custom-searchbox label { color: $get_style !important;}";
        //$opac_style = "#sidebar h6.text-dark, #search, h2, h3, h4, h5, h6, p, label { color: $get_style !important;}";
        //$opac_style = "#sidebar h6.text-dark, h2, h3, h4, h5, h6, p, label, p.text-dark,  .text-dark, label.text-secondary{ color: $get_style !important;}";
        //$opac_style = "body { color: $get_style !important;}";
        return $opac_style;
    }

}

$colorsOPAC = new StyleOPAC($opac_global_style_def,$db_path);

$CustomStyle = $colorsOPAC->inserStyle(); 


