<%@ tag body-content="empty" %>
<%@ attribute name="name" required="true" %>
<%@ tag import="org.w3c.dom.*" %>
<%@ tag import="org.apache.commons.jxpath.*" %>
<%@ tag import="java.util.*" %>
<%@ tag import="net.kalio.xml.KalioXMLUtil" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>

<%
    try {
%>

<io:soap url="${config['ewengine.admin_service']}" SOAPAction="" encoding="UTF-8">

  <x:parse varDom="pipe">
    <admin:getPipeline name="${name}"/>
  </x:parse>

  <jsp:useBean id="nsm" class="java.util.HashMap" />
  <c:set target="${nsm}" property="t" value="http://kalio.net/empweb/schema/transaction/v1" />

  <%-- set new environment parameters --%>
  <c:if test="${not empty fn:trim(param.environment_xml)}">
    <x:parse varDom="env">${fn:trim(param.environment_xml)}</x:parse>
  </c:if>

  <%
// add environment
String pipeName = (String)jspContext.getAttribute("name");
Document pipeDom = (Document)jspContext.getAttribute("pipe");
JXPathContext jx = JXPathContext.newContext(pipeDom);
jx.setLenient(true);
jx.registerNamespace("t", "http://kalio.net/empweb/schema/transaction/v1");
Node transNode = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']")).getNode();
Node oldEnv = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/t:environment")).getNode();

Document envDom = (Document)jspContext.getAttribute("env");
if (envDom != null) {
    Element envElement = envDom.getDocumentElement();
    Node newEnv = pipeDom.importNode(envElement,true);

    if (oldEnv != null) {
        oldEnv.getParentNode().replaceChild(newEnv, oldEnv);
    } else {
        // env node shall be the first child.
        if (transNode.getFirstChild() != null) {
            transNode.insertBefore(newEnv, transNode.getFirstChild());
        } else {
            transNode.appendChild(newEnv);
        }
    }
} else {
    // if envDom is empty, remove oldEnv if it exists.
    if (oldEnv != null) {
        oldEnv.getParentNode().removeChild(oldEnv);
    }
}

// enable/disable process and rules
HashMap enabledMap = new HashMap();
for (Iterator e = request.getParameterMap().keySet().iterator(); e.hasNext() ; ) {
  String thisKey = (String) e.next();
  if ( thisKey.startsWith("enabled_") ) {
      enabledMap.put(thisKey.substring(8), "true");
  }
}


Iterator it = jx.iteratePointers("//t:transaction/t:process | //t:transaction/t:rule | //t:transaction/t:finally"); //pipeName+"']/t:*/@name");
while(it.hasNext()) {
    Pointer elPoint=        (Pointer)it.next();
    JXPathContext procCtx=  jx.getRelativeContext(elPoint);
    String procName=        (String)procCtx.getValue("@name");
    String elementName=     (String)procCtx.getValue("name()");

    if ( enabledMap.get(procName) != null ) {
        jx.removePath("//t:transaction/t:"+elementName+"[@name='"+procName+"']/@enabled");
    } else {
        jx.createPathAndSetValue("//t:transaction/t:"+elementName+"[@name='"+procName+"']/@enabled", "false");
    }
}


// cleanup namespaces
// pipeDom = KalioXMLUtil.cleanupPrefixes(pipeDom.getDocumentElement()).getOwnerDocument();

// publish to the world!
jspContext.setAttribute("pipe", pipeDom);

%>
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
      xmlns:xsd="http://www.w3.org/2001/XMLSchema"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
      <soapenv:Body>
        <savePipeline xmlns="http://kalio.net/empweb/engine/admin/v1" >
          <pipelineParam>
<jxp:outXml cnode="${pipe}" nsmap="${nsm}" select="//t:transaction" />
          </pipelineParam>
        </savePipeline>
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>
<%

    } catch (Exception e) {

      e.printStackTrace();
%>
<error xmlns="http://kalio.net/empweb/schema/engineresult/v1">
  <msg>
    <key bundle="core.gui">error_processing_savepipeline</key>
    <params>
      <param><%=e.toString()%></param>
    </params>
  </msg>
</error>
<% } %>
