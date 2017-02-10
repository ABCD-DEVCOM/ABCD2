<%@ tag import="java.util.*,
                org.w3c.dom.*,
                org.apache.commons.jxpath.*,
                net.kalio.jsptags.jxp.*"
%><%@ tag body-content="empty"
%><%@ attribute name="cnode" required="true" type="java.lang.Object"
%><%@ attribute name="nsmap" required="false" type="java.util.Map"
%><%@ attribute name="select" required="true" type="java.lang.String"
%><%--

/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%><%--

Usage:

Attribute cnode is the context node.  (required)
          It must be a DOM object (Document or Element) or a pointer object generated
          by a jxp tag through the "var" attribute and an xpath selection that returns a nodeset (i.e., not
          a count() which returns a Double, or an xpath function that returns a String)

Attribute nsmap is a Map of prefix/namespaceURI pairs. (optional)
Attribute select is an xpath expression relative to the context node.

Example:

Assume we have a DOM object in the context variable "mydoc".
This could have been obtained by using <x:parse> from the JSTL as shown below.

<!-- Parse XML and store it into mydoc -->
<x:parse varDom="mydoc">
  <rr:root xmlns:rr="urn:mynamespace">
    <rr:elem a="123">
      <text>child number 1</text>
      <rr:color>red</rr:color>
    </rr:elem>
    <rr:elem a="456">
      <texto>child number 2</texto>
      <rr:color>blue</rr:color>
    </rr:elem>
  </rr:root>
</x:parse>

<!-- Define a mapping for namespace prefixes -->
<jsp:useBean id="nsm" class="java.util.HashMap"  />
<c:set target="${nsm}"  property="www"      value="urn:mynamespace"/>


<!-- Output the value of the selected node -->
<jxp:out cnode="${mydoc}"
         select="/www:root/www:elem"
         nsmap="${nsm} />


For more information read the usage of jxp:forEeach

--%><%

String select= (String)jspContext.findAttribute("select");
Object elCNode= jspContext.findAttribute("cnode");

// The attribute cnode may be a DOM object or a PointerWrapper
if (elCNode instanceof PointerWrapper)
  { elCNode= ((PointerWrapper)elCNode).getNode();
  }

JXPathContext ct= JXPathContext.newContext(elCNode);
ct.setLenient(true);

Map nsmap= (Map)jspContext.findAttribute("nsmap");
if (nsmap != null)
  { Set es= nsmap.entrySet();
    Iterator esit= es.iterator();
    while (esit.hasNext())
      { Map.Entry men= (Map.Entry)esit.next();
        ct.registerNamespace((String)men.getKey(), (String)men.getValue());
      }
  }

Object value = ct.getValue(select);
if (value != null) {
%><%=value.toString()
%><%
}%>