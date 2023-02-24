# Upgrade
This file intends to give directions for upgrading an (old) ABCD installation to the latest status.
As there are many known different older versions, each with their own local modifications, adaptions and extensions it is impossible to give detailed step by step instructions.
This file intends to give a <i>guideline</i> for the upgrade process to the last status.
### Preparation
1. Create a full backup of the code and/or webserver
2. Prepare your installation. See [Installation instructions](https://github.com/ABCD-DEVCOM/ABCD2/blob/master/zz_installation/installation_instructions.md) for details
   - Check Prerequisites (e.g. versions of PHP and other components)
   - Download ABCD 
   - Unpack downloaded archive
   - Preprocess the downloaded folders.
### Actual upgrade
1. Ask or force the client to log-off and close or shutdown the webserver
2. Copy folders **htdocs** and **cgi-bin** to the web server.  
It is recommended to delete these folders in the webserver first.
This ensures that files no longer present in the downloaded archives do not pollute your installation
3. Ensure that possible prerequisites are copied to the correct location in the web server (e.g. tika)
4. Perform the [Upgrade post processing](#upgrade-post-processing). Ensure that you have a correct `htdocs/central/config.php`
5. For Linux installations
   - Change ownership of the folders to the owner/group of the webserver (`chown -R ...`)
   - Change protection of the folders to correct values (`chmod -R ...`)
6. Restart the webserver/web server service

---
# Upgrade post processing

## Modifications in code

### File config.php

The main configuration file `htdocs/central/config.php` is no longer distributed (so it will no longer overwrite local modified files).  
The distribution contains now `htdocs/central/config.php.template` with a default content for the `htdocs/central/config.php` suitable for Windows and Linux

&rArr; Merge your existing `config.php` with the template file

## Modifications in the database files

### In file bases/www/epilogoact.pft
Remove the script that sets the current record number/number of records in the Data Entry heading
```
<script> ....
    top.mfn='v1001'
    top.maxmfn='v1002'
    top.menu.forma1.ir_a.value=...
</script>
```  
The complete script must be deleted from this file to ensure correct values.

Remove the following html code at the end of the script:
```
'</form>
</body>
</html>'
```

### In file bases/www/prologoact.pft
Change:  
```
<script type="text/javascript" src="/iah/js/highlight.js"></script>
```  
into  
```
<script type="text/javascript" src="/central/dataentry/js/highlight.js"></script>
```

### Modifications in <database>/dr_path.def
Existing `dr_path.def` files must edited. With a text editor or by menu item `Advanced database settings (dr_path.def)`
- The allowed values for `unicode` are 0 or 1

### New configuration file <database>/def/listoflabels.tab
This table lists the available label names.
Existing installations with enabled label/barcode functionality have to create this file.  
`Update database Definitions` &rArr; `Table with label & barcode names`
