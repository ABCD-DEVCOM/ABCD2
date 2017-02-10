<?xml version="1.0" ?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
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
<div class="middle homepage">

<jsp:useBean id="now" class="java.util.Date"/>
<c:set var="nowts"><util:formatDate type="timestamp" date="${now}"/></c:set>
<c:set var="nowDay"><util:formatDate type="timestamp" date="${now}" pattern="yyyyMMdd"/></c:set>
<c:set var="start_date">
  <c:choose>
    <c:when test="${not empty param.start_date}">${param.start_date}</c:when>
    <c:otherwise>${nowts}</c:otherwise>
  </c:choose>
</c:set>


<x:parse var="doc">
  <trans:doTransaction name="stat-record-availability">
    <transactionExtras>
      <params>
        <param name="recordId">${param.record_id}</param>
        <param name="volumeId">${param.volume_id}</param>
        <param name="objectDb">${param.object_db}</param>
        <param name="objectCategory">${param.object_category}</param>
        <param name="objectLocation">${param.object_location}</param>
        <param name="startTimestamp">${start_date}</param>
        <param name="endTimestamp">${param.end_date}</param>
        <param name="granularity">day</param>
      </params>
    </transactionExtras>
  </trans:doTransaction>
</x:parse>


  
  <%-- MORE THAN ONE VOLUME ID: SHOW FORM TO CHOOSE --%>
  <c:choose>
    <c:when test="${fn:length(paramValues.volume_id) gt 1}">
      <form method="get">
        <input type="hidden" name="record_id" value="${param.record_id}"/>
        <input type="hidden" name="object_db" value="${param.object_db}"/>
        <h2><fmt:message key="reservation_status"/></h2>
        <table>
          <tr>
            <td><fmt:message key="select_volume_id"/></td>
            <td>
              <select name="volume_id">
                <c:forEach items="${paramValues.volume_id}" var="vol">
                  <option value="${vol}">${vol}</option>
                </c:forEach>
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


    <%-- ONE OR NO VOLUME ID: PROCESS --%>
    <c:otherwise>

      <jsp:useBean id="nsm" class="java.util.HashMap" />
      <c:set target="${nsm}" property="tr" value="http://kalio.net/empweb/schema/transactionresult/v1" />

      <h2><fmt:message key="reservation_status"/></h2>

      <h3><fmt:message key="record_info"/></h3>
      <table>
        <tr>
          <td><fmt:message key="record_id"/></td>
          <td>${param.record_id}</td>
        </tr>
        <tr>
          <td><fmt:message key="volume_id"/></td>
          <td>${param.volume_id}</td>
        </tr>
      </table>

      <jxp:forEach cnode="${doc}"  var="location"  select="//tr:value[@name='availability']/tr:location" nsmap="${nsm}">
        <h3><fmt:message key="location"/>: ${location['@name']}</h3>

        <jxp:forEach cnode="${location}"  var="category"  select="tr:category" nsmap="${nsm}">
          <c:set var="totalHold"><jxp:out cnode="${category}" select="@holdings" nsmap="${nsm}"/></c:set>

          <h4><fmt:message key="object_category"/>: ${category['@name']} (total: ${totalHold})</h4>

          <util:parseDate var="firstDate"><jxp:out cnode="${category}" select="tr:avail[1]/@start" nsmap="${nsm}"/></util:parseDate>
          <util:parseDate var="lastDate"><jxp:out cnode="${category}"  select="tr:avail[last()]/@end" nsmap="${nsm}"/></util:parseDate>

          <!-- calendario start -->
          <util:availCalendar start="${firstDate}" end="${lastDate}" var="current">
            <c:set var="currentTimestamp"><fmt:formatDate value="${current}" pattern="yyyyMMddHHmmss" /></c:set>
            <c:set var="currentDay"><fmt:formatDate value="${current}" pattern="yyyyMMdd" /></c:set>
            <c:set var="noreserv"><jxp:out cnode="${category}" select="tr:avail[@start='${currentTimestamp}']/@noreserv" nsmap="${nsm}"/></c:set>
            <c:set var="avail"><jxp:out cnode="${category}" select="tr:avail[@start='${currentTimestamp}']" nsmap="${nsm}"/></c:set>

            <c:choose>
              <c:when test="${(noreserv eq 'true') or (avail eq '')}">
                <td class="notallowed ${(nowDay eq currentDay)?'today':''}"><fmt:formatDate value="${current}" pattern="d" /></td>
              </c:when>
              <c:when test="${(avail < 1)}">
                <td class="reserved ${(nowDay eq currentDay)?'today':''}"><fmt:formatDate value="${current}" pattern="d" /></td>
              </c:when>
              <c:otherwise>
                <td class="${(nowDay eq currentDay)?'today':''}" style="background-color: rgb(${100 - (avail / totalHold * 100)}%, 100% , ${100 - (avail / totalHold * 100)}%)">
                  <a title="${avail}"
                      href="../reservation/create/index.jsp?record_id=${param.record_id}&amp;start_date=${currentTimestamp}&amp;object_category=${category['@name']}&amp;object_location=${location['@name']}&amp;volume_id=${param.volume_id}"><fmt:formatDate value="${current}" pattern="d" /></a>
                </td>
              </c:otherwise>
            </c:choose>
          </td>
          </util:availCalendar>
          <!-- calendario end -->

        </jxp:forEach>
      </jxp:forEach>
    </c:otherwise>
  </c:choose>

</div>
