package org.apache.jsp.tag.web.commons.jxp;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import java.util.*;
import org.w3c.dom.*;
import org.apache.commons.jxpath.*;
import net.kalio.jsptags.jxp.*;

public final class forEach_tag
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
    _jspx_nested = new java.util.ArrayList();
    _jspx_nested.add("punt");
    _jspx_nested.add("_jxpItem");
    this.jspContext = new org.apache.jasper.runtime.JspContextWrapper(ctx, _jspx_nested, _jspx_at_begin, _jspx_at_end, aliasMap);
  }

  public JspContext getJspContext() {
    return this.jspContext;
  }
  private java.lang.Object cnode;
  private java.util.Map nsmap;
  private java.lang.String select;
  private java.lang.String sortby;
  private java.lang.String sortorder;
  private java.lang.String var;
  private java.lang.Integer from;
  private java.lang.Integer to;

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

  public java.lang.String getSortby() {
    return this.sortby;
  }

  public void setSortby(java.lang.String sortby) {
    this.sortby = sortby;
  }

  public java.lang.String getSortorder() {
    return this.sortorder;
  }

  public void setSortorder(java.lang.String sortorder) {
    this.sortorder = sortorder;
  }

  public java.lang.String getVar() {
    return this.var;
  }

  public void setVar(java.lang.String var) {
    this.var = var;
  }

  public java.lang.Integer getFrom() {
    return this.from;
  }

  public void setFrom(java.lang.Integer from) {
    this.from = from;
  }

  public java.lang.Integer getTo() {
    return this.to;
  }

  public void setTo(java.lang.Integer to) {
    this.to = to;
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
    if( getSortby() != null ) 
      _jspx_page_context.setAttribute("sortby", getSortby());
    if( getSortorder() != null ) 
      _jspx_page_context.setAttribute("sortorder", getSortorder());
    if( getVar() != null ) 
      _jspx_page_context.setAttribute("var", getVar());
    if( getFrom() != null ) 
      _jspx_page_context.setAttribute("from", getFrom());
    if( getTo() != null ) 
      _jspx_page_context.setAttribute("to", getTo());

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


  // Calculate from-to range
  Integer fromInt= (Integer)jspContext.findAttribute("from");
  Integer toInt=   (Integer)jspContext.findAttribute("to");

  int from, to;

  from= (fromInt == null || fromInt.intValue() < 1) ? 1 : fromInt.intValue();

  if (toInt == null)
    to= Integer.MAX_VALUE;
  else if (toInt.intValue() < 0)
    to= 0;
  else
    to= toInt.intValue();


  Iterator it= ct.iteratePointers(select);                    // Obtain JXPath Pointers

  // Build an ArrayList of PointerWrappers, only with the elements in the from-to range
  ArrayList pwList= new ArrayList(20);
  for (int i= 1; it.hasNext() && i <= to; i++)
    { Pointer p= (Pointer)it.next();
      if (i < from)                                           // skip the first few
        continue;

      PointerWrapper pw= new PointerWrapper();
      pw.setJXPathContext(ct);
      pw.setPointer(p);
      pwList.add(pw);
    }

  // If sortby requested, sort the PointerWrappers
  String sortby= (String)jspContext.findAttribute("sortby");
  String sortorder= (String)jspContext.findAttribute("sortorder");
  if (sortby != null && sortby.trim().length() > 0)
    { char firstChar= sortby.charAt(0);
      final boolean ascending;
      if (sortorder != null && sortorder.trim().length() > 0)
        ascending = ("-".equals(sortorder) || "descending".equals(sortorder)) ? false : true;
      else
        ascending = (firstChar == '-') ? false : true;   // '+' or other char means ascending
      final String finalSortby;
      if (firstChar == '+' || firstChar == '-')                     // if sorting order was specified...
        finalSortby= sortby.substring(1);                           // ...keep the rest of the string
      else
        finalSortby= sortby;

      java.util.Collections.sort(pwList,
        new Comparator()
          { public int compare(Object o1, Object o2)
            { PointerWrapper pw1= (PointerWrapper)o1;
              PointerWrapper pw2= (PointerWrapper)o2;

              // Obtain PointerWrappers to the sortby node
              PointerWrapper sortPw1= (PointerWrapper)pw1.get(finalSortby);
              PointerWrapper sortPw2= (PointerWrapper)pw2.get(finalSortby);

              // PointerWrapper does a String compareTo of the String contents
              int comp;
              if (sortPw1 != null)
                comp= sortPw1.compareTo(sortPw2);
              else if (sortPw2 == null)                             // if both are null
                comp= 0;
              else                                                  // 1 is null, 2 is not null =>  1 < 2
                comp= -1;

              return ( ascending ? comp : (comp * -1) );
            }
          }
      );
    } // if sortby


  // Iteration loop
  int size= pwList.size();
  for (int i= 0; i < size; i++)
    { PointerWrapper pw= (PointerWrapper)pwList.get(i);
      jspContext.setAttribute("_jxpItem", new Integer(i+from));
      jspContext.setAttribute("punt", pw);

      ((org.apache.jasper.runtime.JspContextWrapper) this.jspContext).syncBeforeInvoke();
      _jspx_sout = null;
      if (getJspBody() != null)
        getJspBody().invoke(_jspx_sout);

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
