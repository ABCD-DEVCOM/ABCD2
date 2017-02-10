package org.apache.jsp.tag.web.admin;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import java.util.*;
import net.kalio.auth.*;

public final class getOperator_tag
    extends javax.servlet.jsp.tagext.SimpleTagSupport
    implements org.apache.jasper.runtime.JspSourceDependent {


  private static java.util.Vector _jspx_dependants;

  private JspContext jspContext;
  private java.io.Writer _jspx_sout;
  public void setJspContext(JspContext ctx) {
    super.setJspContext(ctx);
    java.util.ArrayList _jspx_nested = null;
    java.util.ArrayList _jspx_at_begin = null;
    java.util.ArrayList _jspx_at_end = null;
    this.jspContext = new org.apache.jasper.runtime.JspContextWrapper(ctx, _jspx_nested, _jspx_at_begin, _jspx_at_end, null);
  }

  public JspContext getJspContext() {
    return this.jspContext;
  }
  private java.lang.String id;

  public java.lang.String getId() {
    return this.id;
  }

  public void setId(java.lang.String id) {
    this.id = id;
  }

  public java.util.List getDependants() {
    return _jspx_dependants;
  }

  public void doTag() throws JspException, java.io.IOException {
    PageContext _jspx_page_context = (PageContext)jspContext;
    HttpServletRequest request = (HttpServletRequest) _jspx_page_context.getRequest();
    HttpServletResponse response = (HttpServletResponse) _jspx_page_context.getResponse();
    HttpSession session = _jspx_page_context.getSession();
    ServletContext application = _jspx_page_context.getServletContext();
    ServletConfig config = _jspx_page_context.getServletConfig();
    JspWriter out = jspContext.getOut();
    if( getId() != null ) 
      _jspx_page_context.setAttribute("id", getId());

    try {


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

      out.write("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n");
      out.write("<operator id=\"");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${id}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
      out.write("\">\r\n");
      out.write("  <name>");
      out.print( Auth.getUserData("/users/user[@id='"+id+"']/username") );
      out.write("</name>\r\n");
      out.write("  <email>");
      out.print( Auth.getUserData("/users/user[@id='"+id+"']/email") );
      out.write("</email>\r\n");
      out.write("\r\n");
      out.write("  <groups>\r\n");

    for (int i= 0; i < groups.length; i++) {

      out.write("<group id=\"");
      out.print( groups[i] );
      out.write("\"\r\n");
      out.write("             ");
      out.print( permsh.contains(groups[i]) ? "active=\"true\"" : "" );
      out.write(" />\r\n");

    } // for groups

      out.write("</groups>\r\n");
      out.write("\r\n");
      out.write("  <properties>\r\n");

  Iterator it = props.keySet().iterator();
  while (it.hasNext()) {
    String propname = (String)it.next();
    String propval = (String)props.get(propname);

      out.write("<property id=\"");
      out.print( propname );
      out.write('"');
      out.write('>');
      out.print(propval);
      out.write("</property>\r\n");

  }

      out.write("</properties>\r\n");
      out.write("</operator>");
    } catch( Throwable t ) {
      if( t instanceof SkipPageException )
          throw (SkipPageException) t;
      if( t instanceof java.io.IOException )
          throw (java.io.IOException) t;
      if( t instanceof IllegalStateException )
          throw (IllegalStateException) t;
      if( t instanceof JspException )
          throw (JspException) t;
      throw new JspException(t);
    } finally {
      ((org.apache.jasper.runtime.JspContextWrapper) jspContext).syncEndTagFile();
    }
  }
}
