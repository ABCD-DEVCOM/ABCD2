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
<%@ attribute name="recordDoc" required="false" type="java.lang.Object" %>
<%@ attribute name="userDoc" required="false" type="java.lang.Object" %>
<%@ attribute name="rowMap" required="false" type="java.util.HashMap" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>

<fmt:setBundle basename="ewi18n.local.display" scope="page"/>
<c:choose>
  <%-- JUST THE HEADER OF THE TABLE PLEASE --%>
  <%-- output an open row line --%>
  <c:when test="${not empty isheader}">
    <c:choose>
      <c:when test="${not empty showsortlinks}">

        <c:set var="thisurlprefix">?<c:if test="${(not empty urlprefix)}">${urlprefix}</c:if></c:set>
        <c:set var="sort_order" value="${(param.sort_order eq 'ascending')?'descending':'ascending'}"/>
        <th>&nbsp;</th>
        <th>
          <a href="${thisurlprefix}&amp;sort_by=transactionId&amp;sort_order=${sort_order}">
            <fmt:message key="loan_id"/>${(param.sort_by eq 'transactionId')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
          </a>
        </th>
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
        <th>&nbsp;</th>
        <th><fmt:message key="loan_id"/></th>
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
    

  <%-- A ROW --%>
  <c:otherwise>      
    <c:choose>

      <%-- USING A MAP --%>
      <c:when test="${ not empty rowMap }">
        <c:set var="thisTransactionId">${rowMap["transactionId"]}</c:set>
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
        <c:set var="thisHistoric">${rowMap["transactionHistoric"]}</c:set>
      </c:when>

      <%-- USING DOM --%>
      <c:otherwise>
        <jsp:useBean id="nsm" class="java.util.HashMap" />
        <c:set target="${nsm}" property="l" value="http://kalio.net/empweb/schema/loan/v1" />
        <c:set target="${nsm}" property="h"     value="http://kalio.net/empweb/schema/holdingsinfo/v1" />
        <c:set target="${nsm}" property="mods"  value="http://www.loc.gov/mods/v3" />
        <c:set target="${nsm}" property="uinfo" value="http://kalio.net/empweb/schema/users/v1" />

        <c:set var="rootName"><jxp:out  cnode="${doc}" select="local-name()" nsmap="${nsm}" /></c:set> 
        <c:set var="select">
          <c:choose>
            <c:when test="${rootName eq 'loan'}">.</c:when>
            <c:otherwise>//l:loan</c:otherwise>
          </c:choose> 
        </c:set> 
        <jxp:set cnode="${doc}" var="ptr" select="${select}" nsmap="${nsm}"/>

        <c:set var="thisTransactionId">${ptr['@id']}</c:set>
        <c:set var="thisCopyId">${ptr['l:copyId']}</c:set>
        <jxp:set var="thisTitle" cnode="${recordDoc}"  select="//mods:title" nsmap="${nsm}" />
        <c:set var="thisUserId">${ptr['l:userId']}</c:set>        
        <jxp:set var="thisUserName" cnode="${userDoc}"  select="//uinfo:name" nsmap="${nsm}" />
        <c:set var="thisUserDb">${ptr['l:userDb']}</c:set>
        <c:set var="thisLocation">${ptr['l:location']}</c:set>
        <c:set var="thisRecordId">${ptr['l:recordId']}</c:set>
        <c:set var="thisCopyId">${ptr['l:copyId']}</c:set>
        <c:set var="thisObjectDb">${ptr['l:objectDb']}</c:set>
        <jxp:set var="thisCopyLocation" cnode="${recordDoc}" select="//mods:mods[mods:recordInfo/mods:recordIdentifier='${thisRecordId}']/h:copy[h:copyId='${thisCopyId}']/h:copyLocation" nsmap="${nsm}"/>
        <c:set var="thisStartDate">${ptr['l:startDate']}</c:set>
        <c:set var="thisEndDate">${ptr['l:endDate']}</c:set>
        <c:set var="thisHistoric">${ptr['@historic']}</c:set>
        
      </c:otherwise>
    </c:choose>  

    <%-- output an open row line --%>
    
    <td>
      <c:if test="${thisHistoric}">
        <a href="../../trans/query/view_return_detail.jsp?transaction_id=${thisTransactionId}"><img src="${sessionScope.absoluteContext}/images/pie.png" border="0" /></a>
      </c:if>
    </td>
    
    <td> <%-- loan id --%>      
      <a href="${sessionScope.absoluteContext}/trans/query/view_transaction_details.jsp?transaction_id=${thisTransactionId}">${thisTransactionId}</a>
    </td>

    <td> <%-- record title --%>
      ${fn:escapeXml(thisTitle)}
    </td>

    <td><%-- copy id--%>
      ${thisCopyLocation}&nbsp;${thisCopyId}
      <c:if test="${not config['ew.hide_object_db']}">(${thisObjectDb})</c:if>
    </td>

    <td><%-- record id --%>
      <a href="../../trans/query/record_status_result.jsp?record_id=${thisRecordId}&amp;object_db=${thisObjectDb}">
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
      <a href="../../trans/query/user_status_result.jsp?user_id=${thisUserId}&amp;user_db=${thisUserDb}">
        ${thisUserId}
        <c:if test="${not config['ew.hide_user_db']}">(${thisUserDb})</c:if>
      </a>
    </td>

    <td> <%-- user name --%>
      ${fn:escapeXml(thisUserName)}
    </td>    
  </c:otherwise>
</c:choose>


