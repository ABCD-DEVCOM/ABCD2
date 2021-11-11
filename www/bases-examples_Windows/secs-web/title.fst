3 0 mhu,(|LO=|v3/)
20 0 mpl,(|CN=|v020/)
30 0 mpl,(|I=|v030/)
37 0 mpl,(|S=|v037/),(|JC=|v037/)
40 0 mpl,(|SR=|v040^*/)
40 0 mpl,(if p(v040^c) then v040^*,|=|v040^c/ fi)
50 0 mpl,(|SP=|v050/)
100 0 mpl,(|TW_|v100/)
100 8 mpl,'|TW_|'(v100|%|/),
100 0 mpl,(|TI=|v100/)
100 8 mpl,'|TI=|'(v100|%|/),
110 0 mpl,(|TI=|v110/)
100 8 mpl,'|TI=|'(v110|%|/),
120 0 mpl,(|TI=|v120/)
120 8 mpl,'|TI=|'(v120|%|/),
130 0 mpl,(|TI=|v130/)
130 8 mpl,'|TI=|'(v130|%|/),
140 0 mpl,(|TI=|v140/)
140 8 mpl,'|TI=|'(v140|%|/),
100 0 mpl,(|TI_|v100/)
100 8 mpl,'|TI_|'(v100|%|/),
110 0 mpl,(|TI_|v110/)
100 8 mpl,'|TI_|'(v110|%|/),
120 0 mpl,(|TI_|v120/)
120 8 mpl,'|TI_|'(v120|%|/),
130 0 mpl,(|TI_|v130/)
130 8 mpl,'|TI_|'(v130|%|/),
140 0 mpl,(|TI_|v140/)
140 8 mpl,'|TI_|'(v140|%|/),
150 8 mpl,'|TA_|'(v150|%|/),
100 0 mpl,(v100/)
100 4 mpl,(v100/)
110 0 mpl,(v110/)
110 4 mpl,(v110/)
120 0 mpl,(v120/)
120 4 mpl,(v120/)
130 0 mpl,(v130/)
130 4 mpl,(v130/)
140 0 mpl,(v140/)
140 4 mpl,(v140/)
151 0 mpl,if s(("~"v450|~|)):'~LL~' and a(v810) and not s(mpu,v800):'E' then |TL=|v150/,|TC=|v150*27/ fi
240 0 mpl,(v240/)
240 4 mpl,(v240/)
330 0 mpl,(|NP=|v330/)
350 0 mpl,'|LA_|'(v350|%|/),
380 0 mpl,(|FA=|v380/)
400 0 mpl,(v400/)
400 0 mpl,(|IS_|v400/)
400 0 mpl,(|IS_|v510^x/)
400 0 mpl,(|IS_|v520^x/)
400 0 mpl,(|IS_|v530^x/)
400 0 mpl,(|IS_|v540^x/)
400 0 mpl,(|IS_|v550^x/)
400 0 mpl,(|IS_|v560^x/)
400 0 mpl,(|IS_|v610^x/)
400 0 mpl,(|IS_|v620^x/)
400 0 mpl,(|IS_|v650^x/)
400 0 mpl,(|IS_|v660^x/)
400 0 mpl,(|IS_|v670^x/)
400 0 mpl,(|IS_|v680^x/)
400 0 mpl,(|IS_|v710^x/)
400 0 mpl,(|IS_|v720^x/)
400 0 mpl,(|IS_|v750^x/)
400 0 mpl,(|IS_|v760^x/)
400 0 mpl,(|IS_|v770^x/)
400 0 mpl,(|IS_|v780^x/)
400 0 mpl,(|IS_|v790^x/)
400 0 mpl,(|IS_|v980^x/)
420 0 mpl,(v420/)
420 4 mpl,(v420/)
435 0 mpl,(if p(v435) then |AT=|v435/ fi)
436 0 mpl,(if p(v436) then |BVS=|v436^a'-'v436^b/ fi)
440 0 mpl,('DESC='v440/)
440 8 mpl,'|MH_|'(v440|%|/),
441 8 mpl,'|MH_|'(v441|%|/),
840 8 mpl,'|MH_|'(v840|%|/),
440 4 mpl,(v440/)
460 0 mpl,(|FO=|v460/)
470 0 mpl,(|PA=|v470/)
480 0 mpl,(|EDT=|v480/)
310 0 mpl,(|P=|v310/)
445 0 mpl,(if p(v445) then |USER=|v445/ fi)
450 0 mpl,(|AI=|v450/)
800 0 mpl,(|OB=|v800/)
810 0 mpl,(|DLL=|v810/)
820 0 mpl,(|ED=|v930/)
820 0 mpl,if p(v930) then 'ED=P' else 'ED=A' fi
830 0 mpl,(|EN=|v940/)
840 0 mpl,(|CI=|v920/)
850 0 mpl,(|CD=|v490/)
860 0 mpl,(|CC=|V010/)
870 0 mpl,if p(v304) then 'DF=P' else 'DF=A' fi
900 0 mpl,if v900: 'EBSCO' then 'FN=EBSCO' fi
900 0 mpl,if v900: 'DAWSON' then 'FN=DAWSON' fi
900 0 mpl,if v900: 'BLACKWELL' then 'FN=BLACKWELL' fi
900 0 mpl,if v900: 'SWETS' then 'FN=SWETS' fi
900 0 mpl,if v900: 'MARTINUS' then 'FN=MARTINUS' fi
910 0 mpl,if p(v920) then 'CCI=P' else 'CCI=A' fi
920 0 mpl,(|ID=|v30/)
930 0 mpl,if v910: '00EBSCO' then 'AQ=00EBSCO' fi
930 0 mpl,if v910: '00SWETS' then 'AQ=00SWETS' fi
910 0 mpl,(|FORN=|v910^a'-'v910^b/)
920 0 mpl,if p(v450) then 'CO=P' else 'CO=A' fi
950 0 mpl,'TIT='v100.1/
960 0 mpl,if p(v350) then 'LG=P' else 'LG=A' fi
970 0 mpl,if p(v460) then 'OB=P' else 'OB=A' fi
980 0 mpl, (|DM=|V941/),
301 0 mpl, (|DI=|V301/),
990 0 mpl,if p(v450) then 'AI=P' else 'AI=A' fi
100 0 mpl,(|TC=|v100/)