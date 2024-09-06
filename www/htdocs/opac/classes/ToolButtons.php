<?php

class ToolButtons {
    private $text;
    private $icon;
    private $style;
    private $onclick;

    public function __construct($text, $icon, $style,$onclick) {
        $this->text = $text;
        $this->icon = $icon;
        $this->style = $style;
        $this->onclick = $onclick;
    }

    public function render() {
        $button = '<button class="btn m-1 btn-' . $this->style . '" onclick="'.$this->onclick.'">';
        $button .= '<i class="fa fa-' . $this->icon . '"></i> <span class="d-none d-sm-block"> ' . $this->text;
        $button .= '</span></button>';
        return $button;
    }

    public function rendercard() {
        $button = '<a class="btn btn-outline-' . $this->style . '" href='.$this->onclick.'>';
        $button .= '<i class="fa fa-' . $this->icon . '"></i> <span class="d-none d-sm-inline" alt="'.$this->text.'"> ';
        $button .= '</a>';
        return $button;
    }
}

    $printButton = new ToolButtons('Imprimir', 'print', 'secondary','SendToPrint()');
    $downloadButton = new ToolButtons('Baixar ISO', 'download', 'success','javascript:SendTo("iso","c_=\',mstname,\'_=\'f(mfn,1,0)\'")');
    $WordButton = new ToolButtons('MS Word', 'file-word', 'primary','SendToWord()');
    $emailButton = new ToolButtons('Enviar por email', 'envelope', 'info','ShowHide(\'myMail\')');
    $reserveButton = new ToolButtons('Reserve', 'book', 'success','ShowHide(\'myReserve\')');
    $backButton = new ToolButtons('Voltar', 'arrow-alt-circle-left', 'light','document.regresar.submit()');

    $printCardButton = new ToolButtons('Imprimir','print','secondary','javascript:SendTo("print_one","c_=\',mstname,\'_=\'f(mfn,1,0)\'")');
    $downloadCardButton = new ToolButtons('Baixar ISO', 'download', 'success','javascript:SendToISO()');
    $WordCardButton = new ToolButtons('MS Word', 'file-word', 'primary','javascript:SendTo("word","c_=\',mstname,\'_=\'f(mfn,1,0)\'")');
    $emailCardButton = new ToolButtons('Enviar por email', 'envelope', 'info','javascript:SendTo("mail_one","c_=\',mstname,\'_=\'f(mfn,1,0)\'")');
    $reserveCardButton = new ToolButtons('Reserve', 'book', 'success','javascript:SendTo("reserve_one","c_=\',mstname,\'_=\'f(mfn,1,0)\'")');
    $xmlCardButton = new ToolButtons('Voltar', 'code', 'primary','javascript:SendToXML("c_=\',mstname,\'_=\'f(mfn,1,0)\'")');

?>
