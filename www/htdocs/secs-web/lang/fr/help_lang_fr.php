<?php
/**
 * @file:			language_pt.php
 * @desc:		    Portuguese language file, here are only the Help of filling the forms
 * @author:			Bruno Neofiti <bruno.neofiti@bireme.org>
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

//data not recorded
$BVS_LANG["helpBasedMask"] = "Créez un nouveau masque basé sur un masque sélectionné pour faciliter l’entrée des données.<br />
Cette donnée n’est pas enregistrée dans la base de données";

//field v801
$BVS_LANG["helpMaskName"] = "Entrez ici le nom du masque.
Utilisez un système cohérent de nommination pour tous les masque (tel que recommandé
par l’atelier sur le Contrôle des Périodiques tenu au BIREME, septembre 1989).<br />
Le nom du masque est composé du Code de Fréquence ISDS suivi par le nombre de volumes et/ou de numéros dans une année spécifique.<br />
Utilisez le code M après volume/numéro pour identifier les volumes ou numéros représentés par les noms des mois.<br />
Le symbole + est utilisé pour identifier les volumes ou numéros avec une numérotation continue de 1 à l’infini.<br /> <br />
Exemples : <br />
 M1V12F<br />
 (Correspond à : Mensuel, 1 volume par année, 12 numéros par volume)<br />
 Q4FM<br />
 (Correspond à : Trimestriel, quatre numerous réprésentés par les noms de mois, aucune numérotation de volume)<br />
 B6F+<br />
 (Correspond à : Bimensuel, six numéros par année avec une numérotation continue, aucune numérotation de volume)";


//field v900
$BVS_LANG["helpNotesMask"] = "Saisissez dans ce champ en langage naturel, les informations sur le contenu du bordereau. Ces informations peuvent être : la périodicité, le numéro des volumes par an, etc.<br/>
<br/>
Exemple : <br/>
<br/>
Bimensuel : 2 volumes par an avec 3 numéros par volume<br/>";

//field v860
$BVS_LANG["helpVolume"] = "Ce champ ne doit être renseigné que si le volume est mentionné<br/>
Le code indique au Système si la séquence de volumes d’une publication en série est continue (illimitée) ou répétitive (limitée) sur chaque année.<br/>
Avant de remplir ce champ, il faut vérifier si la numérotation des volumes d’une collection est continue ou est reprise chaque année.<br/>
<br/>
Exemple : <br/>
Une publication en série publiée sur une base trimestrielle avec 2 volumes par an et dont la numérotation de chaque volume change chaque année.<br/>
Volume<br/>
1.<br/>
1.<br/>
2.<br/>
2.<br/>
Séquence des volumes : Illimitée";

//field v880
$BVS_LANG["helpNumber"] = "Ce champ ne doit &#234;tre renseign&#233; que si les num&#233;ros existent dans le bordereau 
<br/>
Le code identifie la s&#233;quence des num&#233;ros, en indiquant au Syst&#232;me si la num&#233;rotation des num&#233;ros est continue (Illimit&#233;e) ou discontinue (limit&#233;e) sur chaque volume ou sur chaque ann&#233;e.<br/>
Avant de remplir ce champ, il faut v&#233;rifier si la num&#233;rotation des num&#233;ros dans une collection est continue ou si elle reste limit&#233;e &#224; un volume ou a une ann&#233;e.<br/>
<br/>
Exemple :<br/>
Un p&#233;riodique publi&#233; sur une base trimestrielle en 1 volume de 4 num&#233;ros par an et dont la num&#233;rotation des num&#233;ros est le m&#234;me toutes les ann&#233;es.<br/>
<br/>
Numero<br/>
1.<br/>
2.<br/>
3.<br/>
4.<br/>
S&#233;quence des num&#233;ros : Limit&#233;e <br/>";



	/****************************************************************************************************/
	/**************************************** Facic Section - Field Helps ****************************************/
	/****************************************************************************************************/

//field v911
$BVS_LANG["helpFacicYear"] = "Ann&#233;e de publication de l&#180;&#233;dition<br/>
<br/>
Taper, en chiffres arabes,  l&#180;ann&#233;e correspondante, <br/>
<br/>
S&#233;parer par le symbole / (slash) plusieurs ann&#233;es correspondant au m&#234;me volume. La derni&#232;re ann&#233;e correspondante sera entr&#233;e sous forme de deux chiffres seulement.<br/>
<br/>
Si l&#180;&#233;dition a &#233;t&#233; suspendue pendant plus de deux ann&#233;es, entrer la premi&#232;re ann&#233;e de la p&#233;riode, suivie d&#180;un / (slash) et les 2 derniers chiffres de l&#180;ann&#233;e de suspension. Dans ce cas, le champ &#233;TAT DE l&#180;&#233;DITION doit &#234;tre rempli par I, indiquant que l&#180;&#233;dition a &#233;t&#233; suspendue pendant cette p&#233;riode.<br/>
<br/>
Exemples :<br/>
a) ANN&#233;E<br/>
	1981/82<br/>
<br/>
b) 	ANN&#233;E		&#233;TAT DE L&#180;&#233;DITION<br/>
	1982/84	I<br/>";

//field v912
$BVS_LANG["helperDonorNotes"] = "Nombres et/ou lettres identifiant le tome de l&#180;&#233;dition d&#233;crite<br/>
Taper le tome en chiffres arabes. S&#180;il contient des lettres, les taper ici<br/>
Si un m&#234;me volume inclut plus d&#180;un tome, les s&#233;parez par un / (slash).<br/>
Les tomes non publi&#233;s par l&#180;&#233;diteur pendant une ann&#233;e sp&#233;cifi&#233;e doivent &#234;tre entr&#233;s ici et le champ &#233;TAT DE L&#180;&#233;DITION doit &#234;tre marqu&#233; de la lettre N, indiquant que le tome n&#180;a pas &#233;t&#233; publi&#233;.<br/>
Avertissement :<br/>
Les informations sur les tomes non publi&#233;es ne doivent &#234;tre tap&#233;es qu&#180;en cas de confirmation par l&#180;&#233;diteur<br/>
<br/>
Exemples :<br/>
a) TOME<br/>
	123<br/>
<br/>
b) TOME<br/>
	123A<br/>
<br/>
c)TOME<br/>
	1/2<br/>
<br/>
d) TOME<br/>
	5/7<br/>
<br/>
e) ANN&#233;E	TOME	&#233;TAT DE L&#180;&#233;DITION<br/>
   1981      	1        	P<br/>
   1982      	2        	N<br/>
   1983      	3        	P <br/>";

//field v913
$BVS_LANG["helpFacicName"] = "Chiffre et/ou lettre identifiant le tome de l&#180;&#233;dition entr&#233;e.<br/>
Taper en chiffre arabe le num&#233;ro de l&#180;&#233;dition. Taper les lettres s&#180;il y en a.<br/>
Les index cumul&#233;s seront entr&#233;s avec les ann&#233;es qu&#180;ils couvrent dans le champ ANN&#233;E et les tomes correspondants dans le champ TOME<br/>
Pour les &#233;ditions qui ont plus de deux num&#233;ros reli&#233;s en un m&#234;me volume, taper le premier num&#233;ro s&#233;par&#233; par un / (slash) de la derni&#232;re &#233;dition. <br/>
Pour les &#233;ditions non publi&#233;es, marquer un N dans le champ &#233;TAT DE L&#180;&#233;DITION.<br/>
Pour les &#233;ditions dont les mois sont connus, taper les mois selon la norme d&#180;abr&#233;viation dans l&#180;index F2<br/>
<br/>
Exemples :<br/>
a) &#233;DITION<br/>
	1<br/>";

//field v910
$BVS_LANG["helpFacicMask"] = "Sélectionnez le masque représentant la fréquence du périodique dans l’année dans laquelle le numéro décrit a été publié. <br /> <br />
Exemple : M1V12F<br />";

//field v916
$BVS_LANG["helpFacicPubType"] = "Informations compl&#233;mentaires sur le tome enregistr&#233;, comme : &#233;dition sp&#233;ciale, &#233;dition comm&#233;morative, suppl&#233;ment, &#233;dition avec subdivisions, utilisant les codifications suivantes :<br/>
<br/>
   S    - suppl&#233;ments<br/>
   P    - &#233;ditions avec des subdivisions ou parties<br/>
   NE   - num&#233;ros sp&#233;ciaux, num&#233;ros comm&#233;moratifs<br/>
   IN   - index<br/>
   AN   - Annuaire<br/>
<br/>
Quand il n&#180;y a pas de num&#233;ro d&#180;&#233;dition, enregistrer seulement le type correspondant<br/>
<br/>
Exemples :<br/>
<br/>
a) S<br/>
b) NE<br/>";

//field v914
$BVS_LANG["helpPubEst"] = "Pr&#233;sence des &#233;ditions dans la biblioth&#232;que<br/>
Taper l&#180;&#233;tat de l&#180;&#233;dition selon la codification suivante :<br/>
P - &#233;dition existante dans la collection<br/>
A - &#233;dition inexistante <br/>
N - tome ou &#233;dition non publi&#233; pendant une ann&#233;e sp&#233;cifi&#233;e<br/>
I - publications suspendues pendant une p&#233;riode sp&#233;cifi&#233;e<br/>
<br/>
Exemples :<br/>
a)<br/>
ANN&#233;E	TOME	&#233;DITION	P/A<br/>
1981	1	1	P<br/>
1981	1 	2	A<br/>
1981	1	3	P<br/>
 <br/>
