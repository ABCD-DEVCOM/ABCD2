This file contains the new and modified features of ABCD.
This text is intended for the end-user and database managers.

Each main chapter contains the information of a release with respect to an older version


<ul>
<li><a href="#Version-220">Latest information</a></li>
<li><a href="#Version-220-beta">Version 2.2 beta</a></li>
<li><a href="##Version-2.1b-/2.0f">Version 2.1b /2.0f</a></li>
</ul>

<hr>

# Version 2.2.0
This is an official release.
This chapter contains the **major** differences with [Version 2.2 beta](#Version-220-beta)

### New look
The user interface of the central module is modernized.
New buttons and new colors will make ABCD look better.
Many forms are also redesigned to make them more clear or look better.

The logo of ABCD is changed.
These logos are accompanied by changes in the .css files.
The logo and style sheet files are cached by most browsers and this can result in distorted views for all users.  
Remedy: &rarr; In the web browser: Goto the website of your ABCD installation, press Ctrl F5 and restart the browser.

Browse functionality for the standard databases is changed: the paging and layout of the browse functionality is improved.  
Affected databases: ``acces, copies, providers, purchaseorder, reserve, servers, suggestions, suspml, trans, users``  
For proper operation of this browser following files are required. (Available in the example databases):
- `<database>/pfts/<LANG>/sort.tab`
- `<database>/pfts/<LANG>/tbacces_html.pft`

### Unicode support
ABCD databases can accomodate data in **ISO-8859-1** or **UTF-8**.
Support for UTF-8 is significantly improved in this version.
The terms **ANSI**, **Windows-1252**, **Extended ASCII** are no longer used as ABCD supported in fact **ISO-8859-1**.

Details:
- The correct current characterset is always shown in the upper right corner of the window
- ISO data files can be previewed in ISO-8859-1 or UTF-8.
When the characterset of the file and the current database do not match, the user will see garbled text or question marks in black diamonds. 
- Options to `Convert ABCD to Unicode` and `Convert ABCD to ANSI` are removed as they raised false expectations.
See the Utilities menu for the new set.
- The valid values  for variable UNICODE in `abcd.def`and `dr_path.def` are now 0 or 1.
This is correctly set by the interactive modifications of these files.
Older versions may still have other values that are now invalid.
Note that older version may show other values as given in the distributed `bases/abcd.def`.  
Remedy: &rarr; Edit and correct interactively `abcd.def` and `dr_path.def` for all databases

A browser page is in normal situations valid for 1 character encoding.
ABCD has now 3 supported combinations:
- ISO-8859-1 database with ISO-8859-1 language files. (historical situation)
- UTF-8 database with UTF-8 language files
- UTF-8 database with ISO-8859-1 language files (ABCD will convert the ISO-8859-1 files on the fly to UTF-8)

Note:
- ISO-8859-1 database with UTF-8 language files will not display correctly
- The current examples and existing installations use ISO-8859-1 for the standard databases (e.g. ``access, copies,...``) and ISO-8859-1 language files.
The dynamic translation of these language files ensures correct display if UTF-8 databases are selected.

### Utilities menu
The menu is reordered. New options in the Utilities menu:
- `DB maintenance -> Create gizmo database` : Create a gizmo database from am ISO file in the current data folder with the current database architecture.
This option is particularly usefull for databases with HTML fields.
- `Export/Import -> Match ISO file with FDT`: This options reads an existing ISO file from an other look-alike database and writes a new ISO file.
This file contains only fields found in the current database FDT.
- `Convert ISO <-> UTF-8 -> Convert database text files to UTF-8`: Converts a user selected set of files from ISO to UTF-8.
Intended for FDT,FST and other database configuration files.
This is the replacement of `Convert ABCD to Unicode`
- `Convert ISO <-> UTF-8 -> Convert ISO file to UTF-8`: Convert the content of a selected ISO file from ISO-8859-1 to UTF-8
- `Convert ISO <-> UTF-8 -> Convert Language files to UTF-8`: Convert the language files fo the current language to UTF-8

### The digital document code is redesigned
The base functionality is still present but the code is more robust and the user has better control.
The functionality was present in  
`Utilities -> Import/Export -> Import Documents -> submenu`  
and is now present in  
`Utilities -> Digital Documents -> changed submenu`

- The content of the imported files is no longer permanently stored in the database but loaded dynamically for the Inverted file generation.
- The code to make the filenames unique is now default ON and uses a timestamp (was a random number)
- It is now possible (and required) to save the mapping of document metadata to ABCD metadata.
This mapping is preserved in `<dbname>/docfiles_metadataconfig.tab`
  - Alternative mapping schemes do not need a lot of typing for each upload
  - Option `Tagslevel` is no longer needed
- Files larger as the available record size are split into smaller files.
The split algoritm is controlled by the next two options.
- When the full available recordsize is used it happened to be impossible to generate the inverted files.
Form `Set Import Options` has two fields to mitigate this problem.
  - `Working record size`: The maximum used record size, default set to 85 % of the physical size.
  The split algorithm will never exceed this size.
  Modification may result in indexing problems.
  - `Granularity`: The target file size to be used for import.
  The split algorithm will split the data on a "good" point (e.g. not in the middle of a word) near the target file size 
- Third party package `tika` is no longer bundled with ABCD. The code will show informative messages if the package is needed but not installed

### Generate Inverted files / Indexing
The functionality and interface of this utility is modified
- An option for Incremental Indexing is shown if applicable.
- HTML fields are detected for all databases. If such fields are detected an option is shown to strip the HTML tags before actual indexing.
If the option is selected the system requires a gizmo to delete the HTML tags from the field.
- Inverted file generation depends on the `actab` and `uctab` tables. The syntax of these files is different for ISO-8859-1 and UTF-8.
Using the wrong syntax will result in fatal error messages on several places..    
The script searches for the files in the following order:
  - If file `dr_path.def` is present it will use the file specified in this file by keys
    - `actab=` or `isisac.tab=`
    - `uctab=` or `isisuc.tab=`
  - If such a file is not found the script searches in `<bases>/<database>/data` for files with name
    - `isisac.tab` for ISO-8859-1 databases and `isisactab_utf8.tab` for UTF-8 databases
    - `isisuc.tab` for ISO-8859-1 databases and `isisuctab_utf8.tab` for UTF-8 databases
  - If such a file is not found the script searches in `<bases>`.

Filenames for `actab` and `uctab` specified in `dr_path.def` are free and it is recommended that they reflect the intention of the file.  
E.g. `isisac.tab=%path_database%mydatabase/data/mydb_utf8_isisac.tab`

### Create a new database from an existing database
This script is enhanced with following features
- The selected characterset is used for the new databases and may be different from the original.
- The selected database architecture  is used for the new databases and may be different from the original.
- The folder structure is completely copied (includes a possible empty "collection")
- All relevant files from the original database are copied and the filename is adapted for the new database name.
- The content of several files is also adapted for the new database name.
- In case the charactersets are equal the original `actab` and `uctab` are used. If the charactersets are different the default `actab` and `uctab` for the characterset are used.

### Translation of message files
When the system displays a message it takes a key and this key is translated into the correct message.
If a key was not found the system showed a "missing index" error.  
The current code uses now a fallback table distributed with the code. And this reduces the "missing index" errors to 0.
Other features:
- The scripts to edit the language tables show the unique key and also "ghost keys": keys present in the language file and not in the fall back table.
- Saving an edited table removes the "ghost" entries.
- The script to edit the language table has an option to show the text in ISO-8859-1 or UTF-8.  
Note that ISO-8859-1 language files will be translated on the fly to UTF-8 in case UTF-8 databases are used.
- The fallback table is modified by adding and deleting entries for the current release.
- The "example" database folder contains updated files for several languages
- All tables are sorted alfabetically.
  - This action allows for comparison between the tables of different languages.
  - This action shows that some tables might have duplicate entries.

### Barcode
The barcode configuration is redesigned.
- The configuration options are available in `Update database definitions -> line: Label & Barcode`
- The barcode label names `barcode,lomos/etiquetas` are no longer fixed in code. They are now defined in file `<dbname>/<lang>/listoflabels.tab`.
Modification by option `Table with label & barcode names`. 
There is a button to insert the legacy labels originally fixed in code to support upgrading of old installations.
- Option `Configure label/barcode` shows for each defined barcode/label name two options:
  - `Configure label/barcode` for the configuration of the label.
  - `Barcode font` to check the configuration, show examples of the generated barcode and download more barcode fonts.

- The barcode icon in the `Date entry` menu gives in configured situations only access to the `Show/print' functionality`.
Incorrect configuration inhibits the `Show/print` functionality and shows links to the configuration options.
- The barcode icon in the `Date entry` menu gives no longer access to the `Stock taking` functionality 

### Minor modifications
- Improved screen for searching using the dictionary
- Login errors caused by wrong `unicode` settings show an alert. This is mitigated by `acces/drpath.def` with the correct settings for the installation
- The `prologact.pft`'s referenced `iah/js/highlight.js`. This is corrected to `central/dataentry/js/highlight.js`
- New folder `<bases>/log` is intended for webserver log files. This location must be configured in the webserver.
- The majority of scripts shows a unified information section at the top of the page with 'help' information and the correct script name.
- The `Back` functionality no longer performs a browser back function but returns now to the correct script with correct parameters.

### Architectural changes
The code has dozens of changes to make it more robust, error resistant, improve feedback and corrections to generate valid HTML.

Major milestones:
- The code is compliant with PHP 7.4.
- **`https`** is accepted by the code. This protocol is recommended for security.
- Isis database architectures `16-60` and `bigisis` are supported for Linux and Windows for charactersets `ISO-8859-1` and `UTF-8`.
This was already the case for Linux.  
For Windows the `bigisis` support is improved and support for `FFI` is terminated.
- A significant number of obsolete PHP scripts is deleted.

### Removed functionality
- Support for `Secs` (Serials Control System) had to be terminated due termination of maintenance for essential plug-ins.
- `EmpWeb` has no development anymore and is considered 'stable' enough to be put in another repo separately.
The directory has been moved to the https://github.com/ABCD-Community/EmpWeb repository.
- `Statistics` pie-chart code relied on Adobe Flash. This product is no longer supported and the code in ABCD is removed

<hr>

# Version 2.2.0 beta

### Unicode support
This version has some support for Unicode. This is an enhancement to the previous version

### Utilities menu
The character links in menu `Utilities` with submenu `EXTRA UTILITIES` are replaced by a button based list with dropdown sublists.

### Field validation
Configuration column `Field validation` for FDT and Worksheet shows a dropdown with options.
Notice the check option for `Unique Key` 

Database `copies` requires this setting for worksheet `new.fmt` ("New copies") requires this setting for tag 30: `Inventory Number`
This is corrected in the example databases

### Architectural changes
Milestones
- A new module called `OPAC`is introduced. This module is intended to replace the `iAH` module
- The ABCD downloads do no longer include software prerequisites. Installation of the webserver, PHP,... is no longer documented in ABCD.

<hr>

# Version 2.1b /2.0f
Information for this and previous versions is not included in this file.
This implies that some "new" options in later releases might be present in this or previous releases.
