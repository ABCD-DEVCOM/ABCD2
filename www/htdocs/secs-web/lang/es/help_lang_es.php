<?php
/**
 * @file:			language_es.php
 * @desc:		    Spanish language file, here are only the Help of filling the forms
 * @author:			Ana Katia Camilo <katia.camilo@bireme.org>
 * @author:			Bruno Neofiti <bruno.neofiti@bireme.org>
 * @author:			Domingos Teruel <domingos.teruel@bireme.org>
 * @since:          2009-05-07
 * @copyright:      (c) 2008 Bireme - PFI
 * @translator:		Monica S. Ugobono <mugobo@mecon.gov.ar>
 * @translator:		Aldo G. Agunin <aldo@flacso.org.ar>
 * @revision:		2009-05-20
 ******************************************************************************/

/****************** Information for translators *************************
 *
 * This Help file is divided in Sections as follows: Mask, Issues, Users, TitlePlus and Title
 * Above each variable there is a comment indicating the field tag of the corresponding ISIS database.
 * The help messages are presented in the same order as the fields appear in the sections of the SeCS-Web interface.
 * The variable names are constructed as follows: All start with the declaration $BVS_LANG followed by a label in square brackets,
 * starting with 'help' or 'helper' and the descriptive field name.
 * After this comes an equal sign and the help message text content in double quotes with a semicolon at the end.
 * Variable names are case sensitive.
 *
 * Example:    $BVS_LANG["helpFullname"] = "Enter user&#180;s full name";
 *
 * To make a new language version, edit the text found between the double quotes.

 * In the help text use the <br /> tag to jump lines.
 * Example:
 * $BVS_LANG["helpersectionPart"] = "Alphabetical or numerical designation of section or part, which completes the Title proper and depends on it for identification or understanding.<br />
 * Enter the term Series, Section, Part or equivalent only if it is part of title proper.<br />
 * Capitalise first letter of significant term.<br />
 * Examples:<br />
 * a) Serial Title: Bulletin signaletique<br />
 * Section/part: Section 330<br />
 * b) Serial Title: Acta pathologica et microbiologica scandinavica<br />
 * Section/part: Section A";
 */

	/****************************************************************************************************/
	/**************************************** Mask Section - Field Helps ****************************************/
	/****************************************************************************************************/

//El dato no se graba
$BVS_LANG["helpBasedMask"] = "Crea una nueva plantilla basada en la planilla seleccionada s&#225;&#243;lo para facilitar el registro.<br />
Este dato no es guardado en la base de datos";

//field v801
$BVS_LANG["helpMaskName"] = "En este campo se registra el nombre de la plantilla.<br />
Para adoptar el mismo patr&#243;n de nombres utilizado por las plantillas ya creadas (recomendaciones del Taller Registro de Publicaciones Peri&#243;dicas, realizado en BIREME en septiembre de 1989), seguir las siguientes indicaciones:<br />
El nombre de la plantilla se forma con el c&#243;digo de frecuencia asignado por el ISDS, m&#225;s la cantidad de vol&#250;menes y/o n&#250;meros de un a&#241;o considerado como t&#237;pico de publicaci&#243;n.<br />
Utilice la letra M para identificar vol&#250;menes/n&#250;meros representados por el nombre de los meses, despu&#233;s del volumen/n&#250;mero.<br />
El s&#237;mbolo + se utiliz&#243; para identificar los n&#250;meros o vol&#250;menes con numeraci&#243;n creciente de 1 a infinito.<br />
Ejemplo:<br />
 M1V12F<br />
 Frecuencia Mensual, 1 volumen por a&#241;o con 12 n&#250;meros por volumen<br />
 Q4FM<br />
 Frecuencia trimestral, cuatro n&#250;meros representados por meses, sin numeraci&#243;n de vol&#250;menes<br />
 B6F+<br />
 Frecuencia bimestral, seis n&#250;meros con numeraci&#243;n creciente, sin numeraci&#243;n de vol&#250;menes";

//field v900
$BVS_LANG["helpNotesMask"] = "Registre en este campo, en lenguaje natural, informaciones que aclaren el contenido de la plantilla, tales como: frecuencia, cantidad de vol&#250;menes al a&#241;o, cantidad de n&#250;meros por volumen, etc.<br />
Ejemplo:<br />
Bimestral: 2 vol&#250;menes al a&#241;o con 3 n&#250;meros por volumen.";

//field v860
$BVS_LANG["helpVolume"] = "El registro de este campo est&#225; condicionado a la existencia de vol&#250;menes en la plantilla creada.<br />
La secuencia de los vol&#250;menes es un c&#243;digo utilizado para indicar al Sistema si la numeraci&#243;n de los vol&#250;menes es creciente (Infinito) o se repite (Finito) para cada a&#241;o.<br />
Para el registro de este campo es necesario observar si la numeraci&#243;n de los vol&#250;menes de una publicaci&#243;n peri&#243;dica cambia para cada a&#241;o de edici&#243;n o si permanece igual para cada a&#241;o.<br />
Ejemplo:<br />
Una publicaci&#243;n con frecuencia trimestral publica 2 vol&#250;menes por a&#241;o y la numeraci&#243;n de los vol&#250;menes cambia para cada a&#241;o:<br />
<br />
Volumen<br />
 1<br />
 1<br />
 2<br />
 2<br />
Secuencia de vol&#250;menes: Infinito";

//field v880
$BVS_LANG["helpNumber"] = "El registro de este campo est&#225; condicionado a la existencia de n&#250;meros en la plantilla creada.<br />
C&#243;digo que identifica a la secuencia de los n&#250;meros, utilizado para indicar al Sistema si la designaci&#243;n num&#233;rica de las entregas es creciente (Infinito) o se repite (Finito) en cada volumen del a&#241;o.<br />
Para registrar este campo es necesario observar si la numeraci&#243;n de las entregas de una publicaci&#243;n peri&#243;dica es creciente o si es igual para cada volumen del a&#241;o.<br />
Ejemplo:<br />
Una publicaci&#243;n de frecuencia trimestral: 1 volumen al a&#241;o con 4 n&#250;meros cada volumen y la numeraci&#243;n de entregas es igual para cada a&#241;o:<br />
 N&#250;mero<br />
  1<br />
  2<br />
  3<br />
  4<br />
 Secuencia de n&#250;meros: Finito";



	/****************************************************************************************************/
	/**************************************** Issues Section - Field Helps ****************************************/
	/****************************************************************************************************/

//field v911
$BVS_LANG["helpFacicYear"] = "A&#241;o de publicaci&#243;n del fasc&#237;culo que se est&#225; ingresando.<br />
Ingrese el a&#241;o correspondiente en n&#250;meros ar&#225;bigos.<br />
Ingrese per&#237;odos de dos o m&#225;s a&#241;os correspondientes al mismo volumen, separados por barra (/). El &#250;ltimo a&#241;o correspondiente al per&#237;odo debe ingresarse s&#243;lo con los dos &#250;ltimos d&#237;gitos.<br />
En el caso de publicaciones suspendidas por un per&#237;odo de dos a&#241;os o m&#225;s, ingrese el primer a&#241;o del per&#237;odo seguido por una barra (/) y los d&#237;gitos finales del &#250;ltimo a&#241;o de suspensi&#243;n. En este caso, el campo de ESTADO DE LA PUBLICACION debe completarse con la letra I, indicando que la publicaci&#243;n fue suspendida en ese per&#237;odo.<br />
<br />
Ejemplos:<br />
a) A&#209;O<br />
   1981/82<br />
<br />
b) A&#209;O         ESTADO DE LA PUBLICACION<br />
   1982/84          I <br />";

//field v912
$BVS_LANG["helperDonorNotes"] = "N&#250;mero y/o letras que identifican el volumen correpondiente al fasc&#237;culo que se est&#225; describiendo.<br />
Ingrese la identificaci&#243;n del volumen en n&#250;meros ar&#225;bigos. Si hay letras incluidas en la identificaci&#243;n tambi&#233;n deben ingresarse.<br />
Cuando dos o m&#225;s vol&#250;menes son publicados juntos en el mismo volumen encuadernado, ingrese el primer volumen separado del siguiente por una barra (/).<br />
Los vol&#250;menes no publicados por el editor en un determinado a&#241;o deben registrarse y el campo ESTADO DE LA PUBLICACION debe contener la letra N indicando que el volumen no fue publicado.<br />
<br />
Advertencia:<br />
La informaci&#243;n respecto de vol&#250;menes no publicados debe ingresarse s&#243;lo si est&#225; confirmada por el editor.<br />
<br />
Ejemplos:<br />
a) VOLUMEN<br />
    123<br />
<br />
b) VOLUMEN<br />
    123A<br />
<br />
c) VOLUMEN<br />
    1/2<br />
<br />
d) VOLUMEN<br />
    5/7<br />
<br />
e) A&#209;O   VOLUMEN    ESTADO DE LA PUBLICACION<br />
   1981      1                     P<br />
   1982      2                     N<br />
   1983      3                     P <br />";

//field v913
$BVS_LANG["helpFacicName"] = "N&#250;mero y/o letra que identifican al fasc&#237;culo que se est&#225; ingresando.<br />
Ingrese el n&#250;mero correspondiente al fasc&#237;culo en n&#250;meros ar&#225;bigos. Si hay letras incluidas en la identificaci&#243;n tambi&#233;n deben ingresarse.<br />
Los &#237;ndices acumulativos deben ingresarse con los a&#241;os que cubren en el campo A&#209;O y los correspondientes vol&#250;menes en el campo VOLUMEN.<br />
Para fasc&#237;culos que incluyen dos o m&#225;s n&#250;meros en la misma encuadernaci&#243;n, ingrese el primero separado del &#250;ltimo por una barra (/).<br />
Los fasc&#237;culos que no han sido publicados, se deben ingresar en el campo ESTADO DE LA PUBLICACION colocando la letra N, lo cual significa que el fasc&#237;culo no fue publicado.<br />
Ingrese los fasc&#237;culos identificados por meses en el idioma correspondiente.
<br />
Ejemplos:<br />
a) FASCICULO<br />
     1<br />";

//field v910
$BVS_LANG["helpFacicMask"] = "Plantillas usadas en la frecuencia de fasc&#237;culos. <br />
<br />
Ejemplo: M1V12F";

//field v916
$BVS_LANG["helpFacicPubType"] = "Informaci&#243;n complementaria sobre el fasc&#237;culo ingresado, como: n&#250;mero especial, n&#250;mero conmemorativo, suplemento, fasc&#237;culo con subdivisiones, usando las convenciones siguientes:<br />
<br />
S    - suplementos<br />
P    - fasc&#237;culos con subdivisiones o partes<br />
NE   - n&#250;mero especial, conmemorativo, o extra<br />
IN   - &#237;ndice<br />
AN   - anuario<br />
<br />
Si estos fasc&#237;culos no est&#225;n numerados, ingrese s&#243;lo el c&#243;digo correspondiente.<br />
<br />
Ejemplos:<br />
<br />
a) S<br />
b) NE<br />";

