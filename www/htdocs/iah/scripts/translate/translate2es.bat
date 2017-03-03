pause
@echo
mx2 seq=es.txt= "proc='d*a1~{{'v1'}}~a2~'v2'~'" -all now create=to_es

for %%i in (*.pft) do mx2 seq=%%i gizmo=to_es lw=9000 pft=v1# now > c:\ABCD\www\htdocs\iah\scripts\es\%%i

for %%i in (*.htm) do mx2 seq=%%i gizmo=to_es lw=9000 pft=v1# now > c:\ABCD\www\htdocs\iah\scripts\es\%%i

del to_es.*

pause
