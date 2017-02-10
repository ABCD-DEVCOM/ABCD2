<?xml version="1.0"?>
<!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>

-->
<div id="content">
  <h1><fmt:message key="confirmation"/></h1>
  <h2><fmt:message key="delete_calendar"/></h2>


  <c:choose>
    <%-- no button pressed --%>
    <c:when test="${not empty param.delete_calendar_no}">
      <c:redirect url="index.jsp"/>
    </c:when>

    <%-- yes button pressed --%>
    <c:when test="${(not empty param.delete_calendar_yes) and (not empty param.year)}">
      <admin:adminResult>
        <admin:deleteCalendar year="${param.year}"/>
      </admin:adminResult>
      <p><a href="index.jsp"><fmt:message key="back_to_calendars"/></a></p>
    </c:when>

    <%-- delete calendar page content --%>
    <c:otherwise>
      <form method="get">
  <input type="hidden" name="year" value="${param.year}"/>
  <table>
    <tr>
      <td><fmt:message key="calendar_year"/></td>
      <td>${param.year}</td>
    </tr>
  </table>
  <div class="query">
    <p><fmt:message key="delete_calendar_are_you_sure"/></p>
    <input type="submit" name="delete_calendar_yes" value="<fmt:message key='yes'/>"/>
    <input type="submit" name="delete_calendar_no" value="<fmt:message key='no'/>"/>
  </div>
      </form>


    </c:otherwise>
  </c:choose>

 </div>
