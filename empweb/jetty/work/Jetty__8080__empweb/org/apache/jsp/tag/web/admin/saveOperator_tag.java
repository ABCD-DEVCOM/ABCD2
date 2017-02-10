package org.apache.jsp.tag.web.admin;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import java.util.*;
import net.kalio.auth.*;

public final class saveOperator_tag
    extends javax.servlet.jsp.tagext.SimpleTagSupport
    implements org.apache.jasper.runtime.JspSourceDependent {


  private static java.util.Vector _jspx_dependants;

  private JspContext jspContext;
  private java.io.Writer _jspx_sout;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_message_key;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_param_value_nobody;
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
  private java.lang.String id;

  public java.lang.String getId() {
    return this.id;
  }

  public void setId(java.lang.String id) {
    this.id = id;
  }

  public java.util.List getDependants() {
    return _jspx_dependants;
  }

  private void _jspInit(ServletConfig config) {
    _jspx_tagPool_fmt_message_key = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_fmt_param_value_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_fmt_message_key_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
  }

  public void _jspDestroy() {
    _jspx_tagPool_fmt_message_key.release();
    _jspx_tagPool_fmt_param_value_nobody.release();
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
    if( getId() != null ) 
      _jspx_page_context.setAttribute("id", getId());

    try {

Auth.setAuthPath( System.getProperty("empweb.home", "/") +
                  application.getInitParameter("net.kalio.auth.location"));

// prepare data
HashMap userdata = new HashMap(4);
userdata.put("username", request.getParameter("name"));
userdata.put("email", request.getParameter("email"));

// keep old password if not changed (BBB are we checking this in edit_operator???)
String pass = request.getParameter("password1");
if ((pass != null) && (pass.length() > 0))
    userdata.put("password", request.getParameter("password1"));
else {
    HashMap olddata = Auth.getUserProperties(id);
    String oldpass = (String)olddata.get("password");
    userdata.put("password", oldpass);
}


HashMap usergroups = new HashMap(30);
String groups[] = Auth.getGroups();
Map allparams = request.getParameterMap();

for (int i=0; i < groups.length; i++) {
    if ( allparams.get("group-"+groups[i]) != null ){
      usergroups.put(groups[i], "true");
    }
}

HashMap userprops = new HashMap(5);
Iterator ip = allparams.keySet().iterator();
String key;
String val;
while (ip.hasNext()) {
    key = (String)ip.next();
    if (key.matches("property-(.*)")) {
        val = request.getParameter(key);
        try {
            //val = new String(val.getBytes(), encoding);  // TODO: no puede ser que tenga que hacer esto!
            userprops.put( key.replaceFirst("property-",""), val);
        } catch(Exception ex) {
            System.err.println(ex);
            ex.printStackTrace();
        }
    }
}

// save operator data
String result = Auth.saveUser(id, userdata, usergroups, userprops);
getJspContext().setAttribute("resultkey", result);

//TODO: actualzar datos de session si me estoy editando a mi mismo :)

if ("".equals(result)) {

      out.write("<p>\r\n");
      out.write("  ");
      if (_jspx_meth_fmt_message_0(_jspx_page_context))
        return;
      out.write("</p>\r\n");

     } else {

      out.write('<');
      out.write('p');
      out.write('>');
      if (_jspx_meth_fmt_message_1(_jspx_page_context))
        return;
      out.write(": <strong>");
      if (_jspx_meth_fmt_message_2(_jspx_page_context))
        return;
      out.write("</strong></p>\r\n");

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

  private boolean _jspx_meth_fmt_message_0(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_0 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_0.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_0.setParent(null);
    _jspx_th_fmt_message_0.setKey("save_operator_succeeded");
    int _jspx_eval_fmt_message_0 = _jspx_th_fmt_message_0.doStartTag();
    if (_jspx_eval_fmt_message_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_fmt_message_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_fmt_message_0.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_fmt_message_0.doInitBody();
      }
      do {
        if (_jspx_meth_fmt_param_0(_jspx_th_fmt_message_0, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_fmt_message_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_fmt_message_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_fmt_message_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key.reuse(_jspx_th_fmt_message_0);
    return false;
  }

  private boolean _jspx_meth_fmt_param_0(javax.servlet.jsp.tagext.JspTag _jspx_th_fmt_message_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:param
    org.apache.taglibs.standard.tag.rt.fmt.ParamTag _jspx_th_fmt_param_0 = (org.apache.taglibs.standard.tag.rt.fmt.ParamTag) _jspx_tagPool_fmt_param_value_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.ParamTag.class);
    _jspx_th_fmt_param_0.setPageContext(_jspx_page_context);
    _jspx_th_fmt_param_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_fmt_message_0);
    _jspx_th_fmt_param_0.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${id}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    int _jspx_eval_fmt_param_0 = _jspx_th_fmt_param_0.doStartTag();
    if (_jspx_th_fmt_param_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_param_value_nobody.reuse(_jspx_th_fmt_param_0);
    return false;
  }

  private boolean _jspx_meth_fmt_message_1(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_1 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_1.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_1.setParent(null);
    _jspx_th_fmt_message_1.setKey("save_operator_failed");
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
    _jspx_th_fmt_message_2.setKey((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${resultkey}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
    int _jspx_eval_fmt_message_2 = _jspx_th_fmt_message_2.doStartTag();
    if (_jspx_th_fmt_message_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_2);
    return false;
  }
}
