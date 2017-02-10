<?xml version="1.0"?>
<!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
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
  <h2><fmt:message key="copy_policy"/></h2>


  <c:choose>
    <c:when test="${not empty param.copy_policy_no}">
      <c:redirect url="index.jsp"/>
    </c:when>

    <c:when test="${(not empty param.copy_policy_yes) and (not empty param.id) and (not empty param.dest_name)}">
      <admin:adminResult>
        <admin:copyPolicy sourceId="${param.id}" destName="${param.dest_name}"/>
      </admin:adminResult>
      <p><a href="index.jsp"><fmt:message key="back_to_policies"/></a></p>
    </c:when>

    <c:otherwise>

      <h3><fmt:message key="source_policy_info"/></h3>
      <table>
        <tr>
          <td><fmt:message key="source_policy_name"/></td>
          <td>${param.name}</td>
        </tr>
        <tr>
          <td><fmt:message key="source_policy_id"/></td>
          <td>${param.id}</td>
        </tr>
      </table>


      <h3><fmt:message key="dest_policy_info"/></h3>
      <form method="get">
        <input type="hidden" name="id" value="${param.id}"/>
        <input type="hidden" name="name" value="${param.name}"/>
        <table>
          <tr>
            <td><fmt:message key="dest_policy_name"/></td>
            <td><input type="text" name="dest_name"/><c:if test="${not empty param.copy_policy_yes}"> <fmt:message key="required_field"/></c:if></td>
          </tr>
        </table>

        <div class="query">
          <p><fmt:message key="copy_policy_are_you_sure"/></p>
          <input type="submit" name="copy_policy_yes" value="<fmt:message key='yes'/>"/>
          <input type="submit" name="copy_policy_no" value="<fmt:message key='no'/>"/>
        </div>
      </form>

    </c:otherwise>
  </c:choose>
<br/>
 </div>
 
