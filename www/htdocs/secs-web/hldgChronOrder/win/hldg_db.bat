set THIS_CISIS=%1
set SRC=%2
set KEY=%3
set TAG_RESUMIDO=%4
set HLDG=%5
set LOG_FILE=%6
SET THIS_PATH=%7
SET THIS_PROC_TMP_PATH=%8


echo Executing of %0 %1 %2 %3 %4 %5 %6 %7 %8 %9>> %LOG_FILE%

if not exist %HLDG%.fst echo Create the %HLDG%.fst >> %LOG_FILE%
if not exist %HLDG%.fst copy %THIS_PATH%\hldg.fst %HLDG%.fst

if exist %HLDG%.xrf goto EXIST_HLDG

:NO_HLDG

	echo Create the HLDG if there is none >> %LOG_FILE%
	call %THIS_PATH%\win\hldg_createRecord.bat %THIS_CISIS% %SRC% %KEY% append %TAG_RESUMIDO% %HLDG% %LOG_FILE%
goto END

:EXIST_HLDG
	%THIS_CISIS%\mx %HLDG% btell=0 "TIT=%KEY%" "pft=if v30='%KEY%' then 'copy'/ fi" now > %THIS_PROC_TMP_PATH%\register_hldg.seq
	echo append >>%THIS_PROC_TMP_PATH%\register_hldg.seq
	rem more %THIS_PATH%\line.txt >> %THIS_PROC_TMP_PATH%\register_hldg.seq

	%THIS_CISIS%\mx seq=%THIS_PROC_TMP_PATH%\register_hldg.seq count=1 lw=99999 "pft='call %THIS_PATH%\win\hldg_createRecord.bat %THIS_CISIS% %SRC% %KEY% ',v1,' %TAG_RESUMIDO% %HLDG% %LOG_FILE%'/" now > %THIS_PROC_TMP_PATH%\register_hldg.bat

	echo Executing %THIS_PROC_TMP_PATH%\register_hldg.bat >> %LOG_FILE%
	call %THIS_PATH%\win\cat.bat %THIS_PROC_TMP_PATH%\register_hldg.bat >> %LOG_FILE% 
	call %THIS_PROC_TMP_PATH%\register_hldg.bat
goto END

:END

echo End of execution of %0 %1 %2 %3 %4 %5 %6 %7 %8 %9>> %LOG_FILE%
