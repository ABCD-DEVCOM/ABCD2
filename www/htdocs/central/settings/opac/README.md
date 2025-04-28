# What's new?

## Opac - v1.1.3-beta (2025-04-28)

OPAC now has a practical autocomplete system in the survey form. Little by little, the elaborate survey forms will be replaced by more dynamic models. The ABCD autocomplete uses the json format, but there is no need to generate a .json file. The json is generated in the http://localhost:9090/opac/json.php?letra=A script, with the "letra" parameter determining the construction of the terms.

In this version, in addition to autocomplete using all available databases, the facets have also been corrected to work with all databases.

The facets have also gained another parameter. Now in the fourth column we can define how the facets are sorted. If 'A', the sorting takes place in alphabetical order, if 'Q', the sorting takes place according to the number of terms.

Images have also been given a better treatment. The ‘show_image.php’ script, used to render images from the repository, now has a fixed watermark with the installation URL, date and time to safeguard against improper copying of the collection.



## Opac - v1.1.2-beta (2025-04-24)

In this version, a radical change has been made to the Facets and consequently to the search flow. The general facets file is still in the *bases/opac_conf/en/facetas.dat* directory.
The database facets file is in */bases/dbname/opac/lang/dbname_facetas.dat*.

**The new structure looks like this:**
 Field | Format language | Prefix

**Example:**

 Year of publication | v260^c | DAT_

With this, the search flow starts with a free search and then you can add or delete terms as required.
To edit the facets, go to the “Database configuration” menu and click on a database. In the “Search” top menu, find “Facets”.



----
## Opac - v1.1.1-beta (2024-06-18)
* Improvements to the Opac configuration screen;
* It's easier to enable and disable bases for Opac, but check the warning below before starting your update;
* Visual <a href="javascript:EnviarForma('presentacion.php')">editing of styles possible</a>;
* Menu <a href="javascript:EnviarForma('adm_email.php')">Setup E-mail</a>
* Google Analytics - parameter <a href="javascript:EnviarForma('parametros.php')">GANALYTICS</a> in the opac.def file to enable the use of Google Analytics;
* On the front: Added Meta tags for SEO and Social Networks; 
* On the front: Added dark mode;
* On the front: Added the option to enlarge and reduce fonts;



### Alerts
*  The dbName.def file within /db/opac/lang/ was only used to define the database description, so this functionality has been incorporated into the opac_conf/lang/bases.dat file to maintain the standard for the entire ABCD. If you are updating your ABCD and Opac, please <a href="javascript:EnviarForma('/central/settings/opac/databases.php')">click here to re-generate your bases.dat file</a>.


### Corrections
- Fixed the advanced search form;
- Fixed the function for sending terms to the advanced search form;

----
## Opac – v1.1.0-beta (2023-03-28)
### New features
- Inclusion of Twitter Booststrap as the basis for new layouts;
- The OpacHttp parameter becomes mandatory for installations that want Opac to be the publicly accessible homepage;
- select_record.pft has been adjusted for Bootstrap;



----
# OPAC description
# OPAC-ABCD Description

### Characteristic

The ABCD Opac allows up to 3 search levels:

*   metasearch
*   Search on a particular database
*   Search on a subset of records in a database (type of material, or other classification defined by a prefix of the FST)

# OPAC - Files structure

The files in the **opac\_conf** folder are for general use of the Opac system, some are mandatory for the basic operation of the system:

bases/opac\_conf/lang/

**Required files:**

*   bases.dat
*   lang.tab
*   footer.info
*   menu.info
*   side\_bar.info
*   sitio.info

## General search form (**metasearch**)

The advanced and free search files need to follow the pattern of the databases' free and advanced searches, i.e. if the prefix TW\_ is defined in a database for the free search, the same prefix should be used for the general search.

*   libre.tab
*   avanzada.tab

**The files that are in the process of evaluation in the development.**

*   camposbusqueda.tab
*   colecciones.tab
*   destacadas.tab
*   facetas.dat
*   formatos.dat
*   autoridades\_opac.pft
*   indice.ix
*   opac.pft
*   opac\_loanobjects.pft
*   select\_record.pft

## Setting up a database in Opac

The configuration files for a database enabled to be displayed in Opac must be present along with the database in a folder called Opac/lang: **/bases/dbName/opac/lang/**

*   dbName.def
*   dbName.ix
*   dbName.lang
*   dbName\_avanzada.tab
*   dbName\_avanzada_col.tab
*   dbName\_facetas.dat
*   dbName\_formatos.dat
*   dbName\_libre.tab

### Search by record types (dbName\_colecciones.tab)

*   dbName\_colecciones.tab

### Search advanced by record types (dbName\_colecciones.tab)

Files to search by collection type, where the \_\[letter\] suffix is related to the first column of the dbName\_collections.tab file

*   dbName\_avanzada\_\[letter\].tab


### Use the variable $sidebar to show or hide the sidebar:

$sidebar=N // hide the bar
$sidebar=Y // shows the sidebar
