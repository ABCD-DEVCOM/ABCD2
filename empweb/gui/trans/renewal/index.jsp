<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>


<div class="middle homepage">

  <div class="searchBox">

  <h1><fmt:message key="renewal"/></h1>
  
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
        <input type="hidden" name="database" value="*" />
      </form>
      
      
      <script>
          function searchUsers()
          {
            document.forms[0].user_name.value=document.forms[1].user_id.value;
            document.forms[0].submit();
          }
       </script>


      <form method="get" action="renewal_result.jsp">
        <c:if test="${config['ew.hide_user_db']}">
          <input type="hidden" name="user_db" value="${userDb}"/>
        </c:if> 
        <c:if test="${config['ew.hide_object_db']}">
          <input type="hidden" name="object_db"  value="${objectDb}"/>
        </c:if> 
        <table>
         
          <tr>
            <td><fmt:message key="copy_ids"/>:<br/>(<fmt:message key="one_per_line"/>)</td>
            <td>
              <textarea name="copy_ids" cols="25" rows="8" class="textEntry"><c:if test="${not empty fn:trim(param.copy_ids) }">${param.copy_ids}</c:if></textarea>
              <c:if test="${empty param.copy_ids and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
            </td>
          </tr>
          <c:if test="${not config['ew.hide_object_db']}">
            <tr>
              <td><fmt:message key="object_db"/>: </td>
              <td>
                <dsp:selectObjectDatabase name="object_db" dbNames="${dbNames}" selectedDb="${objectDb}"/>
                <c:if test="${empty param.object_db and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
              </td>
            </tr>
          </c:if>
          <tr>
            <td></td>
            <td><input type="submit" name="submit" value="<fmt:message key="process_renewal"/>"/></td>
          </tr>
        </table>
      </form>

    </c:otherwise>
  </c:choose>
  
  </div>
  	<div class="spacer">&#160;</div>
  	<br/>

</div>
