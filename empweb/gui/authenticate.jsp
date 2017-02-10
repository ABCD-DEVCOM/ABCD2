<%@ page contentType="text/html; charset=UTF-8" %>
<%@ page import="java.util.Locale" %>
<%@ page import="java.util.HashMap" %>
<%@ page import="java.util.TreeSet" %>
<%@ page import="java.util.Iterator" %>
<%@ page import="java.util.ArrayList" %>
<%@ page import="java.util.Enumeration" %>
<%@ page import="java.util.Calendar" %>
<%@ page import="java.util.GregorianCalendar" %>
<%@ page import="net.kalio.auth.*" %>
<%@ page import="net.kalio.utils.*" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="jxp"   tagdir="/WEB-INF/tags/commons/jxp" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="kfn"   uri="http://kalio.net/jsp/el-func-1.0" %>

<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%>


<fmt:setLocale value="${sessionScope.userLocale}"/>
<fmt:setBundle basename="ewi18n.core.gui" scope="request"/>

<c:if test="${empty param.user || empty param.password}">

  <c:redirect url="login.jsp">
    <c:param name="errorMsg">error_enter_valid_user_pass</c:param>
  </c:redirect>
</c:if>

<%-- get Libraries and IPs from Engine --%>
<x:parse varDom="libraries">
   <trans:doTransaction name="conf-getLibraries"/>
</x:parse>
<jsp:useBean id="nsml" class="java.util.HashMap" />
<c:set target="${nsml}" property="tr" value="http://kalio.net/empweb/schema/transactionresult/v1" />

<%-- store the library id/ip here --%>
<jsp:useBean id="librariesIpMap" class="java.util.HashMap"/>
<jsp:useBean id="librariesHoursMap" class="java.util.HashMap"/>
<jxp:forEach cnode="${libraries}" var="libr" select="//tr:library" nsmap="${nsml}">
   <c:set target="${librariesIpMap}" property="${fn:trim(libr['@id'])}" value="${fn:trim(libr['tr:ipMask'])}"/>
   <c:set target="${librariesHoursMap}" property="${fn:trim(libr['@id'])}" value="${fn:trim(libr['tr:hours'])}"/>
</jxp:forEach>


<%
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
%>
    <c:choose>
      <c:when test="${!empty param.origURL}">
        <c:redirect url="${param.origURL}"/>
      </c:when>
      <c:otherwise>
        <c:redirect url="/home/index.jsp" />
      </c:otherwise>
    </c:choose>
<%
} else if (libsWithAccess.length() > 0) {
  
  session.setAttribute("prevlogin",userid); // default result
  session.setAttribute("prevpass",password); // default result
  
%>
    <c:redirect url="/login.jsp?errorMsg=${errorMsg}&libraries=${libsWithAccess}&user=${param.user}&origURL=${kfn:urlenc(param.origURL)}" />
<%
} else if (errorMsg != null) {
%>
    <c:redirect url="/login.jsp?errorMsg=${errorMsg}" />
<%
} else {
%>
    <c:redirect url="/login.jsp" />
<% } %>


<%! // Helper functions

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

%>
