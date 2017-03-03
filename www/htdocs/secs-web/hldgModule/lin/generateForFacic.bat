THIS_CISIS=$1
DB=$2
THIS_PATH=$3
proc_file=$4
LOG_FILE=$5
TAG_RESUMIDO=$6
SEP=$7
PROC_FILE_CHECK=$8
DEBUG=$9

myproc=$DB.pfirstlast
myproc2=$DB.eval

myprocGetP=$DB.getP

echo Executing $0 $1 $2 $3 $4 $5 $6 $7 $8 $9>> $LOG_FILE

$THIS_PATH/lin/registerTime.bat KEY generateForFacic_inicio
if [ -f $DB.txt ]
then
	$THIS_PATH/lin/registerTime.bat KEY generateForFacic_1
	$THIS_CISIS/mx null count=1 "pft=\`,'a$TAG_RESUMIDO{\`" now >> $proc_file

	$THIS_PATH/lin/registerTime.bat KEY generateForFacic_TXT2MST
	# $THIS_CISIS/mx seq=$DB.txt  create=$DB now -all
  	
	$THIS_CISIS/mx null count=1 "pft='LAST',#" now  >> $DB.txt

	$THIS_CISIS/mx seq=$DB.txt  fst=@$THIS_PATH/temp.fst create=$DB fullinv=$DB now -all

	$THIS_PATH/lin/registerTime.bat KEY generateForFacic_CHECK
	$THIS_CISIS/mx $DB lw=9999 "pft=@$THIS_PATH/checkv913.pft" now >> $PROC_FILE_CHECK
	if [ "@$DEBUG" == "@yes" ]
	then
		$THIS_PATH/lin/registerTime.bat KEY generateForFacic_DEBUG
		$THIS_CISIS/mx $DB lw=9999 "pft=@$THIS_PATH/present.pft" now >> $PROC_FILE_CHECK
	fi

	#$THIS_PATH/lin/registerTime.bat KEY generateForFacic_V2_INV
  	#$THIS_CISIS/mx $DB fst=@$THIS_PATH/temp.fst fullinv=$DB

	$THIS_PATH/lin/registerTime.bat KEY generateForFacic_V2_SEQ
  	# $myproc eh um seq em que cd linha eh 
  	# intervalo (inicio e fim) e/ou primeiro e último número do ano
  	# $THIS_CISIS/mx $DB btell=0 "STATUS=P" lw=9999 "pft=@$THIS_PATH/getP.pft" now > $myprocGetP.seq
	$THIS_CISIS/mx $DB btell=0 "SELECTED_A" lw=9999 "pft=@$THIS_PATH/getA.pft" now > $myprocGetP.seq
  	$THIS_CISIS/mx null count=1 "pft=#" now >> $myprocGetP.seq

	$THIS_PATH/lin/registerTime.bat KEY generateForFacic_LOG_SEQ
  	echo Content of $myprocGetP.seq >> $LOG_FILE
  	cat $myprocGetP.seq >> $LOG_FILE

	$THIS_PATH/lin/registerTime.bat KEY generateForFacic_V2_CREATE3
  	$THIS_CISIS/mx "seq=$myprocGetP.seq" create=$myprocGetP now -all

	$THIS_PATH/lin/registerTime.bat KEY generateForFacic_V2_DISPLAY
  	$THIS_CISIS/mx $myprocGetP lw=9999 "proc='a9970{$TAG_RESUMIDO{'" "pft=@$THIS_PATH/display.pft" now >>   $proc_file

	$THIS_PATH/lin/registerTime.bat KEY generateForFacic_V2_DISPLAY_FIM
	$THIS_CISIS/mx null count=1 "pft=\`{',\`" now >> $proc_file

fi
$THIS_PATH/lin/registerTime.bat KEY generateForFacic_fim
echo End of execution of $0 $1 $2 $3 $4 $5 $6 $7  $8 $9 >> $LOG_FILE
