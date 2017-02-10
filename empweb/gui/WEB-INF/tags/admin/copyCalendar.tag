<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="empty" %>
<%@ attribute name="sourceYear" required="true" %>
<%@ attribute name="destYear" required="true" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>



<io:soap url="${config['ewengine.admin_service']}" SOAPAction="" encoding="UTF-8">
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
      xmlns:xsd="http://www.w3.org/2001/XMLSchema"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
      <soapenv:Body>
        <saveCalendar xmlns="http://kalio.net/empweb/engine/admin/v1">
          <calendarParam xmlns="http://kalio.net/empweb/schema/calendar/v1">
            <calendar xmlns="http://kalio.net/empweb/schema/calendar/v1" >

              <x:parse varDom="incal">
                <io:soap url="${config['ewengine.admin_service']}" SOAPAction="" encoding="UTF-8">
                  <io:body>
                    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                      xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                      <soapenv:Body>
                        <getCalendar xmlns="http://kalio.net/empweb/engine/admin/v1">
                          <year>${fn:trim(sourceYear)}</year>
                        </getCalendar>
                      </soapenv:Body>
                    </soapenv:Envelope>
                  </io:body>
                </io:soap>
              </x:parse>

              <jsp:useBean id="nsm" class="java.util.HashMap" />
              <c:set target="${nsm}" property="c" value="http://kalio.net/empweb/schema/calendar/v1" />

              <year value="${destYear}">
                <%-- For each month with at least one skipDay --%>
                <jxp:forEach
                    cnode="${incal}"
                    var="ptr"
                    select="//c:month[c:day/c:skipDay]"
                    nsmap="${nsm}">

                  <month value="${ptr['@value']}">
                    <%-- For each skipDay within the current month --%>
                    <jxp:forEach
                        cnode="${ptr}"
                        var="ptr2"
                        select="//c:day/c:skipDay"
                        nsmap="${nsm}">
                      <day value="${ptr2['../@value']}">
                        <skipDay/>
                      </day>
                    </jxp:forEach>
                  </month>
                </jxp:forEach>
              </year>
            </calendar>
          </calendarParam>
        </saveCalendar>
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>