b)<br/>
ANN&#233;E	TOME	&#233;DITION	P/A <br/>
1980	1           2	 P<br/>
1981	2           1	N<br/>
1981	2           2	P<br/>
1982/83 			I<br/>
1984	3	1	P<br/>";

//field v915
$BVS_LANG["helpQtd"] = "Nombre d&#180;exemplaires de l&#180;&#233;dition.<br/>
Taper le nombre total d&#180;exemplaires de l&#180;&#233;dition.<br/>
<br/>
Exemples:<br/>
a)<br/>
ANN&#233;E    TOME    &#233;DITION        P/A       QT<br/>
1985      53          1         P         1<br/>
1985      53          2         P         2<br/>
1985      53          3         P         2<br/>
1985      53          4         P         2<br/>
Type de l&#180;&#233;dition ou du tome - Champ<br/>
<br/>
Information compl&#233;mentaire concernant l&#180;&#233;dition, comme : num&#233;ro sp&#233;cial, num&#233;ro de comm&#233;moration, suppl&#233;ment, &#233;ditions avec des subdivisions, etc. utilisant les codes suivants :<br/>
<br/>
S    - pour suppl&#233;ment<br/>
P    - pour les &#233;ditions avec des subdivisions<br/>
NE   - pour les num&#233;ros sp&#233;ciaux, de comm&#233;moration<br/>
IN   - pour les  index<br/>
AN   - pour les revues annuelles<br/>
<br/>
Si ces types d&#180;&#233;dition ne sont pas num&#233;rot&#233;s, taper seulement le code correspondant<br/>";

//field v925
$BVS_LANG["helptextualDesignation"] = "Désignation textuelle et/ou désignation spécifique.";

//field v926
$BVS_LANG["helpstandardizedDate"] = "Norme de la date.";

//field v917
$BVS_LANG["helpInventoryNumber"] = "Entrez un numéro d’ordre unique (aussi appelé d’inventaire ou numéro de codes à barres) pour ce numéro.";

//field v918
$BVS_LANG["helpEAddress"] = "Lien Internet de ce numéro si disponible en ligne";

//field v900
$BVS_LANG["helpFacicNote"] = "Les informations sur tout aspect de l&#180;&#233;dition.<br/>
Dans ce champ, taper en langage naturel, les informations sur toutes les caract&#233;ristiques de l&#180;&#233;dition.<br/>
Exemple: &#233;dition tr&#232;s endommag&#233;e ne pouvant plus &#234;tre photocopi&#233;e. Un exemplaire de remplacement a &#233;t&#233; demand&#233;.<br/>";




/****************************************************************************************************/
/***************** Users Administration Section - Field Help messages ****************************************/
/****************************************************************************************************/


//field v1
$BVS_LANG["helpUser"] = "Nom d’utilisateur pour la connexion au module SeCS-Web.<br />";

//field v3
$BVS_LANG["helpPassword"] = "Mot de passe pour la connexion au module SeCS-Web.<br />";

//data not recorded
$BVS_LANG["helpcPassword"] = "Retapez le mot de passe";

//field v4
$BVS_LANG["helpRole"] = "Entrez le role de l’utilisateur. <br /> <br />
Exemple : Administrateur, Editeur, Opérateur<br />";

//field v8
$BVS_LANG["helpFullname"] = "Entrez le nom complet de l’utilisateur<br />  <br />
Exemple : <br />
Ernesto Luis Spinak";

//field v11
$BVS_LANG["helpEmail"] = "Entrez l’adresse électronique de l’utilisateur<br /> <br />
Exemple : <br />
ernesto.spinak@bireme.org";

//field v9
$BVS_LANG["helpInstitution"] = "Entrez le nom de l’institution<br />
Exemples :
BIREME - OPS/OMS – Centre Latino-Américain et Caraïbéen des Sciences de l’Information sur la Santé";

//field v5
$BVS_LANG["helpCenterCod"] = "Code du Centre<br />";

//field v10
$BVS_LANG["helpNotes"] = "Entrez des informations pertinentes sur l’usager.<br />
Exemples : <br />
Test de Traduction en Anglais<br />
Utilisateur de l’éditeur standard SeCS-Web.<br />";

//field v12
$BVS_LANG["helpLang"] = "Sélectionnez la langue de l’interface préféré pour cet utilisateur<br />
Exemple : <br />
Anglais";

//field v2
$BVS_LANG["helpUsersAcr"] = "Entrez les initiales de l’utilisateur ou l’acronyme équivalent<br />
Exemples : ELS";



/****************************************************************************************************/
/***************** TitlePlus Section - Field Help messages ****************************************/
/****************************************************************************************************/


//field v901
$BVS_LANG["helperAcquisitionMethod"] = "Méthode d’acquisition.<br />Sélectionnez la méthode appropriée.
Exemples :
Payant<br />
Don<br />
Echange<br />
Autre";

//field v902
$BVS_LANG["helperAcquisitionControl"] = "Indication du statut de la publication. <br />
Sélectionnez l’option correspondant à l’actuel statut de ce périodique :<br />
Iconnu : <br />
Actuel : <br />
Non actuel : <br />
Fermé : <br />
Suspendu";

//field v906
$BVS_LANG["helperExpirationSubs"] = "Utilisez le calendrier ci-joint pour sélectionner la date de l’expiration de l’abonnement.<br />La date sera enregistrée dans le format standard ISO.<br />
Après avoir renouvellé l’abonnement vous devez vous rappeler la nouvelle date d’expiration dans ce champ.";

//field v946
$BVS_LANG["helperacquisitionPriority"] = "Code numérique définissant la priorité d’acquisition du périodique pour l’institution.<br />
En vue d’établir les priorités d’acquisition, consultez si besoin est votre Comité de Bibliothèque, les membres de la communauté académique ou d’autres experts.<br />.<br />

Sélectionnez la priorité appropriée à partir de la liste déroulante et le système entrera un code numérique : <br />
1 – Le titre est essentiel pour le centre.<br />
2 – Le titre n’est pas essential pour le centre car il existe dans le pays.<br />
3 – Le titre n’est pas essential pour le centre car il existe dans la Région.<br />";

//field v911
$BVS_LANG["helperAdmNotes"] = "Entrez toutes les informations pertinentes sur ce périodique. Entrez plusieurs informations sur des lignes séparées. <br /> <br />
Exemple : l’abonnement a été interrompu en 2009.";

//field v905
$BVS_LANG["helperProvider"] = "Entrez le nom du Vendeur/Fournisseur (commercial ou non) pour cet abonnement. Si vous n’avez pas une base de données distincte de vendeurs, ajoutez des données de contact et d’autres informations dans le champ Note VendeurFournisseur ci-dessous.
<br />
Si la méthode d’acquisition est un Don d’abonnement, entrez dans le champ 912 les details sur les conditions de don.";

//field v904
$BVS_LANG["helperProviderNotes"] = "Informations sur Vendeur/Fournisseur. Entrez ici toute information pertinente sur le fournisseur de ce périodique.<br />";

//field v903
$BVS_LANG["helperReceivedExchange"] = "Entrez le titre du périodique que vous avez envoyé en échange du présent titre.<br />
Ce champ est obligatoire si la Méthode d’Acquisition est Echange.";

//field v912
$BVS_LANG["helperDonorNotes"] = "Utilisé pour les dons d’abonnement ou des abonnements payant faits sur des fonds d’un projet externe ou des dons soumis à des conditions.<br />
Entrez des informations sur les conditions du don. <br />
Ce champ est obligatoire si la méthodé d’acquisition est Don.<br /><br />
Exemples : <br />
a) Payé par les fonds de l’USAID en provenance du projet 2009/CL/Y35 <br />
b) Ce périodique doit être tenu à l’écart de la collection générale avec une étiquette indiquant le nom de l’institution du donateur. <br />
c) Essai gratuit d’abonnement pour 2009 seulement.";

//field v913
$BVS_LANG["helperAcquisitionHistory"] = "Information concernant la signature historique, le montant payé par la signature, les détails
fascicules qui comprend l'achat. Les sous-zones qui composent
le champ de données: <br/>
(D) Date de paiement de abonnement <br/>
(V) le montant payé par la signature <br/>
(A) Année qui comprend le signature <br/>
(F) qui comprend les questions signature<br/>";//traduzir

$BVS_LANG["helperAcquisitionHistoryD"] = "Date de paiement de abonnement.";
$BVS_LANG["helperAcquisitionHistoryV"] = "Le montant payé par la signature.";
$BVS_LANG["helperAcquisitionHistoryA"] = "Année qui comprend le signature.";
$BVS_LANG["helperAcquisitionHistoryF"] = "qui comprend les questions signature.";

//field v907
$BVS_LANG["helperLocationRoom"] = "Entrez le nom d’appel du périodique indiquant son emplacement dans la collection. <br />Dans les grandes bibliothèques, il peut être commode de construire des noms d’appels qui comprennent des codes pour la salle, la section et un rayon en complément au nom d’appel propre. <br /> <br />
Exemples : <br />
a) Nom d’appel : 0557<br />
b) Nom d’appel : R2-S3-0557";

//field v908
$BVS_LANG["helperEstMap"] = "Entrez le nom du fichier graphique contenant un rayon, un plan de conservation qui indique l’emplacement du périodique.<br />
Exemple : ChambreA1-ModuleB3.jpg ";

//field v909
$BVS_LANG["helperOwnClassif"] = "Entrez le code de classification tel que utilisé par votre Centre.<br />
S’il y a plus d’un code de classification, faites des entrées séparées selon les besoins.";