//field v914
$BVS_LANG["helpPubEst"] = "Situaci&#243;n de los fasc&#237;culos dentro de la colecci&#243;n de la biblioteca.<br />
 Ingrese el estado del fasc&#237;culo de acuerdo con los siguientes c&#243;digos:<br />
 P    - fasc&#237;culo presente en la colecci&#243;n<br />
 A    - fasc&#237;culo ausente en la colecci&#243;n<br />
 N    - vol&#250;menes o fasc&#237;culos no publicados durante un determinado a&#241;o<br />
 I    - publicaciones interrumpidas durante un determinado per&#237;odo<br />
 <br />
Ejemplos:<br />
a)<br />
A&#209;O    VOLUMEN    FASCICULO   P/A<br />
1981      1           1       P<br />
1981      1           2       A<br />
1981      1           3       P<br />
<br />
b)<br />
A&#209;O    VOLUMEN    FASCICULO   P/A<br />
1980      1           2        P<br />
1981      2           1        N<br />
1981      2           2        P<br />
1982/83                        I<br />
1984      3           1        P<br />";

//field v915
$BVS_LANG["helpQtd"] = "N&#250;mero de ejemplares (duplicados) correspondientes al fasc&#237;culo que se est&#225; ingresando.<br />
Ingrese el n&#250;mero total de ejemplares del fasc&#237;culo que se est&#225; ingresando.<br />
<br />
Ejemplos:<br />
a)<br />
A&#209;O    VOLUMEN    FASCICULO        P/A       EJEMPLARES<br />
1985      53          1             P         1<br />
1985      53          2             P         2<br />
1985      53          3             P         2<br />
1985      53          4             P         2<br />
Tipo de fasc&#237;culo o volumen - Campo<br />
<br />
Informaci&#243;n complementaria sobre el fasc&#237;culo que est&#225; ingresando, tal como: n&#250;mero especial, n&#250;mero conmemorativo, suplemento, fasc&#237;culo con subdivisiones, etc., usando los siguientes c&#243;digos:<br />
<br />
S    - para suplementos<br />
P    - para fasc&#237;culos con subdivisiones<br />
NE   - para n&#250;meros especiales, conmemorativos o extras<br />
IN   - para &#237;ndices<br />
AN   - para anuarios<br />
<br />
Si esa clase de fasc&#237;culos no son numerados, ingrese s&#243;lo el c&#243;digo correspondiente.<br />";

//field v925
$BVS_LANG["helptextualDesignation"] = "Designación textual y/o designación específica.";

//field v926
$BVS_LANG["helpstandardizedDate"] = "Fecha normalizada.";

//field v917
$BVS_LANG["helpInventoryNumber"] = "N&#250;mero patrimonial que identifica &#250;nicamente a cada objeto del acervo de la biblioteca.";

//field v918
$BVS_LANG["helpEAddress"] = "Direcci&#243;n (URL) del documento.";

//field v900
$BVS_LANG["helpFacicNote"] = "Informaci&#243;n sobre alg&#250;n aspecto del fasc&#237;culo que est&#225; ingresando.<br />
Ingrese en este campo, en lenguaje natural, informaci&#243;n sobre alg&#250;n aspecto del fasc&#237;culo que est&#225; ingresando.<br />
Ejemplo: Fasc&#237;culo muy da&#241;ado y no conveniente para fotocopias; otra copia fue solicitada.<br />";




	/****************************************************************************************************/
	/**************************************** Users Administration Section - Field Helps ****************************************/
	/****************************************************************************************************/

//field v1
$BVS_LANG["helpUser"] = "Nombre de usuario utilizado para ingresar a SeCS-Web.<br />
Ejemplos:<br />
a) admsecs<br />
b) docsecs";

//field v3
$BVS_LANG["helpPassword"] = "Contrase&#241;a usada para ingresar a SeCS-Web.<br />";

//data not record
$BVS_LANG["helpcPassword"] = "Repita la contrase&#241;a";

//field v4
$BVS_LANG["helpRole"] = "Opciones de perfil de usuario<br />
Ejemplos: Administrador, Editor, Documentalista";

//field v8
$BVS_LANG["helpFullname"] = "Nombre del usuario<br />
Ejemplo: Ernesto Luis Spinak";

//field v11
$BVS_LANG["helpEmail"] = "e-mail del usuario<br />
Ejemplo: ernesto.spinak@bireme.org ";

//field v9
$BVS_LANG["helpInstitution"] = "Nombre de la Instituci&#243;n<br />
Ejemplos: BIREME - OPAS/OMS - Centro Latino-Americano y del Caribe de Informaci&#243;n en Ciencias de la Salud";

//field v5
$BVS_LANG["helpCenterCod"] = "C&#243;digo del centro<br />
Ejemplo: BR1.1";

//field v10
$BVS_LANG["helpNotes"] = "Descripci&#243;n general sobre el usuario y/o campos<br />
Ejemplos: probando traducci&#243;n del ingl&#233;s<br />
        SeCS-Web standart editor user. Usuario editor standard de SeCS-Web<br />
        Nota usuario";

//field v12
$BVS_LANG["helpLang"] = "Opci&#243;n de perfil de la interface<br />
Ejemplos: Espa&#241;ol<br />
          Portugues";

//field v2
$BVS_LANG["helpUsersAcr"] = "Enter user initials or equivalente acronym<br />
Examples: ELS";


	/****************************************************************************************************/
	/**************************************** TitlePlus Section - Field Helps ****************************************/
	/****************************************************************************************************/

//field v901
$BVS_LANG["helperAcquisitionMethod"] = "Compra<br />
La realizar&#225; el Sector de Adquisiciones de la Biblioteca, asesorado por el Coordinador de la Biblioteca. <br />
<br />
[Para bibliotecas en Brasil: Para la compra de peri&#243;dicos, verificar la disponibilidad del t&#237;tulo en el Portal CAPES de Peri&#243;dicos. Es recomendable la no duplicaci&#243;n de suscripciones de peri&#243;dicos impresos] <br />
<br />
Donaci&#243;n<br />
Cualquier donaci&#243;n de materiales bibliogr&#225;ficos es aceptada por la Biblioteca, si el equipo t&#233;cnico la considera pertinente respecto del acervo y si est&#225; dentro de los criterios preestablecidos por la Biblioteca. Todas las donaciones deben ser dirigidas hacia la Secci&#243;n de Formaci&#243;n y Desarrollo de Colecciones. <br />
<br />
Canje<br />
El intercambio de publicaciones, realizado a trav&#233;s de un acuerdo bilateral es formalizado por solicitud, entre las instituciones interesadas en canjear sus publicaciones, con las publicaciones de otras Universidades.";

//field v902
$BVS_LANG["helperAcquisitionControl"] = "Indica&#231;&#227;o do status do peri&#243;dico:<br />
Selecione a op&#231;&#227;o que identifica o status atual do peri&#243;dico:<br />
N&#227;o se conhece<br />
Corrente<br />
N&#227;o corrente<br />
Encerrada<br />
Suspensa";

//field v906
$BVS_LANG["helperExpirationSubs"] = "El sistema informa autom&#225;ticamente el vencimento de la suscripci&#243;n.
El procedimiento de renovaci&#243;n de la suscripci&#243;n se realizar&#225; de acuerdo con las pol&#237;ticas de compra de la instituci&#243;n.<br />
Cuando la actualizaci&#243;n de la suscripci&#243;n se apruebe, la Biblioteca deber&#225; insertar la nueva fecha de vencimiento de la suscripci&#243;n en el sistema.";

//field v946
$BVS_LANG["helperacquisitionPriority"] = "C&#243;digo num&#233;rico que define la prioridad de la adquisici&#243;n de la publicaci&#243;n, en el centro.<br />
Campo de registro obligatorio para los centros que participan con sus colecciones del Registro de Publicaciones Peri&#243;dicas en Ciencias de la Salud - BIREME.<br />
Complete este campo, de esta manera:<br />
1 - Para t&#237;tulos cuya adquisici&#243;n es imprescindible en el centro informante.<br />
2 - Para t&#237;tulos cuya adquisici&#243;n es prescindible pues existe en el pa&#237;s.<br />
3 - Para t&#237;tulos cuya adquisici&#243;n es prescindible pues existe en la regi&#243;n.<br />
Para establecer las prioridades exigidas, consultar, si es necesario, al Comit&#233; de Bibliotecas, miembros de la comunidad acad&#233;mica y/o especialistas.<br />
Ejemplos:<br />
a) Prioridad de adquisici&#243;n: 1<br />
b) Prioridad de adquisici&#243;n: 3";

//field v911
$BVS_LANG["helperAdmNotes"] = "Registre en este campo, en forma libre, informaciones que sean de inter&#233;s para el centro responsable por la descripci&#243;n de la publicaci&#243;n.<br />
<br />
En caso de m&#225;s de una nota, reg&#237;strelas secuencialmente. <br />
<br />
Ejemplo: <br />
La suscripci&#243;n fue interrumpida en 2009";

//field v905
$BVS_LANG["helperProvider"] = "Nombre del proveedor comercial de la publicaci&#243;n. Si no se tiene una base de registro de proveedores, se recomienda registrar el tel&#233;fono, sitio de internet, y el correo electr&#243;nico de la persona de contacto.";

//field v904
$BVS_LANG["helperProviderNotes"] = "Registre neste campo informa&#231;&#245;es sobre o provedor<br />";

//field v903
$BVS_LANG["helperReceivedExchange"] = "Publicaci&#243;n que env&#237;a<br />
Informa la publicaci&#243;n";

//field v912
$BVS_LANG["helperDonorNotes"] = "Usa-se para casos de assinaturas com fundos de projetos, ou doa&#231;&#245;es com restri&#231;&#245;es especiais<br />
Registre as condi&#231;&#245;es sob as quais recebe este seriado em doa&#231;&#227;o<br />
Preenchimento obrigat&#243;rio se o m&#233;todo de aquisi&#231;&#227;o for doa&#231;&#227;o<br />
Exemplos: <br />
a) Pago com fundos de USAID para o projeto 2009_CL_Y35<br />
b) A cole&#231;&#227;o deve estar separada da cole&#231;&#227;o geral e indicar em cartaz o nome da funda&#231;&#227;o que a mant&#233;m<br />
c) Oferta de prova para o ano 2009 somente<br />";

//field v913
$BVS_LANG["helperAcquisitionHistory"] = "La información relativa a la firma histórica, la cantidad pagada por la firma, los detalles
fascículos que incluye la compra. Subcampos que componen
los datos de campo: <br/>
(D) Fecha de pago de la suscripción <br/>
(V) Cantidad pagada por la firma <br/>
(A) el año que incluye la firma <br/>
(F) las cuestiones que incluye la firma <br/>";//traduzir

$BVS_LANG["helperAcquisitionHistoryD"] = "Fecha de pago de la suscripción.";
$BVS_LANG["helperAcquisitionHistoryV"] = "Cantidad pagada por la firma.";
$BVS_LANG["helperAcquisitionHistoryA"] = "El año que incluye la firma.";
$BVS_LANG["helperAcquisitionHistoryF"] = "Las cuestiones que incluye la firma.";

