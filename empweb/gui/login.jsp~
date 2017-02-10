<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->


<%@ page import="java.util.Enumeration" %>


<%


String path = (String) request.getServletPath();
String absoluteContext = request.getRequestURI();
absoluteContext = absoluteContext.substring(0,absoluteContext.length()-path.length());
session.setAttribute("resources",absoluteContext+"/resources");
%>
<fmt:setLocale value="${sessionScope.userLocale}"/>
<fmt:requestEncoding value="UTF-8"/>
<fmt:setBundle basename="ewi18n.core.gui" scope="request"/>


<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><fmt:message key="institution" /> | <fmt:message key="empweb_login" /></title>
    <!--<style type="text/css"media="all">@import "main.css"; </style>
    <style type="text/css"media="all">@import "local.css"; </style>-->
    <style type="text/css"media="all">@import "template.css"; </style>
    
  
  <script src=lr_trim.js></script>
  <script>  
  function Enviar(){
	login=Trim(document.forms[0].user.value)
	password=Trim(document.forms[0].password.value)
	if (login=="" || password=="" ){
		alert("Insert your identification data")
		return
	}else{
		document.forms[0].submit()
	}
  }
  </script>


    
  </head>

  <body ${not empty param.libraries ? 'onload="document.getElementById(\'password\').focus()"' : ''}>

   <jsp:include page="institution.jspf"/>

  <div class="middle login">
    
    <h2><fmt:message key="empweb_login" /></h2>
 
    
  <c:if test="${config['gui.demo']}">
    <p class="demo"><fmt:message key="demo_login_message"/></p>
  </c:if>
  
  
    <c:if test="${not config['gui.hide_languages']}">
      |
        <c:forEach items="${fn:split(config['gui.languages'], ',')}" var="langs">
          <a href="login.jsp?lang=${langs}"><fmt:message key="${fn:substring(langs,0,2)}"/></a> |
        </c:forEach>
      
    </c:if>


    <form method="post" action="authenticate.jsp">



    <div class="loginForm">
    
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				
			<div class="boxContent">
					

  
      <input type="hidden" name="origURL" value="${fn:escapeXml(param.origURL)}" />


          <c:if test="${not empty param.libraries}">
          
          <c:if test="${not empty param.errorMsg}">
            <p class="error"><fmt:message key="${fn:escapeXml(param.errorMsg)}" /></p>
          </c:if>

          
          
            <div id="formRow3" class="formRow formRowFocus">

         
                <select name="library" class="textEntry singleTextEntry">
                  <c:forEach items="${fn:split(param.libraries, ',')}" var="libr">
                    <option value="${libr}">${libr}</option>
                  </c:forEach>
                </select>
            </div>
          </c:if>
          <c:if test="${empty param.libraries}">
          <%
          
            // Esto es por si cierra el navegador y queda con session abierta
          
             session.setAttribute("prevlogin",""); 
             session.setAttribute("prevpass",""); 
 
          %>
          </c:if>
          <div class="spacer">&#160;</div>

            <div class="formRow">
          
            <label><fmt:message key="operator_id"/>:</label>
            <input type="text" name="user" value="${fn:trim(param.user)}" class="textEntry superTextEntry" value="<%= session.getAttribute("prevlogin") %>"/>
            
            <label><fmt:message key="password"/>:</label>
            <input id="password" type="password" name="password" class="textEntry superTextEntry" value="<% if (session.getAttribute("prevpass")!=null) {out.print(session.getAttribute("prevpass"));} %>"/>
            
            <div class="submitRow">
						<div class="frLeftColumn">
						<!--	<a href="#">esqueceu a senha?</a>-->
						</div>

						<div class="frRightColumn">
						
						  <a href="javascript:Enviar()" class="defaultButton goButton">
								<img src="defaultButton_next.png" alt="" title="" />
								<span><strong><fmt:message key='submit'/></strong></span>
							</a>

							
						</div>
						
						<div class="spacer">&#160;</div>
					  </div>

              
            </div>    <!-- del submitrow -->
          
    
      </div> <!-- del box content -->
      
      <div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>

     
     </div> 
    
    
      </form>
  
    </div>
    
    <jsp:include page="coda.jspf"/>
    
  </body>
  </html>
