<?php
/*
	PHP que identifica el tipo de request y retorna su respectivo response armado con los parámetros y datos
	del servidor como de la base de datos respectivamente. Los streams response se arman según lo que se indique
	en las funciones, permitiendo flexibilidad al ACS en caso de no poder ejecutar una función requerida por 
	el SC (se indica como Y/N) y que están en sip2_functions.php.
	
Última actualización: 14 nov 2014
|=============================================================================================================================================
| *Pair* | *Name*              | *Supported?*	| *Details* 
| 01     | Block Patron        | No				|
| 09-10  | Checkin             | Yes			|
| 11-12  | Checkout            | Yes			| No trabaja cuando ACS está offline
| 15-16  | Hold                | No				|
| 17-18  | Item Information    | Yes			|
| 19-20  | Item Status Update  | Yes			|
| 23-24  | Patron Status       | Yes			| 
| 25-26  | Patron Enable       | No				|
| 29-30  | Renew               | No				|
| 35-36  | End Session         | Yes			|
| 37-38  | Fee Paid            | No				|
| 63-64  | Patron Information  | No				|
| 65-66  | Renew All           | No				|
| 93-94  | Login               | No				|
| 97-96  | Resend last message | Yes			|
| 99-98  | SC-ACS Status       | Yes			| No se controla cuando el SC es version 1.00
|--------|---------------------|----------------|-----------------------------------------------------------------------------------------------
| CRC  	 | CRC control         | Yes			| Se habilita en config.php (Y/N)
| AY  	 | AY número secuencia | Yes			| Se habilita cuando CRC está habilitado en config.php (Y/N)
| Param. | Configurables	   | Yes			| Los parámetros configurables: socket_server.php->[Funciones SIP2] y config.php->[Param SIP]
|=============================================================================================================================================
*/

include ("../config.php");

$elsocket = $unsocket;
$id_response = $array_request[0];
$function_response = $array_request[1];
$request = $array_request[2];

/*
	bloque que permite llevar los parámetros de secuencia AY
	AY es un parámetro de longitud fija de 1 caracter del 1 al 9
*/
socket_getpeername($elsocket, $ip, $port);

