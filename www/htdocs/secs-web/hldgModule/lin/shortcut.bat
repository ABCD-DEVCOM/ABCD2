THIS_CISIS=/home/scielo/www/proc/cisis
FACIC=/home/roberta/secs/data/facic
THIS_PATH=/home/roberta/secs/appl/hldgModule
THIS_TMP_PATH=/home/roberta/secs/temp
KEY=$1
HLDG=/home/roberta/secs/data/hldg
TITLE=/home/roberta/secs/data/title
DEBUG=$2yes


if [ ! -f $FACIC.xrf ] 
then
	$THIS_PATH/lin/iso2mst.bat $FACIC $THIS_CISIS $THIS_PATH/facic.fst
fi

if [ ! -f $TITLE.xrf ] 
then
	$THIS_PATH/lin/iso2mst.bat $TITLE $THIS_CISIS $THIS_PATH/hldg.fst
fi

$THIS_PATH/lin/generateForJournal.bat $KEY $FACIC $HLDG $TITLE 970 $THIS_CISIS $THIS_PATH $THIS_TMP_PATH $DEBUG

# echo vi $LOG_FILE

