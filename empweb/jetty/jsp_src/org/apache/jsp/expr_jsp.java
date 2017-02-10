package org.apache.jsp;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;

public final class expr_jsp extends org.apache.jasper.runtime.HttpJspBase
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
      response.setContentType("text/html");
      pageContext = _jspxFactory.getPageContext(this, request, response,
      			null, true, 8192, true);
      _jspx_page_context = pageContext;
      application = pageContext.getServletContext();
      config = pageContext.getServletConfig();
      session = pageContext.getSession();
      out = pageContext.getOut();
      _jspx_out = out;

      out.write("<html>\n<h1>JSP2.0 Expressions</h1>\n\n<table border=\"1\">\n  <tr><th>Expression</th><th>Result</th></tr>      \n  <tr>\n    <td>${param[\"A\"]}</td>\n    <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param[\"A\"]}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&nbsp;</td>\n  </tr><tr>\n    <td>${header[\"host\"]}</td>\n    <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${header[\"host\"]}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n  </tr><tr>\n    <td>${header[\"user-agent\"]}</td>\n    <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${header[\"user-agent\"]}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n  </tr><tr>\n    <td>${1+1}</td>\n    <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${1+1}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("</td>\n  </tr><tr>\n    <td>${param[\"A\"] * 2}</td>\n    <td>");
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param[\"A\"] * 2}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
      out.write("&nbsp;</td>\n  </tr>\n</table>\n</html>\n");
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
