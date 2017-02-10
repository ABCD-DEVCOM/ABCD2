package org.apache.jsp;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import javax.servlet.http.HttpUtils;
import java.util.Enumeration;

public final class snoop_jsp extends org.apache.jasper.runtime.HttpJspBase
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

      out.write("<HTML>\n<HEAD>\n\t<TITLE>JSP snoop page</TITLE>\n\t\n</HEAD>\n<BODY>\n\n<H1>WebApp JSP Snoop page</H1>\n\n<H2>Request information</H2>\n\n<TABLE>\n<TR>\n\t<TH align=right>Requested URL:</TH>\n\t<TD>");
      out.print( HttpUtils.getRequestURL(request) );
      out.write("</TD>\n</TR>\n<TR>\n\t<TH align=right>Request method:</TH>\n\t<TD>");
      out.print( request.getMethod() );
      out.write("</TD>\n</TR>\n<TR>\n\t<TH align=right>Request URI:</TH>\n\t<TD>");
      out.print( request.getRequestURI() );
      out.write("</TD>\n</TR>\n<TR>\n\t<TH align=right>Request protocol:</TH>\n\t<TD>");
      out.print( request.getProtocol() );
      out.write("</TD>\n</TR>\n<TR>\n\t<TH align=right>Servlet path:</TH>\n\t<TD>");
      out.print( request.getServletPath() );
      out.write("</TD>\n</TR>\n<TR>\n\t<TH align=right>Path info:</TH>\n\t<TD>");
      out.print( request.getPathInfo() );
      out.write("</TD>\n</TR>\n<TR>\n\t<TH align=right>Path translated:</TH>\n\t<TD>");
      out.print( request.getPathTranslated() );
      out.write("</TD>\n</TR>\n<TR>\n\t<TH align=right>Query string:</TH>\n\t<TD>");
      out.print( request.getQueryString() );
      out.write("</TD>\n</TR>\n<TR>\n\t<TH align=right>Content length:</TH>\n\t<TD>");
      out.print( request.getContentLength() );
      out.write("</TD>\n</TR>\n<TR>\n\t<TH align=right>Content type:</TH>\n\t<TD>");
      out.print( request.getContentType() );
      out.write("</TD>\n<TR>\n<TR>\n\t<TH align=right>Server name:</TH>\n\t<TD>");
      out.print( request.getServerName() );
      out.write("</TD>\n<TR>\n<TR>\n\t<TH align=right>Server port:</TH>\n\t<TD>");
      out.print( request.getServerPort() );
      out.write("</TD>\n<TR>\n<TR>\n\t<TH align=right>Remote user:</TH>\n\t<TD>");
      out.print( request.getRemoteUser() );
      out.write("</TD>\n<TR>\n<TR>\n\t<TH align=right>Remote address:</TH>\n\t<TD>");
      out.print( request.getRemoteAddr() );
      out.write("</TD>\n<TR>\n<TR>\n\t<TH align=right>Remote host:</TH>\n\t<TD>");
      out.print( request.getRemoteHost() );
      out.write("</TD>\n<TR>\n<TR>\n\t<TH align=right>Authorization scheme:</TH>\n\t<TD>");
      out.print( request.getAuthType() );
      out.write("</TD>\n<TR>\n</TABLE>\n\n");

	Enumeration e = request.getHeaderNames();
	if(e != null && e.hasMoreElements()) {

      out.write("\n<H2>Request headers</H2>\n\n<TABLE>\n<TR>\n\t<TH align=left>Header:</TH>\n\t<TH align=left>Value:</TH>\n</TR>\n");

		while(e.hasMoreElements()) {
			String k = (String) e.nextElement();

      out.write("\n<TR>\n\t<TD>");
      out.print( k );
      out.write("</TD>\n\t<TD>");
      out.print( request.getHeader(k) );
      out.write("</TD>\n</TR>\n");

		}

      out.write("\n</TABLE>\n");

	}

      out.write('\n');
      out.write('\n');
      out.write('\n');

	e = request.getParameterNames();
	if(e != null && e.hasMoreElements()) {

      out.write("\n<H2>Request parameters</H2>\n<TABLE>\n<TR valign=top>\n\t<TH align=left>Parameter:</TH>\n\t<TH align=left>Value:</TH>\n\t<TH align=left>Multiple values:</TH>\n</TR>\n");

		while(e.hasMoreElements()) {
			String k = (String) e.nextElement();
			String val = request.getParameter(k);
			String vals[] = request.getParameterValues(k);

      out.write("\n<TR valign=top>\n\t<TD>");
      out.print( k );
      out.write("</TD>\n\t<TD>");
      out.print( val );
      out.write("</TD>\n\t<TD>");

			for(int i = 0; i < vals.length; i++) {
				if(i > 0)
					out.print("<BR>");
				out.print(vals[i]);
			}
		
      out.write("</TD>\n</TR>\n");

		}

      out.write("\n</TABLE>\n");

	}

      out.write('\n');
      out.write('\n');
      out.write('\n');

	e = request.getAttributeNames();
	if(e != null && e.hasMoreElements()) {

      out.write("\n<H2>Request Attributes</H2>\n<TABLE>\n<TR valign=top>\n\t<TH align=left>Attribute:</TH>\n\t<TH align=left>Value:</TH>\n</TR>\n");

		while(e.hasMoreElements()) {
			String k = (String) e.nextElement();
			Object val = request.getAttribute(k);

      out.write("\n<TR valign=top>\n\t<TD>");
      out.print( k );
      out.write("</TD>\n\t<TD>");
      out.print( val );
      out.write("</TD>\n</TR>\n");

		}

      out.write("\n</TABLE>\n");

	}

      out.write('\n');
      out.write('\n');
      out.write('\n');

	e = getServletConfig().getInitParameterNames();
	if(e != null && e.hasMoreElements()) {

      out.write("\n<H2>Init parameters</H2>\n<TABLE>\n<TR valign=top>\n\t<TH align=left>Parameter:</TH>\n\t<TH align=left>Value:</TH>\n</TR>\n");

		while(e.hasMoreElements()) {
			String k = (String) e.nextElement();
			String val = getServletConfig().getInitParameter(k);

      out.write("\n<TR valign=top>\n\t<TD>");
      out.print( k );
      out.write("</TD>\n\t<TD>");
      out.print( val );
      out.write("</TD>\n</TR>\n");

		}

      out.write("\n</TABLE>\n");

	}

      out.write("\n\n\n</BODY>\n</HTML>\n\n");
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
