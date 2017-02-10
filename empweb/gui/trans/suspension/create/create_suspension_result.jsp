<?xml version="1.0" ?><!--
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

-->

<div class="middle homepage">

  <c:choose>

    <%-- when a field is missing, reject with available parameters --%>
    <c:when test="${( (empty fn:trim(param.user_id)) or (empty fn:trim(param.user_db)) or 
                      (empty fn:trim(param.suspension_days)) or
                      (fn:trim(param.suspension_days) lt 1) )}">
      <c:redirect url="index.jsp">
        <c:if test="${not empty fn:trim(param.suspension_days) }">
          <c:param name="suspension_days" value="${param.suspension_days}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.user_id) }">
          <c:param name="user_id" value="${param.user_id}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.user_db) }">
          <c:param name="user_db" value="${param.user_db}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.obs) }">
          <c:param name="obs" value="${param.obs}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.submit) }">
          <c:param name="submit" value="${param.submit}"/>
        </c:if>
      </c:redirect>
    </c:when>


    <%-- show create_suspension result --%>
    <c:otherwise>
      <h1><fmt:message key="create_suspension"/></h1>
      <h2><fmt:message key="create_suspension_result"/></h2>

      <trans:transResult> 
        <trans:createSuspensionSingle
          userId="${fn:trim(param.user_id)}"
          userDb="${fn:trim(param.user_db)}" 
          daysSuspended="${fn:trim(param.suspension_days)}"
          operatorId="${sessionScope.user}" 
          obs="${fn:trim(param.obs)}" 
          />
      </trans:transResult> 
    </c:otherwise>

  </c:choose>

  <dsp:transactionResultFooter depth="3"/>
  
</div>
