<%@ tag body-content="empty" %>
<%@ attribute name="processType" required="true" %>
<%@ attribute name="processName" required="true" %>
<%@ attribute name="processClass" required="true" %>
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

String procName = (String)jspContext.getAttribute("processName");
String procClass = (String)jspContext.getAttribute("processClass");
String procType = (String)jspContext.getAttribute("processType");
String pipeName = (String)jspContext.getAttribute("pipelineName");

Document pipeDom = (Document)jspContext.getAttribute("pipe");
JXPathContext jx = JXPathContext.newContext(pipeDom);
jx.setLenient(true);
jx.registerNamespace("t", "http://kalio.net/empweb/schema/transaction/v1");
jx.registerNamespace("soapenv", "http://schemas.xmlsoap.org/soap/envelope/");
jx.setFactory( KalioXMLUtil.newJXPathAbstractFactory() );

// verificar que no exista ninguno con ese nombre
Node procExists = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']")).getNode();
if (procExists != null) {
%>
<error xmlns="http://kalio.net/empweb/schema/engineresult/v1">
  <msg>
    <key bundle="core.gui">error_newprocess_name_exists</key>
    <params>
      <param>${processName}</param>
    </params>
  </msg>
</error>

<%
} else {

// insertar al final
int insertPos = 1 + ((Double)jx.getValue("count(//t:transaction/t:"+processType+"/@name)")).intValue();
jx.createPathAndSetValue("//t:transaction/t:"+processType+"["+insertPos+"]/@name",processName);
jx.createPathAndSetValue("//t:transaction/t:"+processType+"["+insertPos+"]/@class",processClass);
jx.createPathAndSetValue("//t:transaction/t:"+processType+"["+insertPos+"]/@enabled","false");

// cleanup namespaces
pipeDom = KalioXMLUtil.cleanupPrefixes(pipeDom.getDocumentElement()).getOwnerDocument();

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
    <key bundle="core.gui">error_processing_newprocess</key>
    <params>
      <param><%=e.toString()%></param>
    </params>
  </msg>
</error>
<% } %>

