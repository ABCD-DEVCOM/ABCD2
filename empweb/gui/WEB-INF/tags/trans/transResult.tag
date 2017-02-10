<%--
/*
 * Copyright 2004-2006 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 */
--%>
<%@ tag body-content="scriptless" %>
<%@ attribute name="showAll" required="false" %>
<%@ taglib prefix="c"   uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x"   uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn"  uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>


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

<x:parse varDom="doc"><jsp:doBody/></x:parse>

<jxp:set cnode="${doc}" nsmap="${nsm}"  var="error" select="//e:error" />

<div>

  <c:choose>
    <%-- show engine errors if any --%>
    <c:when test="${not empty error}">
      <%-- tell us when working with mockups --%>
      <c:if test="${not empty error['@mockup']}">
        <p class="warn">
          <fmt:message key="debug_working_with_mockups" bundle="${guiBundle}"/>
        </p>
      </c:if>

      <h4><fmt:message key="error_processing_request" bundle="${guiBundle}"/></h4>
      <p class="error">
        <dsp:msg msg="${error['e:msg']}"/>
      </p>
    </c:when>

    <%-- no engine errors: show process results --%>
    <c:otherwise>
      <jxp:set cnode="${doc}" nsmap="${nsm}"  var="trans" select="//t:transactionResult"  />
      <%-- tell us when working with mockups --%>
      <c:if test="${not empty trans['@mockup']}">
        <p class="warn">
          <fmt:message key="debug_working_with_mockups" bundle="${guiBundle}"/>
        </p>
      </c:if>


      <%-- first check if there is any error message in the process/rules and show it --%>
      <jxp:set cnode="${doc}" nsmap="${nsm}"  var="hasProcError" select="//t:processResult[@successful='false']/@successful"  />
      <jxp:set cnode="${doc}" nsmap="${nsm}"  var="procError" select="//t:processResult[@successful='false']"  />

      <c:if test="${not empty hasProcError}">
        <h3><fmt:message key="error_processing_transaction" bundle="${guiBundle}"/></h3>
        <jxp:forEach  cnode="${doc}" nsmap="${nsm}" var="ptr" select="//t:processResult[@successful='false']">
          <p class="error">
            <strong><dsp:msg msg="${ptr['e:msg']}"/></strong><br/>
            <fmt:message key="process_name" bundle="${guiBundle}"/>: ${ptr['@name']}
          </p>
        </jxp:forEach>
      </c:if>

      <c:if test="${empty hasProcError}">
        <h3><fmt:message key="transaction_successful" bundle="${guiBundle}"/></h3>
      </c:if>


      <%-- also show the messages of those rules that have a result element --%>
      <jxp:forEach
        cnode="${doc}"
        nsmap="${nsm}"
        var="ptr"
        select="//t:result/..">

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
</div>
