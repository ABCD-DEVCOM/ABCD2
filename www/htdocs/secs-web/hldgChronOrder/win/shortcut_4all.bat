set xTHIS_CISIS=c:\home\scielo\www\proc\cisis1030
set xFACIC=\\alpha1\spd\bases\secs\facic\facic
SET xTHIS_PATH=D:\abcd\www\htdocs\secs-web\hldgChronOrder
set xTHIS_TMP_PATH=d:\temp\secs
rem set KEY=%1
set xHLDG=d:\temp\secs\data\hldgChronOrder
SET xTITLE=d:\temp\secs\data\title
SET xxTITLE=\\alpha1\spd\bases\secs\title\title
set xDEBUG=%2yes

set xCOUNT=%1

set THIS_CISIS=c:\abcd\www
set FACIC=c:\bireme\secs\data2\facic
SET THIS_PATH=c:\abcd\www\htdocs\secs-web\hldgChronOrder
set THIS_TMP_PATH=c:\bireme\secs\temp
rem set KEY=%1
set HLDG=d:\temp\secs\data\hldgChronOrder
SET xTITLE=d:\temp\secs\data\title
SET TITLE=\\alpha1\spd\bases\secs\title\title
set DEBUG=%2yes

set COUNT=%1

if not exist %FACIC%.xrf call %THIS_PATH%\WIN\iso2mst.bat %FACIC% %THIS_CISIS% %THIS_PATH%\facic.fst
if not exist %TITLE%.iso call %THIS_PATH%\WIN\iso2mst.bat %TITLE% %THIS_CISIS% %THIS_PATH%\hldg.fst

if not exist %TITLE%.xrf call %THIS_PATH%\WIN\iso2mst.bat %TITLE% %THIS_CISIS% %THIS_PATH%\hldg.fst

rem %THIS_CISIS%\mx %FACIC% "pft=if p(v916) then v30/ fi" now | sort  > %THIS_TMP_PATH%\id.txt

rem %THIS_CISIS%\mx "seq=%THIS_TMP_PATH%\id.txt" create=%THIS_TMP_PATH%\id now -all

rem %THIS_CISIS%\mx %THIS_TMP_PATH%\id "pft=if v1<>ref(mfn+1,v1) then v1/ fi" now > %THIS_TMP_PATH%\id2.txt


%THIS_CISIS%\mx "seq=%THIS_TMP_PATH%\id2.txt" lw=99999 "pft='call %THIS_PATH%\win\generateForJournal.bat ',v1,' %FACIC% %HLDG% %TITLE% 98 %THIS_CISIS% %THIS_PATH% %THIS_TMP_PATH% %DEBUG%'/" now > %THIS_TMP_PATH%\call_4all.bat


rem %THIS_CISIS%\mx %TITLE% %COUNT% lw=9999 "pft='call %THIS_PATH%\win\generateForJournal.bat ',v30,' %FACIC% %HLDG% %TITLE% 98 %THIS_CISIS% %THIS_PATH% %THIS_TMP_PATH% %DEBUG%'/" now > %THIS_TMP_PATH%\call_4all.bat

call %THIS_TMP_PATH%\call_4all.bat
