<?xml version="1.0"?>
<!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
-->

<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="pr" value="http://kalio.net/empweb/schema/profile/v1" />
<c:set target="${nsm}" property="pol" value="http://kalio.net/empweb/schema/policy/v1" />

<%-- BBB Here we should check possible error results because the profile doesn't exist, for example --%>
<x:parse varDom="doc">
  <admin:getProfile id="${param.profile_id}"/>
</x:parse>
<%-- Define a relative JXP Pointer pointing to the profile context, for convenience --%>
<jxp:set cnode="${doc}" var="profPtr" nsmap="${nsm}" select='//pr:profile'/>


<%-- Get list of policies to obtain the name of the parent policy of this profile (through the id) --%>
<x:parse varDom="policiesDoc">
  <admin:getPolicies/>
</x:parse>
<jxp:set  cnode="${policiesDoc}" var="policyName" nsmap="${nsm}"
          select="//pol:policy[@id='${profPtr[\"pr:policy\"]}']/pol:name" />


<div class="middle homepage">
  <h1><fmt:message key="confirmation"/></h1>
  <h2><fmt:message key="delete_profile"/></h2>

  <c:choose>
    <%-- "NO" button pressed --%>
    <c:when test="${not empty param.delete_profile_no}">
      <c:redirect url="edit_policy.jsp?id=${profPtr['pr:policy']}"/>
    </c:when>

    <%-- "YES" button pressed --%>
    <c:when test="${(not empty param.delete_profile_yes) and (not empty param.profile_id)}">
      <admin:adminResult>
        <admin:deleteProfile id="${param.profile_id}"/>
      </admin:adminResult>
      <p> <a href="edit_policy.jsp?id=${profPtr['pr:policy']}">
            <fmt:message key="back_to_policy"><fmt:param value="${policyName}"/></fmt:message>
          </a>
      </p>
    </c:when>

    <%-- delete profile page content. Show profile to be deleted --%>
    <c:otherwise>
      <form method="get">
        <input type="hidden" name="profile_id" value="${param.profile_id}"/>
        <input type="hidden" name="policy_name" value="${param.policy_name}"/>
        <input type="hidden" name="policy_id" value="${param.policy_id}"/>

        <h3><fmt:message key="profile_details"/></h3>
        <table>
          <tr>
            <td><fmt:message key="policy_name"/></td>
            <td>${policyName}</td>
          </tr>
          <tr>
            <td><fmt:message key="policy_id"/></td>
            <td>${profPtr["pr:policy"]}</td>
          </tr>
          <tr>
            <td><fmt:message key="profile_id"/></td>
            <td>${param.profile_id}</td>
          </tr>
          <tr>
            <td><fmt:message key="user_class"/></td>
            <td>${profPtr["pr:userClass"]}</td>
          </tr>
          <tr>
            <td><fmt:message key="object_category"/></td>
            <td>${profPtr["pr:objectCategory"]}</td>
          </tr>
        </table>
        <div class="query">
          <p><fmt:message key="delete_profile_are_you_sure"/></p>
          <input type="submit" name="delete_profile_yes" value="<fmt:message key='yes'/>"/>
          <input type="submit" name="delete_profile_no" value="<fmt:message key='no'/>"/>
        </div>
      </form>
    </c:otherwise>
  </c:choose>

 </div>
