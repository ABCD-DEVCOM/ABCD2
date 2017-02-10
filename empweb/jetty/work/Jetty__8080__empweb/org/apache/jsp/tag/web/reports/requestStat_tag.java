package org.apache.jsp.tag.web.reports;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import java.util.Map;
import java.util.HashMap;
import java.lang.ref.*;
import java.util.Random;
import net.kalio.utils.collections.SortableMapOfMaps;
import java.util.*;
import org.w3c.dom.*;
import org.apache.commons.jxpath.*;
import net.kalio.jsptags.jxp.*;

public final class requestStat_tag
    extends javax.servlet.jsp.tagext.SimpleTagSupport
    implements org.apache.jasper.runtime.JspSourceDependent {


  private static java.util.Vector _jspx_dependants;

  static {
    _jspx_dependants = new java.util.Vector(5);
    _jspx_dependants.add("/WEB-INF/tags/trans/doTransaction.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/set.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/forEach.tag");
    _jspx_dependants.add("/WEB-INF/tags/trans/searchUsersById.tag");
    _jspx_dependants.add("/WEB-INF/tags/trans/searchObjectsById.tag");
  }

  private JspContext jspContext;
  private java.io.Writer _jspx_sout;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_value_target_property_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_var_value_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_if_test;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_x_parse_varDom;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_forEach_var_items;

  public void setJspContext(JspContext ctx, java.util.Map aliasMap) {
    super.setJspContext(ctx);
    java.util.ArrayList _jspx_nested = null;
    java.util.ArrayList _jspx_at_begin = null;
    java.util.ArrayList _jspx_at_end = null;
    _jspx_at_end = new java.util.ArrayList();
    _jspx_at_end.add("sortedResult");
    _jspx_at_end.add("sortedResultCount");
    _jspx_at_end.add("searchTimestamp");
    this.jspContext = new org.apache.jasper.runtime.JspContextWrapper(ctx, _jspx_nested, _jspx_at_begin, _jspx_at_end, aliasMap);
  }

  public JspContext getJspContext() {
    return this.jspContext;
  }
  private java.lang.String name;
  private java.lang.String fillUsersInfo;
  private java.lang.String fillObjectsInfo;
  private java.lang.String sortBy;
  private java.lang.String order;
  private java.lang.String from;
  private java.lang.String qty;
  private java.lang.String flushCache;
  private java.lang.String var;
  private java.lang.String totalCount;
  private java.lang.String timestamp;
  private java.lang.String hash;
  private java.lang.String cacheId;
  private java.lang.String newCacheIdVar;

  public java.lang.String getName() {
    return this.name;
  }

  public void setName(java.lang.String name) {
    this.name = name;
  }

  public java.lang.String getFillUsersInfo() {
    return this.fillUsersInfo;
  }

  public void setFillUsersInfo(java.lang.String fillUsersInfo) {
    this.fillUsersInfo = fillUsersInfo;
  }

  public java.lang.String getFillObjectsInfo() {
    return this.fillObjectsInfo;
  }

  public void setFillObjectsInfo(java.lang.String fillObjectsInfo) {
    this.fillObjectsInfo = fillObjectsInfo;
  }

  public java.lang.String getSortBy() {
    return this.sortBy;
  }

  public void setSortBy(java.lang.String sortBy) {
    this.sortBy = sortBy;
  }

  public java.lang.String getOrder() {
    return this.order;
  }

  public void setOrder(java.lang.String order) {
    this.order = order;
  }

  public java.lang.String getFrom() {
    return this.from;
  }

  public void setFrom(java.lang.String from) {
    this.from = from;
  }

  public java.lang.String getQty() {
    return this.qty;
  }

  public void setQty(java.lang.String qty) {
    this.qty = qty;
  }

  public java.lang.String getFlushCache() {
    return this.flushCache;
  }

  public void setFlushCache(java.lang.String flushCache) {
    this.flushCache = flushCache;
  }

  public java.lang.String getVar() {
    return this.var;
  }

  public void setVar(java.lang.String var) {
    this.var = var;
  }

  public java.lang.String getTotalCount() {
    return this.totalCount;
  }

  public void setTotalCount(java.lang.String totalCount) {
    this.totalCount = totalCount;
  }

  public java.lang.String getTimestamp() {
    return this.timestamp;
  }

  public void setTimestamp(java.lang.String timestamp) {
    this.timestamp = timestamp;
  }

  public java.lang.String getHash() {
    return this.hash;
  }

  public void setHash(java.lang.String hash) {
    this.hash = hash;
  }

  public java.lang.String getCacheId() {
    return this.cacheId;
  }

  public void setCacheId(java.lang.String cacheId) {
    this.cacheId = cacheId;
  }

  public java.lang.String getNewCacheIdVar() {
    return this.newCacheIdVar;
  }

  public void setNewCacheIdVar(java.lang.String newCacheIdVar) {
    this.newCacheIdVar = newCacheIdVar;
  }

  public java.util.List getDependants() {
    return _jspx_dependants;
  }

  private void _jspInit(ServletConfig config) {
    _jspx_tagPool_c_set_value_target_property_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_set_var_value_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_if_test = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_x_parse_varDom = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_forEach_var_items = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
  }

  public void _jspDestroy() {
    _jspx_tagPool_c_set_value_target_property_nobody.release();
    _jspx_tagPool_c_set_var_value_nobody.release();
    _jspx_tagPool_c_if_test.release();
    _jspx_tagPool_x_parse_varDom.release();
    _jspx_tagPool_c_forEach_var_items.release();
  }

  public void doTag() throws JspException, java.io.IOException {
    PageContext _jspx_page_context = (PageContext)jspContext;
    HttpServletRequest request = (HttpServletRequest) _jspx_page_context.getRequest();
    HttpServletResponse response = (HttpServletResponse) _jspx_page_context.getResponse();
    HttpSession session = _jspx_page_context.getSession();
    ServletContext application = _jspx_page_context.getServletContext();
    ServletConfig config = _jspx_page_context.getServletConfig();
    JspWriter out = jspContext.getOut();
    _jspInit(config);
    if( getName() != null ) 
      _jspx_page_context.setAttribute("name", getName());
    if( getFillUsersInfo() != null ) 
      _jspx_page_context.setAttribute("fillUsersInfo", getFillUsersInfo());
    if( getFillObjectsInfo() != null ) 
      _jspx_page_context.setAttribute("fillObjectsInfo", getFillObjectsInfo());
    if( getSortBy() != null ) 
      _jspx_page_context.setAttribute("sortBy", getSortBy());
    if( getOrder() != null ) 
      _jspx_page_context.setAttribute("order", getOrder());
    if( getFrom() != null ) 
      _jspx_page_context.setAttribute("from", getFrom());
    if( getQty() != null ) 
      _jspx_page_context.setAttribute("qty", getQty());
    if( getFlushCache() != null ) 
      _jspx_page_context.setAttribute("flushCache", getFlushCache());
    if( getVar() != null ) 
      _jspx_page_context.setAttribute("var", getVar());
    if( getTotalCount() != null ) 
      _jspx_page_context.setAttribute("totalCount", getTotalCount());
    if( getTimestamp() != null ) 
      _jspx_page_context.setAttribute("timestamp", getTimestamp());
    if( getHash() != null ) 
      _jspx_page_context.setAttribute("hash", getHash());
    if( getCacheId() != null ) 
      _jspx_page_context.setAttribute("cacheId", getCacheId());
    if( getNewCacheIdVar() != null ) 
      _jspx_page_context.setAttribute("newCacheIdVar", getNewCacheIdVar());

    try {
      java.util.HashMap nsm = null;
      synchronized (_jspx_page_context) {
        nsm = (java.util.HashMap) _jspx_page_context.getAttribute("nsm", PageContext.PAGE_SCOPE);
        if (nsm == null){
          nsm = new java.util.HashMap();
          _jspx_page_context.setAttribute("nsm", nsm, PageContext.PAGE_SCOPE);
        }
      }
      if (_jspx_meth_c_set_0(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_1(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_2(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_3(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_4(_jspx_page_context))
        return;
      if (_jspx_meth_c_set_5(_jspx_page_context))
        return;

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

      //  c:if
      org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_0 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
      _jspx_th_c_if_0.setPageContext(_jspx_page_context);
      _jspx_th_c_if_0.setParent(null);
      _jspx_th_c_if_0.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${isCached eq 'false'}", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
      int _jspx_eval_c_if_0 = _jspx_th_c_if_0.doStartTag();
      if (_jspx_eval_c_if_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {

    Random randomGen = new Random(System.currentTimeMillis());
    String randomString = Integer.toHexString(randomGen.nextInt());
    newCacheId = randomString.toUpperCase();
  
          if (_jspx_meth_x_parse_0(_jspx_th_c_if_0, _jspx_page_context))
            return;
          //  jxp:set
          org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_0 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
          java.util.HashMap _jspx_th_jxp_set_0_aliasMap = new java.util.HashMap();
          _jspx_th_jxp_set_0_aliasMap.put("punt", "resultIds");
          _jspx_th_jxp_set_0.setJspContext(_jspx_page_context, _jspx_th_jxp_set_0_aliasMap);
          _jspx_th_jxp_set_0.setParent(_jspx_th_c_if_0);
          _jspx_th_jxp_set_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${statCount}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
          _jspx_th_jxp_set_0.setVar("resultIds");
          _jspx_th_jxp_set_0.setSelect("//tr:result/tr:values/tr:value[tr:id]");
          _jspx_th_jxp_set_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
          _jspx_th_jxp_set_0.doTag();
          //  jxp:set
          org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_1 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
          java.util.HashMap _jspx_th_jxp_set_1_aliasMap = new java.util.HashMap();
          _jspx_th_jxp_set_1_aliasMap.put("punt", "resultsCount");
          _jspx_th_jxp_set_1.setJspContext(_jspx_page_context, _jspx_th_jxp_set_1_aliasMap);
          _jspx_th_jxp_set_1.setParent(_jspx_th_c_if_0);
          _jspx_th_jxp_set_1.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${resultIds}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
          _jspx_th_jxp_set_1.setVar("resultsCount");
          _jspx_th_jxp_set_1.setSelect("count(tr:id)");
          _jspx_th_jxp_set_1.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
          _jspx_th_jxp_set_1.doTag();
          //  x:parse
          org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_1 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
          _jspx_th_x_parse_1.setPageContext(_jspx_page_context);
          _jspx_th_x_parse_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_0);
          _jspx_th_x_parse_1.setVarDom("doc");
          int _jspx_eval_x_parse_1 = _jspx_th_x_parse_1.doStartTag();
          if (_jspx_eval_x_parse_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
            if (_jspx_eval_x_parse_1 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
              out = _jspx_page_context.pushBody();
              _jspx_th_x_parse_1.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
              _jspx_th_x_parse_1.doInitBody();
            }
            do {
              //  trans:doTransaction
              org.apache.jsp.tag.web.trans.doTransaction_tag _jspx_th_trans_doTransaction_1 = new org.apache.jsp.tag.web.trans.doTransaction_tag();
              _jspx_th_trans_doTransaction_1.setJspContext(_jspx_page_context);
              _jspx_th_trans_doTransaction_1.setParent(_jspx_th_x_parse_1);
              _jspx_th_trans_doTransaction_1.setName("stat-trans-by-ids");
              _jspx_th_trans_doTransaction_1.setJspBody(new requestStat_tagHelper( 1, _jspx_page_context, _jspx_th_trans_doTransaction_1, null));
              _jspx_th_trans_doTransaction_1.doTag();
              int evalDoAfterBody = _jspx_th_x_parse_1.doAfterBody();
              if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                break;
            } while (true);
            if (_jspx_eval_x_parse_1 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
              out = _jspx_page_context.popBody();
          }
          if (_jspx_th_x_parse_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
            throw new SkipPageException();
          _jspx_tagPool_x_parse_varDom.reuse(_jspx_th_x_parse_1);
          //  jxp:set
          org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_2 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
          java.util.HashMap _jspx_th_jxp_set_2_aliasMap = new java.util.HashMap();
          _jspx_th_jxp_set_2_aliasMap.put("punt", "transactions");
          _jspx_th_jxp_set_2.setJspContext(_jspx_page_context, _jspx_th_jxp_set_2_aliasMap);
          _jspx_th_jxp_set_2.setParent(_jspx_th_c_if_0);
          _jspx_th_jxp_set_2.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${doc}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
          _jspx_th_jxp_set_2.setVar("transactions");
          _jspx_th_jxp_set_2.setSelect("//tr:result");
          _jspx_th_jxp_set_2.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
          _jspx_th_jxp_set_2.doTag();
          //  c:if
          org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_1 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
          _jspx_th_c_if_1.setPageContext(_jspx_page_context);
          _jspx_th_c_if_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_0);
          _jspx_th_c_if_1.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(not empty fillUsersInfo) and (fillUsersInfo eq 'true')}", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
          int _jspx_eval_c_if_1 = _jspx_th_c_if_1.doStartTag();
          if (_jspx_eval_c_if_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
            do {
              java.util.HashMap uniqueUserIds = null;
              synchronized (_jspx_page_context) {
                uniqueUserIds = (java.util.HashMap) _jspx_page_context.getAttribute("uniqueUserIds", PageContext.PAGE_SCOPE);
                if (uniqueUserIds == null){
                  uniqueUserIds = new java.util.HashMap();
                  _jspx_page_context.setAttribute("uniqueUserIds", uniqueUserIds, PageContext.PAGE_SCOPE);
                }
              }
              //  jxp:forEach
              org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_1 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
              java.util.HashMap _jspx_th_jxp_forEach_1_aliasMap = new java.util.HashMap();
              _jspx_th_jxp_forEach_1_aliasMap.put("punt", "ptr");
              _jspx_th_jxp_forEach_1.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_1_aliasMap);
              _jspx_th_jxp_forEach_1.setParent(_jspx_th_c_if_1);
              _jspx_th_jxp_forEach_1.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${transactions}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
              _jspx_th_jxp_forEach_1.setVar("ptr");
              _jspx_th_jxp_forEach_1.setSelect("//*[local-name()='userId']");
              _jspx_th_jxp_forEach_1.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
              _jspx_th_jxp_forEach_1.setJspBody(new requestStat_tagHelper( 3, _jspx_page_context, _jspx_th_jxp_forEach_1, null));
              _jspx_th_jxp_forEach_1.doTag();
              if (_jspx_meth_x_parse_2(_jspx_th_c_if_1, _jspx_page_context))
                return;
              int evalDoAfterBody = _jspx_th_c_if_1.doAfterBody();
              if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                break;
            } while (true);
          }
          if (_jspx_th_c_if_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
            throw new SkipPageException();
          _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_1);
          //  c:if
          org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_2 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
          _jspx_th_c_if_2.setPageContext(_jspx_page_context);
          _jspx_th_c_if_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_0);
          _jspx_th_c_if_2.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(not empty fillObjectsInfo) and (fillObjectsInfo eq 'true')}", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
          int _jspx_eval_c_if_2 = _jspx_th_c_if_2.doStartTag();
          if (_jspx_eval_c_if_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
            do {
              java.util.HashMap uniqueCopyIds = null;
              synchronized (_jspx_page_context) {
                uniqueCopyIds = (java.util.HashMap) _jspx_page_context.getAttribute("uniqueCopyIds", PageContext.PAGE_SCOPE);
                if (uniqueCopyIds == null){
                  uniqueCopyIds = new java.util.HashMap();
                  _jspx_page_context.setAttribute("uniqueCopyIds", uniqueCopyIds, PageContext.PAGE_SCOPE);
                }
              }
              //  jxp:forEach
              org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_2 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
              java.util.HashMap _jspx_th_jxp_forEach_2_aliasMap = new java.util.HashMap();
              _jspx_th_jxp_forEach_2_aliasMap.put("punt", "ptr");
              _jspx_th_jxp_forEach_2.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_2_aliasMap);
              _jspx_th_jxp_forEach_2.setParent(_jspx_th_c_if_2);
              _jspx_th_jxp_forEach_2.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${transactions}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
              _jspx_th_jxp_forEach_2.setVar("ptr");
              _jspx_th_jxp_forEach_2.setSelect("//*[local-name()='copyId']");
              _jspx_th_jxp_forEach_2.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
              _jspx_th_jxp_forEach_2.setJspBody(new requestStat_tagHelper( 5, _jspx_page_context, _jspx_th_jxp_forEach_2, null));
              _jspx_th_jxp_forEach_2.doTag();
              if (_jspx_meth_x_parse_3(_jspx_th_c_if_2, _jspx_page_context))
                return;
              int evalDoAfterBody = _jspx_th_c_if_2.doAfterBody();
              if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                break;
            } while (true);
          }
          if (_jspx_th_c_if_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
            throw new SkipPageException();
          _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_2);


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


          int evalDoAfterBody = _jspx_th_c_if_0.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_if_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        throw new SkipPageException();
      _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_0);

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

    } catch( Throwable t ) {
      if( t instanceof SkipPageException )
          throw (SkipPageException) t;
      if( t instanceof java.io.IOException )
          throw (java.io.IOException) t;
      if( t instanceof IllegalStateException )
          throw (IllegalStateException) t;
      if( t instanceof JspException )
          throw (JspException) t;
      throw new JspException(t);
    } finally {
      ((org.apache.jasper.runtime.JspContextWrapper) jspContext).syncEndTagFile();
      _jspDestroy();
    }
  }

  private boolean _jspx_meth_c_set_0(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_0 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_0.setPageContext(_jspx_page_context);
    _jspx_th_c_set_0.setParent(null);
    _jspx_th_c_set_0.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_0.setProperty("uinfo");
    _jspx_th_c_set_0.setValue(new String("http://kalio.net/empweb/schema/users/v1"));
    int _jspx_eval_c_set_0 = _jspx_th_c_set_0.doStartTag();
    if (_jspx_th_c_set_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_0);
    return false;
  }

  private boolean _jspx_meth_c_set_1(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_1 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_1.setPageContext(_jspx_page_context);
    _jspx_th_c_set_1.setParent(null);
    _jspx_th_c_set_1.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_1.setProperty("ustat");
    _jspx_th_c_set_1.setValue(new String("http://kalio.net/empweb/schema/userstatus/v1"));
    int _jspx_eval_c_set_1 = _jspx_th_c_set_1.doStartTag();
    if (_jspx_th_c_set_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_1);
    return false;
  }

  private boolean _jspx_meth_c_set_2(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_2 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_2.setPageContext(_jspx_page_context);
    _jspx_th_c_set_2.setParent(null);
    _jspx_th_c_set_2.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_2.setProperty("mods");
    _jspx_th_c_set_2.setValue(new String("http://www.loc.gov/mods/v3"));
    int _jspx_eval_c_set_2 = _jspx_th_c_set_2.doStartTag();
    if (_jspx_th_c_set_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_2);
    return false;
  }

  private boolean _jspx_meth_c_set_3(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_3 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_3.setPageContext(_jspx_page_context);
    _jspx_th_c_set_3.setParent(null);
    _jspx_th_c_set_3.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_3.setProperty("tr");
    _jspx_th_c_set_3.setValue(new String("http://kalio.net/empweb/schema/transactionresult/v1"));
    int _jspx_eval_c_set_3 = _jspx_th_c_set_3.doStartTag();
    if (_jspx_th_c_set_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_3);
    return false;
  }

  private boolean _jspx_meth_c_set_4(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_4 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_4.setPageContext(_jspx_page_context);
    _jspx_th_c_set_4.setParent(null);
    _jspx_th_c_set_4.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_4.setProperty("tl");
    _jspx_th_c_set_4.setValue(new String("http://kalio.net/empweb/schema/transactionlist/v1"));
    int _jspx_eval_c_set_4 = _jspx_th_c_set_4.doStartTag();
    if (_jspx_th_c_set_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_4);
    return false;
  }

  private boolean _jspx_meth_c_set_5(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_5 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_5.setPageContext(_jspx_page_context);
    _jspx_th_c_set_5.setParent(null);
    _jspx_th_c_set_5.setVar("isCached");
    _jspx_th_c_set_5.setValue(new String("false"));
    int _jspx_eval_c_set_5 = _jspx_th_c_set_5.doStartTag();
    if (_jspx_th_c_set_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var_value_nobody.reuse(_jspx_th_c_set_5);
    return false;
  }

  private boolean _jspx_meth_x_parse_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_0 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_0.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_0);
    _jspx_th_x_parse_0.setVarDom("statCount");
    int _jspx_eval_x_parse_0 = _jspx_th_x_parse_0.doStartTag();
    if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_0.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_0.doInitBody();
      }
      do {
        if (_jspx_meth_trans_doTransaction_0(_jspx_th_x_parse_0, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_x_parse_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_x_parse_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_x_parse_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_x_parse_varDom.reuse(_jspx_th_x_parse_0);
    return false;
  }

  private boolean _jspx_meth_trans_doTransaction_0(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  trans:doTransaction
    org.apache.jsp.tag.web.trans.doTransaction_tag _jspx_th_trans_doTransaction_0 = new org.apache.jsp.tag.web.trans.doTransaction_tag();
    _jspx_th_trans_doTransaction_0.setJspContext(_jspx_page_context);
    _jspx_th_trans_doTransaction_0.setParent(_jspx_th_x_parse_0);
    _jspx_th_trans_doTransaction_0.setName((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("stat-${name}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_trans_doTransaction_0.setJspBody(new requestStat_tagHelper( 0, _jspx_page_context, _jspx_th_trans_doTransaction_0, null));
    _jspx_th_trans_doTransaction_0.doTag();
    return false;
  }

  private boolean _jspx_meth_c_set_6(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_6 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_6.setPageContext(_jspx_page_context);
    _jspx_th_c_set_6.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_set_6.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${uniqueUserIds}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_6.setProperty((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['.']},", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_6.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['.']},", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    int _jspx_eval_c_set_6 = _jspx_th_c_set_6.doStartTag();
    if (_jspx_th_c_set_6.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_6);
    return false;
  }

  private boolean _jspx_meth_x_parse_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_2 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_2.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_1);
    _jspx_th_x_parse_2.setVarDom("usersInfo");
    int _jspx_eval_x_parse_2 = _jspx_th_x_parse_2.doStartTag();
    if (_jspx_eval_x_parse_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_2 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_2.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_2.doInitBody();
      }
      do {
        if (_jspx_meth_trans_searchUsersById_0(_jspx_th_x_parse_2, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_x_parse_2.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_x_parse_2 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_x_parse_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_x_parse_varDom.reuse(_jspx_th_x_parse_2);
    return false;
  }

  private boolean _jspx_meth_trans_searchUsersById_0(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  trans:searchUsersById
    org.apache.jsp.tag.web.trans.searchUsersById_tag _jspx_th_trans_searchUsersById_0 = new org.apache.jsp.tag.web.trans.searchUsersById_tag();
    _jspx_th_trans_searchUsersById_0.setJspContext(_jspx_page_context);
    _jspx_th_trans_searchUsersById_0.setParent(_jspx_th_x_parse_2);
    _jspx_th_trans_searchUsersById_0.setDatabase("*");
    _jspx_th_trans_searchUsersById_0.setJspBody(new requestStat_tagHelper( 4, _jspx_page_context, _jspx_th_trans_searchUsersById_0, null));
    _jspx_th_trans_searchUsersById_0.doTag();
    return false;
  }

  private boolean _jspx_meth_c_forEach_0(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:forEach
    org.apache.taglibs.standard.tag.rt.core.ForEachTag _jspx_th_c_forEach_0 = (org.apache.taglibs.standard.tag.rt.core.ForEachTag) _jspx_tagPool_c_forEach_var_items.get(org.apache.taglibs.standard.tag.rt.core.ForEachTag.class);
    _jspx_th_c_forEach_0.setPageContext(_jspx_page_context);
    _jspx_th_c_forEach_0.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_forEach_0.setItems((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${uniqueUserIds}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_forEach_0.setVar("_uid");
    int[] _jspx_push_body_count_c_forEach_0 = new int[] { 0 };
    try {
      int _jspx_eval_c_forEach_0 = _jspx_th_c_forEach_0.doStartTag();
      if (_jspx_eval_c_forEach_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
          out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${_uid.value}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
          int evalDoAfterBody = _jspx_th_c_forEach_0.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_forEach_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        throw new SkipPageException();
    } catch (Throwable _jspx_exception) {
      while (_jspx_push_body_count_c_forEach_0[0]-- > 0)
        out = _jspx_page_context.popBody();
      _jspx_th_c_forEach_0.doCatch(_jspx_exception);
    } finally {
      _jspx_th_c_forEach_0.doFinally();
      _jspx_tagPool_c_forEach_var_items.reuse(_jspx_th_c_forEach_0);
    }
    return false;
  }

  private boolean _jspx_meth_c_set_7(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_7 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_7.setPageContext(_jspx_page_context);
    _jspx_th_c_set_7.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_set_7.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${uniqueCopyIds}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_7.setProperty((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['.']},", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_7.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['.']},", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    int _jspx_eval_c_set_7 = _jspx_th_c_set_7.doStartTag();
    if (_jspx_th_c_set_7.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_7);
    return false;
  }

  private boolean _jspx_meth_x_parse_3(javax.servlet.jsp.tagext.JspTag _jspx_th_c_if_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  x:parse
    org.apache.taglibs.standard.tag.rt.xml.ParseTag _jspx_th_x_parse_3 = (org.apache.taglibs.standard.tag.rt.xml.ParseTag) _jspx_tagPool_x_parse_varDom.get(org.apache.taglibs.standard.tag.rt.xml.ParseTag.class);
    _jspx_th_x_parse_3.setPageContext(_jspx_page_context);
    _jspx_th_x_parse_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_if_2);
    _jspx_th_x_parse_3.setVarDom("objectsInfo");
    int _jspx_eval_x_parse_3 = _jspx_th_x_parse_3.doStartTag();
    if (_jspx_eval_x_parse_3 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_x_parse_3 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_x_parse_3.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_x_parse_3.doInitBody();
      }
      do {
        if (_jspx_meth_trans_searchObjectsById_0(_jspx_th_x_parse_3, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_x_parse_3.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_x_parse_3 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_x_parse_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_x_parse_varDom.reuse(_jspx_th_x_parse_3);
    return false;
  }

  private boolean _jspx_meth_trans_searchObjectsById_0(javax.servlet.jsp.tagext.JspTag _jspx_th_x_parse_3, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  trans:searchObjectsById
    org.apache.jsp.tag.web.trans.searchObjectsById_tag _jspx_th_trans_searchObjectsById_0 = new org.apache.jsp.tag.web.trans.searchObjectsById_tag();
    _jspx_th_trans_searchObjectsById_0.setJspContext(_jspx_page_context);
    _jspx_th_trans_searchObjectsById_0.setParent(_jspx_th_x_parse_3);
    _jspx_th_trans_searchObjectsById_0.setDatabase("*");
    _jspx_th_trans_searchObjectsById_0.setJspBody(new requestStat_tagHelper( 6, _jspx_page_context, _jspx_th_trans_searchObjectsById_0, null));
    _jspx_th_trans_searchObjectsById_0.doTag();
    return false;
  }

  private boolean _jspx_meth_c_forEach_1(javax.servlet.jsp.tagext.JspTag _jspx_parent, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:forEach
    org.apache.taglibs.standard.tag.rt.core.ForEachTag _jspx_th_c_forEach_1 = (org.apache.taglibs.standard.tag.rt.core.ForEachTag) _jspx_tagPool_c_forEach_var_items.get(org.apache.taglibs.standard.tag.rt.core.ForEachTag.class);
    _jspx_th_c_forEach_1.setPageContext(_jspx_page_context);
    _jspx_th_c_forEach_1.setParent(new javax.servlet.jsp.tagext.TagAdapter((javax.servlet.jsp.tagext.SimpleTag) _jspx_parent));
    _jspx_th_c_forEach_1.setItems((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${uniqueCopyIds}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_forEach_1.setVar("_cpid");
    int[] _jspx_push_body_count_c_forEach_1 = new int[] { 0 };
    try {
      int _jspx_eval_c_forEach_1 = _jspx_th_c_forEach_1.doStartTag();
      if (_jspx_eval_c_forEach_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
          out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${_cpid.value}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
          int evalDoAfterBody = _jspx_th_c_forEach_1.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_forEach_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        throw new SkipPageException();
    } catch (Throwable _jspx_exception) {
      while (_jspx_push_body_count_c_forEach_1[0]-- > 0)
        out = _jspx_page_context.popBody();
      _jspx_th_c_forEach_1.doCatch(_jspx_exception);
    } finally {
      _jspx_th_c_forEach_1.doFinally();
      _jspx_tagPool_c_forEach_var_items.reuse(_jspx_th_c_forEach_1);
    }
    return false;
  }

  private class requestStat_tagHelper
      extends org.apache.jasper.runtime.JspFragmentHelper
  {
    private javax.servlet.jsp.tagext.JspTag _jspx_parent;
    private int[] _jspx_push_body_count;

    public requestStat_tagHelper( int discriminator, JspContext jspContext, javax.servlet.jsp.tagext.JspTag _jspx_parent, int[] _jspx_push_body_count ) {
      super( discriminator, jspContext, _jspx_parent );
      this._jspx_parent = _jspx_parent;
      this._jspx_push_body_count = _jspx_push_body_count;
    }
    public boolean invoke0( JspWriter out ) 
      throws Throwable
    {
      out.write("<transactionExtras>\r\n");
      out.write("        <params>\r\n");
      out.write("          ");
      ((org.apache.jasper.runtime.JspContextWrapper) this.jspContext).syncBeforeInvoke();
      _jspx_sout = null;
      if (getJspBody() != null)
        getJspBody().invoke(_jspx_sout);
      out.write("</params>\r\n");
      out.write("      </transactionExtras>\r\n");
      out.write("    ");
      return false;
    }
    public void invoke1( JspWriter out ) 
      throws Throwable
    {
      out.write("<transactionExtras>\r\n");
      out.write("          <params>\r\n");
      out.write("            <param name=\"transactionIds\">\r\n");
      out.write("              ");
      //  jxp:forEach
      org.apache.jsp.tag.web.commons.jxp.forEach_tag _jspx_th_jxp_forEach_0 = new org.apache.jsp.tag.web.commons.jxp.forEach_tag();
      java.util.HashMap _jspx_th_jxp_forEach_0_aliasMap = new java.util.HashMap();
      _jspx_th_jxp_forEach_0_aliasMap.put("punt", "id");
      _jspx_th_jxp_forEach_0.setJspContext(_jspx_page_context, _jspx_th_jxp_forEach_0_aliasMap);
      _jspx_th_jxp_forEach_0.setParent(_jspx_parent);
      _jspx_th_jxp_forEach_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${resultIds}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
      _jspx_th_jxp_forEach_0.setVar("id");
      _jspx_th_jxp_forEach_0.setSelect("tr:id");
      _jspx_th_jxp_forEach_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
      _jspx_th_jxp_forEach_0.setJspBody(new requestStat_tagHelper( 2, _jspx_page_context, _jspx_th_jxp_forEach_0, null));
      _jspx_th_jxp_forEach_0.doTag();
      out.write("</param>\r\n");
      out.write("          </params>\r\n");
      out.write("        </transactionExtras>\r\n");
      out.write("      ");
      return;
    }
    public void invoke2( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${id}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
      out.write(',');
      return;
    }
    public void invoke3( JspWriter out ) 
      throws Throwable
    {
      if (_jspx_meth_c_set_6(_jspx_parent, _jspx_page_context))
        return;
      return;
    }
    public boolean invoke4( JspWriter out ) 
      throws Throwable
    {
      if (_jspx_meth_c_forEach_0(_jspx_parent, _jspx_page_context))
        return true;
      return false;
    }
    public void invoke5( JspWriter out ) 
      throws Throwable
    {
      if (_jspx_meth_c_set_7(_jspx_parent, _jspx_page_context))
        return;
      return;
    }
    public boolean invoke6( JspWriter out ) 
      throws Throwable
    {
      if (_jspx_meth_c_forEach_1(_jspx_parent, _jspx_page_context))
        return true;
      return false;
    }
    public void invoke( java.io.Writer writer )
      throws JspException
    {
      JspWriter out = null;
      if( writer != null ) {
        out = this.jspContext.pushBody(writer);
      } else {
        out = this.jspContext.getOut();
      }
      try {
        switch( this.discriminator ) {
          case 0:
            invoke0( out );
            break;
          case 1:
            invoke1( out );
            break;
          case 2:
            invoke2( out );
            break;
          case 3:
            invoke3( out );
            break;
          case 4:
            invoke4( out );
            break;
          case 5:
            invoke5( out );
            break;
          case 6:
            invoke6( out );
            break;
        }
      }
      catch( Throwable e ) {
        if (e instanceof SkipPageException)
            throw (SkipPageException) e;
        throw new JspException( e );
      }
      finally {
        if( writer != null ) {
          this.jspContext.popBody();
        }
      }
    }
  }
}
