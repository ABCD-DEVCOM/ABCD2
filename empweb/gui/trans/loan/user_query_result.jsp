<?xml version="1.0"?>
<!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
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

<div id="pleasewait"><fmt:message key="please_wait"/></div>
<% out.flush( ); %>
<script>
<!--
document.getElementById('pleasewait').style.display = "none"
-->
</script>


<%-- NAMESPACE MAPS AND TODAYS DATE--%>
<jsp:useBean id="now" class="java.util.Date"/>
<jsp:useBean id="nsm" class="java.util.HashMap"  />
<c:set target="${nsm}" property="u" value="http://kalio.net/empweb/schema/users/v1" />
<c:set target="${nsm}" property="qr" value="http://kalio.net/empweb/schema/queryresult/v1" />


<%-- PREPARRE EXTRA PARAMS HASH MAP --%>
<jsp:useBean id="extraParams" class="java.util.HashMap" />



<c:if test="${not empty fn:trim(param.user_id)}">
  <c:set target="${extraParams}"  property="user_id"><util:fixUserId>${fn:trim(param.user_id)}</util:fixUserId></c:set>
</c:if>
<c:if test="${not empty param.user_name}">
  <c:set target="${extraParams}"  property="user_name"    value="${fn:trim(param.user_name)}"/>
</c:if>
 <c:if test="${not empty param.user_userClass}">
   <c:set target="${extraParams}"  property="user_userClass"   value="${fn:trim(param.user_userClass)}"/>
</c:if>
<c:if test="${not empty param.user_address}">
  <c:set target="${extraParams}"  property="user_address" value="${fn:trim(param.user_address)}"/>
</c:if>

<c:set var="numExtraParams" value="${fn:length(extraParams)}"/>

<%-- FIRST WE MAKE THE QUERY, CALLING trans:searchUsersById OR THE GENERIC trans:searchUsers --%>
<c:choose>
  <c:when test="${not empty fn:trim(param.user_id)}">
    <c:set var="userId"><util:fixUserId>${fn:trim(param.user_id)}</util:fixUserId></c:set>
    <x:parse var="userResult">
      <trans:searchUsersById database="${fn:trim(param.database)}">
        ${userId}
      </trans:searchUsersById>
    </x:parse>   
        
  </c:when>

  <c:when test="${numExtraParams gt 0}">
    <%-- Map http paramater names to EmpWeb Users/Objects Query tag names. --%>
    <jsp:useBean id="paramTagMap" class="java.util.HashMap"  />
    <c:set target="${paramTagMap}"  property="user_id"        value="userId"/>
    <c:set target="${paramTagMap}"  property="user_name"      value="name"/>
    <c:set target="${paramTagMap}"  property="user_userClass" value="userClass"/>
    <c:set target="${paramTagMap}"  property="user_address"   value="address"/>

    <x:parse var="userResult">
      <trans:searchUsers database="${fn:trim(param.database)}">
        <query xmlns="http://kalio.net/empweb/schema/usersquery/v1">
          <c:if test="${numExtraParams gt 1}">
            <and>
          </c:if>

            <c:forEach var="i" items="${extraParams}">
              <jsp:element name="${paramTagMap[i.key]}">${i.value}</jsp:element>
            </c:forEach>

          <c:if test="${numExtraParams gt 1}">
            </and>
          </c:if>
        </query>
      </trans:searchUsers>
    </x:parse>

  </c:when>

  <%-- SOMETHING WRONG WITH THE  QUERY: FAIL SILENTYL --%>
  <c:otherwise>
    <c:redirect url="index.jsp"/>
  </c:otherwise>
</c:choose>




<%-- SORT PARAMETERS--%>
<c:set var="sortElement">
  <c:choose>
    <c:when test="${param.sort_element eq 'name'}">u:name</c:when>
    <c:when test="${param.sort_element eq 'userClass'}">u:userClass</c:when>
    <c:when test="${param.sort_element eq 'id'}">u:id</c:when>
    <c:when test="${param.sort_element eq 'expirationDate'}">u:expirationDate</c:when>
    <c:otherwise>name</c:otherwise>
  </c:choose>
