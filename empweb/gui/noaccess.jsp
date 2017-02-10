<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>

<fmt:setLocale value="${sessionScope.userLocale}"/>
<fmt:setBundle basename="ewi18n.core.gui" scope="request"/>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><fmt:message key="empweb_access_error" /> | <fmt:message key="institution" /></title>
    <link rel="stylesheet" type="text/css" media="all" href="main.css" />
  </head>

  <body>
    <h1><fmt:message key="empweb_access_error" /></h1>

    <c:if test="${not empty param.errorMsg}">
      <p class="error"><fmt:message key="${fn:escapeXml(param.errorMsg)}" /> </p>
    </c:if>

    <div class="centered">
      <p>
        <a href="home/index.jsp"><fmt:message key="go_home"/></a> |
        <a href="logout.jsp"><fmt:message key="logout"/></a>
      </p>

      <table>
        <tr>
          <td><fmt:message key="requested_url"/></td>
          <td><c:out value="${fn:escapeXml(param.origURL)}"/></td>
        </tr>
        <tr>
          <td><fmt:message key="current_operator"/></td>
          <td><%= session.getAttribute("username")%></td>
        </tr>
        <tr>
          <td><fmt:message key="current_operator_id"/></td>
          <td><%= session.getAttribute("user") %></td>
        </tr>
        <tr>
          <td><fmt:message key="library"/></td>
          <td><%= session.getAttribute("library") %></td>
        </tr>

<c:if test="${config['gui.debug'] eq 'on'}">
        <tr>
          <td><fmt:message key="groups"/></td>
          <td>
<% 
      java.util.Enumeration e = session.getAttributeNames();
String groups = "";
while (e.hasMoreElements()) {
  String attrib = (String)e.nextElement();
  if (attrib.startsWith("group-"))
    groups += attrib +"<br/>";
}
%>
<%= groups %>
          </td>
</c:if>
        </tr>
      </table>
    </div>
  </body>
</html>
