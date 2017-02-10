THIS_CISIS=$2
DB=$1
DB_FST=$3

if [ ! -f $DB.xrf ]
then
	$THIS_CISIS/mx iso=$DB.iso create=$DB now -all
fi
if [ -f $DB_FST ]
then 
	$THIS_CISIS/mx $DB fst=@$DB_FST fullinv=$DB
fi
