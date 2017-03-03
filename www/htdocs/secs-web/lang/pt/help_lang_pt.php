<?php
/**
 * @file:			help_lang_pt.php
 * @desc:		    Portuguese language file, here are only the Help of filling the forms
 * @author:			Ana Katia Camilo <katia.camilo@bireme.org>
 * @author:			Bruno Neofiti <bruno.neofiti@bireme.org>
 * @author:			Domingos Teruel <domingos.teruel@bireme.org>
 * @since:          2009-05-07
 * @copyright:      (c) 2008 Bireme - PFI
 ******************************************************************************/

/****************** Information for translators *************************
 *
 * This Help file is divided in Sections as follows: Mask, Issues, Users, TitlePlus and Title
 * Above each variable there is a comment indicating the field tag of the corresponding ISIS database.
 * The help messages are presented in the same order as the fields appear in the sections of the SeCS-Web interface.
 * The variable names are constructed as follows: All start with the declaration $BVS_LANG followed by a label in square brackets,
 * starting with &#180;help&#180; or &#180;helper&#180; and the descriptive field name.
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

//The data is not record
$BVS_LANG["helpBasedMask"] = "Criar uma nova m&#225;scara baseada na m&#225;scara selecionada apenas para facilitar o preenchimento.<br />
Este dado n&#227;o &#233; armazenado na base de dados";

//field v801
$BVS_LANG["helpMaskName"] = "Registra-se neste campo o nome da m&#225;scara.<br />
Para adotar o mesmo padr&#227;o de nomes utilizado pelas m&#225;scaras j&#225; criadas (recomenda&#231;&#245;es do Taller Registro de Publicaciones Seriadas, realizado na BIREME em setembro de 1989), siga as seguintes indica&#231;&#245;es:<br />
O nome da m&#225;scara &#233; formado pelo c&#243;digo de freq&#252;&#234;ncia atribu&#237;do pelo ISDS, mais o n&#250;mero de volumes e/ou fasc&#237;culos de um ano considerado como t&#237;pico de publica&#231;&#227;o.<br />
Utilize a letra M para identificar volumes/fasc&#237;culos representados pelo nome dos meses, ap&#243;s o volume/fasc&#237;culo.<br />
O s&#237;mbolo + foi utilizado para identificar os fasc&#237;culos ou volumes com numera&#231;&#227;o crescente de 1 ao infinito.<br />
Exemplo:<br />
 M1V12F<br />
 Freq&#252;&#234;ncia Mensal, 1 volume por ano com 12 fasc&#237;culos por volume<br />
 Q4FM<br />
 Freq&#252;&#234;ncia trimestral, quatro fasc&#237;culos representados por meses, sem numera&#231;&#227;o de volumes<br />
 B6F+<br />
 Freq&#252;&#234;ncia bimestral, seis fasc&#237;culos com numera&#231;&#227;o crescente, sem numera&#231;&#227;o de volumes";

//field v860
$BVS_LANG["helpVolume"] = "O preenchimento deste campo esta condicionado a exist&#234;ncia de volumes na m&#225;scara criada.<br />
A Sequ&#234;ncia dos volumes &#233; um c&#243;digo utilizado para indicar ao Sistema se a numera&#231;&#227;o dos volumes &#233; crescente (Infinito) ou se repete (Finito) a cada ano.<br />
Para o registro deste campo &#233; necess&#225;rio observar se a numera&#231;&#227;o dos volumes de uma publica&#231;&#227;o seriada muda a cada ano de edi&#231;&#227;o ou se permanece a mesma a cada ano.<br />
Exemplo:<br />
Uma publica&#231;&#227;o com freq&#252;&#234;ncia trimestral publica 2 volumes por ano e a numera&#231;&#227;o de volumes muda a cada ano:<br />
<br />
Volume<br />
 1<br />
 1<br />
 2<br />
 2<br />
Sequ&#234;ncia de volumes: Infinito";

//field v880
$BVS_LANG["helpNumber"] = "O preenchimento deste campo esta condicionado a exist&#234;ncia de fasc&#237;culos na m&#225;scara criada.<br />
C&#243;digo que identifica a sequ&#234;ncia dos fasc&#237;culos, utilizado para indicar ao Sistema se a numera&#231;&#227;o dos fasc&#237;culos &#233; crescente (Infinito) ou se repete (Finito) a cada volume ou ano.<br />
Para o registro deste campo &#233; necess&#225;rio observar se a numera&#231;&#227;o dos fasc&#237;culos de uma publica&#231;&#227;o seriada &#233; crescente ou se &#233; igual a cada volume ou ano.<br />
Exemplo:<br />
Uma publica&#231;&#227;o de freq&#252;&#234;ncia trimestral: 1 volume ao ano com 4 fasc&#237;culos cada volume e a numera&#231;&#227;o de fasc&#237;culos &#233; igual a cada ano:<br />
 Fasc&#237;culo<br />
  1<br />
  2<br />
  3<br /> 
  4<br />
 Sequ&#234;ncia de n&#250;meros: Finito";



	/****************************************************************************************************/
	/**************************************** Issues Section - Field Helps ****************************************/
	/****************************************************************************************************/

//field v911
$BVS_LANG["helpFacicYear"] = "Ano correspondente data de publica&#231;&#227;o do fasc&#237;culo registrado.
Registre o ano correspondente ao fasc&#237;culo em n&#250;meros ar&#225;bicos.
Registre per&#237;odos de dois ou mais anos abrangendo um mesmo volume separado por
barra. O &#250;ltimo ano correspondente ao per&#237;odo deve ser registrado apenas com os
dois algarismos finais.<br />
<br />
Para o registro de publica&#231;&#245;es interrompidas abrangendo per&#237;odos de dois ou
mais anos registre o primeiro ano do per&#237;odo seguido de barra e os dois
algarismos finais do &#250;ltimo ano correspondente ao per&#237;odo interrompido e o
campo de estado de publica&#231;&#227;o deve ser preenchido com a letra I indica&#231;&#227;o de
que naquele per&#237;odo a publica&#231;&#227;o foi interrompida.<br />
<br />
Exemplos:<br />
a) ANO<br />
   1981/82<br />
<br />
b) ANO         Estado da Publica&#231;&#227;o<br />
   1982/84           I";

//field v912
$BVS_LANG["helpFacicVol"] = "N&#250;mero e/ou letras que identificam o volume correspondente ao fasc&#237;culo
registrado.
Registre a identifica&#231;&#227;o do volume em algarismos ar&#225;bicos. Se a identifica&#231;&#227;o
inclui letras estas tamb&#233;m devem ser registradas.
Quando dois ou mais volumes s&#243; publicados na mesma unidade f&#237;sica registre o
primeiro volume separado por barra do volume seguinte.
Volumes que n&#227;o foram publicados pelo editor em determinado ano devem ser
registrados e o campo de status deve conter a letra N indica&#231;&#227;o de que aquele
volume n&#227;o foi publicado.<br />
 <br />
Aten&#231;&#227;o:<br />
As informa&#231;&#245;es de volumes n&#227;o publicados s&#243; devem ser registradas se
confirmadas pelo editor.<br />
 <br />
Exemplos:<br />
a) VOLUME<br />
    123<br />
 <br />
b) VOLUME<br />
    123A<br />
 <br />
c) VOLUME<br />
    1/2<br />
 <br />
d) VOLUME<br />
    5/7<br />
 <br />
e) ANO    VOLUME    STATUS<br />
   1981      1        P<br />
   1982      2        N<br />
   1983      3        P";

//field v913
$BVS_LANG["helpFacicName"] = "N&#250;mero e/ou letra que identifica o fasc&#237;culo registrado.
Registre o n&#250;mero referente identifica&#231;&#227;o do fasc&#237;culo em algarismos
ar&#225;bicos. Se a identifica&#231;&#227;o inclui letras estas tamb&#233;m devem ser registradas.
&#237;ndices cumulativos devem ser registrados com os anos de abrang&#234;ncia no campo
de ANO e os volumes correspondentes no campo de VOLUME.
Para fasc&#237;culos que incluem dois ou mais n&#250;meros na mesma unidade f&#237;sica
registra-se o algarismo correspondente ao primeiro e o correspondente ao 
&#250;ltimo separados por barra (/).<br />
Fasc&#237;culos que n&#227;o foram publicados pelo editor devem ser registrados e no
campo de Estado de publica&#231;&#227;o registre a letra N, indica&#231;&#227;o de que aquele
fasc&#237;culo n&#227;o foi publicado.<br />
Registre os fasc&#237;culos identificados pelos meses no idioma correspondente e
conforme as para frequ&#234;ncias.<br />
 <br />
Exemplos:<br />
a) FASCICULO 1";

//field v910
$BVS_LANG["helpFacicMask"] = "M&#225;scaras usadas para frequ&#234;ncia de fasc&#237;culos.<br />
<br />
Ex: M1V12F";

//field v916
$BVS_LANG["helpFacicPubType"] = "Informa&#231;&#245;es complementares a respeito do fasc&#237;culo registrado, tais como:
n&#250;mero especial, n&#250;mero comemorativo, suplemento, fasc&#237;culos com subdivis&#245;es,
usando as seguintes instru&#231;&#245;es:<br />
 <br />
S    - para suplementos<br />
PT    - para fasc&#237;culos apresentando subdivis&#245;es<br />
NE   - para n&#250;mero especial, comemorativo ou extra<br />
IN   - para &#237;ndices<br />
AN   - para anu&#225;rios<br />
BI   - para suplemento identificado como bis<br />
E   - para fasc&#237;culos eletr&#244;nicos<br />
 <br />

Quando estes casos n&#227;o se apresentarem numerados registre apenas a conven&#231;&#227;o
correspondente.<br />
 <br />
Exemplos:<br />
<br />
a)	S<br />
b)	NE";

//field v914
$BVS_LANG["helpPubEst"] = "Situa&#231;&#227;o dos fasc&#237;culos dentro da cole&#231;&#227;o da biblioteca.<br />
Registre a situa&#231;&#227;o do fasc&#237;culo conforme as seguintes instru&#231;&#245;es:<br />
 <br />
P    - sempre que o fasc&#237;culo estiver presente na cole&#231;&#227;o<br />
 <br />
A    - sempre que o fasc&#237;culo estiver ausente na cole&#231;&#227;o<br />
 <br />
N    - sempre que volumes ou fasc&#237;culos n&#227;o forem publicados<br />
       durante um determinado ano<br />
 <br />
I    - para publica&#231;&#245;es interrompidas durante determinado   <br />
       per&#237;odo<br />
 <br />
Exemplos:<br />
a)<br />
ANO     VOLUME    FASCICULO  P/A<br />
1981      1           1       P<br />
1981      1           2       A<br />
1981      1           3       P<br />
 <br />
b)<br />
ANO     VOLUME    FASCICULO   P/A<br />
1980      1           2        P<br />
1981      2           1        N<br />
1981      2           2        P<br />
1982/83                        I<br />
1984      3           1        P";

//field v915
$BVS_LANG["helpQtd"] = "N&#250;mero de exemplares (duplicatas) correspondentes ao fasc&#237;culo registrado.<br />
Registre o n&#250;mero total de exemplares correspondentes ao fasc&#237;culo registrado.<br />
 <br />
