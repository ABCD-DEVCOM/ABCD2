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
<%@ attribute name="with_links" required="false" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
-->
<fmt:setBundle basename="ewi18n.local.display" scope="page"/>

<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="r" value="http://kalio.net/empweb/schema/reservation/v1" />

<c:set var="rootName"><jxp:out  cnode="${doc}" select="local-name()" nsmap="${nsm}" /></c:set>
<c:set var="select">
  <c:choose>
    <c:when test="${rootName eq 'reservation'}">.</c:when>
    <c:otherwise>//r:reservation</c:otherwise>
  </c:choose>
</c:set>

<jxp:forEach cnode="${doc}" var="ptr" select="${select}" nsmap="${nsm}">

  <h4><fmt:message key="reservation_info"/></h4>

  <table id="result">
    <tr>
      <td><fmt:message key="transaction_id"/>:</td>
      <td>${ptr['@id']}</td>
    </tr>
    <tr>
      <td><fmt:message key="user_id"/>: </td>
      <td>
        <c:choose>
          <c:when test="${with_links eq 'true'}">
            <a href="user_status_result.jsp?user_id=${ptr['r:userId']}&amp;user_db=${ptr['r:userDb']}">${ptr['r:userId']} (${ptr['r:userDb']})</a>
          </c:when>
          <c:otherwise>
            ${ptr['r:userId']} (${ptr['r:userDb']})
          </c:otherwise>
        </c:choose>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="record_id"/>: </td>
      <td>
        <c:choose>
          <c:when test="${with_links eq 'true'}">
            <a href="record_status_result.jsp?record_id=${ptr['r:recordId']}&amp;object_db=${ptr['r:objectDb']}">${ptr['r:recordId']} (${ptr['r:objectDb']})</a>
          </c:when>
          <c:otherwise>
            ${ptr['r:recordId']} (${ptr['r:objectDb']})
          </c:otherwise>
        </c:choose>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="volume_id"/>: </td>
      <td>${ptr['r:volumeId']}</td>
    </tr>
    <tr>
      <td><fmt:message key="object_location"/>: </td>
      <td>${ptr['r:objectLocation']}</td>
    </tr>
    <tr>
      <td><fmt:message key="profile"/>: </td>
      <td>
        <c:choose>
          <c:when test="${with_links eq 'true'}">
            <a href="view_profile.jsp?profile_id=${ptr['r:profile/@id']}">${ptr['r:profile/@id']}</a>
          </c:when>
          <c:otherwise>
            ${ptr['r:profile/@id']}
          </c:otherwise>
        </c:choose>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="reservation_start_date"/>: </td>
      <td><util:formatDate>${ptr['r:startDate']}</util:formatDate></td>
    </tr>
    <tr>
      <td><fmt:message key="reservation_end_date"/>: </td>
      <td><util:formatDate>${ptr['r:endDate']}</util:formatDate></td>
    </tr>
    <tr>
      <td><fmt:message key="reservation_expiration_date"/>: </td>
      <td><util:formatDate>${ptr['r:expirationDate']}</util:formatDate></td>
    </tr>
    <tr>
      <td><fmt:message key="operator_id"/>: </td>
      <td>${ptr['r:operator']}</td>
    </tr>
    <tr>
      <td><fmt:message key="location"/>: </td>
      <td>${ptr['r:location']}</td>
    </tr>
  </table>
</jxp:forEach>
