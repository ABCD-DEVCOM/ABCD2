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
<c:set target="${nsm}" property="u" value="http://kalio.net/empweb/schema/users/v1" />
<c:set target="${nsm}" property="o" value="http://kalio.net/empweb/schema/objectstatus/v1" />
<c:set target="${nsm}" property="w" value="http://kalio.net/empweb/schema/wait/v1" />
<c:set target="${nsm}" property="r" value="http://kalio.net/empweb/schema/reservation/v1" />
<c:set target="${nsm}" property="l" value="http://kalio.net/empweb/schema/loan/v1" />

<div class="middle homepage">
  <jsp:useBean id="copy_id" class="java.lang.String" />
  <c:set var="copy_id" value="${fn:trim(param.copy_id)}"/>
  <c:set var="object_db" value="${fn:trim(param.object_db)}"/>

  <c:choose>
    <c:when test="${not empty copy_id}">
      <x:parse varDom="copyInfoResult">
        <trans:searchObjectsById database="${object_db}">
          ${copy_id}
        </trans:searchObjectsById>
      </x:parse>

      <x:parse varDom="copyStatusResult">
        <trans:getCopyStatus id="${copy_id}" database="${object_db}"/>
      </x:parse>
    </c:when>

    <c:otherwise>
      <c:redirect url="index.jsp"/>
    </c:otherwise>
  </c:choose>


  <!-- COPY INFO -->
  <h2><fmt:message key="copy_info"/></h2>

  <jxp:set cnode="${copyInfoResult}"  var="copyInfo"   select="//m:modsCollection" nsmap="${nsm}" />
  <c:choose>
    <%-- This user does not exist in the database --%>
    <c:when test="${copyInfo['m:mods'] == null}">
      <p><fmt:message key="no_results_found"/></p>
    </c:when>

    <%-- We found a matching copy: display it --%>
    <c:otherwise>
      <dsp:copy doc="${copyInfo}" object_db="${object_db}" copy_id="${copy_id}" />
    </c:otherwise>
  </c:choose>

  <br />

  <!-- other actions -->
  <c:if test="${(copyStatus['w:waits/w:wait'] == null) && (copyStatus['r:reservations/r:reservation'] == null) && (copyStatus['l:loans/l:loan'] == null)}">
    <h3><fmt:message key="actions"/></h3>
    <p>
      <a href="../loan/index.jsp?copy_ids=${copy_id}&amp;object_db=${object_db}"><fmt:message key="loan"/></a>
    </p>
  </c:if>


  <!-- DETAILED COPY STATUS -->
  <h2><fmt:message key="copy_status"/></h2>
  <jxp:set cnode="${copyStatusResult}" var="copyStatus"   select="//o:copyStatus" nsmap="${nsm}" />

  <h3>
    <fmt:message key="status"/>:
    <c:choose>
      <c:when test="${copyStatus['l:loans/l:loan'] != null}"><fmt:message key="lent"/></c:when>
      <c:otherwise><fmt:message key="available"/></c:otherwise>
    </c:choose>
  </h3>

  <!-- waits -->
  <c:if test="${copyStatus['w:waits/w:wait'] != null }">
    <h3><a name="waits"/><fmt:message key="wait_list"/></h3>
    <table id="result">
      <tr>
        <th><fmt:message key="date"/></th>
        <th><fmt:message key="user_id"/></th>
        <th><fmt:message key="user_name"/></th>
        <th><fmt:message key="actions"/></th>
      </tr>
      <jxp:forEach cnode="${copyStatus}" var="ptr" select="w:waits/w:wait" nsmap="${nsm}">
        <tr>
          <td>
            <util:formatDate pattern="yyyyMMddHHmmss">${ptr['w:date']}</util:formatDate>
          </td>
          <td>
            <a href="user_status_result.jsp?user_id=${ptr['w:userId']}&amp;user_db=${ptr['w:userDb']}">
              ${ptr['w:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['w:userDb']})</c:if></a>
          </td>
          <td>
            <x:parse varDom="thisCopy">
              <trans:searchUsersById  database="${ptr['w:userDb']}">
                ${ptr['w:userId']}
              </trans:searchUsersById>
            </x:parse>
            <jxp:out cnode="${thisCopy}" select="//u:user/u:name" nsmap="${nsm}" />
          </td>
          <td>
            <a href="../loan/index.jsp?user_id=${ptr['w:userId']}&amp;user_db=${ptr['w:userDb']}&amp;copy_id=${ptr['w:copyId']}&amp;object_db=${ptr['w:objectDb']}">
              <fmt:message key="loan"/>
            </a> |
<%--
            <a href="../wait/cancel_wait.jsp?user_id=${ptr['w:userId']}&amp;user_db=${ptr['w:userDb']}&amp;copy_id=${ptr['w:copyId']}&amp;object_db=${ptr['w:objectDb']}">
              <fmt:message key="cancel"/>
            </a>
--%>
          </td>
        </tr>
      </jxp:forEach>
    </table>
  </c:if>

  <!-- reservations -->
  <c:if test="${copyStatus['r:reservations/r:reservation'] != null}">
    <h3><a name="reservations"/><fmt:message key="reservations"/></h3>
    <table id="result">
      <tr>
        <th><fmt:message key="date"/></th>
        <th><fmt:message key="user_id"/></th>
        <th><fmt:message key="user_name"/></th>
        <th><fmt:message key="actions"/></th>
      </tr>
      <jxp:forEach cnode="${copyStatus}" var="ptr" select="r:reservations/r:reservation" nsmap="${nsm}">
        <tr>
          <td>
            <util:formatDate pattern="yyyyMMddHHmmss">${ptr['r:date']}</util:formatDate>
          </td>
          <td>
            <a href="user_status_result.jsp?user_id=${ptr['r:userId']}&amp;user_db=${ptr['r:userDb']}">
              ${ptr['r:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['r:userDb']})</c:if></a>
          </td>
          <td>
            <x:parse varDom="thisCopy">
              <trans:searchUsersById database="${ptr['r:userDb']}">
                ${ptr['r:userId']}
              </trans:searchUsersById>
            </x:parse>
            <jxp:out cnode="${thisCopy}"  select="//u:user/u:name" nsmap="${nsm}" />
          </td>
          <td>
            <a href="../reservation/cancel_reservation.jsp?reservation_id=${ptr['@id']}&amp;user_id=${ptr['r:userId']}&amp;user_db=${ptr['r:userDb']}&amp;copy_id=${ptr['r:copyId']}&amp;object_db=${ptr['r:objectDb']}">
              <fmt:message key="cancel"/>
            </a>
          </td>
        </tr>
      </jxp:forEach>
    </table>
  </c:if>

  <!-- loans -->
  <c:if test="${copyStatus['l:loans/l:loan'] != null}">
    <h3><a name="loans"/><fmt:message key="current_loans"/></h3>
    <table id="result">
      <tr>
        <th><fmt:message key="date"/></th>
        <th><fmt:message key="end_date"/></th>
        <th><fmt:message key="user_id"/></th>
        <th><fmt:message key="user_name"/></th>
        <th><fmt:message key="actions"/></th>
      </tr>

      <jxp:forEach cnode="${copyStatus}" var="ptr" select="l:loans/l:loan" nsmap="${nsm}">
        <tr>
          <td>
            <util:formatDate pattern="yyyyMMddHHmmss">${ptr['l:startDate']}</util:formatDate>
          </td>

          <util:isLate var="late">${ptr['l:endDate']}</util:isLate>
          <td ${late eq 'true' ? 'class="warn"' : ''}>
            <util:formatDate pattern="yyyyMMddHHmmss">${ptr['l:endDate']}</util:formatDate>
          </td>
          <td>
            <a href="user_status_result.jsp?user_id=${ptr['l:userId']}&amp;user_db=${ptr['l:userDb']}">
              ${ptr['l:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['l:userDb']})</c:if>
            </a>
          </td>
          <td>
            <x:parse varDom="thisCopy">
              <trans:searchUsersById  database="${ptr['l:userDb']}">
                ${ptr['l:userId']}
              </trans:searchUsersById>
            </x:parse>
            <jxp:out cnode="${thisCopy}"  select="//u:user/u:name" nsmap="${nsm}" />
          </td>

            <td>
              <a href="../return/index.jsp?copy_ids=${ptr['l:copyId']}&amp;object_db=${ptr['l:objectDb']}">
                <fmt:message key="return"/>
              </a>
<%-- BBB Por ahora no esta, asi que mejor que no se vea
              |
              <a href="../renewal/index.jsp?copy_ids=${ptr['l:copyId']}&amp;object_db=${ptr['l:objectDb']}">
                <fmt:message key="renew"/>
              </a>
 --%>
            </td>
          </tr>
        </jxp:forEach>
    </table>
  </c:if>

</div>




