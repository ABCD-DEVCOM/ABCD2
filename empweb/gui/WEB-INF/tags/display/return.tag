<?xml version="1.0"?><!--
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%--
/* return.tag: Displays the information of a Return defined in
 *           the return schema http://kalio.net/empweb/schema/return/v1
 *
 * attribute: doc (required)
 *    User information received as a a dom or as a context node
 *    constructed  by the commons/jxp tags set or forEach.
 *
 * attribute: with_links (optional) (default true)
 *    * output information with links to user and object info
 */
--%>
<%@ tag import="java.util.*" %>
<%@ tag import="org.apache.commons.jxpath.*" %>
<%@ tag import="org.w3c.dom.*" %>

<%@ tag body-content="empty" %>
<%@ attribute name="doc" required="true" type="java.lang.Object" %>
<%@ attribute name="with_links" required="false" %>

<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
-->
<fmt:setBundle basename="ewi18n.local.display" scope="page"/>

<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="r" value="http://kalio.net/empweb/schema/return/v1" />

<c:set var="rootName"><jxp:out  cnode="${doc}" select="local-name()" nsmap="${nsm}" /></c:set>
<c:set var="select">
  <c:choose>
    <c:when test="${rootName eq 'return'}">.</c:when>
    <c:otherwise>//r:return</c:otherwise>
  </c:choose>
</c:set>


<jxp:forEach cnode="${doc}" var="ptr" select="${select}" nsmap="${nsm}">

  <h4><fmt:message key="return_info"/></h4>

  <table id="result">
    <tr>
      <td><fmt:message key="transaction_id"/>:</td>
      <td>
        <c:choose>
          <c:when test="${with_links eq 'false'}">
            ${ptr['@id']}
          </c:when>
          <c:otherwise>
            <a href="${sessionScope.absoluteContext}/trans/query/view_transaction_details.jsp?transaction_id=${ptr['@id']}">
              ${ptr['@id']}
            </a>
          </c:otherwise>
        </c:choose>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="user_id"/>: </td>
      <td>
        <c:choose>
          <c:when test="${with_links eq 'false'}">
            ${ptr['r:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['r:userDb']})</c:if>
          </c:when>
          <c:otherwise>
            <a href="${sessionScope.absoluteContext}/trans/query/user_status_result.jsp?user_id=${ptr['r:userId']}&amp;user_db=${ptr['r:userDb']}">
            ${ptr['r:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['r:userDb']})</c:if></a>
          </c:otherwise>
        </c:choose>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="copy_id"/>: </td>
      <td>
        <c:choose>
          <c:when test="${with_links eq 'false'}">
            ${ptr['r:copyId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['r:objectDb']}">(${ptr['r:objectDb']})</c:if>
          </c:when>
          <c:otherwise>
            <a href="${sessionScope.absoluteContext}/trans/query/copy_status_result.jsp?copy_id=${ptr['r:copyId']}&amp;object_db=${ptr['r:objectDb']}">
              ${ptr['r:copyId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['r:objectDb']}">(${ptr['r:objectDb']})</c:if>
            </a>
          </c:otherwise>
        </c:choose>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="record_id"/>: </td>
      <td>
        <c:choose>
          <c:when test="${with_links eq 'false'}">
            ${ptr['r:recordId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['r:objectDb']}">(${ptr['r:objectDb']})</c:if>
          </c:when>
          <c:otherwise>
            <a href="${sessionScope.absoluteContext}/trans/query/record_status_result.jsp?record_id=${ptr['r:recordId']}&amp;object_db=${ptr['r:objectDb']}">
              ${ptr['r:recordId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['r:objectDb']}">(${ptr['r:objectDb']})</c:if>
            </a>
          </c:otherwise>
        </c:choose>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="loan_id"/>: </td>
      <td>
        <c:choose>
          <c:when test="${with_links eq 'false'}">
            ${ptr['r:loan/@id']}
          </c:when>
          <c:otherwise>
            <a href="${sessionScope.absoluteContext}/trans/query/transaction_details.jsp?transaction_id=${ptr['r:loan/@id']}">
              ${ptr['r:loan/@id']}
            </a>
          </c:otherwise>
        </c:choose>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="profile"/>: </td>
      <td>
        <c:choose>
          <c:when test="${with_links eq 'false'}">
            ${ptr['r:profile/@id']}
          </c:when>
          <c:otherwise>
            <a href="${sessionScope.absoluteContext}/trans/query/view_profile.jsp?profile_id=${ptr['r:profile/@id']}">${ptr['r:profile/@id']}</a>
          </c:otherwise>
        </c:choose>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="loan_date"/>: </td>
      <td>
        <util:formatDate type="both">${ptr['r:loanDate']}</util:formatDate>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="return_date"/>: </td>
      <td>
        <util:formatDate type="both">${ptr['r:returnDate']}</util:formatDate>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="location"/>: </td>
      <td>${ptr['r:location']}</td>
    </tr>
    <tr>
      <td><fmt:message key="operator_id"/>: </td>
      <td>${ptr['r:operator/@id']}</td>
    </tr>

  </table>
</jxp:forEach>
