<?xml version="1.0"?><!--
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%--
/* record.tag: Displays record information
 *
 * Record information is defined in users schema with namespace
 * http://www.loc.gov/mods/v3
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
 * attribute: databasename (optional)
 *    as database information is not contained within a mods record info
 *    it has to be provided to be displayed.
 */
--%>
<%@ tag import="java.util.*" %>
<%@ tag import="org.apache.commons.jxpath.*" %>
<%@ tag import="org.w3c.dom.*" %>

<%@ tag body-content="empty" %>
<%@ attribute name="doc" required="true" type="java.lang.Object" %>
<%@ attribute name="nsmap" required="false" type="java.lang.Object" %>
<%@ attribute name="select" required="false" %>
<%@ attribute name="databasename" required="false" %>

<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
-->

<%-- load the received dom or cnode into a new context node, based on the select xpath if provided --%>
<jsp:useBean id="localmap" class="java.util.HashMap" />
<c:set target="${localmap}" property="m" value="http://www.loc.gov/mods/v3" />
<c:choose>
  <c:when test="${not empty select}">
    <jxp:set cnode="${doc}"  var="tempDoc" select="${select}" nsmap="${nsmap}" />
    <jxp:set cnode="${tempDoc}" var="recordInfo" select="m:mods" nsmap="${localmap}" />
  </c:when>
  <c:otherwise>
    <jxp:set cnode="${doc}" var="recordInfo" select="//m:mods" nsmap="${localmap}" />
  </c:otherwise>
</c:choose>

<fmt:setBundle basename="ewi18n.local.display" scope="page"/>

<%-- BEGIN DISPLAY CODE --%>
<table>
  <tr>
    <td><fmt:message key="record_id"/></td>
    <td>${recordInfo['m:recordInfo/m:recordIdentifier']}
      <c:if test="${not config['ew.hide_object_db'] and not empty databasename}"> (${databasename})</c:if>
    </td>
  </tr>
  <tr>
    <td><fmt:message key="title"/></td>
    <td>${fn:escapeXml(recordInfo['m:titleInfo/m:title'])}</td>
  </tr>
  <tr>
    <td><fmt:message key="author"/></td>
    <td>${recordInfo['m:name[m:role/m:roleTerm="author"]/m:namePart']}</td>
  </tr>
</table>
<%-- END DISPLAY CODE --%>
