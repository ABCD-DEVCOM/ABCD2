<?xml version="1.0"?>
<!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>

<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->

<div class="middle homepage">
  <h1><fmt:message key="confirmation"/></h1>
  <h2><fmt:message key="admin_bases_initdb"/></h2>

  <c:choose>
    <%-- no button pressed --%>
    <c:when test="${not empty param.init_database_no}">
      <c:redirect url="index.jsp"/>
    </c:when>

    <%-- yes button pressed --%>
    <c:when test="${(not empty param.init_database_yes)}">
      <admin:adminResult showSuccess="true">
        <admin:initDatabases/>
      </admin:adminResult>
    </c:when>

    <%-- init database page content --%>
    <c:otherwise>
      <form method="get">
        <p><fmt:message key="admin_bases_initMsg"/></p>
        <div class="query">
          <p><fmt:message key="init_database_are_you_sure"/></p>
          <input type="submit" name="init_database_yes" value="<fmt:message key='yes'/>"/>
          <input type="submit" name="init_database_no" value="<fmt:message key='no'/>"/>
        </div>
      </form>
    </c:otherwise>
  </c:choose>
</div>
