<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt"   uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c"     uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x"     uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fn"    uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp"   tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="kfn"   uri="http://kalio.net/jsp/el-func-1.0" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%--
Notes:
   * the "admin" operator is a special user that cannot be disabled or deleted
--%>
-->
<div class="middle homepage">

  <div class="searchBox">

  <c:choose>
    <c:when test="${ (not empty param.edit_operator_submit) and (param.password1 == param.password2) }">
      <admin:saveOperator id="${param.id}"/>
      <p><a href="edit_operator.jsp?id=${kfn:urlenc(param.id)}"><fmt:message key="back_to_operators"/></a></p>
    </c:when>

    <%-- default page --%>
    <c:otherwise>

      <x:parse varDom="doc">
        <admin:getOperator id="${param.id}" />
      </x:parse>
      <jxp:set cnode="${doc}" var="op" select="/operator" />

      <h1><fmt:message key="operator_info"/></h1>
      <h2><fmt:message key="edit_operator"/></h2>

      <%-- operator details  --%>
      <h3><fmt:message key="operator_details"/></h3>
      <form method="post">
        <input type="hidden" name="id" value="${op['@id']}"/>
        <c:if test="${op['@id'] eq 'admin'}">
          <input type="hidden" name="property-accountenabled" value="on"/>
        </c:if>
        <table>
          <tr>
            <td><fmt:message key="operator_id"/></td>
            <td>${op['@id']}</td>
          </tr>
          <c:if test="${op['@id'] ne 'admin'}">
            <tr>
              <td><fmt:message key="account_enabled"/></td>
              <c:set var="accEnabled"><jxp:out cnode="${op}" select="/properties/property[@id='accountenabled']"/></c:set>
              <td><input type="checkbox" name="property-accountenabled" ${ accEnabled == 'on'? 'checked="true"' : ''}/></td>
            </tr>
          </c:if>
          <tr>
            <td><fmt:message key="operator_name"/></td>
            <td><input type="text" name="name" value="${op['name']}" class="textEntry" size="50"/></td>
          </tr>
          <tr>
            <td><fmt:message key="email"/></td>
            <td><input type="text" name="email" value="${op['email']}" class="textEntry" size="100"/></td>
          </tr>
          <tr>
            <td><fmt:message key="password"/></td>
            <td>
              <input type="password" name="password1" class="textEntry"/>
              <c:if test="${(not empty param.edit_operator_submit) and (param.password1 != param.password2) }">
                <fmt:message key="password_mismatch"/>
              </c:if>
            </td>
          </tr>
          <tr>
            <td><fmt:message key="confirm_password"/></td>
            <td>
              <input type="password" name="password2" class="textEntry"/>
              <c:if test="${(not empty param.edit_operator_submit) and (param.password1 != param.password2) }">
                <fmt:message key="password_mismatch"/>
              </c:if>
            </td>
          </tr>
        </table>
        <input type="submit" name="edit_operator_submit" value="<fmt:message key='submit'/>"/>

        <%-- ip whitelist --%>
        <h3><fmt:message key="allow_connections_from"/></h3>
        <table>
          <tr>
            <th><fmt:message key="enabled"/></th>
            <th><fmt:message key="location"/></th>
            <th><fmt:message key="ip_list"/></th>
          </tr>
          <tr>
            <c:set var="connFromAny"><jxp:out cnode="${op}" select="/properties/property[@id='connectfrom-anywhere']"/></c:set>
            <td><input type="checkbox" name="property-connectfrom-anywhere" ${ connFromAny == 'on'? 'checked="true"' : ''}></td>
            <td><fmt:message key="anywhere"/></td>
            <td>*</td>
          </tr>

          <x:parse varDom="libraries">
            <trans:doTransaction name="conf-getLibraries"/>
          </x:parse> 
          <jsp:useBean id="nsml" class="java.util.HashMap" />
          <c:set target="${nsml}" property="tr" value="http://kalio.net/empweb/schema/transactionresult/v1" />

          <jxp:forEach cnode="${libraries}" var="libr" select="//tr:library" nsmap="${nsml}">
            <tr>
              <c:set var="librId">${libr['@id']}</c:set>
              <c:set var="connFromLib"><jxp:out cnode="${op}" select="/properties/property[@id='connectfrom-library-${librId}']"/></c:set>
              <td><input type="checkbox" name="property-connectfrom-library-${librId}" ${ connFromLib == 'on'? 'checked="true"' : ''}></td>
              <td><fmt:message key="library"/>${librId}</td>
              <td>${libr['tr:ipMask']}</td>
            </tr>
          </jxp:forEach>
          <tr>
            <c:set var="connFromIPlistOn"><jxp:out cnode="${op}" select="/properties/property[@id='connectfrom-iplist-on']"/></c:set>
            <c:set var="connFromIPlist"><jxp:out cnode="${op}" select="/properties/property[@id='connectfrom-iplist']"/></c:set>
            <td><input type="checkbox" name="property-connectfrom-iplist-on" ${ connFromIPlistOn == 'on'? 'checked="true"' : ''}></td>
            <td><fmt:message key="ip_list"/></td>
            <td><input type="text" size="60" name="property-connectfrom-iplist" value="${ connFromIPlist}"/></td>
          </tr>
        </table>
        <input type="submit" name="edit_operator_submit" value="<fmt:message key='submit'/>"/>

        <%-- libraries --%>
        <h3><fmt:message key="libraries_list"/></h3>
        <table>
          <tr>
            <th><fmt:message key="library"/></th>
            <th><fmt:message key="has_access"/></th>
            <th><fmt:message key="access_hours"/></th>
            <th><fmt:message key="access_hours_unrestricted"/></th>
          </tr>

          <jxp:forEach cnode="${libraries}" var="libr" select="//tr:library" nsmap="${nsml}">
            <tr>
              <c:set var="librId">${libr['@id']}</c:set>
              <c:set var="currLib"><jxp:out cnode="${op}" select="/properties/property[@id='library-${librId}']"/></c:set>
              <c:set var="unresLib"><jxp:out cnode="${op}" select="/properties/property[@id='libraryHoursUnrestricted-${librId}']"/></c:set>

              <td>${libr['@id']} <c:if test="${not empty libr['tr:name']}">: ${libr['tr:name']}</c:if> </td>
              <td><input type="checkbox" name="property-library-${librId}" ${ currLib == 'on'? 'checked="true"' : ''}></td>
              <td>${libr['tr:hours']}</td>
              <td><input type="checkbox" name="property-libraryHoursUnrestricted-${librId}" ${ unresLib == 'on'? 'checked="true"' : ''}></td>
            </tr>
          </jxp:forEach>
        </table>
        <input type="submit" name="edit_operator_submit" value="<fmt:message key='submit'/>"/>

        <%-- groups --%>
        <h3><fmt:message key="group_list"/></h3>
        <table>
          <tr>
            <th><fmt:message key="has_access"/></th>
            <th><fmt:message key="group_id"/></th>
            <th><fmt:message key="group_permissions"/></th>
          </tr>

          <jxp:forEach cnode="${op}" var="group" select="/groups/group">
            <tr>
              <td><input  type="checkbox" name="group-${group['@id']}"
                          ${ (group['@active'] == 'true') ? 'checked="true"' : '' } >
              </td>
              <td>${group['@id']}</td>
              <td><c:set var="gid" value="${group['@id']}"/>
                  <c:forEach items="${fn:split(gid, '-')}" var="loc">
                    / <fmt:message key="${loc}"/>
                  </c:forEach>
              </td>
            </tr>
          </jxp:forEach>
        </table>
        <input type="submit" name="edit_operator_submit" value="<fmt:message key='submit'/>"/>

        <%-- properties --%>
        <x:parse varDom="dbNames">
          <trans:getDatabaseNames/>
        </x:parse>
        <jsp:useBean id="nsm" class="java.util.HashMap"  />
        <c:set target="${nsm}" property="db" value="http://kalio.net/empweb/schema/databases/v1" />
        <h3><fmt:message key="operator_properties"/></h3>
        <table>
          <tr>
            <td><fmt:message key="operator_prop_default_object_db"/></td>
            <td>
             <select name="property-default-object-db">
                <c:set var="currObjDb" value="${op['/properties/property[@id=\"default-object-db\"]']}"/>
                <option value="*"><fmt:message key="search_all"/></option>
                <jxp:forEach cnode="${dbNames}" var="dbptr" select="//db:databases/db:database[@type='objects']" nsmap="${nsm}">
                  <option ${ dbptr['.'] == currObjDb ? 'selected="selected"' : "" } >${dbptr['.']}</option>
                </jxp:forEach>
              </select>
            </td>
          </tr>
          <tr>
            <td><fmt:message key="operator_prop_default_user_db"/></td>
            <td>
              <select name="property-default-user-db">
                <c:set var="currUsuDb" value="${op['/properties/property[@id=\"default-user-db\"]']}"/>
                <option value="*"><fmt:message key="search_all"/></option>
                <jxp:forEach cnode="${dbNames}" var="dbptr" select="//db:databases/db:database[@type='users']" nsmap="${nsm}">
                  <option ${ dbptr['.'] == currUsuDb ? 'selected="selected"' : "" } >${dbptr['.']}</option>
                </jxp:forEach>
              </select>
          </tr>
        </table>

        <input type="submit" name="edit_operator_submit" value="<fmt:message key='submit'/>"/>
      </form>
    </c:otherwise>
  </c:choose>
  </div>
  
</div>

