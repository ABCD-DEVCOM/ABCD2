<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="scriptless" %>
<%@ attribute name="name" required="true" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<% long timei= System.currentTimeMillis(); %>
<io:soap url="${config['ewengine.trans_service']}" SOAPAction="" encoding="UTF-8">
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
      <soapenv:Body>
        <doTransaction xmlns="http://kalio.net/empweb/engine/trans/v1">
          <name>${name}</name>
          <body><jsp:doBody/></body>
        </doTransaction>
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>
<% System.out.println("Total time for stats "+name+": "+(System.currentTimeMillis() - timei)+"ms"); %>
