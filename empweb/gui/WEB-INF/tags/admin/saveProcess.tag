<%@ tag body-content="empty" %>
<%@ attribute name="processName" required="true" %>
<%@ attribute name="pipelineName" required="true" %>
<%@ tag import="org.w3c.dom.*" %>
<%@ tag import="org.apache.commons.jxpath.*" %>
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
<io:soap url="${config['ewengine.admin_service']}" SOAPAction="" encoding="UTF-8">

  <x:parse varDom="pipe">
    <admin:getPipeline name="${pipelineName}"/>
  </x:parse>

  <jsp:useBean id="nsm" class="java.util.HashMap" />
  <c:set target="${nsm}" property="t" value="http://kalio.net/empweb/schema/transaction/v1" />

  <%-- set new doc --%>
  <c:if test="${not empty fn:trim(param.doc_xml)}">
    <x:parse varDom="doc">${fn:trim(param.doc_xml)}</x:parse>
  </c:if>

  <%-- set new limits --%>
  <c:if test="${not empty fn:trim(param.limits_xml)}">
    <x:parse varDom="limits">${fn:trim(param.limits_xml)}</x:parse>
  </c:if>

  <%-- set new parameters --%>
  <c:if test="${not empty fn:trim(param.params_xml)}">
    <x:parse varDom="params">${fn:trim(param.params_xml)}</x:parse>
  </c:if>

  <%
String procName = (String)jspContext.getAttribute("processName");
String pipeName = (String)jspContext.getAttribute("pipelineName");
Document pipeDom = (Document)jspContext.getAttribute("pipe");
JXPathContext jx = JXPathContext.newContext(pipeDom);
jx.setLenient(true);
jx.registerNamespace("t", "http://kalio.net/empweb/schema/transaction/v1");
Node procNode = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']")).getNode();
Node oldDoc = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']/t:doc")).getNode();
Node oldLim = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']/t:limits")).getNode();
Node oldPar = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']/t:params")).getNode();

// replace doc
Document docDom = (Document)jspContext.getAttribute("doc");
if (docDom != null) {
    Element docElement = docDom.getDocumentElement();
    Node newDoc = pipeDom.importNode(docElement,true);

    if (oldDoc != null) {
	oldDoc.getParentNode().replaceChild(newDoc, oldDoc);
    } else {
	// doc node shall be the first child after the enter (text ndode)
        if (procNode.getFirstChild() != null) {
            Node insertPos = procNode.getFirstChild();
            if (insertPos.getNodeType() == Node.TEXT_NODE)
                insertPos = insertPos.getNextSibling();
            if  (insertPos.getNodeType() == Node.COMMENT_NODE)
                insertPos = insertPos.getNextSibling();
            procNode.insertBefore(newDoc, insertPos);
        } else {
            procNode.appendChild(newDoc);
        }
    }
} else {
    // docDom is empty, but oldDoc exists, so remove oldDoc
    if (oldDoc != null) {
	procNode.removeChild(oldDoc);
    }
}

// replace limits
Document limDom = (Document)jspContext.getAttribute("limits");
if (limDom != null) {
    Element limElement = limDom.getDocumentElement();
    Node newLim = pipeDom.importNode(limElement,true);

    if (oldLim != null) {
        oldLim.getParentNode().replaceChild(newLim, oldLim);
    } else {
        Node theDoc = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']/t:doc")).getNode();
        if (theDoc != null)
            procNode.insertBefore(newLim, theDoc.getNextSibling());
        else if (procNode.getFirstChild() != null) {
            Node insertPos = procNode.getFirstChild();
            if (insertPos.getNodeType() == Node.TEXT_NODE)
                insertPos = insertPos.getNextSibling();
            if  (insertPos.getNodeType() == Node.COMMENT_NODE)
                insertPos = insertPos.getNextSibling();
            procNode.insertBefore(newLim, insertPos);
        } else {
            procNode.appendChild(newLim);
        }
    }
} else {
    // limDom is empty, but oldLim exists, so remove oldLim
    if (oldLim != null) {
        procNode.removeChild(oldLim);
    }
}

// replace params
Document parDom = (Document)jspContext.getAttribute("params");
if (parDom != null) {
    Element parElement = parDom.getDocumentElement();
    Node newPar = pipeDom.importNode(parElement,true);

    if (oldPar != null) {
        oldPar.getParentNode().replaceChild(newPar, oldPar);
    } else {
        // par node shall be the third
        Node theDoc = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']/t:doc")).getNode();
        Node lims = (Node)(jx.getPointer("//t:transaction[@name='"+pipeName+"']/*[@name='"+procName+"']/t:limits")).getNode();
        if (lims != null)
            procNode.insertBefore(newPar, lims.getNextSibling());
        else if (theDoc != null)
            procNode.insertBefore(newPar, theDoc.getNextSibling());
        else if (procNode.getFirstChild() != null) {
            Node insertPos = procNode.getFirstChild();
            if (insertPos.getNodeType() == Node.TEXT_NODE)
                insertPos = insertPos.getNextSibling();
            if  (insertPos.getNodeType() == Node.COMMENT_NODE)
                insertPos = insertPos.getNextSibling();
            procNode.insertBefore(newPar, insertPos);
        } else {
            procNode.appendChild(newPar);
        }
    }
} else {
    // parDom is empty, but oldPar exists, so remove oldPar
    if (oldPar != null) {
        procNode.removeChild(oldPar);
    }
}

// cleanup namespaces  TODO: BBB Esto??
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
} catch (Exception e) { %>
<error xmlns="http://kalio.net/empweb/schema/engineresult/v1">
  <msg>
    <key bundle="core.gui">error_processing_saveprocess</key>
    <params>
      <param><%=e.toString()%></param>
    </params>
  </msg>
</error>
<% } %>
