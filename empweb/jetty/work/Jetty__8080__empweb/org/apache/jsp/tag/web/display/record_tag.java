package org.apache.jsp.tag.web.display;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import java.util.*;
import org.apache.commons.jxpath.*;
import org.w3c.dom.*;

public final class record_tag
    extends javax.servlet.jsp.tagext.SimpleTagSupport
    implements org.apache.jasper.runtime.JspSourceDependent {


static private org.apache.jasper.runtime.ProtectedFunctionMapper _jspx_fnmap_0;

static {
  _jspx_fnmap_0= org.apache.jasper.runtime.ProtectedFunctionMapper.getMapForFunction("fn:escapeXml", org.apache.taglibs.standard.functions.Functions.class, "escapeXml", new Class[] {java.lang.String.class});
}

  private static java.util.Vector _jspx_dependants;

  static {
    _jspx_dependants = new java.util.Vector(1);
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/set.tag");
  }

  private JspContext jspContext;
  private java.io.Writer _jspx_sout;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_value_target_property_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_choose;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_when_test;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_otherwise;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_setBundle_scope_basename_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_message_key_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_if_test;

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
  private java.lang.Object doc;
  private java.lang.Object nsmap;
  private java.lang.String select;
  private java.lang.String databasename;

  public java.lang.Object getDoc() {
    return this.doc;
  }

  public void setDoc(java.lang.Object doc) {
    this.doc = doc;
  }

  public java.lang.Object getNsmap() {
    return this.nsmap;
  }

  public void setNsmap(java.lang.Object nsmap) {
    this.nsmap = nsmap;
  }

  public java.lang.String getSelect() {
    return this.select;
  }

  public void setSelect(java.lang.String select) {
    this.select = select;
  }

  public java.lang.String getDatabasename() {
    return this.databasename;
  }

  public void setDatabasename(java.lang.String databasename) {
    this.databasename = databasename;
  }

  public java.util.List getDependants() {
    return _jspx_dependants;
  }

  private void _jspInit(ServletConfig config) {
    _jspx_tagPool_c_set_value_target_property_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_choose = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_when_test = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_otherwise = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_fmt_setBundle_scope_basename_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_fmt_message_key_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_if_test = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
  }

  public void _jspDestroy() {
    _jspx_tagPool_c_set_value_target_property_nobody.release();
    _jspx_tagPool_c_choose.release();
    _jspx_tagPool_c_when_test.release();
    _jspx_tagPool_c_otherwise.release();
    _jspx_tagPool_fmt_setBundle_scope_basename_nobody.release();
    _jspx_tagPool_fmt_message_key_nobody.release();
    _jspx_tagPool_c_if_test.release();
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
    if( getDoc() != null ) 
      _jspx_page_context.setAttribute("doc", getDoc());
    if( getNsmap() != null ) 
      _jspx_page_context.setAttribute("nsmap", getNsmap());
    if( getSelect() != null ) 
      _jspx_page_context.setAttribute("select", getSelect());
    if( getDatabasename() != null ) 
      _jspx_page_context.setAttribute("databasename", getDatabasename());

    try {
      out.write("<?xml version=\"1.0\"?><!--\r\n");
      out.write("\r\n");
      out.write("-->\r\n");
      out.write("\r\n");
      java.util.HashMap localmap = null;
      synchronized (_jspx_page_context) {
        localmap = (java.util.HashMap) _jspx_page_context.getAttribute("localmap", PageContext.PAGE_SCOPE);
        if (localmap == null){
          localmap = new java.util.HashMap();
          _jspx_page_context.setAttribute("localmap", localmap, PageContext.PAGE_SCOPE);
        }
      }
      if (_jspx_meth_c_set_0(_jspx_page_context))
        return;
      //  c:choose
      org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_0 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
      _jspx_th_c_choose_0.setPageContext(_jspx_page_context);
      _jspx_th_c_choose_0.setParent(null);
      int _jspx_eval_c_choose_0 = _jspx_th_c_choose_0.doStartTag();
      if (_jspx_eval_c_choose_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
          //  c:when
          org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_0 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
          _jspx_th_c_when_0.setPageContext(_jspx_page_context);
          _jspx_th_c_when_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_0);
          _jspx_th_c_when_0.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty select}", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
          int _jspx_eval_c_when_0 = _jspx_th_c_when_0.doStartTag();
          if (_jspx_eval_c_when_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
            do {
              //  jxp:set
              org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_0 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
              java.util.HashMap _jspx_th_jxp_set_0_aliasMap = new java.util.HashMap();
              _jspx_th_jxp_set_0_aliasMap.put("punt", "tempDoc");
              _jspx_th_jxp_set_0.setJspContext(_jspx_page_context, _jspx_th_jxp_set_0_aliasMap);
              _jspx_th_jxp_set_0.setParent(_jspx_th_c_when_0);
              _jspx_th_jxp_set_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${doc}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
              _jspx_th_jxp_set_0.setVar("tempDoc");
              _jspx_th_jxp_set_0.setSelect((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${select}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              _jspx_th_jxp_set_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsmap}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
              _jspx_th_jxp_set_0.doTag();
              //  jxp:set
              org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_1 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
              java.util.HashMap _jspx_th_jxp_set_1_aliasMap = new java.util.HashMap();
              _jspx_th_jxp_set_1_aliasMap.put("punt", "recordInfo");
              _jspx_th_jxp_set_1.setJspContext(_jspx_page_context, _jspx_th_jxp_set_1_aliasMap);
              _jspx_th_jxp_set_1.setParent(_jspx_th_c_when_0);
              _jspx_th_jxp_set_1.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${tempDoc}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
              _jspx_th_jxp_set_1.setVar("recordInfo");
              _jspx_th_jxp_set_1.setSelect("m:mods");
              _jspx_th_jxp_set_1.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${localmap}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
              _jspx_th_jxp_set_1.doTag();
              int evalDoAfterBody = _jspx_th_c_when_0.doAfterBody();
              if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                break;
            } while (true);
          }
          if (_jspx_th_c_when_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
            throw new SkipPageException();
          _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_0);
          //  c:otherwise
          org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_0 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
          _jspx_th_c_otherwise_0.setPageContext(_jspx_page_context);
          _jspx_th_c_otherwise_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_0);
          int _jspx_eval_c_otherwise_0 = _jspx_th_c_otherwise_0.doStartTag();
          if (_jspx_eval_c_otherwise_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
            do {
              //  jxp:set
              org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_2 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
              java.util.HashMap _jspx_th_jxp_set_2_aliasMap = new java.util.HashMap();
              _jspx_th_jxp_set_2_aliasMap.put("punt", "recordInfo");
              _jspx_th_jxp_set_2.setJspContext(_jspx_page_context, _jspx_th_jxp_set_2_aliasMap);
              _jspx_th_jxp_set_2.setParent(_jspx_th_c_otherwise_0);
              _jspx_th_jxp_set_2.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${doc}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
              _jspx_th_jxp_set_2.setVar("recordInfo");
              _jspx_th_jxp_set_2.setSelect("//m:mods");
              _jspx_th_jxp_set_2.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${localmap}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
              _jspx_th_jxp_set_2.doTag();
              int evalDoAfterBody = _jspx_th_c_otherwise_0.doAfterBody();
              if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                break;
            } while (true);
          }
          if (_jspx_th_c_otherwise_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
            throw new SkipPageException();
          _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_0);
          int evalDoAfterBody = _jspx_th_c_choose_0.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_choose_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        throw new SkipPageException();
      _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_0);
      if (_jspx_meth_fmt_setBundle_0(_jspx_page_context))
        return;
      out.write("<table>\r\n");
      out.write("  <tr>\r\n");
      out.write("    <td>");
      if (_jspx_meth_fmt_message_0(_jspx_page_context))
        return;
      out.write("</td>\r\n");
      out.write("    <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${recordInfo['m:recordInfo/m:recordIdentifier']}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
      if (_jspx_meth_c_if_0(_jspx_page_context))
        return;
      out.write("</td>\r\n");
      out.write("  </tr>\r\n");
      out.write("  <tr>\r\n");
      out.write("    <td>");
      if (_jspx_meth_fmt_message_1(_jspx_page_context))
        return;
      out.write("</td>\r\n");
      out.write("    <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:escapeXml(recordInfo['m:titleInfo/m:title'])}", java.lang.String.class, (PageContext)this.getJspContext(), _jspx_fnmap_0, false));
      out.write("</td>\r\n");
      out.write("  </tr>\r\n");
      out.write("  <tr>\r\n");
      out.write("    <td>");
      if (_jspx_meth_fmt_message_2(_jspx_page_context))
        return;
      out.write("</td>\r\n");
      out.write("    <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${recordInfo['m:name[m:role/m:roleTerm=\"author\"]/m:namePart']}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
      out.write("</td>\r\n");
      out.write("  </tr>\r\n");
      out.write("</table>\r\n");
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
    _jspx_th_c_set_0.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${localmap}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_0.setProperty("m");
    _jspx_th_c_set_0.setValue(new String("http://www.loc.gov/mods/v3"));
    int _jspx_eval_c_set_0 = _jspx_th_c_set_0.doStartTag();
    if (_jspx_th_c_set_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_0);
    return false;
  }

  private boolean _jspx_meth_fmt_setBundle_0(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:setBundle
    org.apache.taglibs.standard.tag.rt.fmt.SetBundleTag _jspx_th_fmt_setBundle_0 = (org.apache.taglibs.standard.tag.rt.fmt.SetBundleTag) _jspx_tagPool_fmt_setBundle_scope_basename_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.SetBundleTag.class);
    _jspx_th_fmt_setBundle_0.setPageContext(_jspx_page_context);
    _jspx_th_fmt_setBundle_0.setParent(null);
    _jspx_th_fmt_setBundle_0.setBasename("ewi18n.local.display");
    _jspx_th_fmt_setBundle_0.setScope("page");
    int _jspx_eval_fmt_setBundle_0 = _jspx_th_fmt_setBundle_0.doStartTag();
    if (_jspx_th_fmt_setBundle_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_setBundle_scope_basename_nobody.reuse(_jspx_th_fmt_setBundle_0);
    return false;
  }

  private boolean _jspx_meth_fmt_message_0(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_0 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_0.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_0.setParent(null);
    _jspx_th_fmt_message_0.setKey("record_id");
    int _jspx_eval_fmt_message_0 = _jspx_th_fmt_message_0.doStartTag();
    if (_jspx_th_fmt_message_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_0);
    return false;
  }

  private boolean _jspx_meth_c_if_0(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_0 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_0.setPageContext(_jspx_page_context);
    _jspx_th_c_if_0.setParent(null);
    _jspx_th_c_if_0.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not config['ew.hide_object_db'] and not empty databasename}", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
    int _jspx_eval_c_if_0 = _jspx_th_c_if_0.doStartTag();
    if (_jspx_eval_c_if_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write(' ');
        out.write('(');
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${databasename}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write(')');
        int evalDoAfterBody = _jspx_th_c_if_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_0);
    return false;
  }

  private boolean _jspx_meth_fmt_message_1(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_1 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_1.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_1.setParent(null);
    _jspx_th_fmt_message_1.setKey("title");
    int _jspx_eval_fmt_message_1 = _jspx_th_fmt_message_1.doStartTag();
    if (_jspx_th_fmt_message_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_1);
    return false;
  }

  private boolean _jspx_meth_fmt_message_2(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_2 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_2.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_2.setParent(null);
    _jspx_th_fmt_message_2.setKey("author");
    int _jspx_eval_fmt_message_2 = _jspx_th_fmt_message_2.doStartTag();
    if (_jspx_th_fmt_message_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_2);
    return false;
  }
}
