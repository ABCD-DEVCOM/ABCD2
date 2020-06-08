set THIS_CISIS=c:\home\scielo\www\proc\cisis1030
set FACIC=\\alpha1\spd\bases\secs\facic\facic
SET THIS_PATH=D:\c\svn\reddes.bvs\abcd\trunk\htdocs\secs-web\hldgModule
set THIS_TMP_PATH=d:\temp\secs
set KEY=%1
set HLDG=d:\temp\secs\data\hldg
SET xTITLE=d:\temp\secs\data\title
SET TITLE=\\alpha1\spd\bases\secs\title\title
set DEBUG=%2yes



if not exist %FACIC%.xrf call %THIS_PATH%\WIN\iso2mst.bat %FACIC% %THIS_CISIS% %THIS_PATH%\facic.fst
if not exist %TITLE%.xrf call %THIS_PATH%\WIN\iso2mst.bat %TITLE% %THIS_CISIS% %THIS_PATH%\hldg.fst

call %THIS_PATH%\win\generateForJournal.bat %KEY% %FACIC% %HLDG% %TITLE% 970 %THIS_CISIS% %THIS_PATH% %THIS_TMP_PATH% %DEBUG%  

echo notepad %LOG_FILE%

