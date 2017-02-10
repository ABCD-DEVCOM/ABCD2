<?xml version="1.0"?><!-- 
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="rep" tagdir="/WEB-INF/tags/reports" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->


<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="tr" value="http://kalio.net/empweb/schema/transactionresult/v1" />

<%-- THE CONTENT --%>

<%-- CONTENT TABLE --%>

  <x:parse varDom="doc">
    <trans:doTransaction name="stat-status-counts">
      <transactionExtras>
        <params>
          <param name="operatorLocation">${sessionScope.library}</param>
          <param name="onlyCounts">true</param>
        </params>
      </transactionExtras>
    </trans:doTransaction>
  </x:parse>

  <h2><fmt:message key="this_library_status_figures"><fmt:param value="${sessionScope.library}"/></fmt:message></h2>
  <h3><fmt:message key="library"/> : ${sessionScope.library}</h3>
  <table>
    <th><fmt:message key="lent_books"/></th>
    <th><fmt:message key="overdue_objects"/></th>
    <th><fmt:message key="active_suspensions"/></th>
    <th><fmt:message key="pending_fines"/></th>

    <tr>
      <td><a href="include_report.jsp?report_type=status&amp;report_name=loans&amp;library=${sessionScope.library}">
        <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='loansCount']"/></strong>
      </a></td>
      
      <td><a href="include_report.jsp?report_type=status&amp;report_name=lateLoans&amp;library=${sessionScope.library}">
        <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='lateLoansCount']"/></strong>
      </a></td>
      
      <td><a href="include_report.jsp?report_type=status&amp;report_name=suspensions&amp;library=${sessionScope.library}">
        <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='suspensionsCount']"/></strong>
      </a></td>

      <td><a href="include_report.jsp?report_type=status&amp;report_name=fines&amp;library=${sessionScope.library}">
        <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='finesCount']"/></strong>
      </a></td>
    </tr>
  </table>



