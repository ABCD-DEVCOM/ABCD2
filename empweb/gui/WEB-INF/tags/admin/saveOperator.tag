<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>
<%@ tag body-content="empty"%>
<%@ tag import="java.util.*" %>
<%@ tag import="net.kalio.auth.*" %>
<%@ attribute name="id" required="true" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>

<%-- procesar el tema y devolver el html de ok o error --%>

<%
Auth.setAuthPath( System.getProperty("empweb.home", "/") +
                  application.getInitParameter("net.kalio.auth.location"));

// prepare data
HashMap userdata = new HashMap(4);
userdata.put("username", request.getParameter("name"));
userdata.put("email", request.getParameter("email"));

// keep old password if not changed (BBB are we checking this in edit_operator???)
String pass = request.getParameter("password1");
if ((pass != null) && (pass.length() > 0))
    userdata.put("password", request.getParameter("password1"));
else {
    HashMap olddata = Auth.getUserProperties(id);
    String oldpass = (String)olddata.get("password");
    userdata.put("password", oldpass);
}


HashMap usergroups = new HashMap(30);
String groups[] = Auth.getGroups();
Map allparams = request.getParameterMap();

for (int i=0; i < groups.length; i++) {
    if ( allparams.get("group-"+groups[i]) != null ){
      usergroups.put(groups[i], "true");
    }
}

HashMap userprops = new HashMap(5);
Iterator ip = allparams.keySet().iterator();
String key;
String val;
while (ip.hasNext()) {
    key = (String)ip.next();
    if (key.matches("property-(.*)")) {
        val = request.getParameter(key);
        try {
            //val = new String(val.getBytes(), encoding);  // TODO: no puede ser que tenga que hacer esto!
            userprops.put( key.replaceFirst("property-",""), val);
        } catch(Exception ex) {
            System.err.println(ex);
            ex.printStackTrace();
        }
    }
}

// save operator data
String result = Auth.saveUser(id, userdata, usergroups, userprops);
getJspContext().setAttribute("resultkey", result);

//TODO: actualzar datos de session si me estoy editando a mi mismo :)

if ("".equals(result)) {
%>
<p>
  <fmt:message key="save_operator_succeeded">
     <fmt:param value="${id}"/>
  </fmt:message>
</p>
<%
     } else {
%>
<p><fmt:message key="save_operator_failed"/>: <strong><fmt:message key="${resultkey}"/></strong></p>
<%
     }
%>
