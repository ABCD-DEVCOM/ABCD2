package org.apache.jsp.tag.web.admin;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;

public final class newCalendar_tag
    extends javax.servlet.jsp.tagext.SimpleTagSupport
    implements org.apache.jasper.runtime.JspSourceDependent {


  private static java.util.Vector _jspx_dependants;

  static {
    _jspx_dependants = new java.util.Vector(2);
    _jspx_dependants.add("/WEB-INF/tags/admin/getCalendars.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/set.tag");
  }

  private JspContext jspContext;
  private java.io.Writer _jspx_sout;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_x_parse_varDom;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_value_target_property_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_choose;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_when_test;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_otherwise;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_io_soap_url_encoding_SOAPAction;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_io_body;

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
  private java.lang.String year;

  public java.lang.String getYear() {
    return this.year;
  }

  public void setYear(java.lang.String year) {
    this.year = year;
  }

  public java.util.List getDependants() {
    return _jspx_dependants;
  }

  private void _jspInit(ServletConfig config) {
    _jspx_tagPool_x_parse_varDom = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_set_value_target_property_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_choose = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_when_test = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_otherwise = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_io_soap_url_encoding_SOAPAction = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_io_body = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
  }

  public void _jspDestroy() {
    _jspx_tagPool_x_parse_varDom.release();
    _jspx_tagPool_c_set_value_target_property_nobody.release();
    _jspx_tagPool_c_choose.release();
    _jspx_tagPool_c_when_test.release();
    _jspx_tagPool_c_otherwise.release();
    _jspx_tagPool_io_soap_url_encoding_SOAPAction.release();
    _jspx_tagPool_io_body.release();
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
    if( getYear() != null ) 
      _jspx_page_context.setAttribute("year", getYear());

    try {
      if (_jspx_meth_x_parse_0(_jspx_page_context))
        return;
      java.util.HashMap nsm1 = null;
      synchronized (_jspx_page_context) {
        nsm1 = (java.util.HashMap) _jspx_page_context.getAttribute("nsm1", PageContext.PAGE_SCOPE);
        if (nsm1 == null){
          nsm1 = new java.util.HashMap();
          _jspx_page_context.setAttribute("nsm1", nsm1, PageContext.PAGE_SCOPE);
        }
      }
      if (_jspx_meth_c_set_0(_jspx_page_context))
        return;
      //  jxp:set
      org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_0 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
      java.util.HashMap _jspx_th_jxp_set_0_aliasMap = new java.util.HashMap();
      _jspx_th_jxp_set_0_aliasMap.put("punt", "calExists");
      _jspx_th_jxp_set_0.setJspContext(_jspx_page_context, _jspx_th_jxp_set_0_aliasMap);
      _jspx_th_jxp_set_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${cals}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
      _jspx_th_jxp_set_0.setVar("calExists");
      _jspx_th_jxp_set_0.setSelect((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("//c:calendar[c:year/@value='${year}']/@id", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
      _jspx_th_jxp_set_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm1}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
      _jspx_th_jxp_set_0.doTag();
      if (_jspx_meth_c_choose_0(_jspx_page_context))
        return;
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

  private boolean _jspx_meth_x_parse_0(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_0 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_0.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_0.setParent(null);
    _jspx_th_x_parse_0.setVarDom("cals");
    int _jspx_eval_x_parse_0 = _jspx_th_x_parse_0.doStartTag();
    if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_0.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_0.doInitBody();
      }
      do {
        if (_jspx_meth_admin_getCalendars_0(_jspx_th_x_parse_0, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_x_parse_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_x_parse_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_x_parse_varDom.reuse(_jspx_th_x_parse_0);
    return false;
  }

  private boolean _jspx_meth_admin_getCalendars_0(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  admin:getCalendars
    org.apache.jsp.tag.web.admin.getCalendars_tag _jspx_th_admin_getCalendars_0 = new org.apache.jsp.tag.web.admin.getCalendars_tag();
    _jspx_th_admin_getCalendars_0.setJspContext(_jspx_page_context);
    _jspx_th_admin_getCalendars_0.setParent(_jspx_th_x_parse_0);
    _jspx_th_admin_getCalendars_0.doTag();
    return false;
  }

  private boolean _jspx_meth_c_set_0(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_0 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_0.setPageContext(_jspx_page_context);
    _jspx_th_c_set_0.setParent(null);
    _jspx_th_c_set_0.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm1}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_0.setProperty("c");
    _jspx_th_c_set_0.setValue(new String("http://kalio.net/empweb/schema/calendar/v1"));
    int _jspx_eval_c_set_0 = _jspx_th_c_set_0.doStartTag();
    if (_jspx_th_c_set_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_0);
    return false;
  }

  private boolean _jspx_meth_c_choose_0(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:choose
    org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_0 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
    _jspx_th_c_choose_0.setPageContext(_jspx_page_context);
    _jspx_th_c_choose_0.setParent(null);
    int _jspx_eval_c_choose_0 = _jspx_th_c_choose_0.doStartTag();
    if (_jspx_eval_c_choose_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_when_0(_jspx_th_c_choose_0, _jspx_page_context))
          return true;
        if (_jspx_meth_c_otherwise_0(_jspx_th_c_choose_0, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_choose_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_choose_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_0);
    return false;
  }

  private boolean _jspx_meth_c_when_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_0 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_0.setPageContext(_jspx_page_context);
    _jspx_th_c_when_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_0);
    _jspx_th_c_when_0.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${calExists['.'] != null}", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
    int _jspx_eval_c_when_0 = _jspx_th_c_when_0.doStartTag();
    if (_jspx_eval_c_when_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<error xmlns=\"http://kalio.net/empweb/schema/engineresult/v1\">\r\n");
        out.write("      <msg>\r\n");
        out.write("        <key bundle=\"core.gui\">calendar_already_exists</key>\r\n");
        out.write("        <params>\r\n");
        out.write("          <param>");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${year}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("</param>\r\n");
        out.write("        </params>\r\n");
        out.write("      </msg>\r\n");
        out.write("    </error>\r\n");
        out.write("  ");
        int evalDoAfterBody = _jspx_th_c_when_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_0);
    return false;
  }

  private boolean _jspx_meth_c_otherwise_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:otherwise
    org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_0 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
    _jspx_th_c_otherwise_0.setPageContext(_jspx_page_context);
    _jspx_th_c_otherwise_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_0);
    int _jspx_eval_c_otherwise_0 = _jspx_th_c_otherwise_0.doStartTag();
    if (_jspx_eval_c_otherwise_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_io_soap_0(_jspx_th_c_otherwise_0, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_otherwise_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_otherwise_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_0);
    return false;
  }

  private boolean _jspx_meth_io_soap_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  io:soap
    org.apache.taglibs.io.HttpSoapTag _jspx_th_io_soap_0 = (org.apache.taglibs.io.HttpSoapTag) _jspx_tagPool_io_soap_url_encoding_SOAPAction.get(org.apache.taglibs.io.HttpSoapTag.class);
    _jspx_th_io_soap_0.setPageContext(_jspx_page_context);
    _jspx_th_io_soap_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_0);
    _jspx_th_io_soap_0.setUrl((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${config['ewengine.admin_service']}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_io_soap_0.setSOAPAction("");
    _jspx_th_io_soap_0.setEncoding("UTF-8");
    int _jspx_eval_io_soap_0 = _jspx_th_io_soap_0.doStartTag();
    if (_jspx_eval_io_soap_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_io_body_0(_jspx_th_io_soap_0, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_io_soap_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_io_soap_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_io_soap_url_encoding_SOAPAction.reuse(_jspx_th_io_soap_0);
    return false;
  }

  private boolean _jspx_meth_io_body_0(javax.servlet.jsp.tagext.JspTag _jspx_th_io_soap_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  io:body
    org.apache.taglibs.io.PipeTag _jspx_th_io_body_0 = (org.apache.taglibs.io.PipeTag) _jspx_tagPool_io_body.get(org.apache.taglibs.io.PipeTag.class);
    _jspx_th_io_body_0.setPageContext(_jspx_page_context);
    _jspx_th_io_body_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_io_soap_0);
    int _jspx_eval_io_body_0 = _jspx_th_io_body_0.doStartTag();
    if (_jspx_eval_io_body_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_io_body_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_io_body_0.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_io_body_0.doInitBody();
      }
      do {
        out.write("<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"\r\n");
        out.write("          xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"\r\n");
        out.write("          xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">\r\n");
        out.write("          <soapenv:Body>\r\n");
        out.write("            <saveCalendar xmlns=\"http://kalio.net/empweb/engine/admin/v1\">\r\n");
        out.write("             <calendarParam xmlns=\"http://kalio.net/empweb/schema/calendar/v1\">\r\n");
        out.write("              <calendar xmlns=\"http://kalio.net/empweb/schema/calendar/v1\" >\r\n");
        out.write("               <year value=\"");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${year}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("\">\r\n");
        out.write("                </year>\r\n");
        out.write("              </calendar>\r\n");
        out.write("             </calendarParam>\r\n");
        out.write("            </saveCalendar>\r\n");
        out.write("          </soapenv:Body>\r\n");
        out.write("        </soapenv:Envelope>\r\n");
        out.write("      ");
        int evalDoAfterBody = _jspx_th_io_body_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_io_body_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_io_body_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_io_body.reuse(_jspx_th_io_body_0);
    return false;
  }
}