//field v910
$BVS_LANG["helperOwnDesc"] = "Entrez les entêtes de sujet ou descripteurs tel que utilisés dans votre Centre. <BR />
S’il y a plus d’un descripteur, faites des entrées séparées selon les besoins. <br />";




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
$BVS_LANG["helperrecordIdentification"] = "Remplissage automatique de terrain.
Numéro séquentiel attribué et contrôlé par le système.<br>
Processeur d'identifier le titre dans la base de données.<br>
Joignez-vous dans ce domaine, le nombre correspondant au titre d'être décrit.
Ce champ est utilisé par le système pour faire le lien entre le dossier de titre et les enjeux.<br>
Exemples : <br/>
a) Identifiant : 1050<br/>
b) Identifiant : 415<br/>";

//field v100
$BVS_LANG["helperpublicationTitle"] = "Champ obligatoire.<br/>
Titre principal ou Titre propre du périodique dans la langue et le format dans lequel il apparaît incluant le titre alternatif s&#180;il existe mais en excluant les titres parallèles et toute autre information de titre.<br/>
Entrez le titre propre en transcrivant tous les éléments dans l&#180;ordre ou ils apparaissent sur la page de titre ou son substitution en suivant les règles orthographiques de la langue correspondante.<br/>
Respectez les règles de l&#180;ISBD<br/>
Les titres homonymes nécessitent un qualificatif afin de les distinguer (langue, lieu de publication, etc.). Suivez les règles ISBD pour des qualificatfs corrects.<br/>
Exemples : <br/>
a) Titre : Revista chilena de neurocirugía<br/>
b) Titre : Revista brasileira de saúde ocupacional<br/>
c) Titre : Pediatria (São Paulo)<br/>
d) Titre : Pediatría (Bogotá)<br/>
e) Titre : Abboterapia (English ed.)<br/>
f) Titre : Abboterapia (Spanish ed.)";

//field v140
$BVS_LANG["helpernameOfIssuingBody"] = "Organisme responsable du contenu intellectuel du périodique.<br/>
Entrez la mention de responsabilité telle qu&#180;elle se présente sur la page de titre ou son substitut. Respectez les règles ISBD(S)<br/>
Si une mention de responsabilité inclue une hiérarchie, transcrivez-la dans la forme et dans l&#180;ordre ou elle apparaît dans le périodique séparée par des virgules<br/>
Si une mention de responsabilité dans sa forme étendue est une partie du titre du périodique, il n&#180;est pas nécessaire de la répéter ici.<br/>
Ce champ devient obligatoire dans le cas des périodiques avec des titres contenant des titres génériques tels que : Bulletin, Annuaire, Revue, etc. ou les termes correspondants en d&#180;autres langues<br/>
Dans le cas de plusieurs mentions de responsabilité, faites des entrées séparées pour chacune d’elles.<br/>
Exemples : <br/>
a) Mention de responsabilité : Académie Nationale de Médécine<br/>
b) Mention de responsabilité : Société Brésilienne de Cardiologie";

//field v149
$BVS_LANG["helperkeyTitle"] = "Le titre principal tel que attribué par le réseau de l’ISSN ensemble avec l’ISSN.
Un titre principal peut être identique au titre propre si ce dernier est unique.
Si deux titres sont identiques, les titres principaux uniques (unique)sont construits en ajoutant des qualificatifs ou des éléments d’identification tels que Editeur, Lieu d’édition, Edition etc.<br />
Exemples :<br />
ISSN 0340-0352 = Journal de l’IFLA<br />
ISSN 0268-9707 = Bulletin des Services Bibliographiques de la Bibliothèque de l’Angleterre<br />
ISSN 0319-3012 = Image (Nicaragua ed.)";

//field v150
$BVS_LANG["helperabbreviatedTitle"] = "Titre propre sous sa forme abr&#233;g&#233;e<br/>
Entrer le titre abr&#233;g&#233;, suivant les conventions pour les majuscules/minuscules et les diacritiques selon la norme ISO 4-1984 et la liste des abr&#233;viations des mots de titres de p&#233;riodiques.<br/>
Ce champ est obligatoire pour les p&#233;riodiques index&#233;s dans LILACS et/ou MEDLINE.<br/>
Exemples :<br/>
a)Titre: Revista brasileira de sa&#250;de ocupacional<br/>
  Titre abr&#233;g&#233;: Rev. bras. sa&#250;de ocup<br/>
b)Titre: Abboterapia (Spanish ed.)<br/>
  Titre abr&#233;g&#233;: Abboterapia (Sp. ed.)<br/>
c)Titre: : Pediatria (S&#227;o Paulo)<br/>
  Titre abr&#233;g&#233;: Pediatria (S&#227;o Paulo)";

//field v180
$BVS_LANG["helperabbreviatedTitleMedline"] = "Titre abrégé pour d’autres bases de données.<br />
Pour des besoins d’extraction et d’export, ajoutez des abréviations différentes dans les bases de données avec lesquelles vous collaborez. <br />
Cliquez sur le bouton Sous champ pour ajouter un code de Base de données et un titre abrégé.<br />
S’il y a plus d’une base de données, faites des entrées séparées pour chacune d’elles.<br /> <br />

Exemple : pour Rvue BRESILIENNE D’ENTOMOLOGIE<br />
Databases : <br />
ISO^aRev. Bras. Entomol.
JCR^aREV BRAS ENTOMOL
MDL^aRev Bras Entomol
LL^aRev. bras. entomol.
LATINDEX^aRev. Bras. Entomol. (Impr.)
SciELO^aRev. Bras. entomol.";


	/**************************************** Step 2  ****************************************/

//field v110
 $BVS_LANG["helpersubtitle"] = "Sous-titre. Information subordonn&#233;e au titre qui le compl&#232;te, le qualifie ou le rend plus explicite.<br/>
Entrer dans ce champ l&#180;information d&#233;finie comme sous-titre uniquement si cela est n&#233;cessaire pour l&#180;identification du p&#233;riodique. Pour les variantes de titres, utiliser les champs sp&#233;cifiques.<br/>
Exemples :<br/>
a) Titre: MMWR<br/>
   Sous-titre : Morbidity and mortality weekly report";

//field v120
$BVS_LANG["helpersectionPart"] = "D&#233;signation alphab&#233;tique ou num&#233;rique de la section ou partie, qui compl&#232;te le titre propre et en d&#233;pend pour l&#180; identification ou la compr&#233;hension<br/>
Entrer le terme s&#233;ries, section, partie ou &#233;quivalent seulement si c&#180; est une partie du titre<br/>
Mettre en majuscule la premi&#232;re lettre des termes significatifs<br/>
Exemples :<br/>
<br/>a) Titre: Bulletin signaletique<br/>
       Section: Section 330<br/>
b) Titre: Acta pathologica et microbiologica scandinavica<br/>
   Section: Section A";

//field v130
$BVS_LANG["helpertitleOfSectionPart"] = "Nom de la section, partie ou supplément qui complète le titre propre et en dépend pour l&#180;identification ou la compréhension.<br/>
Transcrivez-le nom de la section, partie ou supplément tel qu&#180;il apparaît sur la page de titre ou son substitut.
Mettez la première lettre en majuscule<br/>
Dans le cas de suppléments avec un titre identique au titre principal, et qui constitue un nouveau titre, entrez dans ce champ le mot &#180;Supplément&#180; pour distinguer ce titre d&#180;un autre<br/>
Exemples :<br/>
a) Titre : Acta amazonica<br/>
   Titre section: Supplément<br/>
b) Titre : Bulletin signaletique<br/>
   Section/part : Section 330<br/>
   Titre de section : Sciences pharmacologiques";

//field v230
$BVS_LANG["helperparallelTitle"] = "Titre propre de périodique qui apparaît aussi dans d&#180;autres langues sur la page de titre ou son substitut<br/>
Entrez les titres parallèles suivant la séquence et la forme ou ils apparaissent sur la page de titre ou son substitut en suivant les règles ISBD.<br/>
Si le périodique a des titres parallèles incluant des sections, parties ou suppléments dans d&#180;autres langues, entrez-les successivement en séparant les éléments par des points. (Titre courant. Titre de section, partie ou supplément).<br/>
Dans le cas de plusieurs titres parallèles, créez une entrée séparée pour chacun d’eux.<br/>
Exemples :<br/>
<br/>
a) Titre : Archives de toxicologie<br/>
   Titre parallèle : Archiv fur toxikologie<br/>
b) Titre : Arzneimittel forschung<br/>
   Titre parallèle : Recherche sur la drogue";

//field v240
$BVS_LANG["helperotherTitle"] = "Variantes du titre propre apparaissant dans le p&#233;riodique telles que : titre de couverture, quand diff&#233;rent de la page de titre, titre &#233;tendu et autres formes de titre<br/>
Inclure ici les (petites) variantes du titre qui ne n&#233;cessitent pas un nouvel enregistrement mais qui sont justifi&#233;s dans le cadre de la recherche<br/>
Dans le cas de plusieurs variantes de titre, cr&#233;er une entr&#233;e s&#233;par&#233;e pour chacune<br/>
Exemples :<br/>
a) Titre: Boletin de la Academia Nacional de Medicina de Buenos Aires<br/>
   Autres formes du titre : Boletin de la Academia de Medicina de Buenos Aires<br/>
b) Titre: Folha m&#233;dica<br/>
   Autres formes du titre : FM: a folha m&#233;dica";

//field v510
$BVS_LANG["helpertitleHasOtherLanguageEditions"] = "Ce champ fait le lien entre le titre décrit et ses éditions en d&#180;autres langues<br/>
Entrez le titre du périodique dans les autres langues tel qu&#180;il apparaît en suivant les règles ISBD.<br/>
Dans le cas de plusieurs éditions en d&#180;autres langues, créez une entrée séparée pour chacune d’elles.<br/>
Exemples :<br/>
a) Titre : Therapeutics bulletin<br/>
   Paraît en d&#180;autres langues : Boletim de medicamentos e terapeutica<br/>
