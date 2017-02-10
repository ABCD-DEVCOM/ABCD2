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
  <h2><fmt:message key="delete_operator"/></h2>


  <c:choose>
    <c:when test="${(not empty param.delete_operator_no) or (empty param.id)}">
      <c:redirect url="index.jsp"/>
    </c:when>

    <c:when test="${(not empty param.delete_operator_yes)  and (not empty param.id)}">
      <admin:deleteOperator id="${param.id}"/>      
      <p><a href="index.jsp"><fmt:message key="back_to_operators"/></a></p>

    </c:when>
    <c:otherwise>
	      
      <h3><fmt:message key="delete_operator_info"/></h3>
      <form method="get">
	<input type="hidden" name="id" value="${param.id}"/>
	<div class="query">
	  <p>
	    <fmt:message key="delete_operator_are_you_sure">
	      <fmt:param value="${param.id}"/>
	    </fmt:message>
	  </p>
	  <input type="submit" name="delete_operator_yes" value="<fmt:message key='yes'/>"/>
	  <input type="submit" name="delete_operator_no" value="<fmt:message key='no'/>"/>
	</div>
      </form>

    </c:otherwise>
  </c:choose>

 </div>
