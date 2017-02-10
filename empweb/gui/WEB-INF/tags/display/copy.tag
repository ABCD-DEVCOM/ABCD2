<?xml version="1.0"?><!--
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%--
/* copy.tag: Displays copy information
 *
 * Copy information is defined in users schema with namespace
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
 * attribute: databasename (required)
 *    as database information is not contained within a mods copy info
 *    it has to be provided to be displayed.
 *
 * attribute: copy_id (required)
 *    as the selected copy id is not contained within a mods record info
 *    it has to be provided.
 *
 * attribute: with_links (optional) (default true)
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
<%@ attribute name="copy_id" required="true" %>
<%@ attribute name="object_db" required="true" %>
<%@ attribute name="with_links" required="false" %>

<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
-->

<%-- load the received dom or cnode into a new context node, based on the select xpath if provided --%>
<jsp:useBean id="localmap" class="java.util.HashMap" />
<c:set target="${localmap}" property="m" value="http://www.loc.gov/mods/v3" />
<c:set target="${localmap}" property="h" value="http://kalio.net/empweb/schema/holdingsinfo/v1" />
<c:choose>
  <c:when test="${not empty select}">
    <jxp:set cnode="${doc}"     var="tempDoc"   select="${select}"  nsmap="${nsmap}" />
    <jxp:set cnode="${tempDoc}" var="copyInfo"  select="m:mods"     nsmap="${localmap}" />
  </c:when>
  <c:otherwise>
    <jxp:set cnode="${doc}" var="copyInfo" select="//m:mods" nsmap="${localmap}" />
  </c:otherwise>
</c:choose>

<fmt:setBundle basename="ewi18n.local.display" scope="page"/>

<%-- BEGIN DISPLAY CODE --%>
<table>
  <tr>
    <td><fmt:message key="record_id"/></td>
    <td>
      <c:choose>
        <c:when test="${with_links eq 'false'}">
          ${copyInfo['m:recordInfo/m:recordIdentifier']}
        </c:when>
        <c:otherwise>
          <a href="${sessionScope.absoluteContext}/trans/query/record_status_result.jsp?record_id=${copyInfo['m:recordInfo/m:recordIdentifier']}&amp;object_db=${object_db}">
            ${copyInfo['m:recordInfo/m:recordIdentifier']}
            <c:if test="${not config['ew.hide_object_db'] and not empty object_db}"> (${object_db})</c:if>
          </a>
          <c:if test="${not config['ew.hide_object_db'] and not empty object_db}"> (${object_db})</c:if>
        </c:otherwise>
      </c:choose>
    </td>
  </tr>

  <tr>
    <td><fmt:message key="object_category"/></td>
    <td><jxp:out cnode="${copyInfo}" select="m:extension/h:holdingsInfo/h:copies/h:copy[h:copyId='${copy_id}']/h:objectCategory" nsmap="${localmap}"/>
  </tr>

  <tr>
    <td><fmt:message key="copy_id"/></td>
    <td>
      <c:choose>
        <c:when test="${with_links eq 'false'}">
          ${copy_id}
          <c:if test="${not config['ew.hide_object_db'] and not empty object_db}"> (${object_db})</c:if>
        </c:when>
        <c:otherwise>
          <a href="${sessionScope.absoluteContext}/trans/query/copy_status_result.jsp?copy_id=${copy_id}&amp;object_db=${object_db}">
            ${copy_id}
            <c:if test="${not config['ew.hide_object_db'] and not empty object_db}"> (${object_db})</c:if>
          </a>
        </c:otherwise>
      </c:choose>
    </td>
  </tr>

  <jxp:set var="hasVol" cnode="${copyInfo}" select="m:extension/h:holdingsInfo/h:copies/h:copy[h:copyId='${copy_id}']/h:volumeId" nsmap="${localmap}"/>
  <c:if test="${not empty hasVol}">
    <tr>
      <td><fmt:message key="volume_id"/></td>
      <td><jxp:out cnode="${copyInfo}" select="m:extension/h:holdingsInfo/h:copies/h:copy[h:copyId='${copy_id}']/h:volumeId" nsmap="${localmap}"/></td>
    </tr>
  </c:if>

  <tr>
    <td><fmt:message key="copy_location"/></td>
    <td><jxp:out cnode="${copyInfo}" select="m:extension/h:holdingsInfo/h:copies/h:copy[h:copyId='${copy_id}']/h:copyLocation" nsmap="${localmap}"/></td></td>
  </tr>

  <tr>
    <td><fmt:message key="title"/></td>
    <td>${copyInfo['m:titleInfo/m:title']}</td>
  </tr>
  <tr>
    <td><fmt:message key="author"/></td>
    <td>${copyInfo['m:name[m:role/m:roleTerm="author"]/m:namePart']}</td>
  </tr>
</table>
<%-- END DISPLAY CODE --%>
