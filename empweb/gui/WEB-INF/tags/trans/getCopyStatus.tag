<%@ tag body-content="empty" %>
<%@ attribute name="id"  required="true" %>
<%@ attribute name="database"  required="false" %>

<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%--
/* 
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>

<io:soap url="${config['ewengine.query_service']}" SOAPAction="" encoding="UTF-8">
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                      xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
      <soapenv:Body>
        <getCopyStatus xmlns="http://kalio.net/empweb/engine/query/v1">
          <id xmlns="">${fn:trim(id)}</id>
          <database xmlns="">${fn:trim(database)}</database>
        </getCopyStatus>
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>
