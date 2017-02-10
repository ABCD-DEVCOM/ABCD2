<?xml version="1.0" ?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%@ taglib prefix="kfn"   uri="http://kalio.net/jsp/el-func-1.0" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->

<div class="middle homepage">

  <c:choose>

    <%-- when a field is missing, reject with available parameters --%>
    <c:when test="${( (empty fn:trim(param.user_id)) or (empty fn:trim(param.user_db)) or
                      (empty fn:trim(param.record_id)) or (empty fn:trim(param.object_db))) }">
      <c:redirect url="index.jsp">
        <c:if test="${not empty fn:trim(param.user_id) }">
          <c:param name="user_id" value="${param.user_id}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.user_db) }">
          <c:param name="user_db" value="${param.user_db}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.volume_id)}">
          <c:param name="volume_id" value="${param.volume_id}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.record_id)}">
          <c:param name="record_id" value="${param.record_id}"/>
        </c:if>
        <c:if test="${not empty fn:trim(param.object_db) }">
          <c:param name="object_db" value="${param.object_db}"/>
        </c:if>
//         <c:if test="${not empty fn:trim(param.object_category) }">
//           <c:param name="object_category" value="${param.object_category}"/>
//         </c:if>
//         <c:if test="${not empty fn:trim(param.start_date) }">
//           <c:param name="start_date" value="${param.start_date}"/>
//         </c:if>
//         <c:if test="${not empty fn:trim(param.object_location) }">
//           <c:param name="object_location" value="${param.object_location}"/>
//         </c:if>
        <c:if test="${not empty fn:trim(param.submit) }">
          <c:param name="submit" value="${param.submit}"/>
        </c:if>
      </c:redirect>
    </c:when>


    <%-- show reservation result --%>
    <c:otherwise>
      <h1><fmt:message key="reservation"/></h1>
      <h2><fmt:message key="reservation_result"/></h2>

      <jsp:useBean id="results" class="java.util.HashMap" />
      
      <c:choose>
        <c:when test="${not empty param.accept_end_date}">
          <c:set target="${results}" property="${fn:trim(param.record_id)}">
            <trans:waitSingle
               userId="${fn:trim(param.user_id)}"
               userDb="${fn:trim(param.user_db)}"
               recordId="${fn:trim(param.record_id)}"
               volumeId="${fn:trim(param.volume_id)}"
               objectDb="${fn:trim(param.object_db)}"
               objectCategory="${fn:trim(param.object_category)}"
               objectLocation="${fn:trim(param.object_location)}"
               startDate="${fn:trim(param.start_date)}"
               acceptEndDate="${fn:trim(param.accept_end_date)}" />
          </c:set>
        </c:when>
        <%-- if this is a normal transaction --%>
        <c:otherwise>
          <c:set target="${results}" property="${fn:trim(param.record_id)}">
              <trans:waitSingle
                 userId="${fn:trim(param.user_id)}"
                 userDb="${fn:trim(param.user_db)}"
                 recordId="${fn:trim(param.record_id)}"
                 volumeId="${fn:trim(param.volume_id)}"
                 objectDb="${fn:trim(param.object_db)}"
                 objectCategory="${fn:trim(param.object_category)}"
                 objectLocation="${fn:trim(param.object_location)}"
                 startDate="${fn:trim(param.start_date)}" />
          </c:set>          
        </c:otherwise>
      </c:choose>

      <trans:transResultMulti results="${results}"/>

    </c:otherwise>
  </c:choose>

  <dsp:transactionResultFooter depth="3"/>

</div>
