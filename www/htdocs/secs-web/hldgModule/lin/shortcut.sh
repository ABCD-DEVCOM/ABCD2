#!/bin/bash
THIS_CISIS=/opt/ABCD/www/cgi-bin/ansi/
FACIC=/var/opt/ABCD/bases/secs-web/nss/facic
THIS_PATH=/opt/ABCD/www/htdocs/secs-web/hldgModule
THIS_TMP_PATH=/var/opt/ABCD/bases/secs-web/holdingsTemp
KEY=$1
HLDG=/var/opt/ABCD/bases/secs-web/nss/holdings
TITLE=/var/opt/ABCD/bases/secs-web/title
DEBUG=$2yes
if [ ! -f $FACIC.xrf ] 
then
	$THIS_PATH/lin/iso2mst.sh $FACIC $THIS_CISIS $THIS_PATH/facic.fst
fi
if [ ! -f $TITLE.xrf ] 
then
	$THIS_PATH/lin/iso2mst.sh $TITLE $THIS_CISIS $THIS_PATH/hldg.fst
fi
$THIS_PATH/lin/generateForJournal.sh $KEY $FACIC $HLDG $TITLE 970 $THIS_CISIS $THIS_PATH $THIS_TMP_PATH $DEBUG
# echo vi $LOG_FILE
#END