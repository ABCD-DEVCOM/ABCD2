<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="scriptless" %>
<%@ attribute name="dateStyle" %>
<%@ attribute name="timeStyle" %>
<%@ attribute name="pattern" %>
<%@ attribute name="type" %> <%-- date|time|both|timestamp --%>
<%@ attribute name="date" type="java.util.Date" %> <%-- date object, overrides content --%>
<%@ tag import="java.util.Date" %>
<%@ tag import="java.util.GregorianCalendar" %>
<%@ tag import="java.text.SimpleDateFormat" %>
<%@ tag import="java.text.ParseException" %>

<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<fmt:setLocale value="${sessionScope.userLocale}"/>
<fmt:setBundle basename="ewi18n.core.gui" var="guiBundle" scope="page"/>
<c:choose>
  <c:when test="${not empty date}">
    <c:set var="pdate" value="${date}" />
  </c:when>
  <c:otherwise>
    <util:parseDate var="pdate" pattern="${pattern}"><jsp:doBody/></util:parseDate>
  </c:otherwise>
</c:choose>

<c:choose>
  <c:when test="${not empty dateStyle}">
    <fmt:formatDate dateStyle="${dateStyle}" timeStyle="short" value="${pdate}" />
  </c:when>
  <c:when test="${not empty type}">
    <c:choose>
      <c:when test="${type eq 'timestamp'}">
        <fmt:formatDate pattern="yyyyMMdd" value="${pdate}"/>        
      </c:when>
      <c:when test="${type eq 'timestamplong'}">
        <fmt:formatDate pattern="yyyyMMddHHmmss" value="${pdate}"/>        
      </c:when>
      <c:otherwise>
        <fmt:formatDate type="${type}" dateStyle="short" timeStyle="short" value="${pdate}" />
      </c:otherwise>
    </c:choose>
  </c:when>
  <c:otherwise>
    <fmt:formatDate type="both" dateStyle="short" value="${pdate}" />
  </c:otherwise>
</c:choose>
