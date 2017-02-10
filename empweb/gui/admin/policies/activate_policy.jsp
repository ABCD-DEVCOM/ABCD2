<?xml version="1.0"?>
<!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
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
  <h2><fmt:message key="activate_policy"/></h2>


  <c:choose>
    <%-- no button pressed --%>
    <c:when test="${not empty param.activate_policy_no}">
      <c:redirect url="index.jsp"/>
    </c:when>

    <%-- yes button pressed --%>
    <c:when test="${(not empty param.activate_policy_yes) and (not empty param.id)}">
      <admin:adminResult>
        <admin:activatePolicy id="${param.id}"/>
      </admin:adminResult>
      <p><a href="index.jsp"><fmt:message key="back_to_policies"/></a></p>
    </c:when>

    <%-- activate policy page content --%>
    <c:otherwise>
      <form method="get">
        <input type="hidden" name="id" value="${param.id}"/>
        <table>
          <tr>
            <td><fmt:message key="policy_name"/></td>
            <td>${param.name}</td>
          </tr>
          <tr>
            <td><fmt:message key="policy_id"/></td>
            <td>${param.id}</td>
          </tr>
        </table>
        <div class="query">
          <p><fmt:message key="activate_policy_are_you_sure"/></p>
          <input type="submit" name="activate_policy_yes" value="<fmt:message key='yes'/>"/>
          <input type="submit" name="activate_policy_no" value="<fmt:message key='no'/>"/>
        </div>
      </form>
    </c:otherwise>

  </c:choose>
 </div>
