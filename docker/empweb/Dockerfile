FROM java:7-jdk

COPY ./www/cgi-bin_Linux /opt/ABCD/www/cgi-bin
COPY ./empweb /opt/ABCD/empweb
#COPY ./docker/empweb/mysql-connector-java-3.1.12-bin.jar /opt/ABCD/empweb/common/ext/mysql-connector-java-3.1.12-bin.jar
COPY ./docker/empweb/mysql-connector-java-5.1.49-bin.jar /opt/ABCD/empweb/common/ext/mysql-connector-java-5.1.49-bin.jar

WORKDIR /opt/ABCD

ENV JETTY_HOME=/opt/ABCD/empweb/jetty
ENV JETTY_RUN=/opt/ABCD/empweb
ENV JETTY_PID=/opt/ABCD/empweb/jetty-devel.pid
ENV JETTY_CONSOLE=/opt/ABCD/empweb/logs/jetty-console.log
ENV CONFIGS="/opt/ABCD/empweb/common/etc/ewdbws-jetty.xml /opt/ABCD/empweb/common/etc/ewengine-jetty.xml /opt/ABCD/empweb/common/etc/ewgui-jetty.xml"
ENV JAVA=/usr/bin/java

ENTRYPOINT ["/usr/bin/java"]
CMD ["-server","-DSTART=/opt/ABCD/empweb/common/etc/start.config","-Djetty.home=/opt/ABCD/empweb/jetty","-Dempweb.home=/opt/ABCD/empweb","-Djava.util.logging.config.file=/opt/ABCD/empweb/common/etc/logging.properties","-Daxis.xml.reuseParsers=true","-Dsun.net.client.defaultConnectTimeout=10000","-Dcisis.location=/opt/ABCD/www/cgi-bin/ansi/","-Dcisis.command=mx","-Dabcd.url=http://172.17.0.1","-Dcisis.platform=linux","-Xms128M","-Xmx128M","-Djetty.home=/opt/ABCD/empweb/jetty","-Djava.library.path=/opt/ABCD/empweb/common/ext","-Dfile.encoding=ISO8859_1","-jar","/opt/ABCD/empweb/jetty/start.jar","/opt/ABCD/empweb/common/etc/ewdbws-jetty.xml","/opt/ABCD/empweb/common/etc/ewengine-jetty.xml","/opt/ABCD/empweb/common/etc/ewgui-jetty.xml"]
