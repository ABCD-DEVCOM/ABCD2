package org.apache.jsp.jsp.search;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;

public final class displayResults_jsp extends org.apache.jasper.runtime.HttpJspBase
    implements org.apache.jasper.runtime.JspSourceDependent {

  private static java.util.Vector _jspx_dependants;

  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_s_property_value_nobody;

  public java.util.List getDependants() {
    return _jspx_dependants;
  }

  public void _jspInit() {
    _jspx_tagPool_s_property_value_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
  }

  public void _jspDestroy() {
    _jspx_tagPool_s_property_value_nobody.release();
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
      out.write("\n");
      out.write("\n");
      out.write("\n");
      out.write("<!doctype html>\n");
      out.write("\n");
      out.write("<html>\n");
      out.write("   <head>\n");
      out.write("      <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n");
      out.write("      \n");
      out.write("     \n");
      out.write("      <style type=\"text/css\">\n");
      out.write("         #toolbar {\n");
      out.write("            padding: 10px 4px;\n");
      out.write("         }\n");
      out.write("         // Classes to show/hide the query\n");
      out.write("         // To show it: $(\"#myId\").removeClass('hidden');\n");
      out.write("         // To hide it: $(\"#myId\").addClass('hidden');\n");
      out.write("         // To toggle it: $(\"#myId\").toggleClass('hidden');\n");
      out.write("         .show {\n");
      out.write("            display: block !important;\n");
      out.write("         }\n");
      out.write("         .hidden {\n");
      out.write("            display: none !important;\n");
      out.write("            visibility: hidden !important;\n");
      out.write("         }\n");
      out.write("         .invisible {\n");
      out.write("            visibility: hidden;\n");
      out.write("         }\n");
      out.write("      </style>\n");
      out.write("      <script type=\"text/javascript\">\n");
      out.write("         //---------------------------------------------------------------------\n");
      out.write("         // Code to set the Record navigation toolbar and to respond on\n");
      out.write("         // navigation events\n");
      out.write("         //---------------------------------------------------------------------\n");
      out.write("         //\n");
      out.write("         // When the document is ready, run the function\n");
      out.write("         // shortcut for document-ready idiom\n");
      out.write("         $(function() {\n");
      out.write("\n");
      out.write("            // Get 1st record when document ready\n");
      out.write("            $().ready(function() {\n");
      out.write("               getRecord(\"first\");\n");
      out.write("            });\n");
      out.write("            // First record button\n");
      out.write("            $('button#first').button({\n");
      out.write("               text: false,\n");
      out.write("               icons: {\n");
      out.write("                  primary: 'ui-icon-seek-first'\n");
      out.write("               }\n");
      out.write("            })\n");
      out.write("            .click(function() {\n");
      out.write("               getRecord(\"first\");\n");
      out.write("            });\n");
      out.write("            // Previous record button\n");
      out.write("            $('#prev').button({\n");
      out.write("               text: false,\n");
      out.write("               icons: {\n");
      out.write("                  primary: 'ui-icon-seek-prev'\n");
      out.write("               }\n");
      out.write("            })\n");
      out.write("            .click(function() {\n");
      out.write("               getRecord(\"prev\");\n");
      out.write("            });\n");
      out.write("            // Next record button\n");
      out.write("            $('#next').button({\n");
      out.write("               text: false,\n");
      out.write("               icons: {\n");
      out.write("                  primary: 'ui-icon-seek-next'\n");
      out.write("               }\n");
      out.write("            })\n");
      out.write("            .click(function() {\n");
      out.write("               getRecord(\"next\");\n");
      out.write("            });\n");
      out.write("\n");
      out.write("            $('button#last').button({\n");
      out.write("               text: false,\n");
      out.write("               icons: {\n");
      out.write("                  primary: 'ui-icon-seek-end'\n");
      out.write("               }\n");
      out.write("            })\n");
      out.write("            .click(function() {\n");
      out.write("\n");
      out.write("               getRecord(\"last\");\n");
      out.write("            });\n");
      out.write("            \n");
      out.write("            \n");
      out.write("            $(\"div#query\").replaceWith(\"<p>Query:");
      if (_jspx_meth_s_property_0(_jspx_page_context))
        return;
      out.write("</p>\");\n");
      out.write("            \n");
      out.write("            // Hide the query\n");
      out.write("            $(\"div#info\").addClass('hidden');\n");
      out.write("            \n");
      out.write("         \n");
      out.write("\n");
      out.write("            // Function to request a bunch of records (10 records)\n");
      out.write("            // oper=\"first\" | \"next\" | \"prev\" |\"last\"\n");
      out.write("            function getRecord(oper)\t{\n");
      out.write("\n");
      out.write("               $.getJSON('jisis/doGetRecords.action',\n");
      out.write("               // Parameters sent to the server\n");
      out.write("               {oper: oper, type: \"results\"},\n");
      out.write("               // Callback method, called with the results\n");
      out.write("               function(data){\n");
      out.write("                  \n");
      out.write("                  ");
      out.write("\n");
      out.write("                  if (data.mfnList.length === 0) {\n");
      out.write("                     var msg = \"<h3>No Records found!</h3>\";\n");
      out.write("                     $(\"div#recordsCount\").html(msg);\n");
      out.write("                  } else {\n");
      out.write("                     $(\"div#recordsCount\").html(data.mfnList.length+\" records found:\");\n");
      out.write("                     $(\"#div#mfnList\").html(\"\");\n");
      out.write("                     var link = \"\";\n");
      out.write("                     $.each(data.mfnList, function(i,mfn){\n");
      out.write("\n");
      out.write("                        link  += \"<a href=\\\"#\"+mfn+\"\\\" >\"+mfn+\" </a> \";\n");
      out.write("\n");
      out.write("                       \n");
      out.write("                     });\n");
      out.write("                      $(\"div#mfnList\").html(link);\n");
      out.write("                      var from = parseInt(data.baseResultIndex)+1;\n");
      out.write("                      var to = parseInt(data.baseResultIndex)+data.recordList.length;\n");
      out.write("                      var s = \"<p class=\\\"navbar-text\\\">\"+\"Results \"+from.toString()+\"-\"\n");
      out.write("                              + to.toString()\n");
      out.write("                              + \" of \"+ data.resultsCount\n");
      out.write("                              + \"</p>\";\n");
      out.write("                      \n");
      out.write("                      $(\"div#paging\").html(\"\");      \n");
      out.write("                      $(\"div#paging\").html(s);\n");
      out.write("\n");
      out.write("                      ");
      out.write("\n");
      out.write("                     $(\"#div#recordList\").html(\"\");\n");
      out.write("                     var records = \"\";\n");
      out.write("                     $.each(data.recordList, function(i,record){\n");
      out.write("                        records += record;                     \n");
      out.write("                     });\n");
      out.write("                        $(\"div#recordList\").html(records);\n");
      out.write("                  }\n");
      out.write("               }\n");
      out.write("            );\n");
      out.write("\n");
      out.write("            }\n");
      out.write("         });\n");
      out.write("         \n");
      out.write("        \n");
      out.write("        \n");
      out.write("\n");
      out.write("      </script>\n");
      out.write("      <script type=\"text/javascript\">\n");
      out.write("          $(document).keydown(function(e){\n");
      out.write("             //CTRL + Q keydown - Hide/show info panel\n");
      out.write("             if(e.ctrlKey && e.keyCode === 81){\n");
      out.write("                $(\"div#info\").toggleClass('hidden');\n");
      out.write("             }\n");
      out.write("           });\n");
      out.write("\n");
      out.write("      </script>\n");
      out.write("                     \n");
      out.write("      <script type=\"text/javascript\">\n");
      out.write("         //---------------------------------------------------------------------\n");
      out.write("         // Code to set the PFT selection field in the navigation toolbar and to\n");
      out.write("         //  respond on change events\n");
      out.write("         //---------------------------------------------------------------------\n");
      out.write("         // When the document is ready, run the function\n");
      out.write("         // shortcut for document-ready idiom\n");
      out.write("         $(function() {\n");
      out.write("            $(\"#pftSelect\").ready(function() {\n");
      out.write("               // GET request\n");
      out.write("               $.get('jisis/doGetPftNames.action',\n");
      out.write("               {type: \"results\"},\n");
      out.write("               // The callback will be passed the response data and status\n");
      out.write("               function(options) {\n");
      out.write("                  \n");
      out.write("                 // We get back the list of pftNames in options\n");
      out.write("                 $('select#pftSelect').replaceWith(options);\n");
      out.write("                 // Set the function to be called when there is a change\n");
      out.write("                 //$('select#pftSelect').change(onSelectChange);\n");
      out.write("                  $('select').select2({\n");
      out.write("                       formatResult: format,\n");
      out.write("                       formatSelection: format\n");
      out.write("                  })                 \n");
      out.write("                     .on(\"change\", function(e) {\n");
      out.write("                        // mostly used event, fired to the original element when the value changes\n");
      out.write("                          \n");
      out.write("                        changePft(e.val);\n");
      out.write("                     });\n");
      out.write("               });\n");
      out.write("            });\n");
      out.write("         });\n");
      out.write("         \n");
      out.write("         function format(item) {\n");
      out.write("             var originalText = item.text;\n");
      out.write("             return \"<div style=\\\"text-align:left\\\">\" + originalText + \"</div>\";\n");
      out.write("         }\n");
      out.write("\n");
      out.write("            function changePft(pftName){\n");
      out.write("              //alert(\"changePft function \");\n");
      out.write("              // Change the PFT on the Server side\n");
      out.write("              $.get('jisis/doChangePft.action',\n");
      out.write("                 {pftName: pftName},\n");
      out.write("                 function(){\n");
      out.write("                     \n");
      out.write("                    // Get the record formatted with the new PFT\n");
      out.write("                   \n");
      out.write("                   getRecords(\"first\");\n");
      out.write("                       \n");
      out.write("                 }\n");
      out.write("              );\n");
      out.write("            }\n");
      out.write("            \n");
      out.write("              function getRecords(oper)\t{\n");
      out.write("\n");
      out.write("               $.getJSON('jisis/doGetRecords.action',\n");
      out.write("               {oper: oper, type: \"results\"},\n");
      out.write("               function(data){\n");
      out.write("                  \n");
      out.write("                  ");
      out.write("\n");
      out.write("                  if (data.mfnList.length === 0) {\n");
      out.write("                     var msg = \"<h3>No Records found!</h3>\";\n");
      out.write("                     $(\"div#recordsCount\").html(msg);\n");
      out.write("                  } else {\n");
      out.write("                     $(\"div#recordsCount\").html(\"<p>\"+data.mfnList.length+\" records found:</p>\");\n");
      out.write("                     $(\"#div#mfnList\").html(\"\");\n");
      out.write("                     var link = \"\";\n");
      out.write("                     $.each(data.mfnList, function(i,mfn){\n");
      out.write("\n");
      out.write("                        link  += \"<a href=\\\"#\"+mfn+\"\\\" >\"+mfn+\" </a> \";\n");
      out.write("\n");
      out.write("                       \n");
      out.write("                     });\n");
      out.write("                      $(\"div#mfnList\").html(link);\n");
      out.write("\n");
      out.write("                       var from = parseInt(data.baseResultIndex)+1;\n");
      out.write("                      var to = parseInt(data.baseResultIndex)+data.recordList.length;\n");
      out.write("                      var s = \"<p class=\\\"navbar-text\\\">\"+\"Records \"+from.toString()+\"-\"\n");
      out.write("                              + to.toString()\n");
      out.write("                              + \" of \"+ data.resultsCount\n");
      out.write("                              + \"</p>\";\n");
      out.write("                      \n");
      out.write("                      $(\"div#paging\").html(\"\");      \n");
      out.write("                      $(\"div#paging\").html(s);\n");
      out.write("                      \n");
      out.write("                      ");
      out.write("\n");
      out.write("                     $(\"#div#recordList\").html(\"\");\n");
      out.write("                     var records = \"\";\n");
      out.write("                     $.each(data.recordList, function(i,record){\n");
      out.write("                        records += record;                     \n");
      out.write("                     });\n");
      out.write("                     $(\"div#recordList\").html(records);\n");
      out.write("                  }\n");
      out.write("               }\n");
      out.write("            );\n");
      out.write("\n");
      out.write("            }\n");
      out.write("\n");
      out.write("      </script>     \n");
      out.write("   </head>\n");
      out.write("   \n");
      out.write("   <body>\n");
      out.write("      <!--query placeholder-->\n");
      out.write("      <div id=\"info\">\n");
      out.write("         <div class=\"well\">\n");
      out.write("            <div id=\"query\"></div>\n");
      out.write("            <!--results count placeholder-->\n");
      out.write("            <div id=\"recordsCount\"></div>\n");
      out.write("            <!--Results MFNs placeholder-->\n");
      out.write("            <div id=\"mfnList\"></div>\n");
      out.write("         </div>\n");
      out.write("      </div>\n");
      out.write("      <!--results navigation bar placeholder-->\n");
      out.write("      <div class=\"collapse navbar-collapse\" id=\"example-navbar-collapse\">\n");
      out.write("         <div class=\"navbar navbar-default\" role=\"navigation\">  \n");
      out.write("            <div class=\"navbar-inner\">  \n");
      out.write("               <div class=\"container\">  \n");
      out.write("                  <!--navigation does here--> \n");
      out.write("                  <!--Placeholder for from-to of text -->\n");
      out.write("                  <div id=\"paging\"></div>\n");
      out.write("                  <button  class=\"btn btn-default navbar-btn\" id=\"first\" title=\"First 10 records\"><span class=\"glyphicon glyphicon-step-backward\"></span></button>\n");
      out.write("                  <button  class=\"btn btn-default navbar-btn\" id=\"prev\" title=\"Previous 10 records\"><span class=\"glyphicon glyphicon-chevron-left\"></span></button>\n");
      out.write("                  <button  class=\"btn btn-default navbar-btn\" id=\"next\" title=\"Next 10 records\"><span class=\"glyphicon glyphicon-chevron-right\"></span></button>\n");
      out.write("                  <button  class=\"btn btn-default navbar-btn\" id=\"last\" title=\"Last 10 records\"><span class=\"glyphicon glyphicon-step-forward\"></span></button>\n");
      out.write("\n");
      out.write("                  <span class=\"label label-default\"> PFT: </span><select id=\"pftSelect\"></select>\n");
      out.write("\n");
      out.write("               </div>  \n");
      out.write("            </div>  \n");
      out.write("         </div>  \n");
      out.write("      </div>     \n");
      out.write("      <!--result records placeholder-->\n");
      out.write("      <div class=\"panel\">\n");
      out.write("         <div id=\"recordList\">\n");
      out.write("            <p id=\"records\"></p>\n");
      out.write("         </div>\n");
      out.write("      </div>\n");
      out.write("\n");
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

  private boolean _jspx_meth_s_property_0(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  s:property
    org.apache.struts2.views.jsp.PropertyTag _jspx_th_s_property_0 = (org.apache.struts2.views.jsp.PropertyTag) _jspx_tagPool_s_property_value_nobody.get(org.apache.struts2.views.jsp.PropertyTag.class);
    _jspx_th_s_property_0.setPageContext(_jspx_page_context);
    _jspx_th_s_property_0.setParent(null);
    _jspx_th_s_property_0.setValue("luceneQuery");
    int _jspx_eval_s_property_0 = _jspx_th_s_property_0.doStartTag();
    if (_jspx_th_s_property_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_s_property_value_nobody.reuse(_jspx_th_s_property_0);
    return false;
  }
}
