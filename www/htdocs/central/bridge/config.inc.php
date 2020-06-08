HOST=localhost
PORT=3306
USER=root
PASSWD=empweb
DATABASE=university
EMPWEBDB=corporate
QUERYBYID="SELECT identification,last_name,first_name,user_type.name,DATE_FORMAT(valid_until,'%Y%m%d'),login,passwd FROM users LEFT JOIN user_type ON users.user_type_id=user_type.id WHERE identification='<id>'"
QUERYBYIDLIKE="SELECT identification,last_name,first_name,user_type.name,DATE_FORMAT(valid_until,'%Y%m%d'),login,passwd FROM users LEFT JOIN user_type ON users.user_type_id=user_type.id WHERE identification LIKE '<id>%'"
QUERYBYIDFORREPORTS=" OR identification='<idx>'"
QUERYBYNAMEEXACT="SELECT identification,last_name,first_name,user_type.name,DATE_FORMAT(valid_until,'%Y%m%d'),login,passwd FROM users LEFT JOIN user_type ON users.user_type_id=user_type.id WHERE last_name LIKE '<name>'"
QUERYBYNAMELIKE="SELECT identification,last_name,first_name,user_type.name,DATE_FORMAT(valid_until,'%Y%m%d'),login,passwd FROM users LEFT JOIN user_type ON users.user_type_id=user_type.id WHERE last_name LIKE '<name>%'"
QUERYBYLOGIN="SELECT identification,last_name,first_name,user_type.name,DATE_FORMAT(valid_until,'%Y%m%d'),login,passwd FROM users LEFT JOIN user_type ON users.user_type_id=user_type.id WHERE login='<login>'"
DEBUG=TRUE
LOGFILE="/ABCD/www/bases/bridge/log.txt"