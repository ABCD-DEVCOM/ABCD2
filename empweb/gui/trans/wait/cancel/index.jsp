<?xml version="1.0"?><!--
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

<div class="middle homepage">

  <div class="searchBox">
  
  <h1><fmt:message key="cancel_wait"/></h1>
  <h2><fmt:message key="cancel_wait_form"/></h2>

  <admin:checkEngine var="engineOk"/>

  <c:choose>
    <%-- Engine disabled --%>
    <c:when test="${engineOk ne 'true'}">
      <p class="error"><fmt:message key="engine_disabled_try_again_later"/></p>
      <p><a href=""><fmt:message key="click_here_to_retry_last_transaction"/></a></p>
    </c:when>

    <%-- Engine is enabled --%>
    <c:otherwise>

      <form method="get" action="cancel_wait_result.jsp">
        <%-- needed for redirection back to the status after processing --%>
        <input type="hidden" name="user_id" value="${param.user_id}"/>
        <input type="hidden" name="user_db" value="${param.user_db}"/>
  
        <table>
          <tr>
            <td><fmt:message key="wait_id"/>:</td>
            <td>
              <input type="text" name="wait_id" class="textEntry"
                <c:if test="${not empty fn:trim(param.wait_id) }">
                  value="${param.wait_id}"
                </c:if>
              </input>
              <c:if test="${empty param.wait_id and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
            </td>
          </tr>

          <tr>
            <td><fmt:message key="obs"/>:</td>
            <td>
              <c:choose>
                <c:when test="${config['gui.picklist.cr'] eq 'true'}">
                  <select name="obs">
                    <c:forTokens items="${config['gui.picklist.cr.items']}" delims="," var="item">
                      <option value="${item}">${item}</option>
                    </c:forTokens>
                  </select>
                </c:when>
                <c:otherwise>
                  <textarea name="obs" cols="25" rows="3" class="textEntry"><c:if test="${not empty fn:trim(param.obs) }">${param.obs}</c:if></textarea>
                </c:otherwise>
              </c:choose>
            </td>
          </tr>

          <tr>
            <td></td>
            <td><input type="submit" name="submit" value="<fmt:message key="cancel_wait"/>"/></td>
          </tr>
        </table>
      </form>

    </c:otherwise>
  </c:choose>
  
  </div>
  
  <br />
  
</div>

