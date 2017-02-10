<%@ page contentType="text/html; charset=UTF-8" %>
<%@ page import="net.kalio.auth.*" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>

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


<div class="middle homepage">
  
  <div class="searchBox">

  <h1><fmt:message key="reservation"/></h1>
  <h2><fmt:message key="reservation_form"/></h2>

  <admin:checkEngine var="engineOk"/>

  <c:choose>
    <%-- Engine disabled --%>
    <c:when test="${engineOk ne 'true'}">
      <p class="error"><fmt:message key="engine_disabled_try_again_later"/></p>
      <p><a href=""><fmt:message key="click_here_to_retry_last_transaction"/></a></p>
    </c:when>

    <%-- Engine is enabled --%>
    <c:otherwise>

      <%-- GET DATABASE NAMES --%>
      <c:if test="${not config['ew.hide_user_db'] or not config['ew.hide_object_db']}">
        <x:parse varDom="dbNames">
          <trans:getDatabaseNames/>
        </x:parse>
      </c:if>

      <%-- Check whether the object db comes as a request parameter, or use the one in the operator's property --%>
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
      
      
      
      
      <%-- NAMESPACE MAPS --%>
    <jsp:useBean id="nsm" class="java.util.HashMap"  />
    <c:set target="${nsm}" property="mod" value="http://www.loc.gov/mods/v3" />
    <c:set target="${nsm}" property="hol" value="http://kalio.net/empweb/schema/holdingsinfo/v1" />
    <c:set target="${nsm}" property="qr" value="http://kalio.net/empweb/schema/queryresult/v1" />
    <jxp:set cnode="${objectResult}"  var="modsResult" select="/mod:modsCollection" nsmap="${nsm}" />
    
    <jsp:useBean id="catMap" class="java.util.HashMap" />
      
    <%-- Obtain the object category for the wait --%>
      
      <c:choose>
      <c:when test="${not empty fn:trim(param.record_id)}">
          
      <x:parse var="objectResult">
        <trans:searchObjects database="${fn:trim(param.database)}">
        <query xmlns="http://kalio.net/empweb/schema/objectsquery/v1">
              <recordId>${param.record_id}</recordId>
        </query>
        </trans:searchObjects>
      </x:parse>           
      
        
      <jxp:forEach
          cnode="${objectResult}"
          var="ptr"
          select="//mod:mods"
          nsmap="${nsm}">
                    	  
           <%-- THEN LOAD ALL categoryObjects IDS --%>
           <jxp:forEach  cnode="${ptr}" var="ptr2" select="mod:extension/hol:holdingsInfo/hol:copies/hol:copy/hol:objectCategory" sortby="." nsmap="${nsm}">
                <c:set target="${catMap}"  property="${ptr2['.']}"  value="${ptr2['.']}"/>
           </jxp:forEach>
           
          
      </jxp:forEach>
      </c:when>
      </c:choose>

       
      
      <form method="get" action="user_query_result.jsp">
        <input type="hidden" name="user_name" />
        <input type="hidden" name="record_id" />
        <input type="hidden" name="volume_id" />
        <input type="hidden" name="object_category" />
        <input type="hidden" name="database" value="*" />
      </form>
      
      
      <script>
          function searchUsers()
          {
            
            document.forms[0].user_name.value=document.forms[1].user_id.value;
            document.forms[0].record_id.value=document.forms[1].record_id.value;
            if (document.forms[1].volume_id!="undefined" && document.forms[1].volume_id!=null)
            {
              document.forms[0].volume_id.value=document.forms[1].volume_id.value;
            }  
            document.forms[0].submit();
          }
        </script>



      <form method="get" action="wait_result.jsp">
        <c:if test="${config['ew.hide_user_db']}">
          <input type="hidden" name="user_db" value="${userDb}"/>
        </c:if>
         
        <input type="hidden" name="object_db"  value="${objectDb}"/>
        <table width="30%">
        
          <tr>
            <td><fmt:message key="user_id"/>: </td>
            <td>
              <input type="text" name="user_id" class="textEntry"
                <c:if test="${not empty fn:trim(param.user_id) }">
                  value="${param.user_id}"
                </c:if> size="20"
              >
              <input type="button" value="<fmt:message key="searchuser"/>" OnClick="javascript: searchUsers(); " />
              <c:if test="${empty param.user_id and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
            </td>
          </tr>
          
          <c:if test="${not config['ew.hide_user_db']}">
            <tr>
              <td><fmt:message key="user_db"/>: </td>
              <td>
                <dsp:selectUserDatabase name="user_db" dbNames="${dbNames}" selectedDb="${userDb}"/>
                <c:if test="${empty param.user_db and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
              </td>
            </tr>
          </c:if>

          <tr>
            <td><fmt:message key="record_id"/>: </td>
            <td>
            
              <c:if test="${empty fn:trim(param.record_id) }">
              <input type="text" name="record_id" class="textEntry" size="20">
              </c:if>
              
              <input  type="hidden" name="record_id" class="textEntry"
                <c:if test="${not empty fn:trim(param.record_id) }">
                 value="${param.record_id}"
                </c:if>
              />${param.record_id}
              <c:if test="${empty param.record_id and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
            </td>
          </tr>

          <c:choose>
          <c:when test="${fn:length(paramValues.volume_id) gt 1}">
            <tr>
              <td><fmt:message key="volume_id"/>: </td>
              <td>
                <select name="volume_id">
                  <c:forEach items="${paramValues.volume_id}" var="vol">
                    <option value="${vol}">${vol}</option>
                  </c:forEach>
                </select>
              </td>
            </tr>            
          </c:when>
          <c:when test="${(not empty param.volume_id) && (param.volume_id ne '')}">
            <tr>
              <td><fmt:message key="volume_id"/>: </td>
              <td>
                <input  type="hidden" name="volume_id" value="${param.volume_id}"/>
                ${param.volume_id}
              </td>
            </tr>
          </c:when>
          </c:choose>
          
          
          <tr>
            <td><fmt:message key="object_category"/>: </td>
            <td>
                          
                  <select name="object_category">
                    <c:forEach items="${catMap}" var="cat">
                      <option value="${cat.value}">${cat.value}</option>
                    </c:forEach>
                  </select>
            
            </td>          
          </tr>
          
          
          <tr>
            <td><fmt:message key="library"/>:</td>
            <td>
              <select name="object_location">
                <c:forEach items="${fn:split(sessionScope.libsWithAccess, ',')}" var="libr">
                  <option value="${libr}">${libr}</option>
                </c:forEach>
              </select>
            </td>
          </tr>



