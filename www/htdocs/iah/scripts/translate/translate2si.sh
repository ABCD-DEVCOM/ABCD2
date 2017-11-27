#!/bin/sh

./mx seq=si.txt= "proc='d*a1~{{'v1'}}~a2~'v2'~'" -all now create=to_si

for i in *.pft
do
 ./mx seq=$i£ gizmo=to_si lw=9000 pft=v1# now > ../si/$i
done

for i in *.htm
do
 ./mx seq=$i£ gizmo=to_si lw=9000 pft=v1# now > ../si/$i
done

# rm to_si.*
