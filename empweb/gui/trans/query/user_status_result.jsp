<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
-->

<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="uinfo" value="http://kalio.net/empweb/schema/users/v1" />
<c:set target="${nsm}" property="ustat" value="http://kalio.net/empweb/schema/userstatus/v1" />
<c:set target="${nsm}" property="s"     value="http://kalio.net/empweb/schema/suspension/v1" />
<c:set target="${nsm}" property="f"     value="http://kalio.net/empweb/schema/fine/v1" />
<c:set target="${nsm}" property="w"     value="http://kalio.net/empweb/schema/wait/v1" />
<c:set target="${nsm}" property="r"     value="http://kalio.net/empweb/schema/reservation/v1" />
<c:set target="${nsm}" property="l"     value="http://kalio.net/empweb/schema/loan/v1" />
<c:set target="${nsm}" property="h"     value="http://kalio.net/empweb/schema/holdingsinfo/v1" />
<c:set target="${nsm}" property="mods"  value="http://www.loc.gov/mods/v3" />
<c:set target="${nsm}" property="tr"    value="http://kalio.net/empweb/schema/transactionresult/v1" />


<jsp:useBean id="user_id" class="java.lang.String" />

<c:set var="user_id" value="${fn:trim(param.user_id)}"/>
<c:set var="user_db" value="${fn:trim(param.user_db)}"/>

<jsp:useBean id="now" class="java.util.Date"/>
<c:set var="nowts"><util:formatDate type="timestamplong" date="${now}"/></c:set>



<%-- REQUEST USER INFO AND STATUS --%>
<c:choose>
  <c:when test="${not empty user_id}">
    <x:parse varDom="userInfoResult">
      <trans:searchUsersById database="${user_db}">
        ${user_id}
      </trans:searchUsersById>
    </x:parse>

    <x:parse varDom="userStatusResult">
      <trans:getUserStatus id="${user_id}" database="${user_db}"/>
    </x:parse>

    <jxp:set cnode="${userInfoResult}"  var="userCount" select="count(//uinfo:userCollection/uinfo:user)" nsmap="${nsm}" />
    <c:if test="${userCount != 1}">
      <c:redirect url="user_query_result.jsp?user_id=${user_id}&user_db=${user_db}"/>
    </c:if>

  </c:when>

  <c:otherwise>
    <c:redirect url="index.jsp"/>
  </c:otherwise>
</c:choose>