Exemplos:<br />
a)<br />
ANO     VOLUME    FASCICULO    P/A       QT<br />
1985      53          1         P         1<br />
1985      53          2         P         2<br />
1985      53          3         P         2<br />
1985      53          4         P         2";

//field v925
$BVS_LANG["helptextualDesignation"] = "Designação textual e/ou designação específica.";

//field v926
$BVS_LANG["helpstandardizedDate"] = "Data normalizada.";

//field v917
$BVS_LANG["helpInventoryNumber"] = "N&#250;mero patrimonial que identifica unicamente cada objeto do acervo da biblioteca.";

//field v918
$BVS_LANG["helpEAddress"] = "Indica&#231;&#227;o do endere&#231;o (URL) do documento.";

//field v900
$BVS_LANG["helpFacicNote"] = "Informa&#231;&#245;es relativas a qualquer aspecto do fasc&#237;culo que est&#225; sendo
registrado.<br />
Registre neste campo, em linguagem livre, informa&#231;&#245;es relativas a qualquer
aspecto do fasc&#237;culo que est&#225; sendo registrado.<br />
 <br />
Exemplo: Fasc&#237;culo em condi&#231;&#245;es muito ruins para Xerox, solicitada reposi&#231;&#227;o.";





	/****************************************************************************************************/
	/**************************************** Users Administration Section - Field Helps ****************************************/
	/****************************************************************************************************/

//field v1
$BVS_LANG["helpUser"] = "Nome do usu&#225;rio utlizado para efetuar login na SeCSWeb.";

//field v3
$BVS_LANG["helpPassword"] = "Senha usada para efetuar login na SeCSWeb";

//data not record
$BVS_LANG["helpcPassword"] = "Digitar novamente a senha";

//field v4
$BVS_LANG["helpRole"] = "Op&#231;&#227;o de perfil do usu&#225;rio<br />
Ex: Administrador, Editor, Documentalista";

//field v8
$BVS_LANG["helpFullname"] = "Dever&#225; constar o nome do usu&#225;rio<br />
Ex: Raquel Cristina Martins de Ara&#250;jo";

//field v11
$BVS_LANG["helpEmail"] = "Dever&#225; constar o e-mail do usu&#225;rio<br />
Ex: raquel.araujo@bireme.org";

//field v9
$BVS_LANG["helpInstitution"] = "Dever&#225; constar o nome da Institui&#231;&#227;o<br />
Ex: BIREME - OPAS/OMS - Centro Latino-Americano e do Caribe de Informa&#231;&#227;o em Ci&#234;ncias da Sa&#250;de";

//field v5
$BVS_LANG["helpCenterCod"] = "Dever&#225; constar o c&#243;digo do centro<br />
Ex: BR1.1";

//field v10
$BVS_LANG["helpNotes"] = "Descri&#231;&#227;o geral sobre o usu&#225;rio e/ou campos<br />
Ex: testing English translation<br />
      SeCS-Web standart editor user. Usu&#225;rio Editor padr&#227;o do SeCS-Web<br />
      Nota usu&#225;rio";

//field v12
$BVS_LANG["helpLang"] = "Op&#231;&#227;o de perfil da interface<br />
Ex: Espanhol<br />
       Portugu&#234;s";

//field v2
$BVS_LANG["helpUsersAcr"] = "Dever&#225; constar as iniciais do usu&#225;rio ou sigla equivalente<br />
Ex: RCMA";



	/****************************************************************************************************/
	/**************************************** Title Plus Section - Field Helps ****************************************/
	/****************************************************************************************************/

//field v901
$BVS_LANG["helperAcquisitionMethod"] = "Defini&#231;&#227;o que representa a forma de aquisi&#231;&#227;o do peri&#243;dico<br />
Selecione a op&#231;&#227;o que identifica a forma de aquisi&#231;&#227;o atual do peri&#243;dico<br />
Exemplo: <br />
Compra<br />
Doa&#231;&#227;o<br />
Permuta<br />
Outros";

//field v902
$BVS_LANG["helperAcquisitionControl"] = "Indica&#231;&#227;o do status do peri&#243;dico:<br />
Selecione a op&#231;&#227;o que identifica o status atual do peri&#243;dico:<br />
N&#227;o se conhece<br />
Corrente<br />
N&#227;o corrente<br />
Encerrada<br />
Suspensa";

//field v905
$BVS_LANG["helperProvider"] = "Nome do provedor comercial ou n&#227;o da publica&#231;&#227;o<br />
Se n&#227;o estiver a usar a base de cadastro de provedores do ABCD, recomenda-se registrar tamb&#233;m o telefone, site da internet, e o e-mail eletr&#244;nico da pessoa de contato neste campo<br />
Se  o  m&#233;todo  de  aquisi&#231;&#227;o   for doa&#231;&#227;o, registre no campo 912 as condi&#231;&#245;es da doa&#231;&#227;o<br />
Se o m&#233;todo de aquisi&#231;&#227;o for permuta, registre no campo 903 as publica&#231;&#245;es que s&#227;o enviadas<br />";

//field v904
$BVS_LANG["helperProviderNotes"] = "Registre neste campo informa&#231;&#245;es sobre o provedor<br />";

//field v906
$BVS_LANG["helperExpirationSubs"] = "Data de vencimento da compra do peri&#243;dico sugerido no formato data ISO<br />
Lembre-se de mudar o prazo de validade ap&#243;s a renova&#231;&#227;o da assinatura<br />
Exemplo. AAAAMMDD";

//field v903
$BVS_LANG["helperReceivedExchange"] = "T&#237;tulo do peri&#243;dico utilizado na permuta<br />
Preenchimento obrigat&#243;rio se o m&#233;todo de aquisi&#231;&#227;o for permuta<br />";

//field v912
$BVS_LANG["helperDonorNotes"] = "Usa-se para casos de assinaturas com fundos de projetos, ou doa&#231;&#245;es com restri&#231;&#245;es especiais<br />
Registre as condi&#231;&#245;es sob as quais recebe este seriado em doa&#231;&#227;o<br />
Preenchimento obrigat&#243;rio se o m&#233;todo de aquisi&#231;&#227;o for doa&#231;&#227;o<br />
Exemplos: <br />
a) Pago com fundos de USAID para o projeto 2009_CL_Y35<br />
b) A cole&#231;&#227;o deve estar separada da cole&#231;&#227;o geral e indicar em cartaz o nome da funda&#231;&#227;o que a mant&#233;m<br />
c) Oferta de prova para o ano 2009 somente<br />";

//field 913
$BVS_LANG["helperAcquisitionHistory"] = "Informações relativas a históricos das assinaturas, valor pago pela assinatura, indicação
dos fascículos que inclui a compra. Subcampos que compõe
o campo de dado:<br/>
(d) Data do pagamento da assinatura<br/>
(v) Valor pago pela assinatura<br/>
(a) Ano que inclui a assinatura<br/>
(f) fascículos que inclui a assinatura<br/>";

$BVS_LANG["helperAcquisitionHistoryD"] = "Data do pagamento da assinatura.";
$BVS_LANG["helperAcquisitionHistoryV"] = "Valor pago pela assinatura.";
$BVS_LANG["helperAcquisitionHistoryA"] = "Ano que inclui a assinatura.";
$BVS_LANG["helperAcquisitionHistoryF"] = "Fascículos que inclui a assinatura.";

//field v946
$BVS_LANG["helperacquisitionPriority"] = "Nome que define a prioridade da aquisi&#231;&#227;o do peri&#243;dico, na Institui&#231;&#227;o<br />
Para estabelecer as prioridades exigidas, consultar se necess&#225;rio, o Comit&#234; de Bibliotecas, membros da comunidade acad&#234;mica e/ou especialistas.<br />
Selecione a op&#231;&#227;o que identifica a prioridade de aquisi&#231;&#227;o do peri&#243;dico<br />
Exemplos:<br />
Para t&#237;tulos cuja aquisi&#231;&#227;o &#233; imprescind&#237;vel no centro informante.<br />
Para t&#237;tulos cuja aquisi&#231;&#227;o &#233; prescind&#237;vel pois existe no pa&#237;s.<br />
Para t&#237;tulos cuja aquisi&#231;&#227;o &#233; prescind&#237;vel pois existe na regi&#227;o.<br />";

//field v907
$BVS_LANG["helperLocationRoom"] = "C&#243;digo que representa a localiza&#231;&#227;o f&#237;sica do peri&#243;dico no acervo. Para bibliotecas muito grandes, sugere construir c&#243;digos incluindo indica&#231;&#227;o de sala e estante, quando necess&#225;rio
Registre o n&#250;mero de chamada do peri&#243;dico descrito<br />
Exemplos: <br />
a) Numero de chamada: 0557<br />
b) Numero de chamada: R2-S3-0557<br />";

//field v908
$BVS_LANG["helperEstMap"] = "Nome do arquivo gr&#225;fico que apresenta a planta com a localiza&#231;&#227;o f&#237;sica do m&#243;vel onde est&#225; a publica&#231;&#227;o<br />
Exemplo:   PlantaA1-MovB3.jpg<br />";

//field v909
$BVS_LANG["helperOwnClassif"] = "Nota&#231;&#227;o de classifica&#231;&#227;o de assunto do peri&#243;dico, conforme o sistema de classifica&#231;&#227;o adotado na Institui&#231;&#227;o<br />
Havendo necessidade do registro de mais de uma classifica&#231;&#227;o, estas dever&#227;o ser transcritas uma em cada linha da caixa de texto do formul&#225;rio<br />";

//field v910
$BVS_LANG["helperOwnDesc"] = "Descritores controlados localmente que representam o conte&#250;do tem&#225;tico do peri&#243;dico<br />
Havendo necessidade do registro de mais de um descritor, estes dever&#227;o ser transcritos um em cada linha da caixa de texto do formul&#225;rio<br />";

//field v911
$BVS_LANG["helperAdmNotes"] = "Registre neste campo, em linguagem livre, informa&#231;&#245;es que sejam do interesse da Institui&#231;&#227;o respons&#225;vel pela descri&#231;&#227;o do peri&#243;dico.<br />
Havendo necessidade do registro de mais de uma nota, estas dever&#227;o ser transcritas uma em cada linha da caixa de texto do formul&#225;rio.<br />
Exemplo: A assinatura foi interrompida em 2009.<br />";


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
$BVS_LANG["helperrecordIdentification"] = "Campo de preenchimento autom&aacute;tico.<br />
N&#250;mero seq&#252;encial atribu&#237;do e controlado pelo Sistema<br />
Processador a fim de identificar o t&#237;tulo na base de dados.<br />
Registra-se neste campo o n&#250;mero correspondente ao t&#237;tulo que est&#225; sendo descrito.<br />
Este campo &#233; utilizado pelo sistema para fazer a liga&#231;&#227;o entre o registro do t&#237;tulo e os fasc&#237;culos correspondentes.<br />
<br />
Exemplos:<br />
     a) N&#250;mero de identifica&#231;&#227;o: 1050<br />
     b) N&#250;mero de identifica&#231;&#227;o: 415";

