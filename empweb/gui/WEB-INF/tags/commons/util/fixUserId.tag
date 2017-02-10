<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%><%-- 
--%><%@ tag body-content="scriptless" %><%-- 
--%><%@ attribute name="pattern" required="false" %><%-- 
--%><%@ tag import="java.util.regex.*" %><%-- 
--%><%@ tag import="java.util.Properties" %><%-- 
--%><jsp:doBody var="userIdRaw"/><%

String userIdRaw = (String)jspContext.getAttribute("userIdRaw");
if (userIdRaw != null) {
  String userId = userIdRaw.trim();

  String thePattern = null;
  Properties props = (Properties)application.getAttribute("config");

  if ( (pattern != null) && (pattern.trim().length() > 0) ) {
    thePattern = pattern;
  } else if ( (props != null) && (props.getProperty("gui.fixUserId.pattern") != null) ) {
    thePattern = props.getProperty("gui.fixUserId.pattern");
  } 

  if (thePattern != null) {
    try {
      Pattern p = Pattern.compile(thePattern);
      Matcher m = p.matcher(userId);
      
      String fixedUserId = userId;
      if (m.matches() && m.group(1) != null && m.group(1).length()>0 )
        fixedUserId = m.group(1);

%><%=fixedUserId%><%    
    } catch (Exception ex) {
      System.out.println("fixUserId exception:"+ex.toString());
%><%=userIdRaw%><%
    }
  }  else { // thePattern == null 
%><%=userIdRaw%><%
  }
} 
%>