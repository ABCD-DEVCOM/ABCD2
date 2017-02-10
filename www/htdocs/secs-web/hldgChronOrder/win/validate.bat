set KEY=%1

set CHECKDB=%2
set HLDG=%3
SET GOOD=%4
set BAD=%5

set THIS_CISIS=%6
SET DIFF=%7

%THIS_CISIS%\mx %HLDG% btell=0  tit=%KEY% lw=9999 "pft=v30,' ',v970,#" now >> %BAD%
%THIS_CISIS%\mx %CHECKDB% btell=0  tit=%KEY%  lw=9999 "pft=v30,' ',v98,#" now >> %GOOD%

