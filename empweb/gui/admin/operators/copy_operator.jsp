<?xml version="1.0"?>
<!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->
<div id="content">
  <h1><fmt:message key="confirmation"/></h1>
  <h2><fmt:message key="copy_operator"/></h2>

  <c:choose>
    <c:when test="${not empty param.copy_operator_no}">
      <c:redirect url="index.jsp"/>
    </c:when>

    <c:when test="${(not empty param.copy_operator_yes)  and (not empty param.source_id) and (not empty param.dest_id)}">
      <admin:adminResult>
        <admin:copyOperator sourceId="${param.source_id}" destId="${param.dest_id}"/>
      </admin:adminResult>
      <p><a href="index.jsp"><fmt:message key="back_to_operators"/></a></p>
    </c:when>

    <c:otherwise>
      <h3><fmt:message key="source_operator_info"/></h3>
      <table>
        <tr>
          <td><fmt:message key="source_operator_name"/></td>
          <td>${param.source_name}</td>
        </tr>
        <tr>
          <td><fmt:message key="source_operator_id"/></td>
          <td>${param.source_id}</td>
        </tr>
      </table>

      <h3><fmt:message key="dest_operator_info"/></h3>
      <form method="get">
        <input type="hidden" name="source_id" value="${param.source_id}"/>
        <input type="hidden" name="source_name" value="${param.source_name}"/>

        <table>
          <tr>
            <td><fmt:message key="dest_operator_id"/></td>
            <td><input type="text" name="dest_id"/><c:if test="${not empty param.copy_operator_yes}"><fmt:message key="required_field"/></c:if></td>
          </tr>
        </table>
        <div class="query">
          <p>
            <fmt:message key="copy_operator_are_you_sure">
              <fmt:param value="${param.source_id}"/>
            </fmt:message>
          </p>
          <input type="submit" name="copy_operator_yes" value="<fmt:message key='yes'/>"/>
          <input type="submit" name="copy_operator_no" value="<fmt:message key='no'/>"/>
        </div>
      </form>
    </c:otherwise>
  </c:choose>
 </div>
