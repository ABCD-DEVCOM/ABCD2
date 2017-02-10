<?xml version="1.0"?><!--
<%@ page contentType="text/html; charset=UTF-8" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="x" uri="http://java.sun.com/jsp/jstl/xml" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="trans" tagdir="/WEB-INF/tags/trans" %>
<%@ taglib prefix="jxp" tagdir="/WEB-INF/tags/commons/jxp" %>
-->



	<script type="text/javascript">
	function verify(ver){
		
		if(ver){
			// Confirmed message, i.e. clicked on "Yes"
			alert('Message confirmed');
		}else{
			// Clicked on "No"
			alert('Message not confirmed');
		}
	}
	</script>


<fmt:requestEncoding value="UTF-8"/>

<div class="middle homepage">

  <h2><fmt:message key="welcome_to_empweb"/></h2>
  <!--<h3><fmt:message key="choose_task"/></h3>-->
  
	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
	<div class="boxTop">
		<div class="btLeft">&#160;</div>
		<div class="btRight">&#160;</div>
	</div>

  
  <div class="boxContent loanSection">

					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
						<h4>&#160;<strong><fmt:message key="trans"/></strong></h4>
					</div>
					<div class="sectionButtons">
						<a href="../trans/loan/index.jsp" class="defaultButton multiLine newButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><fmt:message key="loan"/></strong></span>
						</a>
						<a href="../trans/wait/create/index.jsp" class="defaultButton multiLine newButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><fmt:message key="reservation"/></strong></span>
						</a>
						<a href="../trans/return/index.jsp" class="defaultButton multiLine newButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><fmt:message key="return"/></strong></span>
						</a>
						<a href="../trans/renewal/index.jsp" class="defaultButton multiLine newButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><fmt:message key="renewal"/></strong></span>
						</a>
						<a href="../trans/suspension/create/index.jsp" class="defaultButton multiLine newButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><fmt:message key="create_suspension"/></strong></span>
						</a>
						
						<a href="../trans/query/index.jsp" class="defaultButton multiLine queryButton">
							<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
							<span><strong><fmt:message key="query"/></strong></span>
						</a>

						
					</div>
					<div class="spacer">&#160;</div>
				</div>

  </div>


  <%-- Show today's stats for this library by calling stat-status-counts --%>

  <h3><fmt:message key="current_status"/> (${sessionScope.library})</h3>
  <x:parse varDom="doc">
    <trans:doTransaction name="stat-status-counts">
      <transactionExtras>
        <params>
          <param name="operatorLocation">${sessionScope.library}</param>
          <param name="onlyCounts">true</param>
        </params>
      </transactionExtras>
    </trans:doTransaction>
  </x:parse>
  <jsp:useBean id="nsm" class="java.util.HashMap" />
  <c:set target="${nsm}" property="tr" value="http://kalio.net/empweb/schema/transactionresult/v1" />

    
  <table>
    <tr>
      <td><a href="../stats/status/include_report.jsp?report_type=status&amp;report_name=loans&amp;library=${sessionScope.library}"><fmt:message key="lent_books"/>: </a></td>
      <td>
        <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='loansCount']"/></strong>
      </td>
      <td><a href="../stats/status/include_report.jsp?report_type=status&amp;report_name=lateLoans&amp;library=${sessionScope.library}"><fmt:message key="overdue_objects"/>: </a></td>
      <td><strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='lateLoansCount']"/></strong></td>
      <td><a href="../stats/status/include_report.jsp?report_type=status&amp;report_name=suspensions&amp;library=${sessionScope.library}"><fmt:message key="active_suspensions"/>: </a></td>
      <td>
        <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='suspensionsCount']"/></strong>
      </td>
      <td><a href="../stats/status/include_report.jsp?report_type=status&amp;report_name=fines&amp;library=${sessionScope.library}"><fmt:message key="pending_fines"/>: </a></td>
      <td>
        <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='finesCount']"/></strong>
      </td>
      <td><a href="../stats/status/include_report.jsp?report_type=status&amp;report_name=waits&amp;library=${sessionScope.library}"><fmt:message key="waits_general"/>: </a></td>
      <td>
        <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='waitsCount']"/></strong>
      </td>
      <td><a href="../stats/status/include_report.jsp?report_type=status&amp;report_name=waitsAssigned&amp;library=${sessionScope.library}"><fmt:message key="waits_assigned"/>: </a></td>
      <td>
        <strong><jxp:out nsmap="${nsm}" cnode="${doc}" select="//tr:value[@name='waitsAssignedCount']"/></strong>
      </td>
    </tr>
  </table>
  <br/>
  
  <div class="spacer">&#160;</div>

</div>


