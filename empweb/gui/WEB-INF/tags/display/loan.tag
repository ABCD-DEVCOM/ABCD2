<?xml version="1.0"?><!--
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%--
/* loan.tag: Displays the information of a Loan defined in
 *           the loan schema http://kalio.net/empweb/schema/loan/v1
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
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
-->
<fmt:setBundle basename="ewi18n.local.display" scope="page"/>

<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="l" value="http://kalio.net/empweb/schema/loan/v1" />

<c:set var="rootName"><jxp:out  cnode="${doc}" select="local-name()" nsmap="${nsm}" /></c:set>
<c:set var="select">
  <c:choose>
    <c:when test="${rootName eq 'loan'}">.</c:when>
    <c:otherwise>//l:loan</c:otherwise>
  </c:choose>
</c:set>




<jxp:forEach cnode="${doc}" var="ptr" select="${select}" nsmap="${nsm}">

  <h4><fmt:message key="loan_info"/></h4>

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
            ${ptr['l:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['l:userDb']})</c:if>
          </c:when>
          <c:otherwise>
            <a href="${sessionScope.absoluteContext}/trans/query/user_status_result.jsp?user_id=${ptr['l:userId']}&amp;user_db=${ptr['l:userDb']}">
              ${ptr['l:userId']}  <c:if test="${not config['ew.hide_user_db']}">(${ptr['l:userDb']})</c:if>
            </a>
          </c:otherwise>
        </c:choose>
      </td>
    </tr>

    <tr>
      <td><fmt:message key="copy_id"/>: </td>
      <td>
        <c:choose>
          <c:when test="${with_links eq 'false'}">
            ${ptr['l:copyId']} <c:if test="${not config['ew.hide_object_db']}">(${ptr['l:objectDb']})</c:if>
          </c:when>
          <c:otherwise>
            <a href="${sessionScope.absoluteContext}/trans/query/copy_status_result.jsp?copy_id=${ptr['l:copyId']}&amp;object_db=${ptr['l:objectDb']}">
              ${ptr['l:copyId']} <c:if test="${not config['ew.hide_object_db']}">(${ptr['l:objectDb']})</c:if>
            </a>
          </c:otherwise>
        </c:choose>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="profile" />: </td>
      <td>
        <c:choose>
          <c:when test="${with_links eq 'false'}">
            ${ptr['l:profile/@id']}
          </c:when>
          <c:otherwise>
            <a href="${sessionScope.absoluteContext}/trans/query/view_profile.jsp?profile_id=${ptr['l:profile/@id']}">${ptr['l:profile/@id']}</a>
          </c:otherwise>
        </c:choose>
      </td>
    </tr>
    <tr>
      <td><fmt:message key="date"/>: </td>
      <td><util:formatDate type="both">${ptr['l:startDate']}</util:formatDate></td>
    </tr>
    <tr>
      <td><fmt:message key="end_date"/>: </td>
      <td><util:formatDate type="both">${ptr['l:endDate']}</util:formatDate></td>
    </tr>
    <tr>
      <td><fmt:message key="location"/>: </td>
      <td>${ptr['l:location']}</td>
    </tr>
    <tr>
      <td><fmt:message key="operator_id"/>: </td>
      <td>${ptr['l:operator/@id']}</td>
    </tr>
    <c:if test="${not empty ptr['l:reservation/@id']}">
      <tr>
        <td><fmt:message key="reservation_id"/>:</td>
        <td>
          <c:choose>
            <c:when test="${with_links eq 'false'}">
              ${ptr['l:reservation/@id']}
            </c:when>
            <c:otherwise>
              <a href="${sessionScope.absoluteContext}/trans/query/view_transaction_details.jsp?transaction_id=${ptr['l:reservation/@id']}">
                ${ptr['l:reservation/@id']}
              </a>
            </c:otherwise>
          </c:choose>
        </td>
      </tr>
    </c:if>
  </table>
</jxp:forEach>
