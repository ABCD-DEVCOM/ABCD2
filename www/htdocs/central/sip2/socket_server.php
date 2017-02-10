<?php
/*
	COMPONENTE PHP QUE GESTIONA EL SERVIDOR DE SOCKETS, SU
	FUNCION PRINCIPAL ES MANTENER EL SERVIDOR EN ESCUCHA
	CONSTANTE DE CONEXIONES CON SOCKETS.
	EL USUARIO PUEDE INICIAR O PARAR EL SERVIDOR.
*/

include ("../config.php");
include ("sip_config.php");

//Análisis de comando ha ejecutar
$pedido = $_POST['pedido'];
if ($pedido == "start_server" or $pedido == "start_antenas") 
	{
		//Llamado a la función de inicio del servidor de sockets
		error_reporting(~E_NOTICE);
		set_time_limit (0);
		$sock=crear_socket();
		//se usa un puerto específico para SC y para antenas
		if ($pedido == "start_server")
		{
			$sock=enlazar_socket($sock, $ip_sip_server, $port_sip_server);
		}
		elseif ($pedido == "start_antenas")
		{
			$sock=enlazar_socket($sock, $ip_sip_server, $port_sip_antena);
		}
		$sock=escuchar_socket($sock, $max_clients);
		$master_socket = $sock;
		manejar_entradas($sock, $max_clients, $master_socket, $enable_sip_log, $checksum_CRC, $maxretry);
	}
elseif ($pedido == "stop_server" or $pedido == "stop_antenas")
	{
		//Llamado a la función de parar el servidor de sockets
		$semaforo = 'cerrarserver';
		if ($pedido == "stop_server")
		{
			parar_server($semaforo, $ip_sip_server, $port_sip_server);
		}
		elseif ($pedido == "stop_antenas")
		{
			parar_server($semaforo, $ip_sip_server, $port_sip_antena);
		}
	}

