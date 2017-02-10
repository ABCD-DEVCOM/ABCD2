<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ page import="net.kalio.auth.*" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
-->
<div class="middle homepage">

<div class="searchBox">

  <h3><fmt:message key="choose_library"></fmt:message></h3>
  
<% 
   String userid = (String)session.getAttribute("user");
   HashMap propHash = Auth.getUserProperties(userid);
   String libDefault = "";
   String libsWithAccess = "";
   if (propHash != null) {
     Iterator it = (new TreeSet(propHash.keySet())).iterator();
     while (it.hasNext()) {
       String libName = (String)it.next();
         if ( (libName.startsWith("library-")) && ("on".equals(propHash.get(libName))) ) 
         { libDefault = libName.substring(8);
           libsWithAccess += libDefault+(it.hasNext()  ? "," : "");
         }
         System.out.println("Libraries with access : " + libsWithAccess);
         session.setAttribute("libsWithAccess",libsWithAccess);
        }//while
    }
%>


<form method="post" action="/empweb/authenticate.jsp">
  <table>
    <tr>
      <td><fmt:message key="library"/>:</td>
      <td>
        <select name="library">
          <c:forEach items="${fn:split(sessionScope.libsWithAccess, ',')}" var="libr">
            <option value="${libr}">${libr}</option>
          </c:forEach>
        </select>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="submit" name="submit" value="<fmt:message key='submit'/>" />
      </td>
    </tr>
  </table>
  <input type="hidden" name="user" value="${sessionScope.user}" />
  <input type="hidden" name="password" value="dummy"/>
</form>

</div>

<br />

</div>

