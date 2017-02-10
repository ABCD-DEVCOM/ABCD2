package org.apache.jsp.tag.web.commons.jxp;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import java.util.*;
import org.w3c.dom.*;
import org.apache.commons.jxpath.*;
import net.kalio.jsptags.jxp.*;

public final class set_tag
    extends javax.servlet.jsp.tagext.SimpleTagSupport
    implements org.apache.jasper.runtime.JspSourceDependent {


  private static java.util.Vector _jspx_dependants;

  private JspContext jspContext;
  private java.io.Writer _jspx_sout;
  public void setJspContext(JspContext ctx, java.util.Map aliasMap) {
    super.setJspContext(ctx);
    java.util.ArrayList _jspx_nested = null;
    java.util.ArrayList _jspx_at_begin = null;
    java.util.ArrayList _jspx_at_end = null;
    _jspx_at_end = new java.util.ArrayList();
    _jspx_at_end.add("punt");
    this.jspContext = new org.apache.jasper.runtime.JspContextWrapper(ctx, _jspx_nested, _jspx_at_begin, _jspx_at_end, aliasMap);
  }

  public JspContext getJspContext() {
    return this.jspContext;
  }
  private java.lang.Object cnode;
  private java.util.Map nsmap;
  private java.lang.String select;
  private java.lang.String var;

  public java.lang.Object getCnode() {
    return this.cnode;
  }

  public void setCnode(java.lang.Object cnode) {
    this.cnode = cnode;
  }

  public java.util.Map getNsmap() {
    return this.nsmap;
  }

  public void setNsmap(java.util.Map nsmap) {
    this.nsmap = nsmap;
  }

  public java.lang.String getSelect() {
    return this.select;
  }

  public void setSelect(java.lang.String select) {
    this.select = select;
  }

  public java.lang.String getVar() {
    return this.var;
  }

  public void setVar(java.lang.String var) {
    this.var = var;
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
    if( getCnode() != null ) 
      _jspx_page_context.setAttribute("cnode", getCnode());
    if( getNsmap() != null ) 
      _jspx_page_context.setAttribute("nsmap", getNsmap());
    if( getSelect() != null ) 
      _jspx_page_context.setAttribute("select", getSelect());
    if( getVar() != null ) 
      _jspx_page_context.setAttribute("var", getVar());

    try {

String select= (String)jspContext.findAttribute("select");
Object elCNode= jspContext.findAttribute("cnode");

// The attribute cnode may be a DOM object or a PointerWrapper
if (elCNode instanceof PointerWrapper)
  { elCNode= ((PointerWrapper)elCNode).getNode();
  }

JXPathContext ct= JXPathContext.newContext(elCNode);
ct.setLenient(true);

Map nsmap= (Map)jspContext.findAttribute("nsmap");
if (nsmap != null)
  { Set es= nsmap.entrySet();
    Iterator esit= es.iterator();
    while (esit.hasNext())
      { Map.Entry men= (Map.Entry)esit.next();
        ct.registerNamespace((String)men.getKey(), (String)men.getValue());
      }
  }

Pointer selectPtr= ct.getPointer(select);       // What the user asked, relative to the context node
Object selectObj= selectPtr.getNode();          // It may be a Node or a Double in case of a count() or other numeric functions

if (selectObj instanceof Double)
  { jspContext.setAttribute("punt", selectObj); // we export the Double to the attribute
  }
else                                            // We export a PointerWrapper
  { PointerWrapper pw= new PointerWrapper();
    pw.setJXPathContext(ct);
    pw.setPointer(selectPtr);
    jspContext.setAttribute("punt", pw);
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
