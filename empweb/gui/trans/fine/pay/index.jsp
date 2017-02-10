<?xml version="1.0" ?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>

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

  <h1><fmt:message key="fine"/></h1>
  <h2><fmt:message key="fine_payment_form"/></h2>

  <admin:checkEngine var="engineOk"/>

  <c:choose>
    <%-- Engine disabled --%>
    <c:when test="${engineOk ne 'true'}">
      <p class="error"><fmt:message key="engine_disabled_try_again_later"/></p>
      <p><a href=""><fmt:message key="click_here_to_retry_last_transaction"/></a></p>
    </c:when>

    <%-- Engine is enabled --%>
    <c:otherwise>

      <form method="get" action="pay_fine_result.jsp">
        <%-- needed for redirection back to the status after processing --%>
        <input type="hidden" name="user_id" value="${param.user_id}"/>
        <input type="hidden" name="user_db" value="${param.user_db}"/>

        <table>
          <tr>
            <td><fmt:message key="fine_id"/>:</td>
            <td>
              <input type="text" name="fine_id" class="textEntry" 
                <c:if test="${not empty fn:trim(param.fine_id) }">
                  value="${param.fine_id}"
                </c:if>
                >
              </input>
              <c:if test="${empty param.fine_id and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
            </td>
          </tr>

          <tr>
            <td><fmt:message key="amount_paid"/>:</td>
            <td>
              <input type="text" name="fine_paid_amount" class="textEntry" 
                <c:if test="${not empty fn:trim(param.fine_paid_amount) }">
                  value="${param.fine_paid_amount}"
                </c:if>
                >
              </input>
              <c:choose>

                <c:when test="${not empty param.submit}"> 
                  <%-- check if the amount has only numbers --%>
                  <util:isNumber var="fine_amount_is_number">${fn:trim(param.fine_paid_amount)}</util:isNumber>
                  <c:choose>
                    <c:when test="${empty fn:trim(param.fine_paid_amount) or (not fine_amount_is_number)}"> a ${fine_amount_is_number} a<fmt:message key="wrong_value"/></c:when>
                    <c:otherwise>
                      <c:if test="${fn:trim(param.fine_paid_amount) le 0}"><fmt:message key="wrong_value"/></c:if>
                    </c:otherwise>
                  </c:choose>
                </c:when>

                <c:otherwise>
                  (<fmt:message key="fine_amount"/>: ${param.fine_amount})
                </c:otherwise>
              </c:choose>
            </td>
          </tr>


          <tr>
            <td><fmt:message key="obs"/>:</td>
            <td>
              <c:choose>
                <c:when test="${config['gui.picklist.pf'] eq 'true'}">
                  <select name="obs">
                    <c:forTokens items="${config['gui.picklist.pf.items']}" delims="," var="item">
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
            <td><input type="submit" name="submit" value="<fmt:message key="pay_fine"/>"/></td>
          </tr>
        </table>
      </form>
    </c:otherwise>
  </c:choose>
  </div>
  
  <br />
  
</div>
