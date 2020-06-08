set THIS_CISIS=%2
set DB=%1
SET DB_FST=%3

if not exist %DB%.xrf %THIS_CISIS%\mx iso=%DB%.iso create=%DB% now -all
if exist %DB_FST% %THIS_CISIS%\mx %DB% fst=@%DB_FST% fullinv=%DB%
