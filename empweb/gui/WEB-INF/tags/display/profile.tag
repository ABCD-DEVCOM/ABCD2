<?xml version="1.0"?><!--
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%--

/** profile.tag: Displays profile information
 *
 * Profile information is defined in profile schema with the following namespace:
 * http://kalio.net/empweb/schema/profile/v1
 *
 * attribute: doc (required)
 *    Profile information received as a a dom or as a context node
 *    constructed  by the commons/jxp tags set or forEach.
 *
 * attribute: select (optional)
 *    Xpath that specifies the element where the desired user element
 *    is located.
 *
 * attribute: nsmap (optional)
 *    external namespace hash map to be used with the select attribute.
 *
 */

--%>

<%@ tag import="java.util.*" %>
<%@ tag import="org.apache.commons.jxpath.*" %>
<%@ tag import="org.w3c.dom.*" %>

<%@ tag body-content="empty" %>
<%@ attribute name="doc" required="true" type="java.lang.Object" %>
<%@ attribute name="nsmap" required="false" type="java.lang.Object" %>
<%@ attribute name="select" required="false" %>

<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
-->
<fmt:setBundle basename="ewi18n.local.limits"  var="limitsBundle"  scope="request"/>
<fmt:setBundle basename="ewi18n.local.display" var="dspBundle"     scope="request"/>


<%-- load the received dom or cnode into a new context node, based on the select xpath if provided --%>
<jsp:useBean id="localmap" class="java.util.HashMap" />
<c:set target="${localmap}" property="pr" value="http://kalio.net/empweb/schema/profile/v1" />

<c:choose>
  <c:when test="${not empty select}">
    <jxp:set cnode="${doc}"  var="tempDoc" select="${select}" nsmap="${nsmap}" />
    <jxp:set cnode="${tempDoc}" var="profileInfo" select="pr:profile" nsmap="${localmap}" />
  </c:when>
  <c:otherwise>
    <jxp:set cnode="${doc}" var="profileInfo" select="//pr:profile" nsmap="${localmap}" />
  </c:otherwise>
</c:choose>

<%-- BEGIN DISPLAY CODE --%>
  <h3><fmt:message key="profile_details" bundle="${dspBundle}" /></h3>
  <table>
    <tr>
      <td><fmt:message key="profile_id" /></td>
      <td>${profileInfo['@id']}</td>
    </tr>
    <tr>
      <td><fmt:message key="user_class" /></td>
      <td>${profileInfo['/pr:userClass']}</td>
    </tr>
    <tr>
      <td><fmt:message key="object_category" /></td>
      <td>${profileInfo['pr:objectCategory']}</td>
    </tr>
    <tr>
      <td><fmt:message key="date" /></td>
      <td><util:formatDate type="both">${profileInfo['/pr:timestamp']}</util:formatDate></td>
    </tr>
  </table>

  <h3><fmt:message key="limits" /></h3>
  <table>
    <tr>
      <th><fmt:message key="name" /></th>
      <th><fmt:message key="value" /></th>
      <th><fmt:message key="description" /></th>
      <th><fmt:message key="used_in_transaction" /></th>
    </tr>

    <!-- LIMITS TABLE -->
    <jxp:forEach cnode="${profileInfo}"  var="ptr"  select="//pr:limits/pr:limit"   sortby="+@name" nsmap="${localmap}">
      <tr>
        <td>${ptr['@name']}</td>
        <td>${ptr['pr:value']}</td>
        <td><fmt:message key="${ptr['@name']}" bundle="${limitsBundle}" /></td><!-- Description -->
        <td><!-- Pipelines where it's used -->
          <jxp:forEach cnode="${ptr}" var="ptr2" select="pr:pipelines/pr:pipeline" nsmap="${localmap}">
              ${_jxpItem gt 1 ? " | " : ""}${ptr2['.']}
          </jxp:forEach>
        </td>
      </tr>
    </jxp:forEach>
  </table>
<%-- END DISPLAY CODE --%>
