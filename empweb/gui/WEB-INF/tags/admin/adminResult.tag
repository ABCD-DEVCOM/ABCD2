<%@ tag body-content="scriptless" %>
<%@ attribute name="showSuccess" type="java.lang.Boolean" required="false" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>

<fmt:setLocale value="${sessionScope.userLocale}"/>
<fmt:setBundle basename="ewi18n.core.gui" var="guiBundle" scope="page"/>

<jsp:useBean id="nsm" class="java.util.HashMap"  />
<c:set target="${nsm}"  property="e" value="http://kalio.net/empweb/schema/engineresult/v1"/>

<div>
  <x:parse varDom="doc">
    <jsp:doBody />
  </x:parse>

  <jxp:set cnode="${doc}" nsmap="${nsm}"  var="error" select="//e:error|/e:error"  />

  <c:choose>
    <c:when test="${not empty error}">
      <%-- tell us when working with mockups --%>
      <c:if test="${not empty error['@mockup']}">
        <p class="warn">
          <fmt:message key="debug_working_with_mockups" bundle="${guiBundle}"/>
        </p>
      </c:if>

      <%-- show engine errors if any --%>
      <h4><fmt:message key="error_processing_request" bundle="${guiBundle}"/></h4>
      <p class="error">
        <dsp:msg msg="${error['e:msg']}"/>
      </p>
    </c:when>

    <c:otherwise>
      <%-- tell us when working with mockups --%>
      <c:if test="${not empty ok['@mockup']}">
        <p class="warn">
          <fmt:message key="debug_working_with_mockups" bundle="${guiBundle}"/>
        </p>
      </c:if>

      <c:if test="${showSuccess}">
        <h4><fmt:message key="successful_request" bundle="${guiBundle}"/></h4>
        <jxp:set cnode="${doc}" nsmap="${nsm}" var="ok" select="//e:ok"  />
        <c:if test="${not empty ok}">
          <p><dsp:msg msg="${ok['e:msg']}"/></p>
        </c:if>
      </c:if>
    </c:otherwise>
  </c:choose>
</div>