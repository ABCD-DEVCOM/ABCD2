245:if a(v245) then '<b><font size=3 color=red>Field 245 - Main Title - is missing</font></b>' fi$$|$$true
###
100:if a(v100) and a(v110) and a(v111) then '<b><font size=3 color=red>Lack Main Entry: field 100, 110, 111 or 130</font></b>' fi$$|$$false
###
8:if ss(1,6,v8)='yymmdd' then '<b><font size=3 color=red>The date in the fixed  field (008)=yymmdd, change to todays date as indicated</font></b>' fi$$|$$true
###
20:if a(v20) then 'ISBN missing' else if a(v3333) then proc('a3333~'f(mfn,1,0)'~') fi  if val(v3333)=0 then if l(['marc']|ISBN_|v20^a) <> 0 then  'ISBN already exists in MFN ',f(l(['marc']|ISBN_|v20^a),1,0), fi fi fi$$|$$true
###
:
###
