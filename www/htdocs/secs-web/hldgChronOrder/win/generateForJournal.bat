set KEY=%1

set ALLFACIC=%2
set HLDG=%3
SET TITLE=%4
set CCODE=%5
set TAG_RESUMIDO=970

set THIS_CISIS=%6
SET THIS_PATH=%7

set MY_TMP_PATH=%8\geraCompactado

set DEBUG=%9

set LOG_FILE=%8\%KEY%.log

SET TAG_ID=30
set TAG_TIME=90
SET PROC_ID=%RANDOM%
SET TIME_START=%DATE%%TIME%
SET SEP=_
SET THIS_PROC_TMP_PATH=%MY_TMP_PATH%\%KEY%\%PROC_ID%
set PROC_FILE=%THIS_PROC_TMP_PATH%\proc.prc
SET PROC_FILE_CHECK=%THIS_PROC_TMP_PATH%\check.proc.prc

SET DO_TEMP_HLDG=%8\%KEY%.temp.txt

if exist %THIS_PROC_TMP_PATH% del %THIS_PROC_TMP_PATH%\* /s /q
if exist %THIS_PROC_TMP_PATH% rmdir %THIS_PROC_TMP_PATH% /s /q

echo %THIS_PROC_TMP_PATH%>%LOG_FILE%

mkdir %THIS_PROC_TMP_PATH%
echo %DATE%%TIME% >> %LOG_FILE%


rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  
rem  Create or update record of HLDG.
rem 
call %THIS_PATH%\win\hldg_db.bat %THIS_CISIS% %TITLE% %KEY% %TAG_RESUMIDO% %HLDG% %LOG_FILE% %THIS_PATH% %THIS_PROC_TMP_PATH%

rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  
rem  Classify the records from FACIC according to regular or special issues (REG x SPEC).
rem  
echo Classify the records from FACIC >> %LOG_FILE%

rem copy %THIS_PATH%\empty.txt %THIS_PROC_TMP_PATH%\REG.txt
rem copy %THIS_PATH%\empty.txt %THIS_PROC_TMP_PATH%\SPEC.txt

rem %THIS_CISIS%\mx %ALLFACIC% btell=0 "%KEY%=$" lw=99999 "proc='d920a920{',s('000000000000000000000000000000',v920),'{'"  "proc='d920a920{',mid(v920,size(v920)-30+1,30),'{'"  "pft='echo ',v920,'%SEP%',v911,'%SEP%',v912,'%SEP%',v913,'%SEP%',v914,'>> %THIS_PROC_TMP_PATH%\',if v913:'S' or v913:'P' or v913:'NE' or v913:'IN' or v913:'AN' then 'SPEC' else  'REG' fi,'.txt'/" now > %THIS_PROC_TMP_PATH%\classify_facic.bat
rem echo Executing %THIS_PROC_TMP_PATH%\classify_facic.bat >> %LOG_FILE%
rem call %THIS_PATH%\win\cat %THIS_PROC_TMP_PATH%\classify_facic.bat >> %LOG_FILE%
rem call %THIS_PROC_TMP_PATH%\classify_facic.bat

if not exist %DO_TEMP_HLDG% %THIS_CISIS%\mx %ALLFACIC% btell=0 "%KEY%=$" lw=99999 "proc='d920a920{',s('000000000000000000000000000000',v920),'{'"  "proc='d920a920{',mid(v920,size(v920)-30+1,30),'{'"  "pft=replace(s(v920,'%SEP%',v911,'%SEP%',v912,'%SEP%',v913,'%SEP%',v914,'%SEP%',if instr(':PT:S:NE:BI:IN:AN:',s(':',v916,':'))>0 then v916 else '' fi,'%SEP%',v910,'%SEP%',if instr(':PT:S:NE:BI:IN:AN:',s(':',v916,':'))>0 then 'S' else 'R' fi ),'%SEP% %SEP%','%SEP%%SEP%')/" now | sort > %THIS_PROC_TMP_PATH%\ORD.txt

if exist %DO_TEMP_HLDG% more %DO_TEMP_HLDG%  | sort > %THIS_PROC_TMP_PATH%\ORD.txt

rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  
rem  Generate the proc which will create the resumed form
rem  

copy %THIS_PATH%\empty.txt %PROC_FILE_CHECK%

copy %THIS_PATH%\empty.txt %PROC_FILE%

if exist %THIS_PROC_TMP_PATH%\ORD.txt call %THIS_PATH%\win\generateForFacic.bat %THIS_CISIS% %THIS_PROC_TMP_PATH%\ORD %THIS_PATH% %PROC_FILE% %LOG_FILE% %TAG_RESUMIDO% %SEP% %PROC_FILE_CHECK% %DEBUG%

rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  rem  
rem  Apply the proc
rem  
set TIME_END=%DATE%%TIME%

if exist %DO_TEMP_HLDG% goto TEMP_HLDG

%THIS_CISIS%\mx %HLDG% btell=0 "tit=%KEY%" "proc='d*','a10{',v10,'{'," "proc='a%TAG_ID%{%KEY%{a%TAG_TIME%{^s%TIME_START%^e%TIME_END%{'" "proc='a%TAG_TIME%{^d',f(val(s(v%TAG_TIME%^e*11))-val(s(v%TAG_TIME%^s*11)),1,0),'{'"  "proc=@%PROC_FILE%" "proc=@%PROC_FILE_CHECK%" copy=%HLDG% now -all

:TEMP_HLDG
move %PROC_FILE% %DO_TEMP_HLDG%.result
if exist %DO_TEMP_HLDG% del %DO_TEMP_HLDG%

echo %DATE%%TIME% >> %LOG_FILE%

if not "@%DEBUG%"=="@yes" del %THIS_PROC_TMP_PATH%\* /s /q
if not "@%DEBUG%"=="@yes" rmdir %THIS_PROC_TMP_PATH% /s /q