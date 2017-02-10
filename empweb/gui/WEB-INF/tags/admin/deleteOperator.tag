<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="empty" %>
<%@ tag import="net.kalio.auth.*" %>
<%@ attribute name="id" required="true" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>

<%-- procesar el tema y devolver el html de ok o error --%>

<%
Auth.setAuthPath( System.getProperty("empweb.home", "/") +
                  application.getInitParameter("net.kalio.auth.location"));
String result = Auth.deleteUser( id );
getJspContext().setAttribute("resultkey", result);
if ("".equals(result)) {
%>
<p>
  <fmt:message key="delete_operator_succeeded">
     <fmt:param value="${id}"/>
  </fmt:message>
</p>
<%
     } else {
%>
<p><fmt:message key="delete_operator_failed"/>: <strong><fmt:message key="${resultkey}"/></strong></p>
<%
     }
%>
