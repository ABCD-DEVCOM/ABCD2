<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->

<div id="pleasewait"><fmt:message key="please_wait"/></div>
<% out.flush( ); %>
<script>
<!--
document.getElementById('pleasewait').style.display = "none"
-->
</script>


<%-- NAMESPACE MAPS --%>
<jsp:useBean id="nsm" class="java.util.HashMap"  />
<c:set target="${nsm}" property="mod" value="http://www.loc.gov/mods/v3" />
<c:set target="${nsm}" property="hol" value="http://kalio.net/empweb/schema/holdingsinfo/v1" />
<c:set target="${nsm}" property="qr" value="http://kalio.net/empweb/schema/queryresult/v1" />
<jxp:set cnode="${objectResult}"  var="modsResult" select="/mod:modsCollection" nsmap="${nsm}" />

<%-- PREPARRE EXTRA PARAMS HASH MAP --%>
<jsp:useBean id="extraParams" class="java.util.HashMap" />
<c:if test="${not empty fn:trim(param.object_recordid)}">
  <c:set target="${extraParams}"  property="object_recordid"  value="${fn:trim(param.object_recordid)}"/>
</c:if>
<c:if test="${not empty fn:trim(param.object_title)}">
  <c:set target="${extraParams}"  property="object_title"     value="${fn:trim(param.object_title)}"/>
</c:if>
<c:if test="${not empty fn:trim(param.object_author)}">
  <c:set target="${extraParams}"  property="object_author"    value="${fn:trim(param.object_author)}"/>
</c:if>
<c:if test="${not empty fn:trim(param.object_yearfrom)}">
  <c:set target="${extraParams}"  property="object_yearfrom"  value="${fn:trim(param.object_yearfrom)}"/>
</c:if>
<c:if test="${not empty fn:trim(param.object_yearto)}">
  <c:set target="${extraParams}"  property="object_yearto"    value="${fn:trim(param.object_yearto)}"/>
</c:if>

<!--
<%-- DIRTY HACK. The <and> operator of the <query> needs at least two operands.
     If we have object_yearfrom AND object_yearto (and we should have BOTH or NONE!!!) then we count
     one less extraParam, so we only use <and> when necessary.
--%>
-->
<c:choose>
  <c:when test="${not empty extraParams.object_yearfrom and not empty extraParams.object_yearto}">
    <c:set var="numExtraParams" value="${fn:length(extraParams) - 1}"/>
  </c:when>
  <c:otherwise>
    <c:set var="numExtraParams" value="${fn:length(extraParams)}"/>
  </c:otherwise>
</c:choose>

<%-- FIRST WE MAKE THE QUERY, CALLING trans:searchObjectsById OR THE GENERIC trans:searchObjects --%>
<c:choose>
  <%-- WE SEARCH FOR A SPECIFIC COPY --%>
  <c:when test="${not empty fn:trim(param.object_copyid)}">

    <x:parse var="objectResult">
      <trans:searchObjectsById  database="${fn:trim(param.database)}">
        ${fn:trim(param.object_copyid)}
      </trans:searchObjectsById> 
    </x:parse>
  </c:when>

  <%-- WE DO A MORE COMPLEX, GENERIC QUERY --%>
  <c:when test="${numExtraParams gt 0}">
    <x:parse var="objectResult">
      <trans:searchObjects database="${fn:trim(param.database)}">
        <query xmlns="http://kalio.net/empweb/schema/objectsquery/v1">
          <c:choose>

            <%-- we search for a specific record/work --%>
            <c:when test="${ not empty extraParams.object_recordid}">
              <recordId>${extraParams.object_recordid}</recordId>
            </c:when>

            <%-- we search for several fields, combined by and if there's more than one--%>
            <c:otherwise>
              <c:if test="${numExtraParams gt 1}">
                <and>
              </c:if>
              <c:if test="${not empty extraParams.object_title}">
                <title>${extraParams.object_title}</title>
              </c:if>
              <c:if test="${not empty extraParams.object_author}">
                <author>${extraParams.object_author}</author>
              </c:if>
              <c:if test="${(not empty extraParams.object_yearfrom) or (not empty extraParams.object_yearto)}">
                <year from="${extraParams.object_yearfrom}" to="${extraParams.object_yearto}"/>
              </c:if>
              <c:if test="${numExtraParams gt 1}">
              </and>
              </c:if>
            </c:otherwise>
          </c:choose>
        </query>
      </trans:searchObjects>
    </x:parse>
  </c:when>

  <%-- SOMETHING WRONG WITH THE  QUERY: FAIL SILENTYL --%>
  <c:otherwise>
    <c:redirect url="index.jsp"/>
  </c:otherwise>
