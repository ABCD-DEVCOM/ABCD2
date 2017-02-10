<?xml version="1.0" ?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="kfn"   uri="http://kalio.net/jsp/el-func-1.0" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>

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
    <c:when test="${( (empty fn:trim(param.user_id)) or (empty fn:trim(param.copy_ids)) or
                      (empty fn:trim(param.user_db)) or (empty fn:trim(param.object_db)) )}">
      <c:redirect url="index.jsp">
        <c:if test="${not empty fn:trim(param.user_id) }">
          <c:param name="user_id" value="${param.user_id}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.copy_ids)}">
          <c:param name="copy_ids" value="${param.copy_ids}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.user_db) }">
          <c:param name="user_db" value="${param.user_db}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.object_db) }">
          <c:param name="object_db" value="${param.object_db}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.submit) }">
          <c:param name="submit" value="${param.submit}"/>
        </c:if>
      </c:redirect>
    </c:when>

    <%-- show loan result --%>
    <c:otherwise>
      <h1><fmt:message key="loan"/></h1>
      <h2><fmt:message key="loan_result"/></h2>

      <jsp:useBean id="results" class="java.util.HashMap" />

      <c:choose>
        <c:when test="${not empty param.accept_end_date}">
          <c:forEach items="${kfn:splitLines(param.copy_ids)}" var="cid">
            <c:set target="${results}" property="${cid}">
              <trans:loanSingle
                userId="${fn:trim(param.user_id)}"
                copyId="${fn:trim(cid)}"
                userDb="${fn:trim(param.user_db)}"
                objectDb="${fn:trim(param.object_db)}" 
                acceptEndDate="0" />
            </c:set>
          </c:forEach>
        </c:when>
        <%-- if this is a normal transaction --%>
        <c:otherwise>
          <c:forEach items="${kfn:splitLines(param.copy_ids)}" var="cid">
            <c:if test="${fn:trim(cid) ne ''}">
              <c:set target="${results}" property="${cid}">
                <trans:loanSingle
                  userId="${fn:trim(param.user_id)}"
                  copyId="${fn:trim(cid)}"
                  userDb="${fn:trim(param.user_db)}"
                  objectDb="${fn:trim(param.object_db)}" />
              </c:set>
            </c:if>
          </c:forEach>
        </c:otherwise>
      </c:choose>

      <trans:transResultMulti results="${results}"/>
    </c:otherwise>
  </c:choose>

  <dsp:transactionResultFooter/>

</div>
