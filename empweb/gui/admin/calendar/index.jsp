<?xml version="1.0"?> <!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%--
/*
 * Copyright 2004-2006 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 */
--%>
-->

<div class="middle homepage">
  <h1><fmt:message key="calendar_admin"/></h1>
  <h2><fmt:message key="calendar_list"/></h2>


  <x:parse var="doc">
<%--    <admin:adminResult> --%>
      <admin:getCalendars/>
<%--    </admin:adminResult> --%>
  </x:parse>


  <table id="result">
    <tr>
      <th><fmt:message key="year"/></th>
      <th><fmt:message key="actions"/></th>
    </tr>

    <jsp:useBean id="nsm" class="java.util.HashMap" />
    <c:set target="${nsm}" property="c" value="http://kalio.net/empweb/schema/calendar/v1" />

    <jxp:forEach
      cnode="${doc}"
      var="ptr"
      select="//c:calendars/c:calendar"
      nsmap="${nsm}">

      <tr>
        <td>${ptr['c:year/@value']}</td>
        <td>
          <a href="view_calendar.jsp?year=${ptr['c:year/@value']}">
            <fmt:message key="view"/>
          </a> |
          <a href="edit_calendar.jsp?year=${ptr['c:year/@value']}">
            <fmt:message key="edit"/>
            </a> |
          <a href="copy_calendar.jsp?year=${ptr['c:year/@value']}">
            <fmt:message key="copy"/>
          </a> |
          <a href="delete_calendar.jsp?year=${ptr['c:year/@value']}">
            <fmt:message key="delete"/>
          </a>
        </td>
      </tr>
    </jxp:forEach>

      <tr>
        <td><!-- empty --></td>
        <td><a href="new_calendar.jsp"><fmt:message key="calendar_create_new_calendar" /></a></td>
      </tr>
  </table>

</div>
