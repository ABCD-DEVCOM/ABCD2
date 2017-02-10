<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
-->
<div class="middle homepage">
  <h1><fmt:message key="historic_reports"/></h1>
  <h2><fmt:message key="historic_reports"/></h2>

  <h3><fmt:message key="loans"/></h3>
  <ul>
    <li><a href="include_report.jsp?report_type=hist&amp;report_name=loansByUser"><fmt:message key="historic_loans_by_user"/></a></li>
    <li><a href="include_report.jsp?report_type=hist&amp;report_name=loansByRecord"><fmt:message key="historic_loans_by_record"/></a></li>
    <li><a href="include_report.jsp?report_type=hist&amp;report_name=loansByCopy"><fmt:message key="historic_loans_by_copy"/></a></li>
  </ul>

<%--
  <h3><fmt:message key="reservations"/></h3>
  <ul>
    <li><a href="include_report.jsp?report_type=hist&amp;report_name=reservationsByUser"><fmt:message key="historic_reservations_by_user"/></a></li>
    <li><a href="include_report.jsp?report_type=hist&amp;report_name=reservationsByRecord"><fmt:message key="historic_reservations_by_record"/></a></li>
  </ul>
--%>

  <h3><fmt:message key="fines"/></h3>
  <ul>
    <li><a href="include_report.jsp?report_type=hist&amp;report_name=finesByUser"><fmt:message key="historic_fines_by_user"/></a></li>
  </ul>

  <h3><fmt:message key="suspensions"/></h3>
  <ul>
    <li><a href="include_report.jsp?report_type=hist&amp;report_name=suspensionsByUser"><fmt:message key="historic_suspensions_by_user"/></a></li>
  </ul>

</div>
