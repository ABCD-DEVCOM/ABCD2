<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->
<div class="middle homepage">

  <h1><fmt:message key="calendar_admin"/></h1>
  <h2><fmt:message key="view_calendar"/></h2>


  <x:parse varDom="doc">
    <admin:getCalendar year="${param.year}"/>
  </x:parse>


  <h3>
    <fmt:message key="calendar_of">
      <fmt:param value="${param.year}"/>
    </fmt:message>
    (<a href="edit_calendar.jsp?year=${param.year}">edit</a>)
    | <fmt:message key="skip_days"/>
  </h3>

  <table>
    <tr>
      <td colspan="1"></td>
      <th colspan="31"><fmt:message key="day_of_the_month"/></th>
    </tr>
    <tr>
      <td colspan="1"></td>
      <th>1</th>
      <th>2</th>
      <th>3</th>
      <th>4</th>
      <th>5</th>
      <th>6</th>
      <th>7</th>
      <th>8</th>
      <th>9</th>
      <th>10</th>
      <th>11</th>
      <th>12</th>
      <th>13</th>
      <th>14</th>
      <th>15</th>
      <th>16</th>
      <th>17</th>
      <th>18</th>
      <th>19</th>
      <th>20</th>
      <th>21</th>
      <th>22</th>
      <th>23</th>
      <th>24</th>
      <th>25</th>
      <th>26</th>
      <th>27</th>
      <th>28</th>
      <th>29</th>
      <th>30</th>
      <th>31</th>
    </tr>

    <jsp:useBean id="nsm" class="java.util.HashMap" />
    <c:set target="${nsm}" property="c" value="http://kalio.net/empweb/schema/calendar/v1" />
<% java.util.GregorianCalendar today= new java.util.GregorianCalendar();
   Integer month= new Integer(today.get(java.util.Calendar.MONTH) + 1);   // MONTH in a Calendar starts with 0
   Integer date= new Integer(today.get(java.util.Calendar.DATE));

    pageContext.setAttribute("todayMonth", month.toString());
    pageContext.setAttribute("todayDate", date.toString());
    pageContext.setAttribute("todayStyle", "style=\"border-color: red red red red; border-width: 1px 1px 1px 1px\"");
%>
    <%-- foreach month --%>
    <jxp:forEach
      cnode="${doc}"
      var="mptr"
      select="//c:month"
      nsmap="${nsm}">

      <tr>
        <td><fmt:message key="month${mptr['@value']}"/></td>

        <%-- foreach day --%>
        <jxp:forEach
          cnode="${mptr}"
          var="dptr"
          select="c:day"
          nsmap="${nsm}">

          <c:set var="todayBorder" value="${ (dptr['@value'] == todayDate and mptr['@value'] == todayMonth) ? todayStyle : '' }" />
          <c:set var="dow" value="${dptr['@dow']}" />
          <%-- skipDay vale null si no existe y vale vacio si existe. --%>
          <c:set var="skipDay" value="${dptr['c:skipDay']}" />

          <td ${ ((dow=='1') or (dow=='7')) ? 'class="marked"' : ''}  ${todayBorder} >
            ${skipDay ne null ? "X" : "."}
          </td>
        </jxp:forEach> <%-- day --%>
      </tr>
    </jxp:forEach> <%-- month --%>
  </table>
</div>

