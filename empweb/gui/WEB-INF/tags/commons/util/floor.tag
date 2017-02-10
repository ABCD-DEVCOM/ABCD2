<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%><%@ tag body-content="scriptless" %><jsp:doBody var="body"/><%
  String body = (String)jspContext.getAttribute("body");
if (body != null) {
  try {
    double val = Double.parseDouble(body);

%><%= Integer.toString( (new Double(Math.floor(val))).intValue() )%><%
  } catch (NumberFormatException e) {    
  }
}
%>