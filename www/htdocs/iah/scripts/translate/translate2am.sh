#!/bin/sh

./mx seq=am.txt= "proc='d*a1~{{'v1'}}~a2~'v2'~'" -all now create=to_am

for i in *.pft
do
 ./mx seq=$i£ gizmo=to_am lw=9000 pft=v1# now > ../am/$i
done

for i in *.htm
do
 ./mx seq=$i£ gizmo=to_am lw=9000 pft=v1# now > ../am/$i
done

# rm to_en.*

