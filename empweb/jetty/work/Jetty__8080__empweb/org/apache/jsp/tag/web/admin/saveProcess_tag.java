package org.apache.jsp.tag.web.admin;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import org.w3c.dom.*;
import org.apache.commons.jxpath.*;
import java.util.*;
import net.kalio.xml.KalioXMLUtil;

public final class saveProcess_tag
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
  private java.lang.String processName;
  private java.lang.String pipelineName;

  public java.lang.String getProcessName() {
    return this.processName;
  }

  public void setProcessName(java.lang.String processName) {
    this.processName = processName;
  }

  public java.lang.String getPipelineName() {
    return this.pipelineName;
  }

  public void setPipelineName(java.lang.String pipelineName) {
    this.pipelineName = pipelineName;
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
    if( getProcessName() != null ) 
      _jspx_page_context.setAttribute("processName", getProcessName());
    if( getPipelineName() != null ) 
      _jspx_page_context.setAttribute("pipelineName", getPipelineName());

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
          if (_jspx_meth_c_if_1(_jspx_th_io_soap_0, _jspx_page_context))
            return;
          if (_jspx_meth_c_if_2(_jspx_th_io_soap_0, _jspx_page_context))
            return;

String procName = (String)jspContext.getAttribute("processName");
String pipeName = (String)jspContext.getAttribute("pipelineName");
Document pipeDom = (Document)jspContext.getAttribute("pipe");
JXPathContext jx = JXPathContext.newContext(pipeDom);
jx.setLenient(true);
jx.registerNamespace("t", "http://kalio.net/empweb/schema/transaction/v1");
Node procNode = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']")).getNode();
Node oldDoc = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']/t:doc")).getNode();
Node oldLim = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']/t:limits")).getNode();
Node oldPar = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']/t:params")).getNode();

// replace doc
Document docDom = (Document)jspContext.getAttribute("doc");
if (docDom != null) {
    Element docElement = docDom.getDocumentElement();
    Node newDoc = pipeDom.importNode(docElement,true);

    if (oldDoc != null) {
	oldDoc.getParentNode().replaceChild(newDoc, oldDoc);
    } else {
	// doc node shall be the first child after the enter (text ndode)
        if (procNode.getFirstChild() != null) {
            Node insertPos = procNode.getFirstChild();
            if (insertPos.getNodeType() == Node.TEXT_NODE)
                insertPos = insertPos.getNextSibling();
            if  (insertPos.getNodeType() == Node.COMMENT_NODE)
                insertPos = insertPos.getNextSibling();
            procNode.insertBefore(newDoc, insertPos);
        } else {
            procNode.appendChild(newDoc);
        }
    }
} else {
    // docDom is empty, but oldDoc exists, so remove oldDoc
    if (oldDoc != null) {
	procNode.removeChild(oldDoc);
    }
}

// replace limits
Document limDom = (Document)jspContext.getAttribute("limits");
if (limDom != null) {
    Element limElement = limDom.getDocumentElement();
    Node newLim = pipeDom.importNode(limElement,true);

    if (oldLim != null) {
        oldLim.getParentNode().replaceChild(newLim, oldLim);
    } else {
        Node theDoc = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']/t:doc")).getNode();
        if (theDoc != null)
            procNode.insertBefore(newLim, theDoc.getNextSibling());
        else if (procNode.getFirstChild() != null) {
            Node insertPos = procNode.getFirstChild();
            if (insertPos.getNodeType() == Node.TEXT_NODE)
                insertPos = insertPos.getNextSibling();
            if  (insertPos.getNodeType() == Node.COMMENT_NODE)
                insertPos = insertPos.getNextSibling();
            procNode.insertBefore(newLim, insertPos);
        } else {
            procNode.appendChild(newLim);
        }
    }
} else {
    // limDom is empty, but oldLim exists, so remove oldLim
    if (oldLim != null) {
        procNode.removeChild(oldLim);
    }
}

// replace params
Document parDom = (Document)jspContext.getAttribute("params");
if (parDom != null) {
    Element parElement = parDom.getDocumentElement();
    Node newPar = pipeDom.importNode(parElement,true);

    if (oldPar != null) {
        oldPar.getParentNode().replaceChild(newPar, oldPar);
    } else {
        // par node shall be the third
        Node theDoc = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']/t:doc")).getNode();
        Node lims = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']/t:limits")).getNode();
        if (lims != null)
            procNode.insertBefore(newPar, lims.getNextSibling());
        else if (theDoc != null)
            procNode.insertBefore(newPar, theDoc.getNextSibling());
        else if (procNode.getFirstChild() != null) {
            Node insertPos = procNode.getFirstChild();
            if (insertPos.getNodeType() == Node.TEXT_NODE)
                insertPos = insertPos.getNextSibling();
            if  (insertPos.getNodeType() == Node.COMMENT_NODE)
                insertPos = insertPos.getNextSibling();
            procNode.insertBefore(newPar, insertPos);
        } else {
            procNode.appendChild(newPar);
        }
    }
} else {
    // parDom is empty, but oldPar exists, so remove oldPar
    if (oldPar != null) {
        procNode.removeChild(oldPar);
    }
}

// cleanup namespaces  TODO: BBB Esto??
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
      out.write("<error xmlns=\"http://kalio.net/empweb/schema/engineresult/v1\">\r\n");
      out.write("  <msg>\r\n");
      out.write("    <key bundle=\"core.gui\">error_processing_saveprocess</key>\r\n");
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
    _jspx_th_admin_getPipeline_0.setName((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${pipelineName}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
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
    _jspx_th_c_if_0.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty fn:trim(param.doc_xml)}", java.lang.Boolean.class, (PageContext)this.getJspContext(), _jspx_fnmap_0, false)).booleanValue());
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
    _jspx_th_x_parse_1.setVarDom("doc");
    int _jspx_eval_x_parse_1 = _jspx_th_x_parse_1.doStartTag();
    if (_jspx_eval_x_parse_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_1 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_1.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_1.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(param.doc_xml)}", java.lang.String.class, (PageContext)this.getJspContext(), _jspx_fnmap_0, false));
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

  private boolean _jspx_meth_c_if_1(javax.servlet.jsp.tagext.JspTag _jspx_th_io_soap_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_1 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_1.setPageContext(_jspx_page_context);
    _jspx_th_c_if_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_io_soap_0);
    _jspx_th_c_if_1.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty fn:trim(param.limits_xml)}", java.lang.Boolean.class, (PageContext)this.getJspContext(), _jspx_fnmap_0, false)).booleanValue());
    int _jspx_eval_c_if_1 = _jspx_th_c_if_1.doStartTag();
    if (_jspx_eval_c_if_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_x_parse_2(_jspx_th_c_if_1, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_if_1.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_1);
    return false;
  }

  private boolean _jspx_meth_x_parse_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_2 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_2.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_1);
    _jspx_th_x_parse_2.setVarDom("limits");
    int _jspx_eval_x_parse_2 = _jspx_th_x_parse_2.doStartTag();
    if (_jspx_eval_x_parse_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_2 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_2.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_2.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(param.limits_xml)}", java.lang.String.class, (PageContext)this.getJspContext(), _jspx_fnmap_0, false));
        int evalDoAfterBody = _jspx_th_x_parse_2.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_x_parse_2 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_x_parse_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_x_parse_varDom.reuse(_jspx_th_x_parse_2);
    return false;
  }

  private boolean _jspx_meth_c_if_2(javax.servlet.jsp.tagext.JspTag _jspx_th_io_soap_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_2 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_2.setPageContext(_jspx_page_context);
    _jspx_th_c_if_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_io_soap_0);
    _jspx_th_c_if_2.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty fn:trim(param.params_xml)}", java.lang.Boolean.class, (PageContext)this.getJspContext(), _jspx_fnmap_0, false)).booleanValue());
    int _jspx_eval_c_if_2 = _jspx_th_c_if_2.doStartTag();
    if (_jspx_eval_c_if_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_x_parse_3(_jspx_th_c_if_2, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_if_2.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_2);
    return false;
  }

  private boolean _jspx_meth_x_parse_3(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_3 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_3.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_2);
    _jspx_th_x_parse_3.setVarDom("params");
    int _jspx_eval_x_parse_3 = _jspx_th_x_parse_3.doStartTag();
    if (_jspx_eval_x_parse_3 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_3 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_3.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_3.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(param.params_xml)}", java.lang.String.class, (PageContext)this.getJspContext(), _jspx_fnmap_0, false));
        int evalDoAfterBody = _jspx_th_x_parse_3.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_x_parse_3 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_x_parse_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_x_parse_varDom.reuse(_jspx_th_x_parse_3);
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
        out.write("            ");
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
