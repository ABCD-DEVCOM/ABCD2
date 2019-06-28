<?php

/* *****************************************************************************************
old2new - versao 1.1

	Ultims revisao:
	
			02/10/2002 (Shintani) - corrigir problema relacionado com file uploading

	Autores:
	
			Joao Rodolfo Suarez de Oliveira
			Roberto Shintani

	Descricao:
	
			Codigo para compatibilizar versoes anteriores do PHP
			que consideravam qualquer variavel vinda do browser
			como variavel global (versoes anteriores ao PHP 4.1)

Em PHP anterior a 4.1 temos:

	$HTTP_SERVER_VARS...An associative array of variables passed to the current script from the HTTP server.
	$HTTP_GET_VARS......An associative array of variables passed to the current script via the HTTP GET method. 
	$HTTP_POST_VARS.....An associative array of variables passed to the current script via the HTTP POST method. 
	$HTTP_COOKIE_VARS...An associative array of variables passed to the current script via HTTP cookies. 
	$HTTP_POST_FILES....An associative array of variables containing information about files uploaded via the
	                    HTTP POST method. 
	$HTTP_ENV_VARS......An associative array of variables passed to the current script via the parent environment. 

Em PHP 4.2 temos:

	$_SERVER
	Variables set by the web server or otherwise directly related to the execution environment
	of the current script. Analogous to the old $HTTP_SERVER_VARS array (which is still available, but deprecated). 
	
	$_GET
	Variables provided to the script via HTTP GET. Analogous to the old $HTTP_GET_VARS array
	(which is still available, but deprecated). 
	
	$_POST
	Variables provided to the script via HTTP POST. Analogous to the old $HTTP_POST_VARS array
	(which is still available, but deprecated). 
	
	$_COOKIE
	Variables provided to the script via HTTP cookies. Analogous to the old $HTTP_COOKIE_VARS
	array (which is still available, but deprecated). 
	
	$_FILES
	Variables provided to the script via HTTP post file uploads. Analogous to the old $HTTP_POST_FILES
	array (which is still available, but deprecated).
	
	$_ENV
	Variables provided to the script via the environment. Analogous to the old $HTTP_ENV_VARS array
	(which is still available, but deprecated). 
	
	$_REQUEST
	Variables provided to the script via any user input mechanism. This array has no direct
	analogue in versions of PHP prior to 4.1.0. It is an associative array consisting of the
	contents of $_GET, $_POST, $_COOKIE, and $_FILES. 
	
	In PHP 4.2.0 and later the contents of the associative arrays described above are
	not automatically made available in the global scope of the script (the default
	value for php directive register_globals is OFF).

***************************************************************************************** */

$old2newArray = array("HTTP_POST_VARS"    => "_POST",
                      "HTTP_GET_VARS"     => "_GET",
					  "HTTP_COOKIE_VARS"  => "_COOKIE",
					  "HTTP_SERVER_VARS"  => "_SERVER",
					  "HTTP_ENV_VARS"     => "_ENV",
					  "HTTP_SESSION_VARS" => "_SESSION",
					  "HTTP_POST_FILES"   => "_FILES"); // v1.1 corrige o array correspondente
reset ( $old2newArray );
while ( list ( $old, $new ) = each ( $old2newArray ) )
{
	if  ( !isset ( $$old ) && isset ( $$new ) ) $$old = $$new;

	if  ( isset ( $$old ) && $old != "HTTP_POST_FILES" )
	{
		reset ( $$old );
		while ( list ( $key, $value ) = each ( $$old ) )
        {
            if ( !isset ( $GLOBALS[ $key ] ) )
            {
                $GLOBALS[ $key ] = $value;
            }
        }
	}
}

// Codigo diferenciado para file upload
if ( isset ( $HTTP_POST_FILES ) )
{
    reset ( $HTTP_POST_FILES );
    while ( list ( $var, ) = each ( $HTTP_POST_FILES ) )
    {
        $GLOBALS[ $var ] = $HTTP_POST_FILES[ $var ][ 'tmp_name' ];
        $GLOBALS[ $var . "_name" ] = $HTTP_POST_FILES[ $var ][ 'name' ];
        $GLOBALS[ $var . "_type" ] = $HTTP_POST_FILES[ $var ][ 'type' ];
        $GLOBALS[ $var . "_size" ] = $HTTP_POST_FILES[ $var ][ 'size' ];
        $GLOBALS[ $var . "_error" ] = $HTTP_POST_FILES[ $var ][ 'error' ];
    }
}
?>