b) Titre: Abboterapia (Spanish ed.)<br/>
   Paraît en d&#180;autres langues : Abboterapia (English ed.)";

//field v520
$BVS_LANG["helpertitleAnotherLanguageEdition"] = "Ce champ fait le lien entre le titre décrit et ses éditions en d&#180;autres langues<br/>
Entrez le titre du périodique dans les autres langues tel qu&#180;il apparaît en suivant les règles ISBD.<br/>
Dans le cas de plusieurs éditions en d&#180;autres langues, créez une entrée séparée pour chacune d’elles.<br/>
Exemples :<br/>
a) Titre : Boletim de medicamentos e terapeutica<br/>
   Est l&#180;édition en une autre langue de : Drug and therapeutics bulletin<br/>
b) Titre: Abboterapia (English ed.)<br/>
   Est l&#180;édition en une autre langue de : Abboterapia (Spanish ed.)";

//field v530   
$BVS_LANG["helpertitleHasSubseries"] = "Ce champ fait le lien entre le titre décrit et ses sous-séries (périodiques avec un titre séparé et une numérotion publiés en tant que partie d&#180;une série plus large)<br/>
Entrez le nom des sous-séries tel qu&#180;il apparaît en suivant les règles ISBD.<br/>
Dans le cas de plusieurs sous-séries, créez une entrée séparée pour chacune d’elles.<br/>
Exemples : <br/>
a) Titre : Biochimica et biophisica acta<br/>
   A comme sous-séries : Biochimica et biophysica acta. Biomembranes";

//field v540
$BVS_LANG["helpertitleIsSubseriesOf"] = "Ce champ fait le lien entre le titre d&#233;crit et son titre g&#233;n&#233;rique (sup&#233;rieur)<br/>
Entrer le titre des s&#233;ries auxquelles appartient cette sous-s&#233;rie en respectant les r&#232;gles ISBD.<br/>
Exemples :<br/>
a) Titre: Biochimica et biophysica acta<br/>
Titre section:  Enzymology<br/>
Est une sous-s&#233;rie de: Biochimica et biophysica acta";

//field v550
$BVS_LANG["helpertitleHasSupplementInsert"] = "Ce champ fait le lien entre le titre d&#233;crit et son suppl&#233;ment ou encart (fascicules g&#233;n&#233;ralement publi&#233;s avec une num&#233;rotation s&#233;par&#233;e, compl&#233;tant le titre principal)<br/>
Entrer le titre du suppl&#233;ment ou de l&#180;encart, en respectant les r&#232;gles ISBD<br/>
Dans le cas de plusieurs suppl&#233;ments ou encarts, cr&#233;er une entr&#233;e s&#233;par&#233;e pour chacun.<br/>
Exemples :<br/>
a)Titre: Scandinavian journal of plastic and reconstructive surgery<br/>
A comme suppl&#233;ment/encart: Scandinavian journal of plastic and reconstructive surgery. Supplement<br/>
b) Titre: Revista m&#233;dica de Chile<br/>
A comme suppl&#233;ment/encart: Boletin de la Sociedad de Cirugia de Chile";

//field v560
$BVS_LANG["helpertitleIsSupplementInsertOf"] = "Ce champ fait le lien entre le titre d&#233;crit et le titre parent<br/>
Entrer le titre parent de ce suppl&#233;ment ou encart, en respectant les r&#232;gles ISBD<br/>
Exemples :<br/>
a) Titre: Scandinavian journal of plastic and reconstructive surgery<br/>
Titre section: Supplement<br/>
Est un suppl&#233;ment/encart de: Scandinavian journal of plastic and reconstructive surgery<br/>
b) Titre: Boletim da Academia Brasileira de Neurologia<br/>
Est un suppl&#233;ment/encart de: Arquivos de neuro-psiquiatria";



	/**************************************** Step 3  ****************************************/

//field v610
$BVS_LANG["helpertitleContinuationOf"] = "Ce champ fait le lien entre le titre décrit et ses anciens (précédents) titres<br/>
Entrez le titre précédent de ce périodique en respectant les règles ISBD<br/>
Dans le cas de plusieurs anciens titres, créez une entrée séparée pour chacun d’eux.<br/>
Exemples : <br/>
a) Titre : Revista argentina de urología y nefrología<br/>
Continuation of : Revista argentina de urología<br/>
b) Titre : Revista de la Asociación Médica Argentina<br/>
Continuation of : Revista de la Sociedad Médica Argentina";

//field v620
$BVS_LANG["helpertitlePartialContinuationOf"] = "Ce champ qui relie le titre en cours de description avec le titre est une continuation séquentielle de.<br />
Entrez les titres anciens (previous) de ce périodique en suivant <a href=javascript:showISBD(\'fr\');>ISBD rules
- édition consolidée 2007</a>.<br />
Cliquez sur le bouton Sous champ et entrez le titre et l’ISSN dans la fichier de travail actif. <br />
(Dans la base de données, le sous champ pour l’ISSN est ^x et sera automatiquement ajouté).<br />
S’il y a plusieurs anciens titres, faites une entrée séparée pour chacun d’eux.<br />
<br />
Exemples :<br />
a) Tire du périodique : Comptes rendus hebdomadaires de séances de l&#180;Academie des Sciences^x0567-655X<br />
Section/Part : Série D<br />
Titre de la section/part : Sciences naturelles<br />
Continuation partielle de : Comptes rendus hebdomadaires de séances de l&#180;Academie des Sciences^x0001-4036";

//field v650
$BVS_LANG["helpertitleAbsorbed"] = "Ce champ relie le titre en cours de description au (x) titre(s) qu’il a englobé (inclus).<br />
Entrez le titre du périodique inclus en suivant <a href=javascript:showISBD(\'fr\');>ISBD rules -
consolidated edition 2007</a>.<br />
Cliquez sur le bouton du Sous champ et entrez le titre et l’ISSN dans la  fichier de travail actif. <br />
(Dans la base de données, le sous champ pour l’ISSN est ^x et sera automatiquement ajouté).<br />
S’il y a plus d’un périodique englobé (inclus), faites une entrée séparée pour chacun d’eux.<br />
<br />
Exemples :<br />
a) Tire du périodique : Revue brésilienne d’ophtamologie^x0034-7280<br />";

//field v660
$BVS_LANG["helpertitleAbsorbedInPart"] = "Ce champ fait le lien entre le titre d&#233;crit et le titre qu&#180;il a partiellement absorb&#233;.<br/>
Entrer le titre partiellement absorb&#233; par ce p&#233;riodique, en respectant les r&#232;gles ISBD<br/>
Dans le cas de plusieurs titres partiellement absorb&#233;s, cr&#233;er une entr&#233;e s&#233;par&#233;e pour chacun.<br/>
Exemples :<br/>
a) Titre: Journal of pharmacology and experimental therapeutics<br/>
A partiellement absorb&#233;: Pharmacological reviews";

//field v670
$BVS_LANG["helpertitleFormedByTheSplittingOf"] = "Ce champ fait le lien entre le titre d&#233;crit et le(s) titre(s) dont il est issu.<br/>
Entrer le(s) titre(s) pr&#233;c&#233;dent(s), en respectant les r&#232;gles ISBD<br/>
Dans le cas de la scission de plusieurs titres , cr&#233;er une entr&#233;e s&#233;par&#233;e pour chacun.<br/>
Exemples :<br/>
a) Titre: Acta neurologica belgica<br/>
Form&#233; par la scission de: Acta neurologica et psychiatrica belgica";

//field v680
$BVS_LANG["helpertitleMergeOfWith"] = "Ce champ fait le lien entre le titre d&#233;crit et les titres ayant fusionn&#233; pour donner le titre actuel<br/>
Entrer les titres fusionn&#233;s, en respectant les r&#232;gles ISBD<br/>
Cr&#233;er une entr&#233;e s&#233;par&#233;e pour chacun.<br/>
Exemples: <br/>
a) Titre: Revista de psiquiatria din&#226;mica<br/>
Fusion de ... avec ...: Arquivos da cl&#237;nica Pinel<br/> Psiquiatria (Porto Alegre)<br/>
b) Titre: Gerontology<br/>
Fusion de ... avec ...: Gerontologia Cl&#237;nica<br/> Gerontologia";

//field v710
$BVS_LANG["helpertitleContinuedBy"] = "Ce champ fait le lien entre le titre d&#233;crit et son(ses) titre(s) suivant(s).<br/>
Entrer le(s) titre(s) continuant ce p&#233;riodique, en respectant les r&#232;gles ISBD.<br/>
Dans le cas de plusieurs titres suivants, cr&#233;er une entr&#233;e s&#233;par&#233;e pour chacun.<br/>
Exemples :<br/>
a) Titre: Anais da Faculdade de Farmacia e Odontologia da Universidade de S&#227;o Paulo<br/>
Continu&#233; par: Revista da Faculdade de Odontologia da Universidade de S&#227;o Paulo";

//field v720
$BVS_LANG["helpertitleContinuedInPartBy"] = "Ce champ fait le lien entre le titre d&#233;crit et son(ses) titre(s) partiel(s) suivant(s).<br/>
Entrer le(s) titre(s) continuant partiellement ce p&#233;riodique, en respectant les r&#232;gles ISBD.<br/>
Dans le cas de plusieurs titres suivants, cr&#233;er une entr&#233;e s&#233;par&#233;e pour chacun.<br/>
Exemples :<br/>
a)Titre: Annales de mibrobiologie<br/>
Continu&#233; partiellement par: Annales de virologie<br/>
b) Titre: Journal of clinical psychology<br/>
Continu&#233; partiellement par:  Journal of community psychology";

