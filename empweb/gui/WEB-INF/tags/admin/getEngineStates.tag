<%--
/* 
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="empty" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>

<io:soap url="${config['ewengine.admin_service']}" SOAPAction="" encoding="UTF-8">
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
      xmlns:xsd="http://www.w3.org/2001/XMLSchema"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
      <soapenv:Body>
        <getEngineStates xmlns="http://kalio.net/empweb/engine/admin/v1" />
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>

