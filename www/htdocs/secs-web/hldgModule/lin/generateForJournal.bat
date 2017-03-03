KEY=$1
ALLFACIC=$2
HLDG=$3
TITLE=$4
TAG_RESUMIDO=$5

THIS_CISIS=$6
THIS_PATH=$7

MY_TMP_PATH=$8/geraCompactado

DEBUG=$9

LOG_FILE=$8/geraCompactado_logs/$KEY.log


TAG_ID=30
TAG_TIME=90
PROC_ID=`date +%Y%m%d%H%M%S`
TIME_START=`date +%Y%m%d%H%M%S%N`
SEP=_
THIS_PROC_TMP_PATH=$MY_TMP_PATH/$KEY/$PROC_ID
PROC_FILE=$THIS_PROC_TMP_PATH/proc.prc
PROC_FILE_CHECK=$THIS_PROC_TMP_PATH/check.proc.prc
DO_TEMP_HLDG=$8/$KEY.temp.txt

if [ -d $THIS_PROC_TMP_PATH ]
then
	rm -rf $THIS_PROC_TMP_PATH
fi
mkdir -p $THIS_PROC_TMP_PATH 
mkdir -p $8/geraCompactado_logs

chmod -R 775 $THIS_PATH/lin/*.bat

$THIS_PATH/lin/registerTime.bat $KEY generateForJournal_inicio

echo $TIME_START > $LOG_FILE

######################################
# Create or update record of HLDG.
#
$THIS_PATH/lin/hldg_db.bat $THIS_CISIS $TITLE $KEY $TAG_RESUMIDO $HLDG $LOG_FILE $THIS_PATH $THIS_PROC_TMP_PATH


######################################
# Classify the records from FACIC according to regular or special issues (REG x SPEC).
##
echo Classify the records from FACIC >> $LOG_FILE

# cp $THIS_PATH/empty.txt $THIS_PROC_TMP_PATH/REG.txt
# cp $THIS_PATH/empty.txt $THIS_PROC_TMP_PATH/SPEC.txt


# $THIS_CISIS/mx $ALLFACIC btell=0 "$KEY=$" lw=99999 "proc='d920a920{',s('000000000000000000000000000000',v920),'{'"  "proc='d920a920{',mid(v920,size(v920)-30+1,30),'{'" "pft='echo \"',v920,'|',v911,'|',v912,'|',v913,'|',v914,'\">> $THIS_PROC_TMP_PATH/',if s(mpu,v913,mpl):'S' or s(mpu,v913,mpl):'P' or s(mpu,v913,mpl):'NE' or s(mpu,v913,mpl):'IN' or s(mpu,v913,mpl):'AN' then 'SPEC' else  'REG' fi,'.txt'/" now > $THIS_PROC_TMP_PATH/classify_facic.bat

# $THIS_PATH/lin/registerTime.bat $KEY generateForJournal_classifyRecords_execute
# chmod 775 $THIS_PROC_TMP_PATH/classify_facic.bat

# echo Executing $THIS_PROC_TMP_PATH/classify_facic.bat >> $LOG_FILE
# cat $THIS_PROC_TMP_PATH/classify_facic.bat >> $LOG_FILE
# $THIS_PROC_TMP_PATH/classify_facic.bat


if [ -f $DO_TEMP_HLDG ]
then	
	cat $DO_TEMP_HLDG  | sort > $THIS_PROC_TMP_PATH/ORD.txt

else
	$THIS_PATH/lin/registerTime.bat $KEY generateForJournal_classifyRecords_generate
	$THIS_CISIS/mx $ALLFACIC btell=0 "$KEY=$" lw=99999 "proc='d920a920{',s('000000000000000000000000000000',v920),'{'"  "proc='d920a920{',mid(v920,size(v920)-30+1,30),'{'" "pft=if instr(':PT:S:NE:BI:IN:AN:',s(':',mpl,v916,mpu,':'))>0 or size(v916)>0 then 'S' else  'R' fi,replace(s(v920,'|',v911,'|',v912,'|',v913,'|',v914,'|',if instr(':PT:S:NE:BI:IN:AN:',s(':',v916,':'))>0 then v916 else '' fi,'|',v910),'| |','||')/" now | sort > $THIS_PROC_TMP_PATH/ORD.txt
fi



######################################
# Generate the proc which will create the resumed form
##

cp $THIS_PATH/empty.txt $PROC_FILE_CHECK

cp $THIS_PATH/empty.txt $PROC_FILE

$THIS_PATH/lin/generateForFacic.bat $THIS_CISIS $THIS_PROC_TMP_PATH/ORD $THIS_PATH $PROC_FILE $LOG_FILE $TAG_RESUMIDO sep $PROC_FILE_CHECK $DEBUG

######################################
# Apply the proc
##
TIME_END=`date +%Y%m%d%H%M%S%N`
$THIS_PATH/lin/registerTime.bat $KEY generateForJournal_update_hldg
if [ -f $DO_TEMP_HLDG ]
then
	
	mv $PROC_FILE $DO_TEMP_HLDG.result
	rm $DO_TEMP_HLDG 
else
	$THIS_CISIS/mx $HLDG btell=0 "tit=$KEY" "proc='d*','a10{',v10,'{',"  "proc='a$TAG_ID{$KEY{a$TAG_TIME{^s$TIME_START^e$TIME_END{'" "proc='a$TAG_TIME{^d',f(val(s(v$TAG_TIME^e*11))-val(s(v$TAG_TIME^s*11)),1,0),'{'" "proc=@$PROC_FILE" "proc=@$PROC_FILE_CHECK" copy=$HLDG now -all
fi


$THIS_PATH/lin/registerTime.bat $KEY generateForJournal_update_hldg_fim
echo $TIME_END >> $LOG_FILE

if [ "@$DEBUG"=="@yes" ]
then
	echo 
else
	rm -rf $THIS_PROC_TMP_PATH
fi
$THIS_PATH/lin/registerTime.bat $KEY generateForJournal_fim
