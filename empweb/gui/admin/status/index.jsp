<?xml version="1.0"?>
<!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>

<%--
/*
 * Copyright 2004-2005 Kalio.Net
 * All Rights Reserved
 *
 */
--%>
-->

<fmt:setBundle basename="ewi18n.core.engine" var="engineBundle" scope="page"/>

<div class="middle homepage">

  <c:choose>
    <%-- yes button pressed --%>
    <c:when test="${( (not empty param.set_engine_state) and (not empty param.admin_state_engine_code))}">
      <admin:adminResult>
        <admin:setEngineState engineState="${param.admin_state_engine_code}" />
      </admin:adminResult>
    </c:when>
  </c:choose>   

  <%-- get state list --%>
  <x:parse varDom="doc">
    <admin:getEngineStates />
  </x:parse>

  <%-- set engine status --%>
  <h1><fmt:message key="admin_status"/></h1>
  <h2><fmt:message key="admin_status_engine"/></h2>

  <c:choose>
    <c:when test="">
      <p class="error"><fmt:message key="admin_status_error_getting_states"/></p>
    </c:when>

    <c:otherwise>

      <form method="get">
        <p></p>
        <table>
          <tr>
            <th>
              <th><fmt:message key="status"/></th>
          </tr>
          <jsp:useBean id="nsm" class="java.util.HashMap"  />
          <c:set target="${nsm}"  property="e" value="http://kalio.net/empweb/schema/enginestates/v1"/>
          <jxp:forEach
            cnode="${doc}"
            var="ptr"
            select="//e:state"
            nsmap="${nsm}">
            <tr>
              <td><input type="radio" name="admin_state_engine_code" value="${ptr['.']}" ${(ptr['@active'] == 'true')?'checked="true"':''} /></td>
              <td>
                <c:choose>
                  <c:when test="${ptr['@active'] eq 'true'}">
                    <strong><fmt:message key="${ptr['.']}" bundle="${engineBundle}"/></strong>
                  </c:when>
                  <c:otherwise>
                    <fmt:message key="${ptr['.']}" bundle="${engineBundle}"/>
                  </c:otherwise>
                </c:choose>
              </td>
            </tr>
          </jxp:forEach>
        </table>
        <input type="submit" name="set_engine_state" value="<fmt:message key="admin_status_set_state"/>"/>
      </form>

    </c:otherwise>
  </c:choose>

</div>
