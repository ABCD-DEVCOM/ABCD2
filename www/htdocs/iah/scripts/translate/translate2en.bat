@echo off
pause

mx2 seq=en.txt= "proc='d*a1~{{'v1'}}~a2~'v2'~'" -all now create=to_en

for %%i in (*.pft) do mx2 seq=%%i gizmo=to_en lw=9000 pft=v1# now > c:\ABCD\www\htdocs\iah\scripts\en\%%i

for %%i in (*.htm) do mx2 seq=%%i gizmo=to_en lw=9000 pft=v1# now > c:\ABCD\www\htdocs\iah\scripts\en\%%i

del to_en.*

