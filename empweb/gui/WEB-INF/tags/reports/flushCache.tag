<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%><%@ 
tag import="java.util.HashMap" %><%@ 
tag body-content="scriptless" %><%@ 
attribute name="name" required="true" %>
<% 

  // remove the cache entry and its timestamp 

JspContext jspContext = getJspContext();

String searchName = (String)jspContext.getAttribute("name");
HashMap searchMap = (HashMap)session.getAttribute("searchMap");
HashMap searchMapTimestamps = (HashMap)session.getAttribute("searchMapTimestamps");

if (searchMap != null) {
  searchMap.remove(searchName);
  session.setAttribute("searchMap", searchMap);
}
if (searchMapTimestamps != null) {
  searchMapTimestamps.remove(searchName);
  session.setAttribute("searchMapTimestamps", searchMapTimestamps);
}
%>
