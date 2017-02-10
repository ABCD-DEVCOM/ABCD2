<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="empty"%>
<%@ attribute name="year" required="true" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>


<x:parse varDom="cals">
   <admin:getCalendars/>
</x:parse>


<jsp:useBean id="nsm1" class="java.util.HashMap" />
<c:set target="${nsm1}" property="c" value="http://kalio.net/empweb/schema/calendar/v1" />
<jxp:set
  cnode="${cals}"
  var="calExists"
  select="//c:calendar[c:year/@value='${year}']/@id"
  nsmap="${nsm1}"/>

<c:choose>
  <c:when test="${calExists['.'] != null}">
    <error xmlns="http://kalio.net/empweb/schema/engineresult/v1">
      <msg>
        <key bundle="core.gui">calendar_already_exists</key>
        <params>
          <param>${year}</param>
        </params>
      </msg>
    </error>
  </c:when>

  <c:otherwise>
    <io:soap url="${config['ewengine.admin_service']}" SOAPAction="" encoding="UTF-8">
      <io:body>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
          xmlns:xsd="http://www.w3.org/2001/XMLSchema"
          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
          <soapenv:Body>
            <saveCalendar xmlns="http://kalio.net/empweb/engine/admin/v1">
             <calendarParam xmlns="http://kalio.net/empweb/schema/calendar/v1">
              <calendar xmlns="http://kalio.net/empweb/schema/calendar/v1" >
               <year value="${year}">
                </year>
              </calendar>
             </calendarParam>
            </saveCalendar>
          </soapenv:Body>
        </soapenv:Envelope>
      </io:body>
    </io:soap>
  </c:otherwise>
</c:choose>
