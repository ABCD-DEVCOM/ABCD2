# Modifications in the database files

### In file ```bases/www/epilogoact.pft```:
Remove the script that sets the current record number/number of records in the Data Entry heading
```
<script> ....
    top.mfn='v1001'
    top.maxmfn='v1002'
    top.menu.forma1.ir_a.value=...
</script>
```  
The complete script must be deleted from this file to ensure correct values.

### In file ```bases/www/prologoact.pft```:
Change:  
``` <script type="text/javascript" src="/iah/js/highlight.js"></script>```  
into  
``` <script type="text/javascript" src="/central/dataentry/js/highlight.js"></script>```

### Modifications in <database>/dr_path.def
Existing `dr_path.def` files must edited. With a text editor or by menu item `Advanced database settings (dr_path.def)`
- The allowed values for `unicode` are 0 or 1

### New configuration file <database>/def/listoflabels.tab
This table lists the available label names.
Existing installations with enabled label/barcode functionality have to create this file.  
`Update database Definitions` -> `Table with label & barcode names`