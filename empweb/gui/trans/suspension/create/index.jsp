<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>

<div class="middle homepage">

  <div class="searchBox">

  <h1><fmt:message key="suspension"/></h1>
  
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

      

      <form method="get" action="create_suspension_result.jsp">
        <c:if test="${config['ew.hide_user_db']}">
          <input type="hidden" name="user_db" value="${userDb}"/>
        </c:if> 

        <table>
          <tr>
            <td><fmt:message key="user_id"/>: </td>
            <td>
              <input type="text" name="user_id"
                <c:if test="${not empty fn:trim(param.user_id) }">
                  value="${param.user_id}"
                </c:if> class="textEntry"
                >
              </input>
              <input type="button" value="<fmt:message key="searchuser"/>" OnClick="javascript: searchUsers(); " />
              
              <c:if test="${empty param.user_id and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
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
            <td><fmt:message key="days_suspended"/>:</td>
            <td>
              <input type="text" name="suspension_days" 
                <c:if test="${not empty fn:trim(param.suspension_days) }">
                  value="${param.suspension_days}"
                </c:if>
                class="textEntry"
                >
              </input>
              <c:if test="${(empty param.suspension_days or param.suspension_days < 1) and not empty param.submit}"> <fmt:message key="wrong_value"/></c:if>
            </td>
          </tr>

          <tr>
            <td><fmt:message key="obs"/>:</td>
            <td>
              <c:choose>
                <c:when test="${config['gui.picklist.ms'] eq 'true'}">
                  <select name="obs">
                    <c:forTokens items="${config['gui.picklist.ms.items']}" delims="," var="item">
                      <option value="${item}">${item}</option>
                    </c:forTokens>
                  </select>
                </c:when>
                <c:otherwise>
                  <textarea name="obs" cols="25" rows="3" class="textEntry"><c:if test="${not empty fn:trim(param.obs) }" >${param.obs}</c:if></textarea>
                </c:otherwise>
              </c:choose>
            </td>
          </tr>

          <tr>
            <td></td>
            <td><input type="submit" name="submit" value="<fmt:message key="create_suspension"/>"/></td>
          </tr>
        </table>
      </form>

    </c:otherwise>
  </c:choose>
  
  </div>
  <br />

</div>
