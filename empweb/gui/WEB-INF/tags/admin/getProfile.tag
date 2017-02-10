<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="io" uri="http://jakarta.apache.org/taglibs/io-1.0" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>

<%@ tag body-content="empty" %>
<%@ attribute name="id" required="true" %>

<%-- hacer sorting aca porque no tengo con jstl --%>

<io:soap url="${config['ewengine.admin_service']}" SOAPAction="" encoding="UTF-8">
  <io:body>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
      <soapenv:Body>
        <getProfile xmlns="http://kalio.net/empweb/engine/admin/v1">
          <id>${fn:trim(id)}</id>
        </getProfile>
      </soapenv:Body>
    </soapenv:Envelope>
  </io:body>
</io:soap>
