This archive contains the new ABCD2.0 distribution, which has some important differences from the previous installation :

1. We no longer distribute Apache and PHP ourselves with the package; therefore you will only get a directory 'www'  (with the main ABCD system inside)
and 'empweb'  (in case you want to use the Advanced Loans module of ABCD).

2. So you will have to install Apache and PHP yourself, independently from ABCD. The easiest way to do this is to download WAMP(-Server) or XAMPP
from resp. https://sourceforge.net/projects/wampserver
and https://sourceforge.net/projects/xampp/   .

3. Copy/Paste the file httpd-vhosts-abcd.conf from this directory into either :
\WAMP\alias (or WAMP64\alias)
\XAMPP\apache\conf\extra

4. Check and if necessary edit that file httpd-vhosts-abcd.conf for the correct port (default is defined as 9090).
The default paths defined are supposing that ABCD was installed in a 'root'-folder on your harddisk, e.g. C:\
DocumentRoot "/ABCD/www/htdocs"
and
ScriptAlias /cgi-bin/ "/ABCD/www/cgi-bin/"
with one more 'alias'  defined to easily refer to the databases-directory where you can put the ' docs' (PDF's, repository etc.) for the databases :
Alias /docs/ "/ABCD/www/bases/"

5. Check your PHP-configuration in the file php.ini and make sure you have some extra 'extensions' active :
extension=php_bz2.dll
extension=php_curl.dll
extension=php_gd2.dll
extension=php_intl.dll
extension=php_ldap.dll
extension=php_mbstring.dll
;extension=php_mysqli.dll ; Activate this only if you use EmpWeb or other tools like e.g. Piwik
extension=php_xmlrpc.dll
extension=php_xsl.dll
extension=php_yaz.dll  ; This extension is needed for the Z39-50 shared cataloging feature; find the right version at http://www.indexdata.com/phpyaz

6. Restart your WAMP or XAMPP server(s)
and check that there are (hopefully...) no errors mentioned.

7. Now ABCD can be opened from the URL :
- for Central : http://localhost:9090
- for the iAH OPAC : http://localhost:9090/iah
- for the ABCD Site : http://localhost:9090/site
- for the ABCD Serials Control module : http://localhost:9090/Secs-web
- for EmpWeb Advanced Loans : http://localhost:8080/empweb

For more detailed info check the ABCD-manuals.