</c:choose>


<%-- SORT PARAMETERS --%>
<c:set var="sortElement">
  <c:choose>
    <c:when test="${param.sort_element eq 'recordid'}">mod:recordInfo/mod:recordIdentifier</c:when>
    <c:when test="${param.sort_element eq 'title'}">mod:titleInfo/mod:title</c:when>
    <c:when test="${param.sort_element eq 'author'}">mod:name/mod:namePart</c:when>
    <c:when test="${param.show_all_copies eq '1'}">hol:holdingsInfo/hol:copies/hol:copy/hol:copyId</c:when>
    <c:otherwise>mod:titleInfo/mod:title</c:otherwise>
  </c:choose>
</c:set>
<c:set var="sortOrder">${(not empty param.sort_order)?param.sort_order:'ascending'}</c:set>


<%-- COUNT MATCHING RESULTS --%>
<jxp:set var="results_count" cnode="${objectResult}" select="count(//*[local-name()='mods'])" />



<%-- DISPLAY OPTIONS  --%>
<c:choose>



  <%-- ONLY ONE RESULT: SHOW CORRESPONDING STATUS PAGE --%>
  <%-- ONLY ONE RESULT: redirect --%>
  <c:when test="${(empty param.show_all_copies) and (results_count eq 1) and (not empty fn:trim(param.database)) and (fn:trim(param.database) ne '*') and (empty param.action)}">
    <c:choose>
      <c:when test="${(not empty fn:trim(param.object_copyid))}">
        <c:redirect url="copy_status_result.jsp?copy_id=${fn:trim(param.object_copyid)}&object_db=${fn:trim(param.database)}"/>
      </c:when>
      <c:when test="${(not empty fn:trim(param.object_recordid))}">
        <c:redirect url="record_status_result.jsp?record_id=${fn:trim(param.object_recordid)}&object_db=${fn:trim(param.database)}"/>
      </c:when>
    </c:choose>
  </c:when>

  <%-- NO RESULTS --%>
  <c:when test="${results_count == 0}">
    <div class="middle homepage">
      <p><fmt:message key="no_results_found"/></p>
      <p><a href="index.jsp"><fmt:message key="back_to_query"/></a></p>
    </div>
  </c:when>

  <%-- MORE THAN ONE RESULT: SHOW THE LIST --%>
  <c:otherwise>

    <c:set var="thisUrlPrefix">object_query_result.jsp?object_recordid=${param.object_recordid}&amp;object_copyid=${param.object_copyid}&amp;object_author=${param.object_author}&amp;object_title=${param.object_title}&amp;database=${param.database}</c:set>

    
    <div class="middle homepage">

      <table id="result">
        <%-- HEADER ROW --%>
        <tr>
          <c:if test="${not config['ew.hide_object_db']}">
            <th><fmt:message key="database"/></th>
          </c:if>
          <th>
            <a href="${thisUrlPrefix}&amp;sort_element=recordid&amp;sort_order=${(param.sort_order eq 'ascending')?'descending':'ascending'}">
              <fmt:message key="record_id"/>${(param.sort_element eq 'recordid')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
            </a>
          </th>
          <th>
            <fmt:message key="volume_id"/>
          </th>
          <th>
            <fmt:message key="copy_id"/>
          </th>
          <th>
            <a href="${thisUrlPrefix}&amp;sort_element=title&amp;sort_order=${(param.sort_order eq 'ascending')?'descending':'ascending'}">
              <fmt:message key="title"/>${(param.sort_element eq 'title')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
            </a>
          </th>
          <th>
            <a href="${thisUrlPrefix}&amp;sort_element=author&amp;sort_order=${(param.sort_order eq 'ascending')?'descending':'ascending'}">
              <fmt:message key="author"/>${(param.sort_element eq 'author')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}
            </a>
          </th>
          <th>
            <fmt:message key="object_category"/>
          </th>                    
          <th>
            <fmt:message key="year"/>
          </th>
        </tr>

        <%-- RESULT ROWS - FOR EACH RECORD --%>
        <jxp:forEach
          cnode="${objectResult}"
          var="ptr"
          select="//mod:mods"
          nsmap="${nsm}"
          sortby="${sortElement}"
          sortorder="${sortOrder}">

          <jsp:useBean id="volsMap" class="java.util.HashMap" />
	  
          <c:choose>
            <c:when test="${not empty param.volume_id}">
              <c:set target="${volsMap}"  property="${param.volume_id}"  value="${param.volume_id}"/>
            </c:when>
            <c:otherwise>
              <%-- IF THE RECORD HAS NO VOL_ID PUT AN EMPTY ELEMENT --%>
              <jxp:set var="totalCount" cnode="${ptr}" select="count(mod:extension/hol:holdingsInfo/hol:copies/hol:copy)" nsmap="${nsm}" />
              <jxp:set var="withVolCount" cnode="${ptr}" select="count(mod:extension/hol:holdingsInfo/hol:copies/hol:copy/hol:volumeId)" nsmap="${nsm}" />
              <c:if test="${(fn:length(volsMap) == 0) or (totalCount > withVolCount)}"><c:set target="${volsMap}"  property="__"  value=""/></c:if>
              <%-- THEN LOAD ALL VOL IDS --%>
              <jxp:forEach  cnode="${ptr}" var="ptr2" select="mod:extension/hol:holdingsInfo/hol:copies/hol:copy/hol:volumeId" sortby="." nsmap="${nsm}">
                <c:set target="${volsMap}"  property="${ptr2['.']}"  value="${ptr2['.']}"/>
              </jxp:forEach>
            </c:otherwise>
          </c:choose>
          
          
          
          <%-- Saco todas las categorías de los objetos --%>
          
          <jsp:useBean id="catMap" class="java.util.HashMap" />
	  
           <%-- THEN LOAD ALL categoryObjects IDS --%>
           <jxp:forEach  cnode="${ptr}" var="ptr2" select="mod:extension/hol:holdingsInfo/hol:copies/hol:copy/hol:objectCategory" sortby="." nsmap="${nsm}">
                <c:set target="${catMap}"  property="${ptr2['.']}"  value="${ptr2['.']}"/>
           </jxp:forEach>
           

          <%-- FOR EACH VOLUME - ONE ROW PER VOLUME --%>
          <c:forEach items="${volsMap}" var="vol">
          
            
            <c:choose>
              <c:when test="${vol.value eq ''}">
                <jxp:set var="copiesCount" cnode="${ptr}" select="count(mod:extension/hol:holdingsInfo/hol:copies/hol:copy[not(hol:volumeId)])" nsmap="${nsm}" />
              </c:when>
              <c:otherwise>
                <jxp:set var="copiesCount" cnode="${ptr}" select="count(mod:extension/hol:holdingsInfo/hol:copies/hol:copy[hol:volumeId='${vol.value}'])" nsmap="${nsm}" />
              </c:otherwise>
            </c:choose>

            <tr>
              <c:if test="${not config['ew.hide_object_db']}">
                <td>${ptr['ancestor::qr:databaseResult/@name']}</td>
              </c:if>
              <td>
                <a href="indexw.jsp?record_id=${ptr["mod:recordInfo/mod:recordIdentifier"]}&amp;object_db=${ptr['ancestor::qr:databaseResult/@name']}&amp;volume_id=${vol.value}">${ptr["mod:recordInfo/mod:recordIdentifier"]}</a>
              </td>
              <td>
                <a href="indexw.jsp?record_id=${ptr["mod:recordInfo/mod:recordIdentifier"]}&amp;object_db=${ptr['ancestor::qr:databaseResult/@name']}&amp;volume_id=${vol.value}">${vol.value}</a>
              </td>                  

              <td>
                <c:choose>
                  <%-- If  (copiesCount < 8) or (SHOW ALL COPIES was requested) --%>
                  <c:when test="${(not empty param.show_all_copies or copiesCount lt 2)}">
                    <c:choose>
                      <c:when test="${vol.value eq ''}">
                        <c:set var="forEachVol">mod:extension/hol:holdingsInfo/hol:copies/hol:copy[not(hol:volumeId)]</c:set>
                      </c:when>
                      <c:otherwise>
                        <c:set var="forEachVol">mod:extension/hol:holdingsInfo/hol:copies/hol:copy[hol:volumeId='${vol.value}']</c:set>
                      </c:otherwise>
                    </c:choose>

                    <jxp:forEach  cnode="${ptr}" var="ptr2" select="${forEachVol}" nsmap="${nsm}">
                      <c:if test="${not empty ptr2['hol:copyLocation']}">${ptr2["hol:copyLocation"]}:&nbsp;</c:if>
                      ${ptr2["hol:subLocation"]}&nbsp;<c:if test="${not empty ptr2['hol:volumeId']}">&nbsp;${ptr2["hol:volumeId"]}</c:if>
                        ${ptr2["hol:copyId"]}
                      <br/>
                    </jxp:forEach>                    
                  </c:when>

                  <%-- COLLAPSE ALL COPIES FOR THE VOLUME --%>
                  <c:otherwise>
                    <a href="object_query_result.jsp?show_all_copies=1&amp;object_recordid=${ptr['mod:recordInfo/mod:recordIdentifier']}&amp;database=${ptr['ancestor::qr:databaseResult/@name']}&amp;volume_id=${vol.value}">
                      (<fmt:formatNumber value="${copiesCount}" type="number"/>)
                    </a>
                  </c:otherwise>
                </c:choose>
              </td>

              <td>
                <%-- There may be more than one title line --%>
                <jxp:forEach cnode="${ptr}" select="mod:titleInfo/mod:title" nsmap="${nsm}" var="title">
                  ${title}<br />
                </jxp:forEach>
              </td>
              <td>
                <jxp:forEach cnode="${ptr}" select="mod:name[mod:role/mod:roleTerm='author']" nsmap="${nsm}" var="author" >
                  ${author["mod:namePart"]}<!-- (${author["@type"]}) --><br/>
                </jxp:forEach>
              </td>
              
              
              <td align="center">              
               <c:forEach items="${catMap}" var="cat">
                 <font color=red><c:out value="${cat.value}" /></font>&nbsp;/
               </c:forEach>              
              </td>
              
              
              
              <td>${ptr["mod:originInfo/mod:dateIssued"]}</td>
            </tr>

          </c:forEach> <%-- end volume --%>
          <c:remove var="volsMap"/>
        </jxp:forEach>  <%-- end record --%>

        <%-- LAST ROW: COUNT --%>
        <tr><td><strong><fmt:message key="number_of_results"/>: <fmt:formatNumber value="${results_count}" type="number"/></strong></td></tr>
      </table>

    </div>

  </c:otherwise>

</c:choose>
