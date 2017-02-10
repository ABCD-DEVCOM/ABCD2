<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
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

<div class="middle homepage">

  <h1><fmt:message key="confirmation"/></h1>
  <h2><fmt:message key="delete_process"/></h2>


  <c:choose>
    <%-- no button pressed --%>
    <c:when test="${not empty param.delete_process_no}">
      <c:redirect url="edit_pipeline.jsp?name=${param.pipeline_name}"/>
    </c:when>

    <%-- yes button pressed --%>
    <c:when test="${((not empty param.delete_process_yes) and (not empty param.type) and (not empty fn:trim(param.name)) and (not empty fn:trim(param.pipeline_name)))}">
      <admin:adminResult>
        <admin:deleteProcess
            processType="${param.type}"
            processName="${fn:trim(param.name)}"
            pipelineName="${fn:trim(param.pipeline_name)}" />
      </admin:adminResult>
      <p><a href="edit_pipeline.jsp?name=${param.pipeline_name}"><fmt:message key="back_to_pipeline"><fmt:param>${param.pipeline_name}</fmt:param></fmt:message></a></p>
    </c:when>

    <%-- delete process page content --%>
    <c:otherwise>
      <form method="get">
        <input type="hidden" name="pipeline_name" value="${param.pipeline_name}"/>
        <input type="hidden" name="name" value="${param.name}"/>
        <input type="hidden" name="type" value="${param.type}"/>
        <table>
          <tr>
            <td><fmt:message key="pipeline"/></td>
            <td>${param.pipeline_name}</td>
          </tr>
          <tr>
            <td><fmt:message key="process_type"/></td>
            <td>${param.type}</td>
          </tr>
          <tr>
            <td><fmt:message key="process_name"/></td>
            <td>${param.name}</td>
          </tr>
        </table>
        <div class="query">
          <p><fmt:message key="delete_process_are_you_sure"/></p>
          <input type="submit" name="delete_process_yes" value="<fmt:message key='yes'/>"/>
          <input type="submit" name="delete_process_no" value="<fmt:message key='no'/>"/>
        </div>
      </form>
    </c:otherwise>

  </c:choose>

 </div>