//field v100	 
$BVS_LANG["helperpublicationTitle"] = "Campo de preenchimento obrigat&#243;rio.<br />
T&#237;tulo principal ou pr&#243;prio do seriado no idioma e forma que aparece no mesmo, inclu&#237;ndo t&#237;tulo alternativo se existir, e exclu&#237;ndo t&#237;tulos paralelos e outras informa&#231;&#245;es sobre o t&#237;tulo.<br />
Registre o t&#237;tulo pr&#243;prio transcrevendo todos os elementos na ordem e como aparecem na p&#225;gina de rosto ou o que a substitui, respeitando as regras ortogr&#225;ficas do idioma correspondente.<br />
Consulte regras b&#225;sicas para o registro seguindo as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
T&#237;tulos hom&#244;nimos necessitam de um qualificador para diferenci&#225;-los (idioma, cidade, ano, etc.). <br />
Exemplos:<br />
a) T&#237;tulo da publica&#231;&#227;o: Revista chilena de neurocirug&#237;a<br />
b) T&#237;tulo da publica&#231;&#227;o: Revista brasileira de sa&#250;de ocupacional<br />
c) T&#237;tulo da publica&#231;&#227;o: Pediatria (S&#227;o Paulo)<br />
d) T&#237;tulo da publica&#231;&#227;o: Pediatr&#237;a (Bogot&#225;)<br />
e) T&#237;tulo da publica&#231;&#227;o: Endeavour (Span. ed.)<br />";

//field v140
$BVS_LANG["helpernameOfIssuingBody"] = "Entidade respons&#225;vel pelo conte&#250;do intelectual do seriado.<br />
Registre a men&#231;&#227;o de responsabilidade conforme aparece na p&#225;gina de rosto ou o que a substitui.<br />
Consulte regras b&#225;sicas para o registro seguindo as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br/>
Quando uma men&#231;&#227;o de responsabilidade inclui uma hierarquia, transcreve-se na forma e ordem que aparece no seriado separadas por v&#237;rgula.<br />
Quando uma men&#231;&#227;o de responsabilidade, em sua forma por extenso, &#233; parte integrante do t&#237;tulo da publica&#231;&#227;o (campo 100) n&#227;o &#233; necess&#225;rio repet&#237;-la neste campo.<br />
Este campo torna-se de preenchimento obrigat&#243;rio para seriados com t&#237;tulos representados por um termo gen&#233;rico, assim como Boletim, Anu&#225;rio, Revista etc., e seus correspondentes em outros idiomas.<br />
No caso de mais de uma men&#231;&#227;o de responsabilidade, registre na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR.<br />
Exemplos:<br />
a) Men&#231;&#227;o de responsabilidade: Academia Nacional de Medicina<br />
b) Men&#231;&#227;o de responsabilidade: Sociedade Brasileira de Cardiologia";

//field v149
$BVS_LANG["helperkeyTitle"] = "A designa&#231;&#227;o un&#237;voca atribu&#237;da a um recurso cont&#237;nuo pela Rede ISSN e indissoci&#225;vel do respectivo ISSN.
O t&#237;tulo-chave pode coincidir com o t&#237;tulo pr&#243;prio ou, de forma a tornar-se un&#237;voco,
  ser constru&#237;do pela adi&#231;&#227;o de elementos de identifica&#231;&#227;o ou qualifica&#231;&#227;o tais como nome da entidade editora, lugar de publica&#231;&#227;o,
  men&#231;&#227;o de edi&#231;&#227;o, etc.
<br />
Exemplo: ISSN 0340-0352 = IFLA journal<br />
 ISSN 0268-9707 = British Library Bibliographic Services newsletter<br />
 ISSN 0319-3012 = Image (Nicaragua ed.)";

//field v150ulo paralelo: Drug research
$BVS_LANG["helperabbreviatedTitle"] = "T&#237;tulo pr&#243;prio do seriado na forma abreviada.<br />
Registre o t&#237;tulo abreviado respeitando as mai&#250;sculas, min&#250;sculas e acentua&#231;&#227;o, conforme 
a Lista estabelecida e mantida pelo Centro Internacional ISSN de acordo com ISO-4 - Informa&#231;&#227;o e Documenta&#231;&#227;o - Regras para a abreviatura de palavras do t&#237;tulo e de t&#237;tulos das publica&#231;&#245;es.<br />
Este campo &#233; de preenchimento obrigat&#243;rio para t&#237;tulos que s&#227;o indexados em LILACS e/ou MEDLINE.<br />
Exemplos:<br />
a)T&#237;tulo da publica&#231;&#227;o: Revista brasileira de sa&#250;de ocupacional<br />
  T&#237;tulo abreviado: Rev. bras. sa&#250;de ocup<br />
b)T&#237;tulo da publica&#231;&#227;o:Endeavour (Spanish ed.)<br />
  T&#237;tulo abreviado: Endeavour (Span. ed.)<br />
c)T&#237;tulo da publica&#231;&#227;o: Pediatria (S&#227;o Paulo)<br />
  T&#237;tulo abreviado: Pediatria (S&#227;o Paulo)";

//field v180
$BVS_LANG["helperabbreviatedTitleMedline"] = "T&#237;tulo do seriado na forma abreviada<br />
Para fins de pesquisa e de exporta&#231;&#227;o de dados, adicione varia&#231;&#245;es da abreviatura utilizadas nas bases de dados com as quais coopera<br />
Este campo &#233; de preenchimento obrigat&#243;rio para t&#237;tulos que s&#227;o indexados em LILACS e/ou MEDLINE<br />
Clique no bot&#227;o SUBCAMPO e digite o c&#243;digo da base e o t&#237;tulo abreviado<br />
No caso de mais de uma base, registre na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR<br />
Exemplo: para REVISTA BRASILEIRA DE ENTOMOLOGIA<br />
ISO^aRev. Bras. Entomol.<br />
JCR^aREV BRAS ENTOMOL<br />
MDL^aRev Bras Entomol<br />
LL^aRev. bras. entomol.<br />
LATINDEX^aRev. Bras. Entomol. (Impr.)<br />
SciELO^aRev. Bras. entomol.";


	/**************************************** Step 2  ****************************************/

//field v110
$BVS_LANG["helpersubtitle"] = "Qualquer informa&#231;&#227;o subordinada ao t&#237;tulo principal que o completa, qualifica ou o torna mais expl&#237;cito.<br />
Registre, neste campo, apenas informa&#231;&#245;es definidas como subt&#237;tulo e desde que o subt&#237;tulo seja valioso para a identifica&#231;&#227;o do seriado. Varia&#231;&#245;es do t&#237;tulo devem ser registradas em campos espec&#237;ficos.<br />
Exemplos:<br />
a) T&#237;tulo da publica&#231;&#227;o: MMWR<br />
Subt&#237;tulo: morbidity and mortality weekly report";

//field v120
$BVS_LANG["helpersectionPart"] = "Designa&#231;&#227;o num&#233;rica ou alfab&#233;tica de se&#231;&#227;o, parte, etc., que completa o t&#237;tulo pr&#243;prio e que depende dele para sua identifica&#231;&#227;o e compreens&#227;o.<br />
Registre as palavras s&#233;rie, se&#231;&#227;o ou outro equivalente somente quando fazem parte do t&#237;tulo.<br />
A primeira letra da palavra significativa deve ser registrada em mai&#250;scula.<br />
Exemplos:
<br />a) T&#237;tulo da publica&#231;&#227;o: Bulletin signaletique<br />
Se&#231;&#227;o/parte: Section 330<br />
b) T&#237;tulo da publica&#231;&#227;o: Acta pathologica et microbiologica scandinavica<br />
Se&#231;&#227;o/parte: Section A";

//field v130
$BVS_LANG["helpertitleOfSectionPart"] = "Nome da se&#231;&#227;o, parte ou suplemento que completa e depende do t&#237;tulo pr&#243;prio para sua identifica&#231;&#227;o e compreens&#227;o.<br />
Registre neste campo o nome da se&#231;&#227;o, parte ou suplemento transcrevendo-o como aparece na p&#225;gina de rosto ou o que a substitui, registrando em mai&#250;scula a primeira letra.<br />
No caso de suplementos com t&#237;tulos id&#234;nticos ao t&#237;tulo principal e que constituem um novo t&#237;tulo, registre neste campo a palavra Suplemento para distinguir um t&#237;tulo do outro.<br />
Exemplos:<br />
a) T&#237;tulo da publica&#231;&#227;o: Acta amazonica<br />
T&#237;tulo se&#231;&#227;o/parte: Suplemento<br />
b) T&#237;tulo da publica&#231;&#227;o:  Bulletin signaletique<br />
Se&#231;&#227;o/parte: Section 330<br />
T&#237;tulo se&#231;&#227;o/parte: Sciences pharmacologiques";

//field v230
$BVS_LANG["helperparallelTitle"] = "T&#237;tulo pr&#243;prio do seriado que aparece tamb&#233;m em outros idiomas na p&#225;gina de rosto ou o que a substitui.<br />
Registre t&#237;tulos paralelos conforme a sequ&#234;ncia e tipografia em que aparecem na p&#225;gina de rosto ou parte que a substitui de acordo com as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
Se o seriado possui t&#237;tulos paralelos que incluem se&#231;&#227;o, parte ou suplemento em outros idiomas, registre na sequ&#234;ncia separando os elementos (t&#237;tulo comum e t&#237;tulo da se&#231;&#227;o, parte ou suplemento) por ponto.<br />
No caso de mais de um t&#237;tulo paralelo, registra-se na sequ&#234;ncia, clicando no bot&#227;o INSERIR.<br />
Exemplos:<br />
a) T&#237;tulo da publica&#231;&#227;o: Archives of toxicology<br />
T&#237;tulo paralelo: Archiv fur toxikologie<br />
b) T&#237;tulo da publica&#231;&#227;o: Arzneimittel forschung<br />
T&#237;tulo paralelo: Drug research";

//field v240
$BVS_LANG["helperotherTitle"] = "Outras varia&#231;&#245;es do t&#237;tulo pr&#243;prio que aparecem no seriado tais como: t&#237;tulo da capa quando diferente da p&#225;gina de rosto, t&#237;tulo por extenso e outras formas do t&#237;tulo.<br />
Inclua aqui varia&#231;&#245;es (menores) do t&#237;tulo pr&#243;prio que n&#227;o necessitam considerar-se um novo registro, mas que justificam para sua recupera&#231;&#227;o.<br />
No caso de mais de uma varia&#231;&#227;o, registre-se na sequ&#234;ncia, clicando no bot&#227;o INSERIR <br />
Exemplos:<br />
a) T&#237;tulo da publica&#231;&#227;o: Boletin de la Academia Nacional de<br />
   Medicina de Buenos Aires<br />
   Outras formas do t&#237;tulo: Boletin de la Academia de<br />
   Medicina de Buenos Aires<br />
b) T&#237;tulo da publica&#231;&#227;o: Folha m&#233;dica<br />
   Outras formas do t&#237;tulo: FM: a folha m&#233;dica";

