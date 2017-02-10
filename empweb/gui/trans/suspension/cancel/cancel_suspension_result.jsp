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
    <c:when test="${( (empty fn:trim(param.suspension_id)) or (empty fn:trim(param.obs)) )}">
      <c:redirect url="index.jsp">
        <c:if test="${not empty fn:trim(param.suspension_id)}">
          <c:param name="suspension_id" value="${param.suspension_id}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.obs) }">
          <c:param name="obs" value="${param.obs}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.submit) }">
          <c:param name="submit" value="${param.submit}"/>
        </c:if>
      </c:redirect>
    </c:when>


    <%-- show remove suspension result --%>
    <c:otherwise>
      <h1><fmt:message key="remove_suspension"/></h1>
      <h2><fmt:message key="remove_suspension_result"/></h2>

      <c:forEach items="${kfn:splitLines(param.suspension_id)}" var="sid">
        <c:if test="${fn:trim(sid) ne ''}">

          <trans:transResult>
            <trans:cancelSuspensionSingle
              suspensionId="${fn:trim(sid)}"
              operatorId="${sessionScope.user}"
              obs="${fn:trim(param.obs)}" />
          </trans:transResult>
        </c:if>
      </c:forEach>
    </c:otherwise>

  </c:choose>

  <dsp:transactionResultFooter depth="3"/>

</div>
