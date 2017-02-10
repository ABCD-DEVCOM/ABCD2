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
<%@ attribute name="showsortlinks" required ="false" %>
<%@ attribute name="urlprefix" required ="false" %>
<%@ attribute name="doc" required="false" type="java.lang.Object" %>
<%@ attribute name="userDoc" required="false" type="java.lang.Object" %>
<%@ attribute name="rowMap" required="false" type="java.util.HashMap" %>
<%@ attribute name="strong" required="false" %>

<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
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
            <fmt:message key="fine_id"/>${(param.sort_by eq 'transactionId')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=type&amp;sort_order=${sort_order}">
            <fmt:message key="fine_type"/>${(param.sort_by eq 'type')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=date&amp;sort_order=${sort_order}">
            <fmt:message key="date"/>${(param.sort_by eq 'date')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=amount&amp;sort_order=${sort_order}">
            <fmt:message key="fine_amount"/>${(param.sort_by eq 'amount')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=paidAmount&amp;sort_order=${sort_order}">
            <fmt:message key="paid_amount"/>${(param.sort_by eq 'paidAmount')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=status&amp;sort_order=${sort_order}">
            <fmt:message key="status"/>${(param.sort_by eq 'status')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
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
        <th><fmt:message key="fine_id"/></th>
        <th><fmt:message key="fine_type"/></th>
        <th><fmt:message key="date"/></th>
        <th><fmt:message key="fine_amount"/></th>
        <th><fmt:message key="paid_amount"/></th>
        <th><fmt:message key="status"/></th>
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
        <c:set var="thisFineId">${rowMap["transactionId"]}</c:set>
        <c:set var="thisFineType">${rowMap["type"]}</c:set>
        <c:set var="thisDate">${rowMap["date"]}</c:set>
        <c:set var="thisAmount">${rowMap["amount"]}</c:set>
        <c:set var="thisPaidAmount">${rowMap["paidAmount"]}</c:set>            
        <c:set var="thisObs">${rowMap["obs"]}</c:set>
        <c:set var="thisUserId">${rowMap["userId"]}</c:set>
        <c:set var="thisUserName">${rowMap["userName"]}</c:set>
        <c:set var="thisUserDb">${rowMap["userDb"]}</c:set>

        <c:set var="thisStatus">${rowMap["status"]}</c:set>
      </c:when>

      <%-- USING DOM --%>
      <c:otherwise>
        <jsp:useBean id="nsm" class="java.util.HashMap" />
        <c:set target="${nsm}" property="f" value="http://kalio.net/empweb/schema/fine/v1" />
        <c:set target="${nsm}" property="uinfo" value="http://kalio.net/empweb/schema/users/v1" />

        <c:set var="rootName"><jxp:out  cnode="${doc}" select="local-name()" nsmap="${nsm}" /></c:set>
        <c:set var="select">
          <c:choose>
            <c:when test="${rootName eq 'fine'}">.</c:when>
            <c:otherwise>//f:fine</c:otherwise>
          </c:choose>
        </c:set>
        <jxp:set cnode="${doc}" var="ptr" select="${select}" nsmap="${nsm}"/>

        <c:set var="thisFineId">${ptr['@id']}</c:set>
        <c:set var="thisFineType">${ptr['f:type']}</c:set>
        <c:set var="thisDate">${ptr['f:date']}</c:set>
        <c:set var="thisAmount">${ptr['f:amount']}</c:set>
        <c:set var="thisPaidAmount">${ptr['f:paid/f:amount']}</c:set>
        <c:set var="thisObs">${ptr['f:obs']}</c:set>
        <c:set var="thisUserId">${ptr['f:userId']}</c:set>
        <jxp:set var="thisUserName" cnode="${userDoc}" select="//uinfo:name" nsmap="${nsm}"/>
        <c:set var="thisUserDb">${ptr['f:userDb']}</c:set>

      </c:otherwise>
    </c:choose>

    <%-- output an open row line --%>
    <td>
      <c:if test="${'true' eq strong}"><strong></c:if>
      <a href="../../trans/query/fine_status_result.jsp?fine_id=${thisFineId}">${thisFineId}</a>
      <c:if test="${'true' eq strong}"></strong></c:if>
    </td>
    <td>${thisFineType}</td>
    <td>
      <util:formatDate pattern="yyyyMMddHHmmss">${thisDate}</util:formatDate>
    </td>
    <td align="right">
      <c:choose>
        <c:when test="${thisAmount ne '' and thisAmount ne '0'}">
          <dsp:formatAmount>${thisAmount}</dsp:formatAmount>
        </c:when>
        <c:otherwise></c:otherwise>
      </c:choose>
    </td>
    <td align="right">
      <c:choose>
        <c:when test="${thisPaidAmount ne '' and thisPaidAmount ne '0'}">
          <a href="../../trans/query/fine_status_result.jsp?fine_id=${thisFineId}">
            <dsp:formatAmount>${thisPaidAmount}</dsp:formatAmount>
          </a>
        </c:when>
        <c:otherwise></c:otherwise>
      </c:choose>
    </td>

    <td ${thisStatus eq 'active' ? 'class="warn"' : ''}>
      <c:if test="${not empty thisStatus}">
        <fmt:message key="${thisStatus}"/>
      </c:if>
    </td>

    <td>${thisObs}</td>
    <td><%-- user id--%>
      <a href="../../trans/query/user_status_result.jsp?user_id=${thisUserId}&amp;user_db=${thisUserDb}">
        ${thisUserId}
        <c:if test="${not config['ew.hide_user_db']}">(${thisUserDb})</c:if>
      </a>
    </td>
    <td>${thisUserName}</td>


  </c:otherwise>
</c:choose>
