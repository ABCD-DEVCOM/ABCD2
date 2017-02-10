package org.apache.jsp.tag.web.display;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;
import java.util.*;
import org.apache.commons.jxpath.*;
import org.w3c.dom.*;

public final class loanRow_tag
    extends javax.servlet.jsp.tagext.SimpleTagSupport
    implements org.apache.jasper.runtime.JspSourceDependent {


static private org.apache.jasper.runtime.ProtectedFunctionMapper _jspx_fnmap_0;

static {
  _jspx_fnmap_0= org.apache.jasper.runtime.ProtectedFunctionMapper.getMapForFunction("fn:escapeXml", org.apache.taglibs.standard.functions.Functions.class, "escapeXml", new Class[] {java.lang.String.class});
}

  private static java.util.Vector _jspx_dependants;

  static {
    _jspx_dependants = new java.util.Vector(5);
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/out.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/jxp/set.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/util/formatDate.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/util/parseDate.tag");
    _jspx_dependants.add("/WEB-INF/tags/commons/util/isLate.tag");
  }

  private JspContext jspContext;
  private java.io.Writer _jspx_sout;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_setBundle_scope_basename_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_choose;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_when_test;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_var;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_if_test;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_var_value_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_fmt_message_key_nobody;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_otherwise;
  private org.apache.jasper.runtime.TagHandlerPool _jspx_tagPool_c_set_value_target_property_nobody;

  public void setJspContext(JspContext ctx) {
    super.setJspContext(ctx);
    java.util.ArrayList _jspx_nested = null;
    java.util.ArrayList _jspx_at_begin = null;
    java.util.ArrayList _jspx_at_end = null;
    this.jspContext = new org.apache.jasper.runtime.JspContextWrapper(ctx, _jspx_nested, _jspx_at_begin, _jspx_at_end, null);
  }

  public JspContext getJspContext() {
    return this.jspContext;
  }
  private java.lang.String isheader;
  private java.lang.String showsortlinks;
  private java.lang.String urlprefix;
  private java.lang.Object doc;
  private java.lang.Object recordDoc;
  private java.lang.Object userDoc;
  private java.util.HashMap rowMap;

  public java.lang.String getIsheader() {
    return this.isheader;
  }

  public void setIsheader(java.lang.String isheader) {
    this.isheader = isheader;
  }

  public java.lang.String getShowsortlinks() {
    return this.showsortlinks;
  }

  public void setShowsortlinks(java.lang.String showsortlinks) {
    this.showsortlinks = showsortlinks;
  }

  public java.lang.String getUrlprefix() {
    return this.urlprefix;
  }

  public void setUrlprefix(java.lang.String urlprefix) {
    this.urlprefix = urlprefix;
  }

  public java.lang.Object getDoc() {
    return this.doc;
  }

  public void setDoc(java.lang.Object doc) {
    this.doc = doc;
  }

  public java.lang.Object getRecordDoc() {
    return this.recordDoc;
  }

  public void setRecordDoc(java.lang.Object recordDoc) {
    this.recordDoc = recordDoc;
  }

  public java.lang.Object getUserDoc() {
    return this.userDoc;
  }

  public void setUserDoc(java.lang.Object userDoc) {
    this.userDoc = userDoc;
  }

  public java.util.HashMap getRowMap() {
    return this.rowMap;
  }

  public void setRowMap(java.util.HashMap rowMap) {
    this.rowMap = rowMap;
  }

  public java.util.List getDependants() {
    return _jspx_dependants;
  }

  private void _jspInit(ServletConfig config) {
    _jspx_tagPool_fmt_setBundle_scope_basename_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_choose = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_when_test = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_set_var = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_if_test = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_set_var_value_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_fmt_message_key_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_otherwise = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
    _jspx_tagPool_c_set_value_target_property_nobody = org.apache.jasper.runtime.TagHandlerPool.getTagHandlerPool(config);
  }

  public void _jspDestroy() {
    _jspx_tagPool_fmt_setBundle_scope_basename_nobody.release();
    _jspx_tagPool_c_choose.release();
    _jspx_tagPool_c_when_test.release();
    _jspx_tagPool_c_set_var.release();
    _jspx_tagPool_c_if_test.release();
    _jspx_tagPool_c_set_var_value_nobody.release();
    _jspx_tagPool_fmt_message_key_nobody.release();
    _jspx_tagPool_c_otherwise.release();
    _jspx_tagPool_c_set_value_target_property_nobody.release();
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
    if( getIsheader() != null ) 
      _jspx_page_context.setAttribute("isheader", getIsheader());
    if( getShowsortlinks() != null ) 
      _jspx_page_context.setAttribute("showsortlinks", getShowsortlinks());
    if( getUrlprefix() != null ) 
      _jspx_page_context.setAttribute("urlprefix", getUrlprefix());
    if( getDoc() != null ) 
      _jspx_page_context.setAttribute("doc", getDoc());
    if( getRecordDoc() != null ) 
      _jspx_page_context.setAttribute("recordDoc", getRecordDoc());
    if( getUserDoc() != null ) 
      _jspx_page_context.setAttribute("userDoc", getUserDoc());
    if( getRowMap() != null ) 
      _jspx_page_context.setAttribute("rowMap", getRowMap());

    try {
      if (_jspx_meth_fmt_setBundle_0(_jspx_page_context))
        return;
      //  c:choose
      org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_0 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
      _jspx_th_c_choose_0.setPageContext(_jspx_page_context);
      _jspx_th_c_choose_0.setParent(null);
      int _jspx_eval_c_choose_0 = _jspx_th_c_choose_0.doStartTag();
      if (_jspx_eval_c_choose_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
        do {
          if (_jspx_meth_c_when_0(_jspx_th_c_choose_0, _jspx_page_context))
            return;
          //  c:otherwise
          org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_1 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
          _jspx_th_c_otherwise_1.setPageContext(_jspx_page_context);
          _jspx_th_c_otherwise_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_0);
          int _jspx_eval_c_otherwise_1 = _jspx_th_c_otherwise_1.doStartTag();
          if (_jspx_eval_c_otherwise_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
            do {
              //  c:choose
              org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_2 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
              _jspx_th_c_choose_2.setPageContext(_jspx_page_context);
              _jspx_th_c_choose_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_1);
              int _jspx_eval_c_choose_2 = _jspx_th_c_choose_2.doStartTag();
              if (_jspx_eval_c_choose_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
                do {
                  if (_jspx_meth_c_when_2(_jspx_th_c_choose_2, _jspx_page_context))
                    return;
                  //  c:otherwise
                  org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_2 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
                  _jspx_th_c_otherwise_2.setPageContext(_jspx_page_context);
                  _jspx_th_c_otherwise_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_2);
                  int _jspx_eval_c_otherwise_2 = _jspx_th_c_otherwise_2.doStartTag();
                  if (_jspx_eval_c_otherwise_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
                    do {
                      java.util.HashMap nsm = null;
                      synchronized (_jspx_page_context) {
                        nsm = (java.util.HashMap) _jspx_page_context.getAttribute("nsm", PageContext.PAGE_SCOPE);
                        if (nsm == null){
                          nsm = new java.util.HashMap();
                          _jspx_page_context.setAttribute("nsm", nsm, PageContext.PAGE_SCOPE);
                        }
                      }
                      if (_jspx_meth_c_set_14(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      if (_jspx_meth_c_set_15(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      if (_jspx_meth_c_set_16(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      if (_jspx_meth_c_set_17(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      if (_jspx_meth_c_set_18(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      if (_jspx_meth_c_set_19(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      //  jxp:set
                      org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_0 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
                      java.util.HashMap _jspx_th_jxp_set_0_aliasMap = new java.util.HashMap();
                      _jspx_th_jxp_set_0_aliasMap.put("punt", "ptr");
                      _jspx_th_jxp_set_0.setJspContext(_jspx_page_context, _jspx_th_jxp_set_0_aliasMap);
                      _jspx_th_jxp_set_0.setParent(_jspx_th_c_otherwise_2);
                      _jspx_th_jxp_set_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${doc}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
                      _jspx_th_jxp_set_0.setVar("ptr");
                      _jspx_th_jxp_set_0.setSelect((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${select}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
                      _jspx_th_jxp_set_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
                      _jspx_th_jxp_set_0.doTag();
                      if (_jspx_meth_c_set_20(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      if (_jspx_meth_c_set_21(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      //  jxp:set
                      org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_1 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
                      java.util.HashMap _jspx_th_jxp_set_1_aliasMap = new java.util.HashMap();
                      _jspx_th_jxp_set_1_aliasMap.put("punt", "thisTitle");
                      _jspx_th_jxp_set_1.setJspContext(_jspx_page_context, _jspx_th_jxp_set_1_aliasMap);
                      _jspx_th_jxp_set_1.setParent(_jspx_th_c_otherwise_2);
                      _jspx_th_jxp_set_1.setVar("thisTitle");
                      _jspx_th_jxp_set_1.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${recordDoc}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
                      _jspx_th_jxp_set_1.setSelect("//mods:title");
                      _jspx_th_jxp_set_1.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
                      _jspx_th_jxp_set_1.doTag();
                      if (_jspx_meth_c_set_22(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      //  jxp:set
                      org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_2 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
                      java.util.HashMap _jspx_th_jxp_set_2_aliasMap = new java.util.HashMap();
                      _jspx_th_jxp_set_2_aliasMap.put("punt", "thisUserName");
                      _jspx_th_jxp_set_2.setJspContext(_jspx_page_context, _jspx_th_jxp_set_2_aliasMap);
                      _jspx_th_jxp_set_2.setParent(_jspx_th_c_otherwise_2);
                      _jspx_th_jxp_set_2.setVar("thisUserName");
                      _jspx_th_jxp_set_2.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${userDoc}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
                      _jspx_th_jxp_set_2.setSelect("//uinfo:name");
                      _jspx_th_jxp_set_2.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
                      _jspx_th_jxp_set_2.doTag();
                      if (_jspx_meth_c_set_23(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      if (_jspx_meth_c_set_24(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      if (_jspx_meth_c_set_25(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      if (_jspx_meth_c_set_26(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      if (_jspx_meth_c_set_27(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      //  jxp:set
                      org.apache.jsp.tag.web.commons.jxp.set_tag _jspx_th_jxp_set_3 = new org.apache.jsp.tag.web.commons.jxp.set_tag();
                      java.util.HashMap _jspx_th_jxp_set_3_aliasMap = new java.util.HashMap();
                      _jspx_th_jxp_set_3_aliasMap.put("punt", "thisCopyLocation");
                      _jspx_th_jxp_set_3.setJspContext(_jspx_page_context, _jspx_th_jxp_set_3_aliasMap);
                      _jspx_th_jxp_set_3.setParent(_jspx_th_c_otherwise_2);
                      _jspx_th_jxp_set_3.setVar("thisCopyLocation");
                      _jspx_th_jxp_set_3.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${recordDoc}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
                      _jspx_th_jxp_set_3.setSelect((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("//mods:mods[mods:recordInfo/mods:recordIdentifier='${thisRecordId}']/h:copy[h:copyId='${thisCopyId}']/h:copyLocation", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
                      _jspx_th_jxp_set_3.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
                      _jspx_th_jxp_set_3.doTag();
                      if (_jspx_meth_c_set_28(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      if (_jspx_meth_c_set_29(_jspx_th_c_otherwise_2, _jspx_page_context))
                        return;
                      int evalDoAfterBody = _jspx_th_c_otherwise_2.doAfterBody();
                      if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                        break;
                    } while (true);
                  }
                  if (_jspx_th_c_otherwise_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
                    throw new SkipPageException();
                  _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_2);
                  int evalDoAfterBody = _jspx_th_c_choose_2.doAfterBody();
                  if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                    break;
                } while (true);
              }
              if (_jspx_th_c_choose_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
                throw new SkipPageException();
              _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_2);
              out.write("<td> ");
              out.write("<a href=\"");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${sessionScope.absoluteContext}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              out.write("/trans/query/view_transaction_details.jsp?transaction_id=");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisTransactionId}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              out.write('"');
              out.write('>');
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisTransactionId}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              out.write("</a>\r\n");
              out.write("    </td>\r\n");
              out.write("\r\n");
              out.write("    <td> ");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:escapeXml(thisTitle)}", java.lang.String.class, (PageContext)this.getJspContext(), _jspx_fnmap_0, false));
              out.write("</td>\r\n");
              out.write("\r\n");
              out.write("    <td>");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisCopyLocation}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              out.write("&nbsp;");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisCopyId}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              if (_jspx_meth_c_if_1(_jspx_th_c_otherwise_1, _jspx_page_context))
                return;
              out.write("</td>\r\n");
              out.write("\r\n");
              out.write("    <td>");
              out.write("<a href=\"../../trans/query/record_status_result.jsp?record_id=");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisRecordId}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              out.write("&amp;object_db=");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisObjectDb}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              out.write("\">\r\n");
              out.write("        ");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisRecordId}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              if (_jspx_meth_c_if_2(_jspx_th_c_otherwise_1, _jspx_page_context))
                return;
              out.write("</a>\r\n");
              out.write("    </td>\r\n");
              out.write("\r\n");
              out.write("    <td>");
              if (_jspx_meth_util_formatDate_0(_jspx_th_c_otherwise_1, _jspx_page_context))
                return;
              out.write("</td>\r\n");
              out.write("    \r\n");
              out.write("    ");
              //  util:isLate
              org.apache.jsp.tag.web.commons.util.isLate_tag _jspx_th_util_isLate_0 = new org.apache.jsp.tag.web.commons.util.isLate_tag();
              java.util.HashMap _jspx_th_util_isLate_0_aliasMap = new java.util.HashMap();
              _jspx_th_util_isLate_0_aliasMap.put("varout", "late");
              _jspx_th_util_isLate_0.setJspContext(_jspx_page_context, _jspx_th_util_isLate_0_aliasMap);
              _jspx_th_util_isLate_0.setParent(_jspx_th_c_otherwise_1);
              _jspx_th_util_isLate_0.setVar("late");
              _jspx_th_util_isLate_0.setJspBody(new loanRow_tagHelper( 1, _jspx_page_context, _jspx_th_util_isLate_0, null));
              _jspx_th_util_isLate_0.doTag();
              out.write("<td\r\n");
              out.write("      ");
              if (_jspx_meth_c_if_3(_jspx_th_c_otherwise_1, _jspx_page_context))
                return;
              out.write(" >\r\n");
              out.write("      ");
              if (_jspx_meth_util_formatDate_1(_jspx_th_c_otherwise_1, _jspx_page_context))
                return;
              out.write("</td>\r\n");
              out.write("\r\n");
              out.write("    <td>");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisLocation}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              out.write("</td>\r\n");
              out.write("    \r\n");
              out.write("    <td>");
              out.write("<a href=\"../../trans/query/user_status_result.jsp?user_id=");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisUserId}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              out.write("&amp;user_db=");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisUserDb}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              out.write("\">\r\n");
              out.write("        ");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisUserId}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
              if (_jspx_meth_c_if_4(_jspx_th_c_otherwise_1, _jspx_page_context))
                return;
              out.write("</a>\r\n");
              out.write("    </td>\r\n");
              out.write("\r\n");
              out.write("    <td> ");
              out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${fn:escapeXml(thisUserName)}", java.lang.String.class, (PageContext)this.getJspContext(), _jspx_fnmap_0, false));
              out.write("</td>    \r\n");
              out.write("  ");
              int evalDoAfterBody = _jspx_th_c_otherwise_1.doAfterBody();
              if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
                break;
            } while (true);
          }
          if (_jspx_th_c_otherwise_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
            throw new SkipPageException();
          _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_1);
          int evalDoAfterBody = _jspx_th_c_choose_0.doAfterBody();
          if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
            break;
        } while (true);
      }
      if (_jspx_th_c_choose_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
        throw new SkipPageException();
      _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_0);
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

  private boolean _jspx_meth_fmt_setBundle_0(PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:setBundle
    org.apache.taglibs.standard.tag.rt.fmt.SetBundleTag _jspx_th_fmt_setBundle_0 = (org.apache.taglibs.standard.tag.rt.fmt.SetBundleTag) _jspx_tagPool_fmt_setBundle_scope_basename_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.SetBundleTag.class);
    _jspx_th_fmt_setBundle_0.setPageContext(_jspx_page_context);
    _jspx_th_fmt_setBundle_0.setParent(null);
    _jspx_th_fmt_setBundle_0.setBasename("ewi18n.local.display");
    _jspx_th_fmt_setBundle_0.setScope("page");
    int _jspx_eval_fmt_setBundle_0 = _jspx_th_fmt_setBundle_0.doStartTag();
    if (_jspx_th_fmt_setBundle_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_setBundle_scope_basename_nobody.reuse(_jspx_th_fmt_setBundle_0);
    return false;
  }

  private boolean _jspx_meth_c_when_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_0 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_0.setPageContext(_jspx_page_context);
    _jspx_th_c_when_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_0);
    _jspx_th_c_when_0.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty isheader}", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
    int _jspx_eval_c_when_0 = _jspx_th_c_when_0.doStartTag();
    if (_jspx_eval_c_when_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_choose_1(_jspx_th_c_when_0, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_when_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_0);
    return false;
  }

  private boolean _jspx_meth_c_choose_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:choose
    org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_1 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
    _jspx_th_c_choose_1.setPageContext(_jspx_page_context);
    _jspx_th_c_choose_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_0);
    int _jspx_eval_c_choose_1 = _jspx_th_c_choose_1.doStartTag();
    if (_jspx_eval_c_choose_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_when_1(_jspx_th_c_choose_1, _jspx_page_context))
          return true;
        if (_jspx_meth_c_otherwise_0(_jspx_th_c_choose_1, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_choose_1.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_choose_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_1);
    return false;
  }

  private boolean _jspx_meth_c_when_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_1 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_1.setPageContext(_jspx_page_context);
    _jspx_th_c_when_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_1);
    _jspx_th_c_when_1.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not empty showsortlinks}", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
    int _jspx_eval_c_when_1 = _jspx_th_c_when_1.doStartTag();
    if (_jspx_eval_c_when_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_set_0(_jspx_th_c_when_1, _jspx_page_context))
          return true;
        if (_jspx_meth_c_set_1(_jspx_th_c_when_1, _jspx_page_context))
          return true;
        out.write("<th>\r\n");
        out.write("          <a href=\"");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisurlprefix}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("&amp;sort_by=transactionId&amp;sort_order=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${sort_order}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("\">\r\n");
        out.write("            ");
        if (_jspx_meth_fmt_message_0(_jspx_th_c_when_1, _jspx_page_context))
          return true;
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_by eq 'transactionId')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("</a>\r\n");
        out.write("        </th>\r\n");
        out.write("        <th>\r\n");
        out.write("\t  <a href=\"");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisurlprefix}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("&amp;sort_by=recordTitle&amp;sort_order=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${sort_order}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("\">\r\n");
        out.write("            ");
        if (_jspx_meth_fmt_message_1(_jspx_th_c_when_1, _jspx_page_context))
          return true;
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_by eq 'recordTitle')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("</a>\r\n");
        out.write("\t</th>\r\n");
        out.write("        <th>\r\n");
        out.write("          <a href=\"");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisurlprefix}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("&amp;sort_by=copyId&amp;sort_order=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${sort_order}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("\">\r\n");
        out.write("            ");
        if (_jspx_meth_fmt_message_2(_jspx_th_c_when_1, _jspx_page_context))
          return true;
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_by eq 'copyId')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("</a>\r\n");
        out.write("        </th>\r\n");
        out.write("        <th>\r\n");
        out.write("          <a href=\"");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisurlprefix}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("&amp;sort_by=recordId&amp;sort_order=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${sort_order}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("\">\r\n");
        out.write("            ");
        if (_jspx_meth_fmt_message_3(_jspx_th_c_when_1, _jspx_page_context))
          return true;
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_by eq 'recordId')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("</a>\r\n");
        out.write("        </th>        \r\n");
        out.write("        <th>\r\n");
        out.write("          <a href=\"");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisurlprefix}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("&amp;sort_by=startDate&amp;sort_order=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${sort_order}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("\">\r\n");
        out.write("            ");
        if (_jspx_meth_fmt_message_4(_jspx_th_c_when_1, _jspx_page_context))
          return true;
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_by eq 'startDate')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("</a> \r\n");
        out.write("        </th>\r\n");
        out.write("        <th>\r\n");
        out.write("          <a href=\"");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisurlprefix}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("&amp;sort_by=endDate&amp;sort_order=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${sort_order}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("\">\r\n");
        out.write("            ");
        if (_jspx_meth_fmt_message_5(_jspx_th_c_when_1, _jspx_page_context))
          return true;
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_by eq 'endDate')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("</a> \r\n");
        out.write("        </th>\r\n");
        out.write("        <th>\r\n");
        out.write("          <a href=\"");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisurlprefix}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("&amp;sort_by=location&amp;sort_order=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${sort_order}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("\">\r\n");
        out.write("            ");
        if (_jspx_meth_fmt_message_6(_jspx_th_c_when_1, _jspx_page_context))
          return true;
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_by eq 'location')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("</a> \r\n");
        out.write("        </th>\r\n");
        out.write("        <th>\r\n");
        out.write("          <a href=\"");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisurlprefix}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("&amp;sort_by=userId&amp;sort_order=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${sort_order}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("\">\r\n");
        out.write("            ");
        if (_jspx_meth_fmt_message_7(_jspx_th_c_when_1, _jspx_page_context))
          return true;
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_by eq 'userId')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("</a>\r\n");
        out.write("        </th>\r\n");
        out.write("        <th>\r\n");
        out.write("          <a href=\"");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisurlprefix}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("&amp;sort_by=userName&amp;sort_order=");
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${sort_order}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("\">\r\n");
        out.write("            ");
        if (_jspx_meth_fmt_message_8(_jspx_th_c_when_1, _jspx_page_context))
          return true;
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_by eq 'userName')?((param.sort_order eq 'ascending')?'(+)':'(-)'):''}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write("</a>\r\n");
        out.write("        </th>\r\n");
        out.write("\r\n");
        out.write("      ");
        int evalDoAfterBody = _jspx_th_c_when_1.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_1);
    return false;
  }

  private boolean _jspx_meth_c_set_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_0 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_0.setPageContext(_jspx_page_context);
    _jspx_th_c_set_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_1);
    _jspx_th_c_set_0.setVar("thisurlprefix");
    int _jspx_eval_c_set_0 = _jspx_th_c_set_0.doStartTag();
    if (_jspx_eval_c_set_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_0.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_0.doInitBody();
      }
      do {
        out.write('?');
        if (_jspx_meth_c_if_0(_jspx_th_c_set_0, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_set_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_0 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_0);
    return false;
  }

  private boolean _jspx_meth_c_if_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_set_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_0 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_0.setPageContext(_jspx_page_context);
    _jspx_th_c_if_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_set_0);
    _jspx_th_c_if_0.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(not empty urlprefix)}", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
    int _jspx_eval_c_if_0 = _jspx_th_c_if_0.doStartTag();
    if (_jspx_eval_c_if_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${urlprefix}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_if_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_0);
    return false;
  }

  private boolean _jspx_meth_c_set_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_1 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var_value_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_1.setPageContext(_jspx_page_context);
    _jspx_th_c_set_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_1);
    _jspx_th_c_set_1.setVar("sort_order");
    _jspx_th_c_set_1.setValue((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${(param.sort_order eq 'ascending')?'descending':'ascending'}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    int _jspx_eval_c_set_1 = _jspx_th_c_set_1.doStartTag();
    if (_jspx_th_c_set_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var_value_nobody.reuse(_jspx_th_c_set_1);
    return false;
  }

  private boolean _jspx_meth_fmt_message_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_0 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_0.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_1);
    _jspx_th_fmt_message_0.setKey("loan_id");
    int _jspx_eval_fmt_message_0 = _jspx_th_fmt_message_0.doStartTag();
    if (_jspx_th_fmt_message_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_0);
    return false;
  }

  private boolean _jspx_meth_fmt_message_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_1 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_1.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_1);
    _jspx_th_fmt_message_1.setKey("record_title");
    int _jspx_eval_fmt_message_1 = _jspx_th_fmt_message_1.doStartTag();
    if (_jspx_th_fmt_message_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_1);
    return false;
  }

  private boolean _jspx_meth_fmt_message_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_2 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_2.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_1);
    _jspx_th_fmt_message_2.setKey("copy_id");
    int _jspx_eval_fmt_message_2 = _jspx_th_fmt_message_2.doStartTag();
    if (_jspx_th_fmt_message_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_2);
    return false;
  }

  private boolean _jspx_meth_fmt_message_3(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_3 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_3.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_1);
    _jspx_th_fmt_message_3.setKey("record_id");
    int _jspx_eval_fmt_message_3 = _jspx_th_fmt_message_3.doStartTag();
    if (_jspx_th_fmt_message_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_3);
    return false;
  }

  private boolean _jspx_meth_fmt_message_4(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_4 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_4.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_4.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_1);
    _jspx_th_fmt_message_4.setKey("loan_date");
    int _jspx_eval_fmt_message_4 = _jspx_th_fmt_message_4.doStartTag();
    if (_jspx_th_fmt_message_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_4);
    return false;
  }

  private boolean _jspx_meth_fmt_message_5(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_5 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_5.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_5.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_1);
    _jspx_th_fmt_message_5.setKey("return_date");
    int _jspx_eval_fmt_message_5 = _jspx_th_fmt_message_5.doStartTag();
    if (_jspx_th_fmt_message_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_5);
    return false;
  }

  private boolean _jspx_meth_fmt_message_6(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_6 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_6.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_6.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_1);
    _jspx_th_fmt_message_6.setKey("location");
    int _jspx_eval_fmt_message_6 = _jspx_th_fmt_message_6.doStartTag();
    if (_jspx_th_fmt_message_6.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_6);
    return false;
  }

  private boolean _jspx_meth_fmt_message_7(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_7 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_7.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_7.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_1);
    _jspx_th_fmt_message_7.setKey("user_id");
    int _jspx_eval_fmt_message_7 = _jspx_th_fmt_message_7.doStartTag();
    if (_jspx_th_fmt_message_7.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_7);
    return false;
  }

  private boolean _jspx_meth_fmt_message_8(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_8 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_8.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_8.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_1);
    _jspx_th_fmt_message_8.setKey("user_name");
    int _jspx_eval_fmt_message_8 = _jspx_th_fmt_message_8.doStartTag();
    if (_jspx_th_fmt_message_8.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_8);
    return false;
  }

  private boolean _jspx_meth_c_otherwise_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:otherwise
    org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_0 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
    _jspx_th_c_otherwise_0.setPageContext(_jspx_page_context);
    _jspx_th_c_otherwise_0.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_1);
    int _jspx_eval_c_otherwise_0 = _jspx_th_c_otherwise_0.doStartTag();
    if (_jspx_eval_c_otherwise_0 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("<th>");
        if (_jspx_meth_fmt_message_9(_jspx_th_c_otherwise_0, _jspx_page_context))
          return true;
        out.write("</th>\r\n");
        out.write("        <th>");
        if (_jspx_meth_fmt_message_10(_jspx_th_c_otherwise_0, _jspx_page_context))
          return true;
        out.write("</th>\r\n");
        out.write("        <th>");
        if (_jspx_meth_fmt_message_11(_jspx_th_c_otherwise_0, _jspx_page_context))
          return true;
        out.write("</th>\r\n");
        out.write("        <th>");
        if (_jspx_meth_fmt_message_12(_jspx_th_c_otherwise_0, _jspx_page_context))
          return true;
        out.write("</th>\r\n");
        out.write("        <th>");
        if (_jspx_meth_fmt_message_13(_jspx_th_c_otherwise_0, _jspx_page_context))
          return true;
        out.write("</th>\r\n");
        out.write("        <th>");
        if (_jspx_meth_fmt_message_14(_jspx_th_c_otherwise_0, _jspx_page_context))
          return true;
        out.write("</th>\r\n");
        out.write("        <th>");
        if (_jspx_meth_fmt_message_15(_jspx_th_c_otherwise_0, _jspx_page_context))
          return true;
        out.write("</th>\r\n");
        out.write("        <th>");
        if (_jspx_meth_fmt_message_16(_jspx_th_c_otherwise_0, _jspx_page_context))
          return true;
        out.write("</th>\r\n");
        out.write("      ");
        int evalDoAfterBody = _jspx_th_c_otherwise_0.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_otherwise_0.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_0);
    return false;
  }

  private boolean _jspx_meth_fmt_message_9(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_9 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_9.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_9.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_0);
    _jspx_th_fmt_message_9.setKey("loan_id");
    int _jspx_eval_fmt_message_9 = _jspx_th_fmt_message_9.doStartTag();
    if (_jspx_th_fmt_message_9.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_9);
    return false;
  }

  private boolean _jspx_meth_fmt_message_10(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_10 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_10.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_10.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_0);
    _jspx_th_fmt_message_10.setKey("record_title");
    int _jspx_eval_fmt_message_10 = _jspx_th_fmt_message_10.doStartTag();
    if (_jspx_th_fmt_message_10.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_10);
    return false;
  }

  private boolean _jspx_meth_fmt_message_11(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_11 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_11.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_11.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_0);
    _jspx_th_fmt_message_11.setKey("copy_id");
    int _jspx_eval_fmt_message_11 = _jspx_th_fmt_message_11.doStartTag();
    if (_jspx_th_fmt_message_11.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_11);
    return false;
  }

  private boolean _jspx_meth_fmt_message_12(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_12 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_12.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_12.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_0);
    _jspx_th_fmt_message_12.setKey("record_id");
    int _jspx_eval_fmt_message_12 = _jspx_th_fmt_message_12.doStartTag();
    if (_jspx_th_fmt_message_12.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_12);
    return false;
  }

  private boolean _jspx_meth_fmt_message_13(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_13 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_13.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_13.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_0);
    _jspx_th_fmt_message_13.setKey("loan_date");
    int _jspx_eval_fmt_message_13 = _jspx_th_fmt_message_13.doStartTag();
    if (_jspx_th_fmt_message_13.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_13);
    return false;
  }

  private boolean _jspx_meth_fmt_message_14(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_14 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_14.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_14.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_0);
    _jspx_th_fmt_message_14.setKey("return_date");
    int _jspx_eval_fmt_message_14 = _jspx_th_fmt_message_14.doStartTag();
    if (_jspx_th_fmt_message_14.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_14);
    return false;
  }

  private boolean _jspx_meth_fmt_message_15(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_15 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_15.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_15.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_0);
    _jspx_th_fmt_message_15.setKey("user_id");
    int _jspx_eval_fmt_message_15 = _jspx_th_fmt_message_15.doStartTag();
    if (_jspx_th_fmt_message_15.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_15);
    return false;
  }

  private boolean _jspx_meth_fmt_message_16(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_0, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  fmt:message
    org.apache.taglibs.standard.tag.rt.fmt.MessageTag _jspx_th_fmt_message_16 = (org.apache.taglibs.standard.tag.rt.fmt.MessageTag) _jspx_tagPool_fmt_message_key_nobody.get(org.apache.taglibs.standard.tag.rt.fmt.MessageTag.class);
    _jspx_th_fmt_message_16.setPageContext(_jspx_page_context);
    _jspx_th_fmt_message_16.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_0);
    _jspx_th_fmt_message_16.setKey("user_name");
    int _jspx_eval_fmt_message_16 = _jspx_th_fmt_message_16.doStartTag();
    if (_jspx_th_fmt_message_16.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_fmt_message_key_nobody.reuse(_jspx_th_fmt_message_16);
    return false;
  }

  private boolean _jspx_meth_c_when_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_2 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_2.setPageContext(_jspx_page_context);
    _jspx_th_c_when_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_2);
    _jspx_th_c_when_2.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ not empty rowMap }", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
    int _jspx_eval_c_when_2 = _jspx_th_c_when_2.doStartTag();
    if (_jspx_eval_c_when_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_set_2(_jspx_th_c_when_2, _jspx_page_context))
          return true;
        if (_jspx_meth_c_set_3(_jspx_th_c_when_2, _jspx_page_context))
          return true;
        if (_jspx_meth_c_set_4(_jspx_th_c_when_2, _jspx_page_context))
          return true;
        if (_jspx_meth_c_set_5(_jspx_th_c_when_2, _jspx_page_context))
          return true;
        if (_jspx_meth_c_set_6(_jspx_th_c_when_2, _jspx_page_context))
          return true;
        if (_jspx_meth_c_set_7(_jspx_th_c_when_2, _jspx_page_context))
          return true;
        if (_jspx_meth_c_set_8(_jspx_th_c_when_2, _jspx_page_context))
          return true;
        if (_jspx_meth_c_set_9(_jspx_th_c_when_2, _jspx_page_context))
          return true;
        if (_jspx_meth_c_set_10(_jspx_th_c_when_2, _jspx_page_context))
          return true;
        if (_jspx_meth_c_set_11(_jspx_th_c_when_2, _jspx_page_context))
          return true;
        if (_jspx_meth_c_set_12(_jspx_th_c_when_2, _jspx_page_context))
          return true;
        if (_jspx_meth_c_set_13(_jspx_th_c_when_2, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_when_2.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_2);
    return false;
  }

  private boolean _jspx_meth_c_set_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_2 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_2.setPageContext(_jspx_page_context);
    _jspx_th_c_set_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_2);
    _jspx_th_c_set_2.setVar("thisTransactionId");
    int _jspx_eval_c_set_2 = _jspx_th_c_set_2.doStartTag();
    if (_jspx_eval_c_set_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_2 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_2.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_2.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${rowMap[\"transactionId\"]}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_2.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_2 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_2);
    return false;
  }

  private boolean _jspx_meth_c_set_3(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_3 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_3.setPageContext(_jspx_page_context);
    _jspx_th_c_set_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_2);
    _jspx_th_c_set_3.setVar("thisTitle");
    int _jspx_eval_c_set_3 = _jspx_th_c_set_3.doStartTag();
    if (_jspx_eval_c_set_3 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_3 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_3.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_3.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${rowMap[\"recordTitle\"]}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_3.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_3 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_3);
    return false;
  }

  private boolean _jspx_meth_c_set_4(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_4 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_4.setPageContext(_jspx_page_context);
    _jspx_th_c_set_4.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_2);
    _jspx_th_c_set_4.setVar("thisUserId");
    int _jspx_eval_c_set_4 = _jspx_th_c_set_4.doStartTag();
    if (_jspx_eval_c_set_4 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_4 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_4.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_4.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${rowMap[\"userId\"]}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_4.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_4 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_4);
    return false;
  }

  private boolean _jspx_meth_c_set_5(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_5 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_5.setPageContext(_jspx_page_context);
    _jspx_th_c_set_5.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_2);
    _jspx_th_c_set_5.setVar("thisUserName");
    int _jspx_eval_c_set_5 = _jspx_th_c_set_5.doStartTag();
    if (_jspx_eval_c_set_5 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_5 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_5.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_5.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${rowMap[\"userName\"]}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_5.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_5 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_5.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_5);
    return false;
  }

  private boolean _jspx_meth_c_set_6(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_6 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_6.setPageContext(_jspx_page_context);
    _jspx_th_c_set_6.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_2);
    _jspx_th_c_set_6.setVar("thisUserDb");
    int _jspx_eval_c_set_6 = _jspx_th_c_set_6.doStartTag();
    if (_jspx_eval_c_set_6 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_6 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_6.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_6.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${rowMap[\"userDb\"]}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_6.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_6 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_6.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_6);
    return false;
  }

  private boolean _jspx_meth_c_set_7(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_7 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_7.setPageContext(_jspx_page_context);
    _jspx_th_c_set_7.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_2);
    _jspx_th_c_set_7.setVar("thisLocation");
    int _jspx_eval_c_set_7 = _jspx_th_c_set_7.doStartTag();
    if (_jspx_eval_c_set_7 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_7 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_7.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_7.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${rowMap[\"location\"]}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_7.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_7 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_7.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_7);
    return false;
  }

  private boolean _jspx_meth_c_set_8(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_8 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_8.setPageContext(_jspx_page_context);
    _jspx_th_c_set_8.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_2);
    _jspx_th_c_set_8.setVar("thisRecordId");
    int _jspx_eval_c_set_8 = _jspx_th_c_set_8.doStartTag();
    if (_jspx_eval_c_set_8 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_8 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_8.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_8.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${rowMap[\"recordId\"]}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_8.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_8 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_8.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_8);
    return false;
  }

  private boolean _jspx_meth_c_set_9(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_9 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_9.setPageContext(_jspx_page_context);
    _jspx_th_c_set_9.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_2);
    _jspx_th_c_set_9.setVar("thisCopyId");
    int _jspx_eval_c_set_9 = _jspx_th_c_set_9.doStartTag();
    if (_jspx_eval_c_set_9 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_9 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_9.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_9.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${rowMap[\"copyId\"]}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_9.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_9 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_9.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_9);
    return false;
  }

  private boolean _jspx_meth_c_set_10(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_10 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_10.setPageContext(_jspx_page_context);
    _jspx_th_c_set_10.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_2);
    _jspx_th_c_set_10.setVar("thisObjectDb");
    int _jspx_eval_c_set_10 = _jspx_th_c_set_10.doStartTag();
    if (_jspx_eval_c_set_10 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_10 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_10.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_10.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${rowMap[\"objectDb\"]}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_10.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_10 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_10.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_10);
    return false;
  }

  private boolean _jspx_meth_c_set_11(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_11 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_11.setPageContext(_jspx_page_context);
    _jspx_th_c_set_11.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_2);
    _jspx_th_c_set_11.setVar("thisCopyLocation");
    int _jspx_eval_c_set_11 = _jspx_th_c_set_11.doStartTag();
    if (_jspx_eval_c_set_11 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_11 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_11.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_11.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${rowMap[\"copyLocation\"]}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_11.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_11 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_11.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_11);
    return false;
  }

  private boolean _jspx_meth_c_set_12(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_12 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_12.setPageContext(_jspx_page_context);
    _jspx_th_c_set_12.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_2);
    _jspx_th_c_set_12.setVar("thisStartDate");
    int _jspx_eval_c_set_12 = _jspx_th_c_set_12.doStartTag();
    if (_jspx_eval_c_set_12 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_12 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_12.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_12.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${rowMap[\"startDate\"]}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_12.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_12 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_12.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_12);
    return false;
  }

  private boolean _jspx_meth_c_set_13(javax.servlet.jsp.tagext.JspTag _jspx_th_c_when_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_13 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_13.setPageContext(_jspx_page_context);
    _jspx_th_c_set_13.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_when_2);
    _jspx_th_c_set_13.setVar("thisEndDate");
    int _jspx_eval_c_set_13 = _jspx_th_c_set_13.doStartTag();
    if (_jspx_eval_c_set_13 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_13 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_13.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_13.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${rowMap[\"endDate\"]}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_13.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_13 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_13.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_13);
    return false;
  }

  private boolean _jspx_meth_c_set_14(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_14 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_14.setPageContext(_jspx_page_context);
    _jspx_th_c_set_14.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_14.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_14.setProperty("l");
    _jspx_th_c_set_14.setValue(new String("http://kalio.net/empweb/schema/loan/v1"));
    int _jspx_eval_c_set_14 = _jspx_th_c_set_14.doStartTag();
    if (_jspx_th_c_set_14.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_14);
    return false;
  }

  private boolean _jspx_meth_c_set_15(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_15 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_15.setPageContext(_jspx_page_context);
    _jspx_th_c_set_15.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_15.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_15.setProperty("h");
    _jspx_th_c_set_15.setValue(new String("http://kalio.net/empweb/schema/holdingsinfo/v1"));
    int _jspx_eval_c_set_15 = _jspx_th_c_set_15.doStartTag();
    if (_jspx_th_c_set_15.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_15);
    return false;
  }

  private boolean _jspx_meth_c_set_16(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_16 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_16.setPageContext(_jspx_page_context);
    _jspx_th_c_set_16.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_16.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_16.setProperty("mods");
    _jspx_th_c_set_16.setValue(new String("http://www.loc.gov/mods/v3"));
    int _jspx_eval_c_set_16 = _jspx_th_c_set_16.doStartTag();
    if (_jspx_th_c_set_16.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_16);
    return false;
  }

  private boolean _jspx_meth_c_set_17(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_17 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_value_target_property_nobody.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_17.setPageContext(_jspx_page_context);
    _jspx_th_c_set_17.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_17.setTarget((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_c_set_17.setProperty("uinfo");
    _jspx_th_c_set_17.setValue(new String("http://kalio.net/empweb/schema/users/v1"));
    int _jspx_eval_c_set_17 = _jspx_th_c_set_17.doStartTag();
    if (_jspx_th_c_set_17.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_value_target_property_nobody.reuse(_jspx_th_c_set_17);
    return false;
  }

  private boolean _jspx_meth_c_set_18(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_18 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_18.setPageContext(_jspx_page_context);
    _jspx_th_c_set_18.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_18.setVar("rootName");
    int _jspx_eval_c_set_18 = _jspx_th_c_set_18.doStartTag();
    if (_jspx_eval_c_set_18 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_18 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_18.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_18.doInitBody();
      }
      do {
        if (_jspx_meth_jxp_out_0(_jspx_th_c_set_18, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_set_18.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_18 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_18.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_18);
    return false;
  }

  private boolean _jspx_meth_jxp_out_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_set_18, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  jxp:out
    org.apache.jsp.tag.web.commons.jxp.out_tag _jspx_th_jxp_out_0 = new org.apache.jsp.tag.web.commons.jxp.out_tag();
    _jspx_th_jxp_out_0.setJspContext(_jspx_page_context);
    _jspx_th_jxp_out_0.setParent(_jspx_th_c_set_18);
    _jspx_th_jxp_out_0.setCnode((java.lang.Object) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${doc}", java.lang.Object.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_jxp_out_0.setSelect("local-name()");
    _jspx_th_jxp_out_0.setNsmap((java.util.Map) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${nsm}", java.util.Map.class, (PageContext)this.getJspContext(), null, false));
    _jspx_th_jxp_out_0.doTag();
    return false;
  }

  private boolean _jspx_meth_c_set_19(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_19 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_19.setPageContext(_jspx_page_context);
    _jspx_th_c_set_19.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_19.setVar("select");
    int _jspx_eval_c_set_19 = _jspx_th_c_set_19.doStartTag();
    if (_jspx_eval_c_set_19 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_19 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_19.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_19.doInitBody();
      }
      do {
        if (_jspx_meth_c_choose_3(_jspx_th_c_set_19, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_set_19.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_19 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_19.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_19);
    return false;
  }

  private boolean _jspx_meth_c_choose_3(javax.servlet.jsp.tagext.JspTag _jspx_th_c_set_19, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:choose
    org.apache.taglibs.standard.tag.common.core.ChooseTag _jspx_th_c_choose_3 = (org.apache.taglibs.standard.tag.common.core.ChooseTag) _jspx_tagPool_c_choose.get(org.apache.taglibs.standard.tag.common.core.ChooseTag.class);
    _jspx_th_c_choose_3.setPageContext(_jspx_page_context);
    _jspx_th_c_choose_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_set_19);
    int _jspx_eval_c_choose_3 = _jspx_th_c_choose_3.doStartTag();
    if (_jspx_eval_c_choose_3 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        if (_jspx_meth_c_when_3(_jspx_th_c_choose_3, _jspx_page_context))
          return true;
        if (_jspx_meth_c_otherwise_3(_jspx_th_c_choose_3, _jspx_page_context))
          return true;
        int evalDoAfterBody = _jspx_th_c_choose_3.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_choose_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_choose.reuse(_jspx_th_c_choose_3);
    return false;
  }

  private boolean _jspx_meth_c_when_3(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_3, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:when
    org.apache.taglibs.standard.tag.rt.core.WhenTag _jspx_th_c_when_3 = (org.apache.taglibs.standard.tag.rt.core.WhenTag) _jspx_tagPool_c_when_test.get(org.apache.taglibs.standard.tag.rt.core.WhenTag.class);
    _jspx_th_c_when_3.setPageContext(_jspx_page_context);
    _jspx_th_c_when_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_3);
    _jspx_th_c_when_3.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${rootName eq 'loan'}", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
    int _jspx_eval_c_when_3 = _jspx_th_c_when_3.doStartTag();
    if (_jspx_eval_c_when_3 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write('.');
        int evalDoAfterBody = _jspx_th_c_when_3.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_when_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_when_test.reuse(_jspx_th_c_when_3);
    return false;
  }

  private boolean _jspx_meth_c_otherwise_3(javax.servlet.jsp.tagext.JspTag _jspx_th_c_choose_3, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:otherwise
    org.apache.taglibs.standard.tag.common.core.OtherwiseTag _jspx_th_c_otherwise_3 = (org.apache.taglibs.standard.tag.common.core.OtherwiseTag) _jspx_tagPool_c_otherwise.get(org.apache.taglibs.standard.tag.common.core.OtherwiseTag.class);
    _jspx_th_c_otherwise_3.setPageContext(_jspx_page_context);
    _jspx_th_c_otherwise_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_choose_3);
    int _jspx_eval_c_otherwise_3 = _jspx_th_c_otherwise_3.doStartTag();
    if (_jspx_eval_c_otherwise_3 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("//l:loan");
        int evalDoAfterBody = _jspx_th_c_otherwise_3.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_otherwise_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_otherwise.reuse(_jspx_th_c_otherwise_3);
    return false;
  }

  private boolean _jspx_meth_c_set_20(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_20 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_20.setPageContext(_jspx_page_context);
    _jspx_th_c_set_20.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_20.setVar("thisTransactionId");
    int _jspx_eval_c_set_20 = _jspx_th_c_set_20.doStartTag();
    if (_jspx_eval_c_set_20 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_20 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_20.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_20.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['@id']}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_20.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_20 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_20.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_20);
    return false;
  }

  private boolean _jspx_meth_c_set_21(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_21 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_21.setPageContext(_jspx_page_context);
    _jspx_th_c_set_21.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_21.setVar("thisCopyId");
    int _jspx_eval_c_set_21 = _jspx_th_c_set_21.doStartTag();
    if (_jspx_eval_c_set_21 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_21 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_21.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_21.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:copyId']}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_21.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_21 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_21.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_21);
    return false;
  }

  private boolean _jspx_meth_c_set_22(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_22 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_22.setPageContext(_jspx_page_context);
    _jspx_th_c_set_22.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_22.setVar("thisUserId");
    int _jspx_eval_c_set_22 = _jspx_th_c_set_22.doStartTag();
    if (_jspx_eval_c_set_22 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_22 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_22.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_22.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:userId']}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_22.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_22 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_22.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_22);
    return false;
  }

  private boolean _jspx_meth_c_set_23(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_23 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_23.setPageContext(_jspx_page_context);
    _jspx_th_c_set_23.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_23.setVar("thisUserDb");
    int _jspx_eval_c_set_23 = _jspx_th_c_set_23.doStartTag();
    if (_jspx_eval_c_set_23 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_23 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_23.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_23.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:userDb']}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_23.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_23 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_23.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_23);
    return false;
  }

  private boolean _jspx_meth_c_set_24(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_24 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_24.setPageContext(_jspx_page_context);
    _jspx_th_c_set_24.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_24.setVar("thisLocation");
    int _jspx_eval_c_set_24 = _jspx_th_c_set_24.doStartTag();
    if (_jspx_eval_c_set_24 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_24 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_24.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_24.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:location']}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_24.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_24 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_24.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_24);
    return false;
  }

  private boolean _jspx_meth_c_set_25(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_25 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_25.setPageContext(_jspx_page_context);
    _jspx_th_c_set_25.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_25.setVar("thisRecordId");
    int _jspx_eval_c_set_25 = _jspx_th_c_set_25.doStartTag();
    if (_jspx_eval_c_set_25 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_25 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_25.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_25.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:recordId']}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_25.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_25 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_25.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_25);
    return false;
  }

  private boolean _jspx_meth_c_set_26(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_26 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_26.setPageContext(_jspx_page_context);
    _jspx_th_c_set_26.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_26.setVar("thisCopyId");
    int _jspx_eval_c_set_26 = _jspx_th_c_set_26.doStartTag();
    if (_jspx_eval_c_set_26 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_26 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_26.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_26.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:copyId']}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_26.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_26 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_26.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_26);
    return false;
  }

  private boolean _jspx_meth_c_set_27(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_27 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_27.setPageContext(_jspx_page_context);
    _jspx_th_c_set_27.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_27.setVar("thisObjectDb");
    int _jspx_eval_c_set_27 = _jspx_th_c_set_27.doStartTag();
    if (_jspx_eval_c_set_27 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_27 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_27.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_27.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:objectDb']}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_27.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_27 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_27.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_27);
    return false;
  }

  private boolean _jspx_meth_c_set_28(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_28 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_28.setPageContext(_jspx_page_context);
    _jspx_th_c_set_28.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_28.setVar("thisStartDate");
    int _jspx_eval_c_set_28 = _jspx_th_c_set_28.doStartTag();
    if (_jspx_eval_c_set_28 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_28 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_28.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_28.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:startDate']}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_28.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_28 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_28.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_28);
    return false;
  }

  private boolean _jspx_meth_c_set_29(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_2, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:set
    org.apache.taglibs.standard.tag.rt.core.SetTag _jspx_th_c_set_29 = (org.apache.taglibs.standard.tag.rt.core.SetTag) _jspx_tagPool_c_set_var.get(org.apache.taglibs.standard.tag.rt.core.SetTag.class);
    _jspx_th_c_set_29.setPageContext(_jspx_page_context);
    _jspx_th_c_set_29.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_2);
    _jspx_th_c_set_29.setVar("thisEndDate");
    int _jspx_eval_c_set_29 = _jspx_th_c_set_29.doStartTag();
    if (_jspx_eval_c_set_29 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      if (_jspx_eval_c_set_29 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE) {
        out = _jspx_page_context.pushBody();
        _jspx_th_c_set_29.setBodyContent((javax.servlet.jsp.tagext.BodyContent) out);
        _jspx_th_c_set_29.doInitBody();
      }
      do {
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${ptr['l:endDate']}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        int evalDoAfterBody = _jspx_th_c_set_29.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
      if (_jspx_eval_c_set_29 != javax.servlet.jsp.tagext.Tag.EVAL_BODY_INCLUDE)
        out = _jspx_page_context.popBody();
    }
    if (_jspx_th_c_set_29.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_set_var.reuse(_jspx_th_c_set_29);
    return false;
  }

  private boolean _jspx_meth_c_if_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_1 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_1.setPageContext(_jspx_page_context);
    _jspx_th_c_if_1.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_1);
    _jspx_th_c_if_1.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not config['ew.hide_object_db']}", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
    int _jspx_eval_c_if_1 = _jspx_th_c_if_1.doStartTag();
    if (_jspx_eval_c_if_1 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write('(');
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisObjectDb}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write(')');
        int evalDoAfterBody = _jspx_th_c_if_1.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_1.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_1);
    return false;
  }

  private boolean _jspx_meth_c_if_2(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_2 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_2.setPageContext(_jspx_page_context);
    _jspx_th_c_if_2.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_1);
    _jspx_th_c_if_2.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not config['ew.hide_object_db']}", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
    int _jspx_eval_c_if_2 = _jspx_th_c_if_2.doStartTag();
    if (_jspx_eval_c_if_2 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write('(');
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisObjectDb}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write(')');
        int evalDoAfterBody = _jspx_th_c_if_2.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_2.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_2);
    return false;
  }

  private boolean _jspx_meth_util_formatDate_0(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_0 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_0.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_0.setParent(_jspx_th_c_otherwise_1);
    _jspx_th_util_formatDate_0.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_0.setJspBody(new loanRow_tagHelper( 0, _jspx_page_context, _jspx_th_util_formatDate_0, null));
    _jspx_th_util_formatDate_0.doTag();
    return false;
  }

  private boolean _jspx_meth_c_if_3(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_3 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_3.setPageContext(_jspx_page_context);
    _jspx_th_c_if_3.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_1);
    _jspx_th_c_if_3.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${late eq 'true'}", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
    int _jspx_eval_c_if_3 = _jspx_th_c_if_3.doStartTag();
    if (_jspx_eval_c_if_3 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write("\r\n");
        out.write("        class=\"warn\"\r\n");
        out.write("      ");
        int evalDoAfterBody = _jspx_th_c_if_3.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_3.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_3);
    return false;
  }

  private boolean _jspx_meth_util_formatDate_1(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  util:formatDate
    org.apache.jsp.tag.web.commons.util.formatDate_tag _jspx_th_util_formatDate_1 = new org.apache.jsp.tag.web.commons.util.formatDate_tag();
    _jspx_th_util_formatDate_1.setJspContext(_jspx_page_context);
    _jspx_th_util_formatDate_1.setParent(_jspx_th_c_otherwise_1);
    _jspx_th_util_formatDate_1.setPattern("yyyyMMddHHmmss");
    _jspx_th_util_formatDate_1.setJspBody(new loanRow_tagHelper( 2, _jspx_page_context, _jspx_th_util_formatDate_1, null));
    _jspx_th_util_formatDate_1.doTag();
    return false;
  }

  private boolean _jspx_meth_c_if_4(javax.servlet.jsp.tagext.JspTag _jspx_th_c_otherwise_1, PageContext _jspx_page_context)
          throws Throwable {
    JspWriter out = _jspx_page_context.getOut();
    //  c:if
    org.apache.taglibs.standard.tag.rt.core.IfTag _jspx_th_c_if_4 = (org.apache.taglibs.standard.tag.rt.core.IfTag) _jspx_tagPool_c_if_test.get(org.apache.taglibs.standard.tag.rt.core.IfTag.class);
    _jspx_th_c_if_4.setPageContext(_jspx_page_context);
    _jspx_th_c_if_4.setParent((javax.servlet.jsp.tagext.Tag) _jspx_th_c_otherwise_1);
    _jspx_th_c_if_4.setTest(((java.lang.Boolean) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${not config['ew.hide_user_db']}", java.lang.Boolean.class, (PageContext)this.getJspContext(), null, false)).booleanValue());
    int _jspx_eval_c_if_4 = _jspx_th_c_if_4.doStartTag();
    if (_jspx_eval_c_if_4 != javax.servlet.jsp.tagext.Tag.SKIP_BODY) {
      do {
        out.write('(');
        out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisUserDb}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
        out.write(')');
        int evalDoAfterBody = _jspx_th_c_if_4.doAfterBody();
        if (evalDoAfterBody != javax.servlet.jsp.tagext.BodyTag.EVAL_BODY_AGAIN)
          break;
      } while (true);
    }
    if (_jspx_th_c_if_4.doEndTag() == javax.servlet.jsp.tagext.Tag.SKIP_PAGE)
      throw new SkipPageException();
    _jspx_tagPool_c_if_test.reuse(_jspx_th_c_if_4);
    return false;
  }

  private class loanRow_tagHelper
      extends org.apache.jasper.runtime.JspFragmentHelper
  {
    private javax.servlet.jsp.tagext.JspTag _jspx_parent;
    private int[] _jspx_push_body_count;

    public loanRow_tagHelper( int discriminator, JspContext jspContext, javax.servlet.jsp.tagext.JspTag _jspx_parent, int[] _jspx_push_body_count ) {
      super( discriminator, jspContext, _jspx_parent );
      this._jspx_parent = _jspx_parent;
      this._jspx_push_body_count = _jspx_push_body_count;
    }
    public boolean invoke0( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisStartDate}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
      return false;
    }
    public void invoke1( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisEndDate}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
      return;
    }
    public boolean invoke2( JspWriter out ) 
      throws Throwable
    {
      out.write((java.lang.String) org.apache.jasper.runtime.PageContextImpl.proprietaryEvaluate("${thisEndDate}", java.lang.String.class, (PageContext)this.getJspContext(), null, false));
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
