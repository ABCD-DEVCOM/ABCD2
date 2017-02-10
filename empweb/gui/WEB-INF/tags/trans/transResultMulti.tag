<%--
/*
 * Copyright 2004-2006 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 */
--%>
<%@ tag body-content="scriptless" %>
<%@ attribute name="results" required="true" type="java.util.Map" %>
<%@ taglib prefix="c"   uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x"   uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn"  uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>

<div>
  <fmt:setLocale value="${sessionScope.userLocale}"/>
  <fmt:setBundle basename="ewi18n.core.gui" var="guiBundle" scope="page"/>
  <jsp:useBean id="nsm" class="java.util.HashMap" />
  <c:set target="${nsm}" property="e"   value="http://kalio.net/empweb/schema/engineresult/v1" />
  <c:set target="${nsm}" property="t"   value="http://kalio.net/empweb/schema/transactionresult/v1" />
  <c:set target="${nsm}" property="l"   value="http://kalio.net/empweb/schema/loan/v1" />
  <c:set target="${nsm}" property="ret" value="http://kalio.net/empweb/schema/return/v1" />
  <c:set target="${nsm}" property="r"   value="http://kalio.net/empweb/schema/reservation/v1" />
  <c:set target="${nsm}" property="w"   value="http://kalio.net/empweb/schema/wait/v1" />
  <c:set target="${nsm}" property="f"   value="http://kalio.net/empweb/schema/fine/v1" />
  <c:set target="${nsm}" property="s"   value="http://kalio.net/empweb/schema/suspension/v1" />

  <%-- ==================== SUMMARY ====================== --%>
  <jsp:useBean id="resultsOk" class="java.util.HashMap" />
  <jsp:useBean id="resultsFailed" class="java.util.HashMap" />
  <c:forEach items="${results}" var="result">
    <x:parse varDom="doc">${result.value}</x:parse>
    <jxp:set cnode="${doc}" nsmap="${nsm}"  var="error" select="//e:error" />
    <jxp:set cnode="${doc}" nsmap="${nsm}"  var="hasProcError" select="//t:processResult[@successful='false']/@successful"  />
    <jxp:set cnode="${doc}" nsmap="${nsm}"  var="procError" select="//t:processResult[@successful='false']"  />
    <c:choose>
      <c:when test="${not empty error}">
        <c:set target="${resultsFailed}" property="${result.key}" value="${error}"/>
      </c:when>
      <c:when test="${not empty hasProcError}">
        <c:set target="${resultsFailed}" property="${result.key}" value="${procError}"/>
      </c:when>
      <c:otherwise>
        <c:set target="${resultsOk}" property="${result.key}" value="${result.key}"/>
      </c:otherwise>
    </c:choose>
  </c:forEach>


  <%-- list failed transactions, with error message --%>
  <c:if test="${not empty error or not empty hasProcError}">

    <c:choose>

      <%-- loans --%>
      <c:when test="${not empty param.copy_ids}">
        <form method="get" action="index.jsp">
          <input type="hidden" name="user_id" value="${param.user_id}"/>
          <input type="hidden" name="user_db" value="${param.user_db}"/>
          <input type="hidden" name="object_db" value="${param.object_db}"/>
          <input type="hidden" name="accept_end_date" value="0"/>

          <h3><fmt:message key="transaction_failed_for"/></h3>
          <table>
            <tr>
              <th/>
              <th><fmt:message key="id"/></th>
              <th><fmt:message key="transaction_problem"/></th>
            </tr>
            <c:forEach items="${resultsFailed}" var="result">
              <tr>
                <td>
                  <input type="checkbox" name="retry_copy_id" value="${result.key}"/>
                </td>
                <td>
                  <a href="#${result.key}">${result.key}</a>
                </td>
                <td>
                  <dsp:msg msg="${result.value['e:msg']}"/>
                </td>
              </tr>
            </c:forEach>
            <tr>
              <td/>
              <td colspan="2">
                <input type="submit" name="retry" value="<fmt:message key="retry_selected"/>" />
              </td>
            </tr>
          </table>
        </form>
      </c:when>

      <%-- reservations --%>
      <c:when test="${not empty param.record_id}">
        <form method="get" action="index.jsp">
          <input type="hidden" name="user_id" value="${param.user_id}"/>
          <input type="hidden" name="user_db" value="${param.user_db}"/>
          <input type="hidden" name="object_db" value="${param.object_db}"/>

          <%-- for the moment, one reservation can be processed --%>
          <input type="hidden" name="volume_id" value="${param.volume_id}"/>
          <input type="hidden" name="record_id" value="${param.record_id}"/>
          <input type="hidden" name="object_category" value="${param.object_category}"/>
          <input type="hidden" name="object_location" value="${param.object_location}"/>
          <input type="hidden" name="start_date" value="${param.start_date}"/>
          <input type="hidden" name="accept_end_date" value="0"/>

          <h3><fmt:message key="transaction_failed_for"/></h3>
          <table>
            <tr>
              <th/>
              <th><fmt:message key="id"/></th>
              <th><fmt:message key="transaction_problem"/></th>
            </tr>
            <%-- only one in reservations --%>
            <c:forEach items="${resultsFailed}" var="result">
              <tr>
                <td>
                  <input type="checkbox" name="retry_record_id" value="${result.key}"/>
                </td>
                <td>
                  <a href="#${result.key}">${result.key}</a>
                </td>
                <td>
                  <dsp:msg msg="${result.value['e:msg']}"/>
                </td>
              </tr>
            </c:forEach>
            <tr>
              <td/>
              <td colspan="2">
                <input type="submit" name="retry" value="<fmt:message key="retry_selected"/>" />
              </td>
            </tr>
          </table>
        </form>
      </c:when>
    </c:choose>

  </c:if>

  <%-- list sucessful transactions --%>
  <c:if test="${not empty resultsOk}">
    <h3><fmt:message key="transaction_successful_for"/></h3>
    <ul>
      <c:forEach items="${resultsOk}" var="result">
        <li><a href="#${result.key}">${result.key}</a></li>
      </c:forEach>
    </ul>
  </c:if>



  <%-- ==================== DETAILS ====================== --%>
  <h3 style="margin-top:6em;"><fmt:message key="transaction_details"/></h3>

  <c:forEach items="${results}" var="result">
    <x:parse varDom="doc">${result.value}</x:parse>
    <jxp:set cnode="${doc}" nsmap="${nsm}"  var="error" select="//e:error" />

    <c:choose>
      <%-- ENGINE ERRORS FIRST: show engine errors if any --%>
      <c:when test="${not empty error}">
        <%-- tell us when working with mockups --%>
        <c:if test="${not empty error['@mockup']}">
          <p class="warn">
            <fmt:message key="debug_working_with_mockups" bundle="${guiBundle}"/>
          </p>
        </c:if>

        <h3><fmt:message key="error_processing_request" bundle="${guiBundle}"/></h3>
        <p class="error">
          <dsp:msg msg="${error['e:msg']}"/>
        </p>
      </c:when>


      <%-- NO ENGINE ERRORS: show process results --%>
      <c:otherwise>
        <jxp:set cnode="${doc}" nsmap="${nsm}"  var="trans" select="//t:transactionResult"  />
        <%-- tell us when working with mockups --%>
        <c:if test="${not empty trans['@mockup']}">
          <p class="warn">
            <fmt:message key="debug_working_with_mockups" bundle="${guiBundle}"/>
          </p>
        </c:if>

        <%-- ERRORS IN PROCESS/RULES --%>
        <jxp:set cnode="${doc}" nsmap="${nsm}"  var="procError" select="//t:processResult[@successful='false']"  />
        <c:choose>
          <c:when test="${not empty procError}">
            <h3>
              <a name="${result.key}"/>
              <fmt:message key="transaction_error_for_id" bundle="${guiBundle}">
                <fmt:param value="${result.key}"/>
              </fmt:message>
            </h3>
            <%-- show all errors --%>
            <jxp:forEach  cnode="${doc}" nsmap="${nsm}" var="ptr" select="//t:processResult[@successful='false']">
              <p class="error">
                <strong><dsp:msg msg="${ptr['e:msg']}"/></strong><br/>
                <fmt:message key="process_name" bundle="${guiBundle}"/>: ${ptr['@name']}
              </p>
            </jxp:forEach>
          </c:when>

          <%-- NO ERRORS IN PROCESS/RULES --%>
          <c:otherwise>
            <h3>
              <a name="${result.key}"/>
              <fmt:message key="transaction_success_for_id" bundle="${guiBundle}">
                <fmt:param value="${result.key}"/>
              </fmt:message>
            </h3>

            <%-- also show the messages of those rules that have a result element --%>
            <jxp:forEach cnode="${doc}" nsmap="${nsm}" var="ptr" select="//t:result/..">

              <c:if test="${not empty ptr['e:msg']}">
                <h4><dsp:msg msg="${ptr['e:msg']}"/></h4><%-- An optional message along the result --%>
              </c:if>

              <c:if test="${ptr['t:result/s:suspension'] ne null}">
                <dsp:suspension doc="${ptr['t:result']}"/>
              </c:if>

              <c:if test="${ptr['t:result/f:fine'] ne null}">
                <dsp:fine doc="${ptr['t:result']}"/>
              </c:if>

              <c:if test="${ptr['t:result/l:loan'] ne null}">
                <dsp:loan doc="${ptr['t:result']}"/>
                <%--
                <h4><fmt:message key="copy_info"/></h4>
                <x:parse varDom="copyInfoResult">
                  <trans:searchObjectsById database="${fn:trim(param.object_db)}">
                    ${fn:trim(cid)}
                  </trans:searchObjectsById>
                </x:parse>
                <dsp:copy  doc="${copyInfoResult}"  object_db="${fn:trim(param.object_db)}" copy_id="${fn:trim(cid)}" />
                --%>
              </c:if>

              <c:if test="${ptr['t:result/ret:return'] ne null}">
                <dsp:return doc="${ptr['t:result']}"/>
              </c:if>

              <c:if test="${ptr['t:result/r:reservation'] ne null}">
                <dsp:reservation doc="${ptr['t:result']}"/>
              </c:if>

              <c:if test="${ptr['t:result/w:wait'] ne null}">
                <dsp:wait doc="${ptr['t:result']}"/>
              </c:if>

            </jxp:forEach>

          </c:otherwise>
        </c:choose>
      </c:otherwise>
    </c:choose>

  </c:forEach>

</div>

