<?xml version="1.0"?>
<!--
<%--
/* 
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="empty" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>

<%@ attribute name="var" rtexprvalue="false" required="true" %>
<%@ variable name-from-attribute="var" alias="engineOk" variable-class="java.lang.String" scope="AT_END" %>
-->

<x:parse varDom="doc">  
  <io:soap url="${config['ewengine.admin_service']}" SOAPAction="" encoding="UTF-8">
    <io:body>
      <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
        xmlns:xsd="http://www.w3.org/2001/XMLSchema"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
        <soapenv:Body>
          <checkEngine xmlns="http://kalio.net/empweb/engine/admin/v1" />
        </soapenv:Body>
      </soapenv:Envelope>
    </io:body>
  </io:soap>
</x:parse>

<jsp:useBean id="nsm" class="java.util.HashMap"  />
<c:set target="${nsm}"  property="e" value="http://kalio.net/empweb/schema/engineresult/v1"/>
<jxp:set cnode="${doc}" nsmap="${nsm}" var="errorKey" select="//e:error/e:msg/e:key" />

<c:choose>
  <c:when test="${fn:trim(errorKey) eq ''}">
    <c:set var="engineOk" value="true" />
  </c:when>
  <c:otherwise>
    <c:set var="engineOk" value="false" />
  </c:otherwise>
</c:choose>


