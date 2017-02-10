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

<div id="content">
  <h1><fmt:message key="confirmation"/></h1>
  <h2><fmt:message key="order_process"/></h2>


  <c:choose>
    <c:when test="${( (not empty fn:trim(param.dir)) and
                      ((param.dir eq 'up') or (param.dir eq 'down')) and
                      (not empty fn:trim(param.name)) and
                      (not empty fn:trim(param.pipeline_name)))}">
      <admin:adminResult>
        <admin:orderProcess
              direction="${fn:trim(param.dir)}"
              processName="${fn:trim(param.name)}"
              pipelineName="${fn:trim(param.pipeline_name)}" />
      </admin:adminResult>

      <c:redirect url="edit_pipeline.jsp?name=${param.pipeline_name}&moved=${param.name}"/>
    </c:when>

    <c:when test="${not empty fn:trim(param.pipeline_name)}">
      <c:redirect url="edit_pipeline.jsp?name=${param.pipeline_name}"/>
    </c:when>

    <c:otherwise>
      <c:redirect url="index.jsp"/>
    </c:otherwise>

  </c:choose>

 </div>