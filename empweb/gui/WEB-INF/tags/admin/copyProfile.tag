<%--
/* 
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="empty" %>
<%@ attribute name="policyId" required="true" %>
<%@ attribute name="sourceId" required="true" %>
<%@ attribute name="destName" required="true" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>

<%-- procesar el tema y devolver el html de ok o error --%>

<p><fmt:message key="copy_profile_succeeded"/></p>
