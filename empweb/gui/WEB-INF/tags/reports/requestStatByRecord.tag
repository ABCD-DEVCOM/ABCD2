<%--
/*
 * Copyright 2004-2005 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%><%@
tag import="java.util.Map" %><%@
tag import="java.util.HashMap" %><%@
tag import="java.lang.ref.*" %><%@
tag import="java.util.Random" %><%@
tag import="net.kalio.utils.collections.SortableMapOfMaps" %><%@
tag import="java.util.*,org.w3c.dom.*,org.apache.commons.jxpath.*,net.kalio.jsptags.jxp.*" %><%@
tag body-content="scriptless" %><%@
attribute name="name" required="true" %><%@
attribute name="fillUsersInfo" %><%@
attribute name="fillObjectsInfo"  %><%@
attribute name="sortBy"  %><%@
attribute name="order" %><%@
attribute name="from" %><%@
attribute name="qty" %><%@
attribute name="flushCache" %><%@
attribute name="var"  required="true" rtexprvalue="false" %><%@
attribute name="totalCount"  required="true" rtexprvalue="false" %><%@
attribute name="timestamp"  required="true" rtexprvalue="false" %><%@
attribute name="hash" required="false" %><%@
attribute name="cacheId" required="false" %><%@
attribute name="newCacheIdVar" required="false" %><%@
variable  name-from-attribute="var"  alias="sortedResult" scope="AT_END" %><%@
variable  name-from-attribute="totalCount"  alias="sortedResultCount" scope="AT_END" %><%@
variable  name-from-attribute="timestamp"  alias="searchTimestamp" scope="AT_END" %><%@
taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %><%@
taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %><%@
taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %><%@
taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %><%@
taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %><%@
taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp"
%><jsp:useBean id="nsm" class="java.util.HashMap" />
<c:set target="${nsm}" property="uinfo" value="http://kalio.net/empweb/schema/users/v1" />
<c:set target="${nsm}" property="ustat" value="http://kalio.net/empweb/schema/userstatus/v1" />
<c:set target="${nsm}" property="mods"  value="http://www.loc.gov/mods/v3" />
<c:set target="${nsm}" property="tr"    value="http://kalio.net/empweb/schema/transactionresult/v1" />
<c:set target="${nsm}" property="tl"    value="http://kalio.net/empweb/schema/transactionlist/v1" />


<c:set var="isCached" value="false"/>

<%
Object anAttr;              // Temporary object to retrieve an attribute from the context and simplify expressions.

// stores a Map of a weak reference to a sortable map of maps, using
// the search name as the key.
// Also a Map of timestamps is updated to be used from the page displaying the info, if desired.

JspContext jspContext = getJspContext();

SortableMapOfMaps thisSearch = null;
String flushCache    = (String)jspContext.getAttribute("flushCache");
String hashValue     = (String)jspContext.getAttribute("hash");
String cacheId       = (String)jspContext.getAttribute("cacheId");
String newCacheId    = null;
String newCacheIdVar = (String)jspContext.getAttribute("newCacheIdVar");
String searchName    = (String)jspContext.getAttribute("name");
HashMap searchMap    = (HashMap)session.getAttribute("searchMap");
HashMap searchMapTimestamps = (HashMap)session.getAttribute("searchMapTimestamps");
SoftReference<SortableMapOfMaps> thisSearchRef = null;



if ( !("true".equals(flushCache)) && (searchMap != null))
  {
    thisSearchRef = (SoftReference<SortableMapOfMaps>)searchMap.get(cacheId);
    if (thisSearchRef != null)
      {
        thisSearch = thisSearchRef.get();

        if (thisSearch != null)
          {
            jspContext.setAttribute("isCached", "true");
            newCacheId = cacheId;
          }
      }
  }
%>

<%-- if it is cached do not redo the search now --%>
<c:if test="${isCached eq 'false'}">

  <%-- generate a new cache id --%>
  <%
    Random randomGen = new Random(System.currentTimeMillis());
    String randomString = Integer.toHexString(randomGen.nextInt());
    newCacheId = randomString.toUpperCase();
  %>

  <x:parse varDom="statCount">
    <trans:doTransaction name="stat-${name}">
      <transactionExtras>
        <params>
          <jsp:doBody/>
        </params>
      </transactionExtras>
    </trans:doTransaction>
 </x:parse>

  <%-- now get only the complete transactions that we want --%>
  <%-- <c:set var="select" value="//tr:value[@name='${name}Ids']/tr:id" /> --%>
  <%-- BBBB what for??? <c:set var="selectIds" value="//tr:id" /> --%>

  <%-- create a new context called resultIds, starting at the parent element of the ids  --%>
  <jxp:set cnode="${statCount}" var="resultIds"     select="//tr:result/tr:values/tr:value[tr:id]" nsmap="${nsm}" />
  <jxp:set cnode="${resultIds}" var="resultsCount"  select="count(tr:id)"    nsmap="${nsm}"/>
  <x:parse varDom="doc">
      <trans:doTransaction name="stat-trans-by-ids">
        <transactionExtras>
          <params>
            <param name="transactionIds">
              <jxp:forEach cnode="${resultIds}" var="id" select="tr:id" nsmap="${nsm}" >${id},</jxp:forEach>
            </param>
          </params>
        </transactionExtras>
      </trans:doTransaction>
  </x:parse>
  <jxp:set cnode="${doc}" var="transactions" select="//tr:result" nsmap="${nsm}" />

  <%-- get all the users we want at once --%>
  <c:if test="${(not empty fillUsersInfo) and (fillUsersInfo eq 'true')}">
    <jsp:useBean id="uniqueUserIds" class="java.util.HashMap" />
    <jxp:forEach cnode="${transactions}" var="ptr" select="//*[local-name()='userId']" nsmap="${nsm}">
      <c:set target="${uniqueUserIds}" property="${ptr['.']}," value="${ptr['.']}," />
    </jxp:forEach>

    <x:parse varDom="usersInfo">
      <trans:searchUsersById database="*">
        <c:forEach items="${uniqueUserIds}" var="_uid">${_uid.value}</c:forEach>
      </trans:searchUsersById>
    </x:parse>
  </c:if>

  <%-- get all records we want at once --%>
  <c:if test="${(not empty fillObjectsInfo) and (fillObjectsInfo eq 'true')}">
    <jsp:useBean id="recordIds" class="java.util.HashMap" />
    <jxp:forEach cnode="${transactions}" var="ptr" select="//*[local-name()='recordId']" nsmap="${nsm}">
      <c:set target="${recordIds}" property="${ptr['.']}," value="${ptr['.']}," />
    </jxp:forEach>

    <x:parse varDom="objectsInfo">
      <trans:searchObjectsByRecordId database="*">
        <c:forEach items="${recordIds}" var="_cpid">${_cpid.value}</c:forEach>
      </trans:searchObjectsByRecordId>
    </x:parse>
  </c:if>


<%-- load everything in the sortable map of maps --%>
<%

Object transactions  = jspContext.findAttribute("transactions");
Object usersInfo     = jspContext.findAttribute("usersInfo");
Object objectsInfo   = jspContext.findAttribute("objectsInfo");

boolean fillUsersInfo=   (anAttr= jspContext.findAttribute("fillUsersInfo")) != null   ? "true".equals(anAttr) : false;
boolean fillObjectsInfo= (anAttr= jspContext.findAttribute("fillObjectsInfo")) != null ? "true".equals(anAttr) : false;


JXPathContext jxTransactions = null;
JXPathContext jxUsersInfo   = null;
JXPathContext jxObjectsInfo = null;

if (transactions instanceof PointerWrapper)
  jxTransactions = JXPathContext.newContext( ((PointerWrapper)transactions).getNode() );
else
  jxTransactions = JXPathContext.newContext( ((Node)transactions) );

jxTransactions.setLenient(true);
jxTransactions.registerNamespace("tr","http://kalio.net/empweb/schema/transactionresult/v1");
jxTransactions.registerNamespace("tl","http://kalio.net/empweb/schema/transactionlist/v1");


if (fillUsersInfo)
  {
    if (usersInfo instanceof PointerWrapper)
      jxUsersInfo = JXPathContext.newContext( ((PointerWrapper)usersInfo).getNode() );
    else
      jxUsersInfo = JXPathContext.newContext( ((Node)usersInfo) );

    jxUsersInfo.setLenient(true);
    jxUsersInfo.registerNamespace("uinfo", "http://kalio.net/empweb/schema/users/v1");
  }

if (fillObjectsInfo)
  {
    if (objectsInfo instanceof PointerWrapper)
      jxObjectsInfo = JXPathContext.newContext( ((PointerWrapper)objectsInfo).getNode() );
    else
      jxObjectsInfo = JXPathContext.newContext( ((Node)objectsInfo) );

    jxObjectsInfo.setLenient(true);
    jxObjectsInfo.registerNamespace("mods", "http://www.loc.gov/mods/v3");
    jxObjectsInfo.registerNamespace("h", "http://kalio.net/empweb/schema/holdingsinfo/v1");
  }


SortableMapOfMaps map= new SortableMapOfMaps();

// para cada transaccion
// cargo todos sus children de primer nivel en el hash
Iterator it = jxTransactions.iteratePointers("//tl:transactionList/*");
while(it.hasNext())
  {
    Pointer p = (Pointer)it.next();
    Node n= (Node)p.getNode();
    String transactionId=   n.getAttributes().getNamedItem("id").getNodeValue();
    String transactionType= n.getNodeName();

    HashMap hm = new HashMap();
    NodeList nl = n.getChildNodes();
    for(int i=0; i<nl.getLength(); i++)
      {
        Node child = nl.item(i);
        if (child.getNodeType() == Node.ELEMENT_NODE)
          {
            if ("object".equals((String)child.getNodeName()))
              {
                // tomar en cuenta que fine, suspension y reservation tienen un elemento llamado "object" con cosas adentro
                NodeList cnl = child.getChildNodes();
                for (int j=0; j<cnl.getLength(); j++)
                  {
                    Node grandchild = cnl.item(j);
                    if (grandchild.getNodeType() == Node.ELEMENT_NODE)
                      {
                        hm.put(grandchild.getNodeName(), grandchild.getTextContent());
                      }
                  }
              }
            else if("paid".equals((String)child.getNodeName()))
              {
                // en el caso de un fine, existe un elemento "paid" que a su vez incluye amount y date
                NodeList cnl = child.getChildNodes();
                for (int j=0; j<cnl.getLength(); j++)
                  {
                    Node grandchild = cnl.item(j);
                    if (grandchild.getNodeType() == Node.ELEMENT_NODE)
                      {
                        // prefijo el nombre del elemento con "paid" para poder diferenciarlo de otros elementos 'mas afuera'
                        // ademas, por consistencia, dejo la concatenacion en camelCase
                        hm.put("paid" + grandchild.getNodeName().substring(0,1).toUpperCase()
                                      + grandchild.getNodeName().substring(1), grandchild.getTextContent());
                      }
                  }
              }
            else
              {
                hm.put(child.getNodeName(), child.getTextContent());
              }
          }
      }

    // si tiene recordId y me pidieron que llene los records, meto en hash nombre, autor y recordId
    if (fillObjectsInfo)
      {
        String recordId = (String)hm.get("recordId");
        String copyId   = (String)hm.get("copyId");
        if ( (recordId != null) && (recordId.length() > 0) )
          {
            hm.put("recordTitle", (String)jxObjectsInfo.getValue("//mods:mods[mods:recordInfo/mods:recordIdentifier=" + "'"+recordId+"'" +"]/mods:titleInfo/mods:title"));
          }
        // TODO: en el if de aca abajo hay algo que lleva 150ms... investigar!
        // if ( (copyId != null) && (copyId.length() > 0) )
        //   {
        //     hm.put("copyLocation", (String)jxObjectsInfo.getValue("//h:copy[h:copyId='"+copyId+"']/h:copyLocation"));
        //   }
      }

    // si tiene userId y me pidieron que llene userInfo, traigo el nombre
    if (fillUsersInfo)
      {
        String userId = (String)hm.get("userId");
        if ( (userId != null) && (userId.length() > 0) )
          {
            hm.put("userName", (String)jxUsersInfo.getValue("//uinfo:user[uinfo:id='" + userId +"']/uinfo:name"));
          }
      }

    // put the information in a sortableMapOfMaps
    hm.put("transactionId", transactionId);
    map.put(transactionId, hm);
  }

thisSearch = map;

// store it in the session, as a soft reference
thisSearchRef = new SoftReference<SortableMapOfMaps>(thisSearch);
if (searchMap == null)
  searchMap = new HashMap();
searchMap.put(newCacheId, thisSearchRef);
session.setAttribute(newCacheIdVar,newCacheId);
session.setAttribute("searchMap", searchMap);

// store the timestamps
if (searchMapTimestamps == null)
  searchMapTimestamps = new HashMap();
searchMapTimestamps.put(newCacheId, new Date());
session.setAttribute("searchMapTimestamps", searchMapTimestamps);

%>
</c:if>


<%
String sortBy=  ((anAttr= jspContext.findAttribute("sortBy")) != null) && (((String)anAttr).length() > 0) ? (String)anAttr : "transactionId";
String order=   ((anAttr= jspContext.findAttribute("order"))  != null) && (((String)anAttr).length() > 0) ? (String)anAttr : "ascending";
int upOrDown=   "ascending".equalsIgnoreCase(order) ? 1 : -1;

ArrayList sortedData = thisSearch.getArrayListBy(sortBy, upOrDown);
jspContext.setAttribute("sortedResultCount", sortedData.size());

// do we want a sublist?
int from = -1;
int to = -1;
String fromS = (String)jspContext.getAttribute("from");
String qtyS  = (String)jspContext.getAttribute("qty");

if ((fromS != null) && (fromS.length() > 0) &&
    (qtyS != null)  && (qtyS.length() > 0 ))
  {
    from = Integer.parseInt(fromS);
    to   = from + Integer.parseInt(qtyS);
  }
if (to > sortedData.size())
  to = sortedData.size()-1;


if ( (from <= to) && (from >= 0))
  {
    jspContext.setAttribute("sortedResult", sortedData.subList(from,to+1));
  }
else
  {
    jspContext.setAttribute("sortedResult", sortedData);
  }


if (searchMapTimestamps != null)
  {
    jspContext.setAttribute("searchTimestamp", (Date)searchMapTimestamps.get(newCacheId));
  }
%>
