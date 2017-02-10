<?xml version="1.0"?>
<!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
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
  <h2><fmt:message key="copy_calendar"/></h2>


  <c:choose>
    <c:when test="${not empty param.copy_calendar_no}">
      <c:redirect url="index.jsp"/>
    </c:when>

    <c:when test="${(not empty param.copy_calendar_yes) and (not empty param.year) and (not empty param.dest_year)}">
      <admin:adminResult>
        <admin:copyCalendar sourceYear="${param.year}" destYear="${param.dest_year}"/>
      </admin:adminResult>
      <p><a href="index.jsp"><fmt:message key="back_to_calendars"/></a></p>
    </c:when>

    <c:otherwise>

      <h3><fmt:message key="source_calendar_info"/></h3>
      <table>
        <tr>
          <td><fmt:message key="source_calendar_year"/></td>
          <td>${param.year}</td>
        </tr>
      </table>

      <h3><fmt:message key="dest_calendar_info"/></h3>
      <form method="get">
        <input type="hidden" name="year" value="${param.year}"/>
        <table>
          <tr>
            <td><fmt:message key="dest_calendar_year"/></td>
            <td><input type="text" name="dest_year"/><c:if test="${not empty param.copy_calendar_yes}"> <fmt:message key="required_field"/></c:if></td>
          </tr>
        </table>
        <div class="query">
          <p><fmt:message key="copy_calendar_are_you_sure"/></p>
          <input type="submit" name="copy_calendar_yes" value="<fmt:message key='yes'/>"/>
          <input type="submit" name="copy_calendar_no" value="<fmt:message key='no'/>"/>
        </div>
      </form>

    </c:otherwise>
  </c:choose>

 </div>
