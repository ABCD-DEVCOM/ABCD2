<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="scriptless" %>
<%@ tag import="java.util.*" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>

<jsp:useBean id="xmlSend" class="java.lang.String" scope="request"/>
<%

TreeMap skipDays = new TreeMap();
for (Iterator e = request.getParameterMap().keySet().iterator(); e.hasNext() ; ) {
  String thisKey = (String) e.next();

  // IMPORTANT: parameters for the day must start with day_ followed by
  //            year, month and day (eg: 20050201)
  if ( thisKey.startsWith("day_") ) {
    String yearVal  = thisKey.substring(4,8);
    String monthVal = thisKey.substring(8,10);
    String dayVal   = thisKey.substring(10,12);

    TreeMap days;
    if (skipDays.containsKey(monthVal)) {
        days = (TreeMap)skipDays.get(monthVal);
        days.put(dayVal, new Boolean(true));
    } else {
        days = new TreeMap();
        days.put(dayVal, new Boolean(true));
        skipDays.put(monthVal, days);
    }
  } // if
} // for

StringBuffer xmlSendSB= new StringBuffer(4096);
for (Iterator m = skipDays.keySet().iterator() ; m.hasNext() ; ) {
  String thisMonth = (String) m.next();
  xmlSendSB.append(xmlSend);
  xmlSendSB.append(
    "              <month value=\"").append(thisMonth).append("\">\n");
    TreeMap days = (TreeMap)skipDays.get(thisMonth);
    for (Iterator d= days.keySet().iterator() ; d.hasNext() ; ) {
      String thisDay = (String) d.next();
      xmlSendSB.append(
    "                <day value=\"").append(thisDay).append("\"><skipDay/></day>\n");
    }
    xmlSendSB.append(
    "              </month>\n");
} // for

xmlSend= xmlSendSB.toString();
// put back the value of the string to the attribute bean xmlSend
request.setAttribute("xmlSend", xmlSend);
%>

<io:soap url="${config['ewengine.admin_service']}" SOAPAction="" encoding="UTF-8">
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
      xmlns:xsd="http://www.w3.org/2001/XMLSchema"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
      <soapenv:Body>
        <saveCalendar xmlns="http://kalio.net/empweb/engine/admin/v1">
          <calendarParam>
            <calendar xmlns="http://kalio.net/empweb/schema/calendar/v1" >
              <year value="${param.year}">
                ${xmlSend}
              </year>
            </calendar>
          </calendarParam>
        </saveCalendar>
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>
