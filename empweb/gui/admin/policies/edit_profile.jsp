<?xml version="1.0"?>
<!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%--
/*
 * Copyright 2004-2006 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved

 */
--%>
-->

<fmt:setBundle basename="ewi18n.local.limits" var="limitsBundle" scope="page"/>

<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="pr" value="http://kalio.net/empweb/schema/profile/v1" />
<c:set target="${nsm}" property="pol" value="http://kalio.net/empweb/schema/policy/v1" />


<%-- BBB Here we should check possible error results because the profile doesn't exist, for example --%>
<%-- If param.profile_id is "new', we should get a profile template, and we get the policy id
     from a request parameter --%>
<x:parse varDom="doc">
  <admin:getProfile id="${param.profile_id}"/>
</x:parse>


<%-- Get list of policies to obtain the name of the parent policy of this profile (through the id) --%>
<x:parse varDom="policiesDoc">
  <admin:getPolicies/>
</x:parse>


<%-- Define a relative JXP Pointer pointing to the profile context, for convenience --%>
<jxp:set cnode="${doc}" var="profPtr" nsmap="${nsm}" select='//pr:profile'/>


<c:choose>
  <c:when test="${param.profile_id != 'new'}">
    <%-- We are working with an existing profile, so it must belong to a policy. --%>

    <%-- We use the profile's policy id to find the policy name (store it under var policyName) --%>
    <jxp:set  cnode="${policiesDoc}" var="policyName" nsmap="${nsm}"
              select="//pol:policy[@id='${profPtr[\"pr:policy\"]}']/pol:name" />

    <%-- And the policy id under policyId --%>
    <c:set var="policyId"       value="${profPtr['pr:policy']}" />

    <%-- Also, get the userClass and objectCategory, to use them below for the input values --%>
    <c:set var="userClass"      value="${profPtr['pr:userClass']}" />
    <c:set var="objectCategory" value="${profPtr['pr:objectCategory']}" />
  </c:when>

  <c:otherwise>
    <%--NEW NEW NEW:  We are editing a NEW profile.
        So we MUST have the request parameter policy_id (IMPORTANT!). --%>

    <%-- We use the request param.policy_id to find the policy name (store it under var policyName) --%>
    <jxp:set  cnode="${policiesDoc}" var="policyName" nsmap="${nsm}"
              select="//pol:policy[@id='${param.policy_id}']/pol:name" />

    <%-- And the policy id under policyId --%>
    <c:set var="policyId"       value="${param.policy_id}" />

    <%-- These two may come as request parameters, especially from the matrix policy editor --%>
    <c:set var="userClass"      value="${param.user_class}" />
    <c:set var="objectCategory" value="${param.object_category}" />
  </c:otherwise>
</c:choose>

<div class="middle homepage">
  <h1><fmt:message key="profile_info"/></h1>
  <h2><fmt:message key="edit_profile"/></h2>

  <c:choose>
    <c:when test="${not empty param.submit}">
      <!-- when submitted, go for it and show results. -->
      <admin:adminResult>
        <admin:saveProfile/>
      </admin:adminResult>

      <p> <a href="edit_policy.jsp?id=${param.policy_id}">
            <fmt:message key="back_to_policy"><fmt:param value="${policyName}"/></fmt:message>
          </a>
      </p>
    </c:when>


    <c:otherwise>
    <!-- input form -->

      <%-- PROFILE DETAILS --%>
      <h3><fmt:message key="profile_details" /></h3>
      <form method="post" action="edit_profile.jsp">   <!-- must have the action in order to clean up the URL parameters -->
        <input type="hidden" name="profile_id" value="${profPtr['@id']}" />
        <input type="hidden" name="policy_id"  value="${policyId}" />
        <input type="hidden" name="policy_name"  value="${policyName}" /> <!-- for convenience, after submit -->
        <c:if test="${not empty userClass}">
          <input type="hidden" name="user_class" value="${userClass}" />
        </c:if>
        <c:if test="${not empty objectCategory}">
          <input type="hidden" name="object_category" value="${objectCategory}" />
        </c:if>
        <table>
          <tr>
            <td><fmt:message key="user_class" /></td>
            <td>
              <c:choose>
                <c:when test="${not empty userClass}">
                  ${userClass}
                </c:when>
                <c:otherwise>
                  <input  name="user_class" type="text" value="${userClass}" />
                </c:otherwise>
              </c:choose>
            </td>
          </tr>
          <tr>
            <td><fmt:message key="object_category" /></td>
            <td>
              <c:choose>
                <c:when test="${not empty objectCategory}">
                  ${objectCategory}
                </c:when>
                <c:otherwise>
                  <input  name="object_category" type="text" value="${objectCategory}" />
                </c:otherwise>
              </c:choose>
            </td>
          </tr>
          <tr>
            <td><fmt:message key="date" /></td>
            <td><util:formatDate type="both">${profPtr['/pr:timestamp']}</util:formatDate></td>
          </tr>
          <tr>
            <td><fmt:message key="policy_name" /></td>
            <td><a href="edit_policy.jsp?id=${policyId}" >${policyName} (${policyId})</a></td>
          </tr>
        </table>

        <%-- LIMITS LIST --%>
        <h3><fmt:message key="limits" /></h3>
        <table id="result">
          <tr>
            <th><fmt:message key="name" /></th>
            <th><fmt:message key="value" /></th>
            <th><fmt:message key="description" /></th>
            <th><fmt:message key="used_in_transaction" /></th>
          </tr>

          <!-- LIMITS TABLE -->
          <jxp:forEach cnode="${doc}"  var="ptr"  select="//pr:limits/pr:limit"  sortby="+@name" nsmap="${nsm}">
            <tr>
              <td>${ptr['@name']}</td>
              <td>
                <%-- ======================================================================= --%>
                <%-- IMPORTANT: parameters for the limits must start with limit_ followed by --%>
                <%--            the name of the limit. Used in admin:saveProfile tag         --%>
                <%-- ======================================================================= --%>
                <input type="text" name="limit_${ptr['@name']}" value="${ptr['pr:value']}" />
              </td>
              <td><fmt:message key="${ptr['@name']}" bundle="${limitsBundle}"/></td><!-- Description -->
              <td><!-- Pipelines where it's used -->
                <jxp:forEach cnode="${ptr}" var="ptr2" nsmap="${nsm}"
                             select="pr:pipelines/pr:pipeline">
                  ${_jxpItem gt 1 ? " | " : ""}${ptr2['.']}
                </jxp:forEach>
              </td>
            </tr>
          </jxp:forEach>
        </table>

        <input type="submit" name="submit" value="<fmt:message key='submit'/>"/>
      </form>
    </c:otherwise>
  </c:choose>
</div>