<!--           <tr>
//             <td><fmt:message key="start_date"/>: </td>
//             <td>
//               <input  type="hidden" name="start_date"
//                 <c:if test="${not empty fn:trim(param.start_date) }">
//                   value="${param.start_date}"
//                 </c:if>
//               />
//               <util:formatDate type="date">${param.start_date}</util:formatDate> &nbsp; &nbsp;
//               <a href="javascript: history.go(-1)">(<fmt:message key="change"/>)</a>
//               <c:if test="${empty param.start_date and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
//             </td>
//           </tr>
// 
//           <tr>
//             <td><fmt:message key="object_category"/>: </td>
//             <td>
//               <input  type="hidden" name="object_category"
//                 <c:if test="${not empty fn:trim(param.object_category) }">
//                   value="${param.object_category}"
//                 </c:if>
//               />${param.object_category}
//               <c:if test="${empty param.object_category and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
//             </td>
//           </tr>
// 
//           <tr>
//             <td><fmt:message key="object_location"/>: </td>
//             <td>
//               <input  type="hidden" name="object_location"
//                 <c:if test="${not empty fn:trim(param.object_location) }">
//                   value="${param.object_location}"
//                 </c:if>
//               />${param.object_location}
//               <c:if test="${empty param.object_location and not empty param.submit}"> <fmt:message key="required_field"/></c:if>
//             </td>
//           </tr>-->

          <c:if test="${not empty param.accept_end_date}">
            <%-- the loan or reservation possible end date is less than stated in the profile, so ask confirmation --%>
            <tr>
              <td colspan="2">
                <strong><fmt:message key="retry_reservation_accept_possible_end_date_less_than_profile"></fmt:message></strong>
                <input type="hidden" name="accept_end_date"  value="${param.accept_end_date}"/>
              </td>
            </tr>
          </c:if>

           <tr>
            <td>&nbsp;<input type="hidden" name="start_date" value="20090308" /></td>
            
            <td><input type="submit" name="submit" value="<fmt:message key="process_reservation"/>"/></td>
          </tr>
        </table>
      </form>

    </c:otherwise>
  </c:choose>
  </div>
   <br />
</div>