//field v907
$BVS_LANG["helperLocationRoom"] = "Ubicaci&#243;n f&#237;sica de la publicaci&#243;n.<br />
Los documentos se guardan en cajas o carpetas y se almacenan en el mueble/estante respectivo, que tambi&#233;n deber&#225; ser identificado, facilitando su ubicaci&#243;n inmediata para la consulta y el pr&#233;stamo. <br />
<br />
El bibliotecario o los auxiliares verifican en el &#237;ndice/registro donde est&#225; localizada la publicaci&#243;n solicitada.<br />
<br />
Ejemplo: <br />
Nº<br />
T&#205;TULO<br />
SALA<br />
ESTANTERIA<br />
ANAQUEL<br />
CAJA/GAVETA/CARPETA<br />
008<br />
Revista de antropolog&#237;a<br />
Nº 01<br />
Nº03<br />
Nº03<br />
201";

//field v908
$BVS_LANG["helperEstMap"] = "El mapa es un instrumento gr&#225;fico elaborado con el objetivo de optimizar las actividades de recuperaci&#243;n y reposici&#243;n de las publicaciones en las estanter&#237;as.<br />
Por ejemplo un gr&#225;fico (.gif, .jpg) que presenta la planta con la ubicaci&#243;n f&#237;sica del mueble donde est&#225; la publicaci&#243;n.";

//field v909
$BVS_LANG["helperOwnClassif"] = "Notaci&#243;n de clasificaci&#243;n de materia de la publicaci&#243;n, de acuerdo con los sistemas de clasificaci&#243;n adoptados. <br />
Registre la notaci&#243;n de clasificaci&#243;n de acuerdo con el sistema adoptado. <br />
En caso de m&#225;s de una clasificaci&#243;n, reg&#237;strelas secuencialmente.";

//field v910
$BVS_LANG["helperOwnDesc"] = "T&#233;rminos normalizados utilizados para representar el tema principal de la publicaci&#243;n. <br />
Se registra el descriptor de acuerdo con el sistema adoptado. <br />
En caso de m&#225;s de un descriptor, reg&#237;strelos secuencialmente.";


	/****************************************************************************************************/
	/**************************************** Title Section - Field Helps ****************************************/
	/****************************************************************************************************/

/*
 * Because the big size of Title Form
 * The help as the own form is divide in 7 partes
 * the division is the same of the form
 */

	/**************************************** Step 1  ****************************************/

//field v30
$BVS_LANG["helperrecordIdentification"] = "Campo de registro automático.<br />
N&#250;mero secuencial asignado y controlado por el Sistema a fin de identificar el t&#237;tulo en la base de datos.<br />
Registre en este campo el n&#250;mero correspondiente al t&#237;tulo que se est&#225; describiendo.<br />
Este campo es utilizado por el sistema para hacer el enlace entre el registro del t&#237;tulo y los fasc&#237;culos correspondientes.<br />
Ejemplos:<br />
a) N&#250;mero de identificaci&#243;n: 1050<br />
b) N&#250;mero de identificaci&#243;n: 415";

//field v100
$BVS_LANG["helperpublicationTitle"] = "Campo de registro obligatorio.<br />
T&#237;tulo principal o propio de la publicaci&#243;n en el idioma y forma que aparece en la misma, incluyendo el t&#237;tulo alternativo si existiera, y excluyendo t&#237;tulos paralelos y otras informaciones sobre el t&#237;tulo.<br />
Registre el t&#237;tulo propio transcribiendo todos los elementos en el orden y tal como aparecen en la portada o la p&#225;gina que la sustituye, respetando las reglas ortogr&#225;ficas del idioma correspondiente.<br />
Consulte reglas b&#225;sicas para el registro en el Anexo y las normas ISBD consolidated edition 2007.<br />
<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Revista chilena de neurocirug&#237;a<br />
b) T&#237;tulo de la publicaci&#243;n: Revista brasileira de sa&#250;de ocupacional<br />
c) T&#237;tulo de la publicaci&#243;n: Pediatria (S&#227;o Paulo)<br />
d) T&#237;tulo de la publicaci&#243;n: Pediatr&#237;a (Bogot&#225;)<br />";

//field v140
$BVS_LANG["helpernameOfIssuingBody"] = "Entidad responsable por el contenido intelectual de la publicaci&#243;n.<br />
Registre la menci&#243;n de responsabilidad conforme aparece en la portada o la p&#225;gina que la sustituye. Normas b&#225;sicas para el registro de este campo, ver Anexo.<br />
Cuando una menci&#243;n de responsabilidad incluye una jerarqu&#237;a, se transcribe en la forma y orden en que aparece en la publicaci&#243;n separada por comas.<br />
Cuando una menci&#243;n de responsabilidad, en su forma desarrollada, es parte integrante del t&#237;tulo de la publicaci&#243;n (campo 100) no es necesario repetirla en este campo.<br />
Este campo es de registro obligatorio para peri&#243;dicas con t&#237;tulos representados por un t&#233;rmino gen&#233;rico, tales como Bolet&#237;n, Anuario, Revista etc., y sus correspondientes en otros idiomas.<br />
En caso de m&#225;s de una menci&#243;n de responsabilidad, reg&#237;strelas secuencialmente.<br />
Ejemplos:<br />
a) Menci&#243;n de responsabilidad: Academia Nacional de Medicina<br />
b) Menci&#243;n de responsabilidad: Sociedade Brasileira de Cardiologia";

//field v149
$BVS_LANG["helperkeyTitle"] = "T&#237;tulo clave.<br />
Designaci&#243;n un&#237;voca adjudicada a un recurso continuo por la Red ISSN e inseparable del respectivo ISSN. El t&#237;tulo clave puede coincidir con el t&#237;tulo propio o, para volverse un&#237;voco, estar formado por la adici&#243;n de elementos de identificaci&#243;n o calificaci&#243;n tales como: nombre de la entidad editora, lugar de publicaci&#243;n, menci&#243;n de edici&#243;n, etc. <br />
<br />
Ejemplo: ISSN 0340-0352 = IFLA journal<br />
              ISSN 0268-9707 = British Library Bibliographic Services newsletter<br />
              ISSN 0319-3012 = Image (Nicaraga ed.)";

//field v150
$BVS_LANG["helperabbreviatedTitle"] = "T&#237;tulo propio de la publicaci&#243;n en la forma abreviada.<br />
Registre el t&#237;tulo abreviado respetando las may&#250;sculas, min&#250;sculas y acentuaci&#243;n, de acuerdo con la lista establecida y mantenida por el Centro Internacional ISSN conforme con la norma ISO 4- &#34;Informaci&#243;n y Documentaci&#243;n - Normas para la abreviatura de palabras del t&#237;tulo y de los t&#237;tulos de publicaciones&#34;.<br />
<br />
Ejemplos:<br />
a)T&#237;tulo de la publicaci&#243;n: Revista brasileira de sa&#250;de ocupacional<br />
  T&#237;tulo abreviado: Rev. bras. sa&#250;de ocup<br />
b)T&#237;tulo de la publicaci&#243;n: Endeavour (Spanish ed.)<br />
  T&#237;tulo abreviado: Endeavour (Span. ed.)<br />
c)T&#237;tulo de la publicaci&#243;n: Pediatria (S&#227;o Paulo)<br />
  T&#237;tulo abreviado: Pediatria (S&#227;o Paulo)";


//field v180
$BVS_LANG["helperabbreviatedTitleMedline"] = "T&#237;tulo abreviado de otras Bases.<br />
<br />
T&#237;tulo propio de la publicaci&#243;n en forma abreviada. <br />
Observar que cada base de datos sigue una norma para la abreviatura. <br />
Este campo es de registro obligatorio para los t&#237;tulos que son indizados en LILACS y/o MEDLINE. <br />
<br />
Ejemplo: REVISTA BRASILEIRA DE ENTOMOLOGIA<br />
<br />
ISO^aRev. Bras. Entomol. <br />
JCR^aREV BRAS ENTOMOL<br />
MDL^aRev Bras Entomol<br />
LL^aRev. bras. entomol. <br />
LATINDEX^aRev. Bras. Entomol. (Impr.) <br />
SciELO^aRev. Bras. entomol. <br />";


	/**************************************** Step 2  ****************************************/

//field v110
$BVS_LANG["helpersubtitle"] = "Cualquier informaci&#243;n subordinada al t&#237;tulo principal que lo completa, califica o lo hace m&#225;s expl&#237;cito.<br />
Registre, en este campo, solamente informaciones definidas como subt&#237;tulo y cuando el subt&#237;tulo sea valioso para la identificaci&#243;n de la publicaci&#243;n. Las variaciones del t&#237;tulo deben ser registradas en campos espec&#237;ficos.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: MMWR<br />
Subt&#237;tulo: morbidity and mortality weekly report";

//field v120
$BVS_LANG["helpersectionPart"] = "Designaci&#243;n num&#233;rica o alfab&#233;tica de secci&#243;n, parte, etc., que completa el t&#237;tulo propio y que depende de &#233;l para su identificaci&#243;n y comprensi&#243;n.<br />
Registre las palabras serie, secci&#243;n u otra equivalente solamente cuando forman parte del t&#237;tulo.<br />
La primera letra de la palabra significativa debe ser registrada en may&#250;scula.<br />
Ejemplos:
<br />a) T&#237;tulo de la publicaci&#243;n: Bulletin signaletique<br />
Secci&#243;n/parte: Section 330<br />
b) T&#237;tulo de la publicaci&#243;n: Acta pathologica et microbiologica scandinavica<br />
Secci&#243;n/parte: Section A";

//field v130
$BVS_LANG["helpertitleOfSectionPart"] = "Nombre de la secci&#243;n, parte o suplemento que completa y depende del t&#237;tulo propio para su identificaci&#243;n y comprensi&#243;n.<br />
Registre en este campo el nombre de la secci&#243;n, parte o suplemento transcribi&#233;ndolo como aparece en la portada o la p&#225;gina que la sustituye, registrando en may&#250;scula la primera letra.<br />
En caso de suplementos con t&#237;tulos id&#233;nticos al t&#237;tulo principal y que constituyen un nuevo t&#237;tulo, registre en este campo la palabra Suplemento para distinguir un t&#237;tulo de otro.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Acta amazonica<br />
T&#237;tulo secci&#243;n/parte: Suplemento<br />
b) T&#237;tulo de la publicaci&#243;n: Bulletin signaletique<br />
Secci&#243;n/parte: Section 330<br />
T&#237;tulo secci&#243;n/parte: Sciences pharmacologiques";

//field v230
$BVS_LANG["helperparallelTitle"] = "T&#237;tulo propio de la publicaci&#243;n que aparece tambi&#233;n en otros idiomas en la portada o la p&#225;gina que la sustituye.<br />
Registre t&#237;tulos paralelos seg&#250;n la secuencia y tipograf&#237;a con que aparecen en la portada o parte que la sustituye de acuerdo con ISBD – consolidated edition 2007.<br />
En caso de m&#225;s de un t&#237;tulo paralelo, reg&#237;strelos secuencialmente.<br />
Si la publicaci&#243;n posee t&#237;tulos paralelos que incluyen secci&#243;n, parte o suplemento en otros idiomas, registre en orden separando los elementos (t&#237;tulo com&#250;n y t&#237;tulo de la secci&#243;n, parte o suplemento) por punto.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Archives of toxicology<br />
T&#237;tulo paralelo: Archiv fur toxikologie<br />
b) T&#237;tulo de la publicaci&#243;n: Arzneimittel forschung<br />
T&#237;tulo paralelo: Drug research";

