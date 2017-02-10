<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="empty" %>
<%@ attribute name="depth" required="false" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>

<c:choose>
  <c:when test="${depth eq 3}">
    <c:set var="depthPrefix">../../</c:set>
  </c:when>
  <c:otherwise>
    <c:set var="depthPrefix">../</c:set>
  </c:otherwise>
</c:choose>
 
<div class="notprint">
<h3><fmt:message key="actions"/></h3>
<ul>
  <li><a href="#" onclick="window.print();"> <fmt:message key="print"/></a></li>
  <c:if test="${not empty param.user_id and not empty param.user_db}">
    <li><a href="${depthPrefix}query/user_status_result.jsp?user_id=${fn:trim(param.user_id)}&amp;user_db=${fn:trim(param.user_db)}"><fmt:message key="view_user_status"/></a></li>
  </c:if>
</ul>
</div>
