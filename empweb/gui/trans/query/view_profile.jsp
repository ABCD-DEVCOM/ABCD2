<?xml version="1.0"?><!--<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->
<x:parse varDom="profileInfo">
  <admin:getProfile id="${param.profile_id}"/>
</x:parse>

<div class="middle homepage">
  <h1><fmt:message key="profile_details"/></h1>

    <%-- PROFILE DETAILS, IF ANY --%>
  <c:if test="${not empty param.profile_id}">
      <dsp:profile doc="${profileInfo}"/>
  </c:if>
</div>