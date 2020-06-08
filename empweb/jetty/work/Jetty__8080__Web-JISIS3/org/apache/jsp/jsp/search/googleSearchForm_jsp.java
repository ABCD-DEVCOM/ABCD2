package org.apache.jsp.jsp.search;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;

public final class googleSearchForm_jsp extends org.apache.jasper.runtime.HttpJspBase
    implements org.apache.jasper.runtime.JspSourceDependent {

  private static java.util.Vector _jspx_dependants;

  public java.util.List getDependants() {
    return _jspx_dependants;
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

      out.write("\r\n");
      out.write("\r\n");
      out.write("\r\n");
      out.write("\r\n");
      out.write("\r\n");
      out.write("\r\n");
      out.write("<!DOCTYPE html>\r\n");
      out.write("<html>\r\n");
      out.write("   <head>\r\n");
      out.write("       <script>\r\n");
      out.write("       /**\r\n");
      out.write("        *  We call the function in the head tag so that it will be executed immediately,\r\n");
      out.write("        *  before the DOM is even parsed. Futhermore the function is fully synchronous.\r\n");
      out.write("        *   \r\n");
      out.write("        * Be sure a database is selected, otherwise it will redirect to\r\n");
      out.write("        * the doSelectDatabase action \r\n");
      out.write("        */\r\n");
      out.write("          \r\n");
      out.write("         ModUtils.checkDatabaseSelected();\r\n");
      out.write("      </script>\r\n");
      out.write("      <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\r\n");
      out.write("      <title>Google Search Like Page</title>\r\n");
      out.write("\r\n");
      out.write("      \r\n");
      out.write("      <script type=\"text/javascript\">\r\n");
      out.write("         /**\r\n");
      out.write("          * Execute the function when the DOM is ready. This is the function\r\n");
      out.write("          * in charge of building the Web page dynamically\r\n");
      out.write("          * \r\n");
      out.write("          * We use the jQuery shortcut for document-ready idiom\r\n");
      out.write("          */   \r\n");
      out.write("         $(function() {\r\n");
      out.write("                                 \r\n");
      out.write("            $(\"#query\").select2({\r\n");
      out.write("               minimumInputLength: 2,            \r\n");
      out.write("               allowClear: true,\r\n");
      out.write("               multiple: true,\r\n");
      out.write("               separator: \"%\",\r\n");
      out.write("\r\n");
      out.write("               // Function to submit the value (text:) from the selection\r\n");
      out.write("               //  instead of the selected object's ID\r\n");
      out.write("               id: function(object) {\r\n");
      out.write("                   // return only the term without the field and occurences \r\n");
      out.write("                   // number\r\n");
      out.write("                   \r\n");
      out.write("                   return object.text.split(\"\\t\", 2)[1];\r\n");
      out.write("                  },\r\n");
      out.write("                                      \r\n");
      out.write("                      ajax: {\r\n");
      out.write("                           url: \"services/json/doSuggest.action\",\r\n");
      out.write("                           dataType: 'json',\r\n");
      out.write("                           data: function (term, page) {\r\n");
      out.write("                                 \r\n");
      out.write("                                 return {\r\n");
      out.write("                                    q: term,\r\n");
      out.write("                                    searchableTag: \"<All Searchable Fields>\"                                 \r\n");
      out.write("                                  };\r\n");
      out.write("                           },\r\n");
      out.write("                           params: { // extra parameters that will be passed to ajax\r\n");
      out.write("                              contentType: 'application/json; charset=utf-8'\r\n");
      out.write("                           },\r\n");
      out.write("                           results: function (data, page) {\r\n");
      out.write("                              \r\n");
      out.write("                              return { results: data };\r\n");
      out.write("                           }\r\n");
      out.write("                      }\r\n");
      out.write("                   });\r\n");
      out.write("                   /*\r\n");
      out.write("                    * Clear the result data\r\n");
      out.write("                    */\r\n");
      out.write("                  $(\"#query\").select2(\"val\", null);\r\n");
      out.write("         } ); \r\n");
      out.write("         // The search function\r\n");
      out.write("         function doSearchGoogle() {\r\n");
      out.write("            var s = $('#query').val();\r\n");
      out.write("            //alert(s);\r\n");
      out.write("             $.ajax({\r\n");
      out.write("               type: 'POST',\r\n");
      out.write("                url: 'jisis/doSearchGoogle.action',\r\n");
      out.write("               data: { \r\n");
      out.write("                     'googleQuery': s\r\n");
      out.write("                     },\r\n");
      out.write("               success: function(data){\r\n");
      out.write("                    return data;\r\n");
      out.write("                    \r\n");
      out.write("               }\r\n");
      out.write("            });\r\n");
      out.write("       \r\n");
      out.write("          };\r\n");
      out.write("         </script>\r\n");
      out.write("            \r\n");
      out.write("   </head>\r\n");
      out.write("   <body>\r\n");
      out.write("      \r\n");
      out.write("       <form method=\"POST\" action=\"doSearchGoogle.action\" class=\"well form-search\">\r\n");
      out.write("<!--    <form action=\"jsp/search/displayResults.jsp\"  onsubmit=\"doSearchGoogle()\" class=\"form-search\">-->\r\n");
      out.write("       \r\n");
      out.write("          <div class=\"input-append\">\r\n");
      out.write("             <input type=\"hidden\" id=\"query\" name=\"googleQuery\" style=\"width:500px\" class=\"span2 search-query\"/>\r\n");
      out.write("             <button type=\"submit\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-search\"></span>Search</button>\r\n");
      out.write("          </div>\r\n");
      out.write("\r\n");
      out.write("   </form>\r\n");
      out.write("   </body>\r\n");
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
}