//field v750
$BVS_LANG["helpertitleAbsorbedBy"] = "Ce champ fait le lien entre le titre d&#233;crit et le titre qu&#180;il a absorb&#233;.<br/>
Entrer le titre absorb&#233; par ce p&#233;riodique, en respectant les r&#232;gles ISBD<br/>
Dans le cas de plusieurs titres absorb&#233;s, cr&#233;er une entr&#233;e s&#233;par&#233;e pour chacun.<br/>
Exemples :<br/>
a) Titre: Boletim da Sociedade Brasileira de Oftalmologia<br/>
A absorb&#233;: Revista brasileira de oftalmologia";

//field v760
$BVS_LANG["helpertitleAbsorbedInPartBy"] = "Ce champ fait le lien entre le titre d&#233;crit et le titre l&#180;ayant partiellement absorb&#233;.<br/>
Entrer le titre ayant partiellement absorb&#233; ce p&#233;riodique, en respectant les r&#232;gles ISBD<br/>
Dans le cas de plusieurs titres, cr&#233;er une entr&#233;e s&#233;par&#233;e pour chacun.<br/>
Exemples <br/>
a)Titre: Health and social service journal<br/>
Partially absorbed by:  Community medicine";

//field v770
$BVS_LANG["helpertitleSplitInto"] = "Ce champ fait le lien entre le titre d&#233;crit et le(s) titre(s) issu(s) de la scission.<br/>
Entrer le(s) titre(s) issu(s) de la scission en respectant les r&#232;gles ISBD<br/>
Dans le cas de plusieurs titres issus de la scission, cr&#233;er une entr&#233;e s&#233;par&#233;e pour chacun.<br/>
Exemples :<br/>
a) Titre: Acta neurologica et psiquiatrica belgica<br/>
Has split into:<br/>
Acta neurologica belgica<br/>
Acta psychiatrica belgica";

//field v780
$BVS_LANG["helpertitleMergedWith"] = "Ce champ fait le lien entre le titre décrit et le(s) titre(s) avec lequel (lesquels) il a fusionné.<br/>
Entrez le(s) titre(s) issu(s) de la fusion en respectant les règles ISBD.<br/>
Dans le cas de plusieurs titres issus de la fusion, créez une entrée séparée pour chacun d’eux.<br/>
Exemples :<br/>
a) Titre : Anais da Faculdade de Farmacia e Odontologia da Universidade de São Paulo<br/>
b) A fusionné avec <br/>
Estomatologia e cultura. Revista da Faculdade de Odontologia de Ribeirão Preto";

//field v790
$BVS_LANG["helpertitleToForm"] = "Ce champ fait le lien entre le titre décrit et les titres enregistrés dans le champ 780.<br/>
Entrez le(s) de(s) périodique(s) issu(s) de la fusion des titres enregistrés au champ 780 en respectant les règles ISBD.<br/>
Dans le cas de plusieurs périodiques ayant fusionné, créez une entrée séparée pour chacun.<br/>
Exemples :<br/>
a) Titre : Anais da Faculdade de Farmacia e Odontologia da Universidade de São Paulo<br/>
b) A fusionné avec : Estomatologia e cultura<br/>
Revista da Faculdade de Odontologia de Ribeirão Preto<br/>
Sous la forme : Revista de odontologia da Universidade de São Paulo<br/>
b) Titre : Psiquiatria (Porto Alegre)<br/>
A fusionné avec : Arquivos da clínica Pinel<br/>
Sous la forme : Revista de psiquiatria dinâmica";



	/**************************************** Step 4  ****************************************/

//field v480
$BVS_LANG["helperpublisher"] = "Ce champ fait le lien entre le titre décrit et les titres enregistrés dans le champ 780.<br/>
Entrez le(s) de(s) périodique(s) issu(s) de la fusion des titres enregistrés au champ 780 en respectant les règles ISBD.<br/>
Dans le cas de plusieurs périodiques ayant fusionné, créez une entrée séparée pour chacun.<br/>
Exemples :<br/>
a) Editeur : Pergamon Press<br/>
b) Editeur : Plenum Press";

//field v490
$BVS_LANG["helperplace"] = "Lieu d&#180;édition (ville) du périodique en cours de description.<br/>
Entrez le nom de la ville dans la langue dans laquelle il apparaît dans le périodique.<br/>
Si le titre apparaît dans plus d&#180;une langue, entrez le nom de la ville dans la langue du titre propre.<br/>
Si le lieu d&#180;édition ne peut être déterminé entrez l&#180;abréviation s.l (sans lieu).<br/>
a) Lieu de publication : São Paulo<br/>
b) Lieu de publication : Porto Alegre<br/>
c) Lieu de publication : s.l";

//field v310
$BVS_LANG["helpercountry"] = "Code de pays du périodique en cours de description. <br/>
Choisissez le pays dans la liste de choix proposée. Le champ sera rempli avec le code correspondant au pays. <br/>
Exemples : <br/>
a) Pays d&#180;édition : Brésil <br/>
b) Pays d&#180;édition : Chili ";

//field v320
$BVS_LANG["helperstate"] = "Code de l&#180;Etat/province du périodique en cours de description. <br/>
Ce champ est obligatoire pour les publications du Brésil (dans l&#180;environnement VHL) et facultatif pour les autres pays fédérés. <br/>
Choisissez l&#180;Etat dans la liste de choix proposée. Le champ sera rempli avec le code correspondant à l&#180;Etat/province. <br/>
<br/>
Exemples : <br/>
a) Etat : SP<br/>
b) Etat : RJ<br/>";

//field v400
$BVS_LANG["helperissn"] = "Numéro Unique de ISSN attribué au titre du périodique par le Système International des Données des Périodiques (SIDP). <br/>
Entrez le code ISSN complet y compris le trait d&#180;union. <br/>
Exemples :<br/>
a) ISSN: 0716-0860<br/>
b) ISSN: 0716-114X";

//field v410
$BVS_LANG["helpercoden"] = "Code attribué au titre du périodique par la Société Américaine pour les Essais et les Matériaux(SAEM). <br/>
Entrez le code tel qu&#180;il apparaît sur le périodique.<br/>
Exemples :<br/>
a) CODEN : FOMEAN<br/>
b) CODEN : RCPDAF<br/>";


//field v50
$BVS_LANG["helperpublicationStatus"] = "Champ obligatoire. Sélectionnez le status de la publication comme actuelle si elle est actuellement publiée,
 Autrement sélectionnez : Arrêté/Suspendu ou Inconnu.<br />

Exemple :<br />
Statut de la publication : Actuelle<br />";

//field v301
$BVS_LANG["helperinitialDate"] = "Année et mois du premier numéro.<br />
Entrez la date initiale de publication en utilisant les bréviations standard pour les mois dans la langue du titre propre.<br />
Le mois est optionnel. S’il est utilisé le mois précède l’année.<br />
S’il est impossible de déterminer l’année exacte du premier numéro, entrez l’année selon la forme suivante :<br />
1983 Date connue.<br />
?983 Date probable.<br />
198? Date incertaine.<br />
19?? Décennie incertaine.<br />
1??? Siècle incertain.<br />
Exemples :<br />
a) Premier numéro : jan./mar. 1974<br />
b) Premier numéro : 1987<br />
c) Premier numéro : sep. 1988";

//field v302
$BVS_LANG["helperinitialVolume"] = "Premier numéro publié du périodique en cours de descritpion.<br />
Entrez le numéro du volume en chiffres arabes et non Romains.<br />
Laissez cette information si elle est incertaine.<br />
Exemples :<br />
a) Premier volume : 1<br />
b) Premier volume : 4";

//field v303
$BVS_LANG["helperinitialNumber"] = "Numéro du premier numéro du périodique décrit.<br />
Entrez le numéro en chiffres arabes et non Romains.<br />
Exemples :<br />
a) Numéro initial : 1<br />
b) Numéro initial : 2";

//field v304
$BVS_LANG["helperfinalDate"] = "L’année et le mois du dernier numéro.<br />
Entrez la date de la publication finale en utilisant les abréviations standard pour les mois dans la langue du titre propre.<br />
Le mois est optionnel. S’il est utilisé le mois précède l’année.<br />
Exemples :<br />
a) Dernier numéro : oct. 1984<br />
b) Dernier numéro : 1988";

//field v305
$BVS_LANG["helperfinalVolume"] = "Dernier numéro publié.<br />
Entrez le numéro du volume en chiffres Arabes chiffres arabes et non Romains.<br />
Exemples :<br />
a) Dernier volume : 10<br />
b) Dernier volume : 12";

//field v306
$BVS_LANG["helperfinalNumber"] = "Numéro du dernier numéro en cours de description.<br />
Entrez le numéro du numéro en chiffres arabes.<br />
Exemples :<br />
a) Dernier numéro : 7<br />
b) Dernier numéro : 10";


//field v380
$BVS_LANG["helperfrequency"] = "Code identifiant la fr&#233;quence d&#180;&#233;dition du p&#233;riodique.<br/>
Choisissez la fr&#233;quence appropri&#233;e dans la liste de choix propos&#233;e. La lettre du code correspondant sera entr&#233;e dans le champ.<br/>
Exemples : <br/>
a) Fr&#233;quence actuelle : B<br/>
b) Fr&#233;quence actuelle : T<br/>";

