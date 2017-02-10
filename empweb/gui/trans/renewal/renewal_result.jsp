<?xml version="1.0" ?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
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
    <c:when test="${((empty fn:trim(param.copy_ids)) or
                       (empty fn:trim(param.object_db))) }">
      <c:redirect url="index.jsp">
        <c:if test="${not empty fn:trim(param.copy_ids)}">
          <c:param name="copy_ids" value="${param.copy_ids}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.object_db) }">
          <c:param name="object_db" value="${param.object_db}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.submit) }">
          <c:param name="submit" value="${param.submit}"/>
        </c:if>
      </c:redirect>
    </c:when>


    <%-- show renewal result --%>
    <c:otherwise>
      <h1><fmt:message key="renewal"/></h1>
      <h2><fmt:message key="renewal_result"/></h2>

      <c:forEach items="${kfn:splitLines(param.copy_ids)}" var="cid">
        <c:if test="${fn:trim(cid) ne ''}">
          <trans:transResult>
            <trans:renewalSingle
              userId="${fn:trim(param.user_id)}"
              copyId="${fn:trim(cid)}"
              userDb="${fn:trim(param.user_db)}"
              objectDb="${fn:trim(param.object_db)}" />
          </trans:transResult>
        </c:if>
      </c:forEach>
    </c:otherwise>

  </c:choose>

  <dsp:transactionResultFooter/>

</div>
