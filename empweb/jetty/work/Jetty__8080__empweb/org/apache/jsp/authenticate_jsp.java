package org.apache.jsp;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import java.util.Locale;
import java.util.Properties;
import java.util.Locale;
import java.util.HashMap;
import java.util.TreeSet;
import java.util.Iterator;
import java.util.ArrayList;
import java.util.Enumeration;
import java.util.Calendar;
import java.util.GregorianCalendar;
import net.kalio.auth.*;
import net.kalio.utils.*;

public final class authenticate_jsp extends org.apache.jasper.runtime.HttpJspBase
    implements org.apache.jasper.runtime.JspSourceDependent {

 // Helper functions

boolean checkHours(String hs)
{ 
  //expected format examples:
  //   * mon-fri@10:30-23:59;sat@10:30-13:00   (sunday is closed)
  //   * 10:30-23:59   (all days)

  // TODO
  //   * cambiar esta chanchada del hashmap
  //   * como localizar? (definir una entidad biblioteca
  //     dentro del gui, con su sistema de admin parece ser lo mas
  //     razonable. Guardar la constante correspondiente en el engine

  HashMap daysOfWeek = new HashMap();
  daysOfWeek.put("mon", new Integer(Calendar.MONDAY));
  daysOfWeek.put("tue", new Integer(Calendar.TUESDAY));
  daysOfWeek.put("wed", new Integer(Calendar.WEDNESDAY));
  daysOfWeek.put("thu", new Integer(Calendar.THURSDAY));
  daysOfWeek.put("fri", new Integer(Calendar.FRIDAY));
  daysOfWeek.put("sat", new Integer(Calendar.SATURDAY));
  daysOfWeek.put("sun", new Integer(Calendar.SUNDAY));

  daysOfWeek.put("lun", new Integer(Calendar.MONDAY));
  daysOfWeek.put("mar", new Integer(Calendar.TUESDAY));
  daysOfWeek.put("mie", new Integer(Calendar.WEDNESDAY));
  daysOfWeek.put("jue", new Integer(Calendar.THURSDAY));
  daysOfWeek.put("vie", new Integer(Calendar.FRIDAY));
  daysOfWeek.put("sab", new Integer(Calendar.SATURDAY));
  daysOfWeek.put("dom", new Integer(Calendar.SUNDAY));


  GregorianCalendar now = new GregorianCalendar();
  int nowH = now.get(Calendar.HOUR_OF_DAY)*100 + now.get(Calendar.MINUTE);
  int nowD = now.get(Calendar.DAY_OF_WEEK);

  System.out.println("nowH   :"+nowH);
  System.out.println("nowD   :"+nowD);

  int startD = -1;
  int endD   = -1;
  int startH = -1;
  int endH   = -1;

  try {
    hs = hs.replaceAll(":","");
    String ranges[] = hs.split(";");

    for (int i=0; i<ranges.length; i++) {
      String range[] = ranges[i].split("@");
      if (range.length == 2) {
        // has day and time
        String d[] = range[0].split("-");
        startD = ((Integer)daysOfWeek.get(d[0])).intValue();
        if (d.length > 1) {
          endD = ((Integer)daysOfWeek.get(d[1])).intValue();
        } else {
          endD = startD;
        }

        String h[] = range[1].split("-");
        startH = Integer.parseInt(h[0]);
        endH = Integer.parseInt(h[1]);
      } else {
        // has only time
        String h[] = range[0].split("-");
        startH = Integer.parseInt(h[0]);
        endH = Integer.parseInt(h[1]);
        startD = now.get(Calendar.DAY_OF_WEEK);
        endD = startD;
      }

      Properties props = (Properties)getServletContext().getAttribute("config");
      //if ( (props != null) && (props.getProperty("gui.debug") != null) ) {
        System.out.println("range    :"+ranges[i]);
        System.out.println("  startH :"+startH);
        System.out.println("  endH   :"+endH);
        System.out.println("  startD :"+startD);
        System.out.println("  endD   :"+endD);
      //}
    
      // check day of the week and time. consider wrap-arround intervals too
      if (startD <= endD) { 
        if ( (nowD >= startD) && (nowD <= endD) && (nowH > startH) && (nowH < endH) )
          return true;
      } else {
        if ( ((nowD <= startD) || (nowD >= endD)) && (nowH > startH) && (nowH < endH) )
          return true;
      }
        
    }

  } catch (Exception e){
    System.out.println("access denied. invalid hour string: "+hs);
  }
  return false;
}


static private org.apache.jasper.runtime.ProtectedFunctionMapper _jspx_fnmap_0;
static private org.apache.jasper.runtime.ProtectedFunctionMapper _jspx_fnmap_1;

static {
  _jspx_fnmap_0= org.apache.jasper.runtime.ProtectedFunctionMapper.getMapForFunction("fn:trim", org.apache.taglibs.standard.functions.Functions.class, "trim", new Class[] {java.lang.String.class});
  _jspx_fnmap_1= org.apache.jasper.runtime.ProtectedFunctionMapper.getMapForFunction("kfn:urlenc", net.kalio.jsptags.kfn.JSPELFunctions.class, "URLEncode", new Class[] {java.lang.String.class});
}

  private static java.util.Vector _jspx_dependants;

  static {
    _jspx_dependants = new java.util.Vector(5);
    _jspx_dependants.add("/doctype.jspf");
    _jspx_dependants.add("/userlocale.jspf");
    _jspx_dependants.add("/WEB-INF/tld/kaliojsp-el-func-1.0.tld");
    _jspx_dependants.add("/WEB-INF/tags/trans/doTransaction.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/forEach.tag");
  }

  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_setLocale_value_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_setBundle_scope_basename_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_if_test;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_redirect_url;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_param_name;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_x_parse_varDom;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_value_target_property_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_choose;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_when_test;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_redirect_url_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_otherwise;

  public java.util.List getDependants() {
    return _jspx_dependants;
  }

  public void _jspInit() {
    _jspx_tagPool_fmt_setLocale_value_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_fmt_setBundle_scope_basename_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_if_test = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_redirect_url = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_param_name = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_x_parse_varDom = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_set_value_target_property_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_choose = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_when_test = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_redirect_url_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
    _jspx_tagPool_c_otherwise = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(getServletConfig());
  }

  public void _jspDestroy() {
    _jspx_tagPool_fmt_setLocale_value_nobody.release();
    _jspx_tagPool_fmt_setBundle_scope_basename_nobody.release();
    _jspx_tagPool_c_if_test.release();
    _jspx_tagPool_c_redirect_url.release();
    _jspx_tagPool_c_param_name.release();
    _jspx_tagPool_x_parse_varDom.release();
    _jspx_tagPool_c_set_value_target_property_nobody.release();
    _jspx_tagPool_c_choose.release();
    _jspx_tagPool_c_when_test.release();
    _jspx_tagPool_c_redirect_url_nobody.release();
    _jspx_tagPool_c_otherwise.release();
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

      if (_jspx_meth_fmt_setLocale_0(_jspx_page_context))
        return;
      if (_jspx_meth_fmt_setBundle_0(_jspx_page_context))
        return;
      if (_jspx_meth_c_if_0(_jspx_page_context))
        return;
      if (_jspx_meth_x_parse_0(_jspx_page_context))
        return;
      java.util.HashMap nsml = null;
      synchronized (_jspx_page_context) {
        nsml = (java.util.HashMap) _jspx_page_context.getAttribute("nsml", PageContext.PAGE_SCOPE);
        if (nsml == null){
          nsml = new java.util.HashMap();
          _jspx_page_context.setAttribute("nsml", nsml, PageContext.PAGE_SCOPE);
        }
      }
      if (_jspx_meth_c_set_0(_jspx_page_context))
        return;
      java.util.HashMap librariesIpMap = null;
      synchronized (_jspx_page_context) {
        librariesIpMap = (java.util.HashMap) _jspx_page_context.getAttribute("librariesIpMap", PageContext.PAGE_SCOPE);
        if (librariesIpMap == null){
          librariesIpMap = new java.util.HashMap();
          _jspx_page_context.setAttribute("librariesIpMap", librariesIpMap, PageContext.PAGE_SCOPE);
        }
      }
      java.util.HashMap librariesHoursMap = null;
      synchronized (_jspx_page_context) {
        librariesHoursMap = (java.util.HashMap) _jspx_page_context.getAttribute("librariesHoursMap", PageContext.PAGE_SCOPE);
        if (librariesHoursMap == null){
          librariesHoursMap = new java.util.HashMap();
          _jspx_page_context.setAttribute("librariesHoursMap", librariesHoursMap, PageContext.PAGE_SCOPE);
        }
      }
      //  jxp:forEach
      org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_0 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
      java.util.HashMap _jspx_th_jxp_forEach_0_aliasMap = new java.util.HashMap();
      _jspx_th_jxp_forEach_0_aliasMap.put("punt", "libr");
      _jspx_th_jxp_forEach_0.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_0_aliasMap);
      _jspx_th_jxp_forEach_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${libraries}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_forEach_0.setVar("libr");
      _jspx_th_jxp_forEach_0.setSelect("//tr:library");
      _jspx_th_jxp_forEach_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsml}", java.util.Map.class, (PageContext)_jspx_page_context, null, false));
      _jspx_th_jxp_forEach_0.setJspBody(new authenticate_jspHelper( 0, _jspx_page_context, _jspx_th_jxp_forEach_0, null));
      _jspx_th_jxp_forEach_0.doTag();

