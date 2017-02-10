<%@ tag body-content="empty" %>
<%@ tag import="java.util.*" %>
<%@ tag import="net.kalio.auth.*" %>
<%@ attribute name="id" required="true" %>
<%

//It returns an XML representing the operator, with the general format:
//<operator id="john">
//  <name>John Smith</name>
//  <email>john@domain.com</email>
//  <groups>
//    <group id="trans-query" active="true" />
//    <group id="trans-suspension" />
//  </groups>
//  <properties>
//    <property id="someProp">some value</property>
//  </properties>
//</operator>

Auth.setAuthPath( System.getProperty("empweb.home", "/") +
                  application.getInitParameter("net.kalio.auth.location"));
String groups[] = Auth.getGroups();
String perms[] = Auth.getPermissions(id);
HashMap props = Auth.getUserProperties(id);

Set permsh = new HashSet( Arrays.asList(perms) );
%>
<?xml version="1.0" encoding="UTF-8"?>
<operator id="${id}">
  <name><%= Auth.getUserData("/users/user[@id='"+id+"']/username") %></name>
  <email><%= Auth.getUserData("/users/user[@id='"+id+"']/email") %></email>

  <groups>
<%
    for (int i= 0; i < groups.length; i++) {
%>
      <group id="<%= groups[i] %>"
             <%= permsh.contains(groups[i]) ? "active=\"true\"" : "" %> />
<%
    } // for groups
%>
  </groups>

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