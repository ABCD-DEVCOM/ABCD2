@echo
pause
mx2 seq=fr.txt= "proc='d*a1~{{'v1'}}~a2~'v2'~'" -all now create=to_fr

for %%i in (*.pft) do mx2 seq=%%i gizmo=to_fr lw=9000 pft=v1# now > c:\ABCD\www\htdocs\iah\scripts\fr\%%i

for %%i in (*.htm) do mx2 seq=%%i gizmo=to_fr lw=9000 pft=v1# now > c:\ABCD\www\htdocs\iah\scripts\fr\%%i

del to_fr.*

pause