function parar_server($semaforo, $ip_server, $port_server)
{
	//Función que crea un socket y envía un mensaje de stop que es 
	//identificado del lado del servidor
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	$resultado = socket_connect($socket,  $ip_server, $port_server);
	//sleep(3.1415);
	socket_write($socket, "cerrarserver", strlen("cerrarserver"));
	socket_close($socket);
	header("Location: admin_server.php");
}
function escribir_log($mensaje)
{
	if($archivo = fopen("log_sip.txt", "a"))
		{
			fwrite($archivo, date("d m Y H:m:s")."|".$mensaje."|". PHP_EOL);
			fclose($archivo);
		}
}
function crear_socket()
{
	//Función para crear un socket
	if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0)))
	{
		$errorcode = socket_last_error();
		$errormsg = socket_strerror($errorcode);
		$mensaje = "Error: no se pudo crear el socket(".$errocode.": ".$errormsg.")";
		escribir_log($mensaje);
		die();
	}
	else
	{
		$mensaje = "Socket creado";
		escribir_log($mensaje);
		return $sock;
	}
}
function enlazar_socket($sock, $ip_sip_server, $port_sip_server)
{
	//Función para enlazar un socket
	if( !socket_bind($sock, $ip_sip_server , $port_sip_server))
	{
		$errorcode = socket_last_error();
		$errormsg = socket_strerror($errorcode);
		$mensaje = "Error: no se pudo enlazar el socket ".$ip_sip_server.":".$port_sip_server."(".$errocode.": ".$errormsg.")";
		escribir_log($mensaje);
		die();
	}
	else
	{
		$mensaje = "Socket enlazado ".$ip_sip_server.":".$port_sip_server;
		escribir_log($mensaje);
		return $sock;
	}
}
function escuchar_socket($sock, $max_clients)
{
	//Función que pone en escucha el socket.
	if(!socket_listen ($sock , $max_clients))
	{
		$errorcode = socket_last_error();
		$errormsg = socket_strerror($errorcode);
		$mensaje = "Error: no se puede escuchar en el socket (".$errocode.": ".$errormsg.")";
		escribir_log($mensaje);
		die();
	}
	else
	{
		$mensaje = "Escuchando en el socket";
		escribir_log($mensaje);
		return $sock;
	}
}
function manejar_entradas($sock, $max_clients, $master_socket, $enable_sip_log, $checksum_CRC, $maxretry)
{
	//Array de sockets clientes
	$client_socks = array();
	//Array de sockets a leer
	$read = array();
	//Array con sockets y su AY y Retry
	$array_AYR = array();
	//Inicio de lectura continua para la escucha de conexiones entrantes
	while (true)
	{
		$read = array();
		$read[0] = $sock;
		for ($i = 0; $i < $max_clients; $i++)
		{
			if($client_socks[0][$i] != null)
			{
				$read[$i+1] = $client_socks[0][$i];
			}
		}
		//Llamada para analisis de bloqueo
		if(socket_select($read , $write = NULL, $except = NULL, $tv_sec = NULL) === false)
		{
			$errorcode = socket_last_error();
			$errormsg = socket_strerror($errorcode);
			die("Could not listen on socket : [$errorcode] $errormsg \n");
		}
		//Si ya existe un socket maestro, entonces el nuevo socket es una nueva conexion
		if (in_array($sock, $read))
		{
			for ($i = 0; $i < $max_clients; $i++)
			{
				if ($client_socks[0][$i] == null)
				{
					//aceptamos el socket y le asignamos AY y R
					$client_socks[0][$i] = socket_accept($sock);
					$client_socks[1][$i] = 1;	//para control 1 a 9
					$client_socks[2][$i] = 0;	//para maximo de reintentos hasta $maxretry
					//Guardamos información del cliente que está conectado
					if(socket_getpeername($client_socks[0][$i], $ip_client, $port_client))
					{
						if ($enable_sip_log == "Y")
						{
							$mensaje = "Conectado el cliente: $ip_client:$port_client";
							escribir_log($mensaje);
						}
					}
					break;
				}
			}
		}
		//Análisis si algún socket envío datos
		for ($i = 0; $i < $max_clients; $i++)
		{
			/*echo "<br><br><br>".$i."---------------------------------------<br>";
			var_dump($read);
			echo "<br>";
			var_dump($client_socks);
			echo "<br>---------------------------------------<br>";*/
			if (in_array($client_socks[0][$i] , $read))
			{
				//echo "---------envió DATO-----------------<br>";
							
				$input = socket_read($client_socks[0][$i] , 1024);
				if ($input == null)
				{
					//cuando la entrada es null es porque se desconecto el cliente
					//entonces se procede a cerrar ese socket
					if ($client_socks[0][$i] === $master_socket)
					{}
					else
					{
						socket_close($client_socks[0][$i]);
						unset($client_socks[0][$i]);
					}
				}
				if ($input==='cerrarserver')
				{
					//cuando la entrada es cerrarsever, se cierra el server tomado como
					//master socket y todos sus sockets clientes
					$mesaje = "Servidor cerrado";
					escribir_log($mensaje);
					socket_close($master_socket);
					unset($client_socks[0][0]);
					for ($y=0; $y<$max_clients; $y++)
					{
						$socket_temp = $client_socks[0][$y];
						socket_close($socket_temp);
						unset($client_socks[0][$y]);
					}
					break(2);
				}
				$request = $input;
				$tester = trim($request);
				$tester = $tester."&";
				echo $input."&<br>";
				
				if ($checksum_CRC == "Y")
				{
					if ($tester == "&")	//control envío de datos vacío
					{
						$typeofresponse = "99d9";
						$response = "99d9";
					}
					elseif (substr($request,0,2) == "97")
					{
						$typeofresponse = "97";
						$response = "97";
					}
					else
					{
						//Comprobación CRC de mensaje enviado
						$test = preg_split('/(.{4})$/',trim($request),2,PREG_SPLIT_DELIM_CAPTURE);
						$sum = 0;
						$len = strlen($test[0]);
						for ($n = 0; $n < $len; $n++) {
							$sum = $sum + ord(substr($test[0], $n, 1));
						}
						$crc = ($sum & 0xFFFF) * -1;
						$resultado_crc = substr(sprintf ("%4X", $crc), -4, 4);
						if ($resultado_crc == $test[1]) {
							//CRC ok, pasamos a la identificación de mensaje
							$client_socks[2][$i] = 0;
							$typeofresponse = get_message($request);
						} else {
							//pedido de reenvío de mensaje
							if ($client_socks[2][$i] <= $maxretry)
							{
								$typeofresponse = "96";
								$response = "96";
								$client_socks[2][$i] = $client_socks[2][$i] + 1;
							}
							else
							{
								//envío término de sesión ya que supera el $max_retry, se cierra el socket para este cliente
								echo "cierro cliente";
								if ($client_socks[0][$i] === $master_socket)
								{}
								else
								{
									socket_close($client_socks[0][$i]);
									unset($client_socks[0][$i]);
								}
							}
						}
					}
				}
				else
				{
					//pasamos directo a la identificación de mensaje
					$typeofresponse = get_message($request);
				}
				
				//llamar a la función SIP2 con $typeofresponse (array de 3 propiedades)
				if ($response === "96" or $typeofresponse === "96")
				{
					//pedido de reenvío al SC ya que no pasó el CRC
					socket_write($client_socks[0][$i], $response);
				}
				elseif ($response == "99d9" or $typeofresponse == "99d9")
				{
					//control de envío de byte vacio
					//al parecer streams de control de telnet putty
				}
				elseif ($typeofresponse[1] != 1 and $typeofresponse != null and $typeofresponse[0] != '')
				{
					//mensaje correcto
					//envío el tipo de respuesta (array de 3 posiciones) y el socket con AY (array de 2 posiciones)
					/*
						Al pasar AY se desconcatena en sip2.php para analizar la secuencia 
						Podemos controlar esta secuencia desde el servidor sumando 1, en tal caso
						se retornaría el nuevo AY a esta sección para guardarlo en el arreglo
						del respoectivo socket el $client_socks[$i]
					*/
					$array_socket_AYR = array($client_socks[0][$i],$client_socks[1][$i]);
					if ($response == "97")
					{
						//Si es que SC pide reenvío se escribe al response con el envio anterior
						$response = $last_response;
					}
					else
					{
						$response = sip2($typeofresponse, $array_socket_AYR, $checksum_CRC);
					}
					socket_write($client_socks[0][$i], $response);
					$last_response = $response;
				}
				else
				{
					//respuestas en blanco no se toman en cuenta
					//al parecer streams de control de telnet putty
					//$response = "96";
					//socket_write($client_socks[0][$i], $response);
				}
				$response = null;
				$typeofresponse = null;
				$array_socket_ayr = null;
			}
		}
	}
}
function get_message($mensaje_pedido)
{
	//retorna un array de 3 propiedades:
	//[id_de_mensaje_de_respuesta, nombre_funcion_respuesta, request]
	return (include 'case.php');
}
function sip2($array_request, $unsocket, $crc_enabled)
{
	//recibe el array con el request, elabora el response y lo retorna
	return (include 'sip2.php');
}

