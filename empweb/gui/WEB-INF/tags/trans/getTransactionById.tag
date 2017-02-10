<%@ tag body-content="scriptless" %>
<%@ attribute name="id"  required="true" %>

<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>

<%--
/* 
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>


<trans:doTransaction name="stat-trans-by-ids">
    <transactionExtras>
      <params>
        <param name="transactionIds">${id},</param>
      </params>
    </transactionExtras>
</trans:doTransaction>
