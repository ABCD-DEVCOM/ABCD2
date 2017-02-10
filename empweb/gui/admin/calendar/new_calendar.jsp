<?xml version="1.0"?>
<!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>

-->
<div class="middle homepage">
  <h1><fmt:message key="confirmation"/></h1>
  <h2><fmt:message key="new_calendar"/></h2>


  <c:choose>
    
    <c:when test="${not empty param.new_calendar_no}">
      <c:redirect url="index.jsp"/>
    </c:when>
    
    <c:when test="${(not empty param.new_calendar_yes) and (not empty param.year)}">
      <admin:adminResult>
        <admin:newCalendar year="${param.year}"/>
      </admin:adminResult> 
      <p><a href="index.jsp"><fmt:message key="back_to_calendars"/></a></p>
    </c:when>
    
    <c:otherwise>
      <h3><fmt:message key="new_calendar_info"/></h3>
      <form method="get">
        <table>
          <tr>
            <td><fmt:message key="calendar_year"/></td>
            <td><input type="text" name="year"/><c:if test="${not empty param.new_calendar_yes}"> <fmt:message key="required_field"/></c:if></td>
          </tr>
        </table>
        <div class="query">
          <p><fmt:message key="new_calendar_are_you_sure"/></p>
          <input type="submit" name="new_calendar_yes" value="<fmt:message key='yes'/>"/>
          <input type="submit" name="new_calendar_no" value="<fmt:message key='no'/>"/>
        </div>
      </form>
    </c:otherwise>
  </c:choose>

 </div>