//field v330
$BVS_LANG["helperpublicationLevel"] = "Code d&#233;finissant le niveau intellectuel du p&#233;riodique. <br/>
Choisissez l&#180;un des codes suivants : <br/>
CT - Scientifique/technique : pour les p&#233;riodiques y compris des articles bas&#233;s sur la recherche scientifique ou sur la signature des avis d&#180;experts (y compris les &#233;tudes cliniques).<br/>
DI - Sensibilisation : pour la plupart des p&#233;riodiques y compris les articles non sign&#233;s, des notes d&#180;information etc. <br/>
Exemples :<br/>
a) Niveau de publication : CT<br/>
b) Niveau de publication : DI<br/>";

//field v340
$BVS_LANG["helperalphabetTitle"] = "Anglais, Croate, Latin <br/>
B - Romain étendu : pour les langues anglo-saxons et romaines avec des signes diacritiques telles que : <br/>
Portugais, Allemand, Français, Espagnol, Italien. <br/>
C - Cyrillique : pour les langues slaves telles que : <br/>
Russe, Bulgare, Tchèque, Ukrainien, Serbe etc. <br/>
D - Japonais. <br/>
E - Chinois. <br/>
K - Coréen. <br/>
Pour les autres alphabets, consultez le manuel du Système International des Données des Périodiques (SIDP).<br/>
<br/>
Exemples : <br/>
a) Alphabet du titre : A<br/>
b) Alphabet du titre : C<br/>";

//field v350
$BVS_LANG["helperlanguageText"] = "Code identifiant la langue utilisée dans le texte du périodique. <br/>
Choisissez la langue dans la liste de choix proposée. Le champ sera rempli avec le code de la langue correspondante. <br/>
S&#180;il y a plus d&#180;une langue, faites une entrée distincte pour chacune d&#180;elles.<br/>
<br/>
Exemples :<br/>
a) Langue du texte : Fr<br/>
b) Langue du texte : Es<br/>
c) Langue du texte : En<br/>
Pt<br/>";

//field v360
$BVS_LANG["helperlanguageAbstract"] = "Code identifiant la langue utilisée dans les résumés du périodique. <br/>
Choisissez la langue dans la liste de choix proposée. Le champ sera rempli avec le code de la langue correspondante. <br/>
S&#180;il y a plus d&#180;une langue, faites une entrée distincte pour chacune d&#180;elles. <br/>
Exemples : <br/>
a) Langue des résumés : EN<br/>
b) Langue des résumés : En<br/>
Pt<br/>
c) Langue des résumés : Es";



	/**************************************** Step 5  ****************************************/

//field v40
$BVS_LANG["helperrelatedSystems"] = "Code identifiant le ou les système (s) à auquel (s) l&#180;enregistrement actuel doit être transféré. <br/>
Ce champ est obligatoire pour le catalogage des organismes fournissant des données au Registre des Périodiques en Sciences de la Santé de BIREME et pour les titres indexés dans LILACS et/ou MEDLINE.<br/>
Le champ est utilisé par le système pour générer des données d&#180;exploitation à transmettre à BIREME. <br/>
Entrez l&#180;identifiant du SeCS ou un autre code de système. <br/>
S&#180;il y a plus d&#180;un code de système, faites une entrée distincte pour chacun d&#180;eux. <br/>
Exemples : <br/>
a) Systèmes connexes : SECS <br/>
b) Systèmes connexes : CAPSALC<br/>
c) Systèmes connexes : SECS<br/>
CAPSALC <br/>";

//field v20
$BVS_LANG["helpernationalCodeo"] = "Code identifiant le titre au sein du système national de contrôle des titres de périodiques (ou son équivalent) afin de faciliter le transfert de données à de tels systèmes.<br/>
Entrez le code national du périodique tel que fourni par l&#180;organisme responsable du système national ou son équivalent. <br/>
Exemples : <br/>
a)Code national : 001060-X (Numéro SIPS dans le Catalogue Collectif National du Brésil) <br/>
b) Code national: 00043/93<br/>";

//field v37
$BVS_LANG["helpersecsIdentification"] = "Numéro d&#180;identification du titre dans le Registre des Périodiques en Sciences de la Santé<br/>
Entrez le numéro d&#180;identification fourni par BIREME pour ce titre. <br/>
Ce champ est obligatoire pour les organismes de  catalogage qui fournissent des données d&#180;exploitation pour BIREME. <br/>
Le champ est utilisé par le système pour générer les données d&#180;exploitation à transmettre à BIREME. <br/>
Si le titre a un code d&#180;identification SECS dans le domaine relatif du système, ce domaine devrait également être utilisé.<br/>
Exemples : <br/>
a) Numéro SECS : 2<br/>
b) Numéro SECS : 4<br/>";

//field v430
$BVS_LANG["helperclassification"] = "Termes contrôlés utilisés pour représenter le sujet matière principal du périodique. <br/>
Les participants au réseau de BIREME doivent utiliser les descripteurs extraits de DeCS (Descripteurs en Sciences de la Santé). <br/>
S&#180;il y a plus d&#180;un descripteur, faites une entrée distincte pour chacun d&#180;eux. <br/>
Entrez un maximum de 04 descripteurs. <br/>
Exemples : <br/>
a) Descripteurs : médecine du travail<br/>
b) Descripteurs : NEUROLOGIE <br/>
PEDIATRIE <br/>
c) Descripteurs : NEUROLOGIE<br/>
d) Descripteurs : GYNÉCOLOGIE<br/>
OBSTÉTRIQUE<br/>";

//field v421
$BVS_LANG["helperclassificationCdu"] = "CDU (Classification Décimale Universelle)<br />
Entrez un code de classification CDU pour ce périodique.<br />
Exemples: <br />
159.964.2 (for Psychê; psychoanalytical journal)<br />
61:57(05) (for Revista de ciências médicas e biológicas)";

//field v422
$BVS_LANG["helperclassificationDewey"] = "CDD (Classification Décimale Dewey) <br />
Entrez un code de classification Dewey pour ce périodique.<br />
Exemple : <br />
610.05 (for Revista de ciências médicas e biológicas)";

//field v435
$BVS_LANG["helperthematicaArea"] = "Vedettes sujet de <strong>CNPq table</strong> développé par le Conseil National de Développement Technologique et Scientifique du Brésil. <br />
Le système CNPq utilize quatre niveaux : terme le plus large, terme général, sous-domaine et spécialité.";

//field v440
$BVS_LANG["helperdescriptors"] = "Termes contrôlés utilizes pour le sujet principal l’objet principal du périodique.<br />
Les participants au réseau de BIREME doivent utiliser les descripteurs extraits de DeCS (Descripteurs en Sciences de la Santé).<br />
S’il y a plus d’un descripteur, faites une entrée pour chacun d’eux.<br />
Entrez au maximum 4 descripteurs.<br />
Exemples :<br />
a) Descripteurs : OCCUPATIONAL MEDICINE<br />
b) Descripteurs : <br />NEUROLOGIE<br />PEDIATRIE<br />
c) Descripteurs : NEUROLOGIE<br />
d) Descriptors: GYNECOLOGIE<br />OBSTETRIQUE";

//field v441
$BVS_LANG["helperotherDescriptors"] = "Descripteurs sujet defines par l’agence de catalogage ou extraits d’un autre thesaurus non contenu dans DeCS.";

//field v450
$BVS_LANG["helperindexingCoverage"] = "Code identifiant les sources secondaires d&#180;information qui indexent le périodique en cours de description.<br/>
Entrez le code de la source d&#180;indexation comme suit : <br/>
IM-Index Medicus. <br/>
IL-Index Medicus Latino Américain. <br/>
EM-Excerpta Medica. <br/>
BA- Biological abstracts. <br/>
LL-LILACS. <br/>
SP-Saude Publica. <br/>
Quand un titre est choisi pour l&#180;indexation dans la base de données LILACS, il est obligatoire de le décrire aussi dans le système SeCS. <br/>
Consultez le manuel LILACS pour plus d&#180;informations sur la sélection de périodiques pour l&#180;indexation. <br/>
Vous pouvez ajouter d&#180;autres sources pertinentes d&#180;indexation au besoin en entrant leurs titres dans leur intégralité.<br/>
Exemples : <br/>
a) L&#180;indexation de la couverture : EM<br/>
BA<br/>
b) L&#180;indexation de la couverture: IM<br/>
c) L&#180;indexation de la couverture : LL<br/>";

//field v450^a
$BVS_LANG["helperindexingCoverageA"] = "inscrire la date initiale à laquelle le papier a commencé à être indexée sur la source de référence";
//field v450^b
$BVS_LANG["helperindexingCoverageB"] = "enregistrer le volume initial dans lequel le papier a commencé à être indexé sur la source de référence";
//field v450^c
$BVS_LANG["helperindexingCoverageC"] = "inscrire la question initiale dans laquelle le papier a commencé être indexé sur la source de référence";
//field v450^d
$BVS_LANG["helperindexingCoverageD"] = "inscrire la date limite à laquelle le journal a cessé d'être indexée sur la source de référence";
//field v450^e
$BVS_LANG["helperindexingCoverageE"] = "enregistrer le dernier volume de la revue a cessé d'être indexée sur la source de référence";
//field v450^f
$BVS_LANG["helperindexingCoverageF"] = "enregistrement de la dernière tranche dans le journal a cessé de être indexé sur la source de référence";

//field v900
$BVS_LANG["helpernotes"] = "Notes complémentaires au sujet de tout aspect du périodique, son apparence ou son contenu. <br/>
Entrez les informations pertinentes pour l&#180;organisme responsable de la description du périodique dans un langage clair. <br/>
Entrez les notes complémentaires par ordre chronologique. <br/>
Exemples : <br/>
a) Notes : publication interrompue entre 1987-1976<br/>
b) Notes : volume 104 n&#180;a pas été édité<br/>";

