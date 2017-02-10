<%@ tag body-content="empty" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ attribute name="name"  required="true" %>
<%@ attribute name="dbNames" required="true" type="org.w3c.dom.Node" %>
<%@ attribute name="selectedDb"  required="false" %>
<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="db" value="http://kalio.net/empweb/schema/databases/v1" />
<select name="${name}">
  <option value="*"><fmt:message key="search_all"/></option>
  <jxp:forEach cnode="${dbNames}" var="dbptr" select="//db:databases/db:database[@type='users']" nsmap="${nsm}">
    <option value="${dbptr}" ${ dbptr eq selectedDb ? 'selected="selected"' : "" } >${dbptr}</option>
  </jxp:forEach>
</select>