Auth.setAuthPath( System.getProperty("empweb.home", "/") +
                  application.getInitParameter("net.kalio.auth.location"));
String userid =   (request.getParameter("user") != null) ? request.getParameter("user").trim() : null;
String password = (request.getParameter("password") != null) ? request.getParameter("password").trim() : null;
String library =    request.getParameter("library");
String remoteAddr = request.getRemoteAddr();

String errorMsg = null;

String perms[];
HashMap propHash;
boolean accountEnabled = false;
boolean libraryAccessible = false;
boolean addrAllowed = false;
boolean libraryHours = false;

int libsCount = 0;
String libsWithAccess = "";  // comma separated
String libDefault = "";

session.setAttribute("authSuccess","false"); // default result

if ( (userid != null) && (password != null || "true".equals((String)session.getAttribute("auth"))) ) {

    // get permissions

    // was the user already authenticated?
    if ("true".equals((String)session.getAttribute("auth")))
      { if ( (props != null) && (props.getProperty("gui.debug") != null) )
          System.out.println("User was already authenticated!");
        perms = Auth.getPermissions(userid);
      }
    else
      { if ( (props != null) && (props.getProperty("gui.debug") != null) )
          System.out.println("User hadn't been authenticated before...");
        perms = Auth.getPermissionsWithAuth(userid, password); 
      }
    
    propHash = Auth.getUserProperties(userid);                // get properties hash

    if ((library == null) || (library.length() < 1)) {
      // library was not provided by the user, build list to send to login screen
      if (propHash != null) {
        Iterator it = (new TreeSet(propHash.keySet())).iterator();
        while (it.hasNext()) {
          String libName = (String)it.next();
          if ( (libName.startsWith("library-")) && ("on".equals(propHash.get(libName))) ) {
            libDefault = libName.substring(8);
            libsWithAccess += libDefault+(it.hasNext()  ? "," : "");
            libsCount++;
          }
        }//while
      }
    }
    if ( (props != null) && (props.getProperty("gui.debug") != null) ) {
      System.out.println("libsWithAccess :"+libsWithAccess);
    }

    // start checking
    if (perms == null) {
        errorMsg ="error_enter_valid_user_pass";
    } else {
      // check if account enabled
      accountEnabled = ("on".equals(propHash.get("accountenabled")));
      if (!accountEnabled ) {
        session.setAttribute("accountdisabled","true");
        errorMsg = "error_account_disabled";
      } else {
        // check for library access
        if (libsCount == 1)
          library = libDefault;

        libraryAccessible = ("on".equals(propHash.get("library-"+library)));
        System.out.println("library " + library + " accesible: " + libraryAccessible);
        if (!libraryAccessible) {
          if ((library == null) || (library.length() < 1)) {
            errorMsg = "error_choose_library";
          } else {
            errorMsg = "error_library_not_accessible";
          }
        } else {
          // check for library access from the client IP
          String iplist = "";
          if ( "on".equals(propHash.get("connectfrom-iplist-on")) ) {
            iplist = (String) propHash.get("connectfrom-iplist")+",";
          }
          Iterator itP = propHash.keySet().iterator();
          while (itP.hasNext()) {
            String key = (String)itP.next();
            if (key.startsWith("connectfrom-library-")) {
              iplist += librariesIpMap.get(key.substring(20))+",";
            }
          }
          if ("on".equals(propHash.get("connectfrom-anywhere")))
            iplist += ",*";
          addrAllowed = IpAcl.ipInAcl(remoteAddr, iplist);
          // DEBUG
          if ( (props != null) && (props.getProperty("gui.debug") != null) ) {
            System.out.println("remoteAddr :"+remoteAddr);
            System.out.println("iplist     :"+iplist);
            System.out.println("addrAllowed:"+addrAllowed);
          }

          if (!addrAllowed) {
            errorMsg = "error_client_ip_not_allowed";
          } else { // address allowed
            // check library hours
            String hs = (String)librariesHoursMap.get(library);
            if (hs != null) {                                   // the library has defined hour range
              libraryHours = checkHours(hs);

              // Maybe this operator has unrestricted access for this library at all times
              if ("on".equals( (String)propHash.get("libraryHoursUnrestricted-"+library)))
                libraryHours = true;

            } else {  // If the library has no defined hour range, assume it's always closed!
              libraryHours= false;
            }

            if (!libraryHours && !"admin".equals(userid)) {
              errorMsg = "error_outside_library_hours";
            } else {
              // account enabled
              session.removeAttribute("accountdisabled");
              session.setAttribute("authSuccess","true"); // THIS authorization process was successful
              session.setAttribute("auth","true");
              session.setAttribute("user", userid);
              session.setAttribute("useremail", Auth.getUserData("/users/user[@id='"+userid+"']/email"));
              session.setAttribute("username", Auth.getUserData("/users/user[@id='"+userid+"']/username"));
              System.out.println("Setting library to: " + library);
              session.setAttribute("library",library);

              // Limpio los permisos existentes en la sesion, en caso que se haya
              // cambiado de biblioteca en medio de la sesion
              Enumeration currentAttributes = session.getAttributeNames();
              String attrName = "";
              while( currentAttributes.hasMoreElements() )
                { attrName = (String) currentAttributes.nextElement();
                  if (attrName != null && attrName.startsWith("group-") )
                    { System.out.println("Found existing permission : " + attrName);
                      session.removeAttribute(attrName);
                    }
                }

              // debug
              // print the permissions for the user right after flushing them 
              // (there shouldn't be any!!!)
              if ( (props != null) && (props.getProperty("gui.debug") != null) )
                { System.out.println("Permissions right after flushing ( there shouldn't be any! )...");
                  while( currentAttributes.hasMoreElements() )
                  { attrName = (String) currentAttributes.nextElement();
                    if (attrName != null && attrName.startsWith("group-") )
                      { System.out.println("Reviewing existing permission after flushing : " + attrName);
                      }
                  }
                  System.out.println("Done printing permissions after flushing");
                }


              // Ahora pongo un atributo en la sesion para cada uno de los permisos. El formato del nombre
              // del atributo es  group-groupid  donde groupid es el el id del grupo
              for (int i= 0; i < perms.length; i++) {
                session.setAttribute("group-"+perms[i], "true");
              }

              // cargar las propiedades de usuario
              Iterator it = propHash.keySet().iterator();
              while (it.hasNext()) {
                String key = (String)it.next();
                session.setAttribute("property-"+key, (String)propHash.get(key));
              }
            } // else account enabled
          } // else address allowed
        } // else library is accessible
      } // else account is enabled
    } // else perms != null
} // if userid != null & (password != null || auth=="true")
pageContext.setAttribute("errorMsg", errorMsg);
pageContext.setAttribute("libsWithAccess", libsWithAccess);