//field v240
$BVS_LANG["helperotherTitle"] = "Otras variaciones del t&#237;tulo propio que aparecen en la publicaci&#243;n tales como: t&#237;tulo de la tapa cuando es diferente de la portada, t&#237;tulo por extenso y otras formas del t&#237;tulo.<br />
Incluya aqu&#237; variaciones (menores) del t&#237;tulo propio que no necesitan considerarse como un nuevo registro, pero que se justifican para su recuperaci&#243;n.<br />
En caso de m&#225;s de una variaci&#243;n, reg&#237;strelas secuencialmente.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Bolet&#237;n de la Academia Nacional de Medicina de Buenos Aires<br />
   Otras formas del t&#237;tulo: Bolet&#237;n de la Academia de Medicina de Buenos Aires<br />
b) T&#237;tulo de la publicaci&#243;n: Folha m&#233;dica<br />
   Otras formas del t&#237;tulo: FM: a folha m&#233;dica";

//field v510
$BVS_LANG["helpertitleHasOtherLanguageEditions"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y ediciones del mismo t&#237;tulo en otros idiomas.<br />
Registre el t&#237;tulo de la edici&#243;n en otro idioma en la forma en que aparece en la publicaci&#243;n siguiendo las <a href=javascript:showISBD(\'es\');>normas ISBD - consolidated edition 2007</a>. <br />
En caso de m&#225;s de una edici&#243;n en otros idiomas, reg&#237;strelas secuencialmente.<br />
Ejemplos:<br />
a) T&#237;tulo de la publica &#231;&#227;o: Materia medica polona (English ed.)^x0025-5246<br />
    Tiene edici&#243;n en otro idioma: Materia medica polona (Ed. Fran &#231;aise)^x0324-8933<br />
b) T&#237;tulo de la publicaci&#243;n: World health^x0043-8502<br />
   Tiene edici&#243;n en otro idioma: Salud mundial^x0250-9318<br />
                                 Sa&#250;de do mundo^x0250-930X<br />
                                 Sant&#233; du monde^x0250-9326<br />";

//field v520
$BVS_LANG["helpertitleAnotherLanguageEdition"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y sus ediciones en otros idiomas.<br />
Registre el t&#237;tulo que es edici&#243;n en otro idioma en la forma en que aparece en la publicaci&#243;n siguiendo las <a href=javascript:showISBD(\'es\');>normas ISBD - consolidated edition 2007</a>.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Materia medica polona (Ed. fran &#231;aise)^x0324-8933<br />
       Es edici&#243;n en otro idioma: Materia medica polona (English ed.)^x0025-5246<br />
<br />
b) T&#237;tulo de la publicaci&#243;n: Salud mundial^x0250-9318<br />
     Es edici&#243;n en otro idioma: World health^x0043-8502<br />";

//field v530
$BVS_LANG["helpertitleHasSubseries"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y sus subseries (revistas con t&#237;tulo y numeraci&#243;n propia publicadas como parte de una serie m&#225;s amplia).<br />
Registre en este campo, el t&#237;tulo de la subserie en la forma en que aparece en la publicaci&#243;n siguiendo las <a href=javascript:showISBD(\'es\');>normas ISBD - consolidated edition 2007</a>.<br />
En caso de m&#225;s de una subserie, registre los t&#237;tulos secuencialmente.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Biochimica et biophisica acta^x0006-3002<br />
   Tiene subserie: Biochimica et biophysica acta. Biomembranes^x0005-2736";

//field v540
$BVS_LANG["helpertitleIsSubseriesOf"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y el t&#237;tulo mayor.<br />
 Registre el t&#237;tulo de la publicaci&#243;n a la cual la subserie est&#225; vinculada siguiendo las <a href=javascript:showISBD(\'es\');>normas ISBD - consolidated edition 2007</a>.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Biochimica et biophysica acta ^x0924-1086<br />
   T&#237;tulo de la secci&#243;n/parte:  Enzymology<br />
   Es subserie de: Biochimica et biophysica acta^x0006-3002";

//field v550
$BVS_LANG["helpertitleHasSupplementInsert"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y los suplementos/insertos (t&#237;tulos editados generalmente separados con numeraci&#243;n propia que complementan al t&#237;tulo principal)<br />
Registre en este campo, el t&#237;tulo del suplemento/inserto siguiendo las normas ISBD – consolidated edition 2007.<br />
En caso de m&#225;s de un suplemento/inserto, reg&#237;strelos secuencialmente.<br />
Ejemplos:<br />
a)T&#237;tulo de la publicaci&#243;n: Scandinavian journal of plastic and reconstructive surgery^x0036-5556<br />
Tiene suplemento o inserto: Scandinavian journal of plastic and reconstructive surgery. Supplement^x0581-9474<br />
b) T&#237;tulo de la publicaci&#243;n: Tubercle^x0041-3879<br />
Tiene suplemento o inserto: BTTA review^x0300-9602";

//field v560
$BVS_LANG["helpertitleIsSupplementInsertOf"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y el t&#237;tulo principal.<br />
Registre el t&#237;tulo propio de la publicaci&#243;n a la cual el suplemento/inserto est&#225; vinculado siguiendo las <a href=javascript:showISBD(\'es\');>normas ISBD - consolidated edition 2007</a>.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Scandinavian journal of plastic and reconstructive surgery ^x0581-9474<br />
T&#237;tulo de la secci&#243;n/parte: Supplement<br />
Es suplemento o inserto de: Scandinavian journal of plastic and reconstructive surgery ^x0036-5556<br />
b) T&#237;tulo de la publicaci&#243;n: BTTA review^x0300-9602<br />
Es suplemento o inserto de: Tubercle^x0041-3879";


	/**************************************** Step 3  ****************************************/

//field v610
$BVS_LANG["helpertitleContinuationOf"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y sus t&#237;tulos anteriores.<br />
Registre el t&#237;tulo anterior de la publicaci&#243;n siguiendo las <a href=javascript:showISBD(\'es\');>normas ISBD - consolidated edition 2007</a>.<br />
En caso de m&#225;s de un t&#237;tulo anterior, reg&#237;strelos secuencialmente.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Revista argentina de urolog&#237;a y nefrolog&#237;a ^x0048-7627<br />
Continuaci&#243;n de: Revista argentina de urolog&#237;a ^x0325-2531<br />
b) T&#237;tulo de la publicaci&#243;n: Revista de la Asociaci&#243;n M&#233;dica Argentina ^x0004-4830<br />
Continuaci&#243;n de: Revista de la Sociedad M&#233;dica Argentina ^x0327-1633";

//field v620
$BVS_LANG["helpertitlePartialContinuationOf"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y su continuaci&#243;n parcial.<br />
Registre el t&#237;tulo anterior de la publicaci&#243;n, siguiendo las <a href=javascript:showISBD(\'es\');>normas ISBD - consolidated edition 2007</a>.<br />
En caso de m&#225;s de un t&#237;tulo anterior, reg&#237;strelos secuencialmente.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Comptes rendus hebdomadaires de seances de l&#180; Academie des Sciences ^x0567-655X <br />
Secci&#243;n/parte: Serie D<br />
T&#237;tulo de la secci&#243;n/parte: Sciences naturelles<br />
Continuaci&#243;n parcial de: Comptes rendus hebdomadaires de seances de l&#180; Academie de Sciences ^x0001-4036";

//field v650
$BVS_LANG["helpertitleAbsorbed"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y el(los) t&#237;tulo(s) que absorbi&#243;.<br />
Registre el t&#237;tulo anterior de la publicaci&#243;n, siguiendo las <a href=javascript:showISBD(\'es\');>normas ISBD - consolidated edition 2007</a>.<br />
En caso de m&#225;s de un t&#237;tulo anterior, reg&#237;strelos secuencialmente.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Revista brasileira de oftalmologia ^x0034-7280<br />
Absorbi&#243;: Boletim de la Sociedade Brasileira de Oftalmologia ^x0583-7820";

//field v660
$BVS_LANG["helpertitleAbsorbedInPart"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y el(los) t&#237;tulo(s) que absorbi&#243; en parte.<br />
Registre el t&#237;tulo anterior de la publicaci&#243;n, siguiendo las <a href=javascript:showISBD(\'es\');>normas ISBD - consolidated edition 2007</a>.<br />
En caso de m&#225;s de un t&#237;tulo anterior, reg&#237;strelos secuencialmente.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Journal of pharmacology and experimental therapeutics ^x0022-3565<br />
Absorbi&#243; en parte: Pharmacological reviews ^0031-6997";

//field v670
$BVS_LANG["helpertitleFormedByTheSplittingOf"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y los t&#237;tulos que lo han formado, a trav&#233;s de subdivisi&#243;n. <br />
Registre el t&#237;tulo anterior de la publicaci&#243;n, siguiendo las normas ISBD.- consolidated edition 2007.<br />
En caso de m&#225;s de un t&#237;tulo anterior, reg&#237;strelos secuencialmente.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Acta neurologica Belgica^x0300-9009<br />
Formado por la subdivisi&#243;n de: Acta neurologica et psychiatrica Belgica ^x0001-6284";

//field v680
$BVS_LANG["helpertitleMergeOfWith"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y los t&#237;tulos que se fusionaron formando el actual.<br />
Registre el t&#237;tulo anterior de la publicaci&#243;n, siguiendo las <a href=javascript:showISBD(\'es\');>normas ISBD - consolidated edition 2007</a>.<br />
En caso de m&#225;s de un t&#237;tulo anterior, reg&#237;strelos secuencialmente.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Revista de psiquiatria din&#226;mica ^x0034-8767<br />
    Fusi&#243;n de...con...: Arquivos da cl&#237;nica Pinel^x0518-7311<br /> Psiquiatria (Porto Alegre) ^x0552-4377<br />
b) T&#237;tulo de la publicaci&#243;n: Gerontology ^x0304-434X <br />
    Fusi&#243;n de...con...: Gerontologia Cl&#237;nica^x0016-8998 <br /> Gerontologia^x0016-898X ";

//field v710
$BVS_LANG["helpertitleContinuedBy"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y su continuaci&#243;n posterior.<br />
Registre el t&#237;tulo posterior de la publicaci&#243;n, siguiendo las normas ISBD.- consolidated edition 2007.<br />
En caso de m&#225;s de un t&#237;tulo posterior, reg&#237;strelos secuencialmente.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Anais da Faculdade de Farm&#225;cia e Odontologia da Universidade de S&#227;o Paulo ^x0365-2181<br />
   Continuado por: Revista da Faculdade de Odontologia da Universidade de S&#227;o Paulo^x0581-6866";

//field v720
$BVS_LANG["helpertitleContinuedInPartBy"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y sus continuaciones parciales.<br />
Registre el t&#237;tulo posterior de la publicaci&#243;n, siguiendo las <a href=javascript:showISBD(\'es\');>normas ISBD - consolidated edition 2007</a>.<br />
En caso de m&#225;s de un t&#237;tulo posterior, reg&#237;strelos secuencialmente.<br />
Ejemplos:<br />
a)T&#237;tulo de la publicaci&#243;n: Annales de mibrobiologie^x 0300-5410<br />
Continuado en parte por: Annales de virologie^x0242-5017<br />
b) T&#237;tulo de la publicaci&#243;n: Journal of clinical psychology^x0021-9762<br />
Continuado en parte por:  Journal of comunity psychology^x0090-4392";

//field v750
$BVS_LANG["helpertitleAbsorbedBy"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y el t&#237;tulo que lo absorbi&#243;.<br />
Registre el t&#237;tulo posterior de la publicaci&#243;n, <a href=javascript:showISBD(\'es\');>siguiendo las normas ISBD - consolidated edition 2007</a>.<br />
En caso de m&#225;s de un t&#237;tulo posterior, reg&#237;strelos secuencialmente.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Boletim da Sociedade Brasileira de Oftalmologia^x0583-7820<br />
Absorbido por: Revista brasileira de oftalmologia^x0034-7280";

//field v760
$BVS_LANG["helpertitleAbsorbedInPartBy"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y el t&#237;tulo por el cual fue absorbido en parte.<br />
Registre el t&#237;tulo posterior de la publicaci&#243;n, <a href=javascript:showISBD(\'es\');>siguiendo las normas ISBD - consolidated edition 2007</a>.<br />
En caso de m&#225;s de un t&#237;tulo posterior, reg&#237;strelos secuencialmente.<br />
Ejemplos:<br />
a)T&#237;tulo de la publicaci&#243;n: Health and social service journal^x0300-8347<br />
Absorbido en parte por:  Community medicine^x0300-5917";

//field v770
$BVS_LANG["helpertitleSplitInto"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y el t&#237;tulo que se subdividi&#243;.<br />
Registre el t&#237;tulo posterior de la publicaci&#243;n, siguiendo las <a href=javascript:showISBD(\'es\');>normas ISBD - consolidated edition 2007</a>.<br />
En caso de m&#225;s de un t&#237;tulo posterior, reg&#237;strelos secuencialmente.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Acta neurologica et psiquiatrica Belgica^x0001-6284<br />
    Se subdividio en: Acta neurologica Belgica^x0300-9009<br />
    Acta psychiatrica Belgica^x0300-8967";

//field v780
$BVS_LANG["helpertitleMergedWith"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y el t&#237;tulo con el cual se fusion&#243;.<br />
Registre los t&#237;tulos siguiendo las <a href=javascript:showISBD(\'es\');>normas ISBD - consolidated edition 2007</a>.<br />
En caso de m&#225;s de una fusi&#243;n, registre los t&#237;tulos secuencialmente.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Anais da Faculdade de Farm&#225;cia e Odontologia da Universidade de S&#227;o Paulo^0365-2181<br />
b) Se fusion&#243; con: Estomatologia e cultura^x0014-1364<br />
Revista da Faculdade de Odontologia de Ribeir&#227;o Preto^x0102-129X";

//field v790
$BVS_LANG["helpertitleToForm"] = "Nota que act&#250;a como elemento de enlace entre el t&#237;tulo que se est&#225; describiendo y los t&#237;tulos registrados en el campo 780<br />
Registre el t&#237;tulo posterior de la publicaci&#243;n que se form&#243; a partir de la fusi&#243;n con los t&#237;tulos registrados en el campo 780, siguiendo las <a href=javascript:showISBD(\'es\');>normas ISBD - consolidated edition 2007</a>.<br />
En caso de m&#225;s de un t&#237;tulo formado, registre los t&#237;tulos secuencialmente.<br />
Ejemplos:<br />
a) T&#237;tulo de la publicaci&#243;n: Anais da Faculdade de Farm&#225;cia e Odontologia da Universidade de S&#227;o Paulo^x0365-2181<br />
Se fusion&#243; con: Estomatologia e cultura^x0014-1364<br />
Revista da Faculdade de Odontologia de Ribeir&#227;o Preto^x0102-129X <br />
Para formar: Revista de odontologia da Universidade de S&#227;o Paulo^x0103-0663<br />
b) T&#237;tulo de la publicaci&#243;n: Psiquiatria (Porto Alegre)^x0552-4377<br />
Se fusion&#243; con: Arquivos da cl&#237;nica Pinel^x0518-7311<br />
Para formar: Revista de psiquiatria din&#226;mica^x0034-8767";

	/**************************************** Step 4  ****************************************/

//field v480
$BVS_LANG["helperpublisher"] = "Nombre del editor comercial y/o instituci&#243;n que publica la seriada descripta.<br />
Registre el nombre del editor responsable comercialmente por la publicaci&#243;n de la peri&#243;dica conforme aparece en la misma.<br />
Cuando el editor sea el mismo de la menci&#243;n de responsabilidad no es necesario repetirlo en este campo, salvo cuando es imprescindible para la adquisici&#243;n.<br />
En caso de m&#225;s de un editor comercial se registra el primero que aparece o el que coincide con el lugar de publicaci&#243;n.<br />
Ejemplos:<br />
a) Editor comercial: Pergamon Press<br />
b) Editor comercial: Plenum Press";

//field v490
$BVS_LANG["helperplace"] = "Nombre del lugar (ciudad) donde se edita y/o publica la peri&#243;dica descripta.<br />
Registre el nombre por extenso de la ciudad en el idioma en que aparece en la publicaci&#243;n.<br />
Cuando el t&#237;tulo aparece en m&#225;s de un idioma, registre la ciudad en el idioma en que se registr&#243; el t&#237;tulo propio.<br />
Cuando no es posible determinar el lugar de edici&#243;n y/o publicaci&#243;n de la peri&#243;dica, registre la abreviatura s.l. (sin lugar).<br />
Ejemplos:<br />
a) Ciudad: S&#227;o Paulo<br />
b) Ciudad: Porto Alegre<br />
c) Ciudad: s.l.";

//field v310
$BVS_LANG["helpercountry"] = "C&#243;digo del pa&#237;s donde se edita la publicaci&#243;n.<br />
Seleccione el nombre del pa&#237;s en el &#237;ndice.<br />El c&#243;digo ISO correspondiente se guardar&#225; en la base.<br />
Ejemplos:<br />
a) Pa&#237;s de publicaci&#243;n: BR<br />
b) Pa&#237;s de publicaci&#243;n: CL";

