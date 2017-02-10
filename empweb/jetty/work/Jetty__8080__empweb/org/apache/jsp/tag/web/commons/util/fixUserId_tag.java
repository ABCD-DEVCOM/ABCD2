package org.apache.jsp.tag.web.commons.util;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import java.util.regex.*;
import java.util.Properties;

public final class fixUserId_tag
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
  private java.lang.String pattern;

  public java.lang.String getPattern() {
    return this.pattern;
  }

  public void setPattern(java.lang.String pattern) {
    this.pattern = pattern;
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
    if( getPattern() != null ) 
      _jspx_page_context.setAttribute("pattern", getPattern());

    try {
      ((org.apache.jasper.runtime.JspContextWrapper) this.jspContext).syncBeforeInvoke();
      _jspx_sout = new java.io.StringWriter();
      if (getJspBody() != null)
        getJspBody().invoke(_jspx_sout);
      _jspx_page_context.setAttribute("userIdRaw", _jspx_sout.toString());


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


      out.print(fixedUserId);
    
    } catch (Exception ex) {
      System.out.println("fixUserId exception:"+ex.toString());

      out.print(userIdRaw);

    }
  }  else { // thePattern == null 

      out.print(userIdRaw);

  }
} 

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
