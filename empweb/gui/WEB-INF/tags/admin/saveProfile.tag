<%--
  /*
  * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
  * All Rights Reserved
  *
  */
--%>

<%@tag import="java.util.*"%>
<%@taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml"%>
<%@taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0"%>
<%@taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
<%@taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>

<%@tag body-content="scriptless"%>

<jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="pr" value="http://kalio.net/empweb/schema/profile/v1" />

<%-- Get the current profile status before saving the new version --%>
<x:parse varDom="getProfileDoc">
  <admin:getProfile id="${param.profile_id}"/>
</x:parse>

<%-- Define a relative JXP Pointer pointing to the profile context, for convenience --%>
<jxp:set cnode="${getProfileDoc}" var="profPtr" nsmap="${nsm}" select='//pr:profile'/>

<%-- If it's a new profile, the policy id will come from a request parameter --%>
<c:set var="policyId" value="${ empty profPtr['pr:policy'] ? param.policy_id : profPtr['pr:policy']}" />

<jsp:useBean id="xmlSend" class="java.lang.String" scope="request"/>
<%
  for (Iterator e = request.getParameterMap().keySet().iterator(); e.hasNext(); )
    {
      String thisKey = (String) e.next();

      // IMPORTANT: HTTP parameters for the limits must start with limit_ followed by the name of the limit
      if (thisKey.startsWith("limit_"))
        { // BBBBB @todo if the parameter is empty, don't store it!!!
          String limitName = thisKey.substring(6);
          String limitVal = ((String[]) request.getParameterMap().get(thisKey))[0];
          xmlSend = xmlSend
              + "    <limit name='"+limitName+"'>\n"
              + "       <value>"+limitVal.trim()+"</value>\n"
              + "     </limit>\n";
        }
    }
  // put back the value of the string to the attribute bean xmlSend
  request.setAttribute("xmlSend", xmlSend);
%>
<io:soap url="${config['ewengine.admin_service']}" SOAPAction="" encoding="UTF-8">
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
      <soapenv:Body>
        <saveProfile xmlns="http://kalio.net/empweb/engine/admin/v1">
          <profileParam>
            <profile id="${param.profile_id}" xmlns="http://kalio.net/empweb/schema/profile/v1">
              <userClass>${param.user_class}</userClass>
              <objectCategory>${param.object_category}</objectCategory>
              <policy>${policyId}</policy>
              <limits>${xmlSend}</limits>
            </profile>
          </profileParam>
        </saveProfile>
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>
