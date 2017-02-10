<?xml version="1.0" ?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
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
<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="m" value="http://www.loc.gov/mods/v3" />
<c:set target="${nsm}" property="mod" value="http://www.loc.gov/mods/v3" />
<c:set target="${nsm}" property="u" value="http://kalio.net/empweb/schema/users/v1" />
<c:set target="${nsm}" property="o" value="http://kalio.net/empweb/schema/objectstatus/v1" />
<c:set target="${nsm}" property="w" value="http://kalio.net/empweb/schema/wait/v1" />
<c:set target="${nsm}" property="r" value="http://kalio.net/empweb/schema/reservation/v1" />
<c:set target="${nsm}" property="l" value="http://kalio.net/empweb/schema/loan/v1" />
<c:set target="${nsm}" property="hol" value="http://kalio.net/empweb/schema/holdingsinfo/v1" />
<c:set target="${nsm}" property="qr" value="http://kalio.net/empweb/schema/queryresult/v1" />

<div class="middle homepage">
  <jsp:useBean id="record_id" class="java.lang.String" />
  <c:set var="record_id" value="${fn:trim(param.record_id)}"/>
  <c:set var="object_db" value="${fn:trim(param.object_db)}"/>

  <c:choose>
    <c:when test="${not empty record_id}">
      <x:parse varDom="recordInfoResult">
        <trans:searchObjects database="${object_db}">
          <query xmlns="http://kalio.net/empweb/schema/objectsquery/v1">
            <recordId>${fn:trim(param.record_id)}</recordId>
          </query>
        </trans:searchObjects>
      </x:parse>

      <x:parse varDom="recordStatusResult">
        <trans:getRecordStatus id="${fn:trim(param.record_id)}" database="${object_db}"/>
      </x:parse>
    </c:when>

    <c:otherwise>
      <c:redirect url="index.jsp"/>
    </c:otherwise>
  </c:choose>

  <jxp:set cnode="${recordInfoResult}"  var="recordInfo"   select="//m:modsCollection" nsmap="${nsm}" />
  <jxp:set cnode="${recordStatusResult}" var="recordStatus"   select="//o:recordStatus" nsmap="${nsm}" />


  <jxp:set var="totalCopies" cnode="${recordInfo}" select="count(mod:mods/mod:extension/hol:holdingsInfo/hol:copies/hol:copy)" nsmap="${nsm}" />
  <jxp:set var="withVolCount" cnode="${recordInfo}" select="count(mod:mods/mod:extension/hol:holdingsInfo/hol:copies/hol:copy/hol:volumeId)" nsmap="${nsm}" />

  <%-- COUNT VOLUMES --%>
  <jsp:useBean id="volsMap" class="java.util.HashMap" />
  <%-- IF THE RECORD HAS NO VOL_ID PUT AN EMPTY ELEMENT --%>
  <c:if test="${(fn:length(volsMap) == 0) or (totalCopies > withVolCount)}"><c:set target="${volsMap}"  property="-"  value="${totalCopies-withVolCount}"/></c:if>
  <%-- THEN LOAD ALL VOL IDS --%>
  <jxp:forEach  cnode="${recordInfo}" var="ptr2" select="mod:mods/mod:extension/hol:holdingsInfo/hol:copies/hol:copy/hol:volumeId" sortby="." nsmap="${nsm}">
    <c:set target="${volsMap}"  property="${ptr2['.']}"  value="${ptr2['.']}"/>
  </jxp:forEach>
  <c:set var="totalVolumes">${fn:length(volsMap)}</c:set>

  <c:set var="volsList"></c:set>
  <c:if test="${fn:length(volsMap) gt 1}">
    <c:forEach items="${volsMap}" var="vol">
      <c:set var="volsList">&amp;volume_id=${vol.key}${volsList}</c:set>
    </c:forEach>
  </c:if>


  <!-- RECORD INFO -->
  <h2><fmt:message key="record_info"/></h2>

  <div style="float:left">

    <c:choose>
      <%-- This record does not exist in the database --%>
      <c:when test="${recordInfo['m:mods'] == null}">
        <p><fmt:message key="no_results_found"/></p>
      </c:when>

      <%-- We found a matching record: display it --%>
      <c:otherwise>
        <dsp:record doc="${recordInfo}" databasename="${object_db}"/>
      </c:otherwise>
    </c:choose>
  </div>


  <!-- RECORD STATUS -->
  <div style="float:left; margin-left:30px;">
    <!-- record status resume -->
    <c:set var="remainingCopies" value="${totalCopies}"/>

    <table id="result">
      <tr>
        <th><strong><fmt:message key="record_status"/></strong></th>
        <th><strong><fmt:message key="total"/></strong></th>
        <c:if test="${(fn:length(volsMap) gt 1)}">
          <c:forEach items="${volsMap}" var="vol">
            <th><strong>${vol.key}</strong></th>
          </c:forEach>
        </c:if>
      </tr>

      <!-- total copies per volume -->
      <tr>
        <td><fmt:message key="total_copies"/></td>
        <td><a href="object_query_result.jsp?show_all_copies=1&amp;object_recordid=${param.record_id}&amp;database=${object_db}">
            <fmt:formatNumber>${totalCopies}</fmt:formatNumber>
          </a>
        </td>
        <c:if test="${(fn:length(volsMap) gt 1)}">
          <c:forEach items="${volsMap}" var="vol">
            <td><fmt:formatNumber>
                <c:choose>
                  <c:when test="${vol.key eq '-'}">${vol.value}</c:when>
                  <c:otherwise>
                    <jxp:out cnode="${recordInfo}" select="count(mod:mods/mod:extension/hol:holdingsInfo/hol:copies/hol:copy[hol:volumeId='${vol.value}'])" nsmap="${nsm}"/>
                  </c:otherwise>
                </c:choose>
              </fmt:formatNumber>
            </td>
          </c:forEach>
        </c:if>
        </tr>

      <!-- lent copies -->
      <%-- <c:if test="${recordStatus['l:loans/l:loan'] != null }"> --%>
        <jxp:set var="lentCopies" cnode="${recordStatus}" select="count(l:loans/l:loan)" nsmap="${nsm}" />
        <c:set var="remainingCopies" value="${remainingCopies - lentCopies}"/>
        <tr>
          <td><fmt:message key="lent_copies"/></td>
          <td><fmt:formatNumber>${lentCopies}</fmt:formatNumber></td>
        </tr>
        <%-- </c:if> --%>

      <!-- available copies -->
      <tr>
        <td><strong><fmt:message key="available_copies"/>:</strong></td>
        <td><fmt:formatNumber>${remainingCopies}</fmt:formatNumber></td>
      </tr>
    </table>
  </div>



  <div style="clear:both">
    <!-- ACTIONS -->
    <h3><fmt:message key="actions"/>:</h3>
    <p>
      <a href="../wait/create/index.jsp?record_id=${record_id}&amp;object_db=${object_db}${volsList}">
        <fmt:message key="new_reservation"/>
      </a>
    </p>
  </div>



  <!-- DETAILED RECORD STATUS -->
  <div style="clear:both">
    <!-- waits -->
    <c:if test="${recordStatus['w:waits/w:wait'] != null }">
      <h3><a name="waits"/><fmt:message key="wait_list"/></h3>
      <table id="result">
        <tr>
          <th><fmt:message key="date"/></th>
          <th><fmt:message key="user_id"/></th>
          <th><fmt:message key="user_name"/></th>
          <th><fmt:message key="actions"/></th>
        </tr>
        <jxp:forEach cnode="${recordStatus}" var="ptr" select="w:waits/w:wait" nsmap="${nsm}">
          <tr>
            <td>
              <util:formatDate pattern="yyyyMMddHHmmss">${ptr['w:date']}</util:formatDate>
            </td>
            <td>
              <a href="user_status_result.jsp?user_id=${ptr['w:userId']}&amp;user_db=${ptr['w:userDb']}">
                ${ptr['w:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['w:userDb']})</c:if></a>
            </td>
            <td>
              <x:parse varDom="thisRecord">
                <trans:searchUsersById database="${ptr['w:userDb']}">${ptr['w:userId']}</trans:searchUsersById>
              </x:parse>
              <jxp:out cnode="${thisRecord}" select="//u:user/u:name" nsmap="${nsm}" />
            </td>
            <td>
              <a href="../loan/index.jsp?user_id=${ptr['w:userId']}&amp;user_db=${ptr['w:userDb']}&amp;recordId=${ptr['w:recordId']}&amp;objectDb=${ptr['w:objectDb']}">
                <fmt:message key="loan"/>
              </a> |
              <%--
              TODO: armar bien la cancelacion de esperas
              <a href="../wait/cancel_wait.jsp?wait_ids=${ptr['@id']}">
                <fmt:message key="cancel"/>
              </a>
              --%>
            </td>
          </tr>
        </jxp:forEach>
      </table>
    </c:if>

    <!-- reservations -->
    <c:if test="${recordStatus['r:reservations/r:reservation'] != null}">
      <h3><a name="reservations"/><fmt:message key="reservations"/></h3>
      <table id="result">
        <tr>
          <th><fmt:message key="user_id"/></th>
          <th><fmt:message key="user_name"/></th>
          <th><fmt:message key="volume_id"/></th>
          <th><fmt:message key="reservation_start_date"/></th>
          <th><fmt:message key="reservation_expiration_date"/></th>
          <th><fmt:message key="reservation_end_date"/></th>
          <th><fmt:message key="actions"/></th>
        </tr>
        <jxp:forEach cnode="${recordStatus}" var="ptr" select="r:reservations/r:reservation" nsmap="${nsm}">
          <tr>
            <td>
              <a href="user_status_result.jsp?user_id=${ptr['r:userId']}&amp;user_db=${ptr['r:userDb']}">
                ${ptr['r:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['r:userDb']})</c:if></a>
            </td>
            <td>
              <x:parse varDom="thisRecord">
                <trans:searchUsersById database="${ptr['r:userDb']}">${ptr['r:userId']}</trans:searchUsersById>
              </x:parse>
              <jxp:out cnode="${thisRecord}"  select="//u:user/u:name" nsmap="${nsm}" />
            </td>
            <td>
              ${ptr['r:volumeId']}
            </td>
            <td>
              <util:formatDate pattern="yyyyMMddHHmmss">${ptr['r:startDate']}</util:formatDate>
            </td>
            <td>
              <util:formatDate pattern="yyyyMMddHHmmss">${ptr['r:expirationDate']}</util:formatDate>
            </td>
            <td>
              <util:formatDate pattern="yyyyMMddHHmmss">${ptr['r:endDate']}</util:formatDate>
            </td>
            <td>
              <a href="../reservation/cancel/index.jsp?reservation_id=${ptr['@id']}">
                <fmt:message key="cancel"/>
              </a>
            </td>
          </tr>
        </jxp:forEach>
      </table>
    </c:if>

    <!-- loans -->
    <c:if test="${recordStatus['l:loans/l:loan'] != null}">
      <h3><a name="loans"/><fmt:message key="current_loans"/></h3>
      <table id="result">
        <tr>
          <th><fmt:message key="loan_date"/></th>
          <th><fmt:message key="return_date"/></th>
          <th><fmt:message key="copy_id"/></th>
          <th><fmt:message key="user_id"/></th>
          <th><fmt:message key="user_name"/></th>
          <th><fmt:message key="actions"/></th>
        </tr>

        <jxp:forEach cnode="${recordStatus}" var="ptr" select="l:loans/l:loan" nsmap="${nsm}">
          <tr>
            <td>
              <util:formatDate pattern="yyyyMMddHHmmss">${ptr['l:startDate']}</util:formatDate>
            </td>

            <util:isLate var="late">${ptr['l:endDate']}</util:isLate>
            <c:choose>
              <c:when test="${late eq 'true'}">
                <td class="warn">
              </c:when>
              <c:otherwise>
                <td>
              </c:otherwise>
            </c:choose>
            <util:formatDate pattern="yyyyMMddHHmmss">${ptr['l:endDate']}</util:formatDate>
          </td>
            <td>
              <a href="copy_status_result.jsp?copy_id=${ptr['l:copyId']}&amp;object_db=${ptr['l:objectDb']}">
                ${ptr['l:copyId']} <c:if test="${not config['ew.hide_object_db']}">(${ptr['l:objectDb']})</c:if>
              </a>
            </td>
            <td>
              <a href="user_status_result.jsp?user_id=${ptr['l:userId']}&amp;user_db=${ptr['l:userDb']}">
                ${ptr['l:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['l:userDb']})</c:if>
              </a>
            </td>
            <td>
              <x:parse varDom="thisRecord">
                <trans:searchUsersById database="${ptr['l:userDb']}">${ptr['l:userId']}</trans:searchUsersById>
              </x:parse>
              <jxp:out cnode="${thisRecord}"  select="//u:user/u:name" nsmap="${nsm}" />
            </td>
            <td>
              <a href="../return/index.jsp?user_id=${ptr['l:userId']}&amp;user_db=${ptr['l:userDb']}&amp;copy_ids=${ptr['l:copyId']}&amp;object_db=${ptr['l:objectDb']}">
                <fmt:message key="return"/>
              </a> |
              <a href="../renewal/index.jsp?user_id=${ptr['l:userId']}&amp;user_db=${ptr['l:userDb']}&amp;copy_ids=${ptr['l:copyId']}&amp;object_db=${ptr['l:objectDb']}">
                <fmt:message key="renew"/>
              </a>
            </td>
          </tr>
        </jxp:forEach>
      </table>
    </c:if>
  </div> <!-- detailed record status -->
</div>
