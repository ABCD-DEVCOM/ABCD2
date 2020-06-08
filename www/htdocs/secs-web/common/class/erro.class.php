<?php
/**
 * @desc Class with objective to friendly error reporting
 * @package [SECS-Web] SECS Online
 * @name Erro
 * @version 1.1
 * @author  Domingos Teruel <webmaster@dteruel.com.br>
 * @since create 22 de junho de 2004
 * @since update 17 de março de 2006
 * @copyright  BIREME - SCI - 2004
 * @abstract 
 * @final
 */

// desativando todos os erros, para que o usuario nao os veja.
error_reporting(0);

//mudando a funcao que ira gerenciar os erros a partir de agora.
$old_error_handler = set_error_handler("erros");

/**
* @return void
* @param int    $errno     numero do erro
* @param string $errmsg    mensagem de erro
* @param string $filename  nome do arquivo
* @param int    $linenum   numero da linha
* @param array  $vars      diversas variaveis do sistema
* @desc funcao que servira de callBack
*/
function erros($errno, $errmsg, $filename, $linenum, $vars) {
    $erro = new Erro($errno, $errmsg, $filename, $linenum, $vars);
}

class Erro
{    
    var $nErro;
    var $msgErro;
    var $nomeArquivo;
    var $numLinha;
    var $vars;
    
    function Erro($nErro,$msgErro,$nomeArquivo,$numLinha, $vars){
        $this->nErro       = $nErro;
        $this->msgErro     = $msgErro;
        $this->nomeArquivo = $nomeArquivo;
        $this->numLinha       = $numLinha;
        $this->vars          = $vars;
        $this->logErro();
        $this->fluxoNavegacao();
    }
    
    /**
     * @return int
     * @desc Retorna o n�mero do erro
     */
    function getNErro(){
        return $this->nErro;
    }
    
    /**
     * @return String
     * @desc Retorna a mensagem do erro
     */
    function getMsgErro(){
        return $this->msgErro;
    }
    
    /**
     * @return String
     * @desc Retorna o nome do arquivo
     */
    function getNomeArquivo(){
        return $this->nomeArquivo;
    }
    
    /**
     * @return int
     * @desc Retorna o numero da linha do erro
     */
    function getNumLinha(){
        return $this->numLinha;
    }
    
    /**
     * @return Array
     * @desc Retorna diversas variaveis do ambiente e programa
     */
    function getVars(){
        return $this->vars;
    }
    
    /**
     * @return String
     * @desc Retorna o nome do tipo do erro
     */
    function getDescricaoErro($nErro){
        // Define uma matriz associativa com as strings dos erros
        $desErro = array(
                         1    => "Error",
                         2    => "Warning",
                         4    => "Parsing Error",
                         8    => "Notice",
                         16   => "Core Error",
                         32   => "Core Warning",
                         64   => "Compile Error",
                         128  => "Compile Warning",
                         256  => "User Error",
                         512  => "User Warning",
                         1024 => "User Notice"
                        );
        return $desErro[$nErro];
    }
    
    /**
     * @return void
     * @desc Cria a mensagem de Log, chama o metodo de gravacao e envio de email.
     */
    function logErro(){
        $dt = date("d-m-Y H:i:s");
        $mensagem = str_replace("\n","",$this->getMsgErro());
        $msgLog = "Erro aconteceu no dia $dt.<q>".
                  "O numero do erro e ".$this->getNErro().".<q>".
                  "O Tipo do Erro e  ".$this->getDescricaoErro($this->getNErro()).".<q>".
                  "O arquivo que acontece o erro e ".$this->getNomeArquivo().".<q>".
                  "A linha que acontece o erro e ".$this->getNumLinha().".<q><q>".
                  "A mensagem do erro e $mensagem.<q><l><q>";

        // nome do arquivo
        $dirBase = dirname(__FILE__)."/logErros/";
        if (!file_exists($dirBase)) {
            clearstatcache();
            mkdir($dirBase);
        }
        $dt1  = date("dmY");
        $nome = $dirBase.$dt1.".txt";
        clearstatcache();
                   
        // gravando no arquivo de log
        $this->grava($nome,$msgLog);
           
        // enviar somente um e-mail de aviso por dia que acontecer algum erro
        if (!(file_exists($nome))) {
            $this->enviaEmail($msgLog);
        }
    }    

    /**
     * @return void
     * @param string $nome         Nome do arquivo
     * @param string $msgLog        Mensagem de Log
     * @desc Grava no arquivo o erro gerado
     */
    function grava($nome,$msgLog){
        $msgLog = str_replace("<q>","\n",$msgLog);
        $msgLog = str_replace("<l>","-----------------------------------",$msgLog);
        $id = fopen($nome, "a");
        fwrite($id,$msgLog);
    }

    /**
     * @return void
     * @param string $msgLog        Mensagem de Log
     * @desc Envia o E-mail.
     */
    function enviaEmail($msgLog){
        $msgLog = str_replace("<q>","<br>",$msgLog);
        $msgLog = str_replace("<l>","",$msgLog);
        mail("erros@servidor.com.br","Erro no Sistema",$msgLog,"from:....");
    }
       
    /**
     * @return void
     * @desc Redireciona o usu�rio se necess�rio e poss�vel
     */
    function fluxoNavegacao(){
        if ($this->getNErro() == 256) {
            header("location:erro.php".urlencode("Desculpe, o sistema gerou um erro inesperado e sua opera&ccecil;&atilde;o n&atilde;o foi executada.<br>Este erro foi enviado ao(s) administrador(es) do sistema,em breve ser&aacute; corrigido, se necess&aacute;rio entre em contato com o setor respons&aacute;vel."));
        }
    }
}
?> 