//field v455
$BVS_LANG["helperCoveredSubjectDB"] = "Les vedettes contrôlées du sujet principal utilisées dans différentes bases de données de BIREME. <br />
Utilisé par BIREME.<br />
<br />
Exemple : (for the journal Memórias do Instiruto Oswaldo Cruz) <br />
JCR^aPARASITOLOGY;TROPICAL MEDICINE
MDL^aPARASITOLOGY;TROPICAL MEDICINE
SciELO^aCIENCIAS BIOLOGICAS
LL^aMEDICINA TROPICAL";

//field v850
$BVS_LANG["helperIndicators"] = "Les indicateurs statistiques et bibliométriques pour les revues scientifiques.<br />
A utiliser dans le réseau de BIREME.<br />
<br />
Exemples :<br />
JCR^a2007^v0.765<br />
SciELO^a2007^v0.124";

	/**************************************** Step 6  ****************************************/

//field v999

$BVS_LANG["helperurlPortal"] = "Les informations pour le portail composé d'un prestataire URL, du type de
contrôle d'accès et et de temps.
<br/><br/>
Il suffit de cliquer sur le bouton à côté de la zone de texte pour ouvrir un sous-champ
nouvelle fenêtre de remplir les informations sous le nom de
sur le terrain.";

//field v999^a
$BVS_LANG["helpField999SubfieldA"] = "Type d’accès – Champ v999^a <br /> <br />Définis le type d’accès aux articles du périodique avec les options suivantes :<br /><strong>Gratuit </strong> Accès gratuity aux pages correspondantes. <br /><strong>Gratuit pour les abonnés</strong><strong>Demande d’abonnement en ligne </strong> Abonnement à la version en ligne.<strong>Demande d’abonnement version papier</strong> Demande d’abonnement à la version imprimée.<strong>Demande d’abonnement en ligne/imprimé </strong>Accès autorisé pour les abonnés en ligne et à la version papier.";

//field v999^b
$BVS_LANG["helpField999SubfieldB"] = "Lien – Champ 999^b <br /> <br />Le lien Internet URL (Uniform Resource Locator) est l’adresse Internet complète du périodique. <br /> Le navigateur communique avec le serveur à travers la connexion TCP/IP sur le port 80 en utilisant le protocole HTTP. <br /> <br />Exemple : http://www.bireme.br/php/index.php";

//field v999^c
$BVS_LANG["helpField999SubfieldC"] = "Aggrégateur/Fournisseur – Champ 999^c <br /> <br />Les aggrégateurs sont des portails Internet qui permettent la recherche en texte intégral et l’accès à plusieurs bases de données. <br /> L’accès se fait par des abonnements payants et chers. Ils sont généralement disponibles dans les institutions académiques de recherche. <br />Les aggrégateurs principaux sont OVID, EBSCO and PROQUEST. Au Brésil, le portail CAPES donne accès à la recherche en texte intégral à plusieurs revues à travers des accords avec des universités. <br /> <br />Exemples : <br />CAPES-ScIELO <br />CAPES-OVID";

//field v999^d
$BVS_LANG["helpField999SubfieldD"] = "Contrôle d’accès – Champ 999^d <br /> <br />Les moyens pour contrôler que les ressources sont uniquemment accessibles aux usagers connectés. Les options sont :<br /> <br />Gratuit <br />Adresse IP <br />Mot de passe <br />Adresse IP/Mot de passe ";

//field v999^e
$BVS_LANG["helpField999SubfieldsEF"] = "Période – Champ 999^e et 999^f <br /> <br />Année initiale et finale d’accès aux articles en texte intégral. <br /><br />Exemple : <br />1997 to 2009";

//field v999^g
$BVS_LANG["helpField999SubfieldG"] = "Années complémentaires ou des numéros ou quelques numéros d’exemplaires - Champ 999^g<br /><br />Entrez l’information d’autres sources d’accès en ligne.<br /><br />EXEMPLE :<br /><br />";

//field v860
$BVS_LANG["helperurlInformation"] = "Information additionnelle concernant l’accès en ligne au périodique et à ses articles.<br /> <br />
Exemples : <br />
Articles disponibles à titre payant<br />
Accès à la Table des matières uniquement";

//field v861
$BVS_LANG["helperBanPeriod"] = "Interdiction ou embargo <br />Période au cours de laquelle la version en ligne du périodique/ou ses articles ne sont pas comuniqués au public en général.<br />
<br />
Exemple :<br />
Texte intégral en ligne à partir de Janvier 1995 avec 6 mois d’embargo.";


	/**************************************** Step 7  ****************************************/

//field v436
$BVS_LANG["helperspecialtyVHL"] = "Spécialité VHL. Terminologie VHL spécifique utilisé pour faciliter l’extraction du site.<br />
<br />
Exemple : ^aBVSSP^bALIMENTÇÃO E NUTRIÇÃO
est différent de la catégorie DECS correspond, SCIENCES DE NUTRITION";

//field v445
$BVS_LANG["helperuserVHL"] = "Utilisateurs VHL - Code identifiant le titre dans le système VHL en vue de faciliter l’exportation dans différents domaines thématiques<br />
Exemples : <br />
BVSSP <br />
ANVISA <br />
BVS-Evidência";

//field v910
$BVS_LANG["helpernotesBVS"] = "La raison pour laquelle le périodique a cessé d’être indexé dans LILACS <br />
Exemple : <br />
Indexation cessée à cause du retard dans la publication. <br />
Premier indexé : 1981 12(3) <BR />
Dernier indexé : 1998 48(2)";

//field v920
$BVS_LANG["helperwhoindex"] = "Centre participant responsable de l’indexation de ce périodique dans LILACS  <br />
Exemples :  <br />
BR1.1  <br />
AR29.1";

//field v930
$BVS_LANG["helpercodepublisher"] = "Obligatoire pour les participants au réseau de BIREME.<br />
Code attribué par BIREME aux éditeurs pour les périodiques indexés dans LILACS.
Le code est composé du code ISO du pays de l’éditeur et un numéro ID<br />
Le système utilise ce code pour relier les titres LILACS et les données des éditeurs dans la base de données Nmail. Il est par conséquent obligatoire pour CCs pour envoyer dans le formulaire CADASTRE DES EDITEURS DE REVUES LILACS<br />
Exemples :<br />
BR440.9<br />
AR29.9";


        /***************** ISBD - 2007 ****************************************/

$BVS_LANG["helpISBD"] = "Règles d’entrée basique de données pour les Titres de Périodiques – basés sur l’édition consolidée 2007 de l’ISBD adapté à l’environnement de base de données de SeCS-Web.<br /><br />1 – Lorsque le titre contient un ensemble d’initiales ou un acronyme visiblement placés sur la page de titre et si la forme étendue du titre apparaît aussi comme une partie du titre, entrez les initiales ou l’acronyme dans le Titre de la Publication (champ 100) et la forme étendue dans le Sous titre (champ 110). Si les initiales ou l’acronyme sont linguistiquement ou typographiquement séparés de la forme étendue, entrez l’acronyme dans le champ du Titre de la Publication et la forme étendue dans d’autres formes de Titre (champ 240).<br /><br />Exemples :<br />a) Titre de la Publication : ABCD<br />    Sous titre : arquivos brasileiros de cirugia digestiva<br />b) Titre de la Publication : Jornal da AMRIGS.<br />    Sous titre : jornal da Associação Médica do Rio Grande do Sul  <br /><br /><br />2 – Lorsque la mention de responsabilité apparaît dans une forme abrégée comme des initiales ou acronyme et comme une partie intégrée du titre propre, elle est repétée dans une forme étendue dans le champ 140, Organisme Editeur si elle apparaît dans le périodique décrit. Entrez la forme étendue du titre dans d’autres formes du titre (champ 240)<br /><br />Exemples :<br />Titre de la publication : ALA bulletin<br />Organisme Editeur : American Library Association<br />Autres forms de titre : American Library Association bulletin.<br /><br />3 – Lorsque le périodique ne dispose d’aucun autre élément de titre que la mention de responsabilité, entrez la mention de responsabilité comme titre propre dans le Titre de la publication. Il n’est pas nécessaire de répéter la mention de responsabilité dans le champ de l’Organisme éditeur.<br /><br />Exemple :<br />Titre de la publication : Universidad de Antioquia<br /><br />4- Lorsque le titre est composé uniquement d’un terme générique tel que Bulletin, Revue, Bulletin d’information etc. ou leur équivalent dans d’autres langues et est linguistiquement ou typographiquement séparé de la mention de la responsabilité, entrez le titre dans la forme dans laquelle il apparaît et ajoutez la mention de responsabilité dans l’Organisme éditeur (champ 140), qui dans ce cas devient obligatoire pour identifier correctement le périodique.<br /><br />Exemple :<br />Titre de la publication : Boletim<br />Organisme éditeur : Associação Médica Paulista<br /><br /><br />5 – Pour des titres homonymes, ajoutez des éléments de différenciation (qualificatif) à toutes les formes de titre propre (titre abrégé, titre parallèle, etc.).Cette information doit être ajoutée entre parenthèses après le titre séparé par un seul espace comme suit :<br /><br />5.1 – Les titres homonymes avec différents lieux de publication : ajoutez le lieu de publication (ville)<br /><br />Exemples :<br />Titre de la publication : Pediatria (São Paulo)<br />Titre de la publication : Pediatria (Bogotá)<br /><br />5.2 – Les titres homonymes avec les mêmes lieux de publication : ajoutez le lieu de publication (ville) et l’année de la première édition.<br /><br />Exemples :<br />Titre de la publication : Pediatria (São Paulo. 1983)<br />Titre de la publication : Pediatria (São Paulo. 1984)<br /><br />5.3 – Périodiques revenant à un ancien titre : ajoutez le lieu de publication (ville) et l’année de la première édition.<br /><br />Exemples :<br />Titre de la publication : Revista médica (1968)<br />Titre de la publication : Revista médica (1987)<br /><br />5.4 - Editions dans différentes langues avec les titres homonymes : entrez l’édition selon ISO 4-1984 et &#180;Liste des abréviations des mots du titre du périodique&#180;.<br />Exemples :<br />Titre de la publication : Abboterapia (Spanish ed.)<br />Titre de la publication : Abboterapia (Portuguese ed.)<br />Titre abrégé : Abboterapia (Span. ed.)<br />Tire abrégé : Abboterapia (Port. ed.)<br /><br />6 – Lorsqu’une section, une partie ou un supplément est publié séparément et dispose d’un titre spécifique qui peut être séparé du titre principal et le titre spécifique apparaît plus visible que le titre principal, faites un enregistrement séparé pour la section comme titre propre. Ajoutez l’information suivante dans le champ 560 : Est supplément/insertion de l’enregistrement dans la section et dans le champ 550 – A un supplément/insertion dans l’enregistrement du titre principal.<br /><br />Exemple :<br />Titre principal : Veterinary record<br />Titre spécifique : In practice<br />a) Titre de la publication : In practice<br />    Est supplément/insertion de : Veterinary record<br />b) Tire de la publication : Veterinary record<br />    A un supplément/insertion : In practice<br /><br />7 – Lorsque qu’un supplément a le même titre que l’édition principale et un nouvel enregistrement a été fait pour, différenciez-le en ajoutant le Supplément dands le champ 130 – Titre de la section/partie.<br />Exemple :<br />a) Titre de la publication : Ciência e cultura<br />Titre de la section/partie : Supplément<br />b) Titre de la publication : Acta cirúrgica brasileira<br />Titre de la section/partie : Supplément<br /><br />8 – Lorsque des titres parallèles apparaîssent sur la page du titre ou son sbstitut, entrez comme titre propre celui qui apparaît typographiquement visible. Lorsqu’il n’y a aucune distinction typographique entre les titres parallèles, entrez comme titre propre celui qui apparaît en premier et le reste comme titre parallèle dans le champ 230. <br />Exemple :<br />Tire de la publication : Progress in surgery<br />Titre parallèle : Progrès en chirurgie";

	/****************************************************************************************************/
	/**************************************** Library Section - Field Helps ****************************************/
	/****************************************************************************************************/

