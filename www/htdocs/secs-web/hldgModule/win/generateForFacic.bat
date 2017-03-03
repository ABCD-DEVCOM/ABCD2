set THIS_CISIS=%1
set DB=%2
set THIS_PATH=%3
set PROC_FILE=%4
set LOG_FILE=%5
set TAG_RESUMIDO=%6
SET SEP=%7
set PROC_FILE_CHECK=%8
set DEBUG=%9


set myproc=%DB%.pfirstlast
set myproc2=%DB%.eval
echo Executing %0 %1 %2 %3 %4 %5 %6 %7 >> %LOG_FILE%

if not exist %DB%.txt goto END

	%THIS_CISIS%\mx null count=1 "pft=`,'a%TAG_RESUMIDO%{`" now >> %PROC_FILE%

	%THIS_CISIS%\mx null count=1 "pft='LAST',#" now >> %DB%.txt

	%THIS_CISIS%\mx "seq=%DB%.txt%SEP%" create=%DB% now -all
	%THIS_CISIS%\mx %DB% fst=@%THIS_PATH%\temp.fst fullinv=%DB% 

	%THIS_CISIS%\mx %DB% lw=9999 "pft=@%THIS_PATH%\checkv913.pft" now >> %PROC_FILE_CHECK%
	if "@%DEBUG%"=="@yes" %THIS_CISIS%\mx %DB% lw=9999 "pft=@%THIS_PATH%\present.pft" now >> %PROC_FILE_CHECK%

	rem %THIS_CISIS%\mx %DB% btell=0 "STATUS=P" lw=9999 "pft=@%THIS_PATH%\getP.pft" now > %myproc2%.seq
	%THIS_CISIS%\mx %DB% btell=0 "SELECTED_A" lw=9999 "pft=@%THIS_PATH%\getA.pft" now > %myproc2%.seq
	%THIS_CISIS%\mx null count=1 "pft=#" now >> %myproc2%.seq

	echo Content of %myproc2%.seq>> %LOG_FILE%
	call %THIS_PATH%\win\cat.bat %myproc2%.seq >> %LOG_FILE%

	%THIS_CISIS%\mx "seq=%myproc2%.seq" create=%myproc2% now -all
	%THIS_CISIS%\mx %myproc2% lw=9999 "proc='a9970{%TAG_RESUMIDO%{'"  "pft=@%THIS_PATH%\display.pft" now >>   %PROC_FILE%

	%THIS_CISIS%\mx null count=1 "pft=`{',`" now >> %PROC_FILE%

:END

echo End of execution of %0 %1 %2 %3 %4 %5 %6 %7 >> %LOG_FILE%
