package org.apache.jsp.tag.web.trans;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;

public final class renewalSingle_tag
    extends javax.servlet.jsp.tagext.SimpleTagSupport
    implements org.apache.jasper.runtime.JspSourceDependent {


  private static java.util.Vector _jspx_dependants;

  static {
    _jspx_dependants = new java.util.Vector(1);
    _jspx_dependants.add("/WEB-INF/tags/commons/util/fixUserId.tag");
  }

  private JspContext jspContext;
  private java.io.Writer _jspx_sout;
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
  private java.lang.String userId;
  private java.lang.String copyId;
  private java.lang.String userDb;
  private java.lang.String objectDb;

  public java.lang.String getUserId() {
    return this.userId;
  }

  public void setUserId(java.lang.String userId) {
    this.userId = userId;
  }

  public java.lang.String getCopyId() {
    return this.copyId;
  }

  public void setCopyId(java.lang.String copyId) {
    this.copyId = copyId;
  }

  public java.lang.String getUserDb() {
    return this.userDb;
  }

  public void setUserDb(java.lang.String userDb) {
    this.userDb = userDb;
  }

  public java.lang.String getObjectDb() {
    return this.objectDb;
  }

  public void setObjectDb(java.lang.String objectDb) {
    this.objectDb = objectDb;
  }

  public java.util.List getDependants() {
    return _jspx_dependants;
  }

  private void _jspInit(ServletConfig config) {
    _jspx_tagPool_io_soap_url_encoding_SOAPAction = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_io_body = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
  }

  public void _jspDestroy() {
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
    if( getUserId() != null ) 
      _jspx_page_context.setAttribute("userId", getUserId());
    if( getCopyId() != null ) 
      _jspx_page_context.setAttribute("copyId", getCopyId());
    if( getUserDb() != null ) 
      _jspx_page_context.setAttribute("userDb", getUserDb());
    if( getObjectDb() != null ) 
      _jspx_page_context.setAttribute("objectDb", getObjectDb());

    try {
      //  io:soap
      org.apache.taglibs.io.HttpSoapTag _jspx_th_io_soap_0 = (org.apache.taglibs.io.HttpSoapTag) _jspx_tagPool_io_soap_url_encoding_SOAPAction.get(org.apache.taglibs.io.HttpSoapTag.class);
      _jspx_th_io_soap_0.setPageContext(_jspx_page_context);
      _jspx_th_io_soap_0.setParent(null);
      _jspx_th_io_soap_0.setUrl((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${config['ewengine.trans_service']}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
      _jspx_th_io_soap_0.setSOAPAction("");
      _jspx_th_io_soap_0.setEncoding("UTF-8");
      int _jspx_eval_io_soap_0 = _jspx_th_io_soap_0.doStartTag();
      if (_jspx_eval_io_soap_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
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
              out.write("        <renewalSingle xmlns=\"http://kalio.net/empweb/engine/trans/v1\">\r\n");
              out.write("          <userId>");
              if (_jspx_meth_util_fixUserId_0(_jspx_th_io_body_0, _jspx_page_context))
                return;
              out.write("</userId>\r\n");
              out.write("          <copyId>");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${copyId}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              out.write("</copyId>\r\n");
              out.write("          <userDb>");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userDb}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              out.write("</userDb>\r\n");
              out.write("          <objectDb>");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${objectDb}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              out.write("</objectDb>\r\n");
              out.write("          <transactionExtras>\r\n");
              out.write("            <params>\r\n");
              out.write("              <param name=\"operatorLocation\">");
              out.print(session.getAttribute("library"));
              out.write("</param>\r\n");
              out.write("              <param name=\"operatorId\">");
              out.print(session.getAttribute("user"));
              out.write("</param>\r\n");
              out.write("              <param name=\"desktopOrWS\">desktop</param>\r\n");
              out.write("            </params>\r\n");
              out.write("          </transactionExtras>\r\n");
              out.write("        </renewalSingle>\r\n");
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
          int evalDoAfterBody = _jspx_th_io_soap_0.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_io_soap_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        throw new SkipPageException();
      _jspx_tagPool_io_soap_url_encoding_SOAPAction.reuse(_jspx_th_io_soap_0);
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

  private boolean _jspx_meth_util_fixUserId_0(javax.servlet.jsp.tagext.JspTag _jspx_th_io_body_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  util:fixUserId
    org.apache.jsp.tag.web.commons.util.fixUserId_tag _jspx_th_util_fixUserId_0 = new org.apache.jsp.tag.web.commons.util.fixUserId_tag();
    _jspx_th_util_fixUserId_0.setJspContext(_jspx_page_context);
    _jspx_th_util_fixUserId_0.setParent(_jspx_th_io_body_0);
    _jspx_th_util_fixUserId_0.setJspBody(new renewalSingle_tagHelper( 0, _jspx_page_context, _jspx_th_util_fixUserId_0, null));
    _jspx_th_util_fixUserId_0.doTag();
    return false;
  }

  private class renewalSingle_tagHelper
      extends org.apache.jasper.runtime.JspFragmentHelper
  {
    private javax.servlet.jsp.tagext.JspTag _jspx_parent;
    private int[] _jspx_push_body_count;

    public renewalSingle_tagHelper( int discriminator, JspContext jspContext, javax.servlet.jsp.tagext.JspTag _jspx_parent, int[] _jspx_push_body_count ) {
      super( discriminator, jspContext, _jspx_parent );
      this._jspx_parent = _jspx_parent;
      this._jspx_push_body_count = _jspx_push_body_count;
    }
    public boolean invoke0( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userId}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
      return false;
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
