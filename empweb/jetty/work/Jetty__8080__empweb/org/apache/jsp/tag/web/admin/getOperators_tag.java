package org.apache.jsp.tag.web.admin;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import java.util.*;
import net.kalio.auth.*;

public final class getOperators_tag
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

    try {

Auth.setAuthPath( System.getProperty("empweb.home", "/") +
                  application.getInitParameter("net.kalio.auth.location"));
String uids[] = Auth.getUsers();

      out.write("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n");
      out.write("<operators>\r\n");

  for (int i= 0; i < uids.length; i++) {

      out.write("<operator id=\"");
      out.print( uids[i] );
      out.write("\">\r\n");
      out.write("    <name>");
      out.print( Auth.getUserData("/users/user[@id='"+uids[i]+"']/username") );
      out.write("</name>\r\n");
      out.write("    <email>");
      out.print( Auth.getUserData("/users/user[@id='"+uids[i]+"']/email") );
      out.write("</email>\r\n");

    HashMap props = Auth.getUserProperties(uids[i]);

      out.write("<properties>\r\n");

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
      out.write("  </operator>\r\n");

  }

      out.write("</operators>\r\n");
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
