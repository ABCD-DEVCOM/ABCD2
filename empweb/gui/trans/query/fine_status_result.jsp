<?xml version="1.0" ?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="kfn"   uri="http://kalio.net/jsp/el-func-1.0" %>
<%@ taglib prefix="rep" tagdir="/WEB-INF/tags/reports" %>

<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>

-->

<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="tr"    value="http://kalio.net/empweb/schema/transactionresult/v1" />
<c:set target="${nsm}" property="uinfo" value="http://kalio.net/empweb/schema/users/v1" />

  <%-- when a field is missing, reject with available parameters --%>
  <c:choose>
  <c:when test="${(fn:trim(param.fine_id) eq '')}">
    <c:redirect url="index.jsp">
      <c:if test="${not empty fn:trim(param.fine_id) }">
        <c:param name="fine_id" value="${param.fine_id}"/>
      </c:if>
    </c:redirect>
  </c:when>


  <%-- get all the transactions that refer to this fineId --%>
  <c:otherwise>

    <%-- get the fine that started it all, and all the payments related --%>
    <%-- NOTE: The result ALSO includes the original fine, whose id = refId --%>
    <rep:requestStat name="hist-fines"
      flushCache="true"
      timestamp="timestamp"
      sortBy="transactionId"
      var="sortedMap"
      totalCount="totalCount"
      fillUsersInfo="true">
      <param name="searchField">refId</param>
      <param name="searchValue">${param.fine_id}</param>
    </rep:requestStat>

    <%-- get : original fine amount, total amount paid so far, and amount still due --%>
    <x:parse varDom="totalAmounts">
      <trans:doTransaction name="stat-hist-fines">
        <transactionExtras>
          <params>
            <param name="searchField">refId</param>
            <param name="searchValue">${param.fine_id}</param>
          </params>
        </transactionExtras>
      </trans:doTransaction>
    </x:parse>
    
    <jxp:set cnode="${totalAmounts}" var="ptr" select="//tr:originalAmount" nsmap="${nsm}"/>
    <c:set var="originalAmount" value="${ptr['.']}" />

    <jxp:set cnode="${totalAmounts}" var="ptr" select="//tr:paymentsTotal" nsmap="${nsm}"/>
    <c:set var="paymentsTotal" value="${ptr['.']}" />

    <jxp:set cnode="${totalAmounts}" var="ptr" select="//tr:dueAmount" nsmap="${nsm}"/>
    <c:set var="dueAmount" value="${ptr['.']}" />



    <%-- request the info of the user associated with this fine --%>
    <x:parse varDom="userInfoResult">
      <trans:searchUsersById database="${sortedMap[0]['userDb']}">
        ${sortedMap[0]['userId']}
      </trans:searchUsersById>
    </x:parse>

    <div id="content">
      <h1><fmt:message key="fine"/></h1>

      <%-- show errors, if any --%>
      <trans:showErrors  doc="${totalAmounts}" />

      <h2><fmt:message key="track_fine_result"/></h2>

      <%-- USER INFO--%>
      <h3><fmt:message key="fine_issued_to"/></h3>
      <div style="float:left">
        <jxp:set cnode="${userInfoResult}"  var="userInfo" select="//uinfo:userCollection" nsmap="${nsm}" />
        <c:choose>
          <%-- This user does not exist in the database --%>
          <c:when test="${userInfo['uinfo:user'] == null}">
            <p><fmt:message key="no_results_found"/></p>
          </c:when>

          <%-- We found a matching user: display it --%>
          <c:otherwise>
            <dsp:user doc="${userInfoResult}" select="//uinfo:userCollection" nsmap="${nsm}"/>
          </c:otherwise>
        </c:choose>
      </div>

      <%-- DISPLAY FINE SUMMARY --%>
      <%-- escondido... creo que prefiero al final de la tabla para simplificar un poco
      <div style="clear:both">
        <h3><fmt:message key="fine_status"/></h3>
        <table>
          <th/><th/>
          <tr>
            <td><fmt:message key="original_fine_amount"/></td>
            <td><strong><dsp:formatAmount>${originalAmount}</dsp:formatAmount></strong></td>
          </tr>
          <tr>
            <td><fmt:message key="fine_amount_paid"/></td>
            <td><strong><dsp:formatAmount>${paymentsTotal}</dsp:formatAmount></strong></td>
          </tr>
          <tr><td></td><td></td></tr>
          <tr>
            <td><fmt:message key="fine_amount_due"/></td>
            <td><strong><dsp:formatAmount>${dueAmount}</dsp:formatAmount></strong></td>
          </tr>
        </table>
      </div>
      --%>

      <div style="clear:both">
        <h3><fmt:message key="fine_payments_detail"/></h3>
        
        <%-- CONTENT TABLE --%>
        <table id="result">
          <%-- HEADERS --%>
          <th><fmt:message key="type"/></th>
          <th><fmt:message key="date"/></th>
          <th><fmt:message key="fine_id"/></th>
          <th><fmt:message key="fine_type"/></th>
          <th><fmt:message key="fine_amount"/></th>
          <th><fmt:message key="amount_paid"/></th>
          <th><fmt:message key="obs"/></th>
          
          
          <%-- CONTENT ROWS --%>
          <c:forEach items="${sortedMap}" var="rowMap">
            <c:choose>
              <%-- obtain the original amount so we can print it later --%>
              <%-- print the original fineId with bold font --%>
              <c:when test="${rowMap['transactionId'] eq param.fine_id}">
                <c:set var="originalAmount" value="${rowMap['amount']}"/>
                <tr class="strong">
                  <td><fmt:message key="fine"/></td>
                  <td align="right"><util:formatDate>${rowMap['date']}</util:formatDate></td>
                  <td><a href="view_transaction_details.jsp?transaction_id=${rowMap['transactionId']}">${rowMap['transactionId']}</a></td>
                  <td>${rowMap['type']}</td>
                  <td align="right"><dsp:formatAmount>${rowMap['amount']}</dsp:formatAmount></td>
                  <td></td>
                  <td>${rowMap['obs']}</td>
                </tr>
              </c:when>

              <c:when test="${rowMap['paidAmount'] eq 0}">
                <tr>
                  <td><fmt:message key="cancellation"/></td>
                  <td align="right"><util:formatDate>${rowMap['date']}</util:formatDate></td>
                  <td><a href="view_transaction_details.jsp?transaction_id=${rowMap['transactionId']}">${rowMap['transactionId']}</a></td>
                  <td>${rowMap['type']}</td>
                  <td></td>
                  <td></td>
                  <td>${rowMap['obs']}</td>
                </tr>
                <c:set var="fineCancelled" value="true"/>
              </c:when>

              <%-- compute the sum of issued payments --%>
              <%-- and display the payment info       --%>
              <c:otherwise>
                <tr>
                  <td><fmt:message key="payment"/></td>
                  <td align="right"><util:formatDate>${rowMap['date']}</util:formatDate></td>
                  <td><a href="view_transaction_details.jsp?transaction_id=${rowMap['transactionId']}">${rowMap['transactionId']}</a></td>
                  <td>${rowMap['type']}</td>
                  <td></td>
                  <td align="right"><dsp:formatAmount>${rowMap['paidAmount']}</dsp:formatAmount></td>
                  <td>${rowMap['obs']}</td>
                </tr>
              </c:otherwise>
            </c:choose>
          </c:forEach>


          
          <%-- LAST ROW --%>
          <%-- display only if the fine was not cancelled --%>
          <c:choose>
            <c:when test="${not fineCancelled}">
              <tr><td/><td/><td/><td/><td/><td/></tr>
              <tr class="strong" >
                <td style="border:none;" colspan="3"></td>
                <td><fmt:message key="fine_amount_paid"/></td>
                <td></td>
                <td style="text-align:right;"><strong><dsp:formatAmount>${paymentsTotal}</dsp:formatAmount></td>
                <td style="border:none;"></td>
              </tr>
              <tr class="strong">
                <td style="border:none;" colspan="3"></td>
                <td><fmt:message key="fine_amount_due"/></td>
                <td style="text-align:right;"><dsp:formatAmount>${dueAmount}</dsp:formatAmount></td>
                <td style="border:none;" colspan="2"></td>
              </tr>
            </c:when>
          </c:choose>
        </table>
      </div>
    </div>
  </c:otherwise>
  </c:choose>

