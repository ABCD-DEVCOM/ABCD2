#!/bin/sh

./mx seq=es.txt= "proc='d*a1~{{'v1'}}~a2~'v2'~'" -all now create=to_es

for i in *.pft
do
 ./mx seq=$i£ gizmo=to_es lw=9000 pft=v1# now > ../es/$i
done

for i in *.htm
do
 ./mx seq=$i£ gizmo=to_es lw=9000 pft=v1# now > ../es/$i
done

rm to_es.*

