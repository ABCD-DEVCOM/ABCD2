#!/bin/sh

./mx seq=nl.txt= "proc='d*a1~{{'v1'}}~a2~'v2'~'" -all now create=to_nl

for i in *.pft
do
 ./mx seq=$i£ gizmo=to_nl lw=9000 pft=v1# now > ../nl/$i
done

for i in *.htm
do
 ./mx seq=$i£ gizmo=to_nl lw=9000 pft=v1# now > ../nl/$i
done

rm to_nl.*

