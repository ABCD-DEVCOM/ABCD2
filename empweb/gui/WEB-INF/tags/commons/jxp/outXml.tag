<%@ tag import="java.util.*,
                java.io.*,
                javax.xml.parsers.*,
                org.w3c.dom.*,
                org.apache.commons.jxpath.*,
                net.kalio.xml.KalioXMLUtil,
                net.kalio.jsptags.jxp.*" %><%@ tag body-content="empty" %><%@
    attribute name="cnode"  required="true"   type="java.lang.Object" %><%@
    attribute name="nsmap"  required="false"  type="java.util.Map" %><%@
    attribute name="select" required="true"  %><%@
    attribute name="pretty" required="false"  type="java.lang.Boolean" %><%--
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

Example:  BBB Show an example

--%><%
String select= (String)jspContext.findAttribute("select");
Object elCNode= jspContext.findAttribute("cnode");
Boolean doPretty= (Boolean)jspContext.findAttribute("pretty");
if ( doPretty == null )
  doPretty= new Boolean(false);


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

Pointer pt = ct.getPointer(select);
if (pt != null)
  { out.write( KalioXMLUtil.elementToString((Element)pt.getNode(), doPretty.booleanValue()) );
  }
%>