//field v320
$BVS_LANG["helperstate"] = "C&#243;digo de la unidad de federaci&#243;n donde la peri&#243;dica fue publicada.<br />
Este campo es de registro obligatorio para peri&#243;dicas publicadas en Brasil, y optativo para otros pa&#237;ses con similar divisi&#243;n pol&#237;tico-administrativa.<br />
Ejemplos:<br />
a) Estado: SP<br />
b) Estado: RJ";

//field v400
$BVS_LANG["helperissn"] = "N&#250;mero que identifica internacionalmente a cada publicaci&#243;n seriada (International Standart Serial Number).<br />
Registre el ISSN en forma completa, incluyendo el gui&#243;n. Se consignan las versiones en diferentes soportes.<br />
Ejemplos: Plant varieties journal (Ottawa)<br />
ISSN-L 1188-1534<br />
1188-1534^aimpreso<br />
1911-1479^lonline<br />
1911-1460^lcdrom<br />
0273-1134^zcancelado";

//field v410
$BVS_LANG["helpercoden"] = "C&#243;digo asignado a la publicaci&#243;n por el Chemical Abstracts Service (CAS). <br />
Registre en la forma que aparece en la publicaci&#243;n.<br />
Ejemplos:<br />
a) CODEN: FOMEAN<br />
b) CODEN: RCPDAF";

//field v50
$BVS_LANG["helperpublicationStatus"] = "C&#243;digo que identifica el estado actual de la peri&#243;dica en relaci&#243;n con su publicaci&#243;n por el editor.<br />
Campo de registro obligatorio.
Tambi&#233;n se puede completar este campo presionando la tecla F2.
<br />
Utilice los siguientes c&#243;digos: <br />
C  - para publicaciones en curso.<br />
D  - para publicaciones suspendidas o cerradas.<br />
?  - cuando se desconoce.<br />
<br />
Ejemplos:<br />
a)Estado de la publicaci&#243;n: C<br />
b)Estado de la publicaci&#243;n: ?";

//field v301
$BVS_LANG["helperinitialDate"] = "A&#241;o y mes de inicio de publicaci&#243;n de la peri&#243;dica.<br />
Registre la fecha inicial usando las abreviaturas normalizadas para los meses en el idioma en que se registr&#243; el t&#237;tulo propio.<br />
El registro del mes es optativo y en caso de registrarse ambos, el mes precede al a&#241;o.<br />
Cuando no sea posible determinar el a&#241;o exacto de inicio, reg&#237;strelo de la siguiente forma:<br />
1983                      Fecha.<br />
?983                      Fecha probable.<br />
198?                      A&#241;o incierto.<br />
19??                      D&#233;cada incierta.<br />
1???                      Siglo incierto.<br />
Ejemplos:<br />
a) A&#241;o de inicio: ene./mar. 1974<br />
b) A&#241;o de inicio: 1987<br />
c) A&#241;o de inicio: sept. 1988 ";

//field v302
$BVS_LANG["helperinitialVolume"] = "N&#250;mero del volumen con que se inicia la publicaci&#243;n descripta.<br />
Registre el volumen inicial en n&#250;meros ar&#225;bigos.<br />
Omita esta informaci&#243;n en caso de publicaciones que no incluyen informaci&#243;n clara sobre el volumen.<br />
<br />
Ejemplos:<br />
a) Volumen de inicio: 1<br />
b) Volumen de inicio: 4";

//field v303
$BVS_LANG["helperinitialNumber"] = "N&#250;mero del primer fasc&#237;culo de la publicaci&#243;n peri&#243;dica descripta.<br />
Registre el n&#250;mero de inicio en cifras ar&#225;bigas.<br />
Ejemplos:<br />
a) N&#250;mero de inicio: 1<br />
b) N&#250;mero de inicio: 2";

//field v304
$BVS_LANG["helperfinalDate"] = "A&#241;o y mes en que se public&#243; por &#250;ltima vez la peri&#243;dica descripta.<br />
Registre las fechas que aparecen en la publicaci&#243;n, usando abreviaturas normalizadas para los meses en el idioma en que se registr&#243; el t&#237;tulo.<br />
El registro del mes es optativo y en caso de registrarse ambos, el mes precede al a&#241;o.<br />
Ejemplos:<br />
a) A&#241;o de cierre: oct. 1984<br />
b) A&#241;o de cierre: 1988";

//field v305
$BVS_LANG["helperfinalVolume"] = "N&#250;mero del &#250;ltimo volumen editado de la publicaci&#243;n.<br />
Registre el volumen final en cifras ar&#225;bigas.<br />
Ejemplos:<br />
a) Volumen de cierre: 10<br />
b) Volumen de cierre: 12 ";

//field v306
$BVS_LANG["helperfinalNumber"] = " N&#250;mero del &#250;ltimo fasc&#237;culo editado de la publicaci&#243;n descripta
<br />
Registre el n&#250;mero final en cifras ar&#225;bigas.<br />
Ejemplos:<br />
a) N&#250;mero de cierre: 7<br />
b) N&#250;mero de cierre: 10";

