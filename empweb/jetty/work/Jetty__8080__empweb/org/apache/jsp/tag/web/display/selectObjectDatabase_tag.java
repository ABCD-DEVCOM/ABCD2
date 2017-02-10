package org.apache.jsp.tag.web.display;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;

public final class selectObjectDatabase_tag
    extends javax.servlet.jsp.tagext.SimpleTagSupport
    implements org.apache.jasper.runtime.JspSourceDependent {


  private static java.util.Vector _jspx_dependants;

  static {
    _jspx_dependants = new java.util.Vector(1);
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/forEach.tag");
  }

  private JspContext jspContext;
  private java.io.Writer _jspx_sout;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_value_target_property_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_message_key_nobody;

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
  private java.lang.String name;
  private org.w3c.dom.Node dbNames;
  private java.lang.String selectedDb;

  public java.lang.String getName() {
    return this.name;
  }

  public void setName(java.lang.String name) {
    this.name = name;
  }

  public org.w3c.dom.Node getDbNames() {
    return this.dbNames;
  }

  public void setDbNames(org.w3c.dom.Node dbNames) {
    this.dbNames = dbNames;
  }

  public java.lang.String getSelectedDb() {
    return this.selectedDb;
  }

  public void setSelectedDb(java.lang.String selectedDb) {
    this.selectedDb = selectedDb;
  }

  public java.util.List getDependants() {
    return _jspx_dependants;
  }

  private void _jspInit(ServletConfig config) {
    _jspx_tagPool_c_set_value_target_property_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_fmt_message_key_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
  }

  public void _jspDestroy() {
    _jspx_tagPool_c_set_value_target_property_nobody.release();
    _jspx_tagPool_fmt_message_key_nobody.release();
  }

  public void doTag() throws JspException, java.io.IOException {
    PageContext _jspx_page_context = (PageContext)jspContext;
    HttpServletRequest request = (HttpServletRequest) _jspx_page_context.getRequest();
    HttpServletResponse response = (HttpServletResponse) _jspx_page_context.getResponse();
    HttpSession session = _jspx_page_context.getSession();
    ServletContext application = _jspx_page_context.getServletContext();
    ServletConfig config = _jspx_page_context.getServletConfig();
    JspWriter out = jspContext.getOut();
    _jspInit(config);
    if( getName() != null ) 
      _jspx_page_context.setAttribute("name", getName());
    if( getDbNames() != null ) 
      _jspx_page_context.setAttribute("dbNames", getDbNames());
    if( getSelectedDb() != null ) 
      _jspx_page_context.setAttribute("selectedDb", getSelectedDb());

    try {
      java.util.HashMap nsm = null;
      synchronized (_jspx_page_context) {
        nsm = (java.util.HashMap) _jspx_page_context.getAttribute("nsm", PageContext.PAGE_SCOPE);
        if (nsm == null){
          nsm = new java.util.HashMap();
          _jspx_page_context.setAttribute("nsm", nsm, PageContext.PAGE_SCOPE);
        }
      }
      if (_jspx_meth_c_set_0(_jspx_page_context))
        return;
      out.write("<select name=\"");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${name}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
      out.write("\">\r\n");
      out.write("  <option value=\"*\">");
      if (_jspx_meth_fmt_message_0(_jspx_page_context))
        return;
      out.write("</option>\r\n");
      out.write("  ");
      //  jxp:forEach
      org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_0 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
      java.util.HashMap _jspx_th_jxp_forEach_0_aliasMap = new java.util.HashMap();
      _jspx_th_jxp_forEach_0_aliasMap.put("punt", "dbptr");
      _jspx_th_jxp_forEach_0.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_0_aliasMap);
      _jspx_th_jxp_forEach_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${dbNames}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
      _jspx_th_jxp_forEach_0.setVar("dbptr");
      _jspx_th_jxp_forEach_0.setSelect("//db:databases/db:database[@type='objects']");
      _jspx_th_jxp_forEach_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
      _jspx_th_jxp_forEach_0.setJspBody(new selectObjectDatabase_tagHelper( 0, _jspx_page_context, _jspx_th_jxp_forEach_0, null));
      _jspx_th_jxp_forEach_0.doTag();
      out.write("</select>\r\n");
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
      _jspDestroy();
    }
  }

  private boolean _jspx_meth_c_set_0(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_0 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_0.setPageContext(_jspx_page_context);
    _jspx_th_c_set_0.setParent(null);
    _jspx_th_c_set_0.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_0.setProperty("db");
    _jspx_th_c_set_0.setValue(new String("http://kalio.net/empweb/schema/databases/v1"));
    int _jspx_eval_c_set_0 = _jspx_th_c_set_0.doStartTag();
    if (_jspx_th_c_set_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_0);
    return false;
  }

  private boolean _jspx_meth_fmt_message_0(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_0 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_0.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_0.setParent(null);
    _jspx_th_fmt_message_0.setKey("search_all");
    int _jspx_eval_fmt_message_0 = _jspx_th_fmt_message_0.doStartTag();
    if (_jspx_th_fmt_message_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_0);
    return false;
  }

  private class selectObjectDatabase_tagHelper
      extends org.apache.jasper.runtime.JspFragmentHelper
  {
    private javax.servlet.jsp.tagext.JspTag _jspx_parent;
    private int[] _jspx_push_body_count;

    public selectObjectDatabase_tagHelper( int discriminator, JspContext jspContext, javax.servlet.jsp.tagext.JspTag _jspx_parent, int[] _jspx_push_body_count ) {
      super( discriminator, jspContext, _jspx_parent );
      this._jspx_parent = _jspx_parent;
      this._jspx_push_body_count = _jspx_push_body_count;
    }
    public void invoke0( JspWriter out ) 
      throws Throwable
    {
      out.write("<option value=\"");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${dbptr}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
      out.write('"');
      out.write(' ');
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ dbptr eq selectedDb ? 'selected=\"selected\"' : \"\" }", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
      out.write(' ');
      out.write('>');
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${dbptr}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
      out.write("</option>\r\n");
      out.write("  ");
      return;
    }
    public void invoke( java.io.Writer writer )
      throws JspException
    {
      JspWriter out = null;
      if( writer != null ) {
        out = this.jspContext.pushBody(writer);
      } else {
        out = this.jspContext.getOut();
      }
      try {
        switch( this.discriminator ) {
          case 0:
            invoke0( out );
            break;
        }
      }
      catch( Throwable e ) {
        if (e instanceof SkipPageException)
            throw (SkipPageException) e;
        throw new JspException( e );
      }
      finally {
        if( writer != null ) {
          this.jspContext.popBody();
        }
      }
    }
  }
}