/*****************************************************************************************/
/*********************************** FUNCIONES SIP2 **************************************/
/*****************************************************************************************/
/*
	Las variables que indican el estado de ACS no son tratadas como simples variables de 
	dos estados (Y/N) ya que al ser programadas como valores que se retornan de funciones, 
	permiten al ACS crear rutinas que impidan la ejecución de dichas operaciones al 
	trabajar con datos que sean controlados por estas funciones así se puede parametrizar 
	de una mejor manera el estado del ACS frente a un SC en cualquier momento, incluso
	mienstras se encuentren en comunicación, por cuanto los request y response son 
	enviados en cada comunicación.
*/
function server_online()
{
	/*Función que determina si el servidor está listo
	Bloque de código donde se puede programar procedimientos
	que impidan la comunicación normale del servidor con
	los SC. (batch automáticos, secuencias emergentes..)
	Se deberá retornar N en caso de impedimento.*/
	return "Y";
}
function chickin_allowed()
{
	/*Función que determina si está permitido la devolución
	Bloque donde se pueden programar procedimientos que
	interrumpan la devolución para los SC, en tal caso se
	deberá retornar 'N'.*/
	return "Y";
}
function chickout_allowed()
{
	/*Función que determina si está permitido el préstamo.
	Bloque donde se pueden programar procedimientos que
	interrumpan el préstamos para los SC, en tal caso se
	deberá retornar 'N'.*/
	return "Y";
}
function ACS_renewall()
{
	/*Función que determina si se permite la renovación en SC.
	En caso de que la política determine que no, se retorna
	N, caso contrario Y.*/
	return "N";
}
function status_update()
{
	/*Función que indica si se puede cambiar el estado de usuario
	por petición del SC por timeout. Se recomienda Y por cuanto
	se pueden hacer intercambio de etiquetas durante el proceso
	de préstamo desmagnetizando más ejemplares.*/
	return "Y";
}
function off_line()
{
	/*Funcion que determina si el ACS soporta transacciones
	fuera de línea, 'Y' si soporta (se deberá programar una
	secuencia que permita la ejecución de request cuando el
	ACS vuelva a estar en línea dentro de esta función).*/
	return "N";
}
function timeout_period_retries ()
{
	/*Función que devuelve el valor del tiempo de espera para
	el SC, está determinado en el archivo sip_config.php de ABCD
	bajo la variable $sip_timeout_sc expresada en décimas de seg.*/
	include 'sip_config.php';
	return $sip_timeout_sc.$retries_trasaction;
}
function datestamp($timestamp = '') 
{
	/*Función que genera la fecha para las transacciones y
	sincronización con el SC. El formato que se emplea es
	YYYYMMDDZZZZHHMMSS.
	18-char, fixed-length field: YYYYMMDDZZZZHHMMSS. May be used to synchronize
	clocks. The date and time should be expressed according to the ANSI standard X3.30 for date
	and X3.43 for time. 000000000000000000 indicates a unsupported function. When possible
	local time is the preferred format*/
	/* From the spec:
	 * .
	 * All dates and times are expressed according to the ANSI standard X3.30 for date and X3.43 for time.
	 * The ZZZZ field should contain blanks (code $20) to represent local time. To represent universal time,
	 *  a Z character(code $5A) should be put in the last (right hand) position of the ZZZZ field.
	 * To represent other time zones the appropriate character should be used; a Q character (code $51)
	 * should be put in the last (right hand) position of the ZZZZ field to represent Atlantic Standard Time.
	 * When possible local time is the preferred format.
	 */
	if ($timestamp != '') {
		/* Generate a proper date time from the date provided */
		return date('Ymd    His', $timestamp);
	} else {
		/* Current Date/Time */
		return date('Ymd    His');
	}
}
function protocol_version ()
{
	/*Función que indica que versión de protocolo se esta
	usando, el formato es x.xx ej. 1.00*/
	include 'sip_config.php';
	return $protocol_version;
}
function library_id()
{
	/*Función que devuelve el valor de ID de biblioteca
	que pertenece al parámetro AO de SIP2*/
	include 'sip_config.php';
	return "AO".$sip_library_id;
}
function library_id_bg()
{
	/*Función que devuelve el valor de ID de biblioteca
	que pertenece al parámetro AO de SIP2*/
	include 'sip_config.php';
	return "|BG".$sip_library_id;
}
function library_name()
{
	/*Función que devuelve el nombre de la biblioteca y
	que pertenece al parámetro AM de SIP2*/
	include 'sip_config.php';
	if ($sip_library_name == "")
	{
		return "";
	}
	else
	{
		return "|AM".$sip_library_name;
	}
}
function supported_messages()
{
	/*Funcion que devuelve el valor de cada mensaje que
	soporta el ACS, ver table de parámetros en sip_config.php*/
	include 'sip_config.php';
	return "|BX".$sip_supported_messages;
}
function terminal_location()
{
	/*Función que indica el lugar donde está ubicado fisicamente
	el terminal SC, esta asociado al parámetro AN*/
	include 'sip_config.php';
	if ($sip_terminal_location == "")
	{
		return "";
	}
	else
	{
		return "|AN".$sip_terminal_location;
	}
}
function AF_message($tipo)
{
	/*Función que identifica el tipo de response del que
	se necesita su respectivo mensaje que va a ser presentado
	en la pantalla del SC, se usa el nombre de la variable 
	dentro de otra variable*/
	include 'sip_config.php';
	$codigo_mensaje = "AF_".$tipo;
	$mensaje = "$codigo_mensaje";
	return "|AF".${$mensaje};
}
function AG_message($tipo)
{
	/*Función que identifica el tipo de response del que
	se necesita su respectivo mensaje que va a ser presentado
	en la impresión en el SC, se usa el nombre de la variable 
	dentro de otra variable*/
	include 'sip_config.php';
	$codigo_mensaje = "AG_".$tipo;
	$mensaje = "$codigo_mensaje";
	return "|AG".${$mensaje};
}
function print_line($sc_characters)
{
	/*Función que identifica la cantidad de caracteres
	que alcanza a imprimir el SC en impresora, si 
	$sc_characters llega vacío, entonces no se ha definido
	y se usa el valor de config.php ($sip_print_line)*/
	if ($sc_characters == "")
	{
		include 'sip_config.php';
		return "|AG".$sip_print_line;
	}
	else
	{
		return "|AG".$sc_characters;
	}
}
function identificar_AY_sc($tipo_request, $un_pedido)
{
	/*Funcion que identifica el AY y su valor en el 
	request para su reenvío al SC, caracter de control*/
	if ($tipo_request == "98" and substr($un_pedido,10,1) != '|')
	{
		$secuencia_ay = substr($un_pedido, 12, 1);
	}
	else
	{
		$posicion = strpos($un_pedido,"|AY");
		$posicion = $posicion + 3;
		$secuencia_ay = substr($un_pedido, $posicion, 1);
	}
	return "|AY".$secuencia_ay;
}
function crc_message($un_mensaje)
{
	/*Función que arma el CRC de comrpovacion para
	el response y es devuelto para ser añadido al stream*/
	$i = 0;
	$longitud = strlen($un_mensaje);
	for ($n = 0; $n < $longitud; $n++) {
		$i = $i + ord(substr($un_mensaje, $n, 1));
	}
	$crc = ($i & 0xFFFF) * -1;
	return "AZ".substr(sprintf ("%4X", $crc), -4, 4)."\r\n";
}
function sip_lenguage()
{
	/*Función que devuelve el código del lenguaje que
	entiende el usuario (remitirse a tabla de guía 3M*/
	include 'sip_config.php';
	return $sip_lenguaje;
}
function fee_currency()
{
	/*Función que retorna el tipo de moneda que se usa*/
	include 'sip_config.php';
	if ($BH == "")
	{
		return "";
	}
	else
	{
		return "|BH".$BH;
	}
}
/*****************************************************************************************/
/*********************************** FUNCIONES ABCD **************************************/
/*****************************************************************************************/
/*
	Funciones generales que ayudan con la extracción de información del sistema ABCD.
*/
function busqueda_estado_prestamo($id_usuario, $id_libro)
{
	/*Función que busca en la base si un item ah sido prestado a un 
	usuario específico, se retorna los valores encontrados, se trabaja
	consultando a la base trans. La devolución en 0 de la variable
	$banderamx dice que se ejecutó correctamente el comando.*/
	include ("../config.php");
	include 'sip_config.php';
	$mx = $path_mx."\mx ".$db_path."trans/data/trans \"pft=if v20='".$id_usuario."' and v10='".$id_libro."' and v1='P' then v1 fi\" now";
	exec($mx,$outmx,$banderamx);
	if ($banderamx == "1")
	{
		return "error";
	}
	elseif ($outmx[0] == "")
	{
		$outmx = array();
		$banderamx = "";
		$mx = $path_mx."\mx ".$db_path."trans/data/trans \"pft=if v10='".$id_libro."' and v1='P' then v1 fi\" now";
		exec($mx,$outmx,$banderamx);
		if ($banderamx == "1")
		{
			return "error";
		}
		elseif ($outmx[0] == "")
		{
			return "false";
		}
		elseif ($outmx[0] == "P")
		{
			return array(0=>"prestado", 1=>$outmx[0]);
		}
	}
	else
	{
		return array(0=>"true", 1=>$outmx[0]);
	}
}
function multa_usuario($un_usuario)
{
	/*Funcion que analiza si un usuario tiene un multa, retorna 
	el valor y el monto de la multa en caso de que sea positivo,
	en caso afirmativo, false en caso negativo, error en caso
	de error*/
	include ("../config.php");
	include 'sip_config.php';
	$mx = $path_mx."\mx ".$db_path."suspml/data/suspml \"pft=if v20='".$un_usuario."' and v10='0' then v40,'|',v50 fi\" now";
	exec($mx,$outmx,$banderamx);
	if ($banderamx == "1")
	{
		return "error";
	}
	else
	{
		if ($outmx[0] == "")
		{
			return false;
		}
		else
		{
			return array(0=>"true",1=>$outmx);
		}
	}
}
function existe_usuario($un_usuario)
{
	/*Función que busca un usuario específico en la base patrons
	de ABCD, si existe, me devuelve la fecha de validez, caso 
	contrario se retorna false*/
	include ("../config.php");
	include 'sip_config.php';
	$mx = $path_mx."\mx ".$db_path."users/data/users \"pft=if v20='".$un_usuario."' then v18,'~',v10^a fi\" now";
	exec($mx,$outmx,$banderamx);
	if ($banderamx == "1")
	{
		return "error";
	}
	else
	{
		if ($outmx[0] == "")
		{
			return false;
		}
		else
		{
			return $outmx[0];
		}
	}
}
function fecha_actual_simple()
{
	/*Funcion que retorna la fecha actual en formato simple de
	ISO, ejemplo 20141128*/
	$fecha = date("Y-m-d"); 
	return $fecha;
}
function comparar_fechas($fecha1, $fecha2)
{ 
	/*Función que retorna el resultado de comparar 2 fechas:
		0: Las fechas son iguales
		1: La fecha 1 es mayor
		2: La fecha 1 es menor
	*/
	if($fecha1 == $fecha2) return 0; 
	if($fecha1 > $fecha2) return 1; 
	if($fecha1 < $fecha2) return 2; 
} 
function existe_item ($un_item)
{
	/*Función que busca si existe el item en la base de loanobjects
	devuelve error en caso de que existe un error en la busqueda,
	devuelve false, en caso de que no existe el item en la base
	o devuelve el tipo del item, en caso de si encontrarlo.*/
	include ("../config.php");
	include 'sip_config.php';
	$mx = $path_mx."\mx ".$db_path."loanobjects/data/loanobjects \"pft=if v959^i='".$un_item."' then v959^o fi\" now";
	exec($mx,$outmx,$banderamx);
	$mx = $path_mx."\mx ".$db_path."loanobjects/data/loanobjects \"pft=if v959^i='".$un_item."' then v10 fi\" now";
	exec($mx,$outmx2,$banderamx2);
	$mx = $path_mx."\mx ".$db_path."loanobjects/data/loanobjects \"pft=if v959^i='".$un_item."' then v1 fi\" now";
	exec($mx,$outmx3,$banderamx3);
	if ($banderamx == "1" or $banderamx2 == "1" or $banderamx3 == "1")
	{
		return "error";
	}
	else
	{
		if ($outmx[0] == "" or $outmx3[0] == "")
		{
			return false;
		}
		else
		{
			return array(0=>"true",1=>$outmx[0],2=>$outmx2[0],3=>$outmx3[0]);
		}
	}
}
function recuperar_item($un_inventario, $una_base, $un_num_control)
{
	/*Funcion que retorna el titulo de un item, este se busca según
	la base enviada como parámetro y el numero de control.
	El campo para el título se lo tiene como v245 por el momento, 
	campo para número de control, v1.
	El campo para inventario se lo compara con el campo v82^c. 
	(se han parametrizado en sip_config.php)*/
	include ("../config.php");
	include 'sip_config.php';
	$mx = $path_mx."\mx ".$db_path.$una_base."/data/".$una_base." \"pft=if v1='".$un_num_control."' then ".$campo_titulo.",'¬',".$campo_ubicacion." fi\" now";
	exec($mx,$outmx,$banderamx);
	if ($banderamx == "1")
	{
		return "error";
	}
	else
	{
		if ($outmx[0] == "")
		{
			return false;
		}
		else
		{
			return array(0=>"true",1=>$outmx[0]);
		}
	}	
}
function devolucion_unidad ($un_tipo_usuario, $un_tipo_item)
{
	/*Función que análiza la políticas de préstamo del sistema.
	Devuelve error, en caso de fallar la ejecución, devuelve
	false en caso de que el usuario no pueda prestarse el item,
	y devuelve un stream fecha,hora en caso de que pueda prestarse
	el item.*/
	include ("../config.php");	
	$nombre_fichero = $db_path."circulation/def/".$lang."/typeofitems.tab";
	$contenido = file ($nombre_fichero);
	foreach ($contenido as $value)
	{
        $val=explode('|',$value);
        if (($val[0] == $un_tipo_item) and ($val[1] == $un_tipo_usuario))
		{		
            return array(0=>$val[3], 1=>$val[5], 2=>$value, 3=>$val[2]);
        }		
	}

	return false;
}
function prestar($un_inventario, $un_item, $un_num_control, $una_base, $un_tipo_usuario, $un_id_usuario, $una_fecha_devolucion, $una_hora_dev, $un_titulo, $una_politica)
{
	/*Función que recibe los datos de un item y los intenta guardar
	en la base de datos de loanobjects*/
	include ("../config.php");
	$converter_path = $cisis_path."mx";
    $mx = $converter_path." null \"proc='a1~P~a10~".$un_inventario."~a20~".$un_id_usuario."~a30~".date('Ymd')."~a35~".date('g:h A')."~a40~".$una_fecha_devolucion."~a45~".$una_hora_dev."~a70~".strtoupper($un_tipo_usuario)."~a80~".$un_item."~a95~".$un_num_control."~a98~".$una_base."~a100~".$un_titulo."~a120~^aSC^b".date('Ymd g:h:s')."~'\" append=".$db_path."trans/data/trans count=1 now -all";
	exec ($mx,$outmx,$banderamx);
	$mx = $converter_path." ".$db_path."trans/data/trans fst=@".$db_path."trans/data/trans.fst fullinv=".$db_path."trans/data/trans -all now";
	exec ($mx,$outmx,$banderamx);  //GENERAR LISTA INVERTIDA
}
function FechaDevolucion($lapso,$unidad,$fecha_inicio)
{
	/*Se evalua la fecha de devolución de un préstamo, tomando
	en cuenta que se tienen dias no laborables y festibos*/
	include ("../config.php");	
	include ("../circulation/calendario_read.php"); // $feriados
	include ("../circulation/locales_read.php"); // $locales	
	$f_date=explode("/",$config_date_format);
	switch ($unidad){
		case "H":
			$newdate = date("Ymd h:i A",strtotime("+$lapso hours"));
        	return $newdate;
			break;
		case "D":
            if ($fecha_inicio==""){
				$dev= date("Y-m-d",strtotime("+0 days"));
	        }else{
	        	$dev= date("Y-m-d",strtotime($fecha_inicio."+0 days"));
	        }

	        $ix=strpos($dev," ");
	        if (!$ix===false)
	        	$dev=trim(substr($dev,0,$ix));
			break;
	}
    $d=0;
    $df=0;
    $diaFeriado="F";
    $dia_sem="F";
    $timeStamp=strtotime($dev);
    $total_days=-1;
    // se determinan los días feriados
    $ii=0;
    while ($d<$lapso){
    	$ii=$ii+1;
    	if ($ii>5000) {
    		die;
    	}
    	$total_days++;
    	$fdev=date("Y-m-d",strtotime($dev."+$total_days days"));
    	$timeStamp=strtotime($fdev);
    	$f=explode('-',$fdev);
    	$mes=$f[1];
    	$dia=$f[2]-1;
    	if (isset($feriados[$mes*1]) and substr($feriados[$mes*1],$dia,1)=="F"){
    		$diaFeriado="F";
    		$df=$df+1;
    		$dia_sem="";
    	}else{
    		$diaFeriado="";
    		// se determina cuáles dias no trabaja la biblioteca
    		$dia_sem=date("w",$timeStamp);
    		if (!isset($locales[$dia_sem]["from"])) {
    			$df=$df+1;
    			$dia_sem="F";
    		}else{
    			$d++;
    		}
    	}
    }
    $lapso=$lapso+$df-1;
    $dev= date("Ymd h:i:s A",strtotime($dev."+$lapso days"));
	return $dev;
}
function consultar_fecha_devolución ($un_id_item)
{
	/*Función que consulta a la base trans en busca del de id
	$un_id_item y cuyo estado se v1=P (prestado) para
	devolver la fecha de devolucion de ese item.*/
	include ("../config.php");
	include 'sip_config.php';
	$mx = $path_mx."\mx ".$db_path."trans/data/trans \"pft=if v10='".$un_id_item."' and v1='P' then v40,'|',v45 fi\" now";
	exec($mx,$outmx,$banderamx);
	if ($banderamx == "1")
	{
		return "error";
	}
	else
	{
		if ($outmx[0] == "")
		{	//no está en la base
			return false;
		}
		else
		{
			return array(0=>true, 1=>$outmx[0]);
		}
	}
}
function leer_usuario_item($id_libro)
{
	/*Funcion que retorna el id de un usuario en base
	al id del item que tiene prestado en loanobjects*/
	include ("../config.php");
	include 'sip_config.php';
	$mx = $path_mx."\mx ".$db_path."trans/data/trans \"pft=if v1='P' and v10='".$id_libro."' then v20 fi\" now";
	exec($mx,$outmx,$banderamx);
	return array(0=>"true", 1=>$outmx[0]);
}
function guardar_devolucion($un_id_usuario, $un_id_item)
{
	/*Funcion que permite cambiar el estado de un préstamo
	basado en el id del usuario y del item, se comprueba
	primero que el item esté prestado en loanobjects*/
	include ("../config.php");
	$converter_path = $cisis_path."mx";
    $mx = $converter_path." ".$db_path."trans/data/trans \"proc=if v1='P' and v10='".$un_id_item."' and v20='".$un_id_usuario."' then 'd1','<1>X</1>','<500>".date('Ymd')."</500>','<130>^aSC^b".date('Ymd g:h:s')."</130>' fi\" copy=".$db_path."trans/data/trans now -all";
	exec ($mx,$outmx,$banderamx);
	$mx = $converter_path." ".$db_path."trans/data/trans fst=@".$db_path."trans/data/trans.fst fullinv=".$db_path."trans/data/trans -all now";
	exec ($mx,$outmx,$banderamx);  //GENERAR LISTA INVERTIDA
}
function bloquear_usuario($un_usuario, $un_mensaje, $id)
{
	/*Funcion que ingresa un registro en la base suspml para el usuario
	que indica que se encuentra bloqueado por olvido de la tarjeto o
	por manipulación indebida de material en el SC*/
	include ("../config.php");
	$converter_path = $cisis_path."mx";
    $mx = $converter_path." null \"proc='a1~S~a10~0~a20~".$un_usuario."~a30~".date('Ymd')."~a40~01~a100~".$un_mensaje."~a200~".$id."~'\" append=".$db_path."suspml/data/suspml count=1 now -all";
	exec ($mx,$outmx,$banderamx);
	$mx = $converter_path." ".$db_path."suspml/data/suspml fst=@".$db_path."suspml/data/suspml.fst fullinv=".$db_path."suspml/data/suspml -all now";
	exec ($mx,$outmx,$banderamx);  //GENERAR LISTA INVERTIDA
}
function nombre_usuario($un_usuario)
{
	/*Función que busca un usuario específico en la base patrons
	de ABCD, si existe, me devuelve los nmbres del mismo, caso 
	contrario se retorna false*/
	include ("../config.php");
	include 'sip_config.php';
	$mx = $path_mx."\mx ".$db_path."users/data/users \"pft=if v20='".$un_usuario."' then v30 fi\" now";
	exec($mx,$outmx,$banderamx);
	if ($banderamx == "1")
	{
		return "error";
	}
	else
	{
		if ($outmx[0] == "")
		{
			return false;
		}
		else
		{
			return $outmx[0];
		}
	}
}
function buscar_usuario_bloqueado($un_usuario, $un_mensaje)
{
	/*Funcion que busca en el sistema si el usuario $AA tiene una 
	sanción y que adicionalmente contenga en el comentario el
	string: 02SC: que se identifica como un mensaje enviado desde
	un SC.*/
	include ("../config.php");
	include 'sip_config.php';
	$mx = $path_mx."\mx ".$db_path."suspml/data/suspml \"pft=if v20='".$un_usuario."' and v10='0' and v1='S' and v200='".$un_mensaje."' then v100 fi\" now";
	exec($mx,$outmx,$banderamx);
	if ($banderamx == "1")
	{
		return "error";
	}
	else
	{
		if ($outmx[0] == "")
		{
			return false;
		}
		else
		{
			return array(0=>"true",1=>$outmx[0]);
		}
	}
}
function prestamos_actuales_activos($id_usuario)
{
	/*Función que busca en la base trans la cantidad de prestamos
	activos que tiene un usuario y la devuelve.*/
	include ("../config.php");
	include 'sip_config.php';
	$mx = $path_mx."\mx ".$db_path."trans/data/trans \"pft=if v20='".$id_usuario."' and v1='P' then v1 fi\" now";
	exec($mx,$outmx,$banderamx);
	if ($banderamx == "1")
	{
		return "error";
	}
	elseif ($outmx[0] == "")
	{
		return "false";
	}
	else
	{
		return array(0=>"true", 1=>$outmx);
	}
}
function situacion_item($un_item)
{
	/*Funcion que busca un item en la base de copias para
	determinar su estado o situación registrado en el campo
	200.*/
	include ("../config.php");
	include 'sip_config.php';
	$mx = $path_mx."\mx ".$db_path."copies/data/copies \"pft=if v30='".$un_item."' then v200^a fi\" now";
	exec($mx,$outmx,$banderamx);
	if ($banderamx == "1")
	{
		return "error";
	}
	else
	{
		if ($outmx[0] == "")
		{
			return "false";
		}
		else
		{
			return array(0=>"true",1=>$outmx[0]);
		}
	}
}
function recuperar_item_seguridad($un_inventario, $una_base, $un_num_control)
{
	/*Funcion que retorna el titulo de un item, este se busca según
	la base enviada como parámetro y el numero de control.
	El campo para el título se lo tiene como v245 por el momento, 
	campo para número de control, v1.
	El campo para inventario se lo compara con el campo v82^c. 
	(se han parametrizado en sip_config.php)*/
	include ("../config.php");
	include 'sip_config.php';
	$mx = $path_mx."\mx ".$db_path.$una_base."/data/".$una_base." \"pft=if v1='".$un_num_control."' then ".$campo_tipo_seguridad." fi\" now";
	exec($mx,$outmx,$banderamx);
	if ($banderamx == "1")
	{
		return "error";
	}
	else
	{
		if ($outmx[0] == "")
		{
			return false;
		}
		else
		{
			return array(0=>"true",1=>$outmx[0]);
		}
	}	
}
function habilitado_message_25 ()
{
	/*Funcion que determina si el sistema está configurado para
	aceptar los mensajes 25 de SIP, se lee la variable $message_25_enable
	del archivo sip_config.php, se devuelve true si es "Y"
	caso contrario false*/
	include 'sip_config.php';
	if ($message_25_enable == "Y") return true;
	else return false;
}
function desbloquear_usuario_bloqueado($un_usuario)
{
	/*Funcion que busca en el sistema si el usuario $AA tiene una 
	sanción y que adicionalmente contenga en el comentario el
	string: 02SC: que se identifica como un mensaje enviado desde
	un SC.*/
	include ("../config.php");
	include 'sip_config.php';
	
	$converter_path = $cisis_path."mx";
    $mx = $converter_path." ".$db_path."suspml/data/suspml \"proc=if v1='S' and v200='02SC' and v20='".$un_usuario."' then 'd10','<10>3</10>','<110>^aSC^b".date('Ymd g:h:s')."</110>' fi\" copy=".$db_path."suspml/data/suspml now -all";
	exec ($mx,$outmx,$banderamx);
	$mx = $converter_path." ".$db_path."trans/data/trans fst=@".$db_path."trans/data/trans.fst fullinv=".$db_path."trans/data/trans -all now";
	exec ($mx,$outmx,$banderamx);  //GENERAR LISTA INVERTIDA
	
	if ($banderamx == "1")
	{
		return "error";
	}
	else
	{
		if ($outmx[0] == "")
		{
			return false;
		}
		else
		{
			return array(0=>"true",1=>$outmx[0]);
		}
	}
}
/*****************************************************************************************/
/*****************************************************************************************/
?>
