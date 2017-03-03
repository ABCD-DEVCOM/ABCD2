#!/bin/sh

./mx seq=en.txt= "proc='d*a1~{{'v1'}}~a2~'v2'~'" -all now create=to_en

for i in *.pft
do
 ./mx seq=$i£ gizmo=to_en lw=9000 pft=v1# now > ../en/$i
done

for i in *.htm
do
 ./mx seq=$i£ gizmo=to_en lw=9000 pft=v1# now > ../en/$i
done

rm to_en.*