//field v380
$BVS_LANG["helperfrequency"] = "C&#243;digo que identifica los intervalos de tiempo con que se publica la peri&#243;dica.<br />
Registre el c&#243;digo de la frecuencia en forma abreviada.<br />
Ejemplos:<br />
a) Frecuencia actual: B<br />
b) Frecuencia actual: T";

//field v330
$BVS_LANG["helperpublicationLevel"] = "T&#233;rmino que define el nivel intelectual de la publicaci&#243;n.<br />
Registre este campo, de acuerdo con los siguientes c&#243;digos:.<br />
CT - Cient&#237;fico/t&#233;cnico: para publicaciones peri&#243;dicas que incluyen art&#237;culos producto de investigaciones cient&#237;ficas y/o art&#237;culos firmados que emiten la opini&#243;n de especialistas (incluye estudios cl&#237;nicos).<br />
DI - Divulgaci&#243;n: para las publicaciones peri&#243;dicas que incluyen, en su mayor&#237;a, art&#237;culos no firmados, notas informativas, etc.<br />
Ejemplos:<br />
a) Nivel de la publicaci&#243;n: CT<br />
b) Nivel de la publicaci&#243;n: DI";

//field v340
$BVS_LANG["helperalphabetTitle"] = "T&#233;rmino que identifica el alfabeto original del t&#237;tulo.<br />
Registre este campo, de acuerdo con los siguientes c&#243;digos:<br />
A – Romano b&#225;sico: para idiomas anglo-germ&#225;nicos y romanos que no utilizan signos diacr&#237;ticos, tales como: ingl&#233;s, eslavo, croata, lat&#237;n.<br />
B - Romano extendido: para idiomas anglo-germ&#225;nicos y latinos que utilizan signos diacr&#237;ticos, tales como: portugu&#233;s, alem&#225;n, franc&#233;s, espa&#241;ol, italiano.<br />
C - Cir&#237;lico: para idiomas eslavos, tales como: ruso, b&#250;lgaro, checo, ucraniano, serbio, etc.<br />
D - Japon&#233;s.<br />
E - Chino.<br />
K - Coreano.<br />
F – Arabe.<br />
G – Griego.<br />
H – Hebreo.<br />
I - Tailand&#233;s.<br />
J – Devanagari.<br />
L – Tamil.<br />
Z - Otros.<br />
<br />
Ejemplos:<br />
a) Alfabeto del t&#237;tulo: A<br />
b) Alfabeto del t&#237;tulo: C";

//field v350
$BVS_LANG["helperlanguageText"] = "C&#243;digo que identifica el idioma del texto de la publicaci&#243;n descripta de acuerdo con la norma ISO-ST-R-639-1977 (nuevo nº  de la ISO-ST-8601-1988)<br />
Seleccione del &#237;ndice el/los idioma(s) de la publicaci&#243;n. En la base se grabar&#225;n los c&#243;digos ISO correspondientes.<br />
Ejemplos:<br />
SELECCIONA<br />
GUARDA<br />
Portugu&#233;s<br />
Pt<br />
Ingl&#233;s<br />
En<br />
Espa&#241;ol<br />
Es";

//field v360
$BVS_LANG["helperlanguageAbstract"] = "C&#243;digo que identifica el idioma del resumen de la publicaci&#243;n descripta.<br />
Seleccione del &#237;ndice el/los idioma(s) del resumen. En la base se grabar&#225;n los c&#243;digos ISO correspondientes. <br />
Ejemplos:<br />
SELECCIONA<br />
GUARDA<br />
Portugu&#233;s<br />
Pt<br />
Ingl&#233;s<br />
En<br />
Espa&#241;ol<br />
Es";


	/**************************************** Step 5  ****************************************/

//field v40
$BVS_LANG["helperrelatedSystems"] = "C&#243;digo que identifica el(los) sistema(s) al cual determinado registro deber&#225; ser transferido.<br />
Es de registro obligatorio para los centros que participan en el &#180;Registro de Publicaciones Seriadas en Ciencias de la Salud – BIREME&#180; con las colecciones de los t&#237;tulos indizados en LILACS y/o MEDLINE.<br />
Este campo es utilizado por el sistema para generar los archivos de datos de la colecci&#243;n que se enviar&#225; a BIREME.<br />
Registre en este campo el c&#243;digo SECS u otro c&#243;digo que identifique el sistema para el cual el registro deber&#225; ser transferido.<br />
En caso de m&#225;s de un c&#243;digo, reg&#237;strelos secuencialmente.<br />
Ejemplos:<br />
a) Sistemas relacionados: SECS<br />
b) Sistemas relacionados: CAPSALC<br />
c) Sistemas relacionados: <br />SECS<br />CAPSALC";

//field v20
$BVS_LANG["helpernationalCodeo"] = "C&#243;digo que identifica el t&#237;tulo en el sistema nacional de publicaciones peri&#243;dicas de cada pa&#237;s (o equivalente) con el prop&#243;sito de facilitar la transferencia de datos entre &#233;ste y otros sistemas afines.<br />
 Registre en este campo el c&#243;digo asignado por la instituci&#243;n responsable del sistema nacional de publicaciones peri&#243;dicas de cada pa&#237;s (o equivalente).<br />
 Ejemplos:<br />
 a) C&#243;digo nacional: 001060-X (N&#250;mero SIPS en el &#180;Cat&#225;logo Colectivo Nacional brasileiro&#180;)<br />
 b) C&#243;digo nacional: 00043/93";

//field v37
$BVS_LANG["helpersecsIdentification"] = "N&#250;mero de identificaci&#243;n del t&#237;tulo en el ‘Registro de Publicaciones Seriadas en Ciencias de la Salud – BIREME’<br />
Registre en este campo el n&#250;mero proporcionado por BIREME que identifica el t&#237;tulo en la base de datos de Publicaciones Seriadas en Ciencias de la Salud - SeCS.<br />
Campo de registro obligatorio para los Centros que env&#237;an datos de su colecci&#243;n a BIREME<br />
Este campo es utilizado por el sistema para generar los archivos de datos de la colecci&#243;n que se env&#237;a a BIREME.<br />
Si el t&#237;tulo est&#225; identificado con el SECS (campo de Sistemas relacionados), tambi&#233;n deber&#225; completarse este campo.<br />
Ejemplos:<br />
a) N&#250;mero SECS: 2<br />
b) N&#250;mero SECS: 4";


//field v430
$BVS_LANG["helperclassification"] = "Notaci&#243;n de clasificaci&#243;n de materia de la publicaci&#243;n, de acuerdo con el sistema de clasificaci&#243;n adoptado.<br />
Registre la notaci&#243;n de clasificaci&#243;n seg&#250;n el sistema adoptado.<br />
En caso de m&#225;s de una clasificaci&#243;n, reg&#237;strelas secuencialmente.<br />
Ejemplos:<br />
a) Clasificaci&#243;n:  WA^cNLM <br />
b) Clasificaci&#243;n: <br /> WO200%QT34<br />
a) Clasificaci&#243;n: ABCD1234^cJCR";

//field v421
$BVS_LANG["helperclassificationCdu"] = "Clasificaci&#243;n Decimal Universal (CDU), es una clasificaci&#243;n decimal en la que la totalidad de los conocimientos est&#225; dividida en 10 clases, que se subdividen nuevamente de forma decimal, de lo general a lo espec&#237;fico. Cada concepto es traducido por una notaci&#243;n num&#233;rica o alfanum&#233;rica. <br />
Ejemplo: 159.964.2 (Psych&#234;: revista de psicoan&#225;lisis) <br />
          61:57(05) (Revista de ciencias m&#233;dicas y biol&#243;gicas) <br />";

//field v422
$BVS_LANG["helperclassificationDewey"] = "Clasificaci&#243;n Decimal de Dewey (CDD), divide el conocimiento en nueve clases y, contiene una d&#233;cima para las obras generales. <br />
Ejemplos: 610.05 (Revista de ciencias m&#233;dicas y biol&#243;gicas) <br />";

//field v435
$BVS_LANG["helperthematicaArea"] = "Tabla de &#225;reas del conocimiento – CNPq que es de naturaleza jer&#225;rquica en cuatro niveles:
gran &#225;rea<br />
&#225;rea<br />
sub-&#225;rea<br />
especialidad<br />
<br />
Ejemplos: Ciencias de la salud<br />
          Ciencias biol&#243;gicas";

//field v440
$BVS_LANG["helperdescriptors"] = "T&#233;rminos normalizados utilizados para representar el tema principal de la publicaci&#243;n.<br />
Los participantes de la Red de BIREME deben utilizar los t&#233;rminos extra&#237;dos del DeCS (Descriptores en Ciencias de la Salud).<br />
En caso de m&#225;s de un descriptor, reg&#237;strelos secuencialmente.<br />
Registre como m&#225;ximo 4 descriptores.<br />
Ejemplos:<br />
a) Descriptores: MEDICINA OCUPACIONAL<br />
b) Descriptores: NEUROLOGIA<br />PEDIATRIA<br />
c) Descriptores: NEUROLOGIA<br />
d) Descriptores: GINECOLOGIA<br />OBSTETRICIA";

//field v441
$BVS_LANG["helperotherDescriptors"] = "Descriptores definidos por la Instituci&#243;n, no pertenecientes al DeCS, para representar el contenido tem&#225;tico del documento<br />";

//field v450
$BVS_LANG["helperindexingCoverage"] = "C&#243;digo que identifica a las fuentes secundarias de informaci&#243;n que indizan la publicaci&#243;n descripta.<br />
Registre el c&#243;digo de la fuente secundaria que indiza a la publicaci&#243;n, seguido del a&#241;o, volumen, y del n&#250;mero inicial y final.<br />
Si el t&#237;tulo fue seleccionado para ser indizado en la base de datos LILACS, obligatoriamente tiene que ser descripto en el Sistema SeCS.<br />
Consulte el ‘Manual de Selecci&#243;n para la Base de datos LILACS’, para mayor informaci&#243;n sobre la selecci&#243;n de revistas para indizaci&#243;n.<br />
Otras obras de referencia diferentes de las ya citadas y de inter&#233;s para la unidad de informaci&#243;n, podr&#225;n registrarse con sus t&#237;tulos por extenso.<br />
En caso de m&#225;s de una fuente de referencia, reg&#237;strelas secuencialmente.<br />
<br />
Ejemplos: REVISTA DO HOSPITAL DAS CL&#205;NICAS <br />
IM^a1965^b20^c4^d2004^e59^f6<br />
LL^a1981^b36^c1^d2004^e59^f6<br />
SciELO^a1999^b54^c1^d2004^e59^f6<br />";
//Cobertura tem&#225;tica por base de datos – Campo 455<br />
//T&#233;rminos normalizados utilizados para representar el tema principal de la publicaci&#243;n.<br />
//Ejemplo: MEMÓRIAS DO INSTITUO OSWALDO CRUZ<br />
//JCR^aPARASITOLOGY;TROPICAL MEDICINE<br />
//MDL^aPARASITOLOGY;TROPICAL MEDICINE<br />
//SciELO^aCIENCIAS BIOLOGICAS<br />
//LL^aMEDICINA TROPICAL";

