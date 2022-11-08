This folder is intended to store log files of the webserver for the current virtual host

### Web server log files
The virtual host file may have specific indicators to log messages of only the current virtual host.
This allows multiple parallel installations, each with their own logfile.

*** Note that regular cleaning of this folder is recommended ***

Example of "standard" log location indicator for Apache:
```sh
CustomLog ${APACHE_LOG_DIR}/access.log combined
ErrorLog  ${APACHE_LOG_DIR}/error.log
```
Example of virtual host related log indicators for Apache:
```sh
CustomLog ${ABCD_ROOT}/logs/access_${ABCD_PORT}.log combined
ErrorLog  ${ABCD_ROOT}/logs/error_${ABCD_PORT}.log
```
