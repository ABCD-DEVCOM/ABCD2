<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="kfn"   uri="http://kalio.net/jsp/el-func-1.0" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="jxp"   tagdir="/WEB-INF/tags/commons/jxp" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->

<c:set var="sort_by" value="${fn:trim(param.sort_by)}"/>
<c:set var="sort_order" value="${(not empty fn:trim(param.sort_order))?fn:trim(param.sort_order):'ascending' }"/>


<div class="middle homepage">
  <x:parse varDom="doc">
    <admin:getOperators />
  </x:parse>

  <h1><fmt:message key="operators_admin"/></h1>
  <h2><fmt:message key="operators_list"/></h2>

  <form method="post" action="activate_policy.jsp">

    <table id="result">
      <tr>
        <th><a href="?sort_by=id&amp;sort_order=${sort_order}"><fmt:message key="operator_id"/></a></th>
        <th><a href="?sort_by=name&amp;sort_order=${sort_order}"><fmt:message key="operator_name"/></a></th>
        <th><a href="?sort_by=email&amp;sort_order=${sort_order}"><fmt:message key="email"/></a></th>
        <th><fmt:message key="status"/></th>
        <th><fmt:message key="actions"/></th>
      </tr>

      <jxp:forEach cnode="${doc}" var="op" select="/operators/operator" sortby="${sort_by}" sortorder="${sort_order}">
        <tr>
          <td>${op['@id']}</td>
          <td>${op['name']}</td>
          <td>${op['email']}</td>
          <c:set var="accEnabled"><jxp:out cnode="${op}" select="/properties/property[@id='accountenabled']"/></c:set>
          <td>
            <c:if test="${accEnabled ne 'on'}"><fmt:message key="disabled"/></c:if>
          </td>
          <td>
            <a href="edit_operator.jsp?id=${kfn:urlenc(op['@id'])}">
              <fmt:message key="edit"/>
            </a> |
            <a href="copy_operator.jsp?source_id=${kfn:urlenc(op['@id'])}&amp;source_name=${kfn:urlenc(op['name'])}">
              <fmt:message key="copy"/>
            </a> |
            <c:if test="${op['@id'] ne 'admin'}">
              <a href="delete_operator.jsp?id=${kfn:urlenc(op['@id'])}">
                <fmt:message key="delete"/>
              </a>
            </c:if>
          </td>
        </tr>
      </jxp:forEach>

      <tr>
        <td colspan="4">
          <a href="new_operator.jsp"><fmt:message key="create_new_operator" /></a>
        </td>
      </tr>
    </table>
  </form>
</div>
