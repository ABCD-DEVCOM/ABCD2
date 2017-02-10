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

  <x:parse varDom="libraries">
    <trans:doTransaction name="conf-getLibraries"/>
  </x:parse> 

  <h2><fmt:message key="all_libraries_stats"/></h2>
  <table>
    <th align="right"><fmt:message key="library"/></th>
    <th align="right"><fmt:message key="lent_books"/></th>
    <th align="right"><fmt:message key="overdue_objects"/></th>
    <th align="right"><fmt:message key="active_suspensions"/></th>
    <th align="right"><fmt:message key="pending_fines"/></th>

    <%-- get stats for each library --%>
    <jxp:forEach cnode="${libraries}" var="libr" select="//tr:library" nsmap="${nsm}">
      <x:parse varDom="doc">
        <trans:doTransaction name="stat-status-counts">
          <transactionExtras>
            <params>
              <param name="useOperatorLocation">true</param>
              <param name="operatorLocation">${libr['@id']}</param>
              <param name="onlyCounts">true</param>
            </params>
        </transactionExtras>
        </trans:doTransaction>
      </x:parse>
      
      <tr>
        <td>
          ${libr['@id']}
        </td>

        <td align="right"><a href="include_report.jsp?report_type=status&amp;report_name=loans&amp;library=${libr['@id']}">
          <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='loansCount']"/></strong>
        </a></td>
        
        <td align="right"><a href="include_report.jsp?report_type=status&amp;report_name=lateLoans&amp;library=${libr['@id']}">
          <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='lateLoansCount']"/></strong>
        </a></td>
        
        <td align="right"><a href="include_report.jsp?report_type=status&amp;report_name=suspensions&amp;library=${libr['@id']}">
          <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='suspensionsCount']"/></strong>
        </a></td>
        
        <td align="right"><a href="include_report.jsp?report_type=status&amp;report_name=fines&amp;library=${libr['@id']}">
        <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='finesCount']"/></strong>
        </a></td>
      </tr>
      
    </jxp:forEach>

    <%-- display totals --%>
    
    <x:parse varDom="doc">
      <trans:doTransaction name="stat-status-counts">
        <transactionExtras>
          <params>
            <param name="useOperatorLocation">false</param>
            <param name="onlyCounts">true</param>
          </params>
        </transactionExtras>
      </trans:doTransaction>
    </x:parse>
    
    <tr>
      <td>
        <strong><fmt:message key="total"/></strong>
      </td>
      
      <td align="right">
        <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='loansCount']"/></strong>
      </td>
      
      <td align="right">
        <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='lateLoansCount']"/></strong>
      </td>
      
      <td align="right">
        <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='suspensionsCount']"/></strong>
      </td>
      
      <td align="right">
        <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='finesCount']"/></strong>
      </td>
    </tr>
  </table>
  
  
  
