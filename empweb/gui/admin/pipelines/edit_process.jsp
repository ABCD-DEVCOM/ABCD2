<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->
<script language="Javascript" type="text/javascript" src="codepress.js"></script>
<div class="middle homepage">
  <h1><fmt:message key="process_admin"/></h1>
  <h2><fmt:message key="process_edit"/></h2>

  <c:choose>
    <c:when test="${not empty param.submit}">
      <%-- when submitted, save it --%>
      <admin:adminResult>
        <admin:saveProcess processName="${param.process_name}" pipelineName="${param.pipeline_name}"/>
      </admin:adminResult>

      <p><a href="edit_process.jsp?process_name=${param.process_name}&amp;pipeline_name=${param.pipeline_name}">
          <fmt:message key="back_to_process">
            <fmt:param value="${param.process_name}"/>
            <fmt:param value="${param.pipeline_name}"/>
          </fmt:message>
        </a>
      </p>
    </c:when>

    <c:otherwise>
      <%-- otherwise, show the form --%>
      <x:parse var="doc">
        <admin:getPipeline name="${param.pipeline_name}"/>
      </x:parse>

      <jsp:useBean id="nsm" class="java.util.HashMap" />
      <c:set target="${nsm}" property="t" value="http://kalio.net/empweb/schema/transaction/v1" />

      <jxp:set var="process" nsmap="${nsm}" cnode="${doc}" select="//t:transaction/*[@name='${param.process_name}']"/>

      <form method="post" onsubmit="parameters_box.toggleEditor()">
        <h3><fmt:message key="process_info"/></h3>
        <table>
          <tr>
            <td><fmt:message key="pipeline_name"/></td>
            <td><a href="edit_pipeline.jsp?name=${param.pipeline_name}">${param.pipeline_name}</a></td>
          </tr>
          <tr>
            <td><fmt:message key="process_name"/></td> <td>${process['@name']}</td>
          </tr>
          <tr>
            <td><fmt:message key="type"/></td>
            <td><jxp:out nsmap="${nsm}" cnode="${process}" select="name()" /></td>
          </tr>
          <tr>
            <td><fmt:message key="class"/></td> <td>${process['@class']}</td>
          </tr>
          <tr>
            <td><fmt:message key="bundle"/></td> <td>${process['@bundle']}</td>
          </tr>
        </table>

        <h3><fmt:message key="process_doc"/></h3>
        <div>
         <textarea wrap="off"
                    class="xmleditor"
                    name="doc_xml"
                    cols="100"
                    rows="3"><jxp:encodeXml><jxp:outXml cnode="${process}"
                                                        select="t:doc"
                                                        nsmap="${nsm}"/></jxp:encodeXml></textarea>
        </div>

        <h3><fmt:message key="process_limits"/></h3>
        <div>
          <textarea wrap="off"
                    class="xmleditor"
                    name="limits_xml"
                    cols="100"
                    rows="2" ><jxp:encodeXml><jxp:outXml  cnode="${process}"
                                                          select="t:limits"
                                                          nsmap="${nsm}" /></jxp:encodeXml></textarea>
        </div>

        <h3><fmt:message key="process_parameters"/></h3>
        <%--
        <div>
          <table>
            <th>Editor syntax</th>
            <tr><td><input type="radio" name="syntax_lang" value="Java" onclick="parameters_box.language='java'">Java</input></td></tr>
            <tr><td><input type="radio" name="syntax_lang" value="XML" onclick="parameters_box.language='html'">XML</input></td></tr>
          </table>
        </div>
        --%>

        <div style="margin:10px;border:none;">
          <textarea  id="parameters_box"
                     wrap="off"
                     class="codepress java linenumbers-off" 
                     style="width:95%;height:400px;font-size:0.9em;"
                     name="params_xml" ><jxp:encodeXml><jxp:outXml  cnode="${process}"
                                                                    select="t:params"
                                                                    nsmap="${nsm}" /></jxp:encodeXml>
          </textarea>
        </div>
        <script>
          

        </script>


        <div style="margin:0; padding:0; text-align:right; width:95%;">
        <a href="#" onclick="return changeEditBox('parameters_box', 1);">&nbsp;+&nbsp;</a>&nbsp;&nbsp;
        <a href="#" onclick="return changeEditBox('parameters_box', -1);">&nbsp;-&nbsp;</a>
        <script>
          function changeEditBox(id, inDirection) {
          	var rowCount = document.getElementById(id).rows;
          	rowCount += (inDirection * 10);
          	rowCount = (rowCount < 10) ? 10 : rowCount;
          	document.getElementById(id).rows = rowCount;
          	return false;
          }         
        </script>
        </div>





        <input type="submit" name="submit" value="<fmt:message key='submit'/>"/>


      </form>

    </c:otherwise>
  </c:choose>
</div>
