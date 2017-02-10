<?xml version="1.0"?> <!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
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

<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="pol" value="http://kalio.net/empweb/schema/policy/v1" />

<%-- Save the operation result in a scope string for reusing it later --%>
<c:set var="strOpr">
  <admin:getPolicy id="${param.id}" />
</c:set>
<x:parse varDom="docOpr" >
  ${strOpr}
</x:parse>

<jxp:set var="pol_id"   cnode="${docOpr}" nsmap="${nsm}" select="//pol:policy/@id"/>
<jxp:set var="pol_name" cnode="${docOpr}" nsmap="${nsm}" select="//pol:policy/pol:name"/>

<%-- SORTED MAPS TO BUILD THE MATRIX --%>
<jsp:useBean id="objectCategoryList" class="java.util.TreeMap"/>
<jsp:useBean id="userClassList" class="java.util.TreeMap"/>

<div class="middle homepage">

  <c:choose>

    <%-- An empty policy id probably means an error during processing. Process the error message --%>
    <c:when test="${empty pol_id}">
      <admin:adminResult>${strOpr}</admin:adminResult>
    </c:when>


    <c:otherwise>
      <h1><fmt:message key="policy_info"/></h1>
      <h2><fmt:message key="edit_policy"/></h2>

      <%-- POLICY DETAILS  --%>
      <h3><fmt:message key="policy_details"/></h3>
      <table>
        <tr>
          <td><fmt:message key="policy_name"/></td>
          <td>${pol_name}</td>
        </tr>
        <tr>
          <td><fmt:message key="policy_id"/></td>
          <td>${pol_id}</td>
        </tr>
      </table>

      <c:choose>
        <c:when test="${not empty param.show_list}">
          <%-- SHOW PROFILES LIST --%>
          <h3><fmt:message key="profiles_list"/> (<a href="edit_policy.jsp?id=${pol_id}&amp;name=${pol_name}"><fmt:message key="show_as_matrix"/></a>)</h3>
          <table>
            <tr>
              <th><fmt:message key="user_class"/></th>
              <th><fmt:message key="object_category"/></th>
              <th><fmt:message key="actions"/></th>
            </tr>
            <jxp:forEach cnode="${docOpr}" nsmap="${nsm}" var="ptr" select="//pol:profile">
              <tr>
                <td>${ptr['pol:userClass']}</td>
                <td>${ptr['pol:objectCategory']}</td>
                <td>
                  <a href="edit_profile.jsp?profile_id=${ptr['@id']}">
                    <fmt:message key="edit"/>
                  </a> |
                  <a href="delete_profile.jsp?profile_id=${ptr['@id']}">
                    <fmt:message key="delete"/>
                  </a>
                </td>
              </tr>
            </jxp:forEach>
            <tr>
              <td colspan="2" />
              <td>
<%--                <a href="new_profile.jsp?policy_id=${pol_id}&amp;policy_name=${pol_name}"><fmt:message key="create_new_profile" /></a> --%>
                <a href="edit_profile.jsp?policy_id=${pol_id}&amp;profile_id=new"><fmt:message key="create_new_profile" /></a>
              </td>
            </tr>
          </table>
        </c:when>


        <c:otherwise>
          <%-- SHOW PROFILES MATRIX: --%>
          <%-- BUILD THE MATRIX COLUMN AND ROW LISTS --%>
          <jxp:forEach cnode="${docOpr}" nsmap="${nsm}" var="ptr" select="//pol:profile">
            <c:set target="${objectCategoryList}" property="${ptr['pol:objectCategory']}" value="${ptr['pol:objectCategory']}" />
            <c:set target="${userClassList}"      property="${ptr['pol:userClass']}" value="${ptr['pol:userClass']}" />
          </jxp:forEach>

          <h3><fmt:message key="profiles_matrix"/> (<a href="edit_policy.jsp?id=${pol_id}&amp;name=${pol_name}&amp;show_list=true"><fmt:message key="show_as_list"/></a>)</h3>
          <table class="matrix">
            <tr>
              <td class="axisname"/>
              <td class="axisname" colspan="${fn:length(userClassList)+1}"><fmt:message key="user_class"/></td>
            </tr>
            <tr>
              <td class="axisname" rowspan="${fn:length(objectCategoryList)+1}"><fmt:message key="object_category"/></td>
              <td class="axisname"/>
              <c:forEach items="${userClassList}" var="thisUC">
                <td class="axistitle">${thisUC.value}</td>
              </c:forEach>
            </tr>

            <c:forEach items="${objectCategoryList}" var="thisOC">
              <tr>
                <td class="axistitle">${thisOC.value}</td>
                <c:forEach items="${userClassList}" var="thisUC">
                  <jxp:set  cnode="${docOpr}" nsmap="${nsm}" var="thisP" select="//pol:profile[(pol:objectCategory='${thisOC.value}') and (pol:userClass='${thisUC.value}')]"/>
                  <td>
                    <c:choose>
                      <c:when test="${(not empty thisP)}">
                        <a href="edit_profile.jsp?profile_id=${thisP['@id']}">
                          <fmt:message key="edit"/>
                        </a>
                      </c:when>
                      <c:otherwise>
<%--                        <a href="new_profile.jsp?policy_id=${pol_id}&amp;policy_name=${pol_name}&amp;object_category=${thisOC.value}&amp;user_class=${thisUC.value}">+</a> --%>
                        <a href="edit_profile.jsp?policy_id=${pol_id}&amp;profile_id=new&amp;object_category=${thisOC.value}&amp;user_class=${thisUC.value}">+</a>
                      </c:otherwise>
                    </c:choose>
                  </td>
                </c:forEach>
              </tr>
            </c:forEach>
          </table>
          <p>
            <%-- <a href="new_profile.jsp?policy_id=${pol_id}&amp;policy_name=${pol_name}"><fmt:message key="create_new_profile" /></a> --%>
            <a href="edit_profile.jsp?policy_id=${pol_id}&amp;profile_id=new"><fmt:message key="create_new_profile" /></a>
          </p>
        </c:otherwise>
      </c:choose>

    </c:otherwise>
  </c:choose>
</div>
