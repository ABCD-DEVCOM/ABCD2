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

  <%-- GET DATABASE NAMES --%>
  <c:if test="${not config['ew.hide_user_db'] or not config['ew.hide_object_db']}">
    <x:parse varDom="dbNames">
      <trans:getDatabaseNames/>
    </x:parse>
  </c:if>

  
  <table cellspacing="10">
    <tr valign="top">
    <td>
  <h2><fmt:message key="user_query"/></h2>  
  <div class="searchBox">  
  <form method="get" action="user_query_result.jsp">
    <c:if test="${config['ew.hide_user_db']}">
      <input type="hidden" name="user_db" value="${sessionScope['property-default-user-db']}"/>
    </c:if> 
    
    <table>
      <tr>
        <td><fmt:message key="user_id"/>: </td>
        <td>
          <input type="text" name="user_id"/>
          <c:if test="${config['gui.demo']}"><span class="demo"><fmt:message key="demo_example"><fmt:param value="911"/></fmt:message></span></c:if>
        </td>
      </tr>
      <tr>
        <td><fmt:message key="name"/>: </td>
        <td>
          <input type="text" name="user_name" />
          <c:if test="${config['gui.demo']}"><span class="demo"><fmt:message key="demo_example"><fmt:param>Luciana</fmt:param></fmt:message></span></c:if>
        </td>
      </tr>
      
<%--
TODO: not for chile, but...
      <tr><td><fmt:message key="user_class"/>: </td><td><input type="text" name="user_userClass" /> </td></tr>
--%>
      <c:if test="${not config['ew.hide_user_db']}">
        <tr>
          <td><fmt:message key="database"/>: </td>
          <td>
            <dsp:selectUserDatabase name="database" dbNames="${dbNames}"/>
          </td>
        </tr>
      </c:if> 

      <tr>
        <td></td><td><input type="submit" name="ew-search-user" value="<fmt:message key='search_user'/>"/>
        <input type="reset" value="<fmt:message key='reset_form'/>"/></td>
      </tr>
    
    </table>
  </form>
  </div>
  
  

  </td>
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
          <td><fmt:message key="database"/>: </td>
          <td>
            <dsp:selectObjectDatabase name="database" dbNames="${dbNames}"/>
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
  
  
  <td>
  <h2><fmt:message key="transaction_query"/></h2>
  
  <div class="searchBox">
  <form method="get" action="view_transaction_details.jsp">
    <table>
      <tr>
        <td><fmt:message key="transaction_id"/>:</td>
        <td>
          <input type="text" name="transaction_id"
            <c:if test="${not empty fn:trim(param.transaction_id) }">
              value="${param.transaction_id}"
            </c:if>
            >
          </input>
          <c:if test="${empty param.transaction_id and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
        </td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" name="submit" value="<fmt:message key="search_transaction"/>"/></td>
      </tr>
    </table>
  </form>
  </div>
  
  </td>
  </tr>
  </table>
  
  <br/>
  
  
</div>
