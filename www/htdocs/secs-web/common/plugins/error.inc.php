<?php
/**
 * @example
 *  // desativando todos os erros, para que o usu�rio n�o os veja.
 *  error_reporting(0);
 *  //mudando a fun��o que ir� gerenciar os erros a partir de agora.
 *  $old_error_handler = set_error_handler("erros");
 *
 * @return void
 * @param int        $errno       numero do erro
 * @param string     $errmsg      mensagem de erro
 * @param string     $filename    nome do arquivo
 * @param int        $linenum     numero da linha
 * @param array      $vars        diversas vari�veis do sistema
 * @desc fun�ao que servir� de callBack
 *
 *   function erros($errno, $errmsg, $filename, $linenum, $vars) {
 *       $erro = new Erro($errno, $errmsg, $filename, $linenum, $vars);
 *   }
 * @desc Classe responsavel pelo tratamento de erros no Sistema
 *       Constantes usadas nesta classe: _WEBMASTER -> E-mail do resp pelo sistema
 *       NAME_SYSTEM -> Nome da Aplicacao
 * @package [SATISF] Sistema de Pesquisa de Satisfacao
 * @version 0.1
 * @author  Domingos Teruel <domingosteruel@terra.com.br>
 * @since 01 de setembro de 2004
 * @copyright  BIREME - SCI - 2004
 * @public
 * @final
 */
class Erro
{
    /**
     * @desc Recebe o Numero do erro
     * @var int 
     */
    var $nErro;
    /**
     * @desc Recebe a Mensagem de Erro
     * @var string
     */
    var $msgErro;
    /**
     * @desc Recebe o nome do Arquivo onde ocorreu o erro
     * @var string
     */
    var $nomeArquivo;
    /**
     * @desc Recebe o Numero da Linha onde ocorreu o erro
     * @var int
     */
    var $numLinha;
    /**
     * @desc diversas vari�veis do sistema
     * @var array
     */
    var $vars;
    /**
    * @return void
    * @desc constructor
    */      
    function Erro($nErro,$msgErro,$nomeArquivo,$numLinha, $vars){
        $this->nErro       = $nErro;
        $this->msgErro     = $msgErro;
        $this->nomeArquivo = $nomeArquivo;
        $this->numLinha    = $numLinha;
        $this->vars        = $vars;
        //$this->logErro();        
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
    * @desc Retorna o n�mero da linha do erro
    */
    function getNumLinha(){
        return $this->numLinha;
    }

    /**
    * @return Array
    * @desc Retorna diversas vari�veis do ambiente e programa
    */
    function getVars(){
        return $this->vars;
    }
    /**
    * @return String
    * @desc Define an assoc array of error string
    *       in reality the only entries we should
    *       consider are E_WARNING, E_NOTICE, E_USER_ERROR,
    *       E_USER_WARNING and E_USER_NOTICE
    */
    function getDescricaoErro($nErro)
    {        
        $errortype = array (
                E_ERROR           => "Error",
                E_WARNING         => "Warning",
                E_PARSE           => "Parsing Error",
                E_NOTICE          => "Notice",
                E_CORE_ERROR      => "Core Error",
                E_CORE_WARNING    => "Core Warning",
                E_COMPILE_ERROR   => "Compile Error",
                E_COMPILE_WARNING => "Compile Warning",
                E_USER_ERROR      => "User Error",
                E_USER_WARNING    => "User Warning",
                E_USER_NOTICE     => "User Notice",
                E_STRICT          => "Runtime Notice"
                );
        return $errortype[$nErro];
    }  
    /**    
    * @return void
    * @desc Cria a mensagem de Log, chama o m�todo de grava��o e envio de email.
    */
    function logErro()
    {
        // timestamp for the error entry
        $dt = date("Y-m-d H:i:s (T)");
        // set of errors for which a var trace will be saved
        $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
    
        $err = "";
        $err .= "[ $dt ] :errornum " . $this->getNErro() . ": errortype" . $this->getDescricaoErro( $this->getNErro() ) . ": errormsg " . $this->getMsgErro() . ":scriptname " . $this->getNomeArquivo() . "line " . $this->getNumLinha() . ":\n\t";

        if (in_array($this->getNErro(), $user_errors))
            $err .= "\tvartrace" . wddx_serialize_value($this->getVars(), "Variables") . ";\n";    

        // save to the error log, and e-mail me if there is a critical user error        
        error_log($err, 3, BVS_LOG . "/" . date("Y_m_d") . "_error.log");        
    }    
    /**
    * @return void
    * @param string $msgLog        Mensagem de Log
    * @desc Envia o E-mail.
    */
    function sendMail($msgErro)
    {
        if ($this->getNErro() == E_USER_ERROR) {
            mail(_WEBMASTER, "Critical User Error", $msgErro);
        }
    }
    /**
    * @return void
    * @desc Redireciona o usu�rio se necess�rio e poss�vel
    */
    function fluxoNavegacaoOriginal(){
    	global $smarty;
    	$erros = array();
    	$_errorDisplay = "none";
    	$_errorMsg = null;    	
        if ($this->getNErro() == E_USER_ERROR) {
            	$_errorDisplay = "block";
            	$_errorMsg = $this->getMsgErro();
            	$erros = array($_errorDisplay,$_errorMsg);
         		$smarty->assign("getError",$erros);         
         }elseif ($this->getNErro() > E_NOTICE && $this->getNErro() != E_USER_ERROR) {
         		$erros = array($_errorDisplay,$_errorMsg);
         		$smarty->assign("getError",$erros);
         }
    }
    function fluxoNavegacao(){
    	global $smarty;    	
    	if($this->getNErro() > E_NOTICE){
    		$smarty->assign("sMessage",array("message" => $this->getMsgErro(),
    										 "NErro" => $this->getNErro(),
											"success" => false));
    	}
    }
}
?>