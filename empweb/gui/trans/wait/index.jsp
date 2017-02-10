<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="dsp" tagdir="/WEB-INF/tags/display" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>



<div class="middle homepage">
  <h1><fmt:message key="reservation"/></h1>
  <h2><fmt:message key="reservation_forms"/></h2>

  <h3><fmt:message key="choose_task"/></h3>
  <p>
    <ul>
      <li>
        <a href="create/index.jsp"><fmt:message key="create_reservation"/></a>
      </li>
      <li>
        <a href="cancel/index.jsp"><fmt:message key="cancel_reservation"/></a>
      </li>
    </ul>
  </p> 
</div>
