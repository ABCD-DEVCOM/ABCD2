<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%@ taglib prefix="kfn"   uri="http://kalio.net/jsp/el-func-1.0" %>

<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>

<div class="middle homepage">
  <c:set var="user_id"     value="${fn:trim(param.user_id)}"/>
  <c:set var="user_db"     value="${fn:trim(param.user_db)}"/>
  <c:set var="fine_amount" value="${fn:trim(param.fine_amount)}"/>
  <c:set var="obs"              value="${fn:trim(param.obs)}"/>

  <%-- the following check also wont allow decimal numbers --%>
  <util:isNumber var="fine_amount_is_number">${fine_amount}</util:isNumber>

  <c:choose>
    <%-- check if the amount has only numbers --%>
    <c:when test="${not fine_amount_is_number}">
      <c:redirect url="index.jsp">
        <c:if test="${not empty fine_amount }"><c:param name="fine_amount" value="${fine_amount}"/></c:if>
        <c:if test="${not empty user_id }"><c:param name="user_id" value="${user_id}"/></c:if>
        <c:if test="${not empty user_db }"><c:param name="user_db" value="${user_db}"/></c:if>
        <c:if test="${not empty obs }"><c:param name="user_id" value="${obs}"/></c:if>
        <c:if test="${not empty fn:trim(param.submit) }"><c:param name="submit" value="${param.submit}"/></c:if>
      </c:redirect>
    </c:when>

    <%-- when a field is missing, reject with available parameters --%>
    <c:when test="${( (empty user_id) or (empty user_db) or (empty fine_amount) or (fine_amount le 0) )}">
      <c:redirect url="index.jsp">
        <c:if test="${not empty fine_amount }"><c:param name="fine_amount" value="${fine_amount}"/></c:if>
        <c:if test="${not empty user_id }"><c:param name="user_id" value="${user_id}"/></c:if>
        <c:if test="${not empty user_db }"><c:param name="user_db" value="${user_db}"/></c:if>
        <c:if test="${not empty obs }"><c:param name="user_id" value="${obs}"/></c:if>
        <c:if test="${not empty fn:trim(param.submit) }"><c:param name="submit" value="${param.submit}"/></c:if>
      </c:redirect>
    </c:when>


    <%-- show create_fine result --%>
    <c:otherwise>
      <h1><fmt:message key="create_fine"/></h1>
      <h2><fmt:message key="create_fine_result"/></h2>

      <trans:transResult> 
        <trans:createFineSingle
          amount="${fine_amount}"
          userId="${user_id}"
          userDb="${user_db}" 
          operatorId="${sessionScope.user}" 
          obs="${obs}" 
          />
      </trans:transResult> 
    </c:otherwise>

  </c:choose>

  <dsp:transactionResultFooter depth="3"/>
  
</div>
