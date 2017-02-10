<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%--
/* 
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->

<div class="middle homepage">

  <x:parse var="doc">
    <admin:getPipelines />
  </x:parse>

  <jsp:useBean id="nsm" class="java.util.HashMap" />
  <c:set target="${nsm}" property="t" value="http://kalio.net/empweb/schema/transaction/v1" />

  <h1><fmt:message key="pipelines_admin"/></h1>

  <h2><fmt:message key="configuration_pipelines_list"/></h2>
  <table id="result">
    <tr>
      <th><fmt:message key="pipeline_name"/></th>
      <th><fmt:message key="configuration_file"/></th>
      <th><fmt:message key="pipeline_actions"/></th>
    </tr>

    <jxp:forEach
      cnode="${doc}"
      var="ptr"
      select="//t:transaction[@type='configuration']"
      nsmap="${nsm}">

      <tr> 
	<td>${ptr['@name']}</td>
	<td>${ptr['@path']}</td>
	<td>
	  <a href="edit_pipeline.jsp?name=${ptr['@name']}">
	    <fmt:message key="edit"/>
	  </a>
	</td>
      </tr>
    </jxp:forEach>
  </table>


  <h2><fmt:message key="transaction_pipelines_list"/></h2>
  <table id="result">
    <tr>
      <th><fmt:message key="pipeline_name"/></th>
      <th><fmt:message key="configuration_file"/></th>
      <th><fmt:message key="pipeline_actions"/></th>
    </tr>

    <jxp:forEach
      cnode="${doc}"
      var="ptr"
      select="//t:transaction[@type='transaction']"
      nsmap="${nsm}">

      <tr> 
	<td>${ptr['@name']}</td>
	<td>${ptr['@path']}</td>
	<td>
	  <a href="edit_pipeline.jsp?name=${ptr['@name']}">
	    <fmt:message key="edit"/>
	  </a>
	</td>
      </tr>
    </jxp:forEach>
  </table>

  <h2><fmt:message key="statistics_pipelines_list"/></h2>
  <table id="result">
    <tr>
      <th><fmt:message key="pipeline_name"/></th>
      <th><fmt:message key="configuration_file"/></th>
      <th><fmt:message key="pipeline_actions"/></th>
    </tr>

    <jxp:forEach
      cnode="${doc}"
      var="ptr"
      select="//t:transaction[@type='statistic']"
      nsmap="${nsm}">

      <tr> 
	<td>${ptr['@name']}</td>
	<td>${ptr['@path']}</td>
	<td>
	  <a href="edit_pipeline.jsp?name=${ptr['@name']}">
	    <fmt:message key="edit"/>
	  </a>
	</td>
      </tr>
    </jxp:forEach>
  </table>

</div>
