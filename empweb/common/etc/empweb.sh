#!/bin/sh
#
# Startup script for jetty under *nix systems (it works under NT/cygwin too).
#
### BEGIN INIT INFO
# Provides: jetty server start
# Description: start jetty for Empweb
### END INIT INFO
# Configuration variables
#
# JAVA_HOME
#   Home of Java installation.
#
# JAVA
#   Command to invoke Java. If not set, $JAVA_HOME/bin/java will be used.
#
# JAVA_OPTIONS
#   Extra options to pass to the JVM
#
# JETTY_HOME
#   Where Jetty is installed.
#   The java system property "jetty.home" will be
#   set to this value for use by configure.xml files, f.e.:
#
#    <Arg><SystemProperty name="jetty.home" default="."/>/webapps/jetty.war</Arg>
#
# JETTY_CONSOLE
#   Where Jetty console output should go. Defaults to first writeable of
#      /dev/console
#      /dev/tty
#
#
# CISIS_LOCATION
#   Folder where  CISIS utilities could be accessed
#
# CISIS_COMMAND
#   Command name for mx
#
# OS
#   Operative System for mx wrapper
#


############################################################
####### EmpWeb environment variables and Java parameters.
####### CHANGE THIS TO CONFIGURE FOR YOUR LOCAL SETUP!
############################################################

# The root directory of the Empweb installation
EMPWEB_HOME="/opt/ABCD/empweb"
ABCD_URL="http://localhost:80/"
OS="linux"

# Specify the Jetty configuration files for all the parts of Empweb that this server must run.
# If you want to run everything in one machine, then specify ewdbws, ewengine, ewgui configurations.
CONFIGS="$EMPWEB_HOME/common/etc/ewdbws-jetty.xml $EMPWEB_HOME/common/etc/ewengine-jetty.xml $EMPWEB_HOME/common/etc/ewgui-jetty.xml"


# Variables used by Jetty
JETTY_HOME="/opt/ABCD/empweb/jetty"
JETTY_START="$EMPWEB_HOME/common/etc/start.config"
JETTY_CONSOLE="$EMPWEB_HOME/logs/jetty-console.log"


# Java variables.
JAVA_HOME="/usr/lib/jvm/java-7-openjdk-amd64/bin"
JAVA="$JAVA_HOME/java"


# CISIS Wrapper
CISIS_LOCATION="/opt/ABCD/www/cgi-bin/"
CISIS_COMMAND="mx"
OS=linux



# Logging settings.
LOGGING_CONF=$EMPWEB_HOME/common/etc/logging.properties

# For large memory machines, dedicated to Empweb, -Xms = initial heap size, -Xmx = maximum heap size
#JAVA_OPTIONS="-server -DSTART=$JETTY_START  -Djetty.home=$JETTY_HOME -Dempweb.home=$EMPWEB_HOME -Djava.util.logging.config.file=$LOGGING_CONF -Daxis.xml.reuseParsers=true -Xms128M -Xmx512M -Xincgc"

# Or use less memory in smaller machines running other programs
# JAVA_OPTIONS="-server -DSTART=$JETTY_START  -Djetty.home=$JETTY_HOME -Dempweb.home=$EMPWEB_HOME -Djava.util.logging.config.file=$LOGGING_CONF -Daxis.xml.reuseParsers=true -Xms64M -Xmx192M  -Xincgc"

# Or let its inner strength decide:
JAVA_OPTIONS="-server -DSTART=$JETTY_START  -Djetty.home=$JETTY_HOME -Dempweb.home=$EMPWEB_HOME -Djava.util.logging.config.file=$LOGGING_CONF -Daxis.xml.reuseParsers=true -Dsun.net.client.defaultConnectTimeout=10000 -Dcisis.location=$CISIS_LOCATION -Dcisis.command=$CISIS_COMMAND -Dabcd.url=$ABCD_URL -Dcisis.platform=$OS -Xms128M -Xmx128M -Xincgc"

############################################################################
#### You shouldn't change anything below unless you know what you're doing!
############################################################################
usage()
{
    echo "Usage: $0 {start|startdebug|stop|check|supervise} [ CONFIGS ... ] "
    exit 1
}

