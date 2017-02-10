package org.apache.jsp.tag.web.admin;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import java.util.*;

public final class saveProfile_tag
    extends javax.servlet.jsp.tagext.SimpleTagSupport
    implements org.apache.jasper.runtime.JspSourceDependent {


  private static java.util.Vector _jspx_dependants;

  static {
    _jspx_dependants = new java.util.Vector(2);
    _jspx_dependants.add("/WEB-INF/tags/admin/getProfile.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/set.tag");
  }

  private JspContext jspContext;
  private java.io.Writer _jspx_sout;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_value_target_property_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_x_parse_varDom;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_var_value_nobody;
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

  public java.util.List getDependants() {
    return _jspx_dependants;
  }

  private void _jspInit(ServletConfig config) {
    _jspx_tagPool_c_set_value_target_property_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_x_parse_varDom = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_set_var_value_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_io_soap_url_encoding_SOAPAction = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_io_body = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
  }

  public void _jspDestroy() {
    _jspx_tagPool_c_set_value_target_property_nobody.release();
    _jspx_tagPool_x_parse_varDom.release();
    _jspx_tagPool_c_set_var_value_nobody.release();
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
      if (_jspx_meth_x_parse_0(_jspx_page_context))
        return;
      //  jxp:set
      org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_0 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
      java.util.HashMap _jspx_th_jxp_set_0_aliasMap = new java.util.HashMap();
      _jspx_th_jxp_set_0_aliasMap.put("punt", "profPtr");
      _jspx_th_jxp_set_0.setJspContext(_jspx_page_context, _jspx_th_jxp_set_0_aliasMap);
      _jspx_th_jxp_set_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${getProfileDoc}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
      _jspx_th_jxp_set_0.setVar("profPtr");
      _jspx_th_jxp_set_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
      _jspx_th_jxp_set_0.setSelect("//pr:profile");
      _jspx_th_jxp_set_0.doTag();
      if (_jspx_meth_c_set_1(_jspx_page_context))
        return;
      java.lang.String xmlSend = null;
      synchronized (request) {
        xmlSend = (java.lang.String) _jspx_page_context.getAttribute("xmlSend", PageContext.REQUEST_SCOPE);
        if (xmlSend == null){
          xmlSend = new java.lang.String();
          _jspx_page_context.setAttribute("xmlSend", xmlSend, PageContext.REQUEST_SCOPE);
        }
      }

  for (Iterator e = request.getParameterMap().keySet().iterator(); e.hasNext(); )
    {
      String thisKey = (String) e.next();

      // IMPORTANT: HTTP parameters for the limits must start with limit_ followed by the name of the limit
      if (thisKey.startsWith("limit_"))
        { // BBBBB @todo if the parameter is empty, don't store it!!!
          String limitName = thisKey.substring(6);
          String limitVal = ((String[]) request.getParameterMap().get(thisKey))[0];
          xmlSend = xmlSend
              + "    <limit name='"+limitName+"'>\n"
              + "       <value>"+limitVal.trim()+"</value>\n"
              + "     </limit>\n";
        }
    }
  // put back the value of the string to the attribute bean xmlSend
  request.setAttribute("xmlSend", xmlSend);

      if (_jspx_meth_io_soap_0(_jspx_page_context))
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

  private boolean _jspx_meth_c_set_0(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_0 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_0.setPageContext(_jspx_page_context);
    _jspx_th_c_set_0.setParent(null);
    _jspx_th_c_set_0.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_0.setProperty("pr");
    _jspx_th_c_set_0.setValue(new String("http://kalio.net/empweb/schema/profile/v1"));
    int _jspx_eval_c_set_0 = _jspx_th_c_set_0.doStartTag();
    if (_jspx_th_c_set_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_0);
    return false;
  }

  private boolean _jspx_meth_x_parse_0(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_0 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_0.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_0.setParent(null);
    _jspx_th_x_parse_0.setVarDom("getProfileDoc");
    int _jspx_eval_x_parse_0 = _jspx_th_x_parse_0.doStartTag();
    if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_0.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_0.doInitBody();
      }
      do {
        if (_jspx_meth_admin_getProfile_0(_jspx_th_x_parse_0, _jspx_page_context))
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

  private boolean _jspx_meth_admin_getProfile_0(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  admin:getProfile
    org.apache.jsp.tag.web.admin.getProfile_tag _jspx_th_admin_getProfile_0 = new org.apache.jsp.tag.web.admin.getProfile_tag();
    _jspx_th_admin_getProfile_0.setJspContext(_jspx_page_context);
    _jspx_th_admin_getProfile_0.setParent(_jspx_th_x_parse_0);
    _jspx_th_admin_getProfile_0.setId((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.profile_id}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_admin_getProfile_0.doTag();
    return false;
  }

  private boolean _jspx_meth_c_set_1(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_1 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_1.setPageContext(_jspx_page_context);
    _jspx_th_c_set_1.setParent(null);
    _jspx_th_c_set_1.setVar("policyId");
    _jspx_th_c_set_1.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ empty profPtr['pr:policy'] ? param.policy_id : profPtr['pr:policy']}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    int _jspx_eval_c_set_1 = _jspx_th_c_set_1.doStartTag();
    if (_jspx_th_c_set_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var_value_nobody.reuse(_jspx_th_c_set_1);
    return false;
  }

  private boolean _jspx_meth_io_soap_0(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  io:soap
    org.apache.taglibs.io.HttpSoapTag _jspx_th_io_soap_0 = (org.apache.taglibs.io.HttpSoapTag) _jspx_tagPool_io_soap_url_encoding_SOAPAction.get(org.apache.taglibs.io.HttpSoapTag.class);
    _jspx_th_io_soap_0.setPageContext(_jspx_page_context);
    _jspx_th_io_soap_0.setParent(null);
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
        out.write("<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n");
        out.write("      <soapenv:Body>\r\n");
        out.write("        <saveProfile xmlns=\"http://kalio.net/empweb/engine/admin/v1\">\r\n");
        out.write("          <profileParam>\r\n");
        out.write("            <profile id=\"");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.profile_id}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("\" xmlns=\"http://kalio.net/empweb/schema/profile/v1\">\r\n");
        out.write("              <userClass>");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.user_class}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("</userClass>\r\n");
        out.write("              <objectCategory>");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.object_category}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("</objectCategory>\r\n");
        out.write("              <policy>");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${policyId}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("</policy>\r\n");
        out.write("              <limits>");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${xmlSend}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("</limits>\r\n");
        out.write("            </profile>\r\n");
        out.write("          </profileParam>\r\n");
        out.write("        </saveProfile>\r\n");
        out.write("      </soapenv:Body>\r\n");
        out.write("    </soapenv:Envelope>\r\n");
        out.write("  ");
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
