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

## Configuring a database in Opac

The configuration files for a database enabled to be displayed in Opac must be present along with the database in a folder called Opac/lang: **/bases/dbName/opac/lang/**

*   dbName.def
*   dbName.ix
*   dbName.lang
*   dbName\_avanzada.tab
*   dbName\_facetas.dat
*   dbName\_formatos.dat
*   dbName\_libre.tab

### Search by record types (dbName\_colecciones.tab)

*   dbName\_colecciones.tab

### Search advanced by record types (dbName\_colecciones.tab)

Files to search by collection type, where the \_\[letter\] suffix is related to the first column of the dbName\_collections.tab file

*   dbName\_avanzada\_\[letter\].tab