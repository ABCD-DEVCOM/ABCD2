<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="kfn"   uri="http://kalio.net/jsp/el-func-1.0" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->
<div class="middle homepage">
  <h1><fmt:message key="pipelines_admin"/></h1>
  <h2><fmt:message key="pipeline_edit"/></h2>

  <c:choose>
    <c:when test="${not empty param.submit}">
      <%-- when submitted, save it --%>
      <admin:adminResult>
        <admin:savePipeline name="${param.name}"/>
      </admin:adminResult>

      <p><a href="edit_pipeline.jsp?name=${kfn:urlenc(param.name)}"><fmt:message key="back_to_pipeline"><fmt:param value="${param.name}"/></fmt:message></a></p>
    </c:when>

    <c:otherwise>
      <%-- otherwise, show the form --%>
      <x:parse var="doc">
        <admin:getPipeline name="${param.name}"/>
      </x:parse>

      <jsp:useBean id="nsm" class="java.util.HashMap" />
      <c:set target="${nsm}" property="t" value="http://kalio.net/empweb/schema/transaction/v1" />
      <jxp:set cnode="${doc}" var="trans" nsmap="${nsm}" select="//t:transaction" />

      <h3><fmt:message key="pipeline"/></h3>
      <table>
        <tr>
          <td><fmt:message key="name"/></td>                <td>${trans['@name']}</td>
        </tr>
        <tr>
          <td><fmt:message key="type"/></td>                <td>${trans['@type']}</td>
        </tr>
        <tr>
          <td><fmt:message key="evaluation_method"/></td>   <td>${trans['@evaluation']}</td>
        </tr>
        <tr>
          <td><fmt:message key="classpath"/></td>           <td>${trans['@classpath']}</td>
        </tr>
      </table>

      <form method="post">

      <h3><fmt:message key="process_and_rules"/></h3>

        <table id="result">
          <tr>
            <th><fmt:message key="enabled"/></th>
            <th><fmt:message key="type"/></th>
            <th><fmt:message key="name"/></th>
            <th><fmt:message key="description"/></th>
            <th><fmt:message key="actions"/></th>
          </tr>

          <jxp:set cnode="${doc}" var="procCount" select="count(//t:transaction/t:process|//t:transaction/t:rule|//t:transaction/t:finally)" nsmap="${nsm}"/>

          <jxp:forEach
            cnode="${doc}"
            var="ptr"
            select="//t:transaction/t:process|//t:transaction/t:rule|//t:transaction/t:finally"
            nsmap="${nsm}">


            <%-- change the style of the process we just moved --%>
            <c:set var="justMovedStyle" value="${ (ptr['@name'] == param.moved) ? 'style=\"background: #FF7\"' : '' }" />

            <tr ${justMovedStyle} >
              <td>
                <c:set var="checkMark" value=" ${ (ptr['@enabled'] == 'false') ? '' : 'checked' }"/>
                <input type="checkbox" value="enabled" name="enabled_${ptr['@name']}"  ${checkMark}>
              </td>
              <td>
                <jxp:out cnode="${ptr}" select="name(.)" nsmap="${nsm}"/>
                <c:if test="${ptr['@class'] eq 'net.kalio.empweb.engine.rules.GroovyInterpreter'}">(<fmt:message key="script"/>)</c:if>
              </td>
              <td>
                ${ptr['@name']}
              </td>

              <td>
<%-- BBB @todo SACAR LA PRIMERA LINEA DEL ELEMENTO DOC, si vacio SACAR LA DESCRIPCION DEL BUNDLE --%>
                ${kfn:splitLines(ptr['t:doc'])[0]}
              </td>
              <td>
                <c:choose>
                  <c:when test="${(procCount gt 1) and (_jxpItem != 1)}">
                    <a href="order_process.jsp?dir=up&amp;pipeline_name=${kfn:urlenc(param.name)}&amp;name=${kfn:urlenc(ptr['@name'])}"><fmt:message key="up"/></a>
                  </c:when>
                  <c:otherwise>
                    <fmt:message key="up"/>
                  </c:otherwise>
                </c:choose>
                | <c:choose>
                    <c:when test="${(procCount gt 1) and (_jxpItem != procCount)}">
                      <a href="order_process.jsp?dir=down&amp;pipeline_name=${kfn:urlenc(param.name)}&amp;name=${kfn:urlenc(ptr['@name'])}"><fmt:message key="down"/></a>
                    </c:when>
                    <c:otherwise>
                      <fmt:message key="down"/>
                    </c:otherwise>
                  </c:choose>
                | <a href="edit_process.jsp?pipeline_name=${kfn:urlenc(param.name)}&amp;process_name=${kfn:urlenc(ptr['@name'])}"><fmt:message key="edit"/></a>
                | <a href="delete_process.jsp?pipeline_name=${kfn:urlenc(param.name)}&amp;name=${kfn:urlenc(ptr['@name'])}&amp;type=<jxp:out cnode="${ptr}" select="name()" nsmap="${nsm}"/>"><fmt:message key="delete"/></a>
              </td>
            </tr>
          </jxp:forEach>

          <tr>
            <td colspan="4"/>
            <td>
              <a href="new_process.jsp?pipeline_name=${kfn:urlenc(param.name)}">
                <fmt:message key="create_new_process"/>
              </a>
            </td>
          </tr>

        </table>
        <input type="submit" name="submit" value="<fmt:message key='submit'/>"/>

        <h3><fmt:message key="environment_parameters"/></h3>
        <div>
          <fmt:message key="xml"/>
          <textarea  class="xmleditor" name="environment_xml"  rows="8" cols="80" ><jxp:outXml select="//t:transaction/t:environment" cnode="${doc}" nsmap="${nsm}" /></textarea>
        </div>
        <input type="submit" name="submit" value="<fmt:message key='submit'/>"/>
      </form>
    </c:otherwise>

  </c:choose>
</div>
