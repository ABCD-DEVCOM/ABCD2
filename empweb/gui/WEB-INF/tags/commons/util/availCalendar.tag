<%@ tag import="java.util.*,net.kalio.utils.*" %><%@
    taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %><%@
    taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %><%@
    taglib prefix="util" tagdir="/WEB-INF/tags/commons/util" %><%@
    attribute name="start"  required="true"  type="java.util.Date" %><%@
    attribute name="end"    required="false" type="java.util.Date" %><%@

    attribute name="var"    required="true" rtexprvalue="false" %><%@
    variable  name-from-attribute="var"  alias="currentDate" variable-class="java.util.Date" scope="NESTED" %><%--
/*
 * Copyright 2004-2007 Kalio.Net - Barzilai Spinak - Ciro Mondueri
 * All Rights Reserved
 *
 */
--%><%--
Notes:
   * Draws a calendar table for each month in the range (start..end).
   * The actual day content is obtained from the body of the taglib,
     which must also contain the <td></td> elements.
   * The "var" will be loaded with the value of the current Date for
     each iteration, what can be used by the body.
--%><%
Date startDate = (Date)jspContext.getAttribute("start");
Date endDate   = (Date)jspContext.getAttribute("end");

// so the first day of the week follows locale configuration
GregorianCalendar iterday   = new GregorianCalendar((Locale)session.getAttribute("userLocale"));
GregorianCalendar curmonth  = new GregorianCalendar((Locale)session.getAttribute("userLocale"));
GregorianCalendar startday  = new GregorianCalendar((Locale)session.getAttribute("userLocale"));
GregorianCalendar endday    = new GregorianCalendar((Locale)session.getAttribute("userLocale"));

iterday.setTime(startDate);
curmonth.setTime(startDate);
startday.setTime(startDate);
endday.setTime(endDate);

// ok, lets start with the calendar
if ( (iterday != null) && (endDate != null) )
{

  // go to the first day of the week
  iterday.add(Calendar.DATE, (-1 * iterday.get(Calendar.DAY_OF_WEEK) +  iterday.getFirstDayOfWeek()) );

  while (iterday.before(endday))
  {
    jspContext.setAttribute("currentMonth", (Date)curmonth.getTime());
    %><table class="reservation"><%

    // lets make the month header
    %><tr><th class="month" colspan="7"><fmt:formatDate value="${currentMonth}" pattern="MMMM"/></th></tr><%
    %><tr><%
    // and the days of the week header
    for (int i= 0; i < 7; i++)
    {
      jspContext.setAttribute("currentDate", (Date)iterday.getTime());
      %><th class="day"><fmt:formatDate value="${currentDate}" pattern="E" /></th><%
      iterday.add(Calendar.DATE, 1);
    }
    iterday.add(Calendar.DATE, -7);
    %></tr><%

    // now create the actual content for a month
    do
    {
      %><tr><%
      for (int i= 0; i < 7; i++)
      {
        if (iterday.get(Calendar.MONTH) == curmonth.get(Calendar.MONTH)) {
          // delegate actual contents to the body, passing the current date in the iteration
          jspContext.setAttribute("currentDate", (Date)iterday.getTime());
          %><jsp:doBody/><%
        }
        else
        {
          // the day is out of this month, so don't print anything, but leave the space
          %><td class="empty">&nbsp;</td><%
        }
        // add one more day
        iterday.add(Calendar.DATE, 1);
      }
      %></tr><%
    }
    while (iterday.get(Calendar.MONTH) == curmonth.get(Calendar.MONTH));

    // now the next month
    curmonth.setTime(iterday.getTime());

    // repeat the last week in the following month, for clarity.
    if (iterday.get(Calendar.DAY_OF_MONTH) != 1)
      iterday.add(Calendar.DATE, -7);

    %></table><%
  }
}
%>
