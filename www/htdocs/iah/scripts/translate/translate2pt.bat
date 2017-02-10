@echo
pause
mx2 seq=pt.txt= "proc='d*a1~{{'v1'}}~a2~'v2'~'" -all now create=to_pt

for %%i in (*.pft) do mx2 seq=%%i gizmo=to_pt lw=9000 pft=v1# now > c:\ABCD\www\htdocs\iah\scripts\pt\%%i

for %%i in (*.htm) do mx2 seq=%%i gizmo=to_pt lw=9000 pft=v1# now > c:\ABCD\www\htdocs\iah\scripts\pt\%%i

del to_pt.*

pause
