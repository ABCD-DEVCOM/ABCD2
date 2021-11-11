2 0 "ID_"v02/
2 0 "ID="v02/
3 0 ,mpu,(|LO_|v03^*/)
4 0 ,mpu,(|DB_|v4|%|/)
5 0 v05,v06/
5 0 ,mpu,(|TL_|v05/)
6 0 ,mpu,(|NB_|v06/)
8 0 ,mpu,(|EA_|v08^q/)
8 0 ,mpu,(|AR_|v08^y/)
8 0 ,mpu,(|IE_|v08^i/)
8 0 ,mpu,(|FT_|v08^g/)
8 0 if p(v08) then, if s(mpu,v08^*,mpu):'INTERNET' or p(v08^u) then 'IN_INTERNET' fi,fi,
9 0 ,mpu,(|TR_|v9/)
10 0 ,mpu,|AU_|v10^*|%|/,|AU_|v16^*|%|/,|AU_|v23^*|%|/
10 8 ,mpu,'|AU_|'(v10^*|%|/),
10 8 ,mpu,'|AU_|'(v16^*|%|/),
10 8 ,mpu,'|AU_|'(v23^*|%|/),
10 8 ,mpu,'|AF_|'(v10^a|%|/),
10 8 ,mpu,'|AF_|'(v16^a|%|/),
10 8 ,mpu,'|AF_|'(v23^a|%|/),
10 8 ,mpu,'|AF_|'(v10^1|%|/),
10 8 ,mpu,'|AF_|'(v16^1|%|/),
10 8 ,mpu,'|AF_|'(v23^1|%|/),
10 8 ,mpu,'|AF_|'(v10^c|%|/),
10 8 ,mpu,'|AF_|'(v16^c|%|/),
10 8 ,mpu,'|AF_|'(v23^c|%|/),
10 8 ,mpu,'|AF_|'(v10^p|%|/),
10 8 ,mpu,'|AF_|'(v16^p|%|/),
10 8 ,mpu,'|AF_|'(v23^p|%|/),
10 8 ,mpu,'|AF_|'(v10^r|%|/),
10 8 ,mpu,'|AF_|'(v16^r|%|/),
10 8 ,mpu,'|AF_|'(v23^r|%|/),
11 0 ,mpu,|AI_|v11|%|/,|AI_|v17|%|/,|AI_|v24|%|/
11 8 ,mpu,'|AI_|'(v11^*|%|/),
11 8 ,mpu,'|AI_|'(v17^*|%|/),
11 8 ,mpu,'|AI_|'(v24^*|%|/),
12 8 ,mpu,'|TI_|'(v12|%|/),
12 8 ,mpu,'|TI_|'(v13|%|/),
12 8 ,mpu,'|TI_|'(v18|%|/),
12 8 ,mpu,'|TI_|'(v19|%|/),
12 8 ,mpu,'|TI_|'(v25|%|/),
15 8 ,mpu,'|TW_|'(v12|%|/),
15 8 ,mpu,'|TW_|'(v13|%|/),
15 8 ,mpu,'|TW_|'(v18|%|/),
15 8 ,mpu,'|TW_|'(v19|%|/),
15 8 ,mpu,'|TW_|'(v25|%|/),
15 8 ,mpu,'|TW_|'(v87^d|%|/),
15 8 ,mpu,'|TW_|'(v88^d|%|/),
15 8 ,mpu,'|TW_|'(v87^s|%|/),
15 8 ,mpu,'|TW_|'(v88^s|%|/),
30 0 ,if v5.1='S' and v6='as' and not s(v113):'u' then mpu,(|TA_|v30"/"v65.4,","v31,"("v32")"/) ,fi,
30 0 ,if v5.1='S' and v6='as' and v113='u' then mpu,('TA_'v30^*,"/"v65.4,","v31,"("v32") (Separata)"/) ,fi,
30 0 ,if v5.2='MS' then mpu,(|MS_|v30"/"v65.4,","v31,"("v32")"/) ,fi,
38 0 if s(mpu,v38^a,mpu):'CD' then 'SP_CD-ROM' fi,
38 0 if s(mpu,v08^*,mpu):'CD' then 'SP_CD-ROM' fi,
38 0 if s(mpu,v38^a,mpu):'DISQUE' or  s(mpu,v08^*,mpu):'DISK' then 'SP_DISQUETTE' fi,
38 0 if s(mpu,v08^*,mpu):'DISQUE' or  s(mpu,v08^*,mpu):'DISK' then 'SP_DISQUETTE' fi,
40 0 ,mpu,(|LA_|v40^*|%|/),
40 0 ,mpu,(|LA_|v12^i|%|/),
40 0 ,mpu,(|LA_|v18^i|%|/),
40 0 ,mpu,(|LA_|v25^i|%|/),
49 0 ,mpu,|OR_|v49^*|%|/,
49 8 ,mpu,'|OR_|'(v49^*|%|/),
52 0 if s(mpu,v5,mpu):'C' and p(v52) then ,mpu,(|CO_|v52/),(|CO_|v53/) ,(|CO_|v54/)  fi,
67 0 ,mpu,("PD_"v67/,if p(v67) and p(v65) then "PD_"v67,|/|v65*0.4/ fi,"PD_"v65*0.4/)
67 0 ,mpu,(if a(v65) then, if a(v67) then 'PD_/sin fecha y sin país'/ fi, "PD_"v67"/sin fecha"/, fi)
67 0 ,mpu,(if a(v65) then, if p(v67) then 'PD_/sin fecha y con país'/ fi, fi)
76 0 if p(v76) then (|CT_|v76|%|/) fi
71 0 if p(v71) then (|TB_|v71|%|/) fi
700 0 if p(v700) then (|EC_|v700|%|/) fi
84 0 'ME_'v1' 'v84*2.2,v84*5.2
84 0 'ME_'v1' 'v84*2.2
84 0 'ME_'v84
85 0 if p(v85) then (|PC_|v85^*|%|/) fi
92 0 ,mpu,(|DO_|v92/)
78 0 (|MH_|v78|%|/)
78 8 ,mpu,'|MH_|'(v78|%|/)
87 0 (|MH_|v87^*|%|/)
87 8 ,mpu,'|MH_|'(v87^*|%|/)
88 0 (|MH_|v88^*|%|/)
88 8 ,mpu,'|MH_|'(v88^*|%|/)
653 0 if p(v653) then (|ML_|v653^*|%|/) fi
