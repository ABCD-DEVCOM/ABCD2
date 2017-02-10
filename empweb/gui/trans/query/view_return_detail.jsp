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


<!--<trans:getReturnByLoanId id="${transaction_id}"/>-->
<%-- GO FISH --%>
<c:choose>



  <c:when test="${not empty transaction_id}">
    <x:parse varDom="transactionResult">
      <trans:getReturnByLoanId id="${transaction_id}"/>
    </x:parse>
    <jxp:set cnode="${transactionResult}" var="transactionInfo" select="//*[local-name()='return']" />
    <c:set var="transactionType"><jxp:out  cnode="${transactionInfo}" select="local-name()" /></c:set>

    <%-- get the user status for the transaction --%>
    <c:set var="user_id"><jxp:out  cnode="${transactionInfo}" select="//*[local-name()='userId']" /></c:set>
    <c:set var="user_db"><jxp:out  cnode="${transactionInfo}" select="//*[local-name()='userDb']" /></c:set>    
    <c:set var="profile_id"><jxp:out cnode="${transactionInfo}" select="//*[local-name()='profile']/@id" /></c:set>
    <c:set var="ref_id"><jxp:out cnode="${transactionInfo}" select="//*[local-name()='ref']/@id" /></c:set>

    
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

    <dsp:return with_links="true" doc="${transactionInfo}"/>

    <%-- PROFILE DETAILS, IF ANY --%>
    <c:if test="${not empty profile_id}">
      <x:parse varDom="profileInfo">
        <admin:getProfile id="${profile_id}"/>
      </x:parse>

      <br/>
      <h2><fmt:message key="profile" /></h2>
      <dsp:profile doc="${profileInfo}"/>
    </c:if>


  

</div>


