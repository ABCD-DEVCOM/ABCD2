<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%><%@ 
tag body-content="scriptless" %><%@ 
attribute name="var" required="true" rtexprvalue="false" %><%@ 
variable  name-from-attribute="var"  alias="varout" scope="AT_END" %><jsp:doBody var="value"/><%

String value = (String)jspContext.getAttribute("value");
boolean moreThanNumbers = value.matches(".*[^0-9].*");
getJspContext().setAttribute("varout", !moreThanNumbers);
%>
