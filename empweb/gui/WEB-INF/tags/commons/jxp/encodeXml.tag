<%@ tag import="net.kalio.xml.KalioXMLUtil" %><%@
tag body-content="scriptless" %><%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%><jsp:doBody var="body"/><%
String body= (String)jspContext.findAttribute("body");
out.write(KalioXMLUtil.xmlEncode(body));
%>