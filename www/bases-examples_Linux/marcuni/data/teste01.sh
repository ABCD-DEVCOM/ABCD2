#!/bin/bash

# Vamos fazer manobras simples com todas as versoes de CISIS:
#	id2i CDS.id create=CDS
#	mx CDS now -all
#	mx CDS iso=CDS.iso now -all
#	mx iso=CDS.iso create=CDS now -all
#	mx CDS "fst=@" fullinv=CDS
#	mx dict=CDS now -all
#	mx CDS "water * plants" now
#	mx CDS "text=water" now
#	wxis IsisScript=teste01.xis db=CDS

# Codigo .xis utilizado
#
#<IsisScript name="teste01">
#<section name="main">
#
# <field action="cgi" tag="5000">db</field>
#
# <display>Percorrendo 10 registros...
#</display>
# <do task="mfnrange">
#	<parm name="db"><pft>v5000</pft></parm>
#	<parm name="from">1</parm>
#	<parm name="to">10</parm>
#	<loop>
#		<!-- display><pft>mfn(3),' '</pft></display -->
#	</loop>
# </do>
# <display>Percorrendo o IF...
#</display>
# <do task="keyrange">
#	<field action="define" tag="1000">Isis_Key</field>
#	<field action="define" tag="1001">Isis_Current</field>
#	<field action="define" tag="1002">Isis_Total</field>
#	<field action="define" tag="1031">Isis_From</field>
#	<field action="define" tag="1091">Isis_Status</field>
#	<field action="define" tag="1092">Isis_ErrorInfo</field>
#	<parm name="db"><pft>v5000</pft></parm>
#	<parm name="from">A</parm>
#	<parm name="to">ZZZZ</parm>
#	<loop>
#		<display><pft>v1000/</pft></display>
#	</loop>
# </do>
#
# <display>Efetuando uma busca...
#</display>
# <do task="search">
#	<field action="define" tag="1001">Isis_Current</field>
#	<field action="define" tag="1002">Isis_Total</field>
#	<field action="define" tag="1031">Isis_From</field>
#	<field action="define" tag="1091">Isis_Status</field>
#	<field action="define" tag="1092">Isis_ErrorInfo</field>
#	<parm name="db"><pft>v5000</pft></parm>
#	<parm name="expression">water * plants</parm>
#	<loop>
#		<display><pft>mfn(3)/</pft></display>
#	</loop>
# </do>
#
#</section>
#</IsisScript>
#

# Ajusta versão em teste
#for i in BigIsis ffi ffi1660 ffi512 ffi512G4 ffiG4 ffiG4_4 isis isis1660 isisG lind lind512 lind512G4 lindG4
#for i in isis isis1660 lind ffi lindG4 ffiG4

if [ -z "$1" ]; then
	PARM1="isis"
else
	PARM1=$1
fi

for i in $PARM1
do
	export CISIS_DIR=../utl/linux64/$i
	echo "-------------------------------------------------------"
	echo "Iniciando teste com $CISIS_DIR"
	echo 
	$CISIS_DIR/mx what
	$CISIS_DIR/id2i CDS.id create=CDS
	if [ $? != 0 ]; then echo "Erro $i. Carregando .ID"; exit 1; fi
	$CISIS_DIR/mx CDS now -all
	if [ $? != 0 ]; then echo "Erro $i. Lendo MF"; exit 1; fi
	$CISIS_DIR/mx CDS iso=CDS.iso now -all
	if [ $? != 0 ]; then echo "Erro $i. Gerando ISO"; exit 1; fi
	$CISIS_DIR/mx iso=CDS.iso create=CDS now -all
	if [ $? != 0 ]; then echo "Erro $i. Carregando ISO"; exit 1; fi
	$CISIS_DIR/mx CDS "fst=@" fullinv=CDS
	if [ $? != 0 ]; then echo "Erro $i. Gerando IF"; exit 1; fi
	$CISIS_DIR/mx dict=CDS now -all
	if [ $? != 0 ]; then echo "Erro $i. Lendo IF"; exit 1; fi
	$CISIS_DIR/mx CDS "water * plants" now
	if [ $? != 0 ]; then echo "Erro $i. Busca booleana"; exit 1; fi
	$CISIS_DIR/mx CDS "text=water" now
	if [ $? != 0 ]; then echo "Erro $i. Busca livre"; exit 1; fi
	$CISIS_DIR/wxis IsisScript=teste01.xis db=CDS
	if [ $? != 0 ]; then echo "Erro $i. Uso do WWWISIS"; exit 1; fi
	echo
done
unset CISIS_DIR
