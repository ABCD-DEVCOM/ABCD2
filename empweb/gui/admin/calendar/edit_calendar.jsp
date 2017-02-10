<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ page buffer="64kb" autoFlush="true" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
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
  <h2><fmt:message key="edit_calendar"/></h2>


  <c:choose>
    <c:when test="${not empty param.submit}">
      <!-- when submitted, go for it and show results. -->
      <admin:adminResult>
        <admin:saveCalendar/>
      </admin:adminResult>

      <p><a href="view_calendar.jsp?year=${param.year}"><fmt:message key="back_to_calendar"><fmt:param value="${param.year}"/></fmt:message></a></p>
    </c:when>

    <c:otherwise>
      <%-- get data --%>
      <x:parse varDom="doc">
        <admin:getCalendar year="${param.year}"/>
      </x:parse>

      <%-- input form --%>
      <h3>
        <fmt:message key="calendar_of">
          <fmt:param value="${param.year}"/>
        </fmt:message> |
        <fmt:message key="skip_days"/>
      </h3>

      <form method="post" id="calendarform" action="edit_calendar.jsp">
        <input type="hidden" name="year" value="${param.year}"/>

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
          <%-- foreach month --%>
          <jxp:forEach cnode="${doc}" var="ptr" select="//c:month" nsmap="${nsm}">
            <tr><c:set var="msg" value="month${ptr['@value']}"/>
              <td><fmt:message key="${msg}"/></td>

              <%-- foreach day --%>
              <jxp:forEach cnode="${ptr}" var="dptr" select="//c:day" nsmap="${nsm}">
                <%-- skipDay == null if it doesn't exist, and it's empty if it exists.
                     NOTE: The <c:set>'s are concatenated in order to generate less blank text.
                --%>
                  <c:set var="skipDay"  value="${dptr['c:skipDay']}"
                /><c:set var="dow"      value="${dptr['@dow']}"
                /><c:set var="theDay"   value="${(fn:length(dptr['@value']) lt 2 )?'0':''}${dptr['@value']}"
                /><c:set var="theMonth" value="${(fn:length(ptr['@value'])  lt 2 )?'0':''}${ptr['@value']}" />
                <td ${ ((dow=='1') or (dow=='7')) ? 'class="marked"' : ''}>
  <%-- =======================================================================
       IMPORTANT: parameters for the day must start with day_ followed by
                  the year, month and date. Used in admin:saveCalendar tag
       =======================================================================
--%>              <input
                    type="checkbox"
                    name="day_${param.year}${theMonth}${theDay}"
                    ${skipDay ne null ? "checked" : ""}>
                </td>
              </jxp:forEach> <%-- day --%>
            </tr>
          </jxp:forEach>	<%-- month --%>
        </table>

        <input type="submit" name="submit" value="<fmt:message key='submit'/>" />
        <input type="reset"  name="reset"  value="<fmt:message key='undo_changes'/>" />
        <input type="button" name="clear_all" onclick="for (var i=0; i &lt; document.getElementsByTagName('input').length; i++) { document.getElementsByTagName('input')[i].checked = false; };" value="<fmt:message key='clear_all'/>" />
        <input type="button" name="mark_all" onclick="for (var i=0; i &lt; document.getElementsByTagName('input').length; i++) { document.getElementsByTagName('input')[i].checked = true; };" value="<fmt:message key='mark_all'/>" />
      </form>
    </c:otherwise>
  </c:choose>
</div>
