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
<%@ attribute name="rowMap" required="false" type="java.util.HashMap" %>
<%@ attribute name="isheader" required="false" %>
<%@ attribute name="showsortlinks" required ="false" %>
<%@ attribute name="urlprefix" required ="false" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
-->

<fmt:setBundle basename="ewi18n.local.display" scope="page"/>

<c:choose>

  <c:when test="${not empty isheader}">
    <c:choose>
      <c:when test="${not empty showsortlinks}">
        <c:set var="thisurlprefix" value="${(not empty urlprefix)?urlprefix:'?'}"/>
        <c:set var="sort_order" value="${(param.sort_order eq 'ascending')?'descending':'ascending'}"/>

        <th>
	  <a href="${thisurlprefix}&amp;sort_by=recordTitle&amp;sort_order=${sort_order}">
            <fmt:message key="record_title"/>${(param.sort_by eq 'recordTitle')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
	</th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=copyId&amp;sort_order=${sort_order}">
            <fmt:message key="copy_id"/>${(param.sort_by eq 'copyId')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=recordId&amp;sort_order=${sort_order}">
            <fmt:message key="record_id"/>${(param.sort_by eq 'recordId')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>        
        <th>
          <a href="${thisurlprefix}&amp;sort_by=startDate&amp;sort_order=${sort_order}">
            <fmt:message key="loan_date"/>${(param.sort_by eq 'startDate')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a> 
        </th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=endDate&amp;sort_order=${sort_order}">
            <fmt:message key="return_date"/>${(param.sort_by eq 'endDate')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a> 
        </th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=location&amp;sort_order=${sort_order}">
            <fmt:message key="location"/>${(param.sort_by eq 'location')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
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
        <th><fmt:message key="record_title"/></th>
        <th><fmt:message key="copy_id"/></th>
        <th><fmt:message key="record_id"/></th>
        <th><fmt:message key="loan_date"/></th>
        <th><fmt:message key="return_date"/></th>
        <th><fmt:message key="user_id"/></th>
        <th><fmt:message key="user_name"/></th>
      </c:otherwise> 
    </c:choose>
  </c:when>


  <c:otherwise>

  <%-- A ROW --%>
  <c:set var="thisTitle">${rowMap["recordTitle"]}</c:set>
  <c:set var="thisUserId">${rowMap["userId"]}</c:set>
  <c:set var="thisUserName">${rowMap["userName"]}</c:set>
  <c:set var="thisUserDb">${rowMap["userDb"]}</c:set>
  <c:set var="thisLocation">${rowMap["location"]}</c:set>
  <c:set var="thisRecordId">${rowMap["recordId"]}</c:set>
  <c:set var="thisCopyId">${rowMap["copyId"]}</c:set>
  <c:set var="thisObjectDb">${rowMap["objectDb"]}</c:set>
  <c:set var="thisCopyLocation">${rowMap["copyLocation"]}</c:set>
  <c:set var="thisStartDate">${rowMap["startDate"]}</c:set>
  <c:set var="thisEndDate">${rowMap["endDate"]}</c:set>

    <%-- output an open row line --%>
    <td> <%-- record title --%>
      ${fn:escapeXml(thisTitle)}
    </td>

    <td><%-- copy id--%>
      ${thisCopyLocation}&nbsp;${thisCopyId}
      <c:if test="${not config['ew.hide_object_db']}">(${thisObjectDb})</c:if>
    </td>

    <td><%-- record id --%>
      <a href="record_status_result.jsp?record_id=${thisRecordId}&amp;object_db=${thisObjectDb}">
        ${thisRecordId} <c:if test="${not config['ew.hide_object_db']}">(${thisObjectDb})</c:if>
      </a>
    </td>

    <td><%--loan date --%>
      <util:formatDate pattern="yyyyMMddHHmmss">${thisStartDate}</util:formatDate>
    </td>
    
    <%-- return date --%>
    <util:isLate var="late">${thisEndDate}</util:isLate>
    <td
      <c:if test="${late eq 'true'}">
        class="warn"
      </c:if> >
      <util:formatDate pattern="yyyyMMddHHmmss">${thisEndDate}</util:formatDate>
    </td>

    <td><%-- location --%>
      ${thisLocation}
    </td>

    <td><%-- user id--%>
      <a href="user_status_result.jsp?user_id=${thisUserId}&amp;user_db=${thisUserDb}">
      ${thisUserId}
      <c:if test="${not config['ew.hide_user_db']}">(${thisUserDb})</c:if>
      </a>

    </td>

    <td> <%-- user name --%>
      ${fn:escapeXml(thisUserName)}
    </td>

  </c:otherwise>
</c:choose>

