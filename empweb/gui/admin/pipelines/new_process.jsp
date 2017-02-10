<?xml version="1.0"?>
<!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
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
  <h1><fmt:message key="confirmation"/></h1>
  <h2><fmt:message key="new_process"/></h2>


  <c:choose>

    <c:when test="${not empty param.new_process_no}">
      <c:redirect url="index.jsp"/>
    </c:when>

    <c:when test="${((not empty param.new_process_yes) and (not empty param.type) and (not empty fn:trim(param.name)) and (not empty fn:trim(param.class)) and (not empty fn:trim(param.pipeline_name)))}">
      <admin:adminResult>
        <admin:newProcess
          processType="${param.type}" 
          processName="${fn:trim(param.name)}" 
          processClass="${fn:trim(param.class)}" 
          pipelineName="${fn:trim(param.pipeline_name)}" />
     </admin:adminResult>
      <p><a href="edit_pipeline.jsp?name=${param.pipeline_name}"><fmt:message key="back_to_pipeline"><fmt:param>${param.pipeline_name}</fmt:param></fmt:message></a></p>
    </c:when>

    <c:otherwise>
      <h3><fmt:message key="new_process_info"/></h3>
      <form method="get">
        <input type="hidden" name="pipeline_name" value="${param.pipeline_name}"/>
        <table>
          <tr>
            <td><fmt:message key="new_process_type"/></td>
            <td>
              <select name="type">
                <option value="rule"><fmt:message key="process_rule"/> (<fmt:message key="process_rule_desc"/>)</option>
                <option value="process"><fmt:message key="process_process"/> (<fmt:message key="process_process_desc"/>)</option>
                <option value="finally"><fmt:message key="process_finally"/> (<fmt:message key="process_finally_desc"/>)</option>
              </select>
              <c:if test="${not empty param.new_process_yes}"> <fmt:message key="required_field"/></c:if></td>
          </tr>
        </table>

        <table>
          <tr>
            <td><fmt:message key="new_process_name"/></td>
            <td><input type="text" name="name" style="width:40em;" /><c:if test="${not empty param.new_process_yes}"> <fmt:message key="required_field"/></c:if></td>
          </tr>
        </table>

        <table>
          <tr>
            <td><fmt:message key="new_process_class"/></td>
            <td><input type="text" name="class" style="width:40em;" /><c:if test="${not empty param.new_process_yes}"> <fmt:message key="required_field"/></c:if></td>
          </tr>
        </table>

        <div class="query">
          <p><fmt:message key="new_process_are_you_sure"/></p>
          <input type="submit" name="new_process_yes" value="<fmt:message key='yes'/>"/>
          <input type="submit" name="new_process_no" value="<fmt:message key='no'/>"/>
        </div>
      </form>
    </c:otherwise>

  </c:choose>
 </div>