</c:set>
<c:set var="sortOrder">${(not empty param.sort_order)?param.sort_order:'ascending'}</c:set>


<%-- COUNT MATCHIG RESULTS --%>
<jxp:set var="results_count" cnode="${userResult}" select="count(//*[local-name()='user'])" />




<%-- DISPLAY OPTIONS  --%>
<c:choose>

  <%-- NO RESULTS --%>
  <c:when test="${results_count == 0}">
    <div class="middle homepage">
      <p><fmt:message key="no_results_found"/></p>
      <p><a href="index.jsp"><fmt:message key="back_to_query"/></a></p>
    </div>
  </c:when>

  <%-- MORE THAN ONE RESULT: SHOW THE LIST --%>
  <c:otherwise>

    <c:set var="thisUrlPrefix">user_query_result.jsp?user_id=${param.user_id}&amp;user_name=${param.user_name}&amp;database=${param.database}</c:set>

    <div class="middle homepage">
      <table id="result">
        <%-- TABLE HEADERS --%>
        <tr>
          <th>
            <a href="${thisUrlPrefix}&amp;sort_element=name&amp;sort_order=${(param.sort_order eq 'ascending')?'descending':'ascending'}">
              <fmt:message key="name"/>${(param.sort_element eq 'name')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
            </a>
          </th>
          <th>
            <a href="${thisUrlPrefix}&amp;sort_element=userClass&amp;sort_order=${(param.sort_order eq 'ascending')?'descending':'ascending'}">
              <fmt:message key="user_class"/>${(param.sort_element eq 'userClass')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
            </a>
          </th>
                    <th>
            <a href="${thisUrlPrefix}&amp;sort_element=id&amp;sort_order=${(param.sort_order eq 'ascending')?'descending':'ascending'}">
              <fmt:message key="user_id"/>${(param.sort_element eq 'id')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
            </a>
          </th>
          <th>
            <a href="${thisUrlPrefix}&amp;sort_element=expirationDate&amp;sort_order=${(param.sort_order eq 'ascending')?'descending':'ascending'}">
              <fmt:message key="user_expiration"/>${(param.sort_element eq 'expirationDate')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
            </a>
          </th>
        </tr>

        <%-- TABLE ROWS --%>
        <jxp:forEach
          cnode="${userResult}"
          var="ptr"
          select="//u:userCollection/u:user"
          nsmap="${nsm}"
          sortby="${sortElement}"
          sortorder="${sortOrder}">
          <tr>
            <td>${ptr["u:name"]}</td>

            <td>${ptr["u:userClass"]}</td>


              
            <td>
            
             <c:if test="${param.copy_ids!='undefined'}">
              <a href="index.jsp?user_id=${ptr['u:id']}&amp;user_db=${ptr['../@dbname']}&amp;copy_ids=${param.copy_ids}">
             </c:if>
             
             <c:if test="${param.copy_ids=='undefined'}">
              <a href="index.jsp?user_id=${ptr['u:id']}&amp;user_db=${ptr['../@dbname']}">
             </c:if>
             
              
                ${ptr["u:id"]}
             </a>
              
            </td>

            <td>
              <c:choose>
                <c:when test="${ptr['u:expirationDate'] gt '20990000'}"> <%-- HARDCODED --%>
                  <fmt:message key="user_does_not_expire"/>
                </c:when>
                <c:otherwise>
                  <util:formatDate>${ptr['u:expirationDate']}</util:formatDate>
                  <util:parseDate var="pdate" >${ptr['u:expirationDate']}</util:parseDate>
                  <c:if test="${ pdate lt now}">(<fmt:message key="user_expired"/>)</c:if> <%-- CHECK EXPIRATION --%>
                </c:otherwise>
              </c:choose>
            </td>
          </tr>
        </jxp:forEach>

        <%-- LAST ROW: COUNT --%>
        <tr><td><strong><fmt:message key="number_of_results"/>: <fmt:formatNumber value="${results_count}" type="number"/></strong></td></tr>
      </table>
    </div>
  </c:otherwise>
</c:choose>


