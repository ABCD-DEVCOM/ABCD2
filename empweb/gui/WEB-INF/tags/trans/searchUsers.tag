<%--
/* 
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ attribute name="database"  required="false" %>

<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>

<io:soap url="${config['ewengine.query_service']}" SOAPAction="" encoding="UTF-8">
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                      xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
      <soapenv:Body>
        <searchUsers xmlns="http://kalio.net/empweb/engine/query/v1">
          <queryParam xmlns="">
            <jsp:doBody/>
          </queryParam>
          <database xmlns="">${fn:trim(database)}</database>
        </searchUsers>
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>
