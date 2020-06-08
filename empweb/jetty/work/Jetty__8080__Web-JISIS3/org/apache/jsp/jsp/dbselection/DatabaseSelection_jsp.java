package org.apache.jsp.jsp.dbselection;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;

public final class DatabaseSelection_jsp extends org.apache.jasper.runtime.HttpJspBase
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

      out.write("\n");
      out.write("\n");
      out.write("\n");
      out.write("\n");
      out.write("\n");
      out.write("\n");
      out.write("\n");
      out.write("\n");
      out.write("<!DOCTYPE HTML>\n");
      out.write("\n");
      out.write("<html>\n");
      out.write("   <head>\n");
      out.write("      <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n");
      out.write("      \n");
      out.write("      <title>List Databases for Selection</title>\n");
      out.write("      <meta name=\"currentPage\" content=\"Database\"/>\n");
      out.write("      \n");
      out.write("\n");
      out.write("    \n");
      out.write("\n");
      out.write("    \n");
      out.write("      <script type=\"text/javascript\">\n");
      out.write("         /**\n");
      out.write("          * Get {dbHome, dbName} of selected db as JSON string and display\n");
      out.write("          * @returns {undefined}\n");
      out.write("          */             \n");
      out.write("         function getSelectedDatabase() {\n");
      out.write("            $.getJSON('jisis/doGetSelectedDatabase.action',\n");
      out.write("              {type: \"results\"},\n");
      out.write("              // callback function to process results\n");
      out.write("              function(values) {                            \n");
      out.write("                  var s = \"<div id=\\\"database\\\"><p>Home=\"+values[0]+\" dbName= \"+values[1]+\"</p></div>\";\n");
      out.write("                    \n");
      out.write("                  $('#database').replaceWith(s);\n");
      out.write("                  $('#database').css({\n");
      out.write("                                      'background-color': '#ADD8E6',\n");
      out.write("                                      'color': '#256579',\n");
      out.write("                                      'font': '1.6em Verdana, Geneva, Arial, Helvetica, sans-serif'\n");
      out.write("                     \n");
      out.write("                                     });\n");
      out.write("              });\n");
      out.write("            };\n");
      out.write("            \n");
      out.write("         \n");
      out.write("         /**\n");
      out.write("          * Send the selected database index to the server\n");
      out.write("          * index \n");
      out.write("          * @returns {undefined}\n");
      out.write("          */\n");
      out.write("         function sendSelectionIndex(index) {\n");
      out.write("            $.ajax({\n");
      out.write("               type: 'POST',\n");
      out.write("                url: 'jisis/doSetSelectedDbReference.action',\n");
      out.write("               data: { \n");
      out.write("                     'index': index\n");
      out.write("                     },\n");
      out.write("               success: function(data){\n");
      out.write("                    // Get selected db info from server and update page info\n");
      out.write("                    getSelectedDatabase();\n");
      out.write("                    // Scroll web page to the top\n");
      out.write("                    $('html, body').animate({ scrollTop: 0 }, 0);\n");
      out.write("               }\n");
      out.write("            });\n");
      out.write("         };       \n");
      out.write("         \n");
      out.write("      </script>\n");
      out.write("      \n");
      out.write("      <script type=\"text/javascript\">\n");
      out.write("         \n");
      out.write("         // Execute the function when the DOM is ready. This is the function\n");
      out.write("         // in charge of building the Web page dynamically\n");
      out.write("        $(function() {\n");
      out.write("              // 1) Display database selected\n");
      out.write("              $(function() {  \n");
      out.write("                 getSelectedDatabase();\n");
      out.write("              });         \n");
      out.write("              \n");
      out.write("              // 2) Display database homes and names in a table for selection\n");
      out.write("              // Get list of {dbHome, dbName} as JSON string and display for selection\n");
      out.write("              // [ {\"dbHome\": \"DB_HOME\", \"dbName\":\"CDS\"} {..........} ]\n");
      out.write("              //alert($('#select').length + 'elements');\n");
      out.write("              $.getJSON('jisis/doGetDbReferences.action',\n");
      out.write("                    {type: \"results\"},\n");
      out.write("                    function(data) {\n");
      out.write("                       /* build the data table */\n");
      out.write("                      \n");
      out.write("                         var html = ''\n");
      out.write("                             + '<table id=\"table\" class=\"table table-striped table-bordered\">'\n");
      out.write("\n");
      out.write("                             +  '<thead>'\n");
      out.write("                             +     '<tr>'\n");
      out.write("                             +        '<th>dbHome</th>'\n");
      out.write("                             +        '<th>dbName</th>'\n");
      out.write("                             +     '</tr>'\n");
      out.write("                             +  '</thead>'\n");
      out.write("                             +  '<tbody>';\n");
      out.write("\n");
      out.write("                           for (var i=0; i<data.length; i++) {\n");
      out.write("\n");
      out.write("                           \n");
      out.write("                               html += \n");
      out.write("                                       '<tr>'\n");
      out.write("                                       +  '<td width=\"70\">'+data[i].dbHome + '</td>'\n");
      out.write("                                       +  '<td width=\"70\">'+data[i].dbName + '</td>'\n");
      out.write("                                       +  '<td width=\"40\">'+'<button id=\"selectbtn\" class=\"btn\">Select</button>' + '</td>'\n");
      out.write("                               + '</tr>'\n");
      out.write("\n");
      out.write("                           }     \n");
      out.write("                    html += '</tbody>'\n");
      out.write("                            + '<table';\n");
      out.write("\n");
      out.write("                    $('#select').replaceWith(html);\n");
      out.write("                    \n");
      out.write("                    // Select all element buttons that are in the table\n");
      out.write("                    var btns = $('#table tr td button');\n");
      out.write("                    //alert($('#table tr td button').length + 'buttons');\n");
      out.write("                    for (i = 0; i < btns.length; i++) {\n");
      out.write("                       btns[i].onclick = function() {\n");
      out.write("                         \n");
      out.write("                           //alert($(this).closest('td').parent()[0].sectionRowIndex);\n");
      out.write("                           sendSelectionIndex($(this).closest('td').parent()[0].sectionRowIndex);\n");
      out.write("                           \n");
      out.write("                       };\n");
      out.write("                     }\n");
      out.write("\n");
      out.write("                 }\n");
      out.write("                 );\n");
      out.write("         \n");
      out.write("                \n");
      out.write("             \n");
      out.write("           });\n");
      out.write("           \n");
      out.write("  \n");
      out.write("\n");
      out.write("\n");
      out.write("      </script>\n");
      out.write("\n");
      out.write("   </head>\n");
      out.write("   <body>\n");
      out.write("      <!--container constrains the width of the navbar contents, centers them within a wide\n");
      out.write("      screen, and includes a clearfix so that it will contain floated child elements.-->\n");
      out.write("      <div class=\"container\">\n");
      out.write("         <div class=\"well well-small\">\n");
      out.write("            Database Selected:\n");
      out.write("            <div id=\"database\"></div>\n");
      out.write("         </div>\n");
      out.write("         <div class=\"well well-small\">\n");
      out.write("            Select Database:\n");
      out.write("         </div>\n");
      out.write("         <div id=\"select\"></div>\n");
      out.write("      </div>\n");
      out.write("   </body>\n");
      out.write("</html>\n");
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