//field v510
$BVS_LANG["helpertitleHasOtherLanguageEditions"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e edi&#231;&#245;es do mesmo t&#237;tulo em outros idiomas. <br />
Registre o t&#237;tulo da edi&#231;&#227;o em outro idioma na forma que aparece no seriado, seguindo as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>. <br />
Clique no bot&#227;o SUBCAMPO e digite o t&#237;tulo e ISSN na planilha que aparece. (Na base de dados, o indicador de subcampo de ISSN &#233; ^x e se agrega automaticamente). <br />
No caso de mais de uma edi&#231;&#227;o em outros idiomas, registre na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR. <br />
Exemplos: <br />
a)->T&#237;tulo da publica&#231;&#227;o: Materia medica polona (English ed.)^x0025-5246<br />
    Tem edi&#231;&#227;o em outro idioma: 	Materia medica polona (Ed. Fran&#231;aise)^x0324-8933<br />
b) T&#237;tulo da publica&#231;&#227;o: World health^x0043-8502<br />
   Tem edi&#231;&#227;o em outro idioma: 	Salud mundial^x0250-9318<br />
                                               	Sa&#250;de do mundo^x0250-930X<br />
                                               	Sant&#233; du monde^x0250-9326<br />";

//field v520
$BVS_LANG["helpertitleAnotherLanguageEdition"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e suas edi&#231;&#245;es em outros idiomas. <br />
Registre o t&#237;tulo do qual &#233; edi&#231;&#227;o em outro idioma, na forma que  aparece na publica&#231;&#227;o, seguindo as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
Clique no bot&#227;o SUBCAMPO e, digite o t&#237;tulo e ISSN na planilha que aparece. (Na base de dados, o indicador de subcampo de ISSN &#233; ^x e se agrega automaticamente). <br />
 Exemplos: <br />
a) T&#237;tulo da publica&#231;&#227;o: Materia medica polona (Ed. fran&#231;aise)^x0324-8933<br />
       É edi&#231;&#227;o em outro idioma de: Materia medica polona (English ed.)^x0025-5246<br />
b) T&#237;tulo da publica&#231;&#227;o: Salud mundial^x0250-9318<br />
     É edi&#231;&#227;o em outro idioma de: World health^x0043-8502<br />";

//field v530
$BVS_LANG["helpertitleHasSubseries"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e suas subs&#233;ries (revistas com t&#237;tulo e numera&#231;&#227;o pr&#243;pria publicadas como parte de uma s&#233;rie mais ampla). <br />
Registre neste campo, o t&#237;tulo da subs&#233;rie na forma que aparece no seriado, seguindo as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
Clique o bot&#227;o SUBCAMPO e, digite o t&#237;tulo e ISSN na planilha que aparece. (Na base de dados, o indicador de subcampo de ISSN &#233; ^x e se agrega automaticamente). <br />
No caso de mais de uma subs&#233;rie, registra-se os t&#237;tulos na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR. <br />
Exemplos: <br />
a) T&#237;tulo da publica&#231;&#227;o: Biochimica et biophysica acta^x0006-3002<br />
   Tem subs&#233;rie: 	Biochimica et biophysica acta. Biomembranes^x0005-2736<br />";
   
//field v540
$BVS_LANG["helpertitleIsSubseriesOf"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e o t&#237;tulo maior. <br />
Registre o t&#237;tulo do seriado ao qual a subs&#233;rie est&#225; ligada, seguindo as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
Clique o bot&#227;o SUBCAMPO e, digite o t&#237;tulo e ISSN na planilha que aparece. (Na base de dados, o indicador de subcampo de ISSN &#233; ^x e se agrega automaticamente). <br />
Exemplos: <br />
a) T&#237;tulo da publica&#231;&#227;o: Biochimica et biophysica acta^x0924-1086<br />
   T&#237;tulo da se&#231;&#227;o/parte:  Enzymology<br />
   É subs&#233;rie de: Biochimica et biophysica acta^x0006-3002<br />";

//field v550
$BVS_LANG["helpertitleHasSupplementInsert"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e suplementos/insertos (t&#237;tulos editados geralmente separados com numera&#231;&#227;o pr&#243;pria que complementam o t&#237;tulo principal) <br />
Registre neste campo, o t&#237;tulo do suplemento/inserto seguindo as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
Clique no bot&#227;o SUBCAMPO e, digite o t&#237;tulo e ISSN na planilha que aparece. (Na base de dados, o indicador de subcampo de ISSN &#233; ^x e se agrega automaticamente). <br />
No caso de mais de um suplemento/inserto, registre na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR. <br />
Exemplos: <br />
 a) T&#237;tulo da publica&#231;&#227;o: Scandinavian journal of plastic and
reconstructive surgery^x0036-5556<br />
    Tem suplemento ou inser&#231;&#227;o: Scandinavian journal of plastic and reconstructive surgery. Supplement^x0581-9474<br />
b)	T&#237;tulo da publica&#231;&#227;o: Tubercle^x0041-3879<br />
       Tem suplemento ou inser&#231;&#227;o: BTTA review^x0300-9602<br />";

//field v560
$BVS_LANG["helpertitleIsSupplementInsertOf"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e o t&#237;tulo principal. <br />
Registre o t&#237;tulo pr&#243;prio do seriado ao qual o suplemento/inserto est&#225; ligado seguindo as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
Clique o bot&#227;o SUBCAMPO e, digite o t&#237;tulo e ISSN na planilha que aparece. (Na base de dados, o indicador de subcampo de ISSN &#233; ^x e se agrega automaticamente). <br />
Exemplos: <br />
a) T&#237;tulo da publica&#231;&#227;o: Scandinavian journal of plastic and reconstructive surgery^x0581-9474<br />
    T&#237;tulo da se&#231;&#227;o/parte: Supplement<br />
    É suplemento ou inserto de: Scandinavian journal of plastic and reconstructive surgery^x0036-5556<br />
b) T&#237;tulo da publica&#231;&#227;o: BTTA review^x0300-9602<br />
     É suplemento ou inser&#231;&#227;o de : Tubercle^x0041-3879<br />";


	/**************************************** Step 3  ****************************************/

//field v610
$BVS_LANG["helpertitleContinuationOf"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e seus t&#237;tulos anteriores.<br />
Registre o t&#237;tulo anterior da publica&#231;&#227;o, seguindo as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
Clique no bot&#227;o SUBCAMPO e, digite o t&#237;tulo e ISSN na planilha que aparece. (Na base de dados, o indicador de subcampo de ISSN &#233; ^x e se agrega automaticamente) .<br />
No caso de mais de um t&#237;tulo anterior, registra-se na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR.<br />
Exemplos: .<br />
 a) T&#237;tulo da publica&#231;&#227;o: Revista argentina de urolog&#237;a y nefrologia^x0048-7627.<br />
    Continua&#231;&#227;o de: Revista argentina de urologia^x0325-2531.<br />
 b) T&#237;tulo da publica&#231;&#227;o: Revista de la Asociaci&#243;n M&#233;dica Argentina^x0004-4830.<br />
    Continua&#231;&#227;o de: Revista de la Sociedad M&#233;dica Argentina^x0327-1633.<br />";

//field v620
$BVS_LANG["helpertitlePartialContinuationOf"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e sua continua&#231;&#227;o parcial.<br />
Registre o t&#237;tulo anterior do seriado, seguindo as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
Clique no bot&#227;o SUBCAMPO e, digite o t&#237;tulo e ISSN na planilha que aparece. (Na base de dados, o indicador de subcampo de ISSN &#233; ^x e se agrega automaticamente) .<br />
No caso de mais de um t&#237;tulo anterior, registra-se na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR.<br />
Exemplos: .<br />
a) T&#237;tulo da publica&#231;&#227;o: Comptes rendus hebdomadaires de seances de l&#180;Academie des Sciences^x0567-655X.<br />
   Se&#231;&#227;o/parte: Serie D.<br />
   T&#237;tulo da se&#231;&#227;o/parte: Sciences naturelles.<br />
   Continua&#231;&#227;o parcial de: Comptes rendus hebdomadaires de seances de l&#180;Academie de Sciences^x0001-4036.<br />";

//field v650
$BVS_LANG["helpertitleAbsorbed"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e o(s) t&#237;tulo(s) que ele absorveu. .<br />
Registre o t&#237;tulo anterior da publica&#231;&#227;o, seguindo as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
Clique no bot&#227;o SUBCAMPO e, digite o t&#237;tulo e ISSN na planilha que aparece. (Na base de dados, o indicador de subcampo de ISSN &#233; ^x e se agrega automaticamente). .<br />
No caso de mais de um t&#237;tulo anterior, registra-se na sequencia, clicando no bot&#227;o INSERIR. .<br />
Exemplos: .<br />
 a) T&#237;tulo da publica&#231;&#227;o: Revista brasileira de oftalmologia^x0034-7280.<br />
    Absorveu: Boletim da Sociedade Brasileira de Oftalmologia^x0583-7820.<br />";

//field v660
$BVS_LANG["helpertitleAbsorbedInPart"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e o(s) t&#237;tulo(s) que ele absorveu em parte. .<br />
Registre o t&#237;tulo anterior do seriado, seguindo as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
Clique no bot&#227;o SUBCAMPO e, digite o t&#237;tulo e ISSN na planilha que aparece. (Na base de dados, o indicador de subcampo de ISSN &#233; ^x e se agrega automaticamente). .<br />
No caso de mais de um t&#237;tulo anterior, registre na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR.<br />
Exemplos: .<br />
a) T&#237;tulo da publica&#231;&#227;o: Journal of pharmacology and experimental therapeutics^x0022-3565.<br />
   Absorveu em parte: Pharmacological reviews^x0031-6997.<br />";

//field v670
$BVS_LANG["helpertitleFormedByTheSplittingOf"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e t&#237;tulos pelos quais, atrav&#233;s de subdivis&#227;o, ele foi formado. <br />
Registre o t&#237;tulo anterior do seriado, seguindo as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
Clique no bot&#227;o SUBCAMPO e, digite o t&#237;tulo e ISSN na planilha que aparece. (Na base de dados, o indicador de subcampo de ISSN &#233; ^x e se agrega automaticamente). .<br />
No caso de mais de um t&#237;tulo anterior, registre na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR. .<br />
Exemplos: .<br />
a) T&#237;tulo da publica&#231;&#227;o: Acta neurologica belgica^x0300-9009.<br />
   Formado pela subdivis&#227;o de: Acta neurologica et psychiatrica belgica^x0001-6284.<br />";

//field v680
$BVS_LANG["helpertitleMergeOfWith"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e t&#237;tulos que se fundiram formando o atual.<br />
Registre os t&#237;tulos anteriores do seriado, seguindo as <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
Clique no bot&#227;o SUBCAMPO e, digite o t&#237;tulo e ISSN na planilha que aparece. (Na base de dados, o indicador de subcampo de ISSN &#233; ^x e se agrega automaticamente).<br />
No caso de mais de um t&#237;tulo anterior, registre na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR. .<br />
 Exemplos: .<br />
 a) T&#237;tulo da publica&#231;&#227;o: Revista de psiquiatria din&#226;mica^x0034-8767.<br />
    Fus&#227;o de...com...: Arquivos da cl&#237;nica Pinel^x0518-7311.<br />
                                 Psiquiatria (Porto Alegre)^x0552-4377.<br />
 b) T&#237;tulo da publica&#231;&#227;o: Gerontology^x0304-434X.<br />
    Fus&#227;o de...com...: Gerontologia Cl&#237;nica^x0016-8998 .<br />
                                 Gerontologia^x0016-898X.<br />";

