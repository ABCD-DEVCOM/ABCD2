<%@ tag body-content="empty" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>

<%
System.setProperty( "javax.net.ssl.trustStore",
                    System.getProperty("empweb.home", "/")+"/gui-truststore");
System.setProperty("javax.net.ssl.trustStorePassword", "pepepepe");

System.setProperty( "javax.net.ssl.keyStore",
                    System.getProperty("empweb.home", "/")+"/gui-keystore");
System.setProperty("javax.net.ssl.keyStorePassword", "pepepepe");



%>

<io:soap url="${config['ewengine.admin_service']}" SOAPAction="" encoding="UTF-8">
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                      xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
      <soapenv:Body>
        <getCalendars xmlns="http://kalio.net/empweb/engine/admin/v1">
        </getCalendars>
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>




