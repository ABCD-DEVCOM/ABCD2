package org.apache.jsp.tag.web.admin;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import org.w3c.dom.*;
import org.apache.commons.jxpath.*;
import java.util.*;
import net.kalio.xml.KalioXMLUtil;

public final class savePipeline_tag
    extends javax.servlet.jsp.tagext.SimpleTagSupport
    implements org.apache.jasper.runtime.JspSourceDependent {


static private org.apache.jasper.runtime.ProtectedFunctionMapper _jspx_fnmap_0;

static {
  _jspx_fnmap_0= org.apache.jasper.runtime.ProtectedFunctionMapper.getMapForFunction("fn:trim", org.apache.taglibs.standard.functions.Functions.class, "trim", new Class[] {java.lang.String.class});
}

  private static java.util.Vector _jspx_dependants;

  static {
    _jspx_dependants = new java.util.Vector(2);
    _jspx_dependants.add("/WEB-INF/tags/admin/getPipeline.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/outXml.tag");
  }

  private JspContext jspContext;
  private java.io.Writer _jspx_sout;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_io_soap_url_encoding_SOAPAction;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_x_parse_varDom;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_value_target_property_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_if_test;
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
  private java.lang.String name;

  public java.lang.String getName() {
    return this.name;
  }

  public void setName(java.lang.String name) {
    this.name = name;
  }

  public java.util.List getDependants() {
    return _jspx_dependants;
  }

  private void _jspInit(ServletConfig config) {
    _jspx_tagPool_io_soap_url_encoding_SOAPAction = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_x_parse_varDom = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_set_value_target_property_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_if_test = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_io_body = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
  }

  public void _jspDestroy() {
    _jspx_tagPool_io_soap_url_encoding_SOAPAction.release();
    _jspx_tagPool_x_parse_varDom.release();
    _jspx_tagPool_c_set_value_target_property_nobody.release();
    _jspx_tagPool_c_if_test.release();
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
    if( getName() != null ) 
      _jspx_page_context.setAttribute("name", getName());

    try {

    try {

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
          if (_jspx_meth_x_parse_0(_jspx_th_io_soap_0, _jspx_page_context))
            return;
          java.util.HashMap nsm = null;
          synchronized (_jspx_page_context) {
            nsm = (java.util.HashMap) _jspx_page_context.getAttribute("nsm", PageContext.PAGE_SCOPE);
            if (nsm == null){
              nsm = new java.util.HashMap();
              _jspx_page_context.setAttribute("nsm", nsm, PageContext.PAGE_SCOPE);
            }
          }
          if (_jspx_meth_c_set_0(_jspx_th_io_soap_0, _jspx_page_context))
            return;
          if (_jspx_meth_c_if_0(_jspx_th_io_soap_0, _jspx_page_context))
            return;

// add environment
String pipeName = (String)jspContext.getAttribute("name");
Document pipeDom = (Document)jspContext.getAttribute("pipe");
JXPathContext jx = JXPathContext.newContext(pipeDom);
jx.setLenient(true);
jx.registerNamespace("t", "http://kalio.net/empweb/schema/transaction/v1");
Node transNode = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']")).getNode();
Node oldEnv = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/t:environment")).getNode();

Document envDom = (Document)jspContext.getAttribute("env");
if (envDom != null) {
    Element envElement = envDom.getDocumentElement();
    Node newEnv = pipeDom.importNode(envElement,true);

    if (oldEnv != null) {
        oldEnv.getParentNode().replaceChild(newEnv, oldEnv);
    } else {
        // env node shall be the first child.
        if (transNode.getFirstChild() != null) {
            transNode.insertBefore(newEnv, transNode.getFirstChild());
        } else {
            transNode.appendChild(newEnv);
        }
    }
} else {
    // if envDom is empty, remove oldEnv if it exists.
    if (oldEnv != null) {
        oldEnv.getParentNode().removeChild(oldEnv);
    }
}

// enable/disable process and rules
HashMap enabledMap = new HashMap();
for (Iterator e = request.getParameterMap().keySet().iterator(); e.hasNext() ; ) {
  String thisKey = (String) e.next();
  if ( thisKey.startsWith("enabled_") ) {
      enabledMap.put(thisKey.substring(8), "true");
  }
}


Iterator it = jx.iteratePointers("//t:transaction/t:process | //t:transaction/t:rule | //t:transaction/t:finally"); //pipeName+"']/t:*/@name");
while(it.hasNext()) {
    Pointer elPoint=        (Pointer)it.next();
    JXPathContext procCtx=  jx.getRelativeContext(elPoint);
    String procName=        (String)procCtx.getValue("@name");
    String elementName=     (String)procCtx.getValue("name()");

    if ( enabledMap.get(procName) != null ) {
        jx.removePath("//t:transaction/t:"+elementName+"[@name='"+procName+"']/@enabled");
    } else {
        jx.createPathAndSetValue("//t:transaction/t:"+elementName+"[@name='"+procName+"']/@enabled", "false");
    }
}


// cleanup namespaces
// pipeDom = KalioXMLUtil.cleanupPrefixes(pipeDom.getDocumentElement()).getOwnerDocument();

// publish to the world!
jspContext.setAttribute("pipe", pipeDom);


          if (_jspx_meth_io_body_0(_jspx_th_io_soap_0, _jspx_page_context))
            return;
          int evalDoAfterBody = _jspx_th_io_soap_0.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_io_soap_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        throw new SkipPageException();
      _jspx_tagPool_io_soap_url_encoding_SOAPAction.reuse(_jspx_th_io_soap_0);


    } catch (Exception e) {

      e.printStackTrace();

      out.write("<error xmlns=\"http://kalio.net/empweb/schema/engineresult/v1\">\r\n");
      out.write("  <msg>\r\n");
      out.write("    <key bundle=\"core.gui\">error_processing_savepipeline</key>\r\n");
      out.write("    <params>\r\n");
      out.write("      <param>");
      out.print(e.toString());
      out.write("</param>\r\n");
      out.write("    </params>\r\n");
      out.write("  </msg>\r\n");
      out.write("</error>\r\n");
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
      _jspDestroy();
    }
  }

  private boolean _jspx_meth_x_parse_0(javax.servlet.jsp.tagext.JspTag _jspx_th_io_soap_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_0 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_0.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_io_soap_0);
    _jspx_th_x_parse_0.setVarDom("pipe");
    int _jspx_eval_x_parse_0 = _jspx_th_x_parse_0.doStartTag();
    if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_0.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_0.doInitBody();
      }
      do {
        if (_jspx_meth_admin_getPipeline_0(_jspx_th_x_parse_0, _jspx_page_context))
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

  private boolean _jspx_meth_admin_getPipeline_0(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  admin:getPipeline
    org.apache.jsp.tag.web.admin.getPipeline_tag _jspx_th_admin_getPipeline_0 = new org.apache.jsp.tag.web.admin.getPipeline_tag();
    _jspx_th_admin_getPipeline_0.setJspContext(_jspx_page_context);
    _jspx_th_admin_getPipeline_0.setParent(_jspx_th_x_parse_0);
    _jspx_th_admin_getPipeline_0.setName((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${name}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_admin_getPipeline_0.doTag();
    return false;
  }

  private boolean _jspx_meth_c_set_0(javax.servlet.jsp.tagext.JspTag _jspx_th_io_soap_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_0 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_0.setPageContext(_jspx_page_context);
    _jspx_th_c_set_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_io_soap_0);
    _jspx_th_c_set_0.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_0.setProperty("t");
    _jspx_th_c_set_0.setValue(new String("http://kalio.net/empweb/schema/transaction/v1"));
    int _jspx_eval_c_set_0 = _jspx_th_c_set_0.doStartTag();
    if (_jspx_th_c_set_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_0);
    return false;
  }

  private boolean _jspx_meth_c_if_0(javax.servlet.jsp.tagext.JspTag _jspx_th_io_soap_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_0 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_0.setPageContext(_jspx_page_context);
    _jspx_th_c_if_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_io_soap_0);
    _jspx_th_c_if_0.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty fn:trim(param.environment_xml)}", java.lang.Boolean.class, (PageContext)this.getJspContext(), _jspx_fnmap_0, false)).booleanValue());
    int _jspx_eval_c_if_0 = _jspx_th_c_if_0.doStartTag();
    if (_jspx_eval_c_if_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_x_parse_1(_jspx_th_c_if_0, _jspx_page_context))
          return true;
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

  private boolean _jspx_meth_x_parse_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_1 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_1.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_0);
    _jspx_th_x_parse_1.setVarDom("env");
    int _jspx_eval_x_parse_1 = _jspx_th_x_parse_1.doStartTag();
    if (_jspx_eval_x_parse_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_1 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_1.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_1.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(param.environment_xml)}", java.lang.String.class, (PageContext)this.getJspContext(), _jspx_fnmap_0, false));
        int evalDoAfterBody = _jspx_th_x_parse_1.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_x_parse_1 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_x_parse_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_x_parse_varDom.reuse(_jspx_th_x_parse_1);
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
        out.write("      xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"\r\n");
        out.write("      xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">\r\n");
        out.write("      <soapenv:Body>\r\n");
        out.write("        <savePipeline xmlns=\"http://kalio.net/empweb/engine/admin/v1\" >\r\n");
        out.write("          <pipelineParam>\r\n");
        if (_jspx_meth_jxp_outXml_0(_jspx_th_io_body_0, _jspx_page_context))
          return true;
        out.write("</pipelineParam>\r\n");
        out.write("        </savePipeline>\r\n");
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

  private boolean _jspx_meth_jxp_outXml_0(javax.servlet.jsp.tagext.JspTag _jspx_th_io_body_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  jxp:outXml
    org.apache.jsp.tag.web.commons.jxp.outXml_tag _jspx_th_jxp_outXml_0 = new org.apache.jsp.tag.web.commons.jxp.outXml_tag();
    _jspx_th_jxp_outXml_0.setJspContext(_jspx_page_context);
    _jspx_th_jxp_outXml_0.setParent(_jspx_th_io_body_0);
    _jspx_th_jxp_outXml_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${pipe}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_jxp_outXml_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_jxp_outXml_0.setSelect("//t:transaction");
    _jspx_th_jxp_outXml_0.doTag();
    return false;
  }
}
