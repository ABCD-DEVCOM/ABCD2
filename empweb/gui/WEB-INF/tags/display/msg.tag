<%@ tag body-content="scriptless" %><%@
    attribute name="msg" required="true" type="java.lang.Object" %><%@
    taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %><%@
    taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %><%@
    taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %><%@
    taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %><%@
    taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %><%@
    tag import="net.kalio.xml.KalioXMLUtil" %><%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */

======================================================================
Possible result messages are:

1. key + bundle
<msg>
  <key bundle="core.engine">the_key</key>
  <params>
    <param>a param</param>
  </params>
</msg>

2. key and no bundle -> use core.engine bundle
<msg>
  <key>the_key</key>
  <params>
    <param>a param</param>
  </params>
</msg>

3: text + language code -> current locale if available, otherwise first element
<msg>
  <text lang="en">This is an english error</text>
  <text lang="es">Este es un error espa~nol</text>
</msg>

4: text and no language code. Display the text verbatim.
<msg>
  <text>This is an english error</text>
</msg>
=======================================================================
--%>
<fmt:setLocale value="${sessionScope.userLocale}"/>
<jsp:useBean id="nsm" class="java.util.HashMap"  />
<c:set target="${nsm}" property="e" value="http://kalio.net/empweb/schema/engineresult/v1"/>

<c:choose>
  <%-- Case 1: key and bundle --%>
  <c:when test="${(not empty msg['e:key']) and (not empty msg['e:key/@bundle'])}">
    <fmt:setBundle basename="ewi18n.${msg['e:key/@bundle']}" var="messageBundle" scope="page"/>
    <fmt:message key="${msg['e:key']}" bundle="${messageBundle}">
      <jxp:forEach  cnode="${msg}" nsmap="${nsm}"
                    var="p"
                    select="e:params/e:param">
        <util:isDate var="isDate">${p['.']}</util:isDate>
        <c:choose>
          <c:when test="${not empty isDate}">
            <fmt:param value="${isDate}"/>
          </c:when>
          <c:otherwise>
            <fmt:param value="${p['.']}"/>
          </c:otherwise>
        </c:choose>
      </jxp:forEach>
    </fmt:message>
  </c:when>

  <%-- Case 2: key but no bundle --%>
  <c:when test="${not empty msg['e:key']}">
    <fmt:setBundle basename="ewi18n.core.engine" var="messageBundle" scope="page"/>
    <fmt:message key="${msg['e:key']}" bundle="${messageBundle}">
      <jxp:forEach  cnode="${msg}" nsmap="${nsm}"
                    var="p"
                    select="e:params/e:param">
        <fmt:param value="${p['.']}"/>
        <util:isDate var="isDate">${p['.']}</util:isDate>
        <c:choose>
          <c:when test="${not empty isDate}">
            <fmt:param value="${isDate}"/>
          </c:when>
          <c:otherwise>
            <fmt:param value="${p['.']}"/>
          </c:otherwise>
        </c:choose>
      </jxp:forEach>
    </fmt:message>
  </c:when>

  <%-- Case 3: text elements with specified languages --%>
  <c:when test="${not empty msg['e:text/@lang']}">
    <jxp:forEach  cnode="${msg}" nsmap="${nsm}"
                  var="text"
                  select="e:text">
      <%-- OJO: hay un tema con la conversion a string. si no uso el trim no matchea el igual --%>
      <c:if test="${fn:trim(sessionScope.userLocale) == text['@lang']}">
        <c:set var="textString" value="${text['.']}" />
      </c:if>
    </jxp:forEach>
    <c:choose>
      <c:when test="${not empty textString}">${textString}</c:when>
      <c:otherwise>${msg['e:text']}</c:otherwise>
    </c:choose>
  </c:when>

  <%-- Case 4: just show the first available text element --%>
  <c:otherwise>${msg['e:text']}
  </c:otherwise>
</c:choose>


