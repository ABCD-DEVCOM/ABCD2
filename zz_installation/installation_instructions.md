This file contains the installation instructions for the latest version of ABCD.
This text is intended for the system manager and the database manager.

- [Introduction](#Introduction)
- [Prerequisites](#Prerequisites)
- [Preparation](#Preparation)
- [Install ABCD](#Install-ABCD)

<hr>

# Introduction
The ABCD code runs on Windows and Linux flavors. The source code is equal for both OS variants, except for some small differences.

ABCD requires several other components for its operations. Component CISIS (the database kernel software used by ABCD) is distributed with ABCD.
Some integrated components are also distributed with ABCD.

Other components are indicated as prerequisites and not distributed with ABCD.  
<hr>

# Prerequisites

### Always required
- A webserver. ABCD is tested with an Apache web server.
In order to minimize security problems the latest version is recommended. ABCD requires for a minimal installation at least
  - Module `mod_cgi`: To allow execution of CGI scripts
  - Module `mod_rewrite` : To allow rewrite rules in the `.htaccess` file
- A PHP processor. The unicode implementation of ABCD requires PHP 7.4.x. ABCD is not tested on PHP 8 (yet)
The default loaded extensions depend on the actual PHP processor. ABCD requires for a minimal installation at least
  - Extension `mbstring` : Multibyte support. To enable unicode.
  - Extension `gd` or `gd2` : Image functions. The name depends on the PHP implementation

### Optional requirements

- Web server extensions
  - Module `mod_ssl`  : Enables certificates and the https protocol
- PHP Extensions
  - Extension `curl`  : Required if `DSpace bridge` is used (to download records from DSpace repositories)
  - Extension `ldap`  : Required if login with LDAP is used
  - Extension `xmlrpc`: Required if Site is used
  - Extension `xsl`   : Required if Site is used
  - Extension `yaz`   : Required if `Z39.50` client is used (to download records via the Z39.50 communication protocol)
  - Extension `zip`   : Required to update the system.
- Apache Tika. This content analysis toolkit is required by the Digital Document functionality in ABCD.
ABCD uses the archive `tika-app***.jar` and `java` to execute this jar.
Download the `tika` archive from https://tika.apache.org/download.html

<hr>

# Preparation

The preparation phase ensures that a web server and PHP with the desired [prerequisites](#Prerequisites) are installed. This chapter adresses some attention points specifically for of ABCD.  
Multiple solutions exist to fullfill these functions ( native, XAMPP, WAMP, EasyPHP,...). Due to the many solutions and options of these solutions it is required to read the solution documentation carefully. This guide gives only minimal directives.

Good to know:
- Integrated solutions offer multiple functions. ABCD requires only the web server and PHP
- The firewall requires attention for the ABCD ports

### Check the web server and PHP
Ensure that the webserver and PHP are installed correctly and that PHP has the required extensions

### Download ABCD
The code for ABCD contains example configuration files for the webserver.

All code for ABCD is located in [GitHub ABCD-DEVCOM / ABCD2](https://github.com/ABCD-DEVCOM/ABCD2)  
This repository contains shared code for Linux AND Windows and data specific for Linux OR Windows.
The downloads contains all components.  

1. Select option **Releases** on the right side of the window
2. Scroll to the desired release and select **Assets**
3. Select Source code (zip) or Source code (tar.gz)
        
### Unpack downloaded archive
Use your favorite utility (zip/7zip/tar/...) to unpack the downloaded file. The folder structure
will be:
```
<Release_name> --+-- www ----------+-- bases-examples_Linux
                                   +-- bases-examples_Windows
                                   +-- cgi-bin_Linux
                                   +-- cgi-bin_Windows
                                   +-- extra
                                   +-- htdocs
                 +-- zz_installation
                 +-- zz_miscellaneous

```

### Virtual host file
The webserver serves an ABCD installation with a virtual configuration. With this technique multiple, completely different installations are possible.

The example virtual host configuration files for [Linux](vhost_ABCD_9090_Linux.conf) and [Windows](vhost_ABCD_9090_Windows.conf)
contain the values for a default ABCD installation.
- These example files are located in ```<Release_name> --+-- zz_installation```
- These files are example files. MUST be examined and updated to serve your needs and match the actual webserver.
- The virtual host file determines the protocol, port and server name for the ABCD installation.
  - The port number is picked up by the ABCD installation
  - The protocol (**http**/**https**) is picked up by the ABCD installation
  - The **https** protocol is recommended. Take care of a certificate. To enable https: uncomment the lines with parameter names **SSL\***
- The virtual host file determines the locations for the ABCD components. The defaults are different for Linux and Windows.
The webserver adresses these folders with parameters:
  - **DocumentRoot** : folder with ABCD PHP-scripts
  - **ScriptAlias cgi-bin** : folder with executable files (e.g. CISIS, jar's,...)
  - **Alias docs** : folder with database folders
- The example virtual host file specifies a specific location for the logs of this virtual host. Must be an existing folder ! Create it if it does not exist.
- The example virtual host file contains common PHP flags 


### Virtual host file installation

- Copy the example file to the webserver configuration. The file name can be arbitrarily chosen. 
Example locations:  
  - WAMP &rarr; `wamp/alias`,  
  - XAMPP &rarr; `apache/conf/extra`,  
  - native Ubuntu &rarr; `/etc/apache2/sites-available/`
- The existence of the file must be made known to the server. Method depends on the installed webserver solution
  - XAMPP &rarr; edit `httpd.conf` &rarr; `include conf/extra/vhost_ABCD_9090_Windows.conf`
  - native Ubuntu &rarr; `sudo a2ensite vhost_ABCD_9090_Linux.conf`
- Check configuration
  - XAMPP &rarr; Start service and check log files
  - native Ubuntu &rarr; `sudo apachectl -S` /  `sudo apachectl -t -D DUMP_MODULES` / `sudo systemctl start  apache2`


<hr>

# Install ABCD

### Preprocess the downloaded folders
The ABCD code is downloaded in the preparation phase.
Note the different actions for Windows and Linux platforms. 
```
bases-examples_Linux   # Linux users:   Rename to "bases".   Windows users: Delete
bases-examples_Windows # Windows users: Rename to "bases".   Linux users:   Delete
cgi-bin_Linux          # Linux users:   Rename to "cgi-bin". Windows users: Delete
cgi-bin_Windows        # Windows users: Rename to "cgi-bin". Linux users:   Delete
extra                  # Contains c-source code: Delete
htdocs                 # Contains ABCD
zz_installation        # Contains this file, the "virtual host example files", and related files: Delete after installation
zz_miscellaneous       # Only used by developers: Delete
```
The resulting set is:
```
bases                  # Folder with example databases
cgi-bin                # Folder with executable programs
htdocs                 # Contains ABCD
```

### Copy to the web server
The virtual host file specifies the folder names for the ABCD installation.
1. Copy the content of **htdocs** to the folder specified by parameter **DocumentRoot**
2. Copy the content of **cgi-bin** to the folder specified by parameter **ScriptAlias**
3. Copy the content of **bases** to the folder specified by parameter **docs**
4. If the Digital Document feature is used: Copy the downloaded tika jar to the folder specified by parameter **ScriptAlias**
5. Create central configuration file. Git archives no longer supply this configuration file
   - Copy **htdocs/central/config.php.template** to **htdocs/central/config.php**
   - Edit **htdocs/central/config.php** to reflect your local situation and save it. This file is not overwritten by a version update.
6. For Linux installations
   - Change ownership of the folders to the owner/group of the webserver (`chown -R ...`)
   - Change protection of the folders to correct values (`chmod -R ...`)
7. Restart the webserver/web server service

### Run
Start your favourite web browser and run ABCD with following URL's.

- `https://localhost:9090/phpinfo   ` : Show information about PHP settings and extensions
- `https://localhost:9090           ` : The central module. Login username `abcd`, password `adm`.
- `https://localhost:9090/iah       ` : The iAH module. Login username `abcd`, password `adm`.
- `https://localhost:9090/site      ` : The SITE module. No login
- `https://localhost:9090/site/admin` : The SITE module. Login username `adm`, password `x`.
- `https://localhost:9090/opac ` : The OPAC module. No login

### Configure
Recommendation: Modify the passwords of the administrative users to avoid unexpected logins with too much privileges

### Help
Additional help can be obtained by joining and using the e-mail based `ISIS-users discussion list`,
- registering: http://lists.iccisis.org/listinfo/isis-users
- using : mail to 'isis-users@iccisis.org'

Join the forums at https://abcd-community.org/
