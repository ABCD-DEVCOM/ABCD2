THIS_CISIS=$1
SRC=$2
KEY=$3
TAG_RESUMIDO=$4
HLDG=$5
LOG_FILE=$6
THIS_PATH=$7
THIS_PROC_TMP_PATH=$8


echo Executing of $0 $1 $2 $3 $4 $5 $6 $7 $8 $9>> $LOG_FILE

$THIS_PATH/lin/registerTime.bat $KEY $0_inicio

if [ ! -f $HLDG.fst ]
then
$THIS_PATH/lin/registerTime.bat $KEY $0_5

	echo Create the $HLDG.fst >> $LOG_FILE
	cp $THIS_PATH/hldg.fst $HLDG.fst
fi

if [ -f $HLDG.xrf ]
then
$THIS_PATH/lin/registerTime.bat $KEY $0_1
	$THIS_CISIS/mx $HLDG btell=0 "TIT=$KEY" "pft=if v30='$KEY' then 'copy'/ fi" now > $THIS_PROC_TMP_PATH/register_hldg.seq
	echo append >>$THIS_PROC_TMP_PATH/register_hldg.seq
	#more $THIS_PATH/line.txt >> $THIS_PROC_TMP_PATH/register_hldg.seq

$THIS_PATH/lin/registerTime.bat $KEY $0_2
	$THIS_CISIS/mx seq=$THIS_PROC_TMP_PATH/register_hldg.seq count=1 lw=99999 "pft='$THIS_PATH/lin/hldg_createRecord.bat $THIS_CISIS $SRC $KEY ',v1,' $TAG_RESUMIDO $HLDG $LOG_FILE $THIS_PATH'/" now > $THIS_PROC_TMP_PATH/register_hldg.bat

$THIS_PATH/lin/registerTime.bat $KEY $0_3

	chmod 775 $THIS_PROC_TMP_PATH/register_hldg.bat

	echo Executing $THIS_PROC_TMP_PATH/register_hldg.bat >> $LOG_FILE
	cat $THIS_PROC_TMP_PATH/register_hldg.bat >> $LOG_FILE 
	$THIS_PROC_TMP_PATH/register_hldg.bat
	
else
$THIS_PATH/lin/registerTime.bat $KEY $0_4
$THIS_PATH/lin/registerTime.bat $KEY $0_6

	echo Create the HLDG if there is none >> $LOG_FILE
	$THIS_PATH/lin/hldg_createRecord.bat $THIS_CISIS $SRC $KEY append $TAG_RESUMIDO $HLDG $LOG_FILE $THIS_PATH

fi
$THIS_PATH/lin/registerTime.bat $KEY $0_fim
echo End of execution of $0 $1 $2 $3 $4 $5 $6 $7 $8 $9>> $LOG_FILE
