<%@ tag body-content="empty" %>
<%@ attribute name="processType" required="true" %>
<%@ attribute name="processName" required="true" %>
<%@ attribute name="pipelineName" required="true" %>
<%@ tag import="org.w3c.dom.*" %>
<%@ tag import="org.apache.commons.jxpath.*" %>
<%@ tag import="java.util.*" %>
<%@ tag import="java.util.*" %>
<%@ tag import="net.kalio.xml.KalioXMLUtil" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="admin" tagdir="/WEB-INF/tags/admin" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>


<%
    try {
%>


  <x:parse varDom="pipe">
    <admin:getPipeline name="${pipelineName}"/>
  </x:parse>

  <jsp:useBean id="nsm" class="java.util.HashMap" />
  <c:set target="${nsm}" property="t" value="http://kalio.net/empweb/schema/transaction/v1" />


  <%

String processName = (String)jspContext.getAttribute("processName");
String processType = (String)jspContext.getAttribute("processType");
String pipeName = (String)jspContext.getAttribute("pipelineName");

Document pipeDom = (Document)jspContext.getAttribute("pipe");
JXPathContext jx = JXPathContext.newContext(pipeDom);
jx.setLenient(true);
jx.registerNamespace("t", "http://kalio.net/empweb/schema/transaction/v1");
jx.registerNamespace("soapenv", "http://schemas.xmlsoap.org/soap/envelope/");

// verificar que existe con ese nombre
Node procExists = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/t:"+processType+"[@name='"+processName+"']")).getNode();
if (procExists == null) {
%>
<error xmlns="http://kalio.net/empweb/schema/engineresult/v1">
  <msg>
    <key bundle="core.gui">error_deleteprocess_name_not_exists</key>
    <params>
      <param>${processName}</param>
      <param>${pipeName}</param>
    </params>
  </msg>
</error>

<%
} else {

// borrar
jx.removePath("//t:transaction[@name='"+pipeName+"']/t:"+processType+"[@name='"+processName+"']");

// publish to the world!
jspContext.setAttribute("pipe", pipeDom);

%>
<io:soap url="${config['ewengine.admin_service']}" SOAPAction="" encoding="UTF-8">
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
} } catch (Exception e) { %>
<error xmlns="http://kalio.net/empweb/schema/engineresult/v1">
  <msg>
    <key bundle="core.gui">error_processing_deleteprocess</key>
    <params>
      <param><%=e.toString()%></param>
    </params>
  </msg>
</error>
<% } %>


