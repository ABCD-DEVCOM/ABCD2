THIS_CISIS=$1
SRC=$2
KEY=$3
APPEND_OR_CREATE_OR_COPY=$4
TAG_RESUMIDO=$5
HLDG=$6
LOG_FILE=$7
THIS_PATH=$8

CONTROL_FILE=$HLDG.INVERTING

$THIS_PATH/lin/registerTime.bat $KEY $0_inicio

echo Executing of $0 $1 $2 $3 $4 $5 $6 $7 $8 $9>> $LOG_FILE
# echo $APPEND_OR_CREATE_OR_COPY

if [ "@$APPEND_OR_CREATE_OR_COPY" == "@copy" ]
then
$THIS_PATH/lin/registerTime.bat $KEY $0_1
	# echo copying
	$THIS_CISIS/mx $HLDG btell=0 "TIT=$KEY" count=1 "proc='d*','a30{',v30,'{','a10{',v10,'{','a$TAG_RESUMIDO{converting{'" $APPEND_OR_CREATE_OR_COPY=$HLDG now -all
else
$THIS_PATH/lin/registerTime.bat $KEY $0_2
	if [ "@$APPEND_OR_CREATE_OR_COPY" == "@append" ]
	then
	$THIS_PATH/lin/registerTime.bat $KEY $0_3
	# echo appending

		$THIS_CISIS/mx $SRC btell=0 "I=$KEY" count=1 "proc='d*','a30{',v30,'{','a10{',v10,'{','a$TAG_RESUMIDO{converting{'" $APPEND_OR_CREATE_OR_COPY=$HLDG now -all
	else
	$THIS_PATH/lin/registerTime.bat $KEY $0_4
	# echo creating
		$THIS_CISIS/mx $SRC "proc='d*','a30{',v30,'{','a10{',v10,'{',,'a$TAG_RESUMIDO{converting{'" create=$HLDG now -all		
	fi
$THIS_PATH/lin/registerTime.bat $KEY $0_5
	variavel="valor"
	while [ $variavel = "valor" ]; do
	echo testing
$THIS_PATH/lin/registerTime.bat $KEY $0_6
		if [ -f $CONTROL_FILE ]
		then



$THIS_PATH/lin/registerTime.bat $KEY $0_7
			cat $CONTROL_FILE		
			cat $CONTROL_FILE >> control.txt
		else
$THIS_PATH/lin/registerTime.bat $KEY $0_8
			echo NO $CONTROL_FILE
			echo Inverting $HLDG for $KEY 
			echo Inverting $HLDG for $KEY > $CONTROL_FILE



$THIS_PATH/lin/registerTime.bat $KEY $0_9
			$THIS_CISIS/mx $HLDG fst=@$HLDG.fst fullinv=$HLDG
$THIS_PATH/lin/registerTime.bat $KEY $0_10
			rm -rf $CONTROL_FILE	
			variavel="stop"
		fi
	done
fi

$THIS_PATH/lin/registerTime.bat $KEY $0_fim
echo End of execution of $0 $1 $2 $3 $4 $5 $6 $7 $8 $9>> $LOG_FILE
