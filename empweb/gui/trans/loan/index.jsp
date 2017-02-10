<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
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
  <h1><fmt:message key="loan"/></h1>
 
 
  <admin:checkEngine var="engineOk"/>

  <c:choose>
    <%-- Engine disabled --%>
    <c:when test="${engineOk ne 'true'}">
      <p class="error"><fmt:message key="engine_disabled_try_again_later"/></p>
      <p><a href=""><fmt:message key="click_here_to_retry_last_transaction"/></a></p>
    </c:when>

    <%-- Engine is enabled --%>
    <c:otherwise>

      <%-- GET DATABASE NAMES --%>
      <c:if test="${not config['ew.hide_user_db'] or not config['ew.hide_object_db']}">
        <x:parse varDom="dbNames">
          <trans:getDatabaseNames/>
        </x:parse>
      </c:if>
      <%-- Check whether the object db comes as a request parameter, or use the one in the operator's property --%>
      <c:choose>
        <c:when test="${not empty param.user_db}">
          <c:set var="userDb" value="${param.user_db}" />
        </c:when>
        <c:otherwise>
          <c:set var="userDb" value="${sessionScope['property-default-user-db']}" />
        </c:otherwise>
      </c:choose>
      <c:choose>
        <c:when test="${not empty param.object_db}">
          <c:set var="objectDb" value="${param.object_db}" />
        </c:when>
        <c:otherwise>
          <c:set var="objectDb" value="${sessionScope['property-default-object-db']}" />
        </c:otherwise>
      </c:choose>
      
      <form method="get" action="user_query_result.jsp">
        <input type="hidden" name="user_name" />
        <input type="hidden" name="copy_ids" />
        <input type="hidden" name="database" value="*" />
      </form>
      
      
      <script>
          function searchUsers()
          {
            document.forms[0].user_name.value=document.forms[1].user_id.value;
            document.forms[0].copy_ids.value=document.forms[1].copy_ids.value;
            document.forms[0].submit();
          }
        </script>


      <form method="get" action="loan_result.jsp">
        <c:if test="${config['ew.hide_user_db']}">
          <input type="hidden" name="user_db" value="${userDb}"/>
        </c:if> 
        <c:if test="${config['ew.hide_object_db']}">
          <input type="hidden" name="object_db"  value="${objectDb}"/>
        </c:if>
        
        
        <table>
          <tr>
            <td><fmt:message key="user_id"/>: </td>
            <td>
              <input type="text" name="user_id" class="textEntry" value="${fn:trim(param.user_id)}" />
              <c:if test="${empty param.user_id and not empty param.submit}"><fmt:message key="required_field"/></c:if>
              <input type="button" value="<fmt:message key="searchuser"/>" OnClick="javascript: searchUsers(); " />
            </td>
          </tr>
          <c:if test="${not config['ew.hide_user_db']}">
            <tr>
              <td><fmt:message key="user_db"/>: </td>
              <td>
                <dsp:selectUserDatabase name="user_db" dbNames="${dbNames}" selectedDb="${userDb}"/>
                <c:if test="${empty param.user_db and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
              </td>
            </tr>
          </c:if>
          <tr>
            <td><fmt:message key="copy_ids"/>:<br/>(<fmt:message key="one_per_line"/>)</td>
            <td>
              <c:choose>
                <c:when test="${not empty (fn:trim(param.copy_ids))}">
                  <c:set var="copy_ids">${fn:trim(param.copy_ids)}</c:set>
                </c:when>
                <c:when test="${not empty (fn:trim(paramValues.retry_copy_id))}">
                  <c:forEach items="${paramValues.retry_copy_id}" var="copy">
                    <c:set var="copy_ids">${copy_ids}${copy}&#10;</c:set>
                  </c:forEach>
                </c:when>
              </c:choose>
              <textarea class="textEntry" name="copy_ids" cols="25" rows="8" ><c:if test="${not empty fn:trim(copy_ids) }">${copy_ids}</c:if></textarea>
              <c:if test="${((empty param.copy_ids ) and (empty paramValues.retry_copy_id)) and not empty param.submit}">
              <fmt:message key="required_field"/>
              </c:if>
            </td>
          </tr>
          <c:if test="${not config['ew.hide_object_db']}">
            <tr>
              <td><fmt:message key="object_db"/>: </td>
              <td>
                <dsp:selectObjectDatabase name="object_db" dbNames="${dbNames}" selectedDb="${objectDb}"/>
                <c:if test="${empty param.object_db and not empty param.submit}"><fmt:message key="required_field"/></c:if>
              </td>
            </tr>
          </c:if>

          <c:if test="${not empty param.accept_end_date}">
            <%-- the loan or reservation possible end date is less than stated in the profile, so ask confirmation --%>
            <tr>
              <td colspan="2">
                <strong><fmt:message key="retry_loan_accept_possible_end_date_less_than_profile"></fmt:message></strong>
                <input type="hidden" name="accept_end_date"  value="${param.accept_end_date}"/>
              </td>
            </tr>
          </c:if>

          <tr>
            <td></td>
            <td><input type="submit" name="submit" value="<fmt:message key="process_loan"/>"/></td>
          </tr>
        </table>
      </form>

    </c:otherwise>
  </c:choose>
  </div>
  <br />

</div>
