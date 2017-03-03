#!/bin/sh

./mx seq=fr.txt= "proc='d*a1~{{'v1'}}~a2~'v2'~'" -all now create=to_fr

for i in *.pft
do
 ./mx seq=$i£ gizmo=to_fr lw=9000 pft=v1# now > ../fr/$i
done

for i in *.htm
do
 ./mx seq=$i£ gizmo=to_fr lw=9000 pft=v1# now > ../fr/$i
done

rm to_fr.*
