<?xml version="1.0"?><!--
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%--
/* suspension.tag: Displays the information of a Suspension defined in
 *           the suspension schema http://kalio.net/empweb/schema/suspension/v1
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
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
-->
<fmt:setBundle basename="ewi18n.local.display" scope="page"/>

<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="s" value="http://kalio.net/empweb/schema/suspension/v1" />

<c:set var="rootName"><jxp:out  cnode="${doc}" select="local-name()" nsmap="${nsm}" /></c:set>
<c:set var="select">
  <c:choose>
    <c:when test="${rootName eq 'suspension'}">.</c:when>
    <c:otherwise>//s:suspension</c:otherwise>
  </c:choose>
</c:set>

<c:set var="suspension_type" value="suspension_info" />

  <c:choose>
    <c:when test="${not empty ptr['s:cancel/@id']}">
      <c:set var="suspension_type" value="suspension_cancellation" />
    </c:when>
    <c:otherwise>
      <c:set var="suspension_type" value="suspension_issued" />
    </c:otherwise>
  </c:choose>

<jxp:forEach cnode="${doc}" var="ptr" select="${select}" nsmap="${nsm}">

  <h4><fmt:message key="${suspension_type}"/></h4>

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
              ${ptr['s:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['s:userDb']})</c:if>
          </c:when>
          <c:otherwise>
            <a href="${sessionScope.absoluteContext}/trans/query/user_status_result.jsp?user_id=${ptr['s:userId']}&amp;user_db=${ptr['s:userDb']}">
              ${ptr['s:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['s:userDb']})</c:if>
            </a>
          </c:otherwise>
        </c:choose>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="suspension_creation_date"/>: </td>
      <td>
        <util:formatDate type="both">${ptr['s:date']}</util:formatDate>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="suspension_type"/>: </td>
      <td>${ptr['s:type']}</td>
    </tr>
    <tr>
      <td><fmt:message key="days_suspended"/>: </td>
      <td><fmt:formatNumber>${ptr['s:daysSuspended']}</fmt:formatNumber></td>
    </tr>
    <tr>
      <td><fmt:message key="suspended_from"/>: </td>
      <td><util:formatDate>${ptr['s:startDate']}</util:formatDate></td>
    </tr>
    <tr>
      <td><fmt:message key="suspended_until"/>: </td>
      <td><util:formatDate>${ptr['s:endDate']}</util:formatDate></td>
    </tr>
    <tr>
      <td><fmt:message key="obs"/>: </td>
      <td>${ptr['s:obs']}</td>
    </tr>
    <tr>
      <td><fmt:message key="location"/>: </td>
      <td>${ptr['s:location']}</td>
    </tr>
    <tr>
      <td><fmt:message key="operator_id"/>: </td>
      <td>${ptr['s:operator/@id']}</td>
    </tr>
    <c:if test="${not empty ptr['s:cancel/@id']}">
      <tr>
        <td><fmt:message key="cancel_id"/>: </td>
        <td><a href="${sessionScope.absoluteContext}/trans/query/view_transaction_details.jsp?transaction_id=${ptr['s:cancel/@id']}">${ptr['s:cancel/@id']}</a></td>
      </tr>
    </c:if>

    <!-- Object Section -->
    <c:if test="${not empty ptr['s:object/s:copyId']}">
      <tr>
        <td><fmt:message key="copy_id"/>: </td>
        <td>
          <c:choose>
            <c:when test="${with_links eq 'false'}">
              ${ptr['s:object/s:copyId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['s:object/s:objectDb']}">(${ptr['s:object/s:objectDb']})</c:if>
            </c:when>
            <c:otherwise>
              <a href="${sessionScope.absoluteContext}/trans/query/copy_status_result.jsp?copy_id=${ptr['s:object/s:copyId']}&amp;object_db=${ptr['s:object/s:objectDb']}">
                ${ptr['s:object/s:copyId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['s:object/s:objectDb']}">(${ptr['s:object/s:objectDb']})</c:if>
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
              ${ptr['s:object/s:recordId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['s:object/s:objectDb']}">(${ptr['s:object/s:objectDb']})</c:if>
            </c:when>
            <c:otherwise>
              <a href="${sessionScope.absoluteContext}/trans/query/record_status_result.jsp?record_id=${ptr['s:object/s:recordId']}&amp;object_db=${ptr['s:object/s:objectDb']}">
                ${ptr['s:object/s:recordId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['s:object/s:objectDb']}">(${ptr['s:object/s:objectDb']})</c:if>
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
              ${ptr['s:object/s:profile/@id']}
            </c:when>
            <c:otherwise>
              <a href="${sessionScope.absoluteContext}/trans/query/view_profile.jsp?profile_id=${ptr['s:object/s:profile/@id']}">${ptr['s:object/s:profile/@id']}</a>
            </c:otherwise>
          </c:choose>
        </td>
      </tr>
      <tr>
        <td><fmt:message key="loan_date"/>: </td>
        <td>
          <util:formatDate type="both">${ptr['s:object/s:loanStartDate']}</util:formatDate>
        </td>
      </tr>
      <tr>
        <td><fmt:message key="return_date"/>: </td>
        <td>
          <util:formatDate type="both">${ptr['s:object/s:loanEndDate']}</util:formatDate>
        </td>
      </tr>
      <tr>
        <td><fmt:message key="days_overdue"/>: </td>
        <td>${ptr['s:object/s:daysOverdue']}</td>
      </tr>
    </c:if>
  </table>
</jxp:forEach>