//field v710
$BVS_LANG["helpertitleContinuedBy"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e sua continua&#231;&#227;o posterior.<br />
Registre o t&#237;tulo posterior do seriado, <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
No caso de mais de um t&#237;tulo posterior, registre na sequ&#234;ncia, clicando no bot&#227;o INSERIR. .<br />
Exemplos:<br />
a) T&#237;tulo da publica&#231;&#227;o: Anais da Faculdade de Farm&#225;cia e Odontologia da Universidade de S&#227;o Paulo ^x0365-2181<br />
   Continuado por: Revista da Faculdade de Odontologia da Universidade de S&#227;o Paulo^x0581-6866";

//field v720
$BVS_LANG["helpertitleContinuedInPartBy"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo entre o t&#237;tulo que esta sendo descrito e suas continua&#231;&#245;es parciais.<br />
Registre o t&#237;tulo posterior do seriado, <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
No caso de mais de um t&#237;tulo posterior, registre na sequ&#234;ncia, clicando no bot&#227;o INSERIR. .<br />
Exemplos:<br />
a) T&#237;tulo da publica&#231;&#227;o: Annales de mibrobiologie^x 0300-5410<br />
   Continuado em parte por: Annales de virologie^x0242-5017<br />
b) T&#237;tulo da publica&#231;&#227;o: Journal of clinical psychology^x0021-9762<br />
   Continuado em parte por:  Journal of comunity psychology^x0090-4392";

//field v750
$BVS_LANG["helpertitleAbsorbedBy"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e o t&#237;tulo que o absorveu.<br />
Registre o t&#237;tulo posterior do seriado, <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
No caso de mais de um t&#237;tulo posterior, registre na sequ&#234;ncia, clicando no bot&#227;o INSERIR. .<br />
Exemplos:<br />
a) T&#237;tulo da publica&#231;&#227;o: Boletim da Sociedade Brasileira de Oftalmologia^x0583-7820<br />
   Absorvido por: Revista brasileira de oftalmologia^x0034-7280<br />";

//field v760
$BVS_LANG["helpertitleAbsorbedInPartBy"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e o t&#237;tulo pelo qual foi absorvido em parte.<br />
Registre o t&#237;tulo posterior do seriado, <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
No caso de mais de um t&#237;tulo posterior, registre na sequ&#234;ncia, clicando no bot&#227;o INSERIR. .<br />
Exemplos:<br />
a) T&#237;tulo da publica&#231;&#227;o: Health and social service journal^x0300-8347<br />
   Absorvido em parte por:  Community medicine^x0300-5917";

//field v770
$BVS_LANG["helpertitleSplitInto"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e o t&#237;tulo que se subdividiu.<br />
Registre o t&#237;tulo posterior do seriado, <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
No caso de mais de um t&#237;tulo posterior, registre na sequ&#234;ncia, clicando no bot&#227;o INSERIR. .<br />
Exemplos:<br />
a) T&#237;tulo da publica&#231;&#227;o: Acta neurologica et psiqui&#225;trica B&#233;lgica^x0001-6284<br />
   Subdividiu-se em: Acta neurologica b&#233;lgica^x0300-9009<br />
   Acta psychiatrica b&#233;lgica^x0300-8967<br />";

//field v780
$BVS_LANG["helpertitleMergedWith"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e o t&#237;tulo com o qual fundiu-se.<br />
Registre os t&#237;tulos <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
No caso de mais de uma fus&#227;o, registre os t&#237;tulos na sequ&#234;ncia, clicando no bot&#227;o INSERIR. .<br />
Exemplos:<br />
a) T&#237;tulo da publica&#231;&#227;o: Anais da Faculdade de Farm&#225;cia e Odontologia da Universidade de S&#227;o Paulo^0365-2181<br />
b)	Fundiu-se com: Estomatologia e cultura^x0014-1364<br />
Revista da Faculdade de Odontologia de Ribeir&#227;o Preto^x0102-129X<br />";

//field v790
$BVS_LANG["helpertitleToForm"] = "Nota que atua como elemento de liga&#231;&#227;o entre o t&#237;tulo que esta sendo descrito e os t&#237;tulos registrados no campo 780<br />
Registre o t&#237;tulo posterior do seriado que se formou a partir da fus&#227;o com os t&#237;tulos registrados no campo 780, <a href=javascript:showISBD(\'pt\');>normas ISBD - consolidated edition 2007</a>.<br />
No caso de mais de um t&#237;tulo formado, registre os t&#237;tulos na sequ&#234;ncia, clicando no bot&#227;o INSERIR. .<br />
Exemplos:<br />
a) T&#237;tulo da publica&#231;&#227;o: Anais da Faculdade de Farm&#225;cia e Odontologia da Universidade de S&#227;o Paulo^x0365-2181<br />
Fundiu-se com: Estomatologia e cultura^x0014-1364<br />
              Revista da Faculdade de Odontologia de Ribeir&#227;o Preto^x0102-129X<br />
Para formar: Revista de odontologia da Universidade de S&#227;o Paulo^x0103-0663<br />
<br />
b) T&#237;tulo da publica&#231;&#227;o: Psiquiatria (Porto Alegre)^x0552-4377<br />
Fundiu-se com:  Arquivos da cl&#237;nica Pinel^x0518-7311<br />
Para formar: Revista de psiquiatria din&#226;mica^x0034-8767";


	/**************************************** Step 4  ****************************************/

//field v480
$BVS_LANG["helperpublisher"] = "Nome do editor comercial e/ou publicador do seriado.<br />
Registre o nome do editor respons&#225;vel comercialmente pela publica&#231;&#227;o do seriado conforme aparece no mesmo.<br />
Quando o editor for o mesmo que a men&#231;&#227;o de responsabilidade n&#227;o &#233; necess&#225;rio repet&#237;-lo neste campo, salvo quando &#233; imprescind&#237;vel para aquisi&#231;&#227;o.<br />
No caso de mais de um editor comercial/publicador<br />registra-se o primeiro que aparece ou o que coincide com o local de publica&#231;&#227;o.<br />
Exemplos:<br />
a) Editor comercial: Pergamon Press<br />
b) Editor comercial: Plenum Press";

//field v490
$BVS_LANG["helperplace"] = "Nome do local (cidade) onde se edita e/ou publica o seriado descrito.<br />
Registre o nome da cidade por extenso no idioma que aparece na publica&#231;&#227;o.<br />
Quando o t&#237;tulo aparece em mais de um idioma, registre a cidade no idioma em que se registrou o t&#237;tulo proprio.<br />
Quando n&#227;o &#233; poss&#237;vel determinar o local de edi&#231;&#227;o e/ou publica&#231;&#227;o do seriado, registre a abreviatura s.l (sem local).<br />
Exemplos:<br />
a) Cidade: S&#227;o Paulo<br />
b) Cidade: Porto Alegre<br />
c) Cidade: s.l";

//field v310
$BVS_LANG["helpercountry"] = "C&#243;digo do pa&#237;s onde se publica o seriado.<br />
Seleciona-se do &#237;ndice o nome do pa&#237;s. Na base ser&#225; gravado o c&#243;digo ISO do pa&#237;s.<br />
Exemplos:<br />
a) Pa&#237;s de publica&#231;&#227;o: Brasil<br />
b) Pa&#237;s de publica&#231;&#227;o: Chile";

//field v320
$BVS_LANG["helperstate"] = "C&#243;digo da unidade de federa&#231;&#227;o onde o seriado foi publicado.<br />
Este campo &#233; de preenchimento obrigat&#243;rio para seriados publicados no Brasil, e optativo para outros pa&#237;ses com a mesma divis&#227;o pol&#237;tico-administrativa.<br />
O registro do c&#243;digo correspondente ao estado brasileiro.<br />
Seleciona-se do &#237;ndice o nome do estado.<br />
Exemplos:<br />
a) Estado: S&#227;o Paulo<br />
b) Estado: Rio de Janeiro";

//field v400
$BVS_LANG["helperissn"] = "N&#250;mero que identifica internacionalmente um peri&#243;dico. (International Standart Serial Number).<br />
Registre o ISSN na forma completa, incluindo o h&#237;fen. ).<br />
Clique no bot&#227;o SUBCAMPO e, digite o ISSN e o tipo de m&#237;dia na planilha que aparece. ).<br />
No caso de possuir mais de uma m&#237;dia, registre na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR. .<br />
<br />
Exemplos: Plant varieties journal (Ottawa)<br />
ISSN-L 1188-1534<br />
1188-1534^aimpressa<br />
1911-1479^lonline<br />
1911-1460^lcdrom<br />
0273-1134^zcancelado";

//field v410
$BVS_LANG["helpercoden"] = "C&#243;digo atribu&#237;do ao seriado pelo Chemical Abstracts Service (CAS).<br />
Registre na forma que aparece no seriado.<br />
Exemplos:<br />
a) CODEN: FOMEAN<br />
b) CODEN: RCPDAF";

//field v50
$BVS_LANG["helperpublicationStatus"] = "C&#243;digo que identifica o estado atual do seriado em rela&#231;&#227;o a sua publica&#231;&#227;o pelo editor.<br />
Selecione o estado da publica&#231;&#227;o: <br />
corrente.<br />
suspensa ou encerrada.<br />
desconhecida.<br />
Exemplos:<br />
a)Situa&#231;&#227;o da publica&#231;&#227;o: Corrente<br />
b) Situa&#231;&#227;o da publica&#231;&#227;o: desconhecida";

//field v301
$BVS_LANG["helperinitialDate"] = "Ano e m&#234;s de in&#237;cio da publica&#231;&#227;o do seriado.<br />
Registre a data inicial usando abreviaturas normalizadas para meses e no idioma em que se registrou o t&#237;tulo pr&#243;prio.<br />
O registro do m&#234;s &#233; optativo. No caso de registrar-se ambos, o m&#234;s precede o ano.<br />
Quando n&#227;o for poss&#237;vel determinar o ano exato de in&#237;cio, registre da seguinte forma:<br />
1983 Data conhecida.<br />
?983 Data prov&#225;vel.<br />
198? Ano incerto.<br />
19?? D&#233;cada incerta.<br />
1??? S&#233;culo incerto.<br />
Exemplos:<br />
a) Data inicial: jan./mar. 1974<br />
b) Data inicial: 1987<br />
c) Data incial: set. 1988";

//field v302
$BVS_LANG["helperinitialVolume"] = "N&#250;mero do volume em que se inicia o seriado descrito.<br />
Registre o volume inicial em n&#250;meros ar&#225;bicos.<br />
Omita esta informa&#231;&#227;o no caso de seriados que n&#227;o incluem indica&#231;&#227;o clara sobre o volume.<br />
Exemplos:<br />
a) Volume inicial: 1<br />
b) Volume inicial: 4";

//field v303
$BVS_LANG["helperinitialNumber"] = "N&#250;mero do primeiro fasc&#237;culo do seriado descrito.<br />
Registre o n&#250;mero de in&#237;cio em algarismos ar&#225;bicos.<br />
Exemplos:<br />
a) N&#250;mero inicial: 1<br />
b) N&#250;mero inicial: 2";

