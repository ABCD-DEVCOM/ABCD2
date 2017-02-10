<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%><%@ 
tag body-content="scriptless" %><%@ 
attribute name="totalCount" required="true" %><%@ 
attribute name="qty" required="true" %><%@ 
attribute name="from" required="true" %><%@ 
attribute name="urlprefix" required="true" %><%@ 
taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %><%@ 
taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %><%@ 
taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>


<p class="pagenav">
  <c:set var="pagesCount"><util:ceil>${totalCount div qty}</util:ceil></c:set>
  <c:set var="thisPage"><util:ceil>${(from div qty)}</util:ceil></c:set>
  <%-- thisPage is 0 based, so the first page is 0 --%>

  <c:choose>
    <c:when test="${pagesCount lt 25}">
      <fmt:message key="page"/>: 
      <c:forEach begin="0" end="${(pagesCount-1 lt 0)?0:(pagesCount-1)}" var="curr">
        <c:choose>
          <c:when test="${thisPage eq curr}"><strong>${(curr+1)}</strong>&nbsp;
          </c:when>
          <c:otherwise>
            <a href="?${urlprefix}&amp;qty=${qty}&amp;from=${(qty * curr)}">${(curr+1)}</a>&nbsp;
          </c:otherwise>
        </c:choose>
      </c:forEach>
    </c:when>

    <c:otherwise>
      <c:if test="${thisPage gt 0}">
        <a href="?${urlprefix}&amp;qty=${qty}&amp;from=${((from-qty)lt 0)?0:(from-qty) }"><fmt:message key="previous"/></a>
      </c:if>
      (<fmt:message key="page_of">
      <fmt:param value="${thisPage + 1}"/>
      <fmt:param value="${pagesCount}"/>
      </fmt:message>)
      <c:if test="${thisPage lt pagesCount}">
        <a href="?${urlprefix}&amp;qty=${qty}&amp;from=${((from+qty)gt resultsCount)?from:(from+qty)}"><fmt:message key="next"/></a>
      </c:if>
    </c:otherwise>

  </c:choose>

</p>