<div class="middle homepage">
  <!-- USER INFO -->
  <h2><fmt:message key="user_info"/></h2>

  <div>
    <jxp:set cnode="${userInfoResult}"  var="userInfo" select="//uinfo:userCollection" nsmap="${nsm}" />
    <c:choose>
      <%-- This user does not exist in the database --%>
      <c:when test="${userInfo['uinfo:user'] == null}">
        <p><fmt:message key="no_results_found"/></p>
      </c:when>

      <%-- We found a matching user: display it --%>
      <c:otherwise>
        <dsp:user doc="${userInfoResult}" select="//uinfo:userCollection" nsmap="${nsm}"/>
      </c:otherwise>
    </c:choose>
  </div>


  <div style="float:left; ">
    <!-- USER STATUS -->
    <!-- <h2><fmt:message key="user_status"/></h2> -->
    <jxp:set cnode="${userStatusResult}"  var="userStatus"   select="//ustat:userStatus" nsmap="${nsm}" />

    <!-- user status summary -->
    <table id="result">
      <tr><td><strong><fmt:message key="user_status"/></strong></td></tr>
      <!-- administrative suspensions -->
      <c:if test="${(userInfo['uinfo:user/uinfo:extension/s:suspensions/s:suspension'] != null)}">
        <tr>
          <td>
            <a href="#suspensions" onClick="document.getElementById('detailed_info').style.display='block'">
              <fmt:message key="administrative_suspensions"/>
            </a>
          </td>
          <td>
            <fmt:formatNumber>
              <jxp:out cnode="${userInfoResult}" select="count(//uinfo:user/uinfo:extension/s:suspensions/s:suspension)" nsmap="${nsm}"/>
            </fmt:formatNumber>
          </td>
        </tr>
      </c:if>
      <!-- suspensions -->
      <c:if  test="${(userStatus['s:suspensions/s:suspension'] != null)}">
        <c:set var="suspCant" value="0"/>
        <jxp:forEach  cnode="${userStatus}" var="ptr" select="s:suspensions/s:suspension" nsmap="${nsm}">
          <util:isExpired var="suspExp" offset="${ptr['s:daysSuspended']}">${ptr['s:date']}</util:isExpired>
          <c:if test="${suspExp eq 'false'}"><c:set var="suspCant">${suspCant+1}</c:set></c:if>
        </jxp:forEach>

        <c:if test="${suspCant gt 0}">
        <tr>
          <td>
            <a href="#suspensions" onClick="document.getElementById('detailed_info').style.display='block'">
              <fmt:message key="active_suspensions"/>
            </a>
          </td>
          <td>
            <fmt:formatNumber>${suspCant}</fmt:formatNumber>
          </td>
        </tr>
        </c:if>
      </c:if>

      <!-- fines -->
      <c:if test="${userStatus['f:fines/f:fine'] != null}">
        <tr>
          <td>
            <a href="#fines" onClick="document.getElementById('detailed_info').style.display='block'">
              <fmt:message key="pending_fines" />
            </a>
          </td>
          <td>
           <fmt:formatNumber>
              <jxp:out cnode="${userStatusResult}" select="count(//f:fines/f:fine)" nsmap="${nsm}"/>
           </fmt:formatNumber>
          </td>
        </tr>
      </c:if>
      <!-- administrative fines -->
      <c:if test="${userInfo['uinfo:user/uinfo:extension/f:fines/f:fine'] != null}">
        <tr>
          <td>
            <a href="#fines" onClick="document.getElementById('detailed_info').style.display='block'">
              <fmt:message key="administrative_fines" />
            </a>
          </td>
          <td>
            <fmt:formatNumber>
              <jxp:out cnode="${userInfoResult}" select="count(//uinfo:user/uinfo:extension/f:fines/f:fine)" nsmap="${nsm}"/>
            </fmt:formatNumber>
          </td>
        </tr>
      </c:if>
      <!-- waits -->
      <c:if test="${userStatus['w:waits/w:wait'] != null}">
        <tr>
          <td>
            <a href="#waits" onClick="document.getElementById('detailed_info').style.display='block'">
              <fmt:message key="wait_list" />
            </a>
          </td>
          <td>
            <fmt:formatNumber>
              <jxp:out cnode="${userStatusResult}" select="count(//w:waits/w:wait)" nsmap="${nsm}"/>
            </fmt:formatNumber>
          </td>
          <td/>
        </tr>
      </c:if>
      <!-- reservations -->
      <c:if test="${userStatus['r:reservations/r:reservation'] != null}">
        <tr>
          <td>
            <a href="#reservations" onClick="document.getElementById('detailed_info').style.display='block'">
              <fmt:message key="reservations" />
            </a>
          </td>
          <td>
            <fmt:formatNumber>
              <jxp:out cnode="${userStatusResult}" select="count(//r:reservation)" nsmap="${nsm}"/>
            </fmt:formatNumber>
          </td>
        </tr>
      </c:if>
      <!-- loans -->
      <c:if test="${userStatus['l:loans/l:loan'] != null}">
        <tr>
          <td>
            <a href="#loans" onClick="document.getElementById('detailed_info').style.display='block'">
              <fmt:message key="current_loans" />
            </a>
          </td>
          <td>
            <fmt:formatNumber>
              <jxp:out cnode="${userStatusResult}" select="count(//l:loans/l:loan)" nsmap="${nsm}"/>
            </fmt:formatNumber>
          </td>
        </tr>
      </c:if>
    </table>
  </div>


  <%-- HISTORIC USER INFORMATION --%>
  <div style="float:left; margin-left:30px;">
    <x:parse varDom="historicCounts">
      <trans:doTransaction name="stat-hist-user">
        <transactionExtras>
          <params>
            <param name="userId">${user_id}</param>
            <param name="userDb">${user_db}</param>
            <param name="onlyCounts">true</param>
          </params>
        </transactionExtras>
      </trans:doTransaction>
    </x:parse>

    <c:set var="historic_href" value="../../stats/historic/include_report.jsp?report_type=hist&amp;user_id=${user_id}&amp;user_db=${user_db}&amp;library=all_libraries"/>
    <table>
      <tr>
        <td><strong><fmt:message key="user_historic_transactions"/></strong></td>
      </tr>
      <tr>
        <td><a href="${historic_href}&amp;report_name=loansByUser"><fmt:message key="historic_loans_by_user"/></a></td>
        <td><jxp:out cnode="${historicCounts}" select="//tr:value[@name='loanCount']" nsmap="${nsm}"/></td>
      </tr>
