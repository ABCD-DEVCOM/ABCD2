<?php
/****************	PARAMETROS DE CONFIGURACIÓN PARA SERVIDOR SIP  ****************/
//ip SIP server
$ip_sip_server = "127.0.0.1";
//server port para escuchar peticiones de SC y serividor alterno respectivamente (se pretende no cargar la escucha por un solo puerto)
$port_sip_server = 5060;
$port_sip_antena = 5061;
//cantidad de conecciones que se admiten al server
$max_clients = 4;
//habilitar el log de procesos?
$enable_sip_log = "Y";
//Identificar comprobación CRC de mensajes? (Y recomendado)
$checksum_CRC = "Y";
// Maximum number of resends allowed before get_message gives up
$maxretry = 3;
// Timeout para el SC, 000 no en linea, 999 timeout desconocido, se expresa en décimas de segundo y simepre en 3 caracteres.
$sip_timeout_sc = '010';
// Cantidad de reintentos que se permiten para una transacción, 999 la cantidad es desconocida. Siempre en 3 caracteres.
$retries_trasaction = '003';
// Versión de protocolo SIP que se está usando en el ACS
$protocol_version = '2.00';
// Prefijo AO -> library id
$sip_library_id = "1";
// Prefijo AM [opcional] -> Nombre de la biblioteca (si no se usa dejar "")
$sip_library_name = "CDRJB";
/* 
Prefijo BX -> Mensajes que soporta el ACS y que indica al SC. Y -> si soporta, N -> no soporta
	Position Message 	Command/Response pair		Implemented
			0 			Patron Status Request			Yes
			1			Checkout						Yes
			2			Checkin							Yes
			3			Block Patron					No
			4			SC/ACS Status					Yes
			5			Request SC/ACS Resend			Yes
			6			Login							No
			7			Patron Information				No
			8			End Patron Session				Yes
			9			Fee Paid						No
			10			Item Information				Yes
			11			Item Status Update				Yes
			12			Patron Enable					No
			13			Hold							No
			14			Renew							No
			15			Renew All						No
*/
$sip_supported_messages = "YYYNYYNNYNYYNNNN";
// Prefijo AN [opcional] -> Indica la ubicación física del terminal SC (si no se usa dejar "")
$sip_terminal_location = "Piso uno";
// Prefijo AG [optional] -> Indica el número de caracteres que alcanzar a ser impresas en una impresora en el SC (si no se usa dejar ""). Se da prioridad a lo indicado por el SC.
$sip_print_line = 040;
// Lenguaje para el usuario final. 001 es inglés, usamos 003 para español. (remitirse a guia de 3M)
$sip_lenguaje = "008";
// La política de la Biblioteca permite renovaciones en SC (Y/N)
$sip_SC_renewal_policy = "N";
// Tipo de moneda en la que se maneja el dinero, hay tabla en documento 3M, USD para Ecuador, siempre 3 caracteres
$BH = "USD";
// Path de MX
$path_mx = "C:\ABCD\www\cgi-bin";
// Campo bajo el que se buscarán los títulos para un item y se los devolverá al SC
$campo_titulo = "v245^a";
// Campo bajo el cual se compara un número de inventario de un item en una base
$campo_inventario = "v82^c";
// Campo bajo el cual se encuentra la ubicación del item en la base
$campo_ubicacion = "v900^o";
// Campo que indica en el sistema el tipo de suguridad que tiene el item
$campo_tipo_seguridad = "v900^z";
// Habilitar el uso del mensaje 25? Y/N
$message_25_enable = "Y";
/******************Configuración de mensajes AF para cada response*****************/
// Prefijo AF 98 [opcional] -> Indica un mensaje en pantalla para respuesta ACS (
// si no se usa dejar "")
$AF_98 = "Enviados mensajes de estado. Bienvenido a ACS.";
$AF_24 = "Información de Usuario";
$AF_12_ok = "Préstamos realizado";
$AF_12_no = "Fallo en el préstamo";
$AF_12_no_base = "Fallo en el préstamo, no información en base";
$AF_12_no_multa = "El usuario tiene una multa activa.";
$AF_12_no_user = "Error en la búsqueda de usuario..";
$AF_12_no_user2 = "El usuario no se encuentra en la base.";
$AF_12_no_user3 = "Su fecha de membresía expiró.";
$AF_12_no_item = "No existe el item en la base";
$AF_12_no_politica = "Usted no puede hacer préstamo, acercarse a la mesa de préstamo.";
$AF_12_no_renew = "Este item ya está prestado a usted, seleccione renovar.";
$AF_12_no_prestado = "Este item no se encuentra disponible, diríjase al escritorio de préstamo..";
$AF_12_sobrepaso = "Usted ha alcanzado el límite de items disponibles para préstamo.";
$AF_10 = "Devolución de ITEM";
$AF_10_no_busqueda = "Error en la busqueda";
$AF_10_no_base = "El item no puede ser devuelto,  diríjase al escritorio de préstamos..";
$AF_10_ok = "Item devuelto.";
$AF_10_ok_multa = "Item devuelto. Se le ha ocacionado un multa. Si desea información acercarse a la mesa de préstamo.";
$AF_02_block = "Este usuario está bloqueado";
$AF_36_ok = "Gracias, buen día.";
$AF_18_ok = "Información del Item";
$AF_26_ok = "Usuario desbloqueado";
$AF_26_no = "Procedimiento no disponible";
$AF_26_no_base = "El usuario no está bloqueado";
/**********************************************************************************/
/******************Configuración de mensajes AG para cada response*****************/
// Prefijo AG 98 [opcional] -> Indica un mensaje en impresora como respuesta del ACS
// (si no se usa dejar "")
$AG_12 = "Detalles de transacción de préstamo.";
$AG_10 = "Devolución de item, detalles:";
$AG_18 = "Información del item";
/**********************************************************************************/
?>
