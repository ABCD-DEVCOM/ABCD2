package org.apache.jsp.trans.query;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import java.util.Locale;
import java.util.Properties;
import java.util.regex.*;
import java.util.*;
import java.util.Locale;
import java.util.regex.*;
import java.util.Hashtable;
import java.util.Enumeration;

public final class user_005fstatus_005fresult_jsp extends org.apache.jasper.runtime.HttpJspBase
    implements org.apache.jasper.runtime.JspSourceDependent {

static private org.apache.jasper.runtime.ProtectedFunctionMapper _jspx_fnmap_0;
static private org.apache.jasper.runtime.ProtectedFunctionMapper _jspx_fnmap_1;
static private org.apache.jasper.runtime.ProtectedFunctionMapper _jspx_fnmap_2;
static private org.apache.jasper.runtime.ProtectedFunctionMapper _jspx_fnmap_3;

static {
  _jspx_fnmap_0= org.apache.jasper.runtime.ProtectedFunctionMapper.getMapForFunction("fn:split", org.apache.taglibs.standard.functions.Functions.class, "split", new Class[] {java.lang.String.class, java.lang.String.class});
  _jspx_fnmap_1= org.apache.jasper.runtime.ProtectedFunctionMapper.getMapForFunction("fn:substring", org.apache.taglibs.standard.functions.Functions.class, "substring", new Class[] {java.lang.String.class, int.class, int.class});
  _jspx_fnmap_2= org.apache.jasper.runtime.ProtectedFunctionMapper.getMapForFunction("fn:trim", org.apache.taglibs.standard.functions.Functions.class, "trim", new Class[] {java.lang.String.class});
  _jspx_fnmap_3= org.apache.jasper.runtime.ProtectedFunctionMapper.getMapForFunction("fn:escapeXml", org.apache.taglibs.standard.functions.Functions.class, "escapeXml", new Class[] {java.lang.String.class});
}

  private static java.util.Vector _jspx_dependants;

  static {
    _jspx_dependants = new java.util.Vector(23);
    _jspx_dependants.add("/doctype.jspf");
    _jspx_dependants.add("/userlocale.jspf");
    _jspx_dependants.add("/dochead.jspf");
    _jspx_dependants.add("/institution.jspf");
    _jspx_dependants.add("/infobar.jspf");
    _jspx_dependants.add("/websbar.jspf");
    _jspx_dependants.add("/navbar.jspf");
    _jspx_dependants.add("/coda.jspf");
    _jspx_dependants.add("/WEB-INF/tags/commons/util/formatDate.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/util/parseDate.tag");
    _jspx_dependants.add("/WEB-INF/tags/trans/searchUsersById.tag");
    _jspx_dependants.add("/WEB-INF/tags/trans/getUserStatus.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/util/fixUserId.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/set.tag");
    _jspx_dependants.add("/WEB-INF/tags/display/user.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/util/isLate.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/out.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/forEach.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/util/isExpired.tag");
    _jspx_dependants.add("/WEB-INF/tags/trans/doTransaction.tag");
    _jspx_dependants.add("/WEB-INF/tags/display/formatAmount.tag");
    _jspx_dependants.add("/WEB-INF/tags/trans/searchObjectsById.tag");
    _jspx_dependants.add("/WEB-INF/tags/trans/searchObjects.tag");
  }

  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_setLocale_value_scope_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_setBundle_scope_basename_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_message_key_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_url_value_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_if_test;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_forEach_var_items;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_value_target_property_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_var_value_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_var;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_choose;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_when_test;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_x_parse_varDom;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_redirect_url_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_otherwise;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_formatNumber;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_io_request_url_nobody;

  public java.util.List getDependants() {
    return _jspx_dependants;
  }

  public void _jspInit() {
    _jspx_tagPool_fmt_setLocale_value_scope_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_fmt_setBundle_scope_basename_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_fmt_message_key_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_url_value_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_if_test = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_forEach_var_items = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_set_value_target_property_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_set_var_value_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_set_var = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_choose = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_when_test = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_x_parse_varDom = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_redirect_url_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_otherwise = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_fmt_formatNumber = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_io_request_url_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
  }

  public void _jspDestroy() {
    _jspx_tagPool_fmt_setLocale_value_scope_nobody.release();
    _jspx_tagPool_fmt_setBundle_scope_basename_nobody.release();
    _jspx_tagPool_fmt_message_key_nobody.release();
    _jspx_tagPool_c_url_value_nobody.release();
    _jspx_tagPool_c_if_test.release();
    _jspx_tagPool_c_forEach_var_items.release();
    _jspx_tagPool_c_set_value_target_property_nobody.release();
    _jspx_tagPool_c_set_var_value_nobody.release();
    _jspx_tagPool_c_set_var.release();
    _jspx_tagPool_c_choose.release();
    _jspx_tagPool_c_when_test.release();
    _jspx_tagPool_x_parse_varDom.release();
    _jspx_tagPool_c_redirect_url_nobody.release();
    _jspx_tagPool_c_otherwise.release();
    _jspx_tagPool_fmt_formatNumber.release();
    _jspx_tagPool_io_request_url_nobody.release();
  }

  public void _jspService(HttpServletRequest request, HttpServletResponse response)
        throws java.io.IOException, ServletException {

    JspFactory _jspxFactory = null;
    PageContext pageContext = null;
    HttpSession session = null;
    ServletContext application = null;
    ServletConfig config = null;
    JspWriter out = null;
    Object page = this;
    JspWriter _jspx_out = null;
    PageContext _jspx_page_context = null;


    try {
      _jspxFactory = JspFactory.getDefaultFactory();
      response.setContentType("text/html; charset=UTF-8");
      pageContext = _jspxFactory.getPageContext(this, request, response,
      			null, true, 8192, true);
      _jspx_page_context = pageContext;
      application = pageContext.getServletContext();
      config = pageContext.getServletConfig();
      session = pageContext.getSession();
      out = pageContext.getOut();
      _jspx_out = out;

      out.write("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3c.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">");

String defaultLang = "es";
String origLang = request.getParameter("origLang");
String reqLang = request.getParameter("lang");
Properties props = (Properties)getServletContext().getAttribute("config");
Locale sessLocale= (Locale) session.getAttribute("userLocale");

String lang;

/* origLang: to return to the original language when a session times out */
//System.err.println("\n\n\n\n\n============================= ");
//System.err.println("origLang: #"+origLang+"#");
//System.err.println("reqLang: #"+reqLang+"#");
//System.err.println("props: #"+props+"#");
//System.err.println("sessLocale: #"+sessLocale+"#");
//System.err.println("=============================");

if ( (origLang != null) && (origLang.length() > 0) ) {
    lang = origLang;
} else if ( (reqLang != null) && (reqLang.length() > 0) ) {
    lang = reqLang;
} else  if (sessLocale != null) {
    lang = sessLocale.getLanguage();
    if (sessLocale.getCountry() != null) { 
      lang += "_"+sessLocale.getCountry();
      if (sessLocale.getVariant() != null) {
        lang += "_"+sessLocale.getVariant();
      }
    }
} else if ( (props != null) && (props.getProperty("gui.default_locale") != null) ){
    lang = (String)props.getProperty("gui.default_locale");
} else {
    lang = defaultLang;
}

String[] localeParams = lang.split("[-_]");
if (localeParams.length == 3) 
  session.setAttribute("userLocale", new Locale(localeParams[0],localeParams[1],localeParams[2]));
else if (localeParams.length == 2) 
  session.setAttribute("userLocale", new Locale(localeParams[0],localeParams[1]));
else if (localeParams.length == 1) 
  session.setAttribute("userLocale", new Locale(localeParams[0]));
else 
  session.setAttribute("userLocale", new Locale(lang));


/* get title from url */
String path = (String) request.getServletPath();
Pattern p = Pattern.compile("/([^/]+)/([^/]+)(/[^/]+)*");
Matcher m = p.matcher(path);
String activeweb = m.matches()?m.group(1):"";
String activetab = m.matches()?m.group(2):"";


String absoluteContext = request.getRequestURI();
absoluteContext = absoluteContext.substring(0,absoluteContext.length()-path.length());
/* these variables can be used to create absolute urls automatically */
session.setAttribute("absoluteContext",absoluteContext);
session.setAttribute("resources",absoluteContext+"/resources");

      if (_jspx_meth_fmt_setLocale_0(_jspx_page_context))
        return;
      if (_jspx_meth_fmt_setBundle_0(_jspx_page_context))
        return;
      out.write("<html>\n");
      out.write("  <head>\n");
      out.write("    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n");
      out.write("    <title>");
      //  fmt:message
      org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_0 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
      _jspx_th_fmt_message_0.setPageContext(_jspx_page_context);
      _jspx_th_fmt_message_0.setParent(null);
      _jspx_th_fmt_message_0.setKey( activeweb );
      int _jspx_eval_fmt_message_0 = _jspx_th_fmt_message_0.doStartTag();
      if (_jspx_th_fmt_message_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_0);
      out.write(" &lt; ");
      if (_jspx_meth_fmt_message_1(_jspx_page_context))
        return;
      out.write(' ');
      out.write('|');
      out.write(' ');
      if (_jspx_meth_fmt_message_2(_jspx_page_context))
        return;
      out.write("</title>\n");
      out.write("    <!--<style type=\"text/css\"media=\"all\">@import \"compositepage.css\"; </style>\n");
      out.write("    <style type=\"text/css\"media=\"all\">@import \"local.css\"; </style>-->\n");
      out.write("    \n");
      out.write("    <style type=\"text/css\"media=\"all\">@import \"template.css\"; </style>\n");
      out.write("\n");
      out.write("    <script language=\"Javascript\" type=\"text/javascript\" src=\"disableEnterInForms.js\"></script>\n");
      out.write("    <script language=\"Javascript\" type=\"text/javascript\">\n");
      out.write("       // register disableEnterInForms patch.\n");
      out.write("       window.onload = fixEnterKey;\n");
      out.write("    </script>\n");
      out.write("  </head>\n");
      out.write("\n");
      out.write("  <body>\n");
      out.write("<div class=\"heading\">\n");
      out.write(" \n");
      out.write("\t\t\t<div class=\"institutionalInfo\">\n");
      out.write("\t\t\t  <div id=\"parent\">\n");
      out.write("\t\t\t  <img alt=\"ABCD\" src=\"logoABCD.gif\"/>\n");
      out.write("\t\t\t  </div>\n");
      out.write("\t\t\t  <div id=\"identification\">\n");
      out.write("\t\t\t\t<h1>BIREME - Centro Latino Americano e do Caribe de Informação em Ciências da Saúde</h1>\n");
      out.write("\t\t\t\t<h2>ABCD - Empweb plug-in</h2>\n");
      out.write("\t\t\t\t</div>\n");
      out.write("\t\t\t</div>\n");
      out.write("\n");
      out.write("\t\t\t<div class=\"userInfo\">\n");
      out.write("\n");
      out.write("    ");
 
      if (session.getAttribute("library")!=null)
      {
      
    
      out.write("<strong>");
      if (_jspx_meth_fmt_message_3(_jspx_page_context))
        return;
      out.write(": </strong>");
      out.print(session.getAttribute("library"));
      out.write("\n");
      out.write("    (<a href=\"");
      if (_jspx_meth_c_url_0(_jspx_page_context))
        return;
      out.write('"');
      out.write('>');
      if (_jspx_meth_fmt_message_4(_jspx_page_context))
        return;
      out.write("</a>)  |  \n");
      out.write("    <strong>");
      if (_jspx_meth_fmt_message_5(_jspx_page_context))
        return;
      out.write(": </strong>");
      out.print(session.getAttribute("username"));
      out.write("<a class=\"button_logout\" href=\"");
      if (_jspx_meth_c_url_1(_jspx_page_context))
        return;
      out.write('"');
      out.write('>');
      out.write('(');
      if (_jspx_meth_fmt_message_6(_jspx_page_context))
        return;
      out.write(")</a>\n");
      out.write("\n");
      out.write("    <p>\t\n");
      out.write("\t  \n");
      out.write("    ");
      if (_jspx_meth_c_if_0(_jspx_page_context))
        return;
 } 
      out.write("</div>\n");
      out.write("\t\t\t<div class=\"spacer\">&#160;</div>\n");
      out.write("\t\t</div>\n");
      out.write("\n");
      out.write("<div id=\"infobar\">\r\n");
      out.write("  <div id=\"operator\">\r\n");
      out.write("    \r\n");
      out.write("    </div>\r\n");
      out.write("</div>\r\n");

// NOTES:
// activeweb and activetab are defined in dochead.jspf

// tabs
LinkedHashMap webs = new LinkedHashMap();
webs.put("home",  new String[] {} );
webs.put("trans", new String[] {"query", "wait","loan","renewal","return", "suspension", "fine"} );
webs.put("admin", new String[] {"status","policies","exceptions","calendar","pipelines","operators","bases"} );
webs.put("stats", new String[] {"status","globalstatus", "historic"} );


      out.write("<div class=\"sectionInfo\">\r\n");
      out.write("\t\t\t<div class=\"breadcrumb\">\r\n");
      out.write("\r\n");
      out.write("\t\t\t</div>\r\n");
      out.write("\r\n");
      out.write("<div class=\"actions\">\r\n");

  for (Iterator e = webs.keySet().iterator() ; e.hasNext() ; ) {
    String thisWeb = (String) e.next();
    if ( session.getAttribute("group-"+thisWeb) != null)  {
      if (thisWeb.equals(activeweb)) {

      out.write("<a href=\"");
      //  c:url
      org.apache.taglibs.standard.tag.rt.core.UrlTag _jspx_th_c_url_3 = (org.apache.taglibs.standard.tag.rt.core.UrlTag) _jspx_tagPool_c_url_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.UrlTag.class);
      _jspx_th_c_url_3.setPageContext(_jspx_page_context);
      _jspx_th_c_url_3.setParent(null);
      _jspx_th_c_url_3.setValue( "/" + thisWeb + "/index.jsp" );
      int _jspx_eval_c_url_3 = _jspx_th_c_url_3.doStartTag();
      if (_jspx_th_c_url_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_c_url_value_nobody.reuse(_jspx_th_c_url_3);
      out.write("\">\r\n");
      out.write("            <strong>");
      //  fmt:message
      org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_8 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
      _jspx_th_fmt_message_8.setPageContext(_jspx_page_context);
      _jspx_th_fmt_message_8.setParent(null);
      _jspx_th_fmt_message_8.setKey( thisWeb );
      int _jspx_eval_fmt_message_8 = _jspx_th_fmt_message_8.doStartTag();
      if (_jspx_th_fmt_message_8.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_8);
      out.write("</strong>\r\n");
      out.write("          </a>\r\n");
      out.write("  ");

      } else {
  
      out.write("<a href=\"");
      //  c:url
      org.apache.taglibs.standard.tag.rt.core.UrlTag _jspx_th_c_url_4 = (org.apache.taglibs.standard.tag.rt.core.UrlTag) _jspx_tagPool_c_url_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.UrlTag.class);
      _jspx_th_c_url_4.setPageContext(_jspx_page_context);
      _jspx_th_c_url_4.setParent(null);
      _jspx_th_c_url_4.setValue( "/" + thisWeb + "/index.jsp" );
      int _jspx_eval_c_url_4 = _jspx_th_c_url_4.doStartTag();
      if (_jspx_th_c_url_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_c_url_value_nobody.reuse(_jspx_th_c_url_4);
      out.write("\">\r\n");
      out.write("            <strong>");
      //  fmt:message
      org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_9 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
      _jspx_th_fmt_message_9.setPageContext(_jspx_page_context);
      _jspx_th_fmt_message_9.setParent(null);
      _jspx_th_fmt_message_9.setKey( thisWeb );
      int _jspx_eval_fmt_message_9 = _jspx_th_fmt_message_9.doStartTag();
      if (_jspx_th_fmt_message_9.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_9);
      out.write("</strong>\r\n");
      out.write("          </a>\r\n");

        }
      } 
      
      if (e.hasNext())
      {
        
      out.write("\r\n");
      out.write("        \r\n");
      out.write("        |\r\n");
      out.write("      \r\n");
      out.write("    ");
  }
      
  } // for

      out.write("<div class=\"spacer\">&#160;</div>\r\n");
      out.write("</div>\r\n");
      out.write("<div class=\"spacer\">&#160;</div>\r\n");
      out.write("</div>\r\n");
      out.write("\r\n");
      out.write("<div class=\"helpersimg\">\n");

String[] tabs = (String[]) webs.get(activeweb);
for (int i=0; i<tabs.length; i++) {
    if (session.getAttribute("group-"+activeweb+"-"+tabs[i]) != null ) {
        if (tabs[i].equals(activetab)) {


         } else {


         }

      out.write("<a class=\"misactions\" href=\"");
      //  c:url
      org.apache.taglibs.standard.tag.rt.core.UrlTag _jspx_th_c_url_5 = (org.apache.taglibs.standard.tag.rt.core.UrlTag) _jspx_tagPool_c_url_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.UrlTag.class);
      _jspx_th_c_url_5.setPageContext(_jspx_page_context);
      _jspx_th_c_url_5.setParent(null);
      _jspx_th_c_url_5.setValue( "/" + activeweb + "/" + tabs[i] + "/index.jsp" );
      int _jspx_eval_c_url_5 = _jspx_th_c_url_5.doStartTag();
      if (_jspx_th_c_url_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_c_url_value_nobody.reuse(_jspx_th_c_url_5);
      out.write("\">\n");
      out.write("        ");
      //  fmt:message
      org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_10 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
      _jspx_th_fmt_message_10.setPageContext(_jspx_page_context);
      _jspx_th_fmt_message_10.setParent(null);
      _jspx_th_fmt_message_10.setKey( tabs[i] );
      int _jspx_eval_fmt_message_10 = _jspx_th_fmt_message_10.doStartTag();
      if (_jspx_th_fmt_message_10.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_10);
      out.write("</a>\n");
      out.write("    \n");
      out.write("      ");

      if (i+1<tabs.length)
      {
        
      out.write("\n");
      out.write("        \n");
      out.write("        |\n");
      out.write("      \n");

     }
   }
} // for

      out.write("</div>\n");
      out.write("<?xml version=\"1.0\"?><!--\n");
      out.write("\n");
      out.write("-->\n");
      out.write("\n");
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
      if (_jspx_meth_c_set_1(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_2(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_3(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_4(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_5(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_6(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_7(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_8(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_9(_jspx_page_context))
        return;
      java.lang.String user_id = null;
      synchronized (_jspx_page_context) {
        user_id = (java.lang.String) _jspx_page_context.getAttribute("user_id", PageContext.PAGE_SCOPE);
        if (user_id == null){
          user_id = new java.lang.String();
          _jspx_page_context.setAttribute("user_id", user_id, PageContext.PAGE_SCOPE);
        }
      }
      if (_jspx_meth_c_set_10(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_11(_jspx_page_context))
        return;
      java.util.Date now = null;
      synchronized (_jspx_page_context) {
        now = (java.util.Date) _jspx_page_context.getAttribute("now", PageContext.PAGE_SCOPE);
        if (now == null){
          now = new java.util.Date();
          _jspx_page_context.setAttribute("now", now, PageContext.PAGE_SCOPE);
        }
      }
      if (_jspx_meth_c_set_12(_jspx_page_context))
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
          _jspx_th_c_when_0.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty user_id}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
          int _jspx_eval_c_when_0 = _jspx_th_c_when_0.doStartTag();
          if (_jspx_eval_c_when_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
            do {
              if (_jspx_meth_x_parse_0(_jspx_th_c_when_0, _jspx_page_context))
                return;
              if (_jspx_meth_x_parse_1(_jspx_th_c_when_0, _jspx_page_context))
                return;
              //  jxp:set
              org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_0 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
              java.util.HashMap _jspx_th_jxp_set_0_aliasMap = new java.util.HashMap();
              _jspx_th_jxp_set_0_aliasMap.put("punt", "userCount");
              _jspx_th_jxp_set_0.setJspContext(_jspx_page_context, _jspx_th_jxp_set_0_aliasMap);
              _jspx_th_jxp_set_0.setParent(_jspx_th_c_when_0);
              _jspx_th_jxp_set_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userInfoResult}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
              _jspx_th_jxp_set_0.setVar("userCount");
              _jspx_th_jxp_set_0.setSelect("count(//uinfo:userCollection/uinfo:user)");
              _jspx_th_jxp_set_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
              _jspx_th_jxp_set_0.doTag();
              if (_jspx_meth_c_if_1(_jspx_th_c_when_0, _jspx_page_context))
                return;
              int evalDoAfterBody = _jspx_th_c_when_0.doAfterBody();
              if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                break;
            } while (true);
          }
          if (_jspx_th_c_when_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
            return;
          _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_0);
          if (_jspx_meth_c_otherwise_0(_jspx_th_c_choose_0, _jspx_page_context))
            return;
          int evalDoAfterBody = _jspx_th_c_choose_0.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_choose_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_0);
      out.write("<div class=\"middle homepage\">\n");
      out.write("  <!-- USER INFO -->\n");
      out.write("  <h2>");
      if (_jspx_meth_fmt_message_11(_jspx_page_context))
        return;
      out.write("</h2>\n");
      out.write("\n");
      out.write("  <div>\n");
      out.write("    ");
      //  jxp:set
      org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_1 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
      java.util.HashMap _jspx_th_jxp_set_1_aliasMap = new java.util.HashMap();
      _jspx_th_jxp_set_1_aliasMap.put("punt", "userInfo");
      _jspx_th_jxp_set_1.setJspContext(_jspx_page_context, _jspx_th_jxp_set_1_aliasMap);
      _jspx_th_jxp_set_1.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userInfoResult}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_set_1.setVar("userInfo");
      _jspx_th_jxp_set_1.setSelect("//uinfo:userCollection");
      _jspx_th_jxp_set_1.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_set_1.doTag();
      if (_jspx_meth_c_choose_1(_jspx_page_context))
        return;
      out.write("</div>\n");
      out.write("\n");
      out.write("\n");
      out.write("  <div style=\"float:left; \">\n");
      out.write("    <!-- USER STATUS -->\n");
      out.write("    <!-- <h2>");
      if (_jspx_meth_fmt_message_13(_jspx_page_context))
        return;
      out.write("</h2> -->\n");
      out.write("    ");
      //  jxp:set
      org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_2 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
      java.util.HashMap _jspx_th_jxp_set_2_aliasMap = new java.util.HashMap();
      _jspx_th_jxp_set_2_aliasMap.put("punt", "userStatus");
      _jspx_th_jxp_set_2.setJspContext(_jspx_page_context, _jspx_th_jxp_set_2_aliasMap);
      _jspx_th_jxp_set_2.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatusResult}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_set_2.setVar("userStatus");
      _jspx_th_jxp_set_2.setSelect("//ustat:userStatus");
      _jspx_th_jxp_set_2.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_set_2.doTag();
      out.write("<!-- user status summary -->\n");
      out.write("    <table id=\"result\">\n");
      out.write("      <tr><td><strong>");
      if (_jspx_meth_fmt_message_14(_jspx_page_context))
        return;
      out.write("</strong></td></tr>\n");
      out.write("      <!-- administrative suspensions -->\n");
      out.write("      ");
      if (_jspx_meth_c_if_2(_jspx_page_context))
        return;
      out.write("<!-- suspensions -->\n");
      out.write("      ");
      //  c:if
      org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_3 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
      _jspx_th_c_if_3.setPageContext(_jspx_page_context);
      _jspx_th_c_if_3.setParent(null);
      _jspx_th_c_if_3.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(userStatus['s:suspensions/s:suspension'] != null)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
      int _jspx_eval_c_if_3 = _jspx_th_c_if_3.doStartTag();
      if (_jspx_eval_c_if_3 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
          if (_jspx_meth_c_set_13(_jspx_th_c_if_3, _jspx_page_context))
            return;
          //  jxp:forEach
          org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_0 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
          java.util.HashMap _jspx_th_jxp_forEach_0_aliasMap = new java.util.HashMap();
          _jspx_th_jxp_forEach_0_aliasMap.put("punt", "ptr");
          _jspx_th_jxp_forEach_0.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_0_aliasMap);
          _jspx_th_jxp_forEach_0.setParent(_jspx_th_c_if_3);
          _jspx_th_jxp_forEach_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatus}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_0.setVar("ptr");
          _jspx_th_jxp_forEach_0.setSelect("s:suspensions/s:suspension");
          _jspx_th_jxp_forEach_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_0.setJspBody(new user_005fstatus_005fresult_jspHelper( 1, _jspx_page_context, _jspx_th_jxp_forEach_0, null));
          _jspx_th_jxp_forEach_0.doTag();
          if (_jspx_meth_c_if_5(_jspx_th_c_if_3, _jspx_page_context))
            return;
          int evalDoAfterBody = _jspx_th_c_if_3.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_if_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_3);
      out.write("<!-- fines -->\n");
      out.write("      ");
      if (_jspx_meth_c_if_6(_jspx_page_context))
        return;
      out.write("<!-- administrative fines -->\n");
      out.write("      ");
      if (_jspx_meth_c_if_7(_jspx_page_context))
        return;
      out.write("<!-- waits -->\n");
      out.write("      ");
      if (_jspx_meth_c_if_8(_jspx_page_context))
        return;
      out.write("<!-- reservations -->\n");
      out.write("      ");
      if (_jspx_meth_c_if_9(_jspx_page_context))
        return;
      out.write("<!-- loans -->\n");
      out.write("      ");
      if (_jspx_meth_c_if_10(_jspx_page_context))
        return;
      out.write("</table>\n");
      out.write("  </div>\n");
      out.write("\n");
      out.write("\n");
      out.write("  ");
      out.write("<div style=\"float:left; margin-left:30px;\">\n");
      out.write("    ");
      if (_jspx_meth_x_parse_2(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_15(_jspx_page_context))
        return;
      out.write("<table>\n");
      out.write("      <tr>\n");
      out.write("        <td><strong>");
      if (_jspx_meth_fmt_message_22(_jspx_page_context))
        return;
      out.write("</strong></td>\n");
      out.write("      </tr>\n");
      out.write("      <tr>\n");
      out.write("        <td><a href=\"");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${historic_href}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;report_name=loansByUser\">");
      if (_jspx_meth_fmt_message_23(_jspx_page_context))
        return;
      out.write("</a></td>\n");
      out.write("        <td>");
      if (_jspx_meth_jxp_out_6(_jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("      </tr>\n");
      out.write("<tr>\n");
      out.write("        <td><a href=\"");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${historic_href}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;report_name=finesByUser\">");
      if (_jspx_meth_fmt_message_24(_jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("        <td>");
      if (_jspx_meth_jxp_out_7(_jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("      </tr>\n");
      out.write("      <tr>\n");
      out.write("        <td><a href=\"");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${historic_href}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;report_name=suspensionsByUser\">");
      if (_jspx_meth_fmt_message_25(_jspx_page_context))
        return;
      out.write("</a></td>\n");
      out.write("        <td>");
      if (_jspx_meth_jxp_out_8(_jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("      </tr>\n");
      out.write("    </table>\n");
      out.write("  </div>\n");
      out.write("\n");
      out.write("\n");
      out.write("\n");
      out.write("  <div style=\"clear:both\">\n");
      out.write("    <!-- ACTIONS -->\n");
      out.write("    <h3>");
      if (_jspx_meth_fmt_message_26(_jspx_page_context))
        return;
      out.write(":</h3>\n");
      out.write("    <p>\n");
      out.write("      <a href=\"../loan/index.jsp?user_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_id}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;user_db=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_db}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("\">\n");
      out.write("        ");
      if (_jspx_meth_fmt_message_27(_jspx_page_context))
        return;
      out.write("</a> |\n");
      out.write("      <a href=\"../fine/create/index.jsp?user_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_id}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;user_db=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_db}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("\">\n");
      out.write("        ");
      if (_jspx_meth_fmt_message_28(_jspx_page_context))
        return;
      out.write("</a> |\n");
      out.write("      <a href=\"../suspension/create/index.jsp?user_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_id}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;user_db=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_db}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("\">\n");
      out.write("        ");
      if (_jspx_meth_fmt_message_29(_jspx_page_context))
        return;
      out.write("</a>\n");
      out.write("    </p>\n");
      out.write("  </div>\n");
      out.write("\n");
      out.write("  <!-- DETAILED USER STATUS -->\n");
      out.write("  <div id=\"detailed_info\" style=\"display:block;\">\n");
      out.write("\n");
      out.write("    <h2>");
      if (_jspx_meth_fmt_message_30(_jspx_page_context))
        return;
      out.write("</h2>\n");
      out.write("\n");
      out.write("    <!-- suspensions -->\n");
      out.write("    ");
      //  c:if
      org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_11 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
      _jspx_th_c_if_11.setPageContext(_jspx_page_context);
      _jspx_th_c_if_11.setParent(null);
      _jspx_th_c_if_11.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(userStatus['s:suspensions/s:suspension'] != null) or (userInfo['uinfo:user/uinfo:extension/s:suspensions/s:suspension'] != null)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
      int _jspx_eval_c_if_11 = _jspx_th_c_if_11.doStartTag();
      if (_jspx_eval_c_if_11 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
          out.write("<h3><a name=\"suspensions\"/>");
          if (_jspx_meth_fmt_message_31(_jspx_th_c_if_11, _jspx_page_context))
            return;
          out.write("</h3>\n");
          out.write("      <table id=\"result\" width=\"90%\">\n");
          out.write("        <tr>\n");
          out.write("          <th>");
          if (_jspx_meth_fmt_message_32(_jspx_th_c_if_11, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          <th>");
          if (_jspx_meth_fmt_message_33(_jspx_th_c_if_11, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          <th>");
          if (_jspx_meth_fmt_message_34(_jspx_th_c_if_11, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          <th>");
          if (_jspx_meth_fmt_message_35(_jspx_th_c_if_11, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          <th>");
          if (_jspx_meth_fmt_message_36(_jspx_th_c_if_11, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          <th>");
          if (_jspx_meth_fmt_message_37(_jspx_th_c_if_11, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          <th>");
          if (_jspx_meth_fmt_message_38(_jspx_th_c_if_11, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          <th>");
          if (_jspx_meth_fmt_message_39(_jspx_th_c_if_11, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("        </tr>\n");
          out.write("        <!-- administrative suspensions -->\n");
          out.write("        ");
          //  jxp:forEach
          org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_1 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
          java.util.HashMap _jspx_th_jxp_forEach_1_aliasMap = new java.util.HashMap();
          _jspx_th_jxp_forEach_1_aliasMap.put("punt", "ptr");
          _jspx_th_jxp_forEach_1.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_1_aliasMap);
          _jspx_th_jxp_forEach_1.setParent(_jspx_th_c_if_11);
          _jspx_th_jxp_forEach_1.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userInfo}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_1.setVar("ptr");
          _jspx_th_jxp_forEach_1.setSelect("uinfo:user/uinfo:extension/s:suspensions/s:suspension");
          _jspx_th_jxp_forEach_1.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_1.setJspBody(new user_005fstatus_005fresult_jspHelper( 4, _jspx_page_context, _jspx_th_jxp_forEach_1, null));
          _jspx_th_jxp_forEach_1.doTag();
          out.write("<!-- transactional suspensions -->\n");
          out.write("        ");
          //  jxp:forEach
          org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_2 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
          java.util.HashMap _jspx_th_jxp_forEach_2_aliasMap = new java.util.HashMap();
          _jspx_th_jxp_forEach_2_aliasMap.put("punt", "ptr");
          _jspx_th_jxp_forEach_2.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_2_aliasMap);
          _jspx_th_jxp_forEach_2.setParent(_jspx_th_c_if_11);
          _jspx_th_jxp_forEach_2.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatus}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_2.setVar("ptr");
          _jspx_th_jxp_forEach_2.setSelect("s:suspensions/s:suspension");
          _jspx_th_jxp_forEach_2.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_2.setJspBody(new user_005fstatus_005fresult_jspHelper( 6, _jspx_page_context, _jspx_th_jxp_forEach_2, null));
          _jspx_th_jxp_forEach_2.doTag();
          out.write("</table>\n");
          out.write("    ");
          int evalDoAfterBody = _jspx_th_c_if_11.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_if_11.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_11);
      out.write("<!-- fines -->\n");
      out.write("    ");
      //  c:if
      org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_13 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
      _jspx_th_c_if_13.setPageContext(_jspx_page_context);
      _jspx_th_c_if_13.setParent(null);
      _jspx_th_c_if_13.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(userStatus['f:fines/f:fine'] != null) or (userInfo['uinfo:user/uinfo:extension/f:fines/f:fine'] != null)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
      int _jspx_eval_c_if_13 = _jspx_th_c_if_13.doStartTag();
      if (_jspx_eval_c_if_13 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
          out.write("<h3><a name=\"fines\"/>");
          if (_jspx_meth_fmt_message_42(_jspx_th_c_if_13, _jspx_page_context))
            return;
          out.write("</h3>\n");
          out.write("      <table id=\"result\" width=\"90%\">\n");
          out.write("        <tr>\n");
          out.write("          <th>");
          if (_jspx_meth_fmt_message_43(_jspx_th_c_if_13, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          <th>");
          if (_jspx_meth_fmt_message_44(_jspx_th_c_if_13, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          <th>");
          if (_jspx_meth_fmt_message_45(_jspx_th_c_if_13, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          <th>");
          if (_jspx_meth_fmt_message_46(_jspx_th_c_if_13, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          <th>");
          if (_jspx_meth_fmt_message_47(_jspx_th_c_if_13, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          <th>");
          if (_jspx_meth_fmt_message_48(_jspx_th_c_if_13, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("        </tr>\n");
          out.write("\n");
          out.write("          <!-- administrative fines -->\n");
          out.write("          ");
          //  jxp:forEach
          org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_3 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
          java.util.HashMap _jspx_th_jxp_forEach_3_aliasMap = new java.util.HashMap();
          _jspx_th_jxp_forEach_3_aliasMap.put("punt", "ptr");
          _jspx_th_jxp_forEach_3.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_3_aliasMap);
          _jspx_th_jxp_forEach_3.setParent(_jspx_th_c_if_13);
          _jspx_th_jxp_forEach_3.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userInfo}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_3.setVar("ptr");
          _jspx_th_jxp_forEach_3.setSelect("uinfo:user/uinfo:extension/f:fines/f:fine");
          _jspx_th_jxp_forEach_3.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_3.setJspBody(new user_005fstatus_005fresult_jspHelper( 11, _jspx_page_context, _jspx_th_jxp_forEach_3, null));
          _jspx_th_jxp_forEach_3.doTag();
          out.write("<!-- transactional fines -->\n");
          out.write("          ");
          //  jxp:forEach
          org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_4 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
          java.util.HashMap _jspx_th_jxp_forEach_4_aliasMap = new java.util.HashMap();
          _jspx_th_jxp_forEach_4_aliasMap.put("punt", "ptr");
          _jspx_th_jxp_forEach_4.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_4_aliasMap);
          _jspx_th_jxp_forEach_4.setParent(_jspx_th_c_if_13);
          _jspx_th_jxp_forEach_4.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatus}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_4.setVar("ptr");
          _jspx_th_jxp_forEach_4.setSelect("f:fines/f:fine");
          _jspx_th_jxp_forEach_4.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_4.setJspBody(new user_005fstatus_005fresult_jspHelper( 13, _jspx_page_context, _jspx_th_jxp_forEach_4, null));
          _jspx_th_jxp_forEach_4.doTag();
          out.write("</table>\n");
          out.write("      ");
          int evalDoAfterBody = _jspx_th_c_if_13.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_if_13.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_13);
      out.write("<!-- waits -->\n");
      out.write("      ");
      //  c:if
      org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_14 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
      _jspx_th_c_if_14.setPageContext(_jspx_page_context);
      _jspx_th_c_if_14.setParent(null);
      _jspx_th_c_if_14.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatus['w:waits/w:wait'] != null}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
      int _jspx_eval_c_if_14 = _jspx_th_c_if_14.doStartTag();
      if (_jspx_eval_c_if_14 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
          out.write("<h3><a name=\"waits\"/>");
          if (_jspx_meth_fmt_message_51(_jspx_th_c_if_14, _jspx_page_context))
            return;
          out.write("</h3>\n");
          out.write("        <table id=\"result\" width=\"90%\">\n");
          out.write("          <tr>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_52(_jspx_th_c_if_14, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_53(_jspx_th_c_if_14, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_54(_jspx_th_c_if_14, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_55(_jspx_th_c_if_14, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_56(_jspx_th_c_if_14, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_57(_jspx_th_c_if_14, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_58(_jspx_th_c_if_14, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_59(_jspx_th_c_if_14, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          </tr>\n");
          out.write("\n");
          out.write("          ");
          //  jxp:forEach
          org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_5 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
          java.util.HashMap _jspx_th_jxp_forEach_5_aliasMap = new java.util.HashMap();
          _jspx_th_jxp_forEach_5_aliasMap.put("punt", "ptr");
          _jspx_th_jxp_forEach_5.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_5_aliasMap);
          _jspx_th_jxp_forEach_5.setParent(_jspx_th_c_if_14);
          _jspx_th_jxp_forEach_5.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatus}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_5.setVar("ptr");
          _jspx_th_jxp_forEach_5.setSelect("w:waits/w:wait");
          _jspx_th_jxp_forEach_5.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_5.setJspBody(new user_005fstatus_005fresult_jspHelper( 16, _jspx_page_context, _jspx_th_jxp_forEach_5, null));
          _jspx_th_jxp_forEach_5.doTag();
          out.write("</table>\n");
          out.write("      ");
          int evalDoAfterBody = _jspx_th_c_if_14.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_if_14.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_14);
      out.write("<!-- waits -->\n");
      out.write("\n");
      out.write("\n");
      out.write("      <!-- reservations -->\n");
      out.write("      ");
      //  c:if
      org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_16 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
      _jspx_th_c_if_16.setPageContext(_jspx_page_context);
      _jspx_th_c_if_16.setParent(null);
      _jspx_th_c_if_16.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatus['r:reservations/r:reservation'] != null}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
      int _jspx_eval_c_if_16 = _jspx_th_c_if_16.doStartTag();
      if (_jspx_eval_c_if_16 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
          out.write("<h3><a name=\"reservations\"/>");
          if (_jspx_meth_fmt_message_62(_jspx_th_c_if_16, _jspx_page_context))
            return;
          out.write("</h3>\n");
          out.write("        <table id=\"result\">\n");
          out.write("          <tr>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_63(_jspx_th_c_if_16, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_64(_jspx_th_c_if_16, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_65(_jspx_th_c_if_16, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_66(_jspx_th_c_if_16, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_67(_jspx_th_c_if_16, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_68(_jspx_th_c_if_16, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_69(_jspx_th_c_if_16, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_70(_jspx_th_c_if_16, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_71(_jspx_th_c_if_16, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          </tr>\n");
          out.write("\n");
          out.write("          ");
          //  jxp:forEach
          org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_6 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
          java.util.HashMap _jspx_th_jxp_forEach_6_aliasMap = new java.util.HashMap();
          _jspx_th_jxp_forEach_6_aliasMap.put("punt", "ptr");
          _jspx_th_jxp_forEach_6.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_6_aliasMap);
          _jspx_th_jxp_forEach_6.setParent(_jspx_th_c_if_16);
          _jspx_th_jxp_forEach_6.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatus}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_6.setVar("ptr");
          _jspx_th_jxp_forEach_6.setSelect("r:reservations/r:reservation");
          _jspx_th_jxp_forEach_6.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_6.setJspBody(new user_005fstatus_005fresult_jspHelper( 21, _jspx_page_context, _jspx_th_jxp_forEach_6, null));
          _jspx_th_jxp_forEach_6.doTag();
          out.write("</table>\n");
          out.write("      ");
          int evalDoAfterBody = _jspx_th_c_if_16.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_if_16.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_16);
      out.write("<!-- reservations -->\n");
      out.write("\n");
      out.write("      <!-- loans -->\n");
      out.write("      ");
      //  c:if
      org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_19 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
      _jspx_th_c_if_19.setPageContext(_jspx_page_context);
      _jspx_th_c_if_19.setParent(null);
      _jspx_th_c_if_19.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatus['l:loans/l:loan'] != null}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
      int _jspx_eval_c_if_19 = _jspx_th_c_if_19.doStartTag();
      if (_jspx_eval_c_if_19 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
          out.write("<h3><a name=\"loans\"/>");
          if (_jspx_meth_fmt_message_74(_jspx_th_c_if_19, _jspx_page_context))
            return;
          out.write("</h3>\n");
          out.write("        <table id=\"result\" width=\"90%\">\n");
          out.write("          <tr>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_75(_jspx_th_c_if_19, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_76(_jspx_th_c_if_19, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_77(_jspx_th_c_if_19, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_78(_jspx_th_c_if_19, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_79(_jspx_th_c_if_19, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_80(_jspx_th_c_if_19, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("            <th>");
          if (_jspx_meth_fmt_message_81(_jspx_th_c_if_19, _jspx_page_context))
            return;
          out.write("</th>\n");
          out.write("          </tr>\n");
          out.write("\n");
          out.write("          ");
          //  jxp:forEach
          org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_7 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
          java.util.HashMap _jspx_th_jxp_forEach_7_aliasMap = new java.util.HashMap();
          _jspx_th_jxp_forEach_7_aliasMap.put("punt", "ptr");
          _jspx_th_jxp_forEach_7.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_7_aliasMap);
          _jspx_th_jxp_forEach_7.setParent(_jspx_th_c_if_19);
          _jspx_th_jxp_forEach_7.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatus}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_7.setVar("ptr");
          _jspx_th_jxp_forEach_7.setSelect("l:loans/l:loan");
          _jspx_th_jxp_forEach_7.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
          _jspx_th_jxp_forEach_7.setJspBody(new user_005fstatus_005fresult_jspHelper( 27, _jspx_page_context, _jspx_th_jxp_forEach_7, null));
          _jspx_th_jxp_forEach_7.doTag();
          out.write("</table>\n");
          out.write("      ");
          int evalDoAfterBody = _jspx_th_c_if_19.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_if_19.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_19);
      out.write("<!-- loans -->\n");
      out.write("    </div> <!-- detailed_info -->\n");
      out.write("    <br />\n");
      out.write("    \n");
      out.write("\n");
      out.write("</div>\n");

  request.setAttribute("abcd",System.getProperty("abcd.url", "/").concat("/what.php?action=getall"));    

      if (_jspx_meth_io_request_0(_jspx_page_context))
        return;
      out.write("</body>\r\n");
      out.write("</html>\r\n");
    } catch (Throwable t) {
      if (!(t instanceof SkipPageException)){
        out = _jspx_out;
        if (out != null && out.getBufferSize() != 0)
          out.clearBuffer();
        if (_jspx_page_context != null) _jspx_page_context.handlePageException(t);
      }
    } finally {
      if (_jspxFactory != null) _jspxFactory.releasePageContext(_jspx_page_context);
    }
  }

  private boolean _jspx_meth_fmt_setLocale_0(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:setLocale
    org.apache.taglibs.standard.tag.rt.fmt.SetLocaleTag _jspx_th_fmt_setLocale_0 = (org.apache.taglibs.standard.tag.rt.fmt.SetLocaleTag) _jspx_tagPool_fmt_setLocale_value_scope_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.SetLocaleTag.class);
    _jspx_th_fmt_setLocale_0.setPageContext(_jspx_page_context);
    _jspx_th_fmt_setLocale_0.setParent(null);
    _jspx_th_fmt_setLocale_0.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${sessionScope.userLocale}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_fmt_setLocale_0.setScope("request");
    int _jspx_eval_fmt_setLocale_0 = _jspx_th_fmt_setLocale_0.doStartTag();
    if (_jspx_th_fmt_setLocale_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_setLocale_value_scope_nobody.reuse(_jspx_th_fmt_setLocale_0);
    return false;
  }

  private boolean _jspx_meth_fmt_setBundle_0(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:setBundle
    org.apache.taglibs.standard.tag.rt.fmt.SetBundleTag _jspx_th_fmt_setBundle_0 = (org.apache.taglibs.standard.tag.rt.fmt.SetBundleTag) _jspx_tagPool_fmt_setBundle_scope_basename_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.SetBundleTag.class);
    _jspx_th_fmt_setBundle_0.setPageContext(_jspx_page_context);
    _jspx_th_fmt_setBundle_0.setParent(null);
    _jspx_th_fmt_setBundle_0.setBasename("ewi18n.core.gui");
    _jspx_th_fmt_setBundle_0.setScope("request");
    int _jspx_eval_fmt_setBundle_0 = _jspx_th_fmt_setBundle_0.doStartTag();
    if (_jspx_th_fmt_setBundle_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_setBundle_scope_basename_nobody.reuse(_jspx_th_fmt_setBundle_0);
    return false;
  }

  private boolean _jspx_meth_fmt_message_1(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_1 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_1.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_1.setParent(null);
    _jspx_th_fmt_message_1.setKey("empweb");
    int _jspx_eval_fmt_message_1 = _jspx_th_fmt_message_1.doStartTag();
    if (_jspx_th_fmt_message_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_1);
    return false;
  }

  private boolean _jspx_meth_fmt_message_2(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_2 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_2.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_2.setParent(null);
    _jspx_th_fmt_message_2.setKey("institution");
    int _jspx_eval_fmt_message_2 = _jspx_th_fmt_message_2.doStartTag();
    if (_jspx_th_fmt_message_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_2);
    return false;
  }

  private boolean _jspx_meth_fmt_message_3(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_3 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_3.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_3.setParent(null);
    _jspx_th_fmt_message_3.setKey("library");
    int _jspx_eval_fmt_message_3 = _jspx_th_fmt_message_3.doStartTag();
    if (_jspx_th_fmt_message_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_3);
    return false;
  }

  private boolean _jspx_meth_c_url_0(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:url
    org.apache.taglibs.standard.tag.rt.core.UrlTag _jspx_th_c_url_0 = (org.apache.taglibs.standard.tag.rt.core.UrlTag) _jspx_tagPool_c_url_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.UrlTag.class);
    _jspx_th_c_url_0.setPageContext(_jspx_page_context);
    _jspx_th_c_url_0.setParent(null);
    _jspx_th_c_url_0.setValue("/home/chooselibrary.jsp");
    int _jspx_eval_c_url_0 = _jspx_th_c_url_0.doStartTag();
    if (_jspx_th_c_url_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_url_value_nobody.reuse(_jspx_th_c_url_0);
    return false;
  }

  private boolean _jspx_meth_fmt_message_4(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_4 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_4.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_4.setParent(null);
    _jspx_th_fmt_message_4.setKey("change");
    int _jspx_eval_fmt_message_4 = _jspx_th_fmt_message_4.doStartTag();
    if (_jspx_th_fmt_message_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_4);
    return false;
  }

  private boolean _jspx_meth_fmt_message_5(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_5 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_5.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_5.setParent(null);
    _jspx_th_fmt_message_5.setKey("operator");
    int _jspx_eval_fmt_message_5 = _jspx_th_fmt_message_5.doStartTag();
    if (_jspx_th_fmt_message_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_5);
    return false;
  }

  private boolean _jspx_meth_c_url_1(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:url
    org.apache.taglibs.standard.tag.rt.core.UrlTag _jspx_th_c_url_1 = (org.apache.taglibs.standard.tag.rt.core.UrlTag) _jspx_tagPool_c_url_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.UrlTag.class);
    _jspx_th_c_url_1.setPageContext(_jspx_page_context);
    _jspx_th_c_url_1.setParent(null);
    _jspx_th_c_url_1.setValue("/logout.jsp");
    int _jspx_eval_c_url_1 = _jspx_th_c_url_1.doStartTag();
    if (_jspx_th_c_url_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_url_value_nobody.reuse(_jspx_th_c_url_1);
    return false;
  }

  private boolean _jspx_meth_fmt_message_6(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_6 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_6.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_6.setParent(null);
    _jspx_th_fmt_message_6.setKey("logout");
    int _jspx_eval_fmt_message_6 = _jspx_th_fmt_message_6.doStartTag();
    if (_jspx_th_fmt_message_6.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_6);
    return false;
  }

  private boolean _jspx_meth_c_if_0(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_0 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_0.setPageContext(_jspx_page_context);
    _jspx_th_c_if_0.setParent(null);
    _jspx_th_c_if_0.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not config['gui.hide_languages']}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_0 = _jspx_th_c_if_0.doStartTag();
    if (_jspx_eval_c_if_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("\n");
        out.write("      |");
        if (_jspx_meth_c_forEach_0(_jspx_th_c_if_0, _jspx_page_context))
          return true;
        out.write("&nbsp;&nbsp;\n");
        out.write("    ");
        int evalDoAfterBody = _jspx_th_c_if_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_0);
    return false;
  }

  private boolean _jspx_meth_c_forEach_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:forEach
    org.apache.taglibs.standard.tag.rt.core.ForEachTag _jspx_th_c_forEach_0 = (org.apache.taglibs.standard.tag.rt.core.ForEachTag) _jspx_tagPool_c_forEach_var_items.get(org.apache.taglibs.standard.tag.rt.core.ForEachTag.class);
    _jspx_th_c_forEach_0.setPageContext(_jspx_page_context);
    _jspx_th_c_forEach_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_0);
    _jspx_th_c_forEach_0.setItems((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:split(config['gui.languages'], ',')}", java.lang.Object.class, (PageContext)_jspx_page_context, _jspx_fnmap_0, false));
    _jspx_th_c_forEach_0.setVar("langs");
    int[] _jspx_push_body_count_c_forEach_0 = new int[] { 0 };
    try {
      int _jspx_eval_c_forEach_0 = _jspx_th_c_forEach_0.doStartTag();
      if (_jspx_eval_c_forEach_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
          out.write("<a href=\"");
          if (_jspx_meth_c_url_2(_jspx_th_c_forEach_0, _jspx_page_context, _jspx_push_body_count_c_forEach_0))
            return true;
          out.write('"');
          out.write('>');
          if (_jspx_meth_fmt_message_7(_jspx_th_c_forEach_0, _jspx_page_context, _jspx_push_body_count_c_forEach_0))
            return true;
          out.write("</a>|\n");
          out.write("      ");
          int evalDoAfterBody = _jspx_th_c_forEach_0.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_forEach_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return true;
    } catch (Throwable _jspx_exception) {
      while (_jspx_push_body_count_c_forEach_0[0]-- > 0)
        out = _jspx_page_context.popBody();
      _jspx_th_c_forEach_0.doCatch(_jspx_exception);
    } finally {
      _jspx_th_c_forEach_0.doFinally();
      _jspx_tagPool_c_forEach_var_items.reuse(_jspx_th_c_forEach_0);
    }
    return false;
  }

  private boolean _jspx_meth_c_url_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_forEach_0, PageContext _jspx_page_context, int[] _jspx_push_body_count_c_forEach_0)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:url
    org.apache.taglibs.standard.tag.rt.core.UrlTag _jspx_th_c_url_2 = (org.apache.taglibs.standard.tag.rt.core.UrlTag) _jspx_tagPool_c_url_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.UrlTag.class);
    _jspx_th_c_url_2.setPageContext(_jspx_page_context);
    _jspx_th_c_url_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_forEach_0);
    _jspx_th_c_url_2.setValue((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("/home/index.jsp?lang=${langs}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    int _jspx_eval_c_url_2 = _jspx_th_c_url_2.doStartTag();
    if (_jspx_th_c_url_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_url_value_nobody.reuse(_jspx_th_c_url_2);
    return false;
  }

  private boolean _jspx_meth_fmt_message_7(javax.servlet.jsp.tagext.JspTag _jspx_th_c_forEach_0, PageContext _jspx_page_context, int[] _jspx_push_body_count_c_forEach_0)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_7 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_7.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_7.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_forEach_0);
    _jspx_th_fmt_message_7.setKey((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:substring(langs,0,2)}", java.lang.String.class, (PageContext)_jspx_page_context, _jspx_fnmap_1, false));
    int _jspx_eval_fmt_message_7 = _jspx_th_fmt_message_7.doStartTag();
    if (_jspx_th_fmt_message_7.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_7);
    return false;
  }

  private boolean _jspx_meth_c_set_0(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_0 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_0.setPageContext(_jspx_page_context);
    _jspx_th_c_set_0.setParent(null);
    _jspx_th_c_set_0.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_0.setProperty("uinfo");
    _jspx_th_c_set_0.setValue(new String("http://kalio.net/empweb/schema/users/v1"));
    int _jspx_eval_c_set_0 = _jspx_th_c_set_0.doStartTag();
    if (_jspx_th_c_set_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_0);
    return false;
  }

  private boolean _jspx_meth_c_set_1(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_1 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_1.setPageContext(_jspx_page_context);
    _jspx_th_c_set_1.setParent(null);
    _jspx_th_c_set_1.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_1.setProperty("ustat");
    _jspx_th_c_set_1.setValue(new String("http://kalio.net/empweb/schema/userstatus/v1"));
    int _jspx_eval_c_set_1 = _jspx_th_c_set_1.doStartTag();
    if (_jspx_th_c_set_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_1);
    return false;
  }

  private boolean _jspx_meth_c_set_2(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_2 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_2.setPageContext(_jspx_page_context);
    _jspx_th_c_set_2.setParent(null);
    _jspx_th_c_set_2.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_2.setProperty("s");
    _jspx_th_c_set_2.setValue(new String("http://kalio.net/empweb/schema/suspension/v1"));
    int _jspx_eval_c_set_2 = _jspx_th_c_set_2.doStartTag();
    if (_jspx_th_c_set_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_2);
    return false;
  }

  private boolean _jspx_meth_c_set_3(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_3 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_3.setPageContext(_jspx_page_context);
    _jspx_th_c_set_3.setParent(null);
    _jspx_th_c_set_3.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_3.setProperty("f");
    _jspx_th_c_set_3.setValue(new String("http://kalio.net/empweb/schema/fine/v1"));
    int _jspx_eval_c_set_3 = _jspx_th_c_set_3.doStartTag();
    if (_jspx_th_c_set_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_3);
    return false;
  }

  private boolean _jspx_meth_c_set_4(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_4 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_4.setPageContext(_jspx_page_context);
    _jspx_th_c_set_4.setParent(null);
    _jspx_th_c_set_4.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_4.setProperty("w");
    _jspx_th_c_set_4.setValue(new String("http://kalio.net/empweb/schema/wait/v1"));
    int _jspx_eval_c_set_4 = _jspx_th_c_set_4.doStartTag();
    if (_jspx_th_c_set_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_4);
    return false;
  }

  private boolean _jspx_meth_c_set_5(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_5 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_5.setPageContext(_jspx_page_context);
    _jspx_th_c_set_5.setParent(null);
    _jspx_th_c_set_5.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_5.setProperty("r");
    _jspx_th_c_set_5.setValue(new String("http://kalio.net/empweb/schema/reservation/v1"));
    int _jspx_eval_c_set_5 = _jspx_th_c_set_5.doStartTag();
    if (_jspx_th_c_set_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_5);
    return false;
  }

  private boolean _jspx_meth_c_set_6(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_6 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_6.setPageContext(_jspx_page_context);
    _jspx_th_c_set_6.setParent(null);
    _jspx_th_c_set_6.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_6.setProperty("l");
    _jspx_th_c_set_6.setValue(new String("http://kalio.net/empweb/schema/loan/v1"));
    int _jspx_eval_c_set_6 = _jspx_th_c_set_6.doStartTag();
    if (_jspx_th_c_set_6.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_6);
    return false;
  }

  private boolean _jspx_meth_c_set_7(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_7 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_7.setPageContext(_jspx_page_context);
    _jspx_th_c_set_7.setParent(null);
    _jspx_th_c_set_7.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_7.setProperty("h");
    _jspx_th_c_set_7.setValue(new String("http://kalio.net/empweb/schema/holdingsinfo/v1"));
    int _jspx_eval_c_set_7 = _jspx_th_c_set_7.doStartTag();
    if (_jspx_th_c_set_7.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_7);
    return false;
  }

  private boolean _jspx_meth_c_set_8(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_8 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_8.setPageContext(_jspx_page_context);
    _jspx_th_c_set_8.setParent(null);
    _jspx_th_c_set_8.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_8.setProperty("mods");
    _jspx_th_c_set_8.setValue(new String("http://www.loc.gov/mods/v3"));
    int _jspx_eval_c_set_8 = _jspx_th_c_set_8.doStartTag();
    if (_jspx_th_c_set_8.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_8);
    return false;
  }

  private boolean _jspx_meth_c_set_9(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_9 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_9.setPageContext(_jspx_page_context);
    _jspx_th_c_set_9.setParent(null);
    _jspx_th_c_set_9.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_9.setProperty("tr");
    _jspx_th_c_set_9.setValue(new String("http://kalio.net/empweb/schema/transactionresult/v1"));
    int _jspx_eval_c_set_9 = _jspx_th_c_set_9.doStartTag();
    if (_jspx_th_c_set_9.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_9);
    return false;
  }

  private boolean _jspx_meth_c_set_10(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_10 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_10.setPageContext(_jspx_page_context);
    _jspx_th_c_set_10.setParent(null);
    _jspx_th_c_set_10.setVar("user_id");
    _jspx_th_c_set_10.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(param.user_id)}", java.lang.Object.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false));
    int _jspx_eval_c_set_10 = _jspx_th_c_set_10.doStartTag();
    if (_jspx_th_c_set_10.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_var_value_nobody.reuse(_jspx_th_c_set_10);
    return false;
  }

  private boolean _jspx_meth_c_set_11(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_11 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_11.setPageContext(_jspx_page_context);
    _jspx_th_c_set_11.setParent(null);
    _jspx_th_c_set_11.setVar("user_db");
    _jspx_th_c_set_11.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(param.user_db)}", java.lang.Object.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false));
    int _jspx_eval_c_set_11 = _jspx_th_c_set_11.doStartTag();
    if (_jspx_th_c_set_11.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_var_value_nobody.reuse(_jspx_th_c_set_11);
    return false;
  }

  private boolean _jspx_meth_c_set_12(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_12 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_12.setPageContext(_jspx_page_context);
    _jspx_th_c_set_12.setParent(null);
    _jspx_th_c_set_12.setVar("nowts");
    int _jspx_eval_c_set_12 = _jspx_th_c_set_12.doStartTag();
    if (_jspx_eval_c_set_12 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_12 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_12.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_12.doInitBody();
      }
      do {
        if (_jspx_meth_util_formatDate_0(_jspx_th_c_set_12, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_set_12.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_12 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_12.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_12);
    return false;
  }

  private boolean _jspx_meth_util_formatDate_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_set_12, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_0 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_0.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_0.setParent(_jspx_th_c_set_12);
    _jspx_th_util_formatDate_0.setType("timestamplong");
    _jspx_th_util_formatDate_0.setDate((java.util.Date) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${now}", java.util.Date.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_util_formatDate_0.doTag();
    return false;
  }

  private boolean _jspx_meth_x_parse_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_0 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_0.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_0);
    _jspx_th_x_parse_0.setVarDom("userInfoResult");
    int _jspx_eval_x_parse_0 = _jspx_th_x_parse_0.doStartTag();
    if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_0.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_0.doInitBody();
      }
      do {
        if (_jspx_meth_trans_searchUsersById_0(_jspx_th_x_parse_0, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_x_parse_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_x_parse_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_x_parse_varDom.reuse(_jspx_th_x_parse_0);
    return false;
  }

  private boolean _jspx_meth_trans_searchUsersById_0(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  trans:searchUsersById
    org.apache.jsp.tag.web.trans.searchUsersById_tag _jspx_th_trans_searchUsersById_0 = new org.apache.jsp.tag.web.trans.searchUsersById_tag();
    _jspx_th_trans_searchUsersById_0.setJspContext(_jspx_page_context);
    _jspx_th_trans_searchUsersById_0.setParent(_jspx_th_x_parse_0);
    _jspx_th_trans_searchUsersById_0.setDatabase((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_db}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_trans_searchUsersById_0.setJspBody(new user_005fstatus_005fresult_jspHelper( 0, _jspx_page_context, _jspx_th_trans_searchUsersById_0, null));
    _jspx_th_trans_searchUsersById_0.doTag();
    return false;
  }

  private boolean _jspx_meth_x_parse_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_1 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_1.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_0);
    _jspx_th_x_parse_1.setVarDom("userStatusResult");
    int _jspx_eval_x_parse_1 = _jspx_th_x_parse_1.doStartTag();
    if (_jspx_eval_x_parse_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_1 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_1.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_1.doInitBody();
      }
      do {
        if (_jspx_meth_trans_getUserStatus_0(_jspx_th_x_parse_1, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_x_parse_1.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_x_parse_1 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_x_parse_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_x_parse_varDom.reuse(_jspx_th_x_parse_1);
    return false;
  }

  private boolean _jspx_meth_trans_getUserStatus_0(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  trans:getUserStatus
    org.apache.jsp.tag.web.trans.getUserStatus_tag _jspx_th_trans_getUserStatus_0 = new org.apache.jsp.tag.web.trans.getUserStatus_tag();
    _jspx_th_trans_getUserStatus_0.setJspContext(_jspx_page_context);
    _jspx_th_trans_getUserStatus_0.setParent(_jspx_th_x_parse_1);
    _jspx_th_trans_getUserStatus_0.setId((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_id}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_trans_getUserStatus_0.setDatabase((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_db}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_trans_getUserStatus_0.doTag();
    return false;
  }

  private boolean _jspx_meth_c_if_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_1 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_1.setPageContext(_jspx_page_context);
    _jspx_th_c_if_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_0);
    _jspx_th_c_if_1.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userCount != 1}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_1 = _jspx_th_c_if_1.doStartTag();
    if (_jspx_eval_c_if_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_redirect_0(_jspx_th_c_if_1, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_if_1.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_1);
    return false;
  }

  private boolean _jspx_meth_c_redirect_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:redirect
    org.apache.taglibs.standard.tag.rt.core.RedirectTag _jspx_th_c_redirect_0 = (org.apache.taglibs.standard.tag.rt.core.RedirectTag) _jspx_tagPool_c_redirect_url_nobody.get(org.apache.taglibs.standard.tag.rt.core.RedirectTag.class);
    _jspx_th_c_redirect_0.setPageContext(_jspx_page_context);
    _jspx_th_c_redirect_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_1);
    _jspx_th_c_redirect_0.setUrl((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("user_query_result.jsp?user_id=${user_id}&user_db=${user_db}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    int _jspx_eval_c_redirect_0 = _jspx_th_c_redirect_0.doStartTag();
    if (_jspx_th_c_redirect_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_redirect_url_nobody.reuse(_jspx_th_c_redirect_0);
    return false;
  }

  private boolean _jspx_meth_c_otherwise_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:otherwise
    org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_0 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
    _jspx_th_c_otherwise_0.setPageContext(_jspx_page_context);
    _jspx_th_c_otherwise_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_0);
    int _jspx_eval_c_otherwise_0 = _jspx_th_c_otherwise_0.doStartTag();
    if (_jspx_eval_c_otherwise_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_redirect_1(_jspx_th_c_otherwise_0, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_otherwise_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_otherwise_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_0);
    return false;
  }

  private boolean _jspx_meth_c_redirect_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:redirect
    org.apache.taglibs.standard.tag.rt.core.RedirectTag _jspx_th_c_redirect_1 = (org.apache.taglibs.standard.tag.rt.core.RedirectTag) _jspx_tagPool_c_redirect_url_nobody.get(org.apache.taglibs.standard.tag.rt.core.RedirectTag.class);
    _jspx_th_c_redirect_1.setPageContext(_jspx_page_context);
    _jspx_th_c_redirect_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_0);
    _jspx_th_c_redirect_1.setUrl("index.jsp");
    int _jspx_eval_c_redirect_1 = _jspx_th_c_redirect_1.doStartTag();
    if (_jspx_th_c_redirect_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_redirect_url_nobody.reuse(_jspx_th_c_redirect_1);
    return false;
  }

  private boolean _jspx_meth_fmt_message_11(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_11 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_11.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_11.setParent(null);
    _jspx_th_fmt_message_11.setKey("user_info");
    int _jspx_eval_fmt_message_11 = _jspx_th_fmt_message_11.doStartTag();
    if (_jspx_th_fmt_message_11.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_11);
    return false;
  }

  private boolean _jspx_meth_c_choose_1(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:choose
    org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_1 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
    _jspx_th_c_choose_1.setPageContext(_jspx_page_context);
    _jspx_th_c_choose_1.setParent(null);
    int _jspx_eval_c_choose_1 = _jspx_th_c_choose_1.doStartTag();
    if (_jspx_eval_c_choose_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_when_1(_jspx_th_c_choose_1, _jspx_page_context))
          return true;
        if (_jspx_meth_c_otherwise_1(_jspx_th_c_choose_1, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_choose_1.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_choose_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_1);
    return false;
  }

  private boolean _jspx_meth_c_when_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_1 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_1.setPageContext(_jspx_page_context);
    _jspx_th_c_when_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_1);
    _jspx_th_c_when_1.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userInfo['uinfo:user'] == null}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_when_1 = _jspx_th_c_when_1.doStartTag();
    if (_jspx_eval_c_when_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write('<');
        out.write('p');
        out.write('>');
        if (_jspx_meth_fmt_message_12(_jspx_th_c_when_1, _jspx_page_context))
          return true;
        out.write("</p>\n");
        out.write("      ");
        int evalDoAfterBody = _jspx_th_c_when_1.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_1);
    return false;
  }

  private boolean _jspx_meth_fmt_message_12(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_12 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_12.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_12.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_1);
    _jspx_th_fmt_message_12.setKey("no_results_found");
    int _jspx_eval_fmt_message_12 = _jspx_th_fmt_message_12.doStartTag();
    if (_jspx_th_fmt_message_12.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_12);
    return false;
  }

  private boolean _jspx_meth_c_otherwise_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:otherwise
    org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_1 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
    _jspx_th_c_otherwise_1.setPageContext(_jspx_page_context);
    _jspx_th_c_otherwise_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_1);
    int _jspx_eval_c_otherwise_1 = _jspx_th_c_otherwise_1.doStartTag();
    if (_jspx_eval_c_otherwise_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_dsp_user_0(_jspx_th_c_otherwise_1, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_otherwise_1.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_otherwise_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_1);
    return false;
  }

  private boolean _jspx_meth_dsp_user_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  dsp:user
    org.apache.jsp.tag.web.display.user_tag _jspx_th_dsp_user_0 = new org.apache.jsp.tag.web.display.user_tag();
    _jspx_th_dsp_user_0.setJspContext(_jspx_page_context);
    _jspx_th_dsp_user_0.setParent(_jspx_th_c_otherwise_1);
    _jspx_th_dsp_user_0.setDoc((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userInfoResult}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_dsp_user_0.setSelect("//uinfo:userCollection");
    _jspx_th_dsp_user_0.setNsmap((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_dsp_user_0.doTag();
    return false;
  }

  private boolean _jspx_meth_fmt_message_13(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_13 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_13.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_13.setParent(null);
    _jspx_th_fmt_message_13.setKey("user_status");
    int _jspx_eval_fmt_message_13 = _jspx_th_fmt_message_13.doStartTag();
    if (_jspx_th_fmt_message_13.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_13);
    return false;
  }

  private boolean _jspx_meth_fmt_message_14(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_14 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_14.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_14.setParent(null);
    _jspx_th_fmt_message_14.setKey("user_status");
    int _jspx_eval_fmt_message_14 = _jspx_th_fmt_message_14.doStartTag();
    if (_jspx_th_fmt_message_14.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_14);
    return false;
  }

  private boolean _jspx_meth_c_if_2(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_2 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_2.setPageContext(_jspx_page_context);
    _jspx_th_c_if_2.setParent(null);
    _jspx_th_c_if_2.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(userInfo['uinfo:user/uinfo:extension/s:suspensions/s:suspension'] != null)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_2 = _jspx_th_c_if_2.doStartTag();
    if (_jspx_eval_c_if_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<tr>\n");
        out.write("          <td>\n");
        out.write("            <a href=\"#suspensions\" onClick=\"document.getElementById('detailed_info').style.display='block'\">\n");
        out.write("              ");
        if (_jspx_meth_fmt_message_15(_jspx_th_c_if_2, _jspx_page_context))
          return true;
        out.write("</a>\n");
        out.write("          </td>\n");
        out.write("          <td>\n");
        out.write("            ");
        if (_jspx_meth_fmt_formatNumber_0(_jspx_th_c_if_2, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("        </tr>\n");
        out.write("      ");
        int evalDoAfterBody = _jspx_th_c_if_2.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_2);
    return false;
  }

  private boolean _jspx_meth_fmt_message_15(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_2, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_15 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_15.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_15.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_2);
    _jspx_th_fmt_message_15.setKey("administrative_suspensions");
    int _jspx_eval_fmt_message_15 = _jspx_th_fmt_message_15.doStartTag();
    if (_jspx_th_fmt_message_15.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_15);
    return false;
  }

  private boolean _jspx_meth_fmt_formatNumber_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_2, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:formatNumber
    org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag _jspx_th_fmt_formatNumber_0 = (org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag) _jspx_tagPool_fmt_formatNumber.get(org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag.class);
    _jspx_th_fmt_formatNumber_0.setPageContext(_jspx_page_context);
    _jspx_th_fmt_formatNumber_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_2);
    int _jspx_eval_fmt_formatNumber_0 = _jspx_th_fmt_formatNumber_0.doStartTag();
    if (_jspx_eval_fmt_formatNumber_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_fmt_formatNumber_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_fmt_formatNumber_0.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_fmt_formatNumber_0.doInitBody();
      }
      do {
        if (_jspx_meth_jxp_out_0(_jspx_th_fmt_formatNumber_0, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_fmt_formatNumber_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_fmt_formatNumber_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_fmt_formatNumber_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_formatNumber.reuse(_jspx_th_fmt_formatNumber_0);
    return false;
  }

  private boolean _jspx_meth_jxp_out_0(javax.servlet.jsp.tagext.JspTag _jspx_th_fmt_formatNumber_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  jxp:out
    org.apache.jsp.tag.web.commons.jxp.out_tag _jspx_th_jxp_out_0 = new org.apache.jsp.tag.web.commons.jxp.out_tag();
    _jspx_th_jxp_out_0.setJspContext(_jspx_page_context);
    _jspx_th_jxp_out_0.setParent(_jspx_th_fmt_formatNumber_0);
    _jspx_th_jxp_out_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userInfoResult}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_0.setSelect("count(//uinfo:user/uinfo:extension/s:suspensions/s:suspension)");
    _jspx_th_jxp_out_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_0.doTag();
    return false;
  }

  private boolean _jspx_meth_c_set_13(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_3, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_13 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_13.setPageContext(_jspx_page_context);
    _jspx_th_c_set_13.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_3);
    _jspx_th_c_set_13.setVar("suspCant");
    _jspx_th_c_set_13.setValue(new String("0"));
    int _jspx_eval_c_set_13 = _jspx_th_c_set_13.doStartTag();
    if (_jspx_th_c_set_13.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_var_value_nobody.reuse(_jspx_th_c_set_13);
    return false;
  }

  private boolean _jspx_meth_c_if_4(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_4 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_4.setPageContext(_jspx_page_context);
    _jspx_th_c_if_4.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_if_4.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${suspExp eq 'false'}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_4 = _jspx_th_c_if_4.doStartTag();
    if (_jspx_eval_c_if_4 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_set_14(_jspx_th_c_if_4, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_if_4.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_4);
    return false;
  }

  private boolean _jspx_meth_c_set_14(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_14 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_14.setPageContext(_jspx_page_context);
    _jspx_th_c_set_14.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_4);
    _jspx_th_c_set_14.setVar("suspCant");
    int _jspx_eval_c_set_14 = _jspx_th_c_set_14.doStartTag();
    if (_jspx_eval_c_set_14 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_14 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_14.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_14.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${suspCant+1}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        int evalDoAfterBody = _jspx_th_c_set_14.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_14 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_14.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_14);
    return false;
  }

  private boolean _jspx_meth_c_if_5(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_3, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_5 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_5.setPageContext(_jspx_page_context);
    _jspx_th_c_if_5.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_3);
    _jspx_th_c_if_5.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${suspCant gt 0}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_5 = _jspx_th_c_if_5.doStartTag();
    if (_jspx_eval_c_if_5 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<tr>\n");
        out.write("          <td>\n");
        out.write("            <a href=\"#suspensions\" onClick=\"document.getElementById('detailed_info').style.display='block'\">\n");
        out.write("              ");
        if (_jspx_meth_fmt_message_16(_jspx_th_c_if_5, _jspx_page_context))
          return true;
        out.write("</a>\n");
        out.write("          </td>\n");
        out.write("          <td>\n");
        out.write("            ");
        if (_jspx_meth_fmt_formatNumber_1(_jspx_th_c_if_5, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("        </tr>\n");
        out.write("        ");
        int evalDoAfterBody = _jspx_th_c_if_5.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_5);
    return false;
  }

  private boolean _jspx_meth_fmt_message_16(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_5, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_16 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_16.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_16.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_5);
    _jspx_th_fmt_message_16.setKey("active_suspensions");
    int _jspx_eval_fmt_message_16 = _jspx_th_fmt_message_16.doStartTag();
    if (_jspx_th_fmt_message_16.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_16);
    return false;
  }

  private boolean _jspx_meth_fmt_formatNumber_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_5, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:formatNumber
    org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag _jspx_th_fmt_formatNumber_1 = (org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag) _jspx_tagPool_fmt_formatNumber.get(org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag.class);
    _jspx_th_fmt_formatNumber_1.setPageContext(_jspx_page_context);
    _jspx_th_fmt_formatNumber_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_5);
    int _jspx_eval_fmt_formatNumber_1 = _jspx_th_fmt_formatNumber_1.doStartTag();
    if (_jspx_eval_fmt_formatNumber_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_fmt_formatNumber_1 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_fmt_formatNumber_1.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_fmt_formatNumber_1.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${suspCant}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        int evalDoAfterBody = _jspx_th_fmt_formatNumber_1.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_fmt_formatNumber_1 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_fmt_formatNumber_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_formatNumber.reuse(_jspx_th_fmt_formatNumber_1);
    return false;
  }

  private boolean _jspx_meth_c_if_6(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_6 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_6.setPageContext(_jspx_page_context);
    _jspx_th_c_if_6.setParent(null);
    _jspx_th_c_if_6.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatus['f:fines/f:fine'] != null}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_6 = _jspx_th_c_if_6.doStartTag();
    if (_jspx_eval_c_if_6 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<tr>\n");
        out.write("          <td>\n");
        out.write("            <a href=\"#fines\" onClick=\"document.getElementById('detailed_info').style.display='block'\">\n");
        out.write("              ");
        if (_jspx_meth_fmt_message_17(_jspx_th_c_if_6, _jspx_page_context))
          return true;
        out.write("</a>\n");
        out.write("          </td>\n");
        out.write("          <td>\n");
        out.write("           ");
        if (_jspx_meth_fmt_formatNumber_2(_jspx_th_c_if_6, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("        </tr>\n");
        out.write("      ");
        int evalDoAfterBody = _jspx_th_c_if_6.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_6.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_6);
    return false;
  }

  private boolean _jspx_meth_fmt_message_17(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_6, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_17 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_17.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_17.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_6);
    _jspx_th_fmt_message_17.setKey("pending_fines");
    int _jspx_eval_fmt_message_17 = _jspx_th_fmt_message_17.doStartTag();
    if (_jspx_th_fmt_message_17.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_17);
    return false;
  }

  private boolean _jspx_meth_fmt_formatNumber_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_6, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:formatNumber
    org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag _jspx_th_fmt_formatNumber_2 = (org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag) _jspx_tagPool_fmt_formatNumber.get(org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag.class);
    _jspx_th_fmt_formatNumber_2.setPageContext(_jspx_page_context);
    _jspx_th_fmt_formatNumber_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_6);
    int _jspx_eval_fmt_formatNumber_2 = _jspx_th_fmt_formatNumber_2.doStartTag();
    if (_jspx_eval_fmt_formatNumber_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_fmt_formatNumber_2 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_fmt_formatNumber_2.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_fmt_formatNumber_2.doInitBody();
      }
      do {
        if (_jspx_meth_jxp_out_1(_jspx_th_fmt_formatNumber_2, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_fmt_formatNumber_2.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_fmt_formatNumber_2 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_fmt_formatNumber_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_formatNumber.reuse(_jspx_th_fmt_formatNumber_2);
    return false;
  }

  private boolean _jspx_meth_jxp_out_1(javax.servlet.jsp.tagext.JspTag _jspx_th_fmt_formatNumber_2, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  jxp:out
    org.apache.jsp.tag.web.commons.jxp.out_tag _jspx_th_jxp_out_1 = new org.apache.jsp.tag.web.commons.jxp.out_tag();
    _jspx_th_jxp_out_1.setJspContext(_jspx_page_context);
    _jspx_th_jxp_out_1.setParent(_jspx_th_fmt_formatNumber_2);
    _jspx_th_jxp_out_1.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatusResult}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_1.setSelect("count(//f:fines/f:fine)");
    _jspx_th_jxp_out_1.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_1.doTag();
    return false;
  }

  private boolean _jspx_meth_c_if_7(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_7 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_7.setPageContext(_jspx_page_context);
    _jspx_th_c_if_7.setParent(null);
    _jspx_th_c_if_7.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userInfo['uinfo:user/uinfo:extension/f:fines/f:fine'] != null}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_7 = _jspx_th_c_if_7.doStartTag();
    if (_jspx_eval_c_if_7 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<tr>\n");
        out.write("          <td>\n");
        out.write("            <a href=\"#fines\" onClick=\"document.getElementById('detailed_info').style.display='block'\">\n");
        out.write("              ");
        if (_jspx_meth_fmt_message_18(_jspx_th_c_if_7, _jspx_page_context))
          return true;
        out.write("</a>\n");
        out.write("          </td>\n");
        out.write("          <td>\n");
        out.write("            ");
        if (_jspx_meth_fmt_formatNumber_3(_jspx_th_c_if_7, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("        </tr>\n");
        out.write("      ");
        int evalDoAfterBody = _jspx_th_c_if_7.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_7.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_7);
    return false;
  }

  private boolean _jspx_meth_fmt_message_18(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_7, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_18 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_18.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_18.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_7);
    _jspx_th_fmt_message_18.setKey("administrative_fines");
    int _jspx_eval_fmt_message_18 = _jspx_th_fmt_message_18.doStartTag();
    if (_jspx_th_fmt_message_18.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_18);
    return false;
  }

  private boolean _jspx_meth_fmt_formatNumber_3(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_7, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:formatNumber
    org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag _jspx_th_fmt_formatNumber_3 = (org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag) _jspx_tagPool_fmt_formatNumber.get(org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag.class);
    _jspx_th_fmt_formatNumber_3.setPageContext(_jspx_page_context);
    _jspx_th_fmt_formatNumber_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_7);
    int _jspx_eval_fmt_formatNumber_3 = _jspx_th_fmt_formatNumber_3.doStartTag();
    if (_jspx_eval_fmt_formatNumber_3 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_fmt_formatNumber_3 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_fmt_formatNumber_3.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_fmt_formatNumber_3.doInitBody();
      }
      do {
        if (_jspx_meth_jxp_out_2(_jspx_th_fmt_formatNumber_3, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_fmt_formatNumber_3.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_fmt_formatNumber_3 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_fmt_formatNumber_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_formatNumber.reuse(_jspx_th_fmt_formatNumber_3);
    return false;
  }

  private boolean _jspx_meth_jxp_out_2(javax.servlet.jsp.tagext.JspTag _jspx_th_fmt_formatNumber_3, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  jxp:out
    org.apache.jsp.tag.web.commons.jxp.out_tag _jspx_th_jxp_out_2 = new org.apache.jsp.tag.web.commons.jxp.out_tag();
    _jspx_th_jxp_out_2.setJspContext(_jspx_page_context);
    _jspx_th_jxp_out_2.setParent(_jspx_th_fmt_formatNumber_3);
    _jspx_th_jxp_out_2.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userInfoResult}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_2.setSelect("count(//uinfo:user/uinfo:extension/f:fines/f:fine)");
    _jspx_th_jxp_out_2.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_2.doTag();
    return false;
  }

  private boolean _jspx_meth_c_if_8(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_8 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_8.setPageContext(_jspx_page_context);
    _jspx_th_c_if_8.setParent(null);
    _jspx_th_c_if_8.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatus['w:waits/w:wait'] != null}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_8 = _jspx_th_c_if_8.doStartTag();
    if (_jspx_eval_c_if_8 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<tr>\n");
        out.write("          <td>\n");
        out.write("            <a href=\"#waits\" onClick=\"document.getElementById('detailed_info').style.display='block'\">\n");
        out.write("              ");
        if (_jspx_meth_fmt_message_19(_jspx_th_c_if_8, _jspx_page_context))
          return true;
        out.write("</a>\n");
        out.write("          </td>\n");
        out.write("          <td>\n");
        out.write("            ");
        if (_jspx_meth_fmt_formatNumber_4(_jspx_th_c_if_8, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("          <td/>\n");
        out.write("        </tr>\n");
        out.write("      ");
        int evalDoAfterBody = _jspx_th_c_if_8.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_8.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_8);
    return false;
  }

  private boolean _jspx_meth_fmt_message_19(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_8, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_19 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_19.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_19.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_8);
    _jspx_th_fmt_message_19.setKey("wait_list");
    int _jspx_eval_fmt_message_19 = _jspx_th_fmt_message_19.doStartTag();
    if (_jspx_th_fmt_message_19.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_19);
    return false;
  }

  private boolean _jspx_meth_fmt_formatNumber_4(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_8, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:formatNumber
    org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag _jspx_th_fmt_formatNumber_4 = (org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag) _jspx_tagPool_fmt_formatNumber.get(org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag.class);
    _jspx_th_fmt_formatNumber_4.setPageContext(_jspx_page_context);
    _jspx_th_fmt_formatNumber_4.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_8);
    int _jspx_eval_fmt_formatNumber_4 = _jspx_th_fmt_formatNumber_4.doStartTag();
    if (_jspx_eval_fmt_formatNumber_4 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_fmt_formatNumber_4 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_fmt_formatNumber_4.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_fmt_formatNumber_4.doInitBody();
      }
      do {
        if (_jspx_meth_jxp_out_3(_jspx_th_fmt_formatNumber_4, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_fmt_formatNumber_4.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_fmt_formatNumber_4 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_fmt_formatNumber_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_formatNumber.reuse(_jspx_th_fmt_formatNumber_4);
    return false;
  }

  private boolean _jspx_meth_jxp_out_3(javax.servlet.jsp.tagext.JspTag _jspx_th_fmt_formatNumber_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  jxp:out
    org.apache.jsp.tag.web.commons.jxp.out_tag _jspx_th_jxp_out_3 = new org.apache.jsp.tag.web.commons.jxp.out_tag();
    _jspx_th_jxp_out_3.setJspContext(_jspx_page_context);
    _jspx_th_jxp_out_3.setParent(_jspx_th_fmt_formatNumber_4);
    _jspx_th_jxp_out_3.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatusResult}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_3.setSelect("count(//w:waits/w:wait)");
    _jspx_th_jxp_out_3.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_3.doTag();
    return false;
  }

  private boolean _jspx_meth_c_if_9(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_9 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_9.setPageContext(_jspx_page_context);
    _jspx_th_c_if_9.setParent(null);
    _jspx_th_c_if_9.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatus['r:reservations/r:reservation'] != null}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_9 = _jspx_th_c_if_9.doStartTag();
    if (_jspx_eval_c_if_9 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<tr>\n");
        out.write("          <td>\n");
        out.write("            <a href=\"#reservations\" onClick=\"document.getElementById('detailed_info').style.display='block'\">\n");
        out.write("              ");
        if (_jspx_meth_fmt_message_20(_jspx_th_c_if_9, _jspx_page_context))
          return true;
        out.write("</a>\n");
        out.write("          </td>\n");
        out.write("          <td>\n");
        out.write("            ");
        if (_jspx_meth_fmt_formatNumber_5(_jspx_th_c_if_9, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("        </tr>\n");
        out.write("      ");
        int evalDoAfterBody = _jspx_th_c_if_9.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_9.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_9);
    return false;
  }

  private boolean _jspx_meth_fmt_message_20(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_9, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_20 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_20.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_20.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_9);
    _jspx_th_fmt_message_20.setKey("reservations");
    int _jspx_eval_fmt_message_20 = _jspx_th_fmt_message_20.doStartTag();
    if (_jspx_th_fmt_message_20.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_20);
    return false;
  }

  private boolean _jspx_meth_fmt_formatNumber_5(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_9, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:formatNumber
    org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag _jspx_th_fmt_formatNumber_5 = (org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag) _jspx_tagPool_fmt_formatNumber.get(org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag.class);
    _jspx_th_fmt_formatNumber_5.setPageContext(_jspx_page_context);
    _jspx_th_fmt_formatNumber_5.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_9);
    int _jspx_eval_fmt_formatNumber_5 = _jspx_th_fmt_formatNumber_5.doStartTag();
    if (_jspx_eval_fmt_formatNumber_5 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_fmt_formatNumber_5 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_fmt_formatNumber_5.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_fmt_formatNumber_5.doInitBody();
      }
      do {
        if (_jspx_meth_jxp_out_4(_jspx_th_fmt_formatNumber_5, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_fmt_formatNumber_5.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_fmt_formatNumber_5 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_fmt_formatNumber_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_formatNumber.reuse(_jspx_th_fmt_formatNumber_5);
    return false;
  }

  private boolean _jspx_meth_jxp_out_4(javax.servlet.jsp.tagext.JspTag _jspx_th_fmt_formatNumber_5, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  jxp:out
    org.apache.jsp.tag.web.commons.jxp.out_tag _jspx_th_jxp_out_4 = new org.apache.jsp.tag.web.commons.jxp.out_tag();
    _jspx_th_jxp_out_4.setJspContext(_jspx_page_context);
    _jspx_th_jxp_out_4.setParent(_jspx_th_fmt_formatNumber_5);
    _jspx_th_jxp_out_4.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatusResult}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_4.setSelect("count(//r:reservation)");
    _jspx_th_jxp_out_4.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_4.doTag();
    return false;
  }

  private boolean _jspx_meth_c_if_10(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_10 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_10.setPageContext(_jspx_page_context);
    _jspx_th_c_if_10.setParent(null);
    _jspx_th_c_if_10.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatus['l:loans/l:loan'] != null}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_10 = _jspx_th_c_if_10.doStartTag();
    if (_jspx_eval_c_if_10 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<tr>\n");
        out.write("          <td>\n");
        out.write("            <a href=\"#loans\" onClick=\"document.getElementById('detailed_info').style.display='block'\">\n");
        out.write("              ");
        if (_jspx_meth_fmt_message_21(_jspx_th_c_if_10, _jspx_page_context))
          return true;
        out.write("</a>\n");
        out.write("          </td>\n");
        out.write("          <td>\n");
        out.write("            ");
        if (_jspx_meth_fmt_formatNumber_6(_jspx_th_c_if_10, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("        </tr>\n");
        out.write("      ");
        int evalDoAfterBody = _jspx_th_c_if_10.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_10.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_10);
    return false;
  }

  private boolean _jspx_meth_fmt_message_21(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_10, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_21 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_21.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_21.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_10);
    _jspx_th_fmt_message_21.setKey("current_loans");
    int _jspx_eval_fmt_message_21 = _jspx_th_fmt_message_21.doStartTag();
    if (_jspx_th_fmt_message_21.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_21);
    return false;
  }

  private boolean _jspx_meth_fmt_formatNumber_6(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_10, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:formatNumber
    org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag _jspx_th_fmt_formatNumber_6 = (org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag) _jspx_tagPool_fmt_formatNumber.get(org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag.class);
    _jspx_th_fmt_formatNumber_6.setPageContext(_jspx_page_context);
    _jspx_th_fmt_formatNumber_6.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_10);
    int _jspx_eval_fmt_formatNumber_6 = _jspx_th_fmt_formatNumber_6.doStartTag();
    if (_jspx_eval_fmt_formatNumber_6 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_fmt_formatNumber_6 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_fmt_formatNumber_6.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_fmt_formatNumber_6.doInitBody();
      }
      do {
        if (_jspx_meth_jxp_out_5(_jspx_th_fmt_formatNumber_6, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_fmt_formatNumber_6.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_fmt_formatNumber_6 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_fmt_formatNumber_6.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_formatNumber.reuse(_jspx_th_fmt_formatNumber_6);
    return false;
  }

  private boolean _jspx_meth_jxp_out_5(javax.servlet.jsp.tagext.JspTag _jspx_th_fmt_formatNumber_6, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  jxp:out
    org.apache.jsp.tag.web.commons.jxp.out_tag _jspx_th_jxp_out_5 = new org.apache.jsp.tag.web.commons.jxp.out_tag();
    _jspx_th_jxp_out_5.setJspContext(_jspx_page_context);
    _jspx_th_jxp_out_5.setParent(_jspx_th_fmt_formatNumber_6);
    _jspx_th_jxp_out_5.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userStatusResult}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_5.setSelect("count(//l:loans/l:loan)");
    _jspx_th_jxp_out_5.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_5.doTag();
    return false;
  }

  private boolean _jspx_meth_x_parse_2(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_2 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_2.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_2.setParent(null);
    _jspx_th_x_parse_2.setVarDom("historicCounts");
    int _jspx_eval_x_parse_2 = _jspx_th_x_parse_2.doStartTag();
    if (_jspx_eval_x_parse_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_2 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_2.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_2.doInitBody();
      }
      do {
        if (_jspx_meth_trans_doTransaction_0(_jspx_th_x_parse_2, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_x_parse_2.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_x_parse_2 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_x_parse_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_x_parse_varDom.reuse(_jspx_th_x_parse_2);
    return false;
  }

  private boolean _jspx_meth_trans_doTransaction_0(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_2, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  trans:doTransaction
    org.apache.jsp.tag.web.trans.doTransaction_tag _jspx_th_trans_doTransaction_0 = new org.apache.jsp.tag.web.trans.doTransaction_tag();
    _jspx_th_trans_doTransaction_0.setJspContext(_jspx_page_context);
    _jspx_th_trans_doTransaction_0.setParent(_jspx_th_x_parse_2);
    _jspx_th_trans_doTransaction_0.setName("stat-hist-user");
    _jspx_th_trans_doTransaction_0.setJspBody(new user_005fstatus_005fresult_jspHelper( 3, _jspx_page_context, _jspx_th_trans_doTransaction_0, null));
    _jspx_th_trans_doTransaction_0.doTag();
    return false;
  }

  private boolean _jspx_meth_c_set_15(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_15 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_15.setPageContext(_jspx_page_context);
    _jspx_th_c_set_15.setParent(null);
    _jspx_th_c_set_15.setVar("historic_href");
    _jspx_th_c_set_15.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("../../stats/historic/include_report.jsp?report_type=hist&amp;user_id=${user_id}&amp;user_db=${user_db}&amp;library=all_libraries", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    int _jspx_eval_c_set_15 = _jspx_th_c_set_15.doStartTag();
    if (_jspx_th_c_set_15.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_var_value_nobody.reuse(_jspx_th_c_set_15);
    return false;
  }

  private boolean _jspx_meth_fmt_message_22(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_22 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_22.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_22.setParent(null);
    _jspx_th_fmt_message_22.setKey("user_historic_transactions");
    int _jspx_eval_fmt_message_22 = _jspx_th_fmt_message_22.doStartTag();
    if (_jspx_th_fmt_message_22.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_22);
    return false;
  }

  private boolean _jspx_meth_fmt_message_23(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_23 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_23.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_23.setParent(null);
    _jspx_th_fmt_message_23.setKey("historic_loans_by_user");
    int _jspx_eval_fmt_message_23 = _jspx_th_fmt_message_23.doStartTag();
    if (_jspx_th_fmt_message_23.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_23);
    return false;
  }

  private boolean _jspx_meth_jxp_out_6(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  jxp:out
    org.apache.jsp.tag.web.commons.jxp.out_tag _jspx_th_jxp_out_6 = new org.apache.jsp.tag.web.commons.jxp.out_tag();
    _jspx_th_jxp_out_6.setJspContext(_jspx_page_context);
    _jspx_th_jxp_out_6.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${historicCounts}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_6.setSelect("//tr:value[@name='loanCount']");
    _jspx_th_jxp_out_6.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_6.doTag();
    return false;
  }

  private boolean _jspx_meth_fmt_message_24(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_24 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_24.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_24.setParent(null);
    _jspx_th_fmt_message_24.setKey("historic_fines_by_user");
    int _jspx_eval_fmt_message_24 = _jspx_th_fmt_message_24.doStartTag();
    if (_jspx_th_fmt_message_24.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_24);
    return false;
  }

  private boolean _jspx_meth_jxp_out_7(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  jxp:out
    org.apache.jsp.tag.web.commons.jxp.out_tag _jspx_th_jxp_out_7 = new org.apache.jsp.tag.web.commons.jxp.out_tag();
    _jspx_th_jxp_out_7.setJspContext(_jspx_page_context);
    _jspx_th_jxp_out_7.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${historicCounts}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_7.setSelect("//tr:value[@name='finesCount']");
    _jspx_th_jxp_out_7.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_7.doTag();
    return false;
  }

  private boolean _jspx_meth_fmt_message_25(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_25 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_25.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_25.setParent(null);
    _jspx_th_fmt_message_25.setKey("historic_suspensions_by_user");
    int _jspx_eval_fmt_message_25 = _jspx_th_fmt_message_25.doStartTag();
    if (_jspx_th_fmt_message_25.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_25);
    return false;
  }

  private boolean _jspx_meth_jxp_out_8(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  jxp:out
    org.apache.jsp.tag.web.commons.jxp.out_tag _jspx_th_jxp_out_8 = new org.apache.jsp.tag.web.commons.jxp.out_tag();
    _jspx_th_jxp_out_8.setJspContext(_jspx_page_context);
    _jspx_th_jxp_out_8.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${historicCounts}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_8.setSelect("//tr:value[@name='suspensionCount']");
    _jspx_th_jxp_out_8.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_8.doTag();
    return false;
  }

  private boolean _jspx_meth_fmt_message_26(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_26 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_26.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_26.setParent(null);
    _jspx_th_fmt_message_26.setKey("actions");
    int _jspx_eval_fmt_message_26 = _jspx_th_fmt_message_26.doStartTag();
    if (_jspx_th_fmt_message_26.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_26);
    return false;
  }

  private boolean _jspx_meth_fmt_message_27(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_27 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_27.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_27.setParent(null);
    _jspx_th_fmt_message_27.setKey("new_loan");
    int _jspx_eval_fmt_message_27 = _jspx_th_fmt_message_27.doStartTag();
    if (_jspx_th_fmt_message_27.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_27);
    return false;
  }

  private boolean _jspx_meth_fmt_message_28(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_28 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_28.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_28.setParent(null);
    _jspx_th_fmt_message_28.setKey("create_fine");
    int _jspx_eval_fmt_message_28 = _jspx_th_fmt_message_28.doStartTag();
    if (_jspx_th_fmt_message_28.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_28);
    return false;
  }

  private boolean _jspx_meth_fmt_message_29(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_29 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_29.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_29.setParent(null);
    _jspx_th_fmt_message_29.setKey("create_suspension");
    int _jspx_eval_fmt_message_29 = _jspx_th_fmt_message_29.doStartTag();
    if (_jspx_th_fmt_message_29.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_29);
    return false;
  }

  private boolean _jspx_meth_fmt_message_30(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_30 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_30.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_30.setParent(null);
    _jspx_th_fmt_message_30.setKey("user_status_details");
    int _jspx_eval_fmt_message_30 = _jspx_th_fmt_message_30.doStartTag();
    if (_jspx_th_fmt_message_30.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_30);
    return false;
  }

  private boolean _jspx_meth_fmt_message_31(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_11, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_31 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_31.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_31.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_11);
    _jspx_th_fmt_message_31.setKey("active_suspensions");
    int _jspx_eval_fmt_message_31 = _jspx_th_fmt_message_31.doStartTag();
    if (_jspx_th_fmt_message_31.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_31);
    return false;
  }

  private boolean _jspx_meth_fmt_message_32(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_11, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_32 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_32.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_32.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_11);
    _jspx_th_fmt_message_32.setKey("type");
    int _jspx_eval_fmt_message_32 = _jspx_th_fmt_message_32.doStartTag();
    if (_jspx_th_fmt_message_32.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_32);
    return false;
  }

  private boolean _jspx_meth_fmt_message_33(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_11, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_33 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_33.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_33.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_11);
    _jspx_th_fmt_message_33.setKey("suspension_id");
    int _jspx_eval_fmt_message_33 = _jspx_th_fmt_message_33.doStartTag();
    if (_jspx_th_fmt_message_33.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_33);
    return false;
  }

  private boolean _jspx_meth_fmt_message_34(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_11, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_34 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_34.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_34.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_11);
    _jspx_th_fmt_message_34.setKey("suspension_creation_date");
    int _jspx_eval_fmt_message_34 = _jspx_th_fmt_message_34.doStartTag();
    if (_jspx_th_fmt_message_34.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_34);
    return false;
  }

  private boolean _jspx_meth_fmt_message_35(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_11, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_35 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_35.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_35.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_11);
    _jspx_th_fmt_message_35.setKey("suspension_duration");
    int _jspx_eval_fmt_message_35 = _jspx_th_fmt_message_35.doStartTag();
    if (_jspx_th_fmt_message_35.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_35);
    return false;
  }

  private boolean _jspx_meth_fmt_message_36(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_11, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_36 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_36.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_36.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_11);
    _jspx_th_fmt_message_36.setKey("suspended_from");
    int _jspx_eval_fmt_message_36 = _jspx_th_fmt_message_36.doStartTag();
    if (_jspx_th_fmt_message_36.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_36);
    return false;
  }

  private boolean _jspx_meth_fmt_message_37(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_11, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_37 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_37.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_37.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_11);
    _jspx_th_fmt_message_37.setKey("suspended_until");
    int _jspx_eval_fmt_message_37 = _jspx_th_fmt_message_37.doStartTag();
    if (_jspx_th_fmt_message_37.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_37);
    return false;
  }

  private boolean _jspx_meth_fmt_message_38(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_11, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_38 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_38.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_38.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_11);
    _jspx_th_fmt_message_38.setKey("obs");
    int _jspx_eval_fmt_message_38 = _jspx_th_fmt_message_38.doStartTag();
    if (_jspx_th_fmt_message_38.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_38);
    return false;
  }

  private boolean _jspx_meth_fmt_message_39(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_11, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_39 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_39.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_39.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_11);
    _jspx_th_fmt_message_39.setKey("actions");
    int _jspx_eval_fmt_message_39 = _jspx_th_fmt_message_39.doStartTag();
    if (_jspx_th_fmt_message_39.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_39);
    return false;
  }

  private boolean _jspx_meth_util_formatDate_1(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_1 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_1.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_1.setParent(_jspx_parent);
    _jspx_th_util_formatDate_1.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_1.setJspBody(new user_005fstatus_005fresult_jspHelper( 5, _jspx_page_context, _jspx_th_util_formatDate_1, null));
    _jspx_th_util_formatDate_1.doTag();
    return false;
  }

  private boolean _jspx_meth_fmt_message_40(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_40 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_40.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_40.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_fmt_message_40.setKey("administrative_suspension");
    int _jspx_eval_fmt_message_40 = _jspx_th_fmt_message_40.doStartTag();
    if (_jspx_th_fmt_message_40.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_40);
    return false;
  }

  private boolean _jspx_meth_c_if_12(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_12 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_12.setPageContext(_jspx_page_context);
    _jspx_th_c_if_12.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_if_12.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ suspExp eq 'false'}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_12 = _jspx_th_c_if_12.doStartTag();
    if (_jspx_eval_c_if_12 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<tr>\n");
        out.write("              <td>");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['s:type']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("</td>\n");
        out.write("              <td><a href=\"view_transaction_details.jsp?transaction_id=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write('"');
        out.write('>');
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("</a></td>\n");
        out.write("              <td>");
        if (_jspx_meth_util_formatDate_2(_jspx_th_c_if_12, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("              <td>");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['s:daysSuspended']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("</td>\n");
        out.write("              <td>");
        if (_jspx_meth_util_formatDate_3(_jspx_th_c_if_12, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("              <td>");
        if (_jspx_meth_util_formatDate_4(_jspx_th_c_if_12, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("              <td>");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['s:obs']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("</td>\n");
        out.write("              <td>\n");
        out.write("                <a href=\"../suspension/cancel/index.jsp?suspension_id=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("&amp;user_id=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_id}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("&amp;user_db=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_db}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("\" >\n");
        out.write("                  ");
        if (_jspx_meth_fmt_message_41(_jspx_th_c_if_12, _jspx_page_context))
          return true;
        out.write("</a>\n");
        out.write("              </td>\n");
        out.write("            </tr>\n");
        out.write("          ");
        int evalDoAfterBody = _jspx_th_c_if_12.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_12.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_12);
    return false;
  }

  private boolean _jspx_meth_util_formatDate_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_12, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_2 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_2.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_2.setParent(_jspx_th_c_if_12);
    _jspx_th_util_formatDate_2.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_2.setJspBody(new user_005fstatus_005fresult_jspHelper( 8, _jspx_page_context, _jspx_th_util_formatDate_2, null));
    _jspx_th_util_formatDate_2.doTag();
    return false;
  }

  private boolean _jspx_meth_util_formatDate_3(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_12, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_3 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_3.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_3.setParent(_jspx_th_c_if_12);
    _jspx_th_util_formatDate_3.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_3.setJspBody(new user_005fstatus_005fresult_jspHelper( 9, _jspx_page_context, _jspx_th_util_formatDate_3, null));
    _jspx_th_util_formatDate_3.doTag();
    return false;
  }

  private boolean _jspx_meth_util_formatDate_4(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_12, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_4 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_4.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_4.setParent(_jspx_th_c_if_12);
    _jspx_th_util_formatDate_4.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_4.setJspBody(new user_005fstatus_005fresult_jspHelper( 10, _jspx_page_context, _jspx_th_util_formatDate_4, null));
    _jspx_th_util_formatDate_4.doTag();
    return false;
  }

  private boolean _jspx_meth_fmt_message_41(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_12, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_41 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_41.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_41.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_12);
    _jspx_th_fmt_message_41.setKey("cancel");
    int _jspx_eval_fmt_message_41 = _jspx_th_fmt_message_41.doStartTag();
    if (_jspx_th_fmt_message_41.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_41);
    return false;
  }

  private boolean _jspx_meth_fmt_message_42(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_13, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_42 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_42.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_42.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_13);
    _jspx_th_fmt_message_42.setKey("pending_fines");
    int _jspx_eval_fmt_message_42 = _jspx_th_fmt_message_42.doStartTag();
    if (_jspx_th_fmt_message_42.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_42);
    return false;
  }

  private boolean _jspx_meth_fmt_message_43(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_13, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_43 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_43.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_43.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_13);
    _jspx_th_fmt_message_43.setKey("type");
    int _jspx_eval_fmt_message_43 = _jspx_th_fmt_message_43.doStartTag();
    if (_jspx_th_fmt_message_43.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_43);
    return false;
  }

  private boolean _jspx_meth_fmt_message_44(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_13, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_44 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_44.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_44.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_13);
    _jspx_th_fmt_message_44.setKey("fine_id");
    int _jspx_eval_fmt_message_44 = _jspx_th_fmt_message_44.doStartTag();
    if (_jspx_th_fmt_message_44.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_44);
    return false;
  }

  private boolean _jspx_meth_fmt_message_45(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_13, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_45 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_45.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_45.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_13);
    _jspx_th_fmt_message_45.setKey("date");
    int _jspx_eval_fmt_message_45 = _jspx_th_fmt_message_45.doStartTag();
    if (_jspx_th_fmt_message_45.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_45);
    return false;
  }

  private boolean _jspx_meth_fmt_message_46(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_13, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_46 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_46.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_46.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_13);
    _jspx_th_fmt_message_46.setKey("pending_amount");
    int _jspx_eval_fmt_message_46 = _jspx_th_fmt_message_46.doStartTag();
    if (_jspx_th_fmt_message_46.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_46);
    return false;
  }

  private boolean _jspx_meth_fmt_message_47(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_13, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_47 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_47.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_47.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_13);
    _jspx_th_fmt_message_47.setKey("obs");
    int _jspx_eval_fmt_message_47 = _jspx_th_fmt_message_47.doStartTag();
    if (_jspx_th_fmt_message_47.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_47);
    return false;
  }

  private boolean _jspx_meth_fmt_message_48(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_13, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_48 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_48.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_48.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_13);
    _jspx_th_fmt_message_48.setKey("actions");
    int _jspx_eval_fmt_message_48 = _jspx_th_fmt_message_48.doStartTag();
    if (_jspx_th_fmt_message_48.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_48);
    return false;
  }

  private boolean _jspx_meth_util_formatDate_5(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_5 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_5.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_5.setParent(_jspx_parent);
    _jspx_th_util_formatDate_5.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_5.setJspBody(new user_005fstatus_005fresult_jspHelper( 12, _jspx_page_context, _jspx_th_util_formatDate_5, null));
    _jspx_th_util_formatDate_5.doTag();
    return false;
  }

  private boolean _jspx_meth_c_choose_2(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:choose
    org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_2 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
    _jspx_th_c_choose_2.setPageContext(_jspx_page_context);
    _jspx_th_c_choose_2.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    int _jspx_eval_c_choose_2 = _jspx_th_c_choose_2.doStartTag();
    if (_jspx_eval_c_choose_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_when_2(_jspx_th_c_choose_2, _jspx_page_context))
          return true;
        if (_jspx_meth_c_otherwise_2(_jspx_th_c_choose_2, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_choose_2.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_choose_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_2);
    return false;
  }

  private boolean _jspx_meth_c_when_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_2, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_2 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_2.setPageContext(_jspx_page_context);
    _jspx_th_c_when_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_2);
    _jspx_th_c_when_2.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty ptr['f:ref/@id']}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_when_2 = _jspx_th_c_when_2.doStartTag();
    if (_jspx_eval_c_when_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<a href=\"fine_status_result.jsp?fine_id=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['f:ref/@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write('"');
        out.write('>');
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['f:ref/@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("</a>");
        int evalDoAfterBody = _jspx_th_c_when_2.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_2);
    return false;
  }

  private boolean _jspx_meth_c_otherwise_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_2, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:otherwise
    org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_2 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
    _jspx_th_c_otherwise_2.setPageContext(_jspx_page_context);
    _jspx_th_c_otherwise_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_2);
    int _jspx_eval_c_otherwise_2 = _jspx_th_c_otherwise_2.doStartTag();
    if (_jspx_eval_c_otherwise_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<a href=\"fine_status_result.jsp?fine_id=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write('"');
        out.write('>');
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("</a>");
        int evalDoAfterBody = _jspx_th_c_otherwise_2.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_otherwise_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_2);
    return false;
  }

  private boolean _jspx_meth_util_formatDate_6(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_6 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_6.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_6.setParent(_jspx_parent);
    _jspx_th_util_formatDate_6.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_6.setJspBody(new user_005fstatus_005fresult_jspHelper( 14, _jspx_page_context, _jspx_th_util_formatDate_6, null));
    _jspx_th_util_formatDate_6.doTag();
    return false;
  }

  private boolean _jspx_meth_dsp_formatAmount_0(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  dsp:formatAmount
    org.apache.jsp.tag.web.display.formatAmount_tag _jspx_th_dsp_formatAmount_0 = new org.apache.jsp.tag.web.display.formatAmount_tag();
    _jspx_th_dsp_formatAmount_0.setJspContext(_jspx_page_context);
    _jspx_th_dsp_formatAmount_0.setParent(_jspx_parent);
    _jspx_th_dsp_formatAmount_0.setJspBody(new user_005fstatus_005fresult_jspHelper( 15, _jspx_page_context, _jspx_th_dsp_formatAmount_0, null));
    _jspx_th_dsp_formatAmount_0.doTag();
    return false;
  }

  private boolean _jspx_meth_c_set_16(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_16 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_16.setPageContext(_jspx_page_context);
    _jspx_th_c_set_16.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_set_16.setVar("fine_amount_total");
    _jspx_th_c_set_16.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(ptr['f:amount'])}", java.lang.Object.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false));
    int _jspx_eval_c_set_16 = _jspx_th_c_set_16.doStartTag();
    if (_jspx_th_c_set_16.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var_value_nobody.reuse(_jspx_th_c_set_16);
    return false;
  }

  private boolean _jspx_meth_fmt_message_49(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_49 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_49.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_49.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_fmt_message_49.setKey("pay");
    int _jspx_eval_fmt_message_49 = _jspx_th_fmt_message_49.doStartTag();
    if (_jspx_th_fmt_message_49.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_49);
    return false;
  }

  private boolean _jspx_meth_fmt_message_50(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_50 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_50.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_50.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_fmt_message_50.setKey("cancel");
    int _jspx_eval_fmt_message_50 = _jspx_th_fmt_message_50.doStartTag();
    if (_jspx_th_fmt_message_50.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_50);
    return false;
  }

  private boolean _jspx_meth_fmt_message_51(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_14, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_51 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_51.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_51.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_14);
    _jspx_th_fmt_message_51.setKey("wait_list");
    int _jspx_eval_fmt_message_51 = _jspx_th_fmt_message_51.doStartTag();
    if (_jspx_th_fmt_message_51.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_51);
    return false;
  }

  private boolean _jspx_meth_fmt_message_52(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_14, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_52 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_52.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_52.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_14);
    _jspx_th_fmt_message_52.setKey("wait_id");
    int _jspx_eval_fmt_message_52 = _jspx_th_fmt_message_52.doStartTag();
    if (_jspx_th_fmt_message_52.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_52);
    return false;
  }

  private boolean _jspx_meth_fmt_message_53(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_14, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_53 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_53.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_53.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_14);
    _jspx_th_fmt_message_53.setKey("date");
    int _jspx_eval_fmt_message_53 = _jspx_th_fmt_message_53.doStartTag();
    if (_jspx_th_fmt_message_53.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_53);
    return false;
  }

  private boolean _jspx_meth_fmt_message_54(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_14, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_54 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_54.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_54.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_14);
    _jspx_th_fmt_message_54.setKey("confirmed_date");
    int _jspx_eval_fmt_message_54 = _jspx_th_fmt_message_54.doStartTag();
    if (_jspx_th_fmt_message_54.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_54);
    return false;
  }

  private boolean _jspx_meth_fmt_message_55(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_14, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_55 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_55.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_55.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_14);
    _jspx_th_fmt_message_55.setKey("expiration_date");
    int _jspx_eval_fmt_message_55 = _jspx_th_fmt_message_55.doStartTag();
    if (_jspx_th_fmt_message_55.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_55);
    return false;
  }

  private boolean _jspx_meth_fmt_message_56(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_14, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_56 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_56.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_56.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_14);
    _jspx_th_fmt_message_56.setKey("record_id");
    int _jspx_eval_fmt_message_56 = _jspx_th_fmt_message_56.doStartTag();
    if (_jspx_th_fmt_message_56.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_56);
    return false;
  }

  private boolean _jspx_meth_fmt_message_57(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_14, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_57 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_57.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_57.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_14);
    _jspx_th_fmt_message_57.setKey("volume_id");
    int _jspx_eval_fmt_message_57 = _jspx_th_fmt_message_57.doStartTag();
    if (_jspx_th_fmt_message_57.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_57);
    return false;
  }

  private boolean _jspx_meth_fmt_message_58(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_14, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_58 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_58.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_58.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_14);
    _jspx_th_fmt_message_58.setKey("record_title");
    int _jspx_eval_fmt_message_58 = _jspx_th_fmt_message_58.doStartTag();
    if (_jspx_th_fmt_message_58.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_58);
    return false;
  }

  private boolean _jspx_meth_fmt_message_59(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_14, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_59 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_59.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_59.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_14);
    _jspx_th_fmt_message_59.setKey("actions");
    int _jspx_eval_fmt_message_59 = _jspx_th_fmt_message_59.doStartTag();
    if (_jspx_th_fmt_message_59.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_59);
    return false;
  }

  private boolean _jspx_meth_util_formatDate_7(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_7 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_7.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_7.setParent(_jspx_parent);
    _jspx_th_util_formatDate_7.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_7.setJspBody(new user_005fstatus_005fresult_jspHelper( 17, _jspx_page_context, _jspx_th_util_formatDate_7, null));
    _jspx_th_util_formatDate_7.doTag();
    return false;
  }

  private boolean _jspx_meth_util_formatDate_8(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_8 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_8.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_8.setParent(_jspx_parent);
    _jspx_th_util_formatDate_8.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_8.setJspBody(new user_005fstatus_005fresult_jspHelper( 18, _jspx_page_context, _jspx_th_util_formatDate_8, null));
    _jspx_th_util_formatDate_8.doTag();
    return false;
  }

  private boolean _jspx_meth_util_formatDate_9(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_9 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_9.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_9.setParent(_jspx_parent);
    _jspx_th_util_formatDate_9.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_9.setJspBody(new user_005fstatus_005fresult_jspHelper( 19, _jspx_page_context, _jspx_th_util_formatDate_9, null));
    _jspx_th_util_formatDate_9.doTag();
    return false;
  }

  private boolean _jspx_meth_c_if_15(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_15 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_15.setPageContext(_jspx_page_context);
    _jspx_th_c_if_15.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_if_15.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not config['ew.hide_object_db']}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_15 = _jspx_th_c_if_15.doStartTag();
    if (_jspx_eval_c_if_15 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write('(');
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['w:objectDb']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write(')');
        int evalDoAfterBody = _jspx_th_c_if_15.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_15.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_15);
    return false;
  }

  private boolean _jspx_meth_x_parse_3(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_3 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_3.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_3.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_x_parse_3.setVarDom("thisRecord");
    int _jspx_eval_x_parse_3 = _jspx_th_x_parse_3.doStartTag();
    if (_jspx_eval_x_parse_3 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_3 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_3.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_3.doInitBody();
      }
      do {
        if (_jspx_meth_trans_searchObjectsById_0(_jspx_th_x_parse_3, _jspx_page_context))
          return true;
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

  private boolean _jspx_meth_trans_searchObjectsById_0(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_3, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  trans:searchObjectsById
    org.apache.jsp.tag.web.trans.searchObjectsById_tag _jspx_th_trans_searchObjectsById_0 = new org.apache.jsp.tag.web.trans.searchObjectsById_tag();
    _jspx_th_trans_searchObjectsById_0.setJspContext(_jspx_page_context);
    _jspx_th_trans_searchObjectsById_0.setParent(_jspx_th_x_parse_3);
    _jspx_th_trans_searchObjectsById_0.setDatabase((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['w:objectDb']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_trans_searchObjectsById_0.setJspBody(new user_005fstatus_005fresult_jspHelper( 20, _jspx_page_context, _jspx_th_trans_searchObjectsById_0, null));
    _jspx_th_trans_searchObjectsById_0.doTag();
    return false;
  }

  private boolean _jspx_meth_fmt_message_60(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_60 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_60.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_60.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_fmt_message_60.setKey("loan");
    int _jspx_eval_fmt_message_60 = _jspx_th_fmt_message_60.doStartTag();
    if (_jspx_th_fmt_message_60.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_60);
    return false;
  }

  private boolean _jspx_meth_fmt_message_61(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_61 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_61.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_61.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_fmt_message_61.setKey("cancel");
    int _jspx_eval_fmt_message_61 = _jspx_th_fmt_message_61.doStartTag();
    if (_jspx_th_fmt_message_61.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_61);
    return false;
  }

  private boolean _jspx_meth_fmt_message_62(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_16, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_62 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_62.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_62.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_16);
    _jspx_th_fmt_message_62.setKey("reservations");
    int _jspx_eval_fmt_message_62 = _jspx_th_fmt_message_62.doStartTag();
    if (_jspx_th_fmt_message_62.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_62);
    return false;
  }

  private boolean _jspx_meth_fmt_message_63(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_16, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_63 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_63.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_63.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_16);
    _jspx_th_fmt_message_63.setKey("reservation_id");
    int _jspx_eval_fmt_message_63 = _jspx_th_fmt_message_63.doStartTag();
    if (_jspx_th_fmt_message_63.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_63);
    return false;
  }

  private boolean _jspx_meth_fmt_message_64(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_16, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_64 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_64.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_64.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_16);
    _jspx_th_fmt_message_64.setKey("record_title");
    int _jspx_eval_fmt_message_64 = _jspx_th_fmt_message_64.doStartTag();
    if (_jspx_th_fmt_message_64.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_64);
    return false;
  }

  private boolean _jspx_meth_fmt_message_65(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_16, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_65 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_65.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_65.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_16);
    _jspx_th_fmt_message_65.setKey("record_id");
    int _jspx_eval_fmt_message_65 = _jspx_th_fmt_message_65.doStartTag();
    if (_jspx_th_fmt_message_65.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_65);
    return false;
  }

  private boolean _jspx_meth_fmt_message_66(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_16, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_66 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_66.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_66.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_16);
    _jspx_th_fmt_message_66.setKey("volume_id");
    int _jspx_eval_fmt_message_66 = _jspx_th_fmt_message_66.doStartTag();
    if (_jspx_th_fmt_message_66.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_66);
    return false;
  }

  private boolean _jspx_meth_fmt_message_67(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_16, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_67 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_67.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_67.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_16);
    _jspx_th_fmt_message_67.setKey("object_location");
    int _jspx_eval_fmt_message_67 = _jspx_th_fmt_message_67.doStartTag();
    if (_jspx_th_fmt_message_67.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_67);
    return false;
  }

  private boolean _jspx_meth_fmt_message_68(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_16, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_68 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_68.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_68.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_16);
    _jspx_th_fmt_message_68.setKey("reservation_start_date");
    int _jspx_eval_fmt_message_68 = _jspx_th_fmt_message_68.doStartTag();
    if (_jspx_th_fmt_message_68.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_68);
    return false;
  }

  private boolean _jspx_meth_fmt_message_69(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_16, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_69 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_69.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_69.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_16);
    _jspx_th_fmt_message_69.setKey("reservation_expiration_date");
    int _jspx_eval_fmt_message_69 = _jspx_th_fmt_message_69.doStartTag();
    if (_jspx_th_fmt_message_69.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_69);
    return false;
  }

  private boolean _jspx_meth_fmt_message_70(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_16, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_70 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_70.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_70.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_16);
    _jspx_th_fmt_message_70.setKey("reservation_end_date");
    int _jspx_eval_fmt_message_70 = _jspx_th_fmt_message_70.doStartTag();
    if (_jspx_th_fmt_message_70.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_70);
    return false;
  }

  private boolean _jspx_meth_fmt_message_71(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_16, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_71 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_71.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_71.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_16);
    _jspx_th_fmt_message_71.setKey("actions");
    int _jspx_eval_fmt_message_71 = _jspx_th_fmt_message_71.doStartTag();
    if (_jspx_th_fmt_message_71.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_71);
    return false;
  }

  private boolean _jspx_meth_x_parse_4(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_4 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_4.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_4.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_x_parse_4.setVarDom("thisRecord");
    int _jspx_eval_x_parse_4 = _jspx_th_x_parse_4.doStartTag();
    if (_jspx_eval_x_parse_4 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_4 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_4.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_4.doInitBody();
      }
      do {
        if (_jspx_meth_trans_searchObjects_0(_jspx_th_x_parse_4, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_x_parse_4.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_x_parse_4 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_x_parse_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_x_parse_varDom.reuse(_jspx_th_x_parse_4);
    return false;
  }

  private boolean _jspx_meth_trans_searchObjects_0(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  trans:searchObjects
    org.apache.jsp.tag.web.trans.searchObjects_tag _jspx_th_trans_searchObjects_0 = new org.apache.jsp.tag.web.trans.searchObjects_tag();
    _jspx_th_trans_searchObjects_0.setJspContext(_jspx_page_context);
    _jspx_th_trans_searchObjects_0.setParent(_jspx_th_x_parse_4);
    _jspx_th_trans_searchObjects_0.setDatabase((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['r:objectDb']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_trans_searchObjects_0.setJspBody(new user_005fstatus_005fresult_jspHelper( 22, _jspx_page_context, _jspx_th_trans_searchObjects_0, null));
    _jspx_th_trans_searchObjects_0.doTag();
    return false;
  }

  private boolean _jspx_meth_c_if_17(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_17 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_17.setPageContext(_jspx_page_context);
    _jspx_th_c_if_17.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_if_17.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not config['ew.hide_object_db']}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_17 = _jspx_th_c_if_17.doStartTag();
    if (_jspx_eval_c_if_17 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write('(');
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['r:objectDb']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write(')');
        int evalDoAfterBody = _jspx_th_c_if_17.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_17.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_17);
    return false;
  }

  private boolean _jspx_meth_util_formatDate_10(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_10 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_10.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_10.setParent(_jspx_parent);
    _jspx_th_util_formatDate_10.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_10.setJspBody(new user_005fstatus_005fresult_jspHelper( 23, _jspx_page_context, _jspx_th_util_formatDate_10, null));
    _jspx_th_util_formatDate_10.doTag();
    return false;
  }

  private boolean _jspx_meth_util_formatDate_11(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_11 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_11.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_11.setParent(_jspx_parent);
    _jspx_th_util_formatDate_11.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_11.setJspBody(new user_005fstatus_005fresult_jspHelper( 25, _jspx_page_context, _jspx_th_util_formatDate_11, null));
    _jspx_th_util_formatDate_11.doTag();
    return false;
  }

  private boolean _jspx_meth_util_formatDate_12(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_12 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_12.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_12.setParent(_jspx_parent);
    _jspx_th_util_formatDate_12.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_12.setJspBody(new user_005fstatus_005fresult_jspHelper( 26, _jspx_page_context, _jspx_th_util_formatDate_12, null));
    _jspx_th_util_formatDate_12.doTag();
    return false;
  }

  private boolean _jspx_meth_fmt_message_72(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_72 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_72.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_72.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_fmt_message_72.setKey("cancel");
    int _jspx_eval_fmt_message_72 = _jspx_th_fmt_message_72.doStartTag();
    if (_jspx_th_fmt_message_72.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_72);
    return false;
  }

  private boolean _jspx_meth_c_if_18(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_18 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_18.setPageContext(_jspx_page_context);
    _jspx_th_c_if_18.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_if_18.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(ptr['r:startDate'] lt nowts) and (ptr['r:expirationDate'] gt nowts)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_18 = _jspx_th_c_if_18.doStartTag();
    if (_jspx_eval_c_if_18 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("\n");
        out.write("                   | <a href=\"../loan/index.jsp?user_id=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_id}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("&amp;user_db=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_db}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("\">\n");
        out.write("                     ");
        if (_jspx_meth_fmt_message_73(_jspx_th_c_if_18, _jspx_page_context))
          return true;
        out.write("</a>\n");
        out.write("                ");
        int evalDoAfterBody = _jspx_th_c_if_18.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_18.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_18);
    return false;
  }

  private boolean _jspx_meth_fmt_message_73(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_18, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_73 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_73.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_73.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_18);
    _jspx_th_fmt_message_73.setKey("loan");
    int _jspx_eval_fmt_message_73 = _jspx_th_fmt_message_73.doStartTag();
    if (_jspx_th_fmt_message_73.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_73);
    return false;
  }

  private boolean _jspx_meth_fmt_message_74(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_19, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_74 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_74.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_74.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_19);
    _jspx_th_fmt_message_74.setKey("current_loans");
    int _jspx_eval_fmt_message_74 = _jspx_th_fmt_message_74.doStartTag();
    if (_jspx_th_fmt_message_74.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_74);
    return false;
  }

  private boolean _jspx_meth_fmt_message_75(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_19, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_75 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_75.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_75.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_19);
    _jspx_th_fmt_message_75.setKey("loan_id");
    int _jspx_eval_fmt_message_75 = _jspx_th_fmt_message_75.doStartTag();
    if (_jspx_th_fmt_message_75.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_75);
    return false;
  }

  private boolean _jspx_meth_fmt_message_76(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_19, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_76 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_76.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_76.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_19);
    _jspx_th_fmt_message_76.setKey("record_title");
    int _jspx_eval_fmt_message_76 = _jspx_th_fmt_message_76.doStartTag();
    if (_jspx_th_fmt_message_76.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_76);
    return false;
  }

  private boolean _jspx_meth_fmt_message_77(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_19, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_77 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_77.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_77.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_19);
    _jspx_th_fmt_message_77.setKey("copy_id");
    int _jspx_eval_fmt_message_77 = _jspx_th_fmt_message_77.doStartTag();
    if (_jspx_th_fmt_message_77.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_77);
    return false;
  }

  private boolean _jspx_meth_fmt_message_78(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_19, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_78 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_78.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_78.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_19);
    _jspx_th_fmt_message_78.setKey("record_id");
    int _jspx_eval_fmt_message_78 = _jspx_th_fmt_message_78.doStartTag();
    if (_jspx_th_fmt_message_78.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_78);
    return false;
  }

  private boolean _jspx_meth_fmt_message_79(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_19, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_79 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_79.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_79.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_19);
    _jspx_th_fmt_message_79.setKey("loan_date");
    int _jspx_eval_fmt_message_79 = _jspx_th_fmt_message_79.doStartTag();
    if (_jspx_th_fmt_message_79.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_79);
    return false;
  }

  private boolean _jspx_meth_fmt_message_80(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_19, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_80 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_80.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_80.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_19);
    _jspx_th_fmt_message_80.setKey("return_date");
    int _jspx_eval_fmt_message_80 = _jspx_th_fmt_message_80.doStartTag();
    if (_jspx_th_fmt_message_80.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_80);
    return false;
  }

  private boolean _jspx_meth_fmt_message_81(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_19, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_81 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_81.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_81.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_19);
    _jspx_th_fmt_message_81.setKey("actions");
    int _jspx_eval_fmt_message_81 = _jspx_th_fmt_message_81.doStartTag();
    if (_jspx_th_fmt_message_81.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_81);
    return false;
  }

  private boolean _jspx_meth_x_parse_5(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_5 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_5.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_5.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_x_parse_5.setVarDom("thisRecord");
    int _jspx_eval_x_parse_5 = _jspx_th_x_parse_5.doStartTag();
    if (_jspx_eval_x_parse_5 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_5 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_5.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_5.doInitBody();
      }
      do {
        if (_jspx_meth_trans_searchObjectsById_1(_jspx_th_x_parse_5, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_x_parse_5.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_x_parse_5 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_x_parse_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_x_parse_varDom.reuse(_jspx_th_x_parse_5);
    return false;
  }

  private boolean _jspx_meth_trans_searchObjectsById_1(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_5, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  trans:searchObjectsById
    org.apache.jsp.tag.web.trans.searchObjectsById_tag _jspx_th_trans_searchObjectsById_1 = new org.apache.jsp.tag.web.trans.searchObjectsById_tag();
    _jspx_th_trans_searchObjectsById_1.setJspContext(_jspx_page_context);
    _jspx_th_trans_searchObjectsById_1.setParent(_jspx_th_x_parse_5);
    _jspx_th_trans_searchObjectsById_1.setDatabase((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:objectDb']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_trans_searchObjectsById_1.setJspBody(new user_005fstatus_005fresult_jspHelper( 28, _jspx_page_context, _jspx_th_trans_searchObjectsById_1, null));
    _jspx_th_trans_searchObjectsById_1.doTag();
    return false;
  }

  private boolean _jspx_meth_c_set_17(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_17 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_17.setPageContext(_jspx_page_context);
    _jspx_th_c_set_17.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_set_17.setVar("thisCopyId");
    int _jspx_eval_c_set_17 = _jspx_th_c_set_17.doStartTag();
    if (_jspx_eval_c_set_17 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_17 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_17.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_17.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:copyId']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        int evalDoAfterBody = _jspx_th_c_set_17.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_17 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_17.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_17);
    return false;
  }

  private boolean _jspx_meth_jxp_out_9(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  jxp:out
    org.apache.jsp.tag.web.commons.jxp.out_tag _jspx_th_jxp_out_9 = new org.apache.jsp.tag.web.commons.jxp.out_tag();
    _jspx_th_jxp_out_9.setJspContext(_jspx_page_context);
    _jspx_th_jxp_out_9.setParent(_jspx_parent);
    _jspx_th_jxp_out_9.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisRecord}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_9.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_9.setSelect((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("//h:copy[h:copyId='${thisCopyId}']/h:copyLocation", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_9.doTag();
    return false;
  }

  private boolean _jspx_meth_jxp_out_10(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  jxp:out
    org.apache.jsp.tag.web.commons.jxp.out_tag _jspx_th_jxp_out_10 = new org.apache.jsp.tag.web.commons.jxp.out_tag();
    _jspx_th_jxp_out_10.setJspContext(_jspx_page_context);
    _jspx_th_jxp_out_10.setParent(_jspx_parent);
    _jspx_th_jxp_out_10.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisRecord}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_10.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_10.setSelect((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("//h:copy[h:copyId='${thisCopyId}']/h:volumeId", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_jxp_out_10.doTag();
    return false;
  }

  private boolean _jspx_meth_c_if_20(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_20 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_20.setPageContext(_jspx_page_context);
    _jspx_th_c_if_20.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_if_20.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not config['ew.hide_object_db']}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_20 = _jspx_th_c_if_20.doStartTag();
    if (_jspx_eval_c_if_20 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write('(');
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:objectDb']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write(')');
        int evalDoAfterBody = _jspx_th_c_if_20.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_20.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_20);
    return false;
  }

  private boolean _jspx_meth_util_formatDate_13(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_13 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_13.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_13.setParent(_jspx_parent);
    _jspx_th_util_formatDate_13.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_13.setJspBody(new user_005fstatus_005fresult_jspHelper( 29, _jspx_page_context, _jspx_th_util_formatDate_13, null));
    _jspx_th_util_formatDate_13.doTag();
    return false;
  }

  private boolean _jspx_meth_util_formatDate_14(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_14 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_14.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_14.setParent(_jspx_parent);
    _jspx_th_util_formatDate_14.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_14.setJspBody(new user_005fstatus_005fresult_jspHelper( 31, _jspx_page_context, _jspx_th_util_formatDate_14, null));
    _jspx_th_util_formatDate_14.doTag();
    return false;
  }

  private boolean _jspx_meth_fmt_message_82(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_82 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_82.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_82.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_fmt_message_82.setKey("return");
    int _jspx_eval_fmt_message_82 = _jspx_th_fmt_message_82.doStartTag();
    if (_jspx_th_fmt_message_82.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_82);
    return false;
  }

  private boolean _jspx_meth_io_request_0(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  io:request
    org.apache.taglibs.io.URLTag _jspx_th_io_request_0 = (org.apache.taglibs.io.URLTag) _jspx_tagPool_io_request_url_nobody.get(org.apache.taglibs.io.URLTag.class);
    _jspx_th_io_request_0.setPageContext(_jspx_page_context);
    _jspx_th_io_request_0.setParent(null);
    _jspx_th_io_request_0.setUrl((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${abcd}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    int _jspx_eval_io_request_0 = _jspx_th_io_request_0.doStartTag();
    if (_jspx_th_io_request_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_io_request_url_nobody.reuse(_jspx_th_io_request_0);
    return false;
  }

  private class user_005fstatus_005fresult_jspHelper
      extends org.apache.jasper.runtime.JspFragmentHelper
  {
    private javax.servlet.jsp.tagext.JspTag _jspx_parent;
    private int[] _jspx_push_body_count;

    public user_005fstatus_005fresult_jspHelper( int discriminator, JspContext jspContext, javax.servlet.jsp.tagext.JspTag _jspx_parent, int[] _jspx_push_body_count ) {
      super( discriminator, jspContext, _jspx_parent );
      this._jspx_parent = _jspx_parent;
      this._jspx_push_body_count = _jspx_push_body_count;
    }
    public boolean invoke0( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_id}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public void invoke1( JspWriter out ) 
      throws Throwable
    {
      //  util:isExpired
      org.apache.jsp.tag.web.commons.util.isExpired_tag _jspx_th_util_isExpired_0 = new org.apache.jsp.tag.web.commons.util.isExpired_tag();
      java.util.HashMap _jspx_th_util_isExpired_0_aliasMap = new java.util.HashMap();
      _jspx_th_util_isExpired_0_aliasMap.put("varout", "suspExp");
      _jspx_th_util_isExpired_0.setJspContext(_jspx_page_context, _jspx_th_util_isExpired_0_aliasMap);
      _jspx_th_util_isExpired_0.setParent(_jspx_parent);
      _jspx_th_util_isExpired_0.setVar("suspExp");
      _jspx_th_util_isExpired_0.setOffset((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['s:daysSuspended']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_util_isExpired_0.setJspBody(new user_005fstatus_005fresult_jspHelper( 2, _jspx_page_context, _jspx_th_util_isExpired_0, null));
      _jspx_th_util_isExpired_0.doTag();
      if (_jspx_meth_c_if_4(_jspx_parent, _jspx_page_context))
        return;
      return;
    }
    public void invoke2( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['s:date']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return;
    }
    public boolean invoke3( JspWriter out ) 
      throws Throwable
    {
      out.write("<transactionExtras>\n");
      out.write("          <params>\n");
      out.write("            <param name=\"userId\">");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_id}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</param>\n");
      out.write("            <param name=\"userDb\">");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_db}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</param>\n");
      out.write("            <param name=\"onlyCounts\">true</param>\n");
      out.write("          </params>\n");
      out.write("        </transactionExtras>\n");
      out.write("      ");
      return false;
    }
    public void invoke4( JspWriter out ) 
      throws Throwable
    {
      out.write("<tr>\n");
      out.write("            <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@type']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n");
      out.write("            <td/>\n");
      out.write("            <td>\n");
      out.write("              ");
      if (_jspx_meth_util_formatDate_1(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("            <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['s:duration']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n");
      out.write("            <td>");
      if (_jspx_meth_fmt_message_40(_jspx_parent, _jspx_page_context))
        return;
      out.write(": <br/>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['s:obs']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n");
      out.write("            <td></td>\n");
      out.write("          </tr>\n");
      out.write("        ");
      return;
    }
    public boolean invoke5( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['s:startDate']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public void invoke6( JspWriter out ) 
      throws Throwable
    {
      //  util:isExpired
      org.apache.jsp.tag.web.commons.util.isExpired_tag _jspx_th_util_isExpired_1 = new org.apache.jsp.tag.web.commons.util.isExpired_tag();
      java.util.HashMap _jspx_th_util_isExpired_1_aliasMap = new java.util.HashMap();
      _jspx_th_util_isExpired_1_aliasMap.put("varout", "suspExp");
      _jspx_th_util_isExpired_1.setJspContext(_jspx_page_context, _jspx_th_util_isExpired_1_aliasMap);
      _jspx_th_util_isExpired_1.setParent(_jspx_parent);
      _jspx_th_util_isExpired_1.setVar("suspExp");
      _jspx_th_util_isExpired_1.setOffset((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['s:daysSuspended']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_util_isExpired_1.setJspBody(new user_005fstatus_005fresult_jspHelper( 7, _jspx_page_context, _jspx_th_util_isExpired_1, null));
      _jspx_th_util_isExpired_1.doTag();
      if (_jspx_meth_c_if_12(_jspx_parent, _jspx_page_context))
        return;
      return;
    }
    public void invoke7( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['s:date']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return;
    }
    public boolean invoke8( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['s:date']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public boolean invoke9( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['s:startDate']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public boolean invoke10( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['s:endDate']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public void invoke11( JspWriter out ) 
      throws Throwable
    {
      out.write("<tr>\n");
      out.write("              <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['f:type']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n");
      out.write("              <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("                ");
      if (_jspx_meth_util_formatDate_5(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("              ");
      out.write("<td align=\"right\">");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['f:amount']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n");
      out.write("              <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['f:obs']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n");
      out.write("              <td></td>\n");
      out.write("            </tr>\n");
      out.write("          ");
      return;
    }
    public boolean invoke12( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['f:date']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public void invoke13( JspWriter out ) 
      throws Throwable
    {
      out.write("<tr>\n");
      out.write("              <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['f:type']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("              ");
      if (_jspx_meth_c_choose_2(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("                ");
      if (_jspx_meth_util_formatDate_6(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("              <td align=\"right\">");
      if (_jspx_meth_dsp_formatAmount_0(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("              <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['f:obs']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("              ");
      if (_jspx_meth_c_set_16(_jspx_parent, _jspx_page_context))
        return;
      out.write("<a href=\"../fine/pay/index.jsp?fine_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;user_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_id}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;user_db=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_db}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;fine_amount=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fine_amount_total - fine_amount_paid}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("\">\n");
      out.write("                  ");
      if (_jspx_meth_fmt_message_49(_jspx_parent, _jspx_page_context))
        return;
      out.write("</a> |\n");
      out.write("                <a href=\"../fine/cancel/index.jsp?fine_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;user_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_id}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;user_db=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_db}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("\">\n");
      out.write("                  ");
      if (_jspx_meth_fmt_message_50(_jspx_parent, _jspx_page_context))
        return;
      out.write("</a>\n");
      out.write("              </td>\n");
      out.write("            </tr>\n");
      out.write("          ");
      return;
    }
    public boolean invoke14( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['f:date']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public boolean invoke15( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['f:amount']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public void invoke16( JspWriter out ) 
      throws Throwable
    {
      out.write("<tr>\n");
      out.write("              <td>\n");
      out.write("                <a href=\"view_transaction_details.jsp?transaction_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write('"');
      out.write('>');
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</a>\n");
      out.write("              </td>\n");
      out.write("              <td>\n");
      out.write("                ");
      if (_jspx_meth_util_formatDate_7(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("                ");
      if (_jspx_meth_util_formatDate_8(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("                ");
      if (_jspx_meth_util_formatDate_9(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("              \n");
      out.write("              <td>\n");
      out.write("                <a href=\"record_status_result.jsp?record_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['w:recordId']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;object_db=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['w:objectDb']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("\">\n");
      out.write("                  ");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['w:recordId']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      if (_jspx_meth_c_if_15(_jspx_parent, _jspx_page_context))
        return;
      out.write("</a>\n");
      out.write("              </td>\n");
      out.write("              <td>\n");
      out.write("                  ");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['w:volumeId']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("                ");
      if (_jspx_meth_x_parse_3(_jspx_parent, _jspx_page_context))
        return;
      //  jxp:set
      org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_3 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
      java.util.HashMap _jspx_th_jxp_set_3_aliasMap = new java.util.HashMap();
      _jspx_th_jxp_set_3_aliasMap.put("punt", "thisTitle");
      _jspx_th_jxp_set_3.setJspContext(_jspx_page_context, _jspx_th_jxp_set_3_aliasMap);
      _jspx_th_jxp_set_3.setParent(_jspx_parent);
      _jspx_th_jxp_set_3.setVar("thisTitle");
      _jspx_th_jxp_set_3.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisRecord}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_set_3.setSelect("//mods:title");
      _jspx_th_jxp_set_3.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_set_3.doTag();
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:escapeXml(thisTitle)}", java.lang.String.class, (PageContext)_jspx_page_context, _jspx_fnmap_3, false));
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("                <a href=\"../loan/index.jsp?user_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_id}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;user_db=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_db}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;record_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['w:recordId']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;object_db=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['w:objectDb']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("\">\n");
      out.write("                  ");
      if (_jspx_meth_fmt_message_60(_jspx_parent, _jspx_page_context))
        return;
      out.write("</a>\n");
      out.write("                <a href=\"../wait/cancel/index.jsp?user_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_id}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;user_db=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_db}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;wait_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;object_db=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['w:objectDb']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("\">\n");
      out.write("                  ");
      if (_jspx_meth_fmt_message_61(_jspx_parent, _jspx_page_context))
        return;
      out.write("</a>\n");
      out.write("              </td>\n");
      out.write("            </tr>\n");
      out.write("          ");
      return;
    }
    public boolean invoke17( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['w:date']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public boolean invoke18( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['w:confirmedDate']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public boolean invoke19( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['w:expirationDate']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public boolean invoke20( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['w:recordId']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public void invoke21( JspWriter out ) 
      throws Throwable
    {
      if (_jspx_meth_x_parse_4(_jspx_parent, _jspx_page_context))
        return;
      out.write("<tr>\n");
      out.write("              <td>\n");
      out.write("                <a href=\"view_transaction_details.jsp?transaction_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write('"');
      out.write('>');
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</a>\n");
      out.write("              </td>\n");
      out.write("              <td>\n");
      out.write("                ");
      //  jxp:set
      org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_4 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
      java.util.HashMap _jspx_th_jxp_set_4_aliasMap = new java.util.HashMap();
      _jspx_th_jxp_set_4_aliasMap.put("punt", "thisTitle");
      _jspx_th_jxp_set_4.setJspContext(_jspx_page_context, _jspx_th_jxp_set_4_aliasMap);
      _jspx_th_jxp_set_4.setParent(_jspx_parent);
      _jspx_th_jxp_set_4.setVar("thisTitle");
      _jspx_th_jxp_set_4.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisRecord}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_set_4.setSelect("//mods:title");
      _jspx_th_jxp_set_4.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_set_4.doTag();
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:escapeXml(thisTitle)}", java.lang.String.class, (PageContext)_jspx_page_context, _jspx_fnmap_3, false));
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("                <a href=\"record_status_result.jsp?record_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['r:recordId']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;object_db=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['r:objectDb']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("\">\n");
      out.write("                  ");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['r:recordId']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      if (_jspx_meth_c_if_17(_jspx_parent, _jspx_page_context))
        return;
      out.write("</a>\n");
      out.write("              </td>\n");
      out.write("              <td>\n");
      out.write("                ");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['r:volumeId']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("                ");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['r:objectLocation']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("                ");
      if (_jspx_meth_util_formatDate_10(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("              ");
      //  util:isLate
      org.apache.jsp.tag.web.commons.util.isLate_tag _jspx_th_util_isLate_0 = new org.apache.jsp.tag.web.commons.util.isLate_tag();
      java.util.HashMap _jspx_th_util_isLate_0_aliasMap = new java.util.HashMap();
      _jspx_th_util_isLate_0_aliasMap.put("varout", "late");
      _jspx_th_util_isLate_0.setJspContext(_jspx_page_context, _jspx_th_util_isLate_0_aliasMap);
      _jspx_th_util_isLate_0.setParent(_jspx_parent);
      _jspx_th_util_isLate_0.setVar("late");
      _jspx_th_util_isLate_0.setJspBody(new user_005fstatus_005fresult_jspHelper( 24, _jspx_page_context, _jspx_th_util_isLate_0, null));
      _jspx_th_util_isLate_0.doTag();
      out.write("<td ");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${late eq 'true' ? 'class=\"warn\"' : ''}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write(">\n");
      out.write("                ");
      if (_jspx_meth_util_formatDate_11(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("                ");
      if (_jspx_meth_util_formatDate_12(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("                <a href=\"../reservation/cancel/index.jsp?reservation_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("\">\n");
      out.write("                  ");
      if (_jspx_meth_fmt_message_72(_jspx_parent, _jspx_page_context))
        return;
      out.write("</a>\n");
      out.write("                ");
      if (_jspx_meth_c_if_18(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("            </tr>\n");
      out.write("          ");
      return;
    }
    public boolean invoke22( JspWriter out ) 
      throws Throwable
    {
      out.write("<query xmlns=\"http://kalio.net/empweb/schema/objectsquery/v1\">\n");
      out.write("                  <recordId>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['r:recordId']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</recordId>\n");
      out.write("                </query>\n");
      out.write("              ");
      return false;
    }
    public boolean invoke23( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['r:startDate']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public void invoke24( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['r:expirationDate']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return;
    }
    public boolean invoke25( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['r:expirationDate']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public boolean invoke26( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['r:endDate']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public void invoke27( JspWriter out ) 
      throws Throwable
    {
      if (_jspx_meth_x_parse_5(_jspx_parent, _jspx_page_context))
        return;
      if (_jspx_meth_c_set_17(_jspx_parent, _jspx_page_context))
        return;
      out.write("<tr>\n");
      out.write("              <td>\n");
      out.write("                <a href=\"view_transaction_details.jsp?transaction_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write('"');
      out.write('>');
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</a>\n");
      out.write("              </td>\n");
      out.write("              <td>\n");
      out.write("                ");
      //  jxp:set
      org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_5 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
      java.util.HashMap _jspx_th_jxp_set_5_aliasMap = new java.util.HashMap();
      _jspx_th_jxp_set_5_aliasMap.put("punt", "thisTitle");
      _jspx_th_jxp_set_5.setJspContext(_jspx_page_context, _jspx_th_jxp_set_5_aliasMap);
      _jspx_th_jxp_set_5.setParent(_jspx_parent);
      _jspx_th_jxp_set_5.setVar("thisTitle");
      _jspx_th_jxp_set_5.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisRecord}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_set_5.setSelect("//mods:title");
      _jspx_th_jxp_set_5.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_set_5.doTag();
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:escapeXml(thisTitle)}", java.lang.String.class, (PageContext)_jspx_page_context, _jspx_fnmap_3, false));
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("                ");
      if (_jspx_meth_jxp_out_9(_jspx_parent, _jspx_page_context))
        return;
      out.write("&nbsp;\n");
      out.write("                ");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisCopyId}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&nbsp;\n");
      out.write("                ");
      if (_jspx_meth_jxp_out_10(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("                <a href=\"record_status_result.jsp?record_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:recordId']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;object_db=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:objectDb']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("\">\n");
      out.write("                  ");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:recordId']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      if (_jspx_meth_c_if_20(_jspx_parent, _jspx_page_context))
        return;
      out.write("</a>\n");
      out.write("              </td>\n");
      out.write("              <td>\n");
      out.write("                ");
      if (_jspx_meth_util_formatDate_13(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("\n");
      out.write("              ");
      //  util:isLate
      org.apache.jsp.tag.web.commons.util.isLate_tag _jspx_th_util_isLate_1 = new org.apache.jsp.tag.web.commons.util.isLate_tag();
      java.util.HashMap _jspx_th_util_isLate_1_aliasMap = new java.util.HashMap();
      _jspx_th_util_isLate_1_aliasMap.put("varout", "late");
      _jspx_th_util_isLate_1.setJspContext(_jspx_page_context, _jspx_th_util_isLate_1_aliasMap);
      _jspx_th_util_isLate_1.setParent(_jspx_parent);
      _jspx_th_util_isLate_1.setVar("late");
      _jspx_th_util_isLate_1.setJspBody(new user_005fstatus_005fresult_jspHelper( 30, _jspx_page_context, _jspx_th_util_isLate_1, null));
      _jspx_th_util_isLate_1.doTag();
      out.write("<td ");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${late eq 'true' ? 'class=\"warn\"' : ''}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write(">\n");
      out.write("                ");
      if (_jspx_meth_util_formatDate_14(_jspx_parent, _jspx_page_context))
        return;
      out.write("</td>\n");
      out.write("              <td>\n");
      out.write("                <a href=\"../return/index.jsp?copy_ids=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisCopyId}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;object_db=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:objectDb']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;user_id=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_id}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&amp;user_db=");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${user_db}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("\">\n");
      out.write("                  ");
      if (_jspx_meth_fmt_message_82(_jspx_parent, _jspx_page_context))
        return;
      out.write("</a>\n");
      out.write("                ");
      out.write("</td>\n");
      out.write("            </tr>\n");
      out.write("          ");
      return;
    }
    public boolean invoke28( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:copyId']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public boolean invoke29( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:startDate']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return false;
    }
    public void invoke30( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:endDate']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      return;
    }
    public boolean invoke31( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:endDate']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
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
          case 1:
            invoke1( out );
            break;
          case 2:
            invoke2( out );
            break;
          case 3:
            invoke3( out );
            break;
          case 4:
            invoke4( out );
            break;
          case 5:
            invoke5( out );
            break;
          case 6:
            invoke6( out );
            break;
          case 7:
            invoke7( out );
            break;
          case 8:
            invoke8( out );
            break;
          case 9:
            invoke9( out );
            break;
          case 10:
            invoke10( out );
            break;
          case 11:
            invoke11( out );
            break;
          case 12:
            invoke12( out );
            break;
          case 13:
            invoke13( out );
            break;
          case 14:
            invoke14( out );
            break;
          case 15:
            invoke15( out );
            break;
          case 16:
            invoke16( out );
            break;
          case 17:
            invoke17( out );
            break;
          case 18:
            invoke18( out );
            break;
          case 19:
            invoke19( out );
            break;
          case 20:
            invoke20( out );
            break;
          case 21:
            invoke21( out );
            break;
          case 22:
            invoke22( out );
            break;
          case 23:
            invoke23( out );
            break;
          case 24:
            invoke24( out );
            break;
          case 25:
            invoke25( out );
            break;
          case 26:
            invoke26( out );
            break;
          case 27:
            invoke27( out );
            break;
          case 28:
            invoke28( out );
            break;
          case 29:
            invoke29( out );
            break;
          case 30:
            invoke30( out );
            break;
          case 31:
            invoke31( out );
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