//field v304
$BVS_LANG["helperfinalDate"] = "Ano e m&#234;s em que se publicou pela &#250;ltima vez o seriado descrito.<br />
Registre as datas que aparecem no seriado, usando abreviaturas normalizadas para meses e no idioma em que se registrou o t&#237;tulo.<br />
O registro do m&#234;s &#233; optativo e no caso de registrar ambos, o m&#234;s precede o ano.<br />
Exemplos:<br />
a) Data final: out. 1984<br />
b) Data final: 1988";

//field v305
$BVS_LANG["helperfinalVolume"] = "N&#250;mero do &#250;ltimo volume publicado do seriado.<br />
Registre o volume final em algarismos ar&#225;bicos.<br />
Exemplos:<br />
a) Volume final: 10<br />
b) Volume final: 12 ";

//field v306
$BVS_LANG["helperfinalNumber"] = "N&#250;mero do &#250;ltimo fasc&#237;culo publicado do seriado descrito.<br />
Registre o n&#250;mero final em algarismos ar&#225;bicos.<br />
Exemplos:<br />
a) N&#250;mero final: 7<br />
b) N&#250;mero final: winter";

//field v380
$BVS_LANG["helperfrequency"] = "C&#243;digo que identifica os intervalos de tempo com que se publica o seriado.<br />
Seleciona-se a freq&#252;&#234;ncia da lista, e o respectivo c&#243;digo abreviado ser&#225; gravado na base de dados.<br />
Exemplos:<br />
a) Freq&#252;&#234;ncia atual: Semanal<br />
b) Freq&#252;&#234;ncia atual: Trimestral";

//field v330
$BVS_LANG["helperpublicationLevel"] = "Termo que define o n&#237;vel intelectual do seriado.<br />
Seleciona-se:<br />
Cient&#237;fico/t&#233;cnico: para seriados que incluem artigos produto de investiga&#231;&#245;es cient&#237;ficas e/ou artigos assinados emitindo a opini&#227;o de especialistas (inclui estudos cl&#237;nicos).<br />
Divulga&#231;&#227;o: para seriados que incluem, na maior parte, artigos nao assinados, notas informativas, etc.<br />
Exemplos:<br />
a) Nivel da publica&#231;&#227;o: Cient&#237;fico/t&#233;cnico <br />
b) Nivel da publica&#231;&#227;o: Divulga&#231;&#227;o";

//field v340
$BVS_LANG["helperalphabetTitle"] = "Termos que identificam o alfabeto original do t&#237;tulo.<br />
Seleciona-se conforme os seguintes alfabetos:<br />
Romano b&#225;sico: para idiomas anglo-germ&#226;nicos e romanos que n&#227;o utilizam sinais diacr&#237;ticos, tais como:<br />
Ingl&#234;s, Eslavos, Croata, Latim.<br />
Romano estendido: para idiomas anglo-germ&#226;nicos e latinos que utilizam sinais diacr&#237;ticos, tais como:<br />
Portugu&#234;s, Alem&#227;o, Franc&#234;s, Espanhol, Italiano.<br />
Cir&#237;lico: para idiomas eslavos, tais como:<br />
Russo, Bulg&#225;ro, Checo,Ucraniano, Servio, etc.<br />
Japon&#234;s.<br />
Chin&#234;s.<br />
Coreano.<br />
Arabe.<br />
Grego.<br />
Hebraico.<br />
Tailand&#234;s.<br />
Devanagari.<br />
T&#226;mil.<br />
Outros.alfabetos <br />
<br />
Para o registro de outros alfabetos consultar manual ISDS.<br />
Exemplos:<br />
a) Alfabeto do t&#237;tulo: Romano estendido<br />
b) Alfabeto do t&#237;tulo: Chin&#234;s";

//field v350
$BVS_LANG["helperlanguageText"] = "C&#243;digo que identifica o idioma do texto do seriado analisado conforme a norma ISO 639:1988.<br />
<br />
Seleciona-se o idioma da lista e, na base ser&#225; gravado o c&#243;digo ISO do idioma.<br />
 No caso de mais de um idioma, seleciona-se a tecla control (CTRL)<br />
<br />
Exemplos:<br />
Idioma do texto: portugu&#234;s<br />
Idioma do texto: Ingl&#234;s + Espanhol<br />";

//field v360
$BVS_LANG["helperlanguageAbstract"] = "C&#243;digo que identifica o idioma dos resumos do seriado analisado conforme a norma ISSO 639:1988.<br />
Seleciona-se o idioma da lista e, na base ser&#225; gravado o c&#243;digo ISO do idioma.<br />
No caso de mais de um idioma, seleciona-se a tecla control (CTRL)<br />
<br />
Exemplos:<br />
Idioma do texto: portugu&#234;s<br />
Idioma do texto: Ingl&#234;s + Espanhol<br />";


	/**************************************** Step 5  ****************************************/

//field v40
$BVS_LANG["helperrelatedSystems"] = "C&#243;digo que identifica o(s) sistema(s) ao qual determinado registro dever&#225; ser transferido.<br />
Preenchimento obrigat&#243;rio para os centros que participam na alimenta&#231;&#227;o do &#34;Registro de Publica&#231;&#245;es Seriadas em Ci&#234;ncias da Sa&#250;de - BIREME&#34; com as cole&#231;&#245;es dos t&#237;tulos indexados em LILACS e/ou MEDLINE.<br />
Este campo &#233; utilizado pelo sistema para gerar os arquivos de dados de cole&#231;&#227;o a ser enviado para a BIREME.<br />
Registre neste campo a identifica&#231;&#227;o SECS ou outro c&#243;digo que identifique o sistema para o qual o registro dever&#225; ser transferido.<br />
No caso de mais de um c&#243;digo, registre na sequ&#234;ncia.<br />
Exemplos:<br />
a) Sistemas relacionados: SECS<br />
b) Sistemas relacionados: CAPSALC<br />
c) Sistemas relacionados: <br />SECS<br />CAPSALC";

//field v20
$BVS_LANG["helpernationalCode"] = "C&#243;digo que identifica o t&#237;tulo no sistema nacional de publica&#231;&#245;es seriadas em cada pa&#237;s (ou equivalente) com o prop&#243;sito de facilitar a transfer&#234;ncia de dados entre este e outros sistemas afins.<br />
 Registre neste campo o c&#243;digo atribu&#237;do pela institui&#231;&#227;o respons&#225;vel pelo sistema nacional de publica&#231;&#245;es seriadas de cada pa&#237;s (ou equivalente).<br />
 Exemplos:<br />
 a) C&#243;digo nacional: 001060-X (N&#250;mero SIPS no Cat&#225;logo<br />
 Coletivo Nacional brasileiro)<br />
 b) C&#243;digo nacional: 00043/93";

//field v37
$BVS_LANG["helpersecsIdentification"] = "N&#250;mero de identifica&#231;&#227;o do t&#237;tulo no &#34;Registro de Publica&#231;&#245;es Seriadas em Ci&#234;ncias da Sa&#250;de - BIREME&#34;<br />
Registre neste campo o n&#250;mero fornecido pela BIREME que identifica o t&#237;tulo na base de dados de Seriados em Ci&#234;ncias da Sa&#250;de - SeCS.<br />
Campo de preenchimento obrigat&#243;rio para os Centros que enviam dados de cole&#231;&#227;o para a BIREME<br />
Este campo &#233; utilizado pelo sistema para gerar os arquivos de dados de cole&#231;&#227;o a ser enviado para a BIREME.<br />
Sempre que o t&#237;tulo estiver identificado como SECS (campo de Sistemas relacionados) este campo tamb&#233;m dever&#225; ser preenchido.<br />
Exemplos:<br />
a) N&#250;mero SECS: 2<br />
b) N&#250;mero SECS: 4";


//field v430
$BVS_LANG["helperclassification"] = "Nota&#231;&#227;o de classifica&#231;&#227;o de assunto do seriado, conforme outro sistema de classifica&#231;&#227;o.<br />
 Registre a nota&#231;&#227;o de classifica&#231;&#227;o conforme o sistema adotado.<br />
 No caso de mais de uma classifica&#231;&#227;o, registre na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR<br />
 <br />
 Exemplos:<br />
       a) Classifica&#231;&#227;o: WB<br />
       b) Classifica&#231;&#227;o: QH<br />
       c) Classifica&#231;&#227;o: WA";

//field v421
$BVS_LANG["helperclassificationCdu"] = "Classifica&#231;&#227;o Decimal Universal (CDU) <br />
Exemplo: CDU 159.964.2 <br />
      T&#237;tulo: Psych&#234; - revista de psican&#225;lise<br />";

//field v422
$BVS_LANG["helperclassificationDewey"] = "Classifica&#231;&#227;o Decimal de Dewey (CDD).<br />
Exemplos: CDD 610.05.<br />
       T&#237;tulo: Revista de ci&#234;ncias m&#233;dicas e biol&#243;gicas.<br />";

//field v435
$BVS_LANG["helperthematicaArea"] = "C&#243;digo da &#225;rea tem&#225;tica segundo codifica&#231;&#227;o do CNPq. <br />
Para uso de BIREME, registram-se somente as grandes &#225;reas. <br />
No caso de mais de uma &#225;rea tem&#225;tica, registre na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR<br />
Exemplos: :<br />
Grandes &#225;reas -> CI&#202;NCIAS DA SA&#218;DE:<br />
Grandes &#225;reas -> CI&#202;NCIAS BIOL&#211;GICAS:<br />";

//field v440
$BVS_LANG["helperdescriptors"] = "Termos normalizados utilizados para representar o assunto principal do seriado.<br />
  Os participantes da Rede da BIREME devem utilizar os termos extra&#237;dos do DeCS (Descritores em Ci&#234;ncias da Sa&#250;de).<br />
No caso de mais de um descritor, registre na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR<br />
Registre no m&#225;ximo 4 descritores.<br />
<br />
 Exemplos:<br />
      a) Descritores: MEDICINA OCUPACIONAL<br />
      b) Descritores: NEUROLOGIA<br />
                              PEDIATRIA<br />
      c) Descritores: NEUROLOGIA<br />
c)	Descritores: GINECOLOGIA<br />
     OBSTETRICIA";

//field v441
$BVS_LANG["helperotherDescriptors"] = "Descritores definidos e controlados pela Institui&#231;&#227;o, para representar o conte&#250;do tem&#225;tico do documento. Descritores n&#227;o contidos no DeCS<br />";

//field v450
$BVS_LANG["helperindexingCoverage"] = "C&#243;digo que identifica as fontes secund&#225;rias de informa&#231;&#227;o que indexam o seriado. <br />
Registre o c&#243;digo da fonte secund&#225;ria que indexa o seriado, seguido do ano, volume e fasc&#237;culo inicial e final. <br />
No caso de mais de uma fonte de refer&#234;ncia, registre na seq&#252;&#234;ncia, clicando no bot&#227;o INSERIR. <br />
Exemplos: para a REVISTA DO HOSPITAL DAS CL&#205;NICAS<br />
IM^a1965^b20^c4^d2004^e59^f6<br />
LL^a1981^b36^c1^d2004^e59^f6<br />
SciELO^a1999^b54^c1^d2004^e59^f6<br />";

