package org.apache.jsp.trans.wait.create;

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

public final class object_005fquery_005fresult_jsp extends org.apache.jasper.runtime.HttpJspBase
    implements org.apache.jasper.runtime.JspSourceDependent {

static private org.apache.jasper.runtime.ProtectedFunctionMapper _jspx_fnmap_0;
static private org.apache.jasper.runtime.ProtectedFunctionMapper _jspx_fnmap_1;
static private org.apache.jasper.runtime.ProtectedFunctionMapper _jspx_fnmap_2;
static private org.apache.jasper.runtime.ProtectedFunctionMapper _jspx_fnmap_3;

static {
  _jspx_fnmap_0= org.apache.jasper.runtime.ProtectedFunctionMapper.getMapForFunction("fn:split", org.apache.taglibs.standard.functions.Functions.class, "split", new Class[] {java.lang.String.class, java.lang.String.class});
  _jspx_fnmap_1= org.apache.jasper.runtime.ProtectedFunctionMapper.getMapForFunction("fn:substring", org.apache.taglibs.standard.functions.Functions.class, "substring", new Class[] {java.lang.String.class, int.class, int.class});
  _jspx_fnmap_2= org.apache.jasper.runtime.ProtectedFunctionMapper.getMapForFunction("fn:trim", org.apache.taglibs.standard.functions.Functions.class, "trim", new Class[] {java.lang.String.class});
  _jspx_fnmap_3= org.apache.jasper.runtime.ProtectedFunctionMapper.getMapForFunction("fn:length", org.apache.taglibs.standard.functions.Functions.class, "length", new Class[] {java.lang.Object.class});
}

  private static java.util.Vector _jspx_dependants;

  static {
    _jspx_dependants = new java.util.Vector(12);
    _jspx_dependants.add("/doctype.jspf");
    _jspx_dependants.add("/userlocale.jspf");
    _jspx_dependants.add("/dochead.jspf");
    _jspx_dependants.add("/institution.jspf");
    _jspx_dependants.add("/infobar.jspf");
    _jspx_dependants.add("/websbar.jspf");
    _jspx_dependants.add("/navbar.jspf");
    _jspx_dependants.add("/coda.jspf");
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/set.tag");
    _jspx_dependants.add("/WEB-INF/tags/trans/searchObjectsById.tag");
    _jspx_dependants.add("/WEB-INF/tags/trans/searchObjects.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/forEach.tag");
  }

  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_setLocale_value_scope_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_setBundle_scope_basename_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_message_key_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_url_value_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_if_test;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_forEach_var_items;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_value_target_property_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_choose;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_when_test;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_var_value_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_otherwise;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_x_parse_var;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_redirect_url_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_var;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_formatNumber_value_type_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_out_value_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_remove_var_nobody;
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
    _jspx_tagPool_c_choose = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_when_test = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_set_var_value_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_otherwise = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_x_parse_var = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_redirect_url_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_set_var = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_fmt_formatNumber_value_type_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_out_value_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_remove_var_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
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
    _jspx_tagPool_c_choose.release();
    _jspx_tagPool_c_when_test.release();
    _jspx_tagPool_c_set_var_value_nobody.release();
    _jspx_tagPool_c_otherwise.release();
    _jspx_tagPool_x_parse_var.release();
    _jspx_tagPool_c_redirect_url_nobody.release();
    _jspx_tagPool_c_set_var.release();
    _jspx_tagPool_fmt_formatNumber_value_type_nobody.release();
    _jspx_tagPool_c_out_value_nobody.release();
    _jspx_tagPool_c_remove_var_nobody.release();
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

    java.lang.Integer _jspx__jxpItem_1 = null;

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
      out.write("\t\t\t\t<h1>MEKELLE UNIVERSITY LIBRARY with VLIR/UOS support</h1>\n");
      out.write("\t\t\t\t<h2>ABCD - Empweb</h2>\n");
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
      out.write("<div id=\"pleasewait\">");
      if (_jspx_meth_fmt_message_11(_jspx_page_context))
        return;
      out.write("</div>\n");
 out.flush( ); 
      out.write("<script>\n");
      out.write("<!--\n");
      out.write("document.getElementById('pleasewait').style.display = \"none\"\n");
      out.write("-->\n");
      out.write("</script>\n");
      out.write("\n");
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
      //  jxp:set
      org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_0 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
      java.util.HashMap _jspx_th_jxp_set_0_aliasMap = new java.util.HashMap();
      _jspx_th_jxp_set_0_aliasMap.put("punt", "modsResult");
      _jspx_th_jxp_set_0.setJspContext(_jspx_page_context, _jspx_th_jxp_set_0_aliasMap);
      _jspx_th_jxp_set_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${objectResult}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_set_0.setVar("modsResult");
      _jspx_th_jxp_set_0.setSelect("/mod:modsCollection");
      _jspx_th_jxp_set_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_set_0.doTag();
      java.util.HashMap extraParams = null;
      synchronized (_jspx_page_context) {
        extraParams = (java.util.HashMap) _jspx_page_context.getAttribute("extraParams", PageContext.PAGE_SCOPE);
        if (extraParams == null){
          extraParams = new java.util.HashMap();
          _jspx_page_context.setAttribute("extraParams", extraParams, PageContext.PAGE_SCOPE);
        }
      }
      if (_jspx_meth_c_if_1(_jspx_page_context))
        return;
      if (_jspx_meth_c_if_2(_jspx_page_context))
        return;
      if (_jspx_meth_c_if_3(_jspx_page_context))
        return;
      if (_jspx_meth_c_if_4(_jspx_page_context))
        return;
      if (_jspx_meth_c_if_5(_jspx_page_context))
        return;
      out.write("<!--\n");
      out.write("\n");
      out.write("-->\n");
      if (_jspx_meth_c_choose_0(_jspx_page_context))
        return;
      if (_jspx_meth_c_choose_1(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_10(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_11(_jspx_page_context))
        return;
      //  jxp:set
      org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_1 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
      java.util.HashMap _jspx_th_jxp_set_1_aliasMap = new java.util.HashMap();
      _jspx_th_jxp_set_1_aliasMap.put("punt", "results_count");
      _jspx_th_jxp_set_1.setJspContext(_jspx_page_context, _jspx_th_jxp_set_1_aliasMap);
      _jspx_th_jxp_set_1.setVar("results_count");
      _jspx_th_jxp_set_1.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${objectResult}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_set_1.setSelect("count(//*[local-name()='mods'])");
      _jspx_th_jxp_set_1.doTag();
      //  c:choose
      org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_4 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
      _jspx_th_c_choose_4.setPageContext(_jspx_page_context);
      _jspx_th_c_choose_4.setParent(null);
      int _jspx_eval_c_choose_4 = _jspx_th_c_choose_4.doStartTag();
      if (_jspx_eval_c_choose_4 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
          if (_jspx_meth_c_when_8(_jspx_th_c_choose_4, _jspx_page_context))
            return;
          if (_jspx_meth_c_when_11(_jspx_th_c_choose_4, _jspx_page_context))
            return;
          //  c:otherwise
          org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_4 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
          _jspx_th_c_otherwise_4.setPageContext(_jspx_page_context);
          _jspx_th_c_otherwise_4.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_4);
          int _jspx_eval_c_otherwise_4 = _jspx_th_c_otherwise_4.doStartTag();
          if (_jspx_eval_c_otherwise_4 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
            do {
              if (_jspx_meth_c_set_12(_jspx_th_c_otherwise_4, _jspx_page_context))
                return;
              out.write("<div class=\"middle homepage\">\n");
              out.write("\n");
              out.write("      <table id=\"result\">\n");
              out.write("        ");
              out.write("<tr>\n");
              out.write("          ");
              if (_jspx_meth_c_if_11(_jspx_th_c_otherwise_4, _jspx_page_context))
                return;
              out.write("<th>\n");
              out.write("            <a href=\"");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisUrlPrefix}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
              out.write("&amp;sort_element=recordid&amp;sort_order=");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_order eq 'ascending')?'descending':'ascending'}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
              out.write("\">\n");
              out.write("              ");
              if (_jspx_meth_fmt_message_15(_jspx_th_c_otherwise_4, _jspx_page_context))
                return;
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_element eq 'recordid')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
              out.write("</a>\n");
              out.write("          </th>\n");
              out.write("          <th>\n");
              out.write("            ");
              if (_jspx_meth_fmt_message_16(_jspx_th_c_otherwise_4, _jspx_page_context))
                return;
              out.write("</th>\n");
              out.write("          <th>\n");
              out.write("            ");
              if (_jspx_meth_fmt_message_17(_jspx_th_c_otherwise_4, _jspx_page_context))
                return;
              out.write("</th>\n");
              out.write("          <th>\n");
              out.write("            <a href=\"");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisUrlPrefix}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
              out.write("&amp;sort_element=title&amp;sort_order=");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_order eq 'ascending')?'descending':'ascending'}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
              out.write("\">\n");
              out.write("              ");
              if (_jspx_meth_fmt_message_18(_jspx_th_c_otherwise_4, _jspx_page_context))
                return;
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_element eq 'title')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
              out.write("</a>\n");
              out.write("          </th>\n");
              out.write("          <th>\n");
              out.write("            <a href=\"");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisUrlPrefix}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
              out.write("&amp;sort_element=author&amp;sort_order=");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_order eq 'ascending')?'descending':'ascending'}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
              out.write("\">\n");
              out.write("              ");
              if (_jspx_meth_fmt_message_19(_jspx_th_c_otherwise_4, _jspx_page_context))
                return;
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_element eq 'author')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
              out.write("</a>\n");
              out.write("          </th>\n");
              out.write("          <th>\n");
              out.write("            ");
              if (_jspx_meth_fmt_message_20(_jspx_th_c_otherwise_4, _jspx_page_context))
                return;
              out.write("</th>                    \n");
              out.write("          <th>\n");
              out.write("            ");
              if (_jspx_meth_fmt_message_21(_jspx_th_c_otherwise_4, _jspx_page_context))
                return;
              out.write("</th>\n");
              out.write("        </tr>\n");
              out.write("\n");
              out.write("        ");
              //  jxp:forEach
              org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_0 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
              java.util.HashMap _jspx_th_jxp_forEach_0_aliasMap = new java.util.HashMap();
              _jspx_th_jxp_forEach_0_aliasMap.put("punt", "ptr");
              _jspx_th_jxp_forEach_0.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_0_aliasMap);
              _jspx_th_jxp_forEach_0.setParent(_jspx_th_c_otherwise_4);
              _jspx_th_jxp_forEach_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${objectResult}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
              _jspx_th_jxp_forEach_0.setVar("ptr");
              _jspx_th_jxp_forEach_0.setSelect("//mod:mods");
              _jspx_th_jxp_forEach_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
              _jspx_th_jxp_forEach_0.setSortby((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${sortElement}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
              _jspx_th_jxp_forEach_0.setSortorder((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${sortOrder}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
              _jspx_th_jxp_forEach_0.setJspBody(new object_005fquery_005fresult_jspHelper( 2, _jspx_page_context, _jspx_th_jxp_forEach_0, null));
              _jspx_th_jxp_forEach_0.doTag();
              out.write("<tr><td><strong>");
              if (_jspx_meth_fmt_message_22(_jspx_th_c_otherwise_4, _jspx_page_context))
                return;
              out.write(':');
              out.write(' ');
              if (_jspx_meth_fmt_formatNumber_1(_jspx_th_c_otherwise_4, _jspx_page_context))
                return;
              out.write("</strong></td></tr>\n");
              out.write("      </table>\n");
              out.write("\n");
              out.write("    </div>\n");
              out.write("\n");
              out.write("  ");
              int evalDoAfterBody = _jspx_th_c_otherwise_4.doAfterBody();
              if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                break;
            } while (true);
          }
          if (_jspx_th_c_otherwise_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
            return;
          _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_4);
          int evalDoAfterBody = _jspx_th_c_choose_4.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_choose_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        return;
      _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_4);

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

  private boolean _jspx_meth_fmt_message_11(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_11 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_11.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_11.setParent(null);
    _jspx_th_fmt_message_11.setKey("please_wait");
    int _jspx_eval_fmt_message_11 = _jspx_th_fmt_message_11.doStartTag();
    if (_jspx_th_fmt_message_11.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_11);
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
    _jspx_th_c_set_0.setProperty("mod");
    _jspx_th_c_set_0.setValue(new String("http://www.loc.gov/mods/v3"));
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
    _jspx_th_c_set_1.setProperty("hol");
    _jspx_th_c_set_1.setValue(new String("http://kalio.net/empweb/schema/holdingsinfo/v1"));
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
    _jspx_th_c_set_2.setProperty("qr");
    _jspx_th_c_set_2.setValue(new String("http://kalio.net/empweb/schema/queryresult/v1"));
    int _jspx_eval_c_set_2 = _jspx_th_c_set_2.doStartTag();
    if (_jspx_th_c_set_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_2);
    return false;
  }

  private boolean _jspx_meth_c_if_1(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_1 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_1.setPageContext(_jspx_page_context);
    _jspx_th_c_if_1.setParent(null);
    _jspx_th_c_if_1.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty fn:trim(param.object_recordid)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false)).booleanValue());
    int _jspx_eval_c_if_1 = _jspx_th_c_if_1.doStartTag();
    if (_jspx_eval_c_if_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_set_3(_jspx_th_c_if_1, _jspx_page_context))
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

  private boolean _jspx_meth_c_set_3(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_3 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_3.setPageContext(_jspx_page_context);
    _jspx_th_c_set_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_1);
    _jspx_th_c_set_3.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${extraParams}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_3.setProperty("object_recordid");
    _jspx_th_c_set_3.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(param.object_recordid)}", java.lang.Object.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false));
    int _jspx_eval_c_set_3 = _jspx_th_c_set_3.doStartTag();
    if (_jspx_th_c_set_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_3);
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
    _jspx_th_c_if_2.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty fn:trim(param.object_title)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false)).booleanValue());
    int _jspx_eval_c_if_2 = _jspx_th_c_if_2.doStartTag();
    if (_jspx_eval_c_if_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_set_4(_jspx_th_c_if_2, _jspx_page_context))
          return true;
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

  private boolean _jspx_meth_c_set_4(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_2, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_4 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_4.setPageContext(_jspx_page_context);
    _jspx_th_c_set_4.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_2);
    _jspx_th_c_set_4.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${extraParams}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_4.setProperty("object_title");
    _jspx_th_c_set_4.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(param.object_title)}", java.lang.Object.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false));
    int _jspx_eval_c_set_4 = _jspx_th_c_set_4.doStartTag();
    if (_jspx_th_c_set_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_4);
    return false;
  }

  private boolean _jspx_meth_c_if_3(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_3 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_3.setPageContext(_jspx_page_context);
    _jspx_th_c_if_3.setParent(null);
    _jspx_th_c_if_3.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty fn:trim(param.object_author)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false)).booleanValue());
    int _jspx_eval_c_if_3 = _jspx_th_c_if_3.doStartTag();
    if (_jspx_eval_c_if_3 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_set_5(_jspx_th_c_if_3, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_if_3.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_3);
    return false;
  }

  private boolean _jspx_meth_c_set_5(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_3, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_5 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_5.setPageContext(_jspx_page_context);
    _jspx_th_c_set_5.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_3);
    _jspx_th_c_set_5.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${extraParams}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_5.setProperty("object_author");
    _jspx_th_c_set_5.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(param.object_author)}", java.lang.Object.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false));
    int _jspx_eval_c_set_5 = _jspx_th_c_set_5.doStartTag();
    if (_jspx_th_c_set_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_5);
    return false;
  }

  private boolean _jspx_meth_c_if_4(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_4 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_4.setPageContext(_jspx_page_context);
    _jspx_th_c_if_4.setParent(null);
    _jspx_th_c_if_4.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty fn:trim(param.object_yearfrom)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false)).booleanValue());
    int _jspx_eval_c_if_4 = _jspx_th_c_if_4.doStartTag();
    if (_jspx_eval_c_if_4 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_set_6(_jspx_th_c_if_4, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_if_4.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_4);
    return false;
  }

  private boolean _jspx_meth_c_set_6(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_6 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_6.setPageContext(_jspx_page_context);
    _jspx_th_c_set_6.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_4);
    _jspx_th_c_set_6.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${extraParams}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_6.setProperty("object_yearfrom");
    _jspx_th_c_set_6.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(param.object_yearfrom)}", java.lang.Object.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false));
    int _jspx_eval_c_set_6 = _jspx_th_c_set_6.doStartTag();
    if (_jspx_th_c_set_6.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_6);
    return false;
  }

  private boolean _jspx_meth_c_if_5(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_5 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_5.setPageContext(_jspx_page_context);
    _jspx_th_c_if_5.setParent(null);
    _jspx_th_c_if_5.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty fn:trim(param.object_yearto)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false)).booleanValue());
    int _jspx_eval_c_if_5 = _jspx_th_c_if_5.doStartTag();
    if (_jspx_eval_c_if_5 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_set_7(_jspx_th_c_if_5, _jspx_page_context))
          return true;
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

  private boolean _jspx_meth_c_set_7(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_5, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_7 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_7.setPageContext(_jspx_page_context);
    _jspx_th_c_set_7.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_5);
    _jspx_th_c_set_7.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${extraParams}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_7.setProperty("object_yearto");
    _jspx_th_c_set_7.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(param.object_yearto)}", java.lang.Object.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false));
    int _jspx_eval_c_set_7 = _jspx_th_c_set_7.doStartTag();
    if (_jspx_th_c_set_7.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_7);
    return false;
  }

  private boolean _jspx_meth_c_choose_0(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
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
      return true;
    _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_0);
    return false;
  }

  private boolean _jspx_meth_c_when_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_0 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_0.setPageContext(_jspx_page_context);
    _jspx_th_c_when_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_0);
    _jspx_th_c_when_0.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty extraParams.object_yearfrom and not empty extraParams.object_yearto}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_when_0 = _jspx_th_c_when_0.doStartTag();
    if (_jspx_eval_c_when_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_set_8(_jspx_th_c_when_0, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_when_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_0);
    return false;
  }

  private boolean _jspx_meth_c_set_8(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_8 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_8.setPageContext(_jspx_page_context);
    _jspx_th_c_set_8.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_0);
    _jspx_th_c_set_8.setVar("numExtraParams");
    _jspx_th_c_set_8.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:length(extraParams) - 1}", java.lang.Object.class, (PageContext)_jspx_page_context, _jspx_fnmap_3, false));
    int _jspx_eval_c_set_8 = _jspx_th_c_set_8.doStartTag();
    if (_jspx_th_c_set_8.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_var_value_nobody.reuse(_jspx_th_c_set_8);
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
        if (_jspx_meth_c_set_9(_jspx_th_c_otherwise_0, _jspx_page_context))
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

  private boolean _jspx_meth_c_set_9(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_9 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_9.setPageContext(_jspx_page_context);
    _jspx_th_c_set_9.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_0);
    _jspx_th_c_set_9.setVar("numExtraParams");
    _jspx_th_c_set_9.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:length(extraParams)}", java.lang.Object.class, (PageContext)_jspx_page_context, _jspx_fnmap_3, false));
    int _jspx_eval_c_set_9 = _jspx_th_c_set_9.doStartTag();
    if (_jspx_th_c_set_9.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_var_value_nobody.reuse(_jspx_th_c_set_9);
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
        if (_jspx_meth_c_when_2(_jspx_th_c_choose_1, _jspx_page_context))
          return true;
        if (_jspx_meth_c_otherwise_2(_jspx_th_c_choose_1, _jspx_page_context))
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
    _jspx_th_c_when_1.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty fn:trim(param.object_copyid)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false)).booleanValue());
    int _jspx_eval_c_when_1 = _jspx_th_c_when_1.doStartTag();
    if (_jspx_eval_c_when_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_x_parse_0(_jspx_th_c_when_1, _jspx_page_context))
          return true;
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

  private boolean _jspx_meth_x_parse_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_0 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_var.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_0.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_1);
    _jspx_th_x_parse_0.setVar("objectResult");
    int _jspx_eval_x_parse_0 = _jspx_th_x_parse_0.doStartTag();
    if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_0.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_0.doInitBody();
      }
      do {
        if (_jspx_meth_trans_searchObjectsById_0(_jspx_th_x_parse_0, _jspx_page_context))
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
    _jspx_tagPool_x_parse_var.reuse(_jspx_th_x_parse_0);
    return false;
  }

  private boolean _jspx_meth_trans_searchObjectsById_0(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  trans:searchObjectsById
    org.apache.jsp.tag.web.trans.searchObjectsById_tag _jspx_th_trans_searchObjectsById_0 = new org.apache.jsp.tag.web.trans.searchObjectsById_tag();
    _jspx_th_trans_searchObjectsById_0.setJspContext(_jspx_page_context);
    _jspx_th_trans_searchObjectsById_0.setParent(_jspx_th_x_parse_0);
    _jspx_th_trans_searchObjectsById_0.setDatabase((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(param.database)}", java.lang.String.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false));
    _jspx_th_trans_searchObjectsById_0.setJspBody(new object_005fquery_005fresult_jspHelper( 0, _jspx_page_context, _jspx_th_trans_searchObjectsById_0, null));
    _jspx_th_trans_searchObjectsById_0.doTag();
    return false;
  }

  private boolean _jspx_meth_c_when_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_2 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_2.setPageContext(_jspx_page_context);
    _jspx_th_c_when_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_1);
    _jspx_th_c_when_2.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${numExtraParams gt 0}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_when_2 = _jspx_th_c_when_2.doStartTag();
    if (_jspx_eval_c_when_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_x_parse_1(_jspx_th_c_when_2, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_when_2.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_2);
    return false;
  }

  private boolean _jspx_meth_x_parse_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_2, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_1 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_var.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_1.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_2);
    _jspx_th_x_parse_1.setVar("objectResult");
    int _jspx_eval_x_parse_1 = _jspx_th_x_parse_1.doStartTag();
    if (_jspx_eval_x_parse_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_1 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_1.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_1.doInitBody();
      }
      do {
        if (_jspx_meth_trans_searchObjects_0(_jspx_th_x_parse_1, _jspx_page_context))
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
    _jspx_tagPool_x_parse_var.reuse(_jspx_th_x_parse_1);
    return false;
  }

  private boolean _jspx_meth_trans_searchObjects_0(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  trans:searchObjects
    org.apache.jsp.tag.web.trans.searchObjects_tag _jspx_th_trans_searchObjects_0 = new org.apache.jsp.tag.web.trans.searchObjects_tag();
    _jspx_th_trans_searchObjects_0.setJspContext(_jspx_page_context);
    _jspx_th_trans_searchObjects_0.setParent(_jspx_th_x_parse_1);
    _jspx_th_trans_searchObjects_0.setDatabase((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(param.database)}", java.lang.String.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false));
    _jspx_th_trans_searchObjects_0.setJspBody(new object_005fquery_005fresult_jspHelper( 1, _jspx_page_context, _jspx_th_trans_searchObjects_0, null));
    _jspx_th_trans_searchObjects_0.doTag();
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
        if (_jspx_meth_c_when_3(_jspx_th_c_choose_2, _jspx_page_context))
          return true;
        if (_jspx_meth_c_otherwise_1(_jspx_th_c_choose_2, _jspx_page_context))
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

  private boolean _jspx_meth_c_when_3(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_2, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_3 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_3.setPageContext(_jspx_page_context);
    _jspx_th_c_when_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_2);
    _jspx_th_c_when_3.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ not empty extraParams.object_recordid}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_when_3 = _jspx_th_c_when_3.doStartTag();
    if (_jspx_eval_c_when_3 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<recordId>");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${extraParams.object_recordid}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("</recordId>\n");
        out.write("            ");
        int evalDoAfterBody = _jspx_th_c_when_3.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_3);
    return false;
  }

  private boolean _jspx_meth_c_otherwise_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_2, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:otherwise
    org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_1 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
    _jspx_th_c_otherwise_1.setPageContext(_jspx_page_context);
    _jspx_th_c_otherwise_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_2);
    int _jspx_eval_c_otherwise_1 = _jspx_th_c_otherwise_1.doStartTag();
    if (_jspx_eval_c_otherwise_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_if_6(_jspx_th_c_otherwise_1, _jspx_page_context))
          return true;
        if (_jspx_meth_c_if_7(_jspx_th_c_otherwise_1, _jspx_page_context))
          return true;
        if (_jspx_meth_c_if_8(_jspx_th_c_otherwise_1, _jspx_page_context))
          return true;
        if (_jspx_meth_c_if_9(_jspx_th_c_otherwise_1, _jspx_page_context))
          return true;
        if (_jspx_meth_c_if_10(_jspx_th_c_otherwise_1, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_otherwise_1.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_otherwise_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_1);
    return false;
  }

  private boolean _jspx_meth_c_if_6(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_6 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_6.setPageContext(_jspx_page_context);
    _jspx_th_c_if_6.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_1);
    _jspx_th_c_if_6.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${numExtraParams gt 1}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_6 = _jspx_th_c_if_6.doStartTag();
    if (_jspx_eval_c_if_6 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<and>\n");
        out.write("              ");
        int evalDoAfterBody = _jspx_th_c_if_6.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_6.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_6);
    return false;
  }

  private boolean _jspx_meth_c_if_7(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_7 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_7.setPageContext(_jspx_page_context);
    _jspx_th_c_if_7.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_1);
    _jspx_th_c_if_7.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty extraParams.object_title}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_7 = _jspx_th_c_if_7.doStartTag();
    if (_jspx_eval_c_if_7 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<title>");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${extraParams.object_title}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("</title>\n");
        out.write("              ");
        int evalDoAfterBody = _jspx_th_c_if_7.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_7.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_7);
    return false;
  }

  private boolean _jspx_meth_c_if_8(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_8 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_8.setPageContext(_jspx_page_context);
    _jspx_th_c_if_8.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_1);
    _jspx_th_c_if_8.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty extraParams.object_author}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_8 = _jspx_th_c_if_8.doStartTag();
    if (_jspx_eval_c_if_8 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<author>");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${extraParams.object_author}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("</author>\n");
        out.write("              ");
        int evalDoAfterBody = _jspx_th_c_if_8.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_8.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_8);
    return false;
  }

  private boolean _jspx_meth_c_if_9(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_9 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_9.setPageContext(_jspx_page_context);
    _jspx_th_c_if_9.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_1);
    _jspx_th_c_if_9.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(not empty extraParams.object_yearfrom) or (not empty extraParams.object_yearto)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_9 = _jspx_th_c_if_9.doStartTag();
    if (_jspx_eval_c_if_9 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<year from=\"");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${extraParams.object_yearfrom}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("\" to=\"");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${extraParams.object_yearto}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("\"/>\n");
        out.write("              ");
        int evalDoAfterBody = _jspx_th_c_if_9.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_9.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_9);
    return false;
  }

  private boolean _jspx_meth_c_if_10(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_10 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_10.setPageContext(_jspx_page_context);
    _jspx_th_c_if_10.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_1);
    _jspx_th_c_if_10.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${numExtraParams gt 1}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_10 = _jspx_th_c_if_10.doStartTag();
    if (_jspx_eval_c_if_10 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("</and>\n");
        out.write("              ");
        int evalDoAfterBody = _jspx_th_c_if_10.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_10.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_10);
    return false;
  }

  private boolean _jspx_meth_c_otherwise_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_1, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:otherwise
    org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_2 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
    _jspx_th_c_otherwise_2.setPageContext(_jspx_page_context);
    _jspx_th_c_otherwise_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_1);
    int _jspx_eval_c_otherwise_2 = _jspx_th_c_otherwise_2.doStartTag();
    if (_jspx_eval_c_otherwise_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_redirect_0(_jspx_th_c_otherwise_2, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_otherwise_2.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_otherwise_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_2);
    return false;
  }

  private boolean _jspx_meth_c_redirect_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:redirect
    org.apache.taglibs.standard.tag.rt.core.RedirectTag _jspx_th_c_redirect_0 = (org.apache.taglibs.standard.tag.rt.core.RedirectTag) _jspx_tagPool_c_redirect_url_nobody.get(org.apache.taglibs.standard.tag.rt.core.RedirectTag.class);
    _jspx_th_c_redirect_0.setPageContext(_jspx_page_context);
    _jspx_th_c_redirect_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_redirect_0.setUrl("index.jsp");
    int _jspx_eval_c_redirect_0 = _jspx_th_c_redirect_0.doStartTag();
    if (_jspx_th_c_redirect_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_redirect_url_nobody.reuse(_jspx_th_c_redirect_0);
    return false;
  }

  private boolean _jspx_meth_c_set_10(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_10 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_10.setPageContext(_jspx_page_context);
    _jspx_th_c_set_10.setParent(null);
    _jspx_th_c_set_10.setVar("sortElement");
    int _jspx_eval_c_set_10 = _jspx_th_c_set_10.doStartTag();
    if (_jspx_eval_c_set_10 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_10 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_10.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_10.doInitBody();
      }
      do {
        if (_jspx_meth_c_choose_3(_jspx_th_c_set_10, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_set_10.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_10 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_10.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_10);
    return false;
  }

  private boolean _jspx_meth_c_choose_3(javax.servlet.jsp.tagext.JspTag _jspx_th_c_set_10, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:choose
    org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_3 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
    _jspx_th_c_choose_3.setPageContext(_jspx_page_context);
    _jspx_th_c_choose_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_set_10);
    int _jspx_eval_c_choose_3 = _jspx_th_c_choose_3.doStartTag();
    if (_jspx_eval_c_choose_3 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_when_4(_jspx_th_c_choose_3, _jspx_page_context))
          return true;
        if (_jspx_meth_c_when_5(_jspx_th_c_choose_3, _jspx_page_context))
          return true;
        if (_jspx_meth_c_when_6(_jspx_th_c_choose_3, _jspx_page_context))
          return true;
        if (_jspx_meth_c_when_7(_jspx_th_c_choose_3, _jspx_page_context))
          return true;
        if (_jspx_meth_c_otherwise_3(_jspx_th_c_choose_3, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_choose_3.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_choose_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_3);
    return false;
  }

  private boolean _jspx_meth_c_when_4(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_3, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_4 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_4.setPageContext(_jspx_page_context);
    _jspx_th_c_when_4.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_3);
    _jspx_th_c_when_4.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.sort_element eq 'recordid'}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_when_4 = _jspx_th_c_when_4.doStartTag();
    if (_jspx_eval_c_when_4 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("mod:recordInfo/mod:recordIdentifier");
        int evalDoAfterBody = _jspx_th_c_when_4.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_4);
    return false;
  }

  private boolean _jspx_meth_c_when_5(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_3, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_5 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_5.setPageContext(_jspx_page_context);
    _jspx_th_c_when_5.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_3);
    _jspx_th_c_when_5.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.sort_element eq 'title'}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_when_5 = _jspx_th_c_when_5.doStartTag();
    if (_jspx_eval_c_when_5 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("mod:titleInfo/mod:title");
        int evalDoAfterBody = _jspx_th_c_when_5.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_5);
    return false;
  }

  private boolean _jspx_meth_c_when_6(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_3, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_6 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_6.setPageContext(_jspx_page_context);
    _jspx_th_c_when_6.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_3);
    _jspx_th_c_when_6.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.sort_element eq 'author'}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_when_6 = _jspx_th_c_when_6.doStartTag();
    if (_jspx_eval_c_when_6 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("mod:name/mod:namePart");
        int evalDoAfterBody = _jspx_th_c_when_6.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_6.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_6);
    return false;
  }

  private boolean _jspx_meth_c_when_7(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_3, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_7 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_7.setPageContext(_jspx_page_context);
    _jspx_th_c_when_7.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_3);
    _jspx_th_c_when_7.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.show_all_copies eq '1'}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_when_7 = _jspx_th_c_when_7.doStartTag();
    if (_jspx_eval_c_when_7 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("hol:holdingsInfo/hol:copies/hol:copy/hol:copyId");
        int evalDoAfterBody = _jspx_th_c_when_7.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_7.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_7);
    return false;
  }

  private boolean _jspx_meth_c_otherwise_3(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_3, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:otherwise
    org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_3 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
    _jspx_th_c_otherwise_3.setPageContext(_jspx_page_context);
    _jspx_th_c_otherwise_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_3);
    int _jspx_eval_c_otherwise_3 = _jspx_th_c_otherwise_3.doStartTag();
    if (_jspx_eval_c_otherwise_3 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("mod:titleInfo/mod:title");
        int evalDoAfterBody = _jspx_th_c_otherwise_3.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_otherwise_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_3);
    return false;
  }

  private boolean _jspx_meth_c_set_11(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_11 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_11.setPageContext(_jspx_page_context);
    _jspx_th_c_set_11.setParent(null);
    _jspx_th_c_set_11.setVar("sortOrder");
    int _jspx_eval_c_set_11 = _jspx_th_c_set_11.doStartTag();
    if (_jspx_eval_c_set_11 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_11 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_11.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_11.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(not empty param.sort_order)?param.sort_order:'ascending'}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        int evalDoAfterBody = _jspx_th_c_set_11.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_11 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_11.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_11);
    return false;
  }

  private boolean _jspx_meth_c_when_8(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_8 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_8.setPageContext(_jspx_page_context);
    _jspx_th_c_when_8.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_4);
    _jspx_th_c_when_8.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(empty param.show_all_copies) and (results_count eq 1) and (not empty fn:trim(param.database)) and (fn:trim(param.database) ne '*') and (empty param.action)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false)).booleanValue());
    int _jspx_eval_c_when_8 = _jspx_th_c_when_8.doStartTag();
    if (_jspx_eval_c_when_8 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_choose_5(_jspx_th_c_when_8, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_when_8.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_8.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_8);
    return false;
  }

  private boolean _jspx_meth_c_choose_5(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_8, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:choose
    org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_5 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
    _jspx_th_c_choose_5.setPageContext(_jspx_page_context);
    _jspx_th_c_choose_5.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_8);
    int _jspx_eval_c_choose_5 = _jspx_th_c_choose_5.doStartTag();
    if (_jspx_eval_c_choose_5 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_when_9(_jspx_th_c_choose_5, _jspx_page_context))
          return true;
        if (_jspx_meth_c_when_10(_jspx_th_c_choose_5, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_choose_5.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_choose_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_5);
    return false;
  }

  private boolean _jspx_meth_c_when_9(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_5, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_9 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_9.setPageContext(_jspx_page_context);
    _jspx_th_c_when_9.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_5);
    _jspx_th_c_when_9.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(not empty fn:trim(param.object_copyid))}", java.lang.Boolean.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false)).booleanValue());
    int _jspx_eval_c_when_9 = _jspx_th_c_when_9.doStartTag();
    if (_jspx_eval_c_when_9 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_redirect_1(_jspx_th_c_when_9, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_when_9.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_9.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_9);
    return false;
  }

  private boolean _jspx_meth_c_redirect_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_9, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:redirect
    org.apache.taglibs.standard.tag.rt.core.RedirectTag _jspx_th_c_redirect_1 = (org.apache.taglibs.standard.tag.rt.core.RedirectTag) _jspx_tagPool_c_redirect_url_nobody.get(org.apache.taglibs.standard.tag.rt.core.RedirectTag.class);
    _jspx_th_c_redirect_1.setPageContext(_jspx_page_context);
    _jspx_th_c_redirect_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_9);
    _jspx_th_c_redirect_1.setUrl((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("copy_status_result.jsp?copy_id=${fn:trim(param.object_copyid)}&object_db=${fn:trim(param.database)}", java.lang.String.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false));
    int _jspx_eval_c_redirect_1 = _jspx_th_c_redirect_1.doStartTag();
    if (_jspx_th_c_redirect_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_redirect_url_nobody.reuse(_jspx_th_c_redirect_1);
    return false;
  }

  private boolean _jspx_meth_c_when_10(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_5, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_10 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_10.setPageContext(_jspx_page_context);
    _jspx_th_c_when_10.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_5);
    _jspx_th_c_when_10.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(not empty fn:trim(param.object_recordid))}", java.lang.Boolean.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false)).booleanValue());
    int _jspx_eval_c_when_10 = _jspx_th_c_when_10.doStartTag();
    if (_jspx_eval_c_when_10 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_redirect_2(_jspx_th_c_when_10, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_when_10.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_10.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_10);
    return false;
  }

  private boolean _jspx_meth_c_redirect_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_10, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:redirect
    org.apache.taglibs.standard.tag.rt.core.RedirectTag _jspx_th_c_redirect_2 = (org.apache.taglibs.standard.tag.rt.core.RedirectTag) _jspx_tagPool_c_redirect_url_nobody.get(org.apache.taglibs.standard.tag.rt.core.RedirectTag.class);
    _jspx_th_c_redirect_2.setPageContext(_jspx_page_context);
    _jspx_th_c_redirect_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_10);
    _jspx_th_c_redirect_2.setUrl((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("record_status_result.jsp?record_id=${fn:trim(param.object_recordid)}&object_db=${fn:trim(param.database)}", java.lang.String.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false));
    int _jspx_eval_c_redirect_2 = _jspx_th_c_redirect_2.doStartTag();
    if (_jspx_th_c_redirect_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_redirect_url_nobody.reuse(_jspx_th_c_redirect_2);
    return false;
  }

  private boolean _jspx_meth_c_when_11(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_11 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_11.setPageContext(_jspx_page_context);
    _jspx_th_c_when_11.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_4);
    _jspx_th_c_when_11.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${results_count == 0}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_when_11 = _jspx_th_c_when_11.doStartTag();
    if (_jspx_eval_c_when_11 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<div class=\"middle homepage\">\n");
        out.write("      <p>");
        if (_jspx_meth_fmt_message_12(_jspx_th_c_when_11, _jspx_page_context))
          return true;
        out.write("</p>\n");
        out.write("      <p><a href=\"index.jsp\">");
        if (_jspx_meth_fmt_message_13(_jspx_th_c_when_11, _jspx_page_context))
          return true;
        out.write("</a></p>\n");
        out.write("    </div>\n");
        out.write("  ");
        int evalDoAfterBody = _jspx_th_c_when_11.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_11.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_11);
    return false;
  }

  private boolean _jspx_meth_fmt_message_12(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_11, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_12 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_12.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_12.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_11);
    _jspx_th_fmt_message_12.setKey("no_results_found");
    int _jspx_eval_fmt_message_12 = _jspx_th_fmt_message_12.doStartTag();
    if (_jspx_th_fmt_message_12.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_12);
    return false;
  }

  private boolean _jspx_meth_fmt_message_13(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_11, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_13 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_13.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_13.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_11);
    _jspx_th_fmt_message_13.setKey("back_to_query");
    int _jspx_eval_fmt_message_13 = _jspx_th_fmt_message_13.doStartTag();
    if (_jspx_th_fmt_message_13.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_13);
    return false;
  }

  private boolean _jspx_meth_c_set_12(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_12 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_12.setPageContext(_jspx_page_context);
    _jspx_th_c_set_12.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_4);
    _jspx_th_c_set_12.setVar("thisUrlPrefix");
    int _jspx_eval_c_set_12 = _jspx_th_c_set_12.doStartTag();
    if (_jspx_eval_c_set_12 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_12 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_12.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_12.doInitBody();
      }
      do {
        out.write("object_query_result.jsp?object_recordid=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.object_recordid}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("&amp;object_copyid=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.object_copyid}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("&amp;object_author=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.object_author}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("&amp;object_title=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.object_title}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("&amp;database=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.database}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
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

  private boolean _jspx_meth_c_if_11(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_11 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_11.setPageContext(_jspx_page_context);
    _jspx_th_c_if_11.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_4);
    _jspx_th_c_if_11.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not config['ew.hide_object_db']}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_11 = _jspx_th_c_if_11.doStartTag();
    if (_jspx_eval_c_if_11 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<th>");
        if (_jspx_meth_fmt_message_14(_jspx_th_c_if_11, _jspx_page_context))
          return true;
        out.write("</th>\n");
        out.write("          ");
        int evalDoAfterBody = _jspx_th_c_if_11.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_11.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_11);
    return false;
  }

  private boolean _jspx_meth_fmt_message_14(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_11, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_14 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_14.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_14.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_11);
    _jspx_th_fmt_message_14.setKey("database");
    int _jspx_eval_fmt_message_14 = _jspx_th_fmt_message_14.doStartTag();
    if (_jspx_th_fmt_message_14.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_14);
    return false;
  }

  private boolean _jspx_meth_fmt_message_15(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_15 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_15.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_15.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_4);
    _jspx_th_fmt_message_15.setKey("record_id");
    int _jspx_eval_fmt_message_15 = _jspx_th_fmt_message_15.doStartTag();
    if (_jspx_th_fmt_message_15.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_15);
    return false;
  }

  private boolean _jspx_meth_fmt_message_16(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_16 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_16.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_16.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_4);
    _jspx_th_fmt_message_16.setKey("volume_id");
    int _jspx_eval_fmt_message_16 = _jspx_th_fmt_message_16.doStartTag();
    if (_jspx_th_fmt_message_16.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_16);
    return false;
  }

  private boolean _jspx_meth_fmt_message_17(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_17 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_17.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_17.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_4);
    _jspx_th_fmt_message_17.setKey("copy_id");
    int _jspx_eval_fmt_message_17 = _jspx_th_fmt_message_17.doStartTag();
    if (_jspx_th_fmt_message_17.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_17);
    return false;
  }

  private boolean _jspx_meth_fmt_message_18(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_18 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_18.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_18.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_4);
    _jspx_th_fmt_message_18.setKey("title");
    int _jspx_eval_fmt_message_18 = _jspx_th_fmt_message_18.doStartTag();
    if (_jspx_th_fmt_message_18.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_18);
    return false;
  }

  private boolean _jspx_meth_fmt_message_19(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_19 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_19.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_19.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_4);
    _jspx_th_fmt_message_19.setKey("author");
    int _jspx_eval_fmt_message_19 = _jspx_th_fmt_message_19.doStartTag();
    if (_jspx_th_fmt_message_19.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_19);
    return false;
  }

  private boolean _jspx_meth_fmt_message_20(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_20 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_20.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_20.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_4);
    _jspx_th_fmt_message_20.setKey("object_category");
    int _jspx_eval_fmt_message_20 = _jspx_th_fmt_message_20.doStartTag();
    if (_jspx_th_fmt_message_20.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_20);
    return false;
  }

  private boolean _jspx_meth_fmt_message_21(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_21 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_21.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_21.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_4);
    _jspx_th_fmt_message_21.setKey("year");
    int _jspx_eval_fmt_message_21 = _jspx_th_fmt_message_21.doStartTag();
    if (_jspx_th_fmt_message_21.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_21);
    return false;
  }

  private boolean _jspx_meth_c_when_12(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_6, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_12 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_12.setPageContext(_jspx_page_context);
    _jspx_th_c_when_12.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_6);
    _jspx_th_c_when_12.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty param.volume_id}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_when_12 = _jspx_th_c_when_12.doStartTag();
    if (_jspx_eval_c_when_12 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_set_13(_jspx_th_c_when_12, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_when_12.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_12.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_12);
    return false;
  }

  private boolean _jspx_meth_c_set_13(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_12, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_13 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_13.setPageContext(_jspx_page_context);
    _jspx_th_c_set_13.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_12);
    _jspx_th_c_set_13.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${volsMap}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_13.setProperty((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.volume_id}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_13.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.volume_id}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    int _jspx_eval_c_set_13 = _jspx_th_c_set_13.doStartTag();
    if (_jspx_th_c_set_13.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_13);
    return false;
  }

  private boolean _jspx_meth_c_if_12(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_5, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_12 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_12.setPageContext(_jspx_page_context);
    _jspx_th_c_if_12.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_5);
    _jspx_th_c_if_12.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(fn:length(volsMap) == 0) or (totalCount > withVolCount)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, _jspx_fnmap_3, false)).booleanValue());
    int _jspx_eval_c_if_12 = _jspx_th_c_if_12.doStartTag();
    if (_jspx_eval_c_if_12 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_set_14(_jspx_th_c_if_12, _jspx_page_context))
          return true;
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

  private boolean _jspx_meth_c_set_14(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_12, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_14 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_14.setPageContext(_jspx_page_context);
    _jspx_th_c_set_14.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_12);
    _jspx_th_c_set_14.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${volsMap}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_14.setProperty("__");
    _jspx_th_c_set_14.setValue(new String(""));
    int _jspx_eval_c_set_14 = _jspx_th_c_set_14.doStartTag();
    if (_jspx_th_c_set_14.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_14);
    return false;
  }

  private boolean _jspx_meth_c_set_15(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_15 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_15.setPageContext(_jspx_page_context);
    _jspx_th_c_set_15.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_set_15.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${volsMap}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_15.setProperty((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr2['.']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_15.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr2['.']}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    int _jspx_eval_c_set_15 = _jspx_th_c_set_15.doStartTag();
    if (_jspx_th_c_set_15.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_15);
    return false;
  }

  private boolean _jspx_meth_c_set_16(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_16 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_16.setPageContext(_jspx_page_context);
    _jspx_th_c_set_16.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_set_16.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${catMap}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_16.setProperty((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr2['.']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_16.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr2['.']}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    int _jspx_eval_c_set_16 = _jspx_th_c_set_16.doStartTag();
    if (_jspx_th_c_set_16.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_16);
    return false;
  }

  private boolean _jspx_meth_c_if_13(javax.servlet.jsp.tagext.JspTag _jspx_th_c_forEach_1, PageContext _jspx_page_context, int[] _jspx_push_body_count_c_forEach_1)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_13 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_13.setPageContext(_jspx_page_context);
    _jspx_th_c_if_13.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_forEach_1);
    _jspx_th_c_if_13.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not config['ew.hide_object_db']}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_13 = _jspx_th_c_if_13.doStartTag();
    if (_jspx_eval_c_if_13 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<td>");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['ancestor::qr:databaseResult/@name']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("</td>\n");
        out.write("              ");
        int evalDoAfterBody = _jspx_th_c_if_13.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_13.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_13);
    return false;
  }

  private boolean _jspx_meth_c_choose_9(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_14, PageContext _jspx_page_context, int[] _jspx_push_body_count_c_forEach_1)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:choose
    org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_9 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
    _jspx_th_c_choose_9.setPageContext(_jspx_page_context);
    _jspx_th_c_choose_9.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_14);
    int _jspx_eval_c_choose_9 = _jspx_th_c_choose_9.doStartTag();
    if (_jspx_eval_c_choose_9 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_when_15(_jspx_th_c_choose_9, _jspx_page_context, _jspx_push_body_count_c_forEach_1))
          return true;
        if (_jspx_meth_c_otherwise_7(_jspx_th_c_choose_9, _jspx_page_context, _jspx_push_body_count_c_forEach_1))
          return true;
        int evalDoAfterBody = _jspx_th_c_choose_9.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_choose_9.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_9);
    return false;
  }

  private boolean _jspx_meth_c_when_15(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_9, PageContext _jspx_page_context, int[] _jspx_push_body_count_c_forEach_1)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_15 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_15.setPageContext(_jspx_page_context);
    _jspx_th_c_when_15.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_9);
    _jspx_th_c_when_15.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${vol.value eq ''}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_when_15 = _jspx_th_c_when_15.doStartTag();
    if (_jspx_eval_c_when_15 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_set_17(_jspx_th_c_when_15, _jspx_page_context, _jspx_push_body_count_c_forEach_1))
          return true;
        int evalDoAfterBody = _jspx_th_c_when_15.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_15.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_15);
    return false;
  }

  private boolean _jspx_meth_c_set_17(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_15, PageContext _jspx_page_context, int[] _jspx_push_body_count_c_forEach_1)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_17 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_17.setPageContext(_jspx_page_context);
    _jspx_th_c_set_17.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_15);
    _jspx_th_c_set_17.setVar("forEachVol");
    int _jspx_eval_c_set_17 = _jspx_th_c_set_17.doStartTag();
    if (_jspx_eval_c_set_17 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_17 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_push_body_count_c_forEach_1[0]++;
        _jspx_th_c_set_17.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_17.doInitBody();
      }
      do {
        out.write("mod:extension/hol:holdingsInfo/hol:copies/hol:copy[not(hol:volumeId)]");
        int evalDoAfterBody = _jspx_th_c_set_17.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_17 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
        _jspx_push_body_count_c_forEach_1[0]--;
    }
    if (_jspx_th_c_set_17.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_17);
    return false;
  }

  private boolean _jspx_meth_c_otherwise_7(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_9, PageContext _jspx_page_context, int[] _jspx_push_body_count_c_forEach_1)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:otherwise
    org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_7 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
    _jspx_th_c_otherwise_7.setPageContext(_jspx_page_context);
    _jspx_th_c_otherwise_7.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_9);
    int _jspx_eval_c_otherwise_7 = _jspx_th_c_otherwise_7.doStartTag();
    if (_jspx_eval_c_otherwise_7 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_set_18(_jspx_th_c_otherwise_7, _jspx_page_context, _jspx_push_body_count_c_forEach_1))
          return true;
        int evalDoAfterBody = _jspx_th_c_otherwise_7.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_otherwise_7.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_7);
    return false;
  }

  private boolean _jspx_meth_c_set_18(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_7, PageContext _jspx_page_context, int[] _jspx_push_body_count_c_forEach_1)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_18 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_18.setPageContext(_jspx_page_context);
    _jspx_th_c_set_18.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_7);
    _jspx_th_c_set_18.setVar("forEachVol");
    int _jspx_eval_c_set_18 = _jspx_th_c_set_18.doStartTag();
    if (_jspx_eval_c_set_18 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_18 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_push_body_count_c_forEach_1[0]++;
        _jspx_th_c_set_18.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_18.doInitBody();
      }
      do {
        out.write("mod:extension/hol:holdingsInfo/hol:copies/hol:copy[hol:volumeId='");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${vol.value}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write('\'');
        out.write(']');
        int evalDoAfterBody = _jspx_th_c_set_18.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_18 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
        _jspx_push_body_count_c_forEach_1[0]--;
    }
    if (_jspx_th_c_set_18.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_18);
    return false;
  }

  private boolean _jspx_meth_c_if_14(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context, int[] _jspx_push_body_count)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_14 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_14.setPageContext(_jspx_page_context);
    _jspx_th_c_if_14.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_if_14.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty ptr2['hol:copyLocation']}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_14 = _jspx_th_c_if_14.doStartTag();
    if (_jspx_eval_c_if_14 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr2[\"hol:copyLocation\"]}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write(":&nbsp;");
        int evalDoAfterBody = _jspx_th_c_if_14.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_14.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_14);
    return false;
  }

  private boolean _jspx_meth_c_if_15(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context, int[] _jspx_push_body_count)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_15 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_15.setPageContext(_jspx_page_context);
    _jspx_th_c_if_15.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_if_15.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty ptr2['hol:volumeId']}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_15 = _jspx_th_c_if_15.doStartTag();
    if (_jspx_eval_c_if_15 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("&nbsp;");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr2[\"hol:volumeId\"]}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
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

  private boolean _jspx_meth_c_otherwise_8(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_8, PageContext _jspx_page_context, int[] _jspx_push_body_count_c_forEach_1)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:otherwise
    org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_8 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
    _jspx_th_c_otherwise_8.setPageContext(_jspx_page_context);
    _jspx_th_c_otherwise_8.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_8);
    int _jspx_eval_c_otherwise_8 = _jspx_th_c_otherwise_8.doStartTag();
    if (_jspx_eval_c_otherwise_8 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<a href=\"object_query_result.jsp?show_all_copies=1&amp;object_recordid=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['mod:recordInfo/mod:recordIdentifier']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("&amp;database=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['ancestor::qr:databaseResult/@name']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("&amp;volume_id=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${vol.value}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
        out.write("\">\n");
        out.write("                      (");
        if (_jspx_meth_fmt_formatNumber_0(_jspx_th_c_otherwise_8, _jspx_page_context, _jspx_push_body_count_c_forEach_1))
          return true;
        out.write(")\n");
        out.write("                    </a>\n");
        out.write("                  ");
        int evalDoAfterBody = _jspx_th_c_otherwise_8.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_otherwise_8.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_8);
    return false;
  }

  private boolean _jspx_meth_fmt_formatNumber_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_8, PageContext _jspx_page_context, int[] _jspx_push_body_count_c_forEach_1)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:formatNumber
    org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag _jspx_th_fmt_formatNumber_0 = (org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag) _jspx_tagPool_fmt_formatNumber_value_type_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag.class);
    _jspx_th_fmt_formatNumber_0.setPageContext(_jspx_page_context);
    _jspx_th_fmt_formatNumber_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_8);
    _jspx_th_fmt_formatNumber_0.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${copiesCount}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_fmt_formatNumber_0.setType("number");
    int _jspx_eval_fmt_formatNumber_0 = _jspx_th_fmt_formatNumber_0.doStartTag();
    if (_jspx_th_fmt_formatNumber_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_formatNumber_value_type_nobody.reuse(_jspx_th_fmt_formatNumber_0);
    return false;
  }

  private boolean _jspx_meth_c_forEach_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_forEach_1, PageContext _jspx_page_context, int[] _jspx_push_body_count_c_forEach_1)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:forEach
    org.apache.taglibs.standard.tag.rt.core.ForEachTag _jspx_th_c_forEach_2 = (org.apache.taglibs.standard.tag.rt.core.ForEachTag) _jspx_tagPool_c_forEach_var_items.get(org.apache.taglibs.standard.tag.rt.core.ForEachTag.class);
    _jspx_th_c_forEach_2.setPageContext(_jspx_page_context);
    _jspx_th_c_forEach_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_forEach_1);
    _jspx_th_c_forEach_2.setItems((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${catMap}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_forEach_2.setVar("cat");
    int[] _jspx_push_body_count_c_forEach_2 = new int[] { 0 };
    try {
      int _jspx_eval_c_forEach_2 = _jspx_th_c_forEach_2.doStartTag();
      if (_jspx_eval_c_forEach_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
          out.write("<font color=red>");
          if (_jspx_meth_c_out_0(_jspx_th_c_forEach_2, _jspx_page_context, _jspx_push_body_count_c_forEach_2))
            return true;
          out.write("</font>&nbsp;/\n");
          out.write("               ");
          int evalDoAfterBody = _jspx_th_c_forEach_2.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_forEach_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        throw new SkipPageException();
    } catch (Throwable _jspx_exception) {
      while (_jspx_push_body_count_c_forEach_2[0]-- > 0)
        out = _jspx_page_context.popBody();
      _jspx_th_c_forEach_2.doCatch(_jspx_exception);
    } finally {
      _jspx_th_c_forEach_2.doFinally();
      _jspx_tagPool_c_forEach_var_items.reuse(_jspx_th_c_forEach_2);
    }
    return false;
  }

  private boolean _jspx_meth_c_out_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_forEach_2, PageContext _jspx_page_context, int[] _jspx_push_body_count_c_forEach_2)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:out
    org.apache.taglibs.standard.tag.rt.core.OutTag _jspx_th_c_out_0 = (org.apache.taglibs.standard.tag.rt.core.OutTag) _jspx_tagPool_c_out_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.OutTag.class);
    _jspx_th_c_out_0.setPageContext(_jspx_page_context);
    _jspx_th_c_out_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_forEach_2);
    _jspx_th_c_out_0.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${cat.value}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    int _jspx_eval_c_out_0 = _jspx_th_c_out_0.doStartTag();
    if (_jspx_th_c_out_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_out_value_nobody.reuse(_jspx_th_c_out_0);
    return false;
  }

  private boolean _jspx_meth_c_remove_0(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:remove
    org.apache.taglibs.standard.tag.common.core.RemoveTag _jspx_th_c_remove_0 = (org.apache.taglibs.standard.tag.common.core.RemoveTag) _jspx_tagPool_c_remove_var_nobody.get(org.apache.taglibs.standard.tag.common.core.RemoveTag.class);
    _jspx_th_c_remove_0.setPageContext(_jspx_page_context);
    _jspx_th_c_remove_0.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_remove_0.setVar("volsMap");
    int _jspx_eval_c_remove_0 = _jspx_th_c_remove_0.doStartTag();
    if (_jspx_th_c_remove_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_remove_var_nobody.reuse(_jspx_th_c_remove_0);
    return false;
  }

  private boolean _jspx_meth_fmt_message_22(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_22 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_22.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_22.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_4);
    _jspx_th_fmt_message_22.setKey("number_of_results");
    int _jspx_eval_fmt_message_22 = _jspx_th_fmt_message_22.doStartTag();
    if (_jspx_th_fmt_message_22.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_22);
    return false;
  }

  private boolean _jspx_meth_fmt_formatNumber_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_4, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:formatNumber
    org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag _jspx_th_fmt_formatNumber_1 = (org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag) _jspx_tagPool_fmt_formatNumber_value_type_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.FormatNumberTag.class);
    _jspx_th_fmt_formatNumber_1.setPageContext(_jspx_page_context);
    _jspx_th_fmt_formatNumber_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_4);
    _jspx_th_fmt_formatNumber_1.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${results_count}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_fmt_formatNumber_1.setType("number");
    int _jspx_eval_fmt_formatNumber_1 = _jspx_th_fmt_formatNumber_1.doStartTag();
    if (_jspx_th_fmt_formatNumber_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_formatNumber_value_type_nobody.reuse(_jspx_th_fmt_formatNumber_1);
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

  private class object_005fquery_005fresult_jspHelper
      extends org.apache.jasper.runtime.JspFragmentHelper
  {
    private javax.servlet.jsp.tagext.JspTag _jspx_parent;
    private int[] _jspx_push_body_count;

    public object_005fquery_005fresult_jspHelper( int discriminator, JspContext jspContext, javax.servlet.jsp.tagext.JspTag _jspx_parent, int[] _jspx_push_body_count ) {
      super( discriminator, jspContext, _jspx_parent );
      this._jspx_parent = _jspx_parent;
      this._jspx_push_body_count = _jspx_push_body_count;
    }
    public boolean invoke0( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(param.object_copyid)}", java.lang.String.class, (PageContext)_jspx_page_context, _jspx_fnmap_2, false));
      return false;
    }
    public boolean invoke1( JspWriter out ) 
      throws Throwable
    {
      out.write("<query xmlns=\"http://kalio.net/empweb/schema/objectsquery/v1\">\n");
      out.write("          ");
      if (_jspx_meth_c_choose_2(_jspx_parent, _jspx_page_context))
        return true;
      out.write("</query>\n");
      out.write("      ");
      return false;
    }
    public void invoke2( JspWriter out ) 
      throws Throwable
    {
      HttpSession session = _jspx_page_context.getSession();
      ServletContext application = _jspx_page_context.getServletContext();
      HttpServletRequest request = (HttpServletRequest)_jspx_page_context.getRequest();
      java.util.HashMap volsMap = null;
      synchronized (_jspx_page_context) {
        volsMap = (java.util.HashMap) _jspx_page_context.getAttribute("volsMap", PageContext.PAGE_SCOPE);
        if (volsMap == null){
          volsMap = new java.util.HashMap();
          _jspx_page_context.setAttribute("volsMap", volsMap, PageContext.PAGE_SCOPE);
        }
      }
      //  c:choose
      org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_6 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
      _jspx_th_c_choose_6.setPageContext(_jspx_page_context);
      _jspx_th_c_choose_6.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
      int _jspx_eval_c_choose_6 = _jspx_th_c_choose_6.doStartTag();
      if (_jspx_eval_c_choose_6 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
          if (_jspx_meth_c_when_12(_jspx_th_c_choose_6, _jspx_page_context))
            return;
          //  c:otherwise
          org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_5 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
          _jspx_th_c_otherwise_5.setPageContext(_jspx_page_context);
          _jspx_th_c_otherwise_5.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_6);
          int _jspx_eval_c_otherwise_5 = _jspx_th_c_otherwise_5.doStartTag();
          if (_jspx_eval_c_otherwise_5 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
            do {
              //  jxp:set
              org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_2 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
              java.util.HashMap _jspx_th_jxp_set_2_aliasMap = new java.util.HashMap();
              _jspx_th_jxp_set_2_aliasMap.put("punt", "totalCount");
              _jspx_th_jxp_set_2.setJspContext(_jspx_page_context, _jspx_th_jxp_set_2_aliasMap);
              _jspx_th_jxp_set_2.setParent(_jspx_th_c_otherwise_5);
              _jspx_th_jxp_set_2.setVar("totalCount");
              _jspx_th_jxp_set_2.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
              _jspx_th_jxp_set_2.setSelect("count(mod:extension/hol:holdingsInfo/hol:copies/hol:copy)");
              _jspx_th_jxp_set_2.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
              _jspx_th_jxp_set_2.doTag();
              //  jxp:set
              org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_3 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
              java.util.HashMap _jspx_th_jxp_set_3_aliasMap = new java.util.HashMap();
              _jspx_th_jxp_set_3_aliasMap.put("punt", "withVolCount");
              _jspx_th_jxp_set_3.setJspContext(_jspx_page_context, _jspx_th_jxp_set_3_aliasMap);
              _jspx_th_jxp_set_3.setParent(_jspx_th_c_otherwise_5);
              _jspx_th_jxp_set_3.setVar("withVolCount");
              _jspx_th_jxp_set_3.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
              _jspx_th_jxp_set_3.setSelect("count(mod:extension/hol:holdingsInfo/hol:copies/hol:copy/hol:volumeId)");
              _jspx_th_jxp_set_3.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
              _jspx_th_jxp_set_3.doTag();
              if (_jspx_meth_c_if_12(_jspx_th_c_otherwise_5, _jspx_page_context))
                return;
              //  jxp:forEach
              org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_1 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
              java.util.HashMap _jspx_th_jxp_forEach_1_aliasMap = new java.util.HashMap();
              _jspx_th_jxp_forEach_1_aliasMap.put("punt", "ptr2");
              _jspx_th_jxp_forEach_1.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_1_aliasMap);
              _jspx_th_jxp_forEach_1.setParent(_jspx_th_c_otherwise_5);
              _jspx_th_jxp_forEach_1.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
              _jspx_th_jxp_forEach_1.setVar("ptr2");
              _jspx_th_jxp_forEach_1.setSelect("mod:extension/hol:holdingsInfo/hol:copies/hol:copy/hol:volumeId");
              _jspx_th_jxp_forEach_1.setSortby(".");
              _jspx_th_jxp_forEach_1.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
              _jspx_th_jxp_forEach_1.setJspBody(new object_005fquery_005fresult_jspHelper( 3, _jspx_page_context, _jspx_th_jxp_forEach_1, null));
              _jspx_th_jxp_forEach_1.doTag();
              int evalDoAfterBody = _jspx_th_c_otherwise_5.doAfterBody();
              if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                break;
            } while (true);
          }
          if (_jspx_th_c_otherwise_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
            throw new SkipPageException();
          _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_5);
          int evalDoAfterBody = _jspx_th_c_choose_6.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_choose_6.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        throw new SkipPageException();
      _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_6);
      java.util.HashMap catMap = null;
      synchronized (_jspx_page_context) {
        catMap = (java.util.HashMap) _jspx_page_context.getAttribute("catMap", PageContext.PAGE_SCOPE);
        if (catMap == null){
          catMap = new java.util.HashMap();
          _jspx_page_context.setAttribute("catMap", catMap, PageContext.PAGE_SCOPE);
        }
      }
      //  jxp:forEach
      org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_2 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
      java.util.HashMap _jspx_th_jxp_forEach_2_aliasMap = new java.util.HashMap();
      _jspx_th_jxp_forEach_2_aliasMap.put("punt", "ptr2");
      _jspx_th_jxp_forEach_2.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_2_aliasMap);
      _jspx_th_jxp_forEach_2.setParent(_jspx_parent);
      _jspx_th_jxp_forEach_2.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_forEach_2.setVar("ptr2");
      _jspx_th_jxp_forEach_2.setSelect("mod:extension/hol:holdingsInfo/hol:copies/hol:copy/hol:objectCategory");
      _jspx_th_jxp_forEach_2.setSortby(".");
      _jspx_th_jxp_forEach_2.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_forEach_2.setJspBody(new object_005fquery_005fresult_jspHelper( 4, _jspx_page_context, _jspx_th_jxp_forEach_2, null));
      _jspx_th_jxp_forEach_2.doTag();
      //  c:forEach
      org.apache.taglibs.standard.tag.rt.core.ForEachTag _jspx_th_c_forEach_1 = (org.apache.taglibs.standard.tag.rt.core.ForEachTag) _jspx_tagPool_c_forEach_var_items.get(org.apache.taglibs.standard.tag.rt.core.ForEachTag.class);
      _jspx_th_c_forEach_1.setPageContext(_jspx_page_context);
      _jspx_th_c_forEach_1.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
      _jspx_th_c_forEach_1.setItems((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${volsMap}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_c_forEach_1.setVar("vol");
      int[] _jspx_push_body_count_c_forEach_1 = new int[] { 0 };
      try {
        int _jspx_eval_c_forEach_1 = _jspx_th_c_forEach_1.doStartTag();
        if (_jspx_eval_c_forEach_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
          do {
            //  c:choose
            org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_7 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
            _jspx_th_c_choose_7.setPageContext(_jspx_page_context);
            _jspx_th_c_choose_7.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_forEach_1);
            int _jspx_eval_c_choose_7 = _jspx_th_c_choose_7.doStartTag();
            if (_jspx_eval_c_choose_7 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
              do {
                //  c:when
                org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_13 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
                _jspx_th_c_when_13.setPageContext(_jspx_page_context);
                _jspx_th_c_when_13.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_7);
                _jspx_th_c_when_13.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${vol.value eq ''}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
                int _jspx_eval_c_when_13 = _jspx_th_c_when_13.doStartTag();
                if (_jspx_eval_c_when_13 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
                  do {
                    //  jxp:set
                    org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_4 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
                    java.util.HashMap _jspx_th_jxp_set_4_aliasMap = new java.util.HashMap();
                    _jspx_th_jxp_set_4_aliasMap.put("punt", "copiesCount");
                    _jspx_th_jxp_set_4.setJspContext(_jspx_page_context, _jspx_th_jxp_set_4_aliasMap);
                    _jspx_th_jxp_set_4.setParent(_jspx_th_c_when_13);
                    _jspx_th_jxp_set_4.setVar("copiesCount");
                    _jspx_th_jxp_set_4.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
                    _jspx_th_jxp_set_4.setSelect("count(mod:extension/hol:holdingsInfo/hol:copies/hol:copy[not(hol:volumeId)])");
                    _jspx_th_jxp_set_4.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
                    _jspx_th_jxp_set_4.doTag();
                    int evalDoAfterBody = _jspx_th_c_when_13.doAfterBody();
                    if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                      break;
                  } while (true);
                }
                if (_jspx_th_c_when_13.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
                  throw new SkipPageException();
                _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_13);
                //  c:otherwise
                org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_6 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
                _jspx_th_c_otherwise_6.setPageContext(_jspx_page_context);
                _jspx_th_c_otherwise_6.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_7);
                int _jspx_eval_c_otherwise_6 = _jspx_th_c_otherwise_6.doStartTag();
                if (_jspx_eval_c_otherwise_6 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
                  do {
                    //  jxp:set
                    org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_5 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
                    java.util.HashMap _jspx_th_jxp_set_5_aliasMap = new java.util.HashMap();
                    _jspx_th_jxp_set_5_aliasMap.put("punt", "copiesCount");
                    _jspx_th_jxp_set_5.setJspContext(_jspx_page_context, _jspx_th_jxp_set_5_aliasMap);
                    _jspx_th_jxp_set_5.setParent(_jspx_th_c_otherwise_6);
                    _jspx_th_jxp_set_5.setVar("copiesCount");
                    _jspx_th_jxp_set_5.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
                    _jspx_th_jxp_set_5.setSelect((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("count(mod:extension/hol:holdingsInfo/hol:copies/hol:copy[hol:volumeId='${vol.value}'])", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
                    _jspx_th_jxp_set_5.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
                    _jspx_th_jxp_set_5.doTag();
                    int evalDoAfterBody = _jspx_th_c_otherwise_6.doAfterBody();
                    if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                      break;
                  } while (true);
                }
                if (_jspx_th_c_otherwise_6.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
                  throw new SkipPageException();
                _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_6);
                int evalDoAfterBody = _jspx_th_c_choose_7.doAfterBody();
                if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                  break;
              } while (true);
            }
            if (_jspx_th_c_choose_7.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
              throw new SkipPageException();
            _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_7);
            out.write("<tr>\n");
            out.write("              ");
            if (_jspx_meth_c_if_13(_jspx_th_c_forEach_1, _jspx_page_context, _jspx_push_body_count_c_forEach_1))
              return;
            out.write("<td>\n");
            out.write("                <a href=\"indexw.jsp?record_id=");
            out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr[\"mod:recordInfo/mod:recordIdentifier\"]}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
            out.write("&amp;object_db=");
            out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['ancestor::qr:databaseResult/@name']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
            out.write("&amp;volume_id=");
            out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${vol.value}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
            out.write('"');
            out.write('>');
            out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr[\"mod:recordInfo/mod:recordIdentifier\"]}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
            out.write("</a>\n");
            out.write("              </td>\n");
            out.write("              <td>\n");
            out.write("                <a href=\"indexw.jsp?record_id=");
            out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr[\"mod:recordInfo/mod:recordIdentifier\"]}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
            out.write("&amp;object_db=");
            out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['ancestor::qr:databaseResult/@name']}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
            out.write("&amp;volume_id=");
            out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${vol.value}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
            out.write('"');
            out.write('>');
            out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${vol.value}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
            out.write("</a>\n");
            out.write("              </td>                  \n");
            out.write("\n");
            out.write("              <td>\n");
            out.write("                ");
            //  c:choose
            org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_8 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
            _jspx_th_c_choose_8.setPageContext(_jspx_page_context);
            _jspx_th_c_choose_8.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_forEach_1);
            int _jspx_eval_c_choose_8 = _jspx_th_c_choose_8.doStartTag();
            if (_jspx_eval_c_choose_8 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
              do {
                //  c:when
                org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_14 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
                _jspx_th_c_when_14.setPageContext(_jspx_page_context);
                _jspx_th_c_when_14.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_8);
                _jspx_th_c_when_14.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(not empty param.show_all_copies or copiesCount lt 2)}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
                int _jspx_eval_c_when_14 = _jspx_th_c_when_14.doStartTag();
                if (_jspx_eval_c_when_14 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
                  do {
                    if (_jspx_meth_c_choose_9(_jspx_th_c_when_14, _jspx_page_context, _jspx_push_body_count_c_forEach_1))
                      return;
                    //  jxp:forEach
                    org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_3 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
                    java.util.HashMap _jspx_th_jxp_forEach_3_aliasMap = new java.util.HashMap();
                    _jspx_th_jxp_forEach_3_aliasMap.put("punt", "ptr2");
                    _jspx_th_jxp_forEach_3.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_3_aliasMap);
                    _jspx_th_jxp_forEach_3.setParent(_jspx_th_c_when_14);
                    _jspx_th_jxp_forEach_3.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
                    _jspx_th_jxp_forEach_3.setVar("ptr2");
                    _jspx_th_jxp_forEach_3.setSelect((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${forEachVol}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
                    _jspx_th_jxp_forEach_3.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
                    _jspx_th_jxp_forEach_3.setJspBody(new object_005fquery_005fresult_jspHelper( 5, _jspx_page_context, _jspx_th_jxp_forEach_3, _jspx_push_body_count_c_forEach_1));
                    _jspx_th_jxp_forEach_3.doTag();
                    int evalDoAfterBody = _jspx_th_c_when_14.doAfterBody();
                    if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                      break;
                  } while (true);
                }
                if (_jspx_th_c_when_14.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
                  throw new SkipPageException();
                _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_14);
                if (_jspx_meth_c_otherwise_8(_jspx_th_c_choose_8, _jspx_page_context, _jspx_push_body_count_c_forEach_1))
                  return;
                int evalDoAfterBody = _jspx_th_c_choose_8.doAfterBody();
                if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                  break;
              } while (true);
            }
            if (_jspx_th_c_choose_8.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
              throw new SkipPageException();
            _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_8);
            out.write("</td>\n");
            out.write("\n");
            out.write("              <td>\n");
            out.write("                ");
            //  jxp:forEach
            org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_4 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
            java.util.HashMap _jspx_th_jxp_forEach_4_aliasMap = new java.util.HashMap();
            _jspx_th_jxp_forEach_4_aliasMap.put("punt", "title");
            _jspx_th_jxp_forEach_4.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_4_aliasMap);
            _jspx_th_jxp_forEach_4.setParent(_jspx_th_c_forEach_1);
            _jspx_th_jxp_forEach_4.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
            _jspx_th_jxp_forEach_4.setSelect("mod:titleInfo/mod:title");
            _jspx_th_jxp_forEach_4.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
            _jspx_th_jxp_forEach_4.setVar("title");
            _jspx_th_jxp_forEach_4.setJspBody(new object_005fquery_005fresult_jspHelper( 6, _jspx_page_context, _jspx_th_jxp_forEach_4, _jspx_push_body_count_c_forEach_1));
            _jspx_th_jxp_forEach_4.doTag();
            out.write("</td>\n");
            out.write("              <td>\n");
            out.write("                ");
            //  jxp:forEach
            org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_5 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
            java.util.HashMap _jspx_th_jxp_forEach_5_aliasMap = new java.util.HashMap();
            _jspx_th_jxp_forEach_5_aliasMap.put("punt", "author");
            _jspx_th_jxp_forEach_5.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_5_aliasMap);
            _jspx_th_jxp_forEach_5.setParent(_jspx_th_c_forEach_1);
            _jspx_th_jxp_forEach_5.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
            _jspx_th_jxp_forEach_5.setSelect("mod:name[mod:role/mod:roleTerm='author']");
            _jspx_th_jxp_forEach_5.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
            _jspx_th_jxp_forEach_5.setVar("author");
            _jspx_th_jxp_forEach_5.setJspBody(new object_005fquery_005fresult_jspHelper( 7, _jspx_page_context, _jspx_th_jxp_forEach_5, _jspx_push_body_count_c_forEach_1));
            _jspx_th_jxp_forEach_5.doTag();
            out.write("</td>\n");
            out.write("              \n");
            out.write("              \n");
            out.write("              <td align=\"center\">              \n");
            out.write("               ");
            if (_jspx_meth_c_forEach_2(_jspx_th_c_forEach_1, _jspx_page_context, _jspx_push_body_count_c_forEach_1))
              return;
            out.write("</td>\n");
            out.write("              \n");
            out.write("              \n");
            out.write("              \n");
            out.write("              <td>");
            out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr[\"mod:originInfo/mod:dateIssued\"]}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
            out.write("</td>\n");
            out.write("            </tr>\n");
            out.write("\n");
            out.write("          ");
            int evalDoAfterBody = _jspx_th_c_forEach_1.doAfterBody();
            if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
              break;
          } while (true);
        }
        if (_jspx_th_c_forEach_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
          throw new SkipPageException();
      } catch (Throwable _jspx_exception) {
        while (_jspx_push_body_count_c_forEach_1[0]-- > 0)
          out = _jspx_page_context.popBody();
        _jspx_th_c_forEach_1.doCatch(_jspx_exception);
      } finally {
        _jspx_th_c_forEach_1.doFinally();
        _jspx_tagPool_c_forEach_var_items.reuse(_jspx_th_c_forEach_1);
      }
      if (_jspx_meth_c_remove_0(_jspx_parent, _jspx_page_context))
        return;
      return;
    }
    public void invoke3( JspWriter out ) 
      throws Throwable
    {
      if (_jspx_meth_c_set_15(_jspx_parent, _jspx_page_context))
        return;
      return;
    }
    public void invoke4( JspWriter out ) 
      throws Throwable
    {
      if (_jspx_meth_c_set_16(_jspx_parent, _jspx_page_context))
        return;
      return;
    }
    public void invoke5( JspWriter out ) 
      throws Throwable
    {
      if (_jspx_meth_c_if_14(_jspx_parent, _jspx_page_context, _jspx_push_body_count))
        return;
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr2[\"hol:subLocation\"]}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&nbsp;");
      if (_jspx_meth_c_if_15(_jspx_parent, _jspx_page_context, _jspx_push_body_count))
        return;
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr2[\"hol:copyId\"]}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("<br/>\n");
      out.write("                    ");
      return;
    }
    public void invoke6( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${title}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("<br />\n");
      out.write("                ");
      return;
    }
    public void invoke7( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${author[\"mod:namePart\"]}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("<!-- (");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${author[\"@type\"]}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write(") --><br/>\n");
      out.write("                ");
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
