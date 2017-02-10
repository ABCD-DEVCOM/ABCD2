<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
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

<div id="content">
  <h1><fmt:message key="confirmation"/></h1>
  <h2><fmt:message key="new_profile"/></h2>

  <c:choose>
    <c:when test="${not empty param.new_profile_no}">
      <c:redirect url="index.jsp"/>
    </c:when>

    <c:when test="${(not empty param.new_profile_yes) and
                    (not empty param.policy_id) and
                    (not empty param.user_class) and
                    (not empty param.object_category)}">
      <admin:adminResult>
        <admin:saveProfile />
      </admin:adminResult>
      <%-- PARA SALTAR DIRECTAMENTE AL PROFILE CREADO NECESITO EL NUEVO ID Y NO LO TENGO. POR ESO VOY A POLICY --%>
      <p><a href="edit_policy.jsp?id=${param.policy_id}&amp;name=${param.policy_name}"><fmt:message key="back_to_policy"><fmt:param value="${param.policy_name}"/></fmt:message></a></p>
    </c:when>

    <c:otherwise>   <%-- Main form --%>

      <h3><fmt:message key="new_profile_info"/></h3>
      <form method="get">
        <input type="hidden" name="policy_name" value="${param.policy_name}"/>
        <input type="hidden" name="policy_id" value="${param.policy_id}"/>
        <input type="hidden" name="profile_id" value="new"/>
        <table>
          <tr>
            <td><fmt:message key="policy_name"/></td>
            <td>${param.policy_name}</td>
          </tr>
          <tr>
            <td><fmt:message key="new_profile_user_class"/></td>
            <td><input type="text" name="user_class" value="${param.user_class}"/>
                  <c:if test="${not empty param.new_profile_yes}">
                    <fmt:message key="required_field"/>
                  </c:if>
            </td>
          </tr>
          <tr>
            <td><fmt:message key="new_profile_object_category"/></td>
            <td><input type="text" name="object_category" value="${param.object_category}"/>
                  <c:if test="${not empty param.new_profile_yes}">
                    <fmt:message key="required_field"/>
                  </c:if>
            </td>
          </tr>
        </table>
        <div class="query">
          <p><fmt:message key="new_profile_are_you_sure"/></p>
          <input type="submit" name="new_profile_yes" value="<fmt:message key='yes'/>"/>
          <input type="submit" name="new_profile_no" value="<fmt:message key='no'/>"/>
        </div>
      </form>

    </c:otherwise>
  </c:choose>

 </div>