String authSuccess = (String) session.getAttribute("authSuccess");
if ( (authSuccess != null) && (authSuccess.equals("true")) ) {

      if (_jspx_meth_c_choose_0(_jspx_page_context))
        return;

} else if (libsWithAccess.length() > 0) {
  
  session.setAttribute("prevlogin",userid); // default result
  session.setAttribute("prevpass",password); // default result
  

      if (_jspx_meth_c_redirect_3(_jspx_page_context))
        return;

} else if (errorMsg != null) {

      if (_jspx_meth_c_redirect_4(_jspx_page_context))
        return;

} else {

      if (_jspx_meth_c_redirect_5(_jspx_page_context))
        return;
 } 
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
    org.apache.taglibs.standard.tag.rt.fmt.SetLocaleTag _jspx_th_fmt_setLocale_0 = (org.apache.taglibs.standard.tag.rt.fmt.SetLocaleTag) _jspx_tagPool_fmt_setLocale_value_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.SetLocaleTag.class);
    _jspx_th_fmt_setLocale_0.setPageContext(_jspx_page_context);
    _jspx_th_fmt_setLocale_0.setParent(null);
    _jspx_th_fmt_setLocale_0.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${sessionScope.userLocale}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    int _jspx_eval_fmt_setLocale_0 = _jspx_th_fmt_setLocale_0.doStartTag();
    if (_jspx_th_fmt_setLocale_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_fmt_setLocale_value_nobody.reuse(_jspx_th_fmt_setLocale_0);
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

  private boolean _jspx_meth_c_if_0(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_0 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_0.setPageContext(_jspx_page_context);
    _jspx_th_c_if_0.setParent(null);
    _jspx_th_c_if_0.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${empty param.user || empty param.password}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_if_0 = _jspx_th_c_if_0.doStartTag();
    if (_jspx_eval_c_if_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_redirect_0(_jspx_th_c_if_0, _jspx_page_context))
          return true;
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

  private boolean _jspx_meth_c_redirect_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:redirect
    org.apache.taglibs.standard.tag.rt.core.RedirectTag _jspx_th_c_redirect_0 = (org.apache.taglibs.standard.tag.rt.core.RedirectTag) _jspx_tagPool_c_redirect_url.get(org.apache.taglibs.standard.tag.rt.core.RedirectTag.class);
    _jspx_th_c_redirect_0.setPageContext(_jspx_page_context);
    _jspx_th_c_redirect_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_0);
    _jspx_th_c_redirect_0.setUrl("login.jsp");
    int _jspx_eval_c_redirect_0 = _jspx_th_c_redirect_0.doStartTag();
    if (_jspx_eval_c_redirect_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_redirect_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_redirect_0.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_redirect_0.doInitBody();
      }
      do {
        if (_jspx_meth_c_param_0(_jspx_th_c_redirect_0, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_redirect_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_redirect_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_redirect_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_redirect_url.reuse(_jspx_th_c_redirect_0);
    return false;
  }

  private boolean _jspx_meth_c_param_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_redirect_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:param
    org.apache.taglibs.standard.tag.rt.core.ParamTag _jspx_th_c_param_0 = (org.apache.taglibs.standard.tag.rt.core.ParamTag) _jspx_tagPool_c_param_name.get(org.apache.taglibs.standard.tag.rt.core.ParamTag.class);
    _jspx_th_c_param_0.setPageContext(_jspx_page_context);
    _jspx_th_c_param_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_redirect_0);
    _jspx_th_c_param_0.setName("errorMsg");
    int _jspx_eval_c_param_0 = _jspx_th_c_param_0.doStartTag();
    if (_jspx_eval_c_param_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_param_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_param_0.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_param_0.doInitBody();
      }
      do {
        out.write("error_enter_valid_user_pass");
        int evalDoAfterBody = _jspx_th_c_param_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_param_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_param_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_param_name.reuse(_jspx_th_c_param_0);
    return false;
  }

  private boolean _jspx_meth_x_parse_0(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_0 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_0.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_0.setParent(null);
    _jspx_th_x_parse_0.setVarDom("libraries");
    int _jspx_eval_x_parse_0 = _jspx_th_x_parse_0.doStartTag();
    if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_0.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_0.doInitBody();
      }
      do {
        if (_jspx_meth_trans_doTransaction_0(_jspx_th_x_parse_0, _jspx_page_context))
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

  private boolean _jspx_meth_trans_doTransaction_0(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  trans:doTransaction
    org.apache.jsp.tag.web.trans.doTransaction_tag _jspx_th_trans_doTransaction_0 = new org.apache.jsp.tag.web.trans.doTransaction_tag();
    _jspx_th_trans_doTransaction_0.setJspContext(_jspx_page_context);
    _jspx_th_trans_doTransaction_0.setParent(_jspx_th_x_parse_0);
    _jspx_th_trans_doTransaction_0.setName("conf-getLibraries");
    _jspx_th_trans_doTransaction_0.doTag();
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
    _jspx_th_c_set_0.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsml}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_0.setProperty("tr");
    _jspx_th_c_set_0.setValue(new String("http://kalio.net/empweb/schema/transactionresult/v1"));
    int _jspx_eval_c_set_0 = _jspx_th_c_set_0.doStartTag();
    if (_jspx_th_c_set_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_0);
    return false;
  }

  private boolean _jspx_meth_c_set_1(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_1 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_1.setPageContext(_jspx_page_context);
    _jspx_th_c_set_1.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_set_1.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${librariesIpMap}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_1.setProperty((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(libr['@id'])}", java.lang.String.class, (PageContext)_jspx_page_context, _jspx_fnmap_0, false));
    _jspx_th_c_set_1.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(libr['tr:ipMask'])}", java.lang.Object.class, (PageContext)_jspx_page_context, _jspx_fnmap_0, false));
    int _jspx_eval_c_set_1 = _jspx_th_c_set_1.doStartTag();
    if (_jspx_th_c_set_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_1);
    return false;
  }

  private boolean _jspx_meth_c_set_2(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_2 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_2.setPageContext(_jspx_page_context);
    _jspx_th_c_set_2.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_set_2.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${librariesHoursMap}", java.lang.Object.class, (PageContext)_jspx_page_context, null, false));
    _jspx_th_c_set_2.setProperty((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(libr['@id'])}", java.lang.String.class, (PageContext)_jspx_page_context, _jspx_fnmap_0, false));
    _jspx_th_c_set_2.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:trim(libr['tr:hours'])}", java.lang.Object.class, (PageContext)_jspx_page_context, _jspx_fnmap_0, false));
    int _jspx_eval_c_set_2 = _jspx_th_c_set_2.doStartTag();
    if (_jspx_th_c_set_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_2);
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
    _jspx_th_c_when_0.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${!empty param.origURL}", java.lang.Boolean.class, (PageContext)_jspx_page_context, null, false)).booleanValue());
    int _jspx_eval_c_when_0 = _jspx_th_c_when_0.doStartTag();
    if (_jspx_eval_c_when_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_redirect_1(_jspx_th_c_when_0, _jspx_page_context))
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

  private boolean _jspx_meth_c_redirect_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:redirect
    org.apache.taglibs.standard.tag.rt.core.RedirectTag _jspx_th_c_redirect_1 = (org.apache.taglibs.standard.tag.rt.core.RedirectTag) _jspx_tagPool_c_redirect_url_nobody.get(org.apache.taglibs.standard.tag.rt.core.RedirectTag.class);
    _jspx_th_c_redirect_1.setPageContext(_jspx_page_context);
    _jspx_th_c_redirect_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_0);
    _jspx_th_c_redirect_1.setUrl((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${param.origURL}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    int _jspx_eval_c_redirect_1 = _jspx_th_c_redirect_1.doStartTag();
    if (_jspx_th_c_redirect_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_redirect_url_nobody.reuse(_jspx_th_c_redirect_1);
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
        if (_jspx_meth_c_redirect_2(_jspx_th_c_otherwise_0, _jspx_page_context))
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

  private boolean _jspx_meth_c_redirect_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_0, PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:redirect
    org.apache.taglibs.standard.tag.rt.core.RedirectTag _jspx_th_c_redirect_2 = (org.apache.taglibs.standard.tag.rt.core.RedirectTag) _jspx_tagPool_c_redirect_url_nobody.get(org.apache.taglibs.standard.tag.rt.core.RedirectTag.class);
    _jspx_th_c_redirect_2.setPageContext(_jspx_page_context);
    _jspx_th_c_redirect_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_0);
    _jspx_th_c_redirect_2.setUrl("/home/index.jsp");
    int _jspx_eval_c_redirect_2 = _jspx_th_c_redirect_2.doStartTag();
    if (_jspx_th_c_redirect_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_redirect_url_nobody.reuse(_jspx_th_c_redirect_2);
    return false;
  }

  private boolean _jspx_meth_c_redirect_3(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:redirect
    org.apache.taglibs.standard.tag.rt.core.RedirectTag _jspx_th_c_redirect_3 = (org.apache.taglibs.standard.tag.rt.core.RedirectTag) _jspx_tagPool_c_redirect_url_nobody.get(org.apache.taglibs.standard.tag.rt.core.RedirectTag.class);
    _jspx_th_c_redirect_3.setPageContext(_jspx_page_context);
    _jspx_th_c_redirect_3.setParent(null);
    _jspx_th_c_redirect_3.setUrl((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("/login.jsp?errorMsg=${errorMsg}&libraries=${libsWithAccess}&user=${param.user}&origURL=${kfn:urlenc(param.origURL)}", java.lang.String.class, (PageContext)_jspx_page_context, _jspx_fnmap_1, false));
    int _jspx_eval_c_redirect_3 = _jspx_th_c_redirect_3.doStartTag();
    if (_jspx_th_c_redirect_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_redirect_url_nobody.reuse(_jspx_th_c_redirect_3);
    return false;
  }

  private boolean _jspx_meth_c_redirect_4(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:redirect
    org.apache.taglibs.standard.tag.rt.core.RedirectTag _jspx_th_c_redirect_4 = (org.apache.taglibs.standard.tag.rt.core.RedirectTag) _jspx_tagPool_c_redirect_url_nobody.get(org.apache.taglibs.standard.tag.rt.core.RedirectTag.class);
    _jspx_th_c_redirect_4.setPageContext(_jspx_page_context);
    _jspx_th_c_redirect_4.setParent(null);
    _jspx_th_c_redirect_4.setUrl((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("/login.jsp?errorMsg=${errorMsg}", java.lang.String.class, (PageContext)_jspx_page_context, null, false));
    int _jspx_eval_c_redirect_4 = _jspx_th_c_redirect_4.doStartTag();
    if (_jspx_th_c_redirect_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_redirect_url_nobody.reuse(_jspx_th_c_redirect_4);
    return false;
  }

  private boolean _jspx_meth_c_redirect_5(PageContext _jspx_page_context)
          throws Throwable {
    PageContext pageContext = _jspx_page_context;
    JspWriter out = _jspx_page_context.getOut();
    //  c:redirect
    org.apache.taglibs.standard.tag.rt.core.RedirectTag _jspx_th_c_redirect_5 = (org.apache.taglibs.standard.tag.rt.core.RedirectTag) _jspx_tagPool_c_redirect_url_nobody.get(org.apache.taglibs.standard.tag.rt.core.RedirectTag.class);
    _jspx_th_c_redirect_5.setPageContext(_jspx_page_context);
    _jspx_th_c_redirect_5.setParent(null);
    _jspx_th_c_redirect_5.setUrl("/login.jsp");
    int _jspx_eval_c_redirect_5 = _jspx_th_c_redirect_5.doStartTag();
    if (_jspx_th_c_redirect_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      return true;
    _jspx_tagPool_c_redirect_url_nobody.reuse(_jspx_th_c_redirect_5);
    return false;
  }

  private class authenticate_jspHelper
      extends org.apache.jasper.runtime.JspFragmentHelper
  {
    private javax.servlet.jsp.tagext.JspTag _jspx_parent;
    private int[] _jspx_push_body_count;

    public authenticate_jspHelper( int discriminator, JspContext jspContext, javax.servlet.jsp.tagext.JspTag _jspx_parent, int[] _jspx_push_body_count ) {
      super( discriminator, jspContext, _jspx_parent );
      this._jspx_parent = _jspx_parent;
      this._jspx_push_body_count = _jspx_push_body_count;
    }
    public void invoke0( JspWriter out ) 
      throws Throwable
    {
      if (_jspx_meth_c_set_1(_jspx_parent, _jspx_page_context))
        return;
      if (_jspx_meth_c_set_2(_jspx_parent, _jspx_page_context))
        return;
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
