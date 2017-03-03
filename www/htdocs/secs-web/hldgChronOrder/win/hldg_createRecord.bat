set THIS_CISIS=%1
set SRC=%2
set KEY=%3
SET APPEND_OR_CREATE_OR_COPY=%4
set TAG_RESUMIDO=%5
set HLDG=%6
set LOG_FILE=%7

set CONTROL_FILE=%HLDG%.INVERTING

echo Executing of %0 %1 %2 %3 %4 %5 %6 %7 %8 %9>> %LOG_FILE%
echo %APPEND_OR_CREATE_OR_COPY%

if "@%APPEND_OR_CREATE_OR_COPY%" == "@copy"   %THIS_CISIS%\mx %HLDG% btell=0 "TIT=%KEY%" count=1 "proc='d*','a30{',v30,'{','a10{',v10,'{','a%TAG_RESUMIDO%{converting{'" %APPEND_OR_CREATE_OR_COPY%=%HLDG% now -all
if "@%APPEND_OR_CREATE_OR_COPY%" == "@append" %THIS_CISIS%\mx %SRC%  btell=0 "i=%KEY% or tit=%KEY%" count=1 "proc='d*','a30{',v30,'{','a10{',v10,'{','a%TAG_RESUMIDO%{converting{'" %APPEND_OR_CREATE_OR_COPY%=%HLDG% now -all
if "@%APPEND_OR_CREATE_OR_COPY%" == "@create" %THIS_CISIS%\mx %SRC% "proc='d*','a30{',v30,'{','a10{',v10,'{','a%TAG_RESUMIDO%{converting{'" create=%HLDG% now -all		

if "@%APPEND_OR_CREATE_OR_COPY%" == "@copy" goto END


:TEST_FILE
echo Control %CONTROL_FILE% >>%LOG_FILE% 
if exist %CONTROL_FILE% goto TEST_FILE
if exist %CONTROL_FILE% more %CONTROL_FILE%	
if exist %CONTROL_FILE% call %THIS_PATH%\win\cat.bat %CONTROL_FILE% >> control.txt

echo NO %CONTROL_FILE%
echo Inverting %HLDG% for %KEY% 
echo Inverting %HLDG% for %KEY% > %CONTROL_FILE%
%THIS_CISIS%\mx %HLDG% fst=@%HLDG%.fst fullinv=%HLDG% 	
del %CONTROL_FILE%	


:END

echo End of execution of %0 %1 %2 %3 %4 %5 %6 %7 %8 %9>> %LOG_FILE%




