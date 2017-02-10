<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="empty" %>
<%@ attribute name="userId" required="true" %>
<%@ attribute name="copyId" required="true" %>
<%@ attribute name="userDb" required="true" %>
<%@ attribute name="objectDb" required="true" %>
<%@ attribute name="acceptEndDate" required="false" %>
<%@ taglib prefix="c"  uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>

<io:soap url="${config['ewengine.trans_service']}" SOAPAction="" encoding="UTF-8">
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
      xmlns:xsd="http://www.w3.org/2001/XMLSchema"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
      <soapenv:Body>
        <loanSingle xmlns="http://kalio.net/empweb/engine/trans/v1">
          <userId><util:fixUserId>${userId}</util:fixUserId></userId>
          <copyId>${copyId}</copyId>
          <userDb>${userDb}</userDb>
          <objectDb>${objectDb}</objectDb>
          <transactionExtras>
            <params>
              <param name="operatorLocation"><%=session.getAttribute("library")%></param>
              <param name="operatorId"><%=session.getAttribute("user")%></param>
              <c:if test="${not empty acceptEndDate}">
              <param name="acceptEndDate">${acceptEndDate}</param>
              </c:if>
            </params>
          </transactionExtras>
        </loanSingle>
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>
