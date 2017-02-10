<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *io
 */
--%>
<%@ tag body-content="scriptless" %>
<%@ attribute name="doc" required="true" type="java.lang.Object"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>

<fmt:setLocale value="${sessionScope.userLocale}"/>
<fmt:setBundle basename="ewi18n.core.gui" var="guiBundle" scope="page"/>

  <jsp:useBean id="nsm" class="java.util.HashMap" />
  <c:set target="${nsm}" property="e"   value="http://kalio.net/empweb/schema/engineresult/v1" />
  <c:set target="${nsm}" property="t"   value="http://kalio.net/empweb/schema/transactionresult/v1" />

  <jxp:set cnode="${doc}" nsmap="${nsm}"  var="error" select="//e:error"  />

  <c:choose>
    <%-- engine errors if any --%>
    <c:when test="${not empty error}">
      <h4><fmt:message key="error_processing_request" bundle="${guiBundle}"/></h4>
      <p class="error">
        <dsp:msg msg="${error['e:msg']}"/>
      </p>
      <%-- tell us when working with mockups --%>
      <c:if test="${not empty error['@mockup']}">
        <p class="warn">
          <fmt:message key="debug_working_with_mockups" bundle="${guiBundle}"/>
        </p>
      </c:if>
    </c:when>

    <%-- no engine errors: show process results --%>
    <c:otherwise>
      <jxp:set cnode="${doc}" nsmap="${nsm}"  var="trans" select="//t:transactionResult"  />

      <%-- check if there is any error message in the process/rules and show it --%>
      <jxp:set cnode="${doc}" nsmap="${nsm}"  var="procError" select="//t:processResult[@successful='false']"  />
      <c:if test="${not empty procError}">
        <h4><fmt:message key="error_processing_request" bundle="${guiBundle}"/></h4>
      </c:if>

      <%-- show each error --%>
      <jxp:forEach
        cnode="${doc}"
        nsmap="${nsm}"
        var="ptr"
        select="//t:processResult[@successful='false']">
        <p class="error">
          <strong><dsp:msg msg="${ptr['e:msg']}"/></strong><br/>
          <fmt:message key="process_name" bundle="${guiBundle}"/>: ${ptr['@name']}
        </p>
      </jxp:forEach>

      <%-- tell us when working with mockups --%>
      <c:if test="${not empty trans['@mockup']}">
        <p class="warn">
          <fmt:message key="debug_working_with_mockups" bundle="${guiBundle}"/>
        </p>
      </c:if>

    </c:otherwise>
  </c:choose>
