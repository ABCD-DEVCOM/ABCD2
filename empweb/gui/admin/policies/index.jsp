<?xml version="1.0"?>
<!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->


<div class="middle homepage">
  <x:parse var="doc">
    <admin:getPolicies />
  </x:parse>

  <h1><fmt:message key="policies_admin"/></h1>
  <h2><fmt:message key="policies_list"/></h2>



  <table id="result">
    <tr>
      <th><fmt:message key="policy_status"/></th>
      <th><fmt:message key="policy_name"/></th>
      <th><fmt:message key="actions"/></th>
    </tr>

    <jsp:useBean id="nsm" class="java.util.HashMap" />
    <c:set target="${nsm}" property="p" value="http://kalio.net/empweb/schema/policy/v1" />

    <jxp:forEach cnode="${doc}" var="ptr" select="//p:policy" nsmap="${nsm}">
      <c:set var="polId" value="${ptr['@id']}" />
      <c:set var="polName" value="${ptr['p:name']}" />

      <tr>
        <td>
          <c:if test="${ptr['@active'] eq 'true'}">
            <strong><fmt:message key="active_policy"/></strong>
          </c:if>
        </td>

        <td>
          <c:choose>
            <c:when test="${ptr['@active'] eq 'true'}">
              <strong>${polName}</strong>
            </c:when>
            <c:otherwise>
              ${polName}
            </c:otherwise>
          </c:choose>
        </td>

        <td>
          <a href="activate_policy.jsp?id=${ptr['@id']}&amp;name=${ptr['p:name']}">
            <fmt:message key="activate"/>
          </a> |
          <a href="edit_policy.jsp?id=${polId}">
            <fmt:message key="edit"/>
          </a> |
          <a href="copy_policy.jsp?id=${polId}&amp;name=${polName}">
            <fmt:message key="copy"/>
          </a> |
          <a href="delete_policy.jsp?id=${polId}&amp;name=${polName}">
            <fmt:message key="delete"/>
          </a>
        </td>
      </tr>
    </jxp:forEach>

    <tr>
      <td colspan="2">
      </td>
      <td>
        <a href="new_policy.jsp">
          <fmt:message key="create_new_policy" />
        </a>
      </td>
    </tr>
  </table>

</div>
