<?xml version="1.0"?><!--
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%--
/* user.tag: Displays user information.
 *
 * User information is defined in users schema with namespace
 * http:// kalio.net/empweb/schema/users/v1
 *
 * attribute: doc (required)
 *    User information received as a a dom or as a context node
 *    constructed  by the commons/jxp tags set or forEach.
 *
 * attribute: select (optional)
 *    Xpath that specifies the element where the desired user element
 *    is located.
 *
 * attribute: nsmap (optional)
 *    external namespace hash map to be used with the select attribute.
 *
 * attribute: with_links (optional) (default: true)
 *    * output information with links to the corresponding object status
 */
--%>

<%@ tag import="java.util.*" %>
<%@ tag import="org.apache.commons.jxpath.*" %>
<%@ tag import="org.w3c.dom.*" %>

<%@ tag body-content="empty" %>
<%@ attribute name="doc" required="true" type="java.lang.Object" %>
<%@ attribute name="nsmap" required="false" type="java.lang.Object" %>
<%@ attribute name="select" required="false" %>
<%@ attribute name="with_links" required="false" %>

<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
-->

<%-- load the received dom or cnode into a new context node, based on the select xpath if provided --%>
<jsp:useBean id="localmap" class="java.util.HashMap" />
<c:set target="${localmap}" property="u" value="http://kalio.net/empweb/schema/users/v1" />
<c:set target="${nsmap}" property="qr" value="http://kalio.net/empweb/schema/queryresult/v1" />

<c:choose>
  <c:when test="${not empty select}">
    <jxp:set cnode="${doc}"  var="tempDoc" select="${select}" nsmap="${nsmap}" />
    <jxp:set cnode="${tempDoc}" var="userInfo" select="u:user" nsmap="${localmap}" />
  </c:when>
  <c:otherwise>
    <jxp:set cnode="${doc}" var="userInfo" select="//u:user" nsmap="${localmap}" />
  </c:otherwise>
</c:choose>

<fmt:setBundle basename="ewi18n.local.display"  var="dsp" scope="page"/>

<%-- BEGIN DISPLAY CODE --%>

<%
  request.setAttribute("abcd",System.getProperty("abcd.url", "/"));    
%> 

<table>
  <tr>
    <td rowspan="4">
      <!--<img src="${sessionScope.absoluteContext}/webproxy/user_photo/${userInfo['u:id']}" alt="PICTURE"/>-->
      <!--<img src="head_silhouette.jpg" alt="PICTURE"/>-->
      
      
  	<img src="${abcd}photoproxy.php?imgid=users/${userInfo['u:photo']}" alt="PICTURE"/>
  	
    </td>
    <td><fmt:message key="user_id" /></td>
    <td>
      <c:choose>
        <c:when test="${with_links eq 'false'}">
          ${userInfo['u:id']}<c:if test="${not config['ew.hide_user_db']}"> (${tempDoc['ancestor::qr:databaseResult/@name']})</c:if>
        </c:when>
        <c:otherwise>
          <a href="${sessionScope.absoluteContext}/trans/query/user_status_result.jsp?user_id=${userInfo['u:id']}&amp;user_db=${tempDoc['ancestor::qr:databaseResult/@name']}">
            ${userInfo['u:id']}<c:if test="${not config['ew.hide_user_db']}"> (${tempDoc['ancestor::qr:databaseResult/@name']})</c:if>
          </a>
        </c:otherwise>
      </c:choose>
    </td>
  </tr>
  <tr>
    <td><fmt:message key="name" /></td>
    <td>${userInfo['u:name']}</td>
  </tr>
  <tr>
    <td><fmt:message key="user_mail" /></td>
    <td><a href="mailto:${userInfo['u:email']}">${userInfo['u:email']}</a></td>
  </tr>
  <tr>
    <td><fmt:message key="user_class" /></td>
    <td>${userInfo['u:userClass']}</td>
  </tr>
  <tr>
    <td><fmt:message key="user_expiration" /> </td>
    <c:choose>
      <c:when test="${userInfo['u:expirationDate'] gt '20990000'}"> <%-- HARDCODED --%>
        <td><fmt:message key="user_does_not_expire"/></td>
      </c:when>
      <c:otherwise>
        <util:isLate var="late">${userInfo['u:expirationDate']}</util:isLate>
        <td ${late eq 'true' ? 'class="warn"' : ''}><util:formatDate type="date">${userInfo['u:expirationDate']}</util:formatDate></td>
      </c:otherwise>
    </c:choose>

  </tr>
</table>
<%-- END DISPLAY CODE --%>
