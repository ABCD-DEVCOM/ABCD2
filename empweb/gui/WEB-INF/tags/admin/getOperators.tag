<%@ tag body-content="empty" %>
<%@ tag import="java.util.*" %>
<%@ tag import="net.kalio.auth.*" %>
<%
Auth.setAuthPath( System.getProperty("empweb.home", "/") +
                  application.getInitParameter("net.kalio.auth.location"));
String uids[] = Auth.getUsers();
%>
<?xml version="1.0" encoding="UTF-8"?>
<operators>
<%
  for (int i= 0; i < uids.length; i++) {
%>
  <operator id="<%= uids[i] %>">
    <name><%= Auth.getUserData("/users/user[@id='"+uids[i]+"']/username") %></name>
    <email><%= Auth.getUserData("/users/user[@id='"+uids[i]+"']/email") %></email>
<%
    HashMap props = Auth.getUserProperties(uids[i]);
%>
    <properties>
<%
    Iterator it = props.keySet().iterator();
    while (it.hasNext()) {
      String propname = (String)it.next();
      String propval = (String)props.get(propname);
%>
      <property id="<%= propname %>"><%=propval%></property>
<%
    }
%>

    </properties>
  </operator>
<%
  }
%>
</operators>
