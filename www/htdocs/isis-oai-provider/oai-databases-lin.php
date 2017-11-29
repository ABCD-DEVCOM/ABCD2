;<?php /*

; EXAMPLE:
; This is a example of database configuration.

; Starts and describes a section for that database and identifies the logical name of that set. This information is presented in the verb ListSets and it is also part of the unique identifier for each document within the set.
;[lilacs]
; The name variable is the label to the data set to be displayed in the ListSets verb
;name=LILACS
; Description of set, that will be showed in ListSets verb.
;description="Latin American and Caribbean Health Sciences"
; Path and name of the database's files.
;database=/home/bireme/isis-oai-provider/bases/isis-oai-provider/LILACS
; Refers to the filename format used to do the mapping of contents. (Located in map/ directory)
;mapping=lilacs_dc.pft
; Prefix for the date field. This should be inserted in the FST file used by the invertion process.
;prefix=oai_date_
; Specifies the minimum and maximum key length used to invert data. Pay attention to the version according to the database source (e.g.. LILACS is 1660, IAH is 1030)
;isis_key_length=1660
; Specifies which CISIS_version (ansi/utf8 and/or 1660, bigisis, ffi...) of wxis needs to be used
;cisis_version=ansi/1660
; Field in database that contains identifier information of register.
;identifier_field=2
; Field in database that contains datestamp information of register.
;datestamp_field=93


[marc]
name=marc
description="MARC"
path=/var/opt/ABCD/bases/marc/data
database=/var/opt/ABCD/bases/marc/data/marc
mapping=marc.i2x
prefix=oai_date_
;isis_key_length=ansi
cisis_version=ansi/
identifier_field=1
datestamp_field=980

[dubcore]
name=dubcore
description="DublinCore repository"
path=/var/opt/ABCD/bases/dubcore/data
database=/var/opt/ABCD/bases/dubcore/data/dubcore
mapping=dubcore.i2x
prefix=oai_date_
;isis_key_length=utf8/bigisis
cisis_version=utf8/bigisis
identifier_field=111
datestamp_field=507

;*/ ?>
