<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="empty" %>
<%@ attribute name="suspensionId" required="true" %>
<%@ attribute name="operatorId" required="true" %>
<%@ attribute name="obs" required="false" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>

<io:soap url="${config['ewengine.trans_service']}" SOAPAction="" encoding="UTF-8">
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
      xmlns:xsd="http://www.w3.org/2001/XMLSchema"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
      <soapenv:Body>
        <cancelSuspensionSingle xmlns="http://kalio.net/empweb/engine/trans/v1">
          <id>${suspensionId}</id>
          <operatorId><%=session.getAttribute("user")%></operatorId>
          <obs>${obs}</obs>
          <transactionExtras>
            <params>
              <param name="operatorLocation"><%=session.getAttribute("library")%></param>
            </params>
          </transactionExtras>
        </cancelSuspensionSingle>
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>


