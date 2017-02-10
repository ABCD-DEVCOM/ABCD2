<%@ tag body-content="empty" %>
<%@ attribute name="direction" required="true" %>
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
  String direction = (String)jspContext.getAttribute("direction");
  String processName = (String)jspContext.getAttribute("processName");
  String pipeName = (String)jspContext.getAttribute("pipelineName");

  Document pipeDom = (Document)jspContext.getAttribute("pipe");
  JXPathContext jx = JXPathContext.newContext(pipeDom);
  jx.setLenient(true);
  jx.registerNamespace("t", "http://kalio.net/empweb/schema/transaction/v1");
  jx.registerNamespace("soapenv", "http://schemas.xmlsoap.org/soap/envelope/");
  jx.setFactory( KalioXMLUtil.newJXPathAbstractFactory() );

  // verificar que exista alguno con ese nombre
  Node procExists = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+processName+"']")).getNode();
  if (procExists == null) {
  %>
    <error xmlns="http://kalio.net/empweb/schema/engineresult/v1">
      <msg>
        <key bundle="core.gui">error_orderprocess_name_not_exist</key>
        <params>
          <param>${processName}</param>
        </params>
      </msg>
    </error>
  <%
  } else {

    List procNames = new ArrayList(10);

    // cargo una lista  con los nombres
    Iterator it = jx.iteratePointers("//t:transaction/t:process/@name|//t:transaction/t:rule/@name|//t:transaction/t:finally/@name");
    while(it.hasNext()) {
        Pointer elPoint = (Pointer)it.next();
        String elementName = (String)elPoint.getValue();
        procNames.add(elementName);
    }

    int origPos = procNames.indexOf(processName);
    int offset = ("up".equals(direction)) ? -1 : 1;

    if ((offset > 0) || (offset < procNames.size())) {
      String destName = (String)procNames.get(origPos+offset);

      // 1) get source node
      // 2) get destination node
      // 3) clone source node
      Node origNode = (Node)(jx.getPointer("//t:transaction/*[@name='"+processName+"']")).getNode();
      Node destNode = (Node)(jx.getPointer("//t:transaction/*[@name='"+destName+"']")).getNode();
      Node parNode = origNode.getParentNode();
      Node origCloneNode = origNode.cloneNode(true);

      // replace origenclon -> destino
      // replace destino -> origen
      Node destReplacedNode = parNode.replaceChild(origCloneNode, destNode);
      parNode.replaceChild(destReplacedNode, origNode);
    }

    // cleanup namespaces
    // pipeDom = KalioXMLUtil.cleanupPrefixes(pipeDom.getDocumentElement()).getOwnerDocument();

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
  } // else
} catch (Exception e) { %>

  <error xmlns="http://kalio.net/empweb/schema/engineresult/v1">
    <msg>
      <key bundle="core.gui">error_processing_orderprocess</key>
      <params>
        <param><%=e.toString()%></param>
      </params>
    </msg>
  </error>
<%
} // catch
%>