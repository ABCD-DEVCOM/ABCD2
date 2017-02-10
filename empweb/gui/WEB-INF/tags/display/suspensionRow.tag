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
<%@ attribute name="isheader" required="false" %>
<%@ attribute name="doc" required="false" type="java.lang.Object" %>
<%@ attribute name="showsortlinks" required ="false" %>
<%@ attribute name="urlprefix" required ="false" %>
<%@ attribute name="userDoc" required="false" type="java.lang.Object" %>
<%@ attribute name="rowMap" required="false" type="java.util.HashMap" %>

<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
-->

<fmt:setBundle basename="ewi18n.local.display" scope="page"/>
<c:choose>

  <%-- JUST THE HEADER OF THE TABLE PLEASE --%>
  <%-- output an open row line --%>
  <c:when test="${not empty isheader}">

    <c:choose>
      <c:when test="${not empty showsortlinks}">

        <c:set var="thisurlprefix">?<c:if test="${(not empty urlprefix)}">${urlprefix}</c:if></c:set>
        <c:set var="sort_order" value="${(param.sort_order eq 'ascending')?'descending':'ascending'}"/>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=transactionId&amp;sort_order=${sort_order}">
            <fmt:message key="suspension_id"/>${(param.sort_by eq 'transactionId')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=date&amp;sort_order=${sort_order}">
            <fmt:message key="date"/>${(param.sort_by eq 'date')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=daysSuspended&amp;sort_order=${sort_order}">
            <fmt:message key="duration"/>${(param.sort_by eq 'daysSuspended')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=endDate&amp;sort_order=${sort_order}">
            <fmt:message key="suspended_until"/>${(param.sort_by eq 'endDate')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=obs&amp;sort_order=${sort_order}">
            <fmt:message key="obs"/>${(param.sort_by eq 'obs')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=userId&amp;sort_order=${sort_order}">
            <fmt:message key="user_id"/>${(param.sort_by eq 'userId')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=userName&amp;sort_order=${sort_order}">
            <fmt:message key="user_name"/>${(param.sort_by eq 'userName')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>

      </c:when>

      <c:otherwise>
        <%-- <th><fmt:message key="suspension_type"/></th> --%>
        <th><fmt:message key="suspension_id"/></th>
        <th><fmt:message key="date"/></th>
        <th><fmt:message key="duration"/></th>
        <th><fmt:message key="suspended_until"/></th>
        <th><fmt:message key="obs"/></th>
        <th><fmt:message key="user_id"/></th>
        <th><fmt:message key="user_name"/></th>
      </c:otherwise>
    </c:choose>
  </c:when>

  
  <%-- A ROW --%>
  <c:otherwise>
    <c:choose>

      <%-- USING A MAP --%>
      <c:when test="${ not empty rowMap }">
        <c:set var="thisTransactionId">${rowMap["transactionId"]}</c:set>
        <c:set var="thisDaysSuspended">${rowMap["daysSuspended"]}</c:set>
        <c:set var="thisEndDate">${rowMap["endDate"]}</c:set>
        <c:set var="thisObs">${rowMap["obs"]}</c:set>
        <c:set var="thisUserId">${rowMap["userId"]}</c:set>
        <c:set var="thisUserName">${rowMap["userName"]}</c:set>
        <c:set var="thisUserDb">${rowMap["userDb"]}</c:set>
        <c:set var="thisDate">${rowMap["date"]}</c:set>
      </c:when>

      <%-- USING DOM --%>
      <c:otherwise>
        <jsp:useBean id="nsm" class="java.util.HashMap" />
        <c:set target="${nsm}" property="s" value="http://kalio.net/empweb/schema/suspension/v1" />
        <c:set target="${nsm}" property="uinfo" value="http://kalio.net/empweb/schema/users/v1" />
        
        <c:set var="rootName"><jxp:out cnode="${doc}" select="local-name()" nsmap="${nsm}" /></c:set>
        <c:set var="select">
          <c:choose>
            <c:when test="${rootName eq 'suspension'}">.</c:when>
            <c:otherwise>//s:suspension</c:otherwise>
          </c:choose>
        </c:set>
        <jxp:set cnode="${doc}" var="ptr" select="${select}" nsmap="${nsm}"/>
        
        <c:set var="thisTransactionId">${ptr['@id']}</c:set>
        <c:set var="thisDaysSuspended">${ptr['s:daysSuspended']}</c:set>
        <c:set var="thisEndDate">${ptr['s:endDate']}</c:set>
        <c:set var="thisObs">${ptr['s:obs']}</c:set>
        <c:set var="thisUserDb">${ptr['s:userDb']}</c:set>
        <c:set var="thisDate">${ptr['s:date']}</c:set>

        <c:set var="thisUserId">${ptr['s:userId']}</c:set>
        <c:set var="thisUserName"><jxp:out cnode="${userDoc}" select="//uinfo:name" nsmap="${nsm}" /></c:set>
      </c:otherwise>
    </c:choose>
        
      <%-- output an open row line --%>
        <td>
          <a href="${sessionScope.absoluteContext}/trans/query/view_transaction_details.jsp?transaction_id=${thisTransactionId}">${thisTransactionId}</a>
        </td>
        <td>
          <util:formatDate pattern="yyyyMMddHHmmss">${thisDate}</util:formatDate>
        </td>
        <td>${thisDaysSuspended}</td>
        <td>
          <util:formatDate pattern="yyyyMMddHHmmss">${thisEndDate}</util:formatDate>
        </td>
        <td>${thisObs}</td>
        <td><%-- user id--%>
          <a href="../../trans/query/user_status_result.jsp?user_id=${thisUserId}&amp;user_db=${thisUserDb}">
          ${thisUserId}
          <c:if test="${not config['ew.hide_user_db']}">(${thisUserDb})</c:if>
        </td>
        <td>${thisUserName}</td>


    </c:otherwise>
</c:choose>


