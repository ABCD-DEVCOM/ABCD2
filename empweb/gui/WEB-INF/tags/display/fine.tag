<?xml version="1.0"?><!--
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%--
/* fine.tag: Displays the information of a Fine defined in
 *           the fine schema http://kalio.net/empweb/schema/fine/v1
 *
 * attribute: doc (required)
 *    User information received as a a dom or as a context node
 *    constructed  by the commons/jxp tags set or forEach.
 *
 * attribute: with_links (optional) (default true)
 *    * output information with links to user and object info
 */
--%>
<%@ tag import="java.util.*" %>
<%@ tag import="org.apache.commons.jxpath.*" %>
<%@ tag import="org.w3c.dom.*" %>

<%@ tag body-content="empty" %>
<%@ attribute name="doc" required="true" type="java.lang.Object" %>
<%@ attribute name="with_links" required="false" %>

<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
-->
<fmt:setBundle basename="ewi18n.local.display" scope="page"/>

<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="f" value="http://kalio.net/empweb/schema/fine/v1" />

<c:set var="rootName"><jxp:out  cnode="${doc}" select="local-name()" nsmap="${nsm}" /></c:set>
<c:set var="select">
  <c:choose>
    <c:when test="${rootName eq 'fine'}">.</c:when>
    <c:otherwise>//f:fine</c:otherwise>
  </c:choose>
</c:set>


