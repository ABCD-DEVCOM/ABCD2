package org.apache.jsp.jsp.search;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;

public final class searchForm_jsp extends org.apache.jasper.runtime.HttpJspBase
    implements org.apache.jasper.runtime.JspSourceDependent {

  private static java.util.Vector _jspx_dependants;

  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_s_url_value_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_s_form_theme_method_action;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_s_text_name_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_s_radio_value_name_list_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_s_select_name_listKey_list_label_id_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_s_select_name_list_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_s_hidden_style_name_id_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_s_submit_value_align_nobody;

  public java.util.List getDependants() {
    return _jspx_dependants;
  }

  public void _jspInit() {
    _jspx_tagPool_s_url_value_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_s_form_theme_method_action = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_s_text_name_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_s_radio_value_name_list_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_s_select_name_listKey_list_label_id_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_s_select_name_list_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_s_hidden_style_name_id_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_s_submit_value_align_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
  }

  public void _jspDestroy() {
    _jspx_tagPool_s_url_value_nobody.release();
    _jspx_tagPool_s_form_theme_method_action.release();
    _jspx_tagPool_s_text_name_nobody.release();
    _jspx_tagPool_s_radio_value_name_list_nobody.release();
    _jspx_tagPool_s_select_name_listKey_list_label_id_nobody.release();
    _jspx_tagPool_s_select_name_list_nobody.release();
    _jspx_tagPool_s_hidden_style_name_id_nobody.release();
    _jspx_tagPool_s_submit_value_align_nobody.release();
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
      response.setContentType("text/html;charset=UTF-8");
      pageContext = _jspxFactory.getPageContext(this, request, response,
      			null, true, 8192, true);
      _jspx_page_context = pageContext;
      application = pageContext.getServletContext();
      config = pageContext.getServletConfig();
      session = pageContext.getSession();
      out = pageContext.getOut();
      _jspx_out = out;

      out.write('\n');
      out.write('\n');
      out.write("\n");
      out.write("\n");
      out.write("\n");
      out.write("<!doctype html>\n");
      out.write("\n");
      out.write("<html>\n");
      out.write("   <head>\n");
      out.write("       <script>\n");
      out.write("        \n");
      out.write("       /**\n");
      out.write("        *  We call the function in the head tag so that it will be executed immediately,\n");
      out.write("        *  before the DOM is even parsed. Futhermore the function is fully synchronous.\n");
      out.write("        *   \n");
      out.write("        * Be sure a database is selected, otherwise it will redirect to\n");
      out.write("        * the doSelectDatabase action \n");
      out.write("        */\n");
      out.write("          \n");
      out.write("         ModUtils.checkDatabaseSelected();\n");
      out.write("      </script>\n");
      out.write("\n");
      out.write("      <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n");
      out.write("      <meta name=\"currentPage\" content=\"Search\"/>\n");
      out.write("\n");
      out.write("\n");
      out.write("      <title>J-ISIS Search Form</title>\n");
      out.write("\n");
      out.write("      ");
      out.write("\n");
      out.write("<!--      <link  href=\"");
      if (_jspx_meth_s_url_0(_jspx_page_context))
        return;
      out.write("\" rel=\"stylesheet\" type=\"text/css\" />\n");
      out.write("      <script src=\"");
      if (_jspx_meth_s_url_1(_jspx_page_context))
        return;
      out.write("\" type=\"text/javascript\" ></script>-->\n");
      out.write("\n");
      out.write("      <script src=\"");
      if (_jspx_meth_s_url_2(_jspx_page_context))
        return;
      out.write("\" type=\"text/javascript\" ></script>\n");
      out.write("\n");
      out.write("      ");
      out.write("\n");
      out.write("\n");
      out.write("      <style type=\"text/css\">\n");
      out.write("         input {\n");
      out.write("            font-size: 120%;\n");
      out.write("         }\n");
      out.write("         .ac_results {\n");
      out.write("            padding: 0px;\n");
      out.write("            border: 1px solid WindowFrame;\n");
      out.write("            background-color: Window;\n");
      out.write("            overflow: hidden;\n");
      out.write("            text-align: left;\n");
      out.write("         }\n");
      out.write("\n");
      out.write("      </style>\n");
      out.write("\n");
      out.write("      <script type=\"text/javascript\">           \n");
      out.write("          \n");
      out.write("             // When the document is ready, execute our function\n");
      out.write("               $().ready(function() {\n");
      out.write("                     /**\n");
      out.write("                      * Be sure a database is selected, otherwise it will redirect to\n");
      out.write("                      * the doSelectDatabase action \n");
      out.write("                      */\n");
      out.write("                    ModUtils.checkDatabaseSelected();\n");
      out.write("           \n");
      out.write("                       ModSelect2.buildSelect2Field($, \"#query0\", '#query0SearchTag');\n");
      out.write("\n");
      out.write("                       ModSelect2.buildSelect2Field($, \"#query1\", '#query1SearchTag');\n");
      out.write("\n");
      out.write("                       ModSelect2.buildSelect2Field($, \"#query2\", '#query2SearchTag');\n");
      out.write("\n");
      out.write("                       ModSelect2.buildSelect2Field($, \"#query3\", '#query3SearchTag');\n");
      out.write("\n");
      out.write("                       ModSelect2.buildSelect2Field($, \"#query4\", '#query4SearchTag');\n");
      out.write("                   });\n");
      out.write("\n");
      out.write("        \n");
      out.write("      </script>\n");
      out.write("\n");
      out.write("\n");
      out.write("   </head>\n");
      out.write("\n");
      out.write("   <body>\n");
      out.write("      \n");
      out.write("      \n");
      out.write("      ");
      if (_jspx_meth_s_form_0(_jspx_page_context))
        return;
      out.write("\n");
      out.write("\n");
      out.write("   </body>\n");
      out.write("\n");
      out.write("</html>");
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

  private boolean _jspx_meth_s_url_0(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:url
    org.apache.struts2.views.jsp.URLTag _jspx_th_s_url_0 = (org.apache.struts2.views.jsp.URLTag) _jspx_tagPool_s_url_value_nobody.get(org.apache.struts2.views.jsp.URLTag.class);
    _jspx_th_s_url_0.setPageContext(_jspx_page_context);
    _jspx_th_s_url_0.setParent(null);
    _jspx_th_s_url_0.setValue("/scripts/select2-3.4.6/select2.css");
    int _jspx_eval_s_url_0 = _jspx_th_s_url_0.doStartTag();
    if (_jspx_th_s_url_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_url_value_nobody.reuse(_jspx_th_s_url_0);
    return false;
  }

  private boolean _jspx_meth_s_url_1(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:url
    org.apache.struts2.views.jsp.URLTag _jspx_th_s_url_1 = (org.apache.struts2.views.jsp.URLTag) _jspx_tagPool_s_url_value_nobody.get(org.apache.struts2.views.jsp.URLTag.class);
    _jspx_th_s_url_1.setPageContext(_jspx_page_context);
    _jspx_th_s_url_1.setParent(null);
    _jspx_th_s_url_1.setValue("/scripts/select2-3.4.6/select2.js");
    int _jspx_eval_s_url_1 = _jspx_th_s_url_1.doStartTag();
    if (_jspx_th_s_url_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_url_value_nobody.reuse(_jspx_th_s_url_1);
    return false;
  }

  private boolean _jspx_meth_s_url_2(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:url
    org.apache.struts2.views.jsp.URLTag _jspx_th_s_url_2 = (org.apache.struts2.views.jsp.URLTag) _jspx_tagPool_s_url_value_nobody.get(org.apache.struts2.views.jsp.URLTag.class);
    _jspx_th_s_url_2.setPageContext(_jspx_page_context);
    _jspx_th_s_url_2.setParent(null);
    _jspx_th_s_url_2.setValue("/scripts/ModSelect2.js");
    int _jspx_eval_s_url_2 = _jspx_th_s_url_2.doStartTag();
    if (_jspx_th_s_url_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_url_value_nobody.reuse(_jspx_th_s_url_2);
    return false;
  }

  private boolean _jspx_meth_s_form_0(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:form
    org.apache.struts2.views.jsp.ui.FormTag _jspx_th_s_form_0 = (org.apache.struts2.views.jsp.ui.FormTag) _jspx_tagPool_s_form_theme_method_action.get(org.apache.struts2.views.jsp.ui.FormTag.class);
    _jspx_th_s_form_0.setPageContext(_jspx_page_context);
    _jspx_th_s_form_0.setParent(null);
    _jspx_th_s_form_0.setAction("doSearch");
    _jspx_th_s_form_0.setMethod("POST");
    _jspx_th_s_form_0.setTheme("simple");
    int _jspx_eval_s_form_0 = _jspx_th_s_form_0.doStartTag();
    if (_jspx_eval_s_form_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_s_form_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_s_form_0.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_s_form_0.doInitBody();
      }
      do {
        out.write("\n");
        out.write("\n");
        out.write("         <table>\n");
        out.write("            <tr>\n");
        out.write("               <td>");
        if (_jspx_meth_s_text_0(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("               <td colspan=\"2\">");
        if (_jspx_meth_s_radio_0(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("\n");
        out.write("            </tr>\n");
        out.write("            <tr>           \n");
        out.write("               <td>");
        if (_jspx_meth_s_select_0(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("               <td>");
        if (_jspx_meth_s_select_1(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("               <td>");
        if (_jspx_meth_s_hidden_0(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("            </tr>        \n");
        out.write("            <tr>\n");
        out.write("               <td>");
        if (_jspx_meth_s_select_2(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("               <td>");
        if (_jspx_meth_s_select_3(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("               <td>");
        if (_jspx_meth_s_hidden_1(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("            </tr>\n");
        out.write("            <tr>\n");
        out.write("               <td>");
        if (_jspx_meth_s_select_4(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("               <td>");
        if (_jspx_meth_s_select_5(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("               <td>");
        if (_jspx_meth_s_hidden_2(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("            </tr>\n");
        out.write("            <tr>\n");
        out.write("               <td>");
        if (_jspx_meth_s_select_6(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("               <td>");
        if (_jspx_meth_s_select_7(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("               <td>");
        if (_jspx_meth_s_hidden_3(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("            </tr>\n");
        out.write("            <tr>\n");
        out.write("               <td>");
        if (_jspx_meth_s_select_8(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("               <td>");
        if (_jspx_meth_s_select_9(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("               <td>");
        if (_jspx_meth_s_hidden_4(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td>\n");
        out.write("            </tr>\n");
        out.write("\n");
        out.write("            <tr><td>");
        if (_jspx_meth_s_submit_0(_jspx_th_s_form_0, _jspx_page_context))
          return true;
        out.write("</td></tr>\n");
        out.write("         </table>\n");
        out.write("\n");
        out.write("      ");
        int evalDoAfterBody = _jspx_th_s_form_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_s_form_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_s_form_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_form_theme_method_action.reuse(_jspx_th_s_form_0);
    return false;
  }

  private boolean _jspx_meth_s_text_0(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:text
    org.apache.struts2.views.jsp.TextTag _jspx_th_s_text_0 = (org.apache.struts2.views.jsp.TextTag) _jspx_tagPool_s_text_name_nobody.get(org.apache.struts2.views.jsp.TextTag.class);
    _jspx_th_s_text_0.setPageContext(_jspx_page_context);
    _jspx_th_s_text_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_text_0.setName("Match Option:");
    int _jspx_eval_s_text_0 = _jspx_th_s_text_0.doStartTag();
    if (_jspx_th_s_text_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_text_name_nobody.reuse(_jspx_th_s_text_0);
    return false;
  }

  private boolean _jspx_meth_s_radio_0(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:radio
    org.apache.struts2.views.jsp.ui.RadioTag _jspx_th_s_radio_0 = (org.apache.struts2.views.jsp.ui.RadioTag) _jspx_tagPool_s_radio_value_name_list_nobody.get(org.apache.struts2.views.jsp.ui.RadioTag.class);
    _jspx_th_s_radio_0.setPageContext(_jspx_page_context);
    _jspx_th_s_radio_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_radio_0.setName("matchOption");
    _jspx_th_s_radio_0.setList("matchOptions");
    _jspx_th_s_radio_0.setValue("%{'Match All of the Following'}");
    int _jspx_eval_s_radio_0 = _jspx_th_s_radio_0.doStartTag();
    if (_jspx_th_s_radio_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_radio_value_name_list_nobody.reuse(_jspx_th_s_radio_0);
    return false;
  }

  private boolean _jspx_meth_s_select_0(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:select
    org.apache.struts2.views.jsp.ui.SelectTag _jspx_th_s_select_0 = (org.apache.struts2.views.jsp.ui.SelectTag) _jspx_tagPool_s_select_name_listKey_list_label_id_nobody.get(org.apache.struts2.views.jsp.ui.SelectTag.class);
    _jspx_th_s_select_0.setPageContext(_jspx_page_context);
    _jspx_th_s_select_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_select_0.setId("query0SearchTag");
    _jspx_th_s_select_0.setName("termQueryList[0].searchableTag");
    _jspx_th_s_select_0.setLabel("Searchable Field(s):");
    _jspx_th_s_select_0.setList("#session.searchableFields");
    _jspx_th_s_select_0.setListKey("name");
    int _jspx_eval_s_select_0 = _jspx_th_s_select_0.doStartTag();
    if (_jspx_th_s_select_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_select_name_listKey_list_label_id_nobody.reuse(_jspx_th_s_select_0);
    return false;
  }

  private boolean _jspx_meth_s_select_1(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:select
    org.apache.struts2.views.jsp.ui.SelectTag _jspx_th_s_select_1 = (org.apache.struts2.views.jsp.ui.SelectTag) _jspx_tagPool_s_select_name_list_nobody.get(org.apache.struts2.views.jsp.ui.SelectTag.class);
    _jspx_th_s_select_1.setPageContext(_jspx_page_context);
    _jspx_th_s_select_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_select_1.setName("termQueryList[0].matching");
    _jspx_th_s_select_1.setList("{'Matching', 'Not Matching'}");
    int _jspx_eval_s_select_1 = _jspx_th_s_select_1.doStartTag();
    if (_jspx_th_s_select_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_select_name_list_nobody.reuse(_jspx_th_s_select_1);
    return false;
  }

  private boolean _jspx_meth_s_hidden_0(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:hidden
    org.apache.struts2.views.jsp.ui.HiddenTag _jspx_th_s_hidden_0 = (org.apache.struts2.views.jsp.ui.HiddenTag) _jspx_tagPool_s_hidden_style_name_id_nobody.get(org.apache.struts2.views.jsp.ui.HiddenTag.class);
    _jspx_th_s_hidden_0.setPageContext(_jspx_page_context);
    _jspx_th_s_hidden_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_hidden_0.setId("query0");
    _jspx_th_s_hidden_0.setName("termQueryList[0].query");
    _jspx_th_s_hidden_0.setDynamicAttribute(null, "style", new String("width:400px"));
    int _jspx_eval_s_hidden_0 = _jspx_th_s_hidden_0.doStartTag();
    if (_jspx_th_s_hidden_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_hidden_style_name_id_nobody.reuse(_jspx_th_s_hidden_0);
    return false;
  }

  private boolean _jspx_meth_s_select_2(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:select
    org.apache.struts2.views.jsp.ui.SelectTag _jspx_th_s_select_2 = (org.apache.struts2.views.jsp.ui.SelectTag) _jspx_tagPool_s_select_name_listKey_list_label_id_nobody.get(org.apache.struts2.views.jsp.ui.SelectTag.class);
    _jspx_th_s_select_2.setPageContext(_jspx_page_context);
    _jspx_th_s_select_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_select_2.setId("query1SearchTag");
    _jspx_th_s_select_2.setName("termQueryList[1].searchableTag");
    _jspx_th_s_select_2.setLabel("Searchable Field(s):");
    _jspx_th_s_select_2.setList("#session.searchableFields");
    _jspx_th_s_select_2.setListKey("name");
    int _jspx_eval_s_select_2 = _jspx_th_s_select_2.doStartTag();
    if (_jspx_th_s_select_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_select_name_listKey_list_label_id_nobody.reuse(_jspx_th_s_select_2);
    return false;
  }

  private boolean _jspx_meth_s_select_3(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:select
    org.apache.struts2.views.jsp.ui.SelectTag _jspx_th_s_select_3 = (org.apache.struts2.views.jsp.ui.SelectTag) _jspx_tagPool_s_select_name_list_nobody.get(org.apache.struts2.views.jsp.ui.SelectTag.class);
    _jspx_th_s_select_3.setPageContext(_jspx_page_context);
    _jspx_th_s_select_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_select_3.setName("termQueryList[1].matching");
    _jspx_th_s_select_3.setList("{'Matching', 'Not Matching'}");
    int _jspx_eval_s_select_3 = _jspx_th_s_select_3.doStartTag();
    if (_jspx_th_s_select_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_select_name_list_nobody.reuse(_jspx_th_s_select_3);
    return false;
  }

  private boolean _jspx_meth_s_hidden_1(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:hidden
    org.apache.struts2.views.jsp.ui.HiddenTag _jspx_th_s_hidden_1 = (org.apache.struts2.views.jsp.ui.HiddenTag) _jspx_tagPool_s_hidden_style_name_id_nobody.get(org.apache.struts2.views.jsp.ui.HiddenTag.class);
    _jspx_th_s_hidden_1.setPageContext(_jspx_page_context);
    _jspx_th_s_hidden_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_hidden_1.setId("query1");
    _jspx_th_s_hidden_1.setName("termQueryList[1].query");
    _jspx_th_s_hidden_1.setDynamicAttribute(null, "style", new String("width:400px"));
    int _jspx_eval_s_hidden_1 = _jspx_th_s_hidden_1.doStartTag();
    if (_jspx_th_s_hidden_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_hidden_style_name_id_nobody.reuse(_jspx_th_s_hidden_1);
    return false;
  }

  private boolean _jspx_meth_s_select_4(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:select
    org.apache.struts2.views.jsp.ui.SelectTag _jspx_th_s_select_4 = (org.apache.struts2.views.jsp.ui.SelectTag) _jspx_tagPool_s_select_name_listKey_list_label_id_nobody.get(org.apache.struts2.views.jsp.ui.SelectTag.class);
    _jspx_th_s_select_4.setPageContext(_jspx_page_context);
    _jspx_th_s_select_4.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_select_4.setId("query2SearchTag");
    _jspx_th_s_select_4.setName("termQueryList[2].searchableTag");
    _jspx_th_s_select_4.setLabel("Searchable Field(s):");
    _jspx_th_s_select_4.setList("#session.searchableFields");
    _jspx_th_s_select_4.setListKey("name");
    int _jspx_eval_s_select_4 = _jspx_th_s_select_4.doStartTag();
    if (_jspx_th_s_select_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_select_name_listKey_list_label_id_nobody.reuse(_jspx_th_s_select_4);
    return false;
  }

  private boolean _jspx_meth_s_select_5(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:select
    org.apache.struts2.views.jsp.ui.SelectTag _jspx_th_s_select_5 = (org.apache.struts2.views.jsp.ui.SelectTag) _jspx_tagPool_s_select_name_list_nobody.get(org.apache.struts2.views.jsp.ui.SelectTag.class);
    _jspx_th_s_select_5.setPageContext(_jspx_page_context);
    _jspx_th_s_select_5.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_select_5.setName("termQueryList[2].matching");
    _jspx_th_s_select_5.setList("{'Matching', 'Not Matching'}");
    int _jspx_eval_s_select_5 = _jspx_th_s_select_5.doStartTag();
    if (_jspx_th_s_select_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_select_name_list_nobody.reuse(_jspx_th_s_select_5);
    return false;
  }

  private boolean _jspx_meth_s_hidden_2(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:hidden
    org.apache.struts2.views.jsp.ui.HiddenTag _jspx_th_s_hidden_2 = (org.apache.struts2.views.jsp.ui.HiddenTag) _jspx_tagPool_s_hidden_style_name_id_nobody.get(org.apache.struts2.views.jsp.ui.HiddenTag.class);
    _jspx_th_s_hidden_2.setPageContext(_jspx_page_context);
    _jspx_th_s_hidden_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_hidden_2.setId("query2");
    _jspx_th_s_hidden_2.setName("termQueryList[2].query");
    _jspx_th_s_hidden_2.setDynamicAttribute(null, "style", new String("width:400px"));
    int _jspx_eval_s_hidden_2 = _jspx_th_s_hidden_2.doStartTag();
    if (_jspx_th_s_hidden_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_hidden_style_name_id_nobody.reuse(_jspx_th_s_hidden_2);
    return false;
  }

  private boolean _jspx_meth_s_select_6(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:select
    org.apache.struts2.views.jsp.ui.SelectTag _jspx_th_s_select_6 = (org.apache.struts2.views.jsp.ui.SelectTag) _jspx_tagPool_s_select_name_listKey_list_label_id_nobody.get(org.apache.struts2.views.jsp.ui.SelectTag.class);
    _jspx_th_s_select_6.setPageContext(_jspx_page_context);
    _jspx_th_s_select_6.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_select_6.setId("query3SearchTag");
    _jspx_th_s_select_6.setName("termQueryList[3].searchableTag");
    _jspx_th_s_select_6.setLabel("Searchable Field(s):");
    _jspx_th_s_select_6.setList("#session.searchableFields");
    _jspx_th_s_select_6.setListKey("name");
    int _jspx_eval_s_select_6 = _jspx_th_s_select_6.doStartTag();
    if (_jspx_th_s_select_6.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_select_name_listKey_list_label_id_nobody.reuse(_jspx_th_s_select_6);
    return false;
  }

  private boolean _jspx_meth_s_select_7(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:select
    org.apache.struts2.views.jsp.ui.SelectTag _jspx_th_s_select_7 = (org.apache.struts2.views.jsp.ui.SelectTag) _jspx_tagPool_s_select_name_list_nobody.get(org.apache.struts2.views.jsp.ui.SelectTag.class);
    _jspx_th_s_select_7.setPageContext(_jspx_page_context);
    _jspx_th_s_select_7.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_select_7.setName("termQueryList[3].matching");
    _jspx_th_s_select_7.setList("{'Matching', 'Not Matching'}");
    int _jspx_eval_s_select_7 = _jspx_th_s_select_7.doStartTag();
    if (_jspx_th_s_select_7.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_select_name_list_nobody.reuse(_jspx_th_s_select_7);
    return false;
  }

  private boolean _jspx_meth_s_hidden_3(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:hidden
    org.apache.struts2.views.jsp.ui.HiddenTag _jspx_th_s_hidden_3 = (org.apache.struts2.views.jsp.ui.HiddenTag) _jspx_tagPool_s_hidden_style_name_id_nobody.get(org.apache.struts2.views.jsp.ui.HiddenTag.class);
    _jspx_th_s_hidden_3.setPageContext(_jspx_page_context);
    _jspx_th_s_hidden_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_hidden_3.setId("query3");
    _jspx_th_s_hidden_3.setName("termQueryList[3].query");
    _jspx_th_s_hidden_3.setDynamicAttribute(null, "style", new String("width:400px"));
    int _jspx_eval_s_hidden_3 = _jspx_th_s_hidden_3.doStartTag();
    if (_jspx_th_s_hidden_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_hidden_style_name_id_nobody.reuse(_jspx_th_s_hidden_3);
    return false;
  }

  private boolean _jspx_meth_s_select_8(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:select
    org.apache.struts2.views.jsp.ui.SelectTag _jspx_th_s_select_8 = (org.apache.struts2.views.jsp.ui.SelectTag) _jspx_tagPool_s_select_name_listKey_list_label_id_nobody.get(org.apache.struts2.views.jsp.ui.SelectTag.class);
    _jspx_th_s_select_8.setPageContext(_jspx_page_context);
    _jspx_th_s_select_8.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_select_8.setId("query4SearchTag");
    _jspx_th_s_select_8.setName("termQueryList[4].searchableTag");
    _jspx_th_s_select_8.setLabel("Searchable Field(s):");
    _jspx_th_s_select_8.setList("#session.searchableFields");
    _jspx_th_s_select_8.setListKey("name");
    int _jspx_eval_s_select_8 = _jspx_th_s_select_8.doStartTag();
    if (_jspx_th_s_select_8.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_select_name_listKey_list_label_id_nobody.reuse(_jspx_th_s_select_8);
    return false;
  }

  private boolean _jspx_meth_s_select_9(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:select
    org.apache.struts2.views.jsp.ui.SelectTag _jspx_th_s_select_9 = (org.apache.struts2.views.jsp.ui.SelectTag) _jspx_tagPool_s_select_name_list_nobody.get(org.apache.struts2.views.jsp.ui.SelectTag.class);
    _jspx_th_s_select_9.setPageContext(_jspx_page_context);
    _jspx_th_s_select_9.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_select_9.setName("termQueryList[4].matching");
    _jspx_th_s_select_9.setList("{'Matching', 'Not Matching'}");
    int _jspx_eval_s_select_9 = _jspx_th_s_select_9.doStartTag();
    if (_jspx_th_s_select_9.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_select_name_list_nobody.reuse(_jspx_th_s_select_9);
    return false;
  }

  private boolean _jspx_meth_s_hidden_4(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:hidden
    org.apache.struts2.views.jsp.ui.HiddenTag _jspx_th_s_hidden_4 = (org.apache.struts2.views.jsp.ui.HiddenTag) _jspx_tagPool_s_hidden_style_name_id_nobody.get(org.apache.struts2.views.jsp.ui.HiddenTag.class);
    _jspx_th_s_hidden_4.setPageContext(_jspx_page_context);
    _jspx_th_s_hidden_4.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_hidden_4.setId("query4");
    _jspx_th_s_hidden_4.setName("termQueryList[4].query");
    _jspx_th_s_hidden_4.setDynamicAttribute(null, "style", new String("width:400px"));
    int _jspx_eval_s_hidden_4 = _jspx_th_s_hidden_4.doStartTag();
    if (_jspx_th_s_hidden_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_hidden_style_name_id_nobody.reuse(_jspx_th_s_hidden_4);
    return false;
  }

  private boolean _jspx_meth_s_submit_0(javax.servlet.jsp.tagext.JspTag _jspx_th_s_form_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:submit
    org.apache.struts2.views.jsp.ui.SubmitTag _jspx_th_s_submit_0 = (org.apache.struts2.views.jsp.ui.SubmitTag) _jspx_tagPool_s_submit_value_align_nobody.get(org.apache.struts2.views.jsp.ui.SubmitTag.class);
    _jspx_th_s_submit_0.setPageContext(_jspx_page_context);
    _jspx_th_s_submit_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_s_form_0);
    _jspx_th_s_submit_0.setValue("Search");
    _jspx_th_s_submit_0.setAlign("center");
    int _jspx_eval_s_submit_0 = _jspx_th_s_submit_0.doStartTag();
    if (_jspx_th_s_submit_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_submit_value_align_nobody.reuse(_jspx_th_s_submit_0);
    return false;
  }
}
