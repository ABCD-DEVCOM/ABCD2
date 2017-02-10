<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="empty" %>
<%@ attribute name="userId" required="true" %>
<%@ attribute name="recordId" required="true" %>
<%@ attribute name="volumeId" required="false" %>
<%@ attribute name="userDb" required="true" %>
<%@ attribute name="objectDb" required="true" %>
<%@ attribute name="objectCategory" required="true" %>
<%@ attribute name="startDate" required="true" %>
<%@ attribute name="objectLocation" required="false" %>
<%@ attribute name="acceptEndDate" required="false" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>

<io:soap url="${config['ewengine.trans_service']}" SOAPAction="" encoding="UTF-8">
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
      xmlns:xsd="http://www.w3.org/2001/XMLSchema"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
      <soapenv:Body>
        <waitSingle xmlns="http://kalio.net/empweb/engine/trans/v1">
          <userId><util:fixUserId>${userId}</util:fixUserId></userId>
          <recordId>${recordId}</recordId>
          <volumeId>${volumeId}</volumeId>
          <objectCategory>${objectCategory}</objectCategory>
          <userDb>${userDb}</userDb>
          <objectDb>${objectDb}</objectDb>
          <objectLocation>${objectLocation}</objectLocation>
          <startDate>${startDate}</startDate>
          <transactionExtras>
            <params>
              <param name="operatorLocation"><%=session.getAttribute("library")%></param>
              <param name="operatorId"><%=session.getAttribute("user")%></param>
              <param name="acceptEndDate">${acceptEndDate}</param>
            </params>
          </transactionExtras>
        </waitSingle>
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>