<jxp:forEach cnode="${doc}" nsmap="${nsm}" var="ptr" select="${select}">

  <c:choose>
    <c:when test="${(ptr['f:amount'] ne '0') and empty ptr['f:ref/@id']}">
      <c:set var="fine_type" value="fine_issued" />
    </c:when>
    <c:when test="${(ptr['f:amount'] eq '0') and (ptr['f:paid/f:amount'] eq '0')}">
      <c:set var="fine_type" value="fine_cancellation" />
    </c:when>
    <c:when test="${(ptr['f:amount'] eq '0') and (ptr['f:paid/f:amount'] ne '0')}">
      <c:set var="fine_type" value="fine_payment" />
    </c:when>
    <c:when test="${(ptr['f:amount'] ne '0') and empty ptr['f:paid/f:amount']}">
      <c:set var="fine_type" value="fine_pending" />
    </c:when>
    <c:otherwise>
      <c:set var="fine_type" value="fine_info" />
    </c:otherwise>
  </c:choose>


  <%-- // ONE SECTION FOR EACH FINE TYPE --%>

  <%-- // TYPE: FINE ISSUED  (NEW FINE) --%>
  <c:if test="${fine_type eq 'fine_issued'}">
    <h4><fmt:message key="${fine_type}"/></h4>
    <table id="result">
      <tr>
        <td><fmt:message key="transaction_id"/>:</td>
        <td>
          <c:choose>
            <c:when test="${with_links eq 'false'}">
              ${ptr['@id']}
            </c:when>
            <c:otherwise>
              <a href="${sessionScope.absoluteContext}/trans/query/view_transaction_details.jsp?transaction_id=${ptr['@id']}">
                ${ptr['@id']}
              </a>
            </c:otherwise>
          </c:choose>
        </td>
      </tr>
      <tr>
        <td><fmt:message key="user_id"/>: </td>
        <td>
          <c:choose>
            <c:when test="${with_links eq 'false'}">
              ${ptr['f:userId']}  <c:if test="${not config['ew.hide_user_db']}">(${ptr['f:userDb']})</c:if>
            </c:when>
            <c:otherwise>
              <a href="${sessionScope.absoluteContext}/trans/query/user_status_result.jsp?user_id=${ptr['f:userId']}&amp;user_db=${ptr['f:userDb']}">
                ${ptr['f:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['f:userDb']})</c:if>
              </a>
            </c:otherwise>
          </c:choose>
        </td>
      </tr>
      <tr>
        <td><fmt:message key="date"/>: </td>
        <td><util:formatDate type="both">${ptr['f:date']}</util:formatDate></td>
      </tr>
      <tr>
        <td><fmt:message key="fine_type"/>: </td>
        <td>${ptr['f:type']}</td>
      </tr>
      <tr>
        <td><fmt:message key="fine_amount"/>: </td>
        <td><dsp:formatAmount>${ptr['f:amount']}</dsp:formatAmount></td>
      </tr>
      <tr>
        <td><fmt:message key="obs"/>: </td>
        <td>${ptr['f:obs']}</td>
      </tr>
      <tr>
        <td><fmt:message key="location"/>: </td>
        <td>${ptr['f:location']}</td>
      </tr>
      <tr>
        <td><fmt:message key="operator_id"/>: </td>
        <td>${ptr['f:operator/@id']}</td>
      </tr>
      <c:if test="${not empty ptr['f:ref/@id']}">
        <tr>
          <td><fmt:message key="reference_id"/>: </td>
          <td>
            <c:choose>
              <c:when test="${with_links eq 'false'}">
                ${ptr['f:ref/@id']}
              </c:when>
              <c:otherwise>
                <a href="${sessionScope.absoluteContext}/trans/query/view_transaction_details.jsp?transaction_id=${ptr['f:ref/@id']}">
                  ${ptr['f:ref/@id']}
                </a>
              </c:otherwise>
            </c:choose>
          </td>
        </tr>
      </c:if>

      <%-- // associated object info --%>
      <c:if test="${not empty ptr['f:object/f:copyId'] and (fine_type ne 'fine_payment') }">
        <tr>
          <td><fmt:message key="copy_id"/>: </td>
          <td>
            <c:choose>
              <c:when test="${with_links eq 'false'}">
                ${ptr['f:object/f:copyId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['f:object/f:objectDb']}">(${ptr['f:object/f:objectDb']})</c:if>
              </c:when>
              <c:otherwise>
                <a href="${sessionScope.absoluteContext}/trans/query/copy_status_result.jsp?copy_id=${ptr['f:object/f:copyId']}&amp;object_db=${ptr['f:object/f:objectDb']}">
                  ${ptr['f:object/f:copyId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['f:object/f:objectDb']}">(${ptr['f:object/f:objectDb']})</c:if>
                </a>
              </c:otherwise>
            </c:choose>
          </td>
        </tr>
        <tr>
          <td><fmt:message key="record_id"/>: </td>
          <td>
            <c:choose>
              <c:when test="${with_links eq 'false'}">
                ${ptr['f:object/f:recordId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['f:object/f:objectDb']}">(${ptr['f:object/f:objectDb']})</c:if>
              </c:when>
              <c:otherwise>
                <a href="${sessionScope.absoluteContext}/trans/query/record_status_result.jsp?record_id=${ptr['f:object/f:recordId']}&amp;object_db=${ptr['f:object/f:objectDb']}">
                  ${ptr['f:object/f:recordId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['f:object/f:objectDb']}">(${ptr['f:object/f:objectDb']})</c:if>
                </a>
              </c:otherwise>
            </c:choose>
          </td>
        </tr>
        <tr>
          <td><fmt:message key="profile"/>: </td>
          <td>
            <c:choose>
              <c:when test="${with_links eq 'false'}">
                ${ptr['f:object/f:profile/@id']}
              </c:when>
              <c:otherwise>
                <a href="${sessionScope.absoluteContext}/trans/query/view_profile.jsp?profile_id=${ptr['f:object/f:profile/@id']}">${ptr['f:object/f:profile/@id']}</a>
              </c:otherwise>
            </c:choose>
          </td>
        </tr>
        <tr>
          <td><fmt:message key="loan_date"/>: </td>
          <td>
            <util:formatDate type="both">${ptr['f:object/f:loanStartDate']}</util:formatDate>
          </td>
        </tr>
        <tr>
          <td><fmt:message key="return_date"/>: </td>
          <td>
            <util:formatDate type="both">${ptr['f:object/f:loanEndDate']}</util:formatDate>
          </td>
        </tr>
        <tr>
          <td><fmt:message key="days_overdue"/>: </td>
          <td>${ptr['f:object/f:daysOverdue']}</td>
        </tr>
      </c:if>

    </table>
  </c:if>
  <%-- // END TYPE: FINE ISSUED  (NEW FINE) --%>

  <%-- // TYPE: FINE CANCELLATION --%>
  <c:if test="${fine_type eq 'fine_cancellation'}">
    <h4><fmt:message key="${fine_type}"/></h4>
    <table id="result">
      <tr>
        <td><fmt:message key="transaction_id"/>:</td>
        <td>
          <c:choose>
            <c:when test="${with_links eq 'false'}">
              ${ptr['@id']}
            </c:when>
            <c:otherwise>
              <a href="${sessionScope.absoluteContext}/trans/query/view_transaction_details.jsp?transaction_id=${ptr['@id']}">
                ${ptr['@id']}
              </a>
            </c:otherwise>
          </c:choose>
        </td>
      </tr>
      <tr>
        <td><fmt:message key="user_id"/>: </td>
        <td>
          <c:choose>
            <c:when test="${with_links eq 'false'}">
              ${ptr['f:userId']}  <c:if test="${not config['ew.hide_user_db']}">(${ptr['f:userDb']})</c:if>
            </c:when>
            <c:otherwise>
              <a href="${sessionScope.absoluteContext}/trans/query/user_status_result.jsp?user_id=${ptr['f:userId']}&amp;user_db=${ptr['f:userDb']}">
                ${ptr['f:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['f:userDb']})</c:if>
              </a>
            </c:otherwise>
          </c:choose>
        </td>
      </tr>
      <tr>
        <td><fmt:message key="date"/>: </td>
        <td><util:formatDate type="both">${ptr['f:date']}</util:formatDate></td>
      </tr>
      <tr>
        <td><fmt:message key="obs"/>: </td>
        <td>${ptr['f:obs']}</td>
      </tr>
      <tr>
        <td><fmt:message key="location"/>: </td>
        <td>${ptr['f:location']}</td>
      </tr>
      <tr>
        <td><fmt:message key="operator_id"/>: </td>
        <td>${ptr['f:operator/@id']}</td>
      </tr>
      <c:if test="${not empty ptr['f:ref/@id']}">
        <tr>
          <td><fmt:message key="reference_id"/>: </td>
          <td>
            <c:choose>
              <c:when test="${with_links eq 'false'}">
                ${ptr['f:ref/@id']}
              </c:when>
              <c:otherwise>
                <a href="${sessionScope.absoluteContext}/trans/query/view_transaction_details.jsp?transaction_id=${ptr['f:ref/@id']}">
                  ${ptr['f:ref/@id']}
                </a>
              </c:otherwise>
            </c:choose>
          </td>
        </tr>
      </c:if>
    </table>
  </c:if>
  <%-- // END TYPE: FINE CANCELLATION --%>


  <%-- // TYPE: FINE PAYMENT --%>
  <c:if test="${fine_type eq 'fine_payment'}">
    <h4><fmt:message key="${fine_type}"/></h4>
    <table id="result">
      <%-- // payment info, at the top --%>
      <tr>
        <td><fmt:message key="paid_amount"/>: </td>
        <td><dsp:formatAmount>${ptr['f:paid/f:amount']}</dsp:formatAmount></td>
      </tr>
      <tr>
        <td><fmt:message key="paid_date"/>: </td>
        <td><util:formatDate type="both">${ptr['f:paid/f:date']}</util:formatDate></td>
      </tr>
      <tr>
        <td><fmt:message key="transaction_id"/>:</td>
        <td>
          <c:choose>
            <c:when test="${with_links eq 'false'}">
              ${ptr['@id']}
            </c:when>
            <c:otherwise>
              <a href="${sessionScope.absoluteContext}/trans/query/view_transaction_details.jsp?transaction_id=${ptr['@id']}">
                ${ptr['@id']}
              </a>
            </c:otherwise>
          </c:choose>
        </td>
      </tr>
      <tr>
        <td><fmt:message key="user_id"/>: </td>
        <td>
          <c:choose>
            <c:when test="${with_links eq 'false'}">
              ${ptr['f:userId']}  <c:if test="${not config['ew.hide_user_db']}">(${ptr['f:userDb']})</c:if>
            </c:when>
            <c:otherwise>
              <a href="${sessionScope.absoluteContext}/trans/query/user_status_result.jsp?user_id=${ptr['f:userId']}&amp;user_db=${ptr['f:userDb']}">
                ${ptr['f:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['f:userDb']})</c:if>
              </a>
            </c:otherwise>
          </c:choose>
        </td>
      </tr>
      <tr>
        <td><fmt:message key="obs"/>: </td>
        <td>${ptr['f:obs']}</td>
      </tr>
      <tr>
        <td><fmt:message key="location"/>: </td>
        <td>${ptr['f:location']}</td>
      </tr>
      <tr>
        <td><fmt:message key="operator_id"/>: </td>
        <td>${ptr['f:operator/@id']}</td>
      </tr>
      <c:if test="${not empty ptr['f:ref/@id']}">
        <tr>
          <td><fmt:message key="reference_id"/>: </td>
          <td>
            <c:choose>
              <c:when test="${with_links eq 'false'}">
                ${ptr['f:ref/@id']}
              </c:when>
              <c:otherwise>
                <a href="${sessionScope.absoluteContext}/trans/query/view_transaction_details.jsp?transaction_id=${ptr['f:ref/@id']}">
                  ${ptr['f:ref/@id']}
                </a>
              </c:otherwise>
            </c:choose>
          </td>
        </tr>
      </c:if>
    </table>
  </c:if>
  <%-- // END: FINE PAYMENT --%>


  <%-- // TYPE: FINE PENDING --%>
  <c:if test="${fine_type eq 'fine_pending'}">
    <h4><fmt:message key="${fine_type}"/></h4>
    <table id="result">
      <%-- amount at the beginning --%>
      <tr>
        <td><fmt:message key="fine_amount"/>: </td>
        <td><dsp:formatAmount>${ptr['f:amount']}</dsp:formatAmount></td>
      </tr>
      <tr>
        <td><fmt:message key="transaction_id"/>:</td>
        <td>
          <c:choose>
            <c:when test="${with_links eq 'false'}">
              ${ptr['@id']}
            </c:when>
            <c:otherwise>
              <a href="${sessionScope.absoluteContext}/trans/query/view_transaction_details.jsp?transaction_id=${ptr['@id']}">
                ${ptr['@id']}
              </a>
            </c:otherwise>
          </c:choose>
        </td>
      </tr>
      <tr>
        <td><fmt:message key="user_id"/>: </td>
        <td>
          <c:choose>
            <c:when test="${with_links eq 'false'}">
              ${ptr['f:userId']}  <c:if test="${not config['ew.hide_user_db']}">(${ptr['f:userDb']})</c:if>
            </c:when>
            <c:otherwise>
              <a href="${sessionScope.absoluteContext}/trans/query/user_status_result.jsp?user_id=${ptr['f:userId']}&amp;user_db=${ptr['f:userDb']}">
                ${ptr['f:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['f:userDb']})</c:if>
              </a>
            </c:otherwise>
          </c:choose>
        </td>
      </tr>
      <tr>
        <td><fmt:message key="date"/>: </td>
        <td><util:formatDate type="both">${ptr['f:date']}</util:formatDate></td>
      </tr>
      <tr>
        <td><fmt:message key="obs"/>: </td>
        <td>${ptr['f:obs']}</td>
      </tr>
      <tr>
        <td><fmt:message key="location"/>: </td>
        <td>${ptr['f:location']}</td>
      </tr>
    </table>
  </c:if>
  <%-- // END TYPE: FINE PENDING --%>

  <%-- // TYPE: FINE INFO (ALL INFO) --%>
  <c:if test="${fine_type eq 'fine_info'}">
    <h4><fmt:message key="${fine_type}"/></h4>
    <table id="result">
      <tr>
        <td><fmt:message key="transaction_id"/>:</td>
        <td>
          <c:choose>
            <c:when test="${with_links eq 'false'}">
              ${ptr['@id']}
            </c:when>
            <c:otherwise>
              <a href="${sessionScope.absoluteContext}/trans/query/view_transaction_details.jsp?transaction_id=${ptr['@id']}">
                ${ptr['@id']}
              </a>
            </c:otherwise>
          </c:choose>
        </td>
      </tr>
      <tr>
        <td><fmt:message key="user_id"/>: </td>
        <td>
          <c:choose>
            <c:when test="${with_links eq 'false'}">
              ${ptr['f:userId']}  <c:if test="${not config['ew.hide_user_db']}">(${ptr['f:userDb']})</c:if>
            </c:when>
            <c:otherwise>
              <a href="${sessionScope.absoluteContext}/trans/query/user_status_result.jsp?user_id=${ptr['f:userId']}&amp;user_db=${ptr['f:userDb']}">
                ${ptr['f:userId']} <c:if test="${not config['ew.hide_user_db']}">(${ptr['f:userDb']})</c:if>
              </a>
            </c:otherwise>
          </c:choose>
        </td>
      </tr>
      <tr>
        <td><fmt:message key="date"/>: </td>
        <td><util:formatDate type="both">${ptr['f:date']}</util:formatDate></td>
      </tr>
      <tr>
        <td><fmt:message key="fine_type"/>: </td>
        <td>${ptr['f:type']}</td>
      </tr>
      <tr>
        <td><fmt:message key="fine_amount"/>: </td>
        <td><dsp:formatAmount>${ptr['f:amount']}</dsp:formatAmount></td>
      </tr>
      <tr>
        <td><fmt:message key="obs"/>: </td>
        <td>${ptr['f:obs']}</td>
      </tr>
      <tr>
        <td><fmt:message key="location"/>: </td>
        <td>${ptr['f:location']}</td>
      </tr>
      <tr>
        <td><fmt:message key="operator_id"/>: </td>
        <td>${ptr['f:operator/@id']}</td>
      </tr>
      <c:if test="${not empty ptr['f:ref/@id']}">
        <tr>
          <td><fmt:message key="reference_id"/>: </td>
          <td>
            <c:choose>
              <c:when test="${with_links eq 'false'}">
                ${ptr['f:ref/@id']}
              </c:when>
              <c:otherwise>
                <a href="${sessionScope.absoluteContext}/trans/query/view_transaction_details.jsp?transaction_id=${ptr['f:ref/@id']}">
                  ${ptr['f:ref/@id']}
                </a>
              </c:otherwise>
            </c:choose>
          </td>
        </tr>
      </c:if>
      <%-- // Payment section --%>
      <c:if test="${not empty ptr['f:paid/f:date']}">
        <tr>
          <td><fmt:message key="paid_date"/>: </td>
          <td><util:formatDate type="both">${ptr['f:paid/f:date']}</util:formatDate></td>
        </tr>
        <tr>
          <td><fmt:message key="paid_amount"/>: </td>
          <td><dsp:formatAmount>${ptr['f:paid/f:amount']}</dsp:formatAmount></td>
        </tr>
      </c:if>
      <%-- // Object Section --%>
      <c:if test="${not empty ptr['f:object/f:copyId'] }">
        <tr>
          <td><fmt:message key="copy_id"/>: </td>
          <td>
            <c:choose>
              <c:when test="${with_links eq 'false'}">
                ${ptr['f:object/f:copyId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['f:object/f:objectDb']}">(${ptr['f:object/f:objectDb']})</c:if>
              </c:when>
              <c:otherwise>
                <a href="${sessionScope.absoluteContext}/trans/query/copy_status_result.jsp?copy_id=${ptr['f:object/f:copyId']}&amp;object_db=${ptr['f:object/f:objectDb']}">
                  ${ptr['f:object/f:copyId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['f:object/f:objectDb']}">(${ptr['f:object/f:objectDb']})</c:if>
                </a>
              </c:otherwise>
            </c:choose>
          </td>
        </tr>
        <tr>
          <td><fmt:message key="record_id"/>: </td>
          <td>
            <c:choose>
              <c:when test="${with_links eq 'false'}">
                ${ptr['f:object/f:recordId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['f:object/f:objectDb']}">(${ptr['f:object/f:objectDb']})</c:if>
              </c:when>
              <c:otherwise>
                <a href="${sessionScope.absoluteContext}/trans/query/record_status_result.jsp?record_id=${ptr['f:object/f:recordId']}&amp;object_db=${ptr['f:object/f:objectDb']}">
                  ${ptr['f:object/f:recordId']} <c:if test="${not config['ew.hide_object_db'] and not empty ptr['f:object/f:objectDb']}">(${ptr['f:object/f:objectDb']})</c:if>
                </a>
              </c:otherwise>
            </c:choose>
          </td>
        </tr>
        <tr>
          <td><fmt:message key="profile"/>: </td>
          <td>
            <c:choose>
              <c:when test="${with_links eq 'false'}">
                ${ptr['f:object/f:profile/@id']}
              </c:when>
              <c:otherwise>
                <a href="${sessionScope.absoluteContext}/trans/query/view_profile.jsp?profile_id=${ptr['f:object/f:profile/@id']}">${ptr['f:object/f:profile/@id']}</a>
              </c:otherwise>
            </c:choose>
          </td>
        </tr>
        <tr>
          <td><fmt:message key="loan_date"/>: </td>
          <td>
            <util:formatDate type="both">${ptr['f:object/f:loanStartDate']}</util:formatDate>
          </td>
        </tr>
        <tr>
          <td><fmt:message key="return_date"/>: </td>
          <td>
            <util:formatDate type="both">${ptr['f:object/f:loanEndDate']}</util:formatDate>
          </td>
        </tr>
        <tr>
          <td><fmt:message key="days_overdue"/>: </td>
          <td>${ptr['f:object/f:daysOverdue']}</td>
        </tr>
      </c:if> <%-- end if: object section --%>
      </table>
    </c:if>
    <%-- // END TYPE: FINE INFO --%>

</jxp:forEach>

