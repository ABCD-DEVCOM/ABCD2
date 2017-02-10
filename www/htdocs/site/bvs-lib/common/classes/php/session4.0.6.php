<?php
class Session
{
	// Inicia uma sessão e recupera os valores das variáveis registradas.
	// Se $name != "" atualiza o nome da sessão corrente
	// Se $id != "" atualiza o id da sessão corrente
	public function __construct($name = "", $id = "")
	{
		if (!empty($name))
		{
			session_name($name);
		}
		if (!empty($id))
		{
			session_id($id);
		}
		session_start();
		}
	
	// Retorna o nome da sessão corrente
	function getSessionName()
	{
		return session_name();
	}
	
	// Retorna o id da sessão corrente
	function getSessionID()
	{
		return session_id();
	}

	// Registra uma variável de sessão
	//  $varname é o nome da variável de sessão
	//  $value é o valor a ser atribuído
	function register($varname, $value)
	{
		$GLOBALS[$varname] = $value;
 		session_register($varname);
	}
	
	// Desregistra variável da sessão
	function unregister($varname)
	{
	    if ( $this->isRegistered($varname) )
    	{
        	session_unregister($varname);
	    }
	}
	
	// Pega o valor da variável registrada
	function getValue($varname)
	{
		return $GLOBALS[$varname];
	}
	
	// Verifica se a variável com nome $varname está registrada ou não
	function isRegistered($varname)
	{
		return session_is_registered($varname);
	}
	
	// Destrói a sessão
	function logout()
	{
	    // Unregister session variables
    	session_unset();
    
		session_destroy();        

	    // Set cookie expire date to 0 => delete cookie.
		$sessionPath = session_get_cookie_params();
		setcookie(session_name(), "", 0, $sessionPath["path"], $sessionPath["domain"]); 
	}
}
?>