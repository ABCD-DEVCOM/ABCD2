<%@ tag import="java.util.*,org.w3c.dom.*,org.apache.commons.jxpath.*,net.kalio.jsptags.jxp.*" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ attribute name="cnode"  required="true"   type="java.lang.Object" %><%@
    attribute name="nsmap"  required="false"  type="java.util.Map" %><%@
    attribute name="select" required="true"  %><%@
    attribute name="sortby" required="false" %><%@
    attribute name="sortorder" required="false" %><%@

    attribute name="var" required="true" rtexprvalue="false" %><%@
    variable  name-from-attribute="var"  alias="punt" scope="NESTED" %><%@

    attribute name="from" required="false" type="java.lang.Integer" %><%@
    attribute name="to"   required="false" type="java.lang.Integer" %><%@
    variable  name-given="_jxpItem" variable-class="java.lang.Integer" scope="NESTED" %><%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%><%--  Usage:

Attribute cnode is the context node.  (required) It must be a DOM
          object (Document or Element) or a pointer object generated
          by a jxp tag through the "var" attribute and an xpath
          selection that returns a nodeset (i.e., not a count() which
          returns a Double, or an xpath function that returns a
          String)

Attribute nsmap is a Map of prefix/namespaceURI pairs. (optional)

Attribute select is an xpath expression relative to the context node.

Attribute var is the name of an exported variable that points to the
          current selection.  Using the JSP EL [] operator, it can
          further evaluate another xpath relative to this pointer.

Optional attributes "from" and "to" will output only in the indicated
range. The first item is number "1", as the XPath specification
states. Attribute "from" defaults to "1", and attribute "to" defaults
to Integer.MAX_VALUE

Optional attribute "sortby" is an xpath relative to the nodes returned
by "select". The first character of "sortby" may be '+' or '-' for
sorting the selected nodes in ascending or descending order. If
sorting direction is absent, ascending is assumed.

Optional attribute "sortorder" specifies the sort direction. Valid
values are '+' or 'ascending', and '-' or 'descending'. It overrides
the order specified as the first charactier in attribute "sortby". If
sorting direction is absent, ascending is assumed.

The tag exports a nested body variable called "_jxpItem" which has the
current counter.  from <= _jxpItem <= to

Example:

Assume we have a DOM object in the context variable "mydoc".  This
could have been obtained by using <x:parse> from the JSTL as shown
below.

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


<!-- Iterate using jxp:forEach
<jxp:forEach cnode="${mydoc}"
             var="ptr"
             select="/www:root/www:elem"
             nsmap="${nsm}>

   We will do two iterations.

   ${ptr} is the text contents, for example: "child number 1red"
   ${ptr["@a"]} returns "123" and "456"
   ${ptr["texto"]} returns "child number 1" on the first iteration and "child number 2" on the second one
   ${ptr['*[1]']} same as above
   ${ptr["www:color[../@a='456']"]} returns "blue" on the second iteration, empty on the first one
</jxp:forEach>


Attention: In a JSP page single and double quotes can be nested in multiple levels.
In a JSP Document, you can nest one within the other, but after that you must use
XML entities: &quot; and &apos;

This is especially important in attributes:

<eee att="${ptr['www:color[../@a=&quot;456&quot;]']}" />


Finally, to simplify expressions, <jxp:forEach> can be nested, using the pointer
as a cnode.
   <jxp:forEach cnode="${ptr}  .........>
or
   <jxp:forEach cnode="${ptr["some_xpath"]}  .........>

A new, nested, iteration will be generated using the new context node.
--%>
<%
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


  // Calculate from-to range
  Integer fromInt= (Integer)jspContext.findAttribute("from");
  Integer toInt=   (Integer)jspContext.findAttribute("to");

  int from, to;

  from= (fromInt == null || fromInt.intValue() < 1) ? 1 : fromInt.intValue();

  if (toInt == null)
    to= Integer.MAX_VALUE;
  else if (toInt.intValue() < 0)
    to= 0;
  else
    to= toInt.intValue();


  Iterator it= ct.iteratePointers(select);                    // Obtain JXPath Pointers

  // Build an ArrayList of PointerWrappers, only with the elements in the from-to range
  ArrayList pwList= new ArrayList(20);
  for (int i= 1; it.hasNext() && i <= to; i++)
    { Pointer p= (Pointer)it.next();
      if (i < from)                                           // skip the first few
        continue;

      PointerWrapper pw= new PointerWrapper();
      pw.setJXPathContext(ct);
      pw.setPointer(p);
      pwList.add(pw);
    }

  // If sortby requested, sort the PointerWrappers
  String sortby= (String)jspContext.findAttribute("sortby");
  String sortorder= (String)jspContext.findAttribute("sortorder");
  if (sortby != null && sortby.trim().length() > 0)
    { char firstChar= sortby.charAt(0);
      final boolean ascending;
      if (sortorder != null && sortorder.trim().length() > 0)
        ascending = ("-".equals(sortorder) || "descending".equals(sortorder)) ? false : true;
      else
        ascending = (firstChar == '-') ? false : true;   // '+' or other char means ascending
      final String finalSortby;
      if (firstChar == '+' || firstChar == '-')                     // if sorting order was specified...
        finalSortby= sortby.substring(1);                           // ...keep the rest of the string
      else
        finalSortby= sortby;

      java.util.Collections.sort(pwList,
        new Comparator()
          { public int compare(Object o1, Object o2)
            { PointerWrapper pw1= (PointerWrapper)o1;
              PointerWrapper pw2= (PointerWrapper)o2;

              // Obtain PointerWrappers to the sortby node
              PointerWrapper sortPw1= (PointerWrapper)pw1.get(finalSortby);
              PointerWrapper sortPw2= (PointerWrapper)pw2.get(finalSortby);

              // PointerWrapper does a String compareTo of the String contents
              int comp;
              if (sortPw1 != null)
                comp= sortPw1.compareTo(sortPw2);
              else if (sortPw2 == null)                             // if both are null
                comp= 0;
              else                                                  // 1 is null, 2 is not null =>  1 < 2
                comp= -1;

              return ( ascending ? comp : (comp * -1) );
            }
          }
      );
    } // if sortby


  // Iteration loop
  int size= pwList.size();
  for (int i= 0; i < size; i++)
    { PointerWrapper pw= (PointerWrapper)pwList.get(i);
      jspContext.setAttribute("_jxpItem", new Integer(i+from));
      jspContext.setAttribute("punt", pw);
%><jsp:doBody/><%
    }
%>
