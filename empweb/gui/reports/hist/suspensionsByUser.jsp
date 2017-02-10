<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="rep" tagdir="/WEB-INF/tags/reports" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->

<jsp:useBean id="nsml" class="java.util.HashMap" />
<c:set target="${nsml}" property="tr" value="http://kalio.net/empweb/schema/transactionresult/v1" />

<c:choose>

  <%-- THE FORM TO ENTER PARAMETERS --%>
  <c:when test="${empty param.library}">
    <%-- clean up the cache for this search --%>
    <rep:flushCache name="hist-suspensions"/>

    <%-- get Libraries and IPs from Engine --%>
    <x:parse varDom="libraries">
      <trans:doTransaction name="conf-getLibraries"/>
    </x:parse>

    <%-- get user DB names --%>
    <x:parse varDom="dbNames">
      <trans:getDatabaseNames/>
    </x:parse>

    <h2><fmt:message key="historic_suspensions_by_user"/></h2>
    <form method="get">
      <input type="hidden" name="report_type" value="${param.report_type}"/>
      <input type="hidden" name="report_name" value="${param.report_name}"/>
      <c:if test="${config['ew.hide_user_db']}">
        <input type="hidden" name="user_db" value="${sessionScope['property-default-user-db']}"/>
      </c:if>
      <table>
        <tr>
          <td><fmt:message key="user_id"/></td>
          <td><input type="text" name="user_id" /></td>
        </tr>
        <c:if test="${not config['ew.hide_user_db']}">
          <tr>
            <td><fmt:message key="user_db"/></td>
            <td><dsp:selectUserDatabase name="user_db" dbNames="${dbNames}" selectedDb="${userDb}"/></td>
          </tr>
        </c:if>
        <tr>
          <td><fmt:message key="library"/></td>
          <td>
            <select name="library">
              <option value="all_libraries"><fmt:message key="all_libraries"/></option>
              <jxp:forEach cnode="${libraries}" var="libr" select="//tr:library" nsmap="${nsml}">
                <option value="${fn:trim(libr['@id'])}">${fn:trim(libr['@id'])}</option>
              </jxp:forEach>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" name="submit" value="<fmt:message key="submit"/>"/></td>
        </tr>
      </table>
    </form>
  </c:when>



  <%-- DISPLAY THE RESULTS --%>
  <c:otherwise>

    <%-- paging stuff --%>
    <c:set var="from" value="${(not empty fn:trim(param.from))?fn:trim(param.from):0 }"/>
    <c:set var="qty" value="${(not empty fn:trim(param.qty))?fn:trim(param.qty):50}"/>

    <%-- go fetch --%>
    <c:choose>
      <c:when test="${param.printable eq 'true'}">
        <rep:requestStat name="hist-suspensions"
          cacheId = "${param.cache_id}"
          newCacheIdVar = "newCacheId"
          sortBy="${param.sort_by}"
          order="${param.sort_order}"
          timestamp="timestamp"
          var="sortedMap"
          totalCount="totalCount"
          fillUsersInfo="true"
          fillObjectsInfo="true" >
          <c:if test="${(not empty param.library) and (param.library ne 'all_libraries')}">
            <param name="operatorLocation">${param.library}</param>
          </c:if>
          <param name="searchField">userId</param>
          <c:if test="${param.user_db ne '*'}">
            <param name="userDb">${param.user_db}</param>
          </c:if>
          <param name="searchValue">${param.user_id}</param>
        </rep:requestStat>
      </c:when>
      <c:otherwise>
        <rep:requestStat name="hist-suspensions"
          cacheId = "${param.cache_id}"
          newCacheIdVar = "newCacheId"
          sortBy="${param.sort_by}"
          order="${param.sort_order}"
          timestamp="timestamp"
          var="sortedMap"
          totalCount="totalCount"
          fillUsersInfo="true"
          fillObjectsInfo="true"
          from="${from}"
          qty="${qty}" >
          <c:if test="${(not empty param.library) and (param.library ne 'all_libraries')}">
            <param name="operatorLocation">${param.library}</param>
          </c:if>
          <param name="searchField">userId</param>
          <c:if test="${param.user_db ne '*'}">
            <param name="userDb">${param.user_db}</param>
          </c:if>
          <param name="searchValue">${param.user_id}</param>
        </rep:requestStat>
      </c:otherwise>
    </c:choose>

    <%-- the url that produces this search--%>
    <c:set var="urlprefix">report_type=${param.report_type}&amp;report_name=${param.report_name}&amp;library=${param.library}&amp;cache_id=${newCacheId}&amp;user_id=${param.user_id}&amp;user_db=${param.user_db}</c:set>
    <c:if test="${param.printable eq 'true'}">
      <c:set var="urlprefix">${urlprefix}&amp;printable=true</c:set>
    </c:if>


    <%-- THE CONTENT --%>
    <h1><fmt:message key="historic_suspension_list"/></h1>
    <h2>
      <fmt:message key="historic_suspensions_by_user"/>:${param.user_id} (${param.user_db})
      <c:if test="${param.library ne 'all_libraries'}">| <fmt:message key="library"/>:${param.library}</c:if>
    </h2>

    <c:if test="${param.printable ne 'true'}">
      <%-- useful links --%>
      <div>
        <a href="?report_type=${param.report_type}&amp;report_name=${param.report_name}"><fmt:message key="new_search"/></a> |
        <a href="../../reports/${param.report_type}/${param.report_name}.jsp?${urlprefix}&amp;printable=true&amp;sort_order=${param.sort_order}&amp;sort_by=${param.sort_by}"><fmt:message key="printable_version"/></a>
      </div>

      <rep:pageNumber from="${from}" qty="${qty}" totalCount="${totalCount}" urlprefix="${urlprefix}&amp;sort_order=${param.sort_order}&amp;sort_by=${param.sort_by}"/>
    </c:if>

    <%-- display content table only if there any data to be shown --%>
    <c:choose>
      <c:when test="${totalCount gt 0}">

        <%-- CONTENT TABLE --%>
        <table id="result">
          <%-- HEADERS --%>
          <tr><dsp:suspensionRow isheader="true" showsortlinks="true" urlprefix="${urlprefix}"/></tr>

          <%-- CONTENT ROWS --%>
          <c:forEach items="${sortedMap}" var="rowMap">
            <tr><dsp:suspensionRow rowMap="${rowMap}"/></tr>
          </c:forEach>
        </table>



        <c:if test="${param.printable ne 'true'}">
          <%-- BOTTOM NAVIGATION LINKS --%>
          <rep:pageNumber from="${from}" qty="${qty}" totalCount="${totalCount}" urlprefix="${urlprefix}&amp;sort_order=${param.sort_order}&amp;sort_by=${param.sort_by}"/>

          <%-- CACHING TIMESTAMP --%>
          <c:if test="${not empty timestamp}">
            <p class="pagenav">
              <fmt:message key="result_cached_on">
                <fmt:param><fmt:formatDate type="both" dateStyle="short" timeStyle="short" value="${timestamp}"/></fmt:param>
              </fmt:message>
            </p>
          </c:if>
        </c:if>

      </c:when>
      
      <c:otherwise>
        <fmt:message key='report_is_empty'/>
      </c:otherwise>

    </c:choose>

  </c:otherwise>
</c:choose>

