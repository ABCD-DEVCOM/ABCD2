<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
-->
<div class="middle homepage">
  <h1><fmt:message key="global_status"/></h1>

  <h2><fmt:message key="global_status_figures"/></h2>
  <ul>
    <li><a href="include_report.jsp?report_type=status&amp;report_name=allLibrariesStats"><fmt:message key="all_libraries_status_figures"/></a></li>
  </ul>

  <h2><fmt:message key="global_status_reports"/></h2>
  <ul>
    <li><a href="include_report.jsp?report_type=status&amp;report_name=loans"><fmt:message key="current_loans"/></a></li>
    <li><a href="include_report.jsp?report_type=status&amp;report_name=lateLoans"><fmt:message key="overdue_objects"/></a></li>
    <li><a href="include_report.jsp?report_type=status&amp;report_name=suspensions"><fmt:message key="active_suspensions"/></a></li>
    <li><a href="include_report.jsp?report_type=status&amp;report_name=fines"><fmt:message key="pending_fines"/></a></li>
    <%-- <li><a href="include_report.jsp?report_type=status&amp;report_name=reservations"><fmt:message key="current_reservations"/></a></li> --%>
  </ul>

</div>