//field v2
$BVS_LANG["helpLibFullname"] = "Le nom sous lequel la bibliothèque/centre est connue.<br />
EXEMPLE : BIREME - OPS - OMS – Centre Latino-Américain et Caraïbéen des Sciences de l’Information sur la Santé";

//field v1
$BVS_LANG["helpLibCode"] = "Code utilisé pour identifier la bibliothèque, le centre ou l’unité d’information.<br />
La bibliothèque princicpale qui gère SeCS a un nom par défaut : PRINCIPAL<br />
<br />
EXEMPLES<br />
a) FAGRO<br />
b) Sciences<br />
<br />
Les bibliothèques qui appartiennent au réseau BIREME utiliseront le code ID attribué qui les identifie.<br />
Le code de la bibliothèque est composé du code ISO du pays dans lequel il est situé suivi par";

//field v9
$BVS_LANG["helpLibInstitution"] = "Acronyme et nom de l’institution dont la bibliothèque ou le système de bibliothèque fait partie intégrale.<br />
EXEMPLE : UNIFESP : Université Fédérale de São Paulo";

// field v3
$BVS_LANG["helpLibAddress"] = "Addresse complète de la Bibliothèque avec les suppléments appropriés(Rue, Avenue, etc.).<br />
EXEMPLE : Rue Botucatu, 862 - CEP 04023-901 - Villa Clementino";

// field v4
$BVS_LANG["helpLibCity"] = "Ville dans laquelle la bibliothèque est située.<br />
EXEMPLE : São Paulo";

//field v5
$BVS_LANG["helpLibCountry"] = "Pays dans lequel la bibliothèque est située.<br />
EXEMPLE : Brésil";

//field v6
$BVS_LANG["helpLibPhone"] = "Numéro de téléphone de la personne responsable de la Bibliothèque.<br />
EXEMPLE : (55 011) 55769876, (55 011) 55769800";

//field v7
$BVS_LANG["helpLibContact"] = "Nom complet de la personne responsable de la Bibliothèque.<br />
EXEMPLE : Raquel Cristina Vargas";

//field v10
$BVS_LANG["helpLibNote"] = "Plus d’information sur la Bibliothèque.<br />
Enregistrement dans ce champ dans toutes les langues, l’information qui d’intérêt pour l’unité d’information et pour ses usagers.<br />
EXEMPLE : Jours d’ouverture et de fermeture";

//field v11
$BVS_LANG["helpLibEmail"] = "Adresse électronique de la personnes responsable de la Bibliothèque.<br />
EXEMPLE: raquel.araujo@bireme.org";


	/****************************************************************************************************/
	/**************************************** Homepage - Search Field Helps ****************************************/
	/****************************************************************************************************/
/*
 * Help for Title search field and Title Plus search field in homepage section
 */

//search Title database
$BVS_LANG["helpSearchTitle"] = "Comment cherhcher dans la base de données Titre.<br /> <br />
Vous pouvez faire une recherche libre (option Tous les Index) ou faire la recherche par l’un des index disponibles dans la liste déroulante.<br/>
<br/>
Tapez un ou plusieurs termes dans la boîte de recherche et appuyez le bouton Recherche.<br/>
Il est possible de faire la recherche par tous les éléments en utilisant le symbole $<br/>
Ou une recherche avec troncature avec la racine du terme et le symbole $<br/>
Par exemple, une recherche par Brésil$ va donner Brésil, Brésiliens, etc.";

//search Title Plus database
$BVS_LANG["helpSearchTitlePlus"] = "Comment faire la recherche dans la base de données Titres étendus.<br /> <br />
Vous pouvez faire une recherche libre (option Tous les Index) ou faire de la recherche par l’un des index disponibles dans la liste déroulante.<br/>
<br/>
Des index ont prédéfini des valeurs pour la recherche, consultez le changement de la boîte de recherche en une liste avec les options disponibles.<br/>
Tapez un ou plusieurs termes dans la boîte de recherche et appuyez le bouton Recherche.<br/> Il est possible de faire la recherche par tous les éléments en utilisant le symbole $<br/>
une recherche avec troncature avec la racine du terme et le symbole $<br/>
Par exemple, une recherche par Brésil$ va donner Brésil, Brésiliens, etc.";


//search Mask database
$BVS_LANG["helpSearchMask"] = "Comment cherhcher dans la base de données Masques.<br /> <br />
Vous pouvez faire une recherche libre (option Tous les Index) ou faire la recherche par l’un des index disponibles dans la liste déroulante.<br/>
<br/>
Tapez un ou plusieurs termes dans la boîte de recherche et appuyez le bouton Recherche.<br/>
Il est possible de faire la recherche par tous les éléments en utilisant le symbole $<br/>
Ou une recherche avec troncature avec la racine du terme et le symbole $<br/>
Par exemple, une recherche par Brésil$ va donner Brésil, Brésiliens, etc.";

//search Issue database
$BVS_LANG["helpSearchIssue"] = "Comment cherhcher dans la base de données Num&#233;ro.<br /> <br />
Vous pouvez faire une recherche libre (option Tous les Index) ou faire la recherche par l’un des index disponibles dans la liste déroulante.<br/>
<br/>
Tapez un ou plusieurs termes dans la boîte de recherche et appuyez le bouton Recherche.<br/>
Il est possible de faire la recherche par tous les éléments en utilisant le symbole $<br/>
Ou une recherche avec troncature avec la racine du terme et le symbole $<br/>
Par exemple, une recherche par Brésil$ va donner Brésil, Brésiliens, etc.";

//search Users database
$BVS_LANG["helpSearchUsers"] = "Comment cherhcher dans la base de données Utilisateurs.<br /> <br />
Vous pouvez faire une recherche libre (option Tous les Index) ou faire la recherche par l’un des index disponibles dans la liste déroulante.<br/>
<br/>
Tapez un ou plusieurs termes dans la boîte de recherche et appuyez le bouton Recherche.<br/>
Il est possible de faire la recherche par tous les éléments en utilisant le symbole $<br/>
Ou une recherche avec troncature avec la racine du terme et le symbole $<br/>
Par exemple, une recherche par Brésil$ va donner Brésil, Brésiliens, etc.";

//search Library database
$BVS_LANG["helpSearchLibrary"] = "Comment faire la recherche dans la base de données Bibliothèque.<br /> <br />
Vous pouvez faire une recherche libre (option Tous les Index) ou faire de la recherche par l’un des index disponibles dans la liste déroulante.<br/>
<br/>
Des index ont prédéfini des valeurs pour la recherche, consultez le changement de la boîte de recherche en une liste avec les options disponibles.<br/>
Tapez un ou plusieurs termes dans la boîte de recherche et appuyez le bouton Recherche.<br/> Il est possible de faire la recherche par tous les éléments en utilisant le symbole $<br/>
une recherche avec troncature avec la racine du terme et le symbole $<br/>
Par exemple, une recherche par Brésil$ va donner Brésil, Brésiliens, etc.";

?>