switch ($id_response) 
{
    case 24:
		//2300119960212    100239AOid_21|AA104000000105|AC|AD|AY2AZF400<CR>
		//Analizo el Patron Status Request. No se necesita identificar password para SC ni para cliente (AC AD respectivamente)
		$fecha_request = substr($request,5,18);
		//AA Patron ID dentro del request
		$posicion = strpos($request,"|AA");
		$posicion = $posicion + 3;
		$posicion_final = strpos($request,"|AC");
		$AA = substr($request, $posicion, ($posicion_final - $posicion));
		$AC = "";
		$AD = "";

		//24 00119960212 100239AO|AA104000000105|AEJohn Doe|AFScreen Message|AGCheck Printmessage|AY2AZDFC4
		//Análisis del cliente en la base de datos en respuesta al request 23
		$respuesta = "24";
		/*Aquí se adieren los 14 caracteres del estado del cliente que deben ser analizados en la base de datos (POR EL MOMENTO SE ENVIA OK):
		0 charge privileges denied
		1 renewal privileges denied
		2 recall privileges denied
		3 hold privileges denied
		4 card reported lost
		5 too many items charged
		6 too many items overdue
		7 too many renewals
		8 too many claims of items returned
		9 too many items lost
		10 excessive outstanding fines
		11 excessive outstanding fees
		12 recall overdue
		13 too many items billed*/
		$respuesta = $respuesta."              ";
		$respuesta = $respuesta.sip_lenguage().datestamp().library_id()."|AA".$AA;
		/*
		Extraer los datos personales como:
		- nombre y apellido 
		- monto de deuda
		por el momento se llenan con valores de ejemplo
		*/
		$AE = "Mauricio Brito";
		$BL = "Y"; 		// OPCIONAL Este caracter es muy importante, indica si el codigo de barras que identifica al usuario está en la base.
		$CQ = "Y"; 		// OPCIONAL no usamos pass para usuarios
		$respuesta = $respuesta."|AE".$AE."|BL".$BL."|CQ".$CQ;
		$BV = "|BV115.70";	// OPCIONAL usar puntos decimales		
		if (fee_currency() != "")
		{
			$respuesta = $respuesta.fee_currency();	// OPCIONAL USD US Dollar (para más información ver tabla de 3M)
			$respuesta = $respuesta.$BV;
		}
		$respuesta = $respuesta.AF_message($id_response); // OPTIONAL
		$respuesta = $respuesta."|AG999"; // OPCIONAL envio 999 para indefinido, depende de la información que presente el SC
		if ($crc_enabled === "Y") //está habilitada las comprobaciones CRC
		{
			$respuesta = $respuesta.identificar_AY_sc($id_response, $request)."AZ";
			$respuesta = $respuesta.crc_message($respuesta);
		}
		return $respuesta;
        break;
    case 12:
		//11YN19960212    10051419960212    100514AO|AA104000000105|AB000000000005792|AC|AY3AZEDB7
		//Analizo el request del SC para el checkout
		$sc_renewal_policy = substr($request,2,1); 			// está configurado el SC para hacer renovaciones?
		$no_block = substr($request,3,1); 					// Y si se ha realizado la transacción mientras el ACS estaba en línea
		$transaction_date = substr($request,4,18);			// fecha de transacción (momento en el que se envía request to ACS)
		$nb_due_date = substr($request,22,18);				// fecha de transacción fuera de línea
		
		$posicion = strpos($request,"|AA");					// AA Patron ID dentro del request
		$posicion = $posicion + 3;
		$posicion_final = strpos($request,"|AB");
		$AA = substr($request, $posicion, ($posicion_final - $posicion));

		$posicion = strpos($request,"|AB");					// AB Item ID dentro del request
		$posicion = $posicion + 3;
		$posicion_final = strpos($request,"|AC");
		$AB = substr($request, $posicion, ($posicion_final - $posicion));
		//No se programa BI, CH, AD y BO que son opcionales

		/*
			ACS Checkout response
			Ejemplo: 120NNY19960212 100514AO|AA104000000105|AB000000000005792|AJ|AH|AFItem cannot be charged : see help desk|AGItem can not be charged : see help desk|AY3AZD2A1<CR>		
				
				Field 				ID 			Format		
				ok								1-char, fixed-length required field: 0 or 1.
				renewal ok 						1-char, fixed-length required field: Y or N.
				magnetic media 					1-char, fixed-length required field: Y or N or U.
				desensitize 					1-char, fixed-length required field: Y or N or U.
				transaction date	 			18-char, fixed-length required field: YYYYMMDDZZZZHHMMSS
				institution id 		AO 			variable-length required field
				patron identifier 	AA 			variable-length required field
				item identifier 	AB 			variable-length required field
				title identifier 	AJ 			variable-length required field
				due date 			AH 			variable-length required field
				fee type 			BT 			2-char, fixed-length optional field (01 thru 99). The type of fee associated with checking out
				security inhibit 	CI 			1-char, fixed-length optional field : Y or N.
				currency type 		BH 			3-char fixed-length optional field
				fee amount 			BV 			variable-length optional field. The amount of the fee associated with checking out this item.
				media type 			CK			3-char, fixed-length optional field
				item properties 	CH			variable-length optional field
				transaction id 		BK			variable-length optional field. Maybe assigned by ACS when checking out the item involves a fee
				screen message 		AF 			variable-length optional field
				print line 			AG 			variable-length optional field
		*/
		
		// Proceso de análisis de la cuenta del usuario (se analiza si puede pedir material)
		
		//Se encuentra el usuario en la base?
		$usuario = existe_usuario($AA);
		if ($usuario == "error")
		{
			//existe un error en la ejecución de la búsqueda
			$respuesta = "120NUN".datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ|AH".AF_message("12_no_user").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		elseif ($usuario == "false")
		{
			//el usuario no se encuentra en la base
			$respuesta = "120NUN".datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ|AH".AF_message("12_no_user2").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		else
		{
			//El usuario está en la base, validamos la fecha hasta la cual está activo este usuario
			//la fecha llega en formato ISO ejemplo: 20220213 (13/02/2022)
			$fecha_valida_user = substr($usuario,0,4)."-".substr($usuario,4,2)."-".substr($usuario,6,2);
			$fecha_actual = fecha_actual_simple();
			$fecha_comparar = comparar_fechas($fecha_valida_user, $fecha_actual); // si resultado 0 o 1 esta bien
			if ($fecha_comparar == 2 or $fecha_comparar == 0)
			{
				//usuario no valido, fecha de membresía expiró campo v18 base patrons
				//el usuario no se encuentra en la base, cualquier otro caso, el usuario está activo y en la base
				$respuesta = "120NUN".datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ|AH".AF_message("12_no_user3").AG_message($id_response);
				if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
				return $respuesta;
				break;
			}
			$total_caracteres = strlen($usuario);
			$tipo_usuario = substr($usuario,9,$total_caracteres);
		}
		
		//El usuario tiene una multa?
		$tiene_multa = multa_usuario($AA);
		if ($tiene_multa == "error")
		{
			//error interno en la ejecución de la consulta.
			$respuesta = "120NUN".datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ|AH".AF_message("12_no_user").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		elseif ($tiene_multa[0] == "true")
		{
			//tiene una multa activa, no se realiza préstamo, se desconcatena el tipo de multa y el monto
			$la_multa = $tiene_multa[1];
			$total = strlen($la_multa[0]);
			$BT = substr($la_multa[0],0,2);
			$BV = substr($la_multa[0],3,$total);
			$ok = "0";
			$desensitize = "N";
			$magnetic = "U";
			$respuesta = "12".$ok."N".$magnetic.$desensitize.datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ|AH|BT".$BT.fee_currency()."|BV".$BV.AF_message("12_no_multa").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
				
		//Existe el item en la base de loanobjects?
		$existe_item = existe_item($AB);
		if ($existe_item == "error")
		{
			//error interno en la ejecución de la consulta.
			$respuesta = "120NUN".datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ|AH".AF_message("12_no_base").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		elseif ($existe_item[0] == "false")
		{
			//no existe
			$respuesta = "120NUN".datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ|AH".AF_message("12_no_item").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		elseif ($existe_item[0] == "true")
		{
			//si existe el item, recupero el tipo de item
			$tipo_item = $existe_item[1];
			$base_item = $existe_item[2];
			$num_control_item = $existe_item[3];
		}
			
		//El Usuario puede llevarse el item? (política typeofoitem.tab), OJO manejo de idioma.
		$valor_unidad = devolucion_unidad ($tipo_usuario, $tipo_item);
		$politica = $valor_unidad[2];		
		if ($valor_unidad == false)
		{
			//no existe la política para ese usuario y es item
			$respuesta = "120NUN".datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ|AH".AF_message("12_no_politica").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		$cantidad = $valor_unidad[0];
		$unidad = $valor_unidad[1];

		//Hasta cuando puede llevarse un item?
		$fecha_actual = date("Y-m-d");
		$fecha_devolucion = FechaDevolucion($cantidad, $unidad, $fecha_actual);
		$fecha_simple = substr($fecha_devolucion,0,8);
		$hora_devolucion = substr($fecha_devolucion,9);
		$AH = $fecha_devolucion;
				
		//Recupero datos del item (se busca en la base segun lo indicado en el campo v10 del item en loanobjects)
		$datos_item = recuperar_item($AB, $base_item, $num_control_item);
		if ($datos_item == "error")
		{
			//error interno en la ejecución de la consulta.
			$respuesta = "120NUN".datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ|AH".AF_message("12_no_base").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		elseif ($datos_item[0] == "false")
		{
			//no existe el item
			$respuesta = "120NUN".datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ|AH".AF_message("12_no_item").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		elseif ($datos_item[0] == "true")
		{
			//si existe el item, recupero el tipo de item
			$posicion_interna = strpos($datos_item[1],"¬");
			$titulo_item = substr($datos_item[1],0,$posicion_interna);
		}
		$AJ = $titulo_item;
		
		//El usuario puede llevarse más items?
		$cantidad_items_prestados = devolucion_unidad($tipo_usuario, $tipo_item);
		$cantidad_items_prestados = $cantidad_items_prestados[3];
		$resultado_prestamos_actual = prestamos_actuales_activos($AA);
		if ($resultado_prestamos_actual[0] == "true")
		{
			$total_prestamos_actual = $resultado_prestamos_actual[1];
			$total_prestamos_actual = substr_count($total_prestamos_actual[0], 'P');
			if ((int)$total_prestamos_actual >= (int)$cantidad_items_prestados)
			{
				//la cantidad de préstamos es mayor o igual a la permitida en la política para este usuario, se envía mnsaje de que no se le permiten más préstamos
				$respuesta = "120NUN".datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ|AH".AF_message("12_sobrepaso").AG_message($id_response);
				if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
					{
						$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
						$respuesta = $respuesta.crc_message($respuesta);
					}
				return $respuesta;
				break;
			}
		}
		
		//El usuario tiene el item prestado a si mismo? (renovacion)
		$resultado_estado_prestamo = busqueda_estado_prestamo($AA, $AB); //está pedido el item actual?
		if ($resultado_estado_prestamo == "error")
		{
			//error en la búsqueda de la información del prestamo en la base, no se realiza préstamo, se envía mensje de respuesta negando
			$respuesta = "120NUN".datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ".$AJ."|AH".$AH.AF_message("12_no_user").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		if ($resultado_estado_prestamo[0] == "true")
		{
			//se trata de una renovación
			$respuesta = "120YUN".datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ".$AJ."|AH".$AH.AF_message("12_no_renew").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		elseif ($resultado_estado_prestamo[0] == "prestado")
		{
			//el item se encuentra prestado
			$respuesta = "120NUN".datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ".$AJ."|AH".$AH.AF_message("12_no_prestado").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		elseif ($resultado_estado_prestamo == "false")
		{

		//préstamo nuevo
		//Se ejecuta finalmente el préstamo del item, después de guardar la información en la base, puedo tomar datos adicionales como la fechas hasta la cuál se tendrá validez el préstamo (fecha de devolución, etc), y datos del item.

			prestar($AB, $tipo_item, $num_control_item, $base_item, $tipo_usuario, $AA, $fecha_simple, $hora_devolucion, $titulo_item, $politica);
			$resultado_estado_prestamo = busqueda_estado_prestamo($AA, $AB); //comprobamos si se ha prestado el item
			if ($resultado_estado_prestamo[0] == "true")
			{
				//se ha realizado el préstamo, se procede a indicar que se desmagnetice el item
				$ok = "1";
				$renewal = "N";
				$magnetic = "Y"; //Siempre se usará Y, dado el caso de que no se sabe si el item tiene una banda magnética, esta siempre se desmagnetizará para que pueda realizarse el préstamo
				$desensitize = "Y";
				$AJ = $titulo_item;
				$AH = $fecha_devolucion;
				$CI = "Y";
				$respuesta = "12".$ok.$renewal.$magnetic.$desensitize.datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ".$AJ."|AH".$AH."|CI".$CI.AF_message("12_ok").AG_message($id_response);
				if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
				return $respuesta;
			}
			else
			{
				//existe algún problema con el préstamo, se pide al usuario que se dirija a la mesa de préstamos.
				$respuesta = "120NUN".datestamp().library_id()."|AA".$AA."|AB".$AB."|AJ|AH".AF_message("12_no_prestado").AG_message($id_response);
				if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
				return $respuesta;
				break;
			}						
		}
        break;
    case 10:
		//SC Chickin request
		//Example: 09N19980821    085721                  APCertification Terminal Location|AOCertification InstituteID|ABx12345|AC|BIN|AY2AZDBAE
		//Analizo el require de checkin
		$no_block = substr($request,2,1);
		$transaction_date = substr($request,3,18);
		$return_date = substr($request,21,18);
		//AP Current location
		$posicion_final = strpos($request,"|AO");
		$hasta = $posicion_final - 41;
		$AP = substr($request, 41, $hasta);
		//AB Item identifier
		$posicion = strpos($request,"|AB");
		$posicion = $posicion + 3;
		$posicion_final = strpos($request,"|AC");
		$AB = substr($request, $posicion, ($posicion_final - $posicion));
		$BI = "N";
		
		/*
		ACS Checkin response
		Example: 101YNN19980821 085721AOCertification Institute ID|ABCheckInBook|AQPermanent Location for CheckinBook, Language 1|AJTitle For CheckinBook|AAGoodPatron1|CK001|CHCheckinBookProperties|CLsort bin A1|AFScreen Message for CheckInBook|AGPrint Line for CheckInBook|AY2AZA3FF
		
				Field 				ID 				Format
				ok 									1-char, fixed-length required field: 0 or 1.
				resensitize 						1-char, fixed-length required field: Y or N.
				magnetic media 						1-char, fixed-length required field: Y or N or U.
				alert 								1-char, fixed-length required field: Y or N.
				transaction date 					18-char, fixed-length required field: YYYYMMDDZZZZHHMMSS
				institution id 		AO 				variable-length required field
				item identifier 	AB 				variable-length required field
				permanent location 	AQ 				variable-length required field
				title identifier 	AJ 				variable-length optional field
				sort bin 			CL 				variable-length optional field
				patron identifier 	AA 				variable-length optional field. ID of the patron who had the item checked out.
				media type 			CK 				3-char, fixed-length optional field
				item properties 	CH 				variable-length optional field
				screen message 		AF 				variable-length optional field
				print line 			AG 				variable-length optional field
				
				The OK, and Resensitize fields should be set according to the following rules:
					OK 			should be set to 1 if the ACS checked in the item.
								should be set to 0 if the ACS did not check in the item.
					Resensitize should be set to Y if the SC should resensitize the article.
								should be set to N if the SC should not resensitize the article.
		*/
		
		//Existe el item en la base de loanobjects?
		$existe_item = existe_item($AB);
		if ($existe_item == "error")
		{
			//error interno en la ejecución de la consulta.
			$respuesta = "100NUN".datestamp().library_id()."|AB".$AB."|AQ|AJ|AA".$AA.AF_message("12_no_base").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		elseif ($existe_item[0] == "false")
		{
			//no existe
			$respuesta = "100NUN".datestamp().library_id()."|AB".$AB."|AQ|AJ|AA".$AA.AF_message("12_no_item").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		elseif ($existe_item[0] == "true")
		{
			//si existe el item, recupero el tipo de item
			$tipo_item = $existe_item[1];
			$base_item = $existe_item[2];
			$num_control_item = $existe_item[3];
		}
		
		//Recupero datos del item (se busca en la base segun lo indicado en el campo v10 del item en loanobjects)
		$datos_item = recuperar_item($AB, $base_item, $num_control_item);
		if ($datos_item == "error")
		{
			//error interno en la ejecución de la consulta.
			$respuesta = "100NUN".datestamp().library_id()."|AB".$AB."|AQ|AJ|AA".$AA.AF_message("12_no_base").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		elseif ($datos_item[0] == "false")
		{
			//no existe el item
			$respuesta = "100NUN".datestamp().library_id()."|AB".$AB."|AQ|AJ|AA".$AA.AF_message("12_no_item").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
				{
					$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
					$respuesta = $respuesta.crc_message($respuesta);
				}
			return $respuesta;
			break;
		}
		elseif ($datos_item[0] == "true")
		{
			//si existe el item, recupero el tipo de item
			$posicion_interna = strpos($datos_item[1],"¬");
			$titulo_item = substr($datos_item[1],0,$posicion_interna);
			$longitud_total = strlen($datos_item[1]);
			$ubicacion_item = substr($datos_item[1],$posicion_interna + 2,$longitud_total);
		}
		$AJ = $titulo_item;
		$AQ = $ubicacion_item;

		//Devuelve dentro de la fecha límite?
		$fecha_devolucion = consultar_fecha_devolución ($AB);	
		if ($fecha_devolucion == "error")
		{
			//error en la busqueda
			$respuesta = "100NUN".datestamp().library_id()."|AB".$AB."|AQ".$AQ."|AJ".$AJ.AF_message("10_no_busqueda").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
			{
				$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
				$respuesta = $respuesta.crc_message($respuesta);
			}
			return $respuesta;
			break;
		}
		elseif ($fecha_devolucion == false)
		{
			//no está en la base de prestados
			$respuesta = "100NUN".datestamp().library_id()."|AB".$AB."|AQ".$AQ."|AJ".$AJ.AF_message("10_no_base").AG_message($id_response);
			if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
			{
				$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
				$respuesta = $respuesta.crc_message($respuesta);
			}
			return $respuesta;
			break;
		}
		elseif ($fecha_devolucion[0] == true)
		{
			//se encuentra en la base y se ha devuelto la fecha y la hora
			$fecha_d = substr($fecha_devolucion[1],0,8);
			$hora_d = substr($fecha_devolucion[1],9,5);
			$am_pm = substr($fecha_devolucion[1],15,2);
			
			$fechadb = substr($fecha_d,0,4)."-".substr($fecha_d,4,2)."-".substr($fecha_d,6,2);
			$fecha_completa = $fechadb." ".$hora_d." ".$am_pm;
			$segundos=strtotime($fecha_completa) - strtotime(date('Y-m-d g:m:s a'));
			$diferencia_dias=intval($segundos/60/60/24);
			
			//recupero id de usuario
			$usuario_prestamo = leer_usuario_item($AB);
			$AA = $usuario_prestamo[1];

			if((int)$segundos < 0)
			{
				//produce multa.
				$AF_message = AF_message("10_ok_multa");
				
				//procesar la multa en la base!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			}
			else
			{
				$AF_message = AF_message("10_ok");
			}
		}
		
		//Guardado de la devolución en la base.
		$resultado_guardar_devolucion = guardar_devolucion($AA, $AB);
				
		$ok = "1";
		$resensitize = "Y";
		$magnetic_media = "Y"; //tipo de medio magnético?
		$alert = "N"; //artículo especial???
		$respuesta = "10";
		$respuesta = "10".$ok.$resensitize.$magnetic_media.$alert.datestamp().library_id()."|AB".$AB."|AQ".$AQ."|AJ".$AJ."|AA".$AA.$AF_message.AG_message($id_response);
		if ($crc_enabled === "Y") //está habilitada las comprobaciones CRC
		{
			$respuesta = $respuesta.identificar_AY_sc($id_response, $request)."AZ";
			$respuesta = $respuesta.crc_message($respuesta);
		}
		return $respuesta;
        break;
    case 98:
		//9900401.00AY1AZFCA5
		//Analizo el SC Status Request
		$sc_online = substr($request,2,1);
		$sc_characters = substr($request,3,3);
		$sc_version = substr($request,6,4);
		/*
			Se debe realizar el tratamiento de los streams del sc cuando este solamente
			soporta v1.00, este desarrollo contempla que los SC usan la v2.00 de SIP.
			Para el estado 0 de SC no se realiza nada, el SC está en linea. 
			Para el estado
			2 tampoco, ya que está por apagarse, en este caso socket_Server.php lo sacará
			del array de conexiones. Solamente se deberá controlar el estado 1:
		*/
		if ($sc_online == "1")
		{
			//Ejecución de acción. Impresora sin papel! Se puede realizar envío de correo al administrador.
		}
		
		//98YYYNYN01000319960214 1447001.00AOID_21|AMCentralLibrary|ANtty30|AFScreenMessage|AGPrintMessage|AY1AZDA74
		//ACS Status Response
		$respuesta = "98";
		$respuesta = $respuesta.server_online().chickin_allowed().chickout_allowed().ACS_renewall().status_update().off_line();
		$respuesta = $respuesta.timeout_period_retries().datestamp().protocol_version().library_id().library_name().supported_messages();
		$respuesta = $respuesta.terminal_location().AF_message($id_response);
		if ($sc_characters != "000" and $sc_characters != "999")
		{
			//Avisamos al ACS la cantidad de caracteres que maneja la impresora en SC si es mayor a 0, 999 es indefinido
			$cantidad_caracteres = print_line($sc_characters);
			$respuesta = $respuesta.$cantidad_caracteres;
			//se debe controlar la cantidad de caracteres enviados por el SC de manera que los mensajes que superen esa cantidad se manden en múltiples fracciones AF dentro del mismo response.
		}
		else
		{
			$respuesta = $respuesta.print_line("");
		}
		if ($crc_enabled === "Y") //está habilitada las comprobaciones CRC
		{
			$respuesta = $respuesta.identificar_AY_sc($id_response, $request)."AZ";
			$respuesta = $respuesta.crc_message($respuesta);
		}
		return $respuesta;
        break;
    case 64:
		// SC Patron Information request
		// Ejemplo: 6300119980723    091905Y         AOInstitutionID|AAPatronID|BP00001|BQ00005|AY1AZEA83
		// Ejemplo: 6300120141205    120842          AO|AAx12345|AC|AD|AY1AZF39E
		$idioma = substr($request,2,3);
		$transaction_date = substr($request,5,18);
		$summary = substr($request,23,10);
		$posicion_AA = strpos($request,"|AA");
		$fin_posicion_AA = strpos($request,"|AC");
		if ($fin_posicion_AA == "")
		{
			$fin_posicion_AA = strpos($request,"|AD");
			if ($fin_posicion_AA == "")
			{
				$fin_posicion_AA = strpos($request,"|BP");
				if ($fin_posicion_AA == "")
				{
					$fin_posicion_AA = strpos($request,"|BQ");
					if ($fin_posicion_AA == "")
					{
						$AA = substr($request,$posicion_AA+3);
					}
					else
					{
						//existe BQ
						$AA = substr($request,$posicion_AA+3,$fin_posicion_AA);
					}
				}
				else
				{
					//existe BP
					$AA = substr($request,$posicion_AA+3,$fin_posicion_AA);
				}
			}
			else
			{
				//existe AD
				$AA = substr($request,$posicion_AA+3,$fin_posicion_AA);
			}
		}
		else
		{
			//axiste AC
			$AA = substr($request,$posicion_AA+3,$fin_posicion_AA);
		}
		$posicion_BP = strpos($request, "|BP");
		$posicion_BQ = strpos($request, "|BQ");
		if ($posicion_BP != "" and $posicion_BQ != "")
		{
			//pregunto si las posiciones BP y BQ no están vacias, caso contrario no se toman en cuenta
			$total_caracteres = strlen($request);
			$BP = substr($request, $posicion_BP+3, $posicion_BQ);
			$BQ = substr($request, $posicion_BQ);
		}
		
		/*
		ACS Patron Information Response
		Ejemplo: 64              00119980723 104009000100000002000100020000AOInstitutionID for PatronID|AAPatronID|AEPatronName|BZ0002|CA0003|CB0010|BLY|ASItemID1 for PatronID|AUChargeItem1|AUChargeItem2|BDHome Address|BEE Mail Address|BFHome Phone for PatronID|AFScreenMessage 0 for PatronID, Language 1|AFScreen Message 1 for PatronID, Language 1|AFScreen Message 2 for PatronID, Language 1|AGPrint Line 0 for PatronID, Language 1|AGPrint Line 1 for PatronID, Language 1|AGPrint Line 2 for PatronID, language 1|AY4AZ608F\r\n
		
				Field 						ID 		Format
				patron status 						14-char, fixed-length required field
				language 							3-char, fixed-length required field
				transaction date 					18-char, fixed-length required field: YYYYMMDDZZZZHHMMSS
				hold items count 					4-char, fixed-length required field
				overdue items count 				4-char, fixed-length required field
				charged items count 				4-char, fixed-length required field
				fine items count 					4-char, fixed-length required field
				recall items count 					4-char, fixed-length required field
				unavailable holds count 			4-char, fixed-length required field
				institution id 				AO 		variable-length required field
				patron identifier 			AA 		variable-length required field
				personal name 				AE 		variable-length required field
				hold items limit 			BZ 		4-char, fixed-length optional field
				overdue items limit 		CA		4-char, fixed-length optional field
				charged items limit 		CB 		4-char, fixed-length optional field
				valid patron 				BL 		1-char, optional field: Y or N
				valid patron password 		CQ		1-char, optional field: Y or N
				currency type 				BH		3-char fixed-length optional field
				fee amount 					BV 		variable-length optional field. The amount of fees owed by this patron.
				fee limit 					CC 		variable-length optional field. The fee limit amount.

					item: zero or more instances of one of the following, based on “summary” field of the Patron Information message:
				hold items 					AS 		variable-length optional field (this field should be sent for each hold item).
				overdue items 				AT 		variable-length optional field (this field should be sent for each overdue item).
				charged items 				AU 		variable-length optional field (this field should be sent for each charged item).
				fine items 					AV		variable-length optional field (this field should be sent for each fine item).
				recall items 				BU		variable-length optional field (this field should be sent for each recall item).
				unavailable hold items 		CD 		variable-length optional field (this field should be sent for each unavailable hold item).
				home address 				BD 		variable-length optional field
				e-mail address 				BE 		variable-length optional field
				home phone number 			BF 		variable-length optional field
				screen message 				AF 		variable-length optional field
				print line 					AG 		variable-length optional field
		*/
		$respuesta = "64              00119980723 104009000100000002000100020000AOInstitutionID for PatronID|AA011|AEEgbert de Smet|BZ0002|CA0003|CB0010|BLY|ASItemID1 for PatronID|AUChargeItem1|AUChargeItem2|BDHome Address|BEE Mail Address|BFHome Phone for PatronID|AFScreenMessage 0 for PatronID, Language 1|AFScreen Message 1 for PatronID, Language 1|AFScreen Message 2 for PatronID, Language 1|AGPrint Line 0 for PatronID, Language 1|AGPrint Line 1 for PatronID, Language 1|AGPrint Line 2 for PatronID, language 1|AY4AZ6019";
		return $respuesta;
        break;
    case 36:
		//Análisis de reques End Session Patron
		//Ejemplo: 3519980723    094014AOCertification Institute ID|AAPatronID|AY3AZEBF2
		$posicion_intermedia = strpos($request, "|AA");
		$posicion_final = strpos($request, "|AC");
		if ($posicion_final == "")
		{
			$posicion_final = strpos($request, "|AD");
			if ($posicion_final == "")
			{
				$posicion_final = strpos($request, "|AY");
				if ($posicion_final == "")
				{
					$AA = substr($request, $posicion_intermedia+3);
				}
				else
				{
					$AA = substr($request, $posicion_intermedia+3, ($posicion_final - $posicion_intermedia)-3);
				}
			}
			else
			{
				$AA = substr($request, $posicion_intermedia+3, ($posicion_final - $posicion_intermedia)-3);
			}
		}
		else
		{
			$AA = substr($request, $posicion_intermedia+3, ($posicion_final - $posicion_intermedia)-3);
		}
		//Sección para eliminación de variables que sean necesarias, cerrado de sesión
		
		//Armado de End Session Response 
		//Ejemplo: 36Y19980723 110658AOInstitutionID for PatronID|AAPatronID|AFScreenMessage 0 for PatronID|AGPrint Line 0 for PatronID|AY5AZ970F
		 /*
				Field 				ID 		Format
				end session 				1-char, fixed-length required field: Y or N.
				transaction date 			18-char, fixed-length required field: YYYYMMDDZZZZHHMMSS
				institution id 		AO 		variable-length required field
				patron identifier 	AA 		variable-length required field.
				screen message 		AF 		variable-length optional field
				print line 			AG 		variable-length optional field
		 */
		
		$respuesta = "36Y".datestamp().library_id()."|AA".$AA.AF_message("36_ok")."|AG";
		if ($crc_enabled === "Y") //está habilitada las comprobaciones CRC
		{
			$respuesta = $respuesta.identificar_AY_sc($id_response, $request)."AZ";
			$respuesta = $respuesta.crc_message($respuesta);
		}
		return $respuesta;
        break;
    case 38:
		return array("38","FeePaidResponse",$mensaje_pedido);
        break;
    case 18:
		//Análisis de request Item Information
		//Ejemplo:1719980723 100000AOCertification Institute ID|ABItemBook|AY1AZEBEB
		$posicion_intermedia = strpos($request, "|AB");
		$posicion_final = strpos($request, "|AC");
		if ($posicion_final == "")
		{
			$posicion_final = strpos($request, "|AY");
			if ($posicion_final == "")
			{
				$AB = substr($request, $posicion_intermedia+3);
			}
			else
			{
				$AB = substr($request, $posicion_intermedia+3, ($posicion_final - $posicion_intermedia)-3);
			}
		}
		else
		{
			$AB = substr($request, $posicion_intermedia+3, ($posicion_final - $posicion_intermedia)-3);
		}
		//Estructura de la respuesta Item Information Response
		//Ejemplo: 1808000119980723 115615CF00000|ABItemBook|AJTitle For Item Book|CK003|AQPermanent Location for ItemBook, Language 1|APCurrent Location ItemBook|CHFree-form text with new item property|AY0AZC05B
		/*
				Field 				ID 		Format
				circulation status 			2-char, fixed-length required field (00 thru 99)
				security marker 			2-char, fixed-length required field (00 thru 99)
				fee type 					2-char, fixed-length required field Type of fee associated with checking out this item.
				transaction date 			18-char, fixed-length required field: YYYYMMDDZZZZHHMMSS
				hold queue length 	CF 		variable-length optional field
				due date 			AH 		variable-length optional field.
				recall date 		CJ		18-char, fixed-length optional field: YYYYMMDDZZZZHHMMSS
				hold pickup date 	CM 		18-char, fixed-length optional field: YYYYMMDDZZZZHHMMSS
				item identifier 	AB 		variable-length required field
				title identifier 	AJ 		variable-length required field
				owner 				BG 		variable-length optional field
				currency type 		BH 		3 char, fixed-length optional field
				fee amount 			BV 		variable-length optional field. The amount of the fee associated with this item.
				media type 			CK 		3-char, fixed-length optional field
				permanent location 	AQ 		variable-length optional field
				current location 	AP 		variable-length optional field
				item properties 	CH 		variable-length optional field
				screen message 		AF 		variable-length optional field
				print line 			AG 		variable-length optional field
		*/
		//No se programan CF, AH, CJ, CM, CK, AQ, CH

		//Estado de circulación del item
		$resultado_situacion = situacion_item($AB);	//se analiza la situación del item, se acopla a tabla 3M
		if ($resultado_situacion == "false")
		{
			$circulation_status = "01"; 			//situación desconocida, no existe el item en copias
		}
		elseif ($resultado_situacion[0] == "true")
		{
			if($resultado_situacion[1] == "0")
			{
				$circulation_status == "06";		//precatalogado
			}
			elseif($resultado_situacion[1] == "1")
			{
				$circulation_status == "08";		//verificado y etiquetado
			}
			elseif($resultado_situacion[1] == "3")
			{
				$circulation_status == "13";		//perdido
			}
			elseif($resultado_situacion[1] == "2")
			{
				//está en loanobjects, se procede a evaluar si está como préstado o disponible
				$item_data = existe_item ($AB);
				if ($item_data == false) $circulation_status = "01"; 			//situación desconocida, no existe el item en loanobjects
				else
				{
					$tipo_item = $item_data[1];
					$base_item = $item_data[2];
					$num_control_item = $item_data[3];
				}
				$item_prestado = leer_usuario_item($AB);
				if ($item_prestado[1] == "")
				{
					$circulation_status == "03";	//item disponible
				}
				else
				{
					$AA = $item_prestado[1];
					$circulation_status == "02";	//item disponible
				}
			}
		}
		
		//Tipo de seguridad y titulo del item
		if (($base_item != "") and ($num_control_item != ""))
		{
			$tipo_seguridad = recuperar_item_seguridad($AB, $base_item, $num_control_item);
			if ($tipo_seguridad == "error" or $tipo_seguridad == false) $security_marker = "00";
			elseif ($tipo_seguridad[0] == "true") $security_marker = $tipo_seguridad[1];
			
			$respuesta_titulo = recuperar_item($AB, $base_item, $num_control_item);
			if ($respuesta_titulo == "error" or $respuesta_titulo == false) $AJ = "";
			elseif ($respuesta_titulo[0] == "true")
			{
				$posicion_interna = strpos($respuesta_titulo[1],"¬");
				$AJ = substr($respuesta_titulo[1],0,$posicion_interna);
				$AP = substr($respuesta_titulo[1],$posicion_interna+1);
			}
		}
		else
		{
			$security_marker = "00";
			$AJ = "";
			$AP = "";
		}
		
		//El item tiene multa?
		//En este punto, la base de loanobjects no almacena el id de un item al cual se le relaciona una multa, no se puede determinar.
		$fee_type = "01";
		
		//Institucion a la que pertenece el item
		$BG = library_id_bg();
		
		$respuesta = "18".$circulation_status.$security_marker.$fee_type.datestamp()."|AB".$AB."|AJ".$AJ.$BG."|AP".$AP.AF_message("18_ok").AG_message($id_response);
		if ($crc_enabled === "Y") //está habilitada las comprobaciones CRC
		{
			$respuesta = $respuesta.identificar_AY_sc($id_response, $request)."AZ";
			$respuesta = $respuesta.crc_message($respuesta);
		}
		return $respuesta;
        break;
    case 20:
		//Análisis de request Item Status Update
		$posicion_intermedia = strpos($request, "|AB");
		$posicion_final = strpos($request, "|AC");
		if ($posicion_final == "")
		{
			$posicion_final = strpos($request, "|CH");
			if ($posicion_final == "")
			{
				$posicion_final = strpos($request, "|AY");
				if ($posicion_final == "")
				{
					$AB = substr($request, $posicion_intermedia+3);
				}
				else
				{
					$AB = substr($request, $posicion_intermedia+3, ($posicion_final - $posicion_intermedia)-3);
				}
			}
			else
			{
				$AB = substr($request, $posicion_intermedia+3, ($posicion_final - $posicion_intermedia)-3);
				$posicion_intermedia = strpos($request, "|CH");
				$posicion_final = strpos($request, "|AY");
				if ($posicion_final == "")
				{
					$CH = substr($request, $posicion_intermedia+3);
				}
				else
				{
					$CH = substr($request, $posicion_intermedia+3, ($posicion_final - $posicion_intermedia)-3);
				}
			}
		}
		else
		{
			$AB = substr($request, $posicion_intermedia+3, ($posicion_final - $posicion_intermedia)-3);
		}
		if (($AB != "") and ($CH != ""))
		{
			//BLOQUE DE PROGRAMACIÓN DONDE SE PUEDE ADICIONAR LA GESTION DE INFORMACIÓN QUE VIENE DE LA VARIABLE $CH DENTRO DEL ITEM $AB
			$item_properties_ok = "1";
			$datos_item = existe_item ($AB);
			$un_item = recuperar_item($AB, $datos_item[2], $datos_item[3]);
			$posicion_interna = strpos($un_item[1],"¬");
			$AJ = substr($un_item[1],0,$posicion_interna);
		}
		else
		{
			$item_properties_ok = "0";
		}
		
		//Estructurado de Item Status Update Response	
		/*
				Field 				ID 		Format
				transaction date 			18-char, fixed-length required field: YYYYMMDDZZZZHHMMSS
				institution id 		AO 		variable-length required field
				item identifier 	AB 		variable-length required field
				terminal password 	AC 		variable-length optional field
				item properties 	CH 		variable-length required field
		*/
		$respuesta = "20".$item_properties_ok.datestamp()."AB".$AB."|AJ".$AJ."|CH".$CH;
		if ($crc_enabled === "Y") //está habilitada las comprobaciones CRC
		{
			$respuesta = $respuesta.identificar_AY_sc($id_response, $request)."AZ";
			$respuesta = $respuesta.crc_message($respuesta);
		}
		return $respuesta;
        break;
    case 26:
		//preguntamos si el sistema está habilitado para aceptar mensajes 25
		$habilitado = habilitado_message_25();
		if ($habilitado == true)
		{
			//procedemos a analizar el request Patron Enable
			//Ejemplo: 2519980723    094240AOCertification Institute ID|AA011|AY4AZEE60
			$posicion_intermedia = strpos($request, "|AA");
			$posicion_final = strpos($request, "|AC");
			if ($posicion_final == "")
			{
				$posicion_final = strpos($request, "|AD");
				if ($posicion_final == "")
				{
					$posicion_final = strpos($request, "|AY");
					if ($posicion_final == "")
					{
						$AA = substr($request, $posicion_intermedia+3);
					}
					else
					{
						$AA = substr($request, $posicion_intermedia+3, ($posicion_final - $posicion_intermedia)-3);
					}
				}
				else
				{
					$AA = substr($request, $posicion_intermedia+3, ($posicion_final - $posicion_intermedia)-3);
				}
			}
			else
			{
				$AA = substr($request, $posicion_intermedia+3, ($posicion_final - $posicion_intermedia)-3);
			}
			
			//Estrucutación de la respuesta Patron Enable
			//Ejemplo: 26              00119980723 111413AOInstitutionID for PatronID|AAPatronID|AEPatronName|BLY|AFScreenMessage 0 for PatronID, Language 1|AFScreen Message 1 for PatronID, Language 1|AGPrint Line 0 for PatronID, Language 1|AY7AZ8EA6
			/*
				Field 					ID 		Format
				patron status 					14-char, fixed-length required field
				language 						3-char, fixed-length required field
				transaction date 				18-char, fixed-length required field: YYYYMMDDZZZZHHMMSS
				institution id 			AO 		variable-length required field
				patron identifier 		AA		variable-length required field
				personal name 			AE 		variable-length required field
				valid patron 			BL 		1-char, optional field: Y or N.
				valid patron password 	CQ 		1-char, optional field: Y or N
				screen message 			AF		variable-length optional field
				print line 				AG 		variable-length optional field
			*/
			
			//El usuario tiene un bloqueo activo?
			$usuario_bloqueado = buscar_usuario_bloqueado($AA, "02SC");
			$AE = nombre_usuario($AA);
			if ($usuario_bloqueado == "error" or $usuario_bloqueado == false)
			{
				//usuario no está suspendido, envío de mensaje con negación de habilitacion de usuario
				$respuesta = "26              ".sip_lenguage().datestamp().library_id()."|AA".$AA."|AE".$AE."|BLN".AF_message("26_no_base");
			}
			elseif ($usuario_bloqueado[0] == "true")
			{
				//usuario si está suspendido, mandamos a quitar suspencion activa
				desbloquear_usuario_bloqueado($AA);
				$respuesta = "26              ".sip_lenguage().datestamp().library_id()."|AA".$AA."|AE".$AE."|BLY".AF_message("26_ok");
			}
		}
		else
		{
			//se deniega el procedimiento, se envía response 26 indicando que no se ha llevado a cabo la tarea.
			$respuesta = "26              ".sip_lenguage().datestamp().library_id()."|AA".$AA."|AE".$AE."|BLN".AF_message("26_no");
		}
		if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
		{
			$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
			$respuesta = $respuesta.crc_message($respuesta);
		}
		return $respuesta;
        break;
    case 16:
		return array("16","HoldResponse",$mensaje_pedido);
        break;
    case 30:
		return array("30","RenewResponse",$mensaje_pedido);
        break;
    case 66:
		return array("66","RenewAllResponse",$mensaje_pedido);
        break;
    case "02":
		//Análisis de Bloack Patron Request
		//Ejemplo: 01N19960213 162352AO|ALCARD BLOCK TEST|AA104000000705|AC|AY2AZF08F
		$card_retained = substr($request,2,1);
		$transaction_date = substr($request,3,18);
		
		$posicion_intermedia = strpos($request,"|AL");
		$posicion_final = strpos($request,"|AA");
		$AL = substr($request,$posicion_intermedia+3,($posicion_final - $posicion_intermedia)-3);
		
		$posicion_intermedia = strpos($request,"|AA");
		$posicion_final = strpos($request,"|AC");
		$AA = substr($request,$posicion_intermedia+3,($posicion_final - $posicion_intermedia)-3);
		
		//Se procede a bloquear el usuario en la base de datos de multas adicionando la nota de la posicion $AL en los comentarios de la base.
		//Patron Status Response
		//Ejemplo: 24    Y         00119960212 100239AO|AA104000000105|AEJohn Doe|AFScreen Message|AGCheck Printmessage|AY2AZA262
		$resultado_usuario_bloqueado = buscar_usuario_bloqueado($AA, "02SC");
		if ($card_retained == "Y" and $resultado_usuario_bloqueado == false)
		{
			//usuario no tiene el bloqueo activo en la base
			bloquear_usuario($AA, $AL, "02SC");
			$AE = "|AE".nombre_usuario($AA);
			$respuesta = "24    Y         ";
			$respuesta .= datestamp().library_id()."|AA".$AA.$AE.AF_message("02_block")."|AG";
		}
		elseif ($resultado_usuario_bloqueado != "")
		{
			//usuario ya tiene el bloqueo activo en la base
			$AE = "|AE".nombre_usuario($AA);
			$respuesta = "24    Y         ";
			$respuesta .= datestamp().library_id()."|AA".$AA.$AE.AF_message("02_block")."|AG";
		}
		else
		{
			//NO SE DARÄ EL CASO, PERO SI SE DA, SE ENVIAR PATRON STATUS RESPONSE LITE
			$AE = "|AE".nombre_usuario($AA);
			$respuesta = "24              ";
			$respuesta .= datestamp().library_id()."|AA".$AA.$AE."|AF"."|AG";
		}
		if ($crc_enabled == "Y") //está habilitada las comprobaciones CRC
		{
			$respuesta = $respuesta.identificar_AY_sc($id_response, $request);
			$respuesta = $respuesta.crc_message($respuesta);
		}
		return $respuesta;
		break;
    case 96:
        break;
}
?>

