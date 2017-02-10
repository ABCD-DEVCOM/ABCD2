#!/bin/sh

./mx seq=pt.txt= "proc='d*a1~{{'v1'}}~a2~'v2'~'" -all now create=to_pt

for i in *.pft
do
 ./mx seq=$i£ gizmo=to_pt lw=0 pft=v1# now > ../pt/$i
done

for i in *.htm
do
 ./mx seq=$i£ gizmo=to_pt lw=0 pft=v1# now > ../pt/$i
done

rm to_pt.*