//field v450^a
$BVS_LANG["helperindexingCoverageA"] = "registra-se a data inicial em que o periódico começou a ser indexado na fonte de referencia";
//field v450^b
$BVS_LANG["helperindexingCoverageB"] = "registra-se o volume inicial em que o periódico começou a ser indexado na fonte de referencia";
//field v450^c
$BVS_LANG["helperindexingCoverageC"] = "registra-se o fascículo inicial em que o periódico começou a ser indexado na fonte de referencia";
//field v450^d
$BVS_LANG["helperindexingCoverageD"] = "registra-se a data final em que o periódico deixou de ser indexado na fonte de referencia";
//field v450^e
$BVS_LANG["helperindexingCoverageE"] = "registra-se o volume final em que o periódico deixou de ser indexado na fonte de referencia";
//field v450^f
$BVS_LANG["helperindexingCoverageF"] = "registra-se o fascículo final em que o periódico deixou de ser indexado na fonte de referencia";

//field v470
$BVS_LANG["helpermethodAcquisition"] = "C&#243;digo alfanum&#233;rico que identifica a forma de obten&#231;&#227;o do seriado pelo centro.<br />
Registre o c&#243;digo correspondente conforme as seguintes combina&#231;&#245;es:<br />
0 - quando n&#227;o se conhece a forma de obten&#231;&#227;o.<br />
1 - para compra          <br />
2 - para permuta         <br />
3 - doa&#231;&#227;o<br />
Exemplos:<br />  
 a) Tipo de obten&#231;&#227;o: 1A  (compra vigente)<br />
 b) Tipo de obten&#231;&#227;o: 3B  (doa&#231;&#227;o descontinuada)";

//field v900
$BVS_LANG["helpernotes"] = "Informa&#231;&#245;es complementares relativas a qualquer aspecto do seriado, seja em sua apresenta&#231;&#227;o ou conte&#250;do.<br />
Registre neste campo, em linguagem livre, informa&#231;&#245;es que sejam do interesse do centro respons&#225;vel pela descri&#231;&#227;o do seriado.<br />
No caso de mais de uma nota, registre na sequ&#234;ncia.<br />
Exemplos:<br />
a) Notas: Publica&#231;&#227;o interrompida entre 1987-1976<br />
b) Notas: Volume 104 n&#227;o foi publicado";

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

$BVS_LANG["helperurlPortal"] = "As informações para o portal são constituídas
por uma URL, fornecedor, tipo e controle de acesso e período.<br/><br/>
Basta clicar no botão Subcampo ao lado da caixa de texto para abrir uma nova 
janela para o preenchimento das informações de acordo com o nome do campo.
<BR />";

//field v999^a
$BVS_LANG["helpField999SubfieldA"] = "Tipo de acesso - Campo 999^a<br /><br />Define o tipo de acesso permitido aos artigos dos peri&#243;dicos. Para cada item temos 6 op&#231;&#245;es: <br /><br />LIVRE <br />Essa op&#231;&#227;o habilita todo tipo de acesso as p&#225;ginas correspondentes.<br /><br />LIVRE PARA ASSINANTE DO FORMATO ELETRONICO (ONLINE) <br />Essa op&#231;&#227;o libera somente acesso gratuito de informa&#231;&#245;es das p&#225;ginas correspondentes. <br />LIVRE PARA ASSINANTE DO FORMATO PRINT <br />Essa op&#231;&#227;o libera somente acesso gratuito de informa&#231;&#245;es em formato impresso com recebimento via postagem. EXIGE ASSINATURA ONLINE<br />Essa op&#231;&#227;o libera somente acesso via pagamento de assinatura online.<br />EXIGE ASSINATURA PRINT<br />	Essa op&#231;&#227;o libera somente acesso via pagamento de assinatura no formato impresso.<br />EXIGE ASSINATURA ONLINE/PRINT<br />Essa op&#231;&#227;o libera somente acesso via pagamento de assinatura no formato online e tamb&#233;m no formato impresso.";

//field v999^b
$BVS_LANG["helpField999SubfieldB"] = "URL - Campo 999^b<br /><br />URL (Uniform Resource Locator)&#233; o endere&#231;o da publica&#231;&#227;o eletr&#244;nica e/ou seus artigos na Web.<br />Ingresse o endere&#231;o eletr&#244;nico na seguinte forma: <br />Exemplo: http://www.bireme.br/php/index.php<br />Clique no bot&#227;o SUBCAMPO e digite a URL da publica&#231;&#227;o<br />No caso de mais de uma URL, clique no bot&#227;o INSERIR";

//field v999^c
$BVS_LANG["helpField999SubfieldC"] = "Agregador/Fornecedor - Campo 999^c<br /><br />Portais que possibilitam pesquisa e agregam mais de uma base de dados. Seu acesso &#233; pago, por meio de assinatura, de alto custo, e muitas vezes est&#225;o dispon&#237;veis apenas em Institui&#231;&#245;es de ensino/pesquisa.Permitem o acesso ao texto completo. Os principais s&#227;o OVID, EBSCO e PROQUEST. No Brasil, o portal CAPES permite o acesso com texto completo a v&#225;rias revistas, por meio de universidades conveniadas.<br /><br />Exemplo: CAPES-SciELO<br />              CAPES-OVID";

//field v999^d
$BVS_LANG["helpField999SubfieldD"] = "Controle de acesso - Campo 999^d<br /><br />O processo/meio de assegurar que os recursos de um sistema de computador possam ser acessados somente pelos usu&#225;rios cadastrados.<br /><br />EXEMPLOS:<br />IP<br />LIVRE<br />PASSWORD";

//field v999^e
$BVS_LANG["helpField999SubfieldsEF"] = "Per&#237;odo - Campo 999^e^f^g<br /><br />Per&#237;odo inicial e final de acesso ao texto completo.<br /><br />EXEMPLO:<br />1997 &#233; 2009<br />";

//field v999^g
$BVS_LANG["helpField999SubfieldG"] = "Tipo de Arquivo 999^g<br /><br /> <br /><br />EXEMPLO:<br />";
//field v999^h - this field is not in the system
$BVS_LANG["helpField999SubfieldH"] = "Tipo de Arquivo 999^h<br /><br />Se o arquivo &#233; um pdf, HTML etc ... <br /><br />EXEMPLO:<br />Acesso gratuito atrav&#233;s de cadastro de usu&#225;rio e senha;<br />Tamb&#233;m dispon&#237;vel em outro idioma (polon&#234;s);";
//field v860
$BVS_LANG["helperurlInformation"] = "Informa&#231;&#245;es complementares sobre acessibilidade do artigo.<br /><br />EXEMPLO:<br />Permite compra de artigos;<br />Acesso somente as tabelas de conte&#250;do<br />";
//field v861
$BVS_LANG["helperBanPeriod"] = "Per&#237;odo em que a vers&#227;o online do seriado e/ou o texto completo dos artigos n&#227;o est&#227;o liberados para uso p&#250;blico geral.<br />
<br />
Exemplo:<br />
T&#237;tulo em texto completo dispon&#237;vel a partir de janeiro de 1995 e com um per&#237;odo de embargo de 6 meses";

	/**************************************** Step 7  ****************************************/

//field v436
$BVS_LANG["helperspecialtyVHL"] = "Terminologia especifica definida pela BVS Tem&#225;tica para facilitar a recupera&#231;&#227;o do t&#237;tulo na BVS Regional.<br />
Exemplo: ^aBVSSP^bALIMENTACAO E NUTRICAO<br />";

//field v445
$BVS_LANG["helperuserVHL"] = "Campo de dado utilizado para desdobramento do cat&#225;logo das BVS Tem&#225;ticas com objetivo de exporta&#231;&#227;o do registro<br />
Exemplos: BVSSP<br />
  ANVISA<br />
 BVS - Evid&#234;ncia<br />";

//field v910
$BVS_LANG["helpernotesBVS"] = "Motivo pelo qual a publica&#231;&#227;o deixou de ser indexada na LILACS.<br />
Exemplo:<br />
Deixou de ser LILACs por atraso de publica&#231;&#227;o<br />";

//field v920
$BVS_LANG["helperwhoindex"] = "C&#243;digo do Centro Cooperante respons&#225;vel pela indexa&#231;&#227;o da revistas LiLacs.
Exemplos: BR1.1
  AR29.1";

//field v930
$BVS_LANG["helpercodepublisher"] = "Campo de preenchimento obrigat&#243;rio.<br />
N&#250;mero seq&#252;encial atribu&#237;do e controlado pela BIREME.<br />
C&#243;digo de identifica&#231;&#227;o do editor respons&#225;vel da revista indexada na LiLacs.<br />
O c&#243;digo do editor &#233; composto pelo c&#243;digo ISO do pa&#237;s, seguido de um n&#250;mero que o identifica.<br />
Este campo &#233; utilizado pelo sistema para fazer a liga&#231;&#227;o entre o registro do t&#237;tulo LiLacs e os dados
 do editor na base de dados Nmail, sendo portanto obrigat&#243;rio o envio do formul&#225;rio preenchido “CADASTRO DE EDITORES DE REVISTAS LILACS” pelo Centro Cooperante da Rede BIREME <br />
<br />
Exemplos: BR440.9<br />
                AR29.9";


        /***************** ISBD - 2007 ****************************************/

