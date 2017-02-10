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
<div class="middle homepage">

  <div class="searchBox">

  <h1><fmt:message key="confirmation"/></h1>
  
  <c:choose>
    <c:when test="${not empty param.new_operator_no}">
      <c:redirect url="index.jsp"/>
    </c:when>

    <c:when test="${(not empty param.new_operator_yes)  and (not empty param.id)}">
      <admin:newOperator id="${param.id}"/>
      <p><a href="index.jsp"><fmt:message key="back_to_operators"/></a></p>
    </c:when>

    <c:otherwise>
      <h3><fmt:message key="new_operator_info"/></h3>
      <form method="get">
        <table>
          <tr>
            <td><fmt:message key="new_operator_id"/></td>
            <td><input type="text" name="id" class="textEntry" size="40"/><c:if test="${not empty param.new_operator_yes}"><fmt:message key="required_field"/></c:if></td>
          </tr>
        </table>
        <div class="query">
          <p><fmt:message key="new_operator_are_you_sure"/></p>
          <input type="submit" name="new_operator_yes" value="<fmt:message key='yes'/>"/>
          <input type="submit" name="new_operator_no" value="<fmt:message key='no'/>"/>
        </div>
      </form>
    </c:otherwise>
  </c:choose>
   </div>
 </div>
 
 <br />
