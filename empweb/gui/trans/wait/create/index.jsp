<?xml version="1.0" ?>
<!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->

<div class="middle homepage">

  <%-- Check whether the object db comes as a request parameter, or use the one in the operator's property --%>
  
   <c:if test="${not config['ew.hide_user_db'] or not config['ew.hide_object_db']}">
        <x:parse varDom="dbNames">
          <trans:getDatabaseNames/>
        </x:parse>
      </c:if>

  
     <c:choose>
        <c:when test="${not empty param.user_db}">
          <c:set var="userDb" value="${param.user_db}" />
        </c:when>
        <c:otherwise>
          <c:set var="userDb" value="${sessionScope['property-default-user-db']}" />
        </c:otherwise>
      </c:choose>
      <c:choose>
        <c:when test="${not empty param.object_db}">
          <c:set var="objectDb" value="${param.object_db}" />
        </c:when>
        <c:otherwise>
          <c:set var="objectDb" value="${sessionScope['property-default-object-db']}" />
        </c:otherwise>
    </c:choose>
      
  
  <table cellspacing="10">
    <tr valign="top">
    <td>
  
  <h2><fmt:message key="object_query"/></h2>
  
  <div class="searchBox">
  <form  method="get" action="object_query_result.jsp">
    <c:if test="${config['ew.hide_object_db']}">
      <input type="hidden" name="object_db"  value="${sessionScope['property-default-object-db']}"/>      
    </c:if> 
    <input type="hidden" name="action"  value="queryobject"/>
    <table>
      <tr>
        <td>
          <fmt:message key="record_id"/>:</td><td><input type="text" name="object_recordid" />
          <c:if test="${config['gui.demo']}"><span class="demo"><fmt:message key="demo_example"><fmt:param>81</fmt:param></fmt:message></span></c:if>
        </td>
      </tr>
      <tr>
        <td>
          <fmt:message key="copy_id"/>:</td><td><input type="text" name="object_copyid" />
          <c:if test="${config['gui.demo']}"><span class="demo"><fmt:message key="demo_example"><fmt:param>Encontros</fmt:param></fmt:message></span></c:if>
        </td>
      </tr>
      <tr><td><fmt:message key="title"/>:</td><td><input type="text" name="object_title" /></td></tr>
      <tr><td><fmt:message key="author"/>:</td><td><input type="text" name="object_author" /></td></tr>
<%--
TODO: not for chile, but...
      <tr><td><fmt:message key="year_range"/>:</td><td><input type="text" name="object_yearfrom" /> - <input type="text" name="object_yearto" /></td></tr>
--%>
       <c:if test="${not config['ew.hide_object_db']}">
            <tr>
              <td><fmt:message key="object_db"/>: </td>
              <td>
                <dsp:selectObjectDatabase name="object_db" dbNames="${dbNames}" selectedDb="${objectDb}"/>
                <c:if test="${empty param.object_db and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
              </td>
            </tr>
        </c:if>
           

      <tr>
        <td></td><td>
        <input type="submit" name="ew-search-object" value="<fmt:message key='search_object'/>"/>
        <input type="reset" value="<fmt:message key='reset_form'/>"/></td>
      </tr>
    </table>
  </form>
  </div>
  
  </td>
  </tr>
  </table>
  
  <br/>
  
  
</div>