$BVS_LANG["helpISBD"] = "<strong>Regras básicas para a entrada de títulos</strong><br />baseadas na ISBD – edição consolidada de 2007 e adaptadas para a entrada de dados do sistema SeCS-Web.<br /><br />1 - Quando o título do seriado consta de iniciais ou acrônimos destacados na página de rosto, e a forma por extenso também aparece como parte integrante do título, registram-se as iniciais ou acrônimos como título (campo de título da publicação - 100) e a forma por extenso no campo de Subtítulo (campo 110). Se as inicias ou acrônimos estão lingüisticamente e/ou tipograficamente separadas da forma por extenso, registra-se como título as iniciais ou acrônimos e a forma por extenso em Outras formas do título (campo 240).<br /><br />Exemplos:<br />Título da publicação: ABCD<br />Subtítulo: arquivos brasileiros de cirugia digestiva<br />Título da publicação: Jornal da AMRIGS<br />Subtítulo: jornal da Associação Médica do Rio Grande do Sul<br /><br />2 - Quando a menção de responsabilidade aparece como parte integrante do título na forma abreviada como acrônimo ou iniciais, é repetida na forma completa em Menção de responsabilidade - campo 140, se esta forma aparece na publicação descrita, e o título em sua forma por extenso em Outras formas do título - Campo 240.<br /><br />Exemplos:<br />Título da publicação: ALA bulletin<br />Menção de responsabilidade: American Library Association<br />Outras formas do título: American Library Association bulletin<br /><br />3 - Quando o seriado não tem outro título e somente a menção de responsabilidade, transcreve-se esta como título da publicação e não é necessário repetí-la no campo de menção de responsabilidade (campo 140).<br /><br />Exemplo:<br />Título da publicação: Universidad de Antioquia<br /><br />4 - Quando o título da publicação é um termo genérico, assim como Boletim, Boletim técnico, Jornal, Newsletter, etc., ou seus equivalentes em outros idiomas e está separado linguisticamente e/ou tipograficamente da menção de responsabilidade, registra-se o título na forma que aparece e a menção de responsabilidade no campo 140, que neste caso torna-se obrigatória para a correta identificação do seriado. <br /><br />Exemplo:<br />Título da publicação: Boletim<br />Menção de responsabilidade: Associação Médica Paulista <br /><br />5 - Para títulos homônimos deve-se registrar um diferenciador (qualificador), isto é válido tanto para o título próprio como para outras formas do título próprio (abreviados, paralelos, etc.). Essa informação deve ser registrada logo após o título, separada por espaço e entre parênteses. Assim,<br />5.1 - Títulos homônimos em locais diferentes, registra-se como qualificador o local de publicação.<br /><br />Exemplos:<br />Título da publicação: Pediatria (São Paulo)<br />Título da publicação: Pediatria (Bogotá)<br /><br />5.2 - Títulos homônimos em locais idênticos. Registra-se como qualificador o local e data inicial da publicação.<br /><br />Exemplos:<br />Título da publicação: Pediatria (São Paulo. 1983)<br />Título da publicação: Pediatria (São Paulo. 1984)<br /><br />5.3 - Seriados que retornam ao título anterior. Registra-se como qualificador o local e data inicial da publicação.<br /><br />Exemplos:<br />Título da publicação: Revista médica (1968)<br />Título da publicação: Revista médica (1987)<br /><br />5.4 - Edições em distintos idiomas com títulos homônimos. Registra-se como qualificador a edição correspondente, conforme ISO 4-1984 e &#34;List of serial title word abbreviations&#34;.<br/><br />Exemplos:<br />Título da publicação: Abboterapia (ed. espanol)<br />Título da publicação: Abboterapia (ed. português)<br />Título abreviado: Abboterapia (ed. esp.)<br />Título abreviado: Abboterapia (ed. port.)<br /><br />6 - Quando uma seção, parte ou suplemento, publicado separadamente, tem um título específico que pode ser separado do título comum e quando o título específico aparece como mais importante que o título comum, passa a constituir um novo registro como o título próprio.<br/><br />Exemplo:<br />Título comum da publicação: Veterinary record<br />Título específico: In practice<br />a) Título da publicação: In practice<br /> E suplemento/inserto de: Veterinary record<br />b) Título da publicação: Veterinary record<br />Tem suplemento/inserto: In practice<br /><br />7 - Quando o título do suplemento é idéntico ao título próprio e se constitui um novo registro, se diferenciar registrando a palavra Suplemento no campo de Título da seção/parte (campo 130).<br /><br />Exemplos:<br />a) Título da publicação: Ciência e cultura<br />Título da seção/parte: Suplemento<br />b) Título da publicação: Acta cirúrgica brasileira<br />Título da seção/parte: Suplemento<br /><br />8 - No caso de vários Títulos paralelos apresentados na página de rosto ou parte que a substitui, registra-se como título próprio aquele que aparece destacado tipograficamente e se não há distinção tipográfica, registra-se aquele que aparece em primeiro lugar, e como títulos paralelos os demais títulos (campo 230).<br /><br />Exemplos:<br />Título da publicação: Progress in surgery<br />Título paralelo: Progress en chirurgie<br />";



	/****************************************************************************************************/
	/**************************************** Library Section - Field Helps ****************************************/
	/****************************************************************************************************/

//field v2
$BVS_LANG["helpLibFullname"] = "Nome que identifica a biblioteca.<br />
EXEMPLO: BIREME - OPAS - OMS - Centro Latino-Americano e do Caribe de Informa&#231;&#227;o em Ci&#234;ncias da Sa&#250;de";

//field v1
$BVS_LANG["helpLibCode"] = "C&#243;digo utilizado para identificar a biblioteca, centro ou unidade de informa&#231;&#227;o.<br />
A biblioteca principal que administra SeCS tem como nome default: MAIN<br />
<br />
EXEMPLOS:<br />
a)	FAGRO<br />
b)	CIENCIAS<br />
<br />
As bibliotecas que pertencem à rede de BIREME usar&#227;o o c&#243;digo que as identifica.<br />
O c&#243;digo da Biblioteca &#233; composto pelo c&#243;digo ISO do pa&#237;s onde a mesma est&#225; localizada, seguido de um n&#250;mero que a identifica.<br />
EXEMPLO: BR1.1 ";

//field v9
$BVS_LANG["helpLibInstitution"] = "Sigla e nome da institui&#231;&#227;o da qual a biblioteca ou sistema de bibliotecas &#233; parte integrante.<br />
EXEMPLO:  UNIFESP: Universidade Federal de S&#227;o Paulo";

//field v3
$BVS_LANG["helpLibAddress"] = "Endere&#231;o completo da Biblioteca com os devidos complementos (Rua, Av., etc).<br />
EXEMPLO: Rua Botucatu, 862 – CEP 04023-901 – Vila Clementino";

//field v4
$BVS_LANG["helpLibCity"] = "Nome da cidade onde est&#225; localizada a Biblioteca.<br />
EXEMPLO: S&#227;o Paulo";

//field v5
$BVS_LANG["helpLibCountry"] = "Nome do pa&#237;s onde est&#225; localizada a Biblioteca<br />
EXEMPLO: Brasil";

//field v6
$BVS_LANG["helpLibPhone"] = "N&#250;mero do telefone ou telefones de contato do respons&#225;vel pela Biblioteca.<br />
EXEMPLO: (55 011) 55769876; (55 011) 55769800";

//field v7
$BVS_LANG["helpLibContact"] = "Nome completo do respons&#225;vel pela Biblioteca.<br />
EXEMPLO: Raquel Cristina Vargas";

//field v10
$BVS_LANG["helpLibNote"] = "Informa&#231;&#245;es adicionais relativas à Biblioteca. <br />
Registram-se neste campo, em linguagem livre, as informa&#231;&#245;es que sejam de interesse da unidade de informa&#231;&#227;o. <br />
EXEMPLO: dias e hor&#225;rio de aten&#231;&#227;o";

//field v11
$BVS_LANG["helpLibEmail"] = "Endere&#231;o eletr&#244;nico do respons&#225;vel pela Biblioteca.<br />
EXEMPLO: raquel.araujo@bireme.org";



	/****************************************************************************************************/
	/**************************************** Homepage - Search Field Helps ****************************************/
	/****************************************************************************************************/
/*
 * Help for Title search field and Title Plus search field in homepage section
 */

//search Title database
$BVS_LANG["helpSearchTitle"] = "Faz uma busca na base de dados Title.<br />
Você pode fazer uma busca livre, sem selecionar um indice especifico (opção Todos os Indices) ou fazer uma busca por um dos
indices qem estão disponiveis na lista ao lado da ajuda.<br/>
<br/>
Basta digitar um ou mais termos na caixa de pesquisa e pressione o botão &#180;Buscar&#180;.<br/>
Tambem é aceito uma busca por todos os itens usando-se o simbolo $<br/>
Ou uma busca truncada com o termo e o simbolo $<br/>
Por exemplo uma busca por Brasil$, vai retornal Brasil, Brasileiro e Brasileira.";

//search Title Plus database
$BVS_LANG["helpSearchTitlePlus"] = "Faz uma busca na base de dados Title Plus.<br />
Você pode fazer uma busca livre, sem selecionar um indice especifico (opção Todos os Indices) ou fazer uma busca por um dos
indices qem estão disponiveis na lista ao lado da ajuda.<br/>
<br/>
Alguns indices já tem valores pré-definidos para buscas, então a caixa de busca se transfoma em uma lista com as opções disponiveis.<br/>
Basta digitar um ou mais termos na caixa de pesquisa e pressione o botão &#180;Buscar&#180;.<br/>
Tambem é aceito uma busca por todos os itens usando-se o simbolo $<br/>
Ou uma busca truncada com o termo e o simbolo $<br/>
Por exemplo uma busca por Brasil$, vai retornal Brasil, Brasileiro e Brasileira.";

//search Mask database
$BVS_LANG["helpSearchMask"] = "Faz uma busca na base de dados Mascara.<br />
Você pode fazer uma busca livre, sem selecionar um indice especifico (opção Todos os Indices) ou fazer uma busca por um dos
indices qem estão disponiveis na lista ao lado da ajuda.<br/>
<br/>
Basta digitar um ou mais termos na caixa de pesquisa e pressione o botão &#180;Buscar&#180;.<br/>
Tambem é aceito uma busca por todos os itens usando-se o simbolo $<br/>
Ou uma busca truncada com o termo e o simbolo $<br/>
Por exemplo uma busca por Brasil$, vai retornal Brasil, Brasileiro e Brasileira.";

//search Issue database
$BVS_LANG["helpSearchIssue"] = "Faz uma busca na base de dados Fasciculos.<br />
Você pode fazer uma busca livre, sem selecionar um indice especifico (opção Todos os Indices) ou fazer uma busca por um dos
indices qem estão disponiveis na lista ao lado da ajuda.<br/>
<br/>
Basta digitar um ou mais termos na caixa de pesquisa e pressione o botão &#180;Buscar&#180;.<br/>
Tambem é aceito uma busca por todos os itens usando-se o simbolo $<br/>
Ou uma busca truncada com o termo e o simbolo $<br/>
Por exemplo uma busca por Brasil$, vai retornal Brasil, Brasileiro e Brasileira.";

//search Users database
$BVS_LANG["helpSearchUsers"] = "Faz uma busca na base de dados Usuarios.<br />
Você pode fazer uma busca livre, sem selecionar um indice especifico (opção Todos os Indices) ou fazer uma busca por um dos
indices qem estão disponiveis na lista ao lado da ajuda.<br/>
<br/>
Basta digitar um ou mais termos na caixa de pesquisa e pressione o botão &#180;Buscar&#180;.<br/>
Tambem é aceito uma busca por todos os itens usando-se o simbolo $<br/>
Ou uma busca truncada com o termo e o simbolo $<br/>
Por exemplo uma busca por Brasil$, vai retornal Brasil, Brasileiro e Brasileira.";

//search Library database
$BVS_LANG["helpSearchLibrary"] = "Faz uma busca na base de dados Bibliotecas.<br />
Você pode fazer uma busca livre, sem selecionar um indice especifico (opção Todos os Indices) ou fazer uma busca por um dos
indices qem estão disponiveis na lista ao lado da ajuda.<br/>
<br/>
Basta digitar um ou mais termos na caixa de pesquisa e pressione o botão &#180;Buscar&#180;.<br/>
Tambem é aceito uma busca por todos os itens usando-se o simbolo $<br/>
Ou uma busca truncada com o termo e o simbolo $<br/>
Por exemplo uma busca por Brasil$, vai retornal Brasil, Brasileiro e Brasileira.";



	/****************************************************************************************************/
	/**************************************** Validation Messages   ****************************************/
	/****************************************************************************************************/
/*
 *  Title section
 */

//comun end message
$BVS_LANG["msgErrorShouldBeFilled"] = " deve ser preenchido";
//field v50
$BVS_LANG["msgErrorPublicationStatus"] = "Se o campo Situacao da publicacao for Encerrado/Suspenso o campo ";
//field v310
$BVS_LANG["msgErrorCountry"] = "Se o pais for Brasil o campo ";


?>