<%-- BBBBBB TERMINAR ESTOOO: historial de reservas del usuario
      <tr>
        <td><a href="${historic_href}&amp;report_name=reservationsByUser"><fmt:message key="historic_reservations_by_user"/></td>
        <td><jxp:out cnode="${historicCounts}" select="//tr:value[@name='reservationCount']" nsmap="${nsm}"/></td>
      </tr>
--%>
      <tr>
        <td><a href="${historic_href}&amp;report_name=finesByUser"><fmt:message key="historic_fines_by_user"/></td>
        <td><jxp:out cnode="${historicCounts}" select="//tr:value[@name='finesCount']" nsmap="${nsm}"/></td>
      </tr>
      <tr>
        <td><a href="${historic_href}&amp;report_name=suspensionsByUser"><fmt:message key="historic_suspensions_by_user"/></a></td>
        <td><jxp:out cnode="${historicCounts}" select="//tr:value[@name='suspensionCount']" nsmap="${nsm}"/></td>
      </tr>
    </table>
  </div>



  <div style="clear:both">
    <!-- ACTIONS -->
    <h3><fmt:message key="actions"/>:</h3>
    <p>
      <a href="../loan/index.jsp?user_id=${user_id}&amp;user_db=${user_db}">
        <fmt:message key="new_loan"/>
      </a> |
      <a href="../fine/create/index.jsp?user_id=${user_id}&amp;user_db=${user_db}">
        <fmt:message key="create_fine"/>
      </a> |
      <a href="../suspension/create/index.jsp?user_id=${user_id}&amp;user_db=${user_db}">
        <fmt:message key="create_suspension"/>
      </a>
    </p>
  </div>

  <!-- DETAILED USER STATUS -->
  <div id="detailed_info" style="display:block;">

    <h2><fmt:message key="user_status_details"/></h2>

    <!-- suspensions -->
    <c:if  test="${(userStatus['s:suspensions/s:suspension'] != null) or (userInfo['uinfo:user/uinfo:extension/s:suspensions/s:suspension'] != null)}">
      <h3><a name="suspensions"/><fmt:message key="active_suspensions"/></h3>
      <table id="result" width="90%">
        <tr>
          <th><fmt:message key="type"/></th>
          <th><fmt:message key="suspension_id"/></th>
          <th><fmt:message key="suspension_creation_date"/></th>
          <th><fmt:message key="suspension_duration"/></th>
          <th><fmt:message key="suspended_from"/></th>
          <th><fmt:message key="suspended_until"/></th>
          <th><fmt:message key="obs"/></th>
          <th><fmt:message key="actions"/></th>
        </tr>
        <!-- administrative suspensions -->
        <jxp:forEach  cnode="${userInfo}" var="ptr" select="uinfo:user/uinfo:extension/s:suspensions/s:suspension" nsmap="${nsm}">
          <tr>
            <td>${ptr['@type']}</td>
            <td/>
            <td>
              <util:formatDate pattern="yyyyMMddHHmmss">${ptr['s:startDate']}</util:formatDate>
            </td>
            <td>${ptr['s:duration']}</td>
            <td><fmt:message key="administrative_suspension"/>: <br/>${ptr['s:obs']}</td>
            <td></td>
          </tr>
        </jxp:forEach>
        <!-- transactional suspensions -->
        <jxp:forEach  cnode="${userStatus}" var="ptr" select="s:suspensions/s:suspension" nsmap="${nsm}">
          <util:isExpired var="suspExp" offset="${ptr['s:daysSuspended']}">${ptr['s:date']}</util:isExpired>
          <c:if test="${ suspExp eq 'false'}">
          <tr>
              <td>${ptr['s:type']}</td>
              <td><a href="view_transaction_details.jsp?transaction_id=${ptr['@id']}">${ptr['@id']}</a></td>
              <td><util:formatDate pattern="yyyyMMddHHmmss">${ptr['s:date']}</util:formatDate></td>
              <td>${ptr['s:daysSuspended']}</td>
              <td><util:formatDate pattern="yyyyMMddHHmmss">${ptr['s:startDate']}</util:formatDate></td>
              <td><util:formatDate pattern="yyyyMMddHHmmss">${ptr['s:endDate']}</util:formatDate></td>
              <td>${ptr['s:obs']}</td>
              <td>
                <a href="../suspension/cancel/index.jsp?suspension_id=${ptr['@id']}&amp;user_id=${user_id}&amp;user_db=${user_db}" >
                  <fmt:message key="cancel"/>
                </a>
              </td>
            </tr>
          </c:if>
        </jxp:forEach>

      </table>
    </c:if>

    <!-- fines -->
    <c:if test="${(userStatus['f:fines/f:fine'] != null) or (userInfo['uinfo:user/uinfo:extension/f:fines/f:fine'] != null)}">
      <h3><a name="fines"/><fmt:message key="pending_fines"/></h3>
      <table id="result" width="90%">
        <tr>
          <th><fmt:message key="type"/></th>
          <th><fmt:message key="fine_id"/></th>
          <th><fmt:message key="date"/></th>
          <th><fmt:message key="pending_amount"/></th>
          <th><fmt:message key="obs"/></th>
          <th><fmt:message key="actions"/></th>
        </tr>

          <!-- administrative fines -->
          <jxp:forEach cnode="${userInfo}" var="ptr" select="uinfo:user/uinfo:extension/f:fines/f:fine" nsmap="${nsm}">
            <tr>
              <td>${ptr['f:type']}</td>
              <td>${ptr['@id']}</td>
              <td>
                <util:formatDate pattern="yyyyMMddHHmmss">${ptr['f:date']}</util:formatDate>
              </td>
              <%-- BBBB Habia un error con cierto usuario 13767110 que tenia una multa vieja que decia "8m" y el formatAmount fallaba
                   BBBB Habria que ver si es el unico caso o si la m tiene un sifnificado especial o que, por ahora lo comento aca --%>
              <td align="right">${ptr['f:amount']}<%--<dsp:formatAmount>${ptr['f:amount']}</dsp:formatAmount>--%></td>
              <td>${ptr['f:obs']}</td>
              <td></td>
            </tr>
          </jxp:forEach>

          <!-- transactional fines -->
          <jxp:forEach cnode="${userStatus}" var="ptr" select="f:fines/f:fine" nsmap="${nsm}">
            <tr>
              <td>${ptr['f:type']}</td>
              <td>
              <%-- always show the original id --%>
                <c:choose>
                  <c:when test="${not empty ptr['f:ref/@id']}"><a href="fine_status_result.jsp?fine_id=${ptr['f:ref/@id']}">${ptr['f:ref/@id']}</a></c:when>
                  <c:otherwise><a href="fine_status_result.jsp?fine_id=${ptr['@id']}">${ptr['@id']}</a></c:otherwise>
                </c:choose>
              </td>
              <td>
                <util:formatDate pattern="yyyyMMddHHmmss">${ptr['f:date']}</util:formatDate>
              </td>
              <td align="right"><dsp:formatAmount>${ptr['f:amount']}</dsp:formatAmount></td>
              <td>${ptr['f:obs']}</td>
              <td>
              <c:set var="fine_amount_total" value="${fn:trim(ptr['f:amount'])}"/>
                <a href="../fine/pay/index.jsp?fine_id=${ptr['@id']}&amp;user_id=${user_id}&amp;user_db=${user_db}&amp;fine_amount=${fine_amount_total - fine_amount_paid}">
                  <fmt:message key="pay"/>
                </a> |
                <a href="../fine/cancel/index.jsp?fine_id=${ptr['@id']}&amp;user_id=${user_id}&amp;user_db=${user_db}">
                  <fmt:message key="cancel"/>
                </a>
              </td>
            </tr>
          </jxp:forEach>
        </table>
      </c:if>


      <!-- waits -->
      <c:if test="${userStatus['w:waits/w:wait'] != null}">
        <h3><a name="waits"/><fmt:message key="wait_list"/></h3>
        <table id="result" width="90%">
          <tr>
            <th><fmt:message key="wait_id"/></th>
            <th><fmt:message key="date"/></th>
            <th><fmt:message key="confirmed_date"/></th>
            <th><fmt:message key="expiration_date"/></th>
            <th><fmt:message key="record_id"/></th>
            <th><fmt:message key="volume_id"/></th>
            <th><fmt:message key="record_title"/></th>
            <th><fmt:message key="actions"/></th>
          </tr>

          <jxp:forEach cnode="${userStatus}" var="ptr" select="w:waits/w:wait" nsmap="${nsm}">
            <tr>
              <td>
                <a href="view_transaction_details.jsp?transaction_id=${ptr['@id']}">${ptr['@id']}</a>
              </td>
              <td>
                <util:formatDate pattern="yyyyMMddHHmmss">${ptr['w:date']}</util:formatDate>
              </td>
              <td>
                <util:formatDate pattern="yyyyMMddHHmmss">${ptr['w:confirmedDate']}</util:formatDate>
              </td>
              <td>
                <util:formatDate pattern="yyyyMMddHHmmss">${ptr['w:expirationDate']}</util:formatDate>
              </td>
              
              <td>
                <a href="record_status_result.jsp?record_id=${ptr['w:recordId']}&amp;object_db=${ptr['w:objectDb']}">
                  ${ptr['w:recordId']}   <c:if test="${not config['ew.hide_object_db']}">(${ptr['w:objectDb']})</c:if>
                </a>
              </td>
              <td>
                  ${ptr['w:volumeId']}
              </td>
              <td>
                <x:parse varDom="thisRecord">
                  <trans:searchObjectsById database="${ptr['w:objectDb']}">
                    ${ptr['w:recordId']}
                  </trans:searchObjectsById>
                </x:parse>
                <jxp:set var="thisTitle" cnode="${thisRecord}"  select="//mods:title" nsmap="${nsm}" />
                ${fn:escapeXml(thisTitle)}
              </td>
              <td>
                <a href="../loan/index.jsp?user_id=${user_id}&amp;user_db=${user_db}&amp;record_id=${ptr['w:recordId']}&amp;object_db=${ptr['w:objectDb']}">
                  <fmt:message key="loan"/>
                </a>
                <a href="../wait/cancel/index.jsp?user_id=${user_id}&amp;user_db=${user_db}&amp;wait_id=${ptr['@id']}&amp;object_db=${ptr['w:objectDb']}">
                  <fmt:message key="cancel"/>
                </a>
              </td>
            </tr>
          </jxp:forEach>
        </table>
      </c:if> <!-- waits -->


      <!-- reservations -->
      <c:if test="${userStatus['r:reservations/r:reservation'] != null}">
        <h3><a name="reservations"/><fmt:message key="reservations"/></h3>
        <table id="result">
          <tr>
            <th><fmt:message key="reservation_id"/></th>
            <th><fmt:message key="record_title"/></th>
            <th><fmt:message key="record_id"/></th>
            <th><fmt:message key="volume_id"/></th>
            <th><fmt:message key="object_location"/></th>
            <th><fmt:message key="reservation_start_date"/></th>
            <th><fmt:message key="reservation_expiration_date"/></th>
            <th><fmt:message key="reservation_end_date"/></th>
            <th><fmt:message key="actions"/></th>
          </tr>

          <jxp:forEach cnode="${userStatus}" var="ptr" select="r:reservations/r:reservation" nsmap="${nsm}">
            <x:parse varDom="thisRecord">
              <trans:searchObjects  database="${ptr['r:objectDb']}">
                <query xmlns="http://kalio.net/empweb/schema/objectsquery/v1">
                  <recordId>${ptr['r:recordId']}</recordId>
                </query>
              </trans:searchObjects>
            </x:parse>

            <tr>
              <td>
                <a href="view_transaction_details.jsp?transaction_id=${ptr['@id']}">${ptr['@id']}</a>
              </td>
              <td>
                <jxp:set var="thisTitle" cnode="${thisRecord}"  select="//mods:title" nsmap="${nsm}" />
                ${fn:escapeXml(thisTitle)}
              </td>
              <td>
                <a href="record_status_result.jsp?record_id=${ptr['r:recordId']}&amp;object_db=${ptr['r:objectDb']}">
                  ${ptr['r:recordId']} <c:if test="${not config['ew.hide_object_db']}">(${ptr['r:objectDb']})</c:if>
                </a>
              </td>
              <td>
                ${ptr['r:volumeId']}
              </td>
              <td>
                ${ptr['r:objectLocation']}
              </td>
              <td>
                <util:formatDate pattern="yyyyMMddHHmmss">${ptr['r:startDate']}</util:formatDate>
              </td>
              <util:isLate var="late">${ptr['r:expirationDate']}</util:isLate>
              <td ${late eq 'true' ? 'class="warn"' : ''}>
                <util:formatDate pattern="yyyyMMddHHmmss">${ptr['r:expirationDate']}</util:formatDate>
              </td>
              <td>
                <util:formatDate pattern="yyyyMMddHHmmss">${ptr['r:endDate']}</util:formatDate>
              </td>
              <td>
                <a href="../reservation/cancel/index.jsp?reservation_id=${ptr['@id']}">
                  <fmt:message key="cancel"/>
                </a>
                <c:if test="${(ptr['r:startDate'] lt nowts) and (ptr['r:expirationDate'] gt nowts)}">
                   | <a href="../loan/index.jsp?user_id=${user_id}&amp;user_db=${user_db}">
                     <fmt:message key="loan"/>
                   </a>
                </c:if>
              </td>
            </tr>
          </jxp:forEach>
        </table>
      </c:if> <!-- reservations -->

      <!-- loans -->
      <c:if test="${userStatus['l:loans/l:loan'] != null}">
        <h3><a name="loans"/><fmt:message key="current_loans"/></h3>
        <table id="result" width="90%">
          <tr>
            <th><fmt:message key="loan_id"/></th>
            <th><fmt:message key="record_title"/></th>
            <th><fmt:message key="copy_id"/></th>
            <th><fmt:message key="record_id"/></th>
            <th><fmt:message key="loan_date"/></th>
            <th><fmt:message key="return_date"/></th>
            <th><fmt:message key="actions"/></th>
          </tr>

          <jxp:forEach cnode="${userStatus}" var="ptr" select="l:loans/l:loan" nsmap="${nsm}">
            <x:parse varDom="thisRecord">
              <trans:searchObjectsById  database="${ptr['l:objectDb']}">
                ${ptr['l:copyId']}
              </trans:searchObjectsById>
            </x:parse>
            <c:set var="thisCopyId">${ptr['l:copyId']}</c:set>
            <tr>
              <td>
                <a href="view_transaction_details.jsp?transaction_id=${ptr['@id']}">${ptr['@id']}</a>
              </td>
              <td>
                <jxp:set var="thisTitle" cnode="${thisRecord}"  select="//mods:title" nsmap="${nsm}" />
                ${fn:escapeXml(thisTitle)}
              </td>
              <td>
                <jxp:out cnode="${thisRecord}" nsmap="${nsm}"
                         select="//h:copy[h:copyId='${thisCopyId}']/h:copyLocation" />&nbsp;
                ${thisCopyId}&nbsp;
                <jxp:out cnode="${thisRecord}" nsmap="${nsm}"
                         select="//h:copy[h:copyId='${thisCopyId}']/h:volumeId" />
              </td>
              <td>
                <a href="record_status_result.jsp?record_id=${ptr['l:recordId']}&amp;object_db=${ptr['l:objectDb']}">
                  ${ptr['l:recordId']} <c:if test="${not config['ew.hide_object_db']}">(${ptr['l:objectDb']})</c:if>
                </a>
              </td>
              <td>
                <util:formatDate pattern="yyyyMMddHHmmss">${ptr['l:startDate']}</util:formatDate>
              </td>

              <util:isLate var="late">${ptr['l:endDate']}</util:isLate>
              <td ${late eq 'true' ? 'class="warn"' : ''}>
                <util:formatDate pattern="yyyyMMddHHmmss">${ptr['l:endDate']}</util:formatDate>
              </td>
              <td>
                <a href="../return/index.jsp?copy_ids=${thisCopyId}&amp;object_db=${ptr['l:objectDb']}&amp;user_id=${user_id}&amp;user_db=${user_db}">
                  <fmt:message key="return"/>
                </a>
                <%-- BBB Por ahora no esta, asi que mejor que no se vea
                <a href="../renewal/index.jsp?copy_ids=${thisCopyId}&amp;object_db=${ptr['l:objectDb']}&amp;user_id=${user_id}&amp;user_db=${user_db}">
                  <fmt:message key="renew"/>
                </a> |
                --%>
              </td>
            </tr>
          </jxp:forEach>
        </table>
      </c:if> <!-- loans -->
    </div> <!-- detailed_info -->
    <br />
    

</div>
