<?xml version="1.0" ?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>

<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->

<div id="content">
  <h1><fmt:message key="fine"/></h1>
  <h2><fmt:message key="fine_tracking_form"/></h2>

  <admin:checkEngine var="engineOk"/>

  <c:choose>
    <%-- Engine disabled --%>
    <c:when test="${engineOk ne 'true'}">
      <p class="error"><fmt:message key="engine_disabled_try_again_later"/></p>
      <p><a href=""><fmt:message key="click_here_to_retry_last_transaction"/></a></p>
    </c:when>

    <%-- Engine is enabled --%>
    <c:otherwise>

      <form method="get" action="track_fine_result.jsp">
        <%-- needed for redirection back to the status after processing --%>
        <input type="hidden" name="user_id" value="${param.user_id}"/>
        <input type="hidden" name="user_db" value="${param.user_db}"/>
        <table>
          <tr>
            <td><fmt:message key="fine_id"/>:</td>
            <td>
              <input type="text" name="fine_id"
                <c:if test="${not empty fn:trim(param.fine_id) }">
                  value="${param.fine_id}"
                </c:if>
                >
              </input>
              <c:if test="${empty param.fine_id and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
            </td>
          </tr>
          <tr>
            <td></td>
            <td><input type="submit" name="submit" value="<fmt:message key="track_fine"/>"/></td>
          </tr>
        </table>
      </form>
    </c:otherwise>
  </c:choose>
</div>