//field v450^a
$BVS_LANG["helperindexingCoverageA"] = "el registro de la fecha inicial en que el documento comenzó a ser indexada a la fuente de referencia";
//field v450^b
$BVS_LANG["helperindexingCoverageB"] = "registrar el volumen inicial en el que el papel comenzó a ser indexadas en la fuente de referencia";
//field v450^c
$BVS_LANG["helperindexingCoverageC"] = "el registro de la emisión inicial en la que el trabajo comienza para ser indexadas en la fuente de referencia";
//field v450^d
$BVS_LANG["helperindexingCoverageD"] = "el registro de la fecha definitiva en que la revista dejó de ser indexados en la fuente de referencia";
//field v450^e
$BVS_LANG["helperindexingCoverageE"] = "registrar el volumen final en la revista dejó de ser indexada a la fuente de referencia";
//field v450^f
$BVS_LANG["helperindexingCoverageF"] = "el registro de la última entrega de la revista dejó de ser indexadas en la fuente de referencia";

//field v470
$BVS_LANG["helpermethodAcquisition"] = "Alphanumeric code identifying the acquisition method of this serial at the cataloguing agency.<br />
Enter a code combining the following elements:<br />
0 - Acquisition method unknown.<br />
1 - Purchase         A - Current<br />
2 - Exchange         B - Discontinued<br />
3 - Donation<br />
Examples:<br />
 a) Acquisition method: 1A  (purchase, current)<br />
 b) Acquisition method: 3B  (donation, discontinued)";

//field v900
$BVS_LANG["helpernotes"] = "Informaciones complementarias relativas a cualquier aspecto de la publicaci&#243;n, ya sea en su presentaci&#243;n o contenido.<br />
Registre en este campo, en lenguaje natural, informaciones que sean de inter&#233;s para el centro responsable por la descripci&#243;n de la publicaci&#243;n.<br />
En caso de m&#225;s de una nota, reg&#237;strelas secuencialmente.<br />
Ejemplos:<br />
a) Notas: Publicaci&#243;n interrumpida entre 1987-1976<br />
b) Notas: Volumen 104 no fue publicado";

//field v455
$BVS_LANG["helperCoveredSubjectDB"] = "Termos normalizados utilizados para representar o assunto principal do seriado.<br />
Para uso de BIREME.<br />
<br />
Exemplo: (for the journal MEM&#211;RIAS DO INSTITUTO OSWALDO CRUZ) <br />
JCR^aPARASITOLOGY;TROPICAL MEDICINE
MDL^aPARASITOLOGY;TROPICAL MEDICINE
SciELO^aCIENCIAS BIOLOGICAS
LL^aMEDICINA TROPICAL";

//field v850
$BVS_LANG["helperIndicators"] = "Campo de dado utilizado para indicadores estat&#237;sticos e bibliom&#233;tricos dos peri&#243;dicos cient&#237;ficos.<br />
Esta informa&#231;&#227;o &#233; para uso de BIREME.<br />
<br />
Exemplo:<br />
JCR^a2007^v0.765<br />
SciELO^a2007^v0.124";


	/**************************************** Step 6  ****************************************/

//field v999

$BVS_LANG["helperurlPortal"] = "La información para el portal consiste de un
proveedor de dirección, tipo y control de acceso y el tiempo.
<br/><br/>
Basta con hacer clic en el botón Subcampo junto al cuadro de texto para abrir una
nueva ventana para llenar la información bajo el nombre de sobre el terreno.";

//field v999^a
$BVS_LANG["helpField999SubfieldA"] = "Define el tipo de acceso permitido a los art&#237;culos de las peri&#243;dicas. Para cada &#237;tem existen 6 opciones: <br /><br />LIBRE <br />Esta opci&#243;n habilita todo tipo de acceso a las p&#225;ginas correspondientes. <br />LIBRE PARA EL SUSCRIPTOR POR FORMATO ELECTRONICO (ONLINE) <br />Esta opci&#243;n permite s&#243;lo el acceso gratuito a la informaci&#243;n de las p&#225;ginas correspondientes. <br />LIBRE PARA SUSCRIPTOR DE FORMATO IMPRESO<br />Esta opci&#243;n permite s&#243;lo el acceso gratuito a la informaci&#243;n en formato impreso con env&#237;o por correo. <br />EXIGE SUSCRIPCION ONLINE<br />Esta opci&#243;n permite s&#243;lo el acceso mediante el pago de la suscripci&#243;n on line. <br />EXIGE SUSCRIPCION IMPRESA<br />Esta opci&#243;n permite s&#243;lo el acceso mediante el pago de la suscripci&#243;n en formato impreso. <br />EXIGE SUSCRIPCION ONLINE/IMPRESA<br />	Esta opci&#243;n permite s&#243;lo el acceso mediante el pago de la suscripci&#243;n online y tambi&#233;n en formato impreso.";

//field v999^b
$BVS_LANG["helpField999SubfieldB"] = "URL – Campo 999^b<br /><br />URL es una direcci&#243;n &#250;nica en Internet (Uniform Resource Locator), formada por el nombre del archivo, directorio, nombre del servidor y el m&#233;todo con el cual va a ser requerido. <br />Los clientes se comunican con el servidor a trav&#233;s de conexiones TCP/IP establecidas con el puerto 80, utilizando el protocolo HTTP (HyperText Tranfer Protocol). <br />La informaci&#243;n es estructurada en forma de documentos en hipertexto e hipermedia, independientes y relacionados entre s&#237; a trav&#233;s de hiperlinks. <br />La estructura de una URL es : <br /> http:// - es el m&#233;todo como se har&#225; la transacci&#243;n entre cliente y servidor. HTTP es el m&#233;todo para transportar p&#225;ginas en la Web.";

//field v999^c
$BVS_LANG["helpField999SubfieldC"] = "Agregador/Proveedor – Campo 999^c<br /><br />Portales que posibilitan la investigaci&#243;n e incorporan m&#225;s de una base de datos. Su acceso es de pago, por medio de suscripci&#243;n, de alto costo, y muchas veces est&#225;n disponibles s&#243;lo en instituciones de ense&#241;anza/investigaci&#243;n. Permiten el acceso al texto completo. Los principales son OVID, EBSCO y PROQUEST. En Brasil, el portal CAPES permite el acceso al texto completo de varias revistas, por medio de convenios con universidades. <br /><br />Ejemplo: CAPES-SciELO<br />CAPES-OVID";

//field v999^d
$BVS_LANG["helpField999SubfieldD"] = "Control de acceso - Campo 999^d<br /><br />Es el proceso/medio de asegurar que s&#243;lo los usuarios registrados accedan a los recursos de un sistema inform&#225;tico.<br /><br />EJEMPLOS:<br />IP<br />LIBRE<br />CONTRASE&#209;A";

//field v999^e
$BVS_LANG["helpField999SubfieldsEF"] = "Per&#237;odo - Campo 999^e^f<br /><br />Per&#237;odo inicial y final de acceso al texto completo.<br /><br />EJEMPLO:<br />1997 a 2009";

//field v999^g
$BVS_LANG["helpField999SubfieldG"] = "Tipo de Arquivo 999^g<br /><br /> <br /><br />EXEMPLO:<br />";


//field v860
$BVS_LANG["helperurlInformation"] = "Informaciones complementarias sobre el acceso al art&#237;culo.<br />
EJEMPLO:<br />
Permite la compra de art&#237;culos;<br />
Acceso solamente a las tablas de contenido";

//field v861
$BVS_LANG["helperBanPeriod"] = "Period of time in which the online version of the serial and/or its articles
are not released to the general public.<br />
<br />
Example:<br />
Fulltext available online from january 1995, with 6 months embargo.";

	/**************************************** Step 7  ****************************************/

//field v436
$BVS_LANG["helperspecialtyVHL"] = "Terminolog&#237;a espec&#237;fica definida por la BVS para facilitar la recuperaci&#243;n del t&#237;tulo en el Portal. <br />
<br />
Ejemplo: ^aBVSSP^bALIMENTACAO E NUTRICAO<br />
Diferenciado del Decs que es CI&#202;NCIAS DA NUTRI&#199;&#195;O<br />";

//field v445
$BVS_LANG["helperuserVHL"] = "C&#243;digo que identifica al t&#237;tulo en la BVS, con el prop&#243;sito de facilitar la transferencia de datos entre la base T&#237;tulos y otras BVS afines.<br />
<br />
Ejemplos: BVSSP<br />
          ANVISA<br />
          BVS-Evid&#234;ncia";

//field v910
$BVS_LANG["helpernotesBVS"] = "Motivo por el cual la publicaci&#243;n dej&#243; de ser indizada en LILACS. <br />
<br />
Ejemplo: <br />
a) Dej&#243; de estar en LILACS por atraso en la publicaci&#243;n<br />
b)A&#241;o, volumen y n&#250;mero inicial de indizaci&#243;n en LiLAcs<br />
Ejemplo:<br />
1981 12(3)<br />
c) A&#241;o, volumen y &#250;ltimo n&#250;mero indizado en LiLacs<br />
Ejemplo:<br />
&#250;ltima indizaci&#243;n de 1998 48(1/2)<br />";

//field v920
$BVS_LANG["helperwhoindex"] = "C&#243;digo del Centro Cooperante responsable por la indizaci&#243;n de las revistas LiLacs. <br />
<br />
Ejemplos: BR1.1<br />
               AR29.1<br />";

//field v930
$BVS_LANG["helpercodepublisher"] = "Campo de registro obligatorio.<br />
N&#250;mero secuencial adjudicado y controlado por BIREME.<br />
C&#243;digo de identificaci&#243;n del editor responsable de la revista indizada en LiLacs.<br />
El c&#243;digo del editor est&#225; formado por el c&#243;digo ISO de pa&#237;s, seguido de un n&#250;mero que lo identifica.<br />
Este campo es utilizado por el sistema para hacer el enlace entre el registro del t&#237;tulo LiLacs y los datos del editor en la base de datos Nmail, por eso es obligatorio el env&#237;o por parte de los CC´s del formulario precompletado del REGISTRO DE EDITORES DE REVISTAS LILACS<br />
Ejemplos: BR440.9<br />
                AR29.9";




        /***************** ISBD - 2007 ****************************************/

