<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%@ taglib prefix="kfn"   uri="http://kalio.net/jsp/el-func-1.0" %>

<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>

<div class="middle homepage">
  <c:set var="fine_id"          value="${fn:trim(param.fine_id)}"/>
  <c:set var="fine_paid_amount" value="${fn:trim(param.fine_paid_amount)}"/>
  <c:set var="obs"              value="${fn:trim(param.obs)}"/>

  <%-- the following check also wont allow decimal numbers --%>
  <util:isNumber var="fine_amount_is_number">${fine_paid_amount}</util:isNumber>

  <c:choose>

    <%-- check if the amount has only numbers --%>
    <c:when test="${not fine_amount_is_number}">
      <c:redirect url="index.jsp">
        <c:if test="${not empty fine_paid_amount }"><c:param name="fine_paid_amount" value="${fine_paid_amount}"/></c:if>
        <c:if test="${not empty fine_id }"><c:param name="fine_id" value="${fine_id}"/></c:if>
        <c:if test="${not empty fn:trim(param.submit) }"><c:param name="submit" value="${param.submit}"/></c:if>
      </c:redirect>
    </c:when>

    <%-- when a field is missing, reject with available parameters --%>
    <c:when test="${( (empty fine_id) or (empty fine_paid_amount) or (fine_paid_amount le 0) )}">
      <c:redirect url="index.jsp">
        <c:if test="${not empty fine_paid_amount }"><c:param name="fine_paid_amount" value="${fine_paid_amount}"/></c:if>
        <c:if test="${not empty fine_id }"><c:param name="fine_id" value="${fine_id}"/></c:if>
        <c:if test="${not empty fn:trim(param.submit) }"><c:param name="submit" value="${param.submit}"/></c:if>
      </c:redirect>
    </c:when>

    <%-- show pay_fine result --%>
    <c:otherwise>
      <h1><fmt:message key="pay_fine"/></h1>
      <h2><fmt:message key="pay_fine_result"/></h2>

      <c:forEach items="${kfn:splitLines(fine_id)}" var="fid">
        <c:if test="${fn:trim(fid) ne ''}">
          <trans:transResult>
            <trans:payFineSingle
              fineId="${fn:trim(fid)}"
              paidAmount="${fine_paid_amount}"
              operatorId="${sessionScope.user}"
              obs="${obs}" />
          </trans:transResult>
        </c:if>
      </c:forEach>
    </c:otherwise>

  </c:choose>

  <dsp:transactionResultFooter depth="3"/>

</div>
