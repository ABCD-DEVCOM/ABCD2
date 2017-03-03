<?php 
function send($to, $subject, $body) {
	 //$destinatario = "gsignorele@gmail.com"; 
	 //$asunto = "Este mensaje es de prueba"; 
	 /*$cuerpo = ' 
	 <html> 
	 <head> 
	    <title>Prueba de correo</title> 
	 </head> 
	 <body> 
	 <h1>Hola amigos!</h1> 
	 <p> 
	 <b>Bienvenidos a mi correo electróo de prueba</b>. Estoy encantado de tener tantos lectores. Este cuerpo del mensaje es del artílo de envíde mails por PHP. Habríque cambiarlo para poner tu propio cuerpo. Por cierto, cambia tambiélas cabeceras del mensaje. 
	 </p> 
	 </body> 
	 </html> 
	 ';
	 */ 
	 
	 //para el envíen formato HTML 
	 $headers = "MIME-Version: 1.0\r\n"; 
	 $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
	 //direccion del remitente 
	 $headers .= "From: Biblioteca ODON <respuestas@bvsodon.org.uy>\r\n";  

	 //direccion respuesta, si queremos que sea distinta que la del remitente 
	 //$headers .= "Reply-To: respuestas@bvsodon.org.uy\r\n"; 

	 //ruta del mensaje desde origen a destino 
	 //$headers .= "Return-path: spinaker@adinet.com.uy\r\n"; 

	 //direcciones que reciben la copia 
	 //$headers .= "Cc: diego@montevideo.com.uy\r\n"; 

	 //direcciones que recibiran copia oculta 
	 //$headers .= "Bcc: dmuses@gmail.com, dmuses@hotmail.com\r\n"; 

	 mail($to, $subject, $body, $headers); 
	}
 ?> 
