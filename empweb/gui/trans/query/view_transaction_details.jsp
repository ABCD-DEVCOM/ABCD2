<?xml version="1.0"?><!--<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
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
<fmt:setBundle basename="ewi18n.core.gui" scope="page"/>


<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="uinfo" value="http://kalio.net/empweb/schema/users/v1" />
<c:set target="${nsm}" property="ustat" value="http://kalio.net/empweb/schema/userstatus/v1" />
<c:set target="${nsm}" property="s"     value="http://kalio.net/empweb/schema/suspension/v1" />
<c:set target="${nsm}" property="f"     value="http://kalio.net/empweb/schema/fine/v1" />
<c:set target="${nsm}" property="w"     value="http://kalio.net/empweb/schema/wait/v1" />
<c:set target="${nsm}" property="r"     value="http://kalio.net/empweb/schema/reservation/v1" />
<c:set target="${nsm}" property="l"     value="http://kalio.net/empweb/schema/loan/v1" />
<c:set target="${nsm}" property="h"     value="http://kalio.net/empweb/schema/holdingsinfo/v1" />
<c:set target="${nsm}" property="mods"  value="http://www.loc.gov/mods/v3" />

<c:set var="transaction_id" value="${fn:trim(param.transaction_id)}"/>

<%-- GO FISH --%>
<c:choose>

  <c:when test="${not empty transaction_id}">
    <x:parse varDom="transactionResult">
      <trans:getTransactionById id="${transaction_id}"/>
    </x:parse>
    <jxp:set cnode="${transactionResult}" var="transactionInfo" select="//*[@id='${transaction_id}']" />
    <c:set var="transactionType"><jxp:out  cnode="${transactionInfo}" select="local-name()" /></c:set>

    <%-- get the user status for the transaction --%>
    <c:set var="user_id"><jxp:out  cnode="${transactionInfo}" select="//*[local-name()='userId']" /></c:set>
    <c:set var="user_db"><jxp:out  cnode="${transactionInfo}" select="//*[local-name()='userDb']" /></c:set>    
    <c:set var="profile_id"><jxp:out cnode="${transactionInfo}" select="//*[local-name()='profile']/@id" /></c:set>
    <c:set var="ref_id"><jxp:out cnode="${transactionInfo}" select="//*[local-name()='ref']/@id" /></c:set>

    <%-- keep the original fine id --%>
    <c:set var="original_fine_id">${ref_id}</c:set>
    <c:if test="${empty original_fine_id}">
      <c:set var="original_fine_id">${transaction_id}</c:set>
    </c:if>

    <x:parse varDom="userInfoResult">
      <trans:searchUsersById database="${user_db}">${user_id}</trans:searchUsersById>
    </x:parse>
  </c:when>

  <c:otherwise>
    <c:redirect url="index.jsp"/>
  </c:otherwise>
</c:choose>

<div class="middle homepage">
  <h1><fmt:message key="transaction_details"/></h1>

  <%-- show errors, if any --%>
  <trans:showErrors  doc="${transactionResult}" />

  <%-- TRANSACTION INFO --%>
  <%-- LOAN --%>
  <c:if test="${transactionType eq 'loan'}">
    <h2><fmt:message key="loan_info"/></h2>
    <dsp:loan with_links="true" doc="${transactionInfo}"/>

    <%-- PROFILE DETAILS, IF ANY --%>
    <c:if test="${not empty profile_id}">
      <x:parse varDom="profileInfo">
        <admin:getProfile id="${profile_id}"/>
      </x:parse>

      <br/>
      <h2><fmt:message key="profile" /></h2>
      <dsp:profile doc="${profileInfo}"/>
    </c:if>
  </c:if>


  <%-- RESERVATION --%>
  <c:if test="${transactionType eq 'reservation'}">
    <h2><fmt:message key="reservation_info"/></h2>
    <dsp:reservation with_links="true" doc="${transactionInfo}"/>
  </c:if>

  <%-- FINE --%>
  <c:if test="${transactionType eq 'fine'}">
    <h2><fmt:message key="fine_info"/></h2>
    <dsp:fine with_links="true" doc="${transactionInfo}"/>

    <h2><fmt:message key="fine_history"/></h2>
    <p>
      <a href="fine_status_result.jsp?fine_id=${original_fine_id}">
        <fmt:message key="details"/>
      </a>
    </p>    

  </c:if>

  <%-- SUSPENSION --%>
  <c:if test="${transactionType eq 'suspension'}">
    <h2><fmt:message key="suspension_info"/></h2>
    <dsp:suspension with_links="true" doc="${transactionInfo}"/>
  </c:if>


  <!-- USER INFO -->
  <c:if test="${(not empty user_id) and (not empty user_db)}">
    <h2><fmt:message key="user_info"/></h2>
    <dsp:user doc="${userInfoResult}" select="//uinfo:userCollection" nsmap="${nsm}"/>
    <br/>
  </c:if>


</div>


