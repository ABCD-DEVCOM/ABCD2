<%--
/* 
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="empty" %>
<%@ attribute name="daysSuspended" required="true" %>
<%@ attribute name="userId" required="true" %>
<%@ attribute name="userDb" required="true" %>
<%@ attribute name="operatorId" required="true" %>
<%@ attribute name="obs" required="false" %>

<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>

<io:soap url="${config['ewengine.trans_service']}" SOAPAction="" encoding="UTF-8">
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
      xmlns:xsd="http://www.w3.org/2001/XMLSchema"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
      <soapenv:Body>
        <suspensionSingle xmlns="http://kalio.net/empweb/engine/trans/v1">
          <userId><util:fixUserId>${userId}</util:fixUserId></userId>
          <userDb>${userDb}</userDb>
          <daysSuspended>${daysSuspended}</daysSuspended>
          <operatorId>${operatorId}</operatorId>
          <obs>${obs}</obs>
          <transactionExtras>
            <params>
              <param name="operatorLocation"><%=session.getAttribute("library")%></param>
              <param name="operatorId"><%=session.getAttribute("user")%></param>
            </params>
          </transactionExtras>
        </suspensionSingle>
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>


