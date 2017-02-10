<?xml version="1.0"?><!--
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag import="java.util.*" %>
<%@ tag import="org.apache.commons.jxpath.*" %>
<%@ tag import="org.w3c.dom.*" %>

<%@ tag body-content="empty" %>
<%@ attribute name="doc" required="true" type="java.lang.Object" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
-->
<fmt:setBundle basename="ewi18n.local.display" scope="page"/>

<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="w" value="http://kalio.net/empweb/schema/wait/v1" />

<c:set var="rootName"><jxp:out  cnode="${doc}" select="local-name()" nsmap="${nsm}" /></c:set>
<c:set var="select">
  <c:choose>
    <c:when test="${rootName eq 'wait'}">.</c:when>
    <c:otherwise>//w:wait</c:otherwise>
  </c:choose>
</c:set>


<jxp:forEach cnode="${doc}" var="ptr" select="${select}" nsmap="${nsm}">

  <h4><fmt:message key="wait_info"/></h4>

  <table id="result">
    <tr>
      <td><fmt:message key="user_id"/>: </td>
      <td>${ptr['w:userId']}
        <c:if test="${not config['ew.hide_user_db'] and not empty ptr['w:userDb']}">(${ptr['w:userDb']})</c:if>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="record_id"/>: </td>
      <td>${ptr['w:recordId']}
        <c:if test="${not config['ew.hide_object_db'] and not empty ptr['w:objectDb']}">(${ptr['w:objectDb']})</c:if>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="profile"/>: </td>
      <td>${ptr['w:profile/@id']}</td>
    </tr>
    <tr>
      <td><fmt:message key="date"/>: </td>
      <td><util:formatDate type="both">${ptr['w:date']}</util:formatDate></td>
    </tr>
    <tr>
      <td><fmt:message key="obs"/>: </td>
      <td>${ptr['w:obs']}</td>
    </tr>
    <tr>
      <td><fmt:message key="location"/>: </td>
      <td>${ptr['w:location']}</td>
    </tr>
    <tr>
      <td><fmt:message key="operator_id"/>: </td>
      <td>${ptr['w:operator/@id']}</td>
    </tr>

    <c:if test="${not empty ptr['w:cancel/@id']}">
      <tr>
        <td><fmt:message key="cancel_id"/>: </td>
        <td>${ptr['w:cancel/@id']}</td>
      </tr>
    </c:if>
    <c:if test="${not empty ptr['w:cancelDate']}">
      <tr>
        <td><fmt:message key="cancel_date"/>: </td>
        <td><util:formatDate type="both">${ptr['w:cancelDate']}</util:formatDate></td>
      </tr>
    </c:if>
  </table>
</jxp:forEach>