$BVS_LANG["helpISBD"] = "Reglas básicas para la entrada de títulos, basadas en las ISBD – edición consolidada 2007 y adaptadas para la entrada de datos del sistema SeCS-Web<br /><br />1 - Cuando el título de la publicación consta de iniciales o acrónimos destacados en la portada, y la forma por extenso también aparece como parte integrante del título, se registran las iniciales o acrónimos como título (campo de título de la publicación - 100) y la forma por extenso en el campo del Subtítulo (campo 110). Si las iniciales o acrónimos están lingüística y/o tipográficamente separados de la forma por extenso, se registran las iniciales o acrónimos como título y la forma por extenso en Otras formas del título (campo 240).<br /><br />Ejemplos:<br />Título de la publicación: ABCD<br />Subtítulo: arquivos brasileiros de cirugia digestiva<br />Título de la publicación: Jornal de la AMRIGS.<br />Otras formas del título: jornal de la Associación Médica do Rio Grande do Sul<br /><br />2 - Cuando la mención de responsabilidad aparece como parte integrante del título en la forma abreviada como acrónimo o iniciales, ésta se repite en la forma completa en mención de responsabilidad - campo 140, si esta forma aparece en la publicación descripta, y el título en su forma por extenso en Otras formas del título - Campo 240.<br /><br /><br />Ejemplos:<br />Título de la publicación: ALA bulletin<br />Mención de responsabilidad: American Library Association<br />Otras formas del título: American Library Association bulletin.<br /><br />3 - Cuando la publicación no tiene título y sólo tiene mención de responsabilidad, entonces se transcribe ésta como título de la publicación y no es necesario repetirla en el campo de mención de responsabilidad (campo 140).<br /><br /><br />Ejemplo:<br />Título de la publicación: Universidad de Antioquia<br /><br />4 - Cuando el título de la publicación es un término genérico, como Boletín, Boletín técnico, Diario, Gacetilla, etc., o sus equivalentes en otros idiomas, y está separado linguística y/o tipográficamente de la mención de responsabilidad, se registra el título en la forma que aparece y la mención de responsabilidad en el campo 140, que en este caso se convierte en obligatorio para la correcta identificación de la publicación.<br /><br /><br /><br />Ejemplo:<br />Título de la publicación: Boletim<br />Mención de responsabilidad: Associación Médica Paulista<br /><br />5 - Para los títulos homónimos, se debe registrar un diferenciador (calificador), esto es válido tanto para el título propio como para otras formas del título propio (abreviados, paralelos, etc.). Esta información se debe registrar después del título, separada por espacio y entre paréntesis.<br /><br />De esta manera:<br /><br />5.1 – Para los títulos homónimos de lugares diferentes, se registran como calificador el lugar de la publicación.<br /><br />Ejemplos:<br />Título de la publicación: Pediatria (São Paulo)<br />Título de la publicación: Pediatría (Bogotá)<br /><br />5.2 – Para los títulos homónimos de lugares idénticos, se registra como calificador el lugar y la fecha inicial de la publicación.<br />Ejemplos:<br />Título de la publicación: Pediatria (São Paulo. 1983)<br />Título de la publicación: Pediatria (São Paulo. 1984)<br /><br />5.3 – Para las publicaciones que vuelven a usar el título anterior, se registra como calificador el lugar y la fecha inicial de la publicación.<br />Ejemplos:<br />Título de la publicación: Revista médica (1968)<br />Título de la publicación: Revista médica (1987)<br /><br />5.4 - Ediciones en distintos idiomas con títulos homónimos, se registra como calificador la edición correspondiente, de acuerdo con la ISO 4-1984 y la &#180;Lista de abreviaturas de palabras de título de serie&#180;.<br />Ejemplos:<br />Título de la publicación: Abboterapia (ed. español)<br />Título de la publicación: Abboterapia (ed. portugués)<br />Título abreviado: Abboterapia (ed. esp.)<br />Título abreviado: Abboterapia (ed. port.)<br /><br />6 - Cuando una sección, parte o suplemento, publicado separadamente, tiene un título específico que puede ser separado del título común y cuando el título específico aparece como más importante que el título común, éste pasa a constituir un nuevo registro como título propio.<br /><br /><br />Ejemplo:<br />Título común de la publicación: Veterinary record<br />Título específico: In practice<br />a) Título de la publicación: In practice<br />Es suplemento/inserto de: Veterinary record<br />b) Título de la publicación: Veterinary record Tiene suplemento/inserto: In practice<br /><br />7 - Cuando el título del suplemento es idéntico al título propio y se constituye un nuevo registro,  se distingue registrando la palabra Suplemento en el campo de Título de la sección/parte (campo 130).<br /><br />Ejemplos:<br />a) Título de la publicación: Ciência e cultura<br />Título de la sección/parte: Suplemento<br />b) Título de la publicación: Acta cirúrgica brasileira<br />Título de la sección/parte: Suplemento<br /><br />8 – En caso de varios Títulos paralelos presentados en la portada o en la parte que la substituye, se registra como título propio el que aparece destacado tipográficamente y si no hay distinción tipográfica, se registra el que aparece en primer lugar, y como títulos paralelos los demás títulos (campo 230).<br /><br />Ejemplos:<br />Título de la publicación: Progress in surgery<br />Título paralelo: Progress en chirurgie";


	/****************************************************************************************************/
	/**************************************** Library Section - Field Helps ****************************************/
	/****************************************************************************************************/

//field v2
$BVS_LANG["helpLibFullname"] = "Nombre que identifica a la biblioteca.<br />
EJEMPLO: BIREME - OPS - OMS - Centro Latinoamericano y del Caribe de Información en Ciencias de la Salud";

//field v1
$BVS_LANG["helpLibCode"] = "Código utilizado para identificar la biblioteca, centro o unidad de información. <br />
La biblioteca principal que gestiona SeCS tiene el nombre por defecto: PRINCIPALES <br />
<br />
EJEMPLOS <br />
a) FAGRO <br />
b) Ciencia <br />
<br />
Las bibliotecas que pertenecen a la red va a utilizar el código indexados que las identifica. <br />
El código de la Biblioteca está formado por el código ISO del país donde está ubicado, seguido de un número que lo identifica. <br />
EJEMPLO: BR1.1";

//field v9
$BVS_LANG["helpLibInstitution"] = "Logo y nombre de la institución que la biblioteca o sistema bibliotecario es una parte integral. <br />
EJEMPLO: UNIFESP: Universidad Federal de São Paulo";

//field v3
$BVS_LANG["helpLibAddress"] = "Dirección completa de la Biblioteca con los suplementos apropiados (Calle, Av., etc.) <br />
EJEMPLO: Rua Botucatu, 862 - CEP 04023-901 - Vila Clementino";

//field v4
$BVS_LANG["helpLibCity"] = "La ciudad en donde se encuentra la biblioteca. <br />
EJEMPLO: São Paulo";

//field v5
$BVS_LANG["helpLibCountry"] = "Nombre del país donde se encuentra la Biblioteca <br />
Ejemplo: Brasil";

//field v6
$BVS_LANG["helpLibPhone"] = "Número de teléfono o número de teléfono del responsable de la Biblioteca. <br />
EJEMPLO: (55 011) 55769876, (55 011) 55769800";

//field v7
$BVS_LANG["helpLibContact"] = "Nombre completo de la persona responsable de la Biblioteca. <br />
EJEMPLO: Raquel Cristina Vargas";

//field v10
$BVS_LANG["helpLibNote"] = "Más información sobre la Biblioteca. <br />
Registro en este campo, en cualquier idioma, la información que es de interés para la unidad de inteligencia. <br />
EJEMPLO: días y horarios de atención";

//field v11
$BVS_LANG["helpLibEmail"] = "E-dirección de correo electrónico de la persona responsable de la Biblioteca. <br />
EJEMPLO: raquel.araujo@bireme.org";


	/****************************************************************************************************/
	/**************************************** Homepage - Search Field Helps ****************************************/
	/****************************************************************************************************/
/*
 * Help for Title search field and Title Plus search field in homepage section
 */

$BVS_LANG["helpSearchTitle"] = "Buscar en la base de datos Títulos. <br />
Es posible hacer una búsqueda sin seleccionar un índice específico (opción Todos los Indices) o utilizando alguno de los índices que están disponibles en la lista junto a la ayuda. <br/>
<br/>
Basta escribir uno o más términos en el cuadro de búsqueda y pulsar el botón \"Buscar\". <br/>
También es posible realizar una búsqueda de todos los artículos utilizando el símbolo $ <br/>
O una búsqueda truncada con el término y el símbolo $ <br/>
Por ejemplo, una búsqueda por Brasil$, traerá Brasil, Brasileños y Brasileñas.";

$BVS_LANG["helpSearchTitlePlus"] = "Buscar en la base de datos Título Plus. <br />
Es posible hacer una búsqueda sin seleccionar un índice específico (opción Todos los Indices) o utilizando alguno de los índices que están disponibles en la lista junto a la ayuda. <br/>
<br/>
Basta escribir uno o más términos en el cuadro de búsqueda y pulsar el botón \"Buscar\". <br/>
También es posible realizar una búsqueda de todos los artículos utilizando el símbolo $ <br/>
O una búsqueda truncada con el término y el símbolo $ <br/>
Por ejemplo, una búsqueda por Brasil$, traerá Brasil, Brasileños y Brasileñas.";

//search Mask database
$BVS_LANG["helpSearchMask"] = "Buscar en la base de datos Mascaras. <br />
Es posible hacer una búsqueda sin seleccionar un índice específico (opción Todos los Indices) o utilizando alguno de los índices que están disponibles en la lista junto a la ayuda. <br/>
<br/>
Basta escribir uno o más términos en el cuadro de búsqueda y pulsar el botón \"Buscar\". <br/>
También es posible realizar una búsqueda de todos los artículos utilizando el símbolo $ <br/>
O una búsqueda truncada con el término y el símbolo $ <br/>
Por ejemplo, una búsqueda por Brasil$, traerá Brasil, Brasileños y Brasileñas.";

//search Issue database
$BVS_LANG["helpSearchIssue"] = "Buscar en la base de datos Fasciculos. <br />
Es posible hacer una búsqueda sin seleccionar un índice específico (opción Todos los Indices) o utilizando alguno de los índices que están disponibles en la lista junto a la ayuda. <br/>
<br/>
Basta escribir uno o más términos en el cuadro de búsqueda y pulsar el botón \"Buscar\". <br/>
También es posible realizar una búsqueda de todos los artículos utilizando el símbolo $ <br/>
O una búsqueda truncada con el término y el símbolo $ <br/>
Por ejemplo, una búsqueda por Brasil$, traerá Brasil, Brasileños y Brasileñas.";

//search Users database
$BVS_LANG["helpSearchUsers"] = "Buscar en la base de datos Usuarios. <br />
Es posible hacer una búsqueda sin seleccionar un índice específico (opción Todos los Indices) o utilizando alguno de los índices que están disponibles en la lista junto a la ayuda. <br/>
<br/>
Basta escribir uno o más términos en el cuadro de búsqueda y pulsar el botón \"Buscar\". <br/>
También es posible realizar una búsqueda de todos los artículos utilizando el símbolo $ <br/>
O una búsqueda truncada con el término y el símbolo $ <br/>
Por ejemplo, una búsqueda por Brasil$, traerá Brasil, Brasileños y Brasileñas.";

//search Library database
$BVS_LANG["helpSearchLibrary"] = "Buscar en la base de datos Biblioteca. <br />
Es posible hacer una búsqueda sin seleccionar un índice específico (opción Todos los Indices) o utilizando alguno de los índices que están disponibles en la lista junto a la ayuda. <br/>
<br/>
Basta escribir uno o más términos en el cuadro de búsqueda y pulsar el botón \"Buscar\". <br/>
También es posible realizar una búsqueda de todos los artículos utilizando el símbolo $ <br/>
O una búsqueda truncada con el término y el símbolo $ <br/>
Por ejemplo, una búsqueda por Brasil$, traerá Brasil, Brasileños y Brasileñas.";


?>