[ $# -gt 0 ] || usage


##################################################
# Find directory function
##################################################
findDirectory()
{
    OP=$1
    shift
    for L in $* ; do
        [ $OP $L ] || continue
        echo $L
        break
    done
}


##################################################
# Get the action & configs
##################################################

ACTION=$1
shift
ARGS="$*"


###########################################################
# Get the list of config.xml files from the command line.
###########################################################
if [ ! -z "$ARGS" ]
then
  for A in $ARGS
  do
    if [ -f $A ]
    then
       CONF="$A"
    elif [ -f $JETTY_HOME/etc/$A ]
    then
       CONF="$JETTY_HOME/etc/$A"
    elif [ -f ${A}.xml ]
    then
       CONF="${A}.xml"
    elif [ -f $JETTY_HOME/etc/${A}.xml ]
    then
       CONF="$JETTY_HOME/etc/${A}.xml"
    else
       echo "** ERROR: Cannot find configuration '$A' specified in the command line."
       exit 1
    fi
    if [ ! -r $CONF ]
    then
       echo "** ERROR: Cannot read configuration '$A' specified in the command line."
       exit 1
    fi
    CONFIGS="$CONFIGS $CONF"
  done
fi




#####################################################
# Find a location for the pid file
#####################################################
if [  -z "$JETTY_RUN" ]
then
  JETTY_RUN=`findDirectory -w $EMPWEB_HOME /var/run /usr/var/run /tmp`
fi

#####################################################
# Find a PID for the pid file
#####################################################
if [  -z "$JETTY_PID" ]
then
  JETTY_PID="$JETTY_RUN/jetty-devel.pid"
fi

#####################################################
# Find a location for the jetty console
#####################################################
if [  -z "$JETTY_CONSOLE" ]
then
  if [ -w /dev/console ]
  then
    JETTY_CONSOLE=/dev/console
  else
    JETTY_CONSOLE=/dev/tty
  fi
fi




#####################################################
# See if JETTY_PORT is defined
#####################################################
if [ "$JETTY_PORT" != "" ]
then
  JAVA_OPTIONS="$JAVA_OPTIONS -Djetty.port=$JETTY_PORT "
fi



#####################################################
# Add jetty properties to Java VM options.
#####################################################
JAVA_OPTIONS="$JAVA_OPTIONS -Djetty.home=$JETTY_HOME  -Djava.library.path=$EMPWEB_HOME/common/ext -Dfile.encoding=ISO8859_1"

if [ "$ACTION" == "startdebug" ]
then
  JAVA_OPTIONS=" -DDEBUG $JAVA_OPTIONS "
fi


#####################################################
# This is how the Jetty server will be started
#####################################################
RUN_CMD="$JAVA $JAVA_OPTIONS  -jar $JETTY_HOME/"start.jar" $CONFIGS"

#####################################################
# Comment these out after you're happy with what
# the script is doing.
#####################################################
echo "JETTY_HOME     =  $JETTY_HOME"
echo "JETTY_RUN      =  $JETTY_RUN"
echo "JETTY_PID      =  $JETTY_PID"
echo "JETTY_CONSOLE  =  $JETTY_CONSOLE"
echo "CONFIGS        =  $CONFIGS"
echo "JAVA_OPTIONS   =  $JAVA_OPTIONS"
echo "JAVA           =  $JAVA"
echo "CLASSPATH      =  $CLASSPATH"
echo "RUN_CMD        =  $RUN_CMD"

#################################################
# Do the action
##################################################
case "$ACTION" in
  start|startdebug)
        echo "Starting Jetty: "

        #if [ -f $JETTY_PID ]
        #then
        #    echo "Already Running!!"
        #    exit 1
        #fi

        echo "STARTED Jetty `date`" >> $JETTY_CONSOLE

        nohup sh -c "exec $RUN_CMD >>$JETTY_CONSOLE 2>&1" >/dev/null &
        echo $! > $JETTY_PID
        echo "Jetty running pid="`cat $JETTY_PID`
        ;;

  stop)
        PID=`cat $JETTY_PID 2>/dev/null`
        echo "Shutting down Jetty: $PID"
        kill $PID 2>/dev/null
        sleep 2
        kill -9 $PID 2>/dev/null
        rm -f $JETTY_PID
        echo "STOPPED `date`" >>$JETTY_CONSOLE
        ;;

  supervise)
       #
       # Under control of daemontools supervise monitor which
       # handles restarts and shutdowns via the svc program.
       #
         exec $RUN_CMD
         ;;

  check)
        echo "Checking arguments to Jetty: "
        echo "JETTY_HOME     =  $JETTY_HOME"
        echo "JETTY_RUN      =  $JETTY_RUN"
        echo "JETTY_PID      =  $JETTY_PID"
        echo "JETTY_CONSOLE  =  $JETTY_CONSOLE"
        echo "JETTY_PORT     =  $JETTY_PORT"
        echo "CONFIGS        =  $CONFIGS"
        echo "PATH_SEPARATOR =  $PATH_SEPARATOR"
        echo "JAVA_OPTIONS   =  $JAVA_OPTIONS"
        echo "JAVA           =  $JAVA"
        echo "CLASSPATH      =  $CLASSPATH"
        echo "RUN_CMD        =  $RUN_CMD"
        echo

        if [ -f $JETTY_RUN/jetty.pid ]
        then
            echo "Jetty running pid="`cat $JETTY_RUN/jetty.pid`
            exit 0
        fi
        exit 1
        ;;

*)
        usage
  ;;
esac

